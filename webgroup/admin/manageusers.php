<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('./../index.php');
}


$role = $_SESSION['role'];

if ($role == 'user') {
    redirect('//google.com');
    
}


$query = "SELECT * FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_role'])) {
        $user_id = $_POST['user_id'];
        $role = $_POST['role'];

    
        $updateQuery = "UPDATE users SET role = :role WHERE user_id = :user_id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute(['role' => $role, 'user_id' => $user_id]);
        redirect('manageusers.php');
    } elseif (isset($_POST['delete_user'])) {
        $user_id = $_POST['user_id'];

        $deleteQuery = "DELETE FROM users WHERE user_id = :user_id";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute(['user_id' => $user_id]);
        redirect('manageusers.php');
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="./adminstyle1.css">
</head>
<body>
    <h1>Manage Users</h1>
    <a class="navbtn" href="manageusers.php">Manage Users</a>
    <a class="navbtn" href="managecommunitie.php">Manage Community</a>
    <a class="navbtn" href="admin.php">Admin Pannel</a>


    <table class="table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Last Login</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['user_id']) ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <form method="POST" style="display: inline-block;">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                        <select name="role">
                            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                        <button type="submit" name="update_role">Update</button>
                    </form>
                </td>
                <td><?= htmlspecialchars($user['last_login']) ?: 'Never logged in' ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display: inline-block;">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                        <button class="btdel" type="submit" name="delete_user">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
