<?php
// Endpoint: promote selected students to next class.
// If a student is in Basic 9 (or class ending with 9), set class to "Old Student - YEAR".
include('../includes/database.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$student_ids = $_POST['student_ids'] ?? [];
if (!is_array($student_ids)) $student_ids = [$student_ids];

if (count($student_ids) === 0) {
    echo json_encode(['status' => 'error', 'message' => 'No students selected']);
    exit;
}

$updated = 0;
$created_pending = 0;
$errors = [];
$year = date('Y');

foreach ($student_ids as $sid) {
    $sid = trim($sid);
    if ($sid === '') continue;
    $sidEsc = $conn->real_escape_string($sid);
    $res = $conn->query("SELECT `class` FROM students WHERE student_id='" . $sidEsc . "' LIMIT 1");
    if (!$res || $res->num_rows === 0) {
        $errors[] = "Student $sid not found";
        continue;
    }
    $row = $res->fetch_assoc();
    $curClass = $row['class'] ?? '';
    $newClass = null;

    // If class ends with a number, increment. If it's 9 -> promote to Old Student - YEAR
    if (preg_match('/(\d+)\s*$/', $curClass, $m)) {
        $num = (int)$m[1];
        if ($num === 9) {
            $newClass = "Old Student - " . $year;
        } else {
            $next = $num + 1;
            $newClass = preg_replace('/\d+\s*$/', $next, $curClass);
        }
    } else {
        // Try to find next class from class table ordered by class_id
        $classesRes = $conn->query("SELECT class_name FROM class ORDER BY class_id ASC");
        $found = false;
        $nextClass = null;
        if ($classesRes) {
            while ($c = $classesRes->fetch_assoc()) {
                if ($found) { $nextClass = $c['class_name']; break; }
                if ($c['class_name'] === $curClass) { $found = true; }
            }
        }
        if (!empty($nextClass)) {
            $newClass = $nextClass;
        } else {
            // Fallback to marking as old student
            $newClass = "Old Student - " . $year;
        }
    }

    if ($newClass === null) {
        $errors[] = "Could not determine next class for $sid";
        continue;
    }

    // Instead of applying immediately, create a pending promotion
    $escTarget = $conn->real_escape_string($newClass);
    $sql = "UPDATE students SET promotion_status='pending', promotion_target='" . $escTarget . "' WHERE student_id='" . $sidEsc . "'";
    if ($conn->query($sql)) {
        $created_pending++;
    } else {
        $errors[] = "Failed to mark pending for $sid: " . $conn->error;
    }
}
echo json_encode(['status' => 'ok', 'created_pending' => $created_pending, 'errors' => $errors]);
mysqli_close($conn);
exit;

?>
