<?php
session_start();
include __DIR__ . '/../Home/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $description = $conn->real_escape_string($_POST['description']);
    $cover_image = 'placeholder.jpg';

    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $upload_dir = __DIR__ . '/uploads/';
        $file_tmp = $_FILES['cover_image']['tmp_name'];
        $file_name = basename($_FILES['cover_image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($_FILES['cover_image']['type'], $allowed_types)) {
            $new_file_name = uniqid('cover_', true) . '.' . $file_ext;
            $upload_path = $upload_dir . $new_file_name;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($file_tmp, $upload_path)) {
                $cover_image = $new_file_name;
            } else {
                echo "Error uploading file.";
                exit();
            }
        } else {
            echo "Invalid file type. Please upload a JPG, PNG, or GIF image.";
            exit();
        }
    }

    $sql = "INSERT INTO books (title, author, description, cover_image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $title, $author, $description, $cover_image);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?message=Book added successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Add a New Book</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="file" name="cover_image">
        <button type="submit">Add Book</button>
    </form>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
