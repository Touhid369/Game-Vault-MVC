<!DOCTYPE html>
<html>
<head>
    <title>My Library - GameStore</title>
    <link rel="stylesheet" href="assets/css/my_library.css">
</head>
<body>
    
    <nav>
        <h1><a href="index.php?action=home">GameStore</a></h1>
        <div>
            <?php if(isset($_SESSION['user_id'])): ?>
                <span>Welcome, <?php echo $_SESSION['full_name']; ?> (<?php echo ucfirst($_SESSION['role']); ?>)</span>
                <a href="index.php?action=profile" class="profile-link">(Edit Profile)</a>
                <?php if($_SESSION['role'] == 'seller'): ?>
                    <a href="index.php?action=seller_dashboard">Dashboard</a>
                    <a href="index.php?action=upload">Upload Game</a>
                <?php elseif($_SESSION['role'] == 'admin'): ?>
                    <a href="index.php?action=admin_dashboard">Admin Panel</a>
                <?php else: ?>
                    <a href="index.php?action=my_library">My Library</a>
                <?php endif; ?>

                <a href="index.php?action=logout" class="logout-link">Logout</a>
            <?php else: ?>
                <a href="index.php?action=login">Login</a>
                <a href="index.php?action=register">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h2>My Game Library</h2>
            <a href="index.php?action=home">
                <button class="btn-secondary">← Back to Store</button>
            </a>
        </div>

        <?php if(count($myGames) > 0): ?>
            <div class="game-grid">
                <?php foreach($myGames as $game): ?>
                    <div class="library-card">
                        

                        <h3 class="library-title"><?php echo $game['title']; ?></h3>
                        
                        <div class="purchase-date">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>Purchased on: <strong><?php echo date('M d, Y', strtotime($game['transaction_date'])); ?></strong></span>
                        </div>

                        <?php if(!empty($game['description'])): ?>
                            <p class="library-description">
                                <?php echo substr($game['description'], 0, 120); ?><?php echo strlen($game['description']) > 120 ? '...' : ''; ?>
                            </p>
                        <?php endif; ?>

                        <div class="library-actions">
                            <a href="index.php?action=download&file=<?php echo $game['full_file_path']; ?>" class="download-link">
                                <button class="btn-download">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    Download Full Version
                                </button>
                            </a>
                            
                          
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-library">
                <div class="empty-icon">🎮</div>
                <h3 class="empty-title">Your library is empty</h3>
                <p class="empty-text">You haven't purchased any games yet. Start building your collection!</p>
                <a href="index.php?action=home">
                    <button class="btn-browse">
                        Browse Games
                    </button>
                </a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>