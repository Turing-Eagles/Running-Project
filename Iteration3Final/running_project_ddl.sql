-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2015 at 03:54 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `running_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `organizer_account`
--

CREATE TABLE IF NOT EXISTS `organizer_account` (
  `password` varchar(40) DEFAULT NULL,
  `username` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organizer_account`
--

INSERT INTO `organizer_account` (`password`, `username`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `organizer_participation`
--

CREATE TABLE IF NOT EXISTS `organizer_participation` (
  `organizer_name` varchar(15) DEFAULT NULL,
  `race_name` int(3) DEFAULT NULL,
  KEY `race_name` (`race_name`),
  KEY `organizer_name` (`organizer_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organizer_participation`
--

INSERT INTO `organizer_participation` (`organizer_name`, `race_name`) VALUES
('admin', 13),
('admin', 14),
('admin', 15),
('admin', 16),
('admin', 17);

-- --------------------------------------------------------

--
-- Table structure for table `racer_account`
--

CREATE TABLE IF NOT EXISTS `racer_account` (
  `password` varchar(40) DEFAULT NULL,
  `username` varchar(15) NOT NULL DEFAULT '',
  `sex` varchar(1) DEFAULT NULL,
  `last_name` varchar(15) DEFAULT NULL,
  `first_name` varchar(15) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `racer_account`
--

INSERT INTO `racer_account` (`password`, `username`, `sex`, `last_name`, `first_name`, `birthdate`) VALUES
('password', 'user', 'M', 'last', 'first', '1900-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `racer_participation`
--

CREATE TABLE IF NOT EXISTS `racer_participation` (
  `racer_name` varchar(15) DEFAULT NULL,
  `race_name` int(3) DEFAULT NULL,
  `finishing_time` time DEFAULT NULL,
  `finishing_place` int(4) DEFAULT NULL,
  UNIQUE KEY `racer_race` (`racer_name`,`race_name`),
  KEY `race_name` (`race_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `racer_participation`
--

INSERT INTO `racer_participation` (`racer_name`, `race_name`, `finishing_time`, `finishing_place`) VALUES
('user', 17, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `races`
--

CREATE TABLE IF NOT EXISTS `races` (
  `race_id` int(3) NOT NULL AUTO_INCREMENT,
  `category` varchar(15) DEFAULT NULL,
  `name` varchar(15) DEFAULT NULL,
  `race_date` datetime DEFAULT NULL,
  `address` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `state` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`race_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`race_id`, `category`, `name`, `race_date`, `address`, `city`, `state`) VALUES
(13, '5k', 'test', '1900-01-01 00:00:00', 'test', 'test', 'test'),
(14, '5k', 'test2', NULL, 'test', 'test', 'test'),
(15, '5k', 'name', NULL, 'address', 'city', 'state'),
(16, '5k', 'name', '1994-04-22 12:00:00', 'address', 'city', 'state'),
(17, '8k', 'nameupdate', '1902-03-03 03:03:00', 'addressupdate', 'cityupdate', 'stateupdate');

-- --------------------------------------------------------

--
-- Table structure for table `race_categories`
--

CREATE TABLE IF NOT EXISTS `race_categories` (
  `category` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `race_categories`
--

INSERT INTO `race_categories` (`category`) VALUES
('5k'),
('10k'),
('8k');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `organizer_participation`
--
ALTER TABLE `organizer_participation`
  ADD CONSTRAINT `organizer_participation_ibfk_1` FOREIGN KEY (`race_name`) REFERENCES `races` (`race_id`),
  ADD CONSTRAINT `organizer_participation_ibfk_2` FOREIGN KEY (`organizer_name`) REFERENCES `organizer_account` (`username`);

--
-- Constraints for table `racer_participation`
--
ALTER TABLE `racer_participation`
  ADD CONSTRAINT `racer_participation_ibfk_1` FOREIGN KEY (`race_name`) REFERENCES `races` (`race_id`),
  ADD CONSTRAINT `racer_participation_ibfk_2` FOREIGN KEY (`racer_name`) REFERENCES `racer_account` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
