<?php
include("navbar.html");
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing page</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="all">
        <img src="./image/newbg.png" class="landing">

        <div class="con">
            <div class="slider">
                <div class="list">
                    <div class="item" style="--position: 1"><img src="./image/ART.png" alt=""></div>
                    <div class="item" style="--position: 2"><img src="./image/COM.png" alt=""></div>
                    <div class="item" style="--position: 3"><img src="./image/computing.png" alt=""></div>
                    <div class="item" style="--position: 4"><img src="./image/engineering.png" alt=""></div>
                    <div class="item" style="--position: 5"><img src="./image/SCIENCE.png" alt=""></div>
                    <div class="item" style="--position: 6"><img src="./image/study.png" alt=""></div>
                    <div class="item" style="--position: 7"><img src="./image/computing.png" alt=""></div>
                    <div class="item" style="--position: 8"><img src="./image/SCIENCE.png" alt=""></div>
                </div>
            </div>
        </div>
        <img src="./image/machnpoints.png" class="machn">
        <br>
    </div>
    <div class="title-container">
        <div class="title-description">
            <p class="welcome">
                WELCOME TO <br>
            </p>
            <p class="titleDesName">Focus<span class="desname">Net</span></p>
        </div>
        <div class="title-details">
            <p>Join A Community, Ignite Your Learning Journey</p>
            <p>Discover a vibrant platform where students connect, collaborate, and grow together. <br> Engage with like-minded peers and unlock your potential through shared knowledge and experiences.</p>
        </div>
        <div class="join-button-container">
            <a href="./views/auth/signup.php">
                <button class="join-button">Join Now</button>
            </a>
        </div>
    </div>
    
        <div class="all-c">

            <div class="container">
                <div class="content">
                    <h1>Join a Thriving Community of Learners</h1>
                    <p>
                        Experience the power of collaboration and knowledge sharing. Our platform offers a relaxed space for students to connect and grow together.
                    </p>
                    <div class="sections">
                        <div class="section">
                            <h2>Community Interaction</h2>
                            <p>Engage with peers and mentors to enhance your learning experience.</p>
                        </div>
                        <div class="section">
                            <h2>Learning Opportunities</h2>
                            <p>Access a wealth of resources tailored to your unique journey.</p>
                        </div>
                    </div>
                    <div class="buttons">
                        <!-- <button class="btn">Learn More</button>
                        <button class="btn">Sign Up</button> -->
                        <a href="./views/auth/signup.php"><button class="btn">Sign Up</button></a>
                        <a href="./aboutus.php"><button class="btn">Learn More</button></a>
                    </div>
                </div>
                <div class="image-placeholder">
                    <img src="./image/Thumbnails-3_aZkToGu.webp" alt="Placeholder image" />
                </div>
            </div>
        </div>
        <div class="Add">
            <p class="Add1">We want to create a fun, supportive environment where students can hang out, share 
                knowledge and stay motivated. By combining Pomodoro sessions, note sharing and music
                 driven productivity we want to help students learn, grow and connect with like minded people - 
                 all while having fun and being inspired.
            </p><br> <br>

            <p class="Add1">We see a global community of students united by a love of learning and personal growth. Through innovation,
                 collaboration and positive vibes we want to help every student achieve their academic goals,
                 build meaningful relationships and find the joy of learning, one study session at a time.</p>
        </div>
        <br><br>
        <?php
        include("comment.html");
        ?>
    </body>

    </html>

    <?php
    include("footer.html");
    ?>