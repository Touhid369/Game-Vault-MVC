<?php
class Order {
    private $conn;
    private $table = "orders";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Buy a Game
    public function createOrder($user_id, $game_id, $price) {
        $query = "INSERT INTO " . $this->table . " (buyer_id, game_id, payment_amount) VALUES (:uid, :gid, :amt)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':uid', $user_id);
        $stmt->bindParam(':gid', $game_id);
        $stmt->bindParam(':amt', $price);

        return $stmt->execute();
    }

    // 2. Get User's Purchased Games
    public function getPurchasedGames($user_id) {
        // JOIN query to get Game details for the Order
        $query = "SELECT g.title, g.full_file_path, o.transaction_date 
                  FROM " . $this->table . " o
                  JOIN games g ON o.game_id = g.id
                  WHERE o.buyer_id = :uid
                  ORDER BY o.transaction_date DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $user_id);
        $stmt->execute();
        return $stmt;
    }

    // 3. Check if already bought (to hide Buy button)
    public function hasBought($user_id, $game_id) {
        $query = "SELECT id FROM " . $this->table . " WHERE buyer_id = ? AND game_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $game_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    // Add this inside app/models/Order.php
    public function getSalesBySeller($seller_id) {
        $query = "SELECT o.id, g.title, u.username as buyer_name, o.payment_amount, o.transaction_date 
                  FROM " . $this->table . " o
                  JOIN games g ON o.game_id = g.id
                  JOIN users u ON o.buyer_id = u.id
                  WHERE g.seller_id = :seller_id
                  ORDER BY o.transaction_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':seller_id', $seller_id);
        $stmt->execute();
        return $stmt;
    }
    // Add this to Order.php
    public function isFileOwnedBy($user_id, $file_name) {
        $query = "SELECT o.id 
                  FROM " . $this->table . " o
                  JOIN games g ON o.game_id = g.id 
                  WHERE o.buyer_id = :uid AND g.full_file_path = :file";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $user_id);
        $stmt->bindParam(':file', $file_name);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Get Total Sales for each Game (For Charts)
    public function getSalesStats() {
        $query = "SELECT g.title, COUNT(o.id) as total_sales, SUM(o.payment_amount) as total_revenue
                  FROM orders o
                  JOIN games g ON o.game_id = g.id
                  GROUP BY g.title";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
   
}
?>