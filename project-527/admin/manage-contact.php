<?php
session_start();
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit;
}

// Fetch all contact messages from the database
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Contact Messages | Admin Panel</title>
    <link href="../css/style.css" rel='stylesheet' type='text/css' />
</head>
<body>


<div class="container">
    <h2>Contact Messages</h2>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $message) { ?>
                <tr>
                    <td><?php echo htmlentities($message->name); ?></td>
                    <td><?php echo htmlentities($message->email); ?></td>
                    <td><?php echo htmlentities($message->mobile); ?></td>
                    <td><?php echo htmlentities($message->message); ?></td>
                    <td><?php echo htmlentities($message->created_at); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Back Button to go back to Manage Packages -->
    <a href="admin-dashboard.php" class="btn">Back </a>
</div>

<?php include('../includes/footer.php'); ?>

</body>
</html>    