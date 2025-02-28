<?php
session_start(); // Start session at the top

include 'admin-middleware.php'; // Restrict access to admins only
include __DIR__ . '/db-connect.php'; // Database connection
include 'header.php'; // Include common header

$message = "";
$message_type = "";

// Retain values in case of errors
$title = "";
$content = "";
$category_id = "";

// Fetch categories
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
    $category_id = isset($_POST['category']) ? (int)$_POST['category'] : 0;

    // Validate category selection
    $check_category = $conn->query("SELECT id FROM categories WHERE id = $category_id");
    if ($check_category->num_rows == 0) {
        $message = "Error: Invalid category selected.";
        $message_type = "danger";
    } else {
        // Generate a clean slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));

        // Ensure unique slug
        $check_slug = $conn->query("SELECT id FROM blog_posts WHERE slug='$slug' LIMIT 1");
        if ($check_slug->num_rows > 0) {
            $slug .= '-' . time();
        }

        // Handle Image Upload
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $upload_dir = __DIR__ . "/uploads/";
        $image_path = "";

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
            } elseif ($image_size > 2 * 1024 * 1024) {
                $message = "Error: Image size must be less than 2MB.";
                $message_type = "danger";
            } else {
                $new_image_name = time() . '_' . uniqid() . '.' . $image_ext;
                $image_path = "uploads/" . $new_image_name;
                if (!move_uploaded_file($image_tmp, $upload_dir . $new_image_name)) {
                    $message = "Error: Failed to upload image.";
                    $message_type = "danger";
                    $image_path = "";
                }
            }
        }

        // Insert into database if no errors
        if (empty($message)) {
            $sql = "INSERT INTO blog_posts (title, content, category_id, slug, image) 
                    VALUES ('$title', '$content', '$category_id', '$slug', '$image_path')";
            if ($conn->query($sql)) {
                // Ensure `blogs/` folder exists
                $blog_dir = __DIR__ . "/blogs/";
                if (!is_dir($blog_dir)) {
                    mkdir($blog_dir, 0777, true);
                }

                // Generate the new blog post file
                $post_file_path = $blog_dir . "$slug.php";
                $post_content = <<<PHP
<?php
include __DIR__ . '/../db-connect.php';
include __DIR__ . '/../header.php';

\$slug = '$slug';

// Fetch the post
\$sql = "SELECT blog_posts.*, categories.name AS category_name 
        FROM blog_posts 
        LEFT JOIN categories ON blog_posts.category_id = categories.id 
        WHERE slug = ?";
\$stmt = \$conn->prepare(\$sql);
\$stmt->bind_param("s", \$slug);
\$stmt->execute();
\$result = \$stmt->get_result();
\$post = \$result->fetch_assoc();

if (!\$post) {
    echo "<div class='container mt-5'><h2>Post Not Found</h2></div>";
    include __DIR__ . '/../footer.php';
    exit;
}

// Post details
\$category = htmlspecialchars(\$post['category_name']);
\$image_url = !empty(\$post['image']) ? '../' . htmlspecialchars(\$post['image']) : "../assets/img/wa-logo.png";
?>
<section class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <h1><?= htmlspecialchars(\$post['title']) ?></h1>
            <p><strong>Category:</strong> <?= \$category ?></p>
            <img src="<?= \$image_url ?>" class="img-fluid" alt="<?= htmlspecialchars(\$post['title']) ?>">
            <div class="mt-3"><?= nl2br(html_entity_decode(\$post['content'])) ?></div>
            <a href="../index.php" class="btn btn-primary mt-3">Back to Home</a>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../footer.php'; ?>
PHP;

                file_put_contents($post_file_path, $post_content);

                $message = "Post added successfully!";
                $message_type = "success";

                // Clear form values
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

<div class="container mt-5">
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
            <textarea class="form-control" id="content" name="content" rows="5"><?= htmlspecialchars_decode($content) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Feature Image</label>
            <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
        </div>
        <button type="submit" class="btn btn-primary">Add Post</button>
    </form>
</div>

<?php include 'footer.php'; ?>
