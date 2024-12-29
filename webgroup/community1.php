<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('index.php');
}


$category_id = base64_decode($_GET['category_id']);
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : ''; 


if ($searchTerm) {
    $query = "SELECT * FROM communities WHERE category_id = :category_id AND c_name LIKE :searchTerm";
    $params = [
        'category_id' => $category_id,
        'searchTerm' => "%$searchTerm%"
    ];
} else {
    $query = "SELECT * FROM communities WHERE category_id = :category_id";
    $params = ['category_id' => $category_id];
}

$statement = $pdo->prepare($query);
$statement->execute($params);
$communities = $statement->fetchAll(PDO::FETCH_ASSOC);

 error_log("Query executed: $query with params: " . print_r($params, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['community_id'])) {
    $community_id = $_POST['community_id'];
    $user_id = $_SESSION['user_id'];

    $checkQuery = "SELECT * FROM community_members WHERE community_id = :community_id AND user_id = :user_id";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute(['community_id' => $community_id, 'user_id' => $user_id]);

    if ($checkStmt->rowCount() === 0) {
        $insertQuery = "INSERT INTO community_members (community_id, user_id, joined_at) VALUES (:community_id, :user_id, now())";
        $insertStmt = $pdo->prepare($insertQuery);

        try {
            $insertStmt->execute(['community_id' => $community_id, 'user_id' => $user_id]);
            $message = "You have successfully joined the community!";
            header('Location: views/community/view.php?community_id=' . $community_id);
            exit;
        } catch (PDOException $e) {
            $message = "Error joining the community: " . $e->getMessage();
        }
    } else {
        $message = "You are already a member of this community!";
        header('Location: views/community/view.php?community_id=' . $community_id);
        exit;
    }
}

include 'views/userhead.html';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Communities</title>
</head>
<body>
    <h1>Communities</h1>

    <button><a href="category.php">Back to Categories</a></button>
    <button><a href="views/community/create.php?category_id=<?= $category_id ?>">Create a new community in this category</a></button>

    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

    <form method="GET" action="">
        <input type="hidden" name="category_id" value="<?= htmlspecialchars($category_id) ?>">
        <input class="input" type="text" name="search" placeholder="Search communities..." value="<?= htmlspecialchars($searchTerm) ?>">
        <button class="search" type="submit">Search</button>
    </form>

    <div class="container">
        <?php if (count($communities) > 0): ?>
            <?php foreach ($communities as $community): ?>
                <?php
                $description = htmlspecialchars($community['description']);
                $limitedd = mb_substr($description, 0, 120);
                if (mb_strlen($description) > 120) {
                    $limitedd .= '...';
                }
                ?>
                <div class="community-card-alt">
                    <div class="card-header" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
                    <div class="card-body">
                        <h3 class="h33"><?= htmlspecialchars($community['c_name']) ?></h3>
                        <p class="pp"><?= $limitedd ?></p>
                    </div>
                    <form method="POST" onsubmit="confirmJoin(event, this)">
                        <input type="hidden" name="community_id" value="<?= $community['community_id'] ?>">
                        <button class="join" type="submit">Join</button>
                    </form>
                    <div class="card-header" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No communities found.</p>
        <?php endif; ?>
    </div>

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
