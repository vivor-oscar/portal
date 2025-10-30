<?php

include('../../includes/database.php');
// Taking all 5 values from the form data(input)

$class_name =  $_POST['class_name'];


// Function to generate the student ID
function generateClassID($conn) {
    // Query to get the last student ID from the database
    $result = $conn->query("SELECT class_id FROM class ORDER BY class_id DESC LIMIT 1");
    
    if ($result->num_rows > 0) {
        // Fetch the last class ID
        $row = $result->fetch_assoc();
        $lastClassID = (int)substr($row['class_id'], 3);  // Extract the number part from 'CIDxxxxx'
        $newClassID = 'CID' . str_pad($lastClassID + 1, 2, '0', STR_PAD_LEFT); // Increment the ID and pad with leading zeros
    } else {
        // If no student exists, start from CID0
        $newClassID = 'CID0';
    }

    return $newClassID;
}
$class_id =  generateClassID($conn);
// Performing insert query execution
$sql = "INSERT INTO class (class_id, class_name) VALUES ('$class_id', '$class_name')";

if (mysqli_query($conn, $sql)) {
    echo "Saved successfully";
    header("location: ../admin/add-class.php");
} else {
    echo "ERROR: Hush! Sorry $sql. "
        . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
