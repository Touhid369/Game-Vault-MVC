<?php
class User {
    private $conn;
    private $table = "users";

    public $id;
    public $full_name;
    public $username;
    public $email;
    public $password;
    public $contact_number;
    public $address;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Check if email already exists
    public function emailExists() {
        $query = "SELECT id, password, role, full_name FROM " . $this->table . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->password = $row['password']; // Hashed password
            $this->role = $row['role'];
            $this->full_name = $row['full_name'];
            return true;
        }
        return false;
    }

    // Create new user
    public function register() {
        $query = "INSERT INTO " . $this->table . " 
                (full_name, username, email, password, contact_number, address, role) 
                VALUES (:name, :username, :email, :password, :contact, :address, :role)";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contact_number = htmlspecialchars(strip_tags($this->contact_number));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Bind values
        $stmt->bindParam(':name', $this->full_name);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':contact', $this->contact_number);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':role', $this->role);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    // Get all users
    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Block/Unblock User
    public function toggleStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET is_active = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>