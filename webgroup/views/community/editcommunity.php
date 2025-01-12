<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}
include '../usernav.php';


// $username = $_SESSION['username'];

$community_id = $_POST['community_id'];

$query = "SELECT * FROM communities WHERE community_id = :community_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['community_id' => $community_id]);  
$community = $stmt->fetch(PDO::FETCH_ASSOC);

if ($community['current_owner_id'] != $_SESSION['user_id']) {
    redirect('../user/logout.php');
}

 $membersQuery = "SELECT users.name, users.email FROM community_members 
                 JOIN users ON community_members.user_id = users.user_id
                 WHERE community_members.community_id = :community_id";
 $membersStmt = $pdo->prepare($membersQuery);
 $membersStmt->execute(['community_id' => $community_id]);
 $members = $membersStmt->fetchAll(PDO::FETCH_ASSOC);


 // security nisa wena page ekaka server side damu.
//update community details
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $c_name = $_POST['c_name'];
    $description = $_POST['description'];
    $color = $_POST['color'];

    $updateQuery = "UPDATE communities SET c_name = :c_name, description = :description, color = :color WHERE community_id = :community_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([
        'c_name' => $c_name,
        'description' => $description,
        'color' => $color,
        'community_id' => $community_id
    ]);
    echo " <p class='successmessage'>Community updated successfully!</p>";
}
    
    

*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="./view.php">
        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
        <button type="submit">BackToCommunity</button>
    </form>

    <h2>Edit Community</h2>
    <form method="POST" action="" class="updateform">
        <input  type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
        <label for="c_name">Community Name:</label>
        <input class="fromname" type="text" id="c_name" name="c_name" maxlength="45" value="<?= htmlspecialchars($community['c_name']) ?>">
        <br>
        <label for="description">Description:</label>
        <input class ="fromdesc" type="text" id="description" name="description" maxlength="300" rows="8" value="<?= htmlspecialchars($community['description']) ?>">
        <br>
        <label for="color">Main Color:</label>
        <input class="fromcolor" type="color" id="color" name="color" value="<?= htmlspecialchars($community['color']) ?>">
        <br>
        <button class="update" type="submit">Update</button>
    </form>



    <h2>Admin Change</h2>
    <form method="POST" action="./changeowner.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <label for="new_owner">Upadate owner</label>
        <select id="new_owner" name="new_owner">
            <?php foreach ($members as $member): ?>
                <option value="<?= $member['name'] ?>"></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Change Owner</button>
    </form>
    
    <h3>kick members</h3>
    <form method="POST" action="./kickmember.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <label >Member to kick</label>
        <select id="member_to_kick" name="member_to_kick">
            <?php foreach ($members as $member): ?>
                <option value="<?= $member['name'] ?>"></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Kick Member</button>
    </form>

   

    <h3>Delete files</h3>
    <form method="POST" action="./deletefiles.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <select name=" filename">
            <?php foreach ($files as $file): ?>
                <option value="<?= $file['name_for_file'] ?>"></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Delete Files</button>
    </form>


    <h3>Delete Community</h3>
    <form method="POST" action="">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
       
        <button type="submit">Delete Community</button>
    </form>
</body>
</html>