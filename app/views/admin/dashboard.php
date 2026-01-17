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