-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2024 at 08:52 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eauction`
--

-- --------------------------------------------------------

--
-- Table structure for table `auc_bid_dtl`
--

DROP TABLE IF EXISTS `auc_bid_dtl`;
CREATE TABLE `auc_bid_dtl` (
  `abd_id` int(5) NOT NULL,
  `auc_id` int(5) NOT NULL DEFAULT 0,
  `acd_id` int(5) NOT NULL DEFAULT 0,
  `bidder_id` int(5) NOT NULL DEFAULT 0,
  `bid_price` int(5) NOT NULL DEFAULT 0,
  `bid_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auc_bid_dtl`
--

INSERT INTO `auc_bid_dtl` (`abd_id`, `auc_id`, `acd_id`, `bidder_id`, `bid_price`, `bid_time`) VALUES
(1, 5, 2, 0, 312, '2024-02-02 11:19:29'),
(2, 5, 1, 0, 350, '2024-02-02 11:20:43'),
(3, 5, 3, 3, 350, '2024-02-02 11:29:10'),
(7, 5, 2, 0, 315, '2024-02-02 12:59:13'),
(8, 5, 30, 0, 360, '2024-02-02 12:59:24'),
(9, 5, 30, 0, 370, '2024-02-02 12:59:33'),
(11, 5, 11, 0, 375, '2024-02-02 14:15:44'),
(12, 5, 8, 0, 351, '2024-02-02 14:32:50'),
(13, 5, 7, 0, 345, '2024-02-02 14:33:16');

-- --------------------------------------------------------

--
-- Table structure for table `final_auction_dtl`
--

DROP TABLE IF EXISTS `final_auction_dtl`;
CREATE TABLE `final_auction_dtl` (
  `fad_id` int(5) NOT NULL,
  `auc_id` int(5) NOT NULL DEFAULT 0,
  `auc_start_time` datetime DEFAULT NULL,
  `auc_end_time` datetime DEFAULT NULL,
  `knockdown_start` datetime DEFAULT NULL,
  `knockdown_end` datetime DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `payment_type` varchar(25) DEFAULT NULL,
  `contract_type` varchar(25) DEFAULT NULL,
  `offer_srl` varchar(30) DEFAULT NULL,
  `offer_srl_id` int(11) NOT NULL DEFAULT 0,
  `acd_id` int(11) NOT NULL DEFAULT 0,
  `jap_id` int(11) DEFAULT 0,
  `lot_no` int(11) DEFAULT NULL,
  `garden_nm` varchar(50) DEFAULT NULL,
  `grade` varchar(25) DEFAULT NULL,
  `invoice_no` varchar(12) DEFAULT NULL,
  `gp_date` date DEFAULT NULL,
  `chest` varchar(12) DEFAULT NULL,
  `net` decimal(2,0) NOT NULL DEFAULT 0,
  `pkgs` int(5) NOT NULL DEFAULT 0,
  `valu_kg` int(5) NOT NULL DEFAULT 0,
  `base_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `msp` decimal(10,2) NOT NULL DEFAULT 0.00,
  `bid_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `bidder_id` int(5) DEFAULT NULL,
  `auc_status` varchar(1) NOT NULL DEFAULT 'P'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `final_auction_dtl`
--

INSERT INTO `final_auction_dtl` (`fad_id`, `auc_id`, `auc_start_time`, `auc_end_time`, `knockdown_start`, `knockdown_end`, `location`, `payment_type`, `contract_type`, `offer_srl`, `offer_srl_id`, `acd_id`, `jap_id`, `lot_no`, `garden_nm`, `grade`, `invoice_no`, `gp_date`, `chest`, `net`, `pkgs`, `valu_kg`, `base_price`, `msp`, `bid_price`, `bidder_id`, `auc_status`) VALUES
(2, 5, '2024-02-01 11:00:00', '2024-02-02 11:30:12', '2024-02-01 11:30:18', '2024-02-05 11:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'DARJEELING/2024/0006', 1, 3, NULL, 1, 'AMGOORIE', 'BOP', 'C158', '2023-05-06', '6366-6395', 25, 30, 350, 340.00, 0.00, 350.00, 3, 'P'),
(3, 5, '2024-02-01 11:00:00', '2024-02-02 11:30:12', '2024-02-01 11:30:18', '2024-02-05 11:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'DARJEELING/2024/0006', 1, 3, NULL, 1, 'AMGOORIE', 'BOP', 'C158', '2023-05-06', '6366-6395', 25, 30, 350, 340.00, 0.00, 350.00, 3, 'P'),
(4, 5, '2024-02-01 11:00:00', '2024-02-02 11:30:12', '2024-02-01 11:30:18', '2024-02-05 11:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'DARJEELING/2024/0006', 1, 4, NULL, 2, 'AMGOORIE', 'BOP', 'C128', '2023-04-24', '4926-4955', 25, 30, 350, 311.00, 0.00, 341.00, 3, 'P'),
(5, 5, '2024-02-01 11:00:00', '2024-02-02 11:30:12', '2024-02-01 11:30:18', '2024-02-05 11:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'DARJEELING/2024/0006', 1, 4, NULL, 2, 'AMGOORIE', 'BOP', 'C128', '2023-04-24', '4926-4955', 25, 30, 350, 311.00, 0.00, 341.00, 3, 'P'),
(6, 5, '2024-02-01 11:00:00', '2024-02-02 11:30:12', '2024-02-01 11:30:18', '2024-02-05 11:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'DARJEELING/2024/0006', 1, 4, NULL, 2, 'AMGOORIE', 'BOP', 'C128', '2023-04-24', '4926-4955', 25, 30, 350, 311.00, 0.00, 0.00, 0, 'P'),
(7, 5, '2024-02-01 11:00:00', '2024-02-02 11:30:12', '2024-02-01 11:30:18', '2024-02-05 11:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'DARJEELING/2024/0006', 1, 5, NULL, 1, 'AMGOORIE', 'BOP', 'C158', '2023-05-06', '6366-6395', 25, 30, 350, 340.00, 0.00, 0.00, 0, 'P'),
(8, 5, '2024-02-01 11:00:00', '2024-02-02 11:30:12', '2024-02-01 11:30:18', '2024-02-05 11:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'DARJEELING/2024/0006', 1, 6, NULL, 2, 'AMGOORIE', 'BOP', 'C128', '2023-04-24', '4926-4955', 25, 30, 350, 311.00, 0.00, 0.00, 0, 'P');

-- --------------------------------------------------------

--
-- Table structure for table `fin_auc_bid_dtl`
--

DROP TABLE IF EXISTS `fin_auc_bid_dtl`;
CREATE TABLE `fin_auc_bid_dtl` (
  `fabd_id` int(5) NOT NULL,
  `abd_id` int(5) NOT NULL DEFAULT 0,
  `auc_id` int(5) NOT NULL DEFAULT 0,
  `acd_id` int(5) NOT NULL DEFAULT 0,
  `bidder_id` int(5) NOT NULL DEFAULT 0,
  `bid_price` int(5) NOT NULL DEFAULT 0,
  `bid_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fin_auc_bid_dtl`
--

INSERT INTO `fin_auc_bid_dtl` (`fabd_id`, `abd_id`, `auc_id`, `acd_id`, `bidder_id`, `bid_price`, `bid_time`) VALUES
(1, 4, 5, 4, 3, 341, '2024-02-02 11:29:25'),
(2, 10, 5, 4, 0, 370, '2024-02-02 13:20:25'),
(4, 4, 5, 4, 3, 341, '2024-02-02 11:29:25'),
(5, 10, 5, 4, 0, 370, '2024-02-02 13:20:25'),
(7, 5, 5, 5, 3, 341, '2024-02-02 11:29:35'),
(8, 6, 5, 6, 3, 314, '2024-02-02 11:29:44'),
(9, 14, 5, 6, 0, 356, '2024-02-02 14:34:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auc_bid_dtl`
--
ALTER TABLE `auc_bid_dtl`
  ADD PRIMARY KEY (`abd_id`),
  ADD KEY `auc_id` (`auc_id`),
  ADD KEY `acd_id` (`acd_id`),
  ADD KEY `bidder_id` (`bidder_id`);

--
-- Indexes for table `final_auction_dtl`
--
ALTER TABLE `final_auction_dtl`
  ADD PRIMARY KEY (`fad_id`),
  ADD KEY `auc_id` (`auc_id`),
  ADD KEY `acd_id` (`acd_id`),
  ADD KEY `bidder_id` (`bidder_id`);

--
-- Indexes for table `fin_auc_bid_dtl`
--
ALTER TABLE `fin_auc_bid_dtl`
  ADD PRIMARY KEY (`fabd_id`),
  ADD KEY `abd_id` (`abd_id`),
  ADD KEY `auc_id` (`auc_id`),
  ADD KEY `acd_id` (`acd_id`),
  ADD KEY `bidder_id` (`bidder_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auc_bid_dtl`
--
ALTER TABLE `auc_bid_dtl`
  MODIFY `abd_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `final_auction_dtl`
--
ALTER TABLE `final_auction_dtl`
  MODIFY `fad_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fin_auc_bid_dtl`
--
ALTER TABLE `fin_auc_bid_dtl`
  MODIFY `fabd_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
