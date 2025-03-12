<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Footer Section | Tour Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        /* Footer Styling */
        footer {
            background-color: #2c3e50;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 1rem;
            position: relative;
            bottom: 0;
            left: 0;
            width: 100%;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
        }

        footer p {
            margin: 0;
            font-size: 1.1rem;
            color: #ecf0f1;
        }

        footer a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            margin-left: 10px;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #2980b9;
        }

        /* Social Media Links */
        .social-links {
            margin-top: 10px;
        }

        .social-links a {
            font-size: 1.5rem;
            margin: 0 15px;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .social-links a:hover {
            color: #3498db;
            transform: scale(1.1);
        }

        /* Responsive Design for Footer */
        @media (max-width: 768px) {
            footer p {
                font-size: 1rem;
            }

            .social-links {
                margin-top: 15px;
            }

            .social-links a {
                font-size: 1.3rem;
                margin: 0 10px;
            }
        }
    </style>
</head>
<body>
    <footer>
        <p>&copy; 2025 Tour Booking System | All Rights Reserved</p>
        <p>Created with <span style="color: red;">&#10084;</span> by Your Company</p>
        
        <div class="social-links">
            <a href="https://www.facebook.com" target="_blank" title="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="https://www.twitter.com" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com" target="_blank" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
        </div>

        <p>Visit our <a href="about.php">About Us</a> page for more information!</p>
    </footer>

    <!-- Add FontAwesome CDN for social media icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
