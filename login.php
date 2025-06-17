<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$auth = new Auth($pdo);

// Redirect if already logged in
if ($auth->isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}

// Handle login
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if ($auth->login($email, $password)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container">
        <form class="auth-form" id="loginForm" method="POST">
            <h2>Member Login</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <small><a href="forgot-password.php">Forgot password?</a></small>
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </main>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>