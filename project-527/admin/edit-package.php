<?php
session_start();
error_reporting(0);
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");  // Redirect to login page if not logged in
    exit;
}

// Get the PackageId from the URL
if (isset($_GET['id'])) {
    $packageId = $_GET['id'];

    // Fetch package details from the database
    $sql = "SELECT * FROM tbltourpackages WHERE PackageId = :packageId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':packageId', $packageId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if (!$result) {
        echo "<script>alert('Package not found!'); window.location='manage-packages.php';</script>";
        exit;
    }
}

if (isset($_POST['update'])) {
    // Get the updated values from the form
    $packageName = $_POST['packageName'];
    $packageLocation = $_POST['packageLocation'];
    $packageType = $_POST['packageType'];
    $packageFeatures = $_POST['packageFeatures'];
    $packagePrice = $_POST['packagePrice'];

    // Update the package details in the database
    $sql = "UPDATE tbltourpackages SET PackageName = :packageName, PackageLocation = :packageLocation, 
            PackageType = :packageType, PackageFetures = :packageFeatures, PackagePrice = :packagePrice 
            WHERE PackageId = :packageId";

    $query = $dbh->prepare($sql);
    $query->bindParam(':packageName', $packageName);
    $query->bindParam(':packageLocation', $packageLocation);
    $query->bindParam(':packageType', $packageType);
    $query->bindParam(':packageFeatures', $packageFeatures);
    $query->bindParam(':packagePrice', $packagePrice);
    $query->bindParam(':packageId', $packageId, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Package updated successfully!'); window.location='manage-packages.php';</script>";
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Edit Package | Admin Panel</title>
    <link href="../css/style.css" rel='stylesheet' type='text/css' />
</head>
<body>

<?php include('../includes/header.php'); ?>

<!-- Edit Package Form -->
<div class="container">
    <h2>Edit Package: <?php echo htmlentities($result->PackageName); ?></h2>
    
    <form method="POST">
        <label for="packageName">Package Name:</label>
        <input type="text" id="packageName" name="packageName" value="<?php echo htmlentities($result->PackageName); ?>" required>

        <label for="packageLocation">Package Location:</label>
        <input type="text" id="packageLocation" name="packageLocation" value="<?php echo htmlentities($result->PackageLocation); ?>" required>

        <label for="packageType">Package Type:</label>
        <input type="text" id="packageType" name="packageType" value="<?php echo htmlentities($result->PackageType); ?>" required>

        <label for="packageFeatures">Package Features:</label>
        <textarea id="packageFeatures" name="packageFeatures" required><?php echo htmlentities($result->PackageFetures); ?></textarea>

        <label for="packagePrice">Package Price (USD):</label>
        <input type="text" id="packagePrice" name="packagePrice" value="<?php echo htmlentities($result->PackagePrice); ?>" required>

        <button type="submit" name="update">Update Package</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>

</body>
</html>
