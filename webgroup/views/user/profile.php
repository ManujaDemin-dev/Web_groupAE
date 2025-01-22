<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}
include '../usernav.php';
$userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :id');
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    $password = trim($_POST['password']);
    $description = trim($_POST['description']);

        try {
            
            $updateFields = [
                'name' => $name,
                'email' => $email,
                'age' => $age,
                'gender' => $gender,
                'description' => $description ?: null, 
            ];

          
            if (!empty($password)) {
                $updateFields['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

           
            $setPart = [];
            foreach ($updateFields as $field => $value) {
                $setPart[] = "$field = :$field";
            }
            $setQuery = implode(', ', $setPart);

            $updateFields['id'] = $userId;

            $updateStmt = $pdo->prepare("UPDATE users SET $setQuery WHERE user_id = :id");
            $updateStmt->execute($updateFields);
            header('Location: ../user/logout.php');
            exit;

        } catch (Exception $e) {
            $error = 'Error updating profile ' . $e->getMessage();
        }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_SESSION['username']); ?>  Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            
            justify-content: center;
            align-items: center;
            height: 100vh;
           
        }
       
        
        .form-group {
            margin-bottom: 15px;
            text-align: center;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 50%;
            padding: 10px;
            border: 1px solid black;
            border-radius: 5px;
        }
        
    </style>
</head>
<body>

<p>you can any details if you want to change, if you don't want to change you can put same inputs.</p><br>
<div class="profile-container">
    <?php if (isset($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>


    <form method="POST" >
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
      
        <input type="password" id="password" name="password" placeholder="Leave blank if you don't want to change">
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="text" id="age" name="age" value="<?= htmlspecialchars($user['age']) ?>">
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <input type="text" id="gender" name="gender" value="<?= htmlspecialchars($user['gender']) ?>">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" maxlength="210"><?= htmlspecialchars($user['description'] ?? '') ?></textarea>
        </div>

        <button type="submit" id="buttonon">Update Profile</button>
    </form>
</div>

    <div>
        <form method="POST" action="./delete.php">
            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
            <button onclick="del()">Delete My Account</button>
        </form>
    </div>


<script>
        function del(){
            confirm("Are you sure want to DELETE your account?");
        }

</script>





</body>
</html>
