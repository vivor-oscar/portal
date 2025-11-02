self.addEventListener("install", (event) => {
    console.log("Service Worker installed");
    event.waitUntil(
      caches.open("app-cache").then((cache) => {
        return cache.addAll([
          "index.php", // homepage
          "assets/favicon/favicon-16x16.png",
          "assets/favicon/favicon-32x32.png"
        ]);
      })
    );
  });
  
  self.addEventListener("fetch", (event) => {
    event.respondWith(
      caches.match(event.request).then((response) => {
        return response || fetch(event.request);
      })
    );
  });
  