-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2020 at 03:43 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maher_album`
--

-- --------------------------------------------------------

--
-- Table structure for table `maher_albums`
--

CREATE TABLE `maher_albums` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `maher_images`
--

CREATE TABLE `maher_images` (
  `id` int(11) NOT NULL,
  `image_url` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `album_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `maher_users`
--

CREATE TABLE `maher_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `maher_user_category`
--

CREATE TABLE `maher_user_category` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `maher_user_category`
--

INSERT INTO `maher_user_category` (`id`, `category`, `parent_id`) VALUES
(1, 'student', NULL),
(2, 'employee', NULL),
(3, 'full-time', 2),
(4, 'part-time', 2),
(5, 'high-schooler', 1),
(6, 'undergraduate', 1),
(7, 'software developer', 3),
(8, 'web develper', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `maher_albums`
--
ALTER TABLE `maher_albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `albums_of_user_fk` (`user_id`);

--
-- Indexes for table `maher_images`
--
ALTER TABLE `maher_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `image_url` (`image_url`),
  ADD KEY `images_of_album_fk` (`album_id`);

--
-- Indexes for table `maher_users`
--
ALTER TABLE `maher_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_category` (`user_category`);

--
-- Indexes for table `maher_user_category`
--
ALTER TABLE `maher_user_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `maher_albums`
--
ALTER TABLE `maher_albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `maher_images`
--
ALTER TABLE `maher_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `maher_users`
--
ALTER TABLE `maher_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `maher_user_category`
--
ALTER TABLE `maher_user_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maher_albums`
--
ALTER TABLE `maher_albums`
  ADD CONSTRAINT `albums_of_user_fk` FOREIGN KEY (`user_id`) REFERENCES `maher_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maher_images`
--
ALTER TABLE `maher_images`
  ADD CONSTRAINT `images_of_album_fk` FOREIGN KEY (`album_id`) REFERENCES `maher_albums` (`id`);

--
-- Constraints for table `maher_users`
--
ALTER TABLE `maher_users`
  ADD CONSTRAINT `maher_users_ibfk_1` FOREIGN KEY (`user_category`) REFERENCES `maher_user_category` (`id`);

--
-- Constraints for table `maher_user_category`
--
ALTER TABLE `maher_user_category`
  ADD CONSTRAINT `maher_user_category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `maher_user_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;