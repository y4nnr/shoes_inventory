<?php
// db_connection.php

$servername = "localhost"; // Typically 'localhost'
$username = ""; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "shoes_inventory"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
