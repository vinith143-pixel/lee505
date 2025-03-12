<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>LDK-Tour Booking System</title>
    <link href="css/style.css" rel='stylesheet' type='text/css' />

    <style>
        /* Buttons Styling */
        .buttons {
            margin-top: 10px;
        }

        .view, .book {
            display: inline-block;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .view {
            background: linear-gradient(135deg, #007BFF, #0056b3);
            color: white;
            border: none;
            box-shadow: 0px 4px 6px rgba(0, 123, 255, 0.3);
        }

        .view:hover {
            background: linear-gradient(135deg, #0056b3, #004494);
            box-shadow: 0px 5px 10px rgba(0, 123, 255, 0.5);
            transform: translateY(-2px);
        }

        .book {
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
            border: none;
            margin-left: 10px;
            box-shadow: 0px 4px 6px rgba(40, 167, 69, 0.3);
        }

        .book:hover {
            background: linear-gradient(135deg, #1e7e34, #155724);
            box-shadow: 0px 5px 10px rgba(40, 167, 69, 0.5);
            transform: translateY(-2px);
        }

        /* Special Note Styling */
        .special-note {
            margin-top: 20px;
            text-align: center;
        }

        .note-box {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #ffeeba;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0px 4px 6px rgba(255, 193, 7, 0.3);
            max-width: 600px;
            margin: 0 auto 20px auto;
        }
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<!-- Hero Section (Banner) -->
<div class="banner">
    <div class="container">
        <h1>Welcome to LDK - Tour Booking System</h1>
        <p>Explore the best of India with our curated tour packages.</p>
        <a href="package-list.php" class="view">View Tour Packages</a>
    </div>
</div>

<!-- Introduction Section -->
<div class="container intro">
    <h2>About LDK</h2>
    <p>Tour Booking System (LDK) is a comprehensive platform to help you explore and book exciting tour packages in Tamil Nadu. Whether you're looking for a serene hill station experience, a cultural temple tour, or a relaxing beach vacation, we have something for everyone!</p>
</div>

<!-- Special Note Section (Moved Above Featured Packages) -->
<div class="container special-note">
    <div class="note-box">
        <h3>Special Note:</h3>
        <p>
            📢 <strong>Important:</strong> All tour packages require a minimum of <strong>10 members</strong> to be booked.
            The cost of the package will <strong>differ</strong> as the number of members in the group increases. 
            Plan your trip with more people and enjoy a <strong>discounted price!</strong> 🎉
        </p>
    </div>
</div>

<!-- Featured Packages Section -->
<div class="container featured-packages">
    <h3>Featured Tour Packages in Tamil Nadu</h3>
    <div class="package-list">
        <?php
        // Fetch random 4 packages
        $sql = "SELECT * FROM tbltourpackages ORDER BY rand() LIMIT 4";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
        ?>
            <div class="package-card">
                <div class="package-img">
                    <img src="admin/packageimages/<?php echo htmlentities($result->PackageImage); ?>" alt="Package Image">
                </div>
                <div class="package-details">
                    <h4><?php echo htmlentities($result->PackageName); ?></h4>
                    <h6>Location: <?php echo htmlentities($result->PackageLocation); ?></h6>
                    <p><strong>Features:</strong> <?php echo htmlentities($result->PackageFetures); ?></p>
                    <h5>Price: Rs <?php echo htmlentities($result->PackagePrice); ?></h5>
                    <div class="buttons">
                        <a href="package-details.php?pkgid=<?php echo htmlentities($result->PackageId); ?>" class="view">View Details</a>
                        <a href="booking.php?pkgid=<?php echo htmlentities($result->PackageId); ?>" class="book">Book Now</a>
                    </div>
                </div>
            </div>
        <?php
            }
        }
        ?>
    </div>
    <div class="view-more-btn">
        <a href="package-list.php" class="view">Explore More Packages</a>
    </div>
</div>

<!-- Testimonials Section -->
<div class="container testimonials">
    <h3>What Our Tourists Say</h3>
    <div class="testimonial-cards">
        <div class="testimonial-card">
            <p>"An unforgettable experience! LDK made our trip to Ooty easy and hassle-free. Highly recommend the services."</p>
            <h5>- Sarah, USA</h5>
        </div>
        <div class="testimonial-card">
            <p>"I booked a family trip to Kodaikanal with LDK. The entire process was smooth, and we had an amazing time!"</p>
            <h5>- Rajesh, India</h5>
        </div>
        <div class="testimonial-card">
            <p>"Rameswaram Temple tour was beautiful. LDK took care of everything, from bookings to transportation."</p>
            <h5>- John, UK</h5>
        </div>
    </div>
</div>

<!-- Call to Action Section -->
<div class="cta">
    <div class="container">
        <h2>Ready to Explore Tamil Nadu?</h2>
        <p>Start your journey today by exploring our tour packages. Choose your destination, and let us handle the rest!</p>
        <a href="package-list.php" class="view">Explore Packages Now</a>
    </div>
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
