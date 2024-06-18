-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2024 at 04:39 AM
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
-- Database: `listrik`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `level`) VALUES
(1, 'a', 'a', 'admin'),
(2, 'b', 'b', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `meter`
--

CREATE TABLE `meter` (
  `ID` int(11) NOT NULL,
  `ID_Listrik` varchar(20) NOT NULL,
  `Voltage` varchar(20) NOT NULL,
  `Current` varchar(20) NOT NULL,
  `Power` varchar(20) NOT NULL,
  `Energy` varchar(20) NOT NULL,
  `Frequency` varchar(20) NOT NULL,
  `PF` varchar(20) NOT NULL,
  `Date` varchar(20) NOT NULL,
  `Timestamp` varchar(20) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meter`
--

INSERT INTO `meter` (`ID`, `ID_Listrik`, `Voltage`, `Current`, `Power`, `Energy`, `Frequency`, `PF`, `Date`, `Timestamp`) VALUES
(1, 'PLN_001', '222', '20', '4440', '1234', '50', '1', '2024-05-18', '2024-05-18');

-- --------------------------------------------------------

--
-- Table structure for table `statusrelay`
--

CREATE TABLE `statusrelay` (
  `id` int(11) NOT NULL,
  `ID_Listrik` varchar(20) NOT NULL,
  `Stat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statusrelay`
--

INSERT INTO `statusrelay` (`id`, `ID_Listrik`, `Stat`) VALUES
(1, 'PLN_001', '1'),
(2, 'PLN_001', '0'),
(3, 'PLN_001', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meter`
--
ALTER TABLE `meter`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `statusrelay`
--
ALTER TABLE `statusrelay`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meter`
--
ALTER TABLE `meter`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `statusrelay`
--
ALTER TABLE `statusrelay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
