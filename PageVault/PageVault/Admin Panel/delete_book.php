<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to your login page
    exit();
}

include '../db.php'; // Or include 'db.php' if db.php is in the same directory

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Handle Confirmation (Display a message to the user):

    // Fetch the book title for the confirmation message
    $sql_title = "SELECT title FROM books WHERE id = ?";
    $stmt_title = $conn->prepare($sql_title);
    $stmt_title->bind_param("i", $id);
    $stmt_title->execute();
    $result_title = $stmt_title->get_result();

    if ($result_title->num_rows > 0) {
        $row_title = $result_title->fetch_assoc();
        $book_title = $row_title['title'];
    } else {
        echo "Book not found.";
        exit();
    }

    $stmt_title->close();

    // 2. Handle Delete (If the user confirms):

    if (isset($_POST['confirm_delete'])) {
        $sql_delete = "DELETE FROM books WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            header("Location: index.php"); // Redirect back to the book list
            exit();
        } else {
            echo "Error deleting record: " . $stmt_delete->error;
        }

        $stmt_delete->close();
    }

    // 3. Display Confirmation Form:

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Book</title>
</head>
<body>

    <h1>Delete Book</h1>

    <p>Are you sure you want to delete "<?php echo $book_title; ?>"?</p>

    <form method="post">
        <input type="submit" name="confirm_delete" value="Yes, Delete">
    </form>

    <a href="index.php">No, Go Back</a>

</body>
</html>

<?php

} else {
    echo "Book ID not provided.";
    exit();
}

$conn->close();
?>