<?php
session_start();
include('includes/config.php');

if (!isset($_GET['booking_id'])) {
    echo "<script>alert('Invalid Booking!'); window.location='index.php';</script>";
    exit;
}

$booking_id = $_GET['booking_id'];

// Fetch booking details
$sql = "SELECT b.*, p.PackageName, p.PackagePrice, p.PackageLocation 
        FROM tblbookings b
        JOIN tbltourpackages p ON b.PackageId = p.PackageId
        WHERE b.BookingId = :booking_id";
$query = $dbh->prepare($sql);
$query->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
$query->execute();
$booking = $query->fetch(PDO::FETCH_OBJ);

if (!$booking) {
    echo "<script>alert('Booking not found!'); window.location='index.php';</script>";
    exit;
}

// Pricing Calculation
$base_price = $booking->PackagePrice / 10; // Base price per person
$num_persons = $booking->NumPersons;
$total_price = $num_persons * $base_price;

$discount_percentage = 0;
if ($num_persons >= 15) {
    $discount_percentage = floor(($num_persons - 10) / 5) * 2;
}

// Additional discount for specific numbers
$mid_values = [13 => 1, 18 => 3, 23 => 5, 28 => 7, 33 => 9, 38 => 11, 43 => 13, 48 => 15, 53 => 17, 58 => 19];
if (isset($mid_values[$num_persons])) {
    $discount_percentage = $mid_values[$num_persons];
}

// Calculate Discount
$discount_amount = ($total_price * $discount_percentage) / 100;
$final_price = $total_price - $discount_amount;

// Store invoice in database
$insert_sql = "INSERT INTO tblinvoices (BookingId, CustomerName, Email, Mobile, PackageName, PackageLocation, 
                                        NumPersons, StartDate, EndDate, TourType, BasePrice, DiscountPercentage, 
                                        DiscountAmount, FinalAmount)
               VALUES (:booking_id, :customer_name, :email, :mobile, :package_name, :package_location, 
                       :num_persons, :start_date, :end_date, :tour_type, :base_price, :discount_percentage, 
                       :discount_amount, :final_price)";
$insert_query = $dbh->prepare($insert_sql);
$insert_query->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
$insert_query->bindParam(':customer_name', $booking->Name, PDO::PARAM_STR);
$insert_query->bindParam(':email', $booking->Email, PDO::PARAM_STR);
$insert_query->bindParam(':mobile', $booking->Mobile, PDO::PARAM_STR);
$insert_query->bindParam(':package_name', $booking->PackageName, PDO::PARAM_STR);
$insert_query->bindParam(':package_location', $booking->PackageLocation, PDO::PARAM_STR);
$insert_query->bindParam(':num_persons', $num_persons, PDO::PARAM_INT);
$insert_query->bindParam(':start_date', $booking->StartDate, PDO::PARAM_STR);
$insert_query->bindParam(':end_date', $booking->EndDate, PDO::PARAM_STR);
$insert_query->bindParam(':tour_type', $booking->TourType, PDO::PARAM_STR);
$insert_query->bindParam(':base_price', $base_price, PDO::PARAM_STR);
$insert_query->bindParam(':discount_percentage', $discount_percentage, PDO::PARAM_STR);
$insert_query->bindParam(':discount_amount', $discount_amount, PDO::PARAM_STR);
$insert_query->bindParam(':final_price', $final_price, PDO::PARAM_STR);
$insert_query->execute();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .invoice-container {
            width: 60%;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border: 3px solid #007bff;
        }
        h2, h3 {
            text-align: center;
            color: #007bff;
            margin-bottom: 5px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .invoice-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .column {
            width: 48%;
        }
        .column p {
            font-size: 16px;
            color: #333;
            font-weight: 500;
            margin: 5px 0;
            background: #fff;
            padding: 8px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .vertical-line {
            width: 2px;
            background-color: #007bff;
        }
        .total-amount {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
            color: #28a745;
        }
        .discount-info {
            text-align: center;
            font-size: 16px;
            color: #dc3545;
            font-weight: bold;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .button {
            width: 48%;
            background: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s ease;
            cursor: pointer;
            border: none;
        }
        .button:hover {
            background: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="invoice-container">
    <div class="invoice-header">
        <h2>Tourism Management System</h2>
        <h3>Booking Invoice</h3>
    </div>

    <div class="invoice-details">
        <div class="column">
            <p><strong>Booking ID        :</strong><?= $booking_id; ?></p>
            <p><strong>Customer Name     :</strong> <?= $booking->Name; ?></p>
            <p><strong>Email             :</strong><?= $booking->Email; ?></p>
            <p><strong>Mobile            :</strong><?= $booking->Mobile; ?></p>
            <p><strong>Package Name      :</strong> <?= $booking->PackageName; ?></p>
        </div>
        <div class="vertical-line"></div>
        <div class="column">
            <p><strong>Location          :</strong> <?= $booking->PackageLocation; ?></p>
            <p><strong>Number of Persons :</strong><?= $num_persons; ?></p>
            <p><strong>Start Date        :</strong><?= $booking->StartDate; ?></p>
            <p><strong>End Date          :</strong> <?= $booking->EndDate; ?></p>
            <p><strong>Tour Type         :</strong> <?= $booking->TourType; ?></p>
        </div>
    </div>

    <p class="total-amount">Base Price         : Rs <?= number_format($base_price, 2); ?></p>
    <p class="discount-info">Discount Applied  : <?= $discount_percentage; ?>% (Rs <?= number_format($discount_amount, 2); ?>)</p>
    <p class="total-amount">Final Amount       : Rs<?= number_format($final_price, 2); ?></p>
    <div class="button-container">
        <button class="button" id="confirm-button">Confirm</button>
        <button class="button" onclick="window.history.back();">Back</button>
    </div>
</div>

<div class="footer">
    <p>Thank you for booking with us!</p>
</div>

<script>
    document.getElementById('confirm-button').addEventListener('click', function() {
        // Display SweetAlert2 success message
        Swal.fire({
            icon: 'success',
            title: 'Your booking has been confirmed',
            showConfirmButton: false,
            timer: 2000
        }).then(function() {
            // Redirect or perform any additional actions after confirmation
            window.location.href = 'home.php';
        });
    });
</script>

</body>
</html>

