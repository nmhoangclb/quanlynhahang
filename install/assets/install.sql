-- phpMyAdmin SQL Dump
-- version 4.0.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2018 at 06:48 PM
-- Server version: 5.5.56-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zadmin_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `zarest_categories`
--

CREATE TABLE IF NOT EXISTS `zarest_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `zarest_categories`
--

INSERT INTO `zarest_categories` (`id`, `name`, `created_at`) VALUES
(24, 'Ăn Lồn rồi', '2018-04-19 18:46:56'),
(23, 'Ăn vặt', '2018-04-18 12:03:19'),
(25, 'Sặc Cặc Nó', '2018-04-19 18:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `zarest_categorie_expences`
--

CREATE TABLE IF NOT EXISTS `zarest_categorie_expences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_combo_items`
--

CREATE TABLE IF NOT EXISTS `zarest_combo_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_customers`
--

CREATE TABLE IF NOT EXISTS `zarest_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `discount` varchar(5) DEFAULT NULL,
  `created_at` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_expences`
--

CREATE TABLE IF NOT EXISTS `zarest_expences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `reference` varchar(150) NOT NULL,
  `note` text,
  `amount` float NOT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `zarest_expences`
--

INSERT INTO `zarest_expences` (`id`, `date`, `reference`, `note`, `amount`, `attachment`, `created_date`, `category_id`, `store_id`, `created_by`) VALUES
(16, '2018-04-19', 'á', '', 1221, '', '2018-04-19 11:01:11', 0, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `zarest_holds`
--

CREATE TABLE IF NOT EXISTS `zarest_holds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `time` varchar(10) NOT NULL,
  `register_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `waiter_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=317 ;

--
-- Dumping data for table `zarest_holds`
--

INSERT INTO `zarest_holds` (`id`, `number`, `time`, `register_id`, `table_id`, `waiter_id`, `customer_id`) VALUES
(274, 1, '08:31', 61, 44, 0, 0),
(279, 1, '15:48', 0, 47, NULL, NULL),
(290, 1, '17:30', 61, 49, 0, 0),
(283, 1, '16:58', 61, 0, 0, 0),
(316, 1, '18:42', 62, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `zarest_payements`
--

CREATE TABLE IF NOT EXISTS `zarest_payements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `paid` float NOT NULL,
  `paidmethod` varchar(300) NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `register_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `waiter_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `zarest_payements`
--

INSERT INTO `zarest_payements` (`id`, `date`, `paid`, `paidmethod`, `created_by`, `register_id`, `sale_id`, `waiter_id`) VALUES
(36, '2018-04-19', 0, '0', 'Nguyen Ba Hoang', 61, 35, 0);

-- --------------------------------------------------------

--
-- Table structure for table `zarest_posales`
--

CREATE TABLE IF NOT EXISTS `zarest_posales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `qt` int(6) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `register_id` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `options` text,
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1593 ;

--
-- Dumping data for table `zarest_posales`
--

INSERT INTO `zarest_posales` (`id`, `product_id`, `name`, `price`, `qt`, `status`, `register_id`, `number`, `table_id`, `options`, `time`) VALUES
(1573, 157, 'Trà sữa truyền thống', 15000, 1, 0, 61, 1, 44, NULL, '2018-04-19 17:01:24'),
(1584, 161, '123', 128048, 2, 1, 61, 1, 49, NULL, '2018-04-19 17:30:42'),
(1574, 156, 'Trà đào', 15000, 1, 0, 61, 1, 44, NULL, '2018-04-19 17:01:26'),
(1575, 159, 'Bánh tráng trộn', 10000, 1, 0, 61, 1, 0, NULL, '2018-04-19 17:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `zarest_products`
--

CREATE TABLE IF NOT EXISTS `zarest_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(25) NOT NULL,
  `category` varchar(20) NOT NULL,
  `cost` float NOT NULL,
  `tax` varchar(11) DEFAULT NULL,
  `description` mediumtext,
  `price` float NOT NULL,
  `photo` varchar(200) NOT NULL,
  `photothumb` varchar(500) DEFAULT NULL,
  `color` varchar(10) NOT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `modified_at` varchar(30) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `alertqt` int(10) DEFAULT NULL,
  `supplier` varchar(200) DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `taxmethod` tinyint(4) DEFAULT NULL,
  `h_stores` varchar(300) DEFAULT NULL,
  `options` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=168 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_purchases`
--

CREATE TABLE IF NOT EXISTS `zarest_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(11) NOT NULL,
  `date` date NOT NULL,
  `total` float DEFAULT NULL,
  `attachement` varchar(200) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` mediumtext,
  `modified_at` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_purchase_items`
--

CREATE TABLE IF NOT EXISTS `zarest_purchase_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qt` int(10) NOT NULL,
  `cost` float NOT NULL,
  `subtot` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_registers`
--

CREATE TABLE IF NOT EXISTS `zarest_registers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cash_total` float DEFAULT NULL,
  `cash_sub` float DEFAULT NULL,
  `cc_total` float DEFAULT NULL,
  `cc_sub` float DEFAULT NULL,
  `cheque_total` float DEFAULT NULL,
  `cheque_sub` float DEFAULT NULL,
  `cash_inhand` float DEFAULT NULL,
  `note` text,
  `closed_at` varchar(150) DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `waiterscih` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `zarest_registers`
--

INSERT INTO `zarest_registers` (`id`, `date`, `status`, `user_id`, `cash_total`, `cash_sub`, `cc_total`, `cc_sub`, `cheque_total`, `cheque_sub`, `cash_inhand`, `note`, `closed_at`, `closed_by`, `store_id`, `waiterscih`) VALUES
(60, '2018-04-18 04:57:25', 0, 1, 0, 0, 0, 0, 0, 0, 30000, '', '2018-04-19 05:49:49', 16, 1, ''),
(61, '2018-04-19 00:45:54', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 300000, NULL, NULL, NULL, 1, ''),
(62, '2018-04-19 10:31:58', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 100000, NULL, NULL, NULL, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `zarest_sales`
--

CREATE TABLE IF NOT EXISTS `zarest_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `clientname` varchar(50) NOT NULL,
  `tax` varchar(5) DEFAULT NULL,
  `discount` varchar(10) DEFAULT NULL,
  `subtotal` varchar(15) NOT NULL,
  `total` float NOT NULL,
  `created_at` date NOT NULL,
  `modified_at` varchar(150) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `totalitems` int(20) NOT NULL,
  `paid` varchar(15) DEFAULT NULL,
  `paidmethod` varchar(700) DEFAULT NULL,
  `taxamount` float DEFAULT NULL,
  `discountamount` float DEFAULT NULL,
  `register_id` int(11) DEFAULT NULL,
  `firstpayement` float DEFAULT NULL,
  `waiter_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `zarest_sales`
--

INSERT INTO `zarest_sales` (`id`, `client_id`, `clientname`, `tax`, `discount`, `subtotal`, `total`, `created_at`, `modified_at`, `status`, `created_by`, `totalitems`, `paid`, `paidmethod`, `taxamount`, `discountamount`, `register_id`, `firstpayement`, `waiter_id`) VALUES
(39, 0, 'Khách ngoài', '', '0', '30000', 30000, '2018-04-19', '2018-04-19 17:49:59', 2, 'Nguyen Ba Hoang', 2, '30000', '0', 0, 0, 62, 30000, 0),
(40, 0, 'Khách ngoài', '', '', '30000', 30000, '2018-04-19', '2018-04-19 17:49:38', 1, 'Nguyen Ba Hoang', 2, '30000', '1~~', 0, 0, 62, 30000, 0),
(41, 0, 'Khách ngoài', '', '', '0', 0, '2018-04-19', NULL, 1, 'Nguyen Ba Hoang', 0, '0', '0', 0, 0, 62, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `zarest_sale_items`
--

CREATE TABLE IF NOT EXISTS `zarest_sale_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `qt` int(6) NOT NULL,
  `subtotal` varchar(20) NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1029 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_settings`
--

CREATE TABLE IF NOT EXISTS `zarest_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyname` varchar(100) NOT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `keyboard` tinyint(1) NOT NULL,
  `receiptheader` text,
  `receiptfooter` text NOT NULL,
  `theme` varchar(20) NOT NULL,
  `discount` varchar(5) DEFAULT NULL,
  `tax` varchar(5) DEFAULT NULL,
  `timezone` varchar(400) DEFAULT NULL,
  `language` varchar(30) DEFAULT NULL,
  `stripe` tinyint(4) DEFAULT NULL,
  `stripe_secret_key` varchar(150) DEFAULT NULL,
  `stripe_publishable_key` varchar(150) DEFAULT NULL,
  `decimals` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `zarest_settings`
--

INSERT INTO `zarest_settings` (`id`, `companyname`, `logo`, `phone`, `currency`, `keyboard`, `receiptheader`, `receiptfooter`, `theme`, `discount`, `tax`, `timezone`, `language`, `stripe`, `stripe_secret_key`, `stripe_publishable_key`, `decimals`) VALUES
(1, 'PUM milk tea', '94b1e56c7d2dae97d6a4b6d36acc5ed9.jpg', '0962 447 522', 'VND', 0, '', 'Thank you for your business', 'Light', '', '', 'Asia/Bangkok', 'vietnam', 1, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zarest_stocks`
--

CREATE TABLE IF NOT EXISTS `zarest_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_stores`
--

CREATE TABLE IF NOT EXISTS `zarest_stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `adresse` varchar(400) DEFAULT NULL,
  `footer_text` varchar(400) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_suppliers`
--

CREATE TABLE IF NOT EXISTS `zarest_suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `note` mediumtext,
  `created_at` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_tables`
--

CREATE TABLE IF NOT EXISTS `zarest_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `time` varchar(10) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `checked` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `zarest_tables`
--

INSERT INTO `zarest_tables` (`id`, `name`, `zone_id`, `status`, `time`, `store_id`, `checked`) VALUES
(45, '7', 9, 0, '', 1, '2018-04-19 14:43:22'),
(46, '8', 9, 0, '', 1, '2018-04-19 16:59:05'),
(47, '9', 9, 0, '', 1, '2018-04-19 09:54:59'),
(48, '10', 9, 0, '', 1, '2018-04-19 16:59:14'),
(49, '11', 9, 1, '17:30', 1, NULL),
(50, '12', 9, 0, '', 1, NULL),
(51, '1', 10, 0, '', 1, NULL),
(52, '2', 10, 0, '', 1, NULL),
(53, '3', 10, 0, '', 1, NULL),
(54, '4', 10, 0, '', 1, NULL),
(55, '5', 10, 0, '', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zarest_users`
--

CREATE TABLE IF NOT EXISTS `zarest_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `hashed_password` varchar(128) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `last_active` varchar(50) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `created_at` varchar(300) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `zarest_users`
--

INSERT INTO `zarest_users` (`id`, `username`, `firstname`, `lastname`, `hashed_password`, `email`, `role`, `last_active`, `avatar`, `created_at`, `store_id`) VALUES
(1, 'admin', 'Nguyen Ba', 'Hoang', '7af1090bc079327bbb00f049fbdb256d3b017a2de32a5e841018e4a57edde457dd3f55aff0851ae8b49064d2f18d70b4414f701e506ca1aebbbbcd965dd594ea', 'Nguyenbahoang2806@gmail.com', 'admin', '2018-04-19 18:42:32', '9fff9cc26e539214e9a5fd3b6a10cde9.jpg', '2018-04-19 17:27:33', NULL),
(17, 'thungan', 'NV', 'Thu Ngân', '33211b8ba3c6c9a8b8ddab5b9b189fc62bcab7cb8775916aff4e3c7b86a5a649bec5f6419d1eed8fca0fccc6b581e8c8b848ee5dcd81252ca974a631003b718c', '', 'sales', NULL, NULL, '2018-04-18 12:01:15', 1),
(18, 'khach', 'khách', '', '674c914dee0cf5514867c689934e65b0db24db40f72eb442ecc4a2511549d0cb9f147079e0f36e694c2f37ae52c9cbcd4d044bf71e8782a059be9df4f9b3428c', '', 'waiter', NULL, NULL, '2018-04-18 12:02:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `zarest_variations`
--

CREATE TABLE IF NOT EXISTS `zarest_variations` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `price` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_waiters`
--

CREATE TABLE IF NOT EXISTS `zarest_waiters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `created_at` varchar(150) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `zarest_waiters`
--

INSERT INTO `zarest_waiters` (`id`, `name`, `phone`, `email`, `created_at`, `store_id`) VALUES
(10, 'zx', 'a', 'a', '2018-04-19 18:35:01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zarest_warehouses`
--

CREATE TABLE IF NOT EXISTS `zarest_warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `adresse` varchar(400) DEFAULT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `zarest_zones`
--

CREATE TABLE IF NOT EXISTS `zarest_zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `zarest_zones`
--

INSERT INTO `zarest_zones` (`id`, `store_id`, `name`) VALUES
(9, 1, 'Trong nhà'),
(10, 1, 'Ngoài sân');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
