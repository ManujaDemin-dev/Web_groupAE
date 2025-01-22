<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    header ('../../index.php');
}

include '../usernav.php';

$community_id = $_POST['community_id'];


$delquery = "DELETE FROM communities WHERE community_id = :community_id";
$deleteStmt = $pdo->prepare($delquery);
    $deleteStmt->execute(['community_id' => $community_id]);
    echo '<script>window.location.href = "../user/dashboard.php";</script>';
exit;
