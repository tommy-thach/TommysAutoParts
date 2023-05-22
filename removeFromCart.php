<?php
// Start session, load database, and set the PDO connection
session_start();
require_once('./include/database.php');
$pdo = getPDO();

$productID = $_GET['productID']; // Get the product ID to remove

// Check if the user is logged in or not
if (isset($_SESSION['userID'])) { // If user is signed in, proceed with SQL operations to handle carts
   $userID = $_SESSION['userID'];
  
   // Remove product from the database
   $sql = "DELETE FROM carts WHERE userID = '$userID' AND productID = '$productID'";
   $pdo->query($sql);
} else { //If user is not signed in, use session operations to handle carts
   // Remove product from the temporary cart
   foreach ($_SESSION['tempCart'] as $key => $item) {
      if ($item['productID'] == $productID) {
         unset($_SESSION['tempCart'][$key]);
         break;
      }
   }
}

$pdo = null; // Close PDO Connection
header("Location: cart.php"); // Redirect back to cart page
exit();
?>