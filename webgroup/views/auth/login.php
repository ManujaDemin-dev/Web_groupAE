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

    if (!$user) {
        header("Location: signup.php");
        exit;
    }


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
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>

<body>
    <div class="panda">
        <div class="ear"></div>
        <div class="face">
            <div class="eye-shade"></div>
            <div class="eye-white">
                <div class="eye-ball"></div>
            </div>
            <div class="eye-shade rgt"></div>
            <div class="eye-white rgt">
                <div class="eye-ball"></div>
            </div>
            <div class="nose"></div>
            <div class="mouth"></div>
        </div>
        <div class="body"></div>
        <div class="foot">
            <div class="finger"></div>
        </div>
        <div class="foot rgt">
            <div class="finger"></div>
        </div>
    </div>
    <form method="post">
        <div class="hand"></div>
        <div class="hand rgt"></div>
        <h1>Login</h1>
        <div class="form-group">
            <input type="email" required="required" class="form-control" name="email" id="email">
            <label for="username" class="form-label">Email</label>
        </div>
        <div class="form-group">
            <input type="password" required="required" class="form-control" name="password" id="password">
            <label for="username" class="form-label">Password</label>
            <img src="hide (1).png" alt="Toggle Password" class="toggle-password" id="togglePassword">
        </div>
        <div>
            <button class="btn" type="submit">Login</button>
        </div>

        
        <div class="login-help">
            <p >Don't have an account?</p> <button class="logindir"><a href="signup.php">Sign up</a></button>
        </div>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $('#password').focusin(function () {
            $('form').addClass('up')
        });
        $('#password').focusout(function () {
            $('form').removeClass('up')
        });

        //panda Eye Move
        $(document).on("mousemove", function (event) {
            var dw = $(document).width() / 15;
            var dh = $(document).height() / 15;
            var x = event.pageX / dw;
            var y = event.pageY / dh;
            $('.eye-ball').css({
                width: x,
                height: y
            });
        });

        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

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