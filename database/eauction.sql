-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2023 at 09:32 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

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
CREATE TABLE IF NOT EXISTS `auction_dtl` (
  `acd_id` int(5) NOT NULL AUTO_INCREMENT,
  `auc_id` int(5) NOT NULL DEFAULT 0,
  `bidder_id` int(5) NOT NULL DEFAULT 0,
  `bid_price` int(5) NOT NULL DEFAULT 0,
  `bid_time` time DEFAULT NULL,
  PRIMARY KEY (`acd_id`),
  KEY `auc_id` (`auc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auction_mas`
--

DROP TABLE IF EXISTS `auction_mas`;
CREATE TABLE IF NOT EXISTS `auction_mas` (
  `auc_id` int(5) NOT NULL AUTO_INCREMENT,
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
  `auc_status` varchar(1) DEFAULT 'P',
  PRIMARY KEY (`auc_id`),
  KEY `offer_id` (`offer_nm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bidder_mas`
--

DROP TABLE IF EXISTS `bidder_mas`;
CREATE TABLE IF NOT EXISTS `bidder_mas` (
  `bidder_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) DEFAULT NULL,
  `addr` text DEFAULT NULL,
  `state_code` varchar(2) DEFAULT NULL,
  `pin` varchar(6) DEFAULT NULL,
  `pan_no` varchar(10) DEFAULT NULL,
  `gst_no` varchar(15) DEFAULT NULL,
  `cont_no1` varchar(10) DEFAULT NULL,
  `cont_no2` varchar(10) DEFAULT NULL,
  `email_id` varchar(75) DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`bidder_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offer_mas`
--

DROP TABLE IF EXISTS `offer_mas`;
CREATE TABLE IF NOT EXISTS `offer_mas` (
  `offer_id` int(5) NOT NULL AUTO_INCREMENT,
  `offer_nm` varchar(50) DEFAULT NULL,
  `offer_dt` date DEFAULT NULL,
  `start_tm` time DEFAULT NULL,
  `end_tm` time DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `payment_type` varchar(25) DEFAULT NULL,
  `contract_type` varchar(25) DEFAULT NULL,
  `prompt_days` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`offer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offer_srl_mas`
--

DROP TABLE IF EXISTS `offer_srl_mas`;
CREATE TABLE IF NOT EXISTS `offer_srl_mas` (
  `offer_id` int(5) NOT NULL AUTO_INCREMENT,
  `offer_srl` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`offer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_mas`
--

DROP TABLE IF EXISTS `user_mas`;
CREATE TABLE IF NOT EXISTS `user_mas` (
  `uid` int(5) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`uid`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_type_mas`
--

DROP TABLE IF EXISTS `user_type_mas`;
CREATE TABLE IF NOT EXISTS `user_type_mas` (
  `user_type_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(1) DEFAULT 'B',
  `user_type_desc` varchar(15) DEFAULT NULL,
  `assigned_page` text DEFAULT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
