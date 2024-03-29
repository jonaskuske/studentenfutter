// Populated once during install, then treated as offline-first.
// Invalidated if the server-generated asset hash changes.
const STATIC_CACHE = 'static@__ASSET_HASH__'

// Entries stored here are added and constantly updated during runtime.
// Invalidated alongside STATIC_CACHE so we don't keep entries that rely on previous asset versions.
const DYNAMIC_CACHE = 'dynamic@__ASSET_HASH__'

// Entries stored here are added during runtime and never invalidated.
// (but deleted manually if an entry is a dependency and its parent is removed)
const PERMANENT_CACHE = 'permanent@1'

// Entry point for offline app shell, used as response if no other match was found.
// Like all cache entries, it declares its dependencies via the X-SW-Dependencies header.
const OFFLINE_FALLBACK = '/offline'

const STATIC_ASSETS = JSON.parse(`__ASSET_MANIFEST__`)

const trim = (str) => str.trim()
const all = (promises) => Promise.all(promises)
const log = (...a) => console.log('%c[sw]', 'color: darkgray', ...a)
const logBold = (...a) => console.log('%c[sw] %c%s', 'color:darkgray', 'font-weight:bold', ...a)
const doFetch = (req, opts) => fetch(req, opts).then((res) => (res.ok ? res : Promise.reject(res)))
const isImage = (url) => Boolean(url.match(/\.(jpe?g|png|gif|svg)(\?.*)?$/i))
const wait = (time) => new Promise((resolve) => setTimeout(resolve, time))
const shouldCachePermanently = (url) => isImage(url)
const getHeader = (res, header) => (res && res.headers.get(header)) || ''
const arrayFromHeader = (header = '') => header.split(',').map(trim).filter(Boolean)

self.addEventListener('install', (event) => {
  event.waitUntil(handleInstall(event).then(() => skipWaiting()))
})

self.addEventListener('activate', (event) => {
  event.waitUntil(handleActivate(event).then(() => clients.claim()))
})

self.addEventListener('fetch', (event) => {
  if (getHeader(event.request, 'Cache-Control').includes('no-store')) return
  event.respondWith(handleFetch(event))
})

self.addEventListener('message', (event) => {
  event.waitUntil(handleMessage(event))
})

self.addEventListener('periodicsync', (event) => {
  event.waitUntil(handlePeriodicSync(event))
})

async function handleInstall(event) {
  logBold('installing')

  const dynamicCache = await caches.open(DYNAMIC_CACHE)

  if ((await caches.keys()).includes(STATIC_CACHE)) {
    addToCache(dynamicCache, OFFLINE_FALLBACK)
  } else {
    logBold('caching: static assets')
    const staticCache = await caches.open(STATIC_CACHE)
    await all([staticCache.addAll(STATIC_ASSETS), addToCache(dynamicCache, OFFLINE_FALLBACK)])
  }

  logBold('installed')
}

async function handleActivate(event) {
  logBold('activating')
  const allowed = [STATIC_CACHE, DYNAMIC_CACHE, PERMANENT_CACHE]

  const cacheNames = await caches.keys()
  await all(cacheNames.map((name) => !allowed.includes(name) && caches.delete(name)))

  await updateContentIndex()

  if (registration.navigationPreload) {
    await registration.navigationPreload.enable()
  }

  logBold('activated')
}

