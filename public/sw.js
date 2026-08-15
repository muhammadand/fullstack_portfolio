const CACHE_NAME = 'scalify-partner-v1';

const urlsToCache = [
  '/partner/dashboard'
];

self.addEventListener('install', event => {
  self.skipWaiting();
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        // We use catch to avoid failing the whole install process if one URL fails
        return Promise.all(
          urlsToCache.map(url => {
            return cache.add(url).catch(error => console.error('Failed to cache:', url, error));
          })
        );
      })
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.filter(cacheName => {
          return cacheName !== CACHE_NAME;
        }).map(cacheName => {
          return caches.delete(cacheName);
        })
      );
    })
  );
});

self.addEventListener('fetch', event => {
  // Only handle GET requests
  if (event.request.method !== 'GET') return;

  // Don't intercept API calls or web routes not meant to be cached entirely
  if (event.request.url.includes('/api/')) return;

  event.respondWith(
    fetch(event.request)
      .then(response => {
        // Clone the response because it can only be consumed once
        const responseToCache = response.clone();

        // Don't cache if not a valid response
        if (!response || response.status !== 200 || response.type !== 'basic') {
          return response;
        }

        caches.open(CACHE_NAME)
          .then(cache => {
            cache.put(event.request, responseToCache);
          });

        return response;
      })
      .catch(() => {
        // Fallback to cache if network fails (offline)
        return caches.match(event.request);
      })
  );
});

// Handle Web Push Notifications
self.addEventListener('push', function (e) {
  if (!(self.Notification && self.Notification.permission === 'granted')) {
    return;
  }

  if (e.data) {
    var msg = e.data.json();
    e.waitUntil(
      self.registration.showNotification(msg.title, {
        body: msg.body,
        icon: msg.icon,
        actions: msg.actions,
        data: msg.data
      })
    );
  }
});

self.addEventListener('notificationclick', function (e) {
  e.notification.close();

  if (e.notification.data && e.notification.data.url) {
    e.waitUntil(clients.openWindow(e.notification.data.url));
  }
});
