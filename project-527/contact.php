<?php
// Include database configuration
include('includes/config.php');

// Handle the form submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert the contact message into the database
    $sql = "INSERT INTO contact_messages (name, mobile, email, message) 
            VALUES (:name, :mobile, :email, :message)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name);
    $query->bindParam(':mobile', $mobile);
    $query->bindParam(':email', $email);
    $query->bindParam(':message', $message);
    
    if ($query->execute()) {
        echo "<script>alert('Your message has been sent successfully!');</script>";
    } else {
        echo "<script>alert('There was an error sending your message. Please try again.');</script>";
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Contact Us | TMS</title>
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <style>
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .contact-form button {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .contact-form button:hover {
            background-color: #45a049;
        }
        .social-links {
            text-align: center;
            margin-top: 20px;
        }
        .social-links a {
            margin: 0 10px;
            font-size: 24px;
            color: #333;
            text-decoration: none;
        }
        .social-links a:hover {
            color: #4CAF50;
        }
        .home-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .home-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <?php include('includes/header.php'); ?>

    <!-- Contact Form Section -->
    <div class="container">
        <h2>Contact Us</h2>
        <p>Feel free to share your thoughts or ask questions. We'll get back to you as soon as possible!</p>

        <div class="contact-form">
            <form method="POST">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="text" name="mobile" placeholder="Your Mobile Number" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                <button type="submit" name="submit">Send Message</button>
            </form>
        </div>
        <!-- Home Button -->
        <a href="home.php" class="home-btn">Back to Home</a>
    </div>
</body>
</html>   