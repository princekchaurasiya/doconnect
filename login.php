<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); // ✅ Set correct timezone

// ✅ Include necessary files
include __DIR__ . '/db-connect.php';
include 'header.php'; // ✅ Ensure header is included

// ✅ Check if return_url is passed via GET parameter (e.g., login.php?return_url=/add-post.php)
if (isset($_GET['return_url']) && !empty($_GET['return_url'])) {
    $_SESSION['return_url'] = urldecode($_GET['return_url']);
}

// ✅ Log HTTP_REFERER and return_url for debugging
error_log("[" . date("Y-m-d H:i:s") . "] HTTP_REFERER: " . ($_SERVER['HTTP_REFERER'] ?? 'None') . "\n", 3, __DIR__ . '/logs.txt');
error_log("[" . date("Y-m-d H:i:s") . "] Session return_url Before Login: " . ($_SESSION['return_url'] ?? 'None') . "\n", 3, __DIR__ . '/logs.txt');

// ✅ Get return URL (default is index.php)
$returnUrl = $_SESSION['return_url'] ?? 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true); // ✅ Prevent session fixation
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $user['username'];

        // ✅ Log successful login
        error_log("[" . date("Y-m-d H:i:s") . "] Login Successful: $username Redirecting to $returnUrl\n", 3, __DIR__ . '/logs.txt');

        // ✅ Redirect to the stored return URL
        header("Location: " . $returnUrl);
        unset($_SESSION['return_url']); // ✅ Remove return_url after use
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<div class="container m-5 p-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Admin Login</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; // ✅ Include footer ?>
