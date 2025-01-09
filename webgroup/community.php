<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('index.php');
}


$category_id = $_GET['category_id'];
$category_name = $_GET['category_name'];
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : ''; 


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

include 'views/userhead.html';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Communities</title>
    <style>
        body {
            margin-top: 100px;
        }
        .message {
            color: green;
            font-weight: bold;
        }
        .input {
            padding: 8px;
            margin-bottom: 10px;
            width: 300px;
        }
       
           
        
        .wrap {
            margin-bottom: 10px;
            align-items: center;
            text-align: center;
        }
        .join {
            padding: 5px 15px;
            border-radius: 5px;
            border: 3px solid #0d3b66;
            color: black;
            background-color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 15px;

            
        }
        .join:hover {
            border: 3px solid #0d3b66;
            color: white;
            background-color:#0d3b66;
            

        } 

        .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
    <h1> <?= htmlspecialchars($category_name) ?> Communities</h1>

    <button> <a href="category.php">Back to Categories</a></button>.............................................................................................................
    <button><a href="views/community/create.php?category_id=<?= $category_id ?>">Create a new community in this category</a></button><br>

    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

    
    <form method="GET" action="">
        <input  type="hidden" name="category_id" value="<?= htmlspecialchars($category_id) ?>">
        <input class= "input" type="text" name="search" placeholder="Search communities..." value="<?= htmlspecialchars($searchTerm) ?>">
        <button class="search" type="submit">Search</button>
    </form>

    <div class="container">
        <?php if (count($communities) > 0): ?>
            <?php foreach ($communities as $community): ?>
        <?php
        $description = htmlspecialchars($community['description']);
        $limitedd = mb_substr($description, 0, 120); // Limit to 170 characters meken 0 to 170 characters
        if (mb_strlen($description) > 120) {
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
