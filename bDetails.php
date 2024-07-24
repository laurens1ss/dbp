<?php
$host = "localhost";
$dbname = "library_db";
$username = "root";
$password = "123";

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];

    // Query the book details based on the Book ID
    $sql = "SELECT Title, Author, ISBN, Publisher, YearPublished FROM book WHERE BookID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Title: " . $row['Title'] . "<br>";
        echo "Author: " . $row['Author'] . "<br>";
        echo "ISBN: " . $row['ISBN'] . "<br>";
        echo "Publisher: " . $row['Publisher'] . "<br>";
        echo "Year Published: " . $row['YearPublished'];
    } else {
        echo "Book not found.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>