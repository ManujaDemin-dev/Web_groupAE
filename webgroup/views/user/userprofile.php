<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

$username = $_SESSION['username'];
$friend = $_GET['user'];

$query = "SELECT * FROM users WHERE name = :friend";




?>