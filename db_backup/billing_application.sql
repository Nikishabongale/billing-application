-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2021 at 12:48 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billing_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(250) NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `phone_number`, `email_id`, `address`) VALUES
(3, 'Sushmita', '8746078360', 'namrutavshastri@gmail.com', 'KUDBAIL\r\nHaldipur'),
(4, 'Namruta', '8746078360', 'namrutavshastri@gmail.com', 'KUDBAIL\r\nHaldipur');

-- --------------------------------------------------------

--
-- Table structure for table `estimation`
--

CREATE TABLE `estimation` (
  `estimation_id` int(250) NOT NULL,
  `stock_id` int(250) NOT NULL,
  `customer_id` int(250) NOT NULL,
  `quantity` int(250) NOT NULL,
  `date` date NOT NULL,
  `amount` float NOT NULL,
  `discount` varchar(250) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `tax` varchar(250) NOT NULL,
  `total_no_tax_disc` float NOT NULL,
  `descpn` text NOT NULL,
  `price_per_unit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `item_name` varchar(250) NOT NULL,
  `quantity` int(20) NOT NULL,
  `purchase_id` int(250) NOT NULL,
  `gross_weight` float NOT NULL,
  `net_weight` float NOT NULL,
  `descrptn` text NOT NULL,
  `date` date NOT NULL,
  `vendor_id` int(250) DEFAULT NULL,
  `price_unit` float NOT NULL,
  `history` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`item_name`, `quantity`, `purchase_id`, `gross_weight`, `net_weight`, `descrptn`, `date`, `vendor_id`, `price_unit`, `history`) VALUES
('ring', 15, 46, 100, 150, '', '2021-12-30', 10, 100, 'Purchased 10 items on 2021-12-29 12:37:38\nUpdated quantity as 15 items on 2021-12-29 12:47:40'),
('bangles', 5, 47, 0, 0, '', '2021-12-29', 10, 150, 'Purchased 5 items on 2021-12-29 18:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `return_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `return_quantity` int(11) NOT NULL,
  `return_amount` float NOT NULL,
  `sales_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `descpn` text NOT NULL,
  `return_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`return_id`, `customer_id`, `return_quantity`, `return_amount`, `sales_id`, `purchase_id`, `descpn`, `return_date`) VALUES
(10, 4, 1, 1000, 26, 47, '', '2021-12-29'),
(11, 3, 1, 1500, 27, 46, 'Customer liked the product yesterday,\r\nreturning because her husband doesn\'t like it.\r\nHa ha', '2021-12-30'),
(12, 4, 1, 1500, 25, 46, 'test for longgggggg line description insertion, test test test test test test, haven\'t changed the line yet', '2021-12-30'),
(13, 4, 1, 50000, 25, 46, '\'she said I don\'t want to go there\'', '2021-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(250) NOT NULL,
  `stock_id` int(250) NOT NULL,
  `customer_id` int(250) NOT NULL,
  `quantity` int(250) NOT NULL,
  `date` date NOT NULL,
  `amount` float NOT NULL,
  `balance_due` float NOT NULL,
  `discount` varchar(250) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `tax` varchar(250) NOT NULL,
  `total_no_tax_disc` float NOT NULL,
  `descpn` text NOT NULL,
  `price_per_unit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `stock_id`, `customer_id`, `quantity`, `date`, `amount`, `balance_due`, `discount`, `purchase_id`, `tax`, `total_no_tax_disc`, `descpn`, `price_per_unit`) VALUES
(25, 18, 4, 5, '2021-12-29', 500, 0, '0 rs', 46, '0 rs', 500, '', 100),
(26, 19, 4, 2, '2021-12-29', 300, 100, '0 rs', 47, '0 rs', 300, '', 150),
(27, 18, 3, 1, '2021-12-29', 100, 0, '0 rs', 46, '0 rs', 100, '', 100),
(28, 19, 4, 1, '2021-12-30', 150, 0, '10 rs', 47, '10 rs', 150, 'it\'s  chilly today.. want some sweater?', 150),
(29, 18, 4, 2, '2021-12-30', 240, 40, '10 rs', 46, '10 rs', 240, 'test, adding to sale', 120);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(250) NOT NULL,
  `purchase_id` int(250) NOT NULL,
  `quantity` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `purchase_id`, `quantity`) VALUES
(18, 46, 8),
(19, 47, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `password`) VALUES
(1, 'admin', '$2y$10$dfa1L.mKMc2RwKzegEfwd.6ORCjmPRD8mjx2oFlNI9fPrLnFD8/ke');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendor_id` int(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendor_id`, `name`, `phone_number`, `email_id`, `address`) VALUES
(8, 'test', '34234', 'test@test.com', ''),
(10, 'yash', '8746078360', 'namrutavshastri@gmail.com', 'KUDBAIL\r\nHaldipur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_name` (`customer_name`);

--
-- Indexes for table `estimation`
--
ALTER TABLE `estimation`
  ADD PRIMARY KEY (`estimation_id`),
  ADD KEY `fk_stock_id` (`stock_id`),
  ADD KEY `fk_customer_id` (`customer_id`),
  ADD KEY `fk_purchase_id` (`purchase_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`),
  ADD UNIQUE KEY `item_name` (`item_name`),
  ADD KEY `FK_purchase` (`vendor_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`return_id`),
  ADD KEY `fk_customer_id` (`customer_id`),
  ADD KEY `returns_ibfk_3` (`purchase_id`),
  ADD KEY `returns_ibfk_2` (`sales_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `Fk_item_id` (`stock_id`),
  ADD KEY `Fk_sales` (`customer_id`),
  ADD KEY `sales_ibfk_1` (`purchase_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `fk_pid` (`purchase_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendor_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `estimation`
--
ALTER TABLE `estimation`
  MODIFY `estimation_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendor_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `FK_purchase` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `returns_ibfk_3` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `Fk_item_id` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`stock_id`),
  ADD CONSTRAINT `Fk_sales` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`) ON DELETE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_pid` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
