<?php
include('../../includes/database.php');
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$subject_id =  $_REQUEST['subject_id'] ?? '';
$subject_name = $_REQUEST['subject_name'] ?? '';

// Duplicate check
$sn = $conn->real_escape_string($subject_name);
$dq = $conn->query("SELECT COUNT(*) AS c FROM subjects WHERE subject_name='" . $sn . "'");
if ($dq && ($r = $dq->fetch_assoc()) && (int)$r['c'] > 0) {
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['status'=>'duplicate','message'=>'Subject already exists']); mysqli_close($conn); exit; }
    else { echo 'Subject already exists'; mysqli_close($conn); exit; }
}

$sql = "INSERT INTO subjects (subject_id, subject_name) VALUES ('" . $conn->real_escape_string($subject_id) . "', '" . $conn->real_escape_string($subject_name) . "')";

if (mysqli_query($conn, $sql)) {
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['status'=>'ok','message'=>'Saved successfully']); }
    else { header("location: ../staff/add-subject.php"); }
} else {
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['status'=>'error','message'=>mysqli_error($conn)]); }
    else { echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn); }
}

mysqli_close($conn);
?>