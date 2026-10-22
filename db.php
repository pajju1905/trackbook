<?php
// Local development configuration. Set environment variables for your environment.
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'trackbook';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    error_log('TrackBook database connection failed: ' . $conn->connect_error);
    die('Database connection failed. Check your local database configuration.');
}
?>
