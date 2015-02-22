SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=237 ;

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(61, NULL, NULL, NULL, 'controllers', 1, 208),
(62, 61, NULL, NULL, 'Articles', 2, 17),
(68, 61, NULL, NULL, 'Configs', 18, 19),
(74, 61, NULL, NULL, 'EveCategories', 20, 31),
(80, 61, NULL, NULL, 'EveItems', 32, 45),
(86, 61, NULL, NULL, 'Groups', 46, 47),
(92, 61, NULL, NULL, 'Lotteries', 48, 63),
(93, 92, NULL, NULL, 'index', 49, 50),
(98, 61, NULL, NULL, 'LotteryStatuses', 64, 65),
(104, 61, NULL, NULL, 'Pages', 66, 69),
(105, 104, NULL, NULL, 'display', 67, 68),
(106, 61, NULL, NULL, 'Tickets', 70, 75),
(112, 61, NULL, NULL, 'Users', 76, 107),
(119, 112, NULL, NULL, 'logout', 77, 78),
(121, 61, NULL, NULL, 'AclExtras', 108, 109),
(123, 106, NULL, NULL, 'buy', 71, 72),
(132, 92, NULL, NULL, 'list_lotteries', 51, 52),
(133, 92, NULL, NULL, 'admin_index', 53, 54),
(134, 92, NULL, NULL, 'admin_view', 55, 56),
(136, 92, NULL, NULL, 'admin_delete', 57, 58),
(137, 62, NULL, NULL, 'admin_index', 3, 4),
(138, 62, NULL, NULL, 'admin_view', 5, 6),
(139, 62, NULL, NULL, 'admin_add', 7, 8),
(140, 62, NULL, NULL, 'admin_edit', 9, 10),
(141, 62, NULL, NULL, 'admin_delete', 11, 12),
(142, 74, NULL, NULL, 'admin_index', 21, 22),
(143, 74, NULL, NULL, 'admin_view', 23, 24),
(144, 74, NULL, NULL, 'admin_add', 25, 26),
(145, 74, NULL, NULL, 'admin_edit', 27, 28),
(146, 74, NULL, NULL, 'admin_delete', 29, 30),
(147, 80, NULL, NULL, 'admin_index', 33, 34),
(148, 80, NULL, NULL, 'admin_view', 35, 36),
(149, 80, NULL, NULL, 'admin_add', 37, 38),
(150, 80, NULL, NULL, 'admin_edit', 39, 40),
(151, 80, NULL, NULL, 'admin_delete', 41, 42),
(153, 112, NULL, NULL, 'admin_index', 79, 80),
(154, 112, NULL, NULL, 'admin_view', 81, 82),
(155, 112, NULL, NULL, 'admin_edit', 83, 84),
(156, 112, NULL, NULL, 'admin_delete', 85, 86),
(157, 80, NULL, NULL, 'admin_update_prices', 43, 44),
(161, 92, NULL, NULL, 'old_list', 59, 60),
(162, 112, NULL, NULL, 'user_navbar', 87, 88),
(164, 61, NULL, NULL, 'Transactions', 110, 115),
(168, 106, NULL, NULL, 'buy_firsts', 73, 74),
(169, 61, NULL, NULL, 'Withdrawals', 116, 137),
(170, 169, NULL, NULL, 'index', 117, 118),
(171, 169, NULL, NULL, 'list_awards', 119, 120),
(172, 169, NULL, NULL, 'old_list', 121, 122),
(173, 169, NULL, NULL, 'claim', 123, 124),
(174, 169, NULL, NULL, 'admin_index', 125, 126),
(175, 169, NULL, NULL, 'admin_list_awards_to_complete', 127, 128),
(176, 169, NULL, NULL, 'admin_complete_award', 129, 130),
(177, 164, NULL, NULL, 'index', 111, 112),
(180, 169, NULL, NULL, 'admin_reserve_award', 131, 132),
(181, 61, NULL, NULL, 'DatabaseLogger', 138, 149),
(182, 181, NULL, NULL, 'Logs', 139, 148),
(183, 182, NULL, NULL, 'admin_index', 140, 141),
(184, 182, NULL, NULL, 'admin_export', 142, 143),
(185, 182, NULL, NULL, 'admin_view', 144, 145),
(186, 182, NULL, NULL, 'admin_delete', 146, 147),
(187, 61, NULL, NULL, 'Icing', 150, 151),
(190, 61, NULL, NULL, 'Awards', 152, 165),
(191, 190, NULL, NULL, 'admin_index', 153, 154),
(192, 190, NULL, NULL, 'admin_view', 155, 156),
(193, 190, NULL, NULL, 'admin_add', 157, 158),
(194, 190, NULL, NULL, 'admin_edit', 159, 160),
(195, 190, NULL, NULL, 'admin_delete', 161, 162),
(196, 61, NULL, NULL, 'Statistics', 166, 175),
(199, 112, NULL, NULL, 'initDB', 89, 90),
(200, 190, NULL, NULL, 'index', 163, 164),
(201, 61, NULL, NULL, 'UserAwards', 176, 179),
(203, 201, NULL, NULL, 'claim', 177, 178),
(204, 61, NULL, NULL, 'SuperLotteries', 180, 197),
(205, 204, NULL, NULL, 'index', 181, 182),
(207, 204, NULL, NULL, 'admin_index', 183, 184),
(208, 204, NULL, NULL, 'admin_view', 185, 186),
(209, 204, NULL, NULL, 'admin_add', 187, 188),
(210, 204, NULL, NULL, 'admin_edit', 189, 190),
(211, 204, NULL, NULL, 'admin_delete', 191, 192),
(212, 61, NULL, NULL, 'SuperLotteryTickets', 198, 201),
(213, 212, NULL, NULL, 'buy', 199, 200),
(214, 204, NULL, NULL, 'admin_complete', 193, 194),
(215, 112, NULL, NULL, 'login', 91, 92),
(216, 112, NULL, NULL, 'forbidden', 93, 94),
(217, 62, NULL, NULL, 'index', 13, 14),
(218, 196, NULL, NULL, 'index', 167, 168),
(219, 204, NULL, NULL, 'claim', 195, 196),
(220, 169, NULL, NULL, 'list_super_awards', 133, 134),
(221, 61, NULL, NULL, 'Messages', 202, 207),
(222, 221, NULL, NULL, 'index', 203, 204),
(223, 221, NULL, NULL, 'delete', 205, 206),
(224, 169, NULL, NULL, 'view', 135, 136),
(225, 112, NULL, NULL, 'register', 95, 96),
(226, 112, NULL, NULL, 'activate', 97, 98),
(227, 112, NULL, NULL, 'edit', 99, 100),
(228, 112, NULL, NULL, 'password_reinit', 101, 102),
(229, 112, NULL, NULL, 'account', 103, 104),
(230, 112, NULL, NULL, 'resend_activation_mail', 105, 106),
(231, 196, NULL, NULL, 'list_stats', 169, 170),
(232, 164, NULL, NULL, 'list_transactions', 113, 114),
(233, 92, NULL, NULL, 'index_open', 61, 62),
(234, 196, NULL, NULL, 'admin_index', 171, 172),
(235, 62, NULL, NULL, 'read_all', 15, 16),
(236, 196, NULL, NULL, 'admin_thanks_player', 173, 174);

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

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(3, NULL, 'Group', 3, NULL, 1, 2),
(4, NULL, 'Group', 4, NULL, 3, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

INSERT INTO `awards` (`id`, `name`, `description`, `group`, `order`, `request`, `award_credits`, `status`, `created`, `modified`) VALUES
(12, 'Gotta buy them all !', 'Buy 4 or more ticket simultaneously to win this award.', 'ticket', 6, 'SELECT MAX(number_buy)>=4 as result FROM (SELECT user_id, COUNT(*) as number_buy FROM statistics WHERE user_id = ? AND type = ''buy_ticket'' GROUP BY created) er GROUP BY user_id', 2000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:38'),
(22, 'My precious !', 'Win a lottery that you started to win this award.', 'special', 2, 'SELECT COUNT( * ) >=1 AS result\r\nFROM (\r\n\r\nSELECT COUNT( * ) >1 AS result\r\nFROM statistics\r\nWHERE user_id =  ?\r\nAND (\r\n\r\nTYPE =  ''win_lottery''\r\nOR TYPE =  ''init_lottery''\r\n)\r\nGROUP BY value\r\n)er\r\nWHERE er.result >=1', 3000000.00, 'Active', '2014-10-17 19:44:38', '2014-10-18 16:18:24'),
(23, 'Sniper', 'Win a lottery were you bought the last ticket.', 'special', 2, 'SELECT COUNT( * ) >=1 AS result\r\nFROM (\r\n\r\nSELECT COUNT( * ) >1 AS result\r\nFROM statistics\r\nWHERE user_id =  ?\r\nAND (\r\n\r\nTYPE =  ''win_lottery''\r\nOR TYPE =  ''end_lottery''\r\n)\r\nGROUP BY value\r\n)er\r\nWHERE er.result >=1', 3000000.00, 'Active', '2014-10-17 19:44:38', '2014-10-18 16:18:24'),
(26, 'Welcome !', 'Connect into EVE-Lotteries for the first time !', 'special', 1, 'select COUNT(*)>=1 as result FROM statistics WHERE user_id = ? AND type = ''connection'' AND value = ''first''', 1000000.00, 'Active', '2014-10-28 19:36:34', '2014-10-28 19:36:34'),
(27, 'Almost there !', 'Buy 6 or more tickets simultaneously to win this award.', 'ticket', 7, 'SELECT MAX(number_buy)>=6 as result FROM (SELECT user_id, COUNT(*) as number_buy FROM statistics WHERE user_id = ? AND type = ''buy_ticket'' GROUP BY created) er GROUP BY user_id', 4000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(28, 'First try', 'Buy 1 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>1 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', 1000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(29, 'Try again', 'Buy 10 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>10 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', 2500000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(30, 'Fifty shades of green', 'Buy 50 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>50 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', 5000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(31, 'Hundred little ', 'Buy 100 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>100 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', 10000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(32, 'Did he say play ?', 'Buy 250 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>250 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', 25000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(33, 'Heavyweight player', 'Buy 500 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>500 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', 35000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(34, 'Marathon runner', 'Buy 1000 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>1000 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', 50000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(35, 'Gambling is my day job', 'Buy 2000 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>2000 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', 100000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(36, 'Lotteries addict', 'Buy 5000 tickets or more.', 'ticket', 7, 'SELECT COUNT(*)>5000 as result FROM statistics WHERE user_id = ? AND type = ''buy_ticket''', 200000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(37, 'First deposit', 'Deposit 100 millions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=100000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', 5000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(38, 'Oil the machine', 'Deposit 500 millions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=500000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', 25000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(39, 'Billionaire', 'Deposit one billion into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=1000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', 50000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(40, 'Multi billionaire', 'Deposit 5 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=5000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', 100000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(41, 'Extra big spender', 'Deposit 10 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=10000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', 150000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(42, 'Super or gambling ?', 'Deposit 25 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=25000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', 200000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(43, 'Can''t wait to win !', 'Deposit 40 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=40000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', 250000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(44, 'Big red button', 'Deposit 50 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=50000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', 300000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(45, 'I used to have a Titan', 'Deposit 100 billions into your EVE-Lotteries account.', 'deposits', 7, 'select SUM(isk_value)>=100000000000 as result FROM statistics WHERE user_id = ? AND type = ''deposit_isk'' GROUP BY user_id', 500000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(46, 'I did it !', 'Win your first lottery.', 'win', 1, 'select count(*)>=1 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', 1000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(47, 'Chance as nothing to do with it.', 'Win at least ten lotteries.', 'win', 2, 'select count(*)>=10 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', 5000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(48, '50 reasons to play', 'Win at least 50 lotteries.', 'win', 3, 'select count(*)>=50 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', 25000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(49, 'Made my day', 'Win at least 100 lotteries.', 'win', 4, 'select count(*)>=100 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', 50000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(50, 'I was told to play.', 'Win at least 250 lotteries.', 'win', 5, 'select count(*)>=250 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', 100000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(51, 'Chick magnet', 'Win at least 500 lotteries.', 'win', 6, 'select count(*)>=500 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', 150000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(52, 'Elite gambler', 'Win at least a thousand lotteries.', 'win', 7, 'select count(*)>=1000 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery''', 250000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(53, 'Can''t stop the Rokh.', 'Win 1 Rohk.', 'items', 1, 'select count(*)>=1 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 233', 5000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(54, 'Woop Woop !', 'Win 10 police pursuit comet.', 'items', 2, 'select count(*)>=10 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 303', 5000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(55, 'The swarm', 'Win 50 frigates.', 'items', 3, 'SELECT COUNT(*) >=50 AS result FROM statistics INNER JOIN eve_items ON statistics.eve_item_id = eve_items.id WHERE statistics.user_id = ? AND statistics.type =  ''win_lottery'' AND eve_items.eve_category_id = 4', 10000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(56, 'Cruiser addict', 'Win 50 cruiser.', 'items', 4, 'SELECT COUNT(*) >=50 AS result FROM statistics INNER JOIN eve_items ON statistics.eve_item_id = eve_items.id WHERE statistics.user_id = ? AND statistics.type =  ''win_lottery'' AND eve_items.eve_category_id = 3', 20000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(57, 'May the force be with you !', 'Win 50 battleships.', 'items', 5, 'SELECT COUNT(*) >=50 AS result FROM statistics INNER JOIN eve_items ON statistics.eve_item_id = eve_items.id WHERE statistics.user_id = ? AND statistics.type =  ''win_lottery'' AND eve_items.eve_category_id = 59', 50000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(58, 'Falcon is primary !', 'Win 10 falcon.', 'items', 6, 'select count(*)>=10 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 117', 10000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(59, 'Bump machine', 'Win 5 Machariel.', 'items', 7, 'select count(*)>=5 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 180', 10000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(60, 'Providence', 'Win 5 providence.', 'items', 8, 'select count(*)>=5 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 199', 100000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(61, 'Koros', 'Win 5 moros.', 'items', 9, 'select count(*)>=5 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 195', 100000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(62, 'One, Two...', 'Win 3 tempest fleet issue.', 'items', 10, 'select count(*)>=3 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 178', 20000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(63, 'In the navy !', 'Win 5 megathron navy issue.', 'items', 11, 'select count(*)>=5 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 177', 25000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(64, 'Ready to mine', 'Win 15 orcas.', 'items', 11, 'select count(*)>=15 as result FROM statistics WHERE user_id = ? AND type = ''win_lottery'' AND eve_item_id = 248', 100000000.00, 'Active', '2014-10-17 19:39:43', '2014-10-28 20:11:16'),
(65, 'Bug smasher', 'Helping the EVE-Lotteries team to find bugs, errors and exploits in the site. Seriously, guys this helps us a lot !', 'special', 10, 'select count(*) as result FROM statistics WHERE user_id = ? AND type = ''help_bug'' GROUP BY user_id', 50000000.00, 'Active', '2015-02-22 02:30:59', '2015-02-22 02:30:59');

CREATE TABLE IF NOT EXISTS `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(1024) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

INSERT INTO `configs` (`id`, `name`, `value`, `created`, `modified`) VALUES
(1, 'corpoKeyID', '3706873', '2014-09-18 22:45:35', '2014-09-18 22:45:35'),
(2, 'corpoVCode', 'WDb4vFcUcSqPxGl5XzrVr3L8pVdBwGhjqFCNzgrfM03TXo5O3ZUTM3aYrb4jtTS2', '2014-09-18 22:45:52', '2014-09-18 22:45:52'),
(3, 'apiCheck', '2015-02-22T14:35:02+01:00', '2014-09-18 22:49:08', '2014-09-18 22:49:08'),
(4, 'app_eve_id', '8d96866dbbd44046b55eea2e519ca93a', '2014-10-08 19:59:53', '2014-10-08 19:59:53'),
(5, 'app_eve_secret', 'ysYvCpixDmbBALVkv2XIDqsxZgiVXAObGsW6O7lq', '2014-10-08 19:59:53', '2014-10-08 19:59:53'),
(6, 'eve_sso_url', 'https://login.eveonline.com/oauth/', '2014-10-08 20:02:40', '2014-10-08 20:02:40'),
(7, 'app_return_url', 'http://localhost/little/users/eve_login', '2014-10-08 20:02:40', '2014-10-08 20:02:40');

CREATE TABLE IF NOT EXISTS `eve_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `url_start` varchar(255) NOT NULL,
  `url_small_end` varchar(255) NOT NULL DEFAULT '_64.png',
  `url_big_end` varchar(255) NOT NULL DEFAULT '_128.png',
  `profit` int(11) NOT NULL DEFAULT '15',
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

INSERT INTO `eve_categories` (`id`, `name`, `type`, `url_start`, `url_small_end`, `url_big_end`, `profit`, `status`) VALUES
(3, 'Cruisers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 0),
(4, 'Faction Frigates', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(5, 'Interdictors', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(6, 'Covert ops', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(7, 'Heavy Interdictors', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(8, 'Pirate Battleships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(50, 'Electronic Attack Ships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(51, 'Industrials', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(52, 'Assault Frigates', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(53, 'Interceptors', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(54, 'Cruiser T3', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(55, 'Faction Battleships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(56, 'Carriers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(57, 'Freighters', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(58, 'Jump Freighters', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(59, 'Battleships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(60, 'Command Ships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(61, 'Battlecruisers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(62, 'Recon Ships', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(63, 'Mining Barges', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(64, 'Heavy Assault Cruisers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(65, 'Logistics', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(66, 'Limited Edition', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 0),
(67, 'Dreadnought', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(68, 'Black ops', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(69, 'Capital Industrials', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(70, 'Marauders', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(71, 'Destroyers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(72, 'Plex', 'Item', 'https://image.eveonline.com/Type/', '_64.png', '_64.png', 20, 1),
(73, 'Pirate Frigates', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(74, 'Faction Cruisers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(75, 'Pirate Cruisers', 'Ship', 'https://image.eveonline.com/Render/', '_64.png', '_128.png', 20, 1),
(77, 'Items', 'Item', 'https://image.eveonline.com/Type/', '_64.png', '_64.png', 20, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=312 ;

INSERT INTO `eve_items` (`id`, `eve_id`, `name`, `eve_category_id`, `eve_value`, `status`, `nb_tickets_default`) VALUES
(27, 620, 'Osprey', 3, 8533355.91, 0, 8),
(28, 621, 'Caracal', 3, 11964854.68, 0, 8),
(29, 622, 'Stabber', 3, 11787377.10, 0, 8),
(30, 623, 'Moa', 3, 11161374.12, 0, 8),
(31, 624, 'Maller', 3, 11724275.95, 0, 8),
(32, 625, 'Augoror', 3, 10142294.33, 0, 8),
(33, 626, 'Vexor', 3, 11424736.55, 0, 8),
(34, 627, 'Thorax', 3, 11236823.73, 0, 8),
(35, 628, 'Arbitrator', 3, 9594595.24, 0, 8),
(36, 629, 'Rupture', 3, 12006676.79, 0, 8),
(37, 630, 'Bellicose', 3, 9640766.08, 0, 8),
(38, 631, 'Scythe', 3, 9454870.82, 0, 8),
(39, 632, 'Blackbird', 3, 9418030.81, 0, 8),
(40, 633, 'Celestis', 3, 9855607.10, 0, 8),
(41, 634, 'Exequror', 3, 10090664.55, 0, 8),
(43, 638, 'Raven', 59, 188470719.68, 1, 8),
(44, 639, 'Tempest', 59, 184047565.38, 1, 8),
(45, 640, 'Scorpion', 59, 168338869.91, 1, 8),
(46, 641, 'Megathron', 59, 186980033.38, 1, 8),
(47, 642, 'Apocalypse', 59, 188067161.38, 1, 8),
(48, 643, 'Armageddon', 59, 192887190.07, 1, 8),
(49, 644, 'Typhoon', 59, 179449984.48, 1, 8),
(50, 645, 'Dominix', 59, 200225159.38, 1, 8),
(64, 2006, 'Omen', 3, 11812662.51, 0, 8),
(65, 2078, 'Zephyr', 66, 48031003.71, 0, 8),
(69, 2863, 'Primae', 66, 9119278.68, 0, 8),
(70, 2998, 'Noctis', 51, 79679817.21, 1, 8),
(74, 3532, 'Echelon', 66, 9295742.67, 0, 8),
(75, 3756, 'Gnosis', 61, 127755256.78, 0, 8),
(79, 4302, 'Oracle', 61, 76509337.79, 1, 8),
(80, 4306, 'Naga', 61, 71146116.46, 1, 8),
(81, 4308, 'Talos', 61, 76511726.28, 1, 8),
(82, 4310, 'Tornado', 61, 69025325.55, 1, 8),
(89, 11172, 'Helios', 6, 21876861.65, 1, 8),
(90, 11174, 'Keres', 50, 22421298.86, 1, 8),
(91, 11176, 'Crow', 53, 22581660.96, 1, 8),
(92, 11178, 'Raptor', 53, 22100428.69, 1, 8),
(93, 11182, 'Cheetah', 6, 21074128.84, 1, 8),
(94, 11184, 'Crusader', 53, 19010240.59, 1, 8),
(95, 11186, 'Malediction', 53, 21327684.97, 1, 8),
(96, 11188, 'Anathema', 6, 18900957.39, 1, 8),
(97, 11190, 'Sentinel', 50, 19846466.03, 1, 8),
(98, 11192, 'Buzzard', 6, 23809843.24, 1, 8),
(99, 11194, 'Kitsune', 50, 24930008.73, 1, 8),
(100, 11196, 'Claw', 53, 20392659.38, 1, 8),
(101, 11198, 'Stiletto', 53, 19181452.81, 1, 8),
(102, 11200, 'Taranis', 53, 24080539.59, 1, 8),
(103, 11202, 'Ares', 53, 21247919.23, 1, 8),
(104, 11365, 'Vengeance', 52, 23475055.16, 1, 8),
(105, 11371, 'Wolf', 52, 22673272.08, 1, 8),
(106, 11377, 'Nemesis', 6, 22816161.12, 1, 8),
(107, 11379, 'Hawk', 52, 29117039.15, 1, 8),
(108, 11381, 'Harpy', 52, 40410086.72, 1, 8),
(109, 11387, 'Hyena', 50, 23709045.19, 1, 8),
(110, 11393, 'Retribution', 52, 23695562.47, 1, 8),
(111, 11400, 'Jaguar', 52, 22345750.76, 1, 8),
(117, 11957, 'Falcon', 62, 187986182.66, 1, 8),
(118, 11959, 'Rook', 62, 198297079.19, 1, 8),
(119, 11961, 'Huginn', 62, 168920613.58, 1, 8),
(120, 11963, 'Rapier', 62, 171093839.61, 1, 8),
(121, 11965, 'Pilgrim', 62, 150491087.96, 1, 8),
(122, 11969, 'Arazu', 62, 169941779.28, 1, 8),
(123, 11971, 'Lachesis', 62, 190382538.55, 1, 8),
(124, 11978, 'Scimitar', 65, 161636836.68, 1, 8),
(125, 11985, 'Basilisk', 65, 188087416.94, 1, 8),
(126, 11987, 'Guardian', 65, 159765613.86, 1, 8),
(127, 11989, 'Oneiros', 65, 174443241.01, 1, 8),
(128, 11993, 'Cerberus', 64, 200188659.03, 1, 8),
(129, 11995, 'Onyx', 7, 303544456.18, 1, 8),
(130, 11999, 'Vagabond', 64, 167762881.22, 1, 8),
(131, 12003, 'Zealot', 64, 146327411.44, 1, 8),
(132, 12005, 'Ishtar', 64, 186640013.64, 1, 8),
(133, 12011, 'Eagle', 64, 203504660.94, 1, 8),
(134, 12013, 'Broadsword', 7, 237181695.71, 1, 8),
(135, 12015, 'Muninn', 64, 153503347.33, 1, 8),
(136, 12017, 'Devoter', 7, 220038663.45, 1, 8),
(137, 12019, 'Sacrilege', 64, 159488253.77, 1, 8),
(138, 12021, 'Phobos', 7, 264591878.99, 1, 8),
(139, 12023, 'Deimos', 64, 185405306.51, 1, 8),
(140, 12032, 'Manticore', 6, 23496769.79, 1, 8),
(141, 12034, 'Hound', 6, 21498875.38, 1, 8),
(142, 12038, 'Purifier', 6, 21080997.66, 1, 8),
(143, 12042, 'Ishkur', 52, 26009948.62, 1, 8),
(144, 12044, 'Enyo', 52, 25069640.56, 1, 8),
(145, 12729, 'Crane', 51, 139624119.01, 1, 8),
(146, 12731, 'Bustard', 51, 200019674.00, 1, 8),
(147, 12733, 'Prorator', 51, 110373022.50, 1, 8),
(148, 12735, 'Prowler', 51, 114779267.37, 1, 8),
(149, 12743, 'Viator', 51, 125433248.74, 1, 8),
(150, 12745, 'Occator', 51, 187400276.06, 1, 8),
(151, 12747, 'Mastodon', 51, 156371938.16, 1, 8),
(152, 12753, 'Impel', 51, 156992029.97, 1, 8),
(154, 16227, 'Ferox', 61, 46022982.54, 1, 8),
(155, 16229, 'Brutix', 61, 55040312.02, 1, 8),
(156, 16231, 'Cyclone', 61, 42699663.10, 1, 8),
(157, 16233, 'Prophecy', 61, 52301759.12, 1, 8),
(163, 17476, 'Covetor', 63, 33208135.28, 0, 8),
(164, 17478, 'Retriever', 63, 28696399.19, 0, 8),
(165, 17480, 'Procurer', 63, 22722286.27, 0, 8),
(166, 17619, 'Caldari Navy Hookbill', 4, 19367289.60, 1, 8),
(167, 17634, 'Caracal Navy Issue', 74, 86872482.58, 1, 8),
(168, 17636, 'Raven Navy Issue', 55, 602246637.66, 1, 16),
(169, 17703, 'Imperial Navy Slicer', 4, 11464587.02, 1, 8),
(170, 17709, 'Omen Navy Issue', 74, 60556228.47, 1, 8),
(171, 17713, 'Stabber Fleet Issue', 74, 58580632.35, 1, 8),
(172, 17715, 'Gila', 75, 276719950.13, 1, 8),
(173, 17718, 'Phantasm', 75, 170393961.80, 1, 8),
(174, 17720, 'Cynabal', 75, 158998340.00, 1, 8),
(175, 17722, 'Vigilant', 75, 261573936.53, 1, 8),
(176, 17726, 'Apocalypse Navy Issue', 55, 413546165.31, 1, 16),
(177, 17728, 'Megathron Navy Issue', 55, 496111807.62, 1, 16),
(178, 17732, 'Tempest Fleet Issue', 55, 569130284.63, 1, 16),
(179, 17736, 'Nightmare', 8, 609534168.70, 1, 16),
(180, 17738, 'Machariel', 8, 758518685.99, 1, 16),
(181, 17740, 'Vindicator', 8, 844715031.42, 1, 16),
(182, 17812, 'Republic Fleet Firetail', 4, 13475425.94, 1, 8),
(183, 17841, 'Federation Navy Comet', 4, 17837811.18, 1, 8),
(184, 17843, 'Vexor Navy Issue', 74, 91705297.38, 1, 8),
(185, 17918, 'Rattlesnake', 8, 441152974.31, 1, 16),
(186, 17920, 'Bhaalgorn', 8, 562724078.09, 1, 16),
(187, 17922, 'Ashimmu', 75, 138239579.66, 1, 8),
(188, 17924, 'Succubus', 73, 72302150.65, 1, 8),
(189, 17926, 'Cruor', 73, 52997286.91, 1, 8),
(190, 17928, 'Daredevil', 73, 71293137.22, 1, 8),
(191, 17930, 'Worm', 73, 76349577.76, 1, 8),
(192, 17932, 'Dramiel', 73, 51678882.36, 1, 8),
(193, 19720, 'Revelation', 67, 2337026664.47, 1, 16),
(194, 19722, 'Naglfar', 67, 2530696351.38, 1, 16),
(195, 19724, 'Moros', 67, 2538725423.93, 1, 16),
(196, 19726, 'Phoenix', 67, 2409017390.09, 1, 16),
(198, 20125, 'Curse', 62, 167925227.63, 1, 8),
(199, 20183, 'Providence', 57, 1415752583.19, 1, 16),
(200, 20185, 'Charon', 57, 1394074250.74, 1, 16),
(201, 20187, 'Obelisk', 57, 1446296891.86, 1, 16),
(202, 20189, 'Fenrir', 57, 1390306305.64, 1, 16),
(203, 21097, 'Goru''s Shuttle', 66, 4449573.74, 0, 8),
(204, 21628, 'Guristas Shuttle', 66, 22968497.88, 0, 8),
(205, 22428, 'Redeemer', 68, 791528969.84, 1, 16),
(206, 22430, 'Sin', 68, 903881785.76, 1, 16),
(207, 22436, 'Widow', 68, 919080308.11, 1, 16),
(208, 22440, 'Panther', 68, 829053390.86, 1, 16),
(209, 22442, 'Eos', 60, 326661703.35, 1, 8),
(210, 22444, 'Sleipnir', 60, 310410045.36, 1, 8),
(211, 22446, 'Vulture', 60, 311802608.52, 1, 8),
(212, 22448, 'Absolution', 60, 236918847.00, 1, 8),
(213, 22452, 'Heretic', 5, 42888590.67, 1, 8),
(214, 22456, 'Sabre', 5, 48836203.44, 1, 8),
(215, 22460, 'Eris', 5, 46296813.26, 1, 8),
(216, 22464, 'Flycatcher', 5, 55777902.88, 1, 8),
(217, 22466, 'Astarte', 60, 306544804.85, 1, 8),
(218, 22468, 'Claymore', 60, 292500000.00, 1, 8),
(219, 22470, 'Nighthawk', 60, 278536605.42, 1, 8),
(220, 22474, 'Damnation', 60, 260930287.31, 1, 8),
(221, 22544, 'Hulk', 63, 248207887.28, 1, 8),
(222, 22546, 'Skiff', 63, 184499576.83, 1, 8),
(223, 22548, 'Mackinaw', 63, 206191051.85, 1, 8),
(225, 23757, 'Archon', 56, 1288363480.44, 1, 16),
(227, 23911, 'Thanatos', 56, 1310202517.75, 1, 16),
(229, 23915, 'Chimera', 56, 1271427142.18, 1, 16),
(232, 24483, 'Nidhoggur', 56, 1320566880.14, 1, 16),
(233, 24688, 'Rokh', 59, 217682301.30, 1, 8),
(234, 24690, 'Hyperion', 59, 218179521.52, 1, 8),
(235, 24692, 'Abaddon', 59, 217630713.98, 1, 8),
(236, 24694, 'Maelstrom', 59, 191223133.76, 1, 8),
(237, 24696, 'Harbinger', 61, 50914509.01, 1, 8),
(238, 24698, 'Drake', 61, 54618663.33, 1, 8),
(239, 24700, 'Myrmidon', 61, 53051117.66, 1, 8),
(240, 24702, 'Hurricane', 61, 47479855.77, 1, 8),
(247, 28352, 'Rorqual', 69, 2420164163.56, 1, 16),
(248, 28606, 'Orca', 69, 729372090.74, 1, 16),
(249, 28659, 'Paladin', 70, 973180897.11, 1, 16),
(250, 28661, 'Kronos', 70, 1098637092.88, 1, 16),
(251, 28665, 'Vargur', 70, 1024034420.56, 1, 16),
(252, 28710, 'Golem', 70, 1253734769.00, 1, 16),
(253, 28844, 'Rhea', 58, 7600343426.95, 1, 16),
(254, 28846, 'Nomad', 58, 7199743578.42, 1, 16),
(255, 28848, 'Anshar', 58, 7772570993.64, 1, 16),
(256, 28850, 'Ark', 58, 7219432257.87, 1, 16),
(258, 29266, 'Apotheosis', 66, 26402626.46, 0, 8),
(259, 29336, 'Scythe Fleet Issue', 74, 89818143.33, 1, 8),
(260, 29337, 'Augoror Navy Issue', 74, 51243334.08, 1, 8),
(261, 29340, 'Osprey Navy Issue', 74, 77719474.25, 1, 8),
(262, 29344, 'Exequror Navy Issue', 74, 91722071.10, 1, 8),
(263, 29984, 'Tengu', 54, 196036096.88, 1, 8),
(264, 29986, 'Legion', 54, 186358044.36, 1, 8),
(265, 29988, 'Proteus', 54, 196728271.38, 1, 8),
(266, 29990, 'Loki', 54, 178343609.08, 1, 8),
(267, 30842, 'Interbus Shuttle', 66, 859437243.11, 0, 8),
(270, 32305, 'Armageddon Navy Issue', 55, 391167534.88, 1, 16),
(271, 32307, 'Dominix Navy Issue', 55, 557190482.87, 1, 16),
(272, 32309, 'Scorpion Navy Issue', 55, 563187718.78, 1, 16),
(273, 32311, 'Typhoon Fleet Issue', 55, 441309406.47, 1, 16),
(277, 32840, 'InterBus Catalyst', 66, 31036279.05, 0, 8),
(280, 32848, 'Aliastra Catalyst', 66, 34504508.27, 0, 8),
(290, 33079, 'Hematos', 66, 303540222.05, 0, 8),
(291, 33081, 'Taipan', 66, 291128142.28, 0, 8),
(292, 33083, 'Violator', 66, 288582573.08, 0, 8),
(293, 33099, 'Nefantar Thrasher', 66, 120394280.03, 0, 8),
(294, 33151, 'Brutix Navy Issue', 61, 266651988.85, 1, 8),
(295, 33153, 'Drake Navy Issue', 61, 214346190.32, 1, 8),
(296, 33155, 'Harbinger Navy Issue', 61, 146640651.81, 1, 8),
(297, 33157, 'Hurricane Fleet Issue', 61, 170695359.52, 1, 8),
(301, 33468, 'Astero', 73, 87300248.90, 1, 8),
(302, 33470, 'Stratios', 55, 321793643.56, 1, 8),
(303, 33677, 'Police Pursuit Comet', 4, 27928918.61, 1, 8),
(304, 34328, 'Bowhead', 57, 1772718191.98, 1, 16),
(305, 34317, 'Confessor', 71, 49620165.98, 1, 8),
(306, 33818, 'Orthrus', 75, 353661067.65, 1, 8),
(307, 33816, 'Garmur', 4, 86753629.76, 1, 8),
(308, 33820, 'Barghest', 8, 695436292.43, 16, 8),
(309, 34562, 'Svipul', 71, 57727164.86, 1, 8),
(310, 29668, 'PLEX', 72, 881478809.04, 1, 16),
(311, 28756, 'Sisters Expanded Probe Launcher', 77, 43350567.01, 0, 8);

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `groups` (`id`, `name`) VALUES
(3, 'Admin'),
(4, 'Player'),
(5, 'Manager');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24379 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1039 ;

CREATE TABLE IF NOT EXISTS `lottery_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `lottery_status` (`id`, `name`) VALUES
(1, 'ongoing'),
(2, 'finished'),
(3, 'suspended'),
(4, 'claimed'),
(5, 'unclaimed');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1187 ;

CREATE TABLE IF NOT EXISTS `phealng-cache` (
  `userId` int(10) unsigned NOT NULL,
  `scope` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `args` varchar(250) NOT NULL,
  `xml` longtext NOT NULL,
  PRIMARY KEY (`userId`,`scope`,`name`,`args`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Caching for PhealNG';

INSERT INTO `phealng-cache` (`userId`, `scope`, `name`, `args`, `xml`) VALUES
(3706873, 'corp', 'walletjournal', '', '<?xml version=''1.0'' encoding=''UTF-8''?>\r\n<eveapi version="2">\r\n  <currentTime>2015-02-22 13:05:02</currentTime>\r\n  <result>\r\n    <rowset name="entries" key="refID" columns="date,refID,refTypeID,ownerName1,ownerID1,ownerName2,ownerID2,argName1,argID1,amount,balance,reason,owner1TypeID,owner2TypeID">\r\n      <row date="2015-02-22 12:01:36" refID="10793019162" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Taladona Isayeki" ownerID2="95373033" argName1="EVE-Lotteries" argID1="94931126" amount="-76511728.00" balance="2003616414.63" reason="DESC: Well done !&#xA;" owner1TypeID="2" owner2TypeID="1385" />\r\n      <row date="2015-02-22 11:57:48" refID="10793007320" refTypeID="10" ownerName1="Boston10" ownerID1="91165197" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="100000000.00" balance="2080128142.63" reason="" owner1TypeID="1375" owner2TypeID="2" />\r\n      <row date="2015-02-22 09:28:59" refID="10792575186" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Innersoul" ownerID2="796694724" argName1="Natasha Tolsen" argID1="94936751" amount="-217832602.00" balance="1980128142.63" reason="DESC: EVE-Lotteries&#xA;" owner1TypeID="2" owner2TypeID="1375" />\r\n      <row date="2015-02-22 08:16:19" refID="10792330724" refTypeID="10" ownerName1="Taladona Isayeki" ownerID1="95373033" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="200000000.00" balance="2197960744.63" reason="" owner1TypeID="1385" owner2TypeID="2" />\r\n      <row date="2015-02-22 08:00:30" refID="10792282177" refTypeID="10" ownerName1="Rhino Styx" ownerID1="1271064519" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="13300374.00" balance="1997960744.63" reason="" owner1TypeID="1385" owner2TypeID="2" />\r\n      <row date="2015-02-22 06:33:45" refID="10792024413" refTypeID="10" ownerName1="Hiashi Yenzyne" ownerID1="93644993" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="66000000.00" balance="1984660370.63" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-22 04:18:16" refID="10791622293" refTypeID="10" ownerName1="Bronopoly Crushingit" ownerID1="94330648" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="100000000.00" balance="1918660370.63" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-22 03:57:12" refID="10791561965" refTypeID="10" ownerName1="Hiashi Yenzyne" ownerID1="93644993" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="24000000.00" balance="1818660370.63" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-22 02:26:05" refID="10791279289" refTypeID="10" ownerName1="Exodus Cadelanne" ownerID1="93964098" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="50000000.00" balance="1794660370.63" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-22 01:25:54" refID="10791073345" refTypeID="10" ownerName1="Samuel Witwickey" ownerID1="95363276" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="10000000.00" balance="1744660370.63" reason="" owner1TypeID="1373" owner2TypeID="2" />\r\n      <row date="2015-02-21 23:41:25" refID="10790671517" refTypeID="10" ownerName1="Misti Dream" ownerID1="94691017" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="100000000.00" balance="1734660370.63" reason="" owner1TypeID="1373" owner2TypeID="2" />\r\n      <row date="2015-02-21 23:27:01" refID="10790608395" refTypeID="10" ownerName1="Hiashi Yenzyne" ownerID1="93644993" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="36000000.00" balance="1634660370.63" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-21 22:02:00" refID="10790211360" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="nitox wulgax" ownerID2="90950272" argName1="EVE-Lotteries" argID1="94931126" amount="-21160974.00" balance="1598660370.63" reason="" owner1TypeID="2" owner2TypeID="1373" />\r\n      <row date="2015-02-21 21:43:46" refID="10790125453" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Rhino Styx" ownerID2="1271064519" argName1="EVE-Lotteries" argID1="94931126" amount="-13300374.00" balance="1619821344.63" reason="DESC: Well done !&#xA;" owner1TypeID="2" owner2TypeID="1385" />\r\n      <row date="2015-02-21 21:43:15" refID="10790123129" refTypeID="42" ownerName1="EVE-Lotteries" ownerID1="94931126" ownerName2="" ownerID2="0" argName1="" argID1="0" amount="-142999996.98" balance="1633121718.63" reason="" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 21:39:04" refID="10790101720" refTypeID="10" ownerName1="Bawulf" ownerID1="607790377" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="150000000.00" balance="1776121715.61" reason="" owner1TypeID="1379" owner2TypeID="2" />\r\n      <row date="2015-02-21 21:31:58" refID="10790066864" refTypeID="10" ownerName1="Hiashi Yenzyne" ownerID1="93644993" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="50000000.00" balance="1626121715.61" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-21 21:30:25" refID="10790058250" refTypeID="10" ownerName1="Dollkzi" ownerID1="94726635" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="100000000.00" balance="1576121715.61" reason="" owner1TypeID="1386" owner2TypeID="2" />\r\n      <row date="2015-02-21 20:57:20" refID="10789895373" refTypeID="10" ownerName1="Hiashi Yenzyne" ownerID1="93644993" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="26000000.00" balance="1476121715.61" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-21 20:34:21" refID="10789779623" refTypeID="10" ownerName1="Hiashi Yenzyne" ownerID1="93644993" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="20000000.00" balance="1450121715.61" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-21 20:30:51" refID="10789761668" refTypeID="10" ownerName1="Innersoul" ownerID1="796694724" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="50000000.00" balance="1430121715.61" reason="" owner1TypeID="1375" owner2TypeID="2" />\r\n      <row date="2015-02-21 20:28:59" refID="10789752550" refTypeID="10" ownerName1="Innersoul" ownerID1="796694724" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="50000000.00" balance="1380121715.61" reason="" owner1TypeID="1375" owner2TypeID="2" />\r\n      <row date="2015-02-21 20:24:48" refID="10789730806" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Hiashi Yenzyne" ownerID2="93644993" argName1="EVE-Lotteries" argID1="94931126" amount="-18254527.00" balance="1330121715.61" reason="DESC: Well done !&#xA;" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 20:24:07" refID="10789727535" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Hiashi Yenzyne" ownerID2="93644993" argName1="EVE-Lotteries" argID1="94931126" amount="-20964336.00" balance="1348376242.61" reason="DESC: Well done !&#xA;" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 20:18:52" refID="10789700213" refTypeID="10" ownerName1="Oddsodz" ownerID1="587794656" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="50000000.00" balance="1369340578.61" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-21 20:00:19" refID="10789602261" refTypeID="10" ownerName1="Innersoul" ownerID1="796694724" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="100000000.00" balance="1319340578.61" reason="" owner1TypeID="1375" owner2TypeID="2" />\r\n      <row date="2015-02-21 19:59:19" refID="10789597127" refTypeID="10" ownerName1="Hiashi Yenzyne" ownerID1="93644993" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="19000000.00" balance="1219340578.61" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-21 19:58:14" refID="10789591439" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Zolder Zik" ownerID2="94796616" argName1="EVE-Lotteries" argID1="94931126" amount="-23002625.00" balance="1200340578.61" reason="DESC: Well done !&#xA;" owner1TypeID="2" owner2TypeID="1376" />\r\n      <row date="2015-02-21 19:51:21" refID="10789556589" refTypeID="10" ownerName1="Shaaken Wolf" ownerID1="92666903" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="100000000.00" balance="1223343203.61" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-21 19:48:02" refID="10789539603" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Soruko Charante" ownerID2="92354069" argName1="EVE-Lotteries" argID1="94931126" amount="-18969597.00" balance="1123343203.61" reason="DESC: Well done !&#xA;" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 19:45:20" refID="10789525614" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Soruko Charante" ownerID2="92354069" argName1="EVE-Lotteries" argID1="94931126" amount="-75155750.00" balance="1142312800.61" reason="DESC: Well done !&#xA;" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 19:45:16" refID="10789525358" refTypeID="10" ownerName1="Taladona Isayeki" ownerID1="95373033" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="150000000.00" balance="1217468550.61" reason="" owner1TypeID="1385" owner2TypeID="2" />\r\n      <row date="2015-02-21 19:42:34" refID="10789512699" refTypeID="42" ownerName1="EVE-Lotteries" ownerID1="94931126" ownerName2="" ownerID2="0" argName1="" argID1="0" amount="-20879998.89" balance="1067468550.61" reason="" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 19:42:13" refID="10789510759" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Oddsodz" ownerID2="587794656" argName1="EVE-Lotteries" argID1="94931126" amount="-23002625.00" balance="1088348549.50" reason="DESC: Well done !&#xA;" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 19:27:19" refID="10789431645" refTypeID="10" ownerName1="Dakaysv Daka" ownerID1="94949656" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="12000000.00" balance="1111351174.50" reason="" owner1TypeID="1383" owner2TypeID="2" />\r\n      <row date="2015-02-21 19:26:01" refID="10789425293" refTypeID="10" ownerName1="Mark Watts" ownerID1="94975403" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="50000000.00" balance="1099351174.50" reason="" owner1TypeID="1376" owner2TypeID="2" />\r\n      <row date="2015-02-21 19:22:55" refID="10789408217" refTypeID="42" ownerName1="EVE-Lotteries" ownerID1="94931126" ownerName2="" ownerID2="0" argName1="" argID1="0" amount="-79895530.82" balance="1049351174.50" reason="" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 19:16:04" refID="10789368276" refTypeID="10" ownerName1="Bodrul" ownerID1="1499247632" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="40000000.00" balance="1129246705.32" reason="" owner1TypeID="1375" owner2TypeID="2" />\r\n      <row date="2015-02-21 19:09:55" refID="10789333016" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Durand Severasse" ownerID2="93802462" argName1="EVE-Lotteries" argID1="94931126" amount="-25000000.00" balance="1089246705.32" reason="" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 19:09:49" refID="10789332370" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Soruko Charante" ownerID2="92354069" argName1="EVE-Lotteries" argID1="94931126" amount="-25000000.00" balance="1114246705.32" reason="" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 18:51:42" refID="10789239493" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Oddsodz" ownerID2="587794656" argName1="EVE-Lotteries" argID1="94931126" amount="-22237647.00" balance="1139246705.32" reason="DESC: Nice played !&#xA;" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 18:30:43" refID="10789126190" refTypeID="10" ownerName1="Hiashi Yenzyne" ownerID1="93644993" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="50000000.00" balance="1161484352.32" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-21 18:16:22" refID="10789056482" refTypeID="10" ownerName1="Billy Hix" ownerID1="91722367" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="10000000.00" balance="1111484352.32" reason="" owner1TypeID="1380" owner2TypeID="2" />\r\n      <row date="2015-02-21 18:11:25" refID="10789031056" refTypeID="10" ownerName1="Oddsodz" ownerID1="587794656" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="50000000.00" balance="1101484352.32" reason="" owner1TypeID="1377" owner2TypeID="2" />\r\n      <row date="2015-02-21 17:59:36" refID="10788970986" refTypeID="42" ownerName1="EVE-Lotteries" ownerID1="94931126" ownerName2="" ownerID2="0" argName1="" argID1="0" amount="-35999997.96" balance="1051484352.32" reason="" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 17:59:31" refID="10788970677" refTypeID="42" ownerName1="EVE-Lotteries" ownerID1="94931126" ownerName2="" ownerID2="0" argName1="" argID1="0" amount="-143999990.40" balance="1087484350.28" reason="" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 17:59:02" refID="10788968511" refTypeID="42" ownerName1="EVE-Lotteries" ownerID1="94931126" ownerName2="" ownerID2="0" argName1="" argID1="0" amount="-103030219.64" balance="1231484340.68" reason="" owner1TypeID="2" owner2TypeID="1377" />\r\n      <row date="2015-02-21 17:20:13" refID="10788776686" refTypeID="10" ownerName1="Eve Talaminada" ownerID1="94976482" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="50000000.00" balance="1334514560.32" reason="" owner1TypeID="1386" owner2TypeID="2" />\r\n      <row date="2015-02-21 14:18:38" refID="10787920449" refTypeID="37" ownerName1="EVE-Lotteries Corporation" ownerID1="98342107" ownerName2="Goldyass" ownerID2="95076889" argName1="EVE-Lotteries" argID1="94931126" amount="-19410498.00" balance="1284514560.32" reason="DESC: Nice done !&#xA;" owner1TypeID="2" owner2TypeID="1373" />\r\n      <row date="2015-02-21 14:16:30" refID="10787912731" refTypeID="10" ownerName1="NightCamper Roetz" ownerID1="95289170" ownerName2="EVE-Lotteries Corporation" ownerID2="98342107" argName1="" argID1="0" amount="12000000.00" balance="1303925058.32" reason="" owner1TypeID="1378" owner2TypeID="2" />\r\n    </rowset>\r\n  </result>\r\n  <cachedUntil>2015-02-22 13:32:02</cachedUntil>\r\n</eveapi>');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12083 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

INSERT INTO `super_lotteries` (`id`, `eve_item_id`, `number_items`, `name`, `creator_user_id`, `created`, `modified`, `nb_tickets`, `nb_ticket_bought`, `ticket_value`, `status`, `winner_user_id`) VALUES
(1, 187, 3, 'First blood!', 94936751, '2015-02-18 23:54:02', '2015-02-21 01:22:16', 150, 150, 4.00, 'completed', 1300909620),
(2, 305, 1, 'Confess your crime !', 92277125, '2015-02-20 21:06:34', '2015-02-21 18:28:41', 50, 50, 2.00, 'completed', 1712647475),
(3, 106, 5, 'Time to bomb someting !', 92277125, '2015-02-20 23:56:27', '2015-02-21 14:22:39', 100, 100, 2.00, 'completed', 95373033),
(4, 101, 10, 'Tackle all the things !', 92277125, '2015-02-21 03:44:31', '2015-02-21 21:21:53', 100, 100, 3.00, 'completed', 796694724),
(5, 309, 2, 'What a strange name...', 92277125, '2015-02-21 21:23:15', '2015-02-21 22:43:24', 100, 100, 2.00, 'completed', 94726635),
(6, 198, 1, 'We found a Curse !', 92277125, '2015-02-21 22:41:59', '2015-02-22 13:02:23', 200, 200, 2.00, 'completed', 796694724),
(7, 118, 1, 'Jam ALL the things !', 92277125, '2015-02-22 01:00:44', '2015-02-22 13:59:26', 150, 47, 2.00, 'ongoing', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7937 ;

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refid` varchar(255) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `eve_date` datetime NOT NULL,
  `created` datetime NOT NULL,
  KEY `id` (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=424 ;


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
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1028 ;

ALTER TABLE `articles`
  ADD CONSTRAINT `articles_users` FOREIGN KEY (`creator_user_id`) REFERENCES `users` (`id`);

ALTER TABLE `eve_items`
  ADD CONSTRAINT `eve_items_eve_categories` FOREIGN KEY (`eve_category_id`) REFERENCES `eve_categories` (`id`);

ALTER TABLE `lotteries`
  ADD CONSTRAINT `lotteries_eve_items` FOREIGN KEY (`eve_item_id`) REFERENCES `eve_items` (`id`),
  ADD CONSTRAINT `lotteries_lottery_status` FOREIGN KEY (`lottery_status_id`) REFERENCES `lottery_status` (`id`),
  ADD CONSTRAINT `lotteries_users` FOREIGN KEY (`creator_user_id`) REFERENCES `users` (`id`);

ALTER TABLE `statistics`
  ADD CONSTRAINT `statistics_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `super_lotteries`
  ADD CONSTRAINT `eve_items_super_lotteries` FOREIGN KEY (`eve_item_id`) REFERENCES `eve_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_super_lotteries` FOREIGN KEY (`creator_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `winner_users_super_lotteries` FOREIGN KEY (`winner_user_id`) REFERENCES `users` (`id`);

ALTER TABLE `super_lottery_tickets`
  ADD CONSTRAINT `super_lottery_tickets_buyer` FOREIGN KEY (`buyer_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `super_lottery_ticket_id` FOREIGN KEY (`super_lottery_id`) REFERENCES `super_lotteries` (`id`);

ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_lotteries` FOREIGN KEY (`lottery_id`) REFERENCES `lotteries` (`id`),
  ADD CONSTRAINT `tickets_users` FOREIGN KEY (`buyer_user_id`) REFERENCES `users` (`id`);

ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `users`
  ADD CONSTRAINT `users_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

ALTER TABLE `user_awards`
  ADD CONSTRAINT `user_awards_ibfk_1` FOREIGN KEY (`award_id`) REFERENCES `awards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_awards_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_tickets` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `withdrawals_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
