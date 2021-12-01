-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2021 at 12:47 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adise21_matrexa`
--

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `x` tinyint(1) NOT NULL,
  `y` tinyint(1) NOT NULL,
  `piece_color` enum('W','B') DEFAULT NULL,
  `piece_height` enum('S','T') DEFAULT NULL,
  `piece_consistency` enum('H','SO') DEFAULT NULL,
  `piece_shape` enum('SQ','R') DEFAULT NULL,
  `id` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`x`, `y`, `piece_color`, `piece_height`, `piece_consistency`, `piece_shape`, `id`) VALUES
(1, 1, NULL, NULL, NULL, NULL, 0),
(1, 2, NULL, NULL, NULL, NULL, 0),
(1, 3, NULL, NULL, NULL, NULL, 0),
(1, 4, NULL, NULL, NULL, NULL, 0),
(2, 1, NULL, NULL, NULL, NULL, 0),
(2, 2, NULL, NULL, NULL, NULL, 0),
(2, 3, NULL, NULL, NULL, NULL, 0),
(2, 4, NULL, NULL, NULL, NULL, 0),
(3, 1, NULL, NULL, NULL, NULL, 0),
(3, 2, NULL, NULL, NULL, NULL, 0),
(3, 3, NULL, NULL, NULL, NULL, 0),
(3, 4, NULL, NULL, NULL, NULL, 0),
(4, 1, NULL, NULL, NULL, NULL, 0),
(4, 2, NULL, NULL, NULL, NULL, 0),
(4, 3, NULL, NULL, NULL, NULL, 0),
(4, 4, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `board_empty`
--

CREATE TABLE `board_empty` (
  `x` tinyint(1) NOT NULL,
  `y` tinyint(1) NOT NULL,
  `piece_color` enum('W','B') DEFAULT NULL,
  `piece_height` enum('S','T') DEFAULT NULL,
  `piece_consistency` enum('H','SO') DEFAULT NULL,
  `piece_shape` enum('SQ','R') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `board_empty`
--

INSERT INTO `board_empty` (`x`, `y`, `piece_color`, `piece_height`, `piece_consistency`, `piece_shape`) VALUES
(1, 1, NULL, NULL, NULL, NULL),
(1, 2, NULL, NULL, NULL, NULL),
(1, 3, NULL, NULL, NULL, NULL),
(1, 4, NULL, NULL, NULL, NULL),
(2, 1, NULL, NULL, NULL, NULL),
(2, 2, NULL, NULL, NULL, NULL),
(2, 3, NULL, NULL, NULL, NULL),
(2, 4, NULL, NULL, NULL, NULL),
(3, 1, NULL, NULL, NULL, NULL),
(3, 2, NULL, NULL, NULL, NULL),
(3, 3, NULL, NULL, NULL, NULL),
(3, 4, NULL, NULL, NULL, NULL),
(4, 1, NULL, NULL, NULL, NULL),
(4, 2, NULL, NULL, NULL, NULL),
(4, 3, NULL, NULL, NULL, NULL),
(4, 4, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `game_status`
--

CREATE TABLE `game_status` (
  `status` enum('not active','initialized','started','ended','aborded') NOT NULL DEFAULT 'not active',
  `p_turn` enum('P1','P2') DEFAULT NULL,
  `result` enum('P1','P2','D') DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `game_status`
--
DELIMITER $$
CREATE TRIGGER `game_status_update` BEFORE UPDATE ON `game_status` FOR EACH ROW BEGIN
	SET NEW.last_change=NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pieces`
--

CREATE TABLE `pieces` (
  `color` varchar(255) COLLATE utf8_bin NOT NULL,
  `height` varchar(255) COLLATE utf8_bin NOT NULL,
  `consistency` varchar(255) COLLATE utf8_bin NOT NULL,
  `Shape` varchar(255) COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pieces`
--

INSERT INTO `pieces` (`color`, `height`, `consistency`, `Shape`, `id`) VALUES
('black', 'tall', 'hollow', 'square', 0),
('black', 'tall', 'hollow', 'round', 1),
('black', 'tall', 'solid', 'square', 2),
('black', 'tall', 'solid', 'round', 3),
('black', 'short', 'hollow', 'square', 4),
('black', 'short', 'hollow', 'round', 5),
('black', 'short', 'solid', 'square', 6),
('black', 'short', 'solid', 'round', 7),
('white', 'tall', 'hollow', 'square', 8),
('white', 'tall', 'hollow', 'round', 9),
('white', 'tall', 'solid', 'square', 10),
('white', 'tall', 'solid', 'round', 11),
('white', 'short', 'hollow', 'square', 12),
('white', 'short', 'hollow', 'round', 13),
('white', 'short', 'solid', 'square', 14),
('white', 'short', 'solid', 'round', 15);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `username` varchar(20) DEFAULT NULL,
  `player_id` enum('p1','p2') NOT NULL,
  `token` varchar(32) DEFAULT NULL,
  `last_action` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board_empty`
--
ALTER TABLE `board_empty`
  ADD PRIMARY KEY (`x`,`y`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`player_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
