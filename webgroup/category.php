<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('index.php');
}
include 'views/usernav.php';

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
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .h11 {
        text-align: center;

    }
    .grid-container {
        max-width: 1200px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px 40px;
        background: rgb(165, 196, 223);
        width: 99vw;
        padding-top: 30px;
        padding-bottom: 30px;
        margin: 0 auto;
    }
    @media (max-width: 600px) {
        .grid-container {
            flex-direction: row;
            justify-content: space-between;
        }
    }
    
    .community-card-alt {
        width: 320px;
        height: 200px;
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

    
    @media (max-width: 600px) {
        .community-card-alt {
            width: 160px; 
            height: 120px;
           
        }
        .grid-container {
            display: flex;
        flex-wrap: wrap;
        gap: auto; 
        margin: 0 auto;
        justify-content: center;
           
        }
        .card-body p {
            font-size: 0.9em;

        }
        .card-header {
            height: 30px;
        }
        .h11{
        font-size: 23px;
    }
    }
    </style>
</head>
<body>
    <h1 class="h11">Categories</h1>
    <div class="grid-container">
        <?php foreach ($categories as $category): ?>
            <!-- <a href="community.php?category_id=<//?= base64_encode($category['category_id']) ?>" class="community-card-alt"> -->
            <a href="community.php?category_id=<?= $category['category_id'] ?>&category_name=<?=urlencode($category['name']) ?>" class="community-card-alt">
                
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
