-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 09, 2012 at 09:14 AM
-- Server version: 5.1.58
-- PHP Version: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `publications`
--
CREATE DATABASE `publications` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `publications`;

-- --------------------------------------------------------

--
-- Table structure for table `bcabilities`
--

CREATE TABLE IF NOT EXISTS `bcabilities` (
  `staffnumber` int(10) unsigned DEFAULT NULL,
  `operation` varchar(16) DEFAULT NULL,
  `approvaldate` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bcbatchinfo`
--

CREATE TABLE IF NOT EXISTS `bcbatchinfo` (
  `batchno` varchar(16) NOT NULL DEFAULT '',
  `productcode` varchar(16) DEFAULT NULL,
  `productdescription` varchar(32) DEFAULT NULL,
  `qtystart` int(10) unsigned DEFAULT NULL,
  `qtyadd` int(10) unsigned DEFAULT NULL,
  `qtyreq` int(10) unsigned DEFAULT NULL,
  `started` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`batchno`),
  KEY `productcode` (`productcode`),
  KEY `productdescription` (`productdescription`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcbatchinfo`
--

INSERT INTO `bcbatchinfo` (`batchno`, `productcode`, `productdescription`, `qtystart`, `qtyadd`, `qtyreq`, `started`, `completed`, `status`) VALUES
('AA1318', 'OX0240-1000-003', '10MHz SUB MINI', 152, NULL, 152, '2012-03-08 10:58:44', NULL, 1),
('AA1318/1', 'OX0240-1000-003', '10MHz sub min', 0, NULL, 100, NULL, NULL, 0),
('AA1319', 'TX9225-2080-006', '208Mhz Sine TCXO', 140, NULL, 120, '2012-03-07 15:18:10', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bcfriends`
--

CREATE TABLE IF NOT EXISTS `bcfriends` (
  `user` varchar(16) DEFAULT NULL,
  `friend` varchar(16) DEFAULT NULL,
  KEY `user` (`user`(6)),
  KEY `friend` (`friend`(6))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcfriends`
--

INSERT INTO `bcfriends` (`user`, `friend`) VALUES
('Mark', 'Iain'),
('Iain', 'Mark'),
('Steve', 'Mark'),
('lambo', 'Iain'),
('mo', 'Iain'),
('Steve', 'Iain'),
('jamie.harman', 'Iain'),
('Dhan', 'Iain'),
('rfxgordy', 'Iain'),
('jamie.harman', 'rfxgordy'),
('lambo', 'rfxgordy'),
('Mark', 'rfxgordy'),
('mo', 'rfxgordy'),
('Steve', 'rfxgordy'),
('Dhan', 'rfxgordy'),
('Iain', 'rfxgordy');

-- --------------------------------------------------------

--
-- Table structure for table `bckits`
--

CREATE TABLE IF NOT EXISTS `bckits` (
  `batchno` varchar(16) DEFAULT NULL,
  `qty` int(10) unsigned DEFAULT NULL,
  `wor` varchar(16) DEFAULT NULL,
  `date` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bcmembers`
--

CREATE TABLE IF NOT EXISTS `bcmembers` (
  `user` varchar(16) DEFAULT NULL,
  `pass` varchar(16) DEFAULT NULL,
  KEY `user` (`user`(6))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcmembers`
--

INSERT INTO `bcmembers` (`user`, `pass`) VALUES
('Mark', 'P200vespa'),
('Iain', '271180'),
('Steve', 'Crysta!888'),
('lambo', 'PeterB0r0ugh#1'),
('mo', 'Chacicon13'),
('Dhan', 'dana123'),
('jamie.harman', 'H4rm4n123'),
('rfxgordy', 'Z00k33p3r'),
('allan', 'stained windows');

-- --------------------------------------------------------

--
-- Table structure for table `bcmessages`
--

CREATE TABLE IF NOT EXISTS `bcmessages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth` varchar(16) DEFAULT NULL,
  `recip` varchar(16) DEFAULT NULL,
  `pm` char(1) DEFAULT NULL,
  `time` int(10) unsigned DEFAULT NULL,
  `message` varchar(4096) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auth` (`auth`(6)),
  KEY `recip` (`recip`(6))
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `bcmessages`
--

INSERT INTO `bcmessages` (`id`, `auth`, `recip`, `pm`, `time`, `message`) VALUES
(1, 'Mark', 'Iain', '0', 1331135955, 'Hello!! '),
(2, 'Iain', 'lambo', '1', 1331215893, 'hey I''m now following you be afraid very afraid'),
(3, 'Iain', 'jamie.harman', '1', 1331220671, 'batch tickets and sending insulting messages'),
(7, 'rfxgordy', 'Iain', '1', 1331221544, 'fuck you'),
(8, 'rfxgordy', 'jamie.harman', '1', 1331221681, 'TIT!');

-- --------------------------------------------------------

--
-- Table structure for table `bcoperations`
--

CREATE TABLE IF NOT EXISTS `bcoperations` (
  `OpNo` int(3) NOT NULL,
  `operation` varchar(16) DEFAULT NULL,
  `relateddocs` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`OpNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcoperations`
--

INSERT INTO `bcoperations` (`OpNo`, `operation`, `relateddocs`) VALUES
(1, 'Top Kit', 'RFX 403'),
(2, 'Top Paste', 'RFX 303-1'),
(3, 'Top P&P', 'RFX 303-2'),
(4, 'Top Reflow', 'RFX 303-3'),
(5, 'Bottom Paste', 'RFX 303-1'),
(6, 'Bottom P&amp;P', 'RFX 303-2'),
(7, 'Bottom Reflow', 'RFX 303-3'),
(8, 'Inspection', 'RFX 303-5'),
(9, 'Hand Place', 'RFX 303-4'),
(10, 'Separate Boards', 'RFX 309'),
(11, 'Attach Crystal', 'RFX 303-4'),
(12, 'Mount On Bases', 'RFX 303-4'),
(13, 'Inspection', 'RFX 303-5'),
(14, 'Func. test/setup', 'RFX 304'),
(15, 'Drift and Repair', 'RFX 304'),
(16, 'Func. test/setup', 'RFX 304'),
(17, 'Inspection', 'RFX 303-5'),
(18, 'Ageing', 'none'),
(19, 'Phase Noise', 'RFX 304'),
(20, 'Seal', 'RFX 303-6'),
(21, 'Final test', 'RFX 304'),
(22, 'Clean&amp;dress ', 'RFX 309'),
(23, 'Label', 'RFX 309'),
(24, 'Inspection', 'RFX 303-5'),
(25, 'Pack Out', '308');

-- --------------------------------------------------------

--
-- Table structure for table `bcoperationsdone`
--

CREATE TABLE IF NOT EXISTS `bcoperationsdone` (
  `batchno` varchar(16) DEFAULT NULL,
  `operation` varchar(16) DEFAULT NULL,
  `staffnumber` int(10) unsigned DEFAULT NULL,
  `starttime` int(10) unsigned DEFAULT NULL,
  `endtime` int(10) unsigned DEFAULT NULL,
  `quantitycomplete` int(10) unsigned DEFAULT NULL,
  `scrap` int(10) unsigned DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `moved_to_stock` smallint(5) unsigned DEFAULT NULL,
  `moved_from_stock` smallint(5) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcoperationsdone`
--

INSERT INTO `bcoperationsdone` (`batchno`, `operation`, `staffnumber`, `starttime`, `endtime`, `quantitycomplete`, `scrap`, `start`, `end`, `moved_to_stock`, `moved_from_stock`) VALUES
('AA1319', '1', 27, NULL, NULL, 140, 0, '2012-03-07 15:18:10', '2012-03-07 15:18:46', NULL, NULL),
('AA1319', '2', 27, NULL, NULL, 140, 0, '2012-03-07 15:20:26', '2012-03-07 15:20:37', NULL, NULL),
('AA1319', '3', 27, NULL, NULL, 140, 0, '2012-03-07 15:20:56', '2012-03-07 15:21:22', NULL, NULL),
('aa1319', '4', 27, NULL, NULL, 140, 0, '2012-03-08 09:51:26', '2012-03-08 14:13:07', NULL, NULL),
('AA1318', '1', 27, NULL, NULL, 152, 0, '2012-03-08 10:58:44', '2012-03-08 10:59:16', NULL, NULL),
('AA1318', '2', 27, NULL, NULL, 152, 0, '2012-03-08 10:59:33', '2012-03-08 10:59:55', NULL, NULL),
('AA1318', '3', 27, NULL, NULL, 152, 0, '2012-03-08 11:00:11', '2012-03-08 11:01:02', NULL, NULL),
('AA1318', '4', 27, NULL, NULL, 152, 0, '2012-03-08 11:01:19', '2012-03-08 11:02:53', NULL, NULL),
('AA1318', '5', 27, NULL, NULL, 128, 0, '2012-03-08 11:03:13', '2012-03-08 11:03:37', NULL, NULL),
('AA1318', '6', 27, NULL, NULL, 128, 0, '2012-03-08 11:03:56', '2012-03-08 11:04:26', NULL, NULL),
('AA1318', '7', 27, NULL, NULL, 128, 0, '2012-03-08 11:04:38', '2012-03-08 11:05:32', NULL, NULL),
('AA1318', '8', 27, NULL, NULL, 128, 0, '2012-03-08 11:06:19', '2012-03-08 11:06:49', NULL, NULL),
('AA1319', '5', 27, NULL, NULL, 140, 0, '2012-03-08 14:15:09', '2012-03-08 14:15:32', NULL, NULL),
('AA1319', '6', 27, NULL, NULL, 140, 0, '2012-03-08 14:15:49', '2012-03-08 14:16:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bcorders`
--

CREATE TABLE IF NOT EXISTS `bcorders` (
  `productcode` varchar(16) DEFAULT NULL,
  `productdescription` varchar(16) DEFAULT NULL,
  `qtyreq` int(10) unsigned DEFAULT NULL,
  `shipdate` int(10) unsigned DEFAULT NULL,
  `notes` varchar(4096) DEFAULT NULL,
  `sor` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`sor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bcpeople`
--

CREATE TABLE IF NOT EXISTS `bcpeople` (
  `firstname` varchar(16) DEFAULT NULL,
  `lastname` varchar(16) DEFAULT NULL,
  `username` varchar(16) DEFAULT NULL,
  `staffno` int(10) unsigned DEFAULT NULL,
  `password` varchar(16) DEFAULT NULL,
  KEY `username` (`username`),
  KEY `staffno` (`staffno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcpeople`
--

INSERT INTO `bcpeople` (`firstname`, `lastname`, `username`, `staffno`, `password`) VALUES
('Mark', 'Cunningham', 'Mark', 30, 'P200vespa'),
('Iain', 'Gold', 'Iain', 27, '271180'),
('Steven', 'Wilson', 'Steve', 1, 'Crysta!888'),
('Stewart', 'Lambie', 'lambo', 28, 'PeterB0r0ugh#1'),
('moira', 'ewart', 'mo', 14, 'Chacicon13'),
('Dante', 'Cruz', 'Dhan', 26, 'dana123'),
('Jamie', 'Harman', 'jamie.harman', 19, 'H4rm4n123'),
('Gordon', 'Robertson', 'rfxgordy', 15, 'Z00k33p3r'),
('Allan', 'Wilson', 'allan', 32, 'stained windows');

-- --------------------------------------------------------

--
-- Table structure for table `bcprofiles`
--

CREATE TABLE IF NOT EXISTS `bcprofiles` (
  `user` varchar(16) DEFAULT NULL,
  `text` varchar(4096) DEFAULT NULL,
  KEY `user` (`user`(6))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcprofiles`
--

INSERT INTO `bcprofiles` (`user`, `text`) VALUES
('Mark', 'Design Engineer/Quality Manager'),
('lambo', ''),
('Iain', '');

-- --------------------------------------------------------

--
-- Table structure for table `bcshipped`
--

CREATE TABLE IF NOT EXISTS `bcshipped` (
  `batchno` varchar(16) DEFAULT NULL,
  `qty` int(10) unsigned DEFAULT NULL,
  `sor` varchar(16) DEFAULT NULL,
  `date` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bcstock`
--

CREATE TABLE IF NOT EXISTS `bcstock` (
  `quantity` smallint(6) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `operation_number` smallint(6) DEFAULT NULL,
  `date_in` datetime DEFAULT NULL,
  `date_out` datetime NOT NULL,
  `batchno` varchar(12) DEFAULT NULL,
  `product_code` varchar(20) DEFAULT NULL,
  `Stock_ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Stock_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `bcstock`
--

INSERT INTO `bcstock` (`quantity`, `description`, `location`, `operation_number`, `date_in`, `date_out`, `batchno`, `product_code`, `Stock_ID`) VALUES
(0, '', 'test', 9, '2012-03-08 17:55:54', '2012-03-08 18:12:53', 'AA1318', 'OX0240-1000-003', 16);

-- --------------------------------------------------------

--
-- Table structure for table `bcstocklog`
--

CREATE TABLE IF NOT EXISTS `bcstocklog` (
  `quantity` int(11) NOT NULL,
  `product_code` varchar(20) NOT NULL,
  `operation_number` int(11) NOT NULL,
  `user` varchar(40) NOT NULL,
  `location` varchar(50) NOT NULL,
  `date/time` datetime NOT NULL,
  `Direction` varchar(6) NOT NULL,
  `batchno` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcstocklog`
--

INSERT INTO `bcstocklog` (`quantity`, `product_code`, `operation_number`, `user`, `location`, `date/time`, `Direction`, `batchno`) VALUES
(50, 'OX0240-1000-003', 9, 'allan', 'test', '2012-03-08 17:55:54', 'In', 'AA1318'),
(50, 'OX0240-1000-003', 9, 'allan', 'test', '2012-03-08 18:12:53', 'Out', 'AA1318');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
