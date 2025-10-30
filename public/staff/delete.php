<?php
// Database connection
require_once('../../../includes/database.php');
require_once('../../../includes/logger.php');
// Delete record
$id = $_GET['id'];
$delete_sql = "DELETE FROM staff_attendance WHERE id='$id'";

if (mysqli_query($conn, $delete_sql)) {
    // log
    session_start();
    $user_id = $_SESSION['staff_id'] ?? $_SESSION['admin_id'] ?? '';
    $username = $_SESSION['username'] ?? '';
    log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'staff', 'delete_staff_attendance', "id={$id}");

    header("Location: check-in.php");
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
