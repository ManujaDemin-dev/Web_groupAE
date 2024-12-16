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
<!DOCTYPE html>
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
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>