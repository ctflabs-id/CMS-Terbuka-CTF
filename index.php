<?php
require_once './includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>CMS Terbuka</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .header { background: #333; color: white; padding: 10px 20px; }
        .menu { margin: 20px 0; }
        .comment-box { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CMS Terbuka</h1>
    </div>
    
    <div class="menu">
        <a href="index.php">Home</a> | 
        <a href="comments.php">Komentar</a>
    </div>
    
    <h2>Selamat datang di CMS Terbuka</h2>
    <p>Sistem manajemen konten sederhana untuk kebutuhan lokal.</p>
    
    <div class="comment-box">
        <h3>Komentar Terakhir:</h3>
        <?php
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $result = $conn->query("SELECT * FROM comments ORDER BY id DESC LIMIT 3");
        while($row = $result->fetch_assoc()) {
            echo "<div><strong>{$row['name']}</strong>: {$row['comment']}</div>";
        }
        ?>
    </div>
    
    <!-- Hint tersembunyi -->
    <!-- Developer note: Jangan lupa backup di /backup_2023.zip -->
</body>
</html>