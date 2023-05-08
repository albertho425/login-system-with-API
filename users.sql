-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 08, 2023 at 06:44 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maplesyrupweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `loginusers`
--

CREATE TABLE `loginusers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastlogin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loginusers`
--

INSERT INTO `loginusers` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `date`, `lastlogin`) VALUES
(4, 'Steph', 'Curry', 'stephcurry@gmail.com', 'stephcurry', '$2y$10$lk/xvVNUj74B8mspPGa0R.29rqYg5IqFJq3cJJl/O/0WOZHSENyvm', '2023-05-04 16:06:16', '2023-05-08'),
(5, 'Klay', 'Thompson', 'klay@gmail.com', 'klay', '$2y$10$UlkplhJXW04ZLON8R7ttS.4RoHth0Q/opainVHgAco0VmFfqAVxqq', '2023-05-04 21:09:13', '2023-05-06'),
(6, 'Noel', 'Tan', 'noel@hotmail.com', 'noel', '$2y$10$2tWCojAR5dp5qtZteKX1Nu1X1FMIhfgU1i15CkAvBu6ZHaMTC8COO', '2023-05-05 19:54:14', '2023-05-06'),
(7, 'Pavel', 'Bure', 'pavel@hotmail.com', 'pavel', '$2y$10$xfHSRm67zyPSB6FxP8hYIuc5YFwCCCbG/aXYA2kLnzCeiMGU6Bs.C', '2023-05-06 17:38:40', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loginusers`
--
ALTER TABLE `loginusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loginusers`
--
ALTER TABLE `loginusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
