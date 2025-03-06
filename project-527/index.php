<?php
session_start();
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);

        $sql = "INSERT INTO users (name, email, phone) VALUES (:name, :email, :phone)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);

        if ($stmt->execute()) {
            header("Location: home.php");
            exit();
        } else {
            echo "<p style='color:red; text-align:center;'>Registration failed. Please try again.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red; text-align:center;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Background with Gradient */
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container Box */
        .container {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            width: 400px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            color: white;
        }

        /* Heading */
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Form Labels */
        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-top: 12px;
            color: #ddd;
        }

        /* Input Fields */
        input {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 2px solid #444;
            border-radius: 8px;
            font-size: 16px;
            background: #222;
            color: white;
            outline: none;
            transition: 0.3s;
        }

        /* Glowing Effect on Focus */
        input:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 10px #00bcd4;
        }

        /* Submit Button */
        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #00bcd4;
            color: white;
            border: none;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        /* Button Hover Effect */
        button:hover {
            background: #008ba3;
        }

        /* Responsive Design */
        @media (max-width: 500px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Registration</h2>
    <form action="home.php" method="POST">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter your full name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" name="phone" id="phone" placeholder="Enter your phone number" required>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>

<!-- CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL
);
 -->
