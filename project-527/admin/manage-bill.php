<?php
session_start();
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit;
}

// Fetch all invoices
$sql = "SELECT i.*, b.Name, b.Email, b.Mobile, b.StartDate, b.EndDate, b.NumPersons, p.PackageName, p.PackageLocation
        FROM tblinvoices i
        JOIN tblbookings b ON i.BookingId = b.BookingId
        JOIN tbltourpackages p ON b.PackageId = p.PackageId
        ORDER BY i.CreatedAt DESC";
$query = $dbh->prepare($sql);
$query->execute();
$invoices = $query->fetchAll(PDO::FETCH_OBJ);

// Handle AJAX delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_invoice"])) {
    $invoice_id = intval($_POST["delete_invoice"]); // Secure the input

    try {
        // Delete invoice from database
        $sql = "DELETE FROM tblinvoices WHERE InvoiceId = :invoice_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':invoice_id', $invoice_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "success"; // Sending only 'success' to avoid unwanted output
        } else {
            echo "error";
        }
    } catch (PDOException $e) {
        echo "Database Error";
    }
    exit(); // Ensure no extra output is sent
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Bills</title>
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
            max-width: 1400px;
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
        function deleteInvoice(invoiceId, row) {
            if (confirm("Are you sure you want to delete this invoice?")) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText.trim() === "success") {
                            alert("Invoice deleted successfully!");
                            row.parentNode.removeChild(row); // Remove row from table
                        } else {
                            alert("Error deleting invoice. Please try again.");
                        }
                    }
                };
                xhr.send("delete_invoice=" + invoiceId);
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Manage Bills</h2>
    <table>
        <tr>
            <th>Invoice ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>No. of Persons</th>
            <th>Package</th>
            <th>Location</th>
            <th>Discount (%)</th>
            <th>Final Amount (Rs)</th>
            <th>Action</th>
        </tr>
        <?php foreach ($invoices as $invoice) { ?>
            <tr id="row-<?php echo $invoice->InvoiceId; ?>">
                <td><?php echo htmlentities($invoice->InvoiceId); ?></td>
                <td><?php echo htmlentities($invoice->Name); ?></td>
                <td><?php echo htmlentities($invoice->Email); ?></td>
                <td><?php echo htmlentities($invoice->Mobile); ?></td>
                <td><?php echo htmlentities($invoice->StartDate); ?></td>
                <td><?php echo htmlentities($invoice->EndDate); ?></td>
                <td><?php echo htmlentities($invoice->NumPersons); ?></td>
                <td><?php echo htmlentities($invoice->PackageName); ?></td>
                <td><?php echo htmlentities($invoice->PackageLocation); ?></td>
                <td><?php echo htmlentities($invoice->DiscountPercentage); ?>%</td>
                <td><?php echo htmlentities($invoice->FinalAmount); ?></td>
                <td>
                    <button class="btn-delete" onclick="deleteInvoice(<?php echo $invoice->InvoiceId; ?>, document.getElementById('row-<?php echo $invoice->InvoiceId; ?>'))">
                        Delete
                    </button>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div>
<a href="admin-dashboard.php" class="btn-back">Back</a>
</div>
</body>
</html>
