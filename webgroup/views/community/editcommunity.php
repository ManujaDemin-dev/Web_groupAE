<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

include '../usernav.php';

$community_id = $_POST['community_id'];



$query = "SELECT * FROM communities WHERE community_id = :community_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['community_id' => $community_id]);
$community = $stmt->fetch(PDO::FETCH_ASSOC);

if ($community['current_owner_id'] != $_SESSION['user_id']) {
    redirect('../user/logout.php');
}

$membersQuery = "
    SELECT users.user_id, users.name, users.email 
    FROM community_members 
    JOIN users ON community_members.user_id = users.user_id
    WHERE community_members.community_id = :community_id";
$membersStmt = $pdo->prepare($membersQuery);
$membersStmt->execute(['community_id' => $community_id]);
$members = $membersStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_community'])) {
        $c_name = trim($_POST['c_name']);
        $description = trim($_POST['description']);
        $color = trim($_POST['color']);

        $updateQuery = "
            UPDATE communities 
            SET c_name = :c_name, description = :description, color = :color 
            WHERE community_id = :community_id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([
            'c_name' => $c_name,
            'description' => $description,
            'color' => $color,
            'community_id' => $community_id
        ]);
        echo "<p class='successmessage'>Community updated successfully!</p>";
    }

    if (isset($_POST['delete_community'])) {
        $deleteQuery = "DELETE FROM communities WHERE community_id = :community_id";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute(['community_id' => $community_id]);
        redirect('../user/dashboard.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Community</title>
</head>
<body>
    <form method="POST" action="./view.php">
        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
        <button type="submit">Back to Community</button>
    </form>

    <h2>Edit Community</h2>
    <form method="POST" action="" class="updateform">
        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
        <input type="hidden" name="update_community" value="1">
        <label for="c_name">Community Name:</label>
        <input type="text" id="c_name" name="c_name" maxlength="45" value="<?= htmlspecialchars($community['c_name']) ?>" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" maxlength="300" rows="4" required><?= htmlspecialchars($community['description']) ?></textarea>
        <br>
        <label for="color">Main Color:</label>
        <input type="color" id="color" name="color" value="<?= htmlspecialchars($community['color']) ?>">
        <br>
        <button type="submit">Update</button>
    </form>

    <h2>Admin Actions</h2>
    <form method="POST" action="./changeowner.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <label for="new_owner">Change Owner:</label>
        <select id="new_owner" name="new_owner" required>
            <?php foreach ($members as $member): ?>
                <option value="<?= $member['user_id'] ?>"><?= htmlspecialchars($member['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Change Owner</button>
    </form>

    <h3>Kick Members</h3>
    <form method="POST" action="./kickmember.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <label for="member_to_kick">Member to Kick:</label>
        <select id="member_to_kick" name="member_to_kick" required>
            <?php foreach ($members as $member): ?>
                <option value="<?= $member['user_id'] ?>"><?= htmlspecialchars($member['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Kick Member</button>
    </form>

    <h3>Delete Community</h3>
    <form method="POST" action="">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <input type="hidden" name="delete_community" value="1">
        <button type="submit" onclick="return confirm('Are you sure you want to delete this community?')">Delete Community</button>
    </form>
</body>
</html>
