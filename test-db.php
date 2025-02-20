<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/db-connect.php';


$sql = "SELECT * FROM blog_posts";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>" . $row['content'] . "</p><hr>";
}
?>
