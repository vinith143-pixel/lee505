<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if (isset($_POST['submit'])) {
    $PackageName = $_POST['PackageName'];
    $PackageType = $_POST['PackageType'];
    $PackageLocation = $_POST['PackageLocation'];
    $PackageFetures = $_POST['PackageFetures'];
    $PackagePrice = $_POST['PackagePrice'];
    $PackageImage = $_FILES['PackageImage']['name'];

    move_uploaded_file($_FILES['PackageImage']['tmp_name'], "packageimages/" . $PackageImage);

    // Insert the package data into the database
    $sql = "INSERT INTO tbltourpackages (PackageName, PackageType, PackageLocation, PackageFetures, PackagePrice, PackageImage) 
            VALUES (:PackageName, :PackageType, :PackageLocation, :PackageFetures, :PackagePrice, :PackageImage)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':PackageName', $PackageName);
    $query->bindParam(':PackageType', $PackageType);
    $query->bindParam(':PackageLocation', $PackageLocation);
    $query->bindParam(':PackageFetures', $PackageFetures);
    $query->bindParam(':PackagePrice', $PackagePrice);
    $query->bindParam(':PackageImage', $PackageImage);
    
    if ($query->execute()) {
        echo "<script>alert('Package added successfully!');</script>";
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add Package | Admin</title>
    <link href="../css/style.css" rel='stylesheet' type='text/css' />
</head>
<body>


<!-- Add Package Form -->
<div class="container">
    <h2>Add New Tour Package</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="PackageName">Package Name:</label>
        <input type="text" id="PackageName" name="PackageName" required>

        <label for="PackageType">Package Type:</label>
        <input type="text" id="PackageType" name="PackageType" required>

        <label for="PackageLocation">Location:</label>
        <input type="text" id="PackageLocation" name="PackageLocation" required>

        <label for="PackageFetures">Features:</label>
        <textarea id="PackageFetures" name="PackageFetures" required></textarea>

        <label for="PackagePrice">Price (USD):</label>
        <input type="number" id="PackagePrice" name="PackagePrice" required>

        <label for="PackageImage">Upload Package Image:</label>
        <input type="file" id="PackageImage" name="PackageImage" required>

        <button type="submit" name="submit">Add Package</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>

</body>
</html>
