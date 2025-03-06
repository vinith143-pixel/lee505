<?php
session_start();
// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");  // Redirect to login page if not logged in
    exit;
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Dashboard</title>
    <link href="../css/style.css" rel='stylesheet' type='text/css' />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Header */
        header {
            background-color: #2980b9;
            color: white;
            text-align: center;
            padding: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 36px;
        }

        header .sub-header {
            font-size: 18px;
            margin-top: 5px;
        }

        /* Sidebar */
        .sidebar {
            background-color: #34495e;
            color: white;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 24px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 10px;
            text-align: center;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #2c3e50;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .dashboard-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .card {
            background-color: #ddd;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            flex: 1 1 calc(50% - 10px); /* Ensures two cards per row */
            min-width: 200px;
        }

        .card.primary { background-color: #3498db; }
        .card.success { background-color: #2ecc71; }
        .card.warning { background-color: #f39c12; }
        .card.info { background-color: #9b59b6; }

        /* Quick Actions */
        .quick-actions {
            margin-top: 20px;
            display: flex;
            gap: 20px;
        }

        .btn {
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            text-align: center;
            display: block;
            border-radius: 5px;
            flex: 1;
        }

        .btn.primary { background-color: #2980b9; }
        .btn.secondary { background-color: #2c3e50; }
        .btn:hover { opacity: 0.8; }
    </style>
</head>
<body>

<header>
    <h1>Welcome, Admin!</h1>
    <div class="sub-header">TMS Management</div>
</header>

<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <ul>
        <li><a href="manage-user.php">User Details</a></li>
        <li><a href="manage-packages.php">Manage Packages</a></li>
        <li><a href="add-package.php">Add New Package</a></li>
        <li><a href="manage-contact.php">Manage Contact Messages</a></li>
        <li><a href="manage-bill.php">Manage Bills</a></li>
        <li><a href="logout.php" class="text-danger">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="dashboard-cards">
        <div class="card primary">
            <h5>Total Packages</h5>
            <p>
                <?php
                include('../includes/config.php');
                $sql = "SELECT COUNT(*) AS total FROM tbltourpackages";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                echo $result->total;
                ?>
            </p>
        </div>
        
        <div class="card success">
            <h5>Total Messages</h5>
            <p>
                <?php
                $sql = "SELECT COUNT(*) AS total FROM contact_messages";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                echo $result->total;
                ?>
            </p>
        </div>
        
        <div class="card warning">
            <h5>Total Bills</h5>
            <p>
                <?php
                $sql = "SELECT COUNT(*) AS total FROM tblinvoices";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                echo $result->total;
                ?>
            </p>
        </div>
        
        <div class="card info">
            <h5>Total Users</h5>
            <p>
                <?php
                $sql = "SELECT COUNT(*) AS total FROM users";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                echo $result->total;
                ?>
            </p>
        </div>
    </div>

    <h3>Quick Actions</h3>
    <div class="quick-actions">
        <a href="add-package.php" class="btn primary">Add New Package</a>
        <a href="manage-packages.php" class="btn secondary">Manage Packages</a>
    </div>
</div>

</body>
</html>
