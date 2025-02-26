<?php
include 'db-connect.php';

$query = "SELECT slug FROM locations";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slug = $row['slug'];
        $content = '<?php include "location.php"; ?>';
        file_put_contents("$slug.php", $content);
    }
}

echo "Location pages generated successfully!";
?>
