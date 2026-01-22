<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GameStore</title>
    <link rel="stylesheet" href="assets/css/reg-log.css">
</head>
<body>

    <a href="index.php?action=home" class="shoplink">Home</a>

    <div class="registerdiv">
        <h2>Login</h2>
        
        <?php 
        if(isset($_GET['status']) && $_GET['status'] == 'success') {
            echo "<p style='color:#28a745; text-align:center; font-weight:bold; margin-bottom:15px;'>Registration successful! Please login.</p>";
        }
        ?>

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

        <form action="index.php?action=loginSubmit" method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" class="btn">Login</button>
        </form>

        <p style="color: #d3d3d3; margin-top: 10px;">Don't have an account? <a href="index.php?action=register" style="color: #28a745;">Register here</a></p>
    </div>

</body>
</html>