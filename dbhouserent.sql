-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2026 at 02:46 PM
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
-- Database: `dbhouserent`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookmark`
--

CREATE TABLE `tbl_bookmark` (
  `id` int(11) NOT NULL,
  `registry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_bookmark`
--

INSERT INTO `tbl_bookmark` (`id`, `registry_id`, `user_id`) VALUES
(44, 3, 21),
(48, 2, 21);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_centralinfo`
--

CREATE TABLE `tbl_centralinfo` (
  `id` int(11) NOT NULL,
  `lotnumber` int(11) NOT NULL,
  `blocknumber` int(11) NOT NULL,
  `house_status` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_centralinfo`
--

INSERT INTO `tbl_centralinfo` (`id`, `lotnumber`, `blocknumber`, `house_status`, `user_id`) VALUES
(1, 99999, 45, 'For Sale', 21),
(2, 9, 56, 'For Rent', 21),
(3, 5, 22, 'For Sale', 21),
(4, 4, 12, 'For Rent', 21),
(7, 99, 12, 'For Rent', 21),
(8, 90, 18, 'For Sale', 21);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ownerinfo`
--

CREATE TABLE `tbl_ownerinfo` (
  `id` int(11) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_uid` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_ownerinfo`
--

INSERT INTO `tbl_ownerinfo` (`id`, `lname`, `fname`, `age`, `gender`, `email`, `password_hash`, `user_uid`, `picture`) VALUES
(1, 'carl justin belarmino', 'carl justin', 21, 'Male', 'justinbelarmino3@gmail.com', '$2y$10$aa.YhCZnRMyPeND.Lg50TOdBxzVbmz2ZPUT5eaXFxP5YUbzrhmXpK', '', NULL),
(4, 'carl justin belarmino', 'carl justin', 21, 'Male', 'carlbelarmino6@gmail.com', '$2y$10$XcKiw/3r8C10eI6jMLlMveroV55go1/EjXNDxbah4j4xk..TBzfBC', '', NULL),
(6, 'carl justin belarmino', 'carl justin', 21, 'Male', 'justin3belarmino3@gmail.com', '$2y$10$zEbQot93j4NORp3/GAjqWuqTM0dDzcVZMlVLCBXwhiQTZIXWD768m', '', NULL),
(7, 'carl justin belarmino', 'carl justin', 21, 'Male', 'justin27belarmino3@gmail.com', '$2y$10$1uGvZ7dZ.WN1NwEbx2wKMOfMc.etRWeyivOiIv3lYnQjmay.3grYC', '', NULL),
(8, 'carl justin belarmino', 'carl justin', 21, 'Male', 'justin2704belarmino3@gmail.com', '$2y$10$Qz.LZza6sUy4DMBlKnRJLeaj42jYPVQlreBvuTfNdYZkN7fJCBI/W', '', NULL),
(9, 'carl justin belarmino', 'carl justin', 21, 'Male', 'carlbelarmino16@gmail.com', '$2y$10$8MqzVU3ngDd8rq8/dC7euuvXP89hG1cMIFyNppbjHriy6USfPzrG.', '', NULL),
(10, 'carl justin belarmino', 'carl justin', 21, 'Male', 'carlbelarmino69@gmail.com', '$2y$10$9LsAaAOlo52ycN/Buh8PWeYsEy6V9DzJ96IFhEpTtRV5nR44hJI3W', '', NULL),
(11, 'carl justin belarmino', 'carl justin', 15, 'Male', 'carlbelarmino169@gmail.com', '$2y$10$kJtfsgyH0nvikJdghgvG3O7.7vfFK0WdGxKY2i/M8H1M4Ma81m7hi', '', NULL),
(12, 'carl justin belarmino', 'carl justin', 10, '', 'carlbelarmino26@gmail.com', '$2y$10$f6g2hv6fgpOoLiFcCtzuCuGi4WXwrE7EqKVXx/tgPN79nmT0gTp8e', '', NULL),
(13, 'carl justin belarmino', 'carl justin', 10, 'Male', 'carlbelarmino126@gmail.com', '$2y$10$reVNjKRG6uUKpSKNJ8/HUOuXKflbekk0wWBuucnIGYTxEAn1DI/ou', '', NULL),
(15, 'carl justin belarmino', 'carl justin', 21, 'Male', 'justinbelarmino13@gmail.com', '$2y$10$.7VlM9mBM5Ll8qhvZjxyvedD0n00fgpwIucU3RILhkNRoTBa257nC', '', NULL),
(16, 'carl justin belarmino', 'carl justin', 21, 'Male', 'justinbelarmino53@gmail.com', '$2y$10$4dSQ/mR240yaZSO1NlyJUO70uiLeHEE8113h9MadZIdjZTGDFRAwa', '', NULL),
(18, 'carl justin belarmino', 'carl justin', 21, 'Male', 'justinbelarmino23@gmail.com', '$2y$10$lfLA4jTFtvDOYt1TNXJxVe65EjfT3Q06FY4glaMm5J7990uZBkEim', '', NULL),
(20, 'carl justin belarmino', 'CJ', 22, 'Male', 'justinbelarmino36@gmail.com', '$2y$10$T2GibkdD9JVUPkt.DUF/zOyfMDrwkZj2WVWTn/iHfXFaN9PnErii.', '', NULL),
(21, 'carl justin belarmino', 'carl justin', 21, 'Male', 'justinbelarmino366@gmail.com', '$2y$10$qC.M7n23/wgGMLigwkQVmupfxsBC9zMoImQuKQat5iwlcVl5AuYLS', '409aa18c-e648-4e9c-9160-a06492f79605', NULL),
(22, 'Rojo', 'Chester', 19, 'Male', 'chester@gmail.com', '$2y$10$XC8MD/xpnUlJijjeAr93TOQuqVprhm8YMTiSFzjNVKG316pFnqqSS', 'b2e5b239-b74d-4f19-8928-51fe67525683', NULL),
(23, 'admin', 'admin', 32, 'Male', 'admin@gmail.com', '$2y$10$16mIyVWcUX8gkibI8TNCpOpyyuZZ.yWnh0nFHh.jiy10EJjbL/R7q', '5f905ff7-ca07-46e4-994c-9fc8ee527c2f', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rent_info`
--

CREATE TABLE `tbl_rent_info` (
  `id` int(11) NOT NULL,
  `registry_id` int(11) NOT NULL,
  `rentprice` decimal(10,2) NOT NULL,
  `downpayment` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_rent_info`
--

INSERT INTO `tbl_rent_info` (`id`, `registry_id`, `rentprice`, `downpayment`) VALUES
(1, 2, 5000.00, 2000.00),
(2, 4, 5000.00, 2500.00),
(3, 7, 5000.00, 2500.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saleinfo`
--

CREATE TABLE `tbl_saleinfo` (
  `id` int(11) NOT NULL,
  `registry_id` int(11) NOT NULL,
  `houseprice` decimal(30,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_saleinfo`
--

INSERT INTO `tbl_saleinfo` (`id`, `registry_id`, `houseprice`) VALUES
(1, 1, 50000.00),
(2, 3, 30000000.00),
(3, 8, 12000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usertoken`
--

CREATE TABLE `tbl_usertoken` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_hash` varchar(255) NOT NULL,
  `expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_usertoken`
--

INSERT INTO `tbl_usertoken` (`id`, `user_id`, `token_hash`, `expiry`) VALUES
(3, 22, '$2y$10$8m.tPz8GPIGsy.owyfOlAO0yGYTo7Zq54NRSiLex6K3dixHWLcp26', '2026-07-16 04:49:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registry_id` (`registry_id`);

--
-- Indexes for table `tbl_centralinfo`
--
ALTER TABLE `tbl_centralinfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_property` (`blocknumber`,`lotnumber`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_ownerinfo`
--
ALTER TABLE `tbl_ownerinfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_rent_info`
--
ALTER TABLE `tbl_rent_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registry_id` (`registry_id`);

--
-- Indexes for table `tbl_saleinfo`
--
ALTER TABLE `tbl_saleinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registry_id` (`registry_id`);

--
-- Indexes for table `tbl_usertoken`
--
ALTER TABLE `tbl_usertoken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_centralinfo`
--
ALTER TABLE `tbl_centralinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_ownerinfo`
--
ALTER TABLE `tbl_ownerinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_rent_info`
--
ALTER TABLE `tbl_rent_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_saleinfo`
--
ALTER TABLE `tbl_saleinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_usertoken`
--
ALTER TABLE `tbl_usertoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  ADD CONSTRAINT `tbl_bookmark_ibfk_1` FOREIGN KEY (`registry_id`) REFERENCES `tbl_centralinfo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_centralinfo`
--
ALTER TABLE `tbl_centralinfo`
  ADD CONSTRAINT `tbl_centralinfo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_ownerinfo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_rent_info`
--
ALTER TABLE `tbl_rent_info`
  ADD CONSTRAINT `tbl_rent_info_ibfk_1` FOREIGN KEY (`registry_id`) REFERENCES `tbl_centralinfo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_saleinfo`
--
ALTER TABLE `tbl_saleinfo`
  ADD CONSTRAINT `tbl_saleinfo_ibfk_1` FOREIGN KEY (`registry_id`) REFERENCES `tbl_centralinfo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_usertoken`
--
ALTER TABLE `tbl_usertoken`
  ADD CONSTRAINT `tbl_usertoken_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_ownerinfo` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
