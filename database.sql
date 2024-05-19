-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: May 19, 2024 at 01:21 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `Answer`
--

CREATE TABLE `Answer` (
  `id` int NOT NULL,
  `question_id` int NOT NULL,
  `isRight` tinyint(1) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Answer`
--

INSERT INTO `Answer` (`id`, `question_id`, `isRight`, `answer`) VALUES
(16, 16, 0, 'Paris'),
(17, 16, 1, 'London'),
(18, 16, 0, 'Berlin'),
(19, 16, 0, 'Bratislava'),
(20, 20, 0, '101'),
(21, 20, 0, '202'),
(22, 20, 1, '206'),
(23, 21, 1, 'France'),
(24, 21, 0, 'Germany'),
(25, 21, 0, 'Belgium');

-- --------------------------------------------------------

--
-- Table structure for table `Archive`
--

CREATE TABLE `Archive` (
  `id` int NOT NULL,
  `question_id` int NOT NULL,
  `closed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Question`
--

CREATE TABLE `Question` (
  `id` int NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int UNSIGNED NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `isActive` tinyint(1) NOT NULL,
  `type` enum('choice','answer') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Question`
--

INSERT INTO `Question` (`id`, `createdAt`, `user_id`, `subject`, `isActive`, `type`, `question`, `code`) VALUES
(16, '2024-05-18 11:53:00', 3, 'Geography', 1, 'choice', 'What is the capital of Great Britain?', 'nuvWb'),
(20, '2024-05-18 12:10:08', 3, 'Biology', 1, 'choice', 'How many bones are in the human body?', 's6FsV'),
(21, '2024-05-18 12:11:26', 4, 'General', 1, 'choice', 'Who gave the U.S. The Statue of Liberty?', '8szl9');

-- --------------------------------------------------------

--
-- Table structure for table `Response`
--

CREATE TABLE `Response` (
  `id` int NOT NULL,
  `question_id` int NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `answer_id` int DEFAULT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Response`
--

INSERT INTO `Response` (`id`, `question_id`, `user_id`, `answer_id`, `text`) VALUES
(11, 16, 3, 16, ''),
(12, 16, 3, 17, ''),
(13, 16, 3, 18, ''),
(14, 16, 3, 19, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `verified` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `resettable` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `roles_mask` int UNSIGNED NOT NULL DEFAULT '0',
  `registered` int UNSIGNED NOT NULL,
  `last_login` int UNSIGNED DEFAULT NULL,
  `force_logout` mediumint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`) VALUES
(2, 'test2@gmail.com', '$2y$10$.08aZdDQuX4Az2jnSNRv5.SHn.RY4q3NxFF6a6HhfejR64fM527W6', 'test', 0, 1, 1, 1, 1715294249, 1715294261, 0),
(3, 'admin@admin.com', '$2y$10$DmpT5ZvrbpL1TqremcQmX.uhCrdiTUSeqiqZe1qj5On3I.KX2pKpq', 'admin', 0, 1, 1, 1, 1715295439, 1716034346, 16),
(4, 'user@gmail.com', '$2y$10$n8A6LM8OOG9lvNBvddAJGO5yD4YIlWGqcHNQFlNDzi4Nnt2UsDBM2', 'user', 0, 1, 1, 0, 1715295696, 1716034240, 3),
(5, 'test@test.com', '$2y$10$3pqsMV578Ar0aQBavDKK8exDMtDxKNH4gY0wVpU95VT.ua6kHtIS6', 'test', 0, 1, 1, 0, 1715295768, NULL, 0),
(6, 'testst@text.com', '$2y$10$5E.I5FM1WDeatZEQwvyaKuspMGaebY4.fIhYkKullhw3KQeHfywlq', 'testst@text.com', 0, 1, 1, 0, 1715876390, NULL, 0),
(7, 'qwe@asd.adom', '$2y$10$gPmpkGN3nTAKSa62lSbno.XD915yxWDxYgjuyIHLM1cC97A2wV6wa', 'qwe@asd.adom', 0, 1, 1, 0, 1715876658, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_remembered`
--

CREATE TABLE `users_remembered` (
  `id` bigint UNSIGNED NOT NULL,
  `user` int UNSIGNED NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_remembered`
--

INSERT INTO `users_remembered` (`id`, `user`, `selector`, `token`, `expires`) VALUES
(16, 3, 'BfG-KMZd1r31rFJrQWNAx5uX', '$2y$10$/wqVNHxUY9jqwM3e0GZPX.Y/REGANA9PhhKEGGmfVfJLRZ/OcS5Oy', 1716120746);

-- --------------------------------------------------------

--
-- Table structure for table `users_throttling`
--

CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float UNSIGNED NOT NULL,
  `replenished_at` int UNSIGNED NOT NULL,
  `expires_at` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_throttling`
--

INSERT INTO `users_throttling` (`bucket`, `tokens`, `replenished_at`, `expires_at`) VALUES
('RZ5QgDxjDQHIzpHoNfdvC8MqW4blMzHr7oFN22ZvkPw', 70.4978, 1716034346, 1716574346),
('0HqL-0AQcCnmuqbcJF25m95LjmNz-4pg2BxPhPbtB98', 3.0062, 1715876658, 1716308658),
('dsvFjOr0D8G5ojcLW5BCrGMtUdLEHgmTA_C87q2o2dw', 18.5978, 1715294256, 1715330256),
('mgCy-8rDNBXh2evmUOZnyQuyeIEL75fq0ddhcvWv10Y', 499, 1715293718, 1715466518),
('UB6hmCM8ctOttAy5tl39Da2JsNDeuMTCaNNRO9FsAAA', 499, 1715294256, 1715467056);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Answer`
--
ALTER TABLE `Answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionId` (`question_id`);

--
-- Indexes for table `Archive`
--
ALTER TABLE `Archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionId` (`question_id`);

--
-- Indexes for table `Question`
--
ALTER TABLE `Question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Response`
--
ALTER TABLE `Response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answerId` (`answer_id`) USING BTREE,
  ADD KEY `questionId` (`question_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_remembered`
--
ALTER TABLE `users_remembered`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `users_throttling`
--
ALTER TABLE `users_throttling`
  ADD PRIMARY KEY (`bucket`),
  ADD KEY `expires_at` (`expires_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Answer`
--
ALTER TABLE `Answer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `Archive`
--
ALTER TABLE `Archive`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Question`
--
ALTER TABLE `Question`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `Response`
--
ALTER TABLE `Response`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_remembered`
--
ALTER TABLE `users_remembered`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Answer`
--
ALTER TABLE `Answer`
  ADD CONSTRAINT `Answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Archive`
--
ALTER TABLE `Archive`
  ADD CONSTRAINT `Archive_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Question`
--
ALTER TABLE `Question`
  ADD CONSTRAINT `Question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Response`
--
ALTER TABLE `Response`
  ADD CONSTRAINT `Response_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Response_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `Answer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Response_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
