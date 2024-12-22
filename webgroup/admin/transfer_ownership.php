<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

// Ensure the user is authorized to access this page
// if (!isAdmin()) {
//     redirect('../index.php');
// }

$community_id = $_GET['community_id'];

$membersQuery = "SELECT users.user_id, users.name FROM community_members JOIN users ON community_members.user_id = users.user_id WHERE community_members.community_id = :community_id";
$membersStmt = $pdo->prepare($membersQuery);
$membersStmt->execute(['community_id' => $community_id]);
$members = $membersStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle the form submission to transfer ownership
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newOwnerId = $_POST['new_owner_id'];

    // Update the community's current owner
    $updateQuery = "
        UPDATE communities 
        SET current_owner_id = :new_owner_id 
        WHERE community_id = :community_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([
        'new_owner_id' => $newOwnerId,
        'community_id' => $community_id,
    ]);

    redirect('manage_communities.php'); // Redirect after successful transfer
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transfer Ownership</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            margin: 20px 0;
        }
        select, button {
            padding: 10px;
            margin: 5px 0;
        }
        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <h1>Transfer Ownership</h1>
    <form method="POST">
        <label for="new_owner_id">Select New Owner:</label>
        <select id="new_owner_id" name="new_owner_id" required>
            <?php foreach ($members as $member): ?>
                <option value="<?= htmlspecialchars($member['user_id']) ?>">
                    <?= htmlspecialchars($member['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Transfer</button>
    </form>
    <a href="manage_communities.php">Back to Manage Communities</a>
</body>
</html>
