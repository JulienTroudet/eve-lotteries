-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 08 Février 2015 à 15:32
-- Version du serveur: 5.5.32
-- Version de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `eve_lot`
--
CREATE DATABASE IF NOT EXISTS `eve_lot` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `eve_lot`;

-- --------------------------------------------------------

--
-- Structure de la table `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_acos_lft_rght` (`lft`,`rght`),
  KEY `idx_acos_alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=233 ;

--
-- Contenu de la table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(61, NULL, NULL, NULL, 'controllers', 1, 200),
(62, 61, NULL, NULL, 'Articles', 2, 15),
(68, 61, NULL, NULL, 'Configs', 16, 17),
(74, 61, NULL, NULL, 'EveCategories', 18, 29),
(80, 61, NULL, NULL, 'EveItems', 30, 43),
(86, 61, NULL, NULL, 'Groups', 44, 45),
(92, 61, NULL, NULL, 'Lotteries', 46, 59),
(93, 92, NULL, NULL, 'index', 47, 48),
(98, 61, NULL, NULL, 'LotteryStatuses', 60, 61),
(104, 61, NULL, NULL, 'Pages', 62, 65),
(105, 104, NULL, NULL, 'display', 63, 64),
(106, 61, NULL, NULL, 'Tickets', 66, 71),
(112, 61, NULL, NULL, 'Users', 72, 103),
(119, 112, NULL, NULL, 'logout', 73, 74),
(121, 61, NULL, NULL, 'AclExtras', 104, 105),
(123, 106, NULL, NULL, 'buy', 67, 68),
(132, 92, NULL, NULL, 'list_lotteries', 49, 50),
(133, 92, NULL, NULL, 'admin_index', 51, 52),
(134, 92, NULL, NULL, 'admin_view', 53, 54),
(136, 92, NULL, NULL, 'admin_delete', 55, 56),
(137, 62, NULL, NULL, 'admin_index', 3, 4),
(138, 62, NULL, NULL, 'admin_view', 5, 6),
(139, 62, NULL, NULL, 'admin_add', 7, 8),
(140, 62, NULL, NULL, 'admin_edit', 9, 10),
(141, 62, NULL, NULL, 'admin_delete', 11, 12),
(142, 74, NULL, NULL, 'admin_index', 19, 20),
(143, 74, NULL, NULL, 'admin_view', 21, 22),
(144, 74, NULL, NULL, 'admin_add', 23, 24),
(145, 74, NULL, NULL, 'admin_edit', 25, 26),
(146, 74, NULL, NULL, 'admin_delete', 27, 28),
(147, 80, NULL, NULL, 'admin_index', 31, 32),
(148, 80, NULL, NULL, 'admin_view', 33, 34),
(149, 80, NULL, NULL, 'admin_add', 35, 36),
(150, 80, NULL, NULL, 'admin_edit', 37, 38),
(151, 80, NULL, NULL, 'admin_delete', 39, 40),
(153, 112, NULL, NULL, 'admin_index', 75, 76),
(154, 112, NULL, NULL, 'admin_view', 77, 78),
(155, 112, NULL, NULL, 'admin_edit', 79, 80),
(156, 112, NULL, NULL, 'admin_delete', 81, 82),
(157, 80, NULL, NULL, 'admin_update_prices', 41, 42),
(161, 92, NULL, NULL, 'old_list', 57, 58),
(162, 112, NULL, NULL, 'user_navbar', 83, 84),
(164, 61, NULL, NULL, 'Transactions', 106, 111),
(168, 106, NULL, NULL, 'buy_firsts', 69, 70),
(169, 61, NULL, NULL, 'Withdrawals', 112, 133),
(170, 169, NULL, NULL, 'index', 113, 114),
(171, 169, NULL, NULL, 'list_awards', 115, 116),
(172, 169, NULL, NULL, 'old_list', 117, 118),
(173, 169, NULL, NULL, 'claim', 119, 120),
(174, 169, NULL, NULL, 'admin_index', 121, 122),
(175, 169, NULL, NULL, 'admin_list_awards_to_complete', 123, 124),
(176, 169, NULL, NULL, 'admin_complete_award', 125, 126),
(177, 164, NULL, NULL, 'index', 107, 108),
(180, 169, NULL, NULL, 'admin_reserve_award', 127, 128),
(181, 61, NULL, NULL, 'DatabaseLogger', 134, 145),
(182, 181, NULL, NULL, 'Logs', 135, 144),
(183, 182, NULL, NULL, 'admin_index', 136, 137),
(184, 182, NULL, NULL, 'admin_export', 138, 139),
(185, 182, NULL, NULL, 'admin_view', 140, 141),
(186, 182, NULL, NULL, 'admin_delete', 142, 143),
(187, 61, NULL, NULL, 'Icing', 146, 147),
(190, 61, NULL, NULL, 'Awards', 148, 161),
(191, 190, NULL, NULL, 'admin_index', 149, 150),
(192, 190, NULL, NULL, 'admin_view', 151, 152),
(193, 190, NULL, NULL, 'admin_add', 153, 154),
(194, 190, NULL, NULL, 'admin_edit', 155, 156),
(195, 190, NULL, NULL, 'admin_delete', 157, 158),
(196, 61, NULL, NULL, 'Statistics', 162, 167),
(199, 112, NULL, NULL, 'initDB', 85, 86),
(200, 190, NULL, NULL, 'index', 159, 160),
(201, 61, NULL, NULL, 'UserAwards', 168, 171),
(203, 201, NULL, NULL, 'claim', 169, 170),
(204, 61, NULL, NULL, 'SuperLotteries', 172, 189),
(205, 204, NULL, NULL, 'index', 173, 174),
(207, 204, NULL, NULL, 'admin_index', 175, 176),
(208, 204, NULL, NULL, 'admin_view', 177, 178),
(209, 204, NULL, NULL, 'admin_add', 179, 180),
(210, 204, NULL, NULL, 'admin_edit', 181, 182),
(211, 204, NULL, NULL, 'admin_delete', 183, 184),
(212, 61, NULL, NULL, 'SuperLotteryTickets', 190, 193),
(213, 212, NULL, NULL, 'buy', 191, 192),
(214, 204, NULL, NULL, 'admin_complete', 185, 186),
(215, 112, NULL, NULL, 'login', 87, 88),
(216, 112, NULL, NULL, 'forbidden', 89, 90),
(217, 62, NULL, NULL, 'index', 13, 14),
(218, 196, NULL, NULL, 'index', 163, 164),
(219, 204, NULL, NULL, 'claim', 187, 188),
(220, 169, NULL, NULL, 'list_super_awards', 129, 130),
(221, 61, NULL, NULL, 'Messages', 194, 199),
(222, 221, NULL, NULL, 'index', 195, 196),
(223, 221, NULL, NULL, 'delete', 197, 198),
(224, 169, NULL, NULL, 'view', 131, 132),
(225, 112, NULL, NULL, 'register', 91, 92),
(226, 112, NULL, NULL, 'activate', 93, 94),
(227, 112, NULL, NULL, 'edit', 95, 96),
(228, 112, NULL, NULL, 'password_reinit', 97, 98),
(229, 112, NULL, NULL, 'account', 99, 100),
(230, 112, NULL, NULL, 'resend_activation_mail', 101, 102),
(231, 196, NULL, NULL, 'list_stats', 165, 166),
(232, 164, NULL, NULL, 'list_transactions', 109, 110);

-- --------------------------------------------------------

--
-- Structure de la table `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aros_lft_rght` (`lft`,`rght`),
  KEY `idx_aros_alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(3, NULL, 'Group', 3, NULL, 1, 2),
