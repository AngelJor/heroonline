-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27 яну 2020 в 19:03
-- Версия на сървъра: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `heroonline`
--

-- --------------------------------------------------------

--
-- Структура на таблица `avatar`
--

CREATE TABLE `avatar` (
  `avatar_id` int(11) NOT NULL,
  `path` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `avatar`
--

INSERT INTO `avatar` (`avatar_id`, `path`) VALUES
(1, '../Pictures/h1.png'),
(2, '../Pictures/h2.png'),
(3, '../Pictures/h3.png'),
(4, '../Pictures/m1.png'),
(5, '../Pictures/m2.png'),
(6, '../Pictures/m3.png'),
(7, '../Pictures/p1.png'),
(8, '../Pictures/p2.png'),
(9, '../Pictures/p3.png'),
(10, '../Pictures/s2.png'),
(11, '../Pictures/s1.png'),
(12, '../Pictures/s3.png');

-- --------------------------------------------------------

--
-- Структура на таблица `battle_log`
--

CREATE TABLE `battle_log` (
  `battle_id` int(11) NOT NULL,
  `battle_state` int(11) NOT NULL,
  `attacker` int(11) NOT NULL,
  `defender` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `battle_log`
--

INSERT INTO `battle_log` (`battle_id`, `battle_state`, `attacker`, `defender`) VALUES
(1, 0, 23, 22),
(2, 0, 23, 22),
(3, 0, 23, 22),
(4, 0, 23, 22),
(5, 0, 23, 22),
(6, 0, 23, 22),
(7, 0, 23, 22),
(8, 0, 23, 22),
(9, 0, 23, 22),
(10, 0, 23, 22),
(11, 0, 23, 22),
(12, 0, 23, 22),
(13, 0, 22, 23),
(14, 0, 23, 22),
(15, 0, 22, 23),
(16, 0, 23, 22),
(17, 0, 23, 22),
(18, 0, 23, 22),
(19, 0, 23, 22),
(20, 0, 23, 22);

-- --------------------------------------------------------

--
-- Структура на таблица `champion`
--

CREATE TABLE `champion` (
  `name` text NOT NULL,
  `health` int(11) NOT NULL,
  `strength` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `xp` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `champion_id` int(11) NOT NULL,
  `armour_item` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `avatar_id` int(11) NOT NULL,
  `icon_id` int(11) NOT NULL,
  `diamond` int(11) NOT NULL,
  `facebook_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `champion`
--

INSERT INTO `champion` (`name`, `health`, `strength`, `money`, `xp`, `lvl`, `champion_id`, `armour_item`, `user_id`, `avatar_id`, `icon_id`, `diamond`, `facebook_user_id`) VALUES
('Gosho', 100, 10, 900, 900, 1, 22, 0, 0, 1, 1, 15, 62),
('Tosho', 100, 10, 100, 100, 1, 23, 0, 0, 1, 1, 0, 63);

-- --------------------------------------------------------

--
-- Структура на таблица `champion_item`
--

CREATE TABLE `champion_item` (
  `item_id` int(11) NOT NULL,
  `champion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `champion_spell`
--

CREATE TABLE `champion_spell` (
  `champion_id` int(11) NOT NULL,
  `spell_id` int(11) NOT NULL,
  `type` text NOT NULL,
  `power` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `pair_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `champion_spell`
--

INSERT INTO `champion_spell` (`champion_id`, `spell_id`, `type`, `power`, `lvl`, `pair_id`) VALUES
(22, 2, 'Heal', 10, 1, 21),
(22, 1, 'Dmg', 20, 1, 22),
(23, 2, 'Heal', 10, 1, 23),
(23, 1, 'Dmg', 20, 1, 24);

-- --------------------------------------------------------

--
-- Структура на таблица `facebook_users`
--

CREATE TABLE `facebook_users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `facebook_id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `facebook_users`
--

INSERT INTO `facebook_users` (`user_id`, `name`, `facebook_id`) VALUES
(62, 'Ангел Йорда', 2732869433435848);

-- --------------------------------------------------------

--
-- Структура на таблица `icon`
--

CREATE TABLE `icon` (
  `icon_id` int(11) NOT NULL,
  `path` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `icon`
--

INSERT INTO `icon` (`icon_id`, `path`) VALUES
(1, '../Pictures/ChampionIcon1.png'),
(2, '../Pictures/ChampionIcon2.png'),
(3, '../Pictures/ChampionIcon3.png'),
(4, '../Pictures/ChampionIcon4.png'),
(5, '../Pictures/ChampionIcon5.png'),
(6, '../Pictures/ChampionIcon6.png');

-- --------------------------------------------------------

--
-- Структура на таблица `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `price` int(11) NOT NULL,
  `buff` int(11) NOT NULL,
  `item_icon_path` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `round_log`
--

CREATE TABLE `round_log` (
  `round_id` int(11) NOT NULL,
  `battle_id` int(11) NOT NULL,
  `attacker_id` int(11) NOT NULL,
  `defender_id` int(11) NOT NULL,
  `defender_health_left` int(11) NOT NULL,
  `dmg_dealt` int(11) NOT NULL,
  `healing_done` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `round_log`
--

INSERT INTO `round_log` (`round_id`, `battle_id`, `attacker_id`, `defender_id`, `defender_health_left`, `dmg_dealt`, `healing_done`) VALUES
(1, 2, 22, 23, 90, 10, 0),
(2, 1, 23, 22, 90, 10, 0),
(3, 1, 22, 23, 80, 10, 0),
(4, 1, 23, 22, 80, 10, 0),
(5, 1, 22, 23, 70, 10, 0),
(6, 1, 23, 22, 70, 10, 0),
(7, 1, 22, 23, 50, 20, 0),
(8, 1, 23, 22, 60, 10, 0),
(9, 1, 22, 23, 40, 10, 0),
(10, 1, 23, 22, 50, 10, 0),
(11, 1, 22, 23, 30, 10, 0),
(12, 1, 23, 22, 40, 10, 0),
(13, 1, 22, 23, 20, 10, 0),
(14, 1, 23, 22, 30, 10, 0),
(15, 1, 22, 23, 0, 20, 0),
(16, 4, 23, 22, 90, 10, 0),
(17, 4, 22, 23, 90, 10, 0),
(18, 4, 23, 22, 80, 10, 0),
(19, 4, 22, 23, 80, 10, 0),
(20, 4, 23, 22, 70, 10, 0),
(21, 4, 22, 23, 80, 0, 10),
(22, 4, 23, 22, 70, 10, 0),
(23, 4, 22, 23, 70, 10, 0),
(24, 4, 23, 22, 60, 10, 0),
(25, 4, 22, 23, 50, 20, 0),
(26, 4, 23, 22, 50, 10, 0),
(27, 4, 22, 23, 40, 10, 0),
(28, 4, 23, 22, 40, 10, 0),
(29, 4, 22, 23, 40, 0, 10),
(30, 4, 23, 22, 40, 10, 0),
(31, 4, 22, 23, 20, 20, 0),
(32, 4, 23, 22, 30, 10, 0),
(33, 4, 22, 23, 0, 20, 0),
(34, 5, 23, 22, 90, 10, 0),
(35, 5, 22, 23, 100, 0, 10),
(36, 5, 23, 22, 90, 10, 0),
(37, 5, 22, 23, 80, 20, 0),
(38, 6, 22, 23, 70, 10, 0),
(39, 7, 22, 23, 60, 10, 0),
(40, 7, 23, 22, 70, 20, 0),
(41, 7, 22, 23, 50, 10, 0),
(42, 7, 23, 22, 50, 20, 0),
(43, 7, 22, 23, 30, 20, 0),
(44, 7, 23, 22, 30, 20, 0),
(45, 7, 22, 23, 30, 0, 10),
(46, 7, 23, 22, 20, 20, 0),
(47, 7, 22, 23, 20, 10, 0),
(48, 7, 23, 22, 10, 10, 0),
(49, 7, 22, 23, 0, 20, 0),
(50, 8, 22, 23, 90, 10, 0),
(51, 8, 23, 22, 100, 0, 10),
(52, 8, 22, 23, 80, 20, 0),
(53, 8, 23, 22, 90, 10, 0),
(54, 8, 22, 23, 70, 10, 0),
(55, 8, 23, 22, 70, 20, 0),
(56, 8, 22, 23, 60, 10, 0),
(57, 8, 23, 22, 60, 10, 0),
(58, 8, 22, 23, 50, 10, 0),
(59, 8, 23, 22, 50, 10, 0),
(60, 8, 22, 23, 30, 20, 0),
(61, 8, 23, 22, 50, 0, 10),
(62, 8, 22, 23, 20, 20, 0),
(63, 8, 23, 22, 50, 0, 10),
(64, 8, 22, 23, 10, 20, 0),
(65, 8, 23, 22, 40, 10, 0),
(66, 8, 22, 23, -10, 20, 0),
(67, 12, 22, 23, 90, 10, 0),
(68, 12, 23, 22, 100, 0, 10),
(69, 12, 22, 23, 90, 10, 0),
(70, 12, 23, 22, 90, 10, 0),
(71, 12, 22, 23, 90, 0, 10),
(72, 12, 23, 22, 90, 10, 0),
(73, 12, 22, 23, 70, 20, 0),
(74, 12, 23, 22, 70, 20, 0),
(75, 12, 22, 23, 60, 10, 0),
(76, 12, 23, 22, 50, 20, 0),
(77, 12, 22, 23, 40, 20, 0),
(78, 12, 23, 22, 50, 0, 10),
(79, 12, 22, 23, 30, 20, 0),
(80, 12, 23, 22, 30, 20, 0),
(81, 12, 22, 23, 10, 20, 0),
(82, 12, 23, 22, 20, 10, 0),
(83, 12, 22, 23, -10, 20, 0),
(84, 13, 23, 22, 90, 10, 0),
(85, 13, 22, 23, 100, 0, 10),
(86, 13, 23, 22, 90, 10, 0),
(87, 13, 22, 23, 80, 20, 0),
(88, 13, 23, 22, 70, 20, 0),
(89, 13, 22, 23, 80, 0, 10),
(90, 13, 23, 22, 60, 20, 0),
(91, 13, 22, 23, 60, 20, 0),
(92, 13, 23, 22, 40, 20, 0),
(93, 13, 22, 23, 40, 20, 0),
(94, 13, 23, 22, 20, 20, 0),
(95, 13, 22, 23, 40, 0, 10),
(96, 13, 23, 22, 10, 20, 0),
(97, 13, 22, 23, 30, 10, 0),
(98, 13, 23, 22, -10, 20, 0),
(99, 14, 22, 23, 90, 10, 0),
(100, 14, 23, 22, 100, 0, 10),
(101, 14, 22, 23, 80, 20, 0),
(102, 14, 23, 22, 80, 20, 0),
(103, 14, 22, 23, 60, 20, 0),
(104, 14, 23, 22, 70, 10, 0),
(105, 14, 22, 23, 40, 20, 0),
(106, 14, 23, 22, 70, 0, 10),
(107, 14, 22, 23, 30, 20, 0),
(108, 14, 23, 22, 70, 0, 10),
(109, 14, 22, 23, 20, 20, 0),
(110, 14, 23, 22, 60, 10, 0),
(111, 14, 22, 23, 0, 20, 0),
(112, 18, 23, 22, 90, 10, 0),
(113, 18, 22, 23, 90, 10, 0),
(114, 18, 23, 22, 80, 10, 0),
(115, 18, 22, 23, 70, 20, 0),
(116, 18, 23, 22, 60, 20, 0),
(117, 18, 22, 23, 60, 10, 0),
(118, 18, 23, 22, 60, 0, 10),
(119, 18, 22, 23, 60, 10, 0),
(120, 18, 23, 22, 60, 0, 10),
(121, 18, 22, 23, 70, 0, 10),
(122, 18, 23, 22, 70, 0, 10),
(123, 18, 22, 23, 80, 0, 10),
(124, 18, 23, 22, 80, 0, 10),
(125, 18, 22, 23, 70, 20, 0),
(126, 18, 23, 22, 80, 0, 10),
(127, 18, 22, 23, 60, 20, 0),
(128, 18, 23, 22, 80, 0, 10),
(129, 18, 22, 23, 60, 10, 0),
(130, 18, 23, 22, 80, 0, 10),
(131, 18, 22, 23, 60, 10, 0),
(132, 18, 23, 22, 70, 10, 0),
(133, 18, 22, 23, 40, 20, 0),
(134, 18, 23, 22, 60, 10, 0),
(135, 18, 22, 23, 30, 10, 0),
(136, 18, 23, 22, 50, 10, 0),
(137, 18, 22, 23, 10, 20, 0),
(138, 18, 23, 22, 50, 0, 10),
(139, 18, 22, 23, 20, 0, 10),
(140, 18, 23, 22, 60, 0, 10),
(141, 18, 22, 23, 10, 20, 0),
(142, 18, 23, 22, 60, 0, 10),
(143, 18, 22, 23, 10, 10, 0),
(144, 18, 23, 22, 60, 0, 10),
(145, 18, 22, 23, 20, 0, 10),
(146, 18, 23, 22, 70, 0, 10),
(147, 18, 22, 23, 10, 20, 0),
(148, 18, 23, 22, 70, 0, 10),
(149, 18, 22, 23, 10, 10, 0),
(150, 18, 23, 22, 50, 20, 0),
(151, 18, 22, 23, 0, 10, 0),
(152, 19, 22, 23, 90, 10, 0),
(153, 19, 23, 22, 100, 0, 10),
(154, 19, 22, 23, 90, 10, 0),
(155, 19, 23, 22, 80, 20, 0),
(156, 19, 22, 23, 90, 0, 10),
(157, 19, 23, 22, 90, 0, 10),
(158, 19, 22, 23, 80, 20, 0),
(159, 19, 23, 22, 70, 20, 0),
(160, 19, 22, 23, 80, 0, 10),
(161, 19, 23, 22, 70, 10, 0),
(162, 19, 22, 23, 70, 10, 0),
(163, 19, 23, 22, 60, 10, 0),
(164, 19, 22, 23, 70, 0, 10),
(165, 19, 23, 22, 70, 0, 10),
(166, 19, 22, 23, 60, 20, 0),
(167, 19, 23, 22, 70, 0, 10),
(168, 19, 22, 23, 50, 20, 0),
(169, 19, 23, 22, 70, 0, 10),
(170, 19, 22, 23, 40, 20, 0),
(171, 19, 23, 22, 60, 10, 0),
(172, 19, 22, 23, 20, 20, 0),
(173, 19, 23, 22, 50, 10, 0),
(174, 19, 22, 23, 0, 20, 0),
(175, 20, 22, 23, 90, 10, 0),
(176, 20, 23, 22, 100, 0, 10),
(177, 20, 22, 23, 90, 10, 0),
(178, 20, 23, 22, 100, 0, 10),
(179, 20, 22, 23, 80, 20, 0),
(180, 20, 23, 22, 90, 10, 0),
(181, 20, 22, 23, 60, 20, 0),
(182, 20, 23, 22, 70, 20, 0),
(183, 20, 22, 23, 40, 20, 0),
(184, 20, 23, 22, 70, 0, 10),
(185, 20, 22, 23, 30, 20, 0),
(186, 20, 23, 22, 60, 10, 0),
(187, 20, 22, 23, 30, 0, 10),
(188, 20, 23, 22, 60, 10, 0),
(189, 20, 22, 23, 10, 20, 0),
(190, 20, 23, 22, 50, 10, 0),
(191, 20, 22, 23, -10, 20, 0);

-- --------------------------------------------------------

--
-- Структура на таблица `spell`
--

CREATE TABLE `spell` (
  `spell_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `power` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `spell`
--

INSERT INTO `spell` (`spell_id`, `name`, `type`, `power`) VALUES
(1, 'Arcane Comet', 'Dmg', 20),
(2, 'Redemption', 'Heal', 10);

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `name` varchar(999) NOT NULL,
  `email` varchar(999) NOT NULL,
  `username` varchar(999) NOT NULL,
  `password` varchar(999) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`name`, `email`, `username`, `password`, `user_id`) VALUES
('Gosho', 'jordanov.a4o@gmail.com', 'angel', '756bc47cb5215dc3329ca7e1f7be33a2dad68990bb94b76d90aa07f4e44a233a', 11),
('ellie_j', 'vjordanov@totaltelecom.bg', 'ToshoKukata', '756bc47cb5215dc3329ca7e1f7be33a2dad68990bb94b76d90aa07f4e44a233a', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`avatar_id`),
  ADD UNIQUE KEY `avatar_id` (`avatar_id`),
  ADD KEY `avatar_id_2` (`avatar_id`),
  ADD KEY `avatar_id_3` (`avatar_id`);

--
-- Indexes for table `battle_log`
--
ALTER TABLE `battle_log`
  ADD PRIMARY KEY (`battle_id`);

--
-- Indexes for table `champion`
--
ALTER TABLE `champion`
  ADD PRIMARY KEY (`champion_id`);

--
-- Indexes for table `champion_spell`
--
ALTER TABLE `champion_spell`
  ADD PRIMARY KEY (`pair_id`);

--
-- Indexes for table `facebook_users`
--
ALTER TABLE `facebook_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `icon`
--
ALTER TABLE `icon`
  ADD PRIMARY KEY (`icon_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `round_log`
--
ALTER TABLE `round_log`
  ADD PRIMARY KEY (`round_id`);

--
-- Indexes for table `spell`
--
ALTER TABLE `spell`
  ADD PRIMARY KEY (`spell_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avatar`
--
ALTER TABLE `avatar`
  MODIFY `avatar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `battle_log`
--
ALTER TABLE `battle_log`
  MODIFY `battle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `champion`
--
ALTER TABLE `champion`
  MODIFY `champion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `champion_spell`
--
ALTER TABLE `champion_spell`
  MODIFY `pair_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `facebook_users`
--
ALTER TABLE `facebook_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `icon`
--
ALTER TABLE `icon`
  MODIFY `icon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `round_log`
--
ALTER TABLE `round_log`
  MODIFY `round_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `spell`
--
ALTER TABLE `spell`
  MODIFY `spell_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