async function handleFetch(event) {
  const req = event.request
  const url = new URL(req.url)
  const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection
  const isSlowConnection = connection && ['2g', '3g'].includes(connection.effectiveType)

  const staticCache = await caches.open(STATIC_CACHE)

  // Entries in static cache: offline-first
  // Allow requesting assets without specifying their version (?v=<hash>)
  const versionSpecified = url.search.match(/[?&]v=[^&]/)
  const staticCacheResp = await staticCache.match(req, { ignoreSearch: !versionSpecified })
  if (staticCacheResp) return staticCacheResp

  const permanentCache = await caches.open(PERMANENT_CACHE)

  // Entries in permanent cache: offline-first (e.g. images)
  if (shouldCachePermanently(req.url)) {
    const cachedResp = await permanentCache.match(req)
    if (cachedResp) return cachedResp
  }

  // On slow connections, don't bother with fetching the requested image if
  // we have another version of it cached (e.g. 400x200 instead of 600x300)
  if (isImage(req.url) && isSlowConnection) {
    const matchingResp = await getMatchingImage(permanentCache, req.url)
    if (matchingResp) return matchingResp
  }

  const dynamicCache = await caches.open(DYNAMIC_CACHE)

  // Update the offline fallback on each navigation (after a short delay to finish loading)
  // to ensure it matches the last seen online experience
  if (req.mode === 'navigate' && navigator.onLine) {
    event.waitUntil(wait(1000).then(() => addToCache(dynamicCache, OFFLINE_FALLBACK)))
  }

  try {
    const cachedResp = await dynamicCache.match(req)

    // On slow connections: immediately return cached response (offline-first),
    // fetch new resource in the background and update the cache
    if (cachedResp && isSlowConnection) {
      event.waitUntil(
        (async function () {
          const networkResp = (await event.preloadResponse) || (await fetch(req))
          await updateDependencies({
            from: cachedResp,
            to: networkResp,
            label: `updating ${req.url}`,
          })
          await dynamicCache.put(req, networkResp)
        })()
      )

      return cachedResp
    }

    // For fast connections, go network-first: fetch and return the latest response,
    // if it's also stored in our dynamic cache, update it in the background
    const networkResp = (await event.preloadResponse) || (await fetch(req))
    const clonedResp = networkResp.clone()

    if (cachedResp) {
      event.waitUntil(
        updateDependencies({
          from: cachedResp,
          to: clonedResp,
          label: `updating ${req.url}`,
        }).then(() => dynamicCache.put(req, clonedResp))
      )
    }

    return networkResp
  } catch (error) {
    // On error, we'll...

    // 1. Search for a match in all caches.
    const cachedResp = await caches.match(req)
    if (cachedResp) return cachedResp

    // 2. For images, check if we have the requested image in a different size.
    if (isImage(req.url)) {
      // Check if we have another version of this image in cache
      // e.g. respond with ninja-400x200.jpg for ninja-600x300.jpg
      const matchingResp = await getMatchingImage(permanentCache, req.url)
      if (matchingResp) return matchingResp
    }

    // 3. Return the offline page for navigations, else 404.
    return req.mode === 'navigate' ? caches.match(OFFLINE_FALLBACK) : create404()
  }
}

async function handleMessage(event) {
  if (event.data && event.data.type === 'UPDATE_CACHE') {
    const dynamicCache = await caches.open(DYNAMIC_CACHE)
    addToCache(dynamicCache, OFFLINE_FALLBACK)
  }
}

async function handlePeriodicSync(event) {
  if (event.tag === 'UPDATE_CACHE') {
    const dynamicCache = await caches.open(DYNAMIC_CACHE)
    await addToCache(dynamicCache, OFFLINE_FALLBACK)
  }
}

async function addToCache(cache, req) {
  const [cachedResp, response] = await all([cache.match(req), doFetch(req)])

  await cache.put(req, response)
  await updateDependencies({ from: cachedResp, to: response, label: `caching ${req.url || req}` })

  const indexId = getHeader(response, 'X-SW-Index-ID')
  if (indexId) await addToContentIndex(indexId)
}

async function removeFromCache(cache, req) {
  const cachedResp = await cache.match(req)

  if (cachedResp) {
    await updateDependencies({ from: cachedResp, to: null, label: `removing ${req.url || req}` })

    const indexId = getHeader(cachedResp, 'X-SW-Index-ID')
    if (indexId) await removeFromContentIndex(indexId)
  }

  await cache.delete(req)
}

