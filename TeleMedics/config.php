<?php
// TeleMedics Configuration File

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'telemedics_db');

// Application Settings
define('APP_NAME', 'TeleMedics');
define('APP_URL', 'http://localhost/TELEMEDICS');
define('APP_ENV', 'development');

// Security Settings
define('SECRET_KEY', 'telemedics_secure_key_2026');
define('SESSION_TIMEOUT', 3600);

// Email Configuration
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USER', 'your_email@gmail.com');
define('MAIL_PASS', 'your_password');

// Database Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set character set
$conn->set_charset("utf8mb4");

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
}
?>