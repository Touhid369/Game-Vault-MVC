<!DOCTYPE html>
<html>
<head>
    <title>GameStore - Home</title>
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body>
    
    <nav>
        <h1><a href="index.php?action=home">GameStore</a></h1>
        <div>
            <?php if(isset($_SESSION['user_id'])): ?>
                <span>Welcome, <?php echo $_SESSION['full_name']; ?> (<?php echo ucfirst($_SESSION['role']); ?>)</span>
                <a href="index.php?action=profile" style="font-size: 0.9em; text-decoration: underline;">(Edit Profile)</a>
                <?php if($_SESSION['role'] == 'seller'): ?>
                    <a href="index.php?action=seller_dashboard">Dashboard</a>
                    <a href="index.php?action=upload">Upload Game</a>
                <?php elseif($_SESSION['role'] == 'admin'): ?>
                    <a href="index.php?action=admin_dashboard">Admin Panel</a>
                <?php else: ?>
                    <a href="index.php?action=my_library">My Library</a>
                <?php endif; ?>

                <a href="index.php?action=logout" style="color: #e74c3c;">Logout</a>
            <?php else: ?>
                <a href="index.php?action=login">Login</a>
                <a href="index.php?action=register">Register</a>
            <?php endif; ?>
        </div>
    </nav>  
    <div class="container">
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <h2><?php echo isset($search_title) ? $search_title : 'Latest Games'; ?></h2>
        
        <form action="index.php" method="GET" style="margin: 0; box-shadow: none; padding: 0; background: none;">
            <input type="hidden" name="action" value="search">
            <input type="text" name="q" placeholder="Search games..." required style="padding: 8px; width: 200px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit" style="padding: 8px 15px;">Search</button>
            <?php if(isset($_GET['q'])): ?>
                <a href="index.php?action=home" style="margin-left: 10px; color: red; text-decoration: none;">Clear</a>
            <?php endif; ?>
        </form>
    </div>
        <div class="game-grid">
            <?php if(isset($games) && count($games) > 0): ?>
                <?php foreach($games as $game): ?>
                    <div class="game-card">
                        <?php if(!empty($game['image_path'])): ?>
                            <img style="border-radius: 10px;" width="300px" src="uploads/images/<?php echo $game['image_path']; ?>" class="game-img" alt="<?php echo $game['title']; ?>">
                        <?php else: ?>
                            <div style="height:180px; background:#ddd; display:flex; align-items:center; justify-content:center; color:#555;">
                                No Image
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                           <h3><a href="index.php?action=details&id=<?php echo $game['id']; ?>"><?php echo $game['title']; ?></a></h3>
                           <p class="price">$<?php echo number_format($game['price'], 2); ?></p>
                            
                           <div style="margin-top: 10px;">
                              <?php if(!empty($game['demo_file_path'])): ?>
                                 <a href="uploads/demos/<?php echo $game['demo_file_path']; ?>" class="btn" style="background:#95a5a6; font-size:12px; padding: 5px 10px;" download>
                                       Download Demo
                                 </a>
                              <?php endif; ?>
                              
                              <br><br>

                              <?php if(isset($_SESSION['user_id'])): ?>
                                 <?php if($_SESSION['role'] == 'buyer'): ?>
                                       <a href="index.php?action=checkout&id=<?php echo $game['id']; ?>">
                                          <button>Buy Now</button>
                                       </a>
                                       <a href="index.php?action=add_wishlist&id=<?php echo $game['id']; ?>" style="margin-left:5px; color:#e74c3c; font-size:20px; text-decoration:none;" title="Add to Wishlist">
                                       ❤
                                       </a>
                                 <?php endif; ?>
                              <?php else: ?>
                                 <a href="index.php?action=login">
                                       <button>Login to Buy</button>
                                 </a>
                              <?php endif; ?>
                           </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No games available yet. Check back later!</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>