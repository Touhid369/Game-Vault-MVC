<!DOCTYPE html>
<html>
<head>
    <title>Login - GameStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <nav>
        <h1>GameStore</h1>
        <a href="index.php?action=register">Register</a>
    </nav>

    <div class="container">
        <div style="max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            
            <h2 style="text-align: center;">Login</h2>

            <?php if (isset($_GET['error'])): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #f5c6cb; text-align: center;">
                    
                    <?php if ($_GET['error'] == 'invalid'): ?>
                        <strong>Error:</strong> Invalid email or password.
                    
                    <?php elseif ($_GET['error'] == 'banned'): ?>
                        <strong>🚫 Access Denied:</strong><br>
                        Your account has been suspended by the Admin.
                    
                    <?php else: ?>
                        Something went wrong. Please try again.
                    <?php endif; ?>
                    
                </div>
            <?php endif; ?>
            
            <form action="index.php?action=login" method="POST">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">

                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">

                <button type="submit" style="width: 100%; padding: 10px; background: #3498db; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;">
                    Login
                </button>
            </form>

            <p style="text-align: center; margin-top: 20px;">
                Don't have an account? <a href="index.php?action=register">Register here</a>
            </p>

        </div>
    </div>

</body>
</html>