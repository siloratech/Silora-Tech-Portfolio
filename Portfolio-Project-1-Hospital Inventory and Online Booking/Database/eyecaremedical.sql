-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2024 at 09:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eyecaremedical`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `patient_phone` varchar(20) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `status` enum('Booked','Cancelled','Completed') DEFAULT 'Booked',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `doctor_id`, `patient_name`, `patient_phone`, `appointment_date`, `appointment_time`, `status`, `created_at`, `updated_at`) VALUES
(8, 27, 'Mintu', '1232435353', '2024-07-31', '13:45:00', 'Booked', '2024-07-27 16:33:25', '2024-07-27 16:33:25'),
(9, 27, 'sdfds', '2423432', '2024-07-29', '13:45:00', 'Booked', '2024-07-27 16:34:10', '2024-07-27 16:34:10'),
(10, 29, 'DDF', '1234567899', '2024-07-29', '13:30:00', 'Booked', '2024-07-27 16:36:24', '2024-07-27 16:45:13'),
(11, 27, 'Nik', NULL, '2024-07-29', '12:45:00', 'Cancelled', '2024-07-27 16:40:27', '2024-07-27 16:45:23'),
(12, 27, 'asda', '1234567812', '2024-07-24', '12:30:00', 'Booked', '2024-07-27 16:43:18', '2024-07-27 16:43:18'),
(13, 27, 'fsdf', '1234567898', '2024-07-24', '11:00:00', 'Booked', '2024-07-27 16:44:33', '2024-07-27 16:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `biography` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `monday` varchar(255) DEFAULT NULL,
  `tuesday` varchar(255) DEFAULT NULL,
  `wednesday` varchar(255) DEFAULT NULL,
  `thursday` varchar(255) DEFAULT NULL,
  `friday` varchar(255) DEFAULT NULL,
  `saturday` varchar(255) DEFAULT NULL,
  `sunday` varchar(255) DEFAULT NULL,
  `time_slot1` varchar(255) DEFAULT NULL,
  `time_slot2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `designation`, `department`, `email`, `availability`, `biography`, `photo`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `time_slot1`, `time_slot2`) VALUES
(27, 'Arya', 'Den', 'Psychology', 'h@h.com', NULL, 'test bio', 'pexels-heitorverdifotos-2169434.jpg', '', '', '', '', '', '', '', '1-2 PM', '1-4 PM'),
(29, 'Bany', 'DR', 'Micro', 'h@h.com', NULL, 'test bio', 'pexels-italo-melo-881954-2379005.jpg', '', '', '', '', '', '', '', '2-4', ''),
(31, 'Nirav', 'Senior', 'ONT', 'h@h.com', NULL, 'test bio', 'pexels-bharatkuiper-2232981.jpg', '', '', 'Wednesday', '', '', 'Saturday', '', '9-10 AM', '10-11PM');

-- --------------------------------------------------------

--
-- Table structure for table `labtests`
--

CREATE TABLE `labtests` (
  `testid` int(11) NOT NULL,
  `testname` varchar(250) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `labtests`
--

INSERT INTO `labtests` (`testid`, `testname`, `price`) VALUES
(10, 'E#4', 123);

-- --------------------------------------------------------

--
-- Table structure for table `lab_bookings`
--

CREATE TABLE `lab_bookings` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_phone` varchar(10) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_id` int(11) NOT NULL,
  `category` enum('wholesale','retail') NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity_available` int(11) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `dosage_form` varchar(255) DEFAULT NULL,
  `strength` varchar(255) DEFAULT NULL,
  `prescription_required` enum('yes','no') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_id`, `category`, `name`, `description`, `brand`, `manufacturer`, `price`, `quantity_available`, `expiry_date`, `batch_number`, `dosage_form`, `strength`, `prescription_required`, `created_at`) VALUES
(16, 'wholesale', 'DFG', 'dgsdg', 'dsgds', 'dsgsdg', 123.00, 2, '2024-07-04', '1', '121.77', '0', 'no', '2024-07-22 10:03:55'),
(19, 'retail', '31ads', '31', '31', '3', 3.00, 3, '2024-07-26', '1', '2.97', '3', 'yes', '2024-07-22 13:43:34'),
(20, 'retail', 'MedX', 'asd', 'sdfs', '0', 213.00, 23, '0000-00-00', '21', '168.27', 'dwe', 'no', '2024-07-27 15:40:49'),
(21, 'wholesale', 'QQQ', 'asd', 'sads', '0', 2.00, 212, '0000-00-00', '32', '1.36', '321', 'no', '2024-07-27 15:54:48'),
(22, 'retail', 'MedX', 'dsf', 'dsfsd', '0', 120.00, 21, '0000-00-00', '1', '118.80', '12', 'no', '2024-07-27 15:57:06'),
(23, 'wholesale', 'Q12', 'dsfds', 'fdsdf', '0', 1.00, 1, '0000-00-00', NULL, '1.00', '1', 'no', '2024-07-27 16:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `udb_admin_log`
--

CREATE TABLE `udb_admin_log` (
  `name` varchar(80) NOT NULL,
  `userid` varchar(80) NOT NULL,
  `email` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `lastupdated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `udb_admin_log`
--

INSERT INTO `udb_admin_log` (`name`, `userid`, `email`, `pass`, `lastupdated`) VALUES
('Test Account', 'xvy64', 'xvy123@m.com', 'xvy64', '2024-08-18 07:07:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labtests`
--
ALTER TABLE `labtests`
  ADD PRIMARY KEY (`testid`);

--
-- Indexes for table `lab_bookings`
--
ALTER TABLE `lab_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `udb_admin_log`
--
ALTER TABLE `udb_admin_log`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `labtests`
--
ALTER TABLE `labtests`
  MODIFY `testid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lab_bookings`
--
ALTER TABLE `lab_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Constraints for table `lab_bookings`
--
ALTER TABLE `lab_bookings`
  ADD CONSTRAINT `lab_bookings_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `labtests` (`testid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
