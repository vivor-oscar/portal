<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// Buffer output so header redirects can be sent even if includes produce output (watermark/footer)
if (!ob_get_level()) ob_start();
include('includes/database.php');
include('templates/loader.php');
// Determine portal version for display on login page (priority: VERSION file -> package.json version -> git short hash -> default)
$PORTAL_VERSION = '';
$versionFile = __DIR__ . '/VERSION';
if (file_exists($versionFile)) {
  $PORTAL_VERSION = trim(@file_get_contents($versionFile));
} else {
  $pkg = __DIR__ . '/package.json';
  if (file_exists($pkg)) {
    $pkgData = json_decode(@file_get_contents($pkg), true);
    if (!empty($pkgData['version'])) {
      $PORTAL_VERSION = $pkgData['version'];
    }
  }
}
// Try git short hash if still empty and shell_exec available
if (empty($PORTAL_VERSION) && function_exists('shell_exec') && is_dir(__DIR__ . '/.git')) {
  $gitHash = trim(@shell_exec('git rev-parse --short HEAD'));
  if ($gitHash) {
    $PORTAL_VERSION = 'dev-' . $gitHash;
  }
}
if (empty($PORTAL_VERSION)) $PORTAL_VERSION = 'v1.0.0-dev';

include('public/include/watermark.php');
// Function to handle login for any user type (admin, staff, student)
function loginUser($conn, $username, $password, $role)
{
  $query = "";
  $redirectUrl = "";

  switch ($role) {
    case 'administrator':
      $query = "SELECT * FROM administrator WHERE username = '$username' OR admin_id = '$username'";
      $redirectUrl = "public/admin/admin-dashboard.php";
      break;
    case 'student':
      $query = "SELECT * FROM students WHERE username = '$username' OR student_id = '$username' OR email = '$username'";
      $redirectUrl = "public/students/student-dashboard.php";
      break;
    case 'staff':
      $query = "SELECT * FROM staff WHERE username = '$username' OR staff_id = '$username' OR email = '$username'";
      $redirectUrl = "public/staff/staff-dashboard.php";
      break;
    default:
      return false;
  }

  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row['password'])) {
      $_SESSION['username'] = $row['username'];
      $_SESSION['role'] = $role;

      if ($role === 'staff') {
        $_SESSION['staff_id'] = $row['staff_id'];
      }
      if ($role === 'administrator') {
        $_SESSION['admin_id'] = $row['admin_id'];
      }
      if ($role === 'student') {
        $_SESSION['student_id'] = $row['student_id'];
      }

      // Log successful login
      if (file_exists(__DIR__ . '/includes/logger.php')) {
        require_once __DIR__ . '/includes/logger.php';
        $user_id = '';
        if ($role === 'administrator' && isset($row['admin_id'])) $user_id = $row['admin_id'];
        if ($role === 'staff' && isset($row['staff_id'])) $user_id = $row['staff_id'];
        if ($role === 'student' && isset($row['student_id'])) $user_id = $row['student_id'];
        log_activity($conn, $user_id, $row['username'], $role, 'login', 'Successful login');
      }

      header("Location: $redirectUrl");
      exit();
    } else {
      // Log failed password attempt
      if (file_exists(__DIR__ . '/includes/logger.php')) {
        require_once __DIR__ . '/includes/logger.php';
        $user_id = '';
        if ($role === 'administrator' && isset($row['admin_id'])) $user_id = $row['admin_id'];
        if ($role === 'staff' && isset($row['staff_id'])) $user_id = $row['staff_id'];
        if ($role === 'student' && isset($row['student_id'])) $user_id = $row['student_id'];
        log_activity($conn, $user_id, $row['username'] ?? $username, $role, 'failed_login', 'Incorrect password');
      }
    }
  }
  return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if (empty($username) || empty($password)) {
    $_SESSION['error_message'] = "Please fill in all fields.";
  } else {
    if (loginUser($conn, $username, $password, 'administrator')) exit();
    if (loginUser($conn, $username, $password, 'student')) exit();
    if (loginUser($conn, $username, $password, 'staff')) exit();

    // Log failed login (unknown account)
    if (file_exists(__DIR__ . '/includes/logger.php')) {
      require_once __DIR__ . '/includes/logger.php';
      $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
      log_activity($conn, '', $username, 'unknown', 'failed_login', 'Unknown account attempt from IP: ' . $ip);
    }

    $_SESSION['error_message'] = "Unknown account. Please try again.";
  }
}

