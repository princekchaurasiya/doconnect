<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Restrict access to admin users
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
