<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="assets/css/sellerDashboard.css">
</head>
<body>

    <nav>
        <h1>Seller Dashboard</h1>
        <div>
            <a href="index.php?action=home">Visit Store</a>
            <a href="index.php?action=logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
            <h2>Welcome, <?php echo $_SESSION['full_name']; ?></h2>
            <a href="index.php?action=upload" class="btn"> + Upload New Game</a>
        </div>

        <div style="background: linear-gradient(145deg, #252538 0%, #2a2a3e 100%) !important; padding: 10px 20px; border-radius: 10px;">
            <h3>Total Earnings: <span style="color: #27ae60;">$<?php echo number_format($totalEarnings, 2); ?></span></h3>
        </div>

        <h3>My Uploaded Games</h3>
        <table border="1" cellpadding="10" cellspacing="0" width="100%" style="background:white; border-collapse: collapse;">
            <thead>
                <tr style="background: #ecf0f1;">
                    <th>Game Title</th>
                    <th>Price</th>
                    <th>Downloads (Demo)</th>
                    <th>Action</th>
                    <th>update</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($myGames) > 0): ?>
                    <?php foreach($myGames as $game): ?>
                        <tr>
                           <td><?php echo $game['title']; ?></td>
                           <td>$<?php echo $game['price']; ?></td>
                           <td><a href="uploads/demos/<?php echo $game['demo_file_path']; ?>" target="_blank">Test Demo</a></td>
                           <td>
                              <a href="index.php?action=seller_delete_game&id=<?php echo $game['id']; ?>" 
                                 onclick="return confirm('Are you sure? This will remove the game and all its reviews.');">
                                 <button style="background: #e74c3c;">Delete</button>
                              </a>
                           </td>
                           <td>
                              <a href="index.php?action=edit_game&id=<?php echo $game['id']; ?>" class="btn" style="background: #f39c12; padding: 5px 10px; font-size: 12px;">Edit</a>
    
                           </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">You haven't uploaded any games yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <hr>

        <h3>My Sales History</h3>
        <table border="1" cellpadding="10" cellspacing="0" width="100%" style="background:white; border-collapse: collapse;">
            <thead>
                <tr style="background: #ecf0f1;">
                    <th>Date</th>
                    <th>Buyer Name</th>
                    <th>Game Title</th>
                    <th>Amount Earned</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($mySales) > 0): ?>
                    <?php foreach($mySales as $sale): ?>
                        <tr>
                            <td><?php echo $sale['transaction_date']; ?></td>
                            <td><?php echo $sale['buyer_name']; ?></td>
                            <td><?php echo $sale['title']; ?></td>
                            <td style="color: #27ae60; font-weight:bold;">+$<?php echo $sale['payment_amount']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No sales yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</body>
</html>