<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

// if (!isLoggedIn()) {
//     redirect('\Web_groupAE\webgroup\views\auth\login.php');
// }
if (isLoggedIn()) {

} else {
    redirect('\Web_groupAE\webgroup\index.php');
}

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';


$query = "SELECT * FROM community_members 
          JOIN communities ON community_members.community_id = communities.community_id 
          WHERE community_members.user_id = :user_id";


if ($searchQuery) {
    $query .= " AND communities.c_name LIKE :searchQuery";
}

$statement = $pdo->prepare($query);
$params = ['user_id' => $_SESSION['user_id']];

if ($searchQuery) {
    $params['searchQuery'] = '%' . $searchQuery . '%';
}

$statement->execute($params);
$communities = $statement->fetchAll(PDO::FETCH_ASSOC);





// $statement = $pdo->prepare($query);
// $statement->execute(['user_id' => $_SESSION['user_id']]);
// $communities = $statement->fetchAll(PDO::FETCH_ASSOC);



include '../userhead.html'; // Navbar

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['username']; ?>'s Dashboard</title>
    <style>
        body {
            background-color: #fff;
            margin: 0;
            padding: 0;
            margin-top: 70px;
            font-family: Arial, sans-serif;
        }

        .dashboard {
            padding: 20px;
            color: #0d3b66;
            background-color: #fff;
            margin: 0 10px;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        .welcome h2 {
            font-size: 50px;
        }

        .welcome p {
            font-size: 24px;
            font-weight: 600;
        }

        .welcome h2,
        .welcome p {
            color: #fff;
            line-height: 10px;
        }

        .welcome {
            text-align: center;
            border: none;
            border-radius: 10px;
            background: url("table.jpg") no-repeat center center;
            background-size: cover;
            padding: 20px;
            margin-bottom: 20px;
            height: 200px;
            opacity: 0.8;
        }

        .row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
            text-align: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .feature {
            width: 150px;
            border-radius: 10px;
            background: linear-gradient(to right, #53aa43, #f0d78c);
            height: 100px;
            font-size: 16px;
            color: hsl(0, 0%, 100%);
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .edit {
            text-decoration: none;
            color: hsl(0, 0%, 100%);
            font-size: 16px;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            padding: 30px 0;
            flex-wrap: wrap;
        }

        .search-bar h2 {
            margin-top: 10px;
            font-size: 25px;
        }

        .search {
            display: flex;
            gap: 10px;
            flex: 2;
            justify-content: space-between;
        }

        .search input {
            width: 100%;
            max-width: 250px;
            height: 30px;
            border: 2px solid #296b8e;
            border-radius: 10px;
            padding: 5px;
            font-size: 16px;
        }

        .search-button {
            padding: 10px;
            border-radius: 10px;
            background-color: #296b8e;
            border: none;
            width: 100px;
            height: 40px;
            align-items: center;
            color: #fff;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #0d3b66;
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
            text-decoration: none;
            color: black;
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

        /* Responsive Styles */
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
                align-items: stretch;
            }

            .feature {
                width: 100%;
                font-size: 14px;
            }

            .search-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .search input {
                width: 100%;
                max-width: 300px;
            }

            .container {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .community-card-alt {
                height: 250px;
            }

            .welcome p {
                font-size: 19px;
                font-weight: 400;
                line-height: 25px;
            }

            .feature a {
                font-size: 19px;
            }
        }

        @media (max-width: 600px) {
            .feature {
                font-size: 14px;
            }

            .container {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .community-card-alt {
                height: 230px;
            }

            .welcome p {
                font-size: 16px;
                font-weight: 400;
                line-height: 20px;
            }

            .search input {
                max-width: 100%;
            }

            .search-button {
                width: 100%;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">

        <h1>Dashboard</h1>
        <div class="welcome">
            <h2>Welcome</h2>
            <p>Hey <?php echo $_SESSION['username']; ?>, Nice to have you on board!</p>
        </div>

        <div class="row">
            <a href="./../../../Pomodoro Timer/pomodoro.html" target="_blank" class="edit"><button
                    class="feature">Pomodoro timer</button></a>
            <a href="./music.php" target="_blank" class="edit"><button class="feature">Listen to music</button></a>
            <?php if ($_SESSION['role'] == 'admin') { ?>
                <a href="../../admin/admin.php" class="edit"><button class="feature">Admin Panel</button></a>
            <?php } ?>
        </div>

        <div class="search-bar">
            <h2>Your Communities</h2>
            <form method="GET" action="">
                <div class="search">
                    <input type="text" name="search" placeholder="Search communities"
                        value="<?= htmlspecialchars($searchQuery) ?>">
                    <button type="submit" class="search-button">Enter</button>
                </div>
            </form>
        </div>

        <div class="container">
            <?php if ($communities): ?>
                <?php foreach ($communities as $community): ?>
                    <?php
                    $description = htmlspecialchars($community['description']);
                    $limitedd = mb_substr($description, 0, 170);
                    if (mb_strlen($description) > 170) {
                        $limitedd .= '...';
                    }
                    ?>
                    <a href="javascript:void(0);" class="community-card-alt"
                        onclick="submitForm('<?= htmlspecialchars($community['community_id']) ?>', '<?= htmlspecialchars($community['color']) ?>');">
                        <div class="card-header" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
                        <div class="card-body">
                            <h3 class="h33"><?= htmlspecialchars($community['c_name']) ?></h3>
                            <p class="pp"><?= $limitedd ?></p>
                        </div>
                        <div class="card-footer" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
                    </a>

                    <form id="communityForm" method="POST" action="../community/view.php" style="display: none;">
                        <input type="hidden" name="community_id" id="community_id">
                    </form>

                    <script>
                        function submitForm(communityId, color) {
                            document.getElementById('community_id').value = communityId;
                            document.getElementById('communityForm').submit();
                        }
                    </script>

                <?php endforeach; ?>
            <?php else: ?>
                <p>No communities found 🥲</p>
            <?php endif; ?>
        </div>

    </div>
</body>

</html>