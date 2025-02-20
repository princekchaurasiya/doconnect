<?php
// Enable error logging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs.txt'); // Log PHP errors to logs.txt

// Include log functions
require_once __DIR__ . '/log_errors.php'; // Use require_once to prevent redeclaration

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "doconnect";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection and log errors if any
if ($conn->connect_error) {
    logError("Database Connection Failed: " . $conn->connect_error);
    die("Database connection failed.");
}
?>
