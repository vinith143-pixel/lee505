<?php
session_start();
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit;
}

// Fetch all users from the database
try {
    $sql = "SELECT * FROM users ORDER BY id DESC";
    $query = $dbh->prepare($sql);
    $query->execute();
    $users = $query->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    exit;
}

// Handle AJAX delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user"])) {
    $user_id = intval($_POST["delete_user"]);

    try {
        // Delete user from database
        $sql = "DELETE FROM users WHERE id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "success"; 
        } else {
            echo "error";
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users</title>
    <link href="../css/style.css" rel='stylesheet' type='text/css' />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 95%;
            max-width: 1200px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow-x: auto;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            table-layout: auto;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            white-space: nowrap;
        }
        th {
            background-color: #2980b9;
            color: white;
        }
        .btn-delete {
            background: #e74c3c;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-delete:hover {
            background: #c0392b;
        }
        .btn-back {
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 12px 24px;
            background-color: #2980b9;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-back:hover {
            background-color: #1f6391;
            transform: translateY(-2px);
        }
        .btn-back:active {
            background-color: #145374;
            transform: translateY(0);
        }
        @media (max-width: 768px) {
            th, td {
                font-size: 14px;
            }
            .btn-delete, .btn-back {
                padding: 8px 16px;
            }
        }
        @media (max-width: 480px) {
            th, td {
                font-size: 12px;
            }
            .btn-delete, .btn-back {
                padding: 6px 12px;
            }
        }
    </style>
    <script>
        function deleteUser(userId, row) {
            if (confirm("Are you sure you want to delete this user?")) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText.trim() === "success") {
                            alert("User deleted successfully!");
                            row.parentNode.removeChild(row);
                        } else {
                            alert("Error deleting user. Please try again.");
                        }
                    }
                };
                xhr.send("delete_user=" + userId);
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Manage Users</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr id="row-<?php echo $user->id; ?>">
                <td><?php echo htmlentities($user->id); ?></td>
                <td><?php echo htmlentities($user->name); ?></td>
                <td><?php echo htmlentities($user->email); ?></td>
                <td><?php echo htmlentities($user->phone); ?></td>
                <td>
                    <button class="btn-delete" onclick="deleteUser(<?php echo $user->id; ?>, document.getElementById('row-<?php echo $user->id; ?>'))">
                        Delete
                    </button>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="admin-dashboard.php" class="btn-back">Back</a>
</div>
</body>
</html>
