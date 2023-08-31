-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2023 at 02:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `discount_calc` (IN `product` INT(10), IN `quant` INT(10), OUT `disc` INT(10))   BEGIN
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
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department`) VALUES
(1, 'Technical'),
(2, 'Sales'),
(3, 'Operations');

-- --------------------------------------------------------

--
-- Table structure for table `leavetype`
--

CREATE TABLE `leavetype` (
  `id` int(11) NOT NULL,
  `leaveType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leavetype`
--

INSERT INTO `leavetype` (`id`, `leaveType`) VALUES
(1, 'Maternity'),
(4, 'Sickness');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `item` text NOT NULL,
  `status` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requestleave`
--

CREATE TABLE `requestleave` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `leaveType` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `starting_at` varchar(255) NOT NULL,
  `ending_at` varchar(255) NOT NULL,
  `orderdBy` varchar(255) NOT NULL,
  `approvedBy` varchar(255) NOT NULL,
  `issuedBy` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `approve` tinyint(4) NOT NULL,
  `issue` tinyint(4) NOT NULL,
  `decline` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requestleave`
--

INSERT INTO `requestleave` (`id`, `user_id`, `leaveType`, `department`, `starting_at`, `ending_at`, `orderdBy`, `approvedBy`, `issuedBy`, `reason`, `approve`, `issue`, `decline`) VALUES
(1, 49, 'Maternity', 'Sales', '2023-07-21', '2023-07-21', 'Shannon Cannon', 'George Odhiambo', 'George Odhiambo', '                3333333333333', 1, 1, 0),
(2, 49, 'Maternity', 'Sales', '2023-07-21', '2023-07-21', 'Shannon Cannon', 'George Odhiambo', 'George Odhiambo', '            jhhhhhhhhhhhh', 1, 0, 0),
(3, 49, 'Maternity', 'Sales', '2023-07-21', '2023-07-21', 'Shannon Cannon', 'George Odhiambo', 'George Odhiambo', '     lllllllllllll', 0, 1, 0),
(4, 49, 'Sickness', 'Sales', '2023-07-21', '2023-07-21', 'Shannon Cannon', 'George Odhiambo', '', ' lllllllllllll', 0, 0, 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` text NOT NULL,
  `approve` tinyint(4) NOT NULL,
  `issue` tinyint(4) NOT NULL,
  `decline` tinyint(4) NOT NULL,
  `declineReason` text NOT NULL,
  `remaining` float NOT NULL,
  `remainingAfterOrder` float NOT NULL,
  `orderdBy` varchar(255) NOT NULL,
  `approvedBy` varchar(255) NOT NULL,
  `issuedBy` varchar(255) NOT NULL,
  `finalId` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `item`, `total`, `remaining`, `issue`) VALUES
(41, 'Shirt', 50, 50, 0),
(42, 'Touser', 50, 50, 0),
(43, 'Ranks', 50, 50, 0),
(44, 'Mobile Phone', 50, 50, 0),
(45, 'Sim Card', 50, 50, 0),
(46, 'Radio', 50, 50, 0),
(47, 'T-shirt', 50, 50, 0),
(48, 'Suit', 50, 50, 0),
(49, 'Rain Coat', 50, 50, 0),
(50, 'Sweater', 50, 50, 0),
(51, 'Officer’s Shoes', 50, 50, 0),
(52, 'Cap/Beret', 50, 50, 0),
(53, 'Reflective Jacket', 50, 50, 0),
(54, 'Hand Gloves', 50, 50, 0),
(55, 'Helmet', 50, 50, 0),
(56, 'Overall', 50, 50, 0),
(57, 'Neck Scarf', 50, 50, 0),
(58, 'Lanyard', 50, 50, 0),
(59, 'Whistle', 50, 50, 0),
(60, 'Belt', 50, 50, 0),
(61, 'Boots', 50, 50, 0),
(62, 'Baton', 50, 50, 0),
(63, 'Torch', 50, 50, 0),
(64, 'Umbrella', 50, 50, 0),
(65, 'Staff ID Card', 50, 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `username` varchar(255) NOT NULL,
  `secondname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created-at` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL,
  `department` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `admin`, `username`, `secondname`, `email`, `password`, `created-at`, `image`, `department`) VALUES
(36, 2, 'George', 'Odhiambo', 'georgeodmbo007@gmail.com', '$2y$10$Oryzn2IbMV4KjfGQK7dJ7uIIPPj58YUtdnJ8TtlIV2pcCA8sBU34W', '2022-05-21 13:15:07', '1686315337_2dc6251eb795eee0c95ec1fa1b044135.jpg', 'operations'),
(41, 1, 'George', 'Mail', 'georgeodh@ueab.ac.ke', '$2y$10$74tWPawZ3NfsM.6s4CAxOuyAOBej7cs2mqiXZ4syKSJC4SWNxJ4eW', '2023-06-13 19:40:20', '', 'Technical'),
(42, 2, 'Hector', 'Stevens', 'hector@gmail.com', '$2y$10$rBtS86QrrggimyUoqYhhHe.pNRZZxBfPucclj2DVQfccS.NZpLlSq', '2023-06-14 11:54:27', '', 'Sales'),
(48, 0, 'zeu', 'Majors', 'zeu@gmail.com', '$2y$10$IfpDMHAMqIRCnp2ByZENqejRlCD7pFNdRtXXvqRbA61dI1710bHni', '2023-06-28 13:07:29', '', 'Sales'),
(49, 0, 'Shannon', 'Cannon', 'shan@gmail.com', '$2y$10$Ia3wcFer4G687NKos3MwsO0jB0xNE/ALYgWj8C/1O/g4hN3AJmcmu', '2023-07-14 11:48:27', '', 'Sales'),
(50, 2, 'Benjamin', 'Muli', 'muli@gmail.com', '$2y$10$ZbTgMExujQYq7RjAkvcC3uPQnXLz2ek1C/IAS0QLYuff2yEiJqgIy', '2023-07-18 13:57:59', '', 'Technical');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leavetype`
--
ALTER TABLE `leavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requestleave`
--
ALTER TABLE `requestleave`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leavetype`
--
ALTER TABLE `leavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `requestleave`
--
ALTER TABLE `requestleave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `requisition`
--
ALTER TABLE `requisition`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=596;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
