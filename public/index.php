<?php
// 1. Enable Error Reporting (Helps debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Start Session
session_start();

// 3. Get Action
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

// 4. Include Controllers
include_once __DIR__ . '/../app/controllers/AuthController.php';
include_once __DIR__ . '/../app/controllers/GameController.php';
include_once __DIR__ . '/../app/controllers/AdminController.php';
// ... error reporting lines ...

// 1. Include the file FIRST
include_once __DIR__ . '/../app/controllers/WishlistController.php'; 

// 2. THEN create the object
$wishlistController = new WishlistController();

// 5. Initialize Controllers
$auth = new AuthController();
$gameController = new GameController();
$adminController = new AdminController();

// 6. Router Switch
switch ($action) {
    // --- AUTH ROUTES ---
    case 'login':
        $auth->login();
        break;
    case 'loginSubmit':
        $auth->loginSubmit();
        break;
    case 'register':
        $auth->register();
        break;
    case 'registerSubmit':
        $auth->registerSubmit();
        break;
    case 'logout':
        $auth->logout();
        break;

    // --- PUBLIC ROUTES ---
    case 'home':
        $gameController->index();
        break;
    
    // --- SELLER ROUTES ---
    case 'upload':
        $gameController->upload();
        break;
    case 'uploadSubmit':
        $gameController->uploadSubmit();
        break;
    case 'seller_dashboard':
        $gameController->sellerDashboard();
        break;

    // --- ADMIN ROUTES ---
    case 'admin_dashboard':
        $adminController->dashboard();
        break;
    case 'approve_game':
        $adminController->approveGame();
        break;
    case 'toggle_user':
        $adminController->toggleUser();
        break;

    // --- BUYER ROUTES (Checkout & Library) ---
    case 'checkout':                 // <--- THIS WAS MISSING
        $gameController->checkout();
        break;
    case 'confirm_purchase':         // <--- THIS WAS MISSING
        $gameController->confirmPurchase();
        break;
    case 'my_library':
        $gameController->myLibrary();
        break;
    case 'download':
        $gameController->download();
        break;
    // --- REVIEW ROUTES ---
    case 'details':
        $gameController->details();
        break;
    case 'submit_review':
        $gameController->submitReview();
        break;
    // --- EDIT ROUTES ---
    case 'edit_game':
        $gameController->edit();
        break;
    case 'update_game':
        $gameController->updateGame();
        break;
    // --- PROFILE ROUTES ---
    case 'profile':
        $auth->profile();
        break;
    case 'update_profile':
        $auth->updateProfile();
        break;
     // --- WISHLIST ROUTES ---
    case 'my_wishlist':
    $wishlistController->index();
    break;
    case 'add_wishlist':
    $wishlistController->add();
    break;
    case 'remove_wishlist':
    $wishlistController->remove();
    break;
    // --- SEARCH ROUTE ---
    case 'search':
        $gameController->search();
        break;
    // --- COUPON ROUTE ---
    case 'apply_coupon':
        $gameController->applyCoupon();
        break;
    // --- DEFAULT ---
    default:
        echo "404 - Page Not Found";
        break;
}
?>