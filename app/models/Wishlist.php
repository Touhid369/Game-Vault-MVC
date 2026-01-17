<?php
class Wishlist {
    private $conn;
    private $table = "wishlists";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Add item to wishlist
    public function add($user_id, $game_id) {
        // Check if already exists
        if($this->check($user_id, $game_id)) {
            return false; // Already in wishlist
        }

        $query = "INSERT INTO " . $this->table . " (user_id, game_id) VALUES (:uid, :gid)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $user_id);
        $stmt->bindParam(':gid', $game_id);
        return $stmt->execute();
    }

    // 2. Remove item
    public function remove($user_id, $game_id) {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = :uid AND game_id = :gid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $user_id);
        $stmt->bindParam(':gid', $game_id);
        return $stmt->execute();
    }

    // 3. Get user's wishlist
    public function getUserWishlist($user_id) {
        $query = "SELECT w.id, g.id as game_id, g.title, g.price, g.image_path 
                  FROM " . $this->table . " w
                  JOIN games g ON w.game_id = g.id
                  WHERE w.user_id = :uid
                  ORDER BY w.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $user_id);
        $stmt->execute();
        return $stmt;
    }

    // 4. Check if item exists (Helper)
    public function check($user_id, $game_id) {
        $query = "SELECT id FROM " . $this->table . " WHERE user_id = :uid AND game_id = :gid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $user_id);
        $stmt->bindParam(':gid', $game_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>