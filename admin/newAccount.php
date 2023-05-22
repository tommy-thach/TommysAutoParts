<?php
   session_start();
   require_once('../include/database.php');
   $pdo = getPDO();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>New Account</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/admin-styles.css">
   </head>
   <body>
      <div id="navbar"></div> <!-- Load the navbar -->

      <h1>Admin Panel</h1>
      <div class="container">
      <h2>New Account</h2>
      <?php
         // Setting status messages
         if (isset($_GET["status"]) && $_GET["status"] == "error") {
            echo "<div class='statusError'>The username or email is already registered. Please try again.</div>";
         }

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get information from POST
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;
            
            $sql = "SELECT * FROM accounts WHERE username='$username' OR email='$email'";
            $result = $pdo->query($sql);

            if ($result->rowCount() > 0) {
               // Display error if username/email is already registered
         		header("Location: newAccount.php?status=error");
         	} else {
         	   // Insert user into the database
         		$sql = "INSERT INTO accounts (username, email, password, isAdmin) VALUES ('$username', '$email', '$password', '$isAdmin')";
         	
               $pdo->query($sql);
               header("location: admin.php"); // Redirect back to previous page
               $pdo = null; // Close PDO connection
               exit();
         		
         	}
         }
         ?>

      <!-- Create form to add a new account -->
      <form method="post" action="newAccount.php">
         <label>Username</label>
         <input type="text" name="username">
         <label>E-mail</label>
         <input type="email" name="email">
         <label>Password</label>
         <input type="password" name="password">
         <label>Admin Permissions: </label>
         <input type="checkbox" name="isAdmin"/>
         <button type="submit">Create</button>
         <button type="button" onclick="window.location.href='admin.php'">Cancel</button>
      </form>
      <div>
   </body>
</html>