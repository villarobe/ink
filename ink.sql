-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2026 at 03:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ink`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` enum('Jonaxx','Inksteady') NOT NULL,
  `series_id` int(11) DEFAULT NULL,
  `genre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Ongoing','Completed') NOT NULL DEFAULT 'Ongoing',
  `age_rating` varchar(10) NOT NULL DEFAULT '13+',
  `trigger_warning` text DEFAULT NULL,
  `book_cover` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `series_id`, `genre`, `description`, `status`, `age_rating`, `trigger_warning`, `book_cover`, `created_at`) VALUES
(1, 'Chasing the Sun (College Series #1)', 'Inksteady', 1, 'Drama', 'efsef', 'Completed', '18+', 'Contains theme of violence and mature language', '9f98310250cbbff18f07a9a2f8fa8675.jpg', '2026-04-21 01:00:26'),
(2, 'Taming the Waves', 'Inksteady', 1, 'Drama', 'sfdgrgrgfg', 'Completed', '18+', NULL, 'c01c3525e01d4bb6769d434068719bec.jpg', '2026-04-21 01:01:15'),
(3, 'Loving the Sky (College Series #3)', 'Inksteady', 1, 'Drama', 'asdsdsdfsdfsd', 'Completed', '18+', NULL, '5235a4cd3004ef6bca3c5840b92b244c.jpg', '2026-04-21 01:02:47'),
(4, 'In The Midst of the Crowd (Loser #1)', 'Inksteady', 2, 'Drama', 'dfddgdg', 'Completed', '18+', NULL, 'e49c53b50e2374f593a9b6f947387466.jpg', '2026-04-21 01:03:52'),
(5, 'Mistakes We Can\'t Laugh About (Loser #3)', 'Inksteady', 2, 'Drama', 'dgdgdgfg', 'Completed', '18+', NULL, 'ca9ce1d82c8f1a38889274957d117345.jpg', '2026-04-21 01:05:05'),
(6, 'Words Written in Water (Loser#3)', 'Inksteady', 2, 'Drama', 'fgdggf', 'Completed', '18+', NULL, '6db8e566c43f0372c41ca5b05fee39d9.jfif', '2026-04-21 01:06:06'),
(7, 'Could Have Been but Never Was (Loser #4)', 'Inksteady', 2, 'Drama', 'dfdgfdgf', 'Completed', '18+', NULL, '5e076a8ea10505ac4921175808ee2581.jpg', '2026-04-21 01:07:29'),
(8, 'Dosage Of Serotonin', 'Inksteady', 3, 'Drama', 'sdsf', 'Completed', '18+', NULL, 'a2c59dc4c53802571b861a25fd6e7794.jpg', '2026-04-21 01:08:39'),
(9, 'Whipped', 'Jonaxx', 45, 'Drama', 'ereetert', 'Completed', '18+', 'mature', 'b418183b8ec1ddca12107d4f62e94dd6.jfif', '2026-04-21 01:18:23'),
(10, 'Ripped', 'Jonaxx', 45, 'Drama', 'dfgdfgg', 'Completed', '18+', NULL, '8b727b3ecb51041bb857ec621c4eb349.jfif', '2026-04-21 01:19:14'),
(11, 'Tripped', 'Jonaxx', 45, 'Roamance', 'fgdfgfg', 'Completed', '18+', NULL, '582f00599818c4de346ff2c35cca9e1f.jpg', '2026-04-21 01:20:14'),
(12, 'Baka Sakali 1', 'Jonaxx', 39, 'Romance', 'dsdsds', 'Completed', '18+', NULL, '04531662b622d8905b37706b8f31b668.jpg', '2026-04-21 02:02:07'),
(13, 'Baka Sakali 2', 'Jonaxx', 39, 'Romance', 'fsfdfdf', 'Completed', '16+', NULL, 'cbd1f581e8080ac22d1a19d3534a17a0.jpg', '2026-04-21 02:03:24'),
(14, 'Baka Sakali 3', 'Jonaxx', 39, 'Romance', 'fdgdfggfdgd', 'Completed', '16+', NULL, 'b16c19fa2e49d62c2c504219166e9886.jpg', '2026-04-21 02:04:12'),
(15, 'Mapapansin Kaya?', 'Jonaxx', 39, 'Romance', 'fdfer', 'Completed', '16+', NULL, '2e5e521722713e40beecca1f470720a2.jfif', '2026-04-21 02:05:14'),
(16, 'End This War', 'Jonaxx', 39, 'Romance', 'fgdgfgd', 'Completed', '16+', NULL, '9421bd6f89b6ba4359808820ff011145.jpg', '2026-04-21 02:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `book_series`
--

CREATE TABLE `book_series` (
  `id` int(11) NOT NULL,
  `author` enum('Jonaxx','Inksteady') NOT NULL,
  `series_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_series`
--

INSERT INTO `book_series` (`id`, `author`, `series_name`, `created_at`) VALUES
(1, 'Inksteady', 'College Series', '2026-04-21 00:56:32'),
(2, 'Inksteady', 'Loser\'s Club Series', '2026-04-21 00:56:53'),
(3, 'Inksteady', 'Standalone', '2026-04-21 01:00:26'),
(39, 'Jonaxx', 'Alegria Boys Series', '2026-04-21 01:10:27'),
(42, 'Jonaxx', 'Costa Leona Series', '2026-04-21 01:10:45'),
(45, 'Jonaxx', 'Alegria Girls Series', '2026-04-21 01:11:16'),
(50, 'Jonaxx', 'Standalone', '2026-04-21 01:18:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_books_series_id` (`series_id`);

--
-- Indexes for table `book_series`
--
ALTER TABLE `book_series`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_author_series` (`author`,`series_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `book_series`
--
ALTER TABLE `book_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_series` FOREIGN KEY (`series_id`) REFERENCES `book_series` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
