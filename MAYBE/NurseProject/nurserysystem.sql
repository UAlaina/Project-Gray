-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 21 mai 2025 à 00:07
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `nurserysystem`
--

-- --------------------------------------------------------

--
-- Structure de la table `chat`
--

CREATE TABLE `chat` (
  `chatRoomId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `nurseId` int(11) NOT NULL,
  `createAt` text NOT NULL,
  `messages` text NOT NULL,
  `serviceCode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chat`
--

INSERT INTO `chat` (`chatRoomId`, `clientId`, `nurseId`, `createAt`, `messages`, `serviceCode`) VALUES
(1, 42, 22, '2025-05-16 18:46:29', '[{\"msg_id\":1,\"sender_id\":42,\"recipient_id\":22,\"message\":\"hello\",\"timestamp\":\"2025-05-16 19:03:36\",\"read\":true},{\"msg_id\":2,\"sender_id\":22,\"recipient_id\":42,\"message\":\"yo\",\"timestamp\":\"2025-05-16 19:06:30\",\"read\":true},{\"msg_id\":3,\"sender_id\":42,\"recipient_id\":22,\"message\":\"stfu\",\"timestamp\":\"2025-05-16 19:08:41\",\"read\":true}]', 'GEN-CHAT'),
(2, 42, 28, '2025-05-16 19:03:49', '[{\"msg_id\":1,\"sender_id\":42,\"recipient_id\":28,\"message\":\"yo\",\"timestamp\":\"2025-05-16 19:08:25\"}]', 'GEN-CHAT'),
(4, 48, 22, '2025-05-16 19:15:57', '[{\"msg_id\":1,\"sender_id\":48,\"recipient_id\":22,\"message\":\"hello\",\"timestamp\":\"2025-05-16 19:16:01\",\"read\":true}]', 'GEN-CHAT'),
(6, 7, 22, '2025-05-16 19:18:18', '[{\"msg_id\":1,\"sender_id\":22,\"recipient_id\":7,\"message\":\"yo\",\"timestamp\":\"2025-05-16 19:18:22\"}]', 'GEN-CHAT'),
(7, 2, 22, '2025-05-16 19:28:26', '[]', 'GEN-CHAT'),
(8, 49, 22, '2025-05-16 19:51:49', '[{\"msg_id\":1,\"sender_id\":49,\"recipient_id\":22,\"message\":\"I wanna book an apointment\",\"timestamp\":\"2025-05-16 19:52:03\",\"read\":true},{\"msg_id\":2,\"sender_id\":22,\"recipient_id\":49,\"message\":\"nah\",\"timestamp\":\"2025-05-16 19:55:58\",\"read\":true}]', 'GEN-CHAT'),
(9, 49, 38, '2025-05-16 19:52:26', '[{\"msg_id\":1,\"sender_id\":49,\"recipient_id\":38,\"message\":\"I wanna book an apointment for tomorrow if possible?\",\"timestamp\":\"2025-05-16 19:52:44\",\"read\":true},{\"msg_id\":2,\"sender_id\":49,\"recipient_id\":38,\"message\":\"I wanna book an apointment for tomorrow if possible?\",\"timestamp\":\"2025-05-16 19:52:44\",\"read\":true},{\"msg_id\":3,\"sender_id\":38,\"recipient_id\":49,\"message\":\"sure\",\"timestamp\":\"2025-05-16 19:54:54\",\"read\":true}]', 'GEN-CHAT'),
(10, 50, 28, '2025-05-19 04:48:26', '[{\"msg_id\":1,\"sender_id\":50,\"recipient_id\":28,\"message\":\"sdfsdf\",\"timestamp\":\"2025-05-19 04:48:33\"}]', 'GEN-CHAT'),
(11, 57, 22, '2025-05-19 08:39:36', '[{\"msg_id\":1,\"sender_id\":57,\"recipient_id\":22,\"message\":\"hey babes\",\"timestamp\":\"2025-05-19 09:07:22\"},{\"msg_id\":2,\"sender_id\":57,\"recipient_id\":22,\"message\":\"i need a service baba\",\"timestamp\":\"2025-05-19 09:09:22\"},{\"msg_id\":3,\"sender_id\":57,\"recipient_id\":22,\"message\":\"5 STAR BABY\",\"timestamp\":\"2025-05-19 09:14:52\"},{\"msg_id\":4,\"sender_id\":57,\"recipient_id\":22,\"message\":\"i miss u\",\"timestamp\":\"2025-05-19 09:39:05\"}]', 'GEN-CHAT'),
(12, 57, 28, '2025-05-19 09:15:22', '[{\"msg_id\":1,\"sender_id\":57,\"recipient_id\":28,\"message\":\"s\",\"timestamp\":\"2025-05-19 09:15:28\"}]', 'GEN-CHAT'),
(13, 57, 32, '2025-05-19 09:58:42', '[]', 'GEN-CHAT'),
(14, 53, 60, '2025-05-19 10:39:07', '[{\"msg_id\":1,\"sender_id\":60,\"recipient_id\":53,\"message\":\"lemme help u with that lil O\",\"timestamp\":\"2025-05-19 10:39:16\"}]', 'GEN-CHAT'),
(15, 51, 60, '2025-05-19 10:58:18', '[]', 'GEN-CHAT'),
(16, 57, 58, '2025-05-20 19:03:16', '[{\"msg_id\":1,\"sender_id\":57,\"recipient_id\":58,\"message\":\"hey maxy poo\",\"timestamp\":\"2025-05-20 19:03:22\"},{\"msg_id\":2,\"sender_id\":57,\"recipient_id\":58,\"message\":\"how are u babes\",\"timestamp\":\"2025-05-20 19:03:28\"}]', 'GEN-CHAT'),
(17, 57, 59, '2025-05-20 19:07:27', '[]', 'GEN-CHAT'),
(19, 57, 64, '2025-05-20 19:31:33', '[{\"msg_id\":1,\"sender_id\":64,\"recipient_id\":57,\"message\":\"u so saucy\",\"timestamp\":\"2025-05-20 19:31:41\",\"read\":true},{\"msg_id\":2,\"sender_id\":64,\"recipient_id\":57,\"message\":\"what is ur number\",\"timestamp\":\"2025-05-20 19:31:48\",\"read\":true},{\"msg_id\":3,\"sender_id\":57,\"recipient_id\":64,\"message\":\"wassup bae\",\"timestamp\":\"2025-05-20 19:33:14\",\"read\":true},{\"msg_id\":4,\"sender_id\":57,\"recipient_id\":64,\"message\":\"big trucks bae\",\"timestamp\":\"2025-05-20 19:33:22\",\"read\":true},{\"msg_id\":5,\"sender_id\":64,\"recipient_id\":57,\"message\":\"yooo\",\"timestamp\":\"2025-05-20 19:36:25\",\"read\":true}]', 'GEN-CHAT'),
(20, 7, 64, '2025-05-20 21:30:32', '[]', 'GEN-CHAT');

-- --------------------------------------------------------

--
-- Structure de la table `chathistory`
--

CREATE TABLE `chathistory` (
  `chatHistoryID` int(11) NOT NULL,
  `chatRoomID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `messageId` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `message` text NOT NULL,
  `sentAt` datetime DEFAULT current_timestamp(),
  `isRead` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `feedback`
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
-- Déchargement des données de la table `feedback`
--

INSERT INTO `feedback` (`feedbackId`, `clientId`, `nurseId`, `rating`, `description`, `createdAt`) VALUES
(22, 9, 35, '4', '', '2025-05-11'),
(25, 9, 22, '2', 'yay no', '2025-05-12'),
(26, 9, 32, '4', 'wrap it up', '2025-05-11'),
(27, 9, 28, '4', 'Worst nurse', '2025-05-11'),
(28, 9, 38, '4', 'Nah', '2025-05-11'),
(33, 42, 22, '5', 'gud', '2025-05-12'),
(34, 49, 22, '3', 'meh', '2025-05-16'),
(35, 57, 28, '4', 'HAAAAAAAAA', '2025-05-20'),
(36, 57, 60, '5', 'dada', '2025-05-20'),
(37, 57, 58, '3', 'NAH YOURE HIM BRODIGYYY', '2025-05-20'),
(38, 57, 64, '4', 'big buttocks reduction done smoothly', '2025-05-20'),
(39, 52, 58, '4', 'URE HIM', '2025-05-20'),
(40, 57, 70, '5', 'SLAAAAAAAAT', '2025-05-20');

-- --------------------------------------------------------

--
-- Structure de la table `nurse`
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
-- Déchargement des données de la table `nurse`
--

INSERT INTO `nurse` (`NurseID`, `licenseNumber`, `registrationFee`, `schedule`, `specialitiesGoodAt`, `clientHistory`, `feedbackReceived`, `rating`, `years_experience`, `info`) VALUES
(1, 'RN123456789', 200, '9:00 AM - 5:00 PM, Monday to Friday', 'Cardiology, Neurology', 'Has worked with over 50 patients in cardiac care.', 'Received positive feedback from patients and peers.', 4.5, 10, '0'),
(22, '1234567', 0, 'Everyday', 'General Care', '', '', 3.3, 10, '0'),
(28, '1234567', 0, 'Everyday', 'General Care', '', '', 4, 12, '0'),
(32, '1234567', 0, 'Everyday', 'General Care', '', '', 0, 12, 'Tall'),
(33, '1234567', 0, 'Everyday', 'General Care', '', '', 0, 12, 'Tall, Been helping patient for years'),
(34, '1234567', 0, 'Everyday', 'General Care', '', '', 0, 12, 'Tall, Strong, brave, been helping patinents for almost a year'),
(35, '7625321', 0, 'Everyday', 'General Care', '', '', 3, 18, 'Kind, Strong, love helping others'),
(38, '1234567', 0, 'Everyday', 'General Care', '', '', 3.7, 14, 'Been helping patients for a year, have phd in nursery'),
(44, 'maria', 0, 'never', 'General Care', '', '', 0, 4, 'poz'),
(45, 'qwerftgrew', 0, '123e4r432', 'General Care', '', '', 0, 400, 'qwertyh'),
(46, 'qwerftgrew', 0, '123e4r432', 'General Care', '', '', 0, 45, 'qwertrew'),
(47, 'qwerftgrew', 0, '123e4r432', 'General Care', '', '', 0, 6, 'nuh'),
(58, '214214135135413413', 0, 'Everyday', 'General Care', '', '', 3.5, 13, 'This is a 5star premiere'),
(59, '1231241234134', 0, 'mONDAY', 'General Care', '', '', 0, 12, 'sadasd sad'),
(60, '2131241234', 0, 'Monday', 'General Care', '', '', 5, 12, 'asfasf'),
(64, '1243436364343643', 0, 'Friday Only', 'General Care', '', '', 4, 20, 'I will cure ur diseased bbl'),
(67, '13124123413', 0, 'Monday', 'General Care', '', '', 0, 12, 'SKINNY NIGGA'),
(68, '131241324124', 0, 'thursday', 'General Care', '', '', 0, 12, 'DESTROY LONELYYY'),
(70, '1312412', 0, 'none', 'General Care', '', '', 5, 13, 'asdasdasdas');

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `patientID` int(6) NOT NULL,
  `paymentHistory` text NOT NULL,
  `chats` text NOT NULL,
  `serviceHistory` text NOT NULL,
  `problem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`patientID`, `paymentHistory`, `chats`, `serviceHistory`, `problem`) VALUES
(2, 'Paid via credit card on 2025-03-15', 'Chat with nurse on 2025-03-10 about medication', 'General checkup on 2025-03-01', ''),
(7, '', '', '', ''),
(8, '', '', '', ''),
(9, '', '', '', 'My head hurts'),
(42, '', '', '', 'My back hurt'),
(43, '', '', '', '0987890'),
(48, '', '', '', 'my head hurts'),
(49, '', '', '', 'My eyes hurt'),
(50, '', '', '', 'asdas'),
(51, '', '', '', 'help meeeeeeeee'),
(52, '', '', '', 'help meeeeeeeeeeee'),
(53, '', '', '', 'Lil O need dih injections'),
(55, '', '', '', 'I am on percs tryna get my mind right'),
(56, '', '', '', 'where da problem at?'),
(57, '', '', '', 'YVL YSL INJECTIONs'),
(65, '', '', '', 'I CAN GO VERSE FOR VERSE'),
(66, '', '', '', 'SLAAAAAAAAAAAATT '),
(69, '', '', '', 'asdasd');

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `paymentID` int(11) NOT NULL,
  `patientName` varchar(100) NOT NULL,
  `serviceCode` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `timeStamp` datetime DEFAULT current_timestamp(),
  `paymentStatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `payments`
--

INSERT INTO `payments` (`paymentID`, `patientName`, `serviceCode`, `amount`, `timeStamp`, `paymentStatus`) VALUES
(1, 'shaheryar anwar', '12321', 50.00, '2025-05-12 00:14:40', 'Completed'),
(2, 'shaheryar anwar', '12321', 50.00, '2025-05-12 00:15:03', 'Completed'),
(3, 'Yui Kimura', '12321', 50.00, '2025-05-12 00:20:17', 'Pending'),
(4, 'Apple Banana', '12321', 50.00, '2025-05-12 10:22:25', 'Pending'),
(5, 'Banana Apple', '12321', 50.00, '2025-05-12 10:36:41', 'Pending'),
(6, 'ANNas', '12321', 50.00, '2025-05-12 10:48:22', 'Pending'),
(7, 'Yui Kimura', '12122323', 14191.10, '2025-05-12 10:55:28', 'Pending'),
(8, 'Yui Kimura', '12122323', 14191.10, '2025-05-12 11:14:06', 'Pending'),
(9, 'Apple Banana', '12321', 59.00, '2025-05-12 11:27:40', 'Pending'),
(10, 'Yakin', '21341324321', 8.00, '2025-05-20 12:47:52', 'Pending'),
(11, 'YVL ', '2134124', 13.00, '2025-05-20 12:49:08', 'Pending');

-- --------------------------------------------------------

--
-- Structure de la table `payment_processors`
--

CREATE TABLE `payment_processors` (
  `processorID` int(11) NOT NULL,
  `processorName` text NOT NULL,
  `apiKey` text NOT NULL,
  `patientID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paypalpayment`
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
-- Structure de la table `serviceform`
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
-- Déchargement des données de la table `serviceform`
--

INSERT INTO `serviceform` (`Id`, `chatRoomId`, `nurseId`, `appointmentTime`, `appointmentDate`, `serviceCode`, `status`, `address`) VALUES
(2, NULL, 22, '20:42', '2025-08-10', 'MW6CE', '', '885 Av Ogilvy'),
(3, NULL, 22, '22:48', '2025-07-22', 'GRT8H', '', '514 Limgrave'),
(4, NULL, 32, '20:47', '2025-07-22', 'ZW97X', '', '514 Limgrave'),
(5, NULL, 34, '07:54', '2025-07-22', 'DGMTG', '', '514 Limgrave'),
(6, NULL, 22, '02:03', '2025-07-09', 'VWG3X', '', '514 St Croix'),
(7, NULL, 22, '02:03', '2025-07-09', 'VH6IR', '', '514 St Croix'),
(8, NULL, 22, '14:15', '2025-07-12', 'YN87V', '', '514 Limgrave'),
(9, NULL, 32, '23:00', '2025-07-12', 'MGJC1', '', '514 Limgrave'),
(10, NULL, 32, '19:50', '2025-07-12', '5DTD7', '', '514 Limgrave'),
(11, NULL, 38, '12:59', '2025-07-12', 'YPT0X', '', '514 Limgrave'),
(12, NULL, 22, '03:18', '2025-05-01', 'O7RRG', '', 'Vanier college.com'),
(13, NULL, 22, '03:18', '2025-05-01', 'TXS51', '', 'Vanier college.com'),
(14, NULL, 22, '12:24', '2025-05-01', 'Q46ZZ', '', 'Vanier college.com'),
(15, NULL, 22, '12:24', '2025-05-01', 'E0S27', '', 'Vanier college.com'),
(16, NULL, 22, '12:24', '2025-05-01', 'HF35A', '', 'Vanier college.com'),
(17, NULL, 64, '14:57', '2021-01-13', 'PHX2H', '', 'Vanier'),
(18, NULL, 64, '14:01', '2025-05-22', '2REQG', '', 'Vanier College'),
(19, NULL, 64, '19:58', '2025-05-22', 'H436N', '', 'Vanier'),
(20, NULL, 64, '14:05', '2025-05-22', 'IQ6TQ', '', 'V'),
(21, NULL, 64, '14:05', '2025-05-22', 'DSQU6', '', 'V'),
(22, NULL, 64, '14:05', '2025-05-22', 'MI8XS', '', 'V'),
(23, NULL, 64, '14:05', '2025-05-22', 'L6U9W', '', 'V'),
(24, NULL, 64, '14:05', '2025-05-22', 'YJJW7', '', 'V'),
(25, NULL, 64, '14:05', '2025-05-22', 'DAU2Q', '', 'V'),
(26, NULL, 64, '15:15', '2025-05-29', 'H7YRC', '', 'Vanier'),
(27, NULL, 64, '15:15', '2025-05-29', '93KR8', '', 'Vanier'),
(28, NULL, 64, '15:15', '2025-05-29', 'YBHAD', '', 'Vanier');

-- --------------------------------------------------------

--
-- Structure de la table `stripepayment`
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
-- Structure de la table `users`
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
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Id`, `email`, `password`, `firstName`, `lastName`, `ZipCode`, `Gender`, `createdAt`, `updatedAt`, `isActive`, `DOB`) VALUES
(1, 'john.doe@example.com', '123', 'John', 'Doe', '12345', 'Female', '2025-04-01 18:31:13', '2025-04-01 18:31:13', 0, NULL),
(2, 'alice.smith@example.com', '5e884898da28047151d0e56f8dc6292773603d0d', 'Alice', 'Smith', 'V5K1Z9', 'Female', '2025-04-03 21:35:10', '2025-04-03 21:35:10', 1, NULL),
(7, 'Shaheryar.a@hotmail.com', '02a5d12dbeec3a2df8b6435d0ad0afdd93243dda', 'Shaheryar', 'Anwar', 'H3N 2L6', 'Male', '2025-04-29 19:31:41', '2025-04-29 19:31:41', 1, '2005-07-10'),
(8, 'shaheryar751@outlook.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Anwar', 'Shaheryar', 'X0X 0X0', 'Male', '2025-04-29 20:15:40', '2025-04-29 20:15:40', 1, '2005-07-10'),
(9, 'llecopower@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Shaheryar', 'Anwar', 'X0X 0X1', 'Male', '2025-05-06 17:33:14', '2025-05-06 17:33:14', 1, '2005-07-10'),
(22, 'ShaheryarKnight7@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Malenia', 'Miquella', 'X0X 0X0', 'Female', '2025-05-06 20:43:10', '2025-05-06 20:43:10', 1, '2005-07-10'),
(23, 'Miquella@gmail.com', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', 'Miquella', 'The Kind', 'X0X 0X0', 'Male', '2025-05-06 21:27:28', '2025-05-06 21:27:28', 1, '2000-07-11'),
(27, 'hello@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'AKAKA', 'AKAKAKA', 'h3p 1a1', 'Female', '2025-05-09 10:49:18', '2025-05-09 10:49:18', 1, '2005-10-05'),
(28, 'urm@example.com', '7c222fb2927d828af22f592134e8932480637c0d', 'urm', 'ala', 'X0X 0X0', 'Female', '2025-05-09 11:06:14', '2025-05-09 11:06:14', 1, '1988-09-08'),
(32, 'Florence@hotmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'florence', 'amelia', 'X6X 0X8', 'Female', '2025-05-09 15:31:34', '2025-05-09 15:31:34', 1, '2004-11-29'),
(33, 'Pugh@gmail.com', 'f09f75a18a8a2700386fb877dabe76824131bf78', 'Elizabeth', 'Pugh', 'X6X 0X8', 'Female', '2025-05-09 16:56:21', '2025-05-09 16:56:21', 1, '2005-08-10'),
(34, 'eli@gmail.com', 'f09f75a18a8a2700386fb877dabe76824131bf78', 'Elizabeth', 'Pugh', 'X6X 0X8', 'Female', '2025-05-09 18:03:31', '2025-05-09 18:03:31', 1, '2005-08-10'),
(35, 'Nolsen@gmail.com', 'f09f75a18a8a2700386fb877dabe76824131bf78', 'Olsen', 'Noel', 'X6X 0X8', 'Male', '2025-05-09 18:10:59', '2025-05-09 18:10:59', 1, '2005-08-10'),
(38, 'Jill@hotmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Leonel', 'Jill', 'H0N 0S0', 'Female', '2025-05-11 20:53:07', '2025-05-11 20:53:07', 1, '1992-10-01'),
(42, 'Ethan@outlook.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Ethan', 'Hunts', 'H7N 2R5', 'Male', '2025-05-12 20:15:57', '2025-05-12 20:15:57', 1, '2025-05-13'),
(43, 'Knight7Shaheryar@gmail.com', '3d599b2afbb59df5c2b00ef32ff732b7628b593c', 'Guardian ', 'Knight', 'H3N 2L6', 'Male', '2025-05-12 20:41:31', '2025-05-12 20:41:31', 1, '2005-07-10'),
(44, 'nmaria@gmail.gmail', '18ae10b49c6aafbae689c356f98a74463f03f66c', 'uytrew', '12312312312321', 'maria', 'Female', '2025-05-12 21:49:59', '2025-05-12 21:49:59', 1, '1998-07-10'),
(45, 'Shaheryar7@gmail.com', 'c6a5b5fcc4b2e5f596c6593882c2ae46e30e7f74', 'wertrewe', 'qwertgrew', 'H7N 2R5', 'Female', '2025-05-12 22:02:50', '2025-05-12 22:02:50', 0, '1998-06-10'),
(46, 'Shaheryar751@gmail.com', '1dee98f2c6ef3f1181e88b39feb597b49a4878eb', 'wertrewe', 'qwertgrew', 'H7N 2R5', 'Female', '2025-05-12 22:18:57', '2025-05-12 22:18:57', 1, '1992-12-29'),
(47, 'Shaheryar7252@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'wertrewe', 'qwertgrew', 'H7N 2R5', 'Female', '2025-05-16 12:32:56', '2025-05-16 12:32:56', 1, '2005-07-13'),
(48, 'Knight75Shaheryar@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Guardian ', 'Knight', 'H7N 2R5', 'Male', '2025-05-16 13:15:52', '2025-05-16 13:15:52', 1, '2005-07-06'),
(49, 'GodfreyKing@gmail.com', 'b12bed26d164467af318b561b08d9473914838cc', 'Godfrey', 'King', 'H7N 2R5', 'Female', '2025-05-16 13:51:20', '2025-05-16 13:51:20', 1, '2005-06-23'),
(50, 'y@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'yakin', 'sucess', 'h2w 2c5', 'Female', '2025-05-18 22:48:10', '2025-05-18 22:48:10', 1, '1999-02-13'),
(51, 'jeff@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Jeff', 'Succes', 'H2W 2C5', 'Non-binary', '2025-05-18 23:54:28', '2025-05-18 23:54:28', 1, '1995-01-12'),
(52, 'zoota@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Zoota', 'Gumba', 'H2W 2C5', 'Male', '2025-05-18 23:56:58', '2025-05-18 23:56:58', 1, '1998-01-12'),
(53, 'osama@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'kutta', 'LILO', 'H2W 2C5', 'Non-binary', '2025-05-19 01:22:39', '2025-05-19 01:22:39', 1, '2002-12-12'),
(55, 'ela@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Jace', 'Salter', 'J2W 7ST', 'Male', '2025-05-19 01:27:07', '2025-05-19 01:27:07', 1, '2001-02-03'),
(56, 'perc@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Twisty', 'Yeat', 'S2E Y4S', 'Female', '2025-05-19 01:32:24', '2025-05-19 01:32:24', 1, '2001-02-12'),
(57, 'yvl@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Tana', 'YVLYSL', 'A7L J3S', 'Male', '2025-05-19 01:58:47', '2025-05-19 01:58:47', 1, '2003-12-12'),
(58, 'doc@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Maxwell', 'Dent', 'H2W 3S4', 'Male', '2025-05-19 04:17:08', '2025-05-19 04:17:08', 1, '1987-12-25'),
(59, 'rona@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Lana', 'Rona', 'H3S 4J2', 'Non-binary', '2025-05-19 04:27:41', '2025-05-19 04:27:41', 1, '1998-12-21'),
(60, 'sad@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Clona', 'SAS', 'H2W 2C5', 'Male', '2025-05-19 04:30:12', '2025-05-19 04:30:12', 1, '2001-03-21'),
(64, 'y2k@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Diana', 'Spice', 'H2W 2C5', '', '2025-05-20 13:30:12', '2025-05-20 13:30:12', 0, '1999-01-04'),
(65, 'yakin726@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Kentrell', 'YoungBoy', 'H2W 2C5', 'Male', '2025-05-20 15:16:50', '2025-05-20 15:16:50', 1, '2001-04-11'),
(66, 'opium@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Playboi ', 'Carti', 'H2W 2C5', '', '2025-05-20 15:42:45', '2025-05-20 15:42:45', 1, '2025-05-07'),
(67, 'ken@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Ken', 'Carson', 'H2W 2C5', '', '2025-05-20 15:44:15', '2025-05-20 15:44:15', 0, '2001-05-05'),
(68, 'lone@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Destroy', 'Lonely', 'H2W 2C5', '', '2025-05-20 15:50:14', '2025-05-20 15:50:14', 1, '2000-02-20'),
(69, 'jones@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'COCO', 'Jones', 'H2W 2C5', 'Non-binary', '2025-05-20 16:01:22', '2025-05-20 16:01:22', 1, '2025-05-15'),
(70, 'slime@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Slime', 'STuff', 'H2W 2C5', 'Female', '2025-05-20 17:59:31', '2025-05-20 17:59:31', 1, '2000-12-12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chatRoomId`),
  ADD KEY `fk_chat_clientId` (`clientId`),
  ADD KEY `fk_chat_nurseId` (`nurseId`);

--
-- Index pour la table `chathistory`
--
ALTER TABLE `chathistory`
  ADD PRIMARY KEY (`chatHistoryID`),
  ADD KEY `fk_chathistory_chatRoomId` (`chatRoomID`);

--
-- Index pour la table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `senderId` (`senderId`),
  ADD KEY `receiverId` (`receiverId`);

--
-- Index pour la table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackId`),
  ADD KEY `fk_feedback_clientId` (`clientId`),
  ADD KEY `fk_feedback_nurseId` (`nurseId`);

--
-- Index pour la table `nurse`
--
ALTER TABLE `nurse`
  ADD KEY `NurseID` (`NurseID`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD UNIQUE KEY `patientID_2` (`patientID`),
  ADD KEY `patientID` (`patientID`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`);

