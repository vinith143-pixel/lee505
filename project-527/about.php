<?php
    include('includes/config.php'); // Include database connection if needed
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>About Us | Tour Booking System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .about-container {
            max-width: 1000px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .about-content h2, h3 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }
        .about-content p, ul, ol {
            color: #555;
            line-height: 1.6;
        }
        .about-content ul, .about-content ol {
            padding-left: 20px;
        }
        .about-content ul li, .about-content ol li {
            margin-bottom: 10px;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?> <!-- Including header section -->
    
    <div class="about-container">
        <div class="about-content">
            <h2>About Us</h2>
            <p>Welcome to the <strong>Tour Booking System</strong>, your ultimate travel companion. Our platform is designed to provide seamless travel experiences by offering a wide range of customizable tour packages that cater to different tastes and budgets.</p>
            
            <h3>Our Mission</h3>
            <p>We believe that traveling should be effortless and enjoyable. Our mission is to connect travelers with the best destinations, providing them with an easy-to-use booking system and personalized support. Whether you're looking for adventure, relaxation, or cultural experiences, we have something for everyone.</p>
            
            <h3>What We Offer</h3>
            <ul>
                <li><strong>Diverse Tour Packages:</strong> From tropical beaches to historical sites, we offer a variety of destinations to suit all travel preferences.</li>
                <li><strong>Hassle-Free Booking:</strong> Our streamlined booking process allows you to reserve your trip with just a few clicks.</li>
                <li><strong>24/7 Customer Support:</strong> Need assistance? Our dedicated support team is available round the clock to help you with inquiries.</li>
                <li><strong>Secure Payments:</strong> We ensure a safe and secure payment gateway for all transactions.</li>
                <li><strong>Custom Travel Plans:</strong> Want a personalized itinerary? Connect with us and we’ll craft a tour that fits your specific needs.</li>
            </ul>
            
            <h3>Why Choose Us?</h3>
            <p>We stand out from the crowd by offering a blend of affordability, reliability, and personalized service. Our platform is built with user-friendliness in mind, making travel planning a breeze.</p>
            <p>Here’s what makes us the best choice:</p>
            <ul>
                <li><strong>Experienced Team:</strong> Our travel experts curate the best experiences for you.</li>
                <li><strong>Customer Satisfaction:</strong> We prioritize your comfort and convenience at every step.</li>
                <li><strong>Exclusive Deals:</strong> Get access to discounts and special offers on various tour packages.</li>
                <li><strong>Comprehensive Travel Guides:</strong> Our blog section offers insights into destinations, travel tips, and more.</li>
            </ul>
            
            <h3>Meet Our Team</h3>
            <p>Our team consists of passionate travel enthusiasts, industry experts, and customer service professionals who work tirelessly to bring you the best travel experiences. With years of experience in tourism, we ensure that each trip booked through our platform is unforgettable.</p>
            
            <h3>How It Works</h3>
            <ol>
                <li><strong>Explore Packages:</strong> Browse through our extensive list of travel packages.</li>
                <li><strong>Select Your Destination:</strong> Choose a tour that matches your interests and budget.</li>
                <li><strong>Book with Ease:</strong> Fill in your details and confirm your booking in minutes.</li>
                <li><strong>Enjoy Your Trip:</strong> Pack your bags and get ready for an amazing journey.</li>
                <li><strong>Share Your Experience:</strong> Leave a review and let others know about your adventure.</li>
            </ol>
            
            <h3>Contact Us</h3>
            <p>Have questions or need help with your booking? Get in touch with us anytime through our <a href="contact.php">Contact</a> page. We’re always here to assist you!</p>
        </div>
    </div>
    
    <?php include('includes/footer.php'); ?> <!-- Including footer section -->
</body>
</html>