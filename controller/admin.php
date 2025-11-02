
<?php

include('../includes/database.php');

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$admin_id = $_POST['admin_id'] ?? '';
$name =  $_POST['name'] ?? '';
$role = $_POST['role'] ?? '';
$username =  $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$conpassword = $_POST['conpassword'] ?? '';
$hashPassword = password_hash($password, PASSWORD_BCRYPT);
$hashConPassword = password_hash($conpassword, PASSWORD_BCRYPT);

$sql = "INSERT INTO administrator (admin_id, name, role, username, password, conpassword) VALUES ('" . $admin_id . "','" . $conn->real_escape_string($name) . "', '" . $conn->real_escape_string($role) . "', '" . $username . "', '" . $hashPassword . "', '" . $hashConPassword . "')";

if (mysqli_query($conn, $sql)) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'ok', 'message' => 'Saved successfully']);
    } else {
        echo "Saved successfully";
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
} else {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    } else {
        echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
