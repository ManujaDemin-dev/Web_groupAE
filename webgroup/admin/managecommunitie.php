<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

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
    redirect('manage_communities.php');
}

// table boostrap karamu
// admin nav bar
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Communities</title>
</head>
<body>
    <h1>Manage Communities</h1>
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
                <td><?= htmlspecialchars($community['name']) ?></td>
                <td><?= htmlspecialchars($community['category_name']) ?></td>
                <td>
               
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this community?');">
                        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community['community_id']) ?>">
                        <button type="submit">Delete</button>
                    </form>
               
                    <button><a href="transfer_ownership.php?community_id=<?= htmlspecialchars($community['community_id']) ?>">Change Owner</a></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
