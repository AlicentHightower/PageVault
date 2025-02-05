<?php
session_start();
include __DIR__ . '/../Home/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT id, title, author, description, cover_image FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a;
            color: #fff;
        }

        .background {
            background: url('../img/Books.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 36px;
            color: #ffcc00;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 24px;
            color: #ffd9b5;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #fff;
            color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
        }

        tr:nth-child(even) {
            background-color: #444;
        }

        a {
            text-decoration: none;
            color: #ffcc00;
        }

        a:hover {
            color: #ff9900;
        }

        .action-buttons {
            display: inline-flex;
            gap: 10px;
        }

        .action-buttons a {
            padding: 5px 10px;
            background-color: #ffcc00;
            color: #1a1a1a;
            font-weight: bold;
            border-radius: 5px;
        }

        .action-buttons a:hover {
            background-color: #ff9900;
        }

        .form-container form input, .form-container form textarea {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
        }

        .form-container form button {
            padding: 10px;
            background-color: #ffcc00;
            color: #1a1a1a;
            font-weight: bold;
            border-radius: 5px;
            border: none;
        }

        .form-container form button:hover {
            background-color: #ff9900;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #1a1a1a;
            color: #ffd9b5;
            margin-top: 40px;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
        }

        footer p {
            margin: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="background">
        <div class="form-container">
            <h1>Admin Dashboard</h1>
            <a href="../Home/logout.php" style="color: #ffcc00;">Logout</a>

            <h2>Manage Books</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>Cover Image</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['author']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                        <td><img src="uploads/<?= htmlspecialchars($row['cover_image']) ?>" width="50"></td>
                        <td>
                            <div class="action-buttons">
                                <a href="edit_book.php?id=<?= $row['id'] ?>">Edit</a>
                                <a href="delete_book.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <h2>Add a New Book</h2>
            <form action="add_book.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Book Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input type="file" name="cover_image">
                <button type="submit">Add Book</button>
            </form>

        </div>
    </div>

</body>
</html>
