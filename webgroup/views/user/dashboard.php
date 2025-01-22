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



include '../usernav.php'; // Navbar

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['username']; ?> 's Dashboard</title>
    <style>

body {
    /* font-family: Poppins; */
    background-color: #fff;
    margin: 0;
    padding: 0;
    
}

.dashboard {
    padding: 20px;
    color: #0d3b66;
    background-color: #fff;
    margin: 0 0px;
   
   
}

h1 {
    margin-bottom: 20px;
    text-align: center;
  
}

.welcome h2{
    font-size: 50px;
}

.welcome p{
    font-size: 24px;
    font-weight: 600;
}

.welcome h2, .welcome p{
    color: #fff;
    line-height: 10px;
}
/* .welcome h2 {
    font-size: 15px;
} */

/* Welcome Section */
.welcome {
    text-align: center;
    border:none;
    border-radius: 10px;
    background: url("table.jpg") no-repeat center center;
    background-size: cover;
    padding: 20px;
    margin-bottom: 20px;
    height: 200px;
    opacity: 0.8;
}

/* Flexbox Rows */
.row {
    display: flex;
    gap: 10px; /* Space between items */
    margin-bottom: 10px;
}

.feature{
    border-radius: 10px;
    border: none;
    background:linear-gradient(to right, #53aa43, #f0d78c);
    flex: 1; /* Make all items in a row equal width */
    height:80px;
    font-size: larger;
    text-align: center;
    color: hsl(0, 0%, 100%);
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    
}

.feature a{
    text-decoration: none;
    color: hsl(0, 0%, 100%);
    font-family: 'Poppins', sans-serif;
    font-size: 23px;
}


/* Search Box */
.search-bar{
    display: flex;
    gap: 10px;
    padding: 30px 0;
}
.search-bar h2{
    margin-top: 5px;
    margin-bottom: 10px;
    font-size: 25px;
}
.search {
    flex: 2;
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: center;
}

.search input {
    width: 60%;
    height: 35px;
    border: 2px solid #296b8e;
    border-radius: 10px;
    padding: 5px;
    font-size: 16px;
}
.search-button{
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

.search-button:hover{
    background-color: #0d3b66
}


    /*card-styling*/
            .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 0 auto;
            width: 95%; 
            max-width: 1250px;
            
            
        }

      
        .community-card-alt {
            max-width: 280px;
            height: 290px;
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
            text-decoration: none;
            color: black;
        }

        .community-card-alt:hover {
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.4);
        }

       
        .card-header {
           
            height: 25px;
        }

        .card-footer {
           
            height: 25px;
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
    margin: 0 auto;
    width: 98%;

}

.community-card-alt {
    height: 230px; 
   
}
 

.card-header {
           
           height: 12px;
       }

       .card-footer {
          
           height: 12px;
          
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

       .card-body {
           padding: 10px;
           text-align: center;
           flex-grow: 1;
       }

       .h33 {
           font-size: 1.2em;
           margin: 0;
           
       }

       .pp {
           margin-top: 10px;
           font-size: 1em;
       }
    
}

@media (max-width: 768px){
.welcome h2{
    font-size: 40px;
}
.welcome p{
    font-size: 18px;
    font-weight:500;
}
.welcome{
    height: 150px;
}
.feature{
    height: 70px;
    font-size: 30px;
}
.feature a{
    font-size: 20px;
}
.search-bar{
flex-direction: column;
}
.search{
width: 100%;
}
.search input{
width:80%;
height: 30px;
}
}

@media (max-width: 576px){
.welcome h2{
font-size: 35px;
}
.welcome p{
font-size: 16px;
line-height: 1.5;
}
.feature {
height: 70px;
font-size: 10px;
margin-bottom: 0px;
weight: 100;

}
.dashbord {
    padding: 5px;
}
.feature a{
font-size: 16px;
}
.search-bar h2{
    margin-top: 2px;
    margin-bottom: 10px;
    font-size: 20px;
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
    <button class="feature"><a href="./../../../Pomodoro Timer/pomodoro.html" target="_blank"> Pomodoro timer </a></button>
    <button class="feature"><a href="./music.php" target="_blank">Listen to music </a></button>
<?php   $role = $_SESSION['role'];
if ($role == 'admin') {
   
   echo'<button class="feature"><a href="../../admin/admin.php">Admin Panel</a></button>';   
}
?>
</div>

<div class="search-bar">
    <h2>Your Communities</h2>
    <form method="GET" action="" class="search">
            <input type="text" name="search" placeholder="Search communities" value="<?= htmlspecialchars($searchQuery) ?>">
            <button type="submit" class="search-button">Enter</button>
    </form>
</div>




<!--cards-->

<div class="container">
<?php if ($communities): ?>
<?php foreach ($communities as $community): ?>
<?php

$description = htmlspecialchars($community['description']);
$limitedd = mb_substr($description, 0, 170); // Limit to 170 characters meken 0 to 170 characters
if (mb_strlen($description) > 170) {
    $limitedd .= '...'; // if it has more than 270 char print ... a the end
}
?>

<a href="javascript:void(0);" class="community-card-alt" onclick="submitForm('<?= htmlspecialchars($community['community_id']) ?>', '<?= htmlspecialchars($community['color']) ?>');">
    <div class="card-header" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
    <div class="card-body">     
        <h3 class="h33"><?= htmlspecialchars($community['c_name']) ?></h3>
        <p class="pp"><?= $limitedd ?></p>
    </div>
    <div class="card-header" style="background-color: <?= htmlspecialchars($community['color']) ?>;"></div>
</a>

<!-- Hidden Form -->
<form id="communityForm" method="POST" action="../community/view.php" style="display: none;">
    <input type="hidden" name="community_id" id="community_id">
</form>

<script>
    function submitForm(communityId, color) {
        // Populate the hidden form with the necessary data
        document.getElementById('community_id').value = communityId;
        
        // Submit the form programmatically
        document.getElementById('communityForm').submit();
    }
</script>



<!--
<a  method="POST" href="../community/view.php?community_id=<//?= htmlspecialchars($community['community_id']) ?>" class="community-card-alt">
 < no form method="POST" action="../community/view.php">
<input type="hidden" name="community_id" value="<//?= $community['community_id'] ?>"> no 


 <div class="card-header" style="background-color: <//?= htmlspecialchars($community['color']) ?>;"></div>
 <div class="card-body">     
 <h3 class="h33">//?= htmlspecialchars($community['c_name']) ?></h3>
        <p class="pp"><//?= $limitedd ?></p>
    </div>
    <div class="card-header" style="background-color: <//?= htmlspecialchars($community['color']) ?>;"></div>
</a> -->
<?php endforeach; ?>
<?php else: ?>
    <p>No communities found 🥲</p>
<?php endif; ?>
</div>

</div>

</body>
</html>

