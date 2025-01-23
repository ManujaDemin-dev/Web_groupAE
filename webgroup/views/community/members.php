<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}
include '../usernav.php';
//if($_SERVER['REQUEST_METHOD'] == 'GET'){
$community_id = $_GET['community_id'];


$ownerQuery = "SELECT current_owner_id FROM communities WHERE community_id = :community_id";
$ownerStmt = $pdo->prepare($ownerQuery);
$ownerStmt->execute(['community_id' => $community_id]);
$owner = $ownerStmt->fetch(PDO::FETCH_ASSOC);

$isOwner = $_SESSION['user_id'] == $owner['current_owner_id'];


$query = "SELECT users.user_id, users.name, users.email FROM community_members 
          JOIN users ON community_members.user_id = users.user_id 
          WHERE community_members.community_id = :community_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['community_id' => $community_id]);
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle member removal (only by the owner)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $isOwner) {
    $user_id = $_POST['user_id'];

  
    if ($user_id != $owner['current_owner_id']) {
        $deleteQuery = "DELETE FROM community_members WHERE community_id = :community_id AND user_id = :user_id";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute(['community_id' => $community_id, 'user_id' => $user_id]);
    }
    //redirect("members.php?community_id=$community_id");
    
        echo "<form id='redirectForm' method='GET' action='./members.php'>
        <input type='hidden' name='community_id' value='" . htmlspecialchars($community_id) . "'>
    </form>
    <script>document.getElementById('redirectForm').submit();</script>";
}

// include '../userhead.html';
// include '../communityhead.html';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Community Members</title>
    <style>
        body {
            
            
        }
        table {
            font-family: 'Poppins', sans-serif;
            width: 95%;
            border-collapse: collapse;
            margin: 10px auto;
        }
        .head {
            text-align: center;
            margin: 0px 0px 0px 0px;
            font-size: 23px;


        }
        .nav-button {
           margin: 20px 30px;
           padding: 8px 10px;
           background-color: #0d3b66;
           color: white;
           border: none;
           border-radius: 4px;
           cursor: pointer;
           text-decoration: none;
           font-size: 14px;
           
           transition:  transform 0.2s ease;
       }

       .nav-button:hover {
           background-color:  #90D076; 
           color: black;
       }
       .removebutton {
        
           padding: 5px 10px;
           background-color: red;
           color: white;
           border: none;
           border-radius: 5px;
           cursor: pointer;
           text-decoration: none;
           font-size: 14px;
           
           transition:  transform 0.2s ease;
       }
       .nameu {
           text-decoration: none;
           color: black;
           font-weight: 600;
       }
       @media (max-width: 480px) {
        .body {
            font-size: 10px;
        }
        .removebutton {
            padding: 2px 5px;
            
            font-size: 14px;
            
            margin: 0px 0px 0px 0px;
        }
        .nav-button {
           margin: 10px 20px;
           padding: 4px 5px;
           font-size: 14px;
        
       }
       .name {
           font-size: 12px;
       }
       }
    </style>
</head>
<body>
    
    <form method="POST" action = "./view.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <button class="nav-button" type="submit">Back to community</button>
    </form>
    <h1 class="head">Members of the Community</h1>
    <table>
        <thead>
            <tr we don t want to show the table to user.>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member): ?>
            <tr>
            <td><a class="nameu" href="../user/userprofile.php?userid=<?= urlencode($member['user_id']) ?>"><?= htmlspecialchars($member['name']) ?></a></td>
                <td><?= htmlspecialchars($member['email']) ?></td>
                <td>
                    <?php if ($isOwner && $member['user_id'] != $owner['current_owner_id']): ?>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?= $member['user_id'] ?>">
                            <button class="removebutton" type="submit">Remove</button>
                        </form>
                    <?php elseif ($member['user_id'] == $_SESSION['user_id']): ?>
                        You
                    
                    <?php elseif ($member['user_id'] == $owner['current_owner_id']): ?>
                        Admin
                    <?php else: ?>
                        
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</body>
</html>
