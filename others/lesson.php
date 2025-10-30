<?php
include('include/sidebar.php')
?>
<?php
include('../../includes/database.php');
error_reporting(0);
@ini_set('display_error', 0);
$subject_id = $conn->real_escape_string($_POST['subject_id']);
$start_date = $conn->real_escape_string($_POST['start_date']);
$end_date = $conn->real_escape_string($_POST['end_date']);
$objective = $conn->real_escape_string($_POST['objective']);

$sql = "INSERT INTO subject_objectives (subject_id, objective, start_date, end_date) VALUES ('$subject_id', '$objective', '$start_date', '$end_date')";

if ($conn->query($sql) === TRUE) {
  //header('Location: ../staff/reminder/lesson.php');
} else {
  //echo 'Failed to connect';
}

?>
<div style="margin: 150px;">
  <form action="#" method="post">

    <label for="subject_id">Subject ID:</label>
    <input type="text" id="subject_id" name="subject_id" required><br><br>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required><br><br>

    <label for="end_date">Date:</label>
    <input type="date" id="end_date" name="end_date" required><br><br>

    <label for="objective">Objective:</label>
    <textarea id="objective" name="objective" rows="4" cols="50" required></textarea><br><br>

    <input type="submit" value="Submit Report">
  </form>
</div>
<?php
include('include/header.php')
?>