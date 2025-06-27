<?php
require_once './includes/config.php';
require_once './includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? 'Anonim';
    $comment = $_POST['comment'] ?? '';
    
    // Vulnerable - no XSS protection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $stmt = $conn->prepare("INSERT INTO comments (name, comment) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $comment);
    $stmt->execute();
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$result = $conn->query("SELECT * FROM comments ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Komentar</title>
</head>
<body>
    <h1>Komentar Pengguna</h1>
    
    <form method="POST">
        <input type="text" name="name" placeholder="Nama Anda"><br>
        <textarea name="comment" rows="4" cols="50" placeholder="Komentar..."></textarea><br>
        <button type="submit">Kirim</button>
    </form>
    
    <h2>Daftar Komentar:</h2>
    <?php while($row = $result->fetch_assoc()): ?>
        <div style="margin-bottom: 20px; border-bottom: 1px solid #eee;">
            <strong><?= $row['name'] ?></strong><br>
            <?= $row['comment'] ?>
        </div>
    <?php endwhile; ?>
</body>
</html>