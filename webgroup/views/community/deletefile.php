<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

$community_id = $_POST['community_id'];
$file_id = $_POST['file_id'];
//$file_path = $_POST['file_path'];
// echo '$file_path';
// if (file_exists($file_path)) {
  
//     if (unlink($file_path)) {
//         echo "File successfully deleted.";
//     } else {
//         echo "Error: Unable to delete the file.";
//     }
// } else {
//     echo "File does not exist.";
// }

$query = "DELETE FROM files WHERE file_id = :file_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['file_id' => $file_id]);

echo "<form id='redirectForm' method='POST' action='./view.php'>
        <input type='hidden' name='community_id' value='" . htmlspecialchars($community_id) . "'>
    </form>
    <script>document.getElementById('redirectForm').submit();</script>";

    
?>