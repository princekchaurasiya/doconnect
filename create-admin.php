<?php
require_once __DIR__ . '/db-connect.php'; // Prevent duplicate inclusion
require_once __DIR__ . '/log_errors.php'; // Prevent duplicate function declarations
include 'header.php'; // Include common header file

$logFile = 'logs.txt';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Check if username already exists
    $checkUser = $conn->query("SELECT id FROM admin_users WHERE username='$username'");
    if ($checkUser->num_rows > 0) {
        $message = "<div class='alert alert-danger'>❌ Username already exists!</div>";
    } else {
        // Insert admin user
        $sql = "INSERT INTO admin_users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql)) {
            $message = "<div class='alert alert-success'>✅ Admin user created successfully!</div>";
        } else {
            $errorMsg = "Database Insert Error: " . $conn->error;
            file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] " . $errorMsg . "\n", FILE_APPEND);
            $message = "<div class='alert alert-danger'>❌ Error creating admin user. Check logs.</div>";
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center">Create Admin User</h2>
    <div class="col-md-6 mx-auto">
        <?= $message; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Create Admin</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
