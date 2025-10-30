<?php
session_start();
include('../includes/database.php');
// optional logger
if (file_exists(__DIR__ . '/../includes/logger.php')) include_once __DIR__ . '/../includes/logger.php';

// Escape user inputs to prevent SQL injection
$staff_id_post = isset($_POST['staff_id']) ? trim($_POST['staff_id']) : '';
$checkin_code = isset($_POST['checkin_code']) ? $conn->real_escape_string($_POST['checkin_code']) : '';

// Prefer staff_id from session if available to prevent spoofing
$staff_id = '';
if (!empty($_SESSION['staff_id'])) {
    $staff_id = $conn->real_escape_string($_SESSION['staff_id']);
} elseif ($staff_id_post !== '') {
    $staff_id = $conn->real_escape_string($staff_id_post);
}

if (empty($staff_id) || empty($checkin_code)) {
    echo "Missing staff id or check-in code.";
    $conn->close();
    exit;
}

// Check if the random number exists and is not used
$sql = "SELECT id FROM checkin_code WHERE number = '$checkin_code' AND is_used = 0";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $number_id = (int) $row['id'];
    // Mark the random number as used (use prepared statement to be safe)
    $update_stmt = $conn->prepare('UPDATE checkin_code SET is_used = 1 WHERE id = ?');
    if ($update_stmt) {
        $update_stmt->bind_param('i', $number_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // fallback
        $conn->query("UPDATE checkin_code SET is_used = 1 WHERE id = $number_id");
    }

    // Record attendance (use prepared statement) with Ghana timezone timestamp
    $dt = new DateTime('now', new DateTimeZone('Africa/Accra'));
    $now_str = $dt->format('Y-m-d H:i:s');

    $insert_stmt = $conn->prepare('INSERT INTO staff_attendance (staff_id, check_in_time) VALUES (?, ?)');
    if ($insert_stmt) {
        $insert_stmt->bind_param('ss', $staff_id, $now_str);
        if ($insert_stmt->execute()) {
            echo "Check-in successful.";
            // log
            if (function_exists('log_activity')) {
                $user_id = $_SESSION['staff_id'] ?? $staff_id_post ?? '';
                $username = $_SESSION['username'] ?? '';
                log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'staff', 'checkin', "code_id={$number_id};staff_id={$staff_id};time={$now_str}");
            }
        } else {
            echo "Error recording check-in.";
        }
        $insert_stmt->close();
    } else {
        // fallback
        $esc_staff = $conn->real_escape_string($staff_id);
        $insert_sql = "INSERT INTO staff_attendance (staff_id, check_in_time) VALUES ('" . $esc_staff . "', '" . $conn->real_escape_string($now_str) . "')";
        if ($conn->query($insert_sql)) {
            echo "Check-in successful.";
            if (function_exists('log_activity')) {
                $user_id = $_SESSION['staff_id'] ?? $staff_id_post ?? '';
                $username = $_SESSION['username'] ?? '';
                log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'staff', 'checkin', "code_id={$number_id};staff_id={$staff_id};time={$now_str}");
            }
        } else {
            echo "Error recording check-in.";
        }
    }

} else {
    echo "Invalid or already used random number.";
}

$conn->close();
?>
