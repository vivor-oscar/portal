<!-- HEADER -->
<!-- Fixed Header -->
<header class="fixed top-0 left-0 right-0 z-50 h-16 bg-white dark:bg-gray-800 shadow flex items-center justify-between px-4 md:px-6">

  <!-- Toggle button -->
  <div class="flex items-center gap-3">
    <i class="fa fa-cloud text-sm text-gray-700 dark:text-gray-200">sms portal</i>
    <button @click="toggleDarkMode()" class="text-gray-500 dark:text-gray-300 focus:outline-none">
      <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
    </button>
  </div>
  <div> 
    <span id="countdownDisplay" class="counter"></span>
  </div>
  <!-- Center Section -->
  <div class="text-base md:text-lg text-gray-800 dark:text-white">
    <em>Welcome
      <span style="color:blueviolet;">
        <?php
          include('../../includes/database.php');
          if (file_exists(__DIR__ . '/../../includes/logger.php')) {
              include_once(__DIR__ . '/../../includes/logger.php');
              // Log page view
              session_start();
              $user_id = $_SESSION['admin_id'] ?? '';
              $username = $_SESSION['username'] ?? '';
              log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'page_view', 'uri=' . ($_SERVER['REQUEST_URI'] ?? '')); 
          }
        $username = $_SESSION['username'] ?? '';
        $sql = "SELECT name FROM administrator WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'] ?? '';
        // Display the name in uppercase      
        echo strtoupper(htmlspecialchars(($name ?? '')));
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
 
</script>
<?php include 'modals.php'; ?>