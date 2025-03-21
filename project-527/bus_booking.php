<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (!isset($_GET['pkgid'])) {
    echo "<script>alert('Package not found!'); window.location='index.php';</script>";
    exit;
}

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
    $bus_type = $_POST['bus_type'];
    $arrival_date = $_POST['arrival_date'];
    $departure_date = $_POST['departure_date'];
    $payment_status = 'Pending'; // Default payment status

    // Fetch the current booking data for this package
    $sqlSeats = "SELECT SUM(NumPersons) as total_booked_seats FROM tblbookings WHERE PackageId = :pkgid";
    $querySeats = $dbh->prepare($sqlSeats);
    $querySeats->bindParam(':pkgid', $pkgid, PDO::PARAM_INT);
    $querySeats->execute();
    $resultSeats = $querySeats->fetch(PDO::FETCH_OBJ);

    // If no bookings, set total_booked_seats to 0
    $total_booked_seats = $resultSeats->total_booked_seats ? $resultSeats->total_booked_seats : 0;

    // Available seats calculation: Total seats in the package minus booked seats
    $available_seats = $package->TotalSeats - $total_booked_seats;

    // Check for booking conditions
    if ($num_persons < 5) {
        echo "<script>alert('At least 5 members must be booked!');</script>";
    } elseif ($num_persons > 60) {
        echo "<script>alert('A maximum of 60 members can be booked!');</script>";
    } elseif ($num_persons > $available_seats) {
        echo "<script>alert('Not enough seats available! Only " + $available_seats + " seats left.');</script>";
    } else {
        // Insert booking into the database
        $sql = "INSERT INTO tblbookings (PackageId, Name, Email, Mobile, NumPersons, StartDate, EndDate, ArrivalDate, DepartureDate, TourType, BusType, BusSeats, PaymentStatus) 
                VALUES (:pkgid, :name, :email, :mobile, :num_persons, :start_date, :end_date, :arrival_date, :departure_date, :tour_type, :bus_type, 60, :payment_status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pkgid', $pkgid, PDO::PARAM_INT);
        $query->bindParam(':name', $name);
        $query->bindParam(':email', $email);
        $query->bindParam(':mobile', $mobile);
        $query->bindParam(':num_persons', $num_persons, PDO::PARAM_INT);
        $query->bindParam(':start_date', $start_date);
        $query->bindParam(':end_date', $end_date);
        $query->bindParam(':arrival_date', $arrival_date);
        $query->bindParam(':departure_date', $departure_date);
        $query->bindParam(':tour_type', $tour_type);
        $query->bindParam(':bus_type', $bus_type);
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
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Book Your Bus Ticket | Bus Ticket Booking System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 60%;
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
        .bus-details {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .bus-details h5 {
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
    <h2>Book Package: <?php echo htmlentities($package->PackageName); ?></h2>

    <div class="package-details">
        <h5>Price: Rs <?php echo htmlentities($package->Price); ?> per person</h5>
        <p><strong>Tour Destination:</strong> <?php echo htmlentities($package->TourDestination); ?></p>
        <p><strong>Total Seats:</strong> 60</p>
        <p><strong>Booked Seats:</strong> <?php echo htmlentities($total_booked_seats); ?></p>
        <p><strong>Available Seats:</strong> <?php echo htmlentities($available_seats); ?></p>
    </div>

    <p><strong>⚠️ Special Note:</strong> Please ensure you select the available seats.</p>

    <h3>Your Information</h3>
    <form method="POST" onsubmit="return validateForm()">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="mobile">Mobile Number:</label>
        <input type="text" id="mobile" name="mobile" required>

        <label for="num_persons">Number of Persons:</label>
        <input type="number" id="num_persons" name="num_persons" min="5" max="60" required>

        <label for="start_date">Travel Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">Travel End Date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <label for="arrival_date">Arrival Date and Time:</label>
        <input type="datetime-local" id="arrival_date" name="arrival_date" required>

        <label for="departure_date">Departure Date and Time:</label>
        <input type="datetime-local" id="departure_date" name="departure_date" required>

        <label for="tour_type">Tour Type:</label>
        <select id="tour_type" name="tour_type" required>
            <option value="Family">Family</option>
            <option value="School">School</option>
            <option value="College">College</option>
            <option value="Office">Office</option>
            <option value="Others">Others</option>
        </select>

        <label for="bus_type">Bus Type:</label>
        <select id="bus_type" name="bus_type" required>
            <option value="Luxury">Luxury</option>
            <option value="Standard">Standard</option>
            <option value="Sleeper">Sleeper</option>
            <option value="Economy">Economy</option>
        </select>

        <label for="route">Route:</label>
        <select id="route" name="route" required>
            <?php
            $districts = [
                'Chennai', 'Coimbatore', 'Madurai', 'Salem', 'Tiruchirapalli', 'Vellore', 'Erode', 'Tirunelveli', 'Thanjavur',
                'Tiruppur', 'Dindigul', 'Villupuram', 'Cuddalore', 'Karur', 'Kanchipuram', 'Nagapattinam', 'Theni', 'Ramanathapuram',
                'Kanyakumari', 'Sivaganga', 'Virudhunagar', 'Nagercoil', 'Pudukkottai', 'Karaikal', 'Pondicherry'
            ];
            foreach ($districts as $district) {
                echo "<option value='$district'>$district</option>";
            }
            ?>
        </select>

        <button type="submit" name="book">Book Now</button>
    </form>
</div>

<script>
    function validateForm() {
        let numSeats = document.getElementById('num_persons').value;
        let availableSeats = <?php echo $available_seats; ?>;

        // Check if the number of seats is between 5 and 60
        if (numSeats < 5) {
            alert('At least 5 members must be booked!');
            return false;
        }
        if (numSeats > 60) {
            alert('A maximum of 60 members can be booked!');
            return false;
        }
        if (numSeats > availableSeats) {
            alert('Not enough seats available! Only ' + availableSeats + ' seats left.');
            return false;
        }
        return true;
    }
</script>

</body>
</html>
