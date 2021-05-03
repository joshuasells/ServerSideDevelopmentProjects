-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2020 at 05:31 AM
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
-- Database: `marshall`
--

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `job_id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `truck_id` int(11) DEFAULT NULL,
  `dateWorkedOn` date DEFAULT NULL,
  `problem` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `solved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`job_id`, `emp_id`, `truck_id`, `dateWorkedOn`, `problem`, `solved`) VALUES
(1, 11, 520, '2020-04-20', 'New tires', 1),
(2, 12, 521, '2020-05-16', 'Air leak', 1),
(3, 13, 522, '2020-07-27', 'AC repair', 0),
(4, 14, 531, '2020-08-15', 'Air leak', 1),
(5, 15, 532, '2020-08-16', 'New mirrors', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `truck_id` (`truck_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `mechanic` (`emp_id`),
  ADD CONSTRAINT `job_ibfk_2` FOREIGN KEY (`truck_id`) REFERENCES `truck` (`truck_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
