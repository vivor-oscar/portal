
<?php
include('../includes/database.php');

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Get the other form data
$gender = $_REQUEST['gender'] ?? '';
$first_name = $_REQUEST['first_name'] ?? '';
$mid_name = $_REQUEST['mid_name'] ?? '';
$last_name = $_REQUEST['last_name'] ?? '';
$dob = trim($_REQUEST['dob'] ?? '');
$number = trim($_REQUEST['number'] ?? '');
$email = trim($_REQUEST['email'] ?? '');
$class = $_REQUEST['class'] ?? '';
$curaddress = $_REQUEST['curaddress'] ?? '';
$parent_name = trim($_REQUEST['parent_name'] ?? '');
$parent_email = trim($_REQUEST['parent_email'] ?? '');
$parent_number = trim($_REQUEST['parent_number'] ?? '');
$role = $_REQUEST['role'] ?? '';

// Auto-generate username if empty (first.last) and ensure uniqueness
function generateUsername($conn, $first, $last) {
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

// Always generate username automatically from first and last name
$username = generateUsername($conn, $first_name, $last_name);

$defaultPassword = '123456';
$password = trim($_REQUEST['password'] ?? $defaultPassword);
$conpassword = trim($_REQUEST['conpassword'] ?? $defaultPassword);
if ($password === '') { $password = $defaultPassword; $conpassword = $defaultPassword; }
$hashPassword = password_hash($password, PASSWORD_BCRYPT);
$hashConPassword = password_hash($conpassword, PASSWORD_BCRYPT);

// Function to generate the student ID
function generateStudentID($conn) {
    // Generate random number and ensure it's unique in the students table.
    // We'll generate a zero-padded 10-digit number and prefix with 'STD'.
    $maxAttempts = 50;
    for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
        try {
            // Use cryptographically secure random generator when available
            $rand = random_int(0, 9999999999);
        } catch (Exception $e) {
            // Fallback
            $rand = mt_rand(0, 9999999999);
        }
        // Zero-pad to 10 digits (e.g. 0000000123)
        $num = str_pad((string)$rand, 10, '0', STR_PAD_LEFT);
        $candidate = 'STD' . $num;

        $esc = $conn->real_escape_string($candidate);
        $res = $conn->query("SELECT 1 FROM students WHERE student_id='" . $esc . "' LIMIT 1");
        if ($res && $res->num_rows == 0) {
            return $candidate;
        }
    }

    // If we couldn't find a unique random ID in reasonable attempts,
    // fall back to a timestamp-based ID to avoid collisions.
    return 'STD' . time() . sprintf('%04d', mt_rand(0, 9999));
}

$student_id = generateStudentID($conn);
if ($dob === '') $dob = date('Y-m-d');

// Duplicate check by email or phone when provided
if ($email !== '') {
    $er = $conn->query("SELECT COUNT(*) AS c FROM students WHERE email='" . $conn->real_escape_string($email) . "'");
    if ($er && ($rr = $er->fetch_assoc()) && (int)$rr['c'] > 0) {
        if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['status'=>'duplicate','message'=>'Email already exists']); mysqli_close($conn); exit; }
        else { echo 'Email already exists'; mysqli_close($conn); exit; }
    }
}

// Performing insert
$number_val = ($number === '') ? 'NULL' : "'" . $conn->real_escape_string($number) . "'";
$email_val = ($email === '') ? 'NULL' : "'" . $conn->real_escape_string($email) . "'";
$parent_name_val = ($parent_name === '') ? 'NULL' : "'" . $conn->real_escape_string($parent_name) . "'";
$parent_email_val = ($parent_email === '') ? 'NULL' : "'" . $conn->real_escape_string($parent_email) . "'";
$parent_number_val = ($parent_number === '') ? 'NULL' : "'" . $conn->real_escape_string($parent_number) . "'";

$sql = "INSERT INTO students (student_id, gender, first_name, mid_name, last_name, dob, number, email, class, curaddress, parent_name, parent_email, parent_number, role, username, password, conpassword) 
    VALUES ('" . $conn->real_escape_string($student_id) . "', '" . $conn->real_escape_string($gender) . "', '" . $conn->real_escape_string($first_name) . "', '" . $conn->real_escape_string($mid_name) . "', '" . $conn->real_escape_string($last_name) . "', '" . $conn->real_escape_string($dob) . "', " . $number_val . ", " . $email_val . ", '" . $conn->real_escape_string($class) . "', '" . $conn->real_escape_string($curaddress) . "', " . $parent_name_val . ", " . $parent_email_val . ", " . $parent_number_val . ", '" . $conn->real_escape_string($role) . "', '" . $conn->real_escape_string($username) . "', '" . $conn->real_escape_string($hashPassword) . "','" . $conn->real_escape_string($hashConPassword) . "')";

if (mysqli_query($conn, $sql)) {
   if ($isAjax) {
       header('Content-Type: application/json');
       echo json_encode(['status'=>'ok','message'=>'Saved successfully']);
   } else {
       echo '<script>window.history.back();</script>';
   }
} else {
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['status'=>'error','message'=>mysqli_error($conn)]); }
    else { echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn); }
}

mysqli_close($conn);
?>

