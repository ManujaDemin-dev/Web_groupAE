<?php
include("navbar.html");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="all">
        <img src="newbg.png" class="landing" alt="Landing Background">
        <div class="con">
            <div class="slider">
                <div class="list">
                    <div class="item" style="--position: 1"><img src="ART.png" alt="Art"></div>
                    <div class="item" style="--position: 2"><img src="COM.png" alt="Commerce"></div>
                    <div class="item" style="--position: 3"><img src="computing.png" alt="Computing"></div>
                    <div class="item" style="--position: 4"><img src="engineering.png" alt="Engineering"></div>
                    <div class="item" style="--position: 5"><img src="SCIENCE.png" alt="Science"></div>
                    <div class="item" style="--position: 6"><img src="study.png" alt="Study"></div>
                    <div class="item" style="--position: 7"><img src="computing.png" alt="Computing"></div>
                    <div class="item" style="--position: 8"><img src="SCIENCE.png" alt="Science"></div>
                </div>
            </div>
        </div>
        <img src="machnpoints.png" class="machn" alt="Decorative Image">
    </div>
    <div class="titleHead">
        <div class="titleDes">
            <p>WELCOME TO</p>
            <p class="titleDesName">
                Skill<span class="desname">Up</span>
            </p>
        </div>
        <div class="titleAdds">
            <p>Join A Community, Ignite Your Learning Journey</p>
            <p class="titleAdds1">Discover a vibrant platform where students connect, collaborate, and grow together.
                Engage with like-minded peers and unlock your potential through shared knowledge and experiences.</p>
        </div>
        <div class="btnindex1">
            <button class="btnindex">Join Now</button>
        </div>
    </div>
    <div class="all-c">
        <div class="container">
            <div class="content">
                <h1>Join a Thriving Community of Learners</h1>
                <p>Experience the power of collaboration and knowledge sharing. Our platform offers a relaxed space for
                    students to connect and grow together.</p>
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
                <img src="placeholder.png" alt="Placeholder Image">
            </div>
        </div>
    </div>
    <?php include("comment.html"); ?>
    <?php include("footer.html"); ?>
</body>

</html>