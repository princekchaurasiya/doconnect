self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open("offline-cache").then(function (cache) {
            return cache.addAll([
                "/offline.html", // Ensure this page is cached for offline use
                "/assets/css/main.css", // Cache CSS
                "/assets/js/main.js" // Cache JavaScript
            ]);
        })
    );
});

self.addEventListener("fetch", function (event) {
    if (!navigator.onLine) {
        event.respondWith(
            caches.match(event.request).then(function (response) {
                return response || caches.match("/offline.html");
            })
        );
    }
});
