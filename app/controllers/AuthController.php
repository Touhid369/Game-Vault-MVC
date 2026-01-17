<?php
include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../models/User.php';

class AuthController {
    
    // Show Register Form
    public function register() {
        include '../app/views/auth/register.php';
        
    }

    // Show Login Form
    public function login() {
        include '../app/views/auth/login.php';
    }

    // Handle Register Logic
    public function registerSubmit() {
        //session_start();
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);

        // 1. Captcha Check (Simple Math for MVP)
        if ($_POST['captcha_answer'] != $_SESSION['captcha_result']) {
            die("Error: Incorrect Captcha.");
        }

        // 2. Validate Password (8 chars, 1 Upper, 1 Number, 1 Special)
        $password = $_POST['password'];
        $confirm_pass = $_POST['confirm_password'];
        
        if ($password !== $confirm_pass) {
            die("Error: Passwords do not match.");
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            die("Error: Password must be 8+ chars, contain 1 Uppercase, 1 Number, 1 Special char.");
        }

        // 3. Validate Contact (11 Digits)
        if (!preg_match('/^[0-9]{11}$/', $_POST['contact_number'])) {
            die("Error: Contact number must be exactly 11 digits.");
        }

        // 4. Set Data
        $user->full_name = $_POST['full_name'];
        $user->username = $_POST['username'];
        $user->email = $_POST['email'];
        $user->contact_number = $_POST['contact_number'];
        $user->address = $_POST['address'];
        $user->role = $_POST['role'];
        
        // 5. Hash Password
        $user->password = password_hash($password, PASSWORD_BCRYPT);

        // 6. Save to DB
        if($user->emailExists()) {
            echo "Error: Email already exists.";
        } elseif($user->register()) {
            header("Location: index.php?action=login&status=success");
        } else {
            echo "Error: Could not register user.";
        }
    }

    // Handle Login Logic
    public function loginSubmit() {
        session_start();
        
        // Rate Limiting (Prevent Brute Force)
        if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] > 3) {
            if (time() - $_SESSION['last_attempt_time'] < 60) {
                die("Too many failed attempts. Please wait 1 minute.");
            } else {
                $_SESSION['login_attempts'] = 0; // Reset after 1 min
            }
        }

        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);

        $user->email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->emailExists() && password_verify($password, $user->password)) {
            // Success
            $_SESSION['user_id'] = $user->id;
            $_SESSION['full_name'] = $user->full_name;
            $_SESSION['role'] = $user->role;
            $_SESSION['login_attempts'] = 0;
            
            // Redirect based on Role
            if($user->role == 'admin') header("Location: index.php?action=admin_dashboard");
            elseif($user->role == 'seller') header("Location: index.php?action=seller_dashboard");
            else header("Location: index.php?action=home"); // Buyer
        } else {
            // Failure
            if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;
            $_SESSION['login_attempts']++;
            $_SESSION['last_attempt_time'] = time();
            echo "Invalid Email or Password.";
        }
    }

    public function logout() {
        // 1. Unset all session variables
        $_SESSION = array();
    
        // 2. Destroy the session cookie (Important!)
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    
        // 3. Destroy the session
        session_destroy();
    
        // 4. Redirect to login
        header("Location: index.php?action=login");
        exit;
    }
}
?>