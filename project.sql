-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 06:30 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `seats_booked` int(11) DEFAULT NULL,
  `booked_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `post_id`, `seats_booked`, `booked_datetime`) VALUES
(15, 2, 3, 2, '2024-03-30 06:27:14'),
(16, 2, 9, 2, '2024-03-31 03:37:50'),
(17, 10, 3, 1, '2024-03-31 04:35:45'),
(18, 2, 10, 2, '2024-03-31 04:37:57'),
(19, 1, 2, 1, '2024-03-31 19:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `post_rides`
--

CREATE TABLE `post_rides` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `departure` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `seats_available` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_rides`
--

INSERT INTO `post_rides` (`post_id`, `user_id`, `departure`, `destination`, `seats_available`, `price`, `date`, `created_at`) VALUES
(2, 2, 'Chennai', 'Coimbatore', 1, '1500.00', '2024-02-20', '2024-02-17 20:02:17'),
(3, 1, 'Chengalpattu', 'Chennai', 0, '750.00', '2024-02-18', '2024-02-17 20:04:27'),
(4, 1, 'Ariyalur', 'Chennai', 2, '400.00', '2024-02-18', '2024-02-18 03:04:07'),
(5, 1, 'Chengalpattu', 'Coimbatore', 2, '500.00', '2024-03-02', '2024-03-02 03:51:53'),
(6, 1, 'Chennai', 'Coimbatore', 1, '350.00', '2024-03-02', '2024-03-02 04:48:44'),
(7, 1, 'Chennai', 'Coimbatore', 2, '350.00', '2024-03-02', '2024-03-03 06:40:52'),
(8, 1, 'Virudhunagar', 'Chennai', 3, '1100.00', '2024-03-29', '2024-03-29 10:04:06'),
(9, 1, 'Chennai', 'Virudhunagar', 1, '1100.00', '2024-03-29', '2024-03-29 10:11:04'),
(10, 1, 'Virudhunagar', 'Chennai', 1, '1100.00', '2024-03-31', '2024-03-31 02:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `district` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `aadharCardImage` mediumblob DEFAULT NULL,
  `drivingLicenseImage` mediumblob DEFAULT NULL,
  `verificationDetails` enum('pending','verified','rejected','not_verified') NOT NULL DEFAULT 'not_verified',
  `newProfilePicture` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `fullName`, `dateOfBirth`, `gender`, `email`, `phoneNumber`, `district`, `username`, `password`, `aadharCardImage`, `drivingLicenseImage`, `verificationDetails`, `newProfilePicture`) VALUES
(1, 'kathirvel.k', '2004-08-05', 'Male', 'kathir20040508@gmail.com', '9486034835', 'Virudhunagar', 'kathir', '$2y$10$kZ7cwS24IdqTogAVKcVw8OFb0qzVgyaJfpfbUODQvRlaroED/uqWm', 0x75706c6f6164732f6161646861722e6a7067, 0x75706c6f6164732f70616e2e6a7067, 'verified', 0x75706c6f6164732f70726f66696c6520706963747572652e6a706567),
(2, 'kajendran', '1970-01-01', 'Male', 'mahendran@gmail.com', '8608838937', 'Virudhunagar', 'kaje', '$2y$10$65KK9DBEZYaVmKPiBD2MZ.bRkesZhtb/lFbomgVcC2ewhj1k7.hIq', NULL, NULL, 'not_verified', 0x75706c6f6164732f6b616a612e6a706567),
(3, 'mareeswari', '1980-03-14', 'Female', 'mareeswari@gmail.com', '8608838935', 'virudhunagar', 'marees', 'kathir', NULL, NULL, '', NULL),
(9, 'priya', '2000-01-21', 'Male', 'lakshmipriya@gmail.com', '9486056835', 'virudhunagar', 'priya', 'kathir', NULL, NULL, '', NULL),
(10, 'mahesh', '2000-01-13', 'Male', 'mahesh@gmail.com', '7438473207', 'madurai', 'mahesh', '$2y$10$/m523v8pi0AisPP7dGuUT.A.1Sdz0DJd0KtPAkzzyYITkCwu3ufRO', NULL, NULL, '', NULL),
(11, 'logash', '2004-03-16', 'Male', 'logash@gmail.com', '8608838735', 'virudhunagar', 'logash', '$2y$10$9JQOC/MFKtLIALWYuukhHOoMEkqdrC2iWTd04/PUATGl9RLyFm3ZW', NULL, NULL, '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post_rides`
--
ALTER TABLE `post_rides`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`,`phoneNumber`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `post_rides`
--
ALTER TABLE `post_rides`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post_rides` (`post_id`);

--
-- Constraints for table `post_rides`
--
ALTER TABLE `post_rides`
  ADD CONSTRAINT `post_rides_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
