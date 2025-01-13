<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';


if (!isLoggedIn()) {
    redirect('./../index.php');
}


$role = $_SESSION['role'];

if ($role == 'user') {
    redirect('//google.com');
    
}

include '../views/usernav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin pannel</title>
    <style>
        .navbtn{
            background-color: #0d3b66;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
           
            cursor: pointer;
        }
        
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['username'];?> to Admin Pannel </p>
    <a class="navbtn" href="manageusers.php">Manage Users</a>
    <a class="navbtn" href="managecommunitie.php">Manage Community</a>
    
</body>
</html>