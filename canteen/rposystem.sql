-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 01:17 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rposystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchase_detail`
--

CREATE TABLE `purchase_detail` (
  `pdid` int(11) NOT NULL,
  `order_id` varchar(20) NOT NULL,
  `prod_id` varchar(20) NOT NULL,
  `prod_qty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_detail`
--

INSERT INTO `purchase_detail` (`pdid`, `order_id`, `prod_id`, `prod_qty`) VALUES
(13, '8', '15', '2'),
(14, '8', '17', '2'),
(15, '8', '18', '2'),
(16, '9', '15', '3'),
(17, '10', '15', '1'),
(18, '10', '21', '2'),
(19, '0', '06dc36c1be', ''),
(20, '0', '0c4b5c0604', ''),
(21, '0', '06dc36c1be', '1'),
(22, '0', '0c4b5c0604', '2'),
(23, 'ea04ceec1b', '06dc36c1be', '4'),
(24, 'ea04ceec1b', '0c4b5c0604', '5'),
(25, 'b4b2a0ff2f', '0c4b5c0604', '4'),
(26, 'f205b95df8', '06dc36c1be', '1'),
(27, 'f205b95df8', '0c4b5c0604', '2'),
(28, 'f205b95df8', '14c7b6370e', '3'),
(29, '361ecbc214', '06dc36c1be', '2'),
(30, 'bb86a1092b', '06dc36c1be', '3'),
(31, 'bb86a1092b', '14c7b6370e', '1'),
(32, 'bb86a1092b', '1e0fa41eee', '2'),
(33, '0fbb77a32b', '06dc36c1be', '1'),
(34, '0fbb77a32b', '0c4b5c0604', '1'),
(35, 'd748c47aa3', '06dc36c1be', '1'),
(36, 'd748c47aa3', '0c4b5c0604', '2'),
(37, 'dfc3cd0d56', '14c7b6370e', '1'),
(38, 'b3540cc02a', '2b976e49a0', '1'),
(39, '9fa6645cee', '', ''),
(40, '9fa6645cee', '', ''),
(41, 'e22d946e3f', '', ''),
(42, 'e22d946e3f', '', ''),
(43, '2dfc4dae25', '', ''),
(44, '2dfc4dae25', '', ''),
(45, '2dfc4dae25', '', ''),
(46, 'd65b9409b6', '', ''),
(47, 'd65b9409b6', '', ''),
(48, 'c406972bc5', '06dc36c1be', '2'),
(49, 'c406972bc5', '0c4b5c0604', '3'),
(50, '024141c7de', '06dc36c1be', '1'),
(51, '024141c7de', '0c4b5c0604', '1'),
(52, '69a65a28d3', '06dc36c1be', '1'),
(53, '69a65a28d3', '0c4b5c0604', '1'),
(54, '4208cf0a99', '06dc36c1be', '2'),
(55, '4208cf0a99', '14c7b6370e', '2'),
(56, 'b5f3ff7a91', '06dc36c1be', '1'),
(57, 'b5f3ff7a91', '0c4b5c0604', '1');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_admin`
--

CREATE TABLE `rpos_admin` (
  `admin_id` varchar(200) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rpos_admin`
--

INSERT INTO `rpos_admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
('10e0b6dc958adfb5b094d8935a13aeadbe783c25', 'Trex', 'admin@mail.com', '772372450f30b6d06b60aad4f073c6cbd111be0a');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_customers`
--

CREATE TABLE `rpos_customers` (
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_phoneno` varchar(200) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `rewards` double NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rpos_customers`
--

INSERT INTO `rpos_customers` (`customer_id`, `customer_name`, `customer_phoneno`, `customer_email`, `customer_password`, `created_at`, `rewards`, `role`) VALUES
('06549ea58afd', 'Ana J. Browne', '4589698780', 'anaj@mail.com', '55c3b5386c486feb662a0785f340938f518d547f', '2022-09-03 12:39:48.523820', 0, 0),
('1fc1f694985d', 'Jane Doe', '2145896547', 'janed@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', '2022-09-03 13:39:13.076592', 0, 0),
('27e4a5bc74c2', 'Tammy R. Polley', '4589654780', 'tammy@mail.com', '772372450f30b6d06b60aad4f073c6cbd111be0a', '2025-02-25 23:53:34.561813', 1.25, 0),
('29c759d624f9', 'Trina L. Crowder', '5896321002', 'trina@mail.com', '772372450f30b6d06b60aad4f073c6cbd111be0a', '2024-12-14 11:13:56.858794', 0.61, 1),
('35135b319ce3', 'Christine Moore', '2342569698', 'cust23@mail.com', '', '2025-02-08 05:54:04.464602', 1.98, 1),
('3859d26cd9a5', 'Louise R. Holloman', '7856321000', 'holloman@mail.com', '55c3b5386c486feb662a0785f340938f518d547f', '2022-09-03 12:38:12.149280', 0, 0),
('4c33ef81834a', 'sample', '1212121212', 'cust3@mail.com', '772372450f30b6d06b60aad4f073c6cbd111be0a', '2024-12-19 12:07:51.504535', 0, 1),
('57b7541814ed', 'Howard W. Anderson', '8745554589', 'howard@mail.com', '55c3b5386c486feb662a0785f340938f518d547f', '2022-09-03 08:35:10.959590', 0, 0),
('7c8f2100d552', 'Melody E. Hance', '3210145550', 'melody@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', '2022-09-03 13:16:23.996068', 0, 0),
('9c7fcc067bda', 'Delbert G. Campbell', '7850001256', 'delbert@mail.com', '55c3b5386c486feb662a0785f340938f518d547f', '2022-09-03 12:38:56.944364', 0, 0),
('9f6378b79283', 'William C. Gallup', '7145665870', 'william@mail.com', '55c3b5386c486feb662a0785f340938f518d547f', '2022-09-03 12:39:26.507932', 0, 0),
('a19109ab8e60', 'Julsz Calibre', '12121212', '19410054@cic.edu.ph', '772372450f30b6d06b60aad4f073c6cbd111be0a', '2025-03-18 01:28:59.837271', 0.65, 0),
('a1dbcf482163', 'Faculty1', '0992991221', '21310090@cic.edu.ph', '772372450f30b6d06b60aad4f073c6cbd111be0a', '2025-02-26 00:30:34.665558', 2.14, 1),
('d0ba61555aee', 'Jamie R. Barnes', '4125556587', 'jamie@mail.com', '55c3b5386c486feb662a0785f340938f518d547f', '2022-09-03 12:36:59.643216', 0, 0),
('d7c2db8f6cbf', 'Victor A. Pierson', '1458887896', 'victor@mail.com', '55c3b5386c486feb662a0785f340938f518d547f', '2024-12-14 11:19:33.475416', 1.74, 0),
('e711dcc579d9', 'Julie R. Martin', '3245557896', 'julie@mail.com', '772372450f30b6d06b60aad4f073c6cbd111be0a', '2024-12-16 02:52:04.623067', 0.73, 0),
('fe6bb69bdd29', 'Brian S. Boucher', '1020302055', 'brians@mail.com', 'a69681bcf334ae130217fea4505fd3c994f5683f', '2022-09-03 13:16:29.591980', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rpos_orders`
--

CREATE TABLE `rpos_orders` (
  `order_id` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `prod_id` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `prod_qty` varchar(200) NOT NULL,
  `order_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rpos_orders`
--

INSERT INTO `rpos_orders` (`order_id`, `order_code`, `customer_id`, `customer_name`, `prod_id`, `prod_name`, `prod_price`, `prod_qty`, `order_status`, `created_at`) VALUES
('019661e097', 'AEHM-0653', '06549ea58afd', 'Ana J. Browne', 'bd200ef837', 'Turkish Coffee', '8', '1', 'Paid', '2022-09-03 13:26:00.389027'),
('024141c7de', 'VTWN-9761', '1fc1f694985d', 'Jane Doe', 'e769e274a3', '08:45', '0', '0', '', '2025-02-25 23:46:04.837502'),
('059138d669', 'UOAZ-6791', '35135b319ce3', 'Christine Moore', 'e769e274a3', 'Frappuccino', '3', '4', 'Paid', '2024-12-09 11:56:59.344275'),
('0fbb77a32b', 'UWQS-3217', '35135b319ce3', 'Christine Moore', 'e769e274a3', '11:30', '65', '0', 'Paid', '2024-12-14 11:30:59.685359'),
('0feda2b788', 'TYFW-4386', 'e711dcc579d9', 'Julie R. Martin', '06dc36c1be', 'Philly Cheesesteak', '7', '3', 'Paid', '2024-12-12 11:59:16.216477'),
('2509df3db9', 'HPJY-4251', '35135b319ce3', 'Christine Moore', '06dc36c1be', 'Philly Cheesesteak', '7', '3', 'Paid', '2024-12-12 12:55:45.609001'),
('361ecbc214', 'USPE-1682', '35135b319ce3', 'Christine Moore', 'e769e274a3', '11:30', '14', '0', 'Paid', '2024-12-14 04:15:39.158075'),
('4208cf0a99', 'WBXH-4769', 'a1dbcf482163', 'Faculty1', 'e769e274a3', '10:22', '214', '0', 'Paid', '2025-02-26 00:30:34.663358'),
('49c1bd8086', 'IUSP-9453', 'fe6bb69bdd29', 'Brian S. Boucher', 'd57cd89073', 'Country Fried Steak', '10', '1', 'Paid', '2022-09-03 11:50:40.812796'),
('514ada5047', 'OTEV-8532', '3859d26cd9a5', 'Louise R. Holloman', '0c4b5c0604', 'Spaghetti Bolognese', '15', '1', 'Paid', '2022-09-03 13:13:39.042869'),
('5dff3525b1', 'DGAY-4389', 'e711dcc579d9', 'Julie R. Martin', '0c4b5c0604', 'Spaghetti Bolognese', '15', '1', 'Paid', '2024-12-12 12:52:55.727830'),
('6466fd5ee5', 'COXP-6018', '7c8f2100d552', 'Melody E. Hance', '31dfcc94cf', 'Buffalo Wings', '11', '2', 'Paid', '2022-09-03 12:17:44.680896'),
('69a65a28d3', 'JUQD-3758', '27e4a5bc74c2', 'Tammy R. Polley', 'e769e274a3', '09:54', '65', '0', 'Paid', '2025-02-25 23:53:34.560325'),
('739fa374f5', 'QTEB-3560', '1fc1f694985d', 'Jane Doe', '06dc36c1be', 'Philly Cheesesteak', '7', '2', 'Paid', '2024-12-09 11:53:11.902767'),
('80ab270866', 'JFMB-0731', '35135b319ce3', 'Christine Moore', '97972e8d63', 'Irish Coffee', '11', '1', 'Paid', '2022-09-04 16:37:03.716697'),
('8815e7edfc', 'QOEH-8613', '29c759d624f9', 'Trina L. Crowder', '2b976e49a0', 'Cheeseburger', '3', '3', 'Paid', '2022-09-03 12:02:32.985451'),
('88ce0f449a', 'SFOP-8046', '35135b319ce3', 'Christine Moore', '06dc36c1be', 'Philly Cheesesteak', '7', '2', 'Paid', '2024-12-12 12:48:14.379220'),
('91d5162b1e', 'SADV-7426', '35135b319ce3', 'Christine Moore', '0c4b5c0604', 'Spaghetti Bolognese', '15', '4', 'Paid', '2024-12-12 12:44:07.042803'),
('974203e1cd', 'UWMJ-8351', '35135b319ce3', 'Christine Moore', 'e769e274a3', 'Frappuccino', '3', '3', 'Paid', '2024-12-03 10:54:40.116573'),
('a27f1d87be', 'EJKA-4501', '35135b319ce3', 'Christine Moore', 'ec18c5a4f0', 'Corn Dogs', '4', '2', 'Paid', '2022-09-04 16:31:54.581984'),
('a74337db7e', 'ZPXD-6951', 'e711dcc579d9', 'Julie R. Martin', 'a5931158fe', 'Pulled Pork', '8', '2', 'Paid', '2022-09-03 13:12:47.079248'),
('aad97a28b1', 'EOLF-4581', 'fe6bb69bdd29', 'Brian S. Boucher', '06dc36c1be', 'Philly Cheesesteak', '7', '3', 'Paid', '2024-12-03 11:14:56.325068'),
('ae1e00dccd', 'DGTK-7189', 'e711dcc579d9', 'Julie R. Martin', '0c4b5c0604', 'Spaghetti Bolognese', '15', '2', 'Paid', '2024-12-12 12:00:23.683587'),
('af52d0022d', 'FNAB-9142', '35135b319ce3', 'Christine Moore', '2fdec9bdfb', 'Jambalaya', '9', '2', 'Paid', '2022-09-04 16:32:14.949302'),
('b3540cc02a', 'NXPO-4315', '35135b319ce3', 'Christine Moore', 'e769e274a3', '11:41', '3', '0', 'Paid', '2025-02-08 05:54:04.460281'),
('b4b2a0ff2f', 'TCHE-2039', '27e4a5bc74c2', 'Tammy R. Polley', 'e769e274a3', 'N/A', '60', '0', 'Paid', '2024-12-13 02:10:26.070201'),
('b5f3ff7a91', 'NYXT-8379', 'a19109ab8e60', 'Julsz Calibre', 'e769e274a3', '10:20', '65', '0', 'Paid', '2025-03-18 01:28:59.835879'),
('bb86a1092b', 'FWYD-5296', 'd7c2db8f6cbf', 'Victor A. Pierson', 'e769e274a3', '11:21', '174', '0', 'Paid', '2024-12-14 11:19:33.471241'),
('c051fc38eb', 'ONSY-2465', '57b7541814ed', 'Howard W. Anderson', '826e6f687f', 'Margherita Pizza', '12', '1', 'Paid', '2022-09-03 08:35:50.570496'),
('d062fb6926', 'RSND-0413', '35135b319ce3', 'Christine Moore', '06dc36c1be', 'Philly Cheesesteak', '7', '3', 'Paid', '2024-12-12 12:49:32.912647'),
('d0fa918097', 'GLEW-5381', '1fc1f694985d', 'Jane Doe', '06dc36c1be', 'Philly Cheesesteak', '7', '3', 'Paid', '2024-11-29 00:02:08.221729'),
('d748c47aa3', 'MTVX-1524', '35135b319ce3', 'Christine Moore', 'e769e274a3', '10:35', '80', '0', '', '2025-01-03 00:35:40.925398'),
('dfc3cd0d56', 'CWKV-2130', '35135b319ce3', 'Christine Moore', 'e769e274a3', '11:39', '57', '0', '', '2025-01-03 00:36:24.703968'),
('e7598591fc', 'AWQF-9687', 'e711dcc579d9', 'Julie R. Martin', '06dc36c1be', 'Philly Cheesesteak', '7', '3', 'Paid', '2024-12-16 02:52:04.620640'),
('f205b95df8', 'NOZX-7631', '29c759d624f9', 'Trina L. Crowder', 'e769e274a3', 'N/A', '61', '0', 'Paid', '2024-12-13 03:22:16.103247'),
('fc79a55455', 'INHG-0875', '9c7fcc067bda', 'Delbert G. Campbell', '3adfdee116', 'Enchiladas', '10', '1', 'Paid', '2022-09-04 16:35:22.539542');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_pass_resets`
--

CREATE TABLE `rpos_pass_resets` (
  `reset_id` int(20) NOT NULL,
  `reset_code` varchar(200) NOT NULL,
  `reset_token` varchar(200) NOT NULL,
  `reset_email` varchar(200) NOT NULL,
  `reset_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rpos_pass_resets`
--

INSERT INTO `rpos_pass_resets` (`reset_id`, `reset_code`, `reset_token`, `reset_email`, `reset_status`, `created_at`) VALUES
(1, '63KU9QDGSO', '4ac4cee0a94e82a2aedc311617aa437e218bdf68', 'sysadmin@icofee.org', 'Pending', '2020-08-17 15:20:14.318643');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_payments`
--

CREATE TABLE `rpos_payments` (
  `pay_id` varchar(200) NOT NULL,
  `pay_code` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `pay_amt` varchar(200) NOT NULL,
  `pay_method` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `pay_ref` varchar(60) NOT NULL,
  `pay_proof` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rpos_payments`
--

INSERT INTO `rpos_payments` (`pay_id`, `pay_code`, `order_code`, `customer_id`, `pay_amt`, `pay_method`, `created_at`, `pay_ref`, `pay_proof`) VALUES
('0bf592', '9UMWLG4BF8', 'EJKA-4501', '35135b319ce3', '8', 'Cash', '2022-09-04 16:31:54.525284', '', ''),
('0d083e', 'KWMFB2NR20', 'USPE-1682', '35135b319ce3', '14', 'Cash', '2024-12-14 04:15:39.156079', 'N/A', ''),
('0eabc2', '9E8BF5DZTV', 'JUQD-3758', '27e4a5bc74c2', '65', 'Cash', '2025-02-25 23:53:34.558407', '1222122', ''),
('2cece5', 'JUTKGR9NS1', 'NXPO-4315', '35135b319ce3', '3', 'Cash', '2025-02-08 05:54:04.454167', '39991223', ''),
('347252', 'HEYVPJ7UT1', 'AWQF-9687', 'e711dcc579d9', '7', 'Cash', '2024-12-16 02:52:04.609494', 'N/A', ''),
('4423d7', 'QWERT0YUZ1', 'JFMB-0731', '35135b319ce3', '11', 'Cash', '2022-09-04 16:37:03.655834', '', ''),
('442865', '146XLFSC9V', 'INHG-0875', '9c7fcc067bda', '10', 'Paypal', '2022-09-04 16:35:22.470600', '', ''),
('5ae25c', '8TEXOSKJ42', 'FWYD-5296', 'd7c2db8f6cbf', '174', 'Gcash', '2024-12-14 11:19:33.467854', '667212', 'Screenshot 2024-10-11 145452.png'),
('5eb00f', 'KWMFB2NRY6', 'NYXT-8379', 'a19109ab8e60', '65', 'Cash', '2025-03-18 01:28:59.833276', '8882999122', ''),
('65891b', 'MF2TVJA1PY', 'ZPXD-6951', 'e711dcc579d9', '16', 'Cash', '2022-09-03 13:12:46.959558', '', ''),
('65c55f', 'OQ5GCBD3TK', 'UWMJ-8351', '35135b319ce3', '9', 'Paypal', '2024-12-03 10:54:40.112707', '', ''),
('749279', 'CFK6VPANB7', 'EOLF-4581', 'fe6bb69bdd29', '21', 'Cash', '2024-12-03 11:14:56.321350', '', ''),
('75ae21', '1QIKVO69SA', 'IUSP-9453', 'fe6bb69bdd29', '10', 'Cash', '2022-09-03 11:50:40.496625', '', ''),
('7a1303', 'DCLOZBV13K', 'NOZX-7631', '29c759d624f9', '61', 'Cash', '2024-12-13 03:22:16.101573', 'N/A', ''),
('7e1989', 'KLTF3YZHJP', 'QOEH-8613', '29c759d624f9', '9', 'Cash', '2022-09-03 12:02:32.926529', '', ''),
('9427ed', 'XY8MOA9NT3', 'TYFW-4386', 'e711dcc579d9', '21', 'Cash', '2024-12-12 11:59:16.212046', 'N/A', ''),
('9609ca', 'TOMLQK4FV2', 'UWQS-3217', '35135b319ce3', '65', 'Gcash', '2024-12-14 11:30:59.682817', '45621122', 'Screenshot 2024-10-11 145452.png'),
('968488', '5E31DQ2NCG', 'COXP-6018', '7c8f2100d552', '22', 'Cash', '2022-09-03 12:17:44.639979', '', ''),
('984539', 'LSBNK1WRFU', 'FNAB-9142', '35135b319ce3', '18', 'Paypal', '2022-09-04 16:32:14.852482', '', ''),
('9dc522', 'RYL7MSH5BG', 'TCHE-2039', '27e4a5bc74c2', '60', 'Gcash', '2024-12-13 02:10:26.068343', '231222', 'image (6).png'),
('9fcee7', 'AZSUNOKEI7', 'OTEV-8532', '3859d26cd9a5', '15', 'Cash', '2022-09-03 13:13:38.855058', '', ''),
('a370d1', '9UXFYA3LKS', 'DGTK-7189', 'e711dcc579d9', '30', 'Cash', '2024-12-12 12:00:23.681262', 'N/A', ''),
('a8ac0c', 'EABHXUDC22', 'HPJY-4251', '35135b319ce3', '21', 'Gcash', '2024-12-12 12:55:45.606241', '232311', 'Screenshot 2024-10-24 112150.png'),
('b94d89', 'D3UI7QGR1N', 'DGAY-4389', 'e711dcc579d9', '15', 'Cash', '2024-12-12 12:52:55.724511', 'N/A', 'Screenshot 2024-10-24 112150.png'),
('c5616e', 'KWMFB2N2Y9', 'WBXH-4769', 'a1dbcf482163', '214', 'Cash', '2025-02-26 00:30:34.660042', 'Samp11', ''),
('c81d2e', 'WERGFCXZSR', 'AEHM-0653', '06549ea58afd', '8', 'Cash', '2022-09-03 13:26:00.331494', '', ''),
('cde9d8', 'TOMLQK4FV7', 'QTEB-3560', '1fc1f694985d', '14', 'Cash', '2024-12-09 11:53:11.899600', '122122', 'Screenshot 2024-10-26 212310.png'),
('e46e29', 'QMCGSNER3T', 'ONSY-2465', '57b7541814ed', '12', 'Cash', '2022-09-03 08:35:50.172062', '', ''),
('e6bd6e', 'BQO1JH5MVK', 'GLEW-5381', '1fc1f694985d', '21', 'Paypal', '2024-11-29 00:02:08.217944', '', ''),
('f7fbca', '123ABCXATY', 'UOAZ-6791', '35135b319ce3', '12', 'Cash', '2024-12-09 11:56:59.342536', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_products`
--

CREATE TABLE `rpos_products` (
  `prod_id` varchar(200) NOT NULL,
  `prod_code` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_img` varchar(200) NOT NULL,
  `prod_desc` longtext NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rpos_products`
--

INSERT INTO `rpos_products` (`prod_id`, `prod_code`, `prod_name`, `prod_img`, `prod_desc`, `prod_price`, `created_at`, `status`) VALUES
('06dc36c1be', 'FCWU-5762', 'Philly Cheesesteak', '', 'A cheesesteak is a sandwich made from thinly sliced pieces of beefsteak and melted cheese in a long hoagie roll. A popular regional fast food, it has its roots in the U.S. city of Philadelphia, Pennsylvania.', '50', '2024-12-14 11:16:40.030825', 0),
('0c4b5c0604', 'JRZN-9518', 'Spaghetti Bolognese', '', 'Spaghetti bolognese consists of spaghetti (long strings of pasta) with an Italian ragÃ¹ (meat sauce) made with minced beef, bacon and tomatoes, served with Parmesan cheese. Spaghetti bolognese is one of the most popular pasta dishes eaten outside of Italy.', '15', '2024-12-16 12:03:37.006689', 0),
('14c7b6370e', 'QZHM-0391', 'Reuben Sandwich', 'reubensandwich.jpg', 'The Reuben sandwich is a North American grilled sandwich composed of corned beef, Swiss cheese, sauerkraut, and Thousand Island dressing or Russian dressing, grilled between slices of rye bread. It is associated with kosher-style delicatessens, but is not kosher because it combines meat and cheese.', '57', '2024-12-15 13:01:35.544453', 0),
('1e0fa41eee', 'ICFU-1406', 'Submarine Sandwich', 'submarine_sndwh.jpg', 'A submarine sandwich, commonly known as a sub, hoagie, hero, Italian, grinder, wedge, or a spuckie, is a type of American cold or hot sandwich made from a cylindrical bread roll split lengthwise and filled with meats, cheeses, vegetables, and condiments. It has many different names.', '8', '2024-12-15 13:00:59.928822', 1),
('2b976e49a0', 'CEWV-9438', 'Cheeseburger', 'cheeseburgers.jpg', 'A cheeseburger is a hamburger topped with cheese. Traditionally, the slice of cheese is placed on top of the meat patty. The cheese is usually added to the cooking hamburger patty shortly before serving, which allows the cheese to melt. Cheeseburgers can include variations in structure, ingredients and composition.', '3', '2022-09-03 10:45:47.282634', 0),
('2fdec9bdfb', 'UJAK-9614', 'Jambalaya', 'Jambalaya.jpg', 'Jambalaya is an American Creole and Cajun rice dish of French, African, and Spanish influence, consisting mainly of meat and vegetables mixed with rice.', '9', '2022-09-03 10:48:49.593618', 0),
('31dfcc94cf', 'SYQP-3710', 'Buffalo Wings', 'buffalo_wings.jpg', 'A Buffalo wing in American cuisine is an unbreaded chicken wing section that is generally deep-fried and then coated or dipped in a sauce consisting of a vinegar-based cayenne pepper hot sauce and melted butter prior to serving.', '11', '2022-09-03 10:51:09.829079', 0),
('3adfdee116', 'HIPF-5346', 'Enchiladas', 'enchiladas.jpg', 'An enchilada is a corn tortilla rolled around a filling and covered with a savory sauce. Originally from Mexican cuisine, enchiladas can be filled with various ingredients, including meats, cheese, beans, potatoes, vegetables, or combinations', '10', '2022-09-03 12:52:26.427554', 0),
('3d19e0bf27', 'EMBH-6714', 'Cincinnati Chili', 'cincinnatichili.jpg', 'Cincinnati chili is a Mediterranean-spiced meat sauce used as a topping for spaghetti or hot dogs; both dishes were developed by immigrant restaurateurs in the 1920s. In 2013, Smithsonian named one local chili parlor one of the \"20 Most Iconic Food Destinations in America\".', '9', '2022-09-03 12:57:39.265554', 0),
('4e68e0dd49', 'QLKW-0914', 'Caramel Macchiato', '', 'Steamed milk, espresso and caramel; what could be more enticing? This blissful flavor is a favorite of coffee lovers due to its deliciously bold taste of creamy caramel and strong coffee flavor. These', '4', '2022-09-03 08:55:51.237667', 0),
('5d66c79953', 'GOEW-9248', 'Cheese Curd', 'cheesecurd.jpg', 'Cheese curds are moist pieces of curdled milk, eaten either alone or as a snack, or used in prepared dishes. These are chiefly found in Quebec, in the dish poutine, throughout Canada, and in the northeastern, midwestern, mountain, and Pacific Northwestern United States, especially in Wisconsin and Minnesota.', '6', '2022-09-03 11:22:25.639690', 0),
('826e6f687f', 'AYFW-2683', 'Margherita Pizza', 'margherita-pizza0.jpg', 'Pizza margherita, as the Italians call it, is a simple pizza hailing from Naples. When done right, margherita pizza features a bubbly crust, crushed San Marzano tomato sauce, fresh mozzarella and basil, a drizzle of olive oil, and a sprinkle of salt.', '12', '2022-09-03 08:02:57.213354', 0),
('97972e8d63', 'CVWJ-6492', 'Irish Coffee', 'irishcoffee.jpg', 'Irish coffee is a caffeinated alcoholic drink consisting of Irish whiskey, hot coffee, and sugar, stirred, and topped with cream The coffee is drunk through the cream', '11', '2022-09-03 13:08:19.157649', 0),
('a419f2ef1c', 'EPNX-3728', 'Chicken Nugget', 'chicnuggets.jpeg', 'A chicken nugget is a food product consisting of a small piece of deboned chicken meat that is breaded or battered, then deep-fried or baked. Invented in the 1950s, chicken nuggets have become a very popular fast food restaurant item, as well as widely sold frozen for home use', '5', '2022-09-03 12:44:07.749371', 0),
('a5931158fe', 'ELQN-5204', 'Pulled Pork', 'pulledprk.jpeg', 'Pulled pork is an American barbecue dish, more specifically a dish of the Southern U.S., based on shredded barbecued pork shoulder. It is typically slow-smoked over wood; indoor variations use a slow cooker. The meat is then shredded manually and mixed with a sauce', '8', '2022-09-03 13:04:12.191403', 0),
('b2f9c250fd', 'XNWR-2768', 'Strawberry Rhubarb Pie', 'rhuharbpie.jpg', 'Rhubarb pie is a pie with a rhubarb filling. Popular in the UK, where rhubarb has been cultivated since the 1600s, and the leaf stalks eaten since the 1700s. Besides diced rhubarb, it almost always contains a large amount of sugar to balance the intense tartness of the plant', '7', '2022-09-03 13:06:28.235333', 0),
('bd200ef837', 'HEIY-6034', 'Turkish Coffee', 'turkshcoffee.jpg', 'Turkish coffee is a style of coffee prepared in a cezve using very finely ground coffee beans without filtering.', '8', '2022-09-03 13:09:50.234898', 0),
('cff0cb495a', 'ZOBW-2640', 'Americano', '', 'Many espresso-based drinks use milk, but not the cafÃ© Americano â€“ or simply \'Americano\'. The drink also uses espresso but is infused with hot water instead of milk. The result is a coffee beverage ', '3', '2022-09-03 08:56:18.824990', 0),
('d57cd89073', 'ZGQW-9480', 'Country Fried Steak', 'country_fried_stk.jpg', 'Chicken-fried steak, also known as country-fried steak or CFS, is an American breaded cutlet dish consisting of a piece of beefsteak coated with seasoned flour and either deep-fried or pan-fried. It is sometimes associated with the Southern cuisine of the United States.', '10', '2022-09-03 11:00:05.523519', 0),
('d9aed17627', 'FIKD-9703', 'Crab Cake', 'crabcakes.jpg', 'A crab cake is a variety of fishcake that is popular in the United States. It is composed of crab meat and various other ingredients, such as bread crumbs, mayonnaise, mustard, eggs, and seasonings. The cake is then sautÃ©ed, baked, grilled, deep fried, or broiled.', '16', '2022-09-03 12:54:52.120847', 0),
('e2195f8190', 'HKCR-2178', 'Carbonara', 'carbonaraimgre.jpg', 'Carbonara is an Italian pasta dish from Rome made with eggs, hard cheese, cured pork, and black pepper. The dish arrived at its modern form, with its current name, in the middle of the 20th century. The cheese is usually Pecorino Romano, Parmigiano-Reggiano, or a combination of the two.', '16', '2022-09-03 10:23:06.266420', 0),
('e2af35d095', 'IDLC-7819', 'Pepperoni Pizza', 'peperopizza.jpg', 'Pepperoni is an American variety of spicy salami made from cured pork and beef seasoned with paprika or other chili pepper. Prior to cooking, pepperoni is characteristically soft, slightly smoky, and bright red. Thinly sliced pepperoni is one of the most popular pizza toppings in American pizzerias.', '7', '2022-09-03 12:49:01.017677', 0),
('e769e274a3', 'AHRW-3894', 'Frappuccino', 'frappuccino.jpg', 'Frappuccino is a line of blended iced coffee drinks sold by Starbucks. It consists of coffee or crÃ¨me base, blended with ice and ingredients such as flavored syrups and usually topped with whipped cream and or spices.', '3', '2022-09-03 13:11:30.109467', 0),
('ec18c5a4f0', 'PQFV-7049', 'Corn Dogs', 'corndog.jpg', 'A corn dog is a sausage on a stick that has been coated in a thick layer of cornmeal batter and deep fried. It originated in the United States and is commonly found in American cuisine', '4', '2022-09-03 13:00:32.787354', 0),
('f4ce3927bf', 'EAHD-1980', 'Hot Dog', 'hotdog0.jpg', 'A hot dog is a food consisting of a grilled or steamed sausage served in the slit of a partially sliced bun. The term hot dog can also refer to the sausage itself. The sausage used is a wiener or a frankfurter. The names of these sausages also commonly refer to their assembled dish.', '4', '2022-09-03 10:53:04.965223', 0),
('f9c2770a32', 'YXLA-2603', 'Whipped Milk Shake', 'milkshake.jpeg', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,', '8', '2022-09-03 08:54:02.727645', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rpos_staff`
--

CREATE TABLE `rpos_staff` (
  `staff_id` int(20) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `staff_email` varchar(200) NOT NULL,
  `staff_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rpos_staff`
--

INSERT INTO `rpos_staff` (`staff_id`, `staff_name`, `staff_number`, `staff_email`, `staff_password`, `created_at`) VALUES
(2, 'Cashier Trevor', 'QEUY-9042', 'cashier@mail.com', '903b21879b4a60fc9103c3334e4f6f62cf6c3a2d', '2022-09-04 16:11:30.581882'),
(3, 'Trex', 'KISB-4012', 'trex@mail.com', '772372450f30b6d06b60aad4f073c6cbd111be0a', '2024-12-08 09:28:13.545133');

-- --------------------------------------------------------

--
-- Table structure for table `school_details`
--

CREATE TABLE `school_details` (
  `id` int(11) NOT NULL,
  `school_id` text NOT NULL,
  `email` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_details`
--

INSERT INTO `school_details` (`id`, `school_id`, `email`, `date_created`, `role`) VALUES
(1, '19410054@cic.edu.ph', '19410054@cic.edu.ph', '2025-02-08 10:10:16', 0),
(2, '22410208@cic.edu.ph ', '22410208@cic.edu.ph ', '2025-02-08 10:10:16', 0),
(3, '20410211@cic.edu.ph', '20410211@cic.edu.ph', '2025-02-08 10:11:04', 0),
(4, '21410090@cic.edu.ph', '21410090@cic.edu.ph', '2025-02-08 10:11:04', 0),
(5, '21310090@cic.edu.ph', '21310090@cic.edu.ph', '2025-02-26 08:14:54', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  ADD PRIMARY KEY (`pdid`);

--
-- Indexes for table `rpos_admin`
--
ALTER TABLE `rpos_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `rpos_customers`
--
ALTER TABLE `rpos_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `rpos_orders`
--
ALTER TABLE `rpos_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `CustomerOrder` (`customer_id`),
  ADD KEY `ProductOrder` (`prod_id`);

--
-- Indexes for table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `rpos_payments`
--
ALTER TABLE `rpos_payments`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `order` (`order_code`);

--
-- Indexes for table `rpos_products`
--
ALTER TABLE `rpos_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `school_details`
--
ALTER TABLE `school_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  MODIFY `pdid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  MODIFY `reset_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `school_details`
--
ALTER TABLE `school_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rpos_orders`
--
ALTER TABLE `rpos_orders`
  ADD CONSTRAINT `CustomerOrder` FOREIGN KEY (`customer_id`) REFERENCES `rpos_customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductOrder` FOREIGN KEY (`prod_id`) REFERENCES `rpos_products` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
