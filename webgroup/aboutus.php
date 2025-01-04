<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Better Platform</title>
    <style>
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        overflow-x: hidden;
        line-height: 1.5; /* Improved readability */
        scroll-behavior: smooth; /* Smooth scrolling */
    }

    /* Intro Section */
    .intro {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 30px 20px;
        background-color: #f6f6f6;
    }

    .intro .content {
        flex: 1 1 300px;
        max-width: 600px;
        text-align: center;
    }

    .intro .content h1 {
        font-size: 2.5em;
        color: #0D3B66;
        margin-bottom: 20px;
    }

    .intro .content p {
        font-size: 1.2em;
        color: #296B8E;
        margin-bottom: 30px;
    }

    .intro .content .btn {
        background-color: #53AA43;
        color: white;
        padding: 10px 20px;
        font-size: 1em;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
    }

    .intro .content .btn:hover,
    .intro .content .btn:focus {
        background-color: #90D076;
        outline: none; /* Accessibility enhancement */
    }

    .intro img {
        flex: 1 1 300px;
        max-width: 400px;
        width: 100%;
        height: auto;
    }

    /* Learn More Section */
    .learn-more {
        padding: 30px 20px;
        text-align: center;
    }

    .learn-more h2 {
        font-size: 2em;
        color: #0D3B66;
        margin-bottom: 10px;
    }

    .learn-more p {
        font-size: 1.2em;
        color: #296B8E;
        max-width: 800px;
        margin: 0 auto;
    }

    /* Features Section */
    .features {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 30px 20px;
    }

    .features img {
        max-width: 500px;
        width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .features h2 {
        font-size: 1.8em;
        color: #296B8E;
        margin-bottom: 20px;
    }

    .features p {
        font-size: 1.2em;
        color: #5a5858;
        max-width: 600px;
    }

    /* Container 2 Section */
    .container2 {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .container2 h2 {
        font-size: 3.5em;
        color: #0D3B66;
        margin-bottom: 50px;
        margin-top: 100px;
    }

    .cards {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        flex-wrap: wrap;
        margin-bottom: 100px;
    }

    .card {
        background: white;
        border: 5px solid transparent;
        border-radius: 20px;
        max-width: 300px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-image: linear-gradient(to right, #90D076, #296B8E) 1;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card p {
        font-size: 1.2em;
        color: #296B8E;
        margin: 10px 0;
    }

    .card img {
        height: auto;
        max-width: 200px;
        margin-top: 30px;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
        .intro {
            flex-direction: column;
            padding: 20px;
        }

        .intro .content h1 {
            font-size: 2em;
            line-height: 1.2;
        }

        .intro .content p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .intro img {
            max-width: 90%;
            margin-top: 20px;
        }

        .features img {
            margin-bottom: 10px;
        }

        .container2 h2 {
            font-size: 3em;
            text-align: center;
        }

        .cards {
            flex-direction: column;
            gap: 20px;
        }

        .card {
            max-width: 100%;
            margin: 0 auto;
        }
    }

    @media (max-width: 480px) {
        .intro .content h1 {
            font-size: 1.8em;
            line-height: 1.3;
        }

        .intro .content p {
            font-size: 1em;
            margin-bottom: 15px;
        }

        .btn {
            font-size: 0.9em;
            padding: 8px 16px;
        }

        .learn-more p {
            font-size: 1em;
        }

        .features h2 {
            font-size: 1.5em;
        }

        .features p {
            font-size: 1em;
        }

        .container2 h2 {
            font-size: 2.8em;
        }

        .card p {
            font-size: 1em;
        }

        .card img {
            max-width: 100%;
        }
    }
</style>
</head>
<body>
    <?php
        include("navbar.html");
    ?>
    <!-- Intro Section -->
    <div class="intro">
        <div class="content">
            <h1>STUDY BETTER WITH <br>MUSIC AND FRIENDS.</h1>
            <p>Our platform offers you a supportive and collaborative space to stay motivated and focused on studies while building a vibrant learning experience through communities.</p>
            <a href="#learn-more-section" class="btn">Learn More</a>
        </div>
        <img src="about/two.png" alt="Graduation Illustration">
    </div>

    <!-- Learn More Section -->
    <div id="learn-more-section" class="learn-more">
        <h2>Learn More About Our Platform</h2>
        <p>Our features include background study music, community collaboration, a Pomodoro timer to monitor your study hours and help you to stay productive and inspired.</p>
    </div>

    <!-- Fetaures Section 1 -->
    <div class="features">
        <img src="about/pile.jpg" alt="Join Communities">
        <h2>Join or Create Your Own Community</h2>
        <p>Connect with like-minded learners by joining existing communities or creating your own. Share knowledge, collaborate, and grow together in a supportive and engaging environment.</p>
    </div>

    <!-- Features Section 2 -->
    <div class="features">
        <img src="about/study.jpg" alt="Share Notes">
        <h2>Share Notes and Ideas</h2>
        <p>Share your notes and ideas effortlessly with others. Collaborate on study materials, exchange insights, and learn from diverse perspectives to make studying interactive and efficient.</p>
    </div>

    <!-- Features Section 3 -->
    <div class="features">
        <img src="about/clock.jpg" alt="Pomodoro Timer">
        <h2>Music and Timing with Pomodoro</h2>
        <p>Enhance your productivity by listening to music while using the Pomodoro technique to stay focused with timed intervals, boosting concentration and making study sessions effective.</p>
    </div>

<div class="container2">
<h2>What You Can Achieve</h2>
    <div class="cards">
            <div class="card">
                <p>Achieve your study goals faster with tools like Pomodoro timers, calming playlists, and a structured environment to minimize distractions and maximize efficiency.</p>
                <img src="about/target.jpg" alt="img1">
            </div>
            <div class="card">
                <p>Share notes, exchange ideas, and compete in friendly rankings with fellow learners, creating a sense of accountability and encouragement.</p>
                <img src="about/notepad.jpg" alt="img2" style="padding: 20px;">
            </div>
            <div class="card">
                <p>Track your study habits with our pomodoro timer to stay motivated and improve your consistency over time leading towards effective goal achievement.</p>
                <img src="about/stop.jpg" alt="img3" style="padding: 15px;">
            </div>
    </div>
</div>

<div class="intro" style="background-color: white;">
    <div class="content">
        <h1>TEAM WORK MADE THE DREAM WORK</h1>
        <p>So what are you waiting for? <br>Create an account to find your own community and get real time experience of these amazing features now!</p>
        <a href="./views/auth/signup.php" class="btn">Sign In</a>
    </div>
        <img src="about/team.jpg" alt="img4">

</div>

</body>
</html>
<?php
    include("footer.html");
    
?>
