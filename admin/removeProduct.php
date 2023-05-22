<?php
   require_once('../include/database.php');
   $pdo = getPDO();

   // Get the product's ID
   $id = $_GET['id'];
   
   // Remove product from database based on ID
   $sql = "DELETE FROM carts WHERE productID = $id"; // Remove from carts table
   $pdo->query($sql);

   $sql = "DELETE FROM products WHERE productID = $id"; //Remove from products table
   if ($pdo->query($sql)) {
       header("Location: admin.php");
   } else {
       echo "An SQL error has occured.";
   }
   
   $pdo = null; // Close PDO connection
   ?>