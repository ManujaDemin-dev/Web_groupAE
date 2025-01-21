<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('index.php');
}


$category_id = $_GET['category_id'];
$category_name = $_GET['category_name'];

if (isset($_GET['search'])) {
    $searchTerm = trim($_GET['search']); 
} else {
    $searchTerm = ''; 
}



if ($searchTerm) {
    $query = "SELECT * FROM communities WHERE category_id = :category_id AND c_name LIKE :searchTerm";
    $statement = $pdo->prepare($query);
    $statement->execute([
        'category_id' => $category_id,
        'searchTerm' => "%$searchTerm%"
    ]);
} else {
    $query = "SELECT * FROM communities WHERE category_id = :category_id";
    $statement = $pdo->prepare($query);
    $statement->execute(['category_id' => $category_id]);
}
$communities = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['community_id'])) {
    $community_id = $_POST['community_id'];
    $user_id = $_SESSION['user_id'];
    // $joined_at = date('Y-m-d H:i:s');

    $checkQuery = "SELECT * FROM community_members WHERE community_id = :community_id AND user_id = :user_id";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute(['community_id' => $community_id, 'user_id' => $user_id]);

    if ($checkStmt->rowCount() === 0) {
        $insertQuery = "INSERT INTO community_members (community_id, user_id, joined_at) VALUES (:community_id, :user_id, now())";
        $insertStmt = $pdo->prepare($insertQuery);

        try {
            $insertStmt->execute([
                'community_id' => $community_id,
                'user_id' => $user_id,
                // 'joined_at' => $joined_at
            ]);
             $message = "You have successfully joined the community!";
            // if (isset($message)) echo "<p class='message'>$message</p>"; 
            
            echo "<form id='redirectForm' method='POST' action='./views/community/view.php'>
            <input type='hidden' name='community_id' value='" . htmlspecialchars($community_id) . "'>
        </form>
        <script>document.getElementById('redirectForm').submit();</script>";
//   exit();
            
            //header('Location: views/community/view.php?community_id=' . $community_id);
        } catch (PDOException $e) {
            $message = "Error joining the community: " . $e->getMessage();
        }
    } else {
        $message = "You are already a member of this community!";
        

        echo "<form id='redirectForm' method='POST' action='./views/community/view.php'>
        <input type='hidden' name='community_id' value='" . htmlspecialchars($community_id) . "'>
    </form>
    <script>document.getElementById('redirectForm').submit();</script>";
    
    }

    $_SESSION['message'] = $message;
}

include 'views/usernav.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Communities</title>
    <style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
   
    
    
}

.containeris {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 20px 0;
    padding: 20px 0;
}

.buttons {
    display: flex;
    justify-content:space-between;
    align-items: center;
    width: 100%;
    box-sizing: border-box;    
    margin: 0 0;
   
}


.btn {
    background-color: #296b8e;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    width: 200px;
    margin: 20px 20px;
}

.btn:hover {
    background-color: #0d3b66;
}

.main-content {
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    margin: auto;
    height: 9vh;
    background-color: #90d076;
    width: 95%;

}

.main-content h1 {
    color: white;
    font-size: 30px;
}

.search-bar {
    display: flex;
    justify-content:space-between;
    gap: 10px;
    width: 60%;
   
}

.search-bar input {
    width: 100%;
    padding: 7px;
    border: 2px solid #296b8e;
    border-radius: 5px;
    margin: auto;
    font-size: 16px;
   
}

.search-bar .search-btn {
    background-color: #53aa43;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
   
}

.search-bar .search-btn:hover {
    background-color: #0d3b66;
}

#create-btn{
    background-color: rgb(159, 56, 76);
    text-decoration: none;
    padding: 10px 10px;

}



@media (max-width: 768px){
    .containeris{
        padding: 10px 0;
    }

    .main-content{
        height: auto;
        width: 90%;
    }

    .main-content h1{
        font-size: 25px;
    }

    .buttons{
        width: 100%;
        
    }

    .btn{
        font-size: 15px;
        padding: 10px;
    }

    .search-bar input{
        width: 60%;
        margin: 0 auto;
        padding: 4px;
    }

    .search-bar .search-btn{
        width: 30%;
        margin: 0 auto;
    }
}



