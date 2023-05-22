<?php
   // Start session, load database, and set the PDO connection
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
      <title>Edit Account</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/admin-styles.css">
   </head>
   <body>
      <div id="navbar"></div> <!-- Load the navbar -->

      <h1>Admin Panel</h1>
      <div class="container">
      <h2>Editing Product</h2>
      <?php

         // Get user ID to edit
         $id = $_GET['id'];

         // Select the user from the database based on ID
         $sql = "SELECT * FROM accounts WHERE userID = $id";
         $result = $pdo->query($sql);
         $row = $result->fetch(PDO::FETCH_ASSOC);
         
         // Automatically fill in the textboxes with the user's current information
         $username = $row['username'];
         $email = $row['email'];
         $isAdmin = $row['isAdmin'];

         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get information from POST
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;
            
            // Insert user into the database
            $sql = "UPDATE accounts SET username='$username', email='$email', password='$password', isAdmin='$isAdmin' WHERE userID=$id";
         
            $pdo->query($sql);
            header("location: admin.php"); // Redirect back to previous page
            $pdo = null; // Close PDO connection
            exit();
         }
         ?>
      
      <!-- Create form to edit products -->
      <form method="post" action="editAccount.php?id=<?php echo $id; ?>">
         <label>ID: <?php echo $id; ?></label><br>
         <label>Username</label>
         <input type="text" name="username" value="<?php echo $username; ?>">
         <label>E-mail</label>
         <input type="email" name="email" value="<?php echo $email; ?>">
         <label>Password</label>
         <input type="password" name="password">
         <label>Admin Permissions: </label>
         <input type="checkbox" name="isAdmin" <?php echo $isAdmin ? 'checked':''; ?>>
         <button type="submit">Update</button>
         <button type="button" onclick="window.location.href='admin.php'">Cancel</button>
      </form>
      <div>
   </body>
</html>