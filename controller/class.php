<?php

include('../../includes/database.php');
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$class_name = $_POST['class_name'] ?? '';

// Duplicate check
$cn = $conn->real_escape_string($class_name);
$dq = $conn->query("SELECT COUNT(*) AS c FROM class WHERE class_name='" . $cn . "'");
if ($dq && ($r = $dq->fetch_assoc()) && (int)$r['c'] > 0) {
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['status'=>'duplicate','message'=>'Class already exists']); mysqli_close($conn); exit; }
    else { echo 'Class already exists'; mysqli_close($conn); exit; }
}

function generateClassID($conn) {
    $result = $conn->query("SELECT class_id FROM class ORDER BY class_id DESC LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastClassID = (int)substr($row['class_id'], 3);
        $newClassID = 'CID' . str_pad($lastClassID + 1, 2, '0', STR_PAD_LEFT);
    } else {
        $newClassID = 'CID0';
    }
    return $newClassID;
}
$class_id = generateClassID($conn);
$sql = "INSERT INTO class (class_id, class_name) VALUES ('" . $conn->real_escape_string($class_id) . "', '" . $conn->real_escape_string($class_name) . "')";

if (mysqli_query($conn, $sql)) {
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['status'=>'ok','message'=>'Saved successfully']); }
    else { echo "Saved successfully"; header("location: ../admin/add-class.php"); }
} else {
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['status'=>'error','message'=>mysqli_error($conn)]); }
    else { echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn); }
}

mysqli_close($conn);
?>
