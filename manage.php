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
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $isbn = $_POST['isbn'];
    $publisher = $_POST['publisher'];
    $year_published = $_POST['year_published'];
    $availability = $_POST['availability'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO book (BookID, Title, Author, ISBN, Publisher, YearPublished, Category, CopiesAvailable) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE CopiesAvailable=?");
    $stmt->bind_param("ssssssssi", $book_id, $title, $author, $isbn, $publisher, $year_published, $category, $availability, $availability);

    if ($stmt->execute()) {
        echo "Book created or updated successfully!";
    } else {
        echo "Error creating or updating book: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>