<?php
class Game {
    private $conn;
    private $table = "games";

    public $seller_id;
    public $title;
    public $description;
    public $price;
    public $image_path;
    public $demo_file_path;
    public $full_file_path;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getGamesBySeller($seller_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE seller_id = :seller_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':seller_id', $seller_id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                (seller_id, title, description, price, image_path, demo_file_path, full_file_path) 
                VALUES (:seller_id, :title, :desc, :price, :img, :demo, :full)";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));

        // Bind
        $stmt->bindParam(':seller_id', $this->seller_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':desc', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':img', $this->image_path);
        $stmt->bindParam(':demo', $this->demo_file_path);
        $stmt->bindParam(':full', $this->full_file_path);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    // Add this inside your Game class
public function readAll() {
    // Select all approved games, newest first
    // Only show approved games
    $query = "SELECT * FROM " . $this->table . " WHERE is_approved = 1 ORDER BY created_at DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}
// Add this to Game.php
// Get all games (Approved & Pending) for Admin
public function getAllGamesAdmin() {
    $query = "SELECT * FROM " . $this->table . " ORDER BY is_approved ASC, created_at DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

// Approve a Game
public function approveGame($id) {
    $query = "UPDATE " . $this->table . " SET is_approved = 1 WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

// Delete a Game
public function delete($id) {
    $query = "DELETE FROM " . $this->table . " WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

}
?>