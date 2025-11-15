-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 08, 2013 at 05:28 AM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `publications`
--
DROP DATABASE `publications`;
CREATE DATABASE `publications` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `publications`;

-- --------------------------------------------------------

--
-- Table structure for table `bcabilities`
--

DROP TABLE IF EXISTS `bcabilities`;
CREATE TABLE IF NOT EXISTS `bcabilities` (
  `staffnumber` int(10) unsigned DEFAULT NULL,
  `operation` varchar(16) DEFAULT NULL,
  `approvaldate` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bcbatchinfo`
--

DROP TABLE IF EXISTS `bcbatchinfo`;
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
  `build_type` varchar(255) NOT NULL DEFAULT 'Full',
  `Link` text,
  PRIMARY KEY (`batchno`),
  KEY `productcode` (`productcode`),
  KEY `productdescription` (`productdescription`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcbatchinfo`
--

INSERT INTO `bcbatchinfo` (`batchno`, `productcode`, `productdescription`, `qtystart`, `qtyadd`, `qtyreq`, `started`, `completed`, `status`, `build_type`, `Link`) VALUES
('383-5112', 'XT3971-161.6667M', '161.6667MHz, HC49, AT ', 0, NULL, 78, NULL, NULL, 0, '1285-4-161.6667-cement', '/share/1285-4-161.6667-SO1470.pdf'),
('A176', 'XT3988-5.0M', '5.0MHz, TO8, AT, Pin#2-4(', 60, NULL, 25, '2012-12-13 08:25:21', NULL, 1, '1375-3-4.9152', '/share/1375-3-4.9152-SO1455-2.pdf'),
('A239', '010798-0505-1', '10.00MHz, HC37LP, AT3, 01', 30, NULL, 10, '2012-12-13 11:11:18', NULL, 1, '2081-4-10', '/share/2081-4-10-SO1465.pdf'),
('B101', 'XT4015-3.2663M', '3.2663MHz, HC37. AT', 60, NULL, 25, '2012-12-13 08:24:39', NULL, 1, '1383-3-3.266', '/share/1383-3-3.266_SO1455%20pin2-4.pdf'),
('B117', 'XT3875-20.0M', '20.00000MHz, HC45, AT, Fu', 190, NULL, 100, '2012-12-13 09:15:34', NULL, 1, '5404-2-20', '/share/5404-2-20-SO1460'),
('B36-5112', 'XT3971-161.6667M', '161.6667MHz, HC49, AT ', 250, NULL, 200, '2013-01-02 07:16:18', NULL, 1, '1285-4-161.6667', '/share/1285-4-161.6667-SO1470.pdf'),
('B66', 'XT4135-150.0M', '150.0MHz, HC43, IT7, +2.0', 60, NULL, 30, '2013-01-02 09:13:34', NULL, 1, '5616-1-150', '/share/5616-1-150-SO1477.pdf'),
('BN0001', 'XT4129-100.0M', '100.0MHz, HC35LP, SC5', 110, NULL, 100, '2012-11-16 07:50:59', '2012-12-11 09:38:49', 2, 'STANDARD', '/share/5611-1-100.pdf'),
('BN1441', 'XT4058-57.344M', '100MHz, HC35LP, SC5', 200, NULL, 100, '2012-12-07 11:09:48', '2012-12-11 07:53:42', 2, 'Full Build', '/share/5541-1-57.344.pdf'),
('BN1443_1', 'NXT-901-4.400620', '4.400620MHz, HC49, AT1,10', 400, NULL, 200, NULL, '2012-12-11 07:52:07', 2, 'Full Build', '/share/5435-3-4.400620.pdf'),
('BN1443_2', 'NXT-902-4.397050', '4.397050MHz, HC49 ,AT1,10', 400, NULL, 200, NULL, '2012-12-11 07:52:19', 2, 'Full Build', '/share/5436-1-4.397050.pdf'),
('BN1443_3', 'NXT-903-4.399980', '4.399980MHz, HC49, AT1, 1', 200, NULL, 100, NULL, '2012-12-11 07:52:38', 2, 'Full Build', '/share/5437-3-4.399980.pdf'),
('BN1443_4', 'NXT-904-4.397700', '4.397700MHz, HC49, AT1', 200, NULL, 100, NULL, '2012-12-11 07:53:06', 2, 'Full Build', '/share/5438-3-4.3977.pdf'),
('BN1449_1', 'XT4132-23.995M', '23.9954MHz, HC35, AT1', 10, NULL, 3, '2012-12-13 09:17:46', NULL, 1, '5614-1-23.9954', '/share/5614-1-23.9954-SO1449.pdf'),
('BN1453_1', 'XT3871-10.0M', '10.0000MHz, HC43, SC, XT3', 500, NULL, 500, '2012-12-18 11:18:11', NULL, 1, '10sc3hc43', '/share/5396-2-10-SO1453.pdf'),
('D80-5112', 'XT3996-25.60M', '25.6MHz,HC43,AT3,12p', 180, NULL, 100, NULL, NULL, 1, '1377-3-25.6', '/share/1377-3-25.6-SO1471.pdf'),
('SO1328', 'XT3943-100.0M', '100.0MHZ,HC35,SC,5TH O', 425, NULL, 275, NULL, NULL, 0, '5371-4-100', ' /5371-4-100-O1328.pdf'),
('SO1445_1', 'XT4102-100.0M', '100.00000MHz, HC45, AT5', 150, NULL, 100, '2012-12-07 11:47:59', '2012-12-11 09:07:45', 2, 'SO1445_1', '/share/5585-1-100-SO1445.pdf'),
('SO1448_1', 'XT3261-100.0M', '100.0M, TO-5, SC Cut, XT', 150, NULL, 100, '2012-12-07 13:14:39', NULL, 1, '5374-6-100', '/share/5374-6-100-SO1448.pdf'),
('SO1456_1', 'XT4035-40.0M', '40.0000MHz, SC3, HC45 (XT', 700, NULL, 500, '2012-12-18 14:12:41', NULL, 1, '5519-2-40', '/share/5519-2-40-SO1456.pdf'),
('SO1461', 'XT3741-40.0M', '40.0MHZ,HC35LP,SC,3RD', 150, NULL, 60, NULL, NULL, 0, '5230-4-40', '5230-4-40-SO1461.pdf'),
('SO1462-1', 'XT3805-57.344M', '57.344MHZ,HC45,SC,XT3', 200, NULL, 100, NULL, NULL, 0, '5311-2-57.344', '/5311-2-57.344-SO1462-1.pdf'),
('SO1462-2', 'XT4110-102.40M', '102.40MHZ,HC45,SC3,XT4', 100, NULL, 30, NULL, NULL, 0, '5594-2-102.4', '/5594-2-102.4-SO1462-2.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `bcfriends`
--

DROP TABLE IF EXISTS `bcfriends`;
CREATE TABLE IF NOT EXISTS `bcfriends` (
  `user` varchar(16) DEFAULT NULL,
  `friend` varchar(16) DEFAULT NULL,
  KEY `user` (`user`(6)),
  KEY `friend` (`friend`(6))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bckits`
--

DROP TABLE IF EXISTS `bckits`;
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

DROP TABLE IF EXISTS `bcmembers`;
CREATE TABLE IF NOT EXISTS `bcmembers` (
  `user` varchar(16) DEFAULT NULL,
  `pass` varchar(16) DEFAULT NULL,
  KEY `user` (`user`(6))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcmembers`
--

INSERT INTO `bcmembers` (`user`, `pass`) VALUES
('steve', 'gandalf100'),
('Mark', 'P200vespa'),
('tsao.mills', 'Themandarin222'),
('dave.garvey', '$tam4rd'),
('Isobel', 'Murray'),
('Rose.Martin', 'leskard'),
('Theresa.Cumby', 'laflamme'),
('Karen.Greenley', 'greeny'),
('Donna.Welsh', 'brooks99'),
('Gail.Beauprie', 'AbsJae'),
('Pamela.Blake', 'alwaysablake'),
('Kathy.Ross', 'winner'),
('Sharon.Springett', 'morton'),
('Jessica.Prentice', '99999'),
('Ruiming.Yao', 'ruiming'),
('Natasha.Shafikh', 'Ariel2009'),
('Steve.Risebrough', 'wally9'),
('Rosemary.Forbes', 'tygertoad22'),
('Lorie.Fernandes', '4476123'),
('Allan', 'Pa55word');

-- --------------------------------------------------------

--
-- Table structure for table `bcmessages`
--

DROP TABLE IF EXISTS `bcmessages`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bcmessages`
--

INSERT INTO `bcmessages` (`id`, `auth`, `recip`, `pm`, `time`, `message`) VALUES
(1, 'dave.garvey', 'dave.garvey', '0', 1354732775, 'test'),
(2, 'dave.garvey', 'dave.garvey', '0', 1354732932, 'test 2');

-- --------------------------------------------------------

--
-- Table structure for table `bcoperations`
--

DROP TABLE IF EXISTS `bcoperations`;
CREATE TABLE IF NOT EXISTS `bcoperations` (
  `OpNo` int(3) NOT NULL,
  `operation` varchar(16) DEFAULT NULL,
  `relateddocs` varchar(16) DEFAULT NULL,
  `Link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`OpNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcoperations`
--

INSERT INTO `bcoperations` (`OpNo`, `operation`, `relateddocs`, `Link`) VALUES
(1, 'SC Correction', 'PI_150', '/share/Process%20Instructions/Lapping/SC%20Angle%20Correction.pdf'),
(2, 'SC Etch', 'PI_150_SC_Etch', '/share/Process%20Instructions/Lapping/SC%20Etch.pdf'),
(3, 'Rounding', 'PI_90', '/share/Process%20Instructions/Lapping/ROUNDING.pdf'),
(4, 'Edge Finishing', 'PI_95', '/share/Process%20Instructions/Lapping/Edge%20Lapping.pdf'),
(5, 'De Wax &amp; Ins', 'None', ''),
(6, 'Curve Generator', 'PI_70', '/share/Process%20Instructions/Lapping/Curve%20Generator.pdf'),
(7, 'Contour Lap', 'PI_175', '/share/Process%20Instructions/Lapping/Contour%20%28by%20Hand%29.pdf'),
(8, 'Contour Polish', 'PI_190', '/share/Process%20Instructions/Lapping/Polish%20Button%20Contour.pdf'),
(9, 'Pipe', 'PI_170', '/share/Process%20Instructions/Lapping/Fastpipe.pdf'),
(10, 'Bevel', 'PI_140/142', '/share/Process%20Instructions/Lapping/Bevel%201%20%26%202%20Sides.pdf'),
(11, 'Fine Lap', 'PI_130', '/share/Process%20Instructions/Lapping/Pin-Lapping.pdf'),
(12, '1 Micron Lap', 'None', ''),
(13, 'Polish', 'PI_160', '/share/Process%20Instructions/Lapping/POLISH.pdf'),
(14, 'Etch', 'PI_150_Etch', '/share/Process%20Instructions/Lapping/ETCH.pdf'),
(15, 'Clean', 'PI_?', '/share/Process%20Instructions/Finishing/Jig%20Cleaning%20Crystals%20at%20Baseplatae.pdf'),
(16, 'Baseplate', 'PI_300/302', '/share/Process%20Instructions/Finishing/Baseplate.pdf'),
(17, 'Spring Mount', 'None', ''),
(18, 'Nickel', 'PI_310/420', '/share/Process%20Instructions/Finishing/Nickel%20%26%20Adjust.pdf'),
(19, 'Burn In Nickel', 'None', ''),
(20, 'Pre Cal/Anneal', 'PI_440', '/share/Process%20Instructions/Finishing/Calibrate%20%231%20Single%20Head%20-%20Pre%20Cal.pdf'),
(21, 'Mount', 'PI_330/340', '/share/Process%20Instructions/Finishing/Mount%20%26%20Paste.pdf'),
(22, 'Cement', 'PI_330/340', '/share/Process%20Instructions/Finishing/Mount%20%26%20Paste.pdf'),
(23, 'Vacuum Bake', 'PI_350/360', '/share/Process%20Instructions/Finishing/Cement%20Curing.pdf'),
(24, 'Cement 2', 'PI_330/340', '/share/Process%20Instructions/Finishing/Mount%20%26%20Paste.pdf'),
(25, 'Vac Bake Cement2', 'PI_350/360', '/share/Process%20Instructions/Finishing/Cement%20Curing.pdf'),
(26, 'Final Cal Multi', 'PI_500/400', '/share/Process%20Instructions/Finishing/Saunders%205150S%20-%205150S%20-%205250S.pdf'),
(27, 'Final Cal Single', 'PI_500', '/share/Process%20Instructions/Finishing/Calibrate%20%231%20Single%20Head.pdf'),
(28, 'Vacuum Bake Cal', 'PI_350/360', '/share/Process%20Instructions/Finishing/Cement%20Curing.pdf'),
(29, 'Resistance Weld', 'PI_580', '/share/Process%20Instructions/Finishing/R.%20W.%20Sealer%20Rev.pdf'),
(30, 'Cold Weld', 'PI_570', '/share/Process%20Instructions/Finishing/Cold%20Weld%20Seal.pdf'),
(31, 'Glass Seal', 'PI_510', '/share/Process%20Instructions/Finishing/Glass%20Sealing.pdf'),
(32, 'Vacuum Braze', '0', ''),
(33, 'Thermal Cycle', 'PI_530', '/share/Process%20Instructions/Finishing/Cycling%20Oven.pdf'),
(34, 'Leak/Short Test', 'PI_601', '/share/Process%20Instructions/Finishing/Helium%20Leak%20Test.pdf'),
(35, 'Burn in', '0', ''),
(36, 'Burn In 2', 'None', ''),
(37, 'Thermal Test', 'PI_820', '/share/Process%20Instructions/Finishing/250B%20W2200%20Thermal%20Test.pdf'),
(38, 'Final Test 250B', 'PI_800', '/share/Process%20Instructions/Finishing/250B%20Final%20Test.pdf'),
(39, 'Phase Noise', 'None', ''),
(40, 'Glass Visual Ins', 'PI_910', '/share/Process%20Instructions/Finishing/VISUAL.pdf'),
(41, 'Reclaim', 'PI_450', '/share/Process%20Instructions/Lapping/Stripping%20of%20Crystals%20%28.%29.pdf'),
(42, 'Ink Marking', 'PI_620_Ink', '/share/Process%20Instructions/Finishing/Branding.pdf'),
(43, 'Engraving', 'PI_620', '/share/Process%20Instructions/Finishing/Engraving%20Machine%20Rev%20E.pdf'),
(44, 'Tinning', 'PI_550/940', '/share/Process%20Instructions/Finishing/TINNING.pdf'),
(45, 'Lead Bend', 'PI_940', '/share/Process%20Instructions/Finishing/Lead%20Detail.pdf'),
(46, 'Lead Attach', 'PI_940_attach', '/share/Process%20Instructions/Finishing/PINNING.pdf'),
(47, 'Shipping', 'PI_950/960', '/share/Process%20Instructions/Finishing/Shipping%20%26%20Invoicing.pdf'),
(48, 'Vacuum bake 3', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `bcoperationsdone`
--

DROP TABLE IF EXISTS `bcoperationsdone`;
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
  `moved_from_stock` smallint(5) unsigned DEFAULT NULL,
  `Comments` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcoperationsdone`
--

INSERT INTO `bcoperationsdone` (`batchno`, `operation`, `staffnumber`, `starttime`, `endtime`, `quantitycomplete`, `scrap`, `start`, `end`, `moved_to_stock`, `moved_from_stock`, `Comments`) VALUES
('NULL', 'NULL', 8, NULL, NULL, NULL, NULL, '2012-12-06 13:27:43', NULL, NULL, NULL, ''),
('BN1441', '1', 1, NULL, NULL, NULL, NULL, '2012-12-07 11:09:48', NULL, NULL, NULL, NULL),
('BN0001', '1', 1, NULL, NULL, 170, 20, '2012-12-07 11:25:38', '2012-12-07 11:26:03', NULL, NULL, 'broken'),
('SO1445_1', '3', 1, NULL, NULL, 200, 0, '2012-12-07 11:47:59', '2012-12-07 12:35:13', NULL, NULL, ''),
('SO1445_1', '4', 1, NULL, NULL, 200, 0, '2012-12-07 12:35:20', '2012-12-07 12:36:12', NULL, NULL, ''),
('SO1445_1', '11', 1, NULL, NULL, 200, 0, '2012-12-07 12:36:20', '2012-12-07 12:36:43', NULL, NULL, ''),
('SO1445_1', '13', 1, NULL, NULL, 161, 0, '2012-12-07 12:36:58', '2012-12-07 12:38:20', NULL, NULL, 'gail'),
('SO1445_1', '15', 1, NULL, NULL, 161, 0, '2012-12-07 12:40:28', '2012-12-07 12:41:19', NULL, NULL, 'RM'),
('SO1445_1', '16', 1, NULL, NULL, 158, 3, '2012-12-07 12:41:27', '2012-12-07 12:42:01', NULL, NULL, 'JP'),
('SO1448_1', '1', 8, NULL, NULL, 0, 0, '2012-12-07 13:14:39', '2012-12-07 15:30:19', NULL, NULL, 'end of shift'),
('BN0001', '11', 2, NULL, NULL, NULL, NULL, '2012-12-11 08:22:03', NULL, NULL, NULL, NULL),
('SO1448_1', '1', 8, NULL, NULL, 0, 0, '2012-12-11 08:35:36', '2012-12-20 15:32:33', NULL, NULL, 'end of shift'),
('B101', '3', 13, NULL, NULL, 60, 0, '2012-12-13 08:24:39', '2012-12-13 10:21:25', NULL, NULL, ''),
('A176', '3', 13, NULL, NULL, 60, 0, '2012-12-13 08:25:21', '2012-12-13 11:10:00', NULL, NULL, ''),
('B117', '3', 13, NULL, NULL, 190, 0, '2012-12-13 09:15:34', '2012-12-13 11:41:40', NULL, NULL, ''),
('BN1449_1', '3', 13, NULL, NULL, 30, 0, '2012-12-13 09:17:46', '2012-12-13 13:00:51', NULL, NULL, ''),
('A239', '3', 13, NULL, NULL, 30, 0, '2012-12-13 11:11:18', '2012-12-13 12:53:30', NULL, NULL, ''),
('BN1453_1', '15', 8, NULL, NULL, 500, 0, '2012-12-18 11:18:11', '2013-01-03 13:19:53', NULL, NULL, 'started on 1/3/13'),
('SO1456_1', '15', 8, NULL, NULL, 685, 0, '2012-12-18 14:12:41', '2012-12-18 14:13:54', NULL, NULL, 'received 685 pcs'),
('B117', '4', 5, NULL, NULL, 190, 0, '2012-12-20 08:25:45', '2012-12-20 08:26:56', NULL, NULL, ''),
('B117', '5', 5, NULL, NULL, 188, 2, '2012-12-20 08:27:20', '2012-12-20 10:06:46', NULL, NULL, 'broke2'),
('BN1449_1', '4', 5, NULL, NULL, 28, 2, '2012-12-20 08:32:16', '2012-12-20 10:58:58', NULL, NULL, '2broke.dewax'),
('SO1456_1', '16', 4, NULL, NULL, 0, 0, '2012-12-20 10:26:20', '2012-12-20 11:34:27', NULL, NULL, ''),
('SO1456_1', '15', 998, NULL, NULL, 0, 0, '2012-12-20 11:19:56', '2012-12-20 11:20:54', NULL, NULL, 'test entry'),
('SO1456_1', '22', 998, NULL, NULL, NULL, NULL, '2012-12-20 11:22:18', NULL, NULL, NULL, NULL),
('A239', '11', 2, NULL, NULL, 30, 0, '2012-12-20 12:55:13', '2012-12-20 14:07:14', NULL, NULL, ''),
('A176', '11', 2, NULL, NULL, 0, 0, '2012-12-20 14:10:29', '2012-12-20 15:11:22', NULL, NULL, 'End of shift'),
('SO1448_1', '1', 8, NULL, NULL, 0, 0, '2012-12-21 07:03:09', '2012-12-21 11:49:17', NULL, NULL, 'stop for another job 65done'),
('B36-5112', '3', 3, NULL, NULL, 250, 0, '2013-01-02 07:16:18', '2013-01-02 09:11:14', NULL, NULL, ''),
('SO1456_1', '16', 4, NULL, NULL, 0, 0, '2013-01-02 08:24:20', '2013-01-02 15:12:32', NULL, NULL, ''),
('SO1448_1', '1', 13, NULL, NULL, 0, 0, '2013-01-02 08:39:43', '2013-01-02 11:43:53', NULL, NULL, 'lunch'),
('A176', '11', 2, NULL, NULL, 60, 0, '2013-01-02 08:57:14', '2013-01-02 09:05:18', NULL, NULL, ''),
('B101', '11', 2, NULL, NULL, 0, 0, '2013-01-02 09:07:41', '2013-01-02 11:44:58', NULL, NULL, 'lunch'),
('B66', '13', 3, NULL, NULL, 0, 0, '2013-01-02 09:13:34', '2013-01-02 11:46:43', NULL, NULL, 'lunch'),
('B101', '11', 2, NULL, NULL, 60, 0, '2013-01-02 12:27:55', '2013-01-02 12:47:07', NULL, NULL, ''),
('B66', '13', 3, NULL, NULL, 0, 0, '2013-01-02 12:29:59', '2013-01-02 15:21:21', NULL, NULL, 'home'),
('SO1448_1', '1', 13, NULL, NULL, 0, 0, '2013-01-02 12:33:15', '2013-01-02 15:12:11', NULL, NULL, 'home'),
('B117', '11', 2, NULL, NULL, 188, 0, '2013-01-02 12:50:11', '2013-01-02 15:08:26', NULL, NULL, ''),
('B66', '13', 3, NULL, NULL, 75, 4, '2013-01-03 06:59:08', '2013-01-03 07:28:32', NULL, NULL, '9 scratches to stock'),
('SO1448_1', '1', 13, NULL, NULL, 0, 0, '2013-01-03 07:00:05', '2013-01-03 15:23:38', NULL, NULL, 'home'),
('B36-5112', '4', 5, NULL, NULL, 250, 0, '2013-01-03 07:02:53', '2013-01-03 07:55:28', NULL, NULL, 'finish'),
('BN1449_1', '11', 2, NULL, NULL, 27, 1, '2013-01-03 07:05:20', '2013-01-03 08:20:42', NULL, NULL, ''),
('B117', '14', 3, NULL, NULL, 177, 6, '2013-01-03 07:35:37', '2013-01-03 12:45:49', NULL, NULL, '5pcs to stock'),
('SO1456_1', '16', 4, NULL, NULL, 0, 0, '2013-01-03 07:43:41', '2013-01-03 09:16:39', NULL, NULL, ''),
('B66', '15', 8, NULL, NULL, 75, 0, '2013-01-03 07:51:11', '2013-01-03 10:14:13', NULL, NULL, ''),
('B36-5112', '11', 2, NULL, NULL, 0, 0, '2013-01-03 08:30:49', '2013-01-03 15:08:54', NULL, NULL, 'end of day'),
('SO1456_1', '16', 4, NULL, NULL, 681, 4, '2013-01-03 10:28:19', '2013-01-03 11:07:12', NULL, NULL, ''),
('BN1449_1', '14', 3, NULL, NULL, 8, 2, '2013-01-03 12:52:28', '2013-01-03 13:23:47', NULL, NULL, '17put in stock'),
('B117', '15', 8, NULL, NULL, 177, 0, '2013-01-03 12:57:39', '2013-01-03 14:57:03', NULL, NULL, ''),
('BN1449_1', '15', 8, NULL, NULL, 8, 0, '2013-01-03 14:02:26', '2013-01-03 14:45:03', NULL, NULL, ''),
('BN1449_1', '15', 8, NULL, NULL, 0, 0, '2013-01-03 14:58:56', '2013-01-07 07:15:00', NULL, NULL, ''),
('SO1448_1', '1', 13, NULL, NULL, 0, 0, '2013-01-04 07:15:37', '2013-01-04 10:51:37', NULL, NULL, 'appointment'),
('SO1448_1', '1', 13, NULL, NULL, 0, 0, '2013-01-04 12:53:39', '2013-01-04 15:20:07', NULL, NULL, 'home'),
('SO1448_1', '1', 8, NULL, NULL, 216, 15, '2013-01-07 07:12:51', '2013-01-07 15:20:03', NULL, NULL, '19pcs to stock'),
('SO1456_1', '21', 15, NULL, NULL, 0, 0, '2013-01-07 08:00:28', '2013-01-07 11:54:08', NULL, NULL, 'lunch'),
('D80-5112', '3', 3, NULL, NULL, 180, 0, '2013-01-07 08:56:28', '2013-01-07 11:17:57', NULL, NULL, ''),
('A239', '10', 5, NULL, NULL, 30, 0, '2013-01-07 11:13:59', '2013-01-07 11:51:53', NULL, NULL, ''),
('A239', '9', 5, NULL, NULL, 0, 0, '2013-01-07 12:39:07', '2013-01-07 15:17:13', NULL, NULL, 'gone.home'),
('B101', '7', 5, NULL, NULL, 0, 60, '2013-01-07 12:44:12', '2013-01-07 13:11:12', NULL, NULL, '60pcs wrong freq. at la'),
('SO1456_1', '21', 15, NULL, NULL, 679, 2, '2013-01-07 12:44:28', '2013-01-07 14:05:19', NULL, NULL, ''),
('A176', '7', 5, NULL, NULL, 0, 0, '2013-01-07 13:12:46', '2013-01-07 15:14:37', NULL, NULL, 'gone home'),
('SO1456_1', '22', 15, NULL, NULL, 0, 0, '2013-01-07 14:06:02', '2013-01-07 15:08:15', NULL, NULL, ''),
('SO1448_1', '2', 8, NULL, NULL, 216, 0, '2013-01-07 15:24:59', '2013-01-07 15:25:16', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `bcorders`
--

DROP TABLE IF EXISTS `bcorders`;
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

DROP TABLE IF EXISTS `bcpeople`;
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
('Steve', 'Wilson', 'steve', 66, 'gandalf100'),
('Mark', 'Cunningham', 'Mark', 998, 'P200vespa'),
('Tsao', 'Mills', 'tsao.mills', 997, 'Themandarin222'),
('Dave', 'Garvey', 'dave.garvey', 1, '$tam4rd'),
('Isobel', 'Wilson', 'Isobel', 998, 'Murray'),
('Rose', 'Martin', 'Rose.Martin', 8, 'leskard'),
('Theresa ', 'Cumby', 'Theresa.Cumby', 13, 'laflamme'),
('Karen', 'Greenley', 'Karen.Greenley', 5, 'greeny'),
('Donna', 'Welsh', 'Donna.Welsh', 2, 'brooks99'),
('Gail', 'Beauprie', 'Gail.Beauprie', 3, 'AbsJae'),
('Pamela', 'Blake', 'Pamela.Blake', 15, 'alwaysablake'),
('Kathy', 'Ross', 'Kathy.Ross', 6, 'winner'),
('Sharon', 'Springett', 'Sharon.Springett', 11, 'morton'),
('Jessica', 'Prentice', 'Jessica.Prentice', 4, '99999'),
('Ruiming', 'Yao', 'Ruiming.Yao', 10, 'ruiming'),
('Natasha ', 'Shafikh ', 'Natasha.Shafikh', 14, 'Ariel2009'),
('Steve', 'Risebrough', 'Steve.Risebrough', 12, 'wally9'),
('Rosemary', 'Forbes', 'Rosemary.Forbes', 9, 'tygertoad22'),
('Lorie', 'Fernandes', 'Lorie.Fernandes', 7, '4476123'),
('Allan', 'Wilson', 'Allan', 999, 'Pa55word');

-- --------------------------------------------------------

--
-- Table structure for table `bcproductoperations`
--

DROP TABLE IF EXISTS `bcproductoperations`;
CREATE TABLE IF NOT EXISTS `bcproductoperations` (
  `Product_code` varchar(64) DEFAULT NULL,
  `Build_type` varchar(255) DEFAULT NULL,
  `operation_1` int(11) DEFAULT NULL,
  `operation_2` int(11) DEFAULT NULL,
  `operation_3` int(11) DEFAULT NULL,
  `operation_4` int(11) DEFAULT NULL,
  `operation_5` int(11) DEFAULT NULL,
  `operation_6` int(11) DEFAULT NULL,
  `operation_7` int(11) DEFAULT NULL,
  `operation_8` int(11) DEFAULT NULL,
  `operation_9` int(11) DEFAULT NULL,
  `operation_10` int(11) DEFAULT NULL,
  `operation_11` int(11) DEFAULT NULL,
  `operation_12` int(11) DEFAULT NULL,
  `operation_13` int(11) DEFAULT NULL,
  `operation_14` int(11) DEFAULT NULL,
  `operation_15` int(11) DEFAULT NULL,
  `operation_16` int(11) DEFAULT NULL,
  `operation_17` int(11) DEFAULT NULL,
  `operation_18` int(11) DEFAULT NULL,
  `operation_19` int(11) DEFAULT NULL,
  `operation_20` int(11) DEFAULT NULL,
  `operation_21` int(11) DEFAULT NULL,
  `operation_22` int(11) DEFAULT NULL,
  `operation_23` int(11) DEFAULT NULL,
  `operation_24` int(11) DEFAULT NULL,
  `operation_25` int(11) DEFAULT NULL,
  `operation_26` int(11) DEFAULT NULL,
  `operation_27` int(11) DEFAULT NULL,
  `operation_28` int(11) DEFAULT NULL,
  `operation_29` int(11) DEFAULT NULL,
  `operation_30` int(11) DEFAULT NULL,
  `operation_31` int(11) DEFAULT NULL,
  `operation_32` int(11) DEFAULT NULL,
  `operation_33` int(11) DEFAULT NULL,
  `operation_34` int(11) DEFAULT NULL,
  `operation_35` int(11) DEFAULT NULL,
  `operation_36` int(11) DEFAULT NULL,
  `operation_37` int(11) DEFAULT NULL,
  `operation_38` int(11) DEFAULT NULL,
  `operation_39` int(11) DEFAULT NULL,
  `operation_40` int(11) DEFAULT NULL,
  `operation_41` int(11) DEFAULT NULL,
  `operation_42` int(11) DEFAULT NULL,
  `operation_43` int(11) DEFAULT NULL,
  `operation_44` int(11) DEFAULT NULL,
  `operation_45` int(11) DEFAULT NULL,
  `operation_46` int(11) DEFAULT NULL,
  `operation_47` int(11) DEFAULT NULL,
  `operation_48` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcproductoperations`
--

INSERT INTO `bcproductoperations` (`Product_code`, `Build_type`, `operation_1`, `operation_2`, `operation_3`, `operation_4`, `operation_5`, `operation_6`, `operation_7`, `operation_8`, `operation_9`, `operation_10`, `operation_11`, `operation_12`, `operation_13`, `operation_14`, `operation_15`, `operation_16`, `operation_17`, `operation_18`, `operation_19`, `operation_20`, `operation_21`, `operation_22`, `operation_23`, `operation_24`, `operation_25`, `operation_26`, `operation_27`, `operation_28`, `operation_29`, `operation_30`, `operation_31`, `operation_32`, `operation_33`, `operation_34`, `operation_35`, `operation_36`, `operation_37`, `operation_38`, `operation_39`, `operation_40`, `operation_41`, `operation_42`, `operation_43`, `operation_44`, `operation_45`, `operation_46`, `operation_47`, `operation_48`) VALUES
('XT4129-100.0M', 'OLD_STANDARD', 1, 2, 3, 4, 5, 0, 0, 0, 0, 0, 6, 7, 8, 0, 9, 10, 11, 0, 0, 12, 13, 14, 15, 16, 17, 18, 0, 19, 0, 20, 0, 0, 21, 22, 23, 24, 25, 26, 0, 0, 27, 28, 29, 30, 0, 0, 31, 0),
('XT4058-57.344M', 'Full Build', 1, 2, 3, 4, 5, 0, 0, 0, 0, 0, 6, 7, 8, 0, 9, 10, 11, 0, 0, 12, 13, 14, 15, 0, 0, 16, 0, 17, 0, 18, 0, 0, 19, 20, 21, 22, 23, 24, 0, 0, 25, 26, 27, 28, 0, 0, 50, 0),
('NXT-901-4.400620', 'Full Build', 0, 0, 1, 2, 3, 0, 0, 0, 6, 5, 4, 0, 0, 7, 8, 9, 10, 11, 12, 0, 13, 14, 15, 0, 0, 16, 0, 0, 17, 0, 0, 0, 18, 19, 20, 22, 21, 23, 0, 0, 24, 0, 25, 0, 0, 0, 26, 0),
('NXT-902-4.397050', 'Full Build', 0, 0, 1, 2, 3, 0, 0, 0, 6, 5, 4, 0, 0, 7, 8, 9, 10, 11, 12, 0, 13, 14, 15, 0, 0, 16, 0, 0, 17, 0, 0, 0, 18, 19, 20, 22, 21, 23, 0, 0, 24, 0, 25, 0, 0, 0, 26, 0),
('NXT-903-4.399980', 'Full Build', 0, 0, 1, 2, 3, 0, 0, 0, 6, 5, 4, 0, 0, 7, 8, 9, 10, 11, 12, 0, 13, 14, 15, 0, 0, 16, 0, 0, 17, 0, 0, 0, 18, 19, 20, 22, 21, 23, 0, 0, 24, 0, 25, 0, 0, 0, 26, 0),
('NXT-904-4.397700', 'Full Build', 0, 0, 1, 2, 3, 0, 0, 0, 6, 5, 4, 0, 0, 7, 8, 9, 10, 11, 12, 0, 13, 14, 15, 0, 0, 16, 0, 0, 17, 0, 0, 0, 18, 19, 20, 22, 21, 23, 0, 0, 24, 0, 25, 0, 0, 0, 26, 0),
('dd', 'so14333', 32, 25, 6, 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('XT3871-10.0M', '10sc3hc43', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 0, 6, 3, 4, 5, 0, 7, 8, 0, 9, 0, 10, 0, 0, 11, 12, 13, 15, 14, 16, 0, 0, 0, 0, 0, 17, 0, 0, 18, 0),
('XT4132-23.995M', '5614-1-23.9954', 0, 0, 1, 2, 0, 0, 0, 0, 0, 0, 3, 0, 0, 4, 5, 6, 7, 0, 0, 8, 9, 10, 11, 0, 0, 12, 0, 13, 0, 14, 0, 0, 15, 16, 17, 19, 18, 20, 0, 0, 0, 21, 22, 23, 0, 0, 24, 0),
('XT4102-100.0M', 'SO1445_1', 0, 0, 1, 2, 0, 0, 0, 0, 0, 0, 3, 0, 4, 0, 5, 6, 0, 0, 0, 10, 7, 8, 9, 0, 0, 12, 0, 11, 13, 0, 0, 0, 14, 15, 16, 18, 17, 19, 0, 0, 0, 20, 21, 22, 0, 0, 23, 0),
('XT4035-40.0M', '5519-2-40', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 0, 6, 3, 4, 5, 0, 0, 8, 0, 7, 0, 10, 0, 0, 11, 12, 13, 0, 14, 0, 0, 0, 0, 0, 15, 16, 0, 0, 17, 9),
('XT3261-100.0M', '5374-6-100', 1, 2, 3, 4, 5, 0, 0, 0, 0, 0, 6, 7, 8, 0, 9, 10, 11, 0, 0, 12, 13, 14, 15, 16, 17, 18, 0, 19, 0, 20, 0, 0, 21, 22, 23, 25, 24, 26, 0, 0, 0, 27, 28, 29, 0, 0, 30, 0),
('XT4129-100.0M', 'STANDARD', 1, 2, 4, 5, 6, 0, 0, 0, 0, 0, 3, 7, 8, 0, 9, 10, 11, 0, 0, 12, 13, 14, 15, 16, 17, 18, 0, 19, 0, 20, 0, 0, 21, 22, 23, 24, 25, 26, 0, 0, 27, 28, 29, 30, 0, 0, 31, 0),
('XT4015-3.2663M', '1383-2-3.266', 0, 0, 1, 0, 0, 0, 3, 0, 0, 4, 2, 0, 0, 5, 6, 7, 0, 8, 0, 0, 9, 10, 11, 0, 0, 12, 0, 0, 0, 13, 0, 0, 14, 15, 16, 18, 17, 19, 0, 0, 0, 0, 20, 21, 0, 0, 22, 0),
('XT3988-5.0M', '1375-3-4.9152', 0, 0, 1, 0, 0, 0, 3, 0, 0, 4, 2, 0, 0, 5, 6, 7, 0, 8, 0, 0, 9, 10, 11, 0, 0, 12, 0, 0, 0, 13, 0, 0, 14, 15, 16, 18, 17, 19, 0, 0, 0, 0, 20, 21, 0, 0, 22, 0),
('XT3875-20.0M', '5404-2-20', 0, 0, 1, 2, 3, 0, 0, 0, 0, 0, 4, 0, 0, 5, 6, 7, 0, 0, 0, 11, 8, 9, 10, 0, 12, 13, 0, 14, 0, 15, 0, 0, 16, 17, 18, 20, 19, 21, 0, 0, 0, 0, 22, 23, 0, 0, 24, 0),
('010798-0505-1', '2081-4-10', 0, 0, 1, 0, 0, 0, 0, 0, 4, 3, 2, 0, 0, 5, 6, 7, 0, 8, 0, 0, 9, 10, 11, 0, 0, 12, 0, 13, 14, 0, 0, 0, 15, 16, 17, 19, 18, 20, 0, 0, 0, 0, 21, 0, 0, 0, 22, 0),
('XT3971-161.6667M', '1285-4-161.6667', 0, 0, 1, 2, 0, 0, 0, 0, 0, 0, 3, 0, 4, 0, 5, 6, 0, 0, 0, 10, 7, 8, 9, 0, 11, 0, 12, 0, 13, 0, 0, 0, 0, 14, 15, 17, 16, 18, 0, 0, 0, 0, 19, 0, 0, 0, 20, 0),
('XT3996-25.60M', '1377-3-25.6', 0, 0, 1, 0, 0, 0, 0, 0, 0, 4, 2, 0, 3, 0, 5, 6, 7, 0, 0, 8, 9, 10, 11, 0, 0, 12, 0, 13, 0, 14, 0, 0, 15, 16, 17, 19, 18, 20, 0, 0, 0, 0, 21, 22, 0, 0, 23, 0),
('XT3971-161.6667M', '1285-4-161.6667-cement', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 1, 2, 0, 4, 5, 0, 0, 6, 0, 0, 0, 0, 7, 8, 9, 10, 0, 0, 0, 0, 0, 11, 0, 0, 0, 12, 0),
('XT4135-150.0M', '5616-1-150', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 2, 3, 4, 0, 0, 5, 6, 7, 8, 0, 0, 9, 0, 10, 0, 11, 0, 0, 13, 14, 12, 16, 15, 17, 0, 0, 0, 0, 18, 19, 0, 0, 20, 0),
('XT3943-100.0M', '5371-4-100', 1, 0, 3, 4, 5, 0, 0, 0, 0, 0, 2, 6, 7, 0, 8, 9, 10, 0, 0, 11, 12, 13, 14, 15, 16, 17, 0, 18, 0, 19, 0, 0, 20, 21, 22, 24, 23, 25, 26, 0, 0, 0, 27, 28, 0, 0, 29, 0),
('XT3741-40.0M', '5230-4-40', 1, 0, 3, 4, 5, 0, 0, 0, 0, 7, 2, 0, 6, 0, 8, 9, 10, 0, 0, 11, 12, 13, 14, 15, 16, 17, 0, 18, 0, 19, 0, 0, 20, 21, 22, 24, 23, 25, 0, 0, 0, 0, 26, 27, 0, 0, 28, 0),
('XT3805-57.344M', '5311-2-57.344', 1, 0, 3, 4, 5, 0, 0, 0, 0, 0, 2, 0, 6, 0, 7, 8, 9, 0, 0, 10, 11, 12, 13, 0, 0, 14, 0, 15, 0, 16, 0, 0, 17, 18, 19, 21, 20, 22, 0, 0, 0, 0, 23, 24, 0, 0, 25, 0),
('XT4110-102.40M', '5594-2-102.4', 1, 0, 3, 4, 5, 0, 0, 0, 0, 0, 2, 6, 7, 0, 8, 9, 10, 0, 0, 11, 12, 13, 14, 0, 0, 15, 0, 16, 0, 17, 0, 0, 18, 19, 20, 22, 21, 23, 0, 0, 0, 0, 24, 25, 0, 0, 26, 0),
('XT4015-3.2663M', '1383-3-3.266', 0, 0, 1, 0, 0, 0, 3, 0, 0, 4, 2, 0, 0, 5, 6, 7, 0, 8, 0, 0, 9, 10, 11, 0, 0, 12, 0, 0, 0, 13, 0, 0, 14, 15, 16, 18, 17, 19, 0, 0, 0, 0, 20, 21, 0, 0, 22, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bcprofiles`
--

DROP TABLE IF EXISTS `bcprofiles`;
CREATE TABLE IF NOT EXISTS `bcprofiles` (
  `user` varchar(16) DEFAULT NULL,
  `text` varchar(4096) DEFAULT NULL,
  KEY `user` (`user`(6))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bcsalesorders`
--

DROP TABLE IF EXISTS `bcsalesorders`;
CREATE TABLE IF NOT EXISTS `bcsalesorders` (
  `salesorder` varchar(18) NOT NULL,
  `item` int(5) NOT NULL,
  `quantity` int(5) NOT NULL,
  `productcode` varchar(18) NOT NULL,
  `customer` varchar(25) NOT NULL,
  `description` varchar(25) DEFAULT NULL,
  `requestedshipdate` date NOT NULL,
  `expectedshipdate` date NOT NULL,
  `actualshipdate` date DEFAULT NULL,
  `comments` varchar(128) DEFAULT NULL,
  `Op_Entered` varchar(50) DEFAULT NULL,
  `Date_Entered` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bcsalesorders`
--

INSERT INTO `bcsalesorders` (`salesorder`, `item`, `quantity`, `productcode`, `customer`, `description`, `requestedshipdate`, `expectedshipdate`, `actualshipdate`, `comments`, `Op_Entered`, `Date_Entered`) VALUES
('1438', 1, 0, 'XT4129-100.0M', 'Xtalq Technologies', '100.0MHz, HC35LP, SC5', '2013-01-30', '2013-01-28', '2012-12-11', 'batched', NULL, NULL),
('1441', 1, 0, 'XT4058-57.344M', 'Inotech(Shanghai) Co. Ltd', '57.344MHz, HC43, SC', '2013-01-30', '2013-01-28', '2012-12-11', 'batched', NULL, NULL),
('1445', 1, 0, 'XT4102-100.0M', 'Sung Shan Tech Co. Ltd', '100.00000MHz, HC45, AT5', '2013-02-04', '2013-02-01', '2012-12-12', 'cancelled', NULL, NULL),
('1443', 1, 0, 'NXT-901-4.400620', 'Northern Piezo Devices In', '4.400620MHz, HC49, AT1,10', '2013-01-31', '2013-01-30', '2012-12-11', 'batched', NULL, NULL),
('1443', 2, 0, 'NXT-902-4.397050', 'Northern Piezo Devices In', '4.397050MHz, HC49 ,AT1,10', '2013-01-31', '2013-01-30', '2012-12-11', 'batched', NULL, NULL),
('1443', 3, 0, 'NXT-903-4.399980', 'Northern Piezo Devices In', '4.399980MHz, HC49, AT1, 1', '2013-01-31', '2013-01-30', '2012-12-11', 'batched', NULL, NULL),
('1443', 4, 0, 'NXT-904-4.397700', 'Northern Piezo Devices In', '4.397700MHz, HC49, AT1', '2013-01-31', '2013-01-30', '2012-12-11', 'batched', NULL, NULL),
('1453', 1, 500, 'XT3871-10.0M', 'RFX', '10.0000MHz, HC43, SC, XT3', '2013-02-13', '2013-02-06', NULL, 'PO692_ 12.20.12', NULL, NULL),
('1449', 1, 3, 'XT4132-23.995M', 'Rakon', '23.9954MHz, HC35, AT1', '2013-02-08', '2013-02-01', NULL, 'BN1449_1', NULL, NULL),
('SO1448', 1, 100, 'XT3261-100.0M', 'HWA Telecom Co', '100.0M, TO-5, SC Cut,  XT', '2013-02-11', '2013-02-03', NULL, 'SO1448_1', NULL, NULL),
('1456', 1, 500, 'XT4035-40.0M', 'Valpey', '40.0000MHz, SC3, HC45 (XT', '2013-02-08', '2013-02-02', NULL, 'SO1456_1', NULL, NULL),
('1455', 1, 25, 'XT4015-3.2663M', 'Rakon', '3.2663MHz, HC37. AT, Pin#', '2013-01-25', '2013-01-15', NULL, 'B101', NULL, NULL),
('1455', 2, 25, 'XT3988-5.0M', 'Rakon', '5.0MHz, TO8, AT, Pin#2-4(', '2013-01-25', '2013-01-15', NULL, 'A176', NULL, NULL),
('1460', 1, 100, 'XT3875-20.0M', 'Sung Shan', '20.00000MHz, HC45, AT, Fu', '2013-02-11', '2013-02-02', NULL, 'B117', NULL, NULL),
('1462', 1, 100, 'XT3805-57.344M', 'Sung Shan', '57.344MHz, HC45, SC3, XT3', '2013-02-11', '2013-02-02', NULL, 'SO1462-1', NULL, NULL),
('1462', 2, 30, 'XT4110-102.40M', 'Sung Shan', '102.40MHz, HC45, SC3, XT4', '2013-02-11', '2013-02-02', NULL, 'SO1462-2', NULL, NULL),
('1461', 1, 60, 'XT3741-40.0M', 'Sung Shan', '40.0MHz, HC35LP, SC, 3rd ', '2013-02-11', '2013-02-02', NULL, 'SO1461', NULL, NULL),
('1465', 1, 10, '010798-0505-1', 'MTI', '10.00MHz, HC37LP, AT3, 01', '2013-02-08', '2013-02-00', NULL, 'A239', 'tsao.mills', '2012-12-12'),
('1463', 1, 25, 'XT4133-62.50M', 'INOTECH', '62.50MHz,, HC45, SC3, 85d', '2013-02-15', '2013-02-02', NULL, 'PO699-Jan 7th 13', 'tsao.mills', '2012-12-12'),
('1470', 1, 200, 'XT3971-161.6667M', 'Advanced Manufauring', '161.6667MHz, HC49, AT ', '2013-03-01', '2013-02-25', NULL, NULL, 'tsao.mills', '2012-12-17'),
('1471', 1, 100, 'XT3996-25.60M', 'Rakon', '25.6MHz,HC43,AT3,12p', '2013-02-20', '2013-02-10', NULL, NULL, 'tsao.mills', '2012-12-18'),
('1328', 1, 275, 'XT3943-100.0M', 'KVG', '100.0MHz, HC35, SC, 5th O', '2013-03-29', '2013-03-02', NULL, 'SO1328', 'tsao.mills', '2012-12-18'),
('1477', 1, 30, 'XT4135-150.0M', 'KVG', '150.0MHz, HC43, IT7, +2.0', '2013-01-30', '2013-01-21', NULL, 'B66', 'tsao.mills', '2012-12-21'),
('1478', 1, 500, 'XT4035-40.0M', 'Valpey', '40.0000MHz, SC3, HC45 (XT', '2013-02-28', '2013-02-14', NULL, 'PO706-01.16.13', 'tsao.mills', '2012-12-28'),
('1480', 1, 20, 'XT4095-100.0M', 'MTI', '100.000MHz, UM5, 3rd O/T,', '2013-03-04', '2013-02-28', NULL, NULL, 'tsao.mills', '2013-01-06'),
('1481', 1, 25, 'XT4137-32.768M', 'Sungshan', '32.768MHz, HC45, SC3, 70o', '2013-03-21', '2013-03-06', NULL, '', 'tsao.mills', '2013-01-06'),
('1482', 1, 100, 'XL1094G-22.1184M', 'Frequency Management', '22.1184MHz, Blanks, IT LT', '2013-02-06', '2013-01-31', NULL, 'PO708-21.01.13 100pcs', 'tsao.mills', '2013-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `bcsalestobatch`
--

DROP TABLE IF EXISTS `bcsalestobatch`;
CREATE TABLE IF NOT EXISTS `bcsalestobatch` (
  `salesorder` text NOT NULL,
  `item` int(11) NOT NULL,
  `batch` text NOT NULL,
  `key` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `bcsalestobatch`
--

INSERT INTO `bcsalestobatch` (`salesorder`, `item`, `batch`, `key`) VALUES
('1438', 1, 'BN0001', 36),
('1441', 1, 'BN1441', 37),
('1443', 1, 'BN1443_1', 38),
('1443', 2, 'BN1443_2', 39),
('1443', 3, 'BN1443_3', 40),
('1443', 4, 'BN1443_4', 41),
('1453', 1, 'BN1453_1', 42),
('1449', 1, 'BN1449_1', 43),
('1445', 1, 'SO1445_1', 44),
('1456', 1, 'SO1456_1', 46),
('SO1448', 1, 'SO1448_1', 47),
('1455', 1, 'B101', 48),
('1455', 2, 'A176', 49),
('1460', 1, 'B117', 50),
('1465', 1, 'A239', 51),
('1470', 1, 'B36-5112', 52),
('1471', 1, 'D80-5112', 53),
('1456', 1, 'SO1456_1/1', 54),
('1470', 1, '383-5112', 55),
('1477', 1, 'B66', 56),
('1328', 1, 'SO1328', 57),
('1462', 1, 'SO1462-1', 58),
('1462', 2, 'SO1462-2', 59);

-- --------------------------------------------------------

--
-- Table structure for table `bcshipped`
--

DROP TABLE IF EXISTS `bcshipped`;
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

DROP TABLE IF EXISTS `bcstock`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `bcstock`
--

INSERT INTO `bcstock` (`quantity`, `description`, `location`, `operation_number`, `date_in`, `date_out`, `batchno`, `product_code`, `Stock_ID`) VALUES
(0, 'square stock', 'SCC', 1, '2012-12-07 11:16:19', '2012-12-10 11:05:36', 'additional', 'XT4129-100.0M', 1),
(0, 'Square', 'AT stock', 1, '2012-12-07 11:45:29', '2012-12-07 11:46:34', 'additional', 'XT4102-100.0M', 2),
(39, 'NR', 'Round AT stock', 13, '2012-12-07 12:39:00', '0000-00-00 00:00:00', 'SO1445_1', 'XT4102-100.0M', 3),
(0, 'hhhhhhhhhhhhhhhhhhhhhhhh', 'sc square', 1, '2012-12-07 13:01:06', '2012-12-07 13:03:07', 'additional', 'XT3261-100.M', 4),
(10, '', 'SC Round bank', 1, '2012-12-10 10:58:24', '0000-00-00 00:00:00', 'BN0001', 'XT4129-100.0M', 5),
(0, '', 'at square', 3, '2012-12-12 13:27:03', '2012-12-12 13:28:03', 'additional', 'XT4132-23.995M', 6),
(86, 'LF', 'with lorie', 47, '2012-12-19 09:12:37', '0000-00-00 00:00:00', 'last build', 'XT3971-161.6667M', 10),
(0, 'LF', 'at cement', 22, '2012-12-19 09:14:49', '2012-12-19 09:58:44', 'last build', 'XT3971-161.6667M', 11),
(78, '', 'back to stock viewer', 22, '2012-12-20 12:46:13', '0000-00-00 00:00:00', 'B36-5112', 'XT3971-161.6667M', 13),
(0, 'rose', 'Additional', 13, '2012-12-21 13:27:06', '2012-12-21 13:30:37', 'B66', 'XT4135-150.0M', 14),
(0, '', '1', 3, '2013-01-07 13:53:58', '2013-01-07 14:02:43', 'B101', 'XT4015-3.2663M', 15);

-- --------------------------------------------------------

--
-- Table structure for table `bcstocklog`
--

DROP TABLE IF EXISTS `bcstocklog`;
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
(90, 'XT4129-100.0M', 1, 'dave.garvey', 'SCC', '2012-12-07 11:16:19', 'In', 'additional'),
(50, 'XT4102-100.0M', 1, 'dave.garvey', 'AT stock', '2012-12-07 11:45:29', 'In', 'additional'),
(50, 'XT4102-100.0M', 3, 'dave.garvey', 'AT stock', '2012-12-07 11:46:34', 'Out', 'SO1445_1'),
(39, 'XT4102-100.0M', 13, 'dave.garvey', 'Round AT stock', '2012-12-07 12:39:00', 'In', 'SO1445_1'),
(50, 'XT3261-100.M', 1, 'dave.garvey', 'sc square', '2012-12-07 13:01:06', 'In', 'additional'),
(50, 'XT3261-100.0M', 1, 'dave.garvey', 'sc square', '2012-12-07 13:03:07', 'Out', 'SO1448_1'),
(10, 'XT4129-100.0M', 1, 'Mark', 'SC Round bank', '2012-12-10 10:58:24', 'In', 'BN0001'),
(90, 'XT4129-100.0M', 1, 'Mark', 'SCC', '2012-12-10 11:05:36', 'Out', 'BN0001'),
(10, 'XT4132-23.995M', 3, 'rose.martin', 'at square', '2012-12-12 13:27:03', 'In', 'additional'),
(10, 'XT4132-23.995M', 3, 'rose.martin', 'at square', '2012-12-12 13:28:03', 'Out', 'BN1449_1'),
(86, 'XT3971-161.6667M', 47, 'lorie.fernandes', 'with lorie', '2012-12-19 09:12:37', 'In', 'last build'),
(78, 'XT3971-161.6667M', 22, 'lorie.fernandes', 'at cement', '2012-12-19 09:14:49', 'In', 'last build'),
(78, 'XT3971-161.6667M', 22, 'Mark', 'at cement', '2012-12-19 09:58:44', 'Out', 'B36-5112'),
(78, 'XT3971-161.6667M', 22, 'lorie.fernandes', 'back to stock viewer', '2012-12-20 12:46:13', 'In', 'B36-5112'),
(88, 'XT4135-150.0M', 13, 'rose.martin', 'Additional', '2012-12-21 13:27:06', 'In', 'B66'),
(86, 'XT4135-150.0M', 13, 'rose.martin', 'Additional', '2012-12-21 13:29:18', 'Out', 'B66'),
(2, 'XT4135-150.0M', 13, 'rose.martin', 'Additional', '2012-12-21 13:30:37', 'Out', 'B66'),
(65, 'XT4015-3.2663M', 3, 'rose.martin', '1', '2013-01-07 13:53:58', 'In', 'B101'),
(65, 'XT4015-3.2663M', 3, 'rose.martin', '1', '2013-01-07 14:02:43', 'Out', 'B101');

-- --------------------------------------------------------

--
-- Table structure for table `bcworksordertobatch`
--

DROP TABLE IF EXISTS `bcworksordertobatch`;
CREATE TABLE IF NOT EXISTS `bcworksordertobatch` (
  `worksorder` text NOT NULL,
  `batch` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `meta_table`
--

DROP TABLE IF EXISTS `meta_table`;
CREATE TABLE IF NOT EXISTS `meta_table` (
  `Table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
