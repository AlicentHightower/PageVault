<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'librari';

try {
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage()); 
}
?>