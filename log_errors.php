<?php
// Define log file path
$log_file = __DIR__ . '/error_log.txt';

// Ensure function is not redefined
if (!function_exists('logError')) {
    function logError($message) {
        global $log_file;
        $date = date('Y-m-d H:i:s');
        file_put_contents($log_file, "[$date] $message\n", FILE_APPEND);
    }
}

// Check if internet connection is available
$connected = @fsockopen("www.google.com", 80);
if (!$connected) {
    logError("No internet connection detected.");
}
?>
