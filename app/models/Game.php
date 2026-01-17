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
// Add this to app/models/Game.php

    // Get single game details (Reusable)
    public function getGameById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update Game Details (Text only for now)
    public function update($id, $title, $description, $price) {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, description = :desc, price = :price 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $title = htmlspecialchars(strip_tags($title));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':desc', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
// Add this to app/models/Game.php
    
    // Search games by title
    public function search($keyword) {
        // Use SQL 'LIKE' for partial matches
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE is_approved = 1 AND title LIKE :keyword 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        // Add % symbols for partial match (e.g., "Mario" matches "Super Mario Bros")
        $keyword = "%{$keyword}%";
        
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt;
    }
}
?>