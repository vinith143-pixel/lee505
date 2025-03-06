<?php
// Database configuration settings
$host = 'localhost';  // your database server
$dbname = 'suma'; // database name
$username = 'root'; // your database username
$password = ''; // your database password (usually empty for localhost)

try {
    // Create a PDO connection
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch (PDOException $e) {
    // Handle errors if the connection fails
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
