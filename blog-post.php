<?php
include __DIR__ . '/db-connect.php'; // Include DB connection
include 'header.php'; // Include common header

// Enable error logging for debugging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs.txt');

// Get blog post slug from URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (!$slug) {
    error_log("Slug is missing in URL");
    echo "<div class='container mt-5'><h2>Post Not Found</h2></div>";
    include 'footer.php';
    exit;
}

// Fetch the post from the database with category
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
    error_log("No post found for slug: " . $slug);
    echo "<div class='container mt-5'><h2>Post Not Found</h2></div>";
    include 'footer.php';
    exit;
}

// Get category from post
$category = isset($post['category_name']) ? htmlspecialchars($post['category_name']) : 'Uncategorized';

// Validate post image
$image_path = htmlspecialchars($post['image']);
$full_image_path = __DIR__ . '/' . $image_path; // Full system path for checking

if (!empty($image_path) && file_exists($full_image_path)) {
    $image_url = $image_path; // Use stored image path directly
} else {
    error_log("Image missing for post: " . $slug . " | Image Path: " . $full_image_path);
    $image_url = "assets/img/wa-logo.png"; // Fallback image
}

// Fetch latest posts for the sidebar
$latest_posts_query = "SELECT title, slug, image, created_at FROM blog_posts ORDER BY created_at DESC LIMIT 3";
$latest_posts = $conn->query($latest_posts_query);
?>

<section class="portfolio_section med_toppadder50 med_bottompadder70">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="post-single ">
                    <div class="post-single-image">
                        <img src="<?= $image_url ?>" class="img-responsive" alt="<?= htmlspecialchars($post['title']) ?>">
                    </div>
                    <div class="post-single-content text-left mt-5 mb-5">
                        <a class="categorie mb-5"><?= $category ?></a>
                        <h1><?= htmlspecialchars($post['title']) ?></h1>
                        <div class="post-single-info">
                            <ul class="list-inline">
                                <!-- <li><img src="images/author.png" alt="Author"></li> -->
                                <li>Admin</li>
                                <li class="dot"></li>
                                <li><?= date("F j, Y", strtotime($post['created_at'])) ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="post-single-body text-left">
    <?= nl2br(html_entity_decode($post['content'])) ?>
</div>


                </div>
                <div class="text-left mt-4 mb-4">
                    <button onclick="window.history.back()" class="btn btn-primary b-btn">Back</button>
                </div>
            </div>

            <div class="col-lg-4 max-width ">
                <div class="widget text-left latest-post">
                    <div class="section-title">
                        <h5>Latest Posts</h5>
                        <!-- <img src="images/line.png" alt="img" class="img-responsive"> -->
                    </div>





                    <ul class="widget-latest-posts">
    <?php while ($latest = $latest_posts->fetch_assoc()) : 
        $latest_image_path = htmlspecialchars($latest['image']);
        $latest_full_image_path = __DIR__ . '/' . $latest_image_path; 

        if (!empty($latest_image_path) && file_exists($latest_full_image_path)) {
            $latest_image_url = $latest_image_path; // Use directly
        } else {
            error_log("Missing latest post image: " . $latest_full_image_path);
            $latest_image_url = "assets/img/wa-logo.png";
        }
    ?>
        <li class="last-post">
            <div class="image">
                <a href="blog-post.php?slug=<?= htmlspecialchars($latest['slug']) ?>">
                    <img src="<?= $latest_image_url ?>" alt="<?= htmlspecialchars($latest['title']) ?>">
                </a>
            </div>
            <div class="content">
                <p>
                    <a href="blog-post.php?slug=<?= htmlspecialchars($latest['slug']) ?>"  class="blog-title"><?= htmlspecialchars($latest['title']) ?></a>
                </p>
                <small><?= date("F j, Y", strtotime($latest['created_at'])) ?></small>
               
            </div>
        </li>
        
    <?php endwhile; ?>
</ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
