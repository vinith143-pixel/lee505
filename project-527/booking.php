<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if busid or pkgid is provided, determine which functionality to use
if (isset($_GET['busid'])) {
    $busid = $_GET['busid'];

    // Fetch bus details
    $sql = "SELECT * FROM tblbuses WHERE BusId = :busid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':busid', $busid, PDO::PARAM_INT);
    $query->execute();
    $bus = $query->fetch(PDO::FETCH_OBJ);

    if (!$bus) {
        echo "<script>alert('Bus not found!'); window.location='index.php';</script>";
        exit;
    }

    if (isset($_POST['book'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $num_seats = $_POST['num_seats'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $payment_status = 'Pending'; // Default payment status

        if ($num_seats < 1) {
            echo "<script>alert('At least one seat must be booked!');</script>";
        } else {
            // Check available seats
            $available_seats = $bus->TotalSeats - $bus->BookedSeats;
            if ($num_seats > $available_seats) {
                echo "<script>alert('Not enough seats available! Only $available_seats seats left.');</script>";
            } else {
                // Update booked seats
                $new_booked_seats = $bus->BookedSeats + $num_seats;
                $sql_update = "UPDATE tblbuses SET BookedSeats = :new_booked_seats WHERE BusId = :busid";
                $query_update = $dbh->prepare($sql_update);
                $query_update->bindParam(':new_booked_seats', $new_booked_seats, PDO::PARAM_INT);
                $query_update->bindParam(':busid', $busid, PDO::PARAM_INT);
                $query_update->execute();

                // Insert booking into the database
                $sql = "INSERT INTO tblbusbookings (BusId, Name, Email, Mobile, NumSeats, StartDate, EndDate, PaymentStatus) 
                        VALUES (:busid, :name, :email, :mobile, :num_seats, :start_date, :end_date, :payment_status)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':busid', $busid, PDO::PARAM_INT);
                $query->bindParam(':name', $name);
                $query->bindParam(':email', $email);
                $query->bindParam(':mobile', $mobile);
                $query->bindParam(':num_seats', $num_seats, PDO::PARAM_INT);
                $query->bindParam(':start_date', $start_date);
                $query->bindParam(':end_date', $end_date);
                $query->bindParam(':payment_status', $payment_status);

                if ($query->execute()) {
                    $booking_id = $dbh->lastInsertId(); // Get the booking ID
                    // Redirect to bus_booking.php after successful booking
                    header("Location: bus_booking.php?booking_id=$booking_id");
                    exit;
                } else {
                    echo "<script>alert('Booking failed!');</script>";
                }
            }
        }
    }
} elseif (isset($_GET['pkgid'])) {
    $pkgid = $_GET['pkgid'];

    // Fetch package details
    $sql = "SELECT * FROM tbltourpackages WHERE PackageId = :pkgid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pkgid', $pkgid, PDO::PARAM_INT);
    $query->execute();
    $package = $query->fetch(PDO::FETCH_OBJ);

    if (!$package) {
        echo "<script>alert('Package not found!'); window.location='index.php';</script>";
        exit;
    }

    if (isset($_POST['book'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $num_persons = $_POST['num_persons'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $tour_type = $_POST['tour_type'];
        $payment_status = 'Pending'; // Default payment status

        if ($num_persons < 10) {
            echo "<script>alert('Minimum of 10 members required for booking!');</script>";
        } else {
            // Insert booking into the database
            $sql = "INSERT INTO tblbookings (PackageId, Name, Email, Mobile, NumPersons, StartDate, EndDate, TourType, PaymentStatus) 
                    VALUES (:pkgid, :name, :email, :mobile, :num_persons, :start_date, :end_date, :tour_type, :payment_status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':pkgid', $pkgid, PDO::PARAM_INT);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':mobile', $mobile);
            $query->bindParam(':num_persons', $num_persons, PDO::PARAM_INT);
            $query->bindParam(':start_date', $start_date);
            $query->bindParam(':end_date', $end_date);
            $query->bindParam(':tour_type', $tour_type);
            $query->bindParam(':payment_status', $payment_status);

            if ($query->execute()) {
                $booking_id = $dbh->lastInsertId(); // Get the booking ID
                header("Location: bill.php?booking_id=$booking_id");
                exit;
            } else {
                echo "<script>alert('Booking failed!');</script>";
            }
        }
    }
} else {
    echo "<script>alert('No bus or package selected!'); window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Book Your Trip | Booking System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            color: #333;
            text-align: center;
        }
        .details {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .details h5 {
            margin: 5px 0;
            color: #007bff;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        p {
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($bus)): ?>
        <h2>Book Bus Ticket: <?php echo htmlentities($bus->BusName); ?></h2>

        <div class="details">
            <h5>Price: Rs <?php echo htmlentities($bus->TicketPrice); ?> per seat</h5>
            <p><strong>Route:</strong> <?php echo htmlentities($bus->Route); ?></p>
            <p><strong>Total Seats:</strong> <?php echo htmlentities($bus->TotalSeats); ?></p>
            <p><strong>Booked Seats:</strong> <?php echo htmlentities($bus->BookedSeats); ?></p>
            <p><strong>Available Seats:</strong> <?php echo htmlentities($bus->TotalSeats - $bus->BookedSeats); ?></p>
            <p><strong>Bus Features:</strong> <?php echo htmlentities($bus->BusFeatures); ?></p>
        </div>

        <h3>Your Information</h3>
        <form method="POST" onsubmit="return validateBusForm()">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" required>

            <label for="num_seats">Number of Seats:</label>
            <input type="number" id="num_seats" name="num_seats" min="1" required>

            <label for="start_date">Travel Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">Travel End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <button type="submit" name="book">Book Now</button>
        </form>
    <?php elseif (isset($package)): ?>
        <h2>Book Package: <?php echo htmlentities($package->PackageName); ?></h2>

        <div class="details">
            <h5>Price: Rs <?php echo htmlentities($package->PackagePrice); ?></h5>
            <p><strong>Location:</strong> <?php echo htmlentities($package->PackageLocation); ?></p>
            <p><strong>Features:</strong> <?php echo htmlentities($package->PackageFetures); ?></p>
        </div>

        <h3>Your Information</h3>
        <form method="POST" onsubmit="return validatePackageForm()">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" required>

            <label for="num_persons">Number of Persons:</label>
            <input type="number" id="num_persons" name="num_persons" min="10" required>

            <label for="start_date">Travel Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">Travel End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="tour_type">Tour Type:</label>
            <select id="tour_type" name="tour_type" required>
                <option value="Family">Family</option>
                <option value="School">School</option>
                <option value="College">College</option>
                <option value="Office">Office</option>
                <option value="Others">Others</option>
            </select>

            <button type="submit" name="book">Book Now</button>
        </form>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>

<script>
    function validateBusForm() {
        let numSeats = document.getElementById('num_seats').value;
        let availableSeats = <?php echo $bus->TotalSeats - $bus->BookedSeats; ?>;
        if (numSeats < 1) {
            alert('At least one seat must be booked!');
            return false;
        }
        if (numSeats > availableSeats) {
            alert('Not enough seats available! Only ' + availableSeats + ' seats left.');
            return false;
        }
        return true;
    }

    function validatePackageForm() {
        let numPersons = document.getElementById('num_persons').value;
        if (numPersons < 10) {
            alert('Minimum of 10 members required for booking!');
            return false;
        }
        return true;
    }
</script>

</body>
</html>
