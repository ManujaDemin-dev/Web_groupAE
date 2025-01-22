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
        <img src="newbg.png" class="landing">

        <div class="con">
            <div class="slider">
                <div class="list">
                    <div class="item" style="--position: 1"><img src="ART.png" alt=""></div>
                    <div class="item" style="--position: 2"><img src="COM.png" alt=""></div>
                    <div class="item" style="--position: 3"><img src="computing.png" alt=""></div>
                    <div class="item" style="--position: 4"><img src="engineering.png" alt=""></div>
                    <div class="item" style="--position: 5"><img src="SCIENCE.png" alt=""></div>
                    <div class="item" style="--position: 6"><img src="study.png" alt=""></div>
                    <div class="item" style="--position: 7"><img src="computing.png" alt=""></div>
                    <div class="item" style="--position: 8"><img src="SCIENCE.png" alt=""></div>
                </div>
            </div>
        </div>
        <img src="machnpoints.png" class="machn">
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
                        <button class="btn">Learn More</button>
                        <button class="btn">Sign Up</button>
                    </div>
                </div>
                <div class="image-placeholder">
                    <img src="Thumbnails-3_aZkToGu.webp" alt="Placeholder image" />
                </div>
            </div>
        </div>
        <div class="Add">
                    <h2>Add what you want</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit rerum asperiores atque illo delectus? 
                        Magni quam blanditiis repellat dolor, molestias suscipit quasi delectus explicabo, possimus aut 
                        quas recusandae, ex quae.
                    </p>
                </div>

        <?php
        include("comment.html");
        ?>
    </body>

    </html>

    <?php
    include("footer.html");
    ?>