-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 25, 2026 at 11:11 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_western`
--
CREATE DATABASE IF NOT EXISTS `event_western` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `event_western`;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `location_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `district` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `event_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `image_url`, `location_name`, `district`, `category`, `event_date`, `created_at`) VALUES
(1, 'Aloka Varsha', 'A magnificent orchestral night featuring top local and international talent.', 'images/musical/aloka/aloka.jpg', 'Nelum Pokuna', 'Colombo', 'Musical', '2026-03-28', '2026-03-22 17:53:26'),
(2, 'Flash MoB', 'The Super Eight battles begin. Watch the best local clubs fight for the title.', 'images/sports_tourement/flashmob.jpg', 'Ananda College', 'Colombo', 'Sports', '2026-04-10', '2026-03-22 17:53:26'),
(3, 'Sri Lanka Expo 2026', 'The largest trade and technology exhibition in the Western Province.', 'https://picsum.photos/id/2/400/200', 'BMICH', 'Colombo', 'Meetup', '2026-05-18', '2026-03-22 17:53:26'),
(4, 'Gampaha Food Festival', 'Celebrate traditional arts, food, and dance from the Gampaha district.', 'images/Meetups/Foodg/cover.png', 'Municipal Grounds', 'Gampaha', 'Meetup', '0000-00-00', '2026-03-22 17:53:26'),
(5, 'Hunuwataye Kathawa', 'Traditional Sri Lankan folk epic\r\nHunuwataye Kathawa is a traditional Sri Lankan folk epic based on Bertolt Brecht&#039;s &quot;The Caucasian Chalk Circle.&quot; The story revolves around a prince and a water nymph, exploring themes of love, sacrifice, and the mystical connection between humans and nature. The narrative unfolds with the prince falling in love with the water nymph, who belongs to a realm of magic and mystery.', 'images/drama/hunuwataye/hunuwataye_kathawa.jpg', 'Kalutara Balika Vidyalaya', 'Kalutara', 'Drama', '2026-04-01', '2026-03-22 18:03:53'),
(6, 'Battle Of the Blues', 'The 2nd Battle of Dreams – the annual two-day big match between St. Aloysius’ College, Galle and Holy Cross College, Kalutara – is all set to unfold on the 6th and 7th of March 2026 at the iconic Galle International Cricket Stadium.\r\n\r\nAs the newest addition to Sri Lanka’s cherished big match calendar, the Battle of Dreams is steadily carving its own identity, bridging two prestigious educational institutions from the southern and western coasts of the island. With both teams eager to etch their name on the trophy for the first time in the longer format, the 2026 edition promises two days of competitive schools cricket in the southern fortress.', 'images/big_match/blues/cover.jpg', 'Arons Cricket Club Ground', 'Kalutara', 'Big Match', '2026-04-03', '2026-03-23 07:10:49'),
(8, 'Expediction', 'Meet the Speakers of J&#039;pura Expedition 2.0!\r\nGet ready to be inspired by an incredible lineup of experts who are leading the way in AI, robotics, and innovation.\r\n ⭕ Dr. Ruchira Wijesena – How AI is shaping Modern Lifestyles\r\n⭕ Mr. Pasindu Jayasinghe – How to Prompt Modern AI Models\r\n⭕ Mr Ananda Priyadarshana – Future of Robotics and Automation\r\n⭕ Mr. Malinda Alahakoon &amp; Mr. Dileepa Jayawardena – AI vs Human Thinking\r\n Event Details:\r\n📅 Saturday, Nov 28, 2026\r\n⏰ 9:00 AM onwards', 'images/Meetups/expediction/exp.jpg', 'Wickramarachchi University of Indigenous Medicine', 'Gampaha', 'Meetup', '2026-09-28', '2026-03-24 08:40:03'),
(7, 'Battle Of the Maroons', 'The Battle of the Maroons is a historic cricket encounter between Ananda College and Nalanda College, held annually at the Sinhalese Sports Club Ground in Colombo. This event, which began in 1924, is known for its rich tradition and has become a symbol of the brotherhood between the two schools. The 95th edition of the battle took place from February 28 to March 2, 2025, marking the first-ever three-day match in its history. Nalanda College won the 95th encounter, and the 96th edition is set to make history with the first-ever day-night limited-overs match. The rivalry has produced many cricketing legends, including Sri Lanka&#039;s first Test captain, Bandula Warnapura, and Arjuna Ranatunga, who captained the Sri Lankan Cricket Team in the World Cup victory in 1996.', 'images/big_match/maroons/battle.webp', 'SSC Cricket Ground', 'Colombo', 'Big Match', '2026-02-02', '2026-03-23 07:26:36'),
(9, 'Naadhagama', 'A concert series consisting of some of Sri Lanka&#039;s favorite contemporary artists and music held in a unique ambiance created for all our soulful listeners.\r\nAn experience, A feeling.', 'images/musical/nadaga/naadha.jpg', 'Public Ground', 'Kalutara', 'Musical', '2026-12-31', '2026-03-24 08:46:25'),
(10, 'Sinhabahu', 'Sinhabahu is a play directed by the celebrated dramatist Prof Ediriweera Sarachchandra, based on the legend of King Sinhabahu, the son of a lion and a royal princess—Suppa Devi. The play emphasizes portraying the humane feelings of the characters and delivers a unique experience to the audience with its dance and performances. It has been staged multiple times, retaining its popularity and acquiring new meaning over the years', 'images/Drama/sinhabahu/sinhabahu_4.jpg', 'Elphinstone Historic Theatre', 'Colombo', 'Drama', '2026-01-01', '2026-03-24 08:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

DROP TABLE IF EXISTS `event_registrations`;
CREATE TABLE IF NOT EXISTS `event_registrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `event_title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fullName` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tickets` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'HealitH', 'healithgunaweera@gmail.com', '$2y$10$NlcEFLRqaSaes6JmCJSx4OYputLjEq1kOe8ysUqOQ4K9myIc5ykfu', '2026-03-22 07:06:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
