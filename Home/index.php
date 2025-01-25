<?php
include 'db.php';

$sql = "SELECT id, title, author, cover_image FROM books";
$result = $conn->query($sql);
?>
<?php
include 'db.php';

$sql = "SELECT id, title, author, cover_image FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Vault - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="background">
        <header class="header">
            <h1>Welcome to Page Vault</h1>
            <p>Your gateway to exploring the world of books!</p>
        </header>

        <div class="slider">
            <div class="slides">
                <div class="slide">
                    <img src="http://localhost/PROJEKTI%20I%20GRETES/PageVault/Home/img/slider1.png" alt="Discover New Worlds">
                    <div class="slide-text">
                        <h2>Discover New Worlds</h2>
                        <p>Explore our collection of thrilling books.</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="http://localhost/PROJEKTI%20I%20GRETES/PageVault/Home/img/slider2.png" alt="Read Anywhere">
                    <div class="slide-text">
                        <h2>Read Anywhere</h2>
                        <p>Find your next adventure, anytime, anywhere.</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="http://localhost/PROJEKTI%20I%20GRETES/PageVault/Home/img/slider3.png" alt="Timeless Classics">
                    <div class="slide-text">
                        <h2>Timeless Classics</h2>
                        <p>Dive into books that have stood the test of time.</p>
                    </div>
                </div>
            </div>
            <button class="slider-arrow left" onclick="moveSlide(-1)">&#10094;</button>
            <button class="slider-arrow right" onclick="moveSlide(1)">&#10095;</button>
        </div>

        <div class="form-container">
            <div class="search-bar">
                <input type="text" placeholder="Search for books, articles, or authors...">
                <button>Search</button>
            </div>
            <div class="book-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <a href="books.php?id=<?= $row['id'] ?>" class="book">
                            <img src="placeholder.jpg" alt="<?= htmlspecialchars($row['title']) ?>">
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p>by <?= htmlspecialchars($row['author']) ?></p>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No books found.</p>
                <?php endif; ?>
                <?php $conn->close(); ?>
            </div>
        </div>

        <footer class="footer">
            <div class="footer-container">
                <div class="footer-column">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Contact Us</h4>
                    <ul>
                        <li>Email: info@pagevault.com</li>
                        <li>Phone: +123 456 7890</li>
                        <li>Address: 123 Book Street, Library City</li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Follow Us</h4>
                    <div class="footer-socials">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <p class="footer-tagline">© 2025 Page Vault - Your gateway to exploring the world of books!</p>
        </footer>
    </div>
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');

        function moveSlide(direction) {
            slides[currentSlide].style.display = 'none';
            currentSlide = (currentSlide + direction + slides.length) % slides.length;
            slides[currentSlide].style.display = 'flex';
        }

        slides[currentSlide].style.display = 'flex';
    </script>
</body>
</html>
