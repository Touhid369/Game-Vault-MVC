<?php
class Game {
    private $conn;
    private $table = "games";

    public $id;
    public $seller_id;
    public $title;
    public $description;
    public $price;
    public $image_path;
    public $demo_file_path;
    public $full_file_path;
    public $is_approved;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Upload a New Game
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                (seller_id, title, description, price, image_path, demo_file_path, full_file_path, is_approved) 
                VALUES (:seller_id, :title, :desc, :price, :img, :demo, :full, 0)";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));

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

    // 2. Read All Approved Games (Homepage)
    public function readAll() {
        $query = "SELECT * FROM " . $this->table . " WHERE is_approved = 1 ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 3. Search Games (Homepage Search)
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE is_approved = 1 AND title LIKE :keyword 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt;
    }

    // 4. Get Games by Seller (Seller Dashboard)
    public function getGamesBySeller($seller_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE seller_id = :seller_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':seller_id', $seller_id);
        $stmt->execute();
        return $stmt;
    }

    // 5. Get ALL Games (Admin Dashboard)
    public function getAllGamesAdmin() {
        $query = "SELECT g.id, g.title, g.price, g.is_approved, u.full_name as seller_name 
                  FROM " . $this->table . " g
                  JOIN users u ON g.seller_id = u.id
                  ORDER BY g.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 6. Approve Game (Admin)
    public function approveGame($id) {
        $query = "UPDATE " . $this->table . " SET is_approved = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // 7. Get Single Game Details (Edit / Details Page)
    public function getGameById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 8. Update Game Info (Seller Edit)
    public function update($id, $title, $description, $price) {
      $query = "UPDATE " . $this->table . " 
               SET title = :title, description = :desc, price = :price 
               WHERE id = :id";

      $stmt = $this->conn->prepare($query);

      $title = htmlspecialchars(strip_tags($title));
      $description = htmlspecialchars(strip_tags($description));
      $price = htmlspecialchars(strip_tags($price));

      $stmt->bindParam(':title', $title);
      $stmt->bindParam(':desc', $description);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':id', $id);

      return $stmt->execute();
    }

   public function delete($id) {
      $q1 = "DELETE FROM wishlists WHERE game_id = :id";
      $stmt1 = $this->conn->prepare($q1);
      $stmt1->bindParam(':id', $id);
      $stmt1->execute();

      $q2 = "DELETE FROM reviews WHERE game_id = :id";
      $stmt2 = $this->conn->prepare($q2);
      $stmt2->bindParam(':id', $id);
      $stmt2->execute();

      $q3 = "DELETE FROM orders WHERE game_id = :id";
      $stmt3 = $this->conn->prepare($q3);
      $stmt3->bindParam(':id', $id);
      $stmt3->execute();

      $query = "DELETE FROM " . $this->table . " WHERE id = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id);
      
      return $stmt->execute();
   }
}
?>