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
      <title>Admin Panel</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/admin.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/admin-styles.css">
   </head>

   <body>
      <div id="navbar"></div> <!-- Load the navbar -->

      <h1>Admin Panel</h1>
      <div id="container">
         <div id="productsTableContainer">
            <!-- Create filter checkboxes -->
            <div class="filter">
               <label><b>Filter: </b></label>
               <label><input type="checkbox" id="checkAll" onclick="checkAll();filter()">Check All</label>
               <label><input type="checkbox" name="category" value="Engine" onclick="filter()">Engine</label>
               <label><input type="checkbox" name="category" value="Transmission" onclick="filter()">Transmission</label>
               <label><input type="checkbox" name="category" value="Exhaust" onclick="filter()">Exhaust</label>
               <label><input type="checkbox" name="category" value="Brakes" onclick="filter()">Brakes</label>
               <label><input type="checkbox" name="category" value="Suspension" onclick="filter()">Suspension</label>
               <label><input type="checkbox" name="category" value="Cooling" onclick="filter()">Cooling</label>
               <label><input type="checkbox" name="category" value="Lighting" onclick="filter()">Lighting</label>
               <label><input type="checkbox" name="category" value="Interior" onclick="filter()">Interior</label>
               <label><input type="checkbox" name="category" value="Exterior" onclick="filter()">Exterior</label>
               <label><input type="checkbox" name="category" value="WheelsTires" onclick="filter()">Wheels/Tires</label>
               <button onclick="window.location.href='newProduct.php'">New Product</button><br>
               <button onclick="window.location.href='newAccount.php'">New Account</button>
            </div>

            <!-- Create a table to display the products -->
            <div class="productsTable">
               <h2>Products</h2>
               <table>
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>

                  <?php
                     // Select all products from the database
                     $sql = "SELECT * FROM products";
                     $result = $pdo->query($sql);
                     
                     // Display products on the products table
                     if ($result->rowCount() > 0) {
                     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                     echo "<tr>";
                     echo "<td>" . $row['productID'] . "</td>";
                     echo "<td>" . $row['name'] . "</td>";
                     echo "<td>" . $row['description'] . "</td>";
                     echo "<td>$" . $row['price'] . "</td>";
                     echo "<td>" . $row['category'] . "</td>";
                     echo "<td><a href='editProduct.php?id=" . $row['productID'] . "' class='button'>Edit</a> / <a href='removeProduct.php?id=" . $row['productID'] . "' class='button'>Remove</a>";
                     echo "</tr>";
                     }
                     }
                     ?>
                  </tbody>
               </table>
            </div>
         </div>

         <!-- Create a table to display accounts -->
         <div class="accountsTable">
            <table>
               <thead>
                  <h2>Accounts</h2>
                  <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>E-mail</th>
                     <th>Password</th>
                     <th>isAdmin</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
               <?php
                  // Select all accounts from the database
                  $sql = "SELECT * FROM accounts";
                  $result = $pdo->query($sql);
                  
                  // Display accounts on the accounts table
                  if ($result->rowCount() > 0) {
                     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['userID'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . substr($row['password'], 0, 20) . "...</td>";
                        echo "<td>" . $row['isAdmin'] . "</td>";
                        echo "<td><a href='editAccount.php?id=" . $row['userID'] . "' class='button'>Edit</a> / <a href='removeAccount.php?id=" . $row['userID'] . "' class='button'>Remove</a>";
                        echo "</tr>";
                     }
                  }
                  
                  $pdo = null; // Close PDO connection
                  ?>
               </tbody>
            </table>
         </div>
      </div>
   </body>
</html>