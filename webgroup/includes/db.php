<?php
try {
    $pdo = new PDO('mysql:host=bhwjsuparexjfjhzlg0z-mysql.services.clever-cloud.com;dbname=bhwjsuparexjfjhzlg0z', 'ucq7kw8qyrt5l7x1', 'qyhSw757dUINoaxn8pgN');

    //$pdo = new PDO('mysql:host=localhost;dbname=student_community_app', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection is failed: internet oni 😁😎' . $e->getMessage());
}
?>
