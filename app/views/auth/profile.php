<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav>
        <h1>My Profile</h1>
        <a href="index.php?action=home">Home</a>
    </nav>

    <div class="container">
        
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
            <p style="color: green; text-align: center;">Profile updated successfully!</p>
        <?php endif; ?>

        <form action="index.php?action=update_profile" method="POST">
            <h2>Edit Profile</h2>
            
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

            <hr>
            <label>New Password (Optional):</label>
            <input type="password" name="password" placeholder="Leave blank to keep current password">

            <button type="submit">Save Changes</button>
        </form>

        <br>
        <div style="text-align: center;">
            <p>Role: <strong><?php echo ucfirst($user['role']); ?></strong></p>
            <p>Member since: <?php echo $user['created_at']; ?></p>
        </div>

    </div>
</body>
</html>