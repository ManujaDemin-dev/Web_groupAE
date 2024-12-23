<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('\Web_groupAE\webgroup\views\auth\login.php');
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
}

$delete= "DELETE FROM users WHERE user_id = :user_id";
$statement = $pdo->prepare($delete);
$statement->execute(['user_id' => $user_id]);

redirect('\Web_groupAE\webgroup\.');

?>