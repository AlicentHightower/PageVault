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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['update_book'])) {
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

                $sql = "UPDATE books SET title=?, author=?, description=?, cover_image=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $title, $author, $description, $cover_image, $id);

                if ($stmt->execute()) {
                    header("Location: index.php");
                    exit();
                } else {
                    $error_message = "Error updating record: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }

    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Edit Book</h1>

        <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        Title: <input type="text" name="title" value="<?php echo $book['title']; ?>"><span style="color: red;"><?php if(isset($title_error)) echo $title_error; ?></span><br>
        Author: <input type="text" name="author" value="<?php echo $book['author']; ?>"><span style="color: red;"><?php if(isset($author_error)) echo $author_error; ?></span><br>
        Description: <textarea name="description"><?php echo $book['description']; ?></textarea><span style="color: red;"><?php if(isset($description_error)) echo $description_error; ?></span><br>
        Cover Image: <input type="file" name="cover_image"><br>
        <input type="submit" name="update_book" value="Update">
    </form>
</body>
</html>
<?php
}
$conn->close();
?>