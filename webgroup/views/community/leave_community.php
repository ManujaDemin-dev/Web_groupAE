<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

$user_id = $_SESSION['user_id'];
$community_id = $_POST['community_id'];


$query = "SELECT * FROM community_members WHERE user_id = :user_id AND community_id = :community_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id, 'community_id' => $community_id]);

if ($stmt->rowCount() > 0) {

    $deleteQuery = "DELETE FROM community_members WHERE user_id = :user_id AND community_id = :community_id";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->execute(['user_id' => $user_id, 'community_id' => $community_id]);

   
} else {
   
}
   

redirect("../user/dashboard.php"); 
?>
