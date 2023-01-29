-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2023 at 06:32 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resortdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  `quantity` int(15) NOT NULL,
  `fee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(15) NOT NULL,
  `item_desc` varchar(255) NOT NULL,
  `quantity` int(15) NOT NULL,
  `price` float NOT NULL,
  `is_available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_desc`, `quantity`, `price`, `is_available`) VALUES
(1, 'Pillow', 3, 300, 1),
(2, 'Table', 2, 1000, 1),
(5, ' Red Horse', 8, 70, 1),
(6, 'San Mig', 3, 63, 1),
(10, ' dc', 2, 1000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `package_id` bigint(15) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `package_name`, `price`, `status`, `description`, `image`) VALUES
(27, 'PACKAGE RR (Fan Kubo)', 1800, 1, ' (Good for 6 pax)\n\n💧1 Kubo\n💧1 table\n💧3 foam\n💧2 fan\n💧Extra socket for charging\n💧Entrance fee\n💧Use of common bathroom &amp;amp; shower rooms\n💧Use of griller\n', '27'),
(31, 'PACKAGE RR (Fan Kubo)', 2500, 1, 'sdsdsadsaa', '31'),
(41, 'test package', 4500, 1, 'test desc', 'placeholder');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(15) NOT NULL,
  `package_id` int(15) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `price` float NOT NULL,
  `isPaid` tinyint(1) NOT NULL DEFAULT 0,
  `price_paid` float DEFAULT 0,
  `receipt` varchar(999) DEFAULT NULL,
  `id_file` varchar(999) DEFAULT NULL,
  `downpayment` float DEFAULT 0,
  `guest_name` varchar(255) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `emp_no` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(15) NOT NULL,
  `user_id` int(15) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_type`, `is_active`, `fname`, `mname`, `lname`, `suffix`, `email`, `password`) VALUES
(2, 2022100011, 'admin', 1, 'Robert Jeson', 'F. ', 'Jimenez', '', 'robertjesonjimenez@gmail.com', 'boki22'),
(4, 2022110004, 'staff', 1, 'Gio', 'M', 'Farin', '', 'gioorlando@gmail.com', 'qwerty'),
(5, 2022110005, 'staff', 1, 'Ronan Kian', 'C.', 'Abundo', '', 'abundoronankian@gmail.com', '123'),
(6, 2023010006, 'staff', 1, 'Gio', '', 'Test', '', 'sdasda@gmail.com', 'wqeq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `package_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
