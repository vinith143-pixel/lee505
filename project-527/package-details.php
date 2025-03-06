<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_GET['pkgid'])) {
    $pkgid = $_GET['pkgid'];

    // Fetch the package details from the database
    $sql = "SELECT * FROM tbltourpackages WHERE PackageId = :pkgid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pkgid', $pkgid, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Package Details | Tourism Management System</title>
    <link href="css/style.css" rel='stylesheet' type='text/css' />
</head>
<body>

<?php include('includes/header.php'); ?>

<!-- Package Details Section -->
<div class="container">
    <?php if ($result) { ?>
    <div class="package-details-page">
        <div class="package-img">
            <img src="admin/packageimages/<?php echo htmlentities($result->PackageImage); ?>" alt="Package Image">
        </div>
        <div class="package-details">
            <h2><?php echo htmlentities($result->PackageName); ?></h2>
            <h4>Location: <?php echo htmlentities($result->PackageLocation); ?></h4>
            <p><strong>Package Features:</strong> <?php echo htmlentities($result->PackageFetures); ?></p>
            <p><strong>Price:</strong> USD <?php echo htmlentities($result->PackagePrice); ?></p>
        </div>
    </div>
    <?php } else {
        echo "<p>Package not found.</p>";
    } ?>
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
