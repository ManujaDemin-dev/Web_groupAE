<?php
session_start();
include '../../includes/db.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $email = trim($_POST['email']);
    $password = $_POST['password'];

   
    $query = "SELECT * FROM users WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->execute(['email' => $email]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];

        $_SESSION['username'] = $user['name'];


        $updateQuery = "UPDATE users SET last_login = NOW() WHERE user_id = :user_id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute(['user_id' => $user['user_id']]);

       
        session_regenerate_id();
        header('Location: ../user/dashboard.php');
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST"> 
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form><br>

    <div>
        <p>If you Do not have an account?</p><br> <button><a href="signup.php">Sign up</a></button>  <!-- text decoration none danna 
    </div> -->

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #a18cd1, #fbc2eb);
        }

        .signup-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            box-sizing: border-box;
        }

        .signup-container h2 {
            font-size: 26px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            position: relative;
        }

        

        .signup-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .signup-container input {
            width: 92%;
            padding: 13px;
            border: 1px solid black;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        

        .signup-container button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #53AA43;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .signup-container button:hover {
            background: #296b8e;
        }

        .signup-container p {
            font-size: 14px;
            color: #555;
        }

      

        .signup-container .login-help button {
            background: none;
            border: none;
            padding: 0;
            font-size: 14px;
            cursor: pointer;
        }

        .signup-container .login-help button a {
            text-decoration: none;
            color: #6a11cb;
            font-weight: bold;
        }

        .signup-container .login-help button:hover a {
            color: red;
        }

        @media (max-width: 480px) {
            .signup-container {
                padding: 20px;
            }

            .signup-container h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Login</h2>
        <form method="POST"> 
          
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Login</button>
        </form>

        <div class="login-help">
            <p>Don't have an account? <button><a href="signup.php">Sign up</a></button></p>
        </div>
    </div>
</body>
</html>



    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>