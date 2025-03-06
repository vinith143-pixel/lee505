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
    <title>Packages | Tourism Management System</title>
    <link href="css/style.css" rel='stylesheet' type='text/css' />

    <style>
        /* Special Note Styling */
        .special-note {
            background: #ffeb3b;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0px 4px 6px rgba(255, 193, 7, 0.3);
        }

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
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<!-- Special Note Section -->
<div class="container">
    <div class="special-note">
        <p>⚠️ <strong>Special Note:</strong> A package booking must have a minimum of 10 members. The cost of the package will differ as the number of members increases.</p>
    </div>
</div>

<!-- Packages List -->
<div class="container">
    <h2>All Tour Packages in Tamil Nadu</h2>
    <div class="package-list">
        <?php
        // Fetch all packages from the database
        $sql = "SELECT * FROM tbltourpackages";
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
        } else {
            echo "<p>No packages available at the moment.</p>";
        }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
