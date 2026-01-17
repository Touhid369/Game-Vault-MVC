<?php
include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../models/Wishlist.php';

class WishlistController {

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $wishlistModel = new Wishlist($db);

        $stmt = $wishlistModel->getUserWishlist($_SESSION['user_id']);
        $wishlistItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/buyer/wishlist.php';
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $game_id = $_GET['id'];
        $user_id = $_SESSION['user_id'];

        $database = new Database();
        $db = $database->getConnection();
        $wishlistModel = new Wishlist($db);

        $wishlistModel->add($user_id, $game_id);
        
        // Redirect back to where they came from
        header("Location: index.php?action=my_wishlist");
    }

    public function remove() {
        if (!isset($_SESSION['user_id'])) die("Access Denied");

        $game_id = $_GET['id'];
        $user_id = $_SESSION['user_id'];

        $database = new Database();
        $db = $database->getConnection();
        $wishlistModel = new Wishlist($db);

        $wishlistModel->remove($user_id, $game_id);
        header("Location: index.php?action=my_wishlist");
    }
}
?>