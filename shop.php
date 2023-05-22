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
      <title>Shop</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/shop-styles.css">
   </head>
   <body>
      <div id="navbar"></div>
      <div>
         <div class="categoriesContainer">
            <div style="font-size:35px; padding-top:20px;"><b>Categories</b></div>
            <ul>
               <li id='all'><a href="shop.php?category=all">All</a></li>
               <li id='engine'><a href="shop.php?category=engine">Engine</a></li>
               <li id='transmission'><a href="shop.php?category=transmission">Transmission</a></li>
               <li id='exhaust'><a href="shop.php?category=exhaust">Exhaust</a></li>
               <li id='brakes'><a href="shop.php?category=brakes">Brakes</a></li>
               <li id='suspension'><a href="shop.php?category=suspension">Suspension</a></li>
               <li id='cooling'><a href="shop.php?category=cooling">Cooling</a></li>
               <li id='lighting'><a href="shop.php?category=lighting">Lighting</a></li>
               <li id='interior'><a href="shop.php?category=interior">Interior</a></li>
               <li id='exterior'><a href="shop.php?category=exterior">Exterior</a></li>
               <li id='wheelstires'><a href="shop.php?category=wheelstires">Wheels/Tires</a></li>
            </ul>
         </div>
         <div class="container">
            <?php
               // Select products from database based on category
               $category = $_GET['category'];
               if ($category == "all") {
                  $sql = "SELECT * FROM products"; // Selects all products if the "All" category is selected
                  echo "<h1>All Products</h1>";
               } elseif ($category == "wheelstires") {
                  $sql = "SELECT * FROM products WHERE category='$category'";
                  echo "<h1>Wheels/Tires</h1>";
               } else {
                  $sql = "SELECT * FROM products WHERE category='$category'";
                  echo "<h1>$category</h1>";
               }
               $result = $pdo->query($sql);

               // Setting status messages
               if (isset($_GET["status"]) && $_GET["status"] == "success") {
                  echo "<div class='statusSuccess'>Item successfully added to your cart</div>";
               }

               // Make containers for each product
               if ($result->rowCount() > 0) {
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                     echo '<div class="productsContainer">';
                     echo '<div class="products">';
                     echo '<img src="' . $row['imagelink'] . '">';
                     echo '<h2>' . $row['name'] . '</h2>';
                     echo '<p>' . $row['description'] . '</p>';
                     echo '<p>Price: $' . $row['price'] . '</p>';
                     echo '<form method="post" action="/tommyautoparts/addToCart.php?category=' . $category . '">';
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
         </div>
      </div>
   </body>
</html>