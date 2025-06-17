<?php
<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'secure_user');
define('DB_PASS', 'StrongPassword123!');
define('DB_NAME', 'cancer_support_db');

// Site configuration
define('SITE_URL', 'https://yourdomain.com');
define('SITE_NAME', 'Cancer Support Network');

// reCAPTCHA keys
define('RECAPTCHA_SITE_KEY', 'your_site_key');
define('RECAPTCHA_SECRET_KEY', 'your_secret_key');

// Start session
session_start();

// Establish database connection
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>