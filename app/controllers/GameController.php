<?php
include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../models/Game.php';
include_once __DIR__ . '/../models/Order.php';
include_once __DIR__ . '/../models/Review.php';
include_once __DIR__ . '/../models/Coupon.php';

class GameController {

    // 1. Homepage & Search
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        $game = new Game($db);
        
        $stmt = $game->readAll();
        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include __DIR__ . '/../views/home.php';
    }

    public function search() {
        $keyword = isset($_GET['q']) ? $_GET['q'] : '';
        
        $database = new Database();
        $db = $database->getConnection();
        $gameModel = new Game($db);

        if ($keyword) {
            $stmt = $gameModel->search($keyword);
            $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $search_title = "Search Results for: '" . htmlspecialchars($keyword) . "'";
        } else {
            $stmt = $gameModel->readAll();
            $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $search_title = "All Games";
        }

        include __DIR__ . '/../views/home.php';
    }

    // 2. Game Details & Reviews
    public function details() {
        if (!isset($_GET['id'])) die("Game ID missing");
        $game_id = $_GET['id'];
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        $database = new Database();
        $db = $database->getConnection();
        
        // Get Game Info
        $query = "SELECT * FROM games WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $game_id);
        $stmt->execute();
        $game = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$game) die("Game not found");

        // Get Reviews
        $reviewModel = new Review($db);
        $reviewsStmt = $reviewModel->getReviewsByGame($game_id);
        $reviews = $reviewsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if User Bought It
        $orderModel = new Order($db);
        $hasBought = $orderModel->hasBought($user_id, $game_id);

        include __DIR__ . '/../views/game_details.php';
    }

    public function submitReview() {
        if (!isset($_SESSION['user_id'])) die("Please login");
        
        $user_id = $_SESSION['user_id'];
        $game_id = $_POST['game_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        $database = new Database();
        $db = $database->getConnection();
        $order = new Order($db);

        if (!$order->hasBought($user_id, $game_id)) {
            die("You must buy the game to review it.");
        }

        $review = new Review($db);
        if($review->create($user_id, $game_id, $rating, $comment)) {
            header("Location: index.php?action=details&id=$game_id");
        } else {
            echo "Error submitting review.";
        }
    }

    // 3. Seller: Upload & Dashboard
    public function upload() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
            header("Location: index.php?action=login");
            exit;
        }
        include __DIR__ . '/../views/seller/upload.php';
    }

    public function uploadSubmit() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
            die("Access Denied");
        }

        $database = new Database();
        $db = $database->getConnection();
        $game = new Game($db);

        $game->seller_id = $_SESSION['user_id'];
        $game->title = $_POST['title'];
        $game->price = $_POST['price'];
        $game->description = $_POST['description'];

        $target_dir_img = __DIR__ . "/../../public/uploads/images/";
        $target_dir_demo = __DIR__ . "/../../public/uploads/demos/";
        $target_dir_full = __DIR__ . "/../../storage/game_files/";

        $img_name = time() . "_" . basename($_FILES["image"]["name"]);
        $demo_name = time() . "_" . basename($_FILES["demo_file"]["name"]);
        $full_name = time() . "_" . basename($_FILES["full_file"]["name"]);

        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir_img . $img_name);
        move_uploaded_file($_FILES["demo_file"]["tmp_name"], $target_dir_demo . $demo_name);
        
        if(move_uploaded_file($_FILES["full_file"]["tmp_name"], $target_dir_full . $full_name)) {
            $game->image_path = $img_name;
            $game->demo_file_path = $demo_name;
            $game->full_file_path = $full_name;
            
            if($game->create()) {
                header("Location: index.php?action=seller_dashboard&msg=uploaded");
            } else {
                echo "Database Error.";
            }
        } else {
            echo "Error uploading private file.";
        }
    }

    public function sellerDashboard() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
            header("Location: index.php?action=login");
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        
        $gameModel = new Game($db);
        $myGamesStmt = $gameModel->getGamesBySeller($_SESSION['user_id']);
        $myGames = $myGamesStmt->fetchAll(PDO::FETCH_ASSOC);

        $orderModel = new Order($db);
        $salesStmt = $orderModel->getSalesBySeller($_SESSION['user_id']);
        $mySales = $salesStmt->fetchAll(PDO::FETCH_ASSOC);

        $totalEarnings = 0;
        foreach($mySales as $sale) {
            $totalEarnings += $sale['payment_amount'];
        }

        include __DIR__ . '/../views/seller/dashboard.php';
    }

    // 4. Seller: Edit Game
    public function edit() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
            die("Access Denied");
        }

        $id = $_GET['id'];
        $database = new Database();
        $db = $database->getConnection();
        $gameModel = new Game($db);
        
        $game = $gameModel->getGameById($id);

        if($game['seller_id'] != $_SESSION['user_id']) {
            die("Error: You do not own this game.");
        }

        include __DIR__ . '/../views/seller/edit.php';
    }

    public function updateGame() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
            die("Access Denied");
        }

        $id = $_POST['id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        $database = new Database();
        $db = $database->getConnection();
        $gameModel = new Game($db);

        $existingGame = $gameModel->getGameById($id);
        if($existingGame['seller_id'] != $_SESSION['user_id']) {
            die("Error: You do not own this game.");
        }

        if ($gameModel->update($id, $title, $description, $price)) {
            header("Location: index.php?action=seller_dashboard&msg=updated");
        } else {
            echo "Update failed.";
        }
    }

    // 5. COUPON LOGIC
    public function applyCoupon() {
        if (!isset($_SESSION['user_id'])) die("Access Denied");

        $code = $_POST['coupon_code'];
        $game_id = $_POST['game_id'];

        $database = new Database();
        $db = $database->getConnection();
        $couponModel = new Coupon($db);

        $coupon = $couponModel->getCoupon($code);

        if ($coupon) {
            $_SESSION['coupon_code'] = $coupon['code'];
            $_SESSION['discount_percent'] = $coupon['discount_percent'];
            header("Location: index.php?action=checkout&id=$game_id&msg=coupon_valid");
        } else {
            header("Location: index.php?action=checkout&id=$game_id&error=invalid_coupon");
        }
    }

    // 6. Checkout & Purchase
    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $id = $_GET['id'];
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "SELECT * FROM games WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $game = $stmt->fetch(PDO::FETCH_ASSOC);

        // Coupon Logic
        $discount = 0;
        $final_price = $game['price'];

        if(isset($_SESSION['discount_percent'])) {
            $discount = $_SESSION['discount_percent'];
            $discount_amount = ($game['price'] * $discount) / 100;
            $final_price = $game['price'] - $discount_amount;
        }

        include __DIR__ . '/../views/buyer/checkout.php';
    }

    public function confirmPurchase() {
        if (!isset($_SESSION['user_id'])) die("Access Denied");

        $user_id = $_SESSION['user_id'];
        $game_id = $_POST['game_id'];
        $amount = $_POST['amount'];

        $database = new Database();
        $db = $database->getConnection();
        $order = new Order($db);

        if($order->hasBought($user_id, $game_id)) {
            header("Location: index.php?action=my_library");
            exit;
        }

        if ($order->createOrder($user_id, $game_id, $amount)) {
            // Clear Coupon
            unset($_SESSION['coupon_code']);
            unset($_SESSION['discount_percent']);
            
            header("Location: index.php?action=my_library&status=purchased");
        } else {
            echo "Payment Failed.";
        }
    }

    // 7. Library & Download
    public function myLibrary() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $order = new Order($db);

        $stmt = $order->getPurchasedGames($_SESSION['user_id']);
        $myGames = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/buyer/my_library.php';
    }

    public function download() {
        if (!isset($_SESSION['user_id'])) {
            die("Access Denied: Please log in.");
        }

        if(!isset($_GET['file'])) die("Error: No file specified.");
        $file_name = basename($_GET['file']); 
        $file_path = __DIR__ . "/../../storage/game_files/" . $file_name;

        $database = new Database();
        $db = $database->getConnection();
        $order = new Order($db);
        
        if(!$order->isFileOwnedBy($_SESSION['user_id'], $file_name)) {
            die("Error: Access Denied. You have not purchased this game.");
        }

        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            die("Error: File not found on server.");
        }
    }
}
?>