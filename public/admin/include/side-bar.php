<?php
// Harden session cookies and start session
$cookieParams = [
  'httponly' => true,
  'samesite' => 'Lax',
  'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
];
session_set_cookie_params($cookieParams);
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Regenerate session id to prevent fixation
if (empty($_SESSION['initiated'])) {
  session_regenerate_id(true);
  $_SESSION['initiated'] = 1;
}

// Error handling: do not display errors to users, log to project logs
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../../../logs/ad_error.log');

// Require authentication: redirect if username missing or role not administrator
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'administrator') {
  header('Location: ../../index.php');
  exit;
}
include('../../templates/loader.php');
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
  <title><?php echo htmlspecialchars(strtoupper(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME) ?: 'Dashboard'), ENT_QUOTES, 'UTF-8'); ?></title>
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="../../assets/favicon/site.webmanifest">
  <link href="../../dist/output.css" rel="stylesheet">
  <script src="//unpkg.com/alpinejs" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" /> -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans min-h-screen flex">
  <!-- Sidebar -->
  <aside
    x-data="{
    sidebarCollapsed: window.innerWidth < 768,
    dropdowns: {
      staff: false,
      student: false,
      class: false,
      results: false,
      subject: false,
      test: false,
      attendance: false,
      notification: false,
      plan: false,
      reports: false,
      fees: false
    },
    toggleDropdown(id) {
      this.dropdowns[id] = !this.dropdowns[id];
    }
  }"
    @resize.window="sidebarCollapsed = window.innerWidth < 768"
    class="fixed bg-white dark:bg-gray-800 shadow-md h-screen p-4 overflow-y-auto transition-all duration-300 ease-in-out"
    :class="{ 'w-20': sidebarCollapsed, 'w-64': !sidebarCollapsed }"
    x-init="$watch('sidebarCollapsed', value => { if(value) dropdowns = {} })">
    <br><br>
    <!-- Toggle -->
    <div class="flex justify-start px-2 mt-4">
      <button @click="sidebarCollapsed = !sidebarCollapsed" class="text-gray-500">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    <!-- Navigation -->
    <nav class="space-y-1">
      <!-- Dashboard -->
      <a href="admin-dashboard.php" class="flex items-center space-x-3 px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-medium" :title="sidebarCollapsed ? 'Dashboard' : ''">
        <i class="fas fa-tachometer-alt text-lg text-purple-500"></i>
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
      </a>

      <!-- MANAGEMENT Section -->
      <div x-show="!sidebarCollapsed" class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-t border-gray-200 dark:border-gray-600 mt-4 pt-4">
        MANAGEMENT
      </div>

      <!-- Staff -->
      <div>
        <button @click="toggleDropdown('staff')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Staff Management' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-user text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Staff</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['staff'] }"></i>
        </button>
        <div x-show="dropdowns['staff'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="#" onclick="document.getElementById('staffFormModal').classList.remove('hidden')" class="block px-2 py-1 hover:underline">New Staff</a>
          <a href="staff.php" class="block px-2 py-1 hover:underline">All Staff</a>
        </div>
      </div>

      <!-- Student -->
      <div>
        <button @click="toggleDropdown('student')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Student Management' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-user-graduate text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Student</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['student'] }"></i>
        </button>
        <div x-show="dropdowns['student'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="#" onclick="document.getElementById('studentFormModal').classList.remove('hidden'); return false;" class="block px-2 py-1 hover:underline">New Student</a>
          <a href="students.php" class="block px-2 py-1 hover:underline">All Students</a>
          <a href="approve-promotions.php" class="block px-2 py-1 hover:underline">Approve Promotions</a>
        </div>
      </div>

      <!-- FEE MANAGEMENT Section -->
      <div x-show="!sidebarCollapsed" class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-t border-gray-200 dark:border-gray-600 mt-4 pt-4">
        FEE MANAGEMENT
      </div>

      <!-- Fees & Accounts -->
      <div>
        <button @click="toggleDropdown('fees')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Fees & Accounts' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-money-bill-wave text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Fees & Accounts</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['fees'] }"></i>
        </button>
        <div x-show="dropdowns['fees'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="fee-dashboard.php" class="block px-2 py-1 hover:underline">Payment Dashboard</a>
        </div>
      </div>

      <!-- ACADEMICS Section -->
      <div x-show="!sidebarCollapsed" class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-t border-gray-200 dark:border-gray-600 mt-4 pt-4">
        ACADEMICS
      </div>

      <!-- Class -->
      <div>
        <button @click="toggleDropdown('class')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Class Management' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-chalkboard text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Class</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['class'] }"></i>
        </button>
        <div x-show="dropdowns['class'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="#" onclick="newClass(); return false;" class="block px-2 py-1 hover:underline">New Class</a>
          <a href="view.php" class="block px-2 py-1 hover:underline">All Classes</a>
        </div>
      </div>

      <!-- Results -->
      <div>
        <button @click="toggleDropdown('results')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Results Management' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-square-poll-vertical text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Results</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['results'] }"></i>
        </button>
        <div x-show="dropdowns['results'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="result-upload/index.php" class="block px-2 py-1 hover:underline">Upload Results</a>
          <a href="view.php" class="block px-2 py-1 hover:underline">All Results</a>
        </div>
      </div>

      <!-- Subject -->
      <div>
        <button @click="toggleDropdown('subject')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Subject Management' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-book text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Subject</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['subject'] }"></i>
        </button>
        <div x-show="dropdowns['subject'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="#" onclick="newSubject(); return false;" class="block px-2 py-1 hover:underline">New Subject</a>
          <a href="view.php" class="block px-2 py-1 hover:underline">All Subjects</a>
        </div>
      </div>

      <!-- Test -->
      <div>
        <button @click="toggleDropdown('test')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Test Management' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-clipboard text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Test</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['test'] }"></i>
        </button>
        <div x-show="dropdowns['test'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="#" onclick="newTest(); return false;" class="block px-2 py-1 hover:underline">New Test</a>
          <a href="view.php" class="block px-2 py-1 hover:underline">All Tests</a>
        </div>
      </div>

      <!-- OPERATIONS Section -->
      <div x-show="!sidebarCollapsed" class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-t border-gray-200 dark:border-gray-600 mt-4 pt-4">
        OPERATIONS
      </div>

      <!-- Attendance -->
      <div>
        <button @click="toggleDropdown('attendance')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Attendance Management' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-check text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Attendance</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['attendance'] }"></i>
        </button>
        <div x-show="dropdowns['attendance'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="attendance.php" class="block px-2 py-1 hover:underline">Generate Code</a>
          <a href="view-attendance.php" class="block px-2 py-1 hover:underline">Staff Attendance</a>
          <a href="class-attendance.php" class="block px-2 py-1 hover:underline">Student Attendance</a>
        </div>
      </div>

      <!-- Notification -->
      <div>
        <button @click="toggleDropdown('notification')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Notification Center' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-bell text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Notification</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['notification'] }"></i>
        </button>
        <div x-show="dropdowns['notification'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="notification.php" class="block px-2 py-1 hover:underline">Send Notification</a>
        </div>
      </div>

      <!-- PLANNING & REPORTS Section -->
      <div x-show="!sidebarCollapsed" class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-t border-gray-200 dark:border-gray-600 mt-4 pt-4">
        PLANNING & REPORTS
      </div>

      <!-- Plan -->
      <div>
        <button @click="toggleDropdown('plan')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Academic Planning' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-running text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Academic Planning</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['plan'] }"></i>
        </button>
        <div x-show="dropdowns['plan'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="term-plans.php" class="block px-2 py-1 hover:underline">Termly Plans</a>
        </div>
      </div>

      <!-- Reports -->
      <div>
        <button @click="toggleDropdown('reports')" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'System Reports' : ''">
          <div class="flex items-center space-x-3">
            <i class="fas fa-chart-line text-sm text-purple-500"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">System Reports</span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns['reports'] }"></i>
        </button>
        <div x-show="dropdowns['reports'] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <a href="system-report.php" class="block px-2 py-1 hover:underline">View All Reports</a>
        </div>
      </div>

      <!-- SYSTEM Section -->
      <div x-show="!sidebarCollapsed" class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-t border-gray-200 dark:border-gray-600 mt-4 pt-4">
        SYSTEM
      </div>

      <!-- Settings -->
      <a href="settings.php" class="flex items-center px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm space-x-3" :title="sidebarCollapsed ? 'System Settings' : ''">
        <i class="fas fa-cogs text-lg text-purple-500"></i>
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap">System Settings</span>
      </a>

      <!-- Logout -->
      <a href="../session/logout.php" class="flex items-center px-3 py-2 rounded text-red-600 hover:text-red-800 dark:hover:text-red-400 text-sm space-x-3" :title="sidebarCollapsed ? 'Logout' : ''">
        <i class="fas fa-sign-out-alt text-lg"></i>
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Logout</span>
      </a>
    </nav>
  </aside>

  <?php
  include 'modals.php';
  include 'header.php';
  ?>

  <script>

  </script>