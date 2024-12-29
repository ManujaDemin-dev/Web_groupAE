<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

$role = $_SESSION['role'];

if ($role == 'user') {
    redirect('//google.com');
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?></p>
    <p><a href="manageusers.php">Manage Users</a></p>
    <p><a href="managecommunitie.php">Manage Community</a></p>
    
</body>
</html>