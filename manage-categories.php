<?php
session_start();
include 'admin-middleware.php'; // Ensure only admins can access
include __DIR__ . '/db-connect.php';
include 'header.php';

$message = "";

// Handle category addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_category'])) {
    $category_name = $conn->real_escape_string($_POST['new_category']);

    if (!empty($category_name)) {
        $sql = "INSERT INTO categories (name) VALUES ('$category_name')";
        if ($conn->query($sql)) {
            $message = "Category added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

// Fetch categories
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>

<div class="container mt-5">
    <h2>Manage Categories</h2>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="new_category" class="form-label">New Category</label>
            <input type="text" class="form-control" id="new_category" name="new_category" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>

    <h3 class="mt-4">Existing Categories</h3>
    <ul>
        <?php while ($cat = $categories->fetch_assoc()) : ?>
            <li><?= htmlspecialchars($cat['name']) ?></li>
        <?php endwhile; ?>
    </ul>
</div>

<?php include 'footer.php'; ?>
