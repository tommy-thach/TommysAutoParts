<?php
   // Start session, load database, and set the PDO connection
   session_start(); 
   require_once('./include/database.php');
   $pdo = getPDO();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/form-styles.css">
   </head>
   <body>
      <div id="navbar"></div> <!-- Load the navbar -->

      <!-- Creating login form -->
      <div class="form">
         <h1>Login</h1>
         <?php
            // Setting status messages
            if (isset($_GET["status"]) && $_GET["status"] == "success") {
               echo "<div class='statusSuccess'>Account successfully created. Please sign in below.</div>";
            }
            if (isset($_GET["status"]) && $_GET["status"] == "error") {
               echo "<div class='statusError'>Invalid username or password. Please try again.</div>";
            }
            ?>

         <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
            <input type="button" onclick="window.location.href='register.php'" value="Register">
         </form>
      </div>
      
      <?php
         if (isset($_POST['username']) && isset($_POST['password'])) {
         	// Retrieving input from POST
         	$username = $_POST['username'];
         	$password = $_POST['password'];
         
         	// Check input with database
         	$sql = "SELECT * FROM accounts WHERE username='$username'";
         	$result = $pdo->query($sql);
         
            // Log in and then check if user is admin or not
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) { // Verify the encrypted password in the database
               $_SESSION['userID'] = $row['userID'];
               $_SESSION['username'] = $row['username'];
               $_SESSION['isAdmin'] = $row['isAdmin'];
               header("Location: index.php"); // Redirect to the homepage
               exit();
            }
            else {
               header("Location: login.php?status=error"); // Show error if information is incorrect
            }
         	
         	$pdo = null; // Close PDO connection
         }
         ?>
   </body>
</html>