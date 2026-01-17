<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav>
        <h1>Admin Panel</h1>
        <div>
            <a href="index.php?action=home">Visit Site</a>
            <a href="index.php?action=logout">Logout</a>
        </div>
    </nav>
    <div class="container" style="margin-bottom: 40px;">
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h2>Revenue Analytics</h2>
            <canvas id="revenueChart" width="400" height="150"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Get data from PHP
        const titles = <?php echo json_encode($gameTitles); ?>;
        const revenues = <?php echo json_encode($gameRevenue); ?>;

        const ctx = document.getElementById('revenueChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar', // You can change to 'pie' or 'line'
            data: {
                labels: titles,
                datasets: [{
                    label: 'Total Revenue ($)',
                    data: revenues,
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.6)',
                        'rgba(46, 204, 113, 0.6)',
                        'rgba(155, 89, 182, 0.6)',
                        'rgba(241, 196, 15, 0.6)',
                        'rgba(231, 76, 60, 0.6)'
                    ],
                    borderColor: [
                        'rgba(52, 152, 219, 1)',
                        'rgba(46, 204, 113, 1)',
                        'rgba(155, 89, 182, 1)',
                        'rgba(241, 196, 15, 1)',
                        'rgba(231, 76, 60, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <div class="container">
        <h2>Manage Games (Approvals)</h2>
        <table border="1" cellpadding="10" width="100%" style="background:white; border-collapse:collapse;">
            <tr style="background:#ecf0f1;">
                <th>Title</th>
                <th>Seller</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($games as $game): ?>
                <tr>
                    <td><?php echo $game['title']; ?></td>
                    <td>Seller ID: <?php echo $game['seller_id']; ?></td>
                    <td>
                        <?php echo $game['is_approved'] ? '<span style="color:green">Live</span>' : '<span style="color:red">Pending</span>'; ?>
                    </td>
                    <td>
                        <?php if(!$game['is_approved']): ?>
                            <a href="index.php?action=approve_game&id=<?php echo $game['id']; ?>" class="btn" style="background:green;">Approve</a>
                        <?php endif; ?>
                        <a href="#" style="color:red; margin-left:10px;">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <br><hr><br>

        <h2>Manage Users</h2>
        <table border="1" cellpadding="10" width="100%" style="background:white; border-collapse:collapse;">
            <tr style="background:#ecf0f1;">
                <th>Name</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user['full_name']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><?php echo $user['is_active'] ? 'Active' : 'Blocked'; ?></td>
                    <td>
                        <?php if($user['role'] != 'admin'): ?>
                            <?php if($user['is_active']): ?>
                                <a href="index.php?action=toggle_user&id=<?php echo $user['id']; ?>&status=0" style="color:red;">Block</a>
                            <?php else: ?>
                                <a href="index.php?action=toggle_user&id=<?php echo $user['id']; ?>&status=1" style="color:green;">Unblock</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>