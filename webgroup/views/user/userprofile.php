<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}
include './../usernav.php';


$username = $_SESSION['username'];
$User_myid = $_SESSION['user_id'];


$thatuserid = $_GET['user_id'];

echo"that user id  is: $thatuserid";

$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :id');
$stmt->execute(['id' => $thatuserid]);
$that_user = $stmt->fetch(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $that_user['name']; ?></title>
</head>
<body>
     
        <p>Name: <?php echo $that_user['name']; ?></p>
        <p>Email: <?php echo $that_user['email']; ?></p>
        <p>Gender: <?php echo $that_user['gender']; ?></p>
        description: <?php echo $that_user['description']; ?>   
        signuo date , age , gender ,mail
    
</body>
</html>


<?php
if($User_myid == $thatuserid){
echo"<a href='./profile.php'>Edit Profile</a>";

}
?>





