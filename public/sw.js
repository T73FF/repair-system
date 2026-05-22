const CACHE_NAME = 'repair-system-v1';

self.addEventListener('install', event => {
  console.log('SW установлен');
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  console.log('SW активирован');
  event.waitUntil(clients.claim());
});

self.addEventListener('fetch', event => {
  event.respondWith(fetch(event.request));
});

self.addEventListener('push', function(event) {
  let data = {};
  try {
    data = event.data?.json() ?? {};
  } catch (e) {
    data = { title: 'Новое уведомление', body: event.data?.text() ?? '' };
  }

  event.waitUntil(
    self.registration.showNotification(data.title, {
      body: data.body,
      icon: '/images/icons/icon-192x192.png',
      badge: '/images/icons/icon-72x72.png',
      data: { url: data.url || '/' }
    })
  );
});

self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  event.waitUntil(clients.openWindow(event.notification.data?.url || '/'));
});