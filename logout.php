<?php
// Retrieve session
session_start();

// Clear session
$_SESSION = array();

// Destroy session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>