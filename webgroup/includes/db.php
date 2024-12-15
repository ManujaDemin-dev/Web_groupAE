<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=student_community_app', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection is failed: ' . $e->getMessage());
}
?>
