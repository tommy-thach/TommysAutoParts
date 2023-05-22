<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Contact</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/form-styles.css">
   </head>
   <body>
      <div id="navbar"></div> <!-- Load the navbar -->
      <h1>Contact Us</h1>
      <h3>Feel free to contact us at any time using the form below, or by calling our number at (973) 655-4000.</h3>
      <?php
         // Setting the status message
         if (isset($_GET["status"]) && $_GET["status"] == "success") {
            echo "<div class='status'>Your message has been sent, we will get back to you as soon as possible.</div>";
         }
         ?>

      <!-- Creating contact form -->
      <div class="contactForm">
         <form action="contact.php?status=success" method="POST">
            <label>Name:</label>
            <input type="text" id="name" name="name" autofocus required/>
            <label>Phone:</label>
            <input type="text" id="phone" name="phone">
            <label>E-mail Address:</label>
            <input type="email" id="email" name="email" placeholder="name@domain.com" required/>
            <label>Your Comments:</label>
            <textarea style="height:150px;" required></textarea>
            <br>
            <input type="submit" value="Submit">
         </form>
      </div>
   </body>
</html>