<?php
include('include/sidebar.php')
?>
<?php
include('../../includes/database.php');
error_reporting(0);
@ini_set('display_error', 0);

// Retrieve and escape form data
$staff_id = $conn->real_escape_string($_POST['staff_id']);
$subject_id = $conn->real_escape_string($_POST['subject_id']);
$report_date = $conn->real_escape_string($_POST['report_date']);
$report = $conn->real_escape_string($_POST['report']);

// Insert new report into the database
$sql = "INSERT INTO reports (staff_id, subject_id, report_date, report) VALUES ('$staff_id', '$subject_id', '$report_date', '$report')";

if ($conn->query($sql) === TRUE) {
  //header('../staff/reminder/reminder.php');
} else {
  // echo "Error: " . $conn->error;
}
$conn->close();
?>
<?php
include('../../includes/database.php');

// Display data
$sql = "SELECT * FROM subject_objectives";
$result = mysqli_query($conn, $sql);
?>
<h2 class="edit-title">All Students</h2>
<div class="tab">
  <form action="#" method="post">

    <label for="teacher_id">Teacher ID:</label>
    <input type="text" id="staff_id" name="staff_id" required>

    <label for="subject_id">Subject ID:</label>
    <input type="text" id="subject_id" name="subject_id" required>

    <label for="report_date">Date:</label>
    <input type="date" id="report_date" name="report_date" required>

    <label for="report">Report:</label>
    <textarea id="report" name="report" rows="2" cols="100" placeholder="Type report here..." required></textarea>

    <input type="submit" value="Submit Report">
  </form>
  <table style="margin-top: 20px;">
    <tr>
      <div>
        <th class="tab-head">Subject ID</th>
        <th class="tab-head">Objective</th>
        <th class="tab-head">Start Date</th>
        <th class="tab-head">End Date</th>
        <th class="tab-head">Action</th>
    </tr>
    <?php

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td class='tab-data'>" . $row['subject_id'] . "</td>";
        echo "<td class='tab-data'>" . $row['objective'] . "</td>";
        echo "<td class='tab-data'>" . $row['start_date'] . "</td>";
        echo "<td class='tab-data'>" . $row['end_date'] . "</td>";
        echo "<td class='tab-data'><a href='reminder/action/edit.php?id=" . $row['id'] . "'>Edit</a> | <a href='reminder/action/delete.php?id=" . $row['id'] . "'>Delete</a></td>";
        echo "</tr>";
      }
    } else {
      echo "<tr><td colspan='4'>No records found</td></tr>";
    }
    ?>
  </table>

</div>
<?php
include('include/header.php')
?>