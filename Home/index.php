<?php
include 'db.php';

$sql = "SELECT id, title, author, cover_image FROM books";
$result = $conn->query($sql);
?>