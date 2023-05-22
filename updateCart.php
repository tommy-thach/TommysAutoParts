<?php
// Start session, load database, and set the PDO connection
session_start();
require_once('./include/database.php');
$pdo = getPDO();

// Check if the user is logged in or not
if (isset($_SESSION['userID'])) { // If user is signed in, proceed with SQL operations to handle carts
   $userID    = $_SESSION['userID'];
   $productID = $_GET['productID'];
   $quantity  = $_GET['quantity'];
   $sql       = "UPDATE carts SET quantity = '$quantity' WHERE userID = '$userID' AND productID = '$productID'";
   $pdo->query($sql);
   $pdo       = null; // Close PDO Connections
} else { //If user is not signed in, use session operations to handle carts
   if (isset($_GET['productID']) && isset($_GET['quantity'])) {
      $productID = $_GET['productID'] - 1;
      $quantity  = $_GET['quantity'];
      if (isset($_SESSION['tempCart'][$productID])) {
         $_SESSION['tempCart'][$productID]['quantity'] = $quantity;
      }
   }
}
?>