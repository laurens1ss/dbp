
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host="localhost";
$dbname = "library_db";
$username ="root";
$password="123";

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname,  3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $patron_id = $_POST['patron_id'];

    // Check if the book is available
    $sql = "SELECT CopiesAvailable FROM Book WHERE BookID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['CopiesAvailable'] > 0) {
        // Update the CopiesAvailable field
        $sql_update = "UPDATE Book SET CopiesAvailable = CopiesAvailable - 1 WHERE BookID = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("s", $book_id);
        $stmt_update->execute();

        // Insert a new record into the Borrowings table
        $sql_insert = "INSERT INTO Borrowings (PatronID, BookID, BorrowDate) VALUES (?, ?, CURDATE())";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $patron_id, $book_id);
        $stmt_insert->execute();

        echo "Book borrowed successfully!";

        //close the statements
        $stmt_insert->close();
        $stmt_update->close();
    } else {
        echo "No copies available for Book ID: " . $book_id;
    }

    //close initial statement
    $stmt->close(); 
}

//close connection
$conn->close();
?>