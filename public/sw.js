// Service Worker MedisCare — cache shell minimal + offline fallback (Bagian 31).
const CACHE_NAME = 'mediscare-shell-v1';
const OFFLINE_URL = '/offline.html';

const SHELL_ASSETS = [
    OFFLINE_URL,
    '/manifest.json',
    '/icons/icon-192x192.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(SHELL_ASSETS))
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key)))
        )
    );
    self.clients.claim();
});

// Strategi: network-first untuk navigasi halaman, fallback ke /offline.html saat gagal.
// Aset statis (CSS/JS/gambar) memakai cache-first sederhana.
self.addEventListener('fetch', (event) => {
    const { request } = event;

    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => caches.match(OFFLINE_URL))
        );
        return;
    }

    if (['style', 'script', 'image', 'font'].includes(request.destination)) {
        event.respondWith(
            caches.match(request).then((cached) => {
                if (cached) return cached;
                return fetch(request).then((response) => {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
                    return response;
                }).catch(() => cached);
            })
        );
    }
});
