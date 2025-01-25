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
    <style>
            
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            
        }
        .nav-button12 {
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

       .nav-button12:hover {
           background-color:  #90D076; 
           color: black;
       }
        h2, h3 {
           
            text-align: center;
            margin: 20px 0;
            color: #0d3b66;
        }

        .updateform{
           
            border-radius: 8px;
            margin: 20px auto;
            padding: 20px;
            max-width: 800px;
        } 

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: black;
        }

        input[type="text"], input[type="color"], textarea, select {
            width: calc(100% - 20px);
            padding: 8px 10px;
            margin-bottom: 18px;
            border: 1px solid black;
            border-radius: 12px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input[type="color"] {
            height: 50px;
        }
        button {
            display: block;
            
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            color: black;
            cursor: pointer;
            margin-top: 10px;
        }

        button.updateb {
            background-color: #53aa43;
            width: 50%;
            margin: auto;
            font-weight: bold;
            color: white;
            padding: 10px 10px;
        }

        button.updateb:hover {
            background-color: #57b656;
        }

        button.ownerb {
            background-color: #296b8e;
            width: 50%;
            margin: auto;
            font-weight: bold;
            color: white;
            padding: 10px 10px;
        }

        button.ownerb:hover {
            background-color: #0d3b66;
        }

        button.deleteb {
            background-color:rgb(227, 30, 46);
            width: 150px;
            margin: auto;
            font-weight: bold;
            color: white;
            padding: 10px 10px;
        }

        button.deleteb:hover {
            background-color:rgb(246, 7, 7);
        }

        @media (max-width: 768px) {
            form {
                padding: 15px;
                max-width: 90%;
            }

            input[type="text"], input[type="color"], textarea, select {
                width: calc(100% - 16px); 
            }

            button {
                font-size: 14px;
                padding: 8px 12px;
            }
        }

        @media (max-width: 480px) {
            h2, h3 {
                font-size: 18px;
            }

            label {
                font-size: 14px;
            }
            .nav-button {
           margin: 10px 20px;
           padding: 4px 5px;
           font-size: 14px;
            }
        }

        </style>
    
</head>
<body>
    <form method="POST" action="./view.php">
        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
        <button class="nav-button12" type="submit">Back to Community</button>
    </form>

    <h2>Edit Community</h2>
    <form method="POST" action="" class="updateform" >
        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
        <input type="hidden" name="update_community" value="1">
        <label for="c_name">Community Name</label>
        <input type="text" id="c_name" name="c_name" maxlength="45" value="<?= htmlspecialchars($community['c_name']) ?>" required>
        <br>
        <label for="description">Description</label>
        <textarea id="description" name="description" maxlength="300" rows="4" required><?= htmlspecialchars($community['description']) ?></textarea>
        <br>
        <label for="color">Main Color</label>
        <input type="color" id="color" name="color" value="<?= htmlspecialchars($community['color']) ?>">
        <br>
        <button class="updateb" type="submit" onclick="return confirm('Are you sure you want to update this community?')">Update</button>
    </form>

    <h2>Admin Actions</h2>
    <form method="POST" action="./changeowner.php" class="updateform">
        <input class="admininput" type="hidden" name="community_id" value="<?= $community_id ?>">
        <label for="new_owner">Change Owner in this community</label>
        <select id="new_owner" name="new_owner_id" required>
            <?php foreach ($members as $member): ?>
                <option value="<?= $member['user_id'] ?>"><?= htmlspecialchars($member['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <br>
   
        <button class="ownerb" type="submit" onclick="return confirm('Are you sure you want to change the community admin?')" >Change Owner</button>
    </form>

   <br><br><br>

    <h3>Delete Community</h3>
    <form method="POST" action="deletecomm.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <input type="hidden" name="delete_community" value="1">
        <button class="deleteb" type="submit" onclick="return confirm('Are you sure you want to delete this community?')">Delete Community</button>
    </form>
</body>
</html>
