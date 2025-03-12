

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'bca305', 'admin123');

-- --------------------------------------------------------

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL
);

-- Create a table to store bus information
CREATE TABLE tblbuses (
    BusId INT AUTO_INCREMENT PRIMARY KEY,       -- Unique ID for each bus
    BusName VARCHAR(255) NOT NULL,               -- Name of the bus (e.g., "Luxury Bus")
    Route VARCHAR(255) NOT NULL,                 -- Route information (e.g., "City A to City B")
    TotalSeats INT NOT NULL,                    -- Total number of seats on the bus
    BookedSeats INT DEFAULT 0,                  -- Number of seats already booked
    TicketPrice DECIMAL(10, 2) NOT NULL,        -- Price per seat for booking
    BusFeatures TEXT,                            -- Features of the bus (e.g., "Air conditioning, Wi-Fi, Reclining seats")
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Timestamp of when the bus was added
);

-- Create a table to store the bookings for buses
CREATE TABLE tblbusbookings (
    BookingId INT AUTO_INCREMENT PRIMARY KEY,    -- Unique ID for each booking
    BusId INT NOT NULL,                          -- The BusId for which the booking is made
    Name VARCHAR(255) NOT NULL,                  -- Passenger's name
    Email VARCHAR(255) NOT NULL,                 -- Passenger's email
    Mobile VARCHAR(15) NOT NULL,                 -- Passenger's mobile number
    NumSeats INT NOT NULL,                      -- Number of seats booked
    StartDate DATE NOT NULL,                     -- Start date of the travel
    EndDate DATE NOT NULL,                       -- End date of the travel
    PaymentStatus VARCHAR(50) DEFAULT 'Pending', -- Payment status (e.g., "Pending", "Completed")
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of when the booking was made
    FOREIGN KEY (BusId) REFERENCES tblbuses(BusId) -- Foreign key linking to the buses table
);

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `mobile`, `email`, `message`, `created_at`, `reply`) VALUES
(5, 'vasan', '987765444333', 'gchftdr@gmail.com', 'hiii', '2025-01-26 07:34:11', NULL),
(6, 'vasan', '987765444333', 'gchftdr@gmail.com', 'hi', '2025-01-28 06:32:11', 'ok'),
(7, 'mk', '9876543210', 'ak@gmail.com', 'hiiiiii', '2025-03-02 15:21:48', 'okk'),
(8, 'jhc', '87658765', 'jlhdj@gmail.com', 'klsjcjs', '2025-03-02 15:23:54', 'kjddf'),
(9, 'bvbv', '6656', 'nbnb@gmail.com', 'jvjhgh', '2025-03-02 15:27:16', 'gffg');

-- --------------------------------------------------------

--
-- Table structure for table `tblbookings`
--

