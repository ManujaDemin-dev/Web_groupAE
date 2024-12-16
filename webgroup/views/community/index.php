<?php
session_start();
include '../../includes/db.php';

$category_id = $_GET['category_id'];

$query = "SELECT * FROM communities WHERE category_id = :category_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['category_id' => $category_id]);
$communities = $stmt->fetchAll(PDO::FETCH_ASSOC);
//include '../communityhead.html';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Communities</title>
</head>
<body>
    <h1>Communities</h1>
    <a href="create.php?category_id=<?= $category_id ?>">Create Community</a>
    <ul>
        <?php foreach ($communities as $community): ?>
        <li>
            <h2><?= $community['name'] ?></h2>
            <p><?= $community['description'] ?></p>
            <a href="view.php?community_id=<?= $community['community_id'] ?>">View</a>
            <a href="edit.php?community_id=<?= $community['community_id'] ?>">Edit</a>
            <a href="delete.php?community_id=<?= $community['community_id'] ?>">Delete</a>
            
        </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
