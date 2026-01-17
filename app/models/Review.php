<?php
class Review {
    private $conn;
    private $table = "reviews";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Write a Review
    public function create($buyer_id, $game_id, $rating, $comment) {
        $query = "INSERT INTO " . $this->table . " (buyer_id, game_id, rating, comment) VALUES (:uid, :gid, :rating, :comment)";
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $comment = htmlspecialchars(strip_tags($comment));

        $stmt->bindParam(':uid', $buyer_id);
        $stmt->bindParam(':gid', $game_id);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);

        return $stmt->execute();
    }

    // 2. Get Reviews for a Game
    public function getReviewsByGame($game_id) {
        $query = "SELECT r.rating, r.comment, r.created_at, u.username 
                  FROM " . $this->table . " r
                  JOIN users u ON r.buyer_id = u.id
                  WHERE r.game_id = :gid
                  ORDER BY r.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':gid', $game_id);
        $stmt->execute();
        return $stmt;
    }
}
?>