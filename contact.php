<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "icecream_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // SQL query to insert form data into database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

    // Execute query and check for errors
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Your message has been sent successfully!'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href='contact.html';</script>";
    }
}

// Close connection
$conn->close();
?>
