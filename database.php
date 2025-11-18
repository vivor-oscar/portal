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
$host = getenv('DB_HOST') ?: 'sql304.ezyro.com';
$dbname = getenv('DB_NAME') ?: 'ezyro_38431900_portal';
$username = getenv('DB_USER') ?: 'ezyro_38431900';
$password = getenv('DB_PASS') ?: 'Savage16@@';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>