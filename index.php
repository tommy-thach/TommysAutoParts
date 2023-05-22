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
      <title>Home</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <script src="/tommyautoparts/scripts/status.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/shop-styles.css">
   </head>
   <body>
      <div id="navbar"></div> <!-- Load the navbar -->
      <h1>All Products</h1>
      <?php
         // Setting status messages
         if (isset($_GET["status"]) && $_GET["status"] == "success") {
            echo "<div class='statusSuccess'>Item successfully added to your cart</div>";
         }

         // Select all products from database
         $sql = "SELECT * FROM products";
         $result = $pdo->query($sql);
         
         // Make containers for each product
         if ($result->rowCount() > 0) {
         while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="productsContainer">';
            echo '<div class="products">';
            echo '<img src="' . $row['imagelink'] . '">';
            echo '<h2>' . $row['name'] . '</h2>';
            echo '<p>' . $row['description'] . '</p>';
            echo '<p>Price: $' . $row['price'] . '</p>';
            echo '<form method="post" action="/tommyautoparts/addToCart.php">';
            echo '<div class="quantity">';
            echo '<p>Quantity:</p>';
            echo '<input type="number" name="quantity" value="1">';
            echo '</div>';
            echo '<input type="hidden" name="userID" value="' . ($_SESSION['userID'] ?? 0) . '">';
            echo '<input type="hidden" name="productID" value="' . $row['productID'] . '">';
            echo '<input type="hidden" name="name" value="' . $row['name'] . '">';
            echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
            echo '<input type="hidden" name="imagelink" value="' . $row['imagelink'] . '">';
            echo '<button type="submit">Add to Cart</button>';
            echo '</form>';
            echo '</div>';
            echo '</div';
         }
         } else {
            echo "<h3>There are no products in this category.</h3>";
         }

         $pdo = null; // Close PDO connection
         ?>
   </body>
</html>