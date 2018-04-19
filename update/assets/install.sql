-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 22 Mai 2016 à 12:55
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `install`
--

-- --------------------------------------------------------

--
-- Structure de la table `holds`
--

ALTER TABLE `zarest_tables` ADD `checked` varchar(50) CHARACTER SET utf8 DEFAULT NULL;
ALTER TABLE `zarest_users` ADD `store_id` int(11) CHARACTER SET utf8 DEFAULT NULL;
ALTER TABLE `zarest_posales` ADD `time` varchar(50) CHARACTER SET utf8 DEFAULT NULL;

ALTER TABLE `zarest_products` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_categories` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_categorie_expences` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_combo_items` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_customers` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_purchases` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_purchase_items` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_registers` CONVERT TO CHARACTER SET utf8 ;
ALTER TABLE `zarest_sales` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_sale_items` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_settings` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_stores` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_suppliers` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_tables` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_users` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_variations` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_waiters` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_warehouses` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_zones` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_holds` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_payements` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_posales` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_expences` CONVERT TO CHARACTER SET utf8;
ALTER TABLE `zarest_stocks` CONVERT TO CHARACTER SET utf8;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
