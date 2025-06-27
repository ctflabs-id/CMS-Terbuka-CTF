<?php
require_once 'config.php';

class DB {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
        $this->initializeDatabase();
    }

    private function initializeDatabase() {
        // Vulnerable setup with default admin
        $this->conn->query("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                password VARCHAR(50) NOT NULL,
                is_admin BOOLEAN DEFAULT 0
            )
        ");

        $this->conn->query("
            CREATE TABLE IF NOT EXISTS comments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100),
                comment TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // Insert vulnerable admin account
        $this->conn->query("
            INSERT IGNORE INTO users (username, password, is_admin) 
            VALUES ('admin', 's3cret4dmin!!', 1)
        ");

        // Insert some sample comments
        $this->conn->query("
            INSERT IGNORE INTO comments (name, comment) 
            VALUES 
                ('System', 'Welcome to our CMS!'),
                ('Developer', 'Remember to change default credentials!')
        ");
    }

    // Vulnerable function - SQL injection possible
    public function getComments() {
        $result = $this->conn->query("SELECT * FROM comments ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Vulnerable function - XSS possible
    public function addComment($name, $comment) {
        $stmt = $this->conn->prepare("INSERT INTO comments (name, comment) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $comment);
        return $stmt->execute();
    }

    // Vulnerable admin login
    public function checkAdminLogin($username, $password) {
        // This is intentionally vulnerable to brute force
        $result = $this->conn->query("
            SELECT * FROM users 
            WHERE username = '$username' 
            AND password = '$password' 
            AND is_admin = 1
        ");
        
        return $result->num_rows > 0;
    }

    public function getFlag() {
        return "CTF_FLAG{H1dd3n_Adm1n_XSS_Combo}";
    }
}

// Global database instance
$db = new DB();
?>