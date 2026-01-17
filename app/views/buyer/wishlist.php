<!DOCTYPE html>
<html>
<head>
    <title>My Wishlist</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav>
        <h1>My Wishlist</h1>
        <a href="index.php?action=home">Continue Shopping</a>
    </nav>

    <div class="container">
        <?php if(count($wishlistItems) > 0): ?>
            <div class="game-grid">
                <?php foreach($wishlistItems as $item): ?>
                    <div class="game-card">
                        <img src="uploads/images/<?php echo $item['image_path']; ?>" class="game-img">
                        <div class="card-body">
                            <h3><?php echo $item['title']; ?></h3>
                            <p class="price">$<?php echo $item['price']; ?></p>
                            
                            <a href="index.php?action=checkout&id=<?php echo $item['game_id']; ?>" class="btn">Buy Now</a>
                            
                            <a href="index.php?action=remove_wishlist&id=<?php echo $item['game_id']; ?>" 
                               style="color: red; display:block; margin-top:10px; font-size:0.9em;">
                               Remove
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Your wishlist is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>