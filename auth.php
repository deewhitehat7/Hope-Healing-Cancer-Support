<?php
<?php
require_once 'config.php';
require_once 'functions.php';

class Auth {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Register new user
    public function register($name, $email, $phone, $password, $recaptcha) {
        // Verify reCAPTCHA
        if(!verifyRecaptcha($recaptcha)) {
            return ['status' => 'error', 'message' => 'reCAPTCHA verification failed'];
        }
        
        // Validate inputs
        if(empty($name) || empty($email) || empty($phone) || empty($password)) {
            return ['status' => 'error', 'message' => 'All fields are required'];
        }
        
        // Check if email exists
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->rowCount() > 0) {
            return ['status' => 'error', 'message' => 'Email already registered'];
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert user
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        if($stmt->execute([$name, $email, $phone, $hashedPassword])) {
            return ['status' => 'success', 'message' => 'Registration successful'];
        }
        
        return ['status' => 'error', 'message' => 'Registration failed'];
    }
    
    // Login user
    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        }
        
        return false;
    }
    
    // Check if user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Logout user
    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit;
    }
}
?>