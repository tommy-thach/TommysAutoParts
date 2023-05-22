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
      <title>Register</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/form-styles.css">
   </head>
   <body>
      <div id="navbar"></div> <!-- Load the navbar -->

      <!-- Creating registration form -->
      <div class="form">
         <h1>Register</h1>
         <?php
            // Setting status messages
            if (isset($_GET["status"]) && $_GET["status"] == "error") {
               echo "<div class='statusError'>The username or email is already registered. Please try again.</div>";
            }
            ?>
         <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="name@domain.com" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Register">
            <input type="button" onclick="window.location.href='login.php'" value="Back to Login">
         </form>

         
      </div>
      <?php
         if (isset($_POST['username']) && isset($_POST['password'])) {
         	// Retrieving input from POST
         	$username = $_POST['username'];
         	$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt the password to the database
            $email = $_POST['email'];
            
         	// Check if username or email is already registered
         	$sql = "SELECT * FROM accounts WHERE username='$username' OR email='$email'";
            $result = $pdo->query($sql);
         
         	if ($result->rowCount() > 0) {
               // Display error if username/email is already registered
         		header("Location: register.php?status=error");
         	} else {
         	   // Register the account into the database
         		$sql = "INSERT INTO accounts (username, password, email, isAdmin)
         		VALUES ('$username', '$password', '$email', '0')";
         	   

               if ($pdo->query($sql)) {
                  header("Location: login.php?status=success"); // Redirect to login page upon successful registration
                  $pdo = null; // Close PDO connection
                  exit();
         		}
         	}
         
         	$pdo = null; // Close PDO connection
         }
         ?>
   </body>
</html>