<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h2>Login</h2>
    
    <?php 
    if(isset($_GET['status']) && $_GET['status'] == 'success') {
        echo "<p style='color:green'>Registration successful! Please login.</p>";
    }
    ?>

    <form action="index.php?action=loginSubmit" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="index.php?action=register">Register here</a></p>
    <p>Go back <a href="index.php?action=home">Home</a></p>
</body>
</html>