<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('index.php');
}

$category_id = $_GET['category_id'];
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : ''; // Get search term from query parameters


if ($searchTerm) {
    $query = "SELECT * FROM communities WHERE category_id = :category_id AND name LIKE :searchTerm";
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
    $joined_at = date('Y-m-d H:i:s');

    $checkQuery = "SELECT * FROM community_members WHERE community_id = :community_id AND user_id = :user_id";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute(['community_id' => $community_id, 'user_id' => $user_id]);

    if ($checkStmt->rowCount() === 0) {
        $insertQuery = "INSERT INTO community_members (community_id, user_id, joined_at) VALUES (:community_id, :user_id, :joined_at)";
        $insertStmt = $pdo->prepare($insertQuery);

        try {
            $insertStmt->execute([
                'community_id' => $community_id,
                'user_id' => $user_id,
                'joined_at' => $joined_at
            ]);
            $message = "You have successfully joined the community!";
            if (isset($message)) echo "<p class='message'>$message</p>"; 
           
            header('Location: views/community/view.php?community_id=' . $community_id);
        } catch (PDOException $e) {
            $message = "Error joining the community: " . $e->getMessage();
        }
    } else {
        $message = "You are already a member of this community!";

        header('Location: views/community/view.php?community_id=' . $community_id);
    }
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
        button {
            padding: 8px 12px;
        }
        .wrap {
            margin-bottom: 10px;
        }
        .join {
            padding: 5px 15px;
            border-radius: 15px;
            border: 4px solid black;
            color: black;
            background-color:rgb(223, 35, 113);
            text-decoration: bolt;
            cursor: pointer;

            
        }
        .join:hover {
            border: 4px solid rgb(223, 35, 113);
            color:black;
            background-color:rgb(223, 35, 113);
            

        }
    </style>
    
</head>
<body>
    <h1>Communities</h1>

    <button> <a href="category.php">Back to Categories</a></button>.............................................................................................................
    <button><a href="views/community/create.php?category_id=<?= $category_id ?>">Create a new community in this category</a></button><br>

    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

    
    <form method="GET" action="">
        <input  type="hidden" name="category_id" value="<?= htmlspecialchars($category_id) ?>">
        <input class= "input" type="text" name="search" placeholder="Search communities..." value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit">Search</button>
    </form>

    <ul>
        <?php if (count($communities) > 0): ?>
            <?php foreach ($communities as $community): ?>


            <div class="card"  methna card ekka>
                <h3><?= htmlspecialchars($community['name']) ?></h3>
                <p><?= htmlspecialchars($community['description']) ?></p>
                <div class ="wrap">
                <form method="POST" onsubmit="confirmJoin(event, this)">
                    <input type="hidden" name="community_id" value="<?= $community['community_id'] ?>">
                    <button class="join"type="submit">Join</button></div>
                </form>
            </div>

            
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
