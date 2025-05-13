-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2025 at 04:26 AM
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
-- Table structure for table `chathistory`
--

CREATE TABLE `chathistory` (
  `chatHistoryID` int(11) NOT NULL,
  `chatRoomID` int(11) NOT NULL
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

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackId`, `clientId`, `nurseId`, `rating`, `description`, `createdAt`) VALUES
(1, 9, 22, '4', '', '2025-05-10'),
(2, 9, 33, '3', 'She\'s okay', '2025-05-10'),
(3, 31, 22, '4', '', '2025-05-10'),
(4, 31, 33, '4', 'She helped me get better so quickly', '2025-05-10'),
(5, 31, 35, '2', 'She was as confused as me', '2025-05-10'),
(6, 36, 22, '5', 'She\'s very helpful and energetic', '2025-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `nurse`
--

CREATE TABLE `nurse` (
  `NurseID` int(6) NOT NULL,
  `licenseNumber` varchar(32) NOT NULL,
  `registrationFee` double NOT NULL,
  `schedule` text NOT NULL,
  `specialitiesGoodAt` text NOT NULL,
  `clientHistory` text NOT NULL,
  `feedbackReceived` text NOT NULL,
  `rating` double NOT NULL,
  `years_experience` int(11) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurse`
--

INSERT INTO `nurse` (`NurseID`, `licenseNumber`, `registrationFee`, `schedule`, `specialitiesGoodAt`, `clientHistory`, `feedbackReceived`, `rating`, `years_experience`, `info`) VALUES
(1, 'RN123456789', 200, '9:00 AM - 5:00 PM, Monday to Friday', 'Cardiology, Neurology', 'Has worked with over 50 patients in cardiac care.', 'Received positive feedback from patients and peers.', 4.5, 10, '0'),
(22, '1234567', 0, 'Everyday', 'General Care', '', '', 0, 10, '0'),
(26, '1234567', 0, 'Everyday', 'General Care', '', '', 0, 4, '0'),
(28, '1234567', 0, 'Everyday', 'General Care', '', '', 0, 12, '0'),
(32, '1234567', 0, 'Everyday', 'General Care', '', '', 0, 12, 'Tall'),
(33, '1234567', 0, 'Everyday', 'General Care', '', '', 0, 12, 'Tall, Been helping patient for years'),
(34, '1234567', 0, 'Everyday', 'General Care', '', '', 0, 12, 'Tall, Strong, brave, been helping patinents for almost a year'),
(35, '7625321', 0, 'Everyday', 'General Care', '', '', 0, 18, 'Kind, Strong, love helping others');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patientID` int(6) NOT NULL,
  `paymentHistory` text NOT NULL,
  `chats` text NOT NULL,
  `serviceHistory` text NOT NULL,
  `problem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patientID`, `paymentHistory`, `chats`, `serviceHistory`, `problem`) VALUES
(2, 'Paid via credit card on 2025-03-15', 'Chat with nurse on 2025-03-10 about medication', 'General checkup on 2025-03-01', ''),
(7, '', '', '', ''),
(8, '', '', '', ''),
(9, '', '', '', ''),
(24, '', '', '', ''),
(29, '', '', '', ''),
(30, '', '', '', ''),
(31, '', '', '', 'My arm hurts'),
(36, '', '', '', 'My head hurts');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentID` int(11) NOT NULL,
  `patientName` varchar(100) NOT NULL,
  `serviceCode` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `timeStamp` datetime DEFAULT current_timestamp(),
  `paymentStatus` varchar(20) NOT NULL
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
  `chatRoomId` int(11) DEFAULT NULL,
  `nurseId` int(11) NOT NULL,
  `appointmentTime` text NOT NULL,
  `appointmentDate` text NOT NULL,
  `serviceCode` text NOT NULL,
  `status` enum('','','','') NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `serviceform`
--

INSERT INTO `serviceform` (`Id`, `chatRoomId`, `nurseId`, `appointmentTime`, `appointmentDate`, `serviceCode`, `status`, `address`) VALUES
(2, NULL, 22, '20:42', '2025-08-10', 'MW6CE', '', '885 Av Ogilvy'),
(3, NULL, 22, '22:48', '2025-07-22', 'GRT8H', '', '514 Limgrave'),
(4, NULL, 32, '20:47', '2025-07-22', 'ZW97X', '', '514 Limgrave'),
(5, NULL, 34, '07:54', '2025-07-22', 'DGMTG', '', '514 Limgrave'),
(6, NULL, 22, '02:03', '2025-07-09', 'VWG3X', '', '514 St Croix'),
(7, NULL, 22, '02:03', '2025-07-09', 'VH6IR', '', '514 St Croix'),
(8, NULL, 22, '14:15', '2025-07-12', 'YN87V', '', '514 Limgrave');

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
  `Gender` enum('Female','Male','Non-binary','Prefer not to say') NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `DOB` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `email`, `password`, `firstName`, `lastName`, `ZipCode`, `Gender`, `createdAt`, `updatedAt`, `isActive`, `DOB`) VALUES
