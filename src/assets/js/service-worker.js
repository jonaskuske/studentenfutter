/** __ASSET_(HASH, MANIFEST)__ are inserted by server */

const STATIC_CACHE = 'static@__ASSET_HASH__'
const DYNAMIC_CACHE = 'dynamic@__ASSET_HASH__'
const PERMANENT_CACHE = 'permanent@1'

const STATIC_ASSETS = JSON.parse(`__ASSET_MANIFEST__`)

const OFFLINE_FALLBACK = '/offline'

const trim = (str) => str.trim()
const all = (promises) => Promise.all(promises)
const isDef = (val) => val != null
const doFetch = (req, opts) => fetch(req, opts).then((res) => (res.ok ? res : Promise.reject(res)))
const isImage = (url) => Boolean(url.match(/\.(jpe?g|png|gif|svg)(\?.*)?$/i))
const shouldCachePermanently = (url) => isImage(url)
const getHeader = (res, header) => (res && res.headers.get(header)) || ''
const arrayFromHeader = (header = '') => header.split(',').map(trim).filter(Boolean)

self.addEventListener('install', (event) => {
  event.waitUntil(handleInstall(event).then(() => self.skipWaiting()))
})

self.addEventListener('activate', (event) => {
  event.waitUntil(handleActivate(event).then(() => self.clients.claim()))
})

self.addEventListener('fetch', (event) => {
  return event.respondWith(handleFetch(event))
})

self.addEventListener('message', (event) => {
  handleMessage(event)
})

self.addEventListener('periodicsync', (event) => {
  event.waitUntil(handlePeriodicSync(event))
})

async function handleInstall(event) {
  console.log('[sw] installing..')
  const [static, dynamic] = await all([caches.open(STATIC_CACHE), caches.open(DYNAMIC_CACHE)])
  await all([static.addAll(STATIC_ASSETS), addToCache(dynamic, OFFLINE_FALLBACK)])
  console.log('[sw] installed')
}

async function handleActivate(event) {
  const allowed = [STATIC_CACHE, DYNAMIC_CACHE, PERMANENT_CACHE]

  const cacheNames = await caches.keys()
  await all(cacheNames.map((name) => !allowed.includes(name) && caches.delete(name)))
  console.log('[sw] activated')
}

async function handleFetch(event) {
  const preloadResp = await event.preloadResponse
  if (preloadResp) return preloadResp

  const req = event.request

  const dynamic = await caches.open(DYNAMIC_CACHE)
  const cachedInDynamic = await dynamic.match(req)

  if (cachedInDynamic) {
    try {
      const networkResp = await fetch(req).then((response) => {
        const clonedResp = response.clone()
        updateDependencies(clonedResp, cachedInDynamic).then(() => {
          dynamic.put(req, clonedResp)
        })

        return response
      })

      return networkResp
    } catch (error) {
      return cachedInDynamic
    }
  } else {
    try {
      const networkResp = await fetch(req)
      return networkResp
    } catch (error) {
      const cachedResp = await caches.match(req)
      if (cachedResp) return cachedResp

      if (req.url.match(/tailwind\.dev\.css/)) {
        return caches.match(req.url.replace('tailwind.dev.css', 'tailwind.min.css'), {
          ignoreSearch: true,
        })
      }

      if (isImage(req.url)) {
        const matchingResp = await getMatchingImage(req.url)
        if (matchingResp) return matchingResp
      }

      return caches.match(OFFLINE_FALLBACK)
    }
  }
}

async function handleMessage(event) {
  if (event.data && event.data.type === 'UPDATE_CACHE') {
    const dynamic = await caches.open(DYNAMIC_CACHE)
    addToCache(dynamic, OFFLINE_FALLBACK)
  }
}

async function handlePeriodicSync(event) {
  if (event.tag === 'UPDATE_CACHE') {
    const dynamic = await caches.open(DYNAMIC_CACHE)
    await addToCache(dynamic, OFFLINE_FALLBACK)
  }
}