//$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Royal Websters Academy</title>
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#2563eb">
  <link rel="icon" href="/assets/favicon/favicon-16x16.png" type="image/png">
  <link rel="icon" href="/assets/favicon/favicon-32x32.png" type="image/png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="/assets/favicon/site.webmanifest">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="app/app.js"></script>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      overflow: hidden;
      position: relative;
    }

    .modern-bg {
      position: absolute;
      inset: 0;
      z-index: 0;
      background: linear-gradient(135deg, #1e3a8a 0%, #9333ea 50%, #10b981 100%);
      overflow: hidden;
    }

    .modern-bg .shape {
      position: absolute;
      border-radius: 50%;
      opacity: 0.25;
      filter: blur(40px);
      animation: float 10s infinite alternate;
    }

    .modern-bg .shape1 {
      width: 400px;
      height: 400px;
      background: #f472b6;
      top: -100px;
      left: -100px;
      animation-delay: 0s;
    }

    .modern-bg .shape2 {
      width: 300px;
      height: 300px;
      background: #38bdf8;
      bottom: -80px;
      right: -80px;
      animation-delay: 2s;
    }

    .modern-bg .shape3 {
      width: 200px;
      height: 200px;
      background: #facc15;
      top: 60%;
      left: 60%;
      animation-delay: 4s;
    }

    @keyframes float {
      0% {
        transform: translateY(0) scale(1);
      }

      100% {
        transform: translateY(-30px) scale(1.1);
      }
    }

    .glass {
      backdrop-filter: blur(16px);
      background: rgba(255, 255, 255, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.25);
    }
  </style>
</head>

<body class="flex items-center justify-center min-h-screen relative">

  <div class="modern-bg">
    <div class="shape shape1"></div>
    <div class="shape shape2"></div>
    <div class="shape shape3"></div>
  </div>

  <div class="w-full max-w-md p-8 rounded-xl shadow-2xl glass text-white relative z-10">
    <div class="flex items-center gap-4 mb-6">
      <?php
      include('includes/database.php');
      $result = $conn->query("SELECT * FROM school_details LIMIT 1");
      $school_details = $result->fetch_assoc();

      if ($school_details) {
        $image_path = $school_details['image_path'];
      }

      $sql = "SELECT * FROM school_details";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<img src='templates/" . $image_path . "' alt='School Logo' class='w-14 h-14 rounded-full border-2 border-white'>";
          echo "<h2 class='text-xl font-semibold'>" . $row['school_name'] . "</h2>";
        }
      }
      ?>
    </div>

    <?php if (isset($_SESSION['error_message'])) : ?>
      <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4">
        <?= htmlspecialchars($_SESSION['error_message']) ?>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <form action="#" method="post" class="space-y-5">
      <div>
        <label for="username" class="block mb-1 text-sm font-medium">Username | ID | Email</label>
        <div class="flex items-center bg-white bg-opacity-20 backdrop-blur-sm rounded px-3">
          <i class="fas fa-user text-white"></i>
          <input type="text" name="username" id="username" required autocomplete="username"
            class="w-full bg-transparent px-3 py-2 text-white focus:outline-none placeholder-white"
            required>
        </div>
      </div>

      <div>
        <label for="password" class="block mb-1 text-sm font-medium">Password</label>
        <div class="flex items-center bg-white bg-opacity-20 backdrop-blur-sm rounded px-3 relative">
          <i class="fas fa-lock text-white"></i>
          <input type="password" name="password" id="password" autocomplete="current-password"
            class="w-full bg-transparent px-3 py-2 text-white focus:outline-none placeholder-white"
            required>
          <button type="button" onclick="togglePassword()" tabindex="-1"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-white focus:outline-none">
            <i id="toggleIcon" class="fas fa-eye"></i>
          </button>
        </div>
      </div>

      <div>
        <button type="submit"
          class="w-full bg-gradient-to-r from-green-400 to-blue-500 hover:from-blue-500 hover:to-green-400 text-white font-bold py-2 rounded transition-all">
          Login
        </button>
      </div>
    </form>
  </div>
  <script>
  </script>
  <?php
  // Flush output buffer (if any) after page finished rendering
  if (ob_get_level()) {
    ob_end_flush();
  }
  ?>
      const icon = document.getElementById('toggleIcon');
      if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        pwd.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>

</html>