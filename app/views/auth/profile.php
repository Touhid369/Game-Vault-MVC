<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>
    <nav>
        <h1>My Profile</h1>
        <a href="index.php?action=home">Home</a>
    </nav>

    <div class="container">
        <!-- Success Message (shown when msg=updated in URL) -->
        <div class="success-message" style="display: none;" id="successMsg">
            Profile updated successfully!
        </div>

        <form action="index.php?action=update_profile" method="POST">
            <h2>Edit Profile</h2>
            
            <label>Full Name:</label>
            <input type="text" name="full_name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <hr>
            
            <label>New Password (Optional):</label>
            <input type="password" name="password" placeholder="Leave blank to keep current password">

            <button type="submit">Save Changes</button>
        </form>

        <div class="info-section">
            <p>Role: <strong><?php echo ucfirst($user['role']); ?></strong></p>
            <p>Member since: <strong><?php echo $user['created_at']; ?></strong></p>
        </div>
    </div>

    <script>
        // Show success message if URL contains msg=updated
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('msg') === 'updated') {
            document.getElementById('successMsg').style.display = 'block';
        }
    </script>
</body>
</html>