<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}


$community_id = $_POST['community_id'];



$query = "SELECT * FROM communities WHERE community_id = :community_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['community_id' => $community_id]);
$community = $stmt->fetch(PDO::FETCH_ASSOC);

if ($community['current_owner_id'] != $_SESSION['user_id']) {
    redirect('../user/logout.php');
}

$updateowner = "UPDATE communities SET current_owner_id = :new_owner_id WHERE community_id = :community_id";
$stmt = $pdo->prepare($updateowner);
$stmt->execute([
    'new_owner_id' => $_POST['new_owner_id'],
    'community_id' => $community_id
]);

?>