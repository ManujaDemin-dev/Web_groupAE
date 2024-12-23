

<!DOCTYPE html>
<html>
<head>
    <title>web g</title>
</head>
<body>
    <?php
        include("header.html");
    ?>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
        }

        body {
            font-family: Arial, sans-serif;
            color: #0D3B66;
            background-color: rgb(247, 242, 237);
        }

        .main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px;
            gap: 20px;
        }

        .cen {
            flex: 1;
            text-align: left;
        }

        .cen h1 {
            font-size: 3.5em;
            color: #296B8E;
            margin-bottom: 20px;
            font-weight: bolder;
        }

        .cen p{
            font-size: 1.1em;
            font-weight: 500;
            
        }

        .button-group {
            margin-top: 20px;
        }

        .button {
            padding: 10px 20px;
            margin: 5px;
            font-size: 1em;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button.submit {
            background-color: #90D076;
            color: #ffffff;
        }

        .button.submit:hover {
            background-color: #53AA43;
        }

        .button.cancel {
            background-color: #F0D78C;
            color: #0D3B66;
        }

        .button.cancel:hover {
            background-color: #296B8E;
            color: #ffffff;
        }

        .image {
            flex: 1.5;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image img {
            max-width: 100%;
            height: auto;
    
            
        }

        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #296B8E;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="cen">
            <h1>Welcome to StudyHub</h1>
            <p>Expand your knowledge, explore endless possibilities</p>
            <div class="button-group">
                <button class="button submit">Submit</button>
                <button class="button cancel">Cancel</button>
            </div>
        </div>
        
        
        <div class="image">
            <img src="index-pic.png" alt="main-pic">
        </div>
    </div>

    <footer>
        &copy; 2024 Study Learning Platform
    </footer>
</body>
</html>

