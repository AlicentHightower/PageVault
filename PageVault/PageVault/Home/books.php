<?php
include 'db.php';

$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $book_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Vault - Book Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a;
            color: #fff;
        }

        .background {
            background: url('Books.jpg') no-repeat center center fixed;
            background-size: cover; /* Or contain, depending on your preference */
            padding: 20px;
            min-height: 100vh; /* Ensures background covers the entire viewport */
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

        h3 {
            font-size: 24px;
            color: #ffd9b5;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #ddd;
        }

        .book-details {
            display: flex;
            justify-content: center; /* Center the content */
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .book-cover {
            display: none; /* Hide the cover image */
        }

        .book-info {
            max-width: 800px; /* Increased width for description */
        }

        .description {
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .details-link {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #ffcc00;
            color: #1a1a1a;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }

        .details-link:hover {
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
            <?php
            if ($result->num_rows > 0):
                $book = $result->fetch_assoc();
            ?>
                <h1><?= htmlspecialchars($book['title']) ?></h1>
                <h3>Author: <?= htmlspecialchars($book['author']) ?></h3>

                <div class="book-details">
                    <div class="book-info">
                        <p><strong>Description:</strong></p>
                        <div class="description">
                            <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                        </div>
                    </div>
                </div>

                <a href="index.php" class="details-link">Back to Home</a>

            <?php else: ?>
                <p>Book not found.</p>
            <?php endif; ?>

            <?php $conn->close(); ?>
        </div>

        <footer>
            <p>Creators: Egion Xerxa and Flaka Paloja</p>
            <p>Students at UBT College</p>
        </footer>
    </div>

</body>
</html>
