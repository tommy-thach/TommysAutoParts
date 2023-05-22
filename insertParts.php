<?php
// Database connection parameters
$servername = "localhost:5306";
$username = "root";
$password = "";
$dbname = "tommythachdatabase";

// List of car parts with categories
$car_parts = array(
    "Engine" => array("Piston", "Crankshaft", "Camshaft", "Valve", "Timing Belt"),
    "Transmission" => array("Clutch Kit", "Transmission Filter", "Gearbox", "Drive Shaft"),
    "Exhaust" => array("Muffler", "Catalytic Converter", "Exhaust Pipe", "Exhaust Hanger"),
    "Brakes" => array("Brake Pad Set", "Brake Rotor", "Brake Caliper", "Brake Master Cylinder"),
    "Suspension" => array("Shock Absorber", "Strut Assembly", "Coil Spring", "Control Arm"),
    "Cooling" => array("Radiator", "Water Pump", "Thermostat", "Coolant Hose"),
    "Lighting" => array("Headlight Assembly", "Tail Light Assembly", "Fog Light Kit", "Third Brake Light"),
    "Interior" => array("Floor Mats", "Seat Cover", "Steering Wheel Cover", "Dash Cover"),
    "Exterior" => array("Car Cover", "Hood Protector", "Window Visor", "Side Mirror"),
    "Wheels/Tires" => array("Wheel Rim", "Tire Pressure Monitoring System", "Tire Valve Stem", "Wheel Lug Nut")
);

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Loop through each category and insert products into the database
foreach ($car_parts as $category => $parts) {
    foreach ($parts as $part) {
        // Generate random cost between $10 and $100
        $price = rand(10, 3000);
        // Generate product name and description
        $name = $part;
        $description = "This is a " . $part . " for your car's " . $category . ".";
        $description = mysqli_real_escape_string($conn, $description); // Escape special characters in description
        // Insert product into database
        $sql = "INSERT INTO products (name, description, price, imagelink, category)
                VALUES ('$name', '$description', '$price', 'https://waynesville.otc.edu/media/plugins/ninja-forms/assets/img/no-image-available-icon-6.jpg', '$category')";
        if (mysqli_query($conn, $sql)) {
            echo "Product inserted successfully: " . $name . "<br>";
        } else {
            echo "Error inserting product: " . mysqli_error($conn) . "<br>";
        }
    }
}

mysqli_close($conn);
?>
