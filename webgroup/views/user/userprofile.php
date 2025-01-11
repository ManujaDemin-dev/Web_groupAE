<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

$username = $_SESSION['username'];
$User_id = $_SESSION['user_id'];


$thatuser = $_GET['name'];

echo"that user is: $thatuser";

$query = "SELECT * FROM users WHERE name = :thatuser";





?>