<?php
// Simple audit logger utilities
// Usage: require_once 'includes/logger.php'; then call log_activity($conn, $user_id, $username, $role, $action, $details);

function _get_ip_address()
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ips[0]);
    }
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    return $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
}

function log_activity($conn, $user_id, $username, $role, $action, $details = null)
{
    if (!isset($conn)) return false;
    $ip = _get_ip_address();

    $stmt = $conn->prepare("INSERT INTO audit_logs (user_id, username, role, action, details, ip) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('ssssss', $user_id, $username, $role, $action, $details, $ip);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

?>