(1, 'john.doe@example.com', '123', 'John', 'Doe', '12345', 'Female', '2025-04-01 18:31:13', '2025-04-01 18:31:13', 0, NULL),
(2, 'alice.smith@example.com', '5e884898da28047151d0e56f8dc6292773603d0d', 'Alice', 'Smith', 'V5K1Z9', 'Female', '2025-04-03 21:35:10', '2025-04-03 21:35:10', 1, NULL),
(7, 'Shaheryar.a@hotmail.com', '02a5d12dbeec3a2df8b6435d0ad0afdd93243dda', 'Shaheryar', 'Anwar', 'H3N 2L6', 'Male', '2025-04-29 19:31:41', '2025-04-29 19:31:41', 1, '2005-07-10'),
(8, 'shaheryar751@outlook.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Anwar', 'Shaheryar', 'X0X 0X0', 'Male', '2025-04-29 20:15:40', '2025-04-29 20:15:40', 1, '2005-07-10'),
(9, '2274835@edu.vaniercollege.qc.ca', 'b12bed26d164467af318b561b08d9473914838cc', 'Shaheryar', 'Anwar', 'X0X 0X0', 'Male', '2025-05-06 17:33:14', '2025-05-06 17:33:14', 1, '2005-07-10'),
(22, 'ShaheryarKnight7@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Malenia', 'Miquella', 'X0X 0X0', 'Female', '2025-05-06 20:43:10', '2025-05-06 20:43:10', 1, '2005-07-10'),
(23, 'Miquella@gmail.com', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', 'Miquella', 'The Kind', 'X0X 0X0', 'Male', '2025-05-06 21:27:28', '2025-05-06 21:27:28', 1, '2000-07-11'),
(24, 'anwarshaheryar7@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'General', 'Radahn', 'X6X 0X8', 'Male', '2025-05-06 21:32:32', '2025-05-06 21:32:32', 0, '1990-07-11'),
(26, 'ala@example.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Ala', 'Ala', 'X0X 0X0', 'Female', '2025-05-09 10:09:35', '2025-05-09 10:09:35', 1, '1988-04-30'),
(27, 'hello@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'AKAKA', 'AKAKAKA', 'h3p 1a1', 'Female', '2025-05-09 10:49:18', '2025-05-09 10:49:18', 1, '2005-10-05'),
(28, 'urm@example.com', '7c222fb2927d828af22f592134e8932480637c0d', 'urm', 'ala', 'X0X 0X0', 'Female', '2025-05-09 11:06:14', '2025-05-09 11:06:14', 1, '1988-09-08'),
(29, 'ammu@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'ammu', 'ammu', 'H6T 8u9', 'Female', '2025-05-09 11:07:56', '2025-05-09 11:07:56', 1, '1990-10-05'),
(30, 'Godfrey@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Godfrey', 'anwu', 'H3N 2L6', 'Male', '2025-05-09 14:48:46', '2025-05-09 14:48:46', 1, '2005-09-11'),
(31, 'yui@outlook.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Psylocke', 'Yui', 'h3n 2l6', 'Female', '2025-05-09 14:56:43', '2025-05-09 14:56:43', 1, '2005-08-10'),
(32, 'Florence@hotmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'florence', 'amelia', 'X6X 0X8', 'Female', '2025-05-09 15:31:34', '2025-05-09 15:31:34', 1, '2004-11-29'),
(33, 'Pugh@gmail.com', 'f09f75a18a8a2700386fb877dabe76824131bf78', 'Elizabeth', 'Pugh', 'X6X 0X8', 'Female', '2025-05-09 16:56:21', '2025-05-09 16:56:21', 1, '2005-08-10'),
(34, 'eli@gmail.com', 'f09f75a18a8a2700386fb877dabe76824131bf78', 'Elizabeth', 'Pugh', 'X6X 0X8', 'Female', '2025-05-09 18:03:31', '2025-05-09 18:03:31', 1, '2005-08-10'),
(35, 'Nolsen@gmail.com', 'f09f75a18a8a2700386fb877dabe76824131bf78', 'Olsen', 'Noel', 'X6X 0X8', 'Male', '2025-05-09 18:10:59', '2025-05-09 18:10:59', 1, '2005-08-10'),
(36, 'anwsha@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Anwsha', 'shanw', 'h3n 2l6', 'Male', '2025-05-10 19:09:10', '2025-05-10 19:09:10', 1, '2005-08-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chatRoomId`),
  ADD KEY `fk_chat_clientId` (`clientId`),
  ADD KEY `fk_chat_nurseId` (`nurseId`);

--
-- Indexes for table `chathistory`
--
ALTER TABLE `chathistory`
  ADD PRIMARY KEY (`chatHistoryID`),
  ADD KEY `fk_chathistory_chatRoomId` (`chatRoomID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackId`),
  ADD KEY `fk_feedback_clientId` (`clientId`),
  ADD KEY `fk_feedback_nurseId` (`nurseId`);

--
-- Indexes for table `nurse`
--
ALTER TABLE `nurse`
  ADD KEY `NurseID` (`NurseID`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD UNIQUE KEY `patientID_2` (`patientID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `payment_processors`
--
ALTER TABLE `payment_processors`
  ADD PRIMARY KEY (`processorID`),
  ADD KEY `fk_PaymentProcessors_patientID` (`patientID`);

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
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stripepayment`
--
ALTER TABLE `stripepayment`
  MODIFY `stripeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `fk_chat_clientId` FOREIGN KEY (`clientId`) REFERENCES `patients` (`patientID`),
  ADD CONSTRAINT `fk_chat_nurseId` FOREIGN KEY (`nurseId`) REFERENCES `nurse` (`NurseID`);

--
-- Constraints for table `chathistory`
--
ALTER TABLE `chathistory`
  ADD CONSTRAINT `fk_chathistory_chatRoomId` FOREIGN KEY (`chatRoomID`) REFERENCES `chat` (`chatRoomId`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_clientId` FOREIGN KEY (`clientId`) REFERENCES `patients` (`patientID`),
  ADD CONSTRAINT `fk_feedback_nurseId` FOREIGN KEY (`nurseId`) REFERENCES `nurse` (`NurseID`);

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
-- Constraints for table `payment_processors`
--
ALTER TABLE `payment_processors`
  ADD CONSTRAINT `fk_PaymentProcessors_patientID` FOREIGN KEY (`patientID`) REFERENCES `patients` (`patientID`);

--
-- Constraints for table `serviceform`
--
ALTER TABLE `serviceform`
  ADD CONSTRAINT `fk_chatRoomId` FOREIGN KEY (`chatRoomId`) REFERENCES `chat` (`chatRoomId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
