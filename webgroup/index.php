
<!DOCTYPE html>
<html>
<head>
    <title>web g</title>
  
</head>
<style>
           a{
            text-decoration: none;
           }
           
           .navbar{
            background-color: rgb(244, 255, 162);
            padding-left: 15px;
            padding-right: 15px;
           }

           .navdiv{
            display: flex;
            align-items: center;
            justify-content: space-between;
           }

           .logo a{
            font-size: 35px;
            font-weight: 600;
            color: rgb(0, 0, 0);
           }

           li{
            list-style: none;
            display: inline-block;
           }

           li a{
            color: rgb(0, 0, 0);
            font-size: 18px;
            font-weight: bold;
            margin-right: 25px;
           }

           button{
            background-color: orangered;
            margin-left: 10px;
            border-radius: 10px;
            padding: 10px;
            width: 90px;
           }

           button a{
            color: rgb(0, 0, 0);
            font-weight: bold;
            font-size: 18px;

           }

           .cen{
            max-width: fit-content;
            margin-left: auto;
            margin-right: auto;
            margin-top: 250px;
           }
        </style>
<body>
<nav class="navbar">
            <div class="navdiv">
                <div class="logo"><a href="#">LOGO</a></div>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <button><a href="views/auth/login.php">Login</a></button>
                </ul>
            </div>
        </nav>

        <div class="cen">
            <h1>THIS IS THE MAIN HOME PAGE</h1>
        </div>

</body>
</html>
<?php include 'includes/footer.php'; ?>
