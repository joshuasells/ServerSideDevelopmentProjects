-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2020 at 05:32 AM
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
-- Table structure for table `zip`
--

CREATE TABLE `zip` (
  `zipCode` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zip`
--

INSERT INTO `zip` (`zipCode`, `city`, `state`) VALUES
('10011', 'Hamilton', 'OH'),
('10025', 'Chicago', 'IL'),
('11953', 'San Jose', 'CA'),
('12204', 'Sioux Falls', 'SD'),
('19014', 'Prineville', 'OR'),
('19443', 'Baltimore', 'MD'),
('21224', 'Kulpsville', 'PA'),
('21601', 'Middle Island', 'NY'),
('37110', 'Los Angelos', 'CA'),
('43215', 'Chagrin Falls', 'OH'),
('44023', 'Laredo', 'TX'),
('44805', 'Phoenix', 'AZ'),
('45011', 'Mc Minnville', 'TN'),
('48116', 'Milwaukee', 'WI'),
('48180', 'Taylor', 'MI'),
('53207', 'Aston', 'PA'),
('54481', 'Ashertown', 'OH'),
('57105', 'Irving', 'TX'),
('60632', 'Albany', 'NY'),
('66218', 'Middlesex', 'NJ'),
('67410', 'Stevens Point', 'WI'),
('70002', 'Shawnee', 'KS'),
('70116', 'Easton', 'MD'),
('75062', 'New York', 'NY'),
('7660', 'New Orleans', 'LA'),
('77301', 'Conroe', 'TX'),
('78045', 'Columbus', 'OH'),
('78204', 'Las Cruces', 'NM'),
('8014', 'Brighton', 'MI'),
('85013', 'Ridgefield Park', 'NJ'),
('88011', 'Dunellen', 'NJ'),
('8812', 'Bridgeport', 'NJ'),
('8846', 'Anchorage', 'AK'),
('90034', 'Plymouth', 'MN'),
('93012', 'Metairie', 'LA'),
('95111', 'Camarillo', 'CA'),
('97754', 'San Antonio', 'TX'),
('99501', 'Abilene', 'KS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zip`
--
ALTER TABLE `zip`
  ADD PRIMARY KEY (`zipCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
