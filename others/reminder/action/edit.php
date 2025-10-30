<?php
session_start();
if (!isset($_SESSION["username"])) {
  header("Location: ../index.php");
}
if ($_SESSION['role'] !== 'staff' ) {
  header('Location: ../index.php');
  exit;
}

include('../../../../includes/database.php');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve data to edit
$id = $_GET['id'];
$sql = "SELECT * FROM subject_objectives WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $objective = $_POST['objective'];

  $update_sql = "UPDATE subject_objectives SET start_date='$start_date', end_date='$end_date', objective='$objective'";

  if (mysqli_query($conn, $update_sql)) {
    header("Location: index.php");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Add Class</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../../assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  
</head>
<body class="body">
  <div class="main-bar">
    <div>
      <div class="left-bar">
        <div>
          <div class="space"></div>

          <div>
            <p class="d-inline-flex gap-1">
              <a class="btn" role="button" data-bs-toggle="collapse" href="#drop1" aria-expanded="false" aria-controls="collapse">
                <b class="drop-btn"><img class="student-icon" src="../../assets/images/icons/icons8-student-64.png"></b>
              </a>
            </p>
            <div class="collapse" id="drop1">
              <div class="card card-body">
                <a class="link" href="students/index.php">View Students</a>
                <a class="link" href="#">Promote Students</a>
              </div>
            </div>
          </div>

          <div>
            <p class="d-inline-flex gap-1">
              <a class="btn" role="button" data-bs-toggle="collapse" href="#drop3" aria-expanded="false" aria-controls="collapse">
                <b class="drop-btn"><img class="results-icon" src="../../../assets/images/icons/icons8-results-64.png"></b>
              </a>
            </p>
            <div class="collapse" id="drop3">
              <div class="card card-body">
                <a class="link" href="../results/result-entry/level.php">Add Results</a>
                <a class="link" href="#">View Results</a>
              </div>
            </div>
          </div>
          <div>
            <p class="d-inline-flex gap-1">
              <a class="btn" role="button" data-bs-toggle="collapse" href="#drop4" aria-expanded="false" aria-controls="collapse">
                <b class="drop-btn"><img class="subjects-icon" src="../../../assets/images/icons/icons8-subjects-64.png"></b>
              </a>
            </p>
            <div class="collapse" id="drop4">
              <div class="card card-body">
                <a class="link" href="#">Add Subjects</a>
                <a class="link" href="#">View Subjects</a>
              </div>
            </div>
          </div>
          <div>
            <p class="d-inline-flex gap-1">
              <a class="btn" role="button" data-bs-toggle="collapse" href="#drop5" aria-expanded="false" aria-controls="collapse">
                <b class="drop-btn"><img class="exams-icon" src="../../../assets/images/icons/icons8-exams-64.png"></b>
              </a>
            </p>
            <div class="collapse" id="drop5">
              <div class="card card-body">
                <a class="link" href="#">Add Exams</a>
                <a class="link" href="#">View Exams</a>
              </div>
            </div>
          </div>
          <div>
            <p class="d-inline-flex gap-1">
              <a class="btn" role="button" data-bs-toggle="collapse" href="#drop7" aria-expanded="false" aria-controls="collapse">
                <b class="drop-btn"><img class="attend-icon" src="../../../assets/images/icons/icons8-attend-64.png"></b>
              </a>
            </p>
            <div class="collapse" id="drop7">
              <div class="card card-body">
                <a class="link" href="../attendance/check-in.php">Check In</a>
                <a class="link" href="#">Add Student Attendance</a>
                <a class="link" href="#">View Student Attendance</a>
              </div>
            </div>
          </div>
          <div>
            <p class="d-inline-flex gap-1">
              <a class="btn" role="button" data-bs-toggle="collapse" href="#drop8" aria-expanded="false" aria-controls="collapse">
                <b class="drop-btn"><img class="notify-icon" src="../../../assets/images/icons/icons8-notify-64.png"></b>
              </a>
            </p>
            <div class="collapse" id="drop8">
              <div class="card card-body">
                <a class="link" href="#">Add Notification</a>
                <a class="link" href="#">View Notification</a>
              </div>
            </div>
          </div>
          <div>
            <p class="d-inline-flex gap-1">
              <a class="btn" role="button" data-bs-toggle="collapse" href="#drop9" aria-expanded="false" aria-controls="collapse">
                <b class="drop-btn">
                  <img class="activity-icon" src="../../../assets/images/icons/icons8-activity-64.png">
                </b>
              </a>
            </p>
            <div class="collapse" id="drop9">
              <div class="card card-body">
                <a class="link" href="#">Add Activities</a>
                <a class="link" href="#">View Activities</a>
              </div>
            </div>
          </div>
          <div>
            <p class="d-inline-flex gap-1">
              <a class="btn" role="button" data-bs-toggle="collapse" href="#drop10" aria-expanded="false" aria-controls="collapse">
                <b class="drop-btn">
                  <img class="report-icon" src="../../../assets/images/icons/icons8-report-64.png">
                </b>
              </a>
            </p>
            <div class="collapse" id="drop10">
              <div class="card card-body">
                <a class="link" href="#">Report Staff</a>
                <a class="link" href="#">Report Student</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form method="post" action="">
    <h4 class="student-edit-heading">EDIT RECORD</h4>
    <div class="std-edit-container">
      
      <div >
        <div>
          <label>Middle Name:</label><br>
          <input type="text" id="subject_id" name="subject_id" value="<?php echo $row['subject_id']; ?>" class="std-input-box">
        </div>
        <div>
          <label>Email:</label><br>
          <input type="text" id="objective" name="objective" value="<?php echo $row['objective']; ?>" class="std-input-box">
        </div>
        <div>
          <label>Last Name:</label><br>
          <input type="text" id="start_date" name="start_date" value="<?php echo $row['start_date']; ?>" class="std-input-box">
        </div>
        <div>
          <label>Phone Number:</label><br>
          <input type="text" id="end_date" name="end_date" value="<?php echo $row['end_date']; ?>" class="std-input-box">
        </div>
        

      </div>
      <div>
        <input type="submit" class="savebtn" value="UPDATE">
      </div>
          
       
    </div>
  </form>
  <div>
    <div>
      <div>
        <div class="header">
          <!-- LEFT -->
          <div class="left-section">
            <div>
              <a style="text-decoration: none" href="staff-dashboard.php">
                <img class="dashboard-icon" src="../../../assets/images/icons/icons8-dashboard-32.png" />
              </a>
            </div>
          </div>

          <!-- MIDDLE -->
          <div class="mid-section">
            <div class="username"><?php echo $_SESSION["username"] ?></div>
            <div>
              <b class="timeout-text"> User session expires in </b>
              <span id="countdownDisplay" class="counter">00:00:00 </span>
            </div>
          </div>

          <!-- RIGHT -->
          <div class="right-section">
            <a href=""></a>
            <a href=""></a>
            <a href=""></a>
            <a href=""></a>
            <a href=""></a>
            <a href="#"><img class="person" src="../../../assets/images/icons/icons8-user-64.png" /></a>
            <a href="../session/logout.php"><img class="logout" src="../../../assets/images/icons/icons8-logout-64.png" /></a>
          </div>
        </div>
      </div>
    </div>
</body>
<script src="../../js/count.js"></script>
</html>
<?php
mysqli_close($conn);
?>