(4, NULL, 'Group', 4, NULL, 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`),
  KEY `idx_aco_id` (`aco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 3, 61, '1', '1', '1', '1'),
(2, 4, 61, '-1', '-1', '-1', '-1'),
(3, 4, 123, '1', '1', '1', '1'),
(4, 4, 168, '1', '1', '1', '1'),
(5, 4, 213, '1', '1', '1', '1'),
(6, 4, 177, '1', '1', '1', '1'),
(7, 4, 170, '1', '1', '1', '1'),
(8, 4, 132, '1', '1', '1', '1'),
(9, 4, 161, '1', '1', '1', '1'),
(10, 4, 171, '1', '1', '1', '1'),
(11, 4, 172, '1', '1', '1', '1'),
(12, 4, 173, '1', '1', '1', '1'),
(13, 4, 200, '1', '1', '1', '1'),
(14, 4, 203, '1', '1', '1', '1'),
(15, 4, 162, '1', '1', '1', '1'),
(16, 4, 220, '1', '1', '1', '1'),
(17, 4, 219, '1', '1', '1', '1'),
(18, 4, 222, '1', '1', '1', '1'),
(19, 4, 223, '1', '1', '1', '1'),
(20, 4, 224, '1', '1', '1', '1'),
(21, 4, 227, '1', '1', '1', '1'),
(22, 4, 229, '1', '1', '1', '1'),
(23, 4, 230, '1', '1', '1', '1'),
(24, 4, 226, '1', '1', '1', '1'),
(25, 4, 232, '1', '1', '1', '1'),
(26, 4, 231, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `lead` text NOT NULL,
  `body` text NOT NULL,
  `creator_user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `articles_users` (`creator_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `awards`
--

CREATE TABLE IF NOT EXISTS `awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `group` varchar(50) NOT NULL,
  `order` int(11) NOT NULL,
  `request` text NOT NULL,
  `award_credits` decimal(20,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Contenu de la table `awards`
--

INSERT INTO `awards` (`id`, `name`, `description`, `group`, `order`, `request`, `award_credits`, `status`, `created`, `modified`) VALUES
(12, 'Gotta buy them all !', 'Buy 4 or more ticket simultaneously to win this award.', 'ticket', 6, 'SELECT MAX(number_buy)>=4 as result FROM (SELECT user_id, COUNT(*) as number_buy FROM statistics WHERE user_id = ? AND type = ''buy_ticket'' GROUP BY created) er GROUP BY user_id', '2000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:38'),
(22, 'My precious !', 'Win a lottery that you started to win this award.', 'special', 2, 'SELECT COUNT( * ) >=1 AS result\r\nFROM (\r\n\r\nSELECT COUNT( * ) >1 AS result\r\nFROM statistics\r\nWHERE user_id =  ''93070366''\r\nAND (\r\n\r\nTYPE =  ''win_lottery''\r\nOR TYPE =  ''init_lottery''\r\n)\r\nGROUP BY value\r\n)er\r\nWHERE er.result >=1', '3000000.00', 'Active', '2014-10-17 19:44:38', '2014-10-18 16:18:24'),
(23, 'Sniper', 'Win a lottery were you bought the last ticket.', 'special', 2, 'SELECT COUNT( * ) >=1 AS result\nFROM (\n\nSELECT COUNT( * ) >1 AS result\nFROM statistics\nWHERE user_id =  ''93070366''\nAND (\n\nTYPE =  ''win_lottery''\nOR TYPE =  ''end_lottery''\n)\nGROUP BY value\n)er\nWHERE er.result >=1', '3000000.00', 'Active', '2014-10-17 19:44:38', '2014-10-18 16:18:24'),
(26, 'Welcome !', 'Connect into EVE-Lotteries for the first time !', 'special', 1, 'select COUNT(*)>=1 as result FROM statistics WHERE user_id = ? AND type = ''connection'' AND value = ''first''', '1000000.00', 'Active', '2014-10-28 19:36:34', '2014-10-28 19:36:34'),
(27, 'Almost there !', 'Buy 6 or more tickets simultaneously to win this award.', 'ticket', 7, 'SELECT MAX(number_buy)>=6 as result FROM (SELECT user_id, COUNT(*) as number_buy FROM statistics WHERE user_id = ? AND type = ''buy_ticket'' GROUP BY created) er GROUP BY user_id', '4000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(28, 'First try', 'Buy 1 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>1 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', '1000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(29, 'Try again', 'Buy 10 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>10 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', '2500000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(30, 'Fifty shades of green', 'Buy 50 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>50 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', '5000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(31, 'Hundred little ', 'Buy 100 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>100 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', '10000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(32, 'Did he say play ?', 'Buy 250 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>250 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', '25000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(33, 'Heavyweight player', 'Buy 500 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>500 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', '35000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(34, 'Marathon runner', 'Buy 1000 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>1000 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', '50000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(35, 'Gambling is my day job', 'Buy 2000 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>2000 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', '100000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(36, 'Lotteries addict', 'Buy 5000 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>5000 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', '200000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(37, 'First deposit', 'Deposit 100 millions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=100000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', '5000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(38, 'Oil the machine', 'Deposit 500 millions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=500000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', '25000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(39, 'Billionaire', 'Deposit one billion into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=1000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', '50000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(40, 'Multi billionaire', 'Deposit 5 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=5000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', '100000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(41, 'Extra big spender', 'Deposit 10 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=10000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', '150000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(42, 'Super or gambling ?', 'Deposit 25 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=25000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', '200000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(43, 'Can''t wait to win !', 'Deposit 40 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=40000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', '250000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(44, 'Big red button', 'Deposit 50 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=50000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', '300000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(45, 'I used to have a Titan', 'Deposit 100 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=100000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', '500000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(46, 'I did it !', 'Win your first lottery.', 'win', 1, 'select count(*)>=1 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', '1000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(47, 'Chance as nothing to do with it.', 'Win at least ten lotteries.', 'win', 2, 'select count(*)>=10 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', '5000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(48, '50 reasons to play', 'Win at least 50 lotteries.', 'win', 3, 'select count(*)>=50 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', '25000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(49, 'Made my day', 'Win at least 100 lotteries.', 'win', 4, 'select count(*)>=100 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', '50000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(50, 'I was told to play.', 'Win at least 250 lotteries.', 'win', 5, 'select count(*)>=250 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', '10000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(51, 'Chick magnet', 'Win at least 500 lotteries.', 'win', 6, 'select count(*)>=500 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', '150000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(52, 'Elite gambler', 'Win at least a thousand lotteries.', 'win', 7, 'select count(*)>=1000 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', '250000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(53, 'Can''t stop the Rokh.', 'Win 1 Rohk.', 'items', 1, 'select count(*)>=1 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 233', '5000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(54, 'Woop Woop !', 'Win 10 police pursuit comet.', 'items', 2, 'select count(*)>=10 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 303', '5000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(55, 'The swarm', 'Win 50 frigates.', 'items', 3, 'SELECT COUNT(*) >=50 AS result FROM statistics INNER JOIN eve_items ON statistics.eve_item_id = eve_items.id WHERE statistics.user_id = ? AND statistics.type =  ''win_lottery'' AND eve_items.eve_category_id = 4', '10000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(56, 'Cruiser addict', 'Win 50 cruiser.', 'items', 4, 'SELECT COUNT(*) >=50 AS result FROM statistics INNER JOIN eve_items ON statistics.eve_item_id = eve_items.id WHERE statistics.user_id = ? AND statistics.type =  ''win_lottery'' AND eve_items.eve_category_id = 3', '20000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(57, 'May the force be with you !', 'Win 50 battleships.', 'items', 5, 'SELECT COUNT(*) >=50 AS result FROM statistics INNER JOIN eve_items ON statistics.eve_item_id = eve_items.id WHERE statistics.user_id = ? AND statistics.type =  ''win_lottery'' AND eve_items.eve_category_id = 59', '50000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(58, 'Falcon is primary !', 'Win 10 falcon.', 'items', 6, 'select count(*)>=10 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 117', '10000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(59, 'Bump machine', 'Win 5 Machariel.', 'items', 7, 'select count(*)>=5 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 180', '10000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(60, 'Providence', 'Win 5 providence.', 'items', 8, 'select count(*)>=5 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 199', '100000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(61, 'Koros', 'Win 5 moros.', 'items', 9, 'select count(*)>=5 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 195', '100000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(62, 'One, Two...', 'Win 3 tempest fleet issue.', 'items', 10, 'select count(*)>=3 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 178', '20000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(63, 'In the navy !', 'Win 5 megathron navy issue.', 'items', 11, 'select count(*)>=5 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 177', '25000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(64, 'Ready to mine', 'Win 15 orcas.', 'items', 11, 'select count(*)>=15 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 248', '100000000.00', 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16');

-- --------------------------------------------------------

--
-- Structure de la table `cake_sessions`
--

CREATE TABLE IF NOT EXISTS `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `cake_sessions`
--

INSERT INTO `cake_sessions` (`id`, `data`, `expires`) VALUES
('8vi3amu3s7ldku0k29lid5i0i3', 'Config|a:3:{s:9:"userAgent";s:32:"878b6de8c7ada6b8eecbe47fbbb2ec0b";s:4:"time";i:1423420318;s:9:"countdown";i:10;}Message|a:1:{s:4:"auth";a:3:{s:7:"message";s:47:"You are not authorized to access that location.";s:7:"element";s:7:"default";s:6:"params";a:0:{}}}Auth|a:1:{s:4:"User";a:18:{s:2:"id";s:8:"93070366";s:8:"group_id";s:1:"3";s:8:"eve_name";s:17:"Trehan Crendraven";s:8:"username";s:6:"trehan";s:8:"password";s:40:"0075873cde82db46318825877879822b6b5a3417";s:4:"mail";s:16:"vesimok@yahoo.fr";s:6:"wallet";s:15:"489846454593.80";s:6:"tokens";s:9:"501085.60";s:20:"nb_new_won_lotteries";s:1:"0";s:26:"nb_new_won_super_lotteries";s:1:"0";s:13:"nb_new_awards";s:1:"0";s:15:"nb_new_messages";s:1:"0";s:14:"nb_unread_news";s:1:"0";s:15:"sponsor_user_id";N;s:12:"cookie_value";s:40:"9ce0f2b4388271993c4c7118bc5e728ba45abb2d";s:7:"created";s:19:"2015-01-23 20:02:30";s:8:"modified";s:19:"2015-02-08 15:20:25";s:6:"active";s:1:"1";}}', 1423420318);

-- --------------------------------------------------------

--
-- Structure de la table `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(1024) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `configs`
--

INSERT INTO `configs` (`id`, `name`, `value`, `created`, `modified`) VALUES
(1, 'corpoKeyID', '3706873', '2014-09-18 22:45:35', '2014-09-18 22:45:35'),
(2, 'corpoVCode', 'WDb4vFcUcSqPxGl5XzrVr3L8pVdBwGhjqFCNzgrfM03TXo5O3ZUTM3aYrb4jtTS2', '2014-09-18 22:45:52', '2014-09-18 22:45:52'),
(3, 'apiCheck', '2014-12-27 21:51:16', '2014-09-18 22:49:08', '2014-09-18 22:49:08'),
(4, 'app_eve_id', '8d96866dbbd44046b55eea2e519ca93a', '2014-10-08 19:59:53', '2014-10-08 19:59:53'),
(5, 'app_eve_secret', 'ysYvCpixDmbBALVkv2XIDqsxZgiVXAObGsW6O7lq', '2014-10-08 19:59:53', '2014-10-08 19:59:53'),
(6, 'eve_sso_url', 'https://login.eveonline.com/oauth/', '2014-10-08 20:02:40', '2014-10-08 20:02:40'),
(7, 'app_return_url', 'http://localhost/little/users/eve_login', '2014-10-08 20:02:40', '2014-10-08 20:02:40');

-- --------------------------------------------------------

--
-- Structure de la table `eve_categories`
--

CREATE TABLE IF NOT EXISTS `eve_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `url_start` varchar(255) NOT NULL,
  `url_end` varchar(255) NOT NULL,
  `profit` int(11) NOT NULL DEFAULT '15',
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Contenu de la table `eve_categories`
--

INSERT INTO `eve_categories` (`id`, `name`, `type`, `url_start`, `url_end`, `profit`, `status`) VALUES
(3, 'Cruisers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(4, 'Frigates', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(5, 'Interdictors', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(6, 'Covert ops', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(7, 'Heavy Interdictors', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(8, 'Pirate Battleships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(50, 'Electronic Attack Ships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(51, 'Industrials', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(52, 'Assault Frigates', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(53, 'Interceptors', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(54, 'Cruiser T3', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(55, 'Faction Battleships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(56, 'Carriers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 10, 1),
(57, 'Freighters', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 10, 1),
(58, 'Jump Freighters', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 10, 1),
(59, 'Battleships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(60, 'Command Ships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(61, 'Battlecruisers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(62, 'Recon Ships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(63, 'Mining Barges', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(64, 'Heavy Assault Cruisers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(65, 'Logistics', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(66, 'Limited Edition', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 0),
(67, 'Dreadnought', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(68, 'Black ops', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1),
(69, 'Capital Industrials', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 10, 1),
(70, 'Marauders', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', 15, 1);

-- --------------------------------------------------------

--
-- Structure de la table `eve_items`
--

CREATE TABLE IF NOT EXISTS `eve_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eve_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `eve_category_id` int(11) NOT NULL,
  `eve_value` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL,
  `nb_tickets_default` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `eve_items_eve_categories` (`eve_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=304 ;

--
-- Contenu de la table `eve_items`
--

INSERT INTO `eve_items` (`id`, `eve_id`, `name`, `eve_category_id`, `eve_value`, `status`, `nb_tickets_default`) VALUES
(27, 620, 'Osprey', 3, '7358355.79', 0, 8),
(28, 621, 'Caracal', 3, '11961864.65', 0, 8),
(29, 622, 'Stabber', 3, '11091006.80', 0, 8),
(30, 623, 'Moa', 3, '11640346.85', 0, 8),
(31, 624, 'Maller', 3, '11102808.01', 0, 8),
(32, 625, 'Augoror', 3, '9562878.31', 0, 8),
(33, 626, 'Vexor', 3, '11376354.00', 0, 8),
(34, 627, 'Thorax', 3, '11159243.89', 0, 8),
(35, 628, 'Arbitrator', 3, '9060294.28', 0, 8),
(36, 629, 'Rupture', 3, '10964566.40', 0, 8),
(37, 630, 'Bellicose', 3, '9382572.03', 0, 8),
(38, 631, 'Scythe', 3, '10275169.32', 0, 8),
(39, 632, 'Blackbird', 3, '8814809.14', 0, 8),
(40, 633, 'Celestis', 3, '9545514.11', 0, 8),
(41, 634, 'Exequror', 3, '9583046.66', 0, 8),
(43, 638, 'Raven', 59, '187783685.45', 1, 8),
(44, 639, 'Tempest', 59, '177309529.19', 1, 8),
(45, 640, 'Scorpion', 59, '150846871.15', 1, 8),
(46, 641, 'Megathron', 59, '176554509.77', 1, 8),
(47, 642, 'Apocalypse', 59, '184135532.71', 1, 8),
(48, 643, 'Armageddon', 59, '180593132.48', 1, 8),
(49, 644, 'Typhoon', 59, '174351437.76', 1, 8),
(50, 645, 'Dominix', 59, '204036887.90', 1, 8),
(64, 2006, 'Omen', 3, '11660349.86', 0, 8),
(65, 2078, 'Zephyr', 66, '39606977.56', 0, 8),
(69, 2863, 'Primae', 66, '17623688.91', 0, 8),
(70, 2998, 'Noctis', 51, '80534964.46', 1, 8),
(74, 3532, 'Echelon', 66, '6788727.78', 0, 8),
(75, 3756, 'Gnosis', 61, '118169209.94', 0, 8),
(79, 4302, 'Oracle', 61, '70947852.94', 1, 8),
(80, 4306, 'Naga', 61, '68221577.37', 1, 8),
(81, 4308, 'Talos', 61, '76363302.81', 1, 8),
(82, 4310, 'Tornado', 61, '69701253.75', 1, 8),
(89, 11172, 'Helios', 6, '27020536.20', 1, 8),
(90, 11174, 'Keres', 50, '26143480.40', 1, 8),
(91, 11176, 'Crow', 53, '25860802.79', 1, 8),
(92, 11178, 'Raptor', 53, '24795598.50', 1, 8),
(93, 11182, 'Cheetah', 6, '25119917.93', 1, 8),
(94, 11184, 'Crusader', 53, '24732326.99', 1, 8),
(95, 11186, 'Malediction', 53, '24478055.50', 1, 8),
(96, 11188, 'Anathema', 6, '24452632.55', 1, 8),
(97, 11190, 'Sentinel', 50, '27417831.99', 1, 8),
(98, 11192, 'Buzzard', 6, '26634684.64', 1, 8),
(99, 11194, 'Kitsune', 50, '27369409.15', 1, 8),
(100, 11196, 'Claw', 53, '24761343.42', 1, 8),
(101, 11198, 'Stiletto', 53, '24469641.45', 1, 8),
(102, 11200, 'Taranis', 53, '26245189.17', 1, 8),
(103, 11202, 'Ares', 53, '25724078.21', 1, 8),
(104, 11365, 'Vengeance', 52, '27394858.38', 1, 8),
(105, 11371, 'Wolf', 52, '30055723.41', 1, 8),
(106, 11377, 'Nemisis', 6, '24718094.42', 1, 8),
(107, 11379, 'Hawk', 52, '30058141.58', 1, 8),
(108, 11381, 'Harpy', 52, '29602169.49', 1, 8),
(109, 11387, 'Hyena', 50, '27019975.68', 1, 8),
(110, 11393, 'Retribution', 52, '27741392.11', 1, 8),
(111, 11400, 'Jaguar', 52, '26969590.28', 1, 8),
(117, 11957, 'Falcon', 62, '209648056.93', 1, 8),
(118, 11959, 'Rook', 62, '152815315.70', 1, 8),
(119, 11961, 'Huginn', 62, '179281583.05', 1, 8),
(120, 11963, 'Rapier', 62, '172279644.04', 1, 8),
(121, 11965, 'Pilgrim', 62, '171374782.46', 1, 8),
(122, 11969, 'Arazu', 62, '185379711.47', 1, 8),
(123, 11971, 'Lachesis', 62, '175691550.61', 1, 8),
(124, 11978, 'Scimitar', 65, '168420341.60', 1, 8),
(125, 11985, 'Basilisk', 65, '178515422.26', 1, 8),
(126, 11987, 'Guardian', 65, '155288234.47', 1, 8),
(127, 11989, 'Oneiros', 65, '187848188.75', 1, 8),
(128, 11993, 'Cerberus', 64, '202813663.82', 1, 8),
(129, 11995, 'Onyx', 7, '282816362.20', 1, 8),
(130, 11999, 'Vagabond', 64, '179254339.35', 1, 8),
(131, 12003, 'Zealot', 64, '163089070.27', 1, 8),
(132, 12005, 'Ishtar', 64, '201929552.01', 1, 8),
(133, 12011, 'Eagle', 64, '201478221.30', 1, 8),
(134, 12013, 'Broadsword', 7, '234906946.57', 1, 8),
(135, 12015, 'Muninn', 64, '172057853.46', 1, 8),
(136, 12017, 'Devoter', 7, '222111631.74', 1, 8),
(137, 12019, 'Sacrilege', 64, '166926251.77', 1, 8),
(138, 12021, 'Phobos', 7, '282233631.58', 1, 8),
(139, 12023, 'Demios', 64, '201343740.33', 1, 8),
(140, 12032, 'Manticore', 6, '27349400.73', 1, 8),
(141, 12034, 'Hound', 6, '24766480.40', 1, 8),
(142, 12038, 'Purifier', 6, '25289394.77', 1, 8),
(143, 12042, 'Ishkur', 52, '30829134.11', 1, 8),
(144, 12044, 'Enyo', 52, '30112218.84', 1, 8),
(145, 12729, 'Crane', 51, '144904276.48', 1, 8),
(146, 12731, 'Bustard', 51, '202103873.70', 1, 8),
(147, 12733, 'Prorator', 51, '121831520.90', 1, 8),
(148, 12735, 'Prowler', 51, '122104019.01', 1, 8),
(149, 12743, 'Viator', 51, '135893427.57', 1, 8),
(150, 12745, 'Occator', 51, '208192293.90', 1, 8),
(151, 12747, 'Mastodon', 51, '175989876.73', 1, 8),
(152, 12753, 'Impel', 51, '168292713.51', 1, 8),
(154, 16227, 'Ferox', 61, '47390876.10', 1, 8),
(155, 16229, 'Brutix', 61, '52929613.48', 1, 8),
(156, 16231, 'Cyclone', 61, '42355450.45', 1, 8),
(157, 16233, 'Prophecy', 61, '52307547.38', 1, 8),
(163, 17476, 'Covetor', 63, '34406658.86', 0, 8),
(164, 17478, 'Retriever', 63, '30243174.86', 0, 8),
(165, 17480, 'Procurer', 63, '21020718.93', 0, 8),
(166, 17619, 'Caldari Navy Hookbill', 4, '23229571.04', 1, 8),
(167, 17634, 'Caracal Navy Issue', 3, '91249145.66', 1, 8),
(168, 17636, 'Raven Navy Issue', 55, '631964161.92', 1, 16),
(169, 17703, 'Imperial Navy Slicer', 4, '13377758.04', 1, 8),
(170, 17709, 'Omen Navy Issue', 3, '71929425.63', 1, 8),
(171, 17713, 'Stabber Fleet Issue', 3, '54823235.08', 1, 8),
(172, 17715, 'Gila', 3, '410612392.31', 1, 8),
(173, 17718, 'Phantasm', 3, '207656866.90', 1, 8),
(174, 17720, 'Cynabal', 3, '202442999.30', 1, 8),
(175, 17722, 'Vigilant', 3, '267894361.36', 1, 8),
(176, 17726, 'Apocalypse Navy Issue', 55, '561170824.65', 1, 16),
(177, 17728, 'Megathron Navy Issue', 55, '518721702.24', 1, 16),
(178, 17732, 'Tempest Fleet Issue', 55, '455991366.96', 1, 16),
(179, 17736, 'Nightmare', 8, '880678430.85', 1, 16),
(180, 17738, 'Machariel', 8, '803736803.76', 1, 16),
(181, 17740, 'Vindicator', 8, '942295682.91', 1, 16),
(182, 17812, 'Republic Fleet Firetail', 4, '11578399.86', 1, 8),
(183, 17841, 'Federation Navy Comet', 4, '19531530.36', 1, 8),
(184, 17843, 'Vexor Navy Issue', 3, '91698467.95', 1, 8),
(185, 17918, 'Rattlesnake', 8, '514734442.51', 1, 16),
(186, 17920, 'Bhaalgorn', 8, '901854347.00', 1, 16),
(187, 17922, 'Ashimmu', 3, '150423953.20', 1, 8),
(188, 17924, 'Succubus', 4, '74154240.91', 1, 8),
(189, 17926, 'Cruor', 4, '72191567.73', 1, 8),
(190, 17928, 'Daredevil', 4, '102605126.12', 1, 8),
(191, 17930, 'Worm', 4, '121197933.32', 1, 8),
(192, 17932, 'Dramiel', 4, '62545710.92', 1, 8),
(193, 19720, 'Revelation', 67, '2350983619.93', 1, 16),
(194, 19722, 'Naglfar', 67, '2619702085.43', 1, 16),
(195, 19724, 'Moros', 67, '2621563388.92', 1, 16),
(196, 19726, 'Phoenix', 67, '2617492952.17', 1, 16),
(198, 20125, 'Curse', 62, '163971705.89', 1, 8),
(199, 20183, 'Providence', 57, '1422727159.02', 1, 16),
(200, 20185, 'Charon', 57, '1405171102.72', 1, 16),
(201, 20187, 'Obelisk', 57, '1432532391.33', 1, 16),
(202, 20189, 'Fenrir', 57, '1368240596.04', 1, 16),
(203, 21097, 'Goru''s Shuttle', 66, '14132531.03', 0, 8),
(204, 21628, 'Guristas Shuttle', 66, '9778122.15', 0, 8),
(205, 22428, 'Redeemer', 68, '768925269.97', 1, 16),
(206, 22430, 'Sin', 68, '867192244.67', 1, 16),
(207, 22436, 'Widow', 68, '880136501.28', 1, 16),
(208, 22440, 'Panther', 68, '864718495.45', 1, 16),
(209, 22442, 'Eos', 60, '375103189.38', 1, 8),
(210, 22444, 'Sleipnir', 60, '268085506.88', 1, 8),
(211, 22446, 'Vulture', 60, '287170425.34', 1, 8),
(212, 22448, 'Absolution', 60, '271073111.85', 1, 8),
(213, 22452, 'Heretic', 5, '48310254.54', 1, 8),
(214, 22456, 'Sabre', 5, '49848784.34', 1, 8),
(215, 22460, 'Eris', 5, '46189488.49', 1, 8),
(216, 22464, 'Flycatcher', 5, '51238523.18', 1, 8),
(217, 22466, 'Astarte', 60, '318532073.03', 1, 8),
(218, 22468, 'Claymore', 60, '285874596.69', 1, 8),
(219, 22470, 'Nighthawk', 60, '287125513.52', 1, 8),
(220, 22474, 'Damnation', 60, '281951085.93', 1, 8),
(221, 22544, 'Hulk', 63, '277759519.06', 1, 8),
(222, 22546, 'Skiff', 63, '204693024.82', 1, 8),
(223, 22548, 'Mackinaw', 63, '232907821.19', 1, 8),
(225, 23757, 'Archon', 56, '1437454031.40', 1, 16),
(227, 23911, 'Thanatos', 56, '1570846921.61', 1, 16),
(229, 23915, 'Chimera', 56, '1398180249.15', 1, 16),
(232, 24483, 'Nidhoggur', 56, '1496013193.79', 1, 16),
(233, 24688, 'Rokh', 59, '208359476.52', 1, 8),
(234, 24690, 'Hyperion', 59, '224680269.08', 1, 8),
(235, 24692, 'Abaddon', 59, '226226303.57', 1, 8),
(236, 24694, 'Maelstrom', 59, '197384920.39', 1, 8),
(237, 24696, 'Harbinger', 61, '50044405.88', 1, 8),
(238, 24698, 'Drake', 61, '51026590.41', 1, 8),
(239, 24700, 'Myrmidon', 61, '54111732.87', 1, 8),
(240, 24702, 'Hurricane', 61, '46144153.43', 1, 8),
(247, 28352, 'Rorqual', 69, '3115524644.77', 1, 16),
(248, 28606, 'Orca', 69, '712168173.20', 1, 16),
(249, 28659, 'Paladin', 70, '1011632760.28', 1, 16),
(250, 28661, 'Kronos', 70, '1137948839.69', 1, 16),
(251, 28665, 'Vargur', 70, '1069867923.58', 1, 16),
(252, 28710, 'Golem', 70, '1211262285.40', 1, 16),
(253, 28844, 'Rhea', 58, '6599786738.41', 1, 16),
(254, 28846, 'Nomad', 58, '6815136000.66', 1, 16),
(255, 28848, 'Anshar', 58, '7185265515.62', 1, 16),
(256, 28850, 'Ark', 58, '6564440360.77', 1, 16),
(258, 29266, 'Apotheosis', 66, '21298652.58', 0, 8),
(259, 29336, 'Scythe Fleet Issue', 3, '53989541.32', 1, 8),
(260, 29337, 'Augoror Navy Issue', 3, '76134352.24', 1, 8),
(261, 29340, 'Osprey Navy Issue', 3, '84792080.20', 1, 8),
(262, 29344, 'Exequror Navy Issue', 3, '89687416.07', 1, 8),
(263, 29984, 'Tengu', 54, '158315676.43', 1, 8),
(264, 29986, 'Legion', 54, '143926778.24', 1, 8),
(265, 29988, 'Proteus', 54, '151455956.38', 1, 8),
(266, 29990, 'Loki', 54, '147465694.25', 1, 8),
(267, 30842, 'Interbus Shuttle', 66, '490867898.17', 0, 8),
(270, 32305, 'Armageddon Navy Issue', 55, '434976196.45', 1, 16),
(271, 32307, 'Dominix Navy Issue', 55, '556900175.23', 1, 16),
(272, 32309, 'Scorpion Navy Issue', 55, '657996806.67', 1, 16),
(273, 32311, 'Typhoon Fleet Issue', 55, '403008129.21', 1, 16),
(277, 32840, 'InterBus Catalyst', 66, '29759269.37', 0, 8),
(280, 32848, 'Aliastra Catalyst', 66, '27600333.51', 0, 8),
(290, 33079, 'Hematos', 66, '244929330.44', 0, 8),
(291, 33081, 'Taipan', 66, '248396352.10', 0, 8),
(292, 33083, 'Violator', 66, '320829695.95', 0, 8),
(293, 33099, 'Nefantar Thrasher', 66, '100184533.37', 0, 8),
(294, 33151, 'Brutix Navy Issue', 61, '201134247.14', 1, 8),
(295, 33153, 'Drake Navy Issue', 61, '240027186.77', 1, 8),
(296, 33155, 'Harbinger Navy Issue', 55, '198611030.05', 1, 8),
(297, 33157, 'Hurricane Fleet Issue', 55, '146537282.20', 1, 8),
(301, 33468, 'Astero', 7, '86409845.82', 1, 8),
(302, 33470, 'Stratios', 55, '338870928.47', 1, 8),
(303, 33677, 'Police Pursuit Comet', 4, '24736473.30', 1, 8);

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(3, 'Admin'),
(4, 'Player'),
(5, 'Manager');

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `hostname` varchar(50) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `refer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  FULLTEXT KEY `message` (`message`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `lotteries`
--

CREATE TABLE IF NOT EXISTS `lotteries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eve_item_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `creator_user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `nb_tickets` int(11) NOT NULL,
  `lottery_status_id` int(11) NOT NULL,
  `value` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lotteries_eve_items` (`eve_item_id`),
  KEY `lotteries_lottery_status` (`lottery_status_id`),
  KEY `lotteries_users` (`creator_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Structure de la table `lottery_status`
--

CREATE TABLE IF NOT EXISTS `lottery_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `lottery_status`
--

INSERT INTO `lottery_status` (`id`, `name`) VALUES
(1, 'ongoing'),
(2, 'finished'),
(3, 'suspended'),
(4, 'claimed'),
(5, 'unclaimed');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `controller_name` varchar(100) DEFAULT NULL,
  `action_name` varchar(100) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `anchor_name` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `phealng-cache`
--

CREATE TABLE IF NOT EXISTS `phealng-cache` (
  `userId` int(10) unsigned NOT NULL,
  `scope` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `args` varchar(250) NOT NULL,
  `xml` longtext NOT NULL,
  PRIMARY KEY (`userId`,`scope`,`name`,`args`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Caching for PhealNG';

--
-- Contenu de la table `phealng-cache`
--

INSERT INTO `phealng-cache` (`userId`, `scope`, `name`, `args`, `xml`) VALUES
(3706873, 'corp', 'walletjournal', '', '<?xml version=''1.0'' encoding=''UTF-8''?>\r\n<eveapi version="2">\r\n  <currentTime>2014-12-27 21:24:16</currentTime>\r\n  <result>\r\n    <rowset name="entries" key="refID" columns="date,refID,refTypeID,ownerName1,ownerID1,ownerName2,ownerID2,argName1,argID1,amount,balance,reason,owner1TypeID,owner2TypeID">\r\n      <row date="2014-12-27 18:42:26" refID="10512279280" refTypeID="10" ownerName1="Nel''Ea" ownerID1="93510427" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="1500.00" balance="11008616.00" reason="" owner1TypeID="1384" owner2TypeID="2" />\r\n      <row date="2014-12-27 18:14:47" refID="10512144928" refTypeID="10" ownerName1="Nel''Ea" ownerID1="93510427" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="3000.00" balance="11007116.00" reason="" owner1TypeID="1384" owner2TypeID="2" />\r\n      <row date="2014-12-27 18:10:38" refID="10512125936" refTypeID="10" ownerName1="Nel''Ea" ownerID1="93510427" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="666.00" balance="11004116.00" reason="" owner1TypeID="1384" owner2TypeID="2" />\r\n      <row date="2014-12-27 18:02:56" refID="10512090614" refTypeID="10" ownerName1="Trehan Crendraven" ownerID1="93070366" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="666.00" balance="11003450.00" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n    </rowset>\r\n  </result>\r\n  <cachedUntil>2014-12-27 21:51:16</cachedUntil>\r\n</eveapi>');

-- --------------------------------------------------------

--
-- Structure de la table `statistics`
--

CREATE TABLE IF NOT EXISTS `statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `isk_value` decimal(20,2) DEFAULT NULL,
  `eve_item_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `super_lotteries`
--

CREATE TABLE IF NOT EXISTS `super_lotteries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eve_item_id` int(11) NOT NULL,
  `number_items` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `creator_user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `nb_tickets` int(11) NOT NULL,
  `nb_ticket_bought` int(10) DEFAULT '0',
  `ticket_value` decimal(20,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `winner_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lotteries_eve_items` (`eve_item_id`),
  KEY `lotteries_lottery_status` (`status`),
  KEY `lotteries_users` (`creator_user_id`),
  KEY `lottery_status_id` (`status`),
  KEY `eve_item_id` (`eve_item_id`),
  KEY `creator_user_id` (`creator_user_id`),
  KEY `winner_user_id` (`winner_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `super_lottery_tickets`
--

CREATE TABLE IF NOT EXISTS `super_lottery_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `super_lottery_id` int(10) NOT NULL,
  `buyer_user_id` int(20) NOT NULL,
  `nb_tickets` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `super_lottery_id` (`super_lottery_id`),
  KEY `buyer_user_id` (`buyer_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lottery_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `buyer_user_id` int(11) DEFAULT NULL,
  `is_winner` tinyint(1) DEFAULT NULL,
  `value` decimal(20,2) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_lotteries` (`lottery_id`),
  KEY `tickets_users` (`buyer_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=409 ;

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refid` varchar(255) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `eve_date` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `id_3` (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `eve_name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `wallet` decimal(20,2) NOT NULL DEFAULT '0.00',
  `tokens` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nb_new_won_lotteries` int(11) NOT NULL DEFAULT '0',
  `nb_new_won_super_lotteries` int(11) NOT NULL DEFAULT '0',
  `nb_new_awards` int(11) NOT NULL DEFAULT '0',
  `nb_new_messages` int(11) NOT NULL DEFAULT '0',
  `nb_unread_news` int(11) NOT NULL DEFAULT '0',
  `sponsor_user_id` int(20) DEFAULT NULL,
  `cookie_value` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `users_groups` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `group_id`, `eve_name`, `username`, `password`, `mail`, `wallet`, `tokens`, `nb_new_won_lotteries`, `nb_new_won_super_lotteries`, `nb_new_awards`, `nb_new_messages`, `nb_unread_news`, `sponsor_user_id`, `cookie_value`, `created`, `modified`, `active`) VALUES
(93070366, 3, 'Trehan Crendraven', 'trehan', '0075873cde82db46318825877879822b6b5a3417', 'vesimok@yahoo.fr', '489846454593.80', '501085.60', 0, 0, 0, 0, 0, NULL, '9ce0f2b4388271993c4c7118bc5e728ba45abb2d', '2015-01-23 20:02:30', '2015-02-08 15:20:25', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_awards`
--

CREATE TABLE IF NOT EXISTS `user_awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `award_id` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `award_id` (`award_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `withdrawals`
--

CREATE TABLE IF NOT EXISTS `withdrawals` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(20) DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8 NOT NULL,
  `value` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `admin_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`),
  KEY `ticket_id_2` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_users` FOREIGN KEY (`creator_user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `eve_items`
--
ALTER TABLE `eve_items`
  ADD CONSTRAINT `eve_items_eve_categories` FOREIGN KEY (`eve_category_id`) REFERENCES `eve_categories` (`id`);

--
-- Contraintes pour la table `lotteries`
--
ALTER TABLE `lotteries`
  ADD CONSTRAINT `lotteries_eve_items` FOREIGN KEY (`eve_item_id`) REFERENCES `eve_items` (`id`),
  ADD CONSTRAINT `lotteries_lottery_status` FOREIGN KEY (`lottery_status_id`) REFERENCES `lottery_status` (`id`),
  ADD CONSTRAINT `lotteries_users` FOREIGN KEY (`creator_user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `statistics_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `super_lotteries`
--
ALTER TABLE `super_lotteries`
  ADD CONSTRAINT `eve_items_super_lotteries` FOREIGN KEY (`eve_item_id`) REFERENCES `eve_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_super_lotteries` FOREIGN KEY (`creator_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `winner_users_super_lotteries` FOREIGN KEY (`winner_user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `super_lottery_tickets`
--
ALTER TABLE `super_lottery_tickets`
  ADD CONSTRAINT `super_lottery_tickets_buyer` FOREIGN KEY (`buyer_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `super_lottery_ticket_id` FOREIGN KEY (`super_lottery_id`) REFERENCES `super_lotteries` (`id`);

--
-- Contraintes pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_lotteries` FOREIGN KEY (`lottery_id`) REFERENCES `lotteries` (`id`),
  ADD CONSTRAINT `tickets_users` FOREIGN KEY (`buyer_user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Contraintes pour la table `user_awards`
--
ALTER TABLE `user_awards`
  ADD CONSTRAINT `user_awards_ibfk_1` FOREIGN KEY (`award_id`) REFERENCES `awards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_awards_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_tickets` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `withdrawals_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
