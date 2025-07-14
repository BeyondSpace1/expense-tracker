-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 14, 2025 at 11:14 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expense_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `team_id` int DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` text,
  `expense_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `team_id`, `category`, `amount`, `description`, `expense_date`, `created_at`) VALUES
(1, 1, 0, 'Study', 350.00, '', '2025-07-14', '2025-07-14 02:32:47'),
(5, 1, 0, 'Travel', 400.00, '', '2025-07-14', '2025-07-14 03:03:05'),
(6, 1, 0, 'Food', 200.00, 'Pizza', '2025-07-14', '2025-07-14 03:03:18'),
(7, 1, 0, 'Party', 500.00, 'Friends', '2025-07-14', '2025-07-14 03:03:32'),
(8, 2, 1, 'Study', 400.00, '', '2025-07-14', '2025-07-14 03:04:26'),
(9, 2, 1, 'Travel', 500.00, '', '2025-07-14', '2025-07-14 03:37:03'),
(10, 2, 1, 'Food', 200.00, 'Pizza', '2025-07-14', '2025-07-14 03:37:32'),
(11, 2, 1, 'Party', 1000.00, 'Friends', '2025-07-14', '2025-07-14 03:38:15'),
(12, 3, 1, 'Travel', 300.00, 'Home', '2025-07-14', '2025-07-14 03:59:48'),
(13, 3, 1, 'Study', 150.00, '', '2025-07-14', '2025-07-14 04:05:41'),
(14, 4, 2, 'Study', 1000.00, 'School', '2025-07-01', '2025-07-14 04:28:20'),
(15, 4, 2, 'Travel', 500.00, 'Home', '2025-07-02', '2025-07-14 04:28:41'),
(16, 5, 2, 'Food', 300.00, 'Pizza', '2025-07-11', '2025-07-14 04:29:50'),
(17, 5, 2, 'Party', 400.00, 'Friends', '2025-07-13', '2025-07-14 04:30:15');

-- --------------------------------------------------------

--
-- Table structure for table `invite_codes`
--

DROP TABLE IF EXISTS `invite_codes`;
CREATE TABLE IF NOT EXISTS `invite_codes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_id` int DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invite_codes`
--

INSERT INTO `invite_codes` (`id`, `team_id`, `token`, `created_at`) VALUES
(1, 1, 'd69105122ecd689f', '2025-07-14 03:05:19'),
(2, 1, 'c40e2a2f', '2025-07-14 03:58:21'),
(3, 1, '89d7c937', '2025-07-14 03:58:31'),
(4, 2, 'e04e2f50', '2025-07-14 04:28:50');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `t_name` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `t_name`, `name`, `created_by`, `created_at`) VALUES
(1, '', 'xyz', 2, '2025-07-14 03:04:02'),
(2, 'New_1', NULL, 4, '2025-07-14 04:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE IF NOT EXISTS `team_members` (
  `team_id` int NOT NULL,
  `user_id` int NOT NULL,
  `role` enum('owner','member') DEFAULT NULL,
  `joined_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`team_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`team_id`, `user_id`, `role`, `joined_at`) VALUES
(1, 2, 'owner', '2025-07-14 03:04:03'),
(1, 3, 'member', '2025-07-14 03:59:04'),
(2, 4, 'owner', '2025-07-14 04:27:33'),
(2, 5, 'member', '2025-07-14 04:29:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` enum('personal','team') DEFAULT NULL,
  `team_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `team_id`, `created_at`) VALUES
(1, 'abc', 'user@blog.com', '$2y$10$Mme4AIfJCEw5yx6K6u1zBubhU57JGPTIxo6SHa4CfQb.3XJBHIbmK', 'personal', NULL, '2025-07-14 02:31:15'),
(2, 'xyz', 'team@blog.com', '$2y$10$otbFuPMERAgWB9Tpa3UaR.AwMiVUuoOJoUaHzaj5kx56.UMS/XI/G', 'team', 1, '2025-07-14 03:04:02'),
(3, 'jkl', 'user2@blog.com', '$2y$10$v3B3UOZrmB22QNQ1n8DdR.4KTa3wJlxZqQkaEocg1uQvlxkk2qfke', 'team', 1, '2025-07-14 03:59:04'),
(4, 'qwe', 'user3@blog.com', '$2y$10$Q7nsTrltWXcevgGCeZv9Mup7UNuB.Oegm/VHjWLSkHjvGrMjCy1Qu', 'team', 2, '2025-07-14 04:27:33'),
(5, 'rty', 'user4@blog.com', '$2y$10$fSMp2IKhTy/oEd8SMUPz6ejaIO.qrTYmsblbxSeVPC.YPrmbc7bL6', 'team', 2, '2025-07-14 04:29:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
