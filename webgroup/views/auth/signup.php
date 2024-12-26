<?php
session_start();
include '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif ($age < 0 || $age > 30) {
        $error = "Please enter a valid age.";
    }

    if (!isset($error)) {
        $query = "INSERT INTO users (name, email, password, age, gender) VALUES (:name, :email, :password, :age, :gender)";
        $statement = $pdo->prepare($query);

        try {
            $statement->execute(['name' => $name, 'email' => $email, 'password' => $password, 'age' => $age, 'gender' => $gender]);
            header('Location: login.php');
            exit();
        } catch (PDOException $e) {
            $error = "Error creating account: " . $e->getMessage();
        }
    }
}
?>
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<body>
    <h1>Signup</h1>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br><br>
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <label>Age:</label>
        <input type="number" name="age" required><br><br>
        <label>Gender:</label>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br><br>
        <button type="submit">Signup</button>
    </form> -->



    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
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

        .signup-container input, 
        .signup-container select {
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
        <h2>Signup</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Enter Username" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Create Password" required>
            <input type="number" name="age" placeholder="Enter Your Age" required>
            <select name="gender" required>
                <option value="" disabled selected>Select Your Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <input type="checkbox" class="check-box" required><span>I agree to the terms and conditions.</span>

            <button type="submit">Signup</button>
        </form>

        <div class="login-help">
            <p>Already have an account? <button><a href="login.php">Login</a></button></p>
        </div>

    </div>


</body>
</html>




    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>