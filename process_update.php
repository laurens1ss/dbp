<?php
// Database connection
$mysqli = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get user input
$username = $_POST['username'];
$email = $_POST['email'];

// Vulnerable SQL Query
$query = "UPDATE users SET email = '$email' WHERE username = '$username'";
if ($mysqli->query($query) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>
