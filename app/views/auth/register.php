<?php
// Generate Math Captcha
if(!isset($_SESSION)) session_start();
$num1 = rand(1, 10);
$num2 = rand(1, 10);
$_SESSION['captcha_result'] = $num1 + $num2;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - GameStore</title>
</head>
<body>
    <h2>Create an Account</h2>
    <form action="index.php?action=registerSubmit" method="POST">
        
        <label>Full Name:</label>
        <input type="text" name="full_name" required pattern="[A-Za-z\s]+" title="Letters only">
        <br>

        <label>Username:</label>
        <input type="text" name="username" required>
        <br>

        <label>Email:</label>
        <input type="email" name="email" required>
        <br>

        <label>Password:</label>
        <input type="password" name="password" required>
        <small>(Min 8 chars, 1 Upper, 1 Number, 1 Special)</small>
        <br>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <br>

        <label>Contact Number (11 digits):</label>
        <input type="text" name="contact_number" required pattern="[0-9]{11}">
        <br>

        <label>Address:</label>
        <textarea name="address" required></textarea>
        <br>

        <label>I am a:</label>
        <select name="role">
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
        </select>
        <br><br>

        <label>Captcha: What is <?php echo $num1 . " + " . $num2; ?>?</label>
        <input type="number" name="captcha_answer" required>
        <br><br>

        <label>
            <input type="checkbox" required> I agree to Terms & Conditions
        </label>
        <br><br>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="index.php?action=login">Login here</a></p>
</body>
</html>