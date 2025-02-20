<?php
// Detect if running on localhost or live server
$is_local = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);

// Set log file path based on environment
if ($is_local) {
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/logs.txt'); // Local log file
} else {
    ini_set('log_errors', 1);
    ini_set('error_log', '/home/smbrckdy/doconnect.org/logs.txt'); // Live server log file
}

// Log a test entry
error_log("Test log entry: " . date("Y-m-d H:i:s") . " - Logging test from log_test.php");

// Output success message
echo "Log test completed!";
?>