--
-- Index pour la table `payment_processors`
--
ALTER TABLE `payment_processors`
  ADD PRIMARY KEY (`processorID`),
  ADD KEY `fk_PaymentProcessors_patientID` (`patientID`);

--
-- Index pour la table `paypalpayment`
--
ALTER TABLE `paypalpayment`
  ADD PRIMARY KEY (`paypalID`),
  ADD KEY `fk_paypal_processorID` (`processorID`),
  ADD KEY `fk_paypal_paymentID` (`paymentID`);

--
-- Index pour la table `serviceform`
--
ALTER TABLE `serviceform`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_chatRoomId` (`chatRoomId`);

--
-- Index pour la table `stripepayment`
--
ALTER TABLE `stripepayment`
  ADD PRIMARY KEY (`stripeID`),
  ADD KEY `fk_stripe_paymentID` (`paymentID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chat`
--
ALTER TABLE `chat`
  MODIFY `chatRoomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `payment_processors`
--
ALTER TABLE `payment_processors`
  MODIFY `processorID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paypalpayment`
--
ALTER TABLE `paypalpayment`
  MODIFY `paypalID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `serviceform`
--
ALTER TABLE `serviceform`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `stripepayment`
--
ALTER TABLE `stripepayment`
  MODIFY `stripeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `fk_chat_clientId` FOREIGN KEY (`clientId`) REFERENCES `patients` (`patientID`),
  ADD CONSTRAINT `fk_chat_nurseId` FOREIGN KEY (`nurseId`) REFERENCES `nurse` (`NurseID`);

