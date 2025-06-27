<?php
session_start();
require_once '../includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: login.php');
    exit;
}

global $db;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 1rem;
        }
        .sidebar {
            background-color: #34495e;
            color: white;
            padding: 1rem;
            border-radius: 5px;
        }
        .content {
            background-color: white;
            padding: 1rem;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .flag {
            background-color: #f8f9fa;
            border-left: 4px solid #27ae60;
            padding: 1rem;
            margin-top: 2rem;
        }
        .comment {
            border-bottom: 1px solid #eee;
            padding: 0.5rem 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>

    <div class="container">
        <div class="dashboard">
            <div class="sidebar">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="?action=comments">Manage Comments</a></li>
                    <li><a href="?action=users">Manage Users</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>

            <div class="content">
                <?php if (!isset($_GET['action'])): ?>
                    <h2>Welcome, Administrator</h2>
                    <p>You have full control over this CMS.</p>
                    
                    <div class="flag">
                        <h3>🏴 Flag:</h3>
                        <p><?= $db->getFlag() ?></p>
                    </div>

                <?php elseif ($_GET['action'] === 'comments'): ?>
                    <h2>Comment Management</h2>
                    <?php
                    // Vulnerable to XSS via stored comments
                    $comments = $db->getComments();
                    foreach ($comments as $comment): 
                    ?>
                        <div class="comment">
                            <strong><?= htmlspecialchars($comment['name']) ?></strong>
                            <p><?= $comment['comment'] ?></p> <!-- Intentionally vulnerable to XSS -->
                            <small><?= $comment['created_at'] ?></small>
                        </div>
                    <?php endforeach; ?>

                <?php elseif ($_GET['action'] === 'users'): ?>
                    <h2>User Management</h2>
                    <table border="1" cellpadding="8" cellspacing="0">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Is Admin</th>
                        </tr>
                        <?php
                        // Vulnerable to SQL injection via $_GET parameters
                        $search = $_GET['search'] ?? '';
                        $query = "SELECT * FROM users";
                        if (!empty($search)) {
                            $query .= " WHERE username LIKE '%$search%'";
                        }
                        $result = $db->conn->query($query);
                        
                        while ($user = $result->fetch_assoc()): 
                        ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>

                    <form method="GET" style="margin-top: 1rem;">
                        <input type="hidden" name="action" value="users">
                        <input type="text" name="search" placeholder="Search users...">
                        <button type="submit">Search</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>