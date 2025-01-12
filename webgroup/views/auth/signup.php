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
    <link rel="stylesheet" href="signup.css">
</head>

<body>
    <div class="signup-container">
        <h2>Signup</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Enter Username" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <!-- Password field with eye icon toggle -->
            <div class="password-container">
                <input type="password" name="password" placeholder="Create Password" required id="password-input">
                <img src="hide (1).png" alt="Toggle Password" class="toggle-password" id="togglePassword">
            </div>
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
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password-input');

        togglePassword.addEventListener('click', () => {
            // Toggle password visibility
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle the eye icon image
            if (type === 'password') {
                togglePassword.src = 'hide (1).png'; // Show the "hide" image
            } else {
                togglePassword.src = 'view (2).png'; // Show the "show" image
            }
        });
    </script>


</body>

</html>




<?php if (isset($error))
    echo "<p>$error</p>"; ?>
</body>

</html>