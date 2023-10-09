-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 19, 2022 at 05:20 AM
-- Server version: 10.2.41-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `feeder_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_gis`
--

CREATE TABLE `login_gis` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `user_password` varchar(30) NOT NULL,
  `display_name` varchar(300) DEFAULT NULL,
  `user_type` int(1) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `display_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_gis`
--

INSERT INTO `login_gis` (`id`, `user_id`, `user_password`, `display_name`, `user_type`, `status`, `display_order`) VALUES
(1, 'admin', 'mnbvlkjh@123', 'MINISTRY', 0, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_gis`
--
ALTER TABLE `login_gis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_gis`
--
ALTER TABLE `login_gis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
