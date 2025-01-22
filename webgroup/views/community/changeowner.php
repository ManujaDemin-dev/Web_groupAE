<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

$community_id = $_POST['community_id'];
$new_owner_id = $_POST['new_owner_id'];

$query = "SELECT * FROM communities WHERE community_id = :community_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['community_id' => $community_id]);
$community = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$community || $community['current_owner_id'] != $_SESSION['user_id']) {
    redirect('../user/logout.php'); 
}

$updateowner = "UPDATE communities SET current_owner_id = :new_owner_id WHERE community_id = :community_id";
$stmt = $pdo->prepare($updateowner);
$update_success = $stmt->execute([
    'new_owner_id' => $new_owner_id,
    'community_id' => $community_id
]);

if ($update_success) {
    
    echo "<form id='redirectForm' method='POST' action='./view.php'>
    <input type='hidden' name='community_id' value='" . htmlspecialchars($community_id) . "'>
    </form>
    <script>document.getElementById('redirectForm').submit();</script>";
} else {
    echo "Error updating the community owner. Please try again.";
}
?>
