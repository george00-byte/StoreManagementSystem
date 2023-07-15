-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2023 at 08:46 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `discount_calc` (IN `product` INT(10), IN `quant` INT(10), OUT `disc` INT(10))  BEGIN
declare price int; 
declare disc int; 
declare total int;
select USP into price from price_list where ProductID = product;
set total=quant*price; 
if (total >= 20000 and total < 40000) THEN
   set disc=total*0.025;
elseif (total >= 40000 and total < 60000) THEN
   set disc=total*0.05;
elseif (total >= 60000 and total < 100000) THEN
   set disc=total*0.075;
elseif (total >= 100000) THEN
   set disc=total*0.1;
end if;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `requisition`
--

CREATE TABLE `requisition` (
  `id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item` text NOT NULL,
  `quantity` int(255) NOT NULL,
  `department` text NOT NULL,
  `created-at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` text NOT NULL,
  `approve` tinyint(4) NOT NULL,
  `issue` tinyint(4) NOT NULL,
  `decline` tinyint(4) NOT NULL,
  `declineReason` text NOT NULL,
  `remaining` float NOT NULL,
  `remainingAfterOrder` float NOT NULL,
  `orderdBy` text NOT NULL,
  `approvedBy` text NOT NULL,
  `issuedBy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requisition`
--

INSERT INTO `requisition` (`id`, `user_id`, `item_id`, `item`, `quantity`, `department`, `created-at`, `reason`, `approve`, `issue`, `decline`, `declineReason`, `remaining`, `remainingAfterOrder`, `orderdBy`, `approvedBy`, `issuedBy`) VALUES
(427, 41, 35, 'CPU', 12, 'Tech', '2023-06-22 05:53:46', ' edQq', 1, 1, 0, '', 0, 3, 'George', 'George', 'George'),
(428, 41, 35, 'CPU', 2, 'Tech', '2023-06-22 05:53:35', ' WDwdW', 1, 1, 0, '', 0, 1, 'George', 'George', 'George'),
(429, 41, 35, 'CPU', 15, 'Tech', '2023-06-22 05:43:52', ' RDQFQA', 1, 1, 0, '', 16, 1, 'George', 'George', 'George'),
(430, 41, 35, 'CPU', 1, 'Tech', '2023-06-22 05:59:04', '     RDQFQA', 1, 1, 0, '', 0, 0, 'George', 'George', 'George');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `item` text NOT NULL,
  `total` float NOT NULL,
  `remaining` float NOT NULL,
  `issue` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `item`, `total`, `remaining`, `issue`) VALUES
(34, 'Battery', 32, 2, 0),
(35, 'CPU', 30, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created-at` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `admin`, `username`, `email`, `password`, `created-at`, `image`) VALUES
(36, 2, 'George', 'georgeodmbo007@gmail.com', '$2y$10$Oryzn2IbMV4KjfGQK7dJ7uIIPPj58YUtdnJ8TtlIV2pcCA8sBU34W', '2022-05-21 13:15:07', '1686315337_2dc6251eb795eee0c95ec1fa1b044135.jpg'),
(40, 0, 'George', 'georgeodhiambo007@gmail.com', '$2y$10$oUT5n67Hs5l/DRtwsnOnV.4NkJm8i.4xQYe.uU3FqBpoCee2RNpVi', '2023-06-13 19:38:23', ''),
(41, 1, 'George', 'georgeodh@ueab.ac.ke', '$2y$10$74tWPawZ3NfsM.6s4CAxOuyAOBej7cs2mqiXZ4syKSJC4SWNxJ4eW', '2023-06-13 19:40:20', ''),
(42, 0, 'Hector', 'hector@gmail.com', '$2y$10$peKJCDCFUQUFlYNzXk7ZreuT96esD02oh0pO497tX0t5kb2D1uXeS', '2023-06-14 11:54:27', ''),
(43, 0, 'sheilah', 'skimeli@totalsecuritykenya.com', '$2y$10$s5TVgFNoWz/p9CboZMZYDO6BK1JnNjEkGwexayXFwLKJbPh2hi9Cq', '2023-06-14 14:11:06', ''),
(44, 0, 'Zeus', 'zeus@gmail.com', '$2y$10$NvtkTILECOSPHPVlvMDpbu27rk0SlAVAjA04wGZ8J2Lka2ZO6aPjS', '2023-06-16 10:15:50', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `requisition`
--
ALTER TABLE `requisition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`) USING BTREE;

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `requisition`
--
ALTER TABLE `requisition`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `requisition`
--
ALTER TABLE `requisition`
  ADD CONSTRAINT `requisitions_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `store` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
