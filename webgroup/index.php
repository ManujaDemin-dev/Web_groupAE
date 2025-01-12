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
            &nbsp; &nbsp; WELCOME TO <br>
            <p class="titleDesName"> &nbsp; &nbsp; Skill<span class="desname">Up</span></p>
        </div>
        <div class="title-details">
            <p>Join A Community, Ignite Your Learning Journey</p>
            <p>Discover a vibrant platform where students connect, collaborate, and grow together. Engage with like-minded peers and unlock your potential through shared knowledge and experiences.</p>
        </div>
        <div class="join-button-container">
            <button class="join-button">Join Now</button>
        </div>
    </div>

    <head>
        <style>
            .all-c {
                font-family: poppins;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .container {
                display: flex;
                max-width: 1200px;
                background-color: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                overflow: hidden;
            }

            .content {
                padding: 40px;
                flex: 1;
            }

            .content h1 {
                font-size: 2rem;
                margin-bottom: 20px;
            }

            .content p {
                font-size: 1rem;
                margin-bottom: 20px;
                color: #555;
                line-height: 1.6;
            }

            .sections {
                display: flex;
                gap: 20px;
                margin-bottom: 20px;
            }

            .section {
                flex: 1;
            }

            .section h2 {
                font-size: 1.2rem;
                margin-bottom: 10px;
            }

            .section p {
                font-size: 0.9rem;
                color: #666;
            }

            .buttons {
                display: flex;
                gap: 10px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 1rem;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                background: linear-gradient(45deg, #90D076, #F0D78C);
                transition: background 0.3s ease, transform 0.2s ease;
            }

            .btn:hover {
                background: linear-gradient(45deg, #75b060, #d7bc74);
                transform: scale(1.05);
            }

            .image-placeholder {
                flex: 1;
                background-color: #e0e0e0;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .image-placeholder img {
                max-width: 100%;
                max-height: 100%;
                object-fit: cover;
            }
        </style>
    </head>

    <body>
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
                    <img src="placeholder.png" alt="Placeholder image" />
                </div>
            </div>
        </div>

        <?php
        include("comment.html");
        ?>
    </body>

    </html>

    <?php
    include("footer.html");
    ?>