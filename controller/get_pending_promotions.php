<?php
// Return pending promotions for a given class (JSON)
include('../includes/database.php');
header('Content-Type: application/json');

session_start();
// Basic admin check - allow admins only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrator') {
    echo json_encode(['status'=>'error','message'=>'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status'=>'error','message'=>'Invalid request method']);
    exit;
}

$class = trim($_POST['class_name'] ?? '');
if ($class === '') { echo json_encode(['status'=>'error','message'=>'Missing class_name']); exit; }

$esc = $conn->real_escape_string($class);
$sql = "SELECT student_id, first_name, mid_name, last_name, promotion_target FROM students WHERE `class`='" . $esc . "' AND promotion_status='pending'";
$res = $conn->query($sql);
if (!$res) { echo json_encode(['status'=>'error','message'=>$conn->error]); exit; }

$rows = [];
while ($r = $res->fetch_assoc()) {
    $rows[] = $r;
}

echo json_encode(['status'=>'ok','class'=>$class,'students'=>$rows]);
$conn->close();
exit;

?>
