<?php
// Load Composer autoloader if available
$autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
    if (class_exists('Dotenv\\Dotenv')) {
        try {
            $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->safeLoad();
        } catch (Exception $e) {
            // If dotenv fails, fall back to environment variables
        }
    }
}

// Read configuration from environment variables with sensible defaults
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'portal';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';

$mysqli_report_flags = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
mysqli_report($mysqli_report_flags);

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('Database connection error: ' . $e->getMessage());
    http_response_code(500);
    // Generic message for users; real error is written to logs
    die('Internal Server Error');
}
?>