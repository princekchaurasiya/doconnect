<?php
session_start(); // Start session at the top

include 'admin-middleware.php'; // Restrict access to admins only
include __DIR__ . '/db-connect.php'; // Database connection
include 'header.php'; // Include common header

$message = ""; // Initialize message variable
$message_type = ""; // Message type (success or danger)

// Retain previous values if an error occurs
$title = "";
$content = "";
$category_id = "";

// Fetch categories from database
$categories = [];
$category_query = "SELECT * FROM categories ORDER BY name ASC";
$category_result = $conn->query($category_query);
if ($category_result->num_rows > 0) {
    while ($row = $category_result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $category_id = isset($_POST['category']) ? (int) $_POST['category'] : 0;

    // Validate category selection
    $check_category = $conn->query("SELECT id FROM categories WHERE id = $category_id");
    if ($check_category->num_rows == 0) {
        $message = "Error: Invalid category selected.";
        $message_type = "danger";
    } else {
        // Generate slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));

        // Ensure unique slug
        $check_slug = $conn->query("SELECT id FROM blog_posts WHERE slug='$slug' LIMIT 1");
        if ($check_slug->num_rows > 0) {
            $slug .= '-' . time(); // Append timestamp to make it unique
        }

        // Handle Image Upload
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $upload_dir = __DIR__ . "/uploads/"; // Full path for security
        $image_path = ""; // Default empty image path

        // Ensure uploads folder exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (!empty($_FILES['image']['name'])) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_size = $_FILES['image']['size'];
            $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            // Validate image extension
            if (!in_array($image_ext, $allowed_extensions)) {
                $message = "Error: Only JPG, JPEG, PNG, and WEBP formats are allowed.";
                $message_type = "danger";
            } elseif ($image_size > 2 * 1024 * 1024) { // Limit 2MB
                $message = "Error: Image size must be less than 2MB.";
                $message_type = "danger";
            } else {
                $new_image_name = time() . '_' . uniqid() . '.' . $image_ext;
                $image_path = "uploads/" . $new_image_name;
                if (!move_uploaded_file($image_tmp, $upload_dir . $new_image_name)) {
                    $message = "Error: Failed to upload image.";
                    $message_type = "danger";
                    $image_path = ""; // Reset image path if upload fails
                }
            }
        }

        // Insert into database only if no errors
        if (empty($message)) {
            $sql = "INSERT INTO blog_posts (title, content, category_id, slug, image) 
                    VALUES ('$title', '$content', '$category_id', '$slug', '$image_path')";
            if ($conn->query($sql)) {
                $message = "Post added successfully!";
                $message_type = "success";
                // Clear form values after successful insert
                $title = "";
                $content = "";
                $category_id = "";
            } else {
                $message = "Error: " . $conn->error;
                $message_type = "danger";
            }
        }
    }
}
?>

<div class="container mt-5 pt-5 mb-5 pb-5">
    <h2>Add a New Blog Post</h2>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-<?= $message_type ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($title) ?>" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-control" id="category" name="category" required>
                <option value="">-- Select a Category --</option>
                <?php foreach ($categories as $cat) : ?>
                    <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $category_id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
        <label for="content" class="form-label">Content</label>
<textarea class="form-control" id="content" name="content" rows="5" required>
    <?= htmlspecialchars_decode($content) ?>
</textarea>



          
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Feature Image (JPG, PNG, WEBP, max 2MB)</label>
            <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
        </div>
        <button type="submit" class="btn btn-primary">Add Post</button>
    </form>
</div>

<?php include 'footer.php'; // Include common footer ?>
