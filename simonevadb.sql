-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 06, 2016 at 12:16 
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simonevadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(5) NOT NULL,
  `category` int(5) NOT NULL DEFAULT '0',
  `parent_id` int(5) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `publish` int(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `category`, `parent_id`, `code`, `name`, `description`, `publish`, `created`, `deleted`, `updated`) VALUES
(14, 511, 0, '51102', 'tambahan penghasilan pns', 'Tambahan Penghasilan PNS', 1, '2016-11-30 19:31:40', NULL, NULL),
(13, 511, 0, '51101', 'gaji dan tunjangan', 'Gaji Dan Tunjangan', 1, '2016-11-30 19:30:41', NULL, NULL),
(15, 511, 13, '5110101', 'gaji pokok pns / uang representasi', 'Gaji Pokok PNS / Uang Representasi', 1, '2016-11-30 19:32:34', NULL, NULL),
(16, 511, 14, '5110201', 'tambahan penghasilan berdasarkan beban kerja', 'Tambahan Penghasilan Berdasarkan Beban Kerja', 1, '2016-11-30 19:33:24', NULL, '2016-11-30 19:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `account_category`
--

CREATE TABLE `account_category` (
  `id` int(11) NOT NULL,
  `parent_id` int(3) NOT NULL DEFAULT '0',
  `type` enum('1','2','3') NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dppa_id` int(4) NOT NULL,
  `description` text,
  `orders` int(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_category`
--

INSERT INTO `account_category` (`id`, `parent_id`, `type`, `code`, `name`, `dppa_id`, `description`, `orders`, `created`, `deleted`, `updated`) VALUES
(8, 0, '1', '01', 'program pelayanan administrasi perkantoran', 5, 'Program Pelayanan Administrasi Perkantoran', 1, '2016-12-01 00:28:02', NULL, '2016-12-06 16:32:38'),
(9, 8, '1', '0101', 'penyediaan jasa surat menyurat', 5, 'Penyediaan Jasa Surat Menyurat', 1, '2016-12-01 00:29:06', NULL, '2016-12-06 16:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `icon` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `parent_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `modul` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `url` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `menu_order` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `class_style` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `id_style` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `target` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '_parent',
  `parent_status` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `icon`, `parent_id`, `name`, `modul`, `url`, `menu_order`, `class_style`, `id_style`, `target`, `parent_status`, `created`, `updated`, `deleted`) VALUES
(41, NULL, 0, 'Home', 'main', 'main/', 0, 'fa fa-home', '', '_parent', 1, NULL, '2016-11-24 15:42:01', NULL),
(42, NULL, 0, 'Dashboard', 'main', 'main/', 1, 'fa fa-home', '', '_parent', 1, NULL, '2016-11-24 15:42:45', NULL),
(106, NULL, 54, 'Language', 'language', 'language/', 4, '', '', '_parent', 0, NULL, NULL, NULL),
(54, NULL, 0, 'Article', 'main', 'main/', 5, 'fa fa-book', '', '_parent', 1, NULL, '2016-11-24 15:45:29', '2016-11-30 19:09:31'),
(55, NULL, 54, 'New Article', 'article', 'article/add', 0, '', '', '_parent', 0, NULL, NULL, NULL),
(56, NULL, 54, 'Article List', 'article', 'article/', 1, '', '', '_parent', 0, NULL, NULL, NULL),
(72, NULL, 54, 'News Category', 'newscategory', 'newscategory/', 2, '', '', '_parent', 0, NULL, NULL, NULL),
(163, NULL, 41, 'Coba Lagi', 'login', 'login/', 2, '', '', '_parent', 0, NULL, NULL, NULL),
(165, NULL, 0, 'Setting & Data', 'main', 'main/', 4, 'fa fa-book', '', '_parent', 1, NULL, '2016-11-24 19:53:44', NULL),
(166, NULL, 165, 'Product List', 'product', 'product/', 1, '', '', '_parent', 0, NULL, NULL, '2016-11-24 19:57:03'),
(167, NULL, 165, 'Category', 'category', 'category/', 0, '', '', '_parent', 0, NULL, NULL, '2016-11-24 19:57:03'),
(168, NULL, 165, 'Image slider', 'slider', 'slider/', 2, '', '', '_parent', 0, NULL, NULL, '2016-11-24 19:57:03'),
(169, NULL, 165, 'Banner', 'banner', 'banner/', 3, '', '', '_parent', 0, NULL, NULL, '2016-11-24 19:57:03'),
(170, NULL, 165, 'Event', 'project', 'project/', 4, '', '', '_parent', 0, NULL, NULL, '2016-11-24 19:57:03'),
(171, NULL, 54, 'Newsbox', 'newsbox', 'newsbox/', 4, '', '', '_parent', 0, NULL, NULL, NULL),
(172, NULL, 165, 'Testimonial', 'testimonial', 'testimonial/', 5, '', '', '_parent', 0, NULL, NULL, '2016-11-24 19:57:03'),
(173, NULL, 165, 'Manufactures', 'manufacture', 'manufacture/', 1, '', '', '_parent', 0, '2016-11-24 17:01:03', NULL, '2016-11-24 19:57:03'),
(174, NULL, 165, 'Daftar SKPD', 'dppa', 'dppa/', 0, '', '', '_parent', 0, '2016-11-24 20:02:33', '2016-12-01 14:13:59', NULL),
(175, NULL, 165, 'Kode Rekening', 'account', 'account/', 2, '', '', '_parent', 0, '2016-11-25 10:46:09', '2016-11-25 21:03:09', NULL),
(176, NULL, 165, 'Program Kegiatan', 'acategory', 'acategory/', 1, '', '', '_parent', 0, '2016-11-25 21:02:53', '2016-11-30 17:13:46', NULL),
(179, NULL, 165, 'Periode', 'period', 'period/', 0, '', '', '_parent', 0, '2016-12-02 15:33:26', NULL, '2016-12-02 16:04:56'),
(177, NULL, 165, 'Pagu Anggaran', 'balance', 'balance/', 3, '', '', '_parent', 0, '2016-11-28 08:36:46', NULL, NULL),
(178, NULL, 165, 'Transaksi SP2D', 'transaction', 'transaction/', 4, '', '', '_parent', 0, '2016-11-29 11:58:18', '2016-11-29 12:42:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `id` int(11) NOT NULL,
  `type` enum('1','2','3') DEFAULT NULL,
  `account_id` int(4) NOT NULL,
  `category_id` int(5) NOT NULL,
  `dppa_id` int(4) NOT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `source` enum('DAU','DAK') DEFAULT NULL,
  `amount` decimal(15,0) NOT NULL,
  `year` smallint(4) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`id`, `type`, `account_id`, `category_id`, `dppa_id`, `priority`, `source`, `amount`, `year`, `created`, `deleted`, `updated`) VALUES
(10, '1', 15, 9, 5, 0, NULL, '250000', 2016, '2016-12-01 07:21:25', NULL, NULL),
(9, NULL, 0, 0, 5, 1, 'DAU', '1000000', 2016, '2016-12-01 07:20:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE `captcha` (
  `id` int(2) NOT NULL,
  `question` varchar(30) NOT NULL,
  `answer` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `captcha`
--

INSERT INTO `captcha` (`id`, `question`, `answer`) VALUES
(1, '1 + 1 = ', '2'),
(2, '2 x 3 = ', '6'),
(3, '5 + 4 =', '9'),
(4, '6 x 3 =', '18'),
(5, '4 x 6 =', '24'),
(6, '1 + 7 =', '8'),
(7, '4 + 3 = ', '7'),
(8, '6 + 6 =', '12');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(100) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('885f9f9ba22aab178159a8d9c51cc6be', '0.0.0.0', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (K', 1464691531, 'a:3:{s:4:"lang";s:2:"ID";s:12:"refered_from";s:37:"http://localhost/dswip/index.php/home";s:4:"menu";s:1:"1";}'),
('d58b0e60b442a5f41ec802344d2174c1', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 1470982648, 'a:3:{s:4:"lang";s:2:"ID";s:12:"refered_from";s:37:"http://localhost/dswip/index.php/home";s:4:"menu";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `dppa`
--

CREATE TABLE `dppa` (
  `id` int(11) NOT NULL,
  `parent_id` int(3) NOT NULL DEFAULT '0',
  `code` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bendahara` varchar(100) NOT NULL,
  `nip_bendahara` varchar(100) NOT NULL,
  `kadis` varchar(100) NOT NULL,
  `nip_kadis` varchar(100) NOT NULL,
  `publish` int(1) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dppa`
--

INSERT INTO `dppa` (`id`, `parent_id`, `code`, `name`, `bendahara`, `nip_bendahara`, `kadis`, `nip_kadis`, `publish`, `image`, `created`, `deleted`, `updated`) VALUES
(7, 0, '0101009', 'dinas bina marga dan pengairan', 'test', '008', 'test', '008', 0, NULL, '2016-12-06 08:14:48', NULL, '2016-12-06 08:15:47'),
(6, 0, '10210230', 'dinas kesehatan', 'test', '080', 'test', '080', 0, NULL, '2016-12-06 08:13:27', NULL, '2016-12-06 08:15:45'),
(5, 0, '10210202', 'rsud dr. djasemen saragih', 'Drs. L. PARDAMEAN MANURUNG', '19701019 199803 1 003', 'SAKTI SIMATUPANG, SE, MT', '19790917 200604 1 006', 1, NULL, '2016-12-06 09:38:30', NULL, '2016-12-06 09:38:30'),
(8, 0, '01010091', 'dinas tata ruang dan permukiman', 'test', '008', 'test', '008', 0, NULL, '2016-12-06 08:14:26', NULL, '2016-12-06 08:15:48'),
(11, 0, '0190121', 'dinas kependudukan dan capil', 'test', '008', 'test', '008', 0, NULL, '2016-12-06 08:43:04', NULL, NULL),
(9, 0, '010100912', 'dinas perhubungan', 'test', '008', 'test', '008', 0, NULL, '2016-12-06 08:15:22', NULL, NULL),
(10, 0, '0101009123', 'dinas kebersihan', 'test', '008', 'test', '008', 0, NULL, '2016-12-06 08:15:39', NULL, NULL),
(12, 0, '0190122', 'dinas sosial dan tenaga kerja', 'test', '008', 'test', '008', 0, NULL, '2016-12-06 08:43:30', NULL, NULL),
(13, 0, '0190123', 'dinas koperasi dan ukm', 'test', '008', 'test', '008', 0, NULL, '2016-12-06 08:43:55', NULL, NULL),
(14, 0, '0190124', 'dinas pemuda dan olahraga', 'test', '008', 'test', '008', 0, NULL, '2016-12-06 08:44:10', NULL, NULL),
(15, 0, '0190125', 'dinas perindag', 'test', '008', 'test', '008', 0, NULL, '2016-12-06 08:44:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `installation`
--

CREATE TABLE `installation` (
  `database_type` varchar(100) NOT NULL,
  `database_name` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL DEFAULT 'root',
  `pass` varchar(100) NOT NULL,
  `host` varchar(100) NOT NULL DEFAULT 'localhost',
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(10) NOT NULL,
  `userid` int(3) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(30) CHARACTER SET latin1 NOT NULL,
  `component_id` int(5) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `userid`, `date`, `time`, `component_id`, `activity`, `description`, `created`, `updated`, `deleted`) VALUES
(34, 1, '2012-09-17', '10:24:02', 0, 'login', NULL, NULL, NULL, NULL),
(33, 1, '2012-09-12', '12:48:58', 0, 'logout', NULL, NULL, NULL, NULL),
(32, 1, '2012-09-12', '12:47:13', 0, 'login', NULL, NULL, NULL, NULL),
(31, 1, '2012-09-12', '12:47:09', 0, 'logout', NULL, NULL, NULL, NULL),
(30, 1, '2012-09-12', '10:32:47', 0, 'login', NULL, NULL, NULL, NULL),
(29, 1, '2012-09-12', '10:32:38', 0, 'logout', NULL, NULL, NULL, NULL),
(28, 1, '2012-09-12', '09:13:48', 0, 'login', NULL, NULL, NULL, NULL),
(27, 1, '2012-09-11', '12:15:41', 0, 'logout', NULL, NULL, NULL, NULL),
(26, 1, '2012-09-11', '11:43:58', 0, 'login', NULL, NULL, NULL, NULL),
(25, 9, '2012-09-11', '11:43:54', 0, 'logout', NULL, NULL, NULL, NULL),
(24, 9, '2012-09-11', '11:39:25', 0, 'login', NULL, NULL, NULL, NULL),
(23, 1, '2012-09-11', '11:39:20', 0, 'logout', NULL, NULL, NULL, NULL),
(22, 1, '2012-09-11', '11:36:25', 0, 'login', NULL, NULL, NULL, NULL),
(21, 9, '2012-09-11', '11:36:21', 0, 'logout', NULL, NULL, NULL, NULL),
(20, 9, '2012-09-11', '11:34:23', 0, 'login', NULL, NULL, NULL, NULL),
(19, 9, '2012-09-11', '11:34:19', 0, 'logout', NULL, NULL, NULL, NULL),
(35, 1, '2012-09-17', '10:25:12', 0, 'logout', NULL, NULL, NULL, NULL),
(36, 1, '2012-10-11', '14:03:22', 0, 'login', NULL, NULL, NULL, NULL),
(37, 1, '2012-10-11', '14:05:49', 0, 'logout', NULL, NULL, NULL, NULL),
(38, 1, '2012-10-11', '14:05:57', 0, 'login', NULL, NULL, NULL, NULL),
(39, 1, '2012-10-11', '14:07:02', 0, 'logout', NULL, NULL, NULL, NULL),
(40, 9, '2012-10-17', '11:16:05', 0, 'login', NULL, NULL, NULL, NULL),
(41, 9, '2012-10-17', '11:18:24', 0, 'logout', NULL, NULL, NULL, NULL),
(42, 9, '2012-10-17', '11:18:37', 0, 'login', NULL, NULL, NULL, NULL),
(43, 9, '2012-10-17', '11:18:41', 0, 'logout', NULL, NULL, NULL, NULL),
(66, 1, '2012-10-25', '11:25:33', 0, 'login', NULL, NULL, NULL, NULL),
(65, 1, '2012-10-25', '08:46:20', 0, 'login', NULL, NULL, NULL, NULL),
(64, 1, '2012-10-24', '16:11:18', 0, 'logout', NULL, NULL, NULL, NULL),
(63, 1, '2012-10-24', '15:58:40', 0, 'login', NULL, NULL, NULL, NULL),
(62, 1, '2012-10-24', '15:58:08', 0, 'login', NULL, NULL, NULL, NULL),
(61, 1, '2012-10-24', '15:57:58', 0, 'login', NULL, NULL, NULL, NULL),
(60, 1, '2012-10-24', '12:54:50', 0, 'login', NULL, NULL, NULL, NULL),
(59, 1, '2012-10-23', '15:35:35', 0, 'logout', NULL, NULL, NULL, NULL),
(87, 1, '2012-10-31', '21:37:18', 0, 'login', NULL, NULL, NULL, NULL),
(70, 1, '2012-10-25', '13:09:54', 0, 'logout', NULL, NULL, NULL, NULL),
(69, 1, '2012-10-25', '12:51:21', 0, 'login', NULL, NULL, NULL, NULL),
(68, 1, '2012-10-25', '12:51:14', 0, 'login', NULL, NULL, NULL, NULL),
(67, 1, '2012-10-25', '11:25:59', 0, 'logout', NULL, NULL, NULL, NULL),
(58, 1, '2012-10-23', '11:32:08', 0, 'login', NULL, NULL, NULL, NULL),
(86, 1, '2012-10-31', '14:36:47', 0, 'logout', NULL, NULL, NULL, NULL),
(85, 1, '2012-10-31', '10:17:51', 0, 'login', NULL, NULL, NULL, NULL),
(84, 1, '2012-10-27', '19:05:45', 0, 'logout', NULL, NULL, NULL, NULL),
(83, 1, '2012-10-27', '18:22:20', 0, 'login', NULL, NULL, NULL, NULL),
(82, 1, '2012-10-27', '14:57:34', 0, 'logout', NULL, NULL, NULL, NULL),
(77, 1, '2012-10-27', '08:02:31', 0, 'login', NULL, NULL, NULL, NULL),
(78, 1, '2012-10-27', '12:09:37', 0, 'logout', NULL, NULL, NULL, NULL),
(79, 1, '2012-10-27', '13:55:56', 0, 'login', NULL, NULL, NULL, NULL),
(80, 1, '2012-10-27', '14:55:52', 0, 'logout', NULL, NULL, NULL, NULL),
(81, 1, '2012-10-27', '14:56:35', 0, 'login', NULL, NULL, NULL, NULL),
(88, 1, '2012-10-31', '22:05:59', 0, 'logout', NULL, NULL, NULL, NULL),
(89, 1, '2012-11-01', '08:11:35', 0, 'login', NULL, NULL, NULL, NULL),
(90, 1, '2012-12-10', '08:12:51', 0, 'login', NULL, NULL, NULL, NULL),
(91, 1, '2012-12-25', '10:28:45', 0, 'login', NULL, NULL, NULL, NULL),
(92, 1, '2012-12-25', '11:44:29', 0, 'login', NULL, NULL, NULL, NULL),
(93, 1, '2012-12-26', '09:06:58', 0, 'login', NULL, NULL, NULL, NULL),
(94, 1, '2012-12-26', '09:46:18', 0, 'logout', NULL, NULL, NULL, NULL),
(95, 1, '2013-05-06', '07:58:04', 0, 'login', NULL, NULL, NULL, NULL),
(96, 1, '2013-05-07', '17:12:08', 0, 'login', NULL, NULL, NULL, NULL),
(97, 1, '2013-05-07', '18:09:09', 0, 'login', NULL, NULL, NULL, NULL),
(98, 1, '2013-05-08', '08:50:11', 0, 'login', NULL, NULL, NULL, NULL),
(99, 1, '2013-05-08', '09:31:50', 0, 'login', NULL, NULL, NULL, NULL),
(100, 1, '2013-05-08', '11:22:45', 0, 'logout', NULL, NULL, NULL, NULL),
(101, 1, '2013-05-09', '10:32:04', 0, 'login', NULL, NULL, NULL, NULL),
(102, 1, '2013-05-09', '13:49:33', 0, 'login', NULL, NULL, NULL, NULL),
(103, 1, '2013-05-09', '15:47:45', 0, 'logout', NULL, NULL, NULL, NULL),
(104, 1, '2013-05-10', '08:23:42', 0, 'login', NULL, NULL, NULL, NULL),
(105, 1, '2013-05-10', '09:40:38', 0, 'login', NULL, NULL, NULL, NULL),
(106, 1, '2013-05-10', '11:07:02', 0, 'login', NULL, NULL, NULL, NULL),
(107, 1, '2013-05-11', '09:22:42', 0, 'login', NULL, NULL, NULL, NULL),
(108, 1, '2013-05-11', '10:39:31', 0, 'login', NULL, NULL, NULL, NULL),
(109, 1, '2013-05-11', '12:02:08', 0, 'logout', NULL, NULL, NULL, NULL),
(110, 1, '2013-05-11', '16:33:52', 0, 'login', NULL, NULL, NULL, NULL),
(111, 1, '2013-05-11', '19:31:04', 0, 'logout', NULL, NULL, NULL, NULL),
(112, 1, '2013-05-12', '09:20:47', 0, 'login', NULL, NULL, NULL, NULL),
(113, 1, '2013-05-12', '11:53:37', 0, 'logout', NULL, NULL, NULL, NULL),
(114, 1, '2013-05-12', '21:21:52', 0, 'login', NULL, NULL, NULL, NULL),
(115, 1, '2013-05-13', '08:58:55', 0, 'login', NULL, NULL, NULL, NULL),
(116, 1, '2013-05-13', '10:36:09', 0, 'logout', NULL, NULL, NULL, NULL),
(117, 1, '2013-05-21', '10:06:18', 0, 'login', NULL, NULL, NULL, NULL),
(118, 1, '2013-05-21', '10:11:56', 0, 'login', NULL, NULL, NULL, NULL),
(119, 1, '2013-05-21', '11:52:53', 0, 'login', NULL, NULL, NULL, NULL),
(120, 1, '2013-05-21', '11:57:12', 0, 'logout', NULL, NULL, NULL, NULL),
(121, 1, '2013-05-21', '12:13:23', 0, 'login', NULL, NULL, NULL, NULL),
(122, 1, '2013-05-21', '12:15:34', 0, 'logout', NULL, NULL, NULL, NULL),
(123, 1, '2013-05-23', '14:28:50', 0, 'login', NULL, NULL, NULL, NULL),
(124, 1, '2013-05-23', '14:36:11', 0, 'logout', NULL, NULL, NULL, NULL),
(125, 1, '2013-05-23', '14:36:39', 0, 'login', NULL, NULL, NULL, NULL),
(126, 1, '2013-05-23', '15:36:51', 0, 'login', NULL, NULL, NULL, NULL),
(127, 1, '2013-05-23', '21:23:56', 0, 'login', NULL, NULL, NULL, NULL),
(128, 1, '2013-05-23', '22:03:57', 0, 'logout', NULL, NULL, NULL, NULL),
(129, 1, '2013-05-24', '08:58:08', 0, 'login', NULL, NULL, NULL, NULL),
(130, 1, '2013-05-24', '10:29:22', 0, 'login', NULL, NULL, NULL, NULL),
(131, 1, '2013-05-24', '11:27:25', 0, 'logout', NULL, NULL, NULL, NULL),
(132, 1, '2013-05-25', '11:11:56', 0, 'login', NULL, NULL, NULL, NULL),
(133, 1, '2013-05-25', '14:38:28', 0, 'logout', NULL, NULL, NULL, NULL),
(134, 1, '2013-05-25', '23:22:10', 0, 'login', NULL, NULL, NULL, NULL),
(135, 1, '2013-05-26', '10:43:48', 0, 'login', NULL, NULL, NULL, NULL),
(136, 1, '2013-05-27', '20:17:43', 0, 'login', NULL, NULL, NULL, NULL),
(137, 1, '2013-05-28', '09:03:35', 0, 'login', NULL, NULL, NULL, NULL),
(138, 1, '2013-05-28', '19:57:44', 0, 'login', NULL, NULL, NULL, NULL),
(139, 1, '2013-05-28', '20:38:46', 0, 'logout', NULL, NULL, NULL, NULL),
(140, 1, '2013-05-29', '07:20:11', 0, 'login', NULL, NULL, NULL, NULL),
(141, 1, '2013-05-29', '07:21:41', 0, 'logout', NULL, NULL, NULL, NULL),
(142, 1, '2013-05-29', '08:43:17', 0, 'login', NULL, NULL, NULL, NULL),
(143, 1, '2013-05-29', '18:55:04', 0, 'login', NULL, NULL, NULL, NULL),
(144, 1, '2013-05-29', '20:53:49', 0, 'logout', NULL, NULL, NULL, NULL),
(145, 1, '2013-05-30', '08:28:15', 0, 'login', NULL, NULL, NULL, NULL),
(146, 1, '2013-05-31', '10:22:08', 0, 'login', NULL, NULL, NULL, NULL),
(147, 1, '2013-05-31', '10:28:39', 0, 'logout', NULL, NULL, NULL, NULL),
(148, 1, '2013-05-31', '10:28:46', 0, 'login', NULL, NULL, NULL, NULL),
(149, 1, '2013-05-31', '10:41:45', 0, 'logout', NULL, NULL, NULL, NULL),
(150, 1, '2013-05-31', '10:42:21', 0, 'login', NULL, NULL, NULL, NULL),
(151, 1, '2013-05-31', '14:38:51', 0, 'login', NULL, NULL, NULL, NULL),
(152, 1, '2013-05-31', '15:49:10', 0, 'logout', NULL, NULL, NULL, NULL),
(153, 1, '2013-05-31', '18:26:44', 0, 'login', NULL, NULL, NULL, NULL),
(154, 1, '2013-05-31', '18:35:47', 0, 'logout', NULL, NULL, NULL, NULL),
(155, 1, '2013-06-04', '19:30:09', 0, 'login', NULL, NULL, NULL, NULL),
(156, 1, '2013-06-04', '20:31:03', 0, 'logout', NULL, NULL, NULL, NULL),
(157, 1, '2013-06-10', '10:27:43', 0, 'login', NULL, NULL, NULL, NULL),
(158, 1, '2013-06-10', '10:34:40', 0, 'logout', NULL, NULL, NULL, NULL),
(159, 1, '2013-06-11', '09:14:46', 0, 'login', NULL, NULL, NULL, NULL),
(160, 1, '2013-06-11', '09:51:08', 0, 'login', NULL, NULL, NULL, NULL),
(161, 1, '2013-06-11', '11:42:20', 0, 'login', NULL, NULL, NULL, NULL),
(162, 1, '2013-06-11', '12:42:32', 0, 'logout', NULL, NULL, NULL, NULL),
(163, 1, '2013-06-12', '09:05:08', 0, 'login', NULL, NULL, NULL, NULL),
(164, 1, '2013-06-12', '13:52:32', 0, 'logout', NULL, NULL, NULL, NULL),
(165, 1, '2014-03-25', '12:23:36', 0, 'login', NULL, NULL, NULL, NULL),
(166, 1, '2014-03-25', '12:27:44', 0, 'logout', NULL, NULL, NULL, NULL),
(167, 1, '2014-03-25', '16:10:14', 0, 'login', NULL, NULL, NULL, NULL),
(168, 1, '2014-03-25', '16:11:30', 0, 'login', NULL, NULL, NULL, NULL),
(169, 1, '2014-03-25', '16:15:34', 0, 'login', NULL, NULL, NULL, NULL),
(170, 1, '2014-03-25', '16:21:45', 0, 'login', NULL, NULL, NULL, NULL),
(171, 1, '2014-03-25', '16:25:15', 0, 'login', NULL, NULL, NULL, NULL),
(172, 1, '2014-03-25', '16:30:06', 0, 'logout', NULL, NULL, NULL, NULL),
(173, 1, '2015-08-08', '16:20:08', 0, 'login', NULL, NULL, NULL, NULL),
(174, 1, '2015-08-08', '16:35:47', 0, 'logout', NULL, NULL, NULL, NULL),
(175, 1, '2015-08-16', '08:46:10', 0, 'login', NULL, NULL, NULL, NULL),
(176, 1, '2015-08-18', '14:14:36', 0, 'login', NULL, NULL, NULL, NULL),
(177, 1, '2015-08-18', '19:41:16', 0, 'login', NULL, NULL, NULL, NULL),
(178, 1, '2015-08-19', '07:02:54', 0, 'login', NULL, NULL, NULL, NULL),
(179, 1, '2015-08-19', '08:35:10', 0, 'login', NULL, NULL, NULL, NULL),
(180, 1, '2015-08-19', '11:22:18', 0, 'logout', NULL, NULL, NULL, NULL),
(181, 1, '2015-08-19', '12:48:47', 0, 'login', NULL, NULL, NULL, NULL),
(182, 1, '2015-08-20', '06:38:57', 0, 'login', NULL, NULL, NULL, NULL),
(183, 1, '2015-08-20', '12:25:43', 0, 'login', NULL, NULL, NULL, NULL),
(184, 1, '2015-08-21', '07:26:26', 0, 'login', NULL, NULL, NULL, NULL),
(185, 1, '2015-08-21', '13:21:10', 0, 'login', NULL, NULL, NULL, NULL),
(186, 1, '2015-08-21', '15:20:26', 0, 'login', NULL, NULL, NULL, NULL),
(187, 1, '2015-08-21', '15:31:14', 0, 'logout', NULL, NULL, NULL, NULL),
(188, 1, '2015-09-10', '08:29:25', 0, 'login', NULL, NULL, NULL, NULL),
(189, 1, '2015-09-10', '08:29:33', 0, 'logout', NULL, NULL, NULL, NULL),
(190, 1, '2015-09-10', '08:32:07', 0, 'login', NULL, NULL, NULL, NULL),
(191, 1, '2015-09-10', '08:34:49', 0, 'logout', NULL, NULL, NULL, NULL),
(192, 1, '2015-09-10', '08:34:55', 0, 'login', NULL, NULL, NULL, NULL),
(193, 1, '2015-09-10', '08:41:06', 0, 'logout', NULL, NULL, NULL, NULL),
(194, 1, '2015-12-24', '12:51:33', 0, 'login', NULL, NULL, NULL, NULL),
(195, 1, '2016-11-24', '12:45:50', 0, 'login', '', NULL, NULL, NULL),
(196, 1, '2016-11-24', '12:55:13', 0, 'login', '', NULL, NULL, NULL),
(197, 1, '2016-11-24', '12:55:17', 0, 'login', '', NULL, NULL, NULL),
(198, 1, '2016-11-24', '13:18:12', 0, 'login', '', NULL, NULL, NULL),
(199, 1, '2016-11-24', '13:19:37', 0, 'logout', '', NULL, NULL, NULL),
(200, 1, '2016-11-24', '13:20:27', 0, 'login', '', NULL, NULL, NULL),
(201, 1, '2016-11-24', '13:20:30', 0, 'login', '', NULL, NULL, NULL),
(202, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(203, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(204, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(205, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(206, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(207, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(208, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(209, 1, '2016-11-24', '13:20:40', 0, 'login', '', NULL, NULL, NULL),
(210, 1, '2016-11-24', '13:21:11', 0, 'login', '', NULL, NULL, NULL),
(211, 1, '2016-11-24', '13:34:58', 0, 'logout', '', NULL, NULL, NULL),
(212, 1, '2016-11-24', '13:35:02', 0, 'login', '', NULL, NULL, NULL),
(213, 1, '2016-11-24', '15:30:41', 0, 'login', '', NULL, NULL, NULL),
(214, 1, '2016-11-24', '15:34:50', 0, 'login', '', NULL, NULL, NULL),
(215, 1, '2016-11-24', '15:37:17', 92, 'update', '', NULL, NULL, NULL),
(216, 1, '2016-11-24', '15:41:45', 132, 'update', '', NULL, NULL, NULL),
(217, 1, '2016-11-24', '15:42:01', 132, 'update', '', NULL, NULL, NULL),
(218, 1, '2016-11-24', '15:42:45', 132, 'update', '', NULL, NULL, NULL),
(219, 1, '2016-11-24', '15:44:02', 132, 'update', '', NULL, NULL, NULL),
(220, 1, '2016-11-24', '15:44:29', 92, 'update', '', NULL, NULL, NULL),
(221, 1, '2016-11-24', '15:45:01', 132, 'update', '', NULL, NULL, NULL),
(222, 1, '2016-11-24', '15:45:15', 92, 'update', '', NULL, NULL, NULL),
(223, 1, '2016-11-24', '15:45:29', 132, 'update', '', NULL, NULL, NULL),
(224, 1, '2016-11-24', '15:51:27', 139, 'update', '', NULL, NULL, NULL),
(225, 1, '2016-11-24', '15:51:28', 139, 'update', '', NULL, NULL, NULL),
(226, 1, '2016-11-24', '15:51:29', 139, 'update', '', NULL, NULL, NULL),
(227, 1, '2016-11-24', '15:51:31', 139, 'update', '', NULL, NULL, NULL),
(228, 1, '2016-11-24', '15:54:37', 141, 'update', '', NULL, NULL, NULL),
(229, 1, '2016-11-24', '15:54:38', 141, 'update', '', NULL, NULL, NULL),
(230, 1, '2016-11-24', '15:59:57', 130, 'update', '', NULL, NULL, NULL),
(231, 1, '2016-11-24', '15:59:59', 130, 'update', '', NULL, NULL, NULL),
(232, 1, '2016-11-24', '16:00:49', 77, 'update', '', NULL, NULL, NULL),
(233, 1, '2016-11-24', '16:00:49', 77, 'update', '', NULL, NULL, NULL),
(234, 1, '2016-11-24', '16:00:50', 77, 'update', '', NULL, NULL, NULL),
(235, 1, '2016-11-24', '16:00:51', 77, 'update', '', NULL, NULL, NULL),
(236, 1, '2016-11-24', '16:02:48', 40, 'update', '', NULL, NULL, NULL),
(237, 1, '2016-11-24', '16:02:58', 40, 'update', '', NULL, NULL, NULL),
(238, 1, '2016-11-24', '16:03:32', 40, 'update', '', NULL, NULL, NULL),
(239, 1, '2016-11-24', '16:04:12', 40, 'update', '', NULL, NULL, NULL),
(240, 1, '2016-11-24', '16:05:09', 40, 'update', '', NULL, NULL, NULL),
(241, 1, '2016-11-24', '17:00:17', 0, 'create', '', NULL, NULL, NULL),
(242, 1, '2016-11-24', '17:01:03', 132, 'create', '', NULL, NULL, NULL),
(243, 1, '2016-11-24', '18:13:57', 0, 'update', '', NULL, NULL, NULL),
(244, 1, '2016-11-24', '18:14:25', 40, 'update', '', NULL, NULL, NULL),
(245, 1, '2016-11-24', '18:15:21', 147, 'create', '', NULL, NULL, NULL),
(246, 1, '2016-11-24', '18:15:45', 147, 'create', '', NULL, NULL, NULL),
(247, 1, '2016-11-24', '18:33:30', 139, 'update', '', NULL, NULL, NULL),
(248, 1, '2016-11-24', '18:33:39', 139, 'update', '', NULL, NULL, NULL),
(249, 1, '2016-11-24', '18:33:40', 139, 'update', '', NULL, NULL, NULL),
(250, 1, '2016-11-24', '18:33:41', 139, 'update', '', NULL, NULL, NULL),
(251, 1, '2016-11-24', '18:33:45', 139, 'update', '', NULL, NULL, NULL),
(252, 1, '2016-11-24', '18:34:01', 139, 'update', '', NULL, NULL, NULL),
(253, 1, '2016-11-24', '18:34:10', 139, 'delete', '', NULL, NULL, NULL),
(254, 1, '2016-11-24', '18:47:04', 136, 'update', '', NULL, NULL, NULL),
(255, 1, '2016-11-24', '18:47:05', 136, 'update', '', NULL, NULL, NULL),
(256, 1, '2016-11-24', '19:07:26', 0, 'login', '', NULL, NULL, NULL),
(257, 1, '2016-11-24', '19:31:04', 0, 'delete', '', NULL, NULL, NULL),
(258, 1, '2016-11-24', '19:31:04', 0, 'delete', '', NULL, NULL, NULL),
(259, 1, '2016-11-24', '19:31:04', 0, 'delete', '', NULL, NULL, NULL),
(260, 1, '2016-11-24', '19:31:04', 0, 'delete', '', NULL, NULL, NULL),
(261, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(262, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(263, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(264, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(265, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(266, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(267, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(268, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(269, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(270, 1, '2016-11-24', '19:31:29', 0, 'delete', '', NULL, NULL, NULL),
(271, 1, '2016-11-24', '19:31:36', 0, 'delete', '', NULL, NULL, NULL),
(272, 1, '2016-11-24', '19:32:49', 0, 'logout', '', NULL, NULL, NULL),
(273, 1, '2016-11-24', '19:46:55', 0, 'login', '', NULL, NULL, NULL),
(274, 1, '2016-11-24', '19:53:44', 132, 'update', '', NULL, NULL, NULL),
(275, 1, '2016-11-24', '19:57:03', 132, 'delete', '', NULL, NULL, NULL),
(276, 1, '2016-11-24', '19:57:03', 132, 'delete', '', NULL, NULL, NULL),
(277, 1, '2016-11-24', '19:57:03', 132, 'delete', '', NULL, NULL, NULL),
(278, 1, '2016-11-24', '19:57:03', 132, 'delete', '', NULL, NULL, NULL),
(279, 1, '2016-11-24', '19:57:03', 132, 'delete', '', NULL, NULL, NULL),
(280, 1, '2016-11-24', '19:57:03', 132, 'delete', '', NULL, NULL, NULL),
(281, 1, '2016-11-24', '19:57:03', 132, 'delete', '', NULL, NULL, NULL),
(282, 1, '2016-11-24', '20:01:49', 0, 'create', '', NULL, NULL, NULL),
(283, 1, '2016-11-24', '20:02:33', 132, 'create', '', NULL, NULL, NULL),
(284, 1, '2016-11-25', '07:04:53', 0, 'login', '', NULL, NULL, NULL),
(285, 1, '2016-11-25', '07:51:25', 148, 'update', '', NULL, NULL, NULL),
(286, 1, '2016-11-25', '07:51:28', 148, 'update', '', NULL, NULL, NULL),
(287, 1, '2016-11-25', '07:51:30', 148, 'update', '', NULL, NULL, NULL),
(288, 1, '2016-11-25', '07:52:03', 148, 'update', '', NULL, NULL, NULL),
(289, 1, '2016-11-25', '07:52:04', 148, 'update', '', NULL, NULL, NULL),
(290, 1, '2016-11-25', '08:25:21', 148, 'create', '', NULL, NULL, NULL),
(291, 1, '2016-11-25', '09:21:59', 148, 'update', '', NULL, NULL, NULL),
(292, 1, '2016-11-25', '09:22:15', 148, 'update', '', NULL, NULL, NULL),
(293, 1, '2016-11-25', '09:24:22', 148, 'update', '', NULL, NULL, NULL),
(294, 1, '2016-11-25', '09:24:50', 148, 'update', '', NULL, NULL, NULL),
(295, 1, '2016-11-25', '09:25:14', 148, 'update', '', NULL, NULL, NULL),
(296, 1, '2016-11-25', '09:25:41', 148, 'update', '', NULL, NULL, NULL),
(297, 1, '2016-11-25', '09:26:37', 148, 'update', '', NULL, NULL, NULL),
(298, 1, '2016-11-25', '09:27:09', 148, 'update', '', NULL, NULL, NULL),
(299, 1, '2016-11-25', '09:29:54', 148, 'update', '', NULL, NULL, NULL),
(300, 1, '2016-11-25', '09:30:31', 148, 'update', '', NULL, NULL, NULL),
(301, 1, '2016-11-25', '09:30:42', 148, 'update', '', NULL, NULL, NULL),
(302, 1, '2016-11-25', '09:30:56', 148, 'delete', '', NULL, NULL, NULL),
(303, 1, '2016-11-25', '10:44:51', 0, 'login', '', NULL, NULL, NULL),
(304, 1, '2016-11-25', '10:45:35', 0, 'create', '', NULL, NULL, NULL),
(305, 1, '2016-11-25', '10:46:09', 132, 'create', '', NULL, NULL, NULL),
(306, 1, '2016-11-25', '11:25:24', 149, 'delete', '', NULL, NULL, NULL),
(307, 1, '2016-11-25', '11:41:17', 149, 'update', '', NULL, NULL, NULL),
(308, 1, '2016-11-25', '11:41:25', 149, 'update', '', NULL, NULL, NULL),
(309, 1, '2016-11-25', '11:41:26', 149, 'update', '', NULL, NULL, NULL),
(310, 1, '2016-11-25', '11:42:03', 149, 'update', '', NULL, NULL, NULL),
(311, 1, '2016-11-25', '11:42:04', 149, 'update', '', NULL, NULL, NULL),
(312, 1, '2016-11-25', '11:42:21', 149, 'update', '', NULL, NULL, NULL),
(313, 1, '2016-11-25', '11:42:33', 149, 'update', '', NULL, NULL, NULL),
(314, 1, '2016-11-25', '11:42:35', 149, 'update', '', NULL, NULL, NULL),
(315, 1, '2016-11-25', '12:12:24', 149, 'create', '', NULL, NULL, NULL),
(316, 1, '2016-11-25', '12:13:47', 149, 'create', '', NULL, NULL, NULL),
(317, 1, '2016-11-25', '12:15:47', 149, 'create', '', NULL, NULL, NULL),
(318, 1, '2016-11-25', '12:16:00', 149, 'update', '', NULL, NULL, NULL),
(319, 1, '2016-11-25', '12:16:30', 149, 'create', '', NULL, NULL, NULL),
(320, 1, '2016-11-25', '12:17:31', 149, 'update', '', NULL, NULL, NULL),
(321, 1, '2016-11-25', '12:17:32', 149, 'update', '', NULL, NULL, NULL),
(322, 1, '2016-11-25', '12:31:16', 149, 'update', '', NULL, NULL, NULL),
(323, 1, '2016-11-25', '12:31:27', 149, 'update', '', NULL, NULL, NULL),
(324, 1, '2016-11-25', '20:48:38', 0, 'login', '', NULL, NULL, NULL),
(325, 1, '2016-11-25', '21:02:21', 0, 'create', '', NULL, NULL, NULL),
(326, 1, '2016-11-25', '21:02:53', 132, 'create', '', NULL, NULL, NULL),
(327, 1, '2016-11-25', '21:03:09', 132, 'update', '', NULL, NULL, NULL),
(328, 1, '2016-11-25', '21:03:52', 132, 'update', '', NULL, NULL, NULL),
(329, 1, '2016-11-26', '08:37:08', 0, 'login', '', NULL, NULL, NULL),
(330, 1, '2016-11-26', '10:46:11', 0, 'login', '', NULL, NULL, NULL),
(331, 1, '2016-11-26', '12:01:52', 148, 'create', '', NULL, NULL, NULL),
(332, 1, '2016-11-26', '12:01:56', 148, 'update', '', NULL, NULL, NULL),
(333, 1, '2016-11-26', '12:31:28', 150, 'create', '', NULL, NULL, NULL),
(334, 1, '2016-11-26', '12:37:24', 150, 'create', '', NULL, NULL, NULL),
(335, 1, '2016-11-26', '12:42:33', 150, 'create', '', NULL, NULL, NULL),
(336, 1, '2016-11-26', '18:49:19', 0, 'login', '', NULL, NULL, NULL),
(337, 1, '2016-11-26', '18:49:22', 0, 'login', '', NULL, NULL, NULL),
(338, 1, '2016-11-26', '18:49:46', 0, 'login', '', NULL, NULL, NULL),
(339, 1, '2016-11-26', '19:37:25', 149, 'create', '', NULL, NULL, NULL),
(340, 1, '2016-11-26', '20:24:10', 149, 'update', '', NULL, NULL, NULL),
(341, 1, '2016-11-26', '20:24:13', 149, 'update', '', NULL, NULL, NULL),
(342, 1, '2016-11-26', '20:24:39', 149, 'update', '', NULL, NULL, NULL),
(343, 1, '2016-11-26', '20:24:41', 149, 'update', '', NULL, NULL, NULL),
(344, 1, '2016-11-26', '20:24:42', 149, 'update', '', NULL, NULL, NULL),
(345, 1, '2016-11-26', '20:24:45', 149, 'update', '', NULL, NULL, NULL),
(346, 1, '2016-11-26', '20:37:15', 149, 'update', '', NULL, NULL, NULL),
(347, 1, '2016-11-26', '20:37:16', 149, 'update', '', NULL, NULL, NULL),
(348, 1, '2016-11-26', '20:59:53', 0, 'logout', '', NULL, NULL, NULL),
(349, 1, '2016-11-27', '09:41:30', 0, 'login', '', NULL, NULL, NULL),
(350, 1, '2016-11-27', '09:42:05', 149, 'update', '', NULL, NULL, NULL),
(351, 1, '2016-11-27', '09:42:06', 149, 'update', '', NULL, NULL, NULL),
(352, 1, '2016-11-27', '09:52:36', 149, 'update', '', NULL, NULL, NULL),
(353, 1, '2016-11-27', '10:42:31', 149, 'create', '', NULL, NULL, NULL),
(354, 1, '2016-11-27', '10:43:44', 149, 'create', '', NULL, NULL, NULL),
(355, 1, '2016-11-27', '10:43:53', 149, 'update', '', NULL, NULL, NULL),
(356, 1, '2016-11-27', '11:34:07', 149, 'create', '', NULL, NULL, NULL),
(357, 1, '2016-11-27', '12:02:17', 40, 'update', '', NULL, NULL, NULL),
(358, 1, '2016-11-27', '12:05:34', 40, 'update', '', NULL, NULL, NULL),
(359, 1, '2016-11-27', '12:06:07', 40, 'update', '', NULL, NULL, NULL),
(360, 1, '2016-11-27', '12:06:17', 0, 'logout', '', NULL, NULL, NULL),
(361, 1, '2016-11-27', '12:11:01', 0, 'login', '', NULL, NULL, NULL),
(362, 1, '2016-11-27', '12:11:07', 0, 'logout', '', NULL, NULL, NULL),
(363, 1, '2016-11-27', '12:27:37', 0, 'login', '', NULL, NULL, NULL),
(364, 1, '2016-11-27', '12:55:40', 0, 'logout', '', NULL, NULL, NULL),
(365, 1, '2016-11-27', '12:55:48', 0, 'login', '', NULL, NULL, NULL),
(366, 1, '2016-11-27', '12:55:48', 0, 'login', '', NULL, NULL, NULL),
(367, 1, '2016-11-27', '12:56:02', 0, 'login', '', NULL, NULL, NULL),
(368, 1, '2016-11-27', '13:09:11', 149, 'create', '', NULL, NULL, NULL),
(369, 1, '2016-11-27', '13:11:32', 149, 'create', '', NULL, NULL, NULL),
(370, 1, '2016-11-27', '13:12:02', 149, 'create', '', NULL, NULL, NULL),
(371, 1, '2016-11-27', '13:13:46', 149, 'update', '', NULL, NULL, NULL),
(372, 1, '2016-11-27', '13:40:18', 149, 'update', '', NULL, NULL, NULL),
(373, 1, '2016-11-27', '13:44:45', 149, 'update', '', NULL, NULL, NULL),
(374, 1, '2016-11-27', '13:45:47', 149, 'update', '', NULL, NULL, NULL),
(375, 1, '2016-11-27', '14:13:42', 149, 'update', '', NULL, NULL, NULL),
(376, 1, '2016-11-27', '14:13:57', 149, 'update', '', NULL, NULL, NULL),
(377, 1, '2016-11-27', '14:13:58', 149, 'update', '', NULL, NULL, NULL),
(378, 1, '2016-11-27', '14:14:05', 149, 'delete', '', NULL, NULL, NULL),
(379, 1, '2016-11-27', '15:38:15', 0, 'logout', '', NULL, NULL, NULL),
(380, 1, '2016-11-27', '21:02:33', 0, 'login', '', NULL, NULL, NULL),
(381, 1, '2016-11-27', '21:36:14', 150, 'delete', '', NULL, NULL, NULL),
(382, 1, '2016-11-27', '21:40:14', 150, 'create', '', NULL, NULL, NULL),
(383, 1, '2016-11-27', '21:44:06', 150, 'create', '', NULL, NULL, NULL),
(384, 1, '2016-11-27', '21:54:41', 150, 'update', '', NULL, NULL, NULL),
(385, 1, '2016-11-27', '21:54:49', 150, 'update', '', NULL, NULL, NULL),
(386, 1, '2016-11-27', '21:56:24', 150, 'delete', '', NULL, NULL, NULL),
(387, 1, '2016-11-27', '21:58:33', 148, 'update', '', NULL, NULL, NULL),
(388, 1, '2016-11-28', '07:16:14', 0, 'login', '', NULL, NULL, NULL),
(389, 1, '2016-11-28', '08:35:32', 0, 'create', '', NULL, NULL, NULL),
(390, 1, '2016-11-28', '08:36:46', 132, 'create', '', NULL, NULL, NULL),
(391, 1, '2016-11-28', '14:10:59', 0, 'login', '', NULL, NULL, NULL),
(392, 1, '2016-11-28', '20:49:33', 0, 'login', '', NULL, NULL, NULL),
(393, 1, '2016-11-28', '22:49:45', 0, 'login', '', NULL, NULL, NULL),
(394, 1, '2016-11-28', '23:01:21', 150, 'delete', '', NULL, NULL, NULL),
(395, 1, '2016-11-28', '23:01:36', 150, 'delete', '', NULL, NULL, NULL),
(396, 1, '2016-11-28', '23:02:29', 150, 'delete', '', NULL, NULL, NULL),
(397, 1, '2016-11-28', '23:04:43', 151, 'forced_delete', '', NULL, NULL, NULL),
(398, 1, '2016-11-28', '23:15:25', 151, 'create', '', NULL, NULL, NULL),
(399, 1, '2016-11-28', '23:32:14', 151, 'forced_delete', '', NULL, NULL, NULL),
(400, 1, '2016-11-28', '23:33:25', 151, 'create', '', NULL, NULL, NULL),
(401, 1, '2016-11-28', '23:41:32', 0, 'logout', '', NULL, NULL, NULL),
(402, 1, '2016-11-29', '06:40:02', 0, 'login', '', NULL, NULL, NULL),
(403, 1, '2016-11-29', '07:12:00', 151, 'create', '', NULL, NULL, NULL),
(404, 1, '2016-11-29', '07:28:22', 151, 'create', '', NULL, NULL, NULL),
(405, 1, '2016-11-29', '07:57:06', 151, 'create', '', NULL, NULL, NULL),
(406, 1, '2016-11-29', '08:09:08', 151, 'update', '', NULL, NULL, NULL),
(407, 1, '2016-11-29', '09:24:29', 0, 'login', '', NULL, NULL, NULL),
(408, 1, '2016-11-29', '11:37:22', 0, 'login', '', NULL, NULL, NULL),
(409, 1, '2016-11-29', '11:57:37', 0, 'create', '', NULL, NULL, NULL),
(410, 1, '2016-11-29', '11:58:18', 132, 'create', '', NULL, NULL, NULL),
(411, 1, '2016-11-29', '12:42:18', 132, 'update', '', NULL, NULL, NULL),
(412, 1, '2016-11-29', '12:55:00', 0, 'login', '', NULL, NULL, NULL),
(413, 1, '2016-11-29', '12:56:10', 0, 'logout', '', NULL, NULL, NULL),
(414, 1, '2016-11-29', '13:19:18', 0, 'login', '', NULL, NULL, NULL),
(415, 1, '2016-11-30', '07:08:17', 0, 'login', '', NULL, NULL, NULL),
(416, 1, '2016-11-30', '10:01:50', 0, 'login', '', NULL, NULL, NULL),
(417, 1, '2016-11-30', '10:03:19', 148, 'update', '', NULL, NULL, NULL),
(418, 1, '2016-11-30', '10:03:20', 148, 'update', '', NULL, NULL, NULL),
(419, 1, '2016-11-30', '10:53:51', 152, 'create', '', NULL, NULL, NULL),
(420, 1, '2016-11-30', '10:56:28', 152, 'create', '', NULL, NULL, NULL),
(421, 1, '2016-11-30', '10:59:42', 152, 'create', '', NULL, NULL, NULL),
(422, 1, '2016-11-30', '11:01:51', 152, 'forced_delete', '', NULL, NULL, NULL),
(423, 1, '2016-11-30', '11:13:58', 152, 'create', '', NULL, NULL, NULL),
(424, 1, '2016-11-30', '11:18:55', 152, 'create', '', NULL, NULL, NULL),
(425, 1, '2016-11-30', '13:38:31', 0, 'login', '', NULL, NULL, NULL),
(426, 1, '2016-11-30', '15:34:48', 0, 'login', '', NULL, NULL, NULL),
(427, 1, '2016-11-30', '16:40:24', 148, 'create', '', NULL, NULL, NULL),
(428, 1, '2016-11-30', '16:42:37', 148, 'create', '', NULL, NULL, NULL),
(429, 1, '2016-11-30', '16:42:46', 148, 'update', '', NULL, NULL, NULL),
(430, 1, '2016-11-30', '16:45:29', 40, 'update', '', NULL, NULL, NULL),
(431, 1, '2016-11-30', '16:48:06', 148, 'create', '', NULL, NULL, NULL),
(432, 1, '2016-11-30', '16:48:12', 148, 'update', '', NULL, NULL, NULL),
(433, 1, '2016-11-30', '17:08:43', 0, 'logout', '', NULL, NULL, NULL),
(434, 1, '2016-11-30', '17:08:51', 0, 'login', '', NULL, NULL, NULL),
(435, 1, '2016-11-30', '17:13:46', 132, 'update', '', NULL, NULL, NULL),
(436, 1, '2016-11-30', '19:08:36', 0, 'login', '', NULL, NULL, NULL),
(437, 1, '2016-11-30', '19:09:31', 132, 'delete', '', NULL, NULL, NULL),
(438, 1, '2016-11-30', '19:30:41', 149, 'create', '', NULL, NULL, NULL),
(439, 1, '2016-11-30', '19:31:40', 149, 'create', '', NULL, NULL, NULL),
(440, 1, '2016-11-30', '19:32:34', 149, 'create', '', NULL, NULL, NULL),
(441, 1, '2016-11-30', '19:33:24', 149, 'create', '', NULL, NULL, NULL),
(442, 1, '2016-11-30', '19:58:44', 149, 'update', '', NULL, NULL, NULL),
(443, 1, '2016-11-30', '19:58:46', 149, 'update', '', NULL, NULL, NULL),
(444, 1, '2016-12-01', '00:15:13', 0, 'login', '', NULL, NULL, NULL),
(445, 1, '2016-12-01', '00:28:02', 150, 'create', '', NULL, NULL, NULL),
(446, 1, '2016-12-01', '00:29:06', 150, 'create', '', NULL, NULL, NULL),
(447, 1, '2016-12-01', '06:43:28', 0, 'login', '', NULL, NULL, NULL),
(448, 1, '2016-12-01', '07:20:57', 151, 'create', '', NULL, NULL, NULL),
(449, 1, '2016-12-01', '07:21:25', 151, 'create', '', NULL, NULL, NULL),
(450, 1, '2016-12-01', '08:55:20', 152, 'create', '', NULL, NULL, NULL),
(451, 1, '2016-12-01', '08:55:51', 152, 'create', '', NULL, NULL, NULL),
(452, 1, '2016-12-01', '10:01:17', 148, 'update', '', NULL, NULL, NULL),
(453, 1, '2016-12-01', '12:31:06', 0, 'login', '', NULL, NULL, NULL),
(454, 1, '2016-12-01', '12:35:58', 152, 'create', '', NULL, NULL, NULL),
(455, 1, '2016-12-01', '13:28:17', 0, 'logout', '', NULL, NULL, NULL),
(456, 1, '2016-12-01', '13:28:24', 0, 'login', '', NULL, NULL, NULL),
(457, 1, '2016-12-01', '14:13:59', 132, 'update', '', NULL, NULL, NULL),
(458, 1, '2016-12-01', '14:26:33', 0, 'logout', '', NULL, NULL, NULL),
(459, 1, '2016-12-02', '08:13:13', 0, 'login', '', NULL, NULL, NULL),
(460, 1, '2016-12-02', '10:14:12', 152, 'forced_delete', '', NULL, NULL, NULL),
(461, 1, '2016-12-02', '10:15:33', 152, 'create', '', NULL, NULL, NULL),
(462, 1, '2016-12-02', '12:44:25', 0, 'login', '', NULL, NULL, NULL),
(463, 1, '2016-12-02', '14:08:15', 0, 'login', '', NULL, NULL, NULL),
(464, 1, '2016-12-02', '15:32:57', 0, 'create', '', NULL, NULL, NULL),
(465, 1, '2016-12-02', '15:33:26', 132, 'create', '', NULL, NULL, NULL),
(466, 1, '2016-12-02', '16:02:58', 153, 'update', '', NULL, NULL, NULL),
(467, 1, '2016-12-02', '16:03:28', 153, 'update', '', NULL, NULL, NULL),
(468, 1, '2016-12-02', '16:04:07', 153, 'update', '', NULL, NULL, NULL),
(469, 1, '2016-12-02', '16:04:10', 153, 'update', '', NULL, NULL, NULL),
(470, 1, '2016-12-02', '16:04:20', 153, 'update', '', NULL, NULL, NULL),
(471, 1, '2016-12-02', '16:04:56', 132, 'delete', '', NULL, NULL, NULL),
(472, 1, '2016-12-02', '21:02:31', 0, 'login', '', NULL, NULL, NULL),
(473, 1, '2016-12-03', '07:33:53', 0, 'login', '', NULL, NULL, NULL),
(474, 1, '2016-12-03', '07:40:09', 153, 'update', '', NULL, NULL, NULL),
(475, 1, '2016-12-03', '07:44:51', 153, 'update', '', NULL, NULL, NULL),
(476, 1, '2016-12-03', '07:45:03', 153, 'update', '', NULL, NULL, NULL),
(477, 1, '2016-12-03', '08:01:59', 152, 'forced_delete', '', NULL, NULL, NULL),
(478, 1, '2016-12-03', '08:02:19', 152, 'forced_delete', '', NULL, NULL, NULL),
(479, 1, '2016-12-03', '08:06:25', 153, 'update', '', NULL, NULL, NULL),
(480, 1, '2016-12-03', '08:06:33', 152, 'forced_delete', '', NULL, NULL, NULL),
(481, 1, '2016-12-03', '08:07:41', 153, 'update', '', NULL, NULL, NULL),
(482, 1, '2016-12-03', '08:07:45', 152, 'forced_delete', '', NULL, NULL, NULL),
(483, 1, '2016-12-03', '08:12:23', 153, 'update', '', NULL, NULL, NULL),
(484, 1, '2016-12-03', '08:12:26', 152, 'create', '', NULL, NULL, NULL),
(485, 1, '2016-12-04', '08:56:12', 0, 'login', '', NULL, NULL, NULL),
(486, 1, '2016-12-04', '10:51:41', 152, 'update', '', NULL, NULL, NULL),
(487, 1, '2016-12-04', '10:52:18', 152, 'update', '', NULL, NULL, NULL),
(488, 1, '2016-12-05', '08:53:10', 0, 'login', '', NULL, NULL, NULL),
(489, 1, '2016-12-05', '14:09:51', 0, 'login', '', NULL, NULL, NULL),
(490, 1, '2016-12-05', '14:16:20', 153, 'update', '', NULL, NULL, NULL),
(491, 1, '2016-12-05', '14:41:48', 153, 'update', '', NULL, NULL, NULL),
(492, 1, '2016-12-05', '14:49:33', 153, 'update', '', NULL, NULL, NULL),
(493, 1, '2016-12-05', '14:56:30', 152, 'create', '', NULL, NULL, NULL),
(494, 1, '2016-12-05', '15:00:46', 152, 'create', '', NULL, NULL, NULL),
(495, 1, '2016-12-05', '15:01:11', 152, 'create', '', NULL, NULL, NULL),
(496, 1, '2016-12-05', '16:03:50', 0, 'login', '', NULL, NULL, NULL),
(497, 1, '2016-12-05', '16:33:48', 152, 'create', '', NULL, NULL, NULL),
(498, 1, '2016-12-05', '16:34:34', 152, 'update', '', NULL, NULL, NULL),
(499, 1, '2016-12-06', '08:11:57', 0, 'login', '', NULL, NULL, NULL),
(500, 1, '2016-12-06', '08:12:48', 40, 'update', '', NULL, NULL, NULL),
(501, 1, '2016-12-06', '08:12:53', 0, 'logout', '', NULL, NULL, NULL),
(502, 1, '2016-12-06', '08:12:58', 0, 'login', '', NULL, NULL, NULL),
(503, 1, '2016-12-06', '08:13:27', 148, 'update', '', NULL, NULL, NULL),
(504, 1, '2016-12-06', '08:13:58', 148, 'create', '', NULL, NULL, NULL),
(505, 1, '2016-12-06', '08:14:26', 148, 'create', '', NULL, NULL, NULL),
(506, 1, '2016-12-06', '08:14:48', 148, 'update', '', NULL, NULL, NULL),
(507, 1, '2016-12-06', '08:14:52', 148, 'update', '', NULL, NULL, NULL),
(508, 1, '2016-12-06', '08:14:53', 148, 'update', '', NULL, NULL, NULL),
(509, 1, '2016-12-06', '08:15:22', 148, 'create', '', NULL, NULL, NULL),
(510, 1, '2016-12-06', '08:15:39', 148, 'create', '', NULL, NULL, NULL),
(511, 1, '2016-12-06', '08:15:44', 148, 'update', '', NULL, NULL, NULL),
(512, 1, '2016-12-06', '08:15:45', 148, 'update', '', NULL, NULL, NULL),
(513, 1, '2016-12-06', '08:15:47', 148, 'update', '', NULL, NULL, NULL),
(514, 1, '2016-12-06', '08:15:48', 148, 'update', '', NULL, NULL, NULL),
(515, 1, '2016-12-06', '08:42:10', 148, 'update', '', NULL, NULL, NULL),
(516, 1, '2016-12-06', '08:43:04', 148, 'create', '', NULL, NULL, NULL),
(517, 1, '2016-12-06', '08:43:30', 148, 'create', '', NULL, NULL, NULL),
(518, 1, '2016-12-06', '08:43:55', 148, 'create', '', NULL, NULL, NULL),
(519, 1, '2016-12-06', '08:44:10', 148, 'create', '', NULL, NULL, NULL),
(520, 1, '2016-12-06', '08:44:24', 148, 'create', '', NULL, NULL, NULL),
(521, 1, '2016-12-06', '09:02:54', 0, 'logout', '', NULL, NULL, NULL),
(522, 1, '2016-12-06', '09:03:00', 0, 'login', '', NULL, NULL, NULL),
(523, 1, '2016-12-06', '09:16:14', 40, 'update', '', NULL, NULL, NULL),
(524, 1, '2016-12-06', '09:16:18', 0, 'logout', '', NULL, NULL, NULL),
(525, 1, '2016-12-06', '09:16:30', 0, 'login', '', NULL, NULL, NULL),
(526, 1, '2016-12-06', '09:38:30', 148, 'update', '', NULL, NULL, NULL),
(527, 1, '2016-12-06', '09:57:59', 0, 'logout', '', NULL, NULL, NULL),
(528, 1, '2016-12-06', '10:01:32', 0, 'login', '', NULL, NULL, NULL),
(529, 1, '2016-12-06', '10:17:16', 0, 'logout', '', NULL, NULL, NULL),
(530, 1, '2016-12-06', '10:27:04', 0, 'login', '', NULL, NULL, NULL),
(531, 1, '2016-12-06', '10:53:26', 0, 'logout', '', NULL, NULL, NULL),
(532, 1, '2016-12-06', '12:30:46', 0, 'login', '', NULL, NULL, NULL),
(533, 1, '2016-12-06', '12:41:45', 40, 'update', '', NULL, NULL, NULL),
(534, 1, '2016-12-06', '12:41:49', 0, 'logout', '', NULL, NULL, NULL),
(535, 1, '2016-12-06', '12:41:57', 0, 'login', '', NULL, NULL, NULL),
(536, 1, '2016-12-06', '14:18:06', 0, 'login', '', NULL, NULL, NULL),
(537, 1, '2016-12-06', '16:30:16', 0, 'login', '', NULL, NULL, NULL),
(538, 1, '2016-12-06', '16:32:26', 150, 'update', '', NULL, NULL, NULL),
(539, 1, '2016-12-06', '16:32:38', 150, 'update', '', NULL, NULL, NULL),
(540, 1, '2016-12-06', '16:32:52', 150, 'update', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_status`
--

CREATE TABLE `login_status` (
  `userid` int(5) NOT NULL,
  `log` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_status`
--

INSERT INTO `login_status` (`userid`, `log`) VALUES
(1, 536);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `parent_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `position` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `type` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `url` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '#',
  `menu_order` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `class_style` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `id_style` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `default` int(1) NOT NULL DEFAULT '0',
  `limit` int(3) NOT NULL DEFAULT '5',
  `icon` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `target` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '_parent'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `position`, `name`, `type`, `url`, `menu_order`, `class_style`, `id_style`, `default`, `limit`, `icon`, `target`) VALUES
(128, 0, '', 'Top', '', '#', 0, NULL, NULL, 0, 0, NULL, '_parent'),
(111, 0, 'top', 'Event & Gallery', 'modul', 'project/', 3, '', '', 0, 6, NULL, '_parent'),
(94, 0, 'top', 'Home', 'modul', 'home/', 0, '', 'selected', 0, 0, NULL, '_parent'),
(100, 0, 'top', 'About Us', 'article', 'article/get_article/companyprofile/', 1, '', '', 0, 5, 'Dodols.png', '_blank'),
(113, 0, 'top', 'Contact', 'modul', 'contactus/', 5, '', '', 0, 10, NULL, '_parent'),
(108, 100, 'middle', 'Our Profile', 'article', 'article/get_article/companyprofile/', 0, '', '', 0, 5, NULL, '_parent'),
(109, 0, 'top', 'Our Method', 'article', 'article/get_article/eventacara17/', 2, '', '', 0, 6, NULL, '_parent'),
(112, 0, 'top', 'Tips & Article', 'articlelist', 'article/get_category/tips/', 4, '', '', 0, 2, NULL, '_parent'),
(114, 112, 'middle', 'Tips', 'articlelist', 'article/get_category/tips/', 0, '', '', 0, 5, NULL, '_parent'),
(115, 112, 'middle', 'Carrier', 'article', 'article/get_article/coba/', 1, '', '', 0, 0, NULL, '_parent'),
(116, 100, 'middle', 'Visi & Misi', 'article', 'article/get_article/visionmision/', 1, '', '', 0, 5, NULL, '_parent'),
(117, 100, 'middle', 'Struktur Organization', 'article', 'article/get_article/strukturorganization/', 2, '', '', 0, 5, NULL, '_parent'),
(126, 100, 'bottom', 'Alumunium Composite Panel', 'article', 'article/get_article/apc/true/', 0, '', '', 0, 5, NULL, '_parent'),
(119, 100, 'bottom', 'Application & Feature', 'article', 'article/get_article/applicationandfeature/true/', 1, '', '', 0, 5, NULL, '_parent'),
(121, 100, 'bottom', 'High Glossy Series', 'article', 'article/get_article/highglossyseries/', 3, '', '', 0, 5, NULL, '_parent'),
(122, 100, 'bottom', 'Solid & Metallic Series', 'article', 'article/get_article/solidandmetallicseries/', 4, '', '', 0, 5, NULL, '_parent'),
(127, 100, 'bottom', 'Processing Method', 'article', 'article/get_article/processingmethod/', 2, '', '', 0, 5, NULL, '_parent'),
(125, 100, 'bottom', 'Certificated', 'article', 'article/get_article/certificated/', 7, '', '', 0, 5, NULL, '_parent');

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `id` int(5) NOT NULL,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `limit` int(3) NOT NULL DEFAULT '10',
  `publish` enum('Y','N') COLLATE latin1_general_ci NOT NULL,
  `status` enum('user','admin') COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Y','N') COLLATE latin1_general_ci NOT NULL,
  `role` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `icon` varchar(50) COLLATE latin1_general_ci DEFAULT 'default.png',
  `order` int(5) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`id`, `name`, `title`, `limit`, `publish`, `status`, `aktif`, `role`, `icon`, `order`, `created`, `updated`, `deleted`) VALUES
(34, 'main', '', 10, 'N', 'admin', 'Y', 'admin,officer,staff', '', 0, NULL, NULL, NULL),
(39, 'log', 'Log History', 25, 'N', 'admin', 'Y', 'admin', 'log.png', 0, NULL, NULL, NULL),
(40, 'admin', 'User Login', 15, 'N', 'admin', 'Y', 'admin', 'admin.png', 0, NULL, NULL, NULL),
(41, 'login', '', 10, 'N', 'admin', 'Y', 'admin', '', 0, NULL, NULL, NULL),
(66, 'home', '', 10, 'Y', 'user', 'Y', 'admin,officer,staff', '', 0, NULL, NULL, NULL),
(130, 'article', 'Article', 25, 'Y', 'admin', 'Y', 'officer,admin,staff,marketing', 'news.png', 0, NULL, NULL, '2016-11-24 19:31:04'),
(44, 'newscategory', 'Article Category', 10, 'N', 'admin', 'Y', 'officer,admin,staff', '', 0, NULL, NULL, '2016-11-24 19:31:29'),
(47, 'configuration', 'Configuration', 10, 'N', 'admin', 'Y', 'admin', 'configuration.png', 0, NULL, NULL, NULL),
(131, 'widget', 'Widget', 25, 'Y', 'admin', 'Y', 'officer,admin', 'widget.png', 1, NULL, NULL, NULL),
(92, 'roles', 'Role  & Privileges', 15, 'N', 'admin', 'Y', 'admin', '', 0, NULL, NULL, NULL),
(77, 'language', 'Language', 10, 'Y', 'admin', 'Y', 'officer,admin,staff', '', 0, NULL, NULL, NULL),
(132, 'adminmenu', 'Menu Administrator', 25, 'Y', 'admin', 'Y', 'officer,admin', 'adminmenu.png', 2, NULL, NULL, NULL),
(134, 'frontmenu', 'Front Page Menu', 20, 'Y', 'admin', 'Y', 'officer,admin', 'menu.png', 3, NULL, NULL, NULL),
(135, 'city', 'City', 10, 'Y', 'admin', 'Y', 'officer,admin,staff,marketing', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:04'),
(136, 'product', 'Product', 15, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:29'),
(137, 'prodesc', 'Product Description', 50, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:29'),
(138, 'progallery', 'Product Gallery', 50, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:29'),
(139, 'category', 'Product Category', 25, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 0, NULL, NULL, '2016-11-24 19:31:04'),
(140, 'slider', 'Image Slider', 10, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:29'),
(141, 'banner', 'Banner', 10, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:04'),
(142, 'contactus', 'Contact Us', 15, 'Y', 'admin', 'Y', 'officer,admin,staff,marketing', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:36'),
(143, 'project', 'Project Portfolio', 9, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:29'),
(144, 'newsbox', 'News Box', 1, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:29'),
(145, 'testimonial', 'Testimonial', 9, 'Y', 'user', 'Y', 'officer,admin,staff,marketing', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:29'),
(146, 'menugal', 'Menu Gallery', 30, 'Y', 'admin', 'Y', 'officer,admin,staff', 'default.png', 5, NULL, NULL, '2016-11-24 19:31:29'),
(147, 'manufacture', 'Manufactures', 1000, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 5, '2016-11-24 17:00:17', '2016-11-24 18:13:57', '2016-11-24 19:31:29'),
(148, 'dppa', 'Daftar DPPA', 1000, 'Y', 'admin', 'Y', 'admin', 'default.png', 5, '2016-11-24 20:01:49', NULL, NULL),
(149, 'account', 'Kode Rekening', 1000, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 1, '2016-11-25 10:45:35', NULL, NULL),
(150, 'acategory', 'Kategori Rekening', 10000, 'N', 'admin', 'Y', 'officer,admin', 'default.png', 1, '2016-11-25 21:02:21', NULL, NULL),
(151, 'balance', 'Pagu Anggaran', 10000, 'N', 'admin', 'Y', 'officer,admin', 'default.png', 1, '2016-11-28 08:35:31', NULL, NULL),
(152, 'transaction', 'Transaksi SP2D', 15000, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 1, '2016-11-29 11:57:37', NULL, NULL),
(153, 'period', 'Periode', 5, 'Y', 'admin', 'Y', 'officer,admin', 'default.png', 1, '2016-12-02 15:32:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `id` smallint(1) NOT NULL,
  `month` smallint(2) NOT NULL,
  `year` smallint(4) NOT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`id`, `month`, `year`, `updated`) VALUES
(1, 2, 2016, '2016-12-05 14:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone1` varchar(100) NOT NULL,
  `phone2` varchar(100) NOT NULL,
  `fax` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `billing_email` varchar(100) NOT NULL,
  `technical_email` varchar(100) DEFAULT NULL,
  `cc_email` varchar(100) NOT NULL,
  `zip` int(10) NOT NULL,
  `city` char(30) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_no` varchar(100) NOT NULL,
  `bank` text NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `logo` text,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `name`, `address`, `phone1`, `phone2`, `fax`, `email`, `billing_email`, `technical_email`, `cc_email`, `zip`, `city`, `account_name`, `account_no`, `bank`, `site_name`, `logo`, `meta_description`, `meta_keyword`, `created`, `updated`, `deleted`) VALUES
(1, 'Sismonev Kota Pematang Siantar', '--\n', '0', '0-0', '061-4522712', 'none@none.com', 'none@none.com', 'none@none.com', 'none@none.com', 0, 'Pematang Siantar', 'GP', '105-000-000000-0', 'Unknow', 'http://sismonevkotapematangsiantar.net/', 'logo.jpg', 'Sismonev Kota Pematang Siantar', 'Sismonev Kota Pematang Siantar', NULL, '2016-11-27 12:06:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  `rules` int(1) NOT NULL DEFAULT '1',
  `granted_menu` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `desc`, `rules`, `granted_menu`, `created`, `updated`, `deleted`) VALUES
(2, 'officer', 'Manage allsss', 2, NULL, NULL, NULL, NULL),
(4, 'admin', 'Administrator', 3, '54,165', NULL, '2016-11-24 15:45:15', NULL),
(7, 'staff', 'general staff', 1, NULL, NULL, NULL, NULL),
(8, 'marketing', 'marketing', 4, '', NULL, '2016-11-24 15:37:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) DEFAULT NULL,
  `site_offline` tinyint(4) DEFAULT '0',
  `offline_reason` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `type` enum('1','2','3') DEFAULT NULL,
  `account_id` int(4) NOT NULL,
  `category_id` int(5) NOT NULL,
  `dppa_id` int(4) NOT NULL,
  `amount` decimal(15,0) NOT NULL,
  `month` int(2) NOT NULL,
  `opening` decimal(15,0) NOT NULL,
  `progress_amount` decimal(15,0) NOT NULL,
  `rest` decimal(15,0) NOT NULL,
  `year` smallint(4) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `type`, `account_id`, `category_id`, `dppa_id`, `amount`, `month`, `opening`, `progress_amount`, `rest`, `year`, `created`, `deleted`, `updated`) VALUES
(10, '1', 15, 9, 5, '100000', 1, '0', '50000', '50000', 2016, '2016-12-03 08:12:26', NULL, '2016-12-04 10:52:18'),
(14, '1', 15, 9, 5, '100000', 2, '50000', '60000', '90000', 2016, '2016-12-05 16:33:48', NULL, '2016-12-05 16:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone1` varchar(15) NOT NULL,
  `phone2` varchar(13) NOT NULL,
  `city` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `yahooid` varchar(100) DEFAULT NULL,
  `role` char(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `lastlogin` varchar(10) NOT NULL,
  `dppa` int(3) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `address`, `phone1`, `phone2`, `city`, `email`, `yahooid`, `role`, `status`, `lastlogin`, `dppa`, `created`, `updated`, `deleted`) VALUES
(1, 'admin', 'admin', 'Administrator', 'desc', '0618218907', '', '3', 'sanjaya.kiran@gmail.com', '1', 'admin', 1, '', 5, NULL, '2016-12-06 12:41:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `widget`
--

CREATE TABLE `widget` (
  `id` int(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `position` char(10) NOT NULL,
  `order` int(2) NOT NULL DEFAULT '0',
  `publish` int(1) NOT NULL,
  `menu` text NOT NULL,
  `moremenu` int(5) NOT NULL,
  `limit` int(3) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `widget`
--

INSERT INTO `widget` (`id`, `name`, `title`, `position`, `order`, `publish`, `menu`, `moremenu`, `limit`, `created`, `updated`, `deleted`) VALUES
(12, 'wow', 'Wow Slider', 'user3', 0, 1, '0', 0, 0, NULL, NULL, NULL),
(32, 'midmenu', 'Middle Menu', 'user13', 0, 1, '71,73,72', 78, 0, NULL, NULL, NULL),
(45, 'latestnews', 'latestnews', 'user8', 0, 1, '1,74', 73, 5, NULL, NULL, NULL),
(39, 'contact', 'contact', 'user12', 0, 1, '81,76,77,75,1,74,73,71,72,79,80', 76, 0, NULL, NULL, NULL),
(44, 'latestarticle', 'latestarticle', 'user10', 0, 1, '94', 0, 5, NULL, NULL, NULL),
(47, 'catmenu', 'catmenu', 'user15', 0, 1, '75', 75, 5, NULL, NULL, NULL),
(48, 'Test', 'Test aja Ah', 'user1', 2, 1, '100', 94, 6, NULL, NULL, NULL),
(49, 'event_list', 'event_list', 'user2', 0, 1, '111', 0, 20, NULL, NULL, NULL),
(50, 'Test', 'Test aja Ah', 'user1', 2, 1, '100', 94, 5, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_category`
--
ALTER TABLE `account_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `captcha`
--
ALTER TABLE `captcha`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `dppa`
--
ALTER TABLE `dppa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widget`
--
ALTER TABLE `widget`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `account_category`
--
ALTER TABLE `account_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `captcha`
--
ALTER TABLE `captcha`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `dppa`
--
ALTER TABLE `dppa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=541;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
--
-- AUTO_INCREMENT for table `period`
--
ALTER TABLE `period`
  MODIFY `id` smallint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `widget`
--
ALTER TABLE `widget`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
