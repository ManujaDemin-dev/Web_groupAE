<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    .container {
      padding: 20px;
      text-align: center;
    }

    .container h1 {
      font-size: 3rem;
      margin-bottom: 10px;
      color: #296B8E;
    }

    .container p {
      
      color: #555;
      font-size: 1.1em;
      font-weight: 500;
    }

    .contact-form {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .contact-image {
      flex: 1;
      text-align: center;
      padding: 20px;
    }

    .contact-image img {
      max-width: 50%;
      height: auto;
    }

    .form-container {
      flex: 1;
      padding: 50px;
      background-color: #F0D78C;
      border-radius: 60px;
      max-width: 400px;
      box-shadow: 50px 50px 60px rgba(0, 0, 0, 0.1);
    }

    .form-container input, .form-container textarea {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .form-container textarea {
      height: 100px;
    }

    .form-container button {
      width: 48%;
      padding: 10px;
      font-size: 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .form-container .cancel-btn {
      background-color: #90D076;
      color: #000;
    }

    .form-container .submit-btn {
      background-color: #90D076;
      color: #000;
    }

    .form-container button:hover {
      opacity: 0.9;
    }

    .contact-info {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .contact-info div {
      flex: 1;
      text-align: center;
      padding: 20px;
    }

    .contact-info div img {
      width: 120px;
      height: 120px;
      margin-bottom: 10px;
    }

    .contact-info p {
      font-size: 1rem;
      color: #555;
    }

    @media (max-width: 768px) {
      .contact-form {
        flex-direction: column;
      }

      .form-container {
        max-width: 100%;
      }

      .form-container button {
        width: 100%;
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>

  <?php
    include("header.html");
  ?>

  <div class="container">
    <h1>Contact Us</h1>
    <p>Have questions or suggestions? We’re here to help! Reach out to us for support, feedback, or collaboration opportunities. Together, let’s create a vibrant learning community where ideas grow and connections flourish. Contact us today!</p>
    

    <div class="contact-form">
      <div class="contact-image">
        <img src="contact/contact.avif" alt="Contact Us Illustration">
      </div>
      <div class="form-container">
        <form>
          <input type="text" name="name" placeholder="Name" required>
          <input type="email" name="email" placeholder="Email" required>
          <input type="text" name="subject" placeholder="Subject" required>
          <textarea name="comment" placeholder="Write a comment" required></textarea>
          <div style="display: flex; justify-content: space-between;">
            <button type="button" class="cancel-btn">Cancel</button>
            <button type="submit" class="submit-btn">Submit</button>
          </div>
        </form>
      </div>
    </div>

    <div class="contact-info">
      <div>
        <img src="contact/phone2.jpg" alt="Phone Icon">
        <p>+94 11 444 5001</p>
      </div>
      <div>
        <img src="contact/telephone.png" alt="Landline Icon">
        <p>+94 11 444 5555</p>
      </div>
      <div>
        <img src="contact/envelope.webp" alt="Email Icon">
        <p>@learningwithcommunity.com</p>
      </div>
    </div>
  </div>
</body>
</html>

<?php
  include("footer.html");
?>