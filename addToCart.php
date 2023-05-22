<?php
   // Start session, load database, and set the PDO connection
   session_start();
   require_once('./include/database.php');
   $pdo = getPDO();
   
   $productID = $_POST['productID'];
   $quantity = $_POST['quantity'];
   $price = $_POST['price'];

   // Check if the user is logged in or not
   if(isset($_SESSION['userID'])) {
     $userID = $_SESSION['userID'];
     
     // Check if product already exist in the cart
     $sql = "SELECT * FROM carts WHERE userID = '$userID' AND productID = '$productID'";
     $result = $pdo->query($sql);
     $row = $result->fetch();
   
     if($row) {
       // Update quantity if product already exists
       $newQuantity = $row['quantity'] + $quantity;
       $sql = "UPDATE carts SET quantity = '$newQuantity' WHERE userID = '$userID' AND productID = '$productID'";
       $pdo->query($sql);
     } else {
       // Insert a new entry if it doesn't exist
       $sql = "INSERT INTO carts (userID, productID, quantity, price) VALUES ('$userID', '$productID', '$quantity', '$price')";
       $pdo->query($sql);
     }

      $pdo = null; // Close PDO connection

      // Keep track of previous page to return back to after adding to cart
      $previousPage = $_SERVER['HTTP_REFERER'];
      if(strpos($previousPage, 'index.php') !== false) {
         header("Location: /tommyautoparts/index.php?status=success");
      } else if(strpos($previousPage, 'shop.php') !== false) {
         $category = $_GET['category'];
         header("Location: /tommyautoparts/shop.php?category=$category&status=success");
      }
   } else {
      // If the user is not signed in, use a temporary cart
      $rowIndex = -1;
      foreach ($_SESSION["tempCart"] as $index => $item) {
        if ($item['productID'] == $productID) {
          $rowIndex = $index;
          break;
        }
      }
    
      if ($rowIndex >= 0) {
        // Update quantity if the product already exist in the cart
        $newQuantity = $_SESSION["tempCart"][$rowIndex]['quantity'] + $quantity;
        $_SESSION["tempCart"][$rowIndex]['quantity'] = $newQuantity;
      } else {
        // Add a new item if product is not already in cart
        $sql = "SELECT * FROM products WHERE productID = '$productID'";
        $result = $pdo->query($sql);
        $product = $result->fetch(PDO::FETCH_ASSOC);
    
        $newItem = array(
          'productID' => $productID,
          'name' => $product['name'],
          'description' => $product['description'],
          'quantity' => $quantity,
          'price' => $product['price'],
          'imagelink' => $product['imagelink']
        );
    
        $_SESSION["tempCart"][] = $newItem;
      }
    }
    
      $pdo = null; // Close PDO connection

      // Keep track of previous page to return back to after adding to cart
      $previousPage = $_SERVER['HTTP_REFERER'];
      if(strpos($previousPage, 'index.php') !== false) {
         header("Location: /tommyautoparts/index.php?status=success");
      } else if(strpos($previousPage, 'shop.php') !== false) {
         $category = $_GET['category'];
         header("Location: /tommyautoparts/shop.php?category=$category&status=success");
      }
   ?>