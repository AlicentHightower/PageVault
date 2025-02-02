<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to your login page
    exit();
}

include '../db.php';

$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Management</title>
</head>
<body>
    <h1>Book Management</h1>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Cover Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["author"] . "</td>"; // Added author
                    echo "<td><img src='../images/covers/" . $row["cover_image"] . "' width='50'></td>";
                    echo "<td><a href='edit_book.php?id=" . $row["id"] . "'>Edit</a> | <a href='delete_book.php?id=" . $row["id"] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No books found</td></tr>"; // Updated colspan
            }
            ?>
        </tbody>
    </table>
    <a href="add_book.php">Add New Book</a>
</body>
</html>
<?php $conn->close(); ?>