<?php
   require_once('../include/database.php');
   $pdo = getPDO();

   // Get the user's ID
   $id = $_GET['id'];
   
   // Remove user from database based on ID
   $sql = "DELETE FROM carts WHERE userID = $id"; // Remove from carts table
   $pdo->query($sql);

   $sql = "DELETE FROM accounts WHERE userID = $id"; // Remove from accounts table
   if ($pdo->query($sql)) {
       header("Location: admin.php");
   } else {
       echo "An SQL error has occured.";
   }
   
   $pdo = null; // Close PDO connection
   ?>