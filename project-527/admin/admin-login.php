<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the credentials
    $sql = "SELECT * FROM admin WHERE username = :username AND password = :password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);
    $query->execute();

    if ($query->rowCount() > 0) {
        // If valid, set session and redirect to admin dashboard
        $_SESSION['admin'] = $username;
        header("Location: admin-dashboard.php");
    } else {
        // If invalid, show an error message
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Login | Tour Booking System</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298); /* Deep blue gradient */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(12px);
            width: 350px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 26px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #fff;
            font-size: 14px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 16px;
            outline: none;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #56ccf2, #2f80ed); /* Light blue gradient */
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: linear-gradient(135deg, #2f80ed, #56ccf2); /* Reverse gradient on hover */
        }

        /* Back Button */
        .back-btn {
            display: block;
            margin-top: 10px;
            padding: 10px;
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body>

<!-- Admin Login Form -->
<div class="container">
    <h2>Admin Login</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter Username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter Password" required>

        <button type="submit" name="submit">Login</button>
    </form>

    <!-- Back Button -->
    <a href="../home.php" class="back-btn">Back</a>
</div>

</body>
</html>
