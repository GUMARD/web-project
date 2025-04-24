-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 28, 2024 at 01:38 PM
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
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone_no` varchar(15) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `category_id` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_users_category` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`, `Email`, `Phone_no`, `role`, `category_id`) VALUES
(1, 'Nadia Syuhadah', '123', 'nadia@gmail.com', '123456789', 'user', 2),
(2, 'Nadia Syuhadah', '123', 'nadia@gmail.com', '123456789', 'user', 2),
(3, 'Nadia Syuhadah', '222', 'nadia@gmail.com', '456789', 'user', 2),
(4, 'Abu Yamin', 'abc', 'ay@yahoo.com', '1234567', 'user', 4),
(5, 'admin', 'dance123', '', '', 'admin', 0),
(6, 'Melur Aminah', '222', 'melurA@yahoo.com', '987654321', 'user', 1),
(7, 'Muhammad Amir Tan', '456', 'amirtan@gmail.com', '44556677', 'user', 5),
(8, 'Alex Kumar', '987', 'AK@yahoo.com', '95511447', 'user', 5),
(9, 'April Robert', '345', 'april@gmail.com', '11447722', 'user', 3),
(10, 'Benny Woods', '666', 'benny@yahoo.com', '98665544', 'user', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
