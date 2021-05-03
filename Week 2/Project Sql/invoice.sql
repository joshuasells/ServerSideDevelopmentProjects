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
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `inv_id` int(11) NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `officeEmp_id` int(11) DEFAULT NULL,
  `driverEmp_id` int(11) DEFAULT NULL,
  `invDate` date DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zipCode` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`inv_id`, `cust_id`, `officeEmp_id`, `driverEmp_id`, `invDate`, `address`, `zipCode`) VALUES
(1, 1, 16, 1, '2020-08-15', '6 S 33rd St', '53207'),
(2, 2, 17, 2, '2020-08-15', '6 Greenleaf Ave', '11953'),
(3, 3, 18, 3, '2020-08-15', '618 W Yakima Ave', '57105'),
(4, 4, 19, 4, '2020-08-15', '74 S Westgate St', '60632'),
(5, 5, 20, 5, '2020-08-15', '3274 State St', '66218'),
(6, 6, 16, 6, '2020-08-15', '1 Central Ave', '67410'),
(7, 7, 17, 7, '2020-08-15', '86 Nw 66th St #8673', '70002'),
(8, 8, 18, 8, '2020-08-15', '2 Cedar Ave #84', '70116'),
(9, 9, 19, 9, '2020-08-15', '90991 Thorburn Ave', '75062'),
(10, 10, 20, 10, '2020-08-15', '386 9th Ave N', '77301');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `officeEmp_id` (`officeEmp_id`),
  ADD KEY `driverEmp_id` (`driverEmp_id`),
  ADD KEY `zipCode` (`zipCode`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`officeEmp_id`) REFERENCES `officeworker` (`emp_id`),
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`driverEmp_id`) REFERENCES `driver` (`emp_id`),
  ADD CONSTRAINT `invoice_ibfk_4` FOREIGN KEY (`zipCode`) REFERENCES `zip` (`zipCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
