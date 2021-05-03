-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 18, 2020 at 05:10 AM
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
-- Database: `college`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classID` int(6) UNSIGNED NOT NULL,
  `className` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `courseID` int(6) NOT NULL,
  `instructorID` int(6) NOT NULL,
  `semester` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classID`, `className`, `courseID`, `instructorID`, `semester`) VALUES
(1, 'Intro to Java', 2, 3, 'Fall'),
(2, 'Organizational Management', 3, 2, 'Summer'),
(3, 'Human Biology', 1, 1, 'Summer'),
(4, 'Human Biology', 1, 5, 'Spring'),
(5, 'Organizational Management', 3, 4, 'Fall'),
(6, 'Intro to Java', 2, 3, 'Spring');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseID` int(6) UNSIGNED NOT NULL,
  `crsName` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `crsDescription` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `degreeID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `crsName`, `crsDescription`, `degreeID`) VALUES
(1, 'Human Biology', 'A course about the human body', 3),
(2, 'Intro to Java', 'An introduction to the Java programming language', 2),
(3, 'Organizational Management', 'An elective course about Business Administration', 1),
(4, 'Server Side Developement', 'A really cool class!', 2);

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE `degree` (
  `degreeID` int(6) UNSIGNED NOT NULL,
  `degreeName` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `degreeDescription` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`degreeID`, `degreeName`, `degreeDescription`) VALUES
(1, 'Human Resources', 'The study of human resources'),
(2, 'Computer Science', 'The study of computers'),
(3, 'Biology', 'The study of biology');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `instructorID` int(6) UNSIGNED NOT NULL,
  `fName` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `lName` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`instructorID`, `fName`, `lName`, `phone`) VALUES
(1, 'Jerry', 'Seinfield', '0987654321'),
(2, 'Thomas', 'Aquanis', '9987654321'),
(3, 'Joshua', 'Sells', '8987654321'),
(4, 'Brad', 'Pit', '7987654321'),
(5, 'Josh', 'Brolin', '6987654321'),
(6, 'Barry', 'Johnson', '4736876537');

-- --------------------------------------------------------

--
-- Table structure for table `stuclass`
--

CREATE TABLE `stuclass` (
  `studentID` int(6) NOT NULL,
  `classID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stuclass`
--

INSERT INTO `stuclass` (`studentID`, `classID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` int(6) UNSIGNED NOT NULL,
  `fName` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `lName` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `degreeID` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `fName`, `lName`, `phone`, `degreeID`) VALUES
(1, 'Johnny', 'Hayes', '1234567890', 2),
(2, 'Robert', 'Fowler', '2234567890', 1),
(3, 'James', 'Clark', '3234567890', 3),
(4, 'Marie-Louise', 'Ledru', '4234567890', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseID`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`degreeID`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`instructorID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `classID` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseID` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `degree`
--
ALTER TABLE `degree`
  MODIFY `degreeID` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `instructorID` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentID` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
