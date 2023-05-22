<?php 
   session_start(); // Start session

   if(!isset($_SESSION['userID'])) {
      if(!isset($_SESSION['tempCart'])) {
         $_SESSION['tempCart'] = array();
      }
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Document</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"/>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
      <link rel="stylesheet" type="text/css" href="/tommyautoparts/style/navbar-styles.css">
   </head>
   <?php 
   ?>
   <body>
      <div class="navbarContainer">
         <div class="title">
            <h1><a href="/tommyautoparts/index.php">Tommy's Auto Parts</a></h1>
         </div>
         <nav class="navbar navbar-expand-lg justify-content-between align-items-center">
            <ul class="navbar-nav mx-auto">
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">Shop</a>
               <ul class="dropdown-menu">
                  <li><a class="dropdown-item engine" href="/tommyautoparts/shop.php?category=engine">Engine</a></li>
                  <li><a class="dropdown-item transmission" href="/tommyautoparts/shop.php?category=transmission">Transmission</a></li>
                  <li><a class="dropdown-item exhaust" href="/tommyautoparts/shop.php?category=exhaust">Exhaust</a></li>
                  <li><a class="dropdown-item brakes" href="/tommyautoparts/shop.php?category=brakes">Brakes</a></li>
                  <li><a class="dropdown-item suspension" href="/tommyautoparts/shop.php?category=suspension">Suspension</a></li>
                  <li><a class="dropdown-item cooling" href="shop.php?category=cooling">Cooling</a></li>
                  <li><a class="dropdown-item lighting" href="/tommyautoparts/shop.php?category=lighting">Lighting</a></li>
                  <li><a class="dropdown-item interior" href="/tommyautoparts/shop.php?category=interior">Interior</a></li>
                  <li><a class="dropdown-item exterior" href="/tommyautoparts/shop.php?category=exterior">Exterior</a></li>
                  <li><a class="dropdown-item wheelstires" href="/tommyautoparts/shop.php?category=wheels-tires">Wheels/Tires</a></li>
               </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="/tommyautoparts/contact.php">Help</a></li>
            <li class="nav-item"><a class="nav-link" href="/tommyautoparts/about.php">About</a></li>
            <li class="nav-item"><a class="nav-link" href="/tommyautoparts/cart.php">Cart</a></li>
            <li class="nav-item dropdown">
               <!-- Display username on the navbar if user is signed in and show "Orders" and "Sign Out" options in the dropdown -->
               <?php if (isset($_SESSION['username'])) { ?>
               <a class="nav-link dropdown-toggle" href="#" id="navbarAccount" role="button" data-bs-toggle="dropdown"><span>Welcome, <?php echo $_SESSION['username']; ?></span></a>
               <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item orders" href="/tommyautoparts/orders.php">Orders</a></li>
                  <?php if ($_SESSION['isAdmin']) { ?> <!-- Show admin panel in the dropdown if user is an admin -->
                  <li><a class="dropdown-item admin" href="/tommyautoparts/admin/admin.php">Admin Panel</a></li>
                  <?php } ?>
                  <li><a class="dropdown-item signout" href="/tommyautoparts/logout.php">Sign Out</a></li>
                  <?php } else { ?>
                  <!-- Show the text "Account" if user is not signed in followed by "Sign In" and "Register" options in the dropdown -->
                  <a class="nav-link dropdown-toggle" href="#" id="navbarAccount" role="button" data-bs-toggle="dropdown">Account</a> 
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a class="dropdown-item login" href="/tommyautoparts/login.php">Sign In</a></li>
                     <li><a class="dropdown-item register" href="/tommyautoparts/register.php">Register</a></li>
                  </ul>
                  <?php } ?>
                  </li>
               </ul>
         </nav>
      </div>
   </body>
</html>