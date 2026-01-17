<!DOCTYPE html>
<html>
<head>
    <title>Game Details</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .review-box { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .stars { color: #f1c40f; font-weight: bold; }
    </style>
</head>
<body>
    <nav>
        <h1>GameStore</h1>
        <a href="index.php?action=home">Back to Home</a>
    </nav>

    <div class="container">
        <div style="background: white; padding: 20px; border-radius: 8px; display: flex; gap: 20px;">
            <img src="uploads/images/<?php echo $game['image_path']; ?>" style="width: 300px; height: 200px; object-fit: cover;">
            
            <div>
                <h2><?php echo $game['title']; ?></h2>
                <h3 style="color: #27ae60;">$<?php echo $game['price']; ?></h3>
                <p><?php echo nl2br($game['description']); ?></p>

                <?php if($hasBought): ?>
                    <a href="index.php?action=my_library" class="btn">Go to Library (Owned)</a>
                <?php else: ?>
                    <a href="index.php?action=checkout&id=<?php echo $game['id']; ?>" class="btn">Buy Now</a>
                    <?php if($game['demo_file_path']): ?>
                        <a href="uploads/demos/<?php echo $game['demo_file_path']; ?>" class="btn" style="background:#7f8c8d;">Download Demo</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <br><hr><br>

        <h3>Customer Reviews</h3>
        
        <?php if($hasBought): ?>
            <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <h4>Write a Review</h4>
                <form action="index.php?action=submit_review" method="POST">
                    <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                    
                    <label>Rating:</label>
                    <select name="rating" required>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Good</option>
                        <option value="3">3 - Average</option>
                        <option value="2">2 - Poor</option>
                        <option value="1">1 - Terrible</option>
                    </select>
                    
                    <textarea name="comment" placeholder="Write your experience..." required style="width:100%; height:60px;"></textarea>
                    <button type="submit" style="margin-top:10px;">Post Review</button>
                </form>
            </div>
        <?php elseif(isset($_SESSION['user_id'])): ?>
            <p><i>You must buy this game to write a review.</i></p>
        <?php endif; ?>

        <?php if(count($reviews) > 0): ?>
            <?php foreach($reviews as $r): ?>
                <div class="review-box">
                    <p>
                        <strong class="stars"><?php echo str_repeat("★", $r['rating']); ?></strong> 
                        by <b><?php echo $r['username']; ?></b>
                        <small style="color:#777;">(<?php echo $r['created_at']; ?>)</small>
                    </p>
                    <p><?php echo $r['comment']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first!</p>
        <?php endif; ?>
    </div>
</body>
</html>