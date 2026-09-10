import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Registrasi service worker untuk PWA (detail lengkap pada Tahap 10)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {
            // Diam-diam gagal di lingkungan dev tanpa HTTPS; ditangani penuh di Tahap 10.
        });
    });
}
