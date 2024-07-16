-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2024 at 03:36 PM
-- Server version: 5.7.44
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `andrewyu_privatesale`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction_dtl`
--

DROP TABLE IF EXISTS `auction_dtl`;
CREATE TABLE IF NOT EXISTS `auction_dtl` (
  `acd_id` int(5) NOT NULL AUTO_INCREMENT,
  `auc_id` int(5) NOT NULL DEFAULT '0',
  `jap_id` int(5) DEFAULT NULL,
  `lot_no` int(5) NOT NULL DEFAULT '0',
  `garden_nm` varchar(50) DEFAULT NULL,
  `grade` varchar(25) DEFAULT NULL,
  `invoice_no` varchar(12) DEFAULT NULL,
  `gp_date` date DEFAULT NULL,
  `chest` varchar(12) DEFAULT NULL,
  `net` decimal(2,0) DEFAULT NULL,
  `pkgs` int(5) NOT NULL DEFAULT '0',
  `valu_kg` int(5) NOT NULL DEFAULT '0',
  `base_price` decimal(12,2) DEFAULT '0.00',
  `msp` decimal(10,2) DEFAULT '0.00',
  `bid_price` decimal(12,2) DEFAULT '0.00',
  `bidder_id` decimal(12,2) DEFAULT '0.00',
  `auc_status` varchar(1) DEFAULT 'P',
  PRIMARY KEY (`acd_id`),
  KEY `auc_id` (`auc_id`),
  KEY `bidder_id` (`bidder_id`),
  KEY `jap_id` (`jap_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auction_dtl`
--

INSERT INTO `auction_dtl` (`acd_id`, `auc_id`, `jap_id`, `lot_no`, `garden_nm`, `grade`, `invoice_no`, `gp_date`, `chest`, `net`, `pkgs`, `valu_kg`, `base_price`, `msp`, `bid_price`, `bidder_id`, `auc_status`) VALUES
(4, 2, NULL, 2, 'BASMATIA', 'PF', 'C06', '2024-03-22', '6366-6395', 20, 5, 350, 300.00, 0.00, 0.00, 0.00, 'P'),
(5, 2, NULL, 3, 'BASMATIA', 'BOPSM', 'C07', '2024-03-23', '6366-6395', 20, 5, 150, 100.00, 0.00, 0.00, 0.00, 'P'),
(7, 2, NULL, 5, 'BASMATIA', 'BOP', 'C09', '2024-03-23', '6366-6395', 20, 5, 180, 130.00, 0.00, 0.00, 0.00, 'P'),
(9, 2, NULL, 7, 'BASMATIA', 'PF', 'C15', '2024-03-15', '6366-6395', 20, 5, 350, 300.00, 0.00, 0.00, 0.00, 'P'),
(11, 2, NULL, 9, 'BASMATIA', 'BP', 'C17', '2024-03-23', '6366-6395', 20, 5, 250, 200.00, 0.00, 0.00, 0.00, 'P'),
(12, 2, NULL, 10, 'BASMATIA', 'BOP', 'C18', '2024-03-23', '6366-6395', 20, 5, 180, 130.00, 0.00, 0.00, 0.00, 'P'),
(13, 3, NULL, 1, 'DESAM', 'BOP', 'C242', '2024-06-28', '0', 24, 20, 320, 270.00, 305.00, 0.00, 0.00, 'P'),
(14, 3, NULL, 2, 'DESAM', 'BOP', 'C251', '2024-07-04', '0', 24, 30, 320, 270.00, 305.00, 0.00, 0.00, 'P'),
(15, 3, NULL, 3, 'DESAM', 'DUST', 'D237', '2024-06-26', '0', 34, 30, 330, 280.00, 310.00, 0.00, 0.00, 'P'),
(16, 3, NULL, 4, 'DESAM', 'DUST', 'D249', '2024-06-29', '0', 34, 30, 330, 280.00, 310.00, 0.00, 0.00, 'P'),
(17, 3, NULL, 5, 'DESAM', 'DUST', 'D262', '2024-07-06', '0', 33, 20, 330, 280.00, 310.00, 0.00, 0.00, 'P'),
(18, 3, NULL, 6, 'DESAM', 'DUST', 'D269', '2024-07-08', '0', 33, 20, 330, 280.00, 310.00, 0.00, 0.00, 'P'),
(19, 3, NULL, 7, 'DESAM', 'D1', 'D259', '2024-07-05', '0', 35, 40, 260, 210.00, 240.00, 0.00, 0.00, 'P'),
(20, 3, NULL, 8, 'DESAM', 'BOPSM', 'C256', '2024-07-05', '0', 26, 30, 385, 335.00, 365.00, 0.00, 0.00, 'P'),
(21, 3, NULL, 9, 'DESAM', 'BOPSM', 'C260', '2024-07-06', '0', 26, 30, 385, 335.00, 365.00, 0.00, 0.00, 'P'),
(22, 3, NULL, 10, 'DESAM', 'BP', 'C253', '2024-07-04', '0', 28, 30, 365, 315.00, 350.00, 0.00, 0.00, 'P'),
(23, 3, NULL, 11, 'DESAM', 'BP', 'C270', '2024-07-08', '0', 27, 30, 365, 315.00, 350.00, 0.00, 0.00, 'P'),
(24, 3, NULL, 12, 'KHOWANG', 'BOP', 'C727', '2024-06-30', '0', 24, 30, 340, 290.00, 315.00, 0.00, 0.00, 'P'),
(25, 3, NULL, 13, 'KHOWANG', 'BOP', 'C759', '2024-07-05', '0', 23, 30, 340, 290.00, 315.00, 0.00, 0.00, 'P'),
(26, 3, NULL, 14, 'KHOWANG', 'BOP', 'C765', '2024-07-06', '0', 23, 30, 350, 300.00, 315.00, 0.00, 0.00, 'P'),
(27, 3, NULL, 15, 'KHOWANG', 'DUST', 'D725', '2024-06-30', '0', 34, 30, 350, 300.00, 330.00, 0.00, 0.00, 'P'),
(28, 3, NULL, 16, 'KHOWANG', 'DUST', 'D728', '2024-06-30', '0', 34, 30, 350, 300.00, 330.00, 0.00, 0.00, 'P'),
(29, 3, NULL, 17, 'KHOWANG', 'DUST', 'D732', '2024-07-02', '0', 34, 30, 350, 300.00, 330.00, 0.00, 0.00, 'P'),
(30, 3, NULL, 18, 'KHOWANG', 'DUST', 'D743', '2024-07-04', '0', 34, 30, 350, 300.00, 330.00, 0.00, 0.00, 'P'),
(31, 3, NULL, 19, 'KHOWANG', 'D1', 'D736', '2024-07-03', '0', 33, 20, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(32, 3, NULL, 20, 'KHOWANG', 'D1', 'D746', '2024-07-04', '0', 32, 20, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(33, 3, NULL, 21, 'KHOWANG', 'D1', 'D752', '2024-07-04', '0', 32, 20, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(34, 3, NULL, 22, 'KHOWANG', 'D1', 'D746', '2024-07-04', '0', 32, 20, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(35, 3, NULL, 23, 'KHOWANG', 'D1', 'D761', '2024-07-04', '0', 32, 20, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(36, 3, NULL, 24, 'KHOWANG', 'D1', 'D763', '2024-07-06', '0', 32, 20, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(37, 3, NULL, 25, 'KHOWANG', 'D1', 'D766', '2024-07-06', '0', 32, 20, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(38, 3, NULL, 27, 'TINKONG', 'D1', 'D403', '2024-06-29', '0', 31, 15, 260, 210.00, 240.00, 0.00, 0.00, 'P'),
(39, 3, NULL, 28, 'TINKONG', 'D1', 'D405', '2024-06-29', '0', 31, 20, 260, 210.00, 240.00, 0.00, 0.00, 'P'),
(40, 3, NULL, 29, 'TINKONG', 'D1', 'D411', '2024-06-30', '0', 31, 20, 260, 210.00, 240.00, 0.00, 0.00, 'P'),
(41, 3, NULL, 30, 'TINKONG', 'D1', 'D422', '2024-07-03', '0', 30, 15, 260, 210.00, 240.00, 0.00, 0.00, 'P'),
(42, 3, NULL, 31, 'TINKONG', 'D1', 'D442', '2024-07-06', '0', 30, 20, 260, 210.00, 240.00, 0.00, 0.00, 'P'),
(43, 3, NULL, 32, 'TINKONG', 'DUST', 'D429', '2024-07-04', '0', 30, 30, 335, 285.00, 330.00, 0.00, 0.00, 'P'),
(44, 3, NULL, 33, 'TINKONG', 'DUST', 'D438', '2024-07-05', '0', 30, 20, 335, 285.00, 330.00, 0.00, 0.00, 'P'),
(45, 3, NULL, 34, 'TINKONG', 'DUST', 'D441', '2024-07-06', '0', 30, 20, 335, 285.00, 330.00, 0.00, 0.00, 'P'),
(46, 3, NULL, 35, 'TINKONG', 'DUST', 'D450', '2024-07-06', '0', 30, 20, 335, 285.00, 330.00, 0.00, 0.00, 'P'),
(47, 3, NULL, 36, 'TINKONG', 'DUST', 'D455', '2024-07-08', '0', 30, 20, 335, 285.00, 330.00, 0.00, 0.00, 'P'),
(48, 3, NULL, 37, 'HOOLUNGOOREE', 'DUST', 'D386', '2024-07-03', '0', 33, 20, 350, 300.00, 330.00, 0.00, 0.00, 'P'),
(49, 3, NULL, 38, 'HOOLUNGOOREE', 'DUST', 'D392', '2024-07-04', '0', 32, 20, 340, 290.00, 320.00, 0.00, 0.00, 'P'),
(50, 3, NULL, 39, 'HOOLUNGOOREE', 'DUST', 'D401', '2024-07-06', '0', 32, 20, 350, 300.00, 330.00, 0.00, 0.00, 'P'),
(51, 3, NULL, 40, 'HOOLUNGOOREE', 'D1', 'D357', '2024-06-26', '0', 35, 10, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(52, 3, NULL, 41, 'HOOLUNGOOREE', 'D1', 'D382', '2024-07-02', '0', 35, 20, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(53, 3, NULL, 42, 'HOOLUNGOOREE', 'D1', 'D397', '2024-07-05', '0', 35, 20, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(54, 3, NULL, 43, 'HOOLUNGOOREE', 'D1', 'D404', '2024-07-06', '0', 35, 10, 250, 200.00, 230.00, 0.00, 0.00, 'P'),
(55, 3, NULL, 44, 'HOOLUNGOOREE', 'PD', 'D402', '2024-07-06', '0', 28, 20, 365, 315.00, 350.00, 0.00, 0.00, 'P'),
(56, 3, NULL, 45, 'HOOLUNGOOREE', 'PD', 'D406', '2024-07-08', '0', 28, 20, 365, 315.00, 350.00, 0.00, 0.00, 'P');

-- --------------------------------------------------------

--
-- Table structure for table `auction_mas`
--

DROP TABLE IF EXISTS `auction_mas`;
CREATE TABLE IF NOT EXISTS `auction_mas` (
  `auc_id` int(5) NOT NULL AUTO_INCREMENT,
  `auc_start_time` datetime DEFAULT NULL,
  `auc_end_time` datetime DEFAULT NULL,
  `knockdown_start` datetime DEFAULT NULL,
  `knockdown_end` datetime DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `payment_type` varchar(25) DEFAULT NULL,
  `contract_type` varchar(25) DEFAULT NULL,
  `offer_nm` varchar(50) DEFAULT NULL,
  `offer_srl` varchar(30) NOT NULL DEFAULT '0',
  `auc_status` varchar(1) DEFAULT 'P',
  `tea_place` varchar(30) DEFAULT NULL,
  `sale_type` varchar(1) NOT NULL DEFAULT 'E',
  `frequently` int(5) DEFAULT NULL,
  `duration` varchar(3) DEFAULT NULL,
  `offer_srl_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`auc_id`),
  KEY `offer_id` (`offer_nm`),
  KEY `knockdown_start` (`knockdown_start`),
  KEY `knockdown_end` (`knockdown_end`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auction_mas`
--

INSERT INTO `auction_mas` (`auc_id`, `auc_start_time`, `auc_end_time`, `knockdown_start`, `knockdown_end`, `location`, `payment_type`, `contract_type`, `offer_nm`, `offer_srl`, `auc_status`, `tea_place`, `sale_type`, `frequently`, `duration`, `offer_srl_id`) VALUES
(1, '2024-05-13 22:00:00', '2024-05-13 22:18:00', '2024-05-13 22:19:00', '2024-05-13 23:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', NULL, 'ASSAM/2024/0017', 'P', NULL, 'E', NULL, NULL, 2),
(2, '2024-05-30 15:00:00', '2024-05-31 16:00:00', '2024-05-14 16:00:00', '2024-05-14 16:10:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', NULL, 'ASSAM/2024/0018', 'P', NULL, 'E', NULL, NULL, 2),
(3, '2024-07-16 10:15:00', '2024-07-18 17:00:00', '2024-07-18 17:00:00', '2024-07-18 18:00:00', 'Ex-Guwahati', '14 DAYS', 'Cash & Carry', NULL, 'ASSAM/2024/0019', 'P', NULL, 'E', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `auc_bid_dtl`
--

DROP TABLE IF EXISTS `auc_bid_dtl`;
CREATE TABLE IF NOT EXISTS `auc_bid_dtl` (
  `abd_id` int(5) NOT NULL AUTO_INCREMENT,
  `auc_id` int(5) NOT NULL DEFAULT '0',
  `acd_id` int(5) NOT NULL DEFAULT '0',
  `bidder_id` int(5) NOT NULL DEFAULT '0',
  `bid_price` int(5) NOT NULL DEFAULT '0',
  `bid_time` datetime DEFAULT NULL,
  PRIMARY KEY (`abd_id`),
  KEY `auc_id` (`auc_id`),
  KEY `acd_id` (`acd_id`),
  KEY `bidder_id` (`bidder_id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auc_bid_dtl`
--

INSERT INTO `auc_bid_dtl` (`abd_id`, `auc_id`, `acd_id`, `bidder_id`, `bid_price`, `bid_time`) VALUES
(4, 2, 4, 24, 303, '2024-05-14 15:21:48'),
(5, 2, 5, 24, 101, '2024-05-14 15:21:59'),
(7, 2, 7, 24, 135, '2024-05-14 15:22:55'),
(9, 2, 9, 24, 301, '2024-05-14 15:23:19'),
(11, 2, 12, 24, 131, '2024-05-14 15:23:22'),
(12, 2, 11, 24, 201, '2024-05-14 15:23:22'),
(46, 2, 4, 8, 313, '2024-05-14 15:25:41'),
(47, 2, 4, 24, 316, '2024-05-14 15:25:41'),
(48, 2, 4, 8, 326, '2024-05-14 15:25:41'),
(49, 2, 4, 24, 329, '2024-05-14 15:25:41'),
(50, 2, 4, 8, 339, '2024-05-14 15:25:41'),
(51, 2, 4, 24, 342, '2024-05-14 15:25:41'),
(52, 2, 4, 8, 352, '2024-05-14 15:25:41'),
(53, 2, 4, 24, 355, '2024-05-14 15:25:41'),
(54, 2, 4, 8, 365, '2024-05-14 15:25:41'),
(55, 2, 4, 24, 368, '2024-05-14 15:25:41'),
(56, 2, 4, 8, 378, '2024-05-14 15:25:41'),
(57, 2, 4, 24, 381, '2024-05-14 15:25:41'),
(58, 2, 4, 8, 391, '2024-05-14 15:25:41'),
(59, 2, 4, 24, 394, '2024-05-14 15:25:41'),
(60, 2, 5, 8, 104, '2024-05-14 15:25:57'),
(70, 2, 4, 8, 404, '2024-05-14 15:26:08'),
(71, 2, 5, 24, 107, '2024-05-14 15:26:15'),
(72, 2, 5, 8, 110, '2024-05-14 15:26:15'),
(73, 2, 5, 24, 113, '2024-05-14 15:26:15'),
(74, 2, 5, 8, 116, '2024-05-14 15:26:15'),
(75, 2, 5, 24, 119, '2024-05-14 15:26:15'),
(76, 2, 5, 8, 122, '2024-05-14 15:26:15'),
(77, 2, 5, 24, 125, '2024-05-14 15:26:15'),
(78, 2, 5, 8, 128, '2024-05-14 15:26:15'),
(79, 2, 5, 24, 131, '2024-05-14 15:26:15'),
(80, 2, 5, 8, 134, '2024-05-14 15:26:15'),
(81, 2, 5, 24, 137, '2024-05-14 15:26:15'),
(82, 2, 5, 8, 140, '2024-05-14 15:26:15'),
(83, 2, 5, 24, 143, '2024-05-14 15:26:15'),
(84, 2, 5, 8, 146, '2024-05-14 15:26:15'),
(85, 2, 5, 24, 149, '2024-05-14 15:26:15'),
(86, 2, 5, 8, 152, '2024-05-14 15:26:15'),
(87, 2, 5, 24, 155, '2024-05-14 15:26:15'),
(88, 2, 5, 8, 158, '2024-05-14 15:26:15'),
(89, 2, 5, 24, 161, '2024-05-14 15:26:15'),
(90, 2, 5, 8, 164, '2024-05-14 15:26:15'),
(91, 2, 5, 24, 167, '2024-05-14 15:26:15'),
(92, 2, 5, 8, 170, '2024-05-14 15:26:15'),
(93, 2, 5, 24, 173, '2024-05-14 15:26:15'),
(94, 2, 5, 8, 176, '2024-05-14 15:26:15'),
(95, 2, 5, 24, 179, '2024-05-14 15:26:15'),
(96, 2, 5, 8, 182, '2024-05-14 15:26:15'),
(97, 2, 5, 24, 185, '2024-05-14 15:26:15'),
(98, 2, 5, 8, 188, '2024-05-14 15:26:15'),
(99, 2, 5, 24, 191, '2024-05-14 15:26:15'),
(100, 2, 5, 8, 194, '2024-05-14 15:26:15'),
(101, 2, 5, 24, 197, '2024-05-14 15:26:15'),
(102, 2, 5, 8, 200, '2024-05-14 15:26:15'),
(103, 2, 5, 24, 203, '2024-05-14 15:26:15'),
(104, 2, 5, 8, 206, '2024-05-14 15:26:15'),
(105, 2, 5, 24, 209, '2024-05-14 15:26:15'),
(106, 2, 5, 8, 212, '2024-05-14 15:26:15'),
(107, 2, 5, 24, 215, '2024-05-14 15:26:15'),
(108, 2, 5, 8, 218, '2024-05-14 15:26:15'),
(109, 2, 5, 24, 221, '2024-05-14 15:26:15'),
(110, 2, 5, 8, 224, '2024-05-14 15:26:15'),
(111, 2, 5, 24, 227, '2024-05-14 15:26:15'),
(112, 2, 5, 8, 230, '2024-05-14 15:26:15'),
(113, 2, 5, 24, 233, '2024-05-14 15:26:15'),
(114, 2, 5, 8, 236, '2024-05-14 15:26:15'),
(115, 2, 5, 24, 239, '2024-05-14 15:26:15'),
(116, 2, 5, 8, 242, '2024-05-14 15:26:15'),
(117, 2, 5, 24, 245, '2024-05-14 15:26:15'),
(118, 2, 5, 8, 248, '2024-05-14 15:26:15'),
(119, 2, 5, 24, 251, '2024-05-14 15:26:15'),
(120, 2, 5, 8, 254, '2024-05-14 15:26:15'),
(121, 2, 5, 24, 257, '2024-05-14 15:26:15'),
(122, 2, 5, 8, 260, '2024-05-14 15:26:15'),
(123, 2, 5, 24, 263, '2024-05-14 15:26:15'),
(124, 2, 5, 8, 266, '2024-05-14 15:26:15'),
(125, 2, 5, 24, 269, '2024-05-14 15:26:15'),
(126, 2, 5, 8, 272, '2024-05-14 15:26:15'),
(127, 2, 5, 24, 275, '2024-05-14 15:26:15'),
(128, 2, 5, 8, 278, '2024-05-14 15:26:15'),
(129, 2, 5, 24, 281, '2024-05-14 15:26:15'),
(130, 2, 5, 8, 284, '2024-05-14 15:26:15'),
(131, 2, 5, 24, 287, '2024-05-14 15:26:15'),
(132, 2, 5, 8, 290, '2024-05-14 15:26:15'),
(133, 2, 5, 24, 293, '2024-05-14 15:26:15'),
(134, 2, 5, 8, 296, '2024-05-14 15:26:15'),
(135, 2, 5, 24, 299, '2024-05-14 15:26:15'),
(136, 2, 5, 8, 302, '2024-05-14 15:26:15'),
(139, 2, 4, 5, 450, '2024-05-14 15:26:38'),
(142, 2, 7, 5, 140, '2024-05-14 15:26:46'),
(143, 2, 7, 24, 145, '2024-05-14 15:26:46'),
(144, 2, 7, 24, 146, '2024-05-14 15:27:11'),
(145, 2, 5, 5, 350, '2024-05-14 15:27:16'),
(151, 2, 7, 5, 150, '2024-05-14 15:27:50'),
(152, 2, 7, 24, 155, '2024-05-14 15:27:50'),
(155, 2, 9, 5, 330, '2024-05-14 15:27:52'),
(156, 2, 9, 24, 335, '2024-05-14 15:27:52'),
(157, 2, 9, 5, 340, '2024-05-14 15:28:07'),
(158, 2, 9, 24, 345, '2024-05-14 15:28:07'),
(159, 2, 7, 5, 156, '2024-05-14 15:28:16'),
(160, 2, 7, 24, 161, '2024-05-14 15:28:16'),
(161, 2, 7, 5, 165, '2024-05-14 15:28:28'),
(162, 2, 7, 24, 170, '2024-05-14 15:28:28'),
(163, 2, 4, 5, 451450, '2024-05-14 15:46:22'),
(164, 3, 13, 20, 305, '2024-07-16 11:23:58'),
(165, 3, 14, 20, 305, '2024-07-16 11:24:03'),
(166, 3, 15, 20, 310, '2024-07-16 11:24:06'),
(167, 3, 19, 20, 240, '2024-07-16 11:24:23'),
(168, 3, 16, 20, 310, '2024-07-16 11:24:25'),
(169, 3, 17, 20, 310, '2024-07-16 11:24:26'),
(170, 3, 18, 20, 310, '2024-07-16 11:24:27'),
(171, 3, 24, 20, 315, '2024-07-16 11:26:09'),
(172, 3, 25, 20, 315, '2024-07-16 11:26:10'),
(173, 3, 26, 20, 315, '2024-07-16 11:26:11'),
(174, 3, 29, 20, 330, '2024-07-16 11:27:33'),
(175, 3, 27, 20, 330, '2024-07-16 11:27:36'),
(176, 3, 28, 20, 330, '2024-07-16 11:27:39'),
(177, 3, 30, 20, 330, '2024-07-16 11:27:44'),
(178, 3, 31, 20, 230, '2024-07-16 11:28:32'),
(179, 3, 32, 20, 230, '2024-07-16 11:28:36'),
(180, 3, 33, 20, 230, '2024-07-16 11:28:39'),
(181, 3, 34, 20, 230, '2024-07-16 11:28:45'),
(182, 3, 35, 20, 230, '2024-07-16 11:28:49'),
(183, 3, 36, 20, 230, '2024-07-16 11:28:52'),
(184, 3, 37, 20, 230, '2024-07-16 11:28:54'),
(185, 3, 38, 20, 240, '2024-07-16 11:29:21'),
(186, 3, 39, 20, 240, '2024-07-16 11:29:26'),
(187, 3, 40, 20, 240, '2024-07-16 11:29:28'),
(188, 3, 41, 20, 240, '2024-07-16 11:29:31'),
(189, 3, 42, 20, 240, '2024-07-16 11:29:34'),
(190, 3, 43, 20, 300, '2024-07-16 11:29:51'),
(191, 3, 44, 20, 300, '2024-07-16 11:29:55'),
(192, 3, 45, 20, 300, '2024-07-16 11:29:57'),
(193, 3, 46, 20, 300, '2024-07-16 11:29:59'),
(194, 3, 47, 20, 300, '2024-07-16 11:30:01'),
(195, 3, 48, 20, 330, '2024-07-16 11:30:05'),
(196, 3, 49, 20, 320, '2024-07-16 11:30:10'),
(197, 3, 50, 20, 330, '2024-07-16 11:30:13'),
(198, 3, 51, 20, 230, '2024-07-16 11:30:29'),
(199, 3, 52, 20, 230, '2024-07-16 11:30:32'),
(200, 3, 53, 20, 230, '2024-07-16 11:30:41'),
(201, 3, 54, 20, 230, '2024-07-16 11:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `auc_bid_dtl_del`
--

DROP TABLE IF EXISTS `auc_bid_dtl_del`;
CREATE TABLE IF NOT EXISTS `auc_bid_dtl_del` (
  `del_id` int(5) NOT NULL AUTO_INCREMENT,
  `abd_id` int(5) NOT NULL DEFAULT '0',
  `auc_id` int(5) NOT NULL DEFAULT '0',
  `acd_id` int(5) NOT NULL DEFAULT '0',
  `bidder_id` int(5) NOT NULL DEFAULT '0',
  `bid_price` int(5) NOT NULL DEFAULT '0',
  `bid_time` datetime DEFAULT NULL,
  `remk` text,
  PRIMARY KEY (`del_id`),
  KEY `abd_id` (`abd_id`),
  KEY `auc_id` (`auc_id`),
  KEY `acd_id` (`acd_id`),
  KEY `bidder_id` (`bidder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `autobid_dtl`
--

DROP TABLE IF EXISTS `autobid_dtl`;
CREATE TABLE IF NOT EXISTS `autobid_dtl` (
  `auto_dtl_id` int(5) NOT NULL AUTO_INCREMENT,
  `auto_id` int(5) DEFAULT NULL,
  `bidder_id` int(5) DEFAULT NULL,
  `auc_id` int(5) DEFAULT NULL,
  `acd_id` int(5) DEFAULT NULL,
  `autobid_price` decimal(3,0) DEFAULT '0',
  `autbid_maxprice` decimal(4,0) DEFAULT '0',
  `autobid_on` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_dtl_id`),
  KEY `auto_id` (`auto_id`),
  KEY `bidder_id` (`bidder_id`),
  KEY `auc_id` (`auc_id`),
  KEY `acd_id` (`acd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `autobid_mas`
--

DROP TABLE IF EXISTS `autobid_mas`;
CREATE TABLE IF NOT EXISTS `autobid_mas` (
  `auto_id` int(5) NOT NULL AUTO_INCREMENT,
  `bidder_id` int(5) DEFAULT NULL,
  `auc_id` int(5) DEFAULT NULL,
  `acd_id` int(5) DEFAULT NULL,
  `autobid_price` decimal(3,0) DEFAULT '0',
  `autbid_maxprice` decimal(4,0) DEFAULT '0',
  `autobid_on` datetime DEFAULT NULL,
  `update_on` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`),
  KEY `bidder_id` (`bidder_id`),
  KEY `auc_id` (`auc_id`),
  KEY `acd_id` (`acd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `autobid_mas`
--

INSERT INTO `autobid_mas` (`auto_id`, `bidder_id`, `auc_id`, `acd_id`, `autobid_price`, `autbid_maxprice`, `autobid_on`, `update_on`) VALUES
(1, 24, 2, 4, 3, 400, '2024-05-14 15:21:48', NULL),
(2, 24, 2, 3, 5, 1000, '2024-05-14 15:21:54', '2024-05-14 15:29:01'),
(3, 24, 2, 6, 5, 300, '2024-05-14 15:22:13', NULL),
(4, 24, 2, 7, 5, 200, '2024-05-14 15:22:55', NULL),
(5, 24, 2, 8, 3, 350, '2024-05-14 15:23:35', NULL),
(6, 24, 2, 9, 5, 400, '2024-05-14 15:23:47', NULL),
(7, 24, 2, 10, 5, 250, '2024-05-14 15:24:03', NULL),
(8, 5, 2, 3, 3, 360, '2024-05-14 15:25:06', NULL),
(9, 8, 2, 3, 5, 400, '2024-05-14 15:25:09', NULL),
(10, 8, 2, 4, 10, 450, '2024-05-14 15:25:41', '2024-05-14 15:26:08'),
(11, 8, 2, 5, 3, 350, '2024-05-14 15:25:57', NULL),
(12, 24, 2, 5, 3, 300, '2024-05-14 15:26:15', NULL),
(13, 8, 2, 6, 5, 250, '2024-05-14 15:27:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bidder_mas`
--

DROP TABLE IF EXISTS `bidder_mas`;
CREATE TABLE IF NOT EXISTS `bidder_mas` (
  `bidder_id` int(5) NOT NULL AUTO_INCREMENT,
  `uid` int(5) DEFAULT NULL,
  `name` varchar(75) DEFAULT NULL,
  `addr` text,
  `state_code` varchar(2) DEFAULT NULL,
  `pin` varchar(6) DEFAULT NULL,
  `pan_no` varchar(10) DEFAULT NULL,
  `gst_no` varchar(15) DEFAULT NULL,
  `cont_no1` varchar(10) DEFAULT NULL,
  `cont_no2` varchar(10) DEFAULT NULL,
  `email_id` varchar(75) DEFAULT NULL,
  `bidder_type` varchar(1) NOT NULL DEFAULT 'V',
  `billing_nm` varchar(50) DEFAULT NULL,
  `legal_letter` text,
  `letter_approve` varchar(1) NOT NULL DEFAULT 'N',
  `approve_by` int(5) DEFAULT NULL,
  `approve_on` datetime DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`bidder_id`),
  KEY `bidder_type` (`bidder_type`),
  KEY `uid` (`uid`),
  KEY `letter_approve` (`letter_approve`),
  KEY `approve_by` (`approve_by`),
  KEY `approve_on` (`approve_on`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bidder_mas`
--

INSERT INTO `bidder_mas` (`bidder_id`, `uid`, `name`, `addr`, `state_code`, `pin`, `pan_no`, `gst_no`, `cont_no1`, `cont_no2`, `email_id`, `bidder_type`, `billing_nm`, `legal_letter`, `letter_approve`, `approve_by`, `approve_on`, `status`) VALUES
(3, 6, 'AMITABHA BARAT', '29A/1 SANTIRAM RASTA. BALLY, HOWRAH', '19', '711201', 'AHIPN7634G', '19AHIPN7634G1F5', '9830076207', '', 'amitava.barat@gmail.com', 'V', 'INFOTECH SYSTEMS.', NULL, 'N', NULL, NULL, 'A'),
(5, 8, 'AJ', 'YULE HOUSE', '19', '711202', 'AXSDF', 'SAFDAF', '9903194887', '', 'jaiswalaakash2020@gmail.com', 'V', 'ANDREWYULE', NULL, 'N', NULL, NULL, 'A'),
(7, 10, 'AMITABHA', '29A/1 SANTIRAM RASTA, BALLY', '19', '711201', 'AHJPN7254G', '19AHJPN7254G1H6', '9433764700', '', 'amitabha@infotechsystems.in', 'A', NULL, NULL, 'N', NULL, NULL, 'A'),
(8, 11, 'DEMO CO', 'KOLKATA', '19', '711001', 'AHIPJ7645G', '19AHIPJ7645G1G5', '9007363351', '', 'rahulltiwarii0@gmail.com', 'V', 'ANDREWYULE2', NULL, 'N', NULL, NULL, 'A'),
(9, 12, 'ABCD', 'KOL', '19', '700001', 'AHIPK6534F', '19AHIPK6534F1U5', '9051844469', '', 'debajit.nag@andrewyule.com', 'V', NULL, NULL, 'N', NULL, NULL, 'A'),
(15, 18, 'SURAJIT MONDAL', 'HOWRAH', '19', '711303', 'DDDDDDDDDD', 'DDDDDDDDDDDDDDD', '9051530165', '', 'surajit@infotechsystems.in', 'A', 'INFOTECH SYSTEMS', 'legal/PROJECT modification31-01-15-38.pdf', 'N', NULL, NULL, 'A'),
(16, 19, 'SURAJIT MONDAL', '29A/1 SANTIRAM RASTA, BALLY, HOWRAH', '19', '711201', 'AHIOB7518J', '19AHJID7218J1Z5', '9830076207', '', 'contact@infotechsystems.in', 'V', 'INFOTECH SYSTEMS', NULL, 'N', NULL, NULL, 'A'),
(17, 20, 'MANOJ MANNA', '32, J. L. NEHRU ROAD, OM TOWER, 4TH FLOOR', '19', '700071', 'AAGCS5300Q', '19AAGCS5300Q1ZX', '9874456712', '7278755731', 'manojmanna@sumranagro.com', 'V', 'SUMARAN PROJECTS PVT. LTD.', NULL, 'N', NULL, NULL, 'A'),
(18, 21, 'MOHIT JUTHANI', '37 EZRA STREET', '19', '700001', 'AABFD9114H', '19AABFD9114H1ZI', '7022312555', '9051802635', 'dwarkadas07@yahoo.com', 'V', 'DWARKADAS', NULL, 'N', NULL, NULL, 'A'),
(19, 22, 'GAURAV SHAH', 'FF 11-14 , TEJ COMPLEX, MITHAKHALI , AHMEDABAD', '24', '380009', 'BFIPS1786M', '24BFIPS1786M1ZS', '9428372730', '9727783231', 'info@morakhiagroup.com', 'V', 'KINGS MAHINDRA', NULL, 'N', NULL, NULL, 'A'),
(20, 23, 'NEHAL SHAH', '40 / D CHAKRABERIA ROAD NORTH\r\nGROUND FLOOR\r\nBHAWANIPORE', '19', '700020', 'AAGFP3513P', '19AAGFP3513P1ZT', '9836922240', '9433364576', 'pratik@pjshah.in', 'V', 'PRANJIVAN J SHAH', NULL, 'N', NULL, NULL, 'A'),
(21, 24, 'DUNDESH DHANG', 'CHIKODI', '29', '591201', 'AFTPD1919H', '29AFTPD1919H2Z6', '9448111189', '9901189396', 'dundeshdhang83@gmail.com', 'V', 'SANNIDHI TEA ENTERPRISES', NULL, 'N', NULL, NULL, 'A'),
(22, 25, 'RAKESH BHAGAT', 'A/303 AASTHAN COMPLEX\r\nOPP POLYTECHNIC AMBAWADI', '24', '380015', 'AAFFH6383N', '24AAFFH6383N2ZW', '9825039733', '9825069533', 'rakeshbhagat@newteaco.com', 'V', 'HARSH TEA COMPANY', NULL, 'N', NULL, NULL, 'A'),
(23, 26, 'VIKAS SINGAL', 'ORCHID BUILDING, 4TH FLOOR,NEAR LIC BUILDING SILIGURI', '19', '734005', 'AFPPS1007M', '19AFPPS1007M1ZZ', '9832190888', '9735956400', 'VIKASHTEA@YAHOO.IN', 'V', 'VIKAS TEA CORPORATION', NULL, 'N', NULL, NULL, 'A'),
(24, 27, 'DUMMY_UDESHYA', 'XYZ', '10', '110043', 'DGQPK7125G', 'ADADA', '7351766705', '', 'udeshyakmr@gmail.com', 'V', 'UDESHYA', NULL, 'N', NULL, NULL, 'A'),
(25, 28, 'SUBHATIRTHA KAR', '22/123B, RAJA MANINDRA ROAD, KOLKATA, P.O.-BELGACHIA, P.S.-CHITPUR', '19', '700037', 'CESPK6648L', 'XYZ193', '7449782411', '9903990089', 'ksubhatirtha@gmail.com', 'V', 'SUBHA ENTERPRISE', NULL, 'N', NULL, NULL, 'A'),
(26, 29, 'PRAVEEN', '8 DR R P SARANI', '19', '700001', 'BQLPK8456N', '19AACCA4245Q1Z9', '8240112945', '', 'praveen.kothari@andrewyule.com', 'V', 'ANDREW YULE', NULL, 'N', NULL, NULL, 'A'),
(27, 30, 'SOUVIK', 'GSVSB', '19', '712104', 'GSUDJDKSSJ', 'BDJCJCNXJXNXMXN', '7687044580', '8726278283', 'souvikguin06@gmail.com', 'V', 'HDBCXB', NULL, 'N', NULL, NULL, 'A'),
(28, 31, 'TEATEA', 'KOLKATA', '19', '700001', 'AEDFY2418F', '19AEDFY2418F1JC', '9003183790', '', 'rnp@andrewyule.com', 'V', 'TEATEA', NULL, 'N', NULL, NULL, 'A'),
(29, 32, 'SHANTANU BORAL', 'ANDREW YULE & CO. LTD', '19', '700094', 'AHOPB3966F', '19AACCA4245Q1Z9', '9831310812', '', 'shantanu.boral@andrewyule.com', 'V', 'ANDREW YULE', NULL, 'N', NULL, NULL, 'A'),
(30, 33, 'SHUBHANKAR CHAKRABORTY', 'HOOGHLY', '19', '712123', 'AGCPC8666J', 'AA5239', '8638740044', '', 'shubhankar.chakraborty@andrewyule.com', 'V', 'CHAKRABORTY', NULL, 'N', NULL, NULL, 'A'),
(31, 34, 'SUBHODIP DUTTA', 'KOLKATA', '19', '700144', 'AKH982HDOP', '5728920190', '8420383106', '', 'subhodipdutta003@gmail.com', 'V', 'PILA SHARK PVT LTD', NULL, 'N', NULL, NULL, 'A'),
(32, 35, 'UDESHYA KUMAR', 'YULE HOUSE', '19', '700001', '1234BGYU21', '', '8240353924', '', 'udeshyakumar1995@gmail.com', 'A', 'AYCL', 'legal/AIDC Letter.pdf', 'N', NULL, NULL, 'A'),
(33, 36, 'UDESHYA KUMAR', 'YULE HOUSE', '19', '700001', '1234BGYU21', '', '8240353924', '', 'udeshyakumar1995@gmail.com', 'A', 'AYCL', 'legal/AIDC Letter30-04-01-12.pdf', 'N', NULL, NULL, 'A'),
(34, 38, 'MAHENDRA ANCHLIYA', '894 SHYAM KUNJ SHARDA CHOWAK JALALPURA GANDHIBAGH NAGPUR', '27', '440032', 'AFEPA1524Q', '27AFEPA1524Q1ZH', '7775946097', '9423615750', 'manchliya@gmail.com', 'V', 'ANNAPURNA', NULL, 'N', NULL, NULL, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `bid_app_dtl`
--

DROP TABLE IF EXISTS `bid_app_dtl`;
CREATE TABLE IF NOT EXISTS `bid_app_dtl` (
  `bad_id` int(5) NOT NULL AUTO_INCREMENT,
  `fad_id` int(5) DEFAULT NULL,
  `auc_id` int(5) DEFAULT NULL,
  `acd_id` int(5) DEFAULT NULL,
  `uid` int(5) DEFAULT NULL,
  `seq_id` int(5) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'P',
  `update_on` datetime DEFAULT NULL,
  PRIMARY KEY (`bad_id`),
  KEY `auc_id` (`auc_id`),
  KEY `acd_id` (`acd_id`),
  KEY `uid` (`uid`),
  KEY `status` (`status`),
  KEY `seq_id` (`seq_id`),
  KEY `fad_id` (`fad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bid_app_dtl`
--

INSERT INTO `bid_app_dtl` (`bad_id`, `fad_id`, `auc_id`, `acd_id`, `uid`, `seq_id`, `status`, `update_on`) VALUES
(1, 1, 1, 1, 37, 1, 'A', '2024-05-13 23:15:11'),
(2, 2, 1, 2, 37, 1, 'A', '2024-05-13 23:15:11'),
(3, 3, 2, 3, 37, 1, 'A', '2024-05-14 16:12:47'),
(4, 4, 2, 6, 37, 1, 'A', '2024-05-14 16:12:47'),
(5, 5, 2, 8, 37, 1, 'A', '2024-05-14 16:12:47'),
(6, 6, 2, 10, 37, 1, 'A', '2024-05-14 16:12:47'),
(7, 7, 2, 13, 37, 1, 'A', '2024-05-14 16:12:47');

-- --------------------------------------------------------

--
-- Table structure for table `committee_mas`
--

DROP TABLE IF EXISTS `committee_mas`;
CREATE TABLE IF NOT EXISTS `committee_mas` (
  `com_id` int(5) NOT NULL AUTO_INCREMENT,
  `uid` int(5) DEFAULT NULL,
  `seq_id` int(2) DEFAULT NULL,
  PRIMARY KEY (`com_id`),
  KEY `uid` (`uid`),
  KEY `seq_id` (`seq_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contract_type_mas`
--

DROP TABLE IF EXISTS `contract_type_mas`;
CREATE TABLE IF NOT EXISTS `contract_type_mas` (
  `ct_id` int(5) NOT NULL AUTO_INCREMENT,
  `ct_desc` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ct_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contract_type_mas`
--

INSERT INTO `contract_type_mas` (`ct_id`, `ct_desc`) VALUES
(1, 'Cash & Carry'),
(2, 'Against PDC'),
(3, 'BSC - 30 DAYS');

-- --------------------------------------------------------

--
-- Table structure for table `file_send_mas`
--

DROP TABLE IF EXISTS `file_send_mas`;
CREATE TABLE IF NOT EXISTS `file_send_mas` (
  `send_id` int(5) NOT NULL AUTO_INCREMENT,
  `auc_id` int(5) DEFAULT NULL,
  `mail_id` varchar(75) DEFAULT NULL,
  `recv_nm` varchar(30) DEFAULT NULL,
  `excel_path` text,
  `send_time` datetime DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'P',
  PRIMARY KEY (`send_id`),
  KEY `auc_id` (`auc_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_send_mas`
--

INSERT INTO `file_send_mas` (`send_id`, `auc_id`, `mail_id`, `recv_nm`, `excel_path`, `send_time`, `status`) VALUES
(1, 1, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/ctc22202314-06-27-43.xlsx', NULL, 'P'),
(2, 2, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/ctc22202314-06-34-11.xlsx', NULL, 'P'),
(3, 3, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/ctc22202314-06-46-25.xlsx', NULL, 'P'),
(4, 4, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/english-type-sale29-01-02-28.xlsx', NULL, 'P'),
(5, 5, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale.xlsx', NULL, 'P'),
(6, 6, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale30-01-50-18.xlsx', NULL, 'P'),
(7, 1, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/Book1.xlsx', NULL, 'P'),
(8, 2, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/Book102-02-23-26.xlsx', NULL, 'P'),
(9, 3, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/Book103-02-25-53.xlsx', NULL, 'P'),
(10, 4, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/Book105-02-03-35.xlsx', NULL, 'P'),
(11, 5, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale09-02-59-26.xlsx', NULL, 'P'),
(12, 6, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale (1).xlsx', NULL, 'P'),
(13, 7, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale(1).xlsx', NULL, 'P'),
(14, 8, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale(1)11-03-29-37.xlsx', NULL, 'P'),
(15, 9, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale (2)16-04-34-59.xlsx', NULL, 'P'),
(16, 10, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/Book122-04-14-02.xlsx', NULL, 'P'),
(17, 11, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale (2)23-04-02-54.xlsx', NULL, 'P'),
(18, 12, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale (2)30-04-45-35.xlsx', NULL, 'P'),
(19, 13, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/Book113-05-29-12.xlsx', NULL, 'P'),
(20, 1, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/Book113-05-45-50.xlsx', NULL, 'P'),
(21, 2, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/sample-data-sale (2)30-04-45-35 (1).xlsx', NULL, 'P'),
(22, 3, 'surajit@infotechsystems.in', 'Surajit Mondal', 'uploads/OFFER LIST 2024-1916-07-57-58.xlsx', NULL, 'P');

-- --------------------------------------------------------

--
-- Table structure for table `final_auction_dtl`
--

DROP TABLE IF EXISTS `final_auction_dtl`;
CREATE TABLE IF NOT EXISTS `final_auction_dtl` (
  `fad_id` int(5) NOT NULL AUTO_INCREMENT,
  `auc_id` int(5) NOT NULL DEFAULT '0',
  `auc_start_time` datetime DEFAULT NULL,
  `auc_end_time` datetime DEFAULT NULL,
  `knockdown_start` datetime DEFAULT NULL,
  `knockdown_end` datetime DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `payment_type` varchar(25) DEFAULT NULL,
  `contract_type` varchar(25) DEFAULT NULL,
  `offer_srl` varchar(30) DEFAULT NULL,
  `offer_srl_id` int(11) NOT NULL DEFAULT '0',
  `acd_id` int(11) NOT NULL DEFAULT '0',
  `jap_id` int(11) DEFAULT '0',
  `lot_no` int(11) DEFAULT NULL,
  `garden_nm` varchar(50) DEFAULT NULL,
  `grade` varchar(25) DEFAULT NULL,
  `invoice_no` varchar(12) DEFAULT NULL,
  `gp_date` date DEFAULT NULL,
  `chest` varchar(12) DEFAULT NULL,
  `net` decimal(2,0) NOT NULL DEFAULT '0',
  `pkgs` int(5) NOT NULL DEFAULT '0',
  `valu_kg` int(5) NOT NULL DEFAULT '0',
  `base_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `msp` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bid_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `bidder_id` int(5) DEFAULT NULL,
  `auc_status` varchar(1) NOT NULL DEFAULT 'P',
  `all_app` varchar(1) NOT NULL DEFAULT 'N',
  `mail_send` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`fad_id`),
  KEY `auc_id` (`auc_id`),
  KEY `acd_id` (`acd_id`),
  KEY `bidder_id` (`bidder_id`),
  KEY `all_app` (`all_app`),
  KEY `mail_send` (`mail_send`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `final_auction_dtl`
--

INSERT INTO `final_auction_dtl` (`fad_id`, `auc_id`, `auc_start_time`, `auc_end_time`, `knockdown_start`, `knockdown_end`, `location`, `payment_type`, `contract_type`, `offer_srl`, `offer_srl_id`, `acd_id`, `jap_id`, `lot_no`, `garden_nm`, `grade`, `invoice_no`, `gp_date`, `chest`, `net`, `pkgs`, `valu_kg`, `base_price`, `msp`, `bid_price`, `bidder_id`, `auc_status`, `all_app`, `mail_send`) VALUES
(1, 1, '2024-05-13 22:00:00', '2024-05-13 22:18:00', '2024-05-13 22:19:00', '2024-05-13 23:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'ASSAM/2024/0017', 2, 1, NULL, 1, 'AMGOORIE', 'BOP', 'C158', '2023-05-06', '6366-6395', 25, 30, 350, 340.00, 0.00, 341.00, 15, 'M', 'Y', 'Y'),
(2, 1, '2024-05-13 22:00:00', '2024-05-13 22:18:00', '2024-05-13 22:19:00', '2024-05-13 23:00:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'ASSAM/2024/0017', 2, 2, NULL, 2, 'AMGOORIE', 'BOP', 'C128', '2023-04-24', '4926-4955', 25, 30, 350, 311.00, 0.00, 342.00, 15, 'M', 'Y', 'Y'),
(3, 2, '2024-05-14 15:00:00', '2024-05-14 16:00:00', '2024-05-14 16:00:00', '2024-05-14 16:10:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'ASSAM/2024/0018', 2, 3, NULL, 1, 'BASMATIA', 'BP', 'C10', '2024-03-15', '6366-6395', 20, 5, 280, 230.00, 0.00, 455.00, 24, 'M', 'Y', 'Y'),
(4, 2, '2024-05-14 15:00:00', '2024-05-14 16:00:00', '2024-05-14 16:00:00', '2024-05-14 16:10:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'ASSAM/2024/0018', 2, 6, NULL, 4, 'BASMATIA', 'BP', 'C08', '2024-03-23', '6366-6395', 20, 5, 250, 200.00, 0.00, 300.00, 24, 'M', 'Y', 'Y'),
(5, 2, '2024-05-14 15:00:00', '2024-05-14 16:00:00', '2024-05-14 16:00:00', '2024-05-14 16:10:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'ASSAM/2024/0018', 2, 8, NULL, 6, 'BASMATIA', 'BOPSM', 'C14', '2024-03-23', '6366-6395', 20, 5, 300, 250.00, 0.00, 273.00, 24, 'M', 'Y', 'Y'),
(6, 2, '2024-05-14 15:00:00', '2024-05-14 16:00:00', '2024-05-14 16:00:00', '2024-05-14 16:10:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'ASSAM/2024/0018', 2, 10, NULL, 8, 'BASMATIA', 'BOPSM', 'C16', '2024-03-22', '6366-6395', 20, 5, 150, 100.00, 0.00, 101.00, 24, 'M', 'Y', 'Y'),
(7, 2, '2024-05-14 15:00:00', '2024-05-14 16:00:00', '2024-05-14 16:00:00', '2024-05-14 16:10:00', 'Ex- Garden', '14 DAYS', 'BSC - 30 DAYS', 'ASSAM/2024/0018', 2, 13, NULL, 11, 'BASMATIA', 'BOPSM', 'C19', '2025-03-15', '6366-6395', 20, 5, 300, 250.00, 0.00, 251.00, 24, 'M', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `fin_auc_bid_dtl`
--

DROP TABLE IF EXISTS `fin_auc_bid_dtl`;
CREATE TABLE IF NOT EXISTS `fin_auc_bid_dtl` (
  `fabd_id` int(5) NOT NULL AUTO_INCREMENT,
  `abd_id` int(5) NOT NULL DEFAULT '0',
  `auc_id` int(5) NOT NULL DEFAULT '0',
  `acd_id` int(5) NOT NULL DEFAULT '0',
  `bidder_id` int(5) NOT NULL DEFAULT '0',
  `bid_price` int(5) NOT NULL DEFAULT '0',
  `bid_time` datetime DEFAULT NULL,
  PRIMARY KEY (`fabd_id`),
  KEY `abd_id` (`abd_id`),
  KEY `auc_id` (`auc_id`),
  KEY `acd_id` (`acd_id`),
  KEY `bidder_id` (`bidder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fin_auc_bid_dtl`
--

INSERT INTO `fin_auc_bid_dtl` (`fabd_id`, `abd_id`, `auc_id`, `acd_id`, `bidder_id`, `bid_price`, `bid_time`) VALUES
(1, 1, 1, 1, 15, 341, '2024-05-13 22:47:03'),
(2, 2, 1, 2, 15, 342, '2024-05-13 22:47:11'),
(3, 3, 2, 3, 24, 231, '2024-05-14 15:21:33'),
(4, 14, 2, 3, 5, 234, '2024-05-14 15:25:06'),
(5, 15, 2, 3, 24, 239, '2024-05-14 15:25:06'),
(6, 16, 2, 3, 5, 242, '2024-05-14 15:25:06'),
(7, 17, 2, 3, 24, 247, '2024-05-14 15:25:06'),
(8, 18, 2, 3, 5, 250, '2024-05-14 15:25:06'),
(9, 19, 2, 3, 24, 255, '2024-05-14 15:25:06'),
(10, 20, 2, 3, 5, 258, '2024-05-14 15:25:06'),
(11, 21, 2, 3, 24, 263, '2024-05-14 15:25:06'),
(12, 22, 2, 3, 5, 266, '2024-05-14 15:25:06'),
(13, 23, 2, 3, 24, 271, '2024-05-14 15:25:06'),
(14, 24, 2, 3, 5, 274, '2024-05-14 15:25:06'),
(15, 25, 2, 3, 24, 279, '2024-05-14 15:25:06'),
(16, 26, 2, 3, 5, 282, '2024-05-14 15:25:06'),
(17, 27, 2, 3, 24, 287, '2024-05-14 15:25:06'),
(18, 28, 2, 3, 5, 290, '2024-05-14 15:25:06'),
(19, 29, 2, 3, 24, 295, '2024-05-14 15:25:06'),
(20, 30, 2, 3, 5, 298, '2024-05-14 15:25:06'),
(21, 31, 2, 3, 24, 303, '2024-05-14 15:25:06'),
(22, 32, 2, 3, 5, 306, '2024-05-14 15:25:06'),
(23, 33, 2, 3, 24, 311, '2024-05-14 15:25:06'),
(24, 34, 2, 3, 5, 314, '2024-05-14 15:25:06'),
(25, 35, 2, 3, 24, 319, '2024-05-14 15:25:06'),
(26, 36, 2, 3, 5, 322, '2024-05-14 15:25:06'),
(27, 37, 2, 3, 24, 327, '2024-05-14 15:25:06'),
(28, 38, 2, 3, 5, 330, '2024-05-14 15:25:06'),
(29, 39, 2, 3, 24, 335, '2024-05-14 15:25:06'),
(30, 40, 2, 3, 5, 338, '2024-05-14 15:25:06'),
(31, 41, 2, 3, 24, 343, '2024-05-14 15:25:06'),
(32, 42, 2, 3, 5, 346, '2024-05-14 15:25:06'),
(33, 43, 2, 3, 8, 351, '2024-05-14 15:25:09'),
(34, 44, 2, 3, 5, 354, '2024-05-14 15:25:09'),
(35, 45, 2, 3, 8, 359, '2024-05-14 15:25:09'),
(36, 61, 2, 3, 24, 364, '2024-05-14 15:26:01'),
(37, 62, 2, 3, 8, 369, '2024-05-14 15:26:01'),
(38, 63, 2, 3, 24, 374, '2024-05-14 15:26:01'),
(39, 64, 2, 3, 8, 379, '2024-05-14 15:26:01'),
(40, 65, 2, 3, 24, 384, '2024-05-14 15:26:01'),
(41, 66, 2, 3, 8, 389, '2024-05-14 15:26:01'),
(42, 67, 2, 3, 24, 394, '2024-05-14 15:26:01'),
(43, 68, 2, 3, 8, 399, '2024-05-14 15:26:01'),
(44, 69, 2, 3, 24, 404, '2024-05-14 15:26:01'),
(45, 137, 2, 3, 5, 450, '2024-05-14 15:26:35'),
(46, 138, 2, 3, 24, 455, '2024-05-14 15:26:35'),
(47, 6, 2, 6, 24, 205, '2024-05-14 15:22:13'),
(48, 140, 2, 6, 5, 230, '2024-05-14 15:26:40'),
(49, 141, 2, 6, 24, 235, '2024-05-14 15:26:40'),
(50, 146, 2, 6, 5, 240, '2024-05-14 15:27:17'),
(51, 147, 2, 6, 24, 245, '2024-05-14 15:27:17'),
(52, 148, 2, 6, 8, 250, '2024-05-14 15:27:24'),
(53, 149, 2, 6, 24, 255, '2024-05-14 15:27:24'),
(54, 150, 2, 6, 5, 300, '2024-05-14 15:27:43'),
(55, 8, 2, 8, 24, 251, '2024-05-14 15:23:17'),
(56, 153, 2, 8, 5, 270, '2024-05-14 15:27:51'),
(57, 154, 2, 8, 24, 273, '2024-05-14 15:27:51'),
(58, 10, 2, 10, 24, 101, '2024-05-14 15:23:20'),
(59, 13, 2, 13, 24, 251, '2024-05-14 15:23:23');

-- --------------------------------------------------------

--
-- Table structure for table `garden_mas`
--

DROP TABLE IF EXISTS `garden_mas`;
CREATE TABLE IF NOT EXISTS `garden_mas` (
  `garden_id` int(5) NOT NULL AUTO_INCREMENT,
  `garden_nm` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`garden_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `garden_mas`
--

INSERT INTO `garden_mas` (`garden_id`, `garden_nm`) VALUES
(1, 'KHOWANG'),
(2, 'RAJGARH'),
(3, 'TINKONG'),
(4, 'DESAM'),
(5, 'BASMATIA'),
(6, 'MURPHULANI'),
(7, 'HOOLUNGOOREE'),
(8, 'KARBALLA'),
(9, 'BANARHAT'),
(10, 'CHOONABHUTTI'),
(11, 'NEW DOOARS'),
(12, 'MIM'),
(13, 'HINGRIJAN'),
(14, 'YULE ORANGE'),
(15, 'DILLIBARI'),
(16, 'BHAMUN'),
(17, 'YULE GREEN'),
(18, 'BOGIJAN'),
(19, 'KHATISONA'),
(20, 'YULE BLACK'),
(21, 'KALASONA'),
(22, 'YULE DIAMOND'),
(23, 'YULE RED\r\n'),
(27, 'CD'),
(28, 'BOPF'),
(29, 'TGFOP(CL)'),
(30, 'STGFOP1\r'),
(31, 'SFTGFOP1\r'),
(32, 'GFBOP'),
(33, 'GFBOP1\r'),
(34, 'FOF'),
(35, 'BOP(OR)'),
(36, 'TGBOP');

-- --------------------------------------------------------

--
-- Table structure for table `grade_mas`
--

DROP TABLE IF EXISTS `grade_mas`;
CREATE TABLE IF NOT EXISTS `grade_mas` (
  `grade_id` int(5) NOT NULL AUTO_INCREMENT,
  `grade` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grade_mas`
--

INSERT INTO `grade_mas` (`grade_id`, `grade`) VALUES
(1, 'BOP'),
(2, 'BOPSM'),
(3, 'BP'),
(4, 'PF'),
(5, 'BP1\r\n'),
(6, 'BPS'),
(7, 'DUST'),
(8, 'D1'),
(9, 'FTGFOP1'),
(10, 'TGBOP1'),
(11, 'TGOF'),
(12, 'GOF'),
(13, 'BPS(OR)\r\n'),
(14, 'TGFOP1'),
(15, 'TGFOP'),
(16, 'GFOP'),
(17, 'FOP\r\n'),
(18, 'GFOP1\r\n'),
(19, 'GBOP\r\n'),
(20, 'GBOP1\r\n'),
(21, 'FBOP\r\n'),
(22, 'FBOP1\r\n'),
(23, 'OD(OR)'),
(32, 'OPD'),
(33, 'OD1'),
(34, 'CD'),
(35, 'BOPF'),
(36, 'TGFOP(CL)'),
(37, 'STGFOP1'),
(38, 'SFTGFOP1'),
(39, 'GFBOP'),
(40, 'GFBOP1'),
(41, 'FOF'),
(42, 'BOP(OR)'),
(43, 'TGBOP'),
(44, 'PD');

-- --------------------------------------------------------

--
-- Table structure for table `japanese_mas`
--

DROP TABLE IF EXISTS `japanese_mas`;
CREATE TABLE IF NOT EXISTS `japanese_mas` (
  `jap_id` int(5) NOT NULL AUTO_INCREMENT,
  `auc_id` int(5) NOT NULL,
  `jap_dt` date NOT NULL,
  `jap_start` time NOT NULL,
  `jap_end` time NOT NULL,
  PRIMARY KEY (`jap_id`),
  KEY `auc_id` (`auc_id`),
  KEY `jap_end` (`jap_end`),
  KEY `jap_start` (`jap_start`),
  KEY `jap_dt` (`jap_dt`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `japanese_mas`
--

INSERT INTO `japanese_mas` (`jap_id`, `auc_id`, `jap_dt`, `jap_start`, `jap_end`) VALUES
(1, 1, '2023-06-14', '12:00:00', '13:00:00'),
(2, 1, '2023-06-14', '13:00:00', '14:00:00'),
(3, 1, '2023-06-14', '14:00:00', '15:00:00'),
(4, 1, '2023-06-14', '15:00:00', '16:00:00'),
(5, 1, '2023-06-14', '16:00:00', '17:00:00'),
(6, 1, '2023-06-14', '17:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `location_mas`
--

DROP TABLE IF EXISTS `location_mas`;
CREATE TABLE IF NOT EXISTS `location_mas` (
  `loc_id` int(5) NOT NULL AUTO_INCREMENT,
  `loc_desc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`loc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location_mas`
--

INSERT INTO `location_mas` (`loc_id`, `loc_desc`) VALUES
(1, 'Ex- Garden'),
(2, 'Ex- Siliguri'),
(3, 'Ex-Guwahati'),
(4, 'Ex-Kolkata');

-- --------------------------------------------------------

--
-- Table structure for table `mailer_mas`
--

DROP TABLE IF EXISTS `mailer_mas`;
CREATE TABLE IF NOT EXISTS `mailer_mas` (
  `mid` int(5) NOT NULL AUTO_INCREMENT,
  `mail_nm` varchar(30) DEFAULT NULL,
  `mail_id` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mailer_mas`
--

INSERT INTO `mailer_mas` (`mid`, `mail_nm`, `mail_id`) VALUES
(1, 'Surajit Mondal', 'surajit@infotechsystems.in');

-- --------------------------------------------------------

--
-- Table structure for table `menu_mas`
--

DROP TABLE IF EXISTS `menu_mas`;
CREATE TABLE IF NOT EXISTS `menu_mas` (
  `menu_id` int(4) NOT NULL AUTO_INCREMENT,
  `parent_id` int(4) DEFAULT NULL,
  `murl` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `srl` int(4) DEFAULT NULL,
  `mbody` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_nm` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_tag` varchar(1) DEFAULT 'T',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu_mas`
--

INSERT INTO `menu_mas` (`menu_id`, `parent_id`, `murl`, `srl`, `mbody`, `icon_nm`, `show_tag`) VALUES
(1, 0, 'excel-upload.php', 2, 'Excel Upload', 'fa-file-excel-o', 'T'),
(2, 0, 'active-offersheet.php', 2, 'Open Offersheet', 'fa-calendar', 'T'),
(3, 0, NULL, 1, 'Master', 'fa-calendar', 'T'),
(4, 0, NULL, 3, 'Reports', 'fa-print', 'T'),
(5, 0, 'setting.php', 4, 'Settings', 'fa-cog', 'T'),
(6, 3, 'user-mas.php', 1, 'User Master', 'fa-user-md', 'T'),
(7, 6, 'user-insert.php', 1, 'Add', 'fa-plus', 'F'),
(8, 6, 'user-edit.php', 2, 'Edit', 'fa-edit', 'F'),
(9, 2, 'acive-offersheet-bid.php', 1, 'Bid', 'fa-tag', 'F'),
(10, 3, 'bidder-master.php', 2, 'Bidder Master', 'fa-university', 'T'),
(11, 10, 'bidder-edit.php', 1, 'Edit', 'fa-edit', 'F'),
(12, 0, 'knockdown-offersheet.php', 2, 'Knockdown Offersheet', 'fa-file-excel-o', 'T'),
(13, 3, 'loi-verification.php', 3, 'LOI Verification', 'fa-check', 'T'),
(14, 13, 'bidder-update.php', 1, 'Update', 'fa-check', 'F'),
(16, 0, 'knockdown-approval.php', 3, 'Knockdown Approval', 'fa-list', 'T'),
(17, 16, 'offersheet-bid-approval.php', 1, 'Approve', 'fa-check', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `offer_mas`
--

DROP TABLE IF EXISTS `offer_mas`;
CREATE TABLE IF NOT EXISTS `offer_mas` (
  `offer_id` int(5) NOT NULL AUTO_INCREMENT,
  `offer_nm` varchar(50) DEFAULT NULL,
  `offer_srl_id` int(5) DEFAULT NULL,
  `offer_start_time` datetime DEFAULT NULL,
  `offer_end_time` datetime DEFAULT NULL,
  `knockdown_start` datetime DEFAULT NULL,
  `knockdown_end` datetime DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `payment_type` varchar(25) DEFAULT NULL,
  `contract_type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`offer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `offer_mas`
--

INSERT INTO `offer_mas` (`offer_id`, `offer_nm`, `offer_srl_id`, `offer_start_time`, `offer_end_time`, `knockdown_start`, `knockdown_end`, `location`, `payment_type`, `contract_type`) VALUES
(1, NULL, 2, '2024-07-16 10:15:00', '2024-07-18 17:00:00', '2024-07-18 17:00:00', '2024-07-18 18:00:00', 'Ex-Guwahati', '14 DAYS', 'Cash & Carry');

-- --------------------------------------------------------

--
-- Table structure for table `offer_srl_mas`
--

DROP TABLE IF EXISTS `offer_srl_mas`;
CREATE TABLE IF NOT EXISTS `offer_srl_mas` (
  `offer_id` int(5) NOT NULL AUTO_INCREMENT,
  `place` varchar(20) DEFAULT NULL,
  `offer_srl` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`offer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `offer_srl_mas`
--

INSERT INTO `offer_srl_mas` (`offer_id`, `place`, `offer_srl`) VALUES
(1, 'DARJEELING', 9),
(2, 'ASSAM', 20),
(3, 'SILIGURI', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orgn_mas`
--

DROP TABLE IF EXISTS `orgn_mas`;
CREATE TABLE IF NOT EXISTS `orgn_mas` (
  `orgn_id` int(5) NOT NULL AUTO_INCREMENT,
  `orgn_code` varchar(10) DEFAULT NULL,
  `orgn_nm` varchar(50) DEFAULT NULL,
  `orgn_addr` text,
  `orgn_cont_no` varchar(10) DEFAULT NULL,
  `email_id` varchar(100) DEFAULT NULL,
  `gst_no` varchar(15) DEFAULT NULL,
  `old_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`orgn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orgn_mas`
--

INSERT INTO `orgn_mas` (`orgn_id`, `orgn_code`, `orgn_nm`, `orgn_addr`, `orgn_cont_no`, `email_id`, `gst_no`, `old_id`) VALUES
(1, 'T001', 'ANDREW YULE & COMPANY LTD', '8 DR R P SARANI KOLKATA - 700 001', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_type_mas`
--

DROP TABLE IF EXISTS `payment_type_mas`;
CREATE TABLE IF NOT EXISTS `payment_type_mas` (
  `pt_id` int(5) NOT NULL AUTO_INCREMENT,
  `pt_desc` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`pt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_type_mas`
--

INSERT INTO `payment_type_mas` (`pt_id`, `pt_desc`) VALUES
(1, '14 DAYS'),
(2, '30 DAYS');

-- --------------------------------------------------------

--
-- Table structure for table `reg_otp_mas`
--

DROP TABLE IF EXISTS `reg_otp_mas`;
CREATE TABLE IF NOT EXISTS `reg_otp_mas` (
  `otp_id` int(5) NOT NULL AUTO_INCREMENT,
  `email_id` varchar(100) DEFAULT NULL,
  `otp` varchar(4) DEFAULT NULL,
  `mobile_no` varchar(10) DEFAULT NULL,
  `motp` varchar(4) DEFAULT NULL,
  `otp_time` datetime DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`otp_id`),
  KEY `email_id` (`email_id`),
  KEY `otp` (`otp`),
  KEY `mobile_no` (`mobile_no`),
  KEY `motp` (`motp`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reg_otp_mas`
--

INSERT INTO `reg_otp_mas` (`otp_id`, `email_id`, `otp`, `mobile_no`, `motp`, `otp_time`, `status`) VALUES
(2, 'surajit@infotechsystems.in', '9576', NULL, NULL, '2023-06-19 14:39:33', 'D'),
(4, 'amitava.barat@gmail.com', '5069', NULL, NULL, '2023-06-19 14:46:40', 'A'),
(5, 'amitabha@infotechsystems.in', '8605', NULL, NULL, '2023-06-19 14:55:34', 'D'),
(6, 'surajitmondal19@gmail.com', '3054', '9051530165', '0250', '2024-01-09 16:51:28', 'D'),
(7, 'surajitmondal19@gmail.com', '1567', '9051530165', '6856', '2024-01-09 16:58:10', 'D'),
(8, 'surajitmondal19@gmail.com', '6905', '9051530165', '6353', '2024-01-09 17:13:53', 'D'),
(9, 'surajit@infotechsystems.in', '4744', '9051530165', '6114', '2024-01-09 17:15:06', 'D'),
(10, 'jaiswalaakash2020@gmail.com', '6101', '9903194887', '8487', '2024-01-11 11:40:39', 'A'),
(11, 'aakashjaiswal.xcs@gmail.com', '6972', '8240353924', '0058', '2024-01-11 18:31:03', 'A'),
(12, 'surajit@infotechsystems.in', '2127', '9051530165', '6662', '2024-01-29 11:17:24', 'D'),
(13, 'amitabha@infotechsystems.in', '2875', '9433764700', '5868', '2024-01-29 11:34:14', 'D'),
(14, 'amitabha@infotechsystems.in', '4190', '9433764700', '3954', '2024-01-29 11:35:55', 'D'),
(15, 'amitabha@infotechsystems.in', '9592', '9433764700', '2033', '2024-01-29 11:44:44', 'A'),
(16, 'rahulltiwarii0@gmail.com', '9444', '9007363351', '5344', '2024-01-30 12:30:16', 'D'),
(17, 'debajit.nag@andrewyule.com', '6104', '9051844469', '8460', '2024-01-30 13:31:50', 'A'),
(18, 'surajit@infotechsystems.in', '0433', '9051530165', '2958', '2024-01-31 13:39:45', 'D'),
(19, 'surajit@infotechsystems.in', '3088', '9051530165', '5973', '2024-01-31 14:02:01', 'D'),
(20, 'surajit@infotechsystems.in', '2576', '9051530165', '1764', '2024-01-31 14:38:26', 'D'),
(21, 'surajit@infotechsystems.in', '4963', '9051530165', '3148', '2024-01-31 14:38:27', 'D'),
(22, 'surajit@infotechsystems.in', '9744', '9051530165', '6283', '2024-01-31 14:39:19', 'D'),
(23, 'surajit@infotechsystems.in', '7057', '9051530165', '0818', '2024-01-31 14:40:54', 'D'),
(24, 'surajitmondal19@gmail.com', '7173', '7557010990', '5732', '2024-02-01 18:23:46', 'D'),
(25, 'surajitmondal19@gmail.com', '1458', '7557010990', '4039', '2024-02-01 18:26:11', 'D'),
(26, 'surajitmondal19@gmail.com', '6185', '7557010990', '1620', '2024-02-01 18:29:34', 'D'),
(27, 'surajitmondal19@gmail.com', '8581', '7557010990', '8179', '2024-02-05 12:15:23', 'A'),
(28, 'skyjaisw75@gmail.com', '9334', '8240353924', '3489', '2024-02-05 12:27:06', 'A'),
(29, 'contact@infotechsystems.in', '0482', '9830076207', '0921', '2024-03-11 13:13:40', 'A'),
(30, 'shahhimanshu0@gmail.com', '6431', '9831142101', '4084', '2024-03-21 15:44:54', 'D'),
(31, 'gopeshmittal82@gmail.com', '9192', '9332255867', '9759', '2024-03-21 20:05:44', 'A'),
(32, 'shahhimanshu0@gmail.com', '3808', '9831142101', '7500', '2024-03-23 13:32:55', 'D'),
(33, 'shahhimanshu0@gmail.com', '5225', '9831142101', '7822', '2024-03-26 13:48:25', 'A'),
(34, 'manojmanna@sumranagro.com', '0402', '9874456712', '8060', '2024-03-26 16:19:40', 'A'),
(35, 'dwarkadas07@yahoo.com', '0552', '7022312555', '9428', '2024-04-01 12:20:45', 'A'),
(36, 'info@morakhiagroup.com', '9653', '9428372730', '6977', '2024-04-02 17:39:47', 'A'),
(37, 'ayush_mintri@hotmail.com', '9719', '7065729341', '8947', '2024-04-03 09:50:16', 'D'),
(38, 'ayush_mintri@hotmail.com', '7099', '7065729341', '5056', '2024-04-03 15:32:51', 'A'),
(39, 'pratik@pjshah.in', '7395', '9836922240', '8309', '2024-04-04 11:19:19', 'A'),
(40, 'dundeshdhang83@gmail.com', '3953', '9448111189', '9093', '2024-04-04 16:42:14', 'D'),
(41, 'dundeshdhang83@gmail.com', '2178', '9448111189', '0302', '2024-04-04 16:43:30', 'A'),
(42, 'rakeshbhagat@newteaco.com', '9252', '9825039733', '8033', '2024-04-08 12:50:02', 'A'),
(43, 'utkalteaco@gmail.com', '3982', '7602402376', '0781', '2024-04-08 14:37:02', 'A'),
(44, 'Krunalmanek@gmail.com', '1383', '9679990975', '4945', '2024-04-09 16:44:12', 'D'),
(45, 'Krunalmanek@gmail.com', '6554', '9679990975', '3957', '2024-04-09 16:44:49', 'D'),
(46, 'Krunalmanek@gmail.com', '8303', '9679990975', '7794', '2024-04-09 16:45:11', 'D'),
(47, 'Krunalmanek@gmail.com', '3654', '9679990975', '8022', '2024-04-09 16:50:26', 'D'),
(48, 'Krunalmanek@gmail.com', '4928', '9679990975', '2271', '2024-04-09 16:50:53', 'D'),
(49, 'udeshyakmr@gmail.com', '6114', '7351766705', '6949', '2024-04-09 16:58:06', 'D'),
(50, 'Krunalmanek@gmail.com', '1610', '9679990975', '7754', '2024-04-09 16:59:08', 'D'),
(51, 'Krunalmanek@gmail.com', '8697', '9769990975', '4500', '2024-04-09 17:00:14', 'D'),
(52, 'Krunalmanek@gmail.com', '2528', '9679990975', '5621', '2024-04-09 17:01:23', 'D'),
(53, 'Krunalmanek@gmail.com', '8922', '9769990975', '6020', '2024-04-09 17:04:15', 'D'),
(54, 'krunalmanek@gmail.com', '5359', '9769990975', '4832', '2024-04-09 17:07:59', 'A'),
(55, 'udeshyakmr@gmail.com', '1624', '7351766705', '8298', '2024-04-09 18:10:04', 'D'),
(56, 'udeshyakmr@gmail.com', '7425', '7351766705', '9516', '2024-04-09 18:10:12', 'D'),
(57, 'udeshyakmr@gmail.com', '1589', '7351766705', '3942', '2024-04-09 18:10:13', 'D'),
(58, 'udeshyakmr@gmail.com', '8654', '7351766705', '0710', '2024-04-09 18:10:14', 'D'),
(59, 'udeshyakmr@gmail.com', '5061', '7351766705', '1500', '2024-04-09 18:10:14', 'D'),
(60, 'udeshyakmr@gmail.com', '6507', '7351766705', '2055', '2024-04-09 18:10:14', 'D'),
(61, 'udeshyakmr@gmail.com', '5626', '7351766705', '0647', '2024-04-09 18:12:15', 'D'),
(62, 'VIKASHTEA@YAHOO.IN', '1409', '9832190888', '3095', '2024-04-15 16:52:09', 'A'),
(63, 'udeshyakmr@gmail.com', '7765', '7351766705', '1962', '2024-04-15 17:06:45', 'D'),
(64, 'ksubhatirtha@gmail.com', '9801', '7449782411', '8219', '2024-04-15 17:49:28', 'A'),
(65, 'praveen.kothari@andrewyule.com', '7543', '8240112945', '8599', '2024-04-15 17:51:35', 'A'),
(66, 'souvikguin06@gmail.com', '6273', '7687044580', '6467', '2024-04-15 17:54:24', 'D'),
(67, 'rnp@andrewyule.com', '8089', '9003183790', '6638', '2024-04-15 17:56:28', 'A'),
(68, 'shubhankar.chakraborty@andrewyule.com', '6572', '9854168018', '9822', '2024-04-15 18:09:35', 'D'),
(69, 'shantanu.boral@andrewyule.com', '4310', '9831310812', '2163', '2024-04-15 18:14:15', 'A'),
(70, 'shubhankar.chakraborty@andrewyule.com', '8538', '8638740044', '8731', '2024-04-15 18:22:14', 'A'),
(71, 'subhodipdutta003@gmail.com', '8350', '8420383106', '1273', '2024-04-16 15:09:04', 'A'),
(72, 'surajit@infotechsystems.in', '6932', '9051530165', '8097', '2024-04-24 11:27:44', 'D'),
(73, 'surajit@infotechsystems.in', '1845', '9051530165', '2234', '2024-04-24 11:33:13', 'D'),
(74, 'surajit@gmail.com', '5982', '9051530165', '7813', '2024-04-24 11:37:56', 'D'),
(75, 'surajit@gmail.com', '8934', '9051530165', '7417', '2024-04-24 11:51:57', 'A'),
(76, 'surajit@infotechsystems.in', '2859', '9051530165', '9481', '2024-04-24 11:53:53', 'D'),
(77, 'udeshyakmr@gmail.com', '8904', '7351766705', '0585', '2024-04-24 12:24:50', 'A'),
(78, 'surajit@infotechsystems.in', '8200', '9051530165', '8774', '2024-04-24 17:46:28', 'A'),
(79, 'ss@gmail.com', '3454', '9051530165', '4211', '2024-04-24 17:47:08', 'A'),
(80, 'rahulltiwarii0@gmail.com', '5065', '9007363351', '0169', '2024-04-30 11:13:50', 'A'),
(81, 'udeshyakumar1995@gmail.com', '5221', '8240353924', '5401', '2024-04-30 11:27:39', 'A'),
(82, 'manchliya@gmail.com', '0809', '7775946097', '0868', '2024-07-02 11:42:30', 'A'),
(83, 'souvikguin06@gmail.com', '4073', '7687044580', '7342', '2024-07-16 11:23:16', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `show_hide_mas`
--

DROP TABLE IF EXISTS `show_hide_mas`;
CREATE TABLE IF NOT EXISTS `show_hide_mas` (
  `sh_id` int(5) NOT NULL AUTO_INCREMENT,
  `auc_id` int(5) DEFAULT NULL,
  `acd_id` int(5) DEFAULT NULL,
  `bidder_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`sh_id`),
  KEY `auc_id` (`auc_id`),
  KEY `acd_id` (`acd_id`),
  KEY `bidder_id` (`bidder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `soft_mas`
--

DROP TABLE IF EXISTS `soft_mas`;
CREATE TABLE IF NOT EXISTS `soft_mas` (
  `soft_id` int(5) NOT NULL AUTO_INCREMENT,
  `soft_nm` varchar(35) NOT NULL,
  `soft_abbr` varchar(12) NOT NULL,
  `message` text,
  PRIMARY KEY (`soft_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `soft_mas`
--

INSERT INTO `soft_mas` (`soft_id`, `soft_nm`, `soft_abbr`, `message`) VALUES
(1, 'Private Sale', 'Private Sale', 'Dear User, Welcome you to Andrew Yule Private Tea Sale Portal. ');

-- --------------------------------------------------------

--
-- Table structure for table `state_mas`
--

DROP TABLE IF EXISTS `state_mas`;
CREATE TABLE IF NOT EXISTS `state_mas` (
  `state_id` int(5) NOT NULL AUTO_INCREMENT,
  `state_nm` varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `state_code` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state_mas`
--

INSERT INTO `state_mas` (`state_id`, `state_nm`, `state_code`) VALUES
(1, 'Jammu & Kashmir', '01'),
(2, 'Himachal Pradesh', '02'),
(3, 'Punjab', '03'),
(4, 'Chandigarh', '04'),
(5, 'Uttarakhand', '05'),
(6, 'Haryana', '06'),
(7, 'Delhi', '07'),
(8, 'Rajasthan', '08'),
(9, 'Uttar Pradesh', '09'),
(10, 'Bihar', '10'),
(11, 'Sikkim', '11'),
(12, 'Arunachal Pradesh', '12'),
(13, 'Nagaland', '13'),
(14, 'Manipur', '14'),
(15, 'Mizoram', '15'),
(16, 'Tripura', '16'),
(17, 'Meghalaya', '17'),
(18, 'Assam', '18'),
(19, 'West Bengal', '19'),
(20, 'Jharkhand', '20'),
(21, 'Odisha', '21'),
(22, 'Chhattisgarh', '22'),
(23, 'Madhya Pradesh', '23'),
(24, 'Gujarat', '24'),
(25, 'Daman & Diu', '25'),
(26, 'Dadra & Nagar Haveli', '26'),
(27, 'Maharashtra', '27'),
(28, 'Karnataka', '29'),
(29, 'Goa', '30'),
(30, 'Lakshdweep', '31'),
(31, 'Kerala', '32'),
(32, 'Tamil Nadu', '33'),
(33, 'Pondicherry', '34'),
(34, 'Andaman & Nicobar Islands', '35'),
(35, 'Telengana', '36'),
(36, 'Andhra Pradesh', '37'),
(37, '- Other Territory', '98');

-- --------------------------------------------------------

--
-- Table structure for table `temp_mas`
--

DROP TABLE IF EXISTS `temp_mas`;
CREATE TABLE IF NOT EXISTS `temp_mas` (
  `temp_id` int(5) NOT NULL AUTO_INCREMENT,
  `offer_nm` varchar(50) DEFAULT NULL,
  `offer_no` varchar(50) DEFAULT NULL,
  `offer_start_time` datetime DEFAULT NULL,
  `offer_end_time` datetime DEFAULT NULL,
  `knockdown_start` datetime DEFAULT NULL,
  `knockdown_end` datetime DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `payment_type` varchar(25) DEFAULT NULL,
  `contract_type` varchar(25) DEFAULT NULL,
  `offer_srl_id` int(5) DEFAULT NULL,
  `lot` int(5) DEFAULT NULL,
  `garden` varchar(50) DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `invoice` varchar(20) NOT NULL,
  `gp_date` date NOT NULL,
  `chest` varchar(30) DEFAULT NULL,
  `net` decimal(2,0) DEFAULT NULL,
  `sold_pkgs` varchar(2) DEFAULT NULL,
  `valuation` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `msp` decimal(10,2) DEFAULT NULL,
  `tea_place` varchar(30) DEFAULT NULL,
  `sale_type` varchar(1) DEFAULT 'E',
  `frequently` int(5) DEFAULT NULL,
  `duration` varchar(3) DEFAULT NULL,
  `excel_path` text,
  PRIMARY KEY (`temp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
CREATE TABLE IF NOT EXISTS `user_log` (
  `ulog_id` int(5) NOT NULL AUTO_INCREMENT,
  `orgn_id` int(5) DEFAULT '1',
  `uid` int(5) DEFAULT NULL,
  `ip_addr` varchar(15) DEFAULT NULL,
  `date_fr` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  PRIMARY KEY (`ulog_id`),
  KEY `uid` (`uid`),
  KEY `date_fr` (`date_fr`)
) ENGINE=InnoDB AUTO_INCREMENT=322 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`ulog_id`, `orgn_id`, `uid`, `ip_addr`, `date_fr`, `date_to`) VALUES
(1, 1, 1, '::1', '2023-06-02 21:24:31', NULL),
(2, 1, 1, '::1', '2023-06-02 21:25:54', NULL),
(3, 1, 1, '::1', '2023-06-05 10:45:20', NULL),
(4, 1, 1, '::1', '2023-06-05 10:45:40', NULL),
(5, 1, 1, '::1', '2023-06-05 10:47:08', NULL),
(6, 1, 1, '::1', '2023-06-05 10:47:19', '2023-06-05 11:00:04'),
(7, 1, 1, '::1', '2023-06-05 14:37:49', '2023-06-05 14:44:50'),
(8, 1, 1, '::1', '2023-06-05 14:45:00', NULL),
(9, 1, 1, '::1', '2023-06-06 10:56:10', NULL),
(10, 1, 1, '::1', '2023-06-07 11:01:00', NULL),
(11, 1, 1, '::1', '2023-06-12 14:57:09', NULL),
(12, 1, 1, '::1', '2023-06-13 08:59:53', '2023-06-13 10:53:06'),
(13, 1, 1, '::1', '2023-06-13 10:53:16', NULL),
(14, 1, 1, '::1', '2023-06-13 12:26:25', '2023-06-13 18:21:27'),
(15, 1, 1, '::1', '2023-06-13 18:21:39', NULL),
(16, 1, 1, '::1', '2023-06-13 22:59:32', '2023-06-13 23:02:25'),
(17, 1, 1, '::1', '2023-06-14 10:13:46', '2023-06-14 16:39:46'),
(18, 1, 2, '::1', '2023-06-14 16:40:41', NULL),
(19, 1, 2, '::1', '2023-06-14 16:41:04', '2023-06-14 16:42:07'),
(20, 1, 1, '::1', '2023-06-14 16:42:20', '2023-06-14 16:42:32'),
(21, 1, 2, '::1', '2023-06-14 16:42:54', '2023-06-14 17:53:40'),
(22, 1, 2, '::1', '2023-06-14 17:54:08', NULL),
(23, 1, 2, '202.78.234.215', '2023-06-14 22:05:05', '2023-06-14 22:08:12'),
(24, 1, 2, '202.78.234.215', '2023-06-14 22:08:56', '2023-06-14 22:09:55'),
(25, 1, 1, '47.11.192.38', '2023-06-14 22:12:13', '2023-06-14 22:17:43'),
(26, 1, 2, '202.78.234.215', '2023-06-14 22:12:32', NULL),
(27, 1, 2, '47.11.7.42', '2023-06-15 10:08:29', '2023-06-15 10:26:43'),
(28, 1, 2, '47.11.25.100', '2023-06-15 10:27:19', NULL),
(29, 1, 2, '157.41.248.88', '2023-06-15 10:56:06', '2023-06-15 10:57:12'),
(30, 1, 2, '157.41.252.2', '2023-06-15 20:18:00', '2023-06-15 20:31:47'),
(31, 1, 2, '202.78.234.215', '2023-06-17 10:24:41', '2023-06-17 10:36:47'),
(32, 1, 2, '202.78.234.227', '2023-06-19 11:52:30', '2023-06-19 11:52:45'),
(33, 1, 1, '202.78.234.227', '2023-06-19 11:52:53', '2023-06-19 11:57:40'),
(34, 1, 5, '202.78.234.227', '2023-06-19 12:04:26', NULL),
(35, 1, 5, '202.78.234.227', '2023-06-19 12:05:37', '2023-06-19 12:05:47'),
(36, 1, 2, '202.78.234.227', '2023-06-19 12:10:55', '2023-06-19 12:12:55'),
(37, 1, 6, '49.37.45.66', '2023-06-19 14:49:00', NULL),
(38, 1, 6, '49.37.45.66', '2023-06-19 14:49:19', '2023-06-19 14:49:28'),
(39, 1, 1, '49.37.45.66', '2023-06-19 15:01:19', '2023-06-19 15:08:29'),
(40, 1, 5, '122.163.59.139', '2023-06-26 10:19:47', NULL),
(41, 1, 5, '122.176.26.116', '2023-07-04 10:57:18', NULL),
(42, 1, 1, '202.78.234.196', '2024-01-09 17:20:05', '2024-01-09 17:23:46'),
(43, 1, 7, '202.78.234.196', '2024-01-10 14:58:13', NULL),
(44, 1, 7, '202.78.234.196', '2024-01-10 14:58:50', '2024-01-10 14:59:07'),
(45, 1, 8, '122.163.105.50', '2024-01-11 11:42:07', NULL),
(46, 1, 8, '122.163.105.50', '2024-01-11 11:42:36', '2024-01-11 11:43:05'),
(47, 1, 1, '122.163.105.50', '2024-01-11 11:43:18', NULL),
(48, 1, 9, '103.50.83.208', '2024-01-29 11:21:29', '2024-01-29 11:26:42'),
(49, 1, 10, '49.37.44.229', '2024-01-29 11:55:55', '2024-01-29 11:57:05'),
(50, 1, 9, '103.50.83.208', '2024-01-29 11:56:36', '2024-01-29 12:17:00'),
(51, 1, 5, '49.37.44.229', '2024-01-29 11:57:16', '2024-01-29 12:07:29'),
(52, 1, 10, '49.37.44.229', '2024-01-29 12:03:52', '2024-01-29 12:19:18'),
(53, 1, 5, '49.37.44.229', '2024-01-29 12:07:35', '2024-01-29 12:11:47'),
(54, 1, 1, '103.50.83.208', '2024-01-29 12:17:09', '2024-01-29 12:19:47'),
(55, 1, 5, '122.176.26.116', '2024-01-30 12:36:42', '2024-01-30 13:27:04'),
(56, 1, 10, '122.176.26.116', '2024-01-30 12:54:59', NULL),
(57, 1, 8, '223.229.146.11', '2024-01-30 12:57:18', NULL),
(58, 1, 5, '122.176.26.116', '2024-01-30 13:35:15', '2024-01-30 14:23:15'),
(59, 1, 10, '122.176.26.116', '2024-01-30 13:51:46', '2024-01-30 13:54:02'),
(60, 1, 12, '122.176.26.116', '2024-01-30 13:54:40', '2024-01-30 14:30:56'),
(61, 1, 5, '122.176.26.116', '2024-01-30 14:25:21', '2024-01-30 14:30:40'),
(62, 1, 1, '202.78.234.185', '2024-01-31 22:39:36', NULL),
(63, 1, 1, '202.78.234.185', '2024-02-01 12:31:52', '2024-02-01 12:43:39'),
(64, 1, 18, '202.78.234.185', '2024-02-01 12:43:55', '2024-02-01 12:53:15'),
(65, 1, 10, '49.37.40.37', '2024-02-01 12:44:36', '2024-02-01 12:53:09'),
(66, 1, 18, '202.78.234.185', '2024-02-01 14:35:52', '2024-02-01 15:03:18'),
(67, 1, 10, '49.37.40.37', '2024-02-01 14:44:12', NULL),
(68, 1, 10, '49.37.40.37', '2024-02-01 14:46:35', '2024-02-01 14:49:26'),
(69, 1, 10, '49.37.40.37', '2024-02-01 14:49:44', '2024-02-01 15:01:44'),
(70, 1, 18, '202.78.234.185', '2024-02-01 18:17:36', '2024-02-01 18:22:35'),
(71, 1, 8, '223.229.146.11', '2024-02-01 19:14:18', '2024-02-01 19:18:01'),
(72, 1, 8, '223.229.146.11', '2024-02-01 19:18:04', '2024-02-01 19:35:05'),
(73, 1, 5, '223.229.146.11', '2024-02-01 19:35:20', NULL),
(74, 1, 18, '202.78.234.185', '2024-02-01 20:26:55', '2024-02-01 20:27:26'),
(75, 1, 5, '223.229.146.11', '2024-02-02 14:39:25', '2024-02-02 14:47:13'),
(76, 1, 8, '223.229.146.11', '2024-02-02 14:47:17', NULL),
(77, 1, 5, '223.229.146.11', '2024-02-02 14:56:05', NULL),
(78, 1, 1, '202.78.234.185', '2024-02-02 17:21:35', '2024-02-02 17:24:20'),
(79, 1, 18, '202.78.234.185', '2024-02-02 17:24:47', '2024-02-02 17:25:34'),
(80, 1, 1, '202.78.234.185', '2024-02-02 17:26:18', NULL),
(81, 1, 5, '223.229.146.11', '2024-02-02 17:52:36', NULL),
(82, 1, 1, '202.78.234.185', '2024-02-03 11:24:27', NULL),
(83, 1, 1, '202.78.234.185', '2024-02-03 11:24:28', '2024-02-03 11:27:21'),
(84, 1, 18, '202.78.234.185', '2024-02-03 11:27:44', '2024-02-03 11:34:24'),
(85, 1, 10, '49.37.42.139', '2024-02-03 11:30:25', '2024-02-03 11:33:01'),
(86, 1, 5, '49.37.42.139', '2024-02-03 11:33:10', '2024-02-03 11:33:40'),
(87, 1, 8, '122.176.26.116', '2024-02-05 11:58:03', NULL),
(88, 1, 1, '47.11.202.205', '2024-02-05 12:01:30', NULL),
(89, 1, 1, '47.11.202.205', '2024-02-05 12:01:31', '2024-02-05 12:14:30'),
(90, 1, 8, '152.58.181.216', '2024-02-05 12:19:40', '2024-02-05 13:07:22'),
(91, 1, 11, '110.224.108.80', '2024-02-05 12:19:51', NULL),
(92, 1, 8, '122.176.26.101', '2024-02-05 12:35:10', '2024-02-05 13:09:23'),
(93, 1, 12, '171.60.205.140', '2024-02-05 13:08:11', NULL),
(94, 1, 8, '122.176.26.101', '2024-02-05 13:10:11', NULL),
(95, 1, 12, '122.176.26.116', '2024-02-07 11:37:16', NULL),
(96, 1, 5, '223.235.125.222', '2024-02-09 11:56:35', NULL),
(97, 1, 8, '152.58.178.1', '2024-02-09 12:04:29', NULL),
(98, 1, 5, '122.176.26.101', '2024-02-09 12:06:00', '2024-02-09 12:22:37'),
(99, 1, 8, '122.176.26.101', '2024-02-09 12:22:59', '2024-02-09 12:39:18'),
(100, 1, 12, '223.191.48.166', '2024-02-09 13:39:49', NULL),
(101, 1, 12, '223.191.48.166', '2024-02-09 13:42:47', NULL),
(102, 1, 12, '122.176.26.116', '2024-02-09 13:45:12', NULL),
(103, 1, 5, '171.79.91.94', '2024-02-13 16:31:13', '2024-02-13 16:35:48'),
(104, 1, 8, '171.79.91.94', '2024-02-13 16:35:56', NULL),
(105, 1, 8, '223.226.79.106', '2024-02-27 13:08:52', '2024-02-27 13:09:10'),
(106, 1, 5, '49.37.47.6', '2024-03-05 14:16:53', '2024-03-05 14:18:07'),
(107, 1, 5, '122.176.26.101', '2024-03-05 14:20:17', '2024-03-05 14:22:23'),
(108, 1, 5, '122.176.26.101', '2024-03-11 10:10:13', NULL),
(109, 1, 5, '110.225.31.195', '2024-03-11 10:10:45', '2024-03-11 10:11:08'),
(110, 1, 19, '49.37.45.40', '2024-03-11 13:23:10', '2024-03-11 13:42:50'),
(111, 1, 5, '49.37.45.40', '2024-03-11 13:24:07', '2024-03-11 13:35:33'),
(112, 1, 6, '49.37.45.40', '2024-03-11 13:35:47', '2024-03-11 13:37:46'),
(113, 1, 5, '110.225.31.195', '2024-03-11 14:46:56', NULL),
(114, 1, 5, '110.225.31.195', '2024-03-12 10:52:40', NULL),
(115, 1, 5, '122.176.26.101', '2024-03-15 17:07:54', NULL),
(116, 1, 5, '110.225.31.195', '2024-03-18 12:13:23', NULL),
(117, 1, 5, '110.225.31.195', '2024-03-21 11:03:21', NULL),
(118, 1, 5, '110.225.31.195', '2024-03-21 15:34:02', NULL),
(119, 1, 5, '110.225.31.195', '2024-03-21 17:02:13', '2024-03-21 17:02:41'),
(120, 1, 5, '110.225.31.195', '2024-03-22 09:39:04', '2024-03-22 09:39:41'),
(121, 1, 5, '110.225.31.195', '2024-03-22 11:04:42', NULL),
(122, 1, 5, '110.225.31.195', '2024-03-22 17:15:15', '2024-03-22 17:16:16'),
(123, 1, 5, '110.225.31.195', '2024-03-26 09:33:19', NULL),
(124, 1, 20, '157.119.107.210', '2024-03-26 16:27:18', '2024-03-26 16:30:09'),
(125, 1, 20, '157.119.107.210', '2024-03-26 16:32:08', '2024-03-26 16:33:20'),
(126, 1, 5, '110.225.31.195', '2024-04-01 10:14:18', NULL),
(127, 1, 5, '110.225.31.195', '2024-04-01 12:15:40', NULL),
(128, 1, 5, '110.225.31.195', '2024-04-01 14:46:50', NULL),
(129, 1, 5, '110.225.31.195', '2024-04-01 17:12:57', NULL),
(130, 1, 5, '122.176.26.101', '2024-04-02 09:29:16', NULL),
(131, 1, 5, '110.225.31.195', '2024-04-02 12:45:26', NULL),
(132, 1, 22, '103.86.19.153', '2024-04-02 18:25:15', NULL),
(133, 1, 5, '110.225.31.195', '2024-04-03 10:11:01', NULL),
(134, 1, 5, '110.225.31.195', '2024-04-03 16:09:01', NULL),
(135, 1, 5, '110.225.31.195', '2024-04-04 09:26:56', NULL),
(136, 1, 5, '122.176.26.101', '2024-04-04 11:26:34', NULL),
(137, 1, 5, '110.225.31.195', '2024-04-04 16:47:36', NULL),
(138, 1, 24, '157.45.85.138', '2024-04-04 16:51:09', '2024-04-04 16:52:54'),
(139, 1, 5, '110.225.31.195', '2024-04-08 09:33:05', NULL),
(140, 1, 25, '122.173.75.114', '2024-04-08 12:55:44', NULL),
(141, 1, 5, '110.225.31.195', '2024-04-08 13:34:43', NULL),
(142, 1, 5, '110.225.31.195', '2024-04-08 14:32:22', NULL),
(143, 1, 5, '110.225.31.195', '2024-04-08 16:00:51', NULL),
(144, 1, 5, '110.225.31.195', '2024-04-08 16:50:40', NULL),
(145, 1, 5, '110.225.31.195', '2024-04-09 09:37:31', NULL),
(146, 1, 5, '110.225.31.195', '2024-04-09 13:35:47', NULL),
(147, 1, 5, '110.225.31.195', '2024-04-09 15:30:19', NULL),
(148, 1, 5, '110.225.31.195', '2024-04-09 16:20:36', '2024-04-09 16:57:35'),
(149, 1, 5, '110.225.31.195', '2024-04-09 18:06:30', '2024-04-09 18:08:39'),
(150, 1, 5, '110.225.31.195', '2024-04-10 09:30:01', NULL),
(151, 1, 5, '106.213.4.241', '2024-04-15 16:59:01', '2024-04-15 17:06:18'),
(152, 1, 26, '103.89.170.173', '2024-04-15 17:04:16', NULL),
(153, 1, 29, '106.213.4.241', '2024-04-15 17:54:32', '2024-04-15 17:55:17'),
(154, 1, 5, '106.213.4.241', '2024-04-15 17:59:49', NULL),
(155, 1, 31, '106.213.4.241', '2024-04-15 18:01:02', NULL),
(156, 1, 31, '106.213.4.241', '2024-04-15 18:05:33', NULL),
(157, 1, 32, '106.213.4.241', '2024-04-15 18:20:17', NULL),
(158, 1, 8, '106.213.4.241', '2024-04-16 11:01:58', '2024-04-16 11:02:18'),
(159, 1, 5, '106.213.4.241', '2024-04-16 11:02:30', NULL),
(160, 1, 29, '106.213.4.241', '2024-04-16 14:59:39', NULL),
(161, 1, 5, '106.213.4.241', '2024-04-16 15:07:22', '2024-04-16 15:10:43'),
(162, 1, 27, '106.213.4.241', '2024-04-16 15:11:12', '2024-04-16 15:11:26'),
(163, 1, 5, '106.213.4.241', '2024-04-16 15:13:06', '2024-04-16 15:45:33'),
(164, 1, 34, '106.213.4.241', '2024-04-16 15:13:41', NULL),
(165, 1, 11, '106.213.4.241', '2024-04-16 15:14:00', NULL),
(166, 1, 5, '106.213.4.241', '2024-04-16 15:20:38', NULL),
(167, 1, 27, '106.213.4.241', '2024-04-16 15:45:48', '2024-04-16 15:46:16'),
(168, 1, 11, '106.213.4.241', '2024-04-16 15:46:03', '2024-04-16 16:14:51'),
(169, 1, 5, '106.213.4.241', '2024-04-16 16:13:06', '2024-04-16 16:14:25'),
(170, 1, 27, '106.213.4.241', '2024-04-16 16:14:36', '2024-04-16 16:14:44'),
(171, 1, 11, '106.213.4.241', '2024-04-16 16:14:54', NULL),
(172, 1, 31, '106.213.4.241', '2024-04-16 16:20:59', NULL),
(173, 1, 34, '106.213.4.241', '2024-04-16 16:21:25', NULL),
(174, 1, 27, '106.213.4.241', '2024-04-16 16:31:12', '2024-04-16 16:49:06'),
(175, 1, 5, '106.213.4.241', '2024-04-16 16:49:13', '2024-04-16 16:51:10'),
(176, 1, 27, '106.213.4.241', '2024-04-16 16:51:27', NULL),
(177, 1, 34, '106.213.4.241', '2024-04-16 17:10:50', '2024-04-16 17:38:53'),
(178, 1, 27, '106.213.4.241', '2024-04-16 17:44:37', NULL),
(179, 1, 1, '49.37.45.212', '2024-04-18 16:28:40', '2024-04-18 16:32:48'),
(180, 1, 1, '202.78.234.181', '2024-04-19 11:36:42', '2024-04-19 11:37:04'),
(181, 1, 5, '106.213.4.241', '2024-04-19 17:18:19', '2024-04-19 17:19:03'),
(182, 1, 1, '202.78.234.181', '2024-04-22 15:13:34', '2024-04-22 15:14:17'),
(183, 1, 18, '202.78.234.181', '2024-04-22 15:15:44', NULL),
(184, 1, 6, '49.37.45.28', '2024-04-22 15:22:36', '2024-04-22 15:28:39'),
(185, 1, 5, '110.225.3.85', '2024-04-23 13:47:12', '2024-04-23 13:50:28'),
(186, 1, 5, '110.225.3.85', '2024-04-23 15:01:29', NULL),
(187, 1, 27, '110.225.3.85', '2024-04-23 15:38:33', '2024-04-23 15:38:49'),
(188, 1, 27, '110.225.3.85', '2024-04-23 16:02:41', '2024-04-23 16:21:40'),
(189, 1, 8, '110.225.3.85', '2024-04-23 16:03:06', '2024-04-23 16:08:00'),
(190, 1, 1, '157.40.240.86', '2024-04-23 16:05:22', '2024-04-23 16:11:22'),
(191, 1, 8, '110.225.3.85', '2024-04-23 16:08:02', '2024-04-23 16:37:48'),
(192, 1, 11, '110.225.3.85', '2024-04-23 16:09:54', '2024-04-23 16:23:33'),
(193, 1, 27, '110.225.3.85', '2024-04-23 16:22:43', NULL),
(194, 1, 11, '110.225.3.85', '2024-04-23 16:23:35', '2024-04-23 16:59:56'),
(195, 1, 6, '49.37.45.76', '2024-04-23 16:32:32', '2024-04-23 16:35:09'),
(196, 1, 8, '110.225.3.85', '2024-04-23 16:37:53', '2024-04-23 16:37:56'),
(197, 1, 5, '110.225.3.85', '2024-04-23 16:38:00', '2024-04-23 16:43:34'),
(198, 1, 1, '49.37.45.76', '2024-04-23 16:39:09', '2024-04-23 16:40:27'),
(199, 1, 1, '49.37.45.76', '2024-04-23 16:41:10', '2024-04-23 16:41:36'),
(200, 1, 1, '49.37.45.76', '2024-04-23 16:44:06', '2024-04-23 16:46:36'),
(201, 1, 5, '110.225.3.85', '2024-04-23 16:44:21', '2024-04-23 16:45:55'),
(202, 1, 8, '110.225.3.85', '2024-04-23 16:45:59', '2024-04-23 16:47:18'),
(203, 1, 8, '49.37.45.76', '2024-04-23 16:51:05', '2024-04-23 16:53:31'),
(204, 1, 8, '110.225.3.85', '2024-04-23 16:57:33', '2024-04-23 16:59:24'),
(205, 1, 8, '110.225.3.85', '2024-04-23 16:59:29', NULL),
(206, 1, 11, '110.225.3.85', '2024-04-23 16:59:58', NULL),
(207, 1, 8, '49.37.45.76', '2024-04-23 17:01:10', '2024-04-23 17:02:30'),
(208, 1, 27, '110.225.3.85', '2024-04-24 12:25:42', '2024-04-24 12:25:50'),
(209, 1, 5, '122.176.26.101', '2024-04-24 13:58:39', NULL),
(210, 1, 5, '122.176.26.101', '2024-04-26 14:54:42', NULL),
(211, 1, 1, '202.78.234.181', '2024-04-26 14:58:54', NULL),
(212, 1, 1, '202.78.234.181', '2024-04-26 14:58:54', '2024-04-26 15:10:24'),
(213, 1, 1, '202.78.234.181', '2024-04-27 15:50:59', NULL),
(214, 1, 5, '122.176.26.101', '2024-04-29 13:45:03', NULL),
(215, 1, 5, '110.225.3.85', '2024-04-30 10:45:02', '2024-04-30 11:05:51'),
(216, 1, 8, '110.225.3.85', '2024-04-30 11:05:56', '2024-04-30 11:07:01'),
(217, 1, 27, '110.225.3.85', '2024-04-30 11:06:57', '2024-04-30 11:13:27'),
(218, 1, 8, '110.225.3.85', '2024-04-30 11:07:03', '2024-04-30 11:07:08'),
(219, 1, 5, '110.225.3.85', '2024-04-30 11:07:17', '2024-04-30 11:08:11'),
(220, 1, 8, '110.225.3.85', '2024-04-30 11:08:16', '2024-04-30 11:08:42'),
(221, 1, 5, '110.225.3.85', '2024-04-30 11:08:51', '2024-04-30 11:10:21'),
(222, 1, 8, '110.225.3.85', '2024-04-30 11:10:25', '2024-04-30 11:18:14'),
(223, 1, 34, '110.225.3.85', '2024-04-30 11:11:18', NULL),
(224, 1, 27, '110.225.3.85', '2024-04-30 11:13:46', '2024-04-30 11:23:03'),
(225, 1, 1, '122.176.26.116', '2024-04-30 11:14:21', '2024-04-30 11:28:16'),
(226, 1, 11, '172.225.219.25', '2024-04-30 11:15:22', NULL),
(227, 1, 27, '110.224.101.59', '2024-04-30 11:16:21', '2024-04-30 11:18:55'),
(228, 1, 8, '110.225.3.85', '2024-04-30 11:18:34', '2024-04-30 11:18:59'),
(229, 1, 8, '110.225.3.85', '2024-04-30 11:19:01', '2024-04-30 11:19:08'),
(230, 1, 8, '110.225.3.85', '2024-04-30 11:19:17', '2024-04-30 11:22:45'),
(231, 1, 11, '110.225.3.85', '2024-04-30 11:22:49', '2024-04-30 11:26:33'),
(232, 1, 8, '110.225.3.85', '2024-04-30 11:22:51', '2024-04-30 11:40:43'),
(233, 1, 27, '122.176.26.116', '2024-04-30 11:23:15', NULL),
(234, 1, 35, '110.225.3.85', '2024-04-30 11:32:26', '2024-04-30 11:45:29'),
(235, 1, 5, '110.225.3.85', '2024-04-30 11:41:11', NULL),
(236, 1, 8, '110.224.106.116', '2024-04-30 11:44:19', '2024-04-30 11:45:19'),
(237, 1, 5, '110.225.3.85', '2024-04-30 11:45:37', '2024-04-30 11:47:19'),
(238, 1, 8, '110.225.3.85', '2024-04-30 11:47:45', '2024-04-30 12:45:07'),
(239, 1, 1, '122.176.26.116', '2024-04-30 12:38:40', '2024-04-30 12:50:17'),
(240, 1, 27, '122.176.26.116', '2024-04-30 12:44:24', NULL),
(241, 1, 5, '110.225.3.85', '2024-04-30 12:45:16', '2024-04-30 13:05:44'),
(242, 1, 1, '122.176.26.116', '2024-04-30 12:50:32', '2024-04-30 13:02:58'),
(243, 1, 6, '49.37.45.252', '2024-05-03 12:06:56', NULL),
(244, 1, 1, '202.78.234.181', '2024-05-03 12:07:23', '2024-05-03 12:08:44'),
(245, 1, 18, '202.78.234.181', '2024-05-03 12:09:07', NULL),
(246, 1, 1, '202.78.234.181', '2024-05-03 13:03:23', '2024-05-03 13:06:08'),
(247, 1, 18, '202.78.234.181', '2024-05-03 13:06:30', NULL),
(248, 1, 6, '49.37.45.252', '2024-05-03 13:49:10', '2024-05-03 14:01:18'),
(249, 1, 18, '202.78.234.181', '2024-05-03 13:52:28', '2024-05-03 14:16:38'),
(250, 1, 6, '49.37.45.88', '2024-05-06 10:40:00', '2024-05-06 10:40:38'),
(251, 1, 1, '202.78.234.181', '2024-05-07 15:39:15', NULL),
(252, 1, 1, '202.78.234.81', '2024-05-13 22:20:44', '2024-05-13 22:32:24'),
(253, 1, 18, '202.78.234.81', '2024-05-13 22:32:55', '2024-05-13 22:33:25'),
(254, 1, 1, '202.78.234.81', '2024-05-13 22:33:34', '2024-05-13 22:35:16'),
(255, 1, 37, '202.78.234.81', '2024-05-13 22:35:54', '2024-05-13 22:45:04'),
(256, 1, 1, '202.78.234.81', '2024-05-13 22:45:15', '2024-05-13 22:46:23'),
(257, 1, 18, '202.78.234.81', '2024-05-13 22:46:42', '2024-05-13 22:49:47'),
(258, 1, 1, '202.78.234.81', '2024-05-13 22:49:58', '2024-05-13 22:53:19'),
(259, 1, 37, '202.78.234.81', '2024-05-13 22:53:28', NULL),
(260, 1, 37, '202.78.234.81', '2024-05-13 23:13:19', '2024-05-13 23:19:36'),
(261, 1, 6, '122.176.26.116', '2024-05-14 15:07:33', '2024-05-14 15:12:41'),
(262, 1, 1, '122.176.26.116', '2024-05-14 15:12:53', '2024-05-14 15:17:48'),
(263, 1, 27, '122.176.26.116', '2024-05-14 15:17:02', NULL),
(264, 1, 1, '122.176.26.116', '2024-05-14 15:18:00', '2024-05-14 15:18:23'),
(265, 1, 6, '122.176.26.116', '2024-05-14 15:18:47', '2024-05-14 15:44:13'),
(266, 1, 8, '122.163.108.160', '2024-05-14 15:21:00', '2024-05-14 15:53:19'),
(267, 1, 11, '172.225.219.66', '2024-05-14 15:23:02', NULL),
(268, 1, 1, '122.176.26.116', '2024-05-14 15:44:23', NULL),
(269, 1, 8, '110.224.110.17', '2024-05-14 15:44:44', NULL),
(270, 1, 27, '110.224.107.227', '2024-05-14 15:47:12', NULL),
(271, 1, 6, '157.40.124.56', '2024-05-14 15:48:31', '2024-05-14 16:04:12'),
(272, 1, 5, '122.163.108.160', '2024-05-14 15:53:30', '2024-05-14 16:11:04'),
(273, 1, 1, '157.40.124.56', '2024-05-14 16:04:30', NULL),
(274, 1, 37, '122.163.108.160', '2024-05-14 16:11:18', '2024-05-14 16:16:45'),
(275, 1, 5, '122.163.108.160', '2024-05-14 16:16:55', '2024-05-14 16:18:53'),
(276, 1, 1, '49.37.45.116', '2024-05-15 12:45:52', '2024-05-15 12:48:26'),
(277, 1, 1, '103.50.83.214', '2024-05-30 23:15:41', '2024-05-30 23:19:45'),
(278, 1, 1, '103.50.83.214', '2024-05-30 23:20:07', '2024-05-30 23:20:24'),
(279, 1, 18, '103.50.83.214', '2024-05-30 23:21:20', NULL),
(280, 1, 18, '103.50.83.214', '2024-05-30 23:22:57', NULL),
(281, 1, 6, '49.37.45.28', '2024-05-31 10:17:45', '2024-05-31 10:20:53'),
(282, 1, 1, '49.37.45.28', '2024-05-31 10:20:58', '2024-05-31 10:22:06'),
(283, 1, 5, '110.227.72.53', '2024-06-28 11:35:48', NULL),
(284, 1, 5, '110.227.72.53', '2024-07-01 17:09:06', NULL),
(285, 1, 5, '110.227.72.53', '2024-07-01 17:09:41', NULL),
(286, 1, 5, '110.227.72.53', '2024-07-02 12:37:59', NULL),
(287, 1, 5, '223.236.250.12', '2024-07-11 15:47:15', NULL),
(288, 1, 5, '106.213.17.6', '2024-07-15 15:31:08', '2024-07-15 15:37:37'),
(289, 1, 5, '106.213.17.6', '2024-07-15 17:35:38', NULL),
(290, 1, 1, '202.78.234.168', '2024-07-15 17:57:03', '2024-07-15 18:15:27'),
(291, 1, 5, '106.213.17.6', '2024-07-15 18:35:15', '2024-07-15 18:43:57'),
(292, 1, 1, '202.78.234.168', '2024-07-15 18:50:47', '2024-07-15 19:39:43'),
(293, 1, 5, '110.224.109.52', '2024-07-15 20:40:40', NULL),
(294, 1, 5, '157.40.162.86', '2024-07-15 23:19:20', '2024-07-15 23:24:07'),
(295, 1, 5, '106.213.17.6', '2024-07-16 09:48:30', NULL),
(296, 1, 5, '106.213.17.6', '2024-07-16 09:52:51', '2024-07-16 09:54:00'),
(297, 1, 5, '106.213.17.6', '2024-07-16 09:54:07', NULL),
(298, 1, 5, '106.213.17.6', '2024-07-16 09:56:22', NULL),
(299, 1, 5, '106.213.17.6', '2024-07-16 09:59:21', NULL),
(300, 1, 5, '106.213.17.6', '2024-07-16 10:08:59', '2024-07-16 10:10:44'),
(301, 1, 27, '106.213.17.6', '2024-07-16 10:10:59', NULL),
(302, 1, 5, '106.213.17.6', '2024-07-16 10:31:53', NULL),
(303, 1, 5, '106.213.17.6', '2024-07-16 11:12:10', '2024-07-16 11:12:31'),
(304, 1, 27, '106.213.17.6', '2024-07-16 11:13:12', '2024-07-16 11:13:18'),
(305, 1, 5, '106.213.17.6', '2024-07-16 11:13:26', '2024-07-16 11:13:58'),
(306, 1, 27, '106.213.17.6', '2024-07-16 11:14:28', NULL),
(307, 1, 23, '49.37.44.163', '2024-07-16 11:14:53', NULL),
(308, 1, 5, '106.213.17.6', '2024-07-16 11:15:05', '2024-07-16 11:16:19'),
(309, 1, 23, '49.37.44.163', '2024-07-16 11:22:30', NULL),
(310, 1, 30, '106.213.17.6', '2024-07-16 11:24:10', '2024-07-16 11:28:26'),
(311, 1, 27, '106.213.17.6', '2024-07-16 12:09:42', '2024-07-16 12:14:55'),
(312, 1, 5, '106.213.17.6', '2024-07-16 12:15:17', NULL),
(313, 1, 27, '106.213.17.6', '2024-07-16 12:17:59', '2024-07-16 12:57:17'),
(314, 1, 5, '106.213.17.6', '2024-07-16 12:57:23', NULL),
(315, 1, 6, '49.37.41.134', '2024-07-16 14:12:50', '2024-07-16 14:13:39'),
(316, 1, 1, '49.37.41.134', '2024-07-16 14:13:50', '2024-07-16 14:14:19'),
(317, 1, 5, '106.213.17.6', '2024-07-16 14:52:48', NULL),
(318, 1, 5, '117.200.236.201', '2024-07-16 14:52:51', '2024-07-16 15:04:41'),
(319, 1, 6, '49.37.41.134', '2024-07-16 15:18:57', '2024-07-16 15:23:28'),
(320, 1, 5, '49.37.41.134', '2024-07-16 15:23:43', NULL),
(321, 1, 1, '202.78.234.168', '2024-07-16 15:28:44', '2024-07-16 15:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_mas`
--

DROP TABLE IF EXISTS `user_mas`;
CREATE TABLE IF NOT EXISTS `user_mas` (
  `uid` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `password` text,
  `cell_no` varchar(10) DEFAULT NULL,
  `status` varchar(1) DEFAULT 'A',
  `user_type` varchar(1) DEFAULT 'B',
  `page_assign` text,
  `token` text,
  `otp_req` varchar(1) DEFAULT 'N',
  `otp` varchar(4) DEFAULT NULL,
  `mail_req` varchar(1) DEFAULT 'N',
  `mail_otp` varchar(4) DEFAULT NULL,
  `orgn_id` int(5) DEFAULT '1',
  `bidder_id` int(5) DEFAULT NULL,
  `design_nm` varchar(50) DEFAULT NULL,
  `committee` varchar(1) NOT NULL DEFAULT 'N',
  `com_srl` int(5) DEFAULT NULL,
  `signature` text,
  PRIMARY KEY (`uid`),
  KEY `user_id` (`user_id`),
  KEY `orgn_id` (`orgn_id`),
  KEY `bidder_id` (`bidder_id`),
  KEY `committee` (`committee`),
  KEY `com_srl` (`com_srl`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_mas`
--

INSERT INTO `user_mas` (`uid`, `user_id`, `user_name`, `password`, `cell_no`, `status`, `user_type`, `page_assign`, `token`, `otp_req`, `otp`, `mail_req`, `mail_otp`, `orgn_id`, `bidder_id`, `design_nm`, `committee`, `com_srl`, `signature`) VALUES
(1, 'info', 'Developer Team', '$2y$10$MTfD2UT9yfgZFzJzslt4Z.2N.5AZyG9awOglvYM9OezHONWU/eH/q', NULL, 'A', 'A', NULL, NULL, 'N', NULL, 'N', NULL, 1, 0, NULL, 'N', NULL, NULL),
(3, 'suraji', 'SU', '$2y$10$dS.lp7ikUPBdDPs6SbSTzOHALhQgas8ZwJMv9JB9TrnRlK2k5RP2e', '9051530165', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, NULL, 0, NULL, 'N', NULL, NULL),
(5, 'admin', 'System Administrator', '$2y$10$MTfD2UT9yfgZFzJzslt4Z.2N.5AZyG9awOglvYM9OezHONWU/eH/q', NULL, 'A', 'A', NULL, '251308703599ab31199487481d9d1869', 'N', NULL, 'N', NULL, 1, NULL, NULL, 'N', NULL, NULL),
(6, 'amitava.barat@gmail.com', 'AMITABHA BARAT', '$2y$10$lJJcgJkYi9L8qLEPL9Eyjuxy3UoMbRDrkj7pcWUaq3GCOwBjA6VIu', '9830076207', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 3, NULL, 'N', NULL, NULL),
(8, 'jaiswalaakash2020@gmail.com', 'AJ', '$2y$10$O3sXam68Q6TkDn0aZ9qccOrWl4gE6QZggok5o8vTcnmZtxzGIpTTG', '9903194887', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 5, NULL, 'N', NULL, NULL),
(10, 'amitabha@infotechsystems.in', 'AMITABHA', '$2y$10$gO.leWrArVC5ctK76PYw1.K5E/ydid8amhzloVAwCo7MJdU1i07wy', '9433764700', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 7, NULL, 'N', NULL, NULL),
(11, 'rahulltiwarii0@gmail.com', 'DEMO CO', '$2y$10$ZsJn96JCwvR8k6.rgCTwTOXecVqFcTj8hB8yFT8f2hXdkCXNHV4bS', '9007363351', 'A', 'B', '2,9', 'f5bd4e718c6684855586b2636e74fd96', 'N', NULL, 'N', NULL, 1, 8, NULL, 'N', NULL, NULL),
(12, 'debajit.nag@andrewyule.com', 'ABCD', '$2y$10$9hhafZe2OvvWjh6fT5E3GeH1II6pV3mR8SSOGiJg5ymEq/2n4Iokq', '9051844469', 'A', 'B', '2,9', 'c09b95aae58892592c3267c5f80afd1c', 'N', NULL, 'N', NULL, 1, 9, NULL, 'N', NULL, NULL),
(18, 'surajit@infotechsystems.in', 'SURAJIT MONDAL', '$2y$10$bdX8F6MrcQp4KyEjQPD3H.9lT3S62I4bnnZyIoamsng74i13XQkaK', '9051530165', 'A', 'B', '2,9', '5cce098600ef30ce4693b2db647a3f4d', 'N', NULL, 'N', NULL, 1, 15, NULL, 'N', NULL, NULL),
(19, 'contact@infotechsystems.in', 'SURAJIT MONDAL', '$2y$10$ASe.Zv6WW/JKO24S1dJiyeGA1cWq9VIUJ6HB.H0V1NelCKpWeg/0W', '9830076207', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 16, NULL, 'N', NULL, NULL),
(20, 'manojmanna@sumranagro.com', 'MANOJ MANNA', '$2y$10$0P3fhWzsTs0vSlckFW0zf.FZOx/spLgaypZoLtRl/LvSbcBvW.fC6', '9874456712', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 17, NULL, 'N', NULL, NULL),
(21, 'dwarkadas07@yahoo.com', 'MOHIT JUTHANI', '$2y$10$oj/I2XxptFTu6Gc8WuyvE.YhiFpa8.E2zsExZZQxzkJbAkaxWXVpW', '7022312555', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 18, NULL, 'N', NULL, NULL),
(22, 'info@morakhiagroup.com', 'GAURAV SHAH', '$2y$10$44/NyZnOKLgjz/NQjVpx.eymtffF0mYoKq0IaE6sWKEVZdMwiA7xW', '9428372730', 'A', 'B', '2,9', '4084be2c87a42ba01de80bd8e7690d29', 'N', NULL, 'N', NULL, 1, 19, NULL, 'N', NULL, NULL),
(23, 'pratik@pjshah.in', 'NEHAL SHAH', '$2y$10$WgjVVLe7aGn37vX/aJnGFOr2sexrqlKhIc1REdu4dH5Sog8ojHF86', '9836922240', 'A', 'B', '2,9', '1cb5335cd1b0266f29518054aae62941', 'N', NULL, 'N', NULL, 1, 20, NULL, 'N', NULL, NULL),
(24, 'dundeshdhang83@gmail.com', 'DUNDESH DHANG', '$2y$10$eqq09qISTHNvLr.B32BH..Kk5ayzrY1u4WKFPOTAWIjj4dI1byVb.', '9448111189', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 21, NULL, 'N', NULL, NULL),
(25, 'rakeshbhagat@newteaco.com', 'RAKESH BHAGAT', '$2y$10$nJaicT/hREDqlkTqnAWSz.tkHZOLFId6qavTixM0L0wghVQOhxBfK', '9825039733', 'A', 'B', '2,9', 'f988747db96f2cb43b77443e7d33ca3b', 'N', NULL, 'N', NULL, 1, 22, NULL, 'N', NULL, NULL),
(26, 'VIKASHTEA@YAHOO.IN', 'VIKAS SINGAL', '$2y$10$aFht01XWmq4vzCbZ9j4kpeP.51vIH58Vlo0wU1SRcKWO06AQ8ErtC', '9832190888', 'A', 'B', '2,9', 'b5f7b4806b353da7bff528291167cbc6', 'N', NULL, 'N', NULL, 1, 23, NULL, 'N', NULL, NULL),
(27, 'udeshyakmr@gmail.com', 'DUMMY_UDESHYA', '$2y$10$FQ6/VGBPH3tvwG6/Sug3TenGwOYI8zUXNUSAVCEH1djWyQZkMX.be', '7351766705', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 24, NULL, 'N', NULL, NULL),
(28, 'ksubhatirtha@gmail.com', 'SUBHATIRTHA KAR', '$2y$10$G.bxESjY5xGnBzxuWnSnyeYLPPvreWRGcppB3WpMeHqC7o9AmGUUm', '7449782411', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 25, NULL, 'N', NULL, NULL),
(29, 'praveen.kothari@andrewyule.com', 'PRAVEEN', '$2y$10$rwwKRVxopJyPanOkoXUmceT/P3aarWqdSTC4bbO2jhcu5iwPjrwRy', '8240112945', 'A', 'B', '2,9', '1552bc42f61e130b729153a7834b6452', 'N', NULL, 'N', NULL, 1, 26, NULL, 'N', NULL, NULL),
(30, 'souvikguin06@gmail.com', 'SOUVIK', '$2y$10$BI2xd07dWIDD5wZYU9EpfOhx3qOjVSrgMmzN9ts5N0UlgXiW37jaK', '7687044580', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 27, NULL, 'N', NULL, NULL),
(31, 'rnp@andrewyule.com', 'TEATEA', '$2y$10$LpDF14j.lzUQCv25D0uWQOsJAoKUPOs5Qe//xvQ1Eeu2ukhqb/8u.', '9003183790', 'A', 'B', '2,9', '83d7da1f36424bc0a76b3a750a40b62a', 'N', NULL, 'N', NULL, 1, 28, NULL, 'N', NULL, NULL),
(32, 'shantanu.boral@andrewyule.com', 'SHANTANU BORAL', '$2y$10$UGHjN8zGLTE5q8KcO2DV7.V1/15lK8qoWdrQMdtY4FTGtODHl2VlO', '9831310812', 'A', 'B', '2,9', '1c0d61c626c5facd1ed4d9a1ce28cff9', 'N', NULL, 'N', NULL, 1, 29, NULL, 'N', NULL, NULL),
(33, 'shubhankar.chakraborty@andrewyule.com', 'SHUBHANKAR CHAKRABORTY', '$2y$10$f5DbLYH6g12cY5q9y6a.rOHRHYUPLsqyMx1JHtXQ8moyJJUp5tH3C', '8638740044', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, 30, NULL, 'N', NULL, NULL),
(34, 'subhodipdutta003@gmail.com', 'SUBHODIP DUTTA', '$2y$10$Dqum5Gi/lgebdovQ4NyXB.mTDqXHQQwh1sa4.b6LAgINZbttEBX6W', '8420383106', 'A', 'B', '2,9', '7fb3dd966613c4c67d31f0b96b1586ee', 'N', NULL, 'N', NULL, 1, 31, NULL, 'N', NULL, NULL),
(35, 'udeshyakumar1995@gmail.com', 'UDESHYA KUMAR', '$2y$10$cr5WdgbZp8THkWUJ6P9U2OanntTWUw12rhR0A6k/agBrBDxvh.Opy', '8240353924', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, NULL, NULL, 'N', NULL, NULL),
(36, 'udeshyakumar1995@gmail.com', 'UDESHYA KUMAR', '$2y$10$8nOgVwTDL4udCJRg8W1xv.syQ5ba3hOmneMr05fdp3tFSSYg/nAcO', '8240353924', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, NULL, NULL, 'N', NULL, NULL),
(37, 'test', 'TEST', '$2y$10$oltnPOGWKpu6h04yKdUqmui/FYWWc.GL6aAuuQYiY4s6e4oGzAG6i', '9051530165', 'A', 'C', '16,17,0', NULL, 'N', '7343', 'N', NULL, 1, NULL, 'TEST', 'Y', 1, 'uploads/sign/881.jpg'),
(38, 'manchliya@gmail.com', 'MAHENDRA ANCHLIYA', '$2y$10$UDe4ZkB5mCJOUpFkHp3mBOIuiZik8zJfI/mfqSv8DB2DlAfPT2CGm', '7775946097', 'A', 'B', '2,9', NULL, 'N', NULL, 'N', NULL, 1, NULL, NULL, 'N', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_type_mas`
--

DROP TABLE IF EXISTS `user_type_mas`;
CREATE TABLE IF NOT EXISTS `user_type_mas` (
  `user_type_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(1) DEFAULT 'B',
  `user_type_desc` varchar(15) DEFAULT NULL,
  `assigned_page` text,
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type_mas`
--

INSERT INTO `user_type_mas` (`user_type_id`, `user_type`, `user_type_desc`, `assigned_page`) VALUES
(1, 'B', 'Bidder', '2,9'),
(2, 'G', 'General', NULL),
(3, 'C', 'App Committee', '16,17');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
