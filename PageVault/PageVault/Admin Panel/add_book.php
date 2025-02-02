<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to your login page
    exit();
}

include '../db.php';
include 'upload.php';
include 'validate.php';

$error_message = "";

if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];

        $title_error = validate_title($title);
        $author_error = validate_author($author);
        $description_error = validate_description($description);

        if (empty($title_error) && empty($author_error) && empty($description_error)) {
            $cover_image = handle_image_upload($_FILES['cover_image']);

            if ($cover_image === false) {
                $error_message = "Image upload failed.";
            } else {
                $sql = "INSERT INTO books (title, author, description, cover_image) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $title, $author, $description, $cover_image);

                if ($stmt->execute()) {
                    header("Location: index.php");
                    exit();
                } else {
                    $error_message = "Error adding record: " . $stmt->error;
                }
                $stmt->close();
            }
        }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Add New Book</h1>

    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        Title: <input type="text" name="title" value="<?php if(isset($title)) echo $title; ?>"><span style="color: red;"><?php if(isset($title_error)) echo $title_error; ?></span><br>
        Author: <input type="text" name="author" value="<?php if(isset($author)) echo $author; ?>"><span style="color: red;"><?php if(isset($author_error)) echo $author_error; ?></span><br>
        Description: <textarea name="description"><?php if(isset($description)) echo $description; ?></textarea><span style="color: red;"><?php if(isset($description_error)) echo $description_error; ?></span><br>
        Cover Image: <input type="file" name="cover_image"><br>
        <input type="submit" name="add_book" value="Add Book">
    </form>
</body>
</html>
<?php $conn->close(); ?>