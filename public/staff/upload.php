<?php
include 'include/side-bar.php';
include '../../includes/database.php';

$staff_username = $_SESSION['username'];
$staff_result = $conn->query("SELECT staff_id FROM staff WHERE username = '$staff_username'");
$staff_data = $staff_result->fetch_assoc();
$staff_id = $staff_data['staff_id'];

// Get assigned class
$class_query = $conn->query("
    SELECT c.class_name FROM staff_classes sc 
    JOIN class c ON sc.class_name = c.class_name
    WHERE sc.staff_id = '$staff_id'
");
$class_row = $class_query->fetch_assoc();

if (!$class_row) {
  $error = "No class assigned to you.";
} else {
  $class_name = $class_row['class_name'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $target_dir = "../../resultroom/";
    $target_file = $target_dir . basename($_FILES['file']['name']);
    $file_type =  strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_type = array("pdf", "png", "jpeg", "gif");
    if (!in_array($file_type, $allowed_type)) {
      echo "Sorry pdfs and images only";
    } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $student_id = $_REQUEST["student_id"];
        $filename = $_FILES["file"]["name"];
        $filesize = $_FILES["file"]["size"];
        $filetype = $_FILES["file"]["type"];
        include('../../includes/database.php');
        if ($conn->connect_error) {
          die("connection failed" . $conn->connect_error);
        }

        $sql = "INSERT INTO results (student_id, filename, filesize, filetype) VALUES ('$student_id', '$filename', $filesize, '$filetype')";
        if ($conn->query($sql) === TRUE) {
          // log upload
          if (file_exists(__DIR__ . '/../../includes/logger.php')) {
            include_once __DIR__ . '/../../includes/logger.php';
            session_start();
            $user_id = $_SESSION['staff_id'] ?? '';
            $username = $_SESSION['username'] ?? '';
            log_activity($conn, $user_id, $username, $_SESSION['role'] ?? 'staff', 'upload_result', "student={$student_id};file={$filename};size={$filesize}");
          }
          echo "Success";
        } else {
          echo "Sorry there was an error while trying to upload the file" . $conn->error;
        }
        //$conn->close();
      } else {
        echo "Oops, there was an error";
      }
    }
  } else {
    echo "No file  was uploaded";
  }
}
?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-start pt-10">
      <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Upload Student Results</h2>
        <form action="#" method="post" enctype="multipart/form-data" class="space-y-6">
          <div>
            <div>
              <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Student ID</label>
              <select type="text" name="student_id" id="student_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3">
                <option value="">Select Student ID</option>
                <?php
                // Query students and their attendance status for selected date
                $student_query = "SELECT s.student_id, s.first_name, s.last_name FROM students s WHERE s.class = '$class_name'";
                $students_result = $conn->query($student_query);
                while ($s = $students_result->fetch_assoc()): ?>
                  <option value="<?php echo $s['student_id']; ?>"><?php echo $s['first_name'] . ' ' . $s['last_name']; ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div>
              <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Select File</label>
              <input type="file" name="file" id="file" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
              <p class="mt-2 text-xs text-gray-500">Accepted formats: PDF, PNG, JPEG, GIF</p>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              Upload
            </button>
        </form>