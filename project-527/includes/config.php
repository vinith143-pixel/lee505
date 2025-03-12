<?php
$host = 'localhost'; // Typically 'localhost' for local development
$dbname = 'suma';    // Your database name
$username = 'root';  // Default username for XAMPP (MySQL)
$password = '';      // Default password for XAMPP (MySQL) is empty

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
