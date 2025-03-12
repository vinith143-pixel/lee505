<?php
session_start();
include('includes/config.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Sanitize form inputs
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);

        // Prepare SQL query
        $sql = "INSERT INTO users (name, email, phone) VALUES (:name, :email, :phone)";
        $stmt = $dbh->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);

        // Execute the query and check if it is successful
        if ($stmt->execute()) {
            // Redirect to home page after successful registration
            header("Location: home.php");
            exit();
        } else {
            // If execution fails, display an error message
            echo "<p style='color:red; text-align:center;'>Registration failed. Please try again.</p>";
        }
    } catch (PDOException $e) {
        // Display error message if there is an exception
        echo "<p style='color:red; text-align:center;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>
