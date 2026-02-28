-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 28, 2026 at 04:40 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mr_ro`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit_customers`
--

DROP TABLE IF EXISTS `credit_customers`;
CREATE TABLE IF NOT EXISTS `credit_customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `daily_sale_id` bigint UNSIGNED NOT NULL,
  `credit_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT '0.00',
  `note` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `credit_customers_daily_sale_id_foreign` (`daily_sale_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `credit_customers`
--

INSERT INTO `credit_customers` (`id`, `customer_id`, `daily_sale_id`, `credit_date`, `amount`, `balance`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 8, NULL, NULL, 0.00, NULL, '2025-07-03 15:51:13', '2025-07-10 19:26:03', NULL),
(2, 1, 9, NULL, NULL, 0.00, NULL, '2025-07-03 15:51:30', '2025-07-10 19:26:41', NULL),
(3, 1, 10, NULL, NULL, 12.00, NULL, '2025-07-03 16:45:36', '2025-07-10 19:26:41', NULL),
(4, 5, 14, NULL, NULL, 66.00, NULL, '2025-07-09 17:02:57', '2025-07-09 17:02:57', NULL),
(5, 2, 24, NULL, NULL, 264.00, NULL, '2025-07-10 18:09:50', '2025-07-10 18:09:50', NULL),
(6, 8, 28, NULL, NULL, 0.00, NULL, '2025-08-02 12:06:59', '2026-02-28 15:35:53', NULL),
(7, 11, 30, NULL, NULL, 0.00, NULL, '2026-02-26 17:04:22', '2026-02-28 15:34:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `credit_customers_june_2025`
--

DROP TABLE IF EXISTS `credit_customers_june_2025`;
CREATE TABLE IF NOT EXISTS `credit_customers_june_2025` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `daily_sale_id` bigint UNSIGNED NOT NULL,
  `credit_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT '0.00',
  `note` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `credit_customers_daily_sale_id_foreign` (`daily_sale_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '93bb', NULL, NULL, '2025-07-03 15:40:40', '2025-07-03 15:46:44', NULL),
(2, 'Tariq', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(3, 'Shehzad', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(4, '17b Gulshan Ahab', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(5, '11cc', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(6, '29 Fatima', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(7, '214A', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(8, '215A', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(9, '341E', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(10, '45 Waheed Home', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(11, '487B', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(12, '480b lower', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(13, '48cc', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(14, '41E Commercial', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(15, '43H Soraba', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(16, '509GVL', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(17, '502GVL', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(18, '51D', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(19, '541B Upper', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(20, '668B', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(21, '627b lower', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(22, '70cc', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(23, '84CC', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(24, '85CC', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(25, '85BV', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(26, '217D', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(27, 'Medical Store', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(28, '10CC', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(29, '300B', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(30, '217EE', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(31, '86B', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(32, 'Madina Home', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(33, '62BB', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(34, '66CC', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(35, '61CC', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(36, '14B Gulshan Bab', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(37, '16b Gulshan Bab', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(38, '156 soroba', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(39, '45 soroba', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(40, '18D', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(41, '109BB', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(42, '146BB', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(43, '137BB', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(44, '134BB upper', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(45, '103A', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(46, '18bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(47, '18BB', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(48, '111BB', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(49, '139BB', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(50, '104bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(51, '18CC', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(52, '12Bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(53, '127BB', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(54, '86bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(55, '22Bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(56, '25bb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(57, '24bb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(58, '31bb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(59, '30bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(60, '39bb upper', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(61, '362bb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(62, '393b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(63, '39bv lower', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(64, '39bv upper', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(65, '32bb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(66, '358gb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(67, '358bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(68, '31bb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(69, '484bb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(70, '432b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(71, '44bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(72, '452b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(73, '41bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(74, '480b Upper', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(75, '49bb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(76, '407b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(77, '440b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(78, '405b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(79, '400b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(80, '474b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(81, '450b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(82, '49d', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(83, '42bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(84, '452b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(85, '403b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(86, '535b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(87, '520b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(88, '457b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(89, '540b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(90, '50bb', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(91, '502b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(92, '509b upper', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(93, '509b lower', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(94, '50bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(95, '550b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(96, '563b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(97, '553b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(98, '561b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(99, '574b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(100, '542b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(101, '53bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(102, '555b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(103, '604b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(104, '63bv', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(105, '649b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(106, '656b', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(107, '65cc', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(108, '627b upper', NULL, NULL, '2025-07-03 16:10:32', '2025-07-03 16:10:32', NULL),
(109, '611b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(110, '647b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(111, '690b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(112, '642b upper', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(113, '654b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(114, '72bv', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(115, '72cc', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(116, '74cc', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(117, '81bv', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(118, '82bb', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(119, '87cc', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(120, '99bv', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(121, '9bb', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(122, '91bv', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(123, '92bv', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(124, '96cc', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(125, '70 waheed home', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(126, 'hijvery town', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(127, '82 hijvery town', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(128, 'Murtaza Plaza 3rd floor', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(129, 'Doodh Plaza 2nd floor', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(130, '41E Commercial Flat', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(131, '406b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(132, '47bb', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(133, '63bb', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(134, '95cc', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(135, '54bb', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(136, '638b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(137, '369b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(138, 'Sajid NAAN shop 3rd floor', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(139, '121bb', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(140, '593b upper', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(141, '591b upper', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(142, '571b lower', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(143, '691b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(144, '448b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(145, '653b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(146, '99b shadab', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(147, '436e', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(148, '408b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(149, '79bv', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(150, '44bv', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(151, '12c', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(152, '672b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(153, 'hotel plaza', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(154, '557b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(155, '128ee', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(156, '503gvl', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(157, '379b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(158, '64bv', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(159, '497b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(160, '20cc', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(161, '437b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(162, 'RS 502gvl', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(163, '36 fatima', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(164, '61ee', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(165, '537b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(166, 'Malik Store', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(167, '394b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(168, '678b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(169, '21bb', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(170, '52c', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(171, '576b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(172, '76c', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(173, '591e', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(174, '52cc', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(175, '552b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(176, '494b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(177, '515b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(178, '5cc', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(179, '67bv', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(180, '264b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(181, '504b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(182, '600b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(183, '98dd', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(184, '432b lower', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(185, '580ab', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(186, '629b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(187, '169b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(188, '254b', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(189, '71cc', NULL, NULL, '2025-07-03 16:10:33', '2025-07-03 16:10:33', NULL),
(190, 'tention', '099', NULL, '2025-07-09 16:59:27', '2025-07-09 16:59:27', NULL),
(191, '988bb', '09809798', NULL, '2025-07-09 17:07:53', '2025-07-09 17:07:53', NULL),
(192, '988b', '09809798', NULL, '2025-07-09 17:11:22', '2025-07-09 17:11:22', NULL),
(193, '988b', '09809798', NULL, '2025-07-09 17:11:43', '2025-07-09 17:11:43', NULL),
(194, '988bv', '09809798', NULL, '2025-07-09 17:15:35', '2025-07-09 17:15:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_sales`
--

DROP TABLE IF EXISTS `daily_sales`;
CREATE TABLE IF NOT EXISTS `daily_sales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` bigint UNSIGNED NOT NULL,
  `item` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `is_credit` tinyint(1) DEFAULT '0',
  `sale_date` date DEFAULT NULL,
  `month` varchar(191) NOT NULL,
  `year` smallint UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `items` json DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `status` varchar(191) NOT NULL DEFAULT 'draft',
  `fbr_invoice_number` varchar(255) DEFAULT NULL,
  `fbr_synced_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `daily_sales_shop_id_foreign` (`shop_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daily_sales`
--

INSERT INTO `daily_sales` (`id`, `shop_id`, `item`, `amount`, `customer_id`, `is_credit`, `sale_date`, `month`, `year`, `total_amount`, `items`, `created_at`, `updated_at`, `deleted_at`, `quantity`, `status`, `fbr_invoice_number`, `fbr_synced_at`) VALUES
(1, 0, 'Bottle', 80.00, NULL, 0, NULL, '0', 0, NULL, NULL, '2025-07-02 19:20:14', '2025-07-02 19:20:14', NULL, 3, 'draft', NULL, NULL),
(2, 0, 'Bottle', 80.00, NULL, 0, NULL, '0', 0, NULL, NULL, '2025-07-02 19:20:47', '2025-07-02 19:20:47', NULL, 4, 'draft', NULL, NULL),
(3, 0, 'Bottle', 80.00, NULL, 0, '2025-07-02', '0', 0, 320.00, NULL, '2025-07-02 19:25:39', '2025-07-02 19:25:39', NULL, 4, 'draft', NULL, NULL),
(4, 0, 'Bottle', 80.00, NULL, 0, '2025-07-02', '0', 0, 80.00, NULL, '2025-07-02 19:29:07', '2025-07-02 19:29:07', NULL, 1, 'draft', NULL, NULL),
(5, 0, 'Bottle', 80.00, NULL, 1, '2025-07-02', '0', 0, 80.00, NULL, '2025-07-02 19:29:30', '2025-07-02 19:29:30', NULL, 1, 'draft', NULL, NULL),
(6, 0, 'Bottle', 80.00, 1, 1, '2025-07-03', '0', 0, 80.00, NULL, '2025-07-03 15:47:15', '2025-07-03 15:47:15', NULL, 1, 'draft', NULL, NULL),
(7, 0, 'Bottle', 80.00, 1, 1, '2025-07-03', '0', 0, 80.00, NULL, '2025-07-03 15:49:31', '2025-07-03 15:49:31', NULL, 1, 'draft', NULL, NULL),
(8, 0, 'Bottle', 80.00, 1, 1, '2025-07-03', '0', 0, 80.00, NULL, '2025-07-03 15:51:13', '2025-07-03 15:51:13', NULL, 1, 'draft', NULL, NULL),
(9, 0, 'Bottle', 80.00, 1, 1, '2025-07-03', '0', 0, 80.00, NULL, '2025-07-03 15:51:30', '2025-07-03 15:51:30', NULL, 1, 'draft', NULL, NULL),
(10, 0, 'Bottle', 80.00, 1, 1, '2025-07-03', 'July', 2025, 80.00, NULL, '2025-07-03 16:45:36', '2025-07-03 16:45:36', NULL, 1, 'draft', NULL, NULL),
(11, 0, 'Bottle', 80.00, NULL, 0, '2025-07-04', 'July', 2025, 80.00, NULL, '2025-07-04 18:15:42', '2025-07-04 18:15:42', NULL, 1, 'draft', NULL, NULL),
(12, 0, '3', 250.80, NULL, 0, '2025-07-09', 'July', 2025, 176.00, NULL, '2025-07-09 16:59:13', '2025-07-09 16:59:13', NULL, 2, 'draft', NULL, NULL),
(13, 0, 'Bottle', 80.00, NULL, 0, '2025-07-09', 'July', 2025, 88.00, NULL, '2025-07-09 17:01:36', '2025-07-09 17:01:36', NULL, 1, 'draft', NULL, NULL),
(14, 0, 'Bottle', 80.00, 5, 1, '2025-07-09', 'July', 2025, 66.00, NULL, '2025-07-09 17:02:57', '2025-07-09 17:02:57', NULL, 1, 'draft', NULL, NULL),
(15, 2, 'Bottle', 80.00, NULL, 0, '2025-07-09', 'July', 2025, 88.00, NULL, '2025-07-09 19:01:15', '2025-07-09 19:01:15', NULL, 1, 'draft', NULL, NULL),
(16, 2, 'Bottle', 80.00, NULL, 0, '2025-07-09', 'July', 2025, 88.00, NULL, '2025-07-09 19:01:23', '2025-07-09 19:01:23', NULL, 1, 'draft', NULL, NULL),
(17, 2, 'Bottle', 80.00, NULL, 0, '2025-07-09', 'July', 2025, 88.00, NULL, '2025-07-09 19:02:28', '2025-07-09 19:02:28', NULL, 1, 'draft', NULL, NULL),
(18, 1, 'Bottle', 80.00, NULL, 0, '2025-07-09', 'July', 2025, 176.00, NULL, '2025-07-09 19:05:32', '2025-07-09 19:05:32', NULL, 2, 'draft', NULL, NULL),
(19, 1, 'Bottle', 80.00, NULL, 0, '2025-07-09', 'July', 2025, 176.00, NULL, '2025-07-09 19:06:05', '2025-07-09 19:06:05', NULL, 2, 'draft', NULL, NULL),
(20, 1, 'Bottle', 80.00, NULL, 0, '2025-07-09', 'July', 2025, 176.00, NULL, '2025-07-09 19:07:31', '2025-07-10 18:01:16', NULL, 2, 'finalized', NULL, NULL),
(21, 1, 'Bottle', 80.00, NULL, 0, '2025-07-09', 'July', 2025, 88.00, NULL, '2025-07-09 19:07:43', '2025-07-10 18:01:14', NULL, 1, 'finalized', NULL, NULL),
(22, 1, 'Bottle', 80.00, 8, 0, '2025-07-09', 'July', 2025, 198.00, NULL, '2025-07-09 19:09:44', '2025-07-10 17:58:38', NULL, 3, 'finalized', NULL, NULL),
(23, 1, 'Bottle', 80.00, NULL, 1, '2025-07-10', 'July', 2025, 352.00, NULL, '2025-07-10 18:09:10', '2025-07-10 18:09:10', NULL, 4, 'draft', NULL, NULL),
(24, 1, 'Bottle', 80.00, 2, 1, '2025-07-10', 'July', 2025, 264.00, NULL, '2025-07-10 18:09:50', '2025-07-10 18:09:50', NULL, 3, 'draft', NULL, NULL),
(25, 1, 'Bottle', 80.00, NULL, 0, '2025-07-10', 'July', 2025, 176.00, NULL, '2025-07-10 18:11:14', '2025-07-10 18:11:14', NULL, 2, 'draft', NULL, NULL),
(26, 1, 'Bottle', 80.00, NULL, 0, '2025-07-10', 'July', 2025, 176.00, NULL, '2025-07-10 18:31:25', '2025-07-10 18:31:25', NULL, 2, 'draft', NULL, NULL),
(27, 6, 'Bottle', 80.00, NULL, 0, '2025-08-02', 'August', 2025, 88.00, NULL, '2025-08-02 12:05:58', '2025-08-02 12:05:58', NULL, 1, 'draft', NULL, NULL),
(28, 6, 'Bottle', 80.00, 8, 1, '2025-08-02', 'August', 2025, 66.00, NULL, '2025-08-02 12:06:59', '2026-02-26 17:04:50', NULL, 1, 'finalized', NULL, NULL),
(29, 6, 'Bottle', 80.00, NULL, 0, '2026-02-26', 'February', 2026, 88.00, NULL, '2026-02-26 16:19:06', '2026-02-26 17:04:47', NULL, 1, 'finalized', NULL, NULL),
(30, 1, 'Bottle', 80.00, 11, 1, '2026-02-26', 'February', 2026, 880.00, NULL, '2026-02-26 17:04:22', '2026-02-26 17:04:22', NULL, 10, 'draft', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_sale_june_2025`
--

DROP TABLE IF EXISTS `daily_sale_june_2025`;
CREATE TABLE IF NOT EXISTS `daily_sale_june_2025` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `is_credit` tinyint(1) DEFAULT '0',
  `sale_date` date DEFAULT NULL,
  `month` varchar(191) NOT NULL,
  `year` smallint UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `items` json DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `expense_date` date DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `description` text,
  `amount` decimal(10,2) DEFAULT NULL,
  `shop_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendor_id` (`vendor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_date`, `vendor_id`, `description`, `amount`, `shop_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21, '2025-08-02', NULL, 'Lunch', 250.00, 6, '2025-08-02 13:59:30', '2025-08-02 13:59:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fbr_logs`
--

DROP TABLE IF EXISTS `fbr_logs`;
CREATE TABLE IF NOT EXISTS `fbr_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `shop_id` bigint UNSIGNED NOT NULL,
  `daily_sale_id` int DEFAULT NULL,
  `status` enum('success','error') NOT NULL,
  `request` text,
  `response` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`),
  KEY `daily_sale_id` (`daily_sale_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fbr_settings`
--

DROP TABLE IF EXISTS `fbr_settings`;
CREATE TABLE IF NOT EXISTS `fbr_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `shop_id` bigint UNSIGNED NOT NULL,
  `pos_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `integration_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fbr_settings_shop` (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_07_02_181046_create_sessions_table', 1),
(2, '2025_07_02_181106_create_jobs_table', 1),
(3, '2025_07_02_181345_add_role_to_users_table', 2),
(4, '2025_07_02_182752_create_cache_table', 3),
(5, '2025_07_02_190112_add_quantity_to_daily_sales_table', 4),
(6, '2025_07_03_155018_add_daily_sale_id_to_credit_customers_table', 5),
(7, '2025_07_03_163158_add_month_year_to_daily_sales', 6),
(8, '2025_07_03_163210_add_month_year_to_payments', 6),
(9, '2025_07_03_164500_change_month_column_type_in_daily_sales_table', 7),
(10, '2025_07_09_181329_create_shops_table', 8),
(11, '2025_07_09_184028_add_shop_id_to_daily_sales_table', 9),
(12, '2025_07_10_174707_add_status_to_daily_sales_table', 10),
(13, '2025_08_02_103944_create_fbr_settings_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `month` tinyint UNSIGNED NOT NULL,
  `year` smallint UNSIGNED NOT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `note` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `customer_id`, `payment_date`, `month`, `year`, `amount_paid`, `payment_method`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 1, '2025-07-03', 0, 0, 78.00, 'cash', NULL, '2025-07-03 16:01:46', '2025-07-03 16:01:46', NULL),
(4, 1, '2025-07-10', 7, 2025, 50.00, 'cash', NULL, '2025-07-10 19:26:03', '2025-07-10 19:26:03', NULL),
(5, 1, '2025-07-10', 7, 2025, 100.00, 'Bank', NULL, '2025-07-10 19:26:41', '2025-07-10 19:26:41', NULL),
(6, 11, '2026-02-26', 2, 2026, 500.00, 'cash', NULL, '2026-02-26 17:05:46', '2026-02-26 17:05:46', NULL),
(7, 11, '2026-02-28', 2, 2026, 380.00, 'Cash', 'by chota bhai', '2026-02-28 15:34:54', '2026-02-28 15:34:54', NULL),
(8, 8, '2026-02-28', 2, 2026, 66.00, 'Bank', 'by brother', '2026-02-28 15:35:53', '2026-02-28 15:35:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `module` varchar(100) NOT NULL,
  `action` varchar(50) NOT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `assigned_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_permission_role` (`permission_id`,`role_id`),
  KEY `fk_permission_role_role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display_name` varchar(150) DEFAULT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `assigned_by` bigint UNSIGNED DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_role_user` (`role_id`,`user_id`),
  KEY `fk_role_user_user` (`user_id`),
  KEY `fk_role_user_assigned_by` (`assigned_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('SYUHC1sdIFR4BoPnLOOPVjo6R85LSrElgtIOKkI1', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidGF3cFppVjZreXJTa3FFQlVydTI1dXNjWGxMbW9jaXNSZUUzQ01rQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZXR0aW5ncy9zaG9wcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1772294567);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
CREATE TABLE IF NOT EXISTS `shops` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `user_id`, `name`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mr RO', 'D block', '2025-07-09 13:28:11', '2025-07-09 13:28:11'),
(2, 1, 'Mr Frechise', 'D block', '2025-07-09 13:30:55', '2025-07-09 13:30:55'),
(6, 1, 'MR RO Frenchise', 'F Block', '2025-08-02 07:05:40', '2025-08-02 07:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', '2025-07-02 18:28:37', '$2y$12$Af9tseOkLTXnZcZlWielhOOjLQXqqO9eleOByhsQlNE9x56O4rbKi', NULL, '2025-07-02 13:26:08', '2025-07-02 13:26:08', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `fk_permission_role_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_permission_role_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `fk_role_user_assigned_by` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_role_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_role_user_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