--
-- Contraintes pour la table `chathistory`
--
ALTER TABLE `chathistory`
  ADD CONSTRAINT `fk_chathistory_chatRoomId` FOREIGN KEY (`chatRoomID`) REFERENCES `chat` (`chatRoomId`);

--
-- Contraintes pour la table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `users` (`Id`);

--
-- Contraintes pour la table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_clientId` FOREIGN KEY (`clientId`) REFERENCES `patients` (`patientID`),
  ADD CONSTRAINT `fk_feedback_nurseId` FOREIGN KEY (`nurseId`) REFERENCES `nurse` (`NurseID`);

--
-- Contraintes pour la table `nurse`
--
ALTER TABLE `nurse`
  ADD CONSTRAINT `nurse_ibfk_1` FOREIGN KEY (`NurseID`) REFERENCES `users` (`Id`);

--
-- Contraintes pour la table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `users` (`Id`);

--
-- Contraintes pour la table `payment_processors`
--
ALTER TABLE `payment_processors`
  ADD CONSTRAINT `fk_PaymentProcessors_patientID` FOREIGN KEY (`patientID`) REFERENCES `patients` (`patientID`);

--
-- Contraintes pour la table `serviceform`
--
ALTER TABLE `serviceform`
  ADD CONSTRAINT `fk_chatRoomId` FOREIGN KEY (`chatRoomId`) REFERENCES `chat` (`chatRoomId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
