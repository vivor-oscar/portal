<!-- HEADER -->
<!-- Fixed Header -->
<header class="fixed top-0 left-0 right-0 z-50 h-16 bg-white dark:bg-gray-800 shadow flex items-center justify-between px-4 md:px-6">

  <!-- Left Section -->
  <div class="flex items-center gap-3">
    <i class="fa fa-cloud text-sm text-gray-700 dark:text-gray-200">sms portal</i>
    <button @click="darkMode = !darkMode" class="text-gray-500 dark:text-gray-300 focus:outline-none">
      <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
    </button>

  </div>
  <!-- Center Section -->
  <div class="text-base md:text-lg text-gray-800 dark:text-white">
    <em>Welcome
      <span style="color:blueviolet;">
        <?php
    include('../../includes/database.php');
    if (file_exists(__DIR__ . '/../../includes/logger.php')) {
      include_once(__DIR__ . '/../../includes/logger.php');
      session_start();
      $user_id = $_SESSION['staff_id'] ?? $_SESSION['admin_id'] ?? '';
      $username = $_SESSION['username'] ?? '';
      log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'staff', 'page_view', 'uri=' . ($_SERVER['REQUEST_URI'] ?? ''));
    }
        $username = $_SESSION['username'] ?? '';
        $sql = "SELECT first_name, last_name FROM staff WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        $staff = mysqli_fetch_assoc($result);
        $first_name = $staff['first_name'] ?? '';
        $last_name = $staff['last_name'] ?? '';
        echo strtoupper(htmlspecialchars(($first_name) . ' ' . ($last_name)));
        ?>!
      </span>
    </em>
  </div>

</header>

<!-- Scripts -->
<script src="../../assets/js/main.js"></script>
<script src="../../assets/js/modals.js"></script>
<script src="../../assets/js/chart.js"></script>
<script>
  // Function to get the theme from local storage
  function getTheme() {
    return localStorage.getItem('theme');
  }

  // Function to set the theme in local storage
  function setTheme(theme) {
    localStorage.setItem('theme', theme);
  }

  // Function to apply the theme
  function applyTheme(theme) {
    if (theme === 'dark') {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  }

  // Initially set the theme based on local storage
  let darkMode = getTheme() === 'dark';
  if (darkMode === null) {
    darkMode = false;
  }
  applyTheme(darkMode ? 'dark' : 'light');

  // Make darkMode accessible globally
  window.darkMode = darkMode;

  // Toggle dark mode function
  window.toggleDarkMode = function() {
    window.darkMode = !window.darkMode;
    applyTheme(window.darkMode ? 'dark' : 'light');
    setTheme(window.darkMode ? 'dark' : 'light');
  };

  document.querySelector('.toggle-sidebar').addEventListener('click', () => {
    document.querySelector('aside').classList.toggle('hidden');
  });
</script>
<?php include 'modals.php'; ?>
<?php
// include global watermark/footer so they appear on every page that uses this header
if (file_exists(__DIR__ . '/../../include/watermark.php')) {
  include __DIR__ . '/../../include/watermark.php';
}