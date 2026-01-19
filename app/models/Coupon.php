<?php
class Coupon {
    private $conn;
    private $table = "coupons";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Check if code exists and is active
    public function getCoupon($code) {
        $query = "SELECT * FROM " . $this->table . " WHERE code = :code AND status = 1";
        $stmt = $this->conn->prepare($query);
        
        // Clean input
        $code = htmlspecialchars(strip_tags($code));
        
        $stmt->bindParam(':code', $code);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>