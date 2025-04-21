-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2024 at 01:39 PM
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
-- Database: `my_projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

CREATE TABLE `crops` (
  `CropID` int(11) NOT NULL,
  `FarmerID` int(11) DEFAULT NULL,
  `CropName` varchar(50) NOT NULL,
  `CropType` varchar(50) DEFAULT NULL,
  `SoilType` varchar(50) DEFAULT NULL,
  `IdealTemperature` float DEFAULT NULL CHECK (`IdealTemperature` >= 0),
  `IdealHumidity` float DEFAULT NULL CHECK (`IdealHumidity` >= 0 and `IdealHumidity` <= 100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`CropID`, `FarmerID`, `CropName`, `CropType`, `SoilType`, `IdealTemperature`, `IdealHumidity`) VALUES
(13, 21, 'maize', 'grain', 'good', 25, 26),
(15, 21, 'mangoes ', 'fruit', 'black', 24, 32);

-- --------------------------------------------------------

--
-- Table structure for table `farmers`
--

CREATE TABLE `farmers` (
  `FarmerID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `ContactNumber` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmers`
--

INSERT INTO `farmers` (`FarmerID`, `FirstName`, `LastName`, `ContactNumber`, `Email`, `Location`) VALUES
(21, 'Ravitej', 'Kakhandaki', '8073809901', 'anandtsanand4@gmail.com', 'banhatti'),
(22, 'Sagar', 'Kakhandaki', '9972466673', 'ravitejkakhandaki17@gmai.com', 'blr'),
(23, 'ravi', 'ka', '8310877366', 'mmb39441@gmail.com', 'blr');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `FieldID` int(11) NOT NULL,
  `FarmerID` int(11) DEFAULT NULL,
  `FieldName` varchar(50) DEFAULT NULL,
  `FieldSize` float DEFAULT NULL CHECK (`FieldSize` > 0),
  `SoilCondition` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`FieldID`, `FarmerID`, `FieldName`, `FieldSize`, `SoilCondition`) VALUES
(5, 21, 'ravi', 25, 'good'),
(6, 22, 'jhdn', 5285, 'good');

-- --------------------------------------------------------

--
-- Table structure for table `harvestrecords`
--

CREATE TABLE `harvestrecords` (
  `HarvestID` int(11) NOT NULL,
  `CropID` int(11) DEFAULT NULL,
  `HarvestDate` date DEFAULT NULL,
  `QuantityHarvested` float DEFAULT NULL CHECK (`QuantityHarvested` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harvestrecords`
--

INSERT INTO `harvestrecords` (`HarvestID`, `CropID`, `HarvestDate`, `QuantityHarvested`) VALUES
(8, 13, '2024-03-16', 26);

-- --------------------------------------------------------

--
-- Table structure for table `marketprices`
--

CREATE TABLE `marketprices` (
  `PriceID` int(11) NOT NULL,
  `CropID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `MarketName` varchar(100) DEFAULT NULL,
  `PricePerUnit` float DEFAULT NULL CHECK (`PricePerUnit` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesticides`
--

CREATE TABLE `pesticides` (
  `PesticideID` int(11) NOT NULL,
  `PesticideName` varchar(100) NOT NULL,
  `ApplicationDate` date DEFAULT NULL,
  `CropID` int(11) DEFAULT NULL,
  `QuantityUsed` float DEFAULT NULL CHECK (`QuantityUsed` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crops`
--
ALTER TABLE `crops`
  ADD PRIMARY KEY (`CropID`),
  ADD KEY `FarmerID` (`FarmerID`);

--
-- Indexes for table `farmers`
--
ALTER TABLE `farmers`
  ADD PRIMARY KEY (`FarmerID`),
  ADD UNIQUE KEY `ContactNumber` (`ContactNumber`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`FieldID`),
  ADD UNIQUE KEY `FieldName` (`FieldName`),
  ADD KEY `FarmerID` (`FarmerID`);

--
-- Indexes for table `harvestrecords`
--
ALTER TABLE `harvestrecords`
  ADD PRIMARY KEY (`HarvestID`),
  ADD KEY `CropID` (`CropID`);

--
-- Indexes for table `marketprices`
--
ALTER TABLE `marketprices`
  ADD PRIMARY KEY (`PriceID`),
  ADD KEY `CropID` (`CropID`);

--
-- Indexes for table `pesticides`
--
ALTER TABLE `pesticides`
  ADD PRIMARY KEY (`PesticideID`),
  ADD KEY `CropID` (`CropID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `CropID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `farmers`
--
ALTER TABLE `farmers`
  MODIFY `FarmerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `FieldID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `harvestrecords`
--
ALTER TABLE `harvestrecords`
  MODIFY `HarvestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `marketprices`
--
ALTER TABLE `marketprices`
  MODIFY `PriceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pesticides`
--
ALTER TABLE `pesticides`
  MODIFY `PesticideID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crops`
--
ALTER TABLE `crops`
  ADD CONSTRAINT `crops_ibfk_1` FOREIGN KEY (`FarmerID`) REFERENCES `farmers` (`FarmerID`) ON DELETE CASCADE;

--
-- Constraints for table `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`FarmerID`) REFERENCES `farmers` (`FarmerID`) ON DELETE CASCADE;

--
-- Constraints for table `harvestrecords`
--
ALTER TABLE `harvestrecords`
  ADD CONSTRAINT `harvestrecords_ibfk_1` FOREIGN KEY (`CropID`) REFERENCES `crops` (`CropID`) ON DELETE SET NULL;

--
-- Constraints for table `marketprices`
--
ALTER TABLE `marketprices`
  ADD CONSTRAINT `marketprices_ibfk_1` FOREIGN KEY (`CropID`) REFERENCES `crops` (`CropID`) ON DELETE SET NULL;

--
-- Constraints for table `pesticides`
--
ALTER TABLE `pesticides`
  ADD CONSTRAINT `pesticides_ibfk_1` FOREIGN KEY (`CropID`) REFERENCES `crops` (`CropID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
