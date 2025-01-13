<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('./../index.php');
}


$query = "SELECT communities.*, categories.name AS category_name 
          FROM communities 
          JOIN categories ON communities.category_id = categories.category_id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$communities = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $community_id = $_POST['community_id'];

    $deleteQuery = "DELETE FROM communities WHERE community_id = :community_id";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->execute(['community_id' => $community_id]);
    redirect('managecommunitie.php');
}

$role = $_SESSION['role'];

if ($role == 'user') {
    redirect('//google.com');
    
}

// table boostrap karamu
// admin nav bar
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./adminstyle1.css">
    <title>Manage Communities</title>
</head>
<body>
    <h1>Manage Communities</h1>

    <a class="navbtn" href="manageusers.php">Manage Users</a>
    <a class="navbtn" href="managecommunitie.php">Manage Community</a>
    <a class="navbtn" href="admin.php">Admin Pannel</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($communities as $community): ?>
            <tr>
                <td><?= htmlspecialchars($community['community_id']) ?></td>
                <td><?= htmlspecialchars($community['c_name']) ?></td>
                <td><?= htmlspecialchars($community['category_name']) ?></td>
                <td>
               
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this community?');">
                        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community['community_id']) ?>">
                        <button class="btdel" type="submit">Delete</button>
                    </form>
               
                   <a  class="btnchange"href="transfer_ownership.php?community_id=<?= htmlspecialchars($community['community_id']) ?>">Change Owner</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