CREATE TABLE `tblbookings` (
  `BookingId` int(11) NOT NULL,
  `PackageId` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Mobile` varchar(20) NOT NULL,
  `NumPersons` int(11) NOT NULL CHECK (`NumPersons` >= 10),
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `TourType` enum('Family','School','College','Office','Others') NOT NULL,
  `PaymentStatus` enum('Pending','Paid') DEFAULT 'Pending',
  `BookingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbookings`
--

INSERT INTO `tblbookings` (`BookingId`, `PackageId`, `Name`, `Email`, `Mobile`, `NumPersons`, `StartDate`, `EndDate`, `TourType`, `PaymentStatus`, `BookingDate`) VALUES
(1, 8, 'mank', 'dakjna@gmail.oom', '09344003982', 18, '2025-03-05', '2025-03-07', 'Family', 'Pending', '2025-03-04 09:16:05'),
(2, 3, 's manikandan', 'manikandansa172004@gmail.com', '09344003982', 20, '2025-03-06', '2025-03-08', 'Family', 'Pending', '2025-03-04 09:40:38'),
(3, 3, 'mank', 'dakjna@gmail.oom', '09344003982', 18, '2025-03-06', '2025-03-11', 'Family', 'Pending', '2025-03-04 09:41:24'),
(4, 3, 'mank', 'dakjna@gmail.oom', '09344003982', 18, '2025-03-06', '2025-03-11', 'Family', 'Pending', '2025-03-04 09:49:02'),
(5, 3, 'mank', 'dakjna@gmail.oom', '09344003982', 13, '2025-03-06', '2025-03-11', 'Family', 'Pending', '2025-03-04 09:55:28'),
(6, 3, 'mank', 'dakjna@gmail.oom', '09344003982', 20, '2025-03-06', '2025-03-11', 'Family', 'Pending', '2025-03-04 09:55:46'),
(7, 3, 'mank', 'dakjna@gmail.oom', '09344003982', 18, '2025-03-06', '2025-03-11', 'Family', 'Pending', '2025-03-04 09:57:50'),
(8, 2, 'mank', 'dakjna@gmail.oom', '09344003982', 18, '2025-03-05', '2025-03-07', 'Family', 'Pending', '2025-03-04 09:58:23'),
(9, 2, 'mank', 'dakjna@gmail.oom', '09344003982', 18, '2025-03-05', '2025-03-07', 'Family', 'Pending', '2025-03-04 10:04:51'),
(10, 8, 'mank', 'dakjna@gmail.oom', '09344003982', 18, '2025-03-05', '2025-03-09', 'Family', 'Pending', '2025-03-04 10:07:26'),
(11, 8, 'mank', 'dakjna@gmail.oom', '09344003982', 27, '2025-03-05', '2025-03-09', 'Family', 'Pending', '2025-03-04 10:07:42'),
(12, 8, 'mank', 'dakjna@gmail.oom', '09344003982', 27, '2025-03-05', '2025-03-09', 'Family', 'Pending', '2025-03-04 10:10:16'),
(13, 8, 'mank', 'dakjna@gmail.oom', '09344003982', 27, '2025-03-05', '2025-03-07', 'Family', 'Pending', '2025-03-04 11:14:19'),
(14, 8, 'mank', 'dakjna@gmail.oom', '09344003982', 27, '2025-03-05', '2025-03-07', 'Family', 'Pending', '2025-03-04 11:53:50'),
(15, 8, 'mank', 'dakjna@gmail.oom', '09344003982', 27, '2025-03-05', '2025-03-07', 'Family', 'Pending', '2025-03-04 11:57:25'),
(16, 5, 'mank', 'dakjna@gmail.oom', '09344003982', 27, '2025-03-05', '2025-03-07', 'Family', 'Pending', '2025-03-04 14:24:23'),
(17, 4, 'mank', 'dakjna@gmail.oom', '09344003982', 27, '2025-03-06', '2025-03-09', 'Family', 'Pending', '2025-03-04 14:26:08'),
(18, 4, 'mank', 'dakjna@gmail.oom', '09344003982', 27, '2025-03-06', '2025-03-09', 'School', 'Pending', '2025-03-04 14:26:18'),
(19, 3, 'mank', 'dakjna@gmail.oom', '09344003982', 27, '2025-03-05', '2025-03-07', 'College', 'Pending', '2025-03-04 14:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoices`
--

CREATE TABLE `tblinvoices` (
  `InvoiceId` int(11) NOT NULL,
  `BookingId` int(11) NOT NULL,
  `CustomerName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Mobile` varchar(20) NOT NULL,
  `PackageName` varchar(255) NOT NULL,
  `PackageLocation` varchar(255) NOT NULL,
  `NumPersons` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `TourType` varchar(100) NOT NULL,
  `BasePrice` decimal(10,2) NOT NULL,
  `DiscountPercentage` decimal(5,2) DEFAULT NULL,
  `DiscountAmount` decimal(10,2) DEFAULT NULL,
  `FinalAmount` decimal(10,2) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` enum('approved','disapproved') DEFAULT 'disapproved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblinvoices`
--

INSERT INTO `tblinvoices` (`InvoiceId`, `BookingId`, `CustomerName`, `Email`, `Mobile`, `PackageName`, `PackageLocation`, `NumPersons`, `StartDate`, `EndDate`, `TourType`, `BasePrice`, `DiscountPercentage`, `DiscountAmount`, `FinalAmount`, `CreatedAt`, `Status`) VALUES
(1, 12, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-09', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 10:14:46', 'disapproved'),
(2, 12, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-09', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 10:14:48', 'disapproved'),
(3, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:14:19', 'disapproved'),
(4, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:21:31', 'disapproved'),
(5, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:27:01', 'disapproved'),
(6, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:30:27', 'disapproved'),
(7, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:32:49', 'disapproved'),
(8, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:34:16', 'disapproved'),
(9, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:34:39', 'disapproved'),
(10, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:34:50', 'disapproved'),
(11, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:35:16', 'disapproved'),
(12, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:37:13', 'disapproved'),
(13, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:37:15', 'disapproved'),
(14, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:37:15', 'disapproved'),
(15, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:37:16', 'disapproved'),
(16, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:37:16', 'disapproved'),
(17, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:37:16', 'disapproved'),
(18, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:37:16', 'disapproved'),
(19, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:53:28', 'disapproved'),
(20, 13, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:53:43', 'disapproved'),
(21, 14, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:53:50', 'disapproved'),
(22, 14, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:57:21', 'disapproved'),
(23, 15, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 11:57:25', 'disapproved'),
(24, 15, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 12:01:52', 'disapproved'),
(25, 15, 'mank', 'dakjna@gmail.oom', '09344003982', 'somthing', 'dont,no', 27, '2025-03-05', '2025-03-07', 'Family', 55.50, 6.00, 89.91, 1408.59, '2025-03-04 12:01:59', 'disapproved'),
(26, 16, 'mank', 'dakjna@gmail.oom', '09344003982', 'Chennai Beach Tour', 'Chennai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'Family', 13.00, 6.00, 21.06, 329.94, '2025-03-04 14:24:23', 'disapproved'),
(27, 17, 'mank', 'dakjna@gmail.oom', '09344003982', 'Rameswaram Spiritual Journey', 'Rameswaram, Tamil Nadu', 27, '2025-03-06', '2025-03-09', 'Family', 12.00, 6.00, 19.44, 304.56, '2025-03-04 14:26:08', 'disapproved'),
(28, 18, 'mank', 'dakjna@gmail.oom', '09344003982', 'Rameswaram Spiritual Journey', 'Rameswaram, Tamil Nadu', 27, '2025-03-06', '2025-03-09', 'School', 12.00, 6.00, 19.44, 304.56, '2025-03-04 14:26:18', 'disapproved'),
(29, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:27:23', 'disapproved'),
(30, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:28:49', 'disapproved'),
(31, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:28:49', 'disapproved'),
(32, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:28:49', 'disapproved'),
(33, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:28:50', 'disapproved'),
(34, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:28:50', 'disapproved'),
(35, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:28:50', 'disapproved'),
(36, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:28:50', 'disapproved'),
(37, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:28:50', 'disapproved'),
(38, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:31:17', 'disapproved'),
(39, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:32:52', 'disapproved'),
(40, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:34:57', 'disapproved'),
(41, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:35:18', 'disapproved'),
(42, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:35:19', 'disapproved'),
(43, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:35:19', 'disapproved'),
(44, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:35:19', 'disapproved'),
(45, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:38:06', 'disapproved'),
(46, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:38:41', 'disapproved'),
(47, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:41:13', 'disapproved'),
(48, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:42:58', 'disapproved'),
(49, 19, 'mank', 'dakjna@gmail.oom', '09344003982', 'Madurai Temple Tour', 'Madurai, Tamil Nadu', 27, '2025-03-05', '2025-03-07', 'College', 10.00, 6.00, 16.20, 253.80, '2025-03-04 14:49:29', 'disapproved'),
(50, 18, 'mank', 'dakjna@gmail.oom', '09344003982', 'Rameswaram Spiritual Journey', 'Rameswaram, Tamil Nadu', 27, '2025-03-06', '2025-03-09', 'School', 12.00, 6.00, 19.44, 304.56, '2025-03-04 14:54:20', 'disapproved');

-- --------------------------------------------------------

--
-- Table structure for table `tbltourpackages`
--

CREATE TABLE `tbltourpackages` (
  `PackageId` int(11) NOT NULL,
  `PackageName` varchar(255) NOT NULL,
  `PackageType` varchar(255) NOT NULL,
  `PackageLocation` varchar(255) NOT NULL,
  `PackageFetures` text NOT NULL,
  `PackagePrice` decimal(10,2) NOT NULL,
  `PackageImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbltourpackages`
--

INSERT INTO `tbltourpackages` (`PackageId`, `PackageName`, `PackageType`, `PackageLocation`, `PackageFetures`, `PackagePrice`, `PackageImage`) VALUES
(2, 'Kodaikanal Nature Escape', 'Hill Station', 'Kodaikanal, Tamil Nadu', 'Boating, Trekking, Sightseeing,cycling', 500.00, 'kodaikanal.jpg'),
(3, 'Madurai Temple Tour', 'Cultural', 'Madurai, Tamil Nadu', 'Temple visits, Religious, Cultural', 100.00, 'madurai.jpg'),
(4, 'Rameswaram Spiritual Journey', 'Religious', 'Rameswaram, Tamil Nadu', 'Temple visits, Beaches, Spiritual', 120.00, 'rameswaram.jpg'),
(5, 'Chennai Beach Tour', 'Beach', 'Chennai, Tamil Nadu', 'Beach activities, Water sports, Nightlife', 130.00, 'chennai.jpg'),
(8, 'somthing', 'hlo', 'dont,no', 'hzgdkhgc', 555.00, 'black.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbookings`
--
ALTER TABLE `tblbookings`
  ADD PRIMARY KEY (`BookingId`),
  ADD KEY `PackageId` (`PackageId`);

--
-- Indexes for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  ADD PRIMARY KEY (`InvoiceId`),
  ADD KEY `BookingId` (`BookingId`);

--
-- Indexes for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  ADD PRIMARY KEY (`PackageId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblbookings`
--
ALTER TABLE `tblbookings`
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  MODIFY `InvoiceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblbookings`
--
ALTER TABLE `tblbookings`
  ADD CONSTRAINT `tblbookings_ibfk_1` FOREIGN KEY (`PackageId`) REFERENCES `tbltourpackages` (`PackageId`) ON DELETE CASCADE;

--
-- Constraints for table `tblinvoices`
--
ALTER TABLE `tblinvoices`
  ADD CONSTRAINT `tblinvoices_ibfk_1` FOREIGN KEY (`BookingId`) REFERENCES `tblbookings` (`BookingId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
