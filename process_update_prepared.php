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

// Prepared SQL Query
$stmt = $mysqli->prepare("UPDATE users SET email = ? WHERE username = ?");
$stmt->bind_param("ss", $email, $username);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
