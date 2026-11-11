self.addEventListener('install', (evento) => {
    self.skipWaiting();
});
self.addEventListener('fetch', (evento) => {
    evento.respondWith(fetch(evento.request));
});