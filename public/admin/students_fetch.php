<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'administrator') {
  exit("Unauthorized");
}

include('../../includes/database.php');

if (!isset($_GET['id'])) {
  exit("No ID given");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
  exit("Student not found");
}

// Build select options
$locations = ['Akwatia','Kade','Nkwatanang','Boadua','Bamenase','Apinamang','Topremang','Cayco'];
$optionsHtml = '<option value="">Select location</option>';
foreach ($locations as $loc) {
  $sel = ($row['curaddress'] === $loc) ? ' selected' : '';
  $optionsHtml .= "<option value=\"$loc\"$sel>$loc</option>";
}

$sid = htmlspecialchars($row['student_id'], ENT_QUOTES);
$first = htmlspecialchars($row['first_name'], ENT_QUOTES);
$mid = htmlspecialchars($row['mid_name'], ENT_QUOTES);
$last = htmlspecialchars($row['last_name'], ENT_QUOTES);
$num = htmlspecialchars($row['number'], ENT_QUOTES);
$email = htmlspecialchars($row['email'], ENT_QUOTES);
$classVal = htmlspecialchars($row['class'], ENT_QUOTES);
$usernameVal = htmlspecialchars($row['username'], ENT_QUOTES);

echo '<form method="POST" action="students.php" class="space-y-4">'
  . '<input type="hidden" name="student_id" value="' . $sid . '">'
  . '<h3 class="text-lg font-semibold">Edit Student</h3>'
  . '<div class="grid md:grid-cols-3 gap-4">'
  . '<div><label>First Name</label><input type="text" name="first_name" value="' . $first . '"></div>'
  . '<div><label>Middle Name</label><input type="text" name="mid_name" value="' . $mid . '"></div>'
  . '<div><label>Last Name</label><input type="text" name="last_name" value="' . $last . '"></div>'
  . '<div><label>Phone</label><input type="text" name="number" value="' . $num . '"></div>'
  . '<div><label>Email</label><input type="email" name="email" value="' . $email . '"></div>'
  . '<div><label>Class</label><input type="text" name="class" value="' . $classVal . '"></div>'
  . '<div><label>Current Address</label><select name="curaddress">' . $optionsHtml . '</select></div>'
  . '<div><label>Username</label><input type="text" name="username" value="' . $usernameVal . '"></div>'
  . '<div><label>Password</label><input type="password" name="password"></div>'
  . '<div><label>Confirm Password</label><input type="password" name="conpassword"></div>'
  . '</div>'
  . '<div class="text-right"><button type="submit" name="update" class="px-6 py-2 bg-blue-600 text-white rounded">Save Changes</button></div>'
  . '</form>';
