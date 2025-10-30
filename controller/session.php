<?php

include('../includes/database.php');

// Determine which form is being submitted by checking a unique 'action' POST/REQUEST parameter
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

switch ($action) {
    case 'add_exam':
        // Exam form handler
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            exit;
        }
        $test_id =  $_POST['test_id'];
        $term =  $_POST['term'];
        $type =  $_POST['type'];
        $class_nm =  $_POST['class_nm'];
        $start_date =  $_POST['start_date'];
        $end_date =  $_POST['end_date'];
        $sql = "INSERT INTO test VALUES ('$test_id','$term','$type','$class_nm','$start_date','$end_date')";
        if (mysqli_query($conn, $sql)) {
            echo "Saved successfully";
        } else {
            echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
        }
        break;
    case 'add_class':
        // Class form handler
        $class_name = $_POST['class_name'];
        function generateClassID($conn) {
            $result = $conn->query("SELECT class_id FROM class ORDER BY class_id DESC LIMIT 1");
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastClassID = (int)substr($row['class_id'], 3);
                $newClassID = 'CID' . str_pad($lastClassID + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $newClassID = 'CID0';
            }
            return $newClassID;
        }
        $class_id =  generateClassID($conn);
        $sql = "INSERT INTO class (class_id, class_name) VALUES ('$class_id', '$class_name')";
        if (mysqli_query($conn, $sql)) {
            echo "Saved successfully";
            header("location: ../admin/add-class.php");
        } else {
            echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
        }
        break;
    case 'add_student':
        // Student form handler
        $gender = $_REQUEST['gender'];
        $first_name = $_REQUEST['first_name'];
        $mid_name = $_REQUEST['mid_name'];
        $last_name = $_REQUEST['last_name'];
        $dob = $_REQUEST['dob'];
        $number = $_REQUEST['number'];
        $email = $_REQUEST['email'];
        $class = $_REQUEST['class'];
        $healthinsur = $_REQUEST['healthinsur'];
        $curaddress = $_REQUEST['curaddress'];
        $cityname = $_REQUEST['cityname'];
        $parent_first_name = $_REQUEST['parent_first_name'];
        $parent_mid_name = $_REQUEST['parent_mid_name'];
        $parent_last_name = $_REQUEST['parent_last_name'];
        $parent_email = $_REQUEST['parent_email'];
        $parent_number = $_REQUEST['parent_number'];
        $role = $_REQUEST['role'];
        $username = trim($_REQUEST['username'] ?? '');
        $password = trim($_REQUEST['password'] ?? '');
        $conpassword = trim($_REQUEST['conpassword'] ?? '');

        // Helper to generate username from first and last name and ensure uniqueness
        function generateUsernameSession($conn, $first, $last) {
            $base = strtolower(preg_replace('/[^a-z0-9]/', '', $first . '.' . $last));
            if ($base === '') $base = 'user';
            $candidate = $base;
            $i = 1;
            while (true) {
                $esc = $conn->real_escape_string($candidate);
                $res = $conn->query("SELECT COUNT(*) AS c FROM students WHERE username='$esc'");
                if ($res) {
                    $row = $res->fetch_assoc();
                    if ((int)$row['c'] === 0) break;
                }
                $candidate = $base . $i;
                $i++;
            }
            return $candidate;
        }

        if ($username === '') {
            $username = generateUsernameSession($conn, $first_name, $last_name);
        }

        // Default password to '1234' if not provided
        if ($password === '') {
            $password = '1234';
            $conpassword = '1234';
        }

        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $hashConPassword = password_hash($conpassword, PASSWORD_BCRYPT);
        function generateStudentID($conn) {
            $result = $conn->query("SELECT student_id FROM students ORDER BY student_id DESC LIMIT 1");
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastStudentID = (int)substr($row['student_id'], 3);
                $newStudentID = 'STD' . str_pad($lastStudentID + 1, 7, '0', STR_PAD_LEFT);
            } else {
                $newStudentID = 'STD0000001';
            }
            return $newStudentID;
        }
        $student_id = generateStudentID($conn);
        $sql = "INSERT INTO students (student_id, gender, first_name, mid_name, last_name, dob, number, email, class, healthinsur, curaddress, cityname, parent_first_name, parent_mid_name, parent_last_name, parent_email, parent_number, role, username, password, conpassword) VALUES ('$student_id', '$gender', '$first_name', '$mid_name', '$last_name', '$dob', '$number', '$email', '$class', '$healthinsur', '$curaddress', '$cityname',  '$parent_first_name', '$parent_mid_name', '$parent_last_name', '$parent_email', '$parent_number', '$role', '$username', '$hashPassword','$hashConPassword')";
        if (mysqli_query($conn, $sql)) {
            header('../admin/admin-dashboard.php');
        } else {
            echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
        }
        break;
    case 'add_staff':
        // Staff form handler
        $gender =  $_REQUEST['gender'];
        $first_name =  $_REQUEST['first_name'];
        $mid_name =  $_REQUEST['mid_name'];
        $last_name =  $_REQUEST['last_name'];
        $dob =  $_REQUEST['dob'];
        $number =  $_REQUEST['number'];
        $email =  $_REQUEST['email'];
        $healthinsur =  $_REQUEST['healthinsur'];
        $curaddress =  $_REQUEST['curaddress'];
        $cityname =  $_REQUEST['cityname'];
        $qualification =  $_REQUEST['qualification'];
        $join_date =  $_REQUEST['join_date'];
        $curr_position =  $_REQUEST['curr_position'];
        $role =  $_REQUEST['role'];
        $username =  $_REQUEST['username'];
        $password =  $_REQUEST['password'];
        $conpassword =  $_REQUEST['conpassword'];
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $hashConPassword = password_hash($conpassword, PASSWORD_BCRYPT);
        function generateStaffID($conn) {
            $result = $conn->query("SELECT staff_id FROM staff ORDER BY staff_id DESC LIMIT 1");
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastStaffID = (int)substr($row['staff_id'], 3);
                $newStaffID = 'STF' . str_pad($lastStaffID + 1, 7, '0', STR_PAD_LEFT);
            } else {
                $newStaffID = 'STF0000001';
            }
            return $newStaffID;
        }
        $staff_id = generateStaffID($conn);
        $sql = "INSERT INTO staff (staff_id, gender,first_name, mid_name, last_name, dob, number, email,healthinsur, curaddress, cityname,qualification, join_date, curr_position,role,username, password, conpassword )  VALUES ('$staff_id','$gender','$first_name','$mid_name','$last_name','$dob','$number','$email','$healthinsur','$curaddress','$cityname','$qualification','$join_date','$curr_position','$role','$username','$hashPassword','$hashConPassword')";
        if (mysqli_query($conn, $sql)) {
            header("location: ../admin/admin-dashboard.php");
        } else {
            echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
        }
        break;
    case 'add_settings':
        // Settings form handler
        $image =  $_POST['image'];
        $school_name =  $_POST['school_name'];
        $type_of_institution = $_POST['type_of_institution'];
        $address =  $_POST['address'];
        $enrollment_capacity =  $_POST['enrollment_capacity'];
        $facilities = $_POST['facilities'];
        $email =  $_POST['email'];
        $contact =  $_POST['contact'];
        $academic_year = $_POST['academic_year'];
        $sql = "INSERT INTO school_details VALUES ('$image','$school_name', '$type_of_institution','$address','$enrollment_capacity', '$facilities','$email','$contact', '$academic_year')";
        if (mysqli_query($conn, $sql)) {
            echo "Saved successfully";
            header("location: ../admin/settings.php");
        } else {
            echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
        }
        break;
    case 'add_subject':
        // Subject form handler
        $subject_id =  $_REQUEST['subject_id'];
        $subject_name = $_REQUEST['subject_name'];
        $sql = "INSERT INTO subjects  VALUES ('$subject_id', '$subject_name')";
        if (mysqli_query($conn, $sql)) {
            header("location: ../staff/add-subject.php");
        } else {
            echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
        }
        break;
    default:
        echo "No valid action specified.";
        break;
}

// Close connection
mysqli_close($conn);
