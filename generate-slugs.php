<?php
include __DIR__ . '/db-connect.php'; // Include database connection

$logFile = __DIR__ . '/logs.txt'; // Log file path

function logMessage($message) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

$result = $conn->query("SELECT id, title FROM blog_posts");

if (!$result) {
    logMessage("Error fetching blog posts: " . $conn->error);
    exit;
}

while ($row = $result->fetch_assoc()) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['title']), '-'));

    // Ensure slug is unique by appending ID if needed
    $check_slug = $conn->query("SELECT id FROM blog_posts WHERE slug='$slug' LIMIT 1");
    if (!$check_slug) {
        logMessage("Error checking slug: " . $conn->error);
        continue;
    }

    if ($check_slug->num_rows > 0) {
        $slug .= '-' . $row['id'];
    }

    $update = $conn->query("UPDATE blog_posts SET slug='$slug' WHERE id=" . $row['id']);
    if (!$update) {
        logMessage("Error updating slug for ID {$row['id']}: " . $conn->error);
    } else {
        logMessage("Slug updated for ID {$row['id']}: $slug");
    }
}

logMessage("Slug generation completed successfully!");
?>
