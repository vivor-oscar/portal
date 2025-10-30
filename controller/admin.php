
<?php

include('../../includes/database.php');

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$id = $_POST['administrator_id'] ?? '';
$name =  $_POST['name'] ?? '';
$role = $_POST['role'] ?? '';
$username =  $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$conpassword = $_POST['conpassword'] ?? '';

$id_esc = $conn->real_escape_string($id);
$username_esc = $conn->real_escape_string($username);

// Duplicate check: by administrator_id or username
$dupQ = $conn->query("SELECT COUNT(*) AS c FROM administrator WHERE administrator_id='" . $id_esc . "' OR username='" . $username_esc . "'");
if ($dupQ && ($r = $dupQ->fetch_assoc()) && (int)$r['c'] > 0) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'duplicate', 'message' => 'Administrator with same ID or username already exists']);
        mysqli_close($conn);
        exit;
    } else {
        echo "Administrator with same ID or username already exists";
        mysqli_close($conn);
        exit;
    }
}

$hashPassword = password_hash($password, PASSWORD_BCRYPT);
$hashConPassword = password_hash($conpassword, PASSWORD_BCRYPT);

$sql = "INSERT INTO administrator (administrator_id, name, role, username, password, conpassword) VALUES ('" . $id_esc . "','" . $conn->real_escape_string($name) . "', '" . $conn->real_escape_string($role) . "', '" . $username_esc . "', '" . $hashPassword . "', '" . $hashConPassword . "')";

if (mysqli_query($conn, $sql)) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'ok', 'message' => 'Saved successfully']);
    } else {
        echo "Saved successfully";
        header("location: ../admin/settings.php");
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
