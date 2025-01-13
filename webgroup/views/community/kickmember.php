<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

$community_id = $_POST['community_id'];
$member_to_kick = $_POST['member_to_kick'];


if (!$community_id || !$member_to_kick) {
    echo "Invalid request. Community ID and Member ID are required.";
    exit;
}

// Fetch community details
$query = "SELECT * FROM communities WHERE community_id = :community_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['community_id' => $community_id]);
$community = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$community) {
    echo "Community not found.";
    exit;
}

// Check if the current user is the community owner
if ($community['current_owner_id'] != $_SESSION['user_id']) {
    echo "You do not have permission to perform this action.";
    exit;
}

// Check if the member is part of the community
$memberQuery = "
    SELECT * FROM community_members 
    WHERE community_id = :community_id AND user_id = :user_id";
$memberStmt = $pdo->prepare($memberQuery);
$memberStmt->execute([
    'community_id' => $community_id,
    'user_id' => $member_to_kick
]);

if ($memberStmt->rowCount() === 0) {
    echo "The specified member is not part of this community.";
    exit;
}

// Remove the member from the community
$deleteQuery = "
    DELETE FROM community_members 
    WHERE community_id = :community_id AND user_id = :user_id";
$deleteStmt = $pdo->prepare($deleteQuery);
$deleteStmt->execute([
    'community_id' => $community_id,
    'user_id' => $member_to_kick
]);

echo "<p class='successmessage'>Member successfully removed from the community.</p>";
redirect('./editcommunity.php', ['community_id' => $community_id]);
?>
