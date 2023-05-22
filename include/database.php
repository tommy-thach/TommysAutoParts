<?php 
   $dsn = "mysql:host=localhost:3307;";
   
   try {
      // Using root account to create and grant user priveleges
      $pdo = new PDO($dsn, "root", "");
      $sql = "SELECT COUNT(*) as count FROM mysql.user WHERE User = 'tommythach'";
      $result = $pdo->query($sql);
      
      // Create the database if it doesn't exist
      $sql = "CREATE DATABASE IF NOT EXISTS tommythachdatabase";
      $pdo->exec($sql);

      // Select the database
      $pdo->exec("USE tommythachdatabase");

      // Create tommythach user if it doesn't already exist and grant priveledges
      if ($result->fetch(PDO::FETCH_ASSOC)['count'] == 0){
          $pdo->exec("CREATE USER 'tommythach'@'localhost' IDENTIFIED BY 'finalproject'");
          $pdo->exec("GRANT CREATE, SELECT, INSERT, DELETE, UPDATE ON tommythachdatabase.* TO 'tommythach'@'localhost'");
      }
      $pdo = null; // Close PDO connection for root user so we can sign in and use the one we just created
   }
   catch(PDOException $error) {
      echo "Error: " . $error->getMessage();
   }
   ?>

<?php
   // Using created user for the rest of the database instead of root
   // Function to get PDO connection every time we need it
   function getPDO() {
      $dsn = "mysql:host=localhost:3307;dbname=tommythachdatabase";
   
      try {
         $pdo = new PDO($dsn, "tommythach", "finalproject");
         return $pdo;
      } catch(PDOException $e) {
         echo "Connection failed: " . $e->getMessage();
      }
   }
   
   try {
      $pdo = getPdo();

      // Create the accounts table if it doesn't exist
      $sql =   "CREATE TABLE IF NOT EXISTS accounts (
               userID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
               username VARCHAR(50) NOT NULL,
               password VARCHAR(255) NOT NULL,
               email VARCHAR(50),
               isAdmin BOOLEAN NOT NULL
               )";

      $pdo->exec($sql);
   
      // Create the products table if it doesn't exist
      $sql =   "CREATE TABLE IF NOT EXISTS products (
               productID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
               name VARCHAR(50) NOT NULL,
               description TEXT NOT NULL,
               price DECIMAL(10, 2) UNSIGNED NOT NULL,
               category VARCHAR(50) NOT NULL,
               imagelink VARCHAR(255) NOT NULL
               )";

      $pdo->exec($sql);

      // Create the carts table if it doesn't exist
      $sql =   "CREATE TABLE IF NOT EXISTS carts (
               cartID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
               userID INT UNSIGNED NOT NULL,
               productID INT UNSIGNED NOT NULL,
               quantity INT UNSIGNED NOT NULL,
               price DECIMAL(10, 2) UNSIGNED NOT NULL,
               FOREIGN KEY (userID) REFERENCES accounts(userID),
               FOREIGN KEY (productID) REFERENCES products(productID)
               );";

      $pdo->exec($sql);
      
      // Create admin account if it doesn't exist
      // By default:
      // Username: admin
      // Password: admin
      $sql = "SELECT * FROM accounts WHERE username='Admin'";
      $result = $pdo->query($sql);

      if ($result->rowCount() == 0) {
         $adminPassword = password_hash("admin", PASSWORD_DEFAULT);
         $sql =   "INSERT INTO accounts (username, password, email, isAdmin)
                  VALUES ('Admin', '$adminPassword', 'admin@email.com', 1);";

         $pdo->exec($sql);
      }
   } catch(PDOException $error) {
         echo "Error: " . $error->getMessage();
   }
   
   $pdo = null; // Close PDO connection
   ?>