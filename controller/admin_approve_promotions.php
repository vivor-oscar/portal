<?php
// Admin endpoint: approve pending promotions and apply them.
include('../includes/database.php');

header('Content-Type: application/json');

session_start();
// Basic check for admin role - adjust to your auth system as needed
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrator') {
    echo json_encode(['status'=>'error','message'=>'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Accept either class_names[] to approve all pending for those classes
// or student_ids[] to approve specific students. If neither provided, process all pending.
$class_names = $_POST['class_names'] ?? [];
$student_ids = $_POST['student_ids'] ?? [];
if (!is_array($class_names)) $class_names = [$class_names];
if (!is_array($student_ids)) $student_ids = [$student_ids];

$processed = 0;
$failed = 0;
$errors = [];

// Build SQL selection depending on inputs
if (count($student_ids) > 0 && strlen(implode('', $student_ids)) > 0) {
    // process specific student ids
    $escaped = array_map(function($s){ global $conn; return "'" . $conn->real_escape_string($s) . "'"; }, $student_ids);
    $where = "WHERE promotion_status='pending' AND student_id IN (" . implode(',', $escaped) . ")";
} elseif (count($class_names) > 0 && strlen(implode('', $class_names)) > 0) {
    $escaped = array_map(function($c){ global $conn; return "'" . $conn->real_escape_string($c) . "'"; }, $class_names);
    $where = "WHERE promotion_status='pending' AND `class` IN (" . implode(',', $escaped) . ")";
} else {
    $where = "WHERE promotion_status='pending'";
}

$sql = "SELECT student_id, `class`, promotion_target FROM students " . $where;
$res = $conn->query($sql);
if (!$res) {
    echo json_encode(['status'=>'error','message'=>'Query failed: ' . $conn->error]);
    exit;
}

while ($r = $res->fetch_assoc()) {
    $sid_raw = $r['student_id'];
    $sid = $conn->real_escape_string($sid_raw);
    $target = $r['promotion_target'];
    if ($target === null || $target === '') {
        $errors[] = "No target for $sid_raw";
        $failed++;
        // mark failed
        $conn->query("UPDATE students SET promotion_status='failed' WHERE student_id='" . $sid . "'");
        continue;
    }

    // If target looks like 'Old Student - YEAR' extract year
    $newClass = $target;
    $year = date('Y');
    $alumniYear = null;
    if (preg_match('/Old Student\s*-\s*(\d{4})$/', $target, $m)) {
        $alumniYear = (int)$m[1];
        $newClass = 'Old Student - ' . $year;
    }

    $escClass = $conn->real_escape_string($newClass);
    $update = "UPDATE students SET `class`='" . $escClass . "', promotion_status='success', promotion_target=NULL";
    if ($alumniYear !== null) {
        $update .= ", alumni_year=" . intval($alumniYear);
    }
    $update .= " WHERE student_id='" . $sid . "'";

    if ($conn->query($update)) {
        $processed++;
    } else {
        $errors[] = "Failed to apply $sid_raw: " . $conn->error;
        $failed++;
        $conn->query("UPDATE students SET promotion_status='failed' WHERE student_id='" . $sid . "'");
    }
}

echo json_encode(['status'=>'ok','processed'=>$processed,'failed'=>$failed,'errors'=>$errors]);
$conn->close();
exit;

?>
