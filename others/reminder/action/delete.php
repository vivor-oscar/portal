<?php
// Database connection
include('../../../../includes/database.php');

// Delete record
$id = $_GET['id'];
$delete_sql = "DELETE FROM subject_objectives WHERE id=$id";

if (mysqli_query($conn, $delete_sql)) {
    header("Location: ../reminder.php");
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
