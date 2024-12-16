<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php'; 

if (!isLoggedIn()) {
    redirect('../../index.php');
}



// Get the user's ID from the session
$userId = $_SESSION['user_id'];

// Fetch user details
try {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :id');
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception('User not found.it can"t be happen');
    }
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

// Handle form submission to update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
 
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    
    $discription = trim($_POST['description']);

    // Validate inputs
    if (empty($name) || empty($email)) {
        $error = 'Name and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        
        try {
            $updateStmt = $pdo->prepare('UPDATE users SET name = :name, email = :email, age = :age, gender = :gender, discription = :discription WHERE id = :id');
            $updateStmt->execute([
                'name' => $name,
                'email' => $email,
                'age' => $age,
                'gender' => $gender,
                'discription' => $discription,
                'id' => $userId
            ]);
            $success = 'Profile updated successfully.';
        } catch (Exception $e) {
            $error = 'Error updating profile: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['username']; ?> - Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
       
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
       }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
        }
        .success {
            background: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
<div class="profile-container">
    <h1>Edit Profile</h1>

    <?php if (isset($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

    
        <div class="form-group">
            <label for="age">Age</label>
            <input type="text" id="age" name="age" value="<?= htmlspecialchars($user['age']) ?>" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <input type="select" id="gender" name="gender" value="<?= htmlspecialchars($user['gender']) ?>" required>

        </div>
        <div class="form-group">
            <label for="discription">Discription</label>
            <textarea id="discription" name="discription" required><?= htmlspecialchars($user['discription']) ?></textarea>
        </div>

        <button type="submit">Update Profile</button>
    </form>
</div>
</body>
</html>
