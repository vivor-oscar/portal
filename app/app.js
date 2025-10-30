// Dynamically detect correct path for service worker
const swPath = `${window.location.pathname.replace(/\/[^/]*$/, "")}/app/service-worker.js`;

// Register service worker
if ("serviceWorker" in navigator) {
  navigator.serviceWorker.register(swPath)
    .then(() => console.log("✅ Service Worker registered:", swPath))
    .catch(err => console.error("❌ SW registration failed:", err));
}

// Handle install prompt
let deferredPrompt;
window.addEventListener("beforeinstallprompt", (e) => {
  e.preventDefault();
  deferredPrompt = e;

  // Create install button
  const installBtn = document.createElement("button");
  installBtn.textContent = "Install App";
  installBtn.className =
    "fixed bottom-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg z-50";
  document.body.appendChild(installBtn);

  installBtn.addEventListener("click", () => {
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then((choice) => {
      if (choice.outcome === "accepted") {
        console.log("✅ App installed");
      } else {
        console.log("❌ App dismissed");
      }
      installBtn.remove();
      deferredPrompt = null;
    });
  });
});
