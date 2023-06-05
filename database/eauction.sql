-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2023 at 07:27 AM
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
-- Database: `eauction`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction_dtl`
--

DROP TABLE IF EXISTS `auction_dtl`;
CREATE TABLE `auction_dtl` (
  `acd_id` int(5) NOT NULL,
  `auc_id` int(5) NOT NULL DEFAULT 0,
  `bidder_id` int(5) NOT NULL DEFAULT 0,
  `bid_price` int(5) NOT NULL DEFAULT 0,
  `bid_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auction_mas`
--

DROP TABLE IF EXISTS `auction_mas`;
CREATE TABLE `auction_mas` (
  `auc_id` int(5) NOT NULL,
  `auc_dt` date DEFAULT NULL,
  `auc_tm` time DEFAULT NULL,
  `end_tm` time DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `payment_type` varchar(25) DEFAULT NULL,
  `contract_type` varchar(25) DEFAULT NULL,
  `prompt_days` varchar(25) DEFAULT NULL,
  `offer_nm` varchar(50) DEFAULT NULL,
  `offer_srl` int(5) NOT NULL DEFAULT 0,
  `lot_no` int(5) NOT NULL DEFAULT 0,
  `garden_nm` varchar(50) DEFAULT NULL,
  `grade` varchar(25) DEFAULT NULL,
  `invoice_no` varchar(12) DEFAULT NULL,
  `gp_date` date DEFAULT NULL,
  `chest` varchar(12) DEFAULT NULL,
  `pkgs` int(5) NOT NULL DEFAULT 0,
  `valu_kg` int(5) NOT NULL DEFAULT 0,
  `base_price` decimal(12,2) DEFAULT 0.00,
  `bid_price` decimal(12,2) DEFAULT 0.00,
  `bidder_id` decimal(12,2) DEFAULT 0.00,
  `auc_status` varchar(1) DEFAULT 'P'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bidder_mas`
--

