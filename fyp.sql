-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2015 at 11:36 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fyp`
--
CREATE DATABASE IF NOT EXISTS `fyp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `fyp`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `station_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
`id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
`id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL COMMENT 'Just a name',
  `data_path` varchar(32) NOT NULL COMMENT 'Supposed to contain IP addresses'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COMMENT='To have a set of stations in particular location';

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `data_path`) VALUES
(1, 'Kuala Lumpur', ''),
(2, 'Penang', ''),
(3, 'Malacca', ''),
(4, 'Negeri Sembilan', ''),
(5, 'Putrajaya', ''),
(6, 'Selangor', ''),
(7, 'Sarawak', ''),
(8, 'Sabah', ''),
(9, 'Johor', ''),
(10, 'Perak', ''),
(11, 'Pahang', ''),
(12, 'Perlis', ''),
(13, 'Labuan', ''),
(14, 'Kedah', ''),
(15, 'Terengganu', ''),
(16, 'Kelantan', '');

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE IF NOT EXISTS `stations` (
`id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mac` varchar(16) NOT NULL,
  `location_id` int(11) NOT NULL,
  `latlong` varchar(36) NOT NULL,
  `temperature` tinyint(1) DEFAULT '1',
  `humidity` tinyint(1) DEFAULT '1',
  `soilMoist` tinyint(1) DEFAULT '1',
  `phMeter` tinyint(1) DEFAULT '1',
  `wetLeaf` tinyint(1) DEFAULT '1',
  `windSpeed` tinyint(1) DEFAULT '1',
  `windDir` tinyint(1) DEFAULT '1',
  `rainMeter` tinyint(1) DEFAULT '1',
  `solarRad` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`id`, `created_on`, `mac`, `location_id`, `latlong`, `temperature`, `humidity`, `soilMoist`, `phMeter`, `wetLeaf`, `windSpeed`, `windDir`, `rainMeter`, `solarRad`) VALUES
(1, '2015-06-08 19:37:22', '00124B0002D72000', 1, '3.0692513,101.6944768', 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, '2015-06-13 09:21:49', '00R30X420B1017C0', 1, '3.0027857,101.7079188', 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, '2015-06-13 09:24:31', '0F310U6Z01H644N5', 2, '3.1026,101.64475', 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `station_data`
--

CREATE TABLE IF NOT EXISTS `station_data` (
`id` int(11) NOT NULL,
  `station_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `temperature` float(4,2) NOT NULL,
  `humidity` tinyint(2) unsigned NOT NULL,
  `soilMoist` float(3,2) unsigned NOT NULL,
  `phMeter` float(3,2) NOT NULL,
  `wetLeaf` tinyint(2) unsigned NOT NULL,
  `windSpeed` smallint(3) unsigned NOT NULL,
  `windDir` varchar(2) NOT NULL,
  `rainMeter` tinyint(2) unsigned NOT NULL,
  `solarRad` smallint(4) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `station_data`
--

INSERT INTO `station_data` (`id`, `station_id`, `datetime`, `temperature`, `humidity`, `soilMoist`, `phMeter`, `wetLeaf`, `windSpeed`, `windDir`, `rainMeter`, `solarRad`) VALUES
(1, 1, '2015-06-02 15:15:28', 25.00, 94, 1.10, 0.90, 0, 2, 'N', 3, 540),
(2, 1, '2015-06-07 17:57:14', 27.00, 94, 1.10, 0.90, 0, 2, 'SW', 3, 540),
(3, 1, '2015-06-06 00:49:31', 27.00, 94, 1.10, 0.90, 0, 2, 'NE', 3, 540),
(4, 1, '2015-06-07 01:39:37', 27.00, 94, 1.10, 0.90, 0, 2, 'S', 3, 540),
(5, 1, '2015-06-08 06:39:45', 27.00, 94, 1.10, 0.90, 0, 2, 'SE', 3, 540);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `subscription` tinyint(1) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created_on`, `name`, `email`, `password`, `subscription`, `admin`) VALUES
(1, '2015-06-08 19:24:13', 'Sonny Darvishzadeh', 'darvishzadeh@gmail.com', '485ba83bbb79af1947e32364dd77c170', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `station_id` (`station_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `mac` (`mac`,`latlong`(25)), ADD KEY `id` (`id`), ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `station_data`
--
ALTER TABLE `station_data`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`), ADD KEY `station_id` (`station_id`), ADD KEY `station_id_2` (`station_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD KEY `id` (`id`), ADD KEY `id_2` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `station_data`
--
ALTER TABLE `station_data`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `stations`
--
ALTER TABLE `stations`
ADD CONSTRAINT `stations_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `station_data`
--
ALTER TABLE `station_data`
ADD CONSTRAINT `station_data_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
