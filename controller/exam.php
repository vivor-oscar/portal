<?php

include('../../includes/database.php');
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$test_id =  $_POST['test_id'] ?? '';
$term =  $_POST['term'] ?? '';
$type =  $_POST['type'] ?? '';
$class_nm =  $_POST['class_nm'] ?? '';
$start_date =  $_POST['start_date'] ?? '';
$end_date =  $_POST['end_date'] ?? '';

// Duplicate check by test_id
$tid = $conn->real_escape_string($test_id);
$dq = $conn->query("SELECT COUNT(*) AS c FROM test WHERE test_id='" . $tid . "'");
if ($dq && ($r = $dq->fetch_assoc()) && (int)$r['c'] > 0) {
    header('Content-Type: application/json');
    echo json_encode(['status'=>'duplicate','message'=>'Test ID already exists']);
    mysqli_close($conn);
    exit;
}

$sql = "INSERT INTO test (test_id, term, type, class_nm, start_date, end_date) VALUES ('" . $tid . "', '" . $conn->real_escape_string($term) . "', '" . $conn->real_escape_string($type) . "', '" . $conn->real_escape_string($class_nm) . "', '" . $conn->real_escape_string($start_date) . "', '" . $conn->real_escape_string($end_date) . "')";

if (mysqli_query($conn, $sql)) {
    header('Content-Type: application/json');
    echo json_encode(['status'=>'ok','message'=>'Saved successfully']);
} else {
    header('Content-Type: application/json');
    echo json_encode(['status'=>'error','message'=>mysqli_error($conn)]);
}

mysqli_close($conn);
?>
