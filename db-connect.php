<?php
// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs.txt'); // Log PHP errors to logs.txt

// Detect environment
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Localhost database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "doconnect";
} else {
    // Production database credentials
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
    die("Database connection failed.");
}

// If connected successfully, log it
error_log("Database Connected Successfully: " . date("Y-m-d H:i:s"));

?>
