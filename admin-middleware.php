<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Get the current URL and encode it
    $returnUrl = urlencode($_SERVER['REQUEST_URI']);
    
    // Redirect to login page with return URL parameter
    header("Location: login.php?return_url=$returnUrl");
    exit;
}
?>
