<?php
session_start();

// Log logout event if possible
if (file_exists(__DIR__ . '/includes/database.php') && file_exists(__DIR__ . '/includes/logger.php')) {
    include(__DIR__ . '/includes/database.php');
    include(__DIR__ . '/includes/logger.php');
    $user_id = $_SESSION['admin_id'] ?? $_SESSION['staff_id'] ?? $_SESSION['student_id'] ?? '';
    $username = $_SESSION['username'] ?? '';
    $role = $_SESSION['role'] ?? '';
    if ($username) log_activity($conn, $user_id, $username, $role, 'logout', 'User logged out');
}

// Unset all session variables
$_SESSION = [];

// Delete the session cookie (if set)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Prevent caching to block back-button access
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect to login or home page
header("Location: index.php");
exit;
?>
