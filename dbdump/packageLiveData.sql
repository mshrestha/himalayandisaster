-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 14, 2015 at 11:51 AM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `savenepal`
--

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `pkg_id` varchar(20) NOT NULL,
  `pkg_count` int(10) NOT NULL AUTO_INCREMENT,
  `pkg_status` varchar(100) NOT NULL,
  `pkg_timestamp` datetime NOT NULL,
  `pkg_approval` varchar(50) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `help_call_id` int(11) NOT NULL,
  `w_id` int(10) NOT NULL,
  PRIMARY KEY (`pkg_id`),
  UNIQUE KEY `pkg_id` (`pkg_id`),
  KEY `affected_zone_id` (`help_call_id`),
  KEY `pkg_count` (`pkg_count`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`pkg_id`, `pkg_count`, `pkg_status`, `pkg_timestamp`, `pkg_approval`, `agent_id`, `help_call_id`, `w_id`) VALUES
('pk.8pCR8Qo1zs', 28, '0', '2015-05-08 08:09:44', '0', 379, 27008, 2),
('pk1MPH3Mac/c2', 27, '0', '2015-05-08 08:08:31', '0', 378, 27033, 2),
('pk3apS/GZz5D.', 32, '0', '2015-05-08 08:28:25', '0', 385, 27015, 2),
('pk3sEI7C/EBCY', 34, '0', '2015-05-08 08:33:23', '0', 378, 25036, 2),
('pkbPQdUMM85oU', 35, '0', '2015-05-08 08:34:58', '0', 378, 25020, 2),
('pkCJdgLxt10dY', 23, '0', '2015-05-07 17:07:51', '0', 376, 25009, 2),
('pkCMMt9OarThg', 20, '0', '2015-05-07 16:54:15', '0', 105, 27031, 2),
('pkd77E6B6sBl2', 10, '0', '2015-05-07 15:25:12', '0', 361, 26003, 2),
('pkElebeMQUUjs', 22, '0', '2015-05-07 17:01:35', '0', 375, 25021, 2),
('pkfpYw/q6Nob6', 31, '0', '2015-05-08 08:23:15', '0', 383, 23062, 2),
('pkgYl1VnNhkOE', 19, '0', '2015-05-07 16:45:54', '0', 372, 23044, 2),
('pkjInidG9S5MY', 11, '0', '2015-05-07 15:57:22', '0', 362, 25027, 2),
('pkJje.msqvnx6', 21, '0', '2015-05-07 16:57:44', '0', 374, 24041, 2),
('pkk2DFqGvWDfk', 25, '0', '2015-05-07 17:19:01', '0', 370, 25009, 2),
('pkNOxyJiBkADY', 13, '0', '2015-05-07 16:00:29', '0', 364, 25030, 2),
('pknrW.L6ssKFY', 17, '0', '2015-05-07 16:42:33', '0', 371, 27031, 2),
('pkOd3o7n6VL26', 16, '0', '2015-05-07 16:22:12', '0', 366, 25003, 2),
('pkp/LDjqccXOs', 30, '0', '2015-05-08 08:19:20', '0', 381, 25024, 2),
('pkpaaD6eOe27c', 37, '0', '2015-05-08 14:04:42', '0', 1, 25036, 1),
('pkrP.BAYhGT5Y', 29, '0', '2015-05-08 08:11:37', '0', 337, 24041, 2),
('pksySxfZVgba6', 24, '0', '2015-05-07 17:12:28', '0', 377, 25007, 2),
('pkU.oYoh6RIes', 12, '0', '2015-05-07 15:58:57', '0', 363, 23062, 2),
('pkwQHkF.tA6vI', 9, '0', '2015-05-07 15:22:41', '0', 360, 27031, 2),
('pkxtYOHYDUil2', 33, '0', '2015-05-08 08:31:01', '0', 378, 25016, 2),
('pkYi2THRom6JM', 15, '0', '2015-05-07 16:18:02', '0', 367, 26003, 2),
('pkYWlgfYwEdIA', 8, '0', '2015-05-07 12:28:20', '0', 358, 25036, 2),
('pkZcLZhkY.c6k', 36, '0', '2015-05-08 08:35:58', '0', 386, 24072, 2),
('pkZvaYAZKqjDw', 26, '0', '2015-05-08 07:46:22', '0', 368, 27031, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
