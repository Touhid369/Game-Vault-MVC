<?php
include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../models/User.php';
include_once __DIR__ . '/../models/Game.php';

class AdminController {

    public function dashboard() {
        // 1. Security Check (Keep this)
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();

        // 2. Get Users & Games (Keep this)
        $userModel = new User($db);
        $usersStmt = $userModel->getAllUsers();
        $users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

        $gameModel = new Game($db);
        $gamesStmt = $gameModel->getAllGamesAdmin();
        $games = $gamesStmt->fetchAll(PDO::FETCH_ASSOC);

        // --- NEW: Get Chart Data ---
        $orderModel = new Order($db); // Make sure Order.php is included at top!
        $statsStmt = $orderModel->getSalesStats();
        $salesStats = $statsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare data for JavaScript
        $gameTitles = [];
        $gameRevenue = [];
        foreach($salesStats as $stat) {
            $gameTitles[] = $stat['title'];
            $gameRevenue[] = $stat['total_revenue'];
        }

        // 3. Load View
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function approveGame() {
        if ($_SESSION['role'] !== 'admin') die("Access Denied");
        $id = $_GET['id'];
        
        $database = new Database();
        $db = $database->getConnection();
        $game = new Game($db);
        
        $game->approveGame($id);
        header("Location: index.php?action=admin_dashboard");
    }

    public function toggleUser() {
        if ($_SESSION['role'] !== 'admin') die("Access Denied");
        $id = $_GET['id'];
        $status = $_GET['status']; // 1 = Active, 0 = Blocked
        
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        
        $user->toggleStatus($id, $status);
        header("Location: index.php?action=admin_dashboard");
    }
}
?>