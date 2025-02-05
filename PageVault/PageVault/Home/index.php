<?php
session_start();
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
    <style>
        .slider {
            position: relative;
            width: 80%;
            margin: 20px auto;
            overflow: hidden;
        }

        .slides-container {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            position: relative;
        }

        .slide img {
            width: 100%;
            height: auto;
            display: block;
        }

        .slide-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            text-align: center;
            width: 80%;
        }

        .slide-text h2 {
            margin-bottom: 10px;
        }

        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            z-index: 1;
        }

        .left {
            left: 10px;
        }

        .right {
            right: 10px;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px; 
            transition: background-color 0.3s ease; 
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2); 
        }

    </style>
</head>
<body>
    <div class="background">
        <header class="header">
            <h1>Welcome to Page Vault</h1>
            <p>Your gateway to exploring the world of books!</p>
        </header>

        <nav style="display: flex; justify-content: flex-start; background-color: #6a4f4b; padding: 20px 40px; width: 100%; margin-bottom: 30px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <ul style="list-style: none; margin: 0; padding: 0; display: flex; gap: 40px; align-items: center;">
                <li><a href="../Checkout/checkout.html" class="nav-link">Checkout</a></li>
                <li><a href="../Contact%20us/contact.html" class="nav-link">Contact Us</a></li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="../Admin/admin_dashboard.php" class="nav-link">Admin Dashboard</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="logout.php" class="nav-link">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
                <?php else: ?>
                    <li><a href="../Login%20and%20Register/index.html" class="nav-link">Login / Sign In</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="slider">
            <div class="slides-container">
                <div class="slide">
                    <img src="img/slider1.png" alt="Discover New Worlds" loading="lazy">
                    <div class="slide-text">
                        <h2>Discover New Worlds</h2>
                        <p>Explore our collection of thrilling books.</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="img/slider2.png" alt="Read Anywhere" loading="lazy">
                    <div class="slide-text">
                        <h2>Read Anywhere</h2>
                        <p>Find your next adventure, anytime, anywhere.</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="img/slider3.png" alt="Timeless Classics" loading="lazy">
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
                <input type="text" id="search" placeholder="Search for books, articles, or authors..." onkeyup="searchBooks()">
                <button onclick="searchBooks()">Search</button>
            </div>
            <div class="book-list" id="book-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php $image_path = "../Admin/uploads/" . htmlspecialchars($row['cover_image']); ?>
                        <a href="books.php?id=<?= $row['id'] ?>" class="book">
                            <img src="<?= $image_path ?>" alt="<?= htmlspecialchars($row['title']) ?>">
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
        const slidesContainer = document.querySelector('.slides-container');
        const totalSlides = slides.length;

        function showSlide(n) {
            slidesContainer.style.transform = `translateX(-${n * 100}%)`;
        }

        function moveSlide(n) {
            currentSlide = (currentSlide + n + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        showSlide(currentSlide);
    </script>
</body>
</html>