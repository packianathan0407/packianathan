<?php
// Database configuration
$servername = "localhost";  // or your database host (e.g., 127.0.0.1)
$username = "root";         // MySQL username
$password = "";             // MySQL password (default is empty for XAMPP)
$dbname = "icecream_shop"; // Database name (replace with your database name)

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
