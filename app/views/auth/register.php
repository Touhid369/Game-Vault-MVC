<?php
// Generate Math Captcha
if(!isset($_SESSION)) session_start();
$num1 = rand(1, 10);
$num2 = rand(1, 10);
$_SESSION['captcha_result'] = $num1 + $num2;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - GameStore</title>
    <link rel="stylesheet" href="assets/css/reg-log.css">
</head>
<body>

    <a href="index.php" class="shoplink">Back to Store</a>

    <div class="registerdiv">
        <h2>Create an Account</h2>
        <form action="index.php?action=registerSubmit" method="POST">
            
            <input type="text" name="full_name" placeholder="Full Name" required pattern="[A-Za-z\s]+" title="Letters only">

            <input type="text" name="username" placeholder="Username" required>

            <input type="email" name="email" placeholder="Email Address" required>

            <input type="password" name="password" placeholder="Password" required>
            <small style="color: #d3d3d3; font-size: 12px; margin-top: -15px;">(Min 8 chars, 1 Upper, 1 Number, 1 Special)</small>

            <input type="password" name="confirm_password" placeholder="Confirm Password" required>

            <input type="text" name="contact_number" placeholder="Contact Number (11 digits)" required pattern="[0-9]{11}">

            <textarea name="address" placeholder="Residential Address" required></textarea>

            <select name="role">
                <option value="" disabled selected>Select Your Role</option>
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
            </select>

            <div class="captcha-box">
                <label style="color: #d3d3d3;">Captcha: What is <?php echo $num1 . " + " . $num2; ?>?</label>
                <input type="number" name="captcha_answer" placeholder="Your Answer" required>
            </div>

            <label class="checkbox-label" style="color: #d3d3d3;">
                <input type="checkbox" required> I agree to Terms & Conditions
            </label>

            <button type="submit" class="btn">Register</button>
        </form>
        <p style="color: #d3d3d3;">Already have an account? <a href="index.php?action=login" style="color: #28a745;">Login here</a></p>
    </div>

</body>
</html>