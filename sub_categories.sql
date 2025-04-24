-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 29, 2024 at 02:09 PM
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
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dance_category_id` int NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `dance_category_id` (`dance_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `dance_category_id`, `sub_category_name`, `description`) VALUES
(1, 1, 'Ballet Fundamentals', 'Introduction to basic ballet positions and techniques.'),
(2, 1, 'Ballet Posture Training', 'Focus on proper posture and alignment for beginners.'),
(3, 2, 'Ballet Turns and Jumps', 'Intermediate level turns and jumps in ballet.'),
(4, 3, 'Creative Ballet', 'Children-focused creative movement and ballet.'),
(5, 4, 'Tap Basics', 'Learning basic tap dance rhythms and sounds.'),
(6, 4, 'Tap Performance Skills', 'Techniques for performing advanced tap routines.'),
(7, 5, 'Salsa Partner Work', 'Advanced techniques for partner synchronization.'),
(8, 5, 'Salsa Spins', 'Focus on complex spins and footwork.'),
(9, 6, 'Hip Hop Choreography', 'Creating advanced hip hop choreography.'),
(10, 6, 'Hip Hop Freestyle', 'Mastering freestyle moves and techniques.'),
(11, 7, 'Ballroom Essentials', 'Basic ballroom steps and etiquette.'),
(12, 7, 'Competitive Ballroom', 'Techniques for ballroom competitions.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
