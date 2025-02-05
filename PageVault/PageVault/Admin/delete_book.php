<?php
session_start();
include __DIR__ . '/../Home/db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}


if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = intval($_GET['id']);


$sql = "DELETE FROM books WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_dashboard.php?message=Book deleted successfully");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
