<?php
session_start(); // Start the session
   include __DIR__ . '/db-connect.php'; // Include DB connection
   include 'header.php'; // Include common header file
   
   // Log session data for debugging (writes to logs.txt)
error_log("Session Data: " . print_r($_SESSION, true), 3, __DIR__ . '/logs.txt');

   // Enable error logging for debugging
   ini_set('log_errors', 1);
   ini_set('error_log', __DIR__ . '/logs/error_log.txt');
   
   // Pagination settings
   $posts_per_page = 6; // Adjust number of posts per page
   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
   $offset = ($page - 1) * $posts_per_page;
   
   // Fetch total number of posts
   $total_posts_result = $conn->query("SELECT COUNT(*) AS total FROM blog_posts");
   $total_posts = $total_posts_result->fetch_assoc()['total'];
   $total_pages = ceil($total_posts / $posts_per_page);
   
   // Fetch blog posts for the current page
   $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT $posts_per_page OFFSET $offset";
   $result = $conn->query($sql);
   ?>
<div class="container mt-5 pt-5">
   <h2 class="text-center mb-4">📖 Our Blog</h2>
   <div class="row mt-5 pt-5">
      <?php while ($row = $result->fetch_assoc()) : 
         $image_path = htmlspecialchars($row['image']);
         
         // Validate image path
         if (!empty($image_path) && file_exists(__DIR__ . '/' . $image_path)) {
             $image_url = $image_path;
         } else {
             // Log error if image is missing
             error_log("Image not found: " . $image_path);
             $image_url = "assets/img/wa-logo.png"; // Fallback image
         }
         ?>
      <div class="col-md-4">
         <div class="post-card mt-5">
            <div class="post-card-image">
               <a href="blog-post.php?slug=<?= htmlspecialchars($row['slug']) ?>">
               <img src="<?= $image_url ?>" alt="<?= htmlspecialchars($row['title']) ?>" title="<?= htmlspecialchars($row['title']) ?>">
               </a>
            </div>
            <div class="post-card-content">
               <h3>
                  <a class="blog-title" href="blog-post.php?slug=<?= htmlspecialchars($row['slug']) ?>">
                  <?= htmlspecialchars($row['title']) ?>
                  </a>
               </h3>
               <p><?= substr(strip_tags($row['content']), 0, 100) ?>...</p>
               <div class="post-card-info">
                  <ul class="list-inline">
                     <li><a href="#">Admin</a></li>
                     <li style="padding-left:6px;padding-right:6px;">|</li>
                     <li><?= date("d F Y", strtotime($row['created_at'])) ?></li>
                  </ul>
               </div>
               <!-- Add Edit Button Here -->
               <?php 

if (!empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) : ?>
    <a href="edit-post.php?id=<?= htmlspecialchars($row['id']); ?>" class="btn btn-primary mt-2">Edit</a>
<?php endif; ?>


            </div>
         </div>
      </div>
      <?php endwhile; ?>
   </div>
   <!-- Pagination -->
   <nav>
      <ul class="pagination justify-content-center">
         <?php if ($page > 1) : ?>
         <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
         <?php endif; ?>
         <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
         <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
         </li>
         <?php endfor; ?>
         <?php if ($page < $total_pages) : ?>
         <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
         <?php endif; ?>
      </ul>
   </nav>
</div>
<?php include 'footer.php'; // Include common footer file ?>