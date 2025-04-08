-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 04:51 AM
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
-- Database: `nurserysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chatRoomId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `nurseId` int(11) NOT NULL,
  `createAt` text NOT NULL,
  `messages` text NOT NULL,
  `serviceCode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `nurseId` int(11) NOT NULL,
  `rating` text NOT NULL,
  `description` text NOT NULL,
  `createdAt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nurse`
--

CREATE TABLE `nurse` (
  `NurseID` int(6) NOT NULL,
  `DOB` date NOT NULL,
  `gender` enum('Male','Female','Other','') NOT NULL,
  `licenseNumber` varchar(32) NOT NULL,
  `registrationFee` double NOT NULL,
  `schedule` text NOT NULL,
  `specialitiesGoodAt` text NOT NULL,
  `clientHistory` text NOT NULL,
  `feedbackReceived` text NOT NULL,
  `rating` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patientID` int(6) NOT NULL,
  `paymentHistory` text NOT NULL,
  `chats` text NOT NULL,
  `serviceHistory` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `transactionID` int(11) NOT NULL,
  `serviceCode` int(11) NOT NULL,
  `amount` double NOT NULL,
  `timeStamp` datetime NOT NULL,
  `paymentStatus` enum('Pending','Completed','Failed','Cancelled','Expired') NOT NULL,
  `paymentMethod` enum('Credit Card','PayPal','Stripe','Bank Transfer','Apple Pay') NOT NULL,
  `processorID` int(11) NOT NULL,
  `stripeID` int(11) NOT NULL,
  `paypalID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_processors`
--

CREATE TABLE `payment_processors` (
  `processorID` int(11) NOT NULL,
  `processorName` text NOT NULL,
  `apiKey` text NOT NULL,
  `patientID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paypalpayment`
--

CREATE TABLE `paypalpayment` (
  `paypalID` int(11) NOT NULL,
  `paymentID` int(11) NOT NULL,
  `processorID` int(11) NOT NULL,
  `transactionID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `status` enum('Pending','Completed','Failed','Cancelled','Expired') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `serviceform`
--

CREATE TABLE `serviceform` (
  `Id` int(11) NOT NULL,
  `chatRoomId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `nurseId` int(11) NOT NULL,
  `appointmentTime` text NOT NULL,
  `appointmentDate` text NOT NULL,
  `serviceCode` text NOT NULL,
  `status` enum('','','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stripepayment`
--

CREATE TABLE `stripepayment` (
  `stripeID` int(11) NOT NULL,
  `transactionID` int(11) NOT NULL,
  `paymentID` int(11) NOT NULL,
  `apiKey` text NOT NULL,
  `status` enum('Pending','Completed','Failed','Cancelled','Expired') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(6) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `ZipCode` varchar(7) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chatRoomId`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackId`);

--
-- Indexes for table `nurse`
--
ALTER TABLE `nurse`
  ADD KEY `NurseID` (`NurseID`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `fk_payment_processorID` (`processorID`),
  ADD KEY `fk_payment_stripeID` (`stripeID`),
  ADD KEY `fk_payment_paypalID` (`paypalID`);

--
-- Indexes for table `payment_processors`
--
ALTER TABLE `payment_processors`
  ADD PRIMARY KEY (`processorID`);

--
-- Indexes for table `paypalpayment`
--
ALTER TABLE `paypalpayment`
  ADD PRIMARY KEY (`paypalID`),
  ADD KEY `fk_paypal_processorID` (`processorID`),
  ADD KEY `fk_paypal_paymentID` (`paymentID`);

--
-- Indexes for table `serviceform`
--
ALTER TABLE `serviceform`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_chatRoomId` (`chatRoomId`);

--
-- Indexes for table `stripepayment`
--
ALTER TABLE `stripepayment`
  ADD PRIMARY KEY (`stripeID`),
  ADD KEY `fk_stripe_paymentID` (`paymentID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_processors`
--
ALTER TABLE `payment_processors`
  MODIFY `processorID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paypalpayment`
--
ALTER TABLE `paypalpayment`
  MODIFY `paypalID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serviceform`
--
ALTER TABLE `serviceform`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stripepayment`
--
ALTER TABLE `stripepayment`
  MODIFY `stripeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(6) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nurse`
--
ALTER TABLE `nurse`
  ADD CONSTRAINT `nurse_ibfk_1` FOREIGN KEY (`NurseID`) REFERENCES `users` (`Id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `users` (`Id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_paypalID` FOREIGN KEY (`paypalID`) REFERENCES `paypalpayment` (`paypalID`),
  ADD CONSTRAINT `fk_payment_processorID` FOREIGN KEY (`processorID`) REFERENCES `payment_processors` (`processorID`),
  ADD CONSTRAINT `fk_payment_stripeID` FOREIGN KEY (`stripeID`) REFERENCES `stripepayment` (`stripeID`);

--
-- Constraints for table `paypalpayment`
--
ALTER TABLE `paypalpayment`
  ADD CONSTRAINT `fk_paypal_paymentID` FOREIGN KEY (`paymentID`) REFERENCES `payment` (`paymentID`);

--
-- Constraints for table `serviceform`
--
ALTER TABLE `serviceform`
  ADD CONSTRAINT `fk_chatRoomId` FOREIGN KEY (`chatRoomId`) REFERENCES `chat` (`chatRoomId`);

--
-- Constraints for table `stripepayment`
--
ALTER TABLE `stripepayment`
  ADD CONSTRAINT `fk_stripe_paymentID` FOREIGN KEY (`paymentID`) REFERENCES `payment` (`paymentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
