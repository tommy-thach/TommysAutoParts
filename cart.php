<?php
   require_once('./include/database.php');
   $pdo = getPDO();
   session_start();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Cart</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/cart-styles.css">
   </head>
   <body>
      <div id="navbar"></div> <!-- Load the navbar -->

      <div class="parentContainer">
         <div class="cartsContainer">
            <?php
               // Check if the user is logged in or not
               if(isset($_SESSION['userID'])) {
                  $userID = $_SESSION['userID'];
                  
                  // Get products from database from the cart based on user's ID
                  $sql = "SELECT products.productID, products.name, products.description, carts.quantity, carts.price, products.imagelink
                          FROM carts 
                          INNER JOIN products ON carts.productID = products.productID 
                          WHERE userID = '$userID'";

                  $result = $pdo->query($sql);
                  
                  // Display every product in the cart
                  $subtotal = 0;
                  if ($result->rowCount() == 0) { // If cart is empty, display message
                     echo "<div class='emptyCart'>";
                        echo "<h1>Your cart is currently empty</h1>";
                        echo "</div>";
                  } else { 
                  while($row = $result->fetch()) { // Otherwise, display its contents
                     echo "<div class='cart'>";
                     echo "<div class='productImg'>";
                     echo "<img src='".$row['imagelink']."'>";
                     echo "<div class='productText'>";
                     echo "<h2>".$row['name']."</h2>";
                     echo "<p>".$row['description']."</p>";
                     echo "<p>Quantity: <input type='number' id='quantity_".$row['productID']."' value='" . $row['quantity'] . "' min='1' max='50' onchange='updateQuantity(".$row['productID'].", this.value, ".$row['price'].")'></p>";
               
               
                     echo "<p>Price: ".$row['price']."</p>";
                     echo "</div>";
                     
                     echo "<div class='cartButtons'>";
                     echo "<input type='button' name='removeButton' onclick='window.location.href=\"removeFromCart.php?productID=" . $row['productID'] . "\";' value='X' />";
                     echo "</div>";
                     
                     echo "</div>";
                     echo "</div>";
                     
                     $subtotal += $row['price'] * $row['quantity'];
                  }
               }
               } else { //Use temporary cart if user is not signed in
               if (!isset($_SESSION["tempCart"])) {
                  $_SESSION["tempCart"] = array();
               }
               
                      // Display every product in the cart
                      $subtotal = 0;
                      $cart = $_SESSION['tempCart'];
                      if (count($cart) == 0) { // If cart is empty, display message
                        echo "<div class='emptyCart'>";
                        echo "<h1>Your cart is currently empty</h1>";
                        echo "</div>";
                      } else{ 
                      foreach($cart as $row) { // Otherwise, display its contents
                        echo "<div class='cart'>";
                        echo "<div class='productImg'>";
                        echo "<img src='".$row['imagelink']."'>";
                        echo $row['productID'];
                        echo "<div class='productText'>";
                        echo "<h2>".$row['name']."</h2>";
                        echo "<p>".$row['description']."</p>";
                        echo "<p>Quantity: <input type='number' id='quantity_".$row['productID']."' value='" . $row['quantity'] . "' min='1' onchange='updateQuantity(".$row['productID'].", this.value, ".$row['price'].")'></p>";
               
               
                        echo "<p>Price: ".$row['price']."</p>";
                        echo "</div>";
                        
                        echo "<div class='cartButtons'>";
                        echo "<input type='button' name='removeButton' onclick='window.location.href=\"removeFromCart.php?productID=" . $row['productID'] . "\";' value='X' />";
                        echo "</div>";
                        
                        echo "</div>";
                        echo "</div>";
                        
                        $subtotal += $row['price'] * $row['quantity'];
                     }
                  }
                     
                  }
               
               ?>
         </div>
         <div class="totalsContainer"> <!-- Displaying totals -->
            <div class="total">
               <h1>Total</h1>
               <hr size="3" width="100%" color="black">
               <?php
                  $shipping = $subtotal*0.05;
                  $tax = $subtotal*0.065;
                  $grandTotal = $subtotal+$tax+$shipping;
                  ?>
               <div class="subtotal">
                  <span>Subtotal:</span>
                  <span id="subtotal"><?php echo '$'.number_format($subtotal,2)?></span>
               </div>
               <div class="shipping">
                  <span>Shipping:</span>
                  <span id="shipping"><?php echo '$'.number_format($shipping,2)?></span>
               </div>
               <div class="tax">
                  <span>Tax:</span>
                  <span id="tax"><?php echo '$'.number_format($tax,2)?></span>
               </div>
               <hr size="3" width="100%" color="black">
               <div class="grandTotal">
                  <span>
                     <h3>Grand Total:</h3>
                  </span>
                  <span id="grandTotal"><?php echo '$'.number_format($grandTotal,2)?></span>
               </div>
               <input type="button" name="checkoutButton" value="Checkout"/>
            </div>
         </div>
      </div>
   </body>
</html>
<script>
   // Function to automatically update the total calculations when the quantity textbox is changed
   function updateTotal(productID, price) {
       var quantity = document.getElementById("quantity_"+productID).value;
       var newTotal = quantity * price;
   
       var subtotal = newTotal;
       var shipping = subtotal * 0.05;
       var tax = subtotal * 0.0625;
       var grandTotal = subtotal + shipping + tax;
   
      document.getElementById("subtotal").innerHTML = "$" + subtotal.toFixed(2);
      document.getElementById("shipping").innerHTML = "$" + shipping.toFixed(2);
      document.getElementById("tax").innerHTML = "$" + tax.toFixed(2);
      document.getElementById("grandTotal").innerHTML = "$" + grandTotal.toFixed(2);
   }
   
   // Function to update the quantities into the database or temporary cart
   function updateQuantity(productID, quantity, price) {
     var httpReq = new XMLHttpRequest();
     httpReq.onreadystatechange = function() {
       if (httpReq.readyState == 4 && httpReq.status == 200) {
         updateTotal(productID, price);
       }
     };
     httpReq.open("GET", "updateCart.php?productID=" + productID + "&quantity=" + quantity, true);
     httpReq.send();
   }
</script>