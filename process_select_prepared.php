<?php
// Database connection
$mysqli = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get user input
$username = $_POST['username'];

// Prepared SQL Query
$stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "Username: " . $row["username"] . "<br>";
        echo "Email: " . $row["email"] . "<br>";
    }
} else {
    echo "Error: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>
