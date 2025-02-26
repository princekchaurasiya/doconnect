<?php
session_start();
include 'admin-middleware.php'; // Restrict access
include 'db-connect.php';

// Check if post ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid post ID.");
}

$post_id = intval($_GET['id']); // Sanitize input

// Fetch existing post data
$query = "SELECT * FROM blog_posts WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("Post not found.");
}

// If form is submitted, update post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $_POST['content']; // Store raw TinyMCE HTML safely

    // Handle image update
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_path = $target_file;

        $update_query = "UPDATE blog_posts SET title=?, content=?, image=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssi", $title, $content, $image_path, $post_id);
    } else {
        $update_query = "UPDATE blog_posts SET title=?, content=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $title, $content, $post_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Post updated successfully!'); window.location='blog.php';</script>";
    } else {
        echo "Error updating post.";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container m-5 p-5">
    <h2>Edit Blog Post</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" id="content" class="form-control" required><?php echo htmlspecialchars_decode(stripslashes($post['content'])); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Featured Image</label>
            <input type="file" name="image" class="form-control">
            <?php if (!empty($post['image'])): ?>
                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Current Image" class="img-thumbnail mt-2" width="200">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-success">Update Post</button>
        <a href="blog.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>

<script>
    tinymce.init({
        selector: '#content',
        plugins: 'lists link image code',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist | link image | code',
        menubar: false
    });
</script>