@media (max-width: 480px) {
    .containeris {
        padding: 5px 0;
    }

    .main-content {
        height: auto;
        width: 85%;
    }

    .main-content h1 {
        font-size: 20px;
        line-height: 1.2;
    }

    .buttons {
        width: 100%;
        text-decoration: none;
    }

    .btn {
        font-size: 13px;
        padding: 5px 10px;
        width: 140px;
        margin: 13px 10px;
        text-decoration: none;

    }

    .search-bar input{
        width: 60%;
        font-size: 12px;
   

       
    }

    .search-bar .search-btn{
        width: 30%;
        padding: 8px 10px;
       
    }
    .search-bar{
        width: 85%;
       
    }
}





        /* body {
            margin: 0;
            padding: 0;
        } */
        .message {
            color: green;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        /* .input {
            padding: 8px;
            margin-bottom: 5px;
            width: 300px;
        } */
       
           
        
        .wrap {
            margin-bottom: 10px;
            align-items: center;
            text-align: center;
        }
        .join {
            padding: 5px 15px;
            border-radius: 5px;
            border: 2px solid #0d3b66;
            color: black;
            background-color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 15px;

            
        }
        .join:hover {
            border: 2px solid #0d3b66;
            color: white;
            background-color:#0d3b66;
            

        } 

        .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 0 auto;
            width: 96%; 
            max-width: 1250px;
        }

      
        .community-card-alt {
            max-width: 280px;
            height: 300px;
            border-radius: 12px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border: 2px solid black;
            display: flex;
            flex-direction: column;
            background: #fff;
            margin-bottom: 20px;
        }

        .community-card-alt:hover {
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.4);
        }

       
        .card-header {
           
            height: 22px;
        }

        .card-footer {
            
            height: 22px;
            margin-top: auto;
        }

        .card-body {
            padding: 12px;
            text-align: center;
            flex-grow: 1;
        }

        .h33 {
            font-size: 1.2em;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .pp {
            margin-top: 10px;
            font-family: 'Arial', sans-serif;
        }

        @media (max-width: 600px) {
    .container {
        grid-template-columns: repeat(2, 1fr); 
        gap: 9px; 
    }

    .community-card-alt {
        height: 235px; 
       

    }
    
    .card-header {
           
           height: 14px;
       }

       .card-footer {
          
           height: 14px;
          
       }

       .card-body {
           padding: 9px;
           text-align: center;
           flex-grow: 1;
       }

       .h33 {
           font-size: 0.8em;
           margin: 0;
           
       }

       .pp {
           margin-top: 5px;
           font-size: 0.8em;
       }
       .join {
        padding: 4px 7px;
        font-size: 12px;
       }
       .wrap {
        margin-bottom: 5px;
       }
        .community-card-alt {
            margin-bottom: 10px;
        }
}

    
@media (min-width: 701px) and (max-width: 1100px) {
    .container {
        grid-template-columns: repeat(3, 1fr);
    }
    .card-header {
           
           height: 17px;
       }

       .card-footer {
          
           height: 17px;
          
       }
       .community-card-alt {
        height: 260px; 
       
    }
       .card-body {
           padding: 10px;
           text-align: center;
       }
       .h33 {
           font-size: 1.1em;
           margin: 0;
           
       }
       .wrap {
        margin-bottom: 5px;
       }
       .pp {
           margin-top: 10px;
           font-size: 0.9em;
       }

       .join {
        padding: 5px 8px;
        font-size: 14px;
       }
    }
    </style>
    
</head>
<body>
<div class="containeris">
<div class="main-content">
    <h1> <?= htmlspecialchars($category_name) ?> Communities</h1>
    
    </div>

    <div class="buttons">
     <a id="btn" href="category.php">Back to Categories</a>
    <a class="btn" id="create-btn" href="views/community/create.php?category_id=<?= $category_id ?>">Create a new community in this category</a>
    </div>
    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

     <div class="search-bar">
    <form method="GET" action="">
        <input  type="hidden" name="category_id" value="<?= htmlspecialchars($category_id) ?>">
        <input type="hidden" name="category_name" value="<?= htmlspecialchars($category_name) ?>">
        <input class= "input" type="text" name="search" placeholder="Search communities..." value="<?= htmlspecialchars($searchTerm) ?>">
        <button class="search" type="submit">Search</button>
    </form>
    </div>
    </div>

    <div class="container">
        <?php if (count($communities) > 0): ?>
            <?php foreach ($communities as $community): ?>
        <?php
        $description = htmlspecialchars($community['description']);
        $limitedd = mb_substr($description, 0, 145); // Limit to 170 characters meken 0 to 170 characters
        if (mb_strlen($description) > 145) {
            $limitedd .= '...'; // if it has more than 270 char print ... a the end
        }
        ?>

        
        <card class="community-card-alt">

        <div class="card-header" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
        <div class="card-body">     
        <h3 class="h33"><?= htmlspecialchars($community['c_name']) ?></h3>
            <p class="pp"><?= $limitedd ?></p>
        </div>
        <div class ="wrap">
                <form method="POST" action="" onsubmit="confirmJoin(event, this)"> 
                    <input type="hidden" name="community_id" value="<?= $community['community_id'] ?>">
                    <button class="join"type="submit">Join</button></div>
                </form>
        <div class="card-header" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
    </card>



            
            <?php endforeach; ?>
        <?php else: ?>
            <li>No communities</li>
        <?php endif; ?>
    </ul>
    <script>
        function confirmJoin(event, form) {
            event.preventDefault(); 
            if (confirm("Are you sure you want to join this community?")) {
                form.submit(); 
            }
        }
    </script>
</body>
</html>
