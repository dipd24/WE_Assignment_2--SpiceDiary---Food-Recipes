-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2026 at 03:57 PM
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
-- Database: `foodblog_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`) VALUES
(1, 'Breakfast', '2026-02-18 15:16:03'),
(2, 'Lunch', '2026-02-18 15:16:03'),
(3, 'Dinner', '2026-02-18 15:16:03'),
(5, 'Snacks', '2026-02-18 15:59:25'),
(6, 'Bekary', '2026-02-18 19:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` enum('approved','pending') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `name`, `email`, `message`, `status`, `created_at`) VALUES
(1, 4, 'kim jon un', 'kim23@gmail.com', 'very good recepie', 'approved', '2026-02-18 19:45:05'),
(2, 4, 'kim jon un', 'kim23@gmail.com', 'very good recepie', 'approved', '2026-02-18 19:45:28'),
(3, 7, 'fahhh', 'fahh@hot.com', 'very good', 'approved', '2026-02-18 20:29:53'),
(4, 8, 'oiuyuio', 'ouyu@jlji.com', 'iuytsdhgfhiukhhhhhhhrydry', 'approved', '2026-02-19 05:28:19'),
(5, 9, 'iuoiuyl', 'kljfk@juyiu.com', 'louihyuidrtiouiolk.jkhgfdsdfghjkl;', 'approved', '2026-02-19 07:08:51'),
(6, 9, 'iuoiuyl', 'kljfk@juyiu.com', 'louihyuidrtiouiolk.jkhgfdsdfghjkl;', 'approved', '2026-02-19 07:09:14'),
(7, 10, 'mr x', 'mrrrx@gmail.com', 'waiting for recipe', 'approved', '2026-02-19 14:54:34'),
(8, 10, 'mr x', 'mrrrx@gmail.com', 'waiting for recipe', 'approved', '2026-02-19 14:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`, `reply`, `replied_at`) VALUES
(1, 'dip', 'adnan@jfkhg.com', 'khhgiiffkkjjjjjjjjjjjjjjjjjjjjjhdddddddddddddduyyyyyyyyyyyy', '2026-02-19 10:44:49', 'hiiiiiiiiiiiiiiiiiiiii', '2026-02-19 11:14:25'),
(2, 'dip dey', 'deydip146@gmail.com', 'pead more to learn', '2026-02-19 11:23:46', 'ok bro', '2026-02-19 11:25:25'),
(3, 'Dip Dey', 'deydip146@gmail.com', 'good', '2026-02-19 15:13:10', 'tnx', '2026-02-19 15:13:45'),
(4, 'Dip Dey', 'deydip146@gmail.com', 'helloooo', '2026-02-19 16:16:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cooking_time` varchar(50) DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT 'Easy',
  `status` enum('published','draft') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `title`, `description`, `image`, `cooking_time`, `difficulty`, `status`, `created_at`) VALUES
(3, 9, 1, 'boiled egg', 'very healthy and easy', 'boiled_egg.jpg', '15 mins', 'Easy', 'published', '2026-02-18 16:52:48'),
(4, 9, 2, 'egg curry', 'perfect curry for lunch', 'egg_curry.webp', '45 mins', 'Medium', 'published', '2026-02-18 17:13:02'),
(5, 9, 3, 'Fried rice', 'Little bit oily but tasty', 'fried-rice.jpg', '30 mins', 'Easy', 'published', '2026-02-18 20:04:30'),
(6, 9, 1, 'noodles', 'very tasty to eat', 'noodles.jfif', '30 mins', 'Medium', 'published', '2026-02-18 20:05:26'),
(7, 9, 5, 'potato fry', 'very light food', 'potato_fry.jfif', '30 mins', 'Medium', 'published', '2026-02-18 20:27:17'),
(8, 9, 3, 'chicken curry', 'very well to eat with rice and parata', 'chicken_curry.jfif', '1 hour', 'Hard', 'published', '2026-02-18 20:28:53'),
(9, 9, 6, 'pan cake', 'tasty to eat and less hassle to prepare', 'pancake.jfif', '1 hour', 'Medium', 'published', '2026-02-19 05:32:03'),
(10, 9, 2, 'Fish Curry', 'u can make it for lunch, we will publish the process later.', 'fish_curry.jfif', '45 mins', 'Hard', 'published', '2026-02-19 14:53:28'),
(11, 9, 3, 'Rooti', 'very healthy and safe', 'Rooti.jfif', '30 mins', 'Hard', 'published', '2026-02-19 16:29:40'),
(12, 9, 5, 'Papad', 'easy to prerare fun to eat', 'papad.jfif', '15 mins', 'Easy', 'published', '2026-02-19 16:31:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(9, 'Admin', 'admin@gmail.com', '$2y$10$d./a.mpWGhgpr6quLAOm2.hqkD.dPpOd5FoprFqNxDEdeu7lq8Ycu', '2026-02-18 15:42:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