DROP TABLE IF EXISTS `bidder_mas`;
CREATE TABLE `bidder_mas` (
  `bidder_id` int(5) NOT NULL,
  `name` varchar(75) DEFAULT NULL,
  `addr` text DEFAULT NULL,
  `state_code` varchar(2) DEFAULT NULL,
  `pin` varchar(6) DEFAULT NULL,
  `pan_no` varchar(10) DEFAULT NULL,
  `gst_no` varchar(15) DEFAULT NULL,
  `cont_no1` varchar(10) DEFAULT NULL,
  `cont_no2` varchar(10) DEFAULT NULL,
  `email_id` varchar(75) DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_mas`
--

DROP TABLE IF EXISTS `menu_mas`;
CREATE TABLE `menu_mas` (
  `menu_id` int(4) NOT NULL,
  `parent_id` int(4) DEFAULT NULL,
  `murl` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `srl` int(4) DEFAULT NULL,
  `mbody` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_nm` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_tag` varchar(1) DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_mas`
--

DROP TABLE IF EXISTS `offer_mas`;
CREATE TABLE `offer_mas` (
  `offer_id` int(5) NOT NULL,
  `offer_nm` varchar(50) DEFAULT NULL,
  `offer_dt` date DEFAULT NULL,
  `start_tm` time DEFAULT NULL,
  `end_tm` time DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `payment_type` varchar(25) DEFAULT NULL,
  `contract_type` varchar(25) DEFAULT NULL,
  `prompt_days` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_srl_mas`
--

DROP TABLE IF EXISTS `offer_srl_mas`;
CREATE TABLE `offer_srl_mas` (
  `offer_id` int(5) NOT NULL,
  `offer_srl` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orgn_mas`
--

DROP TABLE IF EXISTS `orgn_mas`;
CREATE TABLE `orgn_mas` (
  `orgn_id` int(5) NOT NULL,
  `orgn_code` varchar(10) DEFAULT NULL,
  `orgn_nm` varchar(50) DEFAULT NULL,
  `orgn_addr` text DEFAULT NULL,
  `orgn_cont_no` varchar(10) DEFAULT NULL,
  `email_id` varchar(100) DEFAULT NULL,
  `gst_no` varchar(15) DEFAULT NULL,
  `old_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orgn_mas`
--

INSERT INTO `orgn_mas` (`orgn_id`, `orgn_code`, `orgn_nm`, `orgn_addr`, `orgn_cont_no`, `email_id`, `gst_no`, `old_id`) VALUES
(1, 'T001', 'ANDREW YULE & COMPANY LTD', '8 DR R P SARANI KOLKATA - 700 001', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `soft_mas`
--

DROP TABLE IF EXISTS `soft_mas`;
CREATE TABLE `soft_mas` (
  `soft_id` int(5) NOT NULL,
  `soft_nm` varchar(35) NOT NULL,
  `soft_abbr` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soft_mas`
--

INSERT INTO `soft_mas` (`soft_id`, `soft_nm`, `soft_abbr`) VALUES
(1, 'EAuction', 'eAuction');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
CREATE TABLE `user_log` (
  `ulog_id` int(5) NOT NULL,
  `orgn_id` int(5) DEFAULT 1,
  `uid` int(5) DEFAULT NULL,
  `ip_addr` varchar(15) DEFAULT NULL,
  `date_fr` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`ulog_id`, `orgn_id`, `uid`, `ip_addr`, `date_fr`, `date_to`) VALUES
(1, 1, 1, '::1', '2023-06-02 21:24:31', NULL),
(2, 1, 1, '::1', '2023-06-02 21:25:54', NULL),
(3, 1, 1, '::1', '2023-06-05 10:45:20', NULL),
(4, 1, 1, '::1', '2023-06-05 10:45:40', NULL),
(5, 1, 1, '::1', '2023-06-05 10:47:08', NULL),
(6, 1, 1, '::1', '2023-06-05 10:47:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_mas`
--

DROP TABLE IF EXISTS `user_mas`;
CREATE TABLE `user_mas` (
  `uid` int(5) NOT NULL,
  `user_id` varchar(15) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `cell_no` varchar(10) DEFAULT NULL,
  `status` varchar(1) DEFAULT 'A',
  `user_type` varchar(1) DEFAULT 'B',
  `page_assign` text DEFAULT NULL,
  `token` text DEFAULT NULL,
  `otp_req` varchar(1) DEFAULT 'N',
  `otp` varchar(4) DEFAULT NULL,
  `mail_req` varchar(1) DEFAULT 'N',
  `mail_otp` varchar(4) DEFAULT NULL,
  `orgn_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_mas`
--

INSERT INTO `user_mas` (`uid`, `user_id`, `user_name`, `password`, `cell_no`, `status`, `user_type`, `page_assign`, `token`, `otp_req`, `otp`, `mail_req`, `mail_otp`, `orgn_id`) VALUES
(1, 'info', 'Developer Team', '$2y$10$MTfD2UT9yfgZFzJzslt4Z.2N.5AZyG9awOglvYM9OezHONWU/eH/q', NULL, 'A', 'B', NULL, 'f7f9e28d3350f923b83d2d33d2866b97', 'N', NULL, 'N', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_type_mas`
--

DROP TABLE IF EXISTS `user_type_mas`;
CREATE TABLE `user_type_mas` (
  `user_type_id` int(5) NOT NULL,
  `user_type` varchar(1) DEFAULT 'B',
  `user_type_desc` varchar(15) DEFAULT NULL,
  `assigned_page` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction_dtl`
--
ALTER TABLE `auction_dtl`
  ADD PRIMARY KEY (`acd_id`),
  ADD KEY `auc_id` (`auc_id`);

--
-- Indexes for table `auction_mas`
--
ALTER TABLE `auction_mas`
  ADD PRIMARY KEY (`auc_id`),
  ADD KEY `offer_id` (`offer_nm`);

--
-- Indexes for table `bidder_mas`
--
ALTER TABLE `bidder_mas`
  ADD PRIMARY KEY (`bidder_id`);

--
-- Indexes for table `menu_mas`
--
ALTER TABLE `menu_mas`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `offer_mas`
--
ALTER TABLE `offer_mas`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `offer_srl_mas`
--
ALTER TABLE `offer_srl_mas`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `orgn_mas`
--
ALTER TABLE `orgn_mas`
  ADD PRIMARY KEY (`orgn_id`);

--
-- Indexes for table `soft_mas`
--
ALTER TABLE `soft_mas`
  ADD PRIMARY KEY (`soft_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`ulog_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `date_fr` (`date_fr`);

--
-- Indexes for table `user_mas`
--
ALTER TABLE `user_mas`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `orgn_id` (`orgn_id`);

--
-- Indexes for table `user_type_mas`
--
ALTER TABLE `user_type_mas`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auction_dtl`
--
ALTER TABLE `auction_dtl`
  MODIFY `acd_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auction_mas`
--
ALTER TABLE `auction_mas`
  MODIFY `auc_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bidder_mas`
--
ALTER TABLE `bidder_mas`
  MODIFY `bidder_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_mas`
--
ALTER TABLE `menu_mas`
  MODIFY `menu_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_mas`
--
ALTER TABLE `offer_mas`
  MODIFY `offer_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_srl_mas`
--
ALTER TABLE `offer_srl_mas`
  MODIFY `offer_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orgn_mas`
--
ALTER TABLE `orgn_mas`
  MODIFY `orgn_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `soft_mas`
--
ALTER TABLE `soft_mas`
  MODIFY `soft_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `ulog_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_mas`
--
ALTER TABLE `user_mas`
  MODIFY `uid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_type_mas`
--
ALTER TABLE `user_type_mas`
  MODIFY `user_type_id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
