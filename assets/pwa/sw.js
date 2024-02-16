if ('serviceWorker' in navigator && 'PushManager' in window) {
    // Mendaftarkan service worker
    navigator.serviceWorker.register('http://localhost/kasir2/kasir/assets/pwa/sw.js').then(function(registration) {
        console.log('Service Worker terdaftar dengan sukses:', registration);

        // Memeriksa apakah aplikasi dapat diinstal (menambahkan tombol Install jika iya)
        if (registration.installing || registration.waiting) {
            document.getElementById('installButton').style.display = 'block';
        }

        registration.addEventListener('updatefound', function() {
            registration.installing.addEventListener('statechange', function(e) {
                if (e.target.state === 'installed') {
                    // Menampilkan tombol Install setelah service worker diinstal
                    document.getElementById('installButton').style.display = 'block';
                }
            });
        });
    }).catch(function(error) {
        console.error('Gagal mendaftarkan Service Worker:', error);
    });
}