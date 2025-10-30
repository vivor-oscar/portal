<?php

include('../../includes/database.php');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}
// Taking all 5 values from the form data(input)
$test_id =  $_POST['test_id'];
$term =  $_POST['term'];
$type =  $_POST['type'];
$class_nm =  $_POST['class_nm'];
$start_date =  $_POST['start_date'];
$end_date =  $_POST['end_date'];
// Performing insert query execution
$sql = "INSERT INTO test VALUES ('$test_id','$term','$type','$class_nm','$start_date','$end_date')";

if (mysqli_query($conn, $sql)) {
    echo "Saved successfully";
} else {
    echo "ERROR: Hush! Sorry $sql. "
        . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
