<?php
// Secure delete handler for admin
session_start();
include('../../includes/database.php');

// Allow POST (preferred) and fallback to GET for compatibility
$method = $_SERVER['REQUEST_METHOD'];
$input = $method === 'POST' ? $_POST : $_GET;

// Minimal whitelist mapping: delete_type => [table, id_column, redirect]
$map = [
    'class' => ['class', 'class_id', 'view.php'],
    'subject' => ['subjects', 'subject_id', 'view.php'],
    'test' => ['test', 'test_id', 'view.php'],
    // existing admin areas
    'students' => ['students', 'student_id', 'students.php'],
    'staff' => ['staff', 'staff_id', 'staff.php'],
    'checkin_code' => ['checkin_code', 'id', 'attendance.php'],
];

$type = isset($input['delete_type']) ? trim($input['delete_type']) : (isset($input['table']) ? trim($input['table']) : '');
$id = isset($input['delete_id']) ? trim($input['delete_id']) : (isset($input['id']) ? trim($input['id']) : '');

// Basic validation
if (empty($type) || empty($id) || !isset($map[$type])) {
    $msg = 'Invalid delete request';
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $msg]);
        exit();
    }
    $_SESSION['message'] = $msg;
    header('Location: ' . ($map[$type][2] ?? 'view.php'));
    exit();
}

list($table, $id_col, $redirect) = $map[$type];

// Use prepared statement to delete
$stmt = $conn->prepare("DELETE FROM `$table` WHERE `$id_col` = ? LIMIT 1");
if (!$stmt) {
    $msg = 'Prepare failed: ' . $conn->error;
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $msg]);
        exit();
    }
    $_SESSION['message'] = $msg;
    header('Location: ' . $redirect);
    exit();
}

$stmt->bind_param('s', $id);
$ok = $stmt->execute();

if ($ok) {
    // success
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'ok', 'message' => 'Deleted']);
        $stmt->close();
        //$conn->close();
        exit();
    }
    // Log delete action
    if (file_exists(__DIR__ . '/../../includes/logger.php')) {
        require_once __DIR__ . '/../../includes/logger.php';
        session_start();
        $user_id = $_SESSION['admin_id'] ?? $_SESSION['staff_id'] ?? $_SESSION['student_id'] ?? '';
        $username = $_SESSION['username'] ?? '';
        $role = $_SESSION['role'] ?? 'administrator';
        log_activity($conn, $user_id, $username, $role, 'delete', "table={$table};id={$id};type={$type}");
    }

    $_SESSION['message'] = 'Record deleted successfully';
    $stmt->close();
    //$conn->close();
    header('Location: ' . $redirect);
    exit();
} else {
    $msg = 'Delete failed: ' . $stmt->error;
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $msg]);
        $stmt->close();
        //$conn->close();
        exit();
    }
    $_SESSION['message'] = $msg;
    $stmt->close();
    //$conn->close();
    header('Location: ' . $redirect);
    exit();
}

?>
