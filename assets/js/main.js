// Modal functionality
document.addEventListener("DOMContentLoaded", () => {
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

          modal.classList.add("show");
        });
    });
  });

  closeModal.addEventListener("click", () => {
    modal.classList.remove("show");
  });
});

document.querySelector(".toggle-sidebar").addEventListener("click", () => {
  document.querySelector("aside").classList.toggle("hidden");
});

document.getElementById("openmodalBtn").onclick = function () {
  document.getElementById("uploadmodal").style.display = "block";
};

document.querySelector(".close").onclick = function () {
  document.getElementById("uploadmodal").style.display = "none";
};

window.onclick = function (event) {
  if (event.target == document.getElementById("uploadmodal")) {
    document.getElementById("uploadmodal").style.display = "none";
  }
};



var totalSeconds = 180;

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
  countdownElement.textContent = hours + ":" + minutes + ":" + seconds;

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
  totalSeconds = 180; // Reset the timer back to 5 minutes
}

// Start the countdown
updateCountdown();

//Event listeners to reset the timer on user activity
document.addEventListener("mousemove", resetTimer);
document.addEventListener("keypress", resetTimer);

