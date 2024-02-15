-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- Generation Time: Dec 15, 2023 at 05:21 AM
-- Server version: 10.8.8-MariaDB-1:10.8.8+maria~ubu2204
-- PHP Version: 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cw2`
--

-- --------------------------------------------------------

--
-- Table structure for table `Fines`
--

CREATE TABLE `Fines` (
  `Fine_ID` int(11) NOT NULL,
  `Fine_amount` int(11) NOT NULL,
  `Fine_points` int(11) NOT NULL,
  `Incident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Fines`
--

INSERT INTO `Fines` (`Fine_ID`, `Fine_amount`, `Fine_points`, `Incident_ID`) VALUES
(1, 2000, 6, 3),
(2, 50, 0, 2),
(3, 500, 3, 4),
(4, 1, 1, 1),
(5, 20, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Incident`
--

CREATE TABLE `Incident` (
  `Incident_ID` int(11) NOT NULL,
  `Vehicle_ID` int(11) DEFAULT NULL,
  `People_ID` int(11) DEFAULT NULL,
  `Incident_Date` date NOT NULL,
  `Incident_Report` varchar(500) NOT NULL,
  `Offence_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Incident`
--

INSERT INTO `Incident` (`Incident_ID`, `Vehicle_ID`, `People_ID`, `Incident_Date`, `Incident_Report`, `Offence_ID`) VALUES
(1, 15, 4, '2017-12-01', '40mph in a 30 limit', 1),
(2, 20, 8, '2017-11-01', 'Double parked', 4),
(3, 13, 4, '2017-09-17', '110mph on motorway', 1),
(4, 14, 2, '2017-08-22', 'Failure to stop at a red light - travelling 25mph', 8),
(5, 13, 4, '2017-10-17', 'Not wearing a seatbelt on the M1', 3),
(6, NULL, 1, '2023-12-14', '9', 9),
(7, 12, 1, '2023-12-14', '11', 1),
(8, 12, 1, '2023-12-14', '1', 1),
(9, 62, 1, '2023-12-14', 'q', 1),
(10, 62, 1, '2023-12-14', 'q', 1),
(11, 62, 1, '2023-12-14', 'q', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Log`
--

CREATE TABLE `Log` (
  `log_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `operation_time` datetime NOT NULL DEFAULT current_timestamp(),
  `operation_type` enum('CREATE','DELETE','UPDATE','RETRIEVE') NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Log`
--

INSERT INTO `Log` (`log_id`, `username`, `operation_time`, `operation_type`, `details`) VALUES
(1, 'admin1', '2023-11-25 23:03:45', 'CREATE', 'Created new user: user123'),
(3, 'officer1', '2023-11-25 23:05:35', 'UPDATE', 'Updated vehicle record: vehicle_id 101'),
(6, 'officer1', '2023-12-15 03:55:03', 'CREATE', 'details'),
(8, 'officer1', '2023-12-15 03:55:54', 'CREATE', 'details'),
(9, 'admin1', '2023-12-15 03:59:17', 'RETRIEVE', 'searched for people with aa'),
(10, 'admin1', '2023-12-15 04:00:41', 'RETRIEVE', 'searched for <strong>people</strong> with: \'aax\''),
(11, 'admin1', '2023-12-15 04:03:03', 'RETRIEVE', 'searched for <strong>People</strong> with: \'<strong>test\'</strong>'),
(12, 'admin1', '2023-12-15 04:09:03', 'CREATE', 'Added new Person: <strong>test</strong> with licence number: testaudit'),
(13, 'admin1', '2023-12-15 04:10:24', 'RETRIEVE', 'showed all <strong>People</strong>'),
(14, 'admin1', '2023-12-15 04:10:31', 'RETRIEVE', 'searched for <strong>Vehicle</strong> with: \'<strong>ss\'</strong>'),
(15, 'admin1', '2023-12-15 04:10:33', 'RETRIEVE', 'searched for <strong>Vehicle</strong> with: \'<strong>j\'</strong>'),
(16, 'admin1', '2023-12-15 04:10:35', 'RETRIEVE', 'showed all <strong>Vehicles</strong>'),
(17, 'admin1', '2023-12-15 04:12:32', 'CREATE', 'added new <strong>Vehicle</strong> with: \'<strong>ddddd\'</strong>'),
(18, 'admin1', '2023-12-15 04:15:52', 'CREATE', 'Added new Fine: <strong>20</strong> with points: 2 and incident ID: 5'),
(19, 'admin1', '2023-12-15 04:17:40', 'CREATE', 'Added new Police User: <strong>newpolice</strong> with role: <strong>Police</strong>'),
(20, 'admin1', '2023-12-15 04:19:37', 'RETRIEVE', 'searched for <strong>People</strong> with: \'<strong>sssssstest\'</strong>'),
(21, 'officer1', '2023-12-15 04:23:34', 'RETRIEVE', 'showed all <strong>People</strong>'),
(22, 'officer1', '2023-12-15 04:23:51', 'RETRIEVE', 'showed all <strong>Vehicles</strong>'),
(23, 'officer1', '2023-12-15 04:23:58', 'RETRIEVE', 'searched for <strong>Vehicle</strong> with: \'<strong>a\'</strong>'),
(24, 'officer1', '2023-12-15 04:28:00', 'RETRIEVE', 'Searched for Incident: <strong></strong>'),
(25, 'officer1', '2023-12-15 04:28:03', 'RETRIEVE', 'Searched for Incident: <strong></strong>'),
(26, 'officer1', '2023-12-15 04:28:07', 'RETRIEVE', 'Searched for Incident: <strong>a</strong>'),
(27, 'moreland', '2023-12-15 04:46:51', 'RETRIEVE', 'showed all <strong>People</strong>'),
(28, 'admin1', '2023-12-15 05:14:39', 'RETRIEVE', 'searched for <strong>People</strong> with: \'<strong>a\'</strong>'),
(29, 'admin1', '2023-12-15 05:14:41', 'RETRIEVE', 'searched for <strong>People</strong> with: \'<strong>a\'</strong>'),
(30, 'admin1', '2023-12-15 05:14:41', 'RETRIEVE', 'showed all <strong>People</strong>'),
(31, 'admin1', '2023-12-15 05:14:51', 'CREATE', 'Added new Person: <strong>aaa</strong> with licence number: num2299'),
(32, 'admin1', '2023-12-15 05:14:59', 'RETRIEVE', 'searched for <strong>People</strong> with: \'<strong>num2299\'</strong>'),
(33, 'admin1', '2023-12-15 05:15:01', 'RETRIEVE', 'searched for <strong>People</strong> with: \'<strong>num2299\'</strong>'),
(34, 'admin1', '2023-12-15 05:15:01', 'RETRIEVE', 'showed all <strong>People</strong>'),
(35, 'admin1', '2023-12-15 05:15:04', 'RETRIEVE', 'showed all <strong>Vehicles</strong>'),
(36, 'admin1', '2023-12-15 05:20:31', 'RETRIEVE', 'Searched for Incident: <strong></strong>'),
(37, 'admin1', '2023-12-15 05:20:44', 'CREATE', 'Added new Fine: <strong>aa</strong> with points: aa and incident ID: 7');

-- --------------------------------------------------------

--
-- Table structure for table `Offence`
--

CREATE TABLE `Offence` (
  `Offence_ID` int(11) NOT NULL,
  `Offence_description` varchar(50) NOT NULL,
  `Offence_maxFine` int(11) NOT NULL,
  `Offence_maxPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Offence`
--

INSERT INTO `Offence` (`Offence_ID`, `Offence_description`, `Offence_maxFine`, `Offence_maxPoints`) VALUES
(1, 'Speeding', 1000, 3),
(2, 'Speeding on a motorway', 2500, 6),
(3, 'Seat belt offence', 500, 0),
(4, 'Illegal parking', 500, 0),
(5, 'Drink driving', 10000, 11),
(6, 'Driving without a licence', 10000, 0),
(7, 'Traffic light offences', 1000, 3),
(8, 'Cycling on pavement', 500, 0),
(9, 'Failure to have control of vehicle', 1000, 3),
(10, 'Dangerous driving', 1000, 11),
(11, 'Careless driving', 5000, 6),
(12, 'Dangerous cycling', 2500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Ownership`
--

CREATE TABLE `Ownership` (
  `People_ID` int(11) NOT NULL,
  `Vehicle_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Ownership`
--

INSERT INTO `Ownership` (`People_ID`, `Vehicle_ID`) VALUES
(3, 12),
(8, 20),
(4, 15),
(4, 13),
(1, 16),
(2, 14),
(5, 17),
(6, 18),
(7, 21),
(1, 22),
(1, 21),
(1, 48),
(1, 48),
(11, 50),
(14, 51),
(14, 51),
(14, 51),
(14, 51),
(14, 51),
(14, 51),
(14, 51),
(14, 51),
(2, 51),
(2, 51),
(2, 51),
(2, 51),
(2, 51),
(2, 51),
(15, 59),
(15, 59),
(15, 59),
(15, 59),
(32, 60),
(32, 60),
(32, 60),
(32, 60),
(32, 60),
(32, 60),
(32, 60),
(33, 22),
(33, 22),
(33, 22),
(33, 22),
(33, 22),
(34, 61),
(34, 61),
(1, 62),
(1, 63);

-- --------------------------------------------------------

--
-- Table structure for table `People`
--

CREATE TABLE `People` (
  `People_ID` int(11) NOT NULL,
  `People_name` varchar(50) NOT NULL,
  `People_licence` varchar(16) DEFAULT NULL,
  `People_address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `People`
--

INSERT INTO `People` (`People_ID`, `People_name`, `People_licence`, `People_address`) VALUES
(1, 'James Smith', 'SMITH92LDOFJJ829', '23 Barnsdale Road, Leicester'),
(2, 'Jennifer Allen', 'ALLEN88K23KLR9B3', '46 Bramcote Drive, Nottingham'),
(3, 'John Myers', 'MYERS99JDW8REWL3', '323 Derby Road, Nottingham'),
(4, 'James Smith', 'SMITHR004JFS20TR', '26 Devonshire Avenue, Nottingham'),
(5, 'Terry Brown', 'BROWND3PJJ39DLFG', '7 Clarke Rd, Nottingham'),
(6, 'Mary Adams', 'ADAMSH9O3JRHH107', '38 Thurman St, Nottingham'),
(7, 'Neil Becker', 'BECKE88UPR840F9R', '6 Fairfax Close, Nottingham'),
(8, 'Angela Smith', 'SMITH222LE9FJ5DS', '30 Avenue Road, Grantham'),
(9, 'Xene Medora', 'MEDORH914ANBB223', '22 House Drive, West Bridgford'),
(10, '', 'aa', NULL),
(11, '', 'qq', NULL),
(12, 'new', 'newnum', NULL),
(13, 'modal', '1234', NULL),
(14, 'test', 'num321', NULL),
(15, 'tesqqq', 'qqq', NULL),
(16, '111', '1111', NULL),
(17, '222', '22222', NULL),
(18, '333', '3333', NULL),
(19, 'aaaa', 'aaaa', NULL),
(20, 'z', 'z', NULL),
(21, 'ss', 'ww', NULL),
(22, '1357', '1423', NULL),
(23, '2341', 'qw12', NULL),
(24, '0099', '9900', NULL),
(25, 'test99', 'num09', NULL),
(26, 'tt', 'tt09', NULL),
(27, 'another', 'numbre1', NULL),
(28, 'newppp', 'new111', NULL),
(29, '2564', '5642', NULL),
(30, 'pwesonname1', 'licencenum11', NULL),
(31, 'name2', 'num22', NULL),
(32, 'name3', 'num33', NULL),
(33, 'name4', 'num44', NULL),
(34, 'name5', 'ppnum5', NULL),
(35, '2288', '9764', NULL),
(36, 'name22', 'num22222', NULL),
(37, 'testname', 'teapot', 'Flat 60 Block F, Nottingham two accommodation'),
(38, 'unset', 'numunset1', NULL),
(39, 'test', 'testaudit', NULL),
(40, 'aaa', 'num2299', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Police`
--

CREATE TABLE `Police` (
  `Police_username` varchar(50) NOT NULL,
  `Police_password` varchar(255) NOT NULL,
  `Police_role` enum('Administrator','Police') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Police`
--

INSERT INTO `Police` (`Police_username`, `Police_password`, `Police_role`) VALUES
('aaaaaa', 'aa', 'Police'),
('admin1', 'admin', 'Administrator'),
('daniels', 'copper99', 'Administrator'),
('mcnulty', 'plod123', 'Police'),
('moreland', 'fuzz42', 'Police'),
('newpolice', '1', 'Police'),
('officer1', 'user', 'Police');

-- --------------------------------------------------------

--
-- Table structure for table `Vehicle`
--

CREATE TABLE `Vehicle` (
  `Vehicle_ID` int(11) NOT NULL,
  `Vehicle_type` varchar(20) NOT NULL,
  `Vehicle_colour` varchar(20) NOT NULL,
  `Vehicle_licence` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Vehicle`
--

INSERT INTO `Vehicle` (`Vehicle_ID`, `Vehicle_type`, `Vehicle_colour`, `Vehicle_licence`) VALUES
(12, 'Ford Fiesta', 'Blue', 'LB15AJL'),
(13, 'Ferrari 458', 'Red', 'MY64PRE'),
(14, 'Vauxhall Astra', 'Silver', 'FD65WPQ'),
(15, 'Honda Civic', 'Green', 'FJ17AUG'),
(16, 'Toyota Prius', 'Silver', 'FP16KKE'),
(17, 'Ford Mondeo', 'Black', 'FP66KLM'),
(18, 'Ford Focus', 'White', 'DJ14SLE'),
(20, 'Nissan Pulsar', 'Red', 'NY64KWD'),
(21, 'Renault Scenic', 'Silver', 'BC16OEA'),
(22, 'Hyundai i30', 'Grey', 'AD223NG'),
(23, 'a', 'a', 'a'),
(24, 'a', 'a', 'a'),
(25, 'a', 'a', 'a'),
(26, 'a', 'a', 'a'),
(27, 'q', 'q', 'q'),
(28, 'w', 'w', 'w'),
(29, 'w', 'w', 'w'),
(30, 'a', 'a', 'a'),
(31, 'a', 'a', 'a'),
(32, 'a', 'a', 'a'),
(33, 'a', 'a', 'a'),
(34, 'q', 'q', 'q'),
(35, 'q', 'q', 'q'),
(36, 'q', 'q', 'q'),
(37, 'q', 'q', 'q'),
(38, 'q', 'q', 'q'),
(39, 'q', 'q', 'q'),
(40, 'q', 'q', 'q'),
(41, 'q', 'q', 'q'),
(42, 'q', 'q', 'q'),
(43, 'q', 'q', 'q'),
(44, 'a', 'a', 'a'),
(45, 'a', 'a', 'a'),
(46, 'aa', 'a', 'a'),
(47, 'aaa', 'bb', 'c'),
(48, 'v', 'v', 'v'),
(49, 'v', 'v', 'v'),
(50, 'qq', 'qq', 'qq'),
(51, '1', 'a', 'z'),
(52, '1', 'a', 'z'),
(53, '1', 'a', 'z'),
(54, '1', 'a', 'z'),
(55, '1', 'a', 'z'),
(56, '1', 'a', 'z'),
(57, '1', 'a', 'z'),
(58, '1', 'a', 'z'),
(59, 'qqqq', 'qqqq', 'qqqq'),
(60, 'type1', 'color1', 'vl1'),
(61, 'tp5', 'cl5', 'rgnum5'),
(62, '1', '1', '521'),
(63, 'aa', 'ss', 'ddddd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Fines`
--
ALTER TABLE `Fines`
  ADD PRIMARY KEY (`Fine_ID`),
  ADD KEY `fk_fines_incident` (`Incident_ID`);

--
-- Indexes for table `Incident`
--
ALTER TABLE `Incident`
  ADD PRIMARY KEY (`Incident_ID`),
  ADD KEY `fk_incident_offence` (`Offence_ID`),
  ADD KEY `fk_incident_vehicle` (`Vehicle_ID`);

--
-- Indexes for table `Log`
--
ALTER TABLE `Log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `Offence`
--
ALTER TABLE `Offence`
  ADD PRIMARY KEY (`Offence_ID`);

--
-- Indexes for table `Ownership`
--
ALTER TABLE `Ownership`
  ADD KEY `fk_ownership_people` (`People_ID`),
  ADD KEY `fk_ownership_vehicle` (`Vehicle_ID`);

--
-- Indexes for table `People`
--
ALTER TABLE `People`
  ADD PRIMARY KEY (`People_ID`);

--
-- Indexes for table `Police`
--
ALTER TABLE `Police`
  ADD PRIMARY KEY (`Police_username`);

--
-- Indexes for table `Vehicle`
--
ALTER TABLE `Vehicle`
  ADD PRIMARY KEY (`Vehicle_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Fines`
--
ALTER TABLE `Fines`
  MODIFY `Fine_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Incident`
--
ALTER TABLE `Incident`
  MODIFY `Incident_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Log`
--
ALTER TABLE `Log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `Offence`
--
ALTER TABLE `Offence`
  MODIFY `Offence_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `People`
--
ALTER TABLE `People`
  MODIFY `People_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `Vehicle`
--
ALTER TABLE `Vehicle`
  MODIFY `Vehicle_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Fines`
--
ALTER TABLE `Fines`
  ADD CONSTRAINT `fk_fines_incident` FOREIGN KEY (`Incident_ID`) REFERENCES `Incident` (`Incident_ID`);

--
-- Constraints for table `Incident`
--
ALTER TABLE `Incident`
  ADD CONSTRAINT `fk_incident_offence` FOREIGN KEY (`Offence_ID`) REFERENCES `Offence` (`Offence_ID`),
  ADD CONSTRAINT `fk_incident_people` FOREIGN KEY (`People_ID`) REFERENCES `People` (`People_ID`),
  ADD CONSTRAINT `fk_incident_vehicle` FOREIGN KEY (`Vehicle_ID`) REFERENCES `Vehicle` (`Vehicle_ID`);

--
-- Constraints for table `Log`
--
ALTER TABLE `Log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`username`) REFERENCES `Police` (`Police_username`);

--
-- Constraints for table `Ownership`
--
ALTER TABLE `Ownership`
  ADD CONSTRAINT `fk_ownership_people` FOREIGN KEY (`People_ID`) REFERENCES `People` (`People_ID`),
  ADD CONSTRAINT `fk_ownership_vehicle` FOREIGN KEY (`Vehicle_ID`) REFERENCES `Vehicle` (`Vehicle_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
