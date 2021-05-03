-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2020 at 04:22 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sunrun`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `runnerUpdate` (IN `thisFName` VARCHAR(25), IN `thisLName` VARCHAR(25), IN `thisPhone` VARCHAR(25), IN `thisGender` VARCHAR(25), IN `thisIDRunner` INT)  BEGIN
UPDATE runner SET fName = thisFName, lName = thisLName, phone = thisPhone, gender = thisGender WHERE id_runner = thisIDRunner;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `race`
--

CREATE TABLE `race` (
  `id_race` int(6) UNSIGNED NOT NULL,
  `raceName` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `entranceFee` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `race`
--

INSERT INTO `race` (`id_race`, `raceName`, `entranceFee`) VALUES
(1, '10K', 46),
(2, '5K', 46),
(3, 'Marathon', 85),
(4, 'Half Marathon', 75);

-- --------------------------------------------------------

--
-- Table structure for table `runner`
--

CREATE TABLE `runner` (
  `id_runner` int(6) UNSIGNED NOT NULL,
  `fName` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `lName` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `runner`
--

INSERT INTO `runner` (`id_runner`, `fName`, `lName`, `gender`, `phone`) VALUES
(1, 'Johnny', 'Hayes', 'male', '1234567890'),
(2, 'Robert', 'Fowler', 'male', '2234567890'),
(3, 'James', 'Clark', 'male', '3234567890'),
(4, 'Marie-Louise', 'Ledru', 'female', '4234567890'),
(5, 'John', 'Watson', 'male', '5071237899'),
(6, 'Sally', 'Johnson', 'female', '8121237800'),
(7, 'Paula', 'Radcliff', 'female', '8029881123');

-- --------------------------------------------------------

--
-- Table structure for table `runner_race`
--

CREATE TABLE `runner_race` (
  `id_runner` int(6) DEFAULT NULL,
  `id_race` int(6) DEFAULT NULL,
  `bibNumber` int(6) DEFAULT NULL,
  `paid` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `runner_race`
--

INSERT INTO `runner_race` (`id_runner`, `id_race`, `bibNumber`, `paid`) VALUES
(2, 4, 1234, 1),
(1, 3, 1234, 1),
(1, 4, 1234, 1),
(2, 3, 1234, 1),
(3, 3, 1234, 1),
(3, 4, 1234, 1),
(4, 3, 1234, 1),
(4, 4, 1234, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE `sponsor` (
  `id_sponsor` int(6) UNSIGNED NOT NULL,
  `sponsorName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_runner` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`id_sponsor`, `sponsorName`, `id_runner`) VALUES
(1, 'Nike', 2),
(2, '', 3),
(3, 'House of Heroes', 4),
(4, 'Wells Fargo Bank', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `race`
--
ALTER TABLE `race`
  ADD PRIMARY KEY (`id_race`);

--
-- Indexes for table `runner`
--
ALTER TABLE `runner`
  ADD PRIMARY KEY (`id_runner`);

--
-- Indexes for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`id_sponsor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `race`
--
ALTER TABLE `race`
  MODIFY `id_race` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `runner`
--
ALTER TABLE `runner`
  MODIFY `id_runner` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sponsor`
--
ALTER TABLE `sponsor`
  MODIFY `id_sponsor` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
