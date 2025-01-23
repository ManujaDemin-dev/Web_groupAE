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

$isOwner = $_SESSION['user_id'] == $owner['current_owne r_id'];


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
            font-family: 'Poppins';
            margin: 0;
            padding: 0;
        }
        .comma {
            margin-top: 50px;
            text-align: center;
        }
        h1 {
            font-size: 23px;
            margin: 20px 0;
        }
        table {
            width: 85%;
            border-collapse: collapse;
            margin: 10px auto;
        }
        table th, table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #fff;
            font-weight: bold;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .removebutton {
            background-color: #75b060;
            color: white;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
        }
        .removebutton:hover {
            background-color: #d7bc74;
        }
        .back-button {
            display: inline-block;
            margin: 20px auto;
            background: linear-gradient(45deg, #75b060, #d7bc74);
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }
        .back-button:hover {
            background: linear-gradient(45deg, #d7bc74, #75b060);
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            h1 {
                font-size: 20px;
            }
            table {
                width: 100%;
                font-size: 14px;
            }
            table th, table td {
                padding: 6px;
            }
            table th, table td, table {
                display: block;
                text-align: left;
            }
            table thead {
                display: none;
            }
            table tr {
                margin-bottom: 15px;
                border-bottom: 1px solid #ddd;
            }
            table tr td {
                display: block;
                padding: 8px;
                text-align: left;
            }
            table tr td:first-child {
                font-weight: bold;
            }
            .back-button {
                width: 90%;
                font-size: 14px;
                margin: 10px auto;
            }
            .removebutton {
                padding: 4px 8px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="comma">
    <form method="POST" action = "./view.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <button type="submit">Back to community</button>
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
            <td><a href="../user/userprofile.php?userid=<?= urlencode($member['user_id']) ?>"><?= htmlspecialchars($member['name']) ?></a></td>
                <td><?= htmlspecialchars($member['email']) ?></td>
                <td>
                    <?php if ($isOwner && $member['user_id'] != $owner['current_owner_id']): ?>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?= $member['user_id'] ?>">
                            <button claas="removebutton" type="submit">Remove</button>
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
    </div>
    
</body>
</html>
