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

    // Check if the book exists and has been borrowed (with NULL ReturnDate)
    $sql_check_borrowed = "SELECT * FROM borrowings WHERE BookID = ? AND ReturnDate IS NULL";
    $stmt_check_borrowed = $conn->prepare($sql_check_borrowed);
    $stmt_check_borrowed->bind_param("s", $book_id);
    $stmt_check_borrowed->execute();
    $result_borrowed = $stmt_check_borrowed->get_result();

    if ($result_borrowed->num_rows > 0) {
        // Book is borrowed, update ReturnDate
        $sql_update_return_date = "UPDATE borrowings SET ReturnDate = CURDATE() WHERE BookID = ?";
        $stmt_update_return_date = $conn->prepare($sql_update_return_date);
        $stmt_update_return_date->bind_param("s", $book_id);
        $stmt_update_return_date->execute();

        // Increment CopiesAvailable in the book table
        $sql_update_copies = "UPDATE book SET CopiesAvailable = CopiesAvailable + 1 WHERE BookID = ?";
        $stmt_update_copies = $conn->prepare($sql_update_copies);
        $stmt_update_copies->bind_param("s", $book_id);
        $stmt_update_copies->execute();

        echo "Book returned successfully!";
    } else {
        echo "Book not found or not borrowed.";
    }

    // Close statements
    $stmt_check_borrowed->close();
    if (isset($stmt_update_return_date)) {
        $stmt_update_return_date->close();
    }
    if (isset($stmt_update_copies)) {
        $stmt_update_copies->close();
    }
}

// Close connection
$conn->close();
?>