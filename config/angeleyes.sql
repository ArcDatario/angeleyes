-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2025 at 11:29 AM
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
-- Database: `angeleyes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `remember_expiry` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `profile`, `remember_token`, `remember_expiry`, `last_login`, `created_at`) VALUES
(1, 'admin', '$2y$10$6iRK3cYaPlH0CXx86Ib4yuaagqdDqpJr.99Ywz32v3Ovm9ViuC//e', 'admin_1755896702.jpeg', '08c87ce77b2d9c7eda4dd232fbc90d572479108e7d595edbfab139c94fba0d7c', '2025-09-26 02:08:42', '2025-08-28 17:27:37', '2025-08-17 17:23:27');

-- --------------------------------------------------------

--
-- Table structure for table `inclusions`
--

CREATE TABLE `inclusions` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `inclusion_text` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inclusions`
--

INSERT INTO `inclusions` (`id`, `plan_id`, `inclusion_text`, `created_at`) VALUES
(59, 11, '600 mbps', '2025-08-22 19:02:06'),
(60, 11, '60 mbps', '2025-08-22 19:02:06'),
(61, 11, '600 mbps', '2025-08-22 19:02:06'),
(62, 11, '600 mbps', '2025-08-22 19:02:06'),
(63, 11, '600 mbps', '2025-08-22 19:02:06'),
(64, 11, '600 mbps', '2025-08-22 19:02:06'),
(65, 11, '600 mbps', '2025-08-22 19:02:06'),
(66, 9, '60 mbps', '2025-08-22 20:58:37'),
(67, 9, '600 mbps', '2025-08-22 20:58:37'),
(68, 9, '600 mbps', '2025-08-22 20:58:37'),
(69, 9, '60 mbps', '2025-08-22 20:58:37'),
(70, 9, '60 mbps', '2025-08-22 20:58:37'),
(71, 4, '600 mbps', '2025-08-22 21:10:24'),
(72, 4, '600 mbps', '2025-08-22 21:10:24'),
(73, 4, '600 mbps', '2025-08-22 21:10:24'),
(74, 4, '600 mbps', '2025-08-22 21:10:24'),
(75, 5, '600 mbps', '2025-08-22 21:10:28'),
(76, 5, '600 mbps', '2025-08-22 21:10:28'),
(77, 5, '600 mbps', '2025-08-22 21:10:28'),
(78, 5, '600 mbps', '2025-08-22 21:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `admin_id`, `content`, `created_at`) VALUES
(42, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription A7UFYBA0RE', '2025-08-23 00:57:49'),
(43, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription A7UFYBA0RE', '2025-08-23 01:04:13'),
(44, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription A7UFYBA0RE', '2025-08-23 01:04:22'),
(45, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription A7UFYBA0RE', '2025-08-23 01:05:24'),
(46, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription A7UFYBA0RE', '2025-08-23 01:05:32'),
(47, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription A7UFYBA0RE', '2025-08-23 01:06:15'),
(48, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription A7UFYBA0RE', '2025-08-23 01:06:43'),
(49, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription A7UFYBA0RE', '2025-08-23 01:07:20'),
(50, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription A7UFYBA0RE', '2025-08-23 01:08:08'),
(51, 1, 'Deleted subscriber: Arc Datario, USER_ID: HVLBA812O3, Email: datarioarc@gmail.com, Phone: 09123456789, Had 1 subscriptions', '2025-08-23 01:17:54'),
(52, 1, 'Updated subscriber USER_ID: C7MSS7S9V1 - name: Deenisonsss → Arc, email: storex@gmail.com → datarioarc@gmail.com', '2025-08-23 01:18:30'),
(53, 1, 'Deleted subscriber: Denison, USER_ID: 2JJ8XVT9KC, Email: denison@gmail.com, Phone: 09123456789, Had 0 subscriptions', '2025-08-23 01:18:59'),
(54, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription 3XDUKJVAHC', '2025-08-23 01:19:45'),
(55, 0, 'Manual test billing notice sent to: datarioarc@gmail.com for subscription 3XDUKJVAHC', '2025-08-23 01:22:10'),
(56, 1, 'Deleted plan ID: 10 - Name: Plan 9003, Price: ₱3122.00, Badge: none', '2025-08-23 02:04:07'),
(57, 1, 'Created new plan: Plan 699 (₱699) with badge: none and 7 inclusions', '2025-08-23 03:02:06'),
(58, 1, 'Deleted subscriber: Arc Datarioss, USER_ID: 1OV39SCH6T, Email: datarioarc16@gmail.com, Phone: 09946726471, Had 1 subscriptions', '2025-08-23 04:18:37'),
(59, 1, 'Deleted subscriber: Arc, USER_ID: C7MSS7S9V1, Email: datarioarc@gmail.com, Phone: 09686409348, Had 2 subscriptions', '2025-08-23 04:18:40'),
(60, 1, 'Created new subscriber: Arc Datario, USER_ID: 5GNCD07A3V, Email: datarioarc16@gmail.com, Phone: 09686409348, Status: Active', '2025-08-23 04:18:51'),
(61, 1, 'Created new subscription ref: NFFT6UEGLP for subscriber: Arc Datario (USER_ID: 5GNCD07A3V) - Plan: Plan 1499 ($1599.00), Address: East Center, Started: 2025-08-23, Due: 2025-09-23, Status: Active', '2025-08-23 04:19:03'),
(62, 1, 'increased subscription count for subscriber: Arc Datario (USER_ID: 5GNCD07A3V) from 0 to 1', '2025-08-23 04:19:03'),
(63, 1, 'Deleted subscription ID: 9 for subscriber: Arc Datario (USER_ID: 5GNCD07A3V) - Plan: Plan 1499 ($1599.00), Started: 2025-08-23 00:00:00, Due: 2025-09-23 00:00:00, Status: Active', '2025-08-23 04:21:28'),
(64, 1, 'decreased subscription count for subscriber: Arc Datario (USER_ID: 5GNCD07A3V) from 1 to 0', '2025-08-23 04:21:28'),
(65, 1, 'Created new subscription ref: S1DAVYPWW7 for subscriber: Arc Datario (USER_ID: 5GNCD07A3V) - Plan: Plan 1499 ($1599.00), Address: East Center, Started: 2025-08-23, Due: 2025-09-23, Status: Active', '2025-08-23 04:22:08'),
(66, 1, 'increased subscription count for subscriber: Arc Datario (USER_ID: 5GNCD07A3V) from 0 to 1', '2025-08-23 04:22:08'),
(67, 1, 'Updated plan ID: 9 - inclusions updated', '2025-08-23 04:58:37'),
(68, 1, 'Created new subscription ref: 1DJG999PTR for subscriber: Arc Datario (USER_ID: 5GNCD07A3V) - Plan: Plan 1499 (₱1599.00), Address: East Center, Started: 2025-08-23, Due: 2025-09-23, Status: Active', '2025-08-23 05:09:35'),
(69, 1, 'increased subscription count for subscriber: Arc Datario (USER_ID: 5GNCD07A3V) from 1 to 2', '2025-08-23 05:09:35'),
(70, 1, 'Updated plan ID: 4 - name: Plan 1499 → Plan 1599', '2025-08-23 05:10:24'),
(71, 1, 'Updated plan ID: 5 - name: Plan 1499 → Plan 1599', '2025-08-23 05:10:28'),
(72, 1, 'Created new subscriber: Denison, USER_ID: 1P0YIRR61N, Email: denisonpaoloabergas@gmail.com, Phone: 09996549965, Status: Active', '2025-08-27 02:29:04'),
(73, 1, 'Created new subscription ref: SF2S9X2WX4 for subscriber: Denison (USER_ID: 1P0YIRR61N) - Plan: Plan 1599 (₱1599.00), Address: East Center, Started: 2025-08-27, Due: 2025-09-27, Status: Active', '2025-08-27 02:29:17'),
(74, 1, 'increased subscription count for subscriber: Denison (USER_ID: 1P0YIRR61N) from 0 to 1', '2025-08-27 02:29:17'),
(75, 1, 'Updated subscriber USER_ID: 5GNCD07A3V - phone: 09686409348 → 09761125698', '2025-08-27 02:33:47');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `payment_id` varchar(100) NOT NULL,
  `payment_request_id` varchar(100) DEFAULT NULL,
  `external_id` varchar(100) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `authorized_amount` decimal(15,2) DEFAULT NULL,
  `captured_amount` decimal(15,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'PHP',
  `status` varchar(50) NOT NULL,
  `payment_method_type` varchar(50) DEFAULT NULL,
  `payment_method_id` varchar(100) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `channel_code` varchar(50) DEFAULT NULL,
  `channel_name` varchar(100) DEFAULT NULL,
  `reusability` varchar(20) DEFAULT NULL,
  `method_status` varchar(20) DEFAULT NULL,
  `card_token_id` varchar(100) DEFAULT NULL,
  `masked_card_number` varchar(20) DEFAULT NULL,
  `cardholder_name` varchar(255) DEFAULT NULL,
  `expiry_month` varchar(2) DEFAULT NULL,
  `expiry_year` varchar(4) DEFAULT NULL,
  `card_type` varchar(20) DEFAULT NULL,
  `card_network` varchar(20) DEFAULT NULL,
  `card_country` varchar(5) DEFAULT NULL,
  `card_issuer` varchar(50) DEFAULT NULL,
  `card_fingerprint` varchar(100) DEFAULT NULL,
  `three_d_secure_flow` varchar(20) DEFAULT NULL,
  `eci_code` varchar(10) DEFAULT NULL,
  `three_d_secure_result` varchar(20) DEFAULT NULL,
  `three_d_secure_version` varchar(10) DEFAULT NULL,
  `cvv_result` varchar(20) DEFAULT NULL,
  `address_verification_result` varchar(20) DEFAULT NULL,
  `account_details` text DEFAULT NULL,
  `reference_id` varchar(100) DEFAULT NULL,
  `payer_email` varchar(255) DEFAULT NULL,
  `payer_country` varchar(5) DEFAULT 'PH',
  `description` text DEFAULT NULL,
  `failure_code` varchar(100) DEFAULT NULL,
  `failure_message` varchar(255) DEFAULT NULL,
  `metadata` text DEFAULT NULL,
  `channel_properties` text DEFAULT NULL,
  `payment_detail` text DEFAULT NULL,
  `available_payment_methods` text DEFAULT NULL,
  `created_time_gmt8` datetime NOT NULL,
  `updated_time_gmt8` datetime NOT NULL,
  `settlement_status` varchar(50) DEFAULT NULL,
  `settlement_time_gmt8` datetime DEFAULT NULL,
  `business_id` varchar(100) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `event_type`, `payment_id`, `payment_request_id`, `external_id`, `amount`, `authorized_amount`, `captured_amount`, `currency`, `status`, `payment_method_type`, `payment_method_id`, `payment_method`, `channel_code`, `channel_name`, `reusability`, `method_status`, `card_token_id`, `masked_card_number`, `cardholder_name`, `expiry_month`, `expiry_year`, `card_type`, `card_network`, `card_country`, `card_issuer`, `card_fingerprint`, `three_d_secure_flow`, `eci_code`, `three_d_secure_result`, `three_d_secure_version`, `cvv_result`, `address_verification_result`, `account_details`, `reference_id`, `payer_email`, `payer_country`, `description`, `failure_code`, `failure_message`, `metadata`, `channel_properties`, `payment_detail`, `available_payment_methods`, `created_time_gmt8`, `updated_time_gmt8`, `settlement_status`, `settlement_time_gmt8`, `business_id`, `created`) VALUES
(56, 'invoice.created', '68a6f78ea38788dceaa2ff0b', NULL, 'invoice-1755772813-8684', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a6f78ea38788dceaa2ff0b\",\"expiry_date\":\"2025-08-22 18:40:15\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-21 18:40:15', '2025-08-21 18:40:15', NULL, NULL, NULL, '2025-08-21 10:40:15'),
(57, 'invoice.created', '68a6f791f8a9ea6a913f6ce1', NULL, 'invoice-1755772815-6830', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a6f791f8a9ea6a913f6ce1\",\"expiry_date\":\"2025-08-22 18:40:17\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-21 18:40:17', '2025-08-21 18:40:17', NULL, NULL, NULL, '2025-08-21 10:40:17'),
(58, 'invoice.created', '68a6f937a38788dceaa301ad', NULL, 'invoice-1755773238-6407', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a6f937a38788dceaa301ad\",\"expiry_date\":\"2025-08-22 18:47:19\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-21 18:47:19', '2025-08-21 18:47:19', NULL, NULL, NULL, '2025-08-21 10:47:19'),
(59, 'invoice.created', '68a6f938a38788dceaa301b6', NULL, 'invoice-1755773239-8128', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a6f938a38788dceaa301b6\",\"expiry_date\":\"2025-08-22 18:47:21\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-21 18:47:21', '2025-08-21 18:47:21', NULL, NULL, NULL, '2025-08-21 10:47:21'),
(60, 'invoice.created', '68a71529f8a9ea6a913f999c', NULL, 'invoice-1755780393-4979', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a71529f8a9ea6a913f999c\",\"expiry_date\":\"2025-08-22 20:46:34\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-21 20:46:34', '2025-08-21 20:46:34', NULL, NULL, NULL, '2025-08-21 12:46:34'),
(61, 'invoice.created', '68a7158aa38788dceaa32827', NULL, 'invoice-1755780489-8152', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a7158aa38788dceaa32827\",\"expiry_date\":\"2025-08-22 20:48:10\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-21 20:48:11', '2025-08-21 20:48:11', NULL, NULL, NULL, '2025-08-21 12:48:11'),
(62, 'invoice.created', '68a7158cf8a9ea6a913f9a37', NULL, 'invoice-1755780491-7353', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a7158cf8a9ea6a913f9a37\",\"expiry_date\":\"2025-08-22 20:48:12\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-21 20:48:13', '2025-08-21 20:48:13', NULL, NULL, NULL, '2025-08-21 12:48:13'),
(63, 'invoice.created', '68a71790de2a63b45a456453', NULL, 'invoice-1755781007-4213', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a71790de2a63b45a456453\",\"expiry_date\":\"2025-08-22 20:56:49\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-21 20:56:49', '2025-08-21 20:56:49', NULL, NULL, NULL, '2025-08-21 12:56:49'),
(64, 'invoice.created', '68a82ee50ab65146db0cebfc', NULL, 'invoice-1755852516-2585', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a82ee50ab65146db0cebfc\",\"expiry_date\":\"2025-08-23 16:48:37\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-22 16:48:37', '2025-08-22 16:48:37', NULL, NULL, NULL, '2025-08-22 08:48:37'),
(65, 'invoice.created', '68a83b48f8a9ea6a91417b60', NULL, 'invoice-1755855687-8164', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a83b48f8a9ea6a91417b60\",\"expiry_date\":\"2025-08-23 17:41:29\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-22 17:41:29', '2025-08-22 17:41:29', NULL, NULL, NULL, '2025-08-22 09:41:29'),
(66, 'invoice.created', '68a89b8ef8a9ea6a9141f817', NULL, 'invoice-1755880333-2020', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a89b8ef8a9ea6a9141f817\",\"expiry_date\":\"2025-08-24 00:32:15\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-23 00:32:15', '2025-08-23 00:32:15', NULL, NULL, NULL, '2025-08-22 16:32:15'),
(67, 'invoice.created', '68a8b109f8a9ea6a91421e4f', NULL, 'invoice-1755885833-5858', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a8b109f8a9ea6a91421e4f\",\"expiry_date\":\"2025-08-24 02:03:54\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-23 02:03:54', '2025-08-23 02:03:54', NULL, NULL, NULL, '2025-08-22 18:03:54'),
(68, 'invoice.created', '68a8cfebf8a9ea6a9142533a', NULL, 'invoice-1755893738-2835', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a8cfebf8a9ea6a9142533a\",\"expiry_date\":\"2025-08-24 04:15:39\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-23 04:15:39', '2025-08-23 04:15:39', NULL, NULL, NULL, '2025-08-22 20:15:39'),
(69, 'invoice.created', '68a8d7c4f8a9ea6a91425ff6', NULL, 'invoice-1755895745-1372', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68a8d7c4f8a9ea6a91425ff6\",\"expiry_date\":\"2025-08-24 04:49:08\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-23 04:49:06', '2025-08-23 04:49:06', NULL, NULL, NULL, '2025-08-22 20:49:06'),
(70, 'invoice.created', '68b01e38d061d6a3e8f91ca7', NULL, 'invoice-1756372535-9796', 1000.00, NULL, NULL, 'PHP', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arcjdatario@gmail.com', 'PH', 'Test Payment Invoice', NULL, NULL, NULL, '{\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/68b01e38d061d6a3e8f91ca7\",\"expiry_date\":\"2025-08-29 17:15:36\"}', NULL, '[{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"SHOPEEPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GCASH\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"GRABPAY\"},{\"type\":\"E-WALLET\",\"name\":\"\",\"channel_code\":\"PAYMAYA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"7ELEVEN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"CEBUANA\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_MLHUILLIER\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_ECPAY_LOAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"DP_PALAWAN\"},{\"type\":\"RETAIL\",\"name\":\"\",\"channel_code\":\"LBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UBP\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_EPAY\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BDO_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BPI_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_UNIONBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_BOC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_CHINABANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_INSTAPAY_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_LANDBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_MAYBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_METROBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PNB_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PSBANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_PESONET_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_RCBC_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_ROBINSONS_BANK_ONLINE_BANKING\"},{\"type\":\"DIRECT_DEBIT\",\"name\":\"\",\"channel_code\":\"DD_SECURITY_BANK_ONLINE_BANKING\"}]', '2025-08-28 17:15:37', '2025-08-28 17:15:37', NULL, NULL, NULL, '2025-08-28 09:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `subs_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `plan_name`, `badge`, `price`, `subs_count`, `created_at`) VALUES
(4, 'Plan 1599', 'premium', 1599.00, 0, '2025-08-17 19:06:04'),
(5, 'Plan 1599', 'top rated', 1599.00, 0, '2025-08-17 19:06:26'),
(9, '999', 'popular', 999.00, 0, '2025-08-17 20:14:34'),
(11, 'Plan 699', '', 699.00, 0, '2025-08-22 19:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` text NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `subscription_count` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `user_id`, `full_name`, `email`, `address`, `phone`, `status`, `profile`, `subscription_count`, `created_at`) VALUES
(7, '5GNCD07A3V', 'Arc Datario', 'datarioarc16@gmail.com', 'East Center', '09761125698', 'Active', NULL, 2, '2025-08-22 20:18:51'),
(8, '1P0YIRR61N', 'Denison', 'denisonpaoloabergas@gmail.com', 'East Center', '09996549965', 'Active', NULL, 1, '2025-08-26 18:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `started_date` date NOT NULL,
  `continue_date` date DEFAULT NULL,
  `due_date` date NOT NULL,
  `status` varchar(50) DEFAULT 'Active',
  `is_advanced` int(11) NOT NULL,
  `paid_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `reference`, `address`, `started_date`, `continue_date`, `due_date`, `status`, `is_advanced`, `paid_count`, `created_at`) VALUES
(10, 7, 4, 'S1DAVYPWW7', 'East Center', '2025-08-23', NULL, '2025-09-23', 'Active', 0, 0, '2025-08-22 20:22:08'),
(11, 7, 5, '1DJG999PTR', 'East Center', '2025-08-23', NULL, '2025-09-23', 'Active', 0, 0, '2025-08-22 21:09:35'),
(12, 8, 4, 'SF2S9X2WX4', 'East Center', '2025-08-27', NULL, '2025-09-27', 'Active', 0, 0, '2025-08-26 18:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reference_number` varchar(100) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_method_code` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `xendit_id` varchar(100) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `business_id` varchar(100) DEFAULT NULL,
  `payment_request_id` varchar(100) DEFAULT NULL,
  `payment_token_id` varchar(100) DEFAULT NULL,
  `customer_id` varchar(100) DEFAULT NULL,
  `xendit_response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `invoice_url` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `payer_email` varchar(100) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'PHP',
  `capture_method` varchar(50) DEFAULT NULL,
  `payment_channel` varchar(50) DEFAULT NULL,
  `payment_destination` varchar(100) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `payment_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inclusions`
--
ALTER TABLE `inclusions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_payment_id` (`payment_id`),
  ADD KEY `idx_external_id` (`external_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_time` (`created_time_gmt8`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_id` (`subscription_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inclusions`
--
ALTER TABLE `inclusions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inclusions`
--
ALTER TABLE `inclusions`
  ADD CONSTRAINT `inclusions_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