async function addToCache(cache, req) {
  const url = req.url || req

  console.log('[sw] attempting to cache:', url)
  const [response, cachedResp] = await all([doFetch(req), cache.match(req)])

  await updateDependencies(response, cachedResp)
  await cache.put(req, response)

  if ('index' in registration) {
    const id = getHeader(response, 'X-SW-Index-ID')
    const title = getHeader(response, 'X-SW-Index-Title')
    const description = getHeader(response, 'X-SW-Index-Description') || undefined
    const icon = getHeader(response, 'X-SW-Index-Icon') || undefined
    if (id && title && description && icon) {
      const sizes = getHeader(response, 'X-SW-Index-Icon-Sizes') || undefined
      const type = getHeader(response, 'X-SW-Index-Icon-Type') || undefined

      await registration.index.add({
        id,
        title,
        description,
        url,
        launchUrl: url,
        icons: [{ src: icon, sizes, type }],
      })
    }
  }

  console.log('[sw] cached:', url)
}

async function updateDependencies(res, cachedRes) {
  console.log('[sw] attempting to update deps for', res || cachedRes)

  const depHeader = getHeader(res, 'X-SW-Dependencies')
  const cachedDepHeader = getHeader(cachedRes, 'X-SW-Dependencies')

  const deps = arrayFromHeader(depHeader)
  const cachedDeps = arrayFromHeader(cachedDepHeader)
  const revalidate = arrayFromHeader(getHeader(res, 'X-SW-Revalidate'))

  if (depHeader === cachedDepHeader && !revalidate.length) {
    console.log('[sw] no update neccessary for:', res)
    return
  }

  const [dynamic, permanent] = await all([caches.open(DYNAMIC_CACHE), caches.open(PERMANENT_CACHE)])

  const toAdd = new Set(deps.filter((url) => !cachedDeps.includes(url)))
  const toRemove = new Set(cachedDeps.filter((url) => !deps.includes(url)))

  console.log('[sw] to add:', toAdd)
  console.log('[sw] to remove:', toRemove)

  for (const dep of revalidate) {
    console.log('[sw] revalidating:', dep)
    toAdd.add(dep)
  }

  const addPromises = [...toAdd].map((url) => {
    const cache = shouldCachePermanently(url) ? permanent : dynamic
    return addToCache(cache, url)
  })

  const removePromises = [...toRemove].map((url) => {
    const cache = shouldCachePermanently(url) ? permanent : dynamic
    return removeFromCache(cache, url)
  })

  await all([...addPromises, ...removePromises])
}

async function removeFromCache(cache, req) {
  console.log('[sw] attempting to remove:', req)
  const stored = await cache.match(req)

  if (stored) {
    if ('index' in registration) {
      const id = getHeader(stored, 'X-SW-Index-ID')
      if (id) await registration.index.delete(id)
    }
    console.log('[sw] attempting to remove transitive deps:', req)
    await updateDependencies(null, stored)
  }

  await cache.delete(req)
  console.log('[sw] removed:', req)
}

async function getMatchingImage(url) {
  const original = parseImageURL(url)

  const permanent = await caches.open(PERMANENT_CACHE)
  const responses = await permanent.keys()

  let match

  for (const res of responses) {
    const img = parseImageURL(res.url)
    if (original.sourceURL !== img.sourceURL || !isSameAspectRatio(original, img)) {
      continue
    }

    if (!match) match = img
    else {
      // choose largest
      if (isDef(match.width) && img.width > match.width) match = img
      else if (isDef(match.height) && img.height > match.height) match = img
    }
  }

  if (match) return permanent.match(match.url)
}

function parseImageURL(url) {
  const match = url.match(/(\d*)x(\d*)\..*$/)
  if (!match) return { url, sourceURL: url }

  const sourceURL = url.replace(match[0], '')
  const width = parseInt(match[1], 10) || undefined
  const height = parseInt(match[2], 10) || undefined

  return { url, sourceURL, width, height }
}

function isSameAspectRatio(a, b) {
  const aHasWidth = isDef(a.width)
  const bHasWidth = isDef(b.width)
  const aHasHeight = isDef(a.height)
  const bHasHeight = isDef(b.height)

  if (aHasWidth && bHasWidth && !aHasHeight && !bHasHeight) return true
  if (aHasHeight && bHasHeight && !aHasWidth && !bHasWidth) return true

  if (aHasWidth && bHasWidth && aHasHeight && bHasHeight) {
    return a.width / a.height === b.width / b.height
  }

  return false
}
