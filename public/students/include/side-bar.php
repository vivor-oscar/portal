<?php
session_start();
error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../../logs/sd_error.log');
@ini_set('display_error', 0);
if (!isset($_SESSION['username']) && ($_SESSION['role'] !== 'student')) {
  header("Location:../../index.php");
}
include('../../templates/loader.php');
include('../../includes/database.php');
// Fetch unread notification count for this student (per-user recipients, fallback to legacy)
$notif_count = 0;
$username = $_SESSION['username'] ?? '';
$student_id = '';
if (!empty($username)) {
  $stmt = $conn->prepare("SELECT student_id FROM students WHERE username = ? LIMIT 1");
  if ($stmt) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $row = $res->fetch_assoc()) {
      $student_id = $row['student_id'];
    }
    $stmt->close();
  }
}

if (!empty($student_id)) {
  $count_sql = "SELECT COUNT(DISTINCT n.notification_id) AS cnt
    FROM notifications n
    LEFT JOIN notification_recipients nr ON nr.notification_id = n.notification_id AND nr.user_type = 'student' AND nr.user_id = ?
    WHERE (
      (nr.id IS NOT NULL AND nr.read_at IS NULL)
      OR (nr.id IS NULL AND (n.target_role IN ('all','student')) AND (n.is_read = 0 OR n.is_read IS NULL))
    )";
  $cstmt = $conn->prepare($count_sql);
  if ($cstmt) {
    $cstmt->bind_param('s', $student_id);
    $cstmt->execute();
    $cres = $cstmt->get_result();
    if ($cres && $crow = $cres->fetch_assoc()) $notif_count = $crow['cnt'];
    $cstmt->close();
  }
} else {
  // Fallback: legacy behavior (counts all student-targeted notifications)
  $notif_sql = "SELECT COUNT(*) AS cnt FROM notifications WHERE (target_role = 'all' OR target_role = 'student') AND (is_read = 0 OR is_read IS NULL)";
  $result = $conn->query($notif_sql);
  if ($result) {
    $row = $result->fetch_assoc();
    $notif_count = $row['cnt'];
  }
}
?>
<!DOCTYPE html>
<html lang="en" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || false,
    toggleDarkMode() {
      this.darkMode = !this.darkMode;
      localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
      if (this.darkMode) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }
  }" :class="{ 'dark': darkMode }" class="">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo strtoupper(substr(basename($_SERVER['PHP_SELF']), 0, -4)); ?></title>
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="../../assets/favicon/site.webmanifest">
  <script src="//unpkg.com/alpinejs" defer></script>
  <link href="../../dist/output.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans min-h-screen flex">
  <!-- Sidebar -->

  <aside
  x-data="{
    sidebarCollapsed: window.innerWidth < 768,
    dropdowns: {
      results: false,
      test: false,
      attendance: false,
      notification: false,
      plan: false,
      reports: false
    },
    toggleDropdown(id) {
      this.dropdowns[id] = !this.dropdowns[id];
    }
  }"
  @resize.window="sidebarCollapsed = window.innerWidth < 768"
  class="fixed bg-white dark:bg-gray-800 shadow-md h-screen p-2 overflow-y-auto transition-all duration-300 ease-in-out"
  :class="{ 'w-20': sidebarCollapsed, 'w-64': !sidebarCollapsed }"
  x-init="$watch('sidebarCollapsed', value => { if(value) dropdowns = {} })"
>
<br><br>
  <!-- Toggle -->
  <div class="flex justify-start px-2 mt-4">
    <button @click="sidebarCollapsed = !sidebarCollapsed" class="text-gray-500">
      <i class="fas fa-bars"></i>
    </button>
  </div>

  <!-- Navigation -->
  <nav class="space-y-1 mt-4">
    <!-- Dashboard -->
    <a href="student-dashboard.php" class="flex items-center space-x-3 px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-medium" :title="sidebarCollapsed ? 'Dashboard' : ''">
      <i class="fas fa-tachometer-alt text-lg text-purple-500"></i>
      <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
    </a>

    <!-- Dropdown Menus -->
    <template x-for="[key, icon, label, links] of [
      ['results', 'fa-square-poll-vertical', 'Results', [['view-result.php','View']]],
      ['test', 'fa-clipboard', 'Test', [['view.php','View']]]
    ]" :key="key">
      <div>
        <button @click="toggleDropdown(key)" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? label : ''">
          <div class="flex items-center space-x-3">
            <i :class="`fas ${icon} text-sm text-purple-500`"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap" x-text="label"></span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns[key] }"></i>
        </button>
        <div x-show="dropdowns[key] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <template x-for="[url, name, action] of links" :key="name">
            <a
              :href="url"
              class="block px-2 py-1 hover:underline"
              :onclick="action ? `${action}(); return false;` : null"
              x-text="name"
            ></a>
          </template>
        </div>
      </div>
    </template>
    <!-- Notification menu (manual, outside x-for loop) -->
    <div>
      <button @click="toggleDropdown('notification')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Notification' : ''">
        <div class="flex items-center space-x-3 relative">
          <i class="fas fa-bell text-sm text-purple-500"></i>
          <?php if ($notif_count > 0): ?>
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-2 py-0.5"><?php echo $notif_count; ?></span>
          <?php endif; ?>
          <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Notification</span>
        </div>
        <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['notification'] }"></i>
      </button>
      <div x-show="dropdowns['notification'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
        <a href="notification.php" class="block px-2 py-1 hover:underline">View Notifications</a>
      </div>
    </div>

    <!-- Settings -->
    <a href="settings.php" class="flex items-center space-x-3 px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Settings' : ''">
      <i class="fas fa-cogs text-lg text-purple-500"></i>
      <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Settings</span>
    </a>

    <!-- Logout -->
    <a href="../session/logout.php" class="flex items-center space-x-3 px-3 py-2 text-red-600 hover:text-red-800 dark:hover:text-red-400 text-sm" :title="sidebarCollapsed ? 'Logout' : ''">
      <i class="fas fa-sign-out-alt text-lg"></i>
      <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Logout</span>
    </a>
  </nav>
</aside>


  <?php include('include/header.php'); ?>