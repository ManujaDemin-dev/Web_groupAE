<?php

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');

        /* * {
            margin: 0;
            padding: 0;
        } */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            
            z-index: 50;
        }

        .custom-navbar {
            height: 60px;
            background-color: #0D3B66;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 80px;
        }

        .custom-navbar-links-container {
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .custom-navbar a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color:white;
            font-family: "Poppins", serif;
            font-weight: 600;
            font-style: normal;
            font-size: 18px;
            border-radius: 5px;
        }

        .custom-navbar a:hover {
            background-color: #53AA43;
        }

        .custom-navbar-home-link {
            margin-right: auto;
            font-size: 35px;
        }

        #custom-navbar-sidebar-active {
            display: none;
        }

        .custom-navbar-open-sidebar-button,
        .custom-navbar-close-sidebar-button {
            padding: 0 20px;
            display: none;
        }

        .custom-navbar-mob {
            display: none;
        }

        .custom-navbar-links {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .custom-navbar-item {
            list-style: none;
            margin-right: 25px;
        }

        .custom-navbar-item a {
            color: white;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s ease, background-color 0.3s ease;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .custom-navbar-item a:hover {
            color: white;
            background-color: #53AA43;
        }

        .custom-navbar-login {
            color: white;
            background-color: #0d3b66;
            padding: 6px;
            border: none;
            border-radius: 5px;
            font-family: "Poppins", serif;
            font-weight: 600;
            font-style: normal;
            font-size: 18px;
        }

        .custom-navbar-login:hover {
            color: black;
            background-color: #f0d78c;
        }

        @media (max-width: 760px) {
            .custom-navbar {
                padding: 0;
            }

            .custom-navbar-mob {
                display: block;
            }

            .custom-navbar-home-link {
                display: none;
            }

            .custom-navbar-links-container {
                flex-direction: column;
                align-items: flex-start;
                position: fixed;
                top: 0;
                right: -100%;
                z-index: 1000;
                width: 300px;
                background-color: #0D3B66;
                box-shadow: -5px 0 5px #0000006b;
                transition: 0.75s ease-out;
            }

            .custom-navbar a {
                box-sizing: border-box;
                height: auto;
                width: 100%;
                padding: 20px 30px;
                justify-content: flex-start;
                font-weight: bold;
            }

            .custom-navbar-open-sidebar-button,
            .custom-navbar-close-sidebar-button {
                display: block;
            }

            #custom-navbar-sidebar-active:checked ~ .custom-navbar-links-container {
                right: 0;
            }

            #custom-navbar-sidebar-active:checked ~ #custom-navbar-overlay {
                height: 100%;
                width: 100%;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 900;
            }

            .custom-navbar-links {
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .custom-navbar-item {
                width: 100%;
                justify-content: flex-start;
                font-weight: bold;
            }

            .custom-navbar-item a:hover {
                color: #0D3B66;
                background-color: #00000000;
            }

            .custom-navbar-login:hover {
                color: #0D3B66;
                background-color: #0d3b6600;
            }
        }
    </style>
</head>
<body>
    <nav class="custom-navbar">
        <a href="#" class="custom-navbar-mob">Navigate Menu</a>
        <input type="checkbox" id="custom-navbar-sidebar-active">
        <label for="custom-navbar-sidebar-active" class="custom-navbar-open-sidebar-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#000000">
                <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
            </svg>
        </label>

        <label id="custom-navbar-overlay" for="custom-navbar-sidebar-active"></label>
        <div class="custom-navbar-links-container">
            <label for="custom-navbar-sidebar-active" class="custom-navbar-close-sidebar-button">
                <svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#000000">
                    <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
                </svg>
            </label>
            <a href="index.php" class="custom-navbar-home-link">Navigate ></a>
            <ul class="custom-navbar-links">
                <li class="custom-navbar-item">
                    <a href="/Web_groupAE/webgroup/views/user/dashboard.php">Home</a>
                </li>
                <li class="custom-navbar-item">
                    <a href="/Web_groupAE/webgroup/category.php">Categories</a>
                </li>
                <li class="custom-navbar-item">
                    <a href="#">Any</a>
                </li>
                <li class="custom-navbar-item">
                   
                    <a href="/Web_groupAE/webgroup/views/user/userprofile.php?userid=<?= urlencode($user_id) ?>">Profile</a> 
                </li>
            </ul>
            <a href="/Web_groupAE/webgroup/views/user/logout.php">
                <button class="custom-navbar-login">Logout</button>
            </a>
        </div>
    </nav>
</body>
</html>
