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
      <title>New Product</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/admin-styles.css">
   </head>
   <body>
      <div id="navbar"></div> <!-- Load the navbar -->

      <h1>Admin Panel</h1>
      <div class="container">
      <h2>New Product</h2>
      <?php
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get information from POST
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $imagelink = $_POST['imagelink'];

            // Insert product into the database
            $sql = "INSERT INTO products (name, description, price, category, imagelink) VALUES ('$name', '$description', '$price', '$category', '$imagelink')";
            $pdo->query($sql);

            $pdo = null; // Close PDO connection
            
            header("location: admin.php"); // Redirect back to previous page
            exit();
         }
         ?>

      <!-- Create form to add new products -->
      <form method="post" action="newProduct.php">
         <label>Name</label>
         <input type="text" name="name">
         <label>Description</label>
         <textarea name="description"></textarea>
         <label>Price</label>
         <input type="text" name="price">
         <label>Image Link</label>
         <input type="text" name="imagelink">
         <label>Category</label>
         <select name="category">
            <option value="Engine">Engine</option>
            <option value="Transmission">Transmission</option>
            <option value="Exhaust">Exhaust</option>
            <option value="Brakes">Brakes</option>
            <option value="Suspension">Suspension</option>
            <option value="Cooling">Cooling</option>
            <option value="Lighting">Lighting</option>
            <option value="Interior">Interior</option>
            <option value="Exterior">Exterior</option>
            <option value="WheelsTires">Wheels/Tires</option>
         </select>
         <button type="submit">Add</button>
         <button type="button" onclick="window.location.href='admin.php'">Cancel</button>
      </form>
      <div>
   </body>
</html>