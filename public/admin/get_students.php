<?php
// get_students.php
include '../../includes/database.php';

$class_name = isset($_GET['class_name']) ? ($_GET['class_name']) : 0;
$students = [];

if ($class_name) {
    // Escape the class_id to prevent SQL injection
    $class_name = $conn->real_escape_string($class_name);
    
    $students_query = "SELECT student_id, first_name, last_name, class FROM students WHERE class= '$class_name'";
    $students_result = $conn->query($students_query);
    
    if ($students_result && $students_result->num_rows > 0) {
        while ($row = $students_result->fetch_assoc()) {
            $students[] = $row;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($students);
?>
