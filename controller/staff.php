<?php
include('../includes/database.php');

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$gender =  $_REQUEST['gender'] ?? '';
$first_name =  $_REQUEST['first_name'] ?? '';
$mid_name =  $_REQUEST['mid_name'] ?? '';
$last_name =  $_REQUEST['last_name'] ?? '';
$dob =  $_REQUEST['dob'] ?? '';
$number =  $_REQUEST['number'] ?? '';
$email =  $_REQUEST['email'] ?? '';
$curaddress =  $_REQUEST['curaddress'] ?? '';
$qualification =  $_REQUEST['qualification'] ?? '';
$join_date =  $_REQUEST['join_date'] ?? '';
$role =  $_REQUEST['role'] ?? '';
$username =  $_REQUEST['username'] ?? '';
$password =  $_REQUEST['password'] ?? '';
$conpassword =  $_REQUEST['conpassword'] ?? '';

// Duplicate username check
$usernameEsc = $conn->real_escape_string($username);
$dupr = $conn->query("SELECT COUNT(*) AS c FROM staff WHERE username='" . $usernameEsc . "'");
if ($dupr && ($rr = $dupr->fetch_assoc()) && (int)$rr['c'] > 0) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'duplicate', 'message' => 'Username already exists']);
        mysqli_close($conn);
        exit;
    } else {
        echo 'Username already exists';
        mysqli_close($conn);
        exit;
    }
}

// Function to generate the staff ID
function generateStaffID($conn)
{
    $result = $conn->query("SELECT staff_id FROM staff ORDER BY staff_id DESC LIMIT 1");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastStaffID = (int)substr($row['staff_id'], 3);
        $newStaffID = 'STF' . str_pad($lastStaffID + 1, 7, '0', STR_PAD_LEFT);
        return $newStaffID;
    } else {
        return 'STF001';
    }
}

$staff_id = generateStaffID($conn);
$hashPassword = password_hash($password, PASSWORD_BCRYPT);
$hashConPassword = password_hash($conpassword, PASSWORD_BCRYPT);

$sql = "INSERT INTO staff (staff_id, gender,first_name, mid_name, last_name, dob, number, email, curaddress, qualification, join_date, role, username, password, conpassword )  VALUES ('" . $conn->real_escape_string($staff_id) . "','" . $conn->real_escape_string($gender) . "','" . $conn->real_escape_string($first_name) . "','" . $conn->real_escape_string($mid_name) . "','" . $conn->real_escape_string($last_name) . "',
            '" . $conn->real_escape_string($dob) . "','" . $conn->real_escape_string($number) . "','" . $conn->real_escape_string($email) . "',
            '" . $conn->real_escape_string($curaddress) . "',
            '" . $conn->real_escape_string($qualification) . "','" . $conn->real_escape_string($join_date) . "',
            '" . $conn->real_escape_string($role) . "','" . $conn->real_escape_string($username) . "','" . $hashPassword . "', 
            '" . $hashConPassword . "')";
if (mysqli_query($conn, $sql)) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'ok', 'message' => 'Saved successfully']);
    } else {
        echo '<script>window.history.back();</script>';
    }
} else {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    } else {
        echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
    }
}

mysqli_close($conn);
