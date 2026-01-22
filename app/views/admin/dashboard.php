<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - GameStore</title>
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    
    <nav style="background: #2c3e50;">
        <h1>Admin Panel</h1>
        <div>
            <a href="index.php?action=home" target="_blank">View Homepage</a>
            <a href="index.php?action=logout" style="color: #e74c3c;">Logout</a>
        </div>
    </nav>

    <div class="container">
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 40px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h2>Revenue Analytics</h2>
            <canvas id="revenueChart" width="100%" height="30"></canvas>
        </div>

        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            
            <div style="background-color: #2c3e50d5; border-radius: 10px; padding: 10px 20px;">
                <h2>Manage Users</h2>
                <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; border-color: #eee;">
                    <thead>
                        <tr style="background: #ecf0f1;">
                            <th>Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td>
                                <?php echo $user['full_name']; ?><br>
                                <small style="color: gray;"><?php echo $user['email']; ?></small>
                            </td>
                            <td><?php echo ucfirst($user['role']); ?></td>
                            <td>
                                <?php if($user['is_active']): ?>
                                    <span style="color: green;">Active</span>
                                <?php else: ?>
                                    <span style="color: red;">Banned</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($user['role'] !== 'admin'): ?>
                                    <a href="index.php?action=toggle_user&id=<?php echo $user['id']; ?>" 
                                       style="color: <?php echo $user['is_active'] ? 'red' : 'green'; ?>; text-decoration: underline;">
                                       <?php echo $user['is_active'] ? 'Ban User' : 'Activate'; ?>
                                    </a>
                                <?php else: ?>
                                    <span style="color: gray;">(Admin)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="background-color: #2c3e50d5; border-radius: 10px; padding: 10px 20px;">
                <h2>Manage Games</h2>
                
                <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
                    <p style="color: green; background: #e8f5e9; padding: 10px;">Game deleted successfully.</p>
                <?php endif; ?>

                <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; border-color: #eee;">
                    <thead>
                        <tr style="background: #ecf0f1;">
                            <th>Game Title</th>
                            <th>Seller</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($games as $game): ?>
                        <tr>
                            <td><?php echo $game['title']; ?></td>
                            <td><?php echo $game['seller_name']; ?></td>
                            <td>$<?php echo $game['price']; ?></td>
                            
                            <td>
                                <?php if($game['is_approved']): ?>
                                    <span style="color: green; font-weight: bold;">Live</span>
                                <?php else: ?>
                                    <span style="color: orange; font-weight: bold;">Pending</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div style="display: flex; gap: 5px;">
                                    
                                    <a href="index.php?action=details&id=<?php echo $game['id']; ?>" target="_blank" 
                                       style="background: #3498db; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 11px;">
                                       Preview
                                    </a>

                                    <?php if(!$game['is_approved']): ?>
                                        <a href="index.php?action=approve_game&id=<?php echo $game['id']; ?>" 
                                           style="background: #27ae60; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 11px;">
                                           Approve
                                        </a>
                                    <?php endif; ?>

                                    <a href="index.php?action=admin_delete_game&id=<?php echo $game['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this game permanently?');"
                                       style="background: #e74c3c; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 11px;">
                                       Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        // Data passed from PHP Controller
        const titles = <?php echo json_encode($gameTitles); ?>;
        const revenues = <?php echo json_encode($gameRevenue); ?>;

        const ctx = document.getElementById('revenueChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: titles,
                datasets: [{
                    label: 'Total Revenue ($)',
                    data: revenues,
                    backgroundColor: 'rgba(52, 152, 219, 0.6)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

</body>
</html>