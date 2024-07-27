<?php
// Database connection
$mysqli = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get user input
$username = $_POST['username'];

// Vulnerable SQL Query
$query = "SELECT * FROM users WHERE username = '$username'";
$result = $mysqli->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "Username: " . $row["username"] . "<br>";
        echo "Email: " . $row["email"] . "<br>";
    }
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>
