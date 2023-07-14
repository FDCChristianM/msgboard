-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2023 at 11:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `messageboard_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `to_fk_user_id` int(11) NOT NULL,
  `from_fk_user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_sent` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `to_fk_user_id`, `from_fk_user_id`, `content`, `date_sent`) VALUES
(4, 5, 14, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2023-07-12 02:31:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `birthdate` varchar(250) NOT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '1 = Male, 2 = Female',
  `email` varchar(250) NOT NULL,
  `password` text NOT NULL,
  `photo` varchar(250) NOT NULL,
  `hubby` text NOT NULL,
  `date_created` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `birthdate`, `gender`, `email`, `password`, `photo`, `hubby`, `date_created`, `last_login`) VALUES
(1, 'Christian', '', 0, 'fdc.christianm@gmail.com', '123123', '', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(2, 'Breanna Wyatt', '', 0, 'sasymaqis@mailinator.com', 'Pa$$w0rd!', '', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(3, 'Brody Weber', '', 0, 'nizirebypa@mailinator.com', 'Pa$$w0rd!', '', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(4, 'Brody Weber', '', 0, 'nizirebypa@mailinator.com', 'Pa$$w0rd!123', '', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(5, 'Gray Russell', '', 0, 'fypuno@mailinator.com', 'Pa$$w0rd!', 'Pantheon_0.jpg', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(6, 'Melyssa Newman', '', 0, 'huhomapys@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(7, 'Kai Allen', '', 0, 'gubiwebuw@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(8, 'Uma Crawford', '', 0, 'pyzo@mailinator.com', '5a98cf76de77b626cf462026235b72346e4b4c9d', '', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(9, 'Stone Peck', '', 0, 'zocypu@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(10, 'Kevyn Neal', '', 0, 'bakob@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 01:58:14', '2023-07-07 09:29:09'),
(11, 'Dana Murphy', '', 0, 'hunyx@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 01:58:14', NULL),
(12, 'Adena Mathews', '', 0, 'hosowejyn@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 01:58:14', NULL),
(13, 'Russell Velazquez', '', 0, 'putow@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 01:58:14', NULL),
(14, 'Tanner Bowman', 'July 15, 1988', 2, 'jyqy@mailinator.com', 'e30e63dcb6dc6258b85b7886e52773e2e2e18ef5', '1689062490_1625209709.jpg', 'Dicta et ut providen', '2023-07-11 01:58:14', '2023-07-12 06:28:24'),
(15, 'Kristen Caldwell', '', 0, 'hebesa@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 01:58:14', NULL),
(16, 'Dexter Harrington', '', 0, 'syzinysase@mailinator.com', 'e30e63dcb6dc6258b85b7886e52773e2e2e18ef5', '', '', '2023-07-11 01:59:27', '2023-07-10 19:59:27'),
(17, 'Hall Ortiz', '', 0, 'vewesyh@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 02:04:31', NULL),
(18, 'Grant Booker', '', 0, 'nagis@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 02:05:04', NULL),
(19, 'Colt King', '', 0, 'hybuhuh@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 02:05:42', NULL),
(20, 'Courtney Meyer', '', 0, 'kujajagi@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 02:06:56', NULL),
(21, 'Ava Hooper', '', 0, 'qudyjy@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-11 02:09:31', NULL),
(22, 'Jaime Gould', '', 0, 'vazycared@mailinator.com', 'e30e63dcb6dc6258b85b7886e52773e2e2e18ef5', '', '', '2023-07-10 20:13:26', '2023-07-10 20:13:37'),
(26, 'Nicole Stout', '', 0, 'typyc@mailinator.com', 'a8cdc2b3dd81439ec348bd8966dd9f6b7da6a264', '', '', '2023-07-12 01:11:43', NULL),
(27, 'Hiram Christian', '', 0, 'povinuf@mailinator.com', 'e30e63dcb6dc6258b85b7886e52773e2e2e18ef5', '', '', '2023-07-12 06:22:11', '2023-07-12 06:22:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
