-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2021 at 01:31 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `connectus2`
--

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `Id` int(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `DOB` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`Id`, `Username`, `Email`, `DOB`, `Password`, `Token`, `Status`, `Picture`) VALUES
(1, 'abhi_1', 'pabkajmaru78987@gmail.com', '2003-09-15', '$2y$10$LWJQTYItkFNGfsXv8qjI9eTa.xPTJTpU3TlZSce232.WvY5.FDLG6', '8bb9c61d0bf8762411a60e34fdf883', 'active', 'dist/img/avatars/user1.png'),
(25, 'abhi_maru1111', 'hibetif449@onmail3.com', '2003-09-15', '$2y$10$d70FyPH1E1mGM6TdNbj.oe/mJctunX75A2mbX5dMvE5bqjJR5WHYW', 'f3d37f047524c8a36b73b0ee07d4a7', 'active', 'dist/img/avatars/user1.png'),
(30, 'Aum_radia1111', 'mofoni2014@rmomail.com', '2003-04-05', '$2y$10$WcJJlvmPLi7CmPnsbPgMAe2RITGKQnhyZh24Mem6DynAg5zPFXume', '7b320ed7bf19cbcdd705d302e8e53a', 'active', 'dist/img/avatars/user1.png'),
(33, 'rudradeep', 'wahexa1517@qatw.net', '2002-10-18', '$2y$10$yK6ytRwh8S2wb.q6wyJhreOlxfoyxISIqzxqXePTM6lg2RpUAcynW', '6e69674e7c2342a2ae307c1ceefe65', 'active', 'dist/img/avatars/user1.png'),
(35, 'New_user1', 'papeten784@deselling.com', '2000-11-11', '$2y$10$KqvkYozJWb7kDNrNVwKLUOF13mKusieOfXZfccdiF4ZDXUVhyw7N6', '7da489d5e688f351948a1c01aeb052', 'active', 'dist/img/avatars/user1.png'),
(41, 'abhishek', 'pixoxat419@94jo.com', '2003-09-15', '$2y$10$fUG6BXLABuHV/Dzj96OLue6HQTMoDpeXRnPHB7HRHdpAPxUp8VRVK', 'c964718b16cf78f65a40aeafef8c91', 'active', 'dist/img/avatars/user2.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
