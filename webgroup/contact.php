<?php
include("navbar.html");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <style>
    .hero-section {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      background-color: white;
      position: relative;
      flex-direction: column;
    }

    .hero-text {
      font-size: 3.5rem;
      font-family: Arial, sans-serif;
      text-align: center;
      margin-bottom: 20px;
      font-size: 3rem;
      margin-bottom: 10px;
      color: #296b8e;
      /* Blue */
    }

    .hero-image {
      max-width: 300px;
    }

    .hero-image img {
      width: 100%;
      border-radius: 10px;
    }

    .contact-options {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin: 20px;
    }

    .contact-option {
      background-color: #f0d78c;
      /* Soft yellow */
      padding: 20px;
      border-radius: 8px;
      width: 300px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .contact-option .icon {
      font-size: 40px;
      margin-bottom: 10px;
    }

    .contact-option h2 {
      margin-bottom: 10px;
      font-size: 20px;
    }

    .contact-option p {
      margin-bottom: 15px;
    }

    .contact-option a {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }

    .contact-option a:hover {
      text-decoration: underline;
    }

    @media (max-width: 600px) {
      .hero-section {
        padding: 10px;
      }

      .hero-text {
        font-size: 2rem;
      }

      .contact-option {
        width: 100%;
      }
    }

    @media (max-width: 576px) {
      .contact-option {
        font-size: 10px;
        width: calc(50% - 10px);
        /* Adjusted to allow two cards per row with a small gap */
        box-sizing: border-box;
      }
      .contact-option a{
        font-size: 9px
      }
    }

    @import url('https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(90deg, #F8F8F8 0%, #F8F8F8 30%, #F8F8F8 30%, #90d076 100%) !important;
    }

    .contactUs {
      position: relative;
      width: 100%;
      padding: 20px 60px;
      /* Reduced padding for smaller height */
    }

    .contactUs .title {
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 2em;
      /* Slightly smaller font */
      margin-bottom: 10px;
      /* Reduce space below the title */
    }

    .contactUs .title h2 {
      color: #fff;
      font-weight: 500;
    }

    .box {
      position: relative;
      display: grid;
      grid-template-columns: 2fr 1fr;
      grid-template-rows: 4fr 3fr;
      /* Reduced height for rows */
      grid-template-areas:
        "form info"
        "form map";
      grid-gap: 15px;
      /* Smaller gap between sections */
      margin-top: 20px;
      /* Adjusted margin */
    }

    .form,
    .info,
    .map {
      padding: 20px;
      /* Reduced padding */
      border-radius: 10px;
    }

    .contact {
      background: #fff;
    }

    .contact h3 {
      color: #0d3b66;
      /* Deep blue */
      font-weight: 500;
      font-size: 1.4em;
      /* Slightly smaller text */
      margin-bottom: 10px;
    }

    /* Form styling */
    .formBox {
      position: relative;
      width: 100%;
    }

    .formBox .row50 {
      display: flex;
      gap: 15px;
      /* Reduced gap */
    }

    .inputBox {
      display: flex;
      flex-direction: column;
      margin-bottom: 10px;
      width: 50%;
    }

    .formBox .row100 .inputBox {
      width: 100%;
    }

    .inputBox span {
      color: #296b8e;
      /* Blue */
      margin-top: 5px;
      /* Reduced spacing */
      margin-bottom: 3px;
      font-weight: 500;
      font-size: 1em;
    }

    .inputBox input {
      padding: 8px;
      /* Reduced padding */
      font-size: 1em;
      /* Smaller font size */
      outline: none;
      border: 1px solid #333;
      border-radius: 5px;
    }

    .inputBox textarea {
      padding: 8px;
      font-size: 1em;
      outline: none;
      border: 1px solid #333;
      border-radius: 5px;
      resize: none;
      min-height: 150px;
      /* Reduced height */
      margin-bottom: 10px;
    }

    .inputBox input[type="submit"] {
      background: #53aa43;
      /* Green */
      color: #fff;
      border: none;
      font-size: 1em;
      max-width: 120px;
      font-weight: 500;
      cursor: pointer;
      padding: 10px 12px;
      /* Reduced button size */
      border-radius: 5px;
    }

    .inputBox ::placeholder {
      color: #999;
    }

    /* Info Section */
    .info {
      background: #0d3b66;
      /* Deep blue */
      padding: 20px;
    }

    .info h3 {
      color: black !important;
      font-size: 1.4em;
      /* Slightly smaller headers */
      margin-bottom: 15px;
    }

    .info .infoBox div {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      /* Reduced spacing */
    }

    .info .infoBox div span {
      min-width: 40px;
      /* Smaller icons */
      height: 40px;
      color: #fff;
      background: #53aa43;
      /* Green */
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.4em;
      border-radius: 50%;
      margin-right: 15px;
    }

    .info .infoBox div p {
      color: black !important;
      font-size: 1em;
      /* Smaller text */
    }

    /* Map Section */
    .map {
      padding: 0;
    }

    .map iframe {
      width: 100%;
      height: 100%;
      border-radius: 10px;
    }

    /* Social Media Icons */
    .sci {
      margin-top: 30px;
      /* Reduced spacing */
      display: flex;
    }

    .sci li {
      list-style: none;
      margin-right: 10px;
    }

    .sci li a {
      color: #ccc;
      font-size: 1.5em;
      /* Smaller icons */
      transition: color 0.3s;
    }

    .sci li a:hover {
      color: #fff;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
      body {
        background: #03a9f5;
      }

      .contactUs {
        padding: 10px;
        /* Reduced padding */
      }

      .box {
        grid-template-columns: 1fr;
        grid-template-rows: auto;
        grid-template-areas:
          "form"
          "info"
          "map";
      }

      .map {
        min-height: 250px;
        /* Reduced height */
      }

      .formBox .row50 {
        display: flex;
        gap: 0;
        flex-direction: column;
      }

      .inputBox {
        display: flex;
        flex-direction: column;
        margin-bottom: 5px;
        width: 100%;
      }
    }
  </style>


  <!-- Hero Section -->
  <div class="hero-section">
    <div class="hero-text">Contact Us</div>
    <div class="hero-image">
      <img src="image9.avif" alt="Support Illustration">
    </div>
  </div>

  <!-- Contact Options -->
  <div class="contact-options">
    <div class="contact-option">
      <div class="icon">📧</div>
      <h2>Usability Issues</h2>
      <p>If you encounter issues like poor accessibility or unclear instructions, email us at:</p>
      <a href="mailto:usabilityissues@gmail.com">usabilityissues@gmail.com</a>
    </div>

    <div class="contact-option">
      <div class="icon">📧</div>
      <h2>Technical Errors</h2>
      <p>Report technical bugs or system malfunctions to:</p>
      <a href="mailto:technicalerrors@gmail.com">technicalerrors@gmail.com</a>
    </div>

    <div class="contact-option">
      <div class="icon">📧</div>
      <h2>Functional Errors</h2>
      <p>For issues with features not working as expected, contact:</p>
      <a href="mailto:functionalerrors@gmail.com">functionalerrors@gmail.com</a>
    </div>
  </div>

  <div class="contact-options">
    <div class="contact-option">
      <div class="icon">📧</div>
      <h2>User Account Problems</h2>
      <p>Need help with account-related issues? Email us:</p>
      <a href="mailto:useraccissues@gmail.com">useraccissues@gmail.com</a>
    </div>

    <div class="contact-option">
      <div class="icon">📧</div>
      <h2>Community Features Failures</h2>
      <p>For issues with community tools, reach out to:</p>
      <a href="mailto:communityissues@gmail.com">communityissues@gmail.com</a>
    </div>

    <div class="contact-option">
      <div class="icon">📧</div>
      <h2>Integration Problems</h2>
      <p>Having trouble with third-party integrations? Email:</p>
      <a href="mailto:thirdpartyissues@gmail.com">thirdpartyissues@gmail.com</a>
    </div>
  </div>

  <div class="contactUs">
    <div class="title">
      <h2> Get in Touch</h2>
    </div>
    <div class="box">
      <!-- Form -->
      <div class="contact form">
        <h3>Send a message</h3>
        <form>
          <div class="formBox">
            <div class="row50">
              <div class="inputBox">
                <span>First name</span>
                <input type="text">
              </div>
              <div class="inputBox">
                <span>Last name</span>
                <input type="text" placeholder="Enter the last name">
              </div>
            </div>

            <div class="row50">
              <div class="inputBox">
                <span>Email</span>
                <input type="text" placeholder="Enter the email">
              </div>
              <div class="inputBox">
                <span>Mobile</span>
                <input type="text" placeholder="Enter the mobile number">
              </div>
            </div>

            <div class="row100">
              <div class="inputBox">
                <span>Message</span>
                <textarea placeholder="Write your message here..."></textarea>
              </div>
            </div>

            <div class="row100">
              <div class="inputBox">
                <span>Send</span>
                <input type="submit" value="Send">
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Info Box -->
      <div class="contact info">
        <h3>Contact Info</h3>
        <div class="infoBox">
          <div>
            <span><ion-icon name="location"></ion-icon></span>
            <p>Cinnamon garden, Colombo 07<br> Sri Lanka</p>
          </div>
          <div>
            <span><ion-icon name="mail"></ion-icon></span>
            <a href="mailto:studyhub@email.com">studyhub@email.com</a>
          </div>
          <div>
            <span><ion-icon name="call"></ion-icon></span>
            <a href="tel:+9407765467">+9407765467</a>
          </div>

          <!-- Social Media Links -->
          <ul class="sci">
            <li><a href="#"><ion-icon name="logo-facebook"></ion-icon></a></li>
            <li><a href="#"><ion-icon name="logo-twitter"></ion-icon></a></li>
            <li><a href="#"><ion-icon name="logo-linkedin"></ion-icon></a></li>
            <li><a href="#"><ion-icon name="logo-instagram"></ion-icon></a></li>
          </ul>
        </div>
      </div>

      <!-- Map -->
      <div class="contact map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.481375056299!2d79.85604919392105!3d6.906103939491147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259706bfa613f%3A0xf79d7adae85305f7!2sCinnamon%20Gardens%2C%20Colombo!5e0!3m2!1sen!2slk!4v1735411581779!5m2!1sen!2slk"
          width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  </body>

</html>
<?php
include("footer.html");
?>