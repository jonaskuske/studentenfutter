self.addEventListener('install', (event) => {
  event.waitUntil(handleInstall(event).then(() => self.skipWaiting()))
})

self.addEventListener('activate', (event) => {
  event.waitUntil(handleActivate(event).then(() => self.clients.claim()))
})

self.addEventListener('fetch', (event) => {
  return event.respondWith(handleFetch(event))
})

async function handleInstall(event) {}

async function handleActivate(event) {}

async function handleFetch(event) {
  return fetch(event.request)
}
