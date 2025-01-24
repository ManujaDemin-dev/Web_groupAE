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
            //header('Location: ../user/logout.php');
            
        echo "<form id='redirectForm' method='GET' action='./logout.php'>
        <input type='hidden' name='community_id' value='" . htmlspecialchars($community_id) . "'>
    </form>
    <script>document.getElementById('redirectForm').submit();</script>";
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
    <title><?php echo htmlspecialchars($_SESSION['username']); ?> Profile</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .janathawa {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
            padding: 20px; /* Added padding for better layout on mobile */
        }

        .profile-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #75b060;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #d7bc74;
        }

        .message.error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }

        textarea {
            resize: none;
        }

        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .janathawa {
                padding: 10px;
            }

            .profile-container {
                padding: 15px;
                width: 100%; /* Ensure it takes full width on smaller devices */
            }

            input, textarea, select {
                font-size: 14px; /* Adjust font size for smaller screens */
                padding: 8px; /* Reduce padding for smaller elements */
            }

            button {
                font-size: 14px;
                padding: 8px;
            }

            label {
                font-size: 14px; /* Adjust label size */
            }
        }
    </style>
</head>
<body>
    <div class="janathawa">

        <p style="text-align: center; margin-bottom: 20px;">You can update your details below. If you don't want to change something, leave the field as it is.</p>

        <div class="profile-container">
            <?php if (isset($error)): ?>
                <div class="message error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Leave blank if you don't want to change">
                </div>

                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" value="<?= htmlspecialchars($user['age']) ?>" placeholder="Enter your age">
                </div>

                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender">
                        <option value="" disabled>Select your gender</option>
                        <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= $user['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" maxlength="210" placeholder="Tell us something about yourself...">
                        <?= htmlspecialchars($user['description'] ?? '') ?>
                    </textarea>
                </div>

                <button type="submit">Update Profile</button>
            </form>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <form id="deleteForm" method="POST" action="./delete.php">
                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                <button type="button1" style="background-color: #dc3545;" onclick="del()">Delete My Account</button>
            </form>
        </div>

        <script>
            function del() {
                const confirmation = confirm("Are you sure you want to delete your account?");
                if (confirmation) {
                    document.getElementById('deleteForm').submit();
                }
            }
        </script>
    </div>
</body>
</html>
