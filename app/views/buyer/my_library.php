<!DOCTYPE html>
<html>
<head>
    <title>My Library</title>
</head>
<body>
    <h2>My Game Library</h2>
    <a href="index.php?action=home">Back to Store</a>

    <?php if(count($myGames) > 0): ?>
        <ul>
            <?php foreach($myGames as $game): ?>
                <li>
                    <h3><?php echo $game['title']; ?></h3>
                    <p>Purchased on: <?php echo $game['transaction_date']; ?></p>
                    
                    <a href="index.php?action=download&file=<?php echo $game['full_file_path']; ?>">
                        Download Full Version
                    </a>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You haven't bought any games yet.</p>
    <?php endif; ?>
</body>
</html>