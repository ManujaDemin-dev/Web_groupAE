<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_GET['category_id'];
    $color = $_POST['color'];

    // Start transaction to ensure both queries succeed together
    $pdo->beginTransaction();
  // for community user table 
    try {
        // Insert the new community into the communities table
        $query = "INSERT INTO communities (name, description, category_id, created_by, current_owner_id, color) 
                  VALUES (:name, :description, :category_id, :created_by, :current_owner_id, :color)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'category_id' => $category_id,
            'created_by' => $_SESSION['user_id'],
            'current_owner_id' => $_SESSION['user_id'],
            'color' => $color
        ]);

        // Get the ID of the newly created community
        $community_id = $pdo->lastInsertId();

        // Insert the creator into the community_members table
        $memberQuery = "INSERT INTO community_members (community_id, user_id, joined_at) 
                        VALUES (:community_id, :user_id, :joined_at)";
        $memberStmt = $pdo->prepare($memberQuery);
        $memberStmt->execute([
            'community_id' => $community_id,
            'user_id' => $_SESSION['user_id'],
            'joined_at' => date('Y-m-d H:i:s')
        ]);

        // Commit transaction
        $pdo->commit();

        // Redirect back to the category page
        // redirect("index.php?category_id=$category_id");
        redirect("view.php?community_id=$community_id");
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        $error = "Error creating community: " . $e->getMessage();
    }
}

include '../userhead.html';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Community</title>
</head>
<body>
    <h1>Create Community</h1>
    <form action="" method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br><br>
        <label>Description:</label>
        <textarea name="description" required></textarea><br><br>
        <label for="color">Select a main color for your Community:</label>
        <input type="color" id="color" name="color" value="#ff0000"><br><br>

        <button type="submit">Create</button>
    </form>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
</body>
</html>