async function updateDependencies({ from, to, label }) {
  console.groupCollapsed('%c[sw]', 'color: darkgray', label)
  const { add, remove } = diffDependencies({ from, to })
  console.groupEnd()

  if (!add && !remove) return

  const dynamicCache = await caches.open(DYNAMIC_CACHE)
  const permanentCache = await caches.open(PERMANENT_CACHE)

  const addPromises = [...add].map((url) => {
    const cache = shouldCachePermanently(url) ? permanentCache : dynamicCache
    return addToCache(cache, url)
  })

  const removePromises = [...remove].map((url) => {
    const cache = shouldCachePermanently(url) ? permanentCache : dynamicCache
    return removeFromCache(cache, url)
  })

  await all([...addPromises, ...removePromises])
}

function diffDependencies({ from, to }) {
  const fromHeader = getHeader(from, 'X-SW-Dependencies')
  const toHeader = getHeader(to, 'X-SW-Dependencies')
  const fromDeps = arrayFromHeader(fromHeader)
  const toDeps = arrayFromHeader(toHeader)
  const revalidate = new Set(arrayFromHeader(getHeader(to, 'X-SW-Revalidate')))

  if (fromHeader === toHeader && !revalidate.size) {
    log(toDeps.length === 0 ? 'no dependencies' : 'no changed dependencies')

    return { add: null, remove: null }
  }

  const add = new Set(toDeps.filter((url) => !fromDeps.includes(url)))
  const remove = new Set(fromDeps.filter((url) => !toDeps.includes(url)))

  log('add:', add)
  log('remove:', remove)
  log('revalidate:', revalidate)

  for (const dep of revalidate) add.add(dep)

  return { add, remove }
}

async function updateContentIndex() {
  if (!('index' in registration)) return

  logBold('updating content index')

  const dynamicCache = await caches.open(DYNAMIC_CACHE)

  const indexedEntries = await registration.index.getAll()
  const idsInIndex = new Set(indexedEntries.map((entry) => entry.id))

  const cachedRequests = await dynamicCache.keys()
  const idsInCache = (
    await all(
      cachedRequests.map(async (req) => {
        const response = await dynamicCache.match(req)
        return getHeader(response, 'X-SW-Index-ID')
      })
    )
  ).filter(Boolean)

  for (const id of idsInCache) {
    if (idsInIndex.has(id)) idsInIndex.delete(id)
    else await addToContentIndex(id)
  }

  for (const remainingId of idsInIndex) {
    await removeFromContentIndex(remainingId)
  }
}

async function addToContentIndex(id) {
  if (!('index' in registration) || !registration.active) return

  logBold('adding to content index:', id)

  try {
    const indexData = await doFetch(`/content-index/${id}`).then((res) => res.json())
    await registration.index.add(indexData)
  } catch (error) {
    console.error(error)
  }
}

async function removeFromContentIndex(id) {
  if (!('index' in registration)) return

  logBold('removing from content index:', id)

  await registration.index.delete(id)
}

async function getMatchingImage(cache, url) {
  const requested = parseImageURL(url)
  const requests = await cache.keys()

  let match

  for (const req of requests) {
    const img = parseImageURL(req.url)

    if (requested.originalURL === img.originalURL && isSameAspectRatio(requested, img)) {
      if (requested.originalURL === img.url) {
        // if we have the original, non-resized version in cache,
        // use that one and stop looking – there's no larger one
        match = img
        break
      } else if (!match) {
        // no match yet? use the image
        match = img
      } else {
        // already a match? compare and use the larger one
        if (match.width && img.width > match.width) match = img
        else if (match.height && img.height > match.height) match = img
      }
    }
  }

  if (match) return cache.match(match.url)
}

function parseImageURL(url) {
  const match = url.match(/-(\d*)x(\d*)\..+$/)
  if (!match) return { url, originalURL: url }

  const originalURL = url.replace(match[0], '')
  const width = parseInt(match[1], 10) || undefined
  const height = parseInt(match[2], 10) || undefined

  return { url, originalURL, width, height }
}

function isSameAspectRatio(a, b) {
  if ((a.width && a.height) || (b.width && b.height)) {
    return a.width / a.height === b.width / b.height
  }

  return true
}

function create404() {
  const body = { code: 404, message: "Sorry, you're offline." }
  return new Response(JSON.stringify(body), {
    status: 404,
    statusText: 'Not found',
    headers: { 'Content-Type': 'application/json' },
  })
}
