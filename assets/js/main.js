// Modal functionality and guarded UI wiring
document.addEventListener("DOMContentLoaded", () => {
  // Edit modal logic
  const modal = document.getElementById("modal_container");
  const closeModal = document.getElementById("close_modal");

  document.querySelectorAll(".edit").forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const studentId = link.getAttribute("data-id");

      fetch(`?action=fetch_student&id=${studentId}`)
        .then((response) => response.json())
        .then((data) => {
          Object.entries(data).forEach(([key, value]) => {
            const field = document.getElementById(key);
            if (field) field.value = value;
          });

          if (modal) modal.classList.add("show");
        })
        .catch((err) => { /* fail silently - page may not have endpoint */ });
    });
  });

  if (closeModal) {
    closeModal.addEventListener("click", () => {
      if (modal) modal.classList.remove("show");
    });
  }

  // Guarded sidebar toggle: attach only if .toggle-sidebar exists
  const toggleButtons = document.querySelectorAll('.toggle-sidebar');
  if (toggleButtons && toggleButtons.length) {
    toggleButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const aside = document.querySelector('aside');
        if (aside) aside.classList.toggle('hidden');
      });
    });
  }

  // Upload modal wiring (guarded)
  const openModalBtn = document.getElementById("openmodalBtn");
  const uploadModal = document.getElementById("uploadmodal");
  const uploadClose = document.querySelector(".close");

  if (openModalBtn && uploadModal) {
    openModalBtn.addEventListener('click', () => { uploadModal.style.display = 'block'; });
  }
  if (uploadClose && uploadModal) {
    uploadClose.addEventListener('click', () => { uploadModal.style.display = 'none'; });
  }
  if (uploadModal) {
    window.addEventListener('click', function (event) {
      if (event.target === uploadModal) uploadModal.style.display = 'none';
    });
  }

});
//TIMER FOR AUTOLOGOUT AFTER 10 MINUTES OF INACTIVITY
var totalSeconds = 600;

// Function to update countdown and logout user
function updateCountdown() {
  var hours = Math.floor(totalSeconds / 3600);
  var minutes = Math.floor((totalSeconds % 3600) / 60);
  var seconds = totalSeconds % 60;

  // Add leading zeros if needed
  hours = String(hours).padStart(2, "0");
  minutes = String(minutes).padStart(2, "0");
  seconds = String(seconds).padStart(2, "0");

  // Update countdown element
  var countdownElement = document.getElementById("countdownDisplay");
  if (countdownElement) countdownElement.textContent = hours + ":" + minutes + ":" + seconds;

  // Decrease totalSeconds
  totalSeconds--;

  // Check if countdown has reached 0
  if (totalSeconds < 0) {
    // Redirect or log out the user here
    window.location.href = "../../logout.php"; // Replace with your logout URL
  } else {
    // Call updateCountdown function again after 1 second
    setTimeout(updateCountdown, 1000);
  }
}

// Function to reset the timer when user activity detected
function resetTimer() {
  totalSeconds = 600; // Reset the timer back to 10 minutes
}

// Start the countdown
updateCountdown();

//Event listeners to reset the timer on user activity
document.addEventListener("mousemove", resetTimer);
document.addEventListener("keypress", resetTimer);

