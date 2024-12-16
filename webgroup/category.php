<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('index.php');
}
include 'views/userhead.html';

// Fetch all categories
$query = "SELECT * FROM categories";
$statement = $pdo->query($query);
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin-top: 100px;
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0;
        }
        .grid-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px 60px;
            background: rgb(165, 196, 223);
            width: 99vw;
            padding-top: 30px;
            padding-bottom: 30px;
        }
        @media (max-width: 600px) {
            .grid-container {
                flex-direction: column;
                align-items: center;
            }
        }
        .community-card-alt {
            width: 340px;
            height: 210px;
            display: block;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border: 3px solid black;
            font-family: Arial, Helvetica, sans-serif; 
            text-decoration: none;
            color: inherit;  
        }
        .community-card-alt:hover {
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.4);
        }
        .card-header {
            background: linear-gradient(135deg, #58c316, #44ff15);
            height: 60px;
        }
        .card-body {
            padding: 20px;
            text-align: center;
        }
        .card-body p {
            font-size: 1.3em;
            margin: 0;
        }
    </style>
</head>
<body>
    <h1>Categories</h1>
    <div class="grid-container">
        <?php foreach ($categories as $category): ?>
            
            <a href="community.php?category_id=<?= $category['category_id'] ?>" class="community-card-alt">
                <div class="card-header"></div>
                <div class="card-body">
                    <p><?= htmlspecialchars($category['name']) ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <p>Description about categories</p>
    <p>Footer</p>
</body>
</html>
