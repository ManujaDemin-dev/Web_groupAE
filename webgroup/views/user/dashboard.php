<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('\Web_groupAE\webgroup\views\auth\login.php');
}


$role = $_SESSION['role'];

if ($role == 'admin') {
   
   echo'<button class="admin"><a href="../../admin/admin.php">Create Community</a></button>';

    
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
    <title><?php echo $_SESSION['username']; ?> 's Dashboard</title>
    <style>
        body {
            
            justify-content: center;
            align-items: center;
            margin: 0;
           
            font-family: Arial, Helvetica, sans-serif;
            margin-top: 100px;
        }

               
            .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr); */
            gap: 20px;
            margin: 0 auto;
            width: 95%; 
            max-width: 1300px;
        }

      
        .community-card-alt {
            max-width: 280px;
            height: 300px;
            border-radius: 12px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border: 3px solid black;
            display: flex;
            flex-direction: column;
            background: #fff;
            margin-bottom: 20px;
        }

        .community-card-alt:hover {
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.4);
        }

       
        .card-header {
            background: #44ff15;
            height: 30px;
        }

        .card-footer {
            background-color: #44ff15;
            height: 30px;
            margin-top: auto;
        }

        .card-body {
            padding: 17px;
            text-align: center;
            flex-grow: 1;
        }

        .h33 {
            font-size: 1.2em;
            margin: 0;
        }

        .pp {
            margin-top: 10px;
        }

        @media (max-width: 600px) {
    .container {
        grid-template-columns: repeat(2, 1fr); 
        gap: 10px; 
    }

    .community-card-alt {
        height: 250px; 
       
    }
}

    </style>
</head>
<body>
    <div>
    <h1><?php echo $_SESSION['username']; ?>'s page</h1>
    <h2>Your Communities</h2>
    <h3>Hi <?php echo $_SESSION['username']; ?></h3>
    </div><br>
    <button><a href="./../../../Pomodoro Timer/pomodoro.html" target="_blank" >Start pomodoro</a></button>
    <button><a href="./profile.php">edit profile</a></button>
    <div class="container">

    <?php foreach ($communities as $community): ?>
        <?php
        
        $description = htmlspecialchars($community['description']);
        $limitedd = mb_substr($description, 0, 170); // Limit to 170 characters meken 0 to 170 characters
        if (mb_strlen($description) > 170) {
            $limitedd .= '...'; // if it has more than 270 char print ... a the end
        }
        ?>
       
        
        <a href="../community/view.php?community_id=<?= htmlspecialchars($community['community_id']) ?>" class="community-card-alt">

         <div class="card-header" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
         <div class="card-body">     
         <h3 class="h33"><?= htmlspecialchars($community['name']) ?></h3>
                <p class="pp"><?= $limitedd ?></p>
            </div>
            <div class="card-header" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
        </a>
        <?php endforeach; ?>
    </div>
</body>
</html>

