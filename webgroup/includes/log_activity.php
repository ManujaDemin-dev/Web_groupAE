<?php

function logActivity($user_id, $action_type, $details) {
    global $pdo;

    $query = "INSERT INTO activity_logs (user_id, action_type, details) VALUES (:user_id, :action_type, :details)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'user_id' => $user_id,
        'action_type' => $action_type,
        'details' => $details
    ]);
}

?>
