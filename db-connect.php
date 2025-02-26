<?php
// Detect environment
$is_local = ($_SERVER['SERVER_NAME'] === 'localhost');
date_default_timezone_set('Asia/Kolkata'); // ✅ Set correct timezone

if ($is_local) {
    // Enable error reporting for local development
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    // Disable public error display in production
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Always log errors (both local & production)
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs.txt'); // Log errors to logs.txt

// Database credentials
if ($is_local) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "doconnect";
} else {
    $servername = "localhost";  // Change if your production DB is on another server
    $username = "smbrckdy_doconnect";
    $password = "Prince@6590";
    $database = "smbrckdy_doconnect";
}

// Establish database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection and log errors if any
if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    die("Database connection failed."); // Don't expose error details
}

// Log successful connection (for debugging)
if ($is_local) {
    error_log("Database Connected Successfully: " . date("Y-m-d H:i:s"));
}
?>
