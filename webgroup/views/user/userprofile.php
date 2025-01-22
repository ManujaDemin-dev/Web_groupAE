<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}
include './../usernav.php';


$username = $_SESSION['username'];
$User_myid = $_SESSION['user_id'];


$thatuserid = $_GET['userid'];

// echo"that user id  is: $thatuserid";

$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :id');
$stmt->execute(['id' => $thatuserid]);
$that_user = $stmt->fetch(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $that_user['name']; ?></title>
    <style>
        .con {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .subcon {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
            background-color:#ffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            margin-left: 10px;
        }

        .subcon p {
            font-size: 17px;
            margin: 10px 0;
          
            text-align: left;
            margin-left: 10px;
        }

        .subcon p:first-of-type {
            font-size: 18px;
            font-weight: bold;
            color: #222;
            
        }

        .subcon a {
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            color: #ffffff;
            background-color: rgb(171, 54, 54);
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        .subcon a:hover {
            background-color: #296b8e;
        }

        
        @media (max-width: 480px) {
            .subcon {
                padding: 20px;
            }

            .subcon p {
                font-size: 14px;
            }

            .subcon a {
                font-size: 12px;
                padding: 8px 15px;
            }
        }

    </style>
</head>
<body>
    
    <div class="con">
        
        <div class="subcon">
            <p> <?php echo $that_user['name']; ?></p>
            <p> <?php echo $that_user['email']; ?></p>
         
        
          <p>  <?php echo $that_user['description']; ?> </p>
            
            <p>Age  :-  <?php echo $that_user['age'] ?></p>  
            <p>Gender :-  <?php echo $that_user['gender'] ?></p>  
            <br>
            <p>Signup Date <?php echo $that_user['sign_up_date']; ?></p> 
            <p>Last login  <?php echo $that_user['last_login']; ?></p> 

            <?php
            if($User_myid == $thatuserid){
            echo"<a href='./profile.php'>Edit Profile</a>";

            }
            ?>

        </div>
    </div>
    
</body>
</html>






