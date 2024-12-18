<?php 


session_start();
$_SESSION = [];

session_unset();
session_destroy();

redirect('Web_groupAE/webgroup/index.php');
exit();

?>