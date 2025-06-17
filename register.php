<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$auth = new Auth($pdo);

// Redirect if already logged in
if ($auth->isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}

// Handle registration
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $recaptcha = $_POST['g-recaptcha-response'];

    if ($password !== $confirmPassword) {
        $message = "Passwords do not match";
    } else {
        $result = $auth->register($name, $email, $phone, $password, $recaptcha);
        $message = $result['message'];

        if ($result['status'] === 'success') {
            header("Location: login.php?registered=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container">
        <form class="auth-form" id="registerForm" method="POST">
            <h2>Create Account</h2>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo strpos($message, 'success') !== false ? 'success' : 'error'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password (min 8 characters)</label>
                <input type="password" id="password" name="password" minlength="8" required>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" minlength="8" required>
            </div>
            
            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"></div>
            
            <button type="submit" class="btn btn-primary">Register</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </main>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>