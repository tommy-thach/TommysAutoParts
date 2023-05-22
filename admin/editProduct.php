<?php
   // Start session, load database, and set the PDO connection
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
      <title>Edit Product</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="/tommyautoparts/scripts/navbar.js"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/admin-styles.css">
   </head>
   <body>
      <div id="navbar"></div> <!-- Load the navbar -->

      <h1>Admin Panel</h1>
      <div class="container">
      <h2>Editing Product</h2>
      <?php
         // Get product ID to edit
         $id = $_GET['id'];
         
         // Select the product from the database based on ID
         $sql = "SELECT * FROM products WHERE productID = $id";
         $result = $pdo->query($sql);
         $row = $result->fetch(PDO::FETCH_ASSOC);
         
         // Automatically fill in the textboxes with the product's current information
         $name = $row['name'];
         $description = $row['description'];
         $price = $row['price'];
         $category = $row['category'];
         $imagelink = $row['imagelink'];
         
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get information from POST
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $imagelink = $_POST['imagelink'];

            // Update the product in the database
            $sql = "UPDATE products SET name='$name', description='$description', price='$price', category='$category', imagelink='$imagelink' WHERE productID=$id";
            $pdo->query($sql);

            $pdo = null; // Close PDO Connection

            header("location: admin.php"); // Redirect back to previous page
            exit();
         }
         ?>
      
      <!-- Create form to edit products -->
      <form method="post" action="editProduct.php?id=<?php echo $id; ?>">
         <label>ID: <?php echo $id; ?></label><br>
         <label>Name</label>
         <input type="text" name="name" value="<?php echo $name; ?>">
         <label>Description</label>
         <textarea name="description"><?php echo $description; ?></textarea>
         <label>Price</label>
         <input type="text" name="price" value="<?php echo $price; ?>">
         <label>Image Link</label>
         <input type="text" name="imagelink" value="<?php echo $imagelink; ?>">
         <label>Category</label>
         <select name="category">
            <option value="Engine" <?php if($category == "Engine") echo "selected"; ?>>Engine</option>
            <option value="Transmission" <?php if($category == "Transmission") echo "selected"; ?>>Transmission</option>
            <option value="Exhaust" <?php if($category == "Exhaust") echo "selected"; ?>>Exhaust</option>
            <option value="Brakes" <?php if($category == "Brakes") echo "selected"; ?>>Brakes</option>
            <option value="Suspension" <?php if($category == "Suspension") echo "selected"; ?>>Suspension</option>
            <option value="Cooling" <?php if($category == "Cooling") echo "selected"; ?>>Cooling</option>
            <option value="Lighting" <?php if($category == "Lighting") echo "selected"; ?>>Lighting</option>
            <option value="Interior" <?php if($category == "Interior") echo "selected"; ?>>Interior</option>
            <option value="Exterior" <?php if($category == "Exterior") echo "selected"; ?>>Exterior</option>
            <option value="WheelsTires" <?php if($category == "WheelsTires") echo "selected"; ?>>Wheels/Tires</option>
         </select>
         <button type="submit">Update</button>
         <button type="button" onclick="window.location.href='admin.php'">Cancel</button>
      </form>
      <div>
   </body>
</html>