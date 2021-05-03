-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2020 at 05:30 AM
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
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `fName` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lName` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zipCode` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ssn` varchar(11) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `empType` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `fName`, `lName`, `address`, `zipCode`, `ssn`, `empType`) VALUES
(1, 'James', 'Butt', '6649 N Blue Gum St', '7660', '679614601', 'Driver'),
(2, 'Josephine', 'Darakjy', '4 B Blue Ridge Blvd', '8014', '804646339', 'Driver'),
(3, 'Art', 'Venere', '8 W Cerritos Ave #54', '8812', '818355560', 'Driver'),
(4, 'Lenna', 'Paprocki', '639 Main St', '8846', '935450453', 'Driver'),
(5, 'Donette', 'Foller', '34 Center St', '10011', '633790641', 'Driver'),
(6, 'Simona', 'Morasca', '3 Mcauley Dr', '10011', '659683025', 'Driver'),
(7, 'Mitsue', 'Tollner', '7 Eads St', '10025', '944233634', 'Driver'),
(8, 'Leota', 'Dilliard', '7 W Jackson Blvd', '11953', '557316225', 'Driver'),
(9, 'Sage', 'Wieser', '5 Boston Ave #88', '12204', '970378893', 'Driver'),
(10, 'Youlanda', 'Schemmer', '2881 Lewis Rd', '19014', '165845976', 'Driver'),
(11, 'Kris', 'Marrier', '228 Runamuck Pl #2808', '19443', '649122686', 'Mechanic'),
(12, 'Minna', 'Amigon', '2371 Jerrold Ave', '21224', '681820033', 'Mechanic'),
(13, 'Abel', 'Maclead', '37275 St Rt 17m M', '21601', '549741177', 'Mechanic'),
(14, 'Kiley', 'Caldarera', '25 E 75th St #69', '37110', '516489484', 'Mechanic'),
(15, 'Graciela', 'Ruta', '98 Connecticut Ave NW', '43215', '718498531', 'Mechanic'),
(16, 'Cammy', 'Albares', '56 E Morehead St', '44023', '719715686', 'Office Worker'),
(17, 'Mattie', 'Poquette', '73 State Road 434 E', '44805', '470072481', 'Office Worker'),
(18, 'Meaghan', 'Garufi', '69734 E Carrillo St', '45011', '251088200', 'Office Worker'),
(19, 'Gladys', 'Rim', '322 New Horizon Blvd', '48116', '466540748', 'Office Worker'),
(20, 'Yuki', 'Whobrey', '1 State Route 27', '48180', '176163082', 'Office Worker');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `zipCode` (`zipCode`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`zipCode`) REFERENCES `zip` (`zipCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
