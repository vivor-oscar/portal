<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include('../../includes/database.php');
include('../../includes/logger.php');

// Simple CSRF protection: token must match session token
function json_response($data) {
    echo json_encode($data);
    exit;
}

$action = $_POST['action'] ?? '';
$token = $_POST['csrf_token'] ?? '';

if (empty($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    json_response(['success' => false, 'error' => 'Invalid CSRF token']);
}

if ($action === 'create' || $action === 'update') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $start = trim($_POST['start'] ?? '');
    $end = trim($_POST['end'] ?? '');
    $event_type = trim($_POST['event_type'] ?? 'general');

    if ($title === '' || $start === '') {
        json_response(['success' => false, 'error' => 'Title and start date are required']);
    }

    if ($action === 'create') {
        $stmt = $conn->prepare('INSERT INTO term_plans (title, description, plan_date, end_date, event_type) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $title, $description, $start, $end, $event_type);
        if ($stmt->execute()) {
            // log
            session_start();
            $user_id = $_SESSION['admin_id'] ?? $_SESSION['staff_id'] ?? '';
            $username = $_SESSION['username'] ?? '';
            log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'create_term_plan', "id={$stmt->insert_id};title={$title}");
            json_response(['success' => true, 'id' => $stmt->insert_id]);
        }
        json_response(['success' => false, 'error' => $conn->error]);
    } else {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) json_response(['success' => false, 'error' => 'Invalid id']);
        $stmt = $conn->prepare('UPDATE term_plans SET title = ?, description = ?, plan_date = ?, end_date = ?, event_type = ? WHERE id = ?');
        $stmt->bind_param('sssssi', $title, $description, $start, $end, $event_type, $id);
        if ($stmt->execute()) {
            session_start();
            $user_id = $_SESSION['admin_id'] ?? $_SESSION['staff_id'] ?? '';
            $username = $_SESSION['username'] ?? '';
            log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'update_term_plan', "id={$id};title={$title}");
            json_response(['success' => true]);
        }
        json_response(['success' => false, 'error' => $conn->error]);
    }
} elseif ($action === 'delete') {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id <= 0) json_response(['success' => false, 'error' => 'Invalid id']);
    $stmt = $conn->prepare('DELETE FROM term_plans WHERE id = ?');
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        session_start();
        $user_id = $_SESSION['admin_id'] ?? $_SESSION['staff_id'] ?? '';
        $username = $_SESSION['username'] ?? '';
        log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'administrator', 'delete_term_plan', "id={$id}");
        json_response(['success' => true]);
    }
    json_response(['success' => false, 'error' => $conn->error]);
} else {
    json_response(['success' => false, 'error' => 'Unknown action']);
}
