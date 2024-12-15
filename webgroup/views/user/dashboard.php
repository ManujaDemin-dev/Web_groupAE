<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

$query = "SELECT * FROM community_members 
          JOIN communities ON community_members.community_id = communities.community_id 
          WHERE community_members.user_id = :user_id";
$statement = $pdo->prepare($query);
$statement->execute(['user_id' => $_SESSION['user_id']]);
$communities = $statement->fetchAll(PDO::FETCH_ASSOC);

include '../userhead.html'; // Navbar
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            background-color: #efeeee;
            font-family: Arial, Helvetica, sans-serif;
            margin-top: 100px;
        }

        .container {
            width: 1200px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .book {
            width: 100%;
            height: 300px;
            position: relative;
            font-family: Arial, Helvetica, sans-serif;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            cursor: pointer; 
           
        }

        .book:hover {
           
        }

        .cover {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            background: linear-gradient(135deg, rgb(41, 170, 31), rgb(14, 129, 6));
            color: white;
            padding: 10px;
            
        }

        .bookmark {
            position: absolute;
            top: 0px; 
            right: 20px;
            width: 50px;
            height: 60px; 
            
            clip-path: polygon(0 0, 100% 0, 100% 70%, 50% 100%, 0 70%);
        }

        .h33 {
            font-size: 1.2em;
            color: #fff;
            text-align: center;
            margin: 50px 0 12px;
        }

        .pp {
            font-size: 0.8em;
            color: #fff;
            line-height: 1.2;
            text-align: center;
            padding: 0 10px;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php foreach ($communities as $community): ?>
        
        <a href="../community/view.php?community_id=<?= htmlspecialchars($community['community_id']) ?>" class="book">
            <div class="cover"> <div class="bookmark"style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
                <h3 class="h33"><?= htmlspecialchars($community['name']) ?></h3>
                <p class="pp"><?= htmlspecialchars($community['description']) ?></p>
            </div>
            <div class="bookmark"></div>
        </a>
        <?php endforeach; ?>
    </div>
</body>
</html>

