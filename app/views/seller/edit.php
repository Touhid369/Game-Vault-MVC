<!DOCTYPE html>
<html>
<head>
    <title>Edit Game</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav>
        <h1>Edit Game</h1>
        <a href="index.php?action=seller_dashboard">Cancel</a>
    </nav>

    <div class="container">
        <form action="index.php?action=update_game" method="POST">
            <input type="hidden" name="id" value="<?php echo $game['id']; ?>">

            <label>Game Title:</label>
            <input type="text" name="title" value="<?php echo $game['title']; ?>" required>

            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" value="<?php echo $game['price']; ?>" required>

            <label>Description:</label>
            <textarea name="description" required style="height: 100px;"><?php echo $game['description']; ?></textarea>

            <p style="color: #666; font-size: 0.9em;">* To update files (Images/Zips), please delete and re-upload the game.</p>

            <button type="submit" style="background: #f39c12;">Update Game</button>
        </form>
    </div>
</body>
</html>