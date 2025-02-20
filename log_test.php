<?php
// Check if the script is running on localhost
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Localhost settings
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/logs.txt'); // Save log in the project directory
} else {
    // Live server settings
    ini_set('log_errors', 1);
    ini_set('error_log', '/home/smbrckdy/doconnect.org/logs.txt'); // Use full server path
}

// Test log entry
error_log("Test log entry: " . date("Y-m-d H:i:s") . " - Logging test from log_test.php");

// Output to confirm execution
echo "Log test completed!";
?>
