-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2023 at 03:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bulletin_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `message` varchar(210) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `message`, `time`) VALUES
(1, 'character length', '2023-08-01 19:55:24'),
(2, 'huahahahahahhaa', '2023-08-01 20:15:48'),
(3, 'mari coba lagi', '2023-08-01 20:22:50'),
(4, 'dhsdshd hsdbsdbj d', '2023-08-01 20:39:15'),
(5, 'bbbbbbbbbbbjjjjjj', '2023-08-01 20:41:17'),
(6, 'komen ke sekian', '2023-08-01 20:45:10'),
(7, 'ggndkr jkskjsdakrl', '2023-08-01 20:46:14'),
(8, 'ggndkr jkskjsdakrl', '2023-08-01 20:47:11'),
(9, 'bhbchdc cbecdcv', '2023-08-01 20:52:42'),
(10, 'if ($message == &#039;&#039;) {\r\n    return &#039;empty&#039;;\r\n  } elseif ($longchar &lt; 10) {\r\n    return &#039;to short&#039;;\r\n  } elseif ($longchar &gt; 200) {\r\n    return &#039;to long&#039;;\r\n  }\r\n\r\n  r', '2023-08-01 20:54:19'),
(11, '&lt;h1&gt;HALO Cuy&lt;/h1&gt;', '2023-08-01 20:55:18'),
(12, 'vvvvvvvvvvvvvvvvvvvv', '2023-08-03 14:29:16'),
(13, 'ddddddddddddd ddddd', '2023-08-04 01:41:04'),
(14, '😀😀😁😁☺😏', '2023-08-04 01:49:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
-- ALTER TABLE `message`
--   ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
-- ALTER TABLE `message`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;