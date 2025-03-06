<?php
session_start();
error_reporting(0);
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit;
}

// Handle Delete Package
if (isset($_GET['delete'])) {
    $packageId = $_GET['delete'];

    // Delete the package from the database
    $sql = "DELETE FROM tbltourpackages WHERE PackageId = :packageId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':packageId', $packageId, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Package deleted successfully!'); window.location='manage-packages.php';</script>";
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Manage Packages | Admin Panel</title>
    <link href="../css/style.css" rel='stylesheet' type='text/css' />
    <style>
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>



<!-- Admin Dashboard -->
<div class="container">
    <h2>Welcome, Admin</h2>
    <p>Manage Tour Packages</p>

    <!-- Package Management Section -->
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Package Name</th>
                <th>Location</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch all packages from the database
        $sql = "SELECT * FROM tbltourpackages";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($results as $result) {
        ?>
            <tr>
                <td><?php echo htmlentities($result->PackageName); ?></td>
                <td><?php echo htmlentities($result->PackageLocation); ?></td>
                <td><?php echo htmlentities($result->PackagePrice); ?></td>
                <td>
                    <!-- Edit Link -->
                    <a href="edit-package.php?id=<?php echo htmlentities($result->PackageId); ?>">Edit</a> | 
                    <!-- Delete Link with Confirmation -->
                    <a href="manage-packages.php?delete=<?php echo htmlentities($result->PackageId); ?>" onclick="return confirm('Are you sure you want to delete this package?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- Logout Link -->
    <a href="admin-dashboard.php">Back</a>

</div>

<?php include('../includes/footer.php'); ?>

</body>
</html>
