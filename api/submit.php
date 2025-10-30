<?php
// /api/submit.php
// Generic endpoint to handle different actions from JS

// Connect to database
require_once  '/../includes/database.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

// Get action from POST data
$action = isset($_POST['action']) ? $_POST['action'] : '';
$response = [];

switch ($action) {
    case 'class':
        $class_id = $_POST['class_id'] ?? '';
        $class_name = $_POST['class_name'] ?? '';
        $sql = "INSERT INTO classes (class_id, class_name) VALUES ('$class_id', '$class_name')";
        if ($conn->query($sql)) {
            $response = ['status' => 'success', 'message' => 'Class saved'];
        } else {
            $response = ['status' => 'error', 'message' => $conn->error];
        }
        break;
    case 'subject':
        $subject_id = $_POST['subject_id'] ?? '';
        $subject_name = $_POST['subject_name'] ?? '';
        $sql = "INSERT INTO subjects (subject_id, subject_name) VALUES ('$subject_id', '$subject_name')";
        if ($conn->query($sql)) {
            $response = ['status' => 'success', 'message' => 'Subject saved'];
        } else {
            $response = ['status' => 'error', 'message' => $conn->error];
        }
        break;
    case 'exam':
        $test_id = $_POST['test_id'] ?? '';
        $term = $_POST['term'] ?? '';
        $type = $_POST['type'] ?? '';
        $class_nm = $_POST['class_nm'] ?? '';
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';
        $sql = "INSERT INTO exams (test_id, term, type, class_nm, start_date, end_date) VALUES ('$test_id', '$term', '$type', '$class_nm', '$start_date', '$end_date')";
        if ($conn->query($sql)) {
            $response = ['status' => 'success', 'message' => 'Exam saved'];
        } else {
            $response = ['status' => 'error', 'message' => $conn->error];
        }
        break;
    case 'assign_staff':
        $staff_id = $_POST['staff_id'] ?? '';
        $classame = $_POST['classame'] ?? '';
        $sql = "INSERT INTO staff_assignments (staff_id, classame) VALUES ('$staff_id', '$classame')";
        if ($conn->query($sql)) {
            $response = ['status' => 'success', 'message' => 'Staff assigned'];
        } else {
            $response = ['status' => 'error', 'message' => $conn->error];
        }
        break;
    default:
        http_response_code(400);
        $response = ['error' => 'Invalid action'];
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
