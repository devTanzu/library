<?php
$servername = "localhost"; // Database server
$username = "root";        // Database username
$password = "";            // Database password (default for XAMPP is empty)
$database = "library";     // Database name

// Create connection
$db = new mysqli($servername, $username, $password, $database);  // Changed $conn to $db

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);  // Changed $conn to $db
}
?>
