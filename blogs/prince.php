<?php
include __DIR__ . '/../db-connect.php';
include __DIR__ . '/../header.php';

$slug = 'prince';

// Fetch the post
$sql = "SELECT blog_posts.*, categories.name AS category_name 
        FROM blog_posts 
        LEFT JOIN categories ON blog_posts.category_id = categories.id 
        WHERE slug = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "<div class='container mt-5'><h2>Post Not Found</h2></div>";
    include __DIR__ . '/../footer.php';
    exit;
}

// Post details
$category = htmlspecialchars($post['category_name']);
$image_url = !empty($post['image']) ? '../' . htmlspecialchars($post['image']) : "../assets/img/wa-logo.png";
?>
<section class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <h1><?= htmlspecialchars($post['title']) ?></h1>
            <p><strong>Category:</strong> <?= $category ?></p>
            <img src="<?= $image_url ?>" class="img-fluid" alt="<?= htmlspecialchars($post['title']) ?>">
            <div class="mt-3"><?= nl2br(html_entity_decode($post['content'])) ?></div>
            <a href="../index.php" class="btn btn-primary mt-3">Back to Home</a>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../footer.php'; ?>