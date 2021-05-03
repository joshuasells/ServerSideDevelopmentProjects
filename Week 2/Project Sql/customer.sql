-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2020 at 05:27 AM
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
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` int(11) NOT NULL,
  `fName` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lName` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `fName`, `lName`, `comName`) VALUES
(1, 'Bette', 'Nicka', 'Sport En Art'),
(2, 'Veronika', 'Inouye', 'C 4 Network Inc'),
(3, 'Willard', 'Kolmetz', 'Ingalls, Donald R Esq'),
(4, 'Maryann', 'Royster', 'Franklin, Peter L Esq'),
(5, 'Alisha', 'Slusarski', 'Wtlz Power 107 Fm'),
(6, 'Allene', 'Iturbide', 'Ledecky, David Esq'),
(7, 'Chanel', 'Caudy', 'Professional Image Inc'),
(8, 'Ezekiel', 'Chui', 'Sider, Donald C Esq'),
(9, 'Willow', 'Kusko', 'U Pull It'),
(10, 'Bernardo', 'Figeroa', 'Clark, Richard Cpa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
