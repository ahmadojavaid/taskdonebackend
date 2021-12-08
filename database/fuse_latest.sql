-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 03, 2018 at 01:01 PM
-- Server version: 5.7.21
-- PHP Version: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fuse`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cardId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `src` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

DROP TABLE IF EXISTS `boards`;
CREATE TABLE IF NOT EXISTS `boards` (
  `id` varchar(500) NOT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `boardData` longtext CHARACTER SET utf8mb4,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `createdBy`, `name`, `uri`, `boardData`, `created_at`, `updated_at`) VALUES
('699', 30, NULL, NULL, '{\"name\":\"Board for ahmad\",\"uri\":\"board-for-ahmad\",\"id\":699,\"settings\":{\"color\":\"\",\"subscribed\":true,\"cardCoverImages\":true},\"lists\":[{\"id\":\"2e1d03f9\",\"name\":\"List 1\",\"idCards\":[841]}],\"cards\":[{\"id\":841,\"name\":\"Card 444\",\"description\":\"Descriptoin here\",\"idAttachmentCover\":\"\",\"idMembers\":[29,31],\"idLabels\":[],\"attachments\":[],\"subscribed\":true,\"checklists\":[{\"id\":\"dbbccd4d\",\"name\":\"Checklist 1\",\"checkItemsChecked\":0,\"checkItems\":[{\"name\":\"Item 1\",\"checked\":false},{\"name\":\"Item 2\",\"checked\":false}]}],\"checkItems\":2,\"checkItemsChecked\":0,\"comments\":[{\"idMember\":\"36027j1930450d8bf7b10158\",\"message\":\"Comment here\",\"time\":\"now\"}],\"activities\":[],\"due\":\"2018-11-14T19:00:00.000Z\"}],\"members\":[{\"id\":18,\"name\":\"Abbott\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Abbott.jpg\"},{\"id\":20,\"name\":\"alice\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/alice.jpg\"},{\"id\":21,\"name\":\"andrew\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/andrew.jpg\"},{\"id\":22,\"name\":\"Arnold\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Arnold.jpg\"},{\"id\":23,\"name\":\"Barrera\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Barrera.jpg\"},{\"id\":24,\"name\":\"Blair\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Blair.jpg\"},{\"id\":25,\"name\":\"Boyle\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Boyle.jpg\"},{\"id\":26,\"name\":\"carl\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/carl.jpg\"},{\"id\":27,\"name\":\"Christy\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Christy.jpg\"},{\"id\":29,\"name\":\"Usama Bajwa\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Abbott.jpg\"},{\"id\":30,\"name\":\"Ahmad izhar\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Arnold.jpg\"},{\"id\":31,\"name\":\"Fahad\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Blair.jpg\"}],\"labels\":[{\"id\":\"56027e4119ad3a5dc28b36cd\",\"name\":\"Design\",\"color\":\"mat-red-500-bg\"},{\"id\":\"5640635e19ad3a5dc21416b2\",\"name\":\"App\",\"color\":\"mat-blue-500-bg\"},{\"id\":\"6540635g19ad3s5dc31412b2\",\"name\":\"Feature\",\"color\":\"mat-green-400-bg\"}],\"createdAt\":\"2018-10-29T14:16:04.029Z\"}', '2018-11-03 09:22:15', '2018-11-03 09:22:15'),
('889', 31, NULL, NULL, '{\"name\":\"Board from fahad for usama\",\"uri\":\"board-from-fahad-for-usama\",\"id\":889,\"settings\":{\"color\":\"\",\"subscribed\":true,\"cardCoverImages\":true},\"lists\":[{\"id\":\"2dba77d9\",\"name\":\"List 1\",\"idCards\":[992]}],\"cards\":[{\"id\":992,\"name\":\"card 1\",\"description\":\"Description here\",\"idAttachmentCover\":\"\",\"idMembers\":[30,29],\"idLabels\":[],\"attachments\":[],\"subscribed\":true,\"checklists\":[],\"checkItems\":0,\"checkItemsChecked\":0,\"comments\":[{\"idMember\":\"36027j1930450d8bf7b10158\",\"message\":\"Comment 2\",\"time\":\"now\"},{\"idMember\":\"36027j1930450d8bf7b10158\",\"message\":\"Comment here\",\"time\":\"now\"}],\"activities\":[],\"due\":\"2018-11-22T19:00:00.000Z\"}],\"members\":[{\"id\":18,\"name\":\"Abbott\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Abbott.jpg\"},{\"id\":20,\"name\":\"alice\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/alice.jpg\"},{\"id\":21,\"name\":\"andrew\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/andrew.jpg\"},{\"id\":22,\"name\":\"Arnold\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Arnold.jpg\"},{\"id\":23,\"name\":\"Barrera\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Barrera.jpg\"},{\"id\":24,\"name\":\"Blair\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Blair.jpg\"},{\"id\":25,\"name\":\"Boyle\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Boyle.jpg\"},{\"id\":26,\"name\":\"carl\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/carl.jpg\"},{\"id\":27,\"name\":\"Christy\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Christy.jpg\"},{\"id\":29,\"name\":\"Usama Bajwa\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Abbott.jpg\"},{\"id\":30,\"name\":\"Ahmad izhar\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Arnold.jpg\"},{\"id\":31,\"name\":\"Fahad\",\"avatar\":\"..\\/..\\/..\\/..\\/..\\/assets\\/images\\/avatars\\/Blair.jpg\"}],\"labels\":[{\"id\":\"56027e4119ad3a5dc28b36cd\",\"name\":\"Design\",\"color\":\"mat-red-500-bg\"},{\"id\":\"5640635e19ad3a5dc21416b2\",\"name\":\"App\",\"color\":\"mat-blue-500-bg\"},{\"id\":\"6540635g19ad3s5dc31412b2\",\"name\":\"Feature\",\"color\":\"mat-green-400-bg\"}],\"createdAt\":\"2018-10-29T14:12:26.622Z\"}', '2018-11-03 11:34:24', '2018-11-03 11:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_events`
--

DROP TABLE IF EXISTS `calendar_events`;
CREATE TABLE IF NOT EXISTS `calendar_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createdBy` int(11) NOT NULL,
  `calendarData` longtext NOT NULL,
  `members` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar_events`
--

INSERT INTO `calendar_events` (`id`, `createdBy`, `calendarData`, `members`, `created_at`, `updated_at`) VALUES
(1, 30, '{\"data\":[{\"start\":\"2018-11-22T19:00:00.000Z\",\"end\":\"2018-11-22T19:00:00.000Z\",\"title\":\"card 1\",\"allDay\":false,\"color\":{\"primary\":\"#1e90ff\",\"secondary\":\"#D1E8FF\"},\"resizable\":{\"beforeStart\":true,\"afterEnd\":true},\"draggable\":true,\"meta\":{\"location\":\"\",\"notes\":\"\"},\"members\":[30,29,\"31\"]}],\"members\":[]}', '[]', '2018-11-03 11:34:24', '2018-11-03 11:34:24'),
(2, 29, '{\"data\":[{\"start\":\"2018-11-22T19:00:00.000Z\",\"end\":\"2018-11-22T19:00:00.000Z\",\"title\":\"card 1\",\"allDay\":false,\"color\":{\"primary\":\"#1e90ff\",\"secondary\":\"#D1E8FF\"},\"resizable\":{\"beforeStart\":true,\"afterEnd\":true},\"draggable\":true,\"meta\":{\"location\":\"\",\"notes\":\"\"},\"members\":[30,29,\"31\"]}],\"members\":[]}', '[]', '2018-11-03 11:34:25', '2018-11-03 11:34:25'),
(3, 31, '{\"data\":[{\"start\":\"2018-11-22T19:00:00.000Z\",\"end\":\"2018-11-22T19:00:00.000Z\",\"title\":\"card 1\",\"allDay\":false,\"color\":{\"primary\":\"#1e90ff\",\"secondary\":\"#D1E8FF\"},\"resizable\":{\"beforeStart\":true,\"afterEnd\":true},\"draggable\":true,\"meta\":{\"location\":\"\",\"notes\":\"\"},\"members\":[30,29,\"31\"]}],\"members\":[]}', '[]', '2018-11-03 11:34:25', '2018-11-03 11:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `boardId` int(11) DEFAULT NULL,
  `listId` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `idAttachmentCover` varchar(1000) DEFAULT NULL,
  `due` varchar(5000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_Id` int(11) DEFAULT NULL,
  `categoryName` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `product_Id`, `categoryName`, `created_at`, `updated_at`) VALUES
(1, NULL, 'A', '2018-07-19 11:48:52', '2018-07-19 11:48:52'),
(2, NULL, 'B', '2018-07-19 11:48:56', '2018-07-19 11:48:56'),
(3, NULL, 'C', '2018-07-19 11:49:03', '2018-07-19 11:49:03'),
(4, NULL, 'D', '2018-07-19 11:49:08', '2018-07-19 11:49:08'),
(5, NULL, 'E', '2018-07-19 11:49:13', '2018-07-19 11:49:13'),
(6, NULL, 'F', '2018-07-19 11:49:20', '2018-07-19 11:49:20'),
(7, NULL, 'G', '2018-07-19 11:49:25', '2018-07-19 11:49:25'),
(8, NULL, 'H', '2018-07-19 11:49:29', '2018-07-19 11:49:29'),
(9, NULL, 'I', '2018-07-19 11:49:37', '2018-07-19 11:49:37'),
(10, NULL, 'J', '2018-07-19 11:49:49', '2018-07-19 11:49:49'),
(11, NULL, 'C', '2018-07-19 12:38:22', '2018-07-19 12:38:22'),
(12, NULL, 'C1', '2018-07-19 12:38:22', '2018-07-19 12:38:22'),
(13, NULL, 'Category name 1', '2018-07-21 11:52:47', '2018-07-21 11:52:47'),
(14, NULL, 'dsdsd', '2018-07-21 12:29:11', '2018-07-21 12:29:11');

-- --------------------------------------------------------

--
-- Table structure for table `checkitems`
--

DROP TABLE IF EXISTS `checkitems`;
CREATE TABLE IF NOT EXISTS `checkitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `checklists`
--

DROP TABLE IF EXISTS `checklists`;
CREATE TABLE IF NOT EXISTS `checklists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cardId` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `checkItemsChecked` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cardId` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `attachemnt` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `jobTitle` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `invoiceAddress` varchar(50) DEFAULT NULL,
  `invoicelat` varchar(50) DEFAULT NULL,
  `invoicelng` varchar(50) DEFAULT NULL,
  `shippingAddress` varchar(50) DEFAULT NULL,
  `shippinglat` varchar(50) DEFAULT NULL,
  `shippinglng` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `filters`
--

DROP TABLE IF EXISTS `filters`;
CREATE TABLE IF NOT EXISTS `filters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `handle` longtext,
  `title` longtext,
  `icon` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `filters`
--

INSERT INTO `filters` (`id`, `handle`, `title`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'starred', 'Starred', 'star', NULL, NULL),
(2, 'important', 'Priority', 'error', NULL, NULL),
(4, 'dueDate', 'Sheduled', 'schedule', NULL, NULL),
(5, 'today', 'Today', 'today', NULL, NULL),
(6, 'completed', 'Done', 'check', NULL, NULL),
(7, 'deleted', 'Deleted', 'delete', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

DROP TABLE IF EXISTS `labels`;
CREATE TABLE IF NOT EXISTS `labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `cardId` int(11) DEFAULT NULL,
  `boardId` int(11) DEFAULT NULL,
  `listId` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

DROP TABLE IF EXISTS `lists`;
CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `boardId` varchar(500) DEFAULT NULL,
  `memberId` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_cards`
--

DROP TABLE IF EXISTS `list_cards`;
CREATE TABLE IF NOT EXISTS `list_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listId` varchar(500) NOT NULL,
  `boardId` varchar(500) NOT NULL,
  `cardId` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_labels`
--

DROP TABLE IF EXISTS `list_labels`;
CREATE TABLE IF NOT EXISTS `list_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listId` int(11) NOT NULL,
  `boardId` int(11) NOT NULL,
  `idLabels` varchar(5000) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_members`
--

DROP TABLE IF EXISTS `list_members`;
CREATE TABLE IF NOT EXISTS `list_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listId` int(11) DEFAULT NULL,
  `boardId` int(11) DEFAULT NULL,
  `cardId` varchar(5000) DEFAULT NULL,
  `idMembers` varchar(50000) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `boardId` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `boardId`, `name`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 511, 'Alice Freeman', 'assets/images/avatars/alice.jpg', '2018-09-27 13:22:42', '2018-09-27 13:22:42'),
(2, 511, 'Danielle Obrien', 'assets/images/avatars/danielle.jpg', '2018-09-27 13:22:42', '2018-09-27 13:22:42'),
(3, 511, 'James Lewis', 'assets/images/avatars/james.jpg', '2018-09-27 13:22:42', '2018-09-27 13:22:42'),
(4, 511, 'Vincent Munoz', 'assets/images/avatars/vincent.jpg', '2018-09-27 13:22:42', '2018-09-27 13:22:42'),
(5, 511, 'Alice Freeman', 'assets/images/avatars/alice.jpg', '2018-09-27 13:22:57', '2018-09-27 13:22:57'),
(6, 511, 'Danielle Obrien', 'assets/images/avatars/danielle.jpg', '2018-09-27 13:22:57', '2018-09-27 13:22:57'),
(7, 511, 'James Lewis', 'assets/images/avatars/james.jpg', '2018-09-27 13:22:57', '2018-09-27 13:22:57'),
(8, 511, 'Vincent Munoz', 'assets/images/avatars/vincent.jpg', '2018-09-27 13:22:57', '2018-09-27 13:22:57'),
(9, 511, 'Alice Freeman', 'assets/images/avatars/alice.jpg', '2018-09-27 13:23:02', '2018-09-27 13:23:02'),
(10, 511, 'Danielle Obrien', 'assets/images/avatars/danielle.jpg', '2018-09-27 13:23:02', '2018-09-27 13:23:02'),
(11, 511, 'James Lewis', 'assets/images/avatars/james.jpg', '2018-09-27 13:23:02', '2018-09-27 13:23:02'),
(12, 511, 'Vincent Munoz', 'assets/images/avatars/vincent.jpg', '2018-09-27 13:23:03', '2018-09-27 13:23:03'),
(13, 511, 'Alice Freeman', 'assets/images/avatars/alice.jpg', '2018-09-27 13:23:07', '2018-09-27 13:23:07'),
(14, 511, 'Danielle Obrien', 'assets/images/avatars/danielle.jpg', '2018-09-27 13:23:07', '2018-09-27 13:23:07'),
(15, 511, 'James Lewis', 'assets/images/avatars/james.jpg', '2018-09-27 13:23:07', '2018-09-27 13:23:07'),
(16, 511, 'Vincent Munoz', 'assets/images/avatars/vincent.jpg', '2018-09-27 13:23:07', '2018-09-27 13:23:07'),
(17, 511, 'Alice Freeman', 'assets/images/avatars/alice.jpg', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(18, 511, 'Danielle Obrien', 'assets/images/avatars/danielle.jpg', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(19, 511, 'James Lewis', 'assets/images/avatars/james.jpg', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(20, 511, 'Vincent Munoz', 'assets/images/avatars/vincent.jpg', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(21, 10, 'Alice Freeman', 'assets/images/avatars/alice.jpg', '2018-10-05 10:18:36', '2018-10-05 10:18:36'),
(22, 10, 'Danielle Obrien', 'assets/images/avatars/danielle.jpg', '2018-10-05 10:18:36', '2018-10-05 10:18:36'),
(23, 10, 'James Lewis', 'assets/images/avatars/james.jpg', '2018-10-05 10:18:36', '2018-10-05 10:18:36'),
(24, 10, 'Vincent Munoz', 'assets/images/avatars/vincent.jpg', '2018-10-05 10:18:36', '2018-10-05 10:18:36'),
(25, 480, 'Alice Freeman', 'assets/images/avatars/alice.jpg', '2018-10-05 10:18:40', '2018-10-05 10:18:40'),
(26, 480, 'Danielle Obrien', 'assets/images/avatars/danielle.jpg', '2018-10-05 10:18:40', '2018-10-05 10:18:40'),
(27, 480, 'James Lewis', 'assets/images/avatars/james.jpg', '2018-10-05 10:18:40', '2018-10-05 10:18:40'),
(28, 480, 'Vincent Munoz', 'assets/images/avatars/vincent.jpg', '2018-10-05 10:18:40', '2018-10-05 10:18:40');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_Id` int(11) NOT NULL,
  `products_Id` int(11) NOT NULL,
  `reference` varchar(110) DEFAULT NULL,
  `subtotal` varchar(110) DEFAULT NULL,
  `tax` varchar(1000) DEFAULT NULL,
  `discount` varchar(110) DEFAULT NULL,
  `total` varchar(110) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `statuses_id` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_Id` int(11) NOT NULL,
  `transactionId` varchar(100) DEFAULT NULL,
  `amount` varchar(1000) DEFAULT NULL,
  `method` varchar(110) DEFAULT NULL,
  `date` varchar(110) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_Id` int(11) DEFAULT NULL,
  `categories` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `handle` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `priceTaxExcl` varchar(100) DEFAULT NULL,
  `priceTaxIncl` varchar(100) DEFAULT NULL,
  `taxRate` varchar(100) DEFAULT NULL,
  `comparedPrice` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `width` varchar(100) DEFAULT NULL,
  `height` varchar(100) DEFAULT NULL,
  `depth` varchar(100) DEFAULT NULL,
  `weight` varchar(100) DEFAULT NULL,
  `extraShippingFee` varchar(100) DEFAULT NULL,
  `active` varchar(11) DEFAULT 'false',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `productCategory` (`categories_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_attachements`
--

DROP TABLE IF EXISTS `product_attachements`;
CREATE TABLE IF NOT EXISTS `product_attachements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `url` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `boardId` varchar(500) NOT NULL,
  `subscribed` tinyint(1) DEFAULT NULL,
  `color` varchar(500) NOT NULL,
  `cardCoverImages` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1181 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `boardId`, `subscribed`, `color`, `cardCoverImages`, `created_at`, `updated_at`) VALUES
(49, '328', 1, '', '1', '2018-09-19 10:17:31', '2018-09-19 10:17:31'),
(50, '328', 1, '', '1', '2018-09-19 10:17:31', '2018-09-19 10:17:31'),
(51, '328', 1, '', '1', '2018-09-19 10:17:31', '2018-09-19 10:17:31'),
(52, '328', 1, '', '1', '2018-09-19 10:17:31', '2018-09-19 10:17:31'),
(53, '328', 1, '', '1', '2018-09-19 10:17:31', '2018-09-19 10:17:31'),
(54, '328', 1, '', '1', '2018-09-19 10:17:31', '2018-09-19 10:17:31'),
(55, '328', 1, '', '1', '2018-09-19 10:17:31', '2018-09-19 10:17:31'),
(56, '214', 1, '', '1', '2018-09-19 10:20:45', '2018-09-19 10:20:45'),
(57, '214', 1, '', '1', '2018-09-19 10:20:45', '2018-09-19 10:20:45'),
(58, '214', 1, '', '1', '2018-09-19 10:20:45', '2018-09-19 10:20:45'),
(111, '556', 1, '', '1', '2018-09-27 05:17:19', '2018-09-27 05:17:19'),
(112, '556', 1, '', '1', '2018-09-27 05:17:19', '2018-09-27 05:17:19'),
(113, '556', 1, '', '1', '2018-09-27 05:17:19', '2018-09-27 05:17:19'),
(114, '556', 1, '', '1', '2018-09-27 05:17:19', '2018-09-27 05:17:19'),
(115, '556', 1, '', '1', '2018-09-27 05:17:19', '2018-09-27 05:17:19'),
(116, '556', 1, '', '1', '2018-09-27 05:17:19', '2018-09-27 05:17:19'),
(117, '556', 1, '', '1', '2018-09-27 05:17:19', '2018-09-27 05:17:19'),
(118, '690', 1, '', '1', '2018-09-27 05:28:40', '2018-09-27 05:28:40'),
(119, '690', 1, '', '1', '2018-09-27 05:28:40', '2018-09-27 05:28:40'),
(120, '690', 1, '', '1', '2018-09-27 05:28:40', '2018-09-27 05:28:40'),
(121, '319', 1, '', '1', '2018-09-27 05:34:18', '2018-09-27 05:34:18'),
(122, '319', 1, '', '1', '2018-09-27 05:34:18', '2018-09-27 05:34:18'),
(123, '319', 1, '', '1', '2018-09-27 05:34:18', '2018-09-27 05:34:18'),
(124, '69', 1, '', '1', '2018-09-27 05:40:24', '2018-09-27 05:40:24'),
(125, '69', 1, '', '1', '2018-09-27 05:40:24', '2018-09-27 05:40:24'),
(126, '69', 1, '', '1', '2018-09-27 05:40:24', '2018-09-27 05:40:24'),
(127, '4', 1, '', '1', '2018-09-27 05:40:39', '2018-09-27 05:40:39'),
(128, '4', 1, '', '1', '2018-09-27 05:40:39', '2018-09-27 05:40:39'),
(129, '4', 1, '', '1', '2018-09-27 05:40:39', '2018-09-27 05:40:39'),
(130, '11', 1, '', '1', '2018-09-27 05:41:36', '2018-09-27 05:41:36'),
(131, '11', 1, '', '1', '2018-09-27 05:41:36', '2018-09-27 05:41:36'),
(132, '11', 1, '', '1', '2018-09-27 05:41:36', '2018-09-27 05:41:36'),
(133, '595', 1, '', '1', '2018-09-27 05:42:52', '2018-09-27 05:42:52'),
(134, '595', 1, '', '1', '2018-09-27 05:42:52', '2018-09-27 05:42:52'),
(135, '595', 1, '', '1', '2018-09-27 05:42:52', '2018-09-27 05:42:52'),
(148, '209', 1, '', '1', '2018-09-27 06:33:09', '2018-09-27 06:33:09'),
(149, '209', 1, '', '1', '2018-09-27 06:33:09', '2018-09-27 06:33:09'),
(150, '209', 1, '', '1', '2018-09-27 06:33:09', '2018-09-27 06:33:09'),
(168, '519', 1, '', '1', '2018-09-27 06:34:51', '2018-09-27 06:34:51'),
(169, '519', 1, '', '1', '2018-09-27 06:34:51', '2018-09-27 06:34:51'),
(170, '519', 1, '', '1', '2018-09-27 06:34:51', '2018-09-27 06:34:51'),
(171, '519', 1, '', '1', '2018-09-27 06:34:51', '2018-09-27 06:34:51'),
(172, '519', 1, '', '1', '2018-09-27 06:34:51', '2018-09-27 06:34:51'),
(173, '519', 1, '', '1', '2018-09-27 06:34:51', '2018-09-27 06:34:51'),
(174, '519', 1, '', '1', '2018-09-27 06:34:51', '2018-09-27 06:34:51'),
(199, '311', 1, '', '1', '2018-09-27 06:43:20', '2018-09-27 06:43:20'),
(200, '311', 1, '', '1', '2018-09-27 06:43:20', '2018-09-27 06:43:20'),
(201, '311', 1, '', '1', '2018-09-27 06:43:20', '2018-09-27 06:43:20'),
(202, '311', 1, '', '1', '2018-09-27 06:43:20', '2018-09-27 06:43:20'),
(203, '311', 1, '', '1', '2018-09-27 06:43:20', '2018-09-27 06:43:20'),
(204, '311', 1, '', '1', '2018-09-27 06:43:20', '2018-09-27 06:43:20'),
(205, '311', 1, '', '1', '2018-09-27 06:43:20', '2018-09-27 06:43:20'),
(233, '803', 1, '', '1', '2018-09-27 06:53:33', '2018-09-27 06:53:33'),
(234, '803', 1, '', '1', '2018-09-27 06:53:33', '2018-09-27 06:53:33'),
(235, '803', 1, '', '1', '2018-09-27 06:53:33', '2018-09-27 06:53:33'),
(236, '803', 1, '', '1', '2018-09-27 06:53:33', '2018-09-27 06:53:33'),
(237, '803', 1, '', '1', '2018-09-27 06:53:33', '2018-09-27 06:53:33'),
(238, '803', 1, '', '1', '2018-09-27 06:53:33', '2018-09-27 06:53:33'),
(239, '803', 1, '', '1', '2018-09-27 06:53:33', '2018-09-27 06:53:33'),
(257, '344', 1, '', '1', '2018-09-27 06:54:59', '2018-09-27 06:54:59'),
(258, '344', 1, '', '1', '2018-09-27 06:54:59', '2018-09-27 06:54:59'),
(259, '344', 1, '', '1', '2018-09-27 06:54:59', '2018-09-27 06:54:59'),
(260, '344', 1, '', '1', '2018-09-27 06:54:59', '2018-09-27 06:54:59'),
(261, '344', 1, '', '1', '2018-09-27 06:54:59', '2018-09-27 06:54:59'),
(262, '344', 1, '', '1', '2018-09-27 06:54:59', '2018-09-27 06:54:59'),
(263, '344', 1, '', '1', '2018-09-27 06:54:59', '2018-09-27 06:54:59'),
(399, '503', 1, '', '1', '2018-09-27 09:01:11', '2018-09-27 09:01:11'),
(400, '503', 1, '', '1', '2018-09-27 09:01:11', '2018-09-27 09:01:11'),
(401, '503', 1, '', '1', '2018-09-27 09:01:11', '2018-09-27 09:01:11'),
(430, '341', 1, '', '1', '2018-09-27 09:05:13', '2018-09-27 09:05:13'),
(431, '341', 1, '', '1', '2018-09-27 09:05:13', '2018-09-27 09:05:13'),
(432, '341', 1, '', '1', '2018-09-27 09:05:13', '2018-09-27 09:05:13'),
(433, '341', 1, '', '1', '2018-09-27 09:05:13', '2018-09-27 09:05:13'),
(434, '341', 1, '', '1', '2018-09-27 09:05:13', '2018-09-27 09:05:13'),
(435, '341', 1, '', '1', '2018-09-27 09:05:13', '2018-09-27 09:05:13'),
(436, '341', 1, '', '1', '2018-09-27 09:05:13', '2018-09-27 09:05:13'),
(499, '726', 1, '', '1', '2018-09-27 10:40:44', '2018-09-27 10:40:44'),
(500, '726', 1, '', '1', '2018-09-27 10:40:44', '2018-09-27 10:40:44'),
(501, '726', 1, '', '1', '2018-09-27 10:40:44', '2018-09-27 10:40:44'),
(502, '726', 1, '', '1', '2018-09-27 10:40:44', '2018-09-27 10:40:44'),
(503, '726', 1, '', '1', '2018-09-27 10:40:44', '2018-09-27 10:40:44'),
(504, '726', 1, '', '1', '2018-09-27 10:40:44', '2018-09-27 10:40:44'),
(505, '726', 1, '', '1', '2018-09-27 10:40:44', '2018-09-27 10:40:44'),
(841, '921', 1, '', '1', '2018-09-27 10:55:35', '2018-09-27 10:55:35'),
(842, '921', 1, '', '1', '2018-09-27 10:55:35', '2018-09-27 10:55:35'),
(843, '921', 1, '', '1', '2018-09-27 10:55:35', '2018-09-27 10:55:35'),
(844, '921', 1, '', '1', '2018-09-27 10:55:35', '2018-09-27 10:55:35'),
(845, '921', 1, '', '1', '2018-09-27 10:55:35', '2018-09-27 10:55:35'),
(846, '921', 1, '', '1', '2018-09-27 10:55:35', '2018-09-27 10:55:35'),
(847, '921', 1, '', '1', '2018-09-27 10:55:35', '2018-09-27 10:55:35'),
(925, '836', 1, '', '1', '2018-09-27 10:59:05', '2018-09-27 10:59:05'),
(926, '836', 1, '', '1', '2018-09-27 10:59:05', '2018-09-27 10:59:05'),
(927, '836', 1, '', '1', '2018-09-27 10:59:05', '2018-09-27 10:59:05'),
(928, '836', 1, '', '1', '2018-09-27 10:59:05', '2018-09-27 10:59:05'),
(929, '836', 1, '', '1', '2018-09-27 10:59:05', '2018-09-27 10:59:05'),
(930, '836', 1, '', '1', '2018-09-27 10:59:05', '2018-09-27 10:59:05'),
(931, '836', 1, '', '1', '2018-09-27 10:59:05', '2018-09-27 10:59:05'),
(935, '766', 1, '', '1', '2018-09-27 11:48:14', '2018-09-27 11:48:14'),
(936, '766', 1, '', '1', '2018-09-27 11:48:14', '2018-09-27 11:48:14'),
(937, '766', 1, '', '1', '2018-09-27 11:48:14', '2018-09-27 11:48:14'),
(965, '42', 1, '', '1', '2018-09-27 12:04:16', '2018-09-27 12:04:16'),
(966, '42', 1, '', '1', '2018-09-27 12:04:16', '2018-09-27 12:04:16'),
(967, '42', 1, '', '1', '2018-09-27 12:04:16', '2018-09-27 12:04:16'),
(968, '42', 1, '', '1', '2018-09-27 12:04:16', '2018-09-27 12:04:16'),
(969, '42', 1, '', '1', '2018-09-27 12:04:16', '2018-09-27 12:04:16'),
(970, '42', 1, '', '1', '2018-09-27 12:04:16', '2018-09-27 12:04:16'),
(971, '42', 1, '', '1', '2018-09-27 12:04:16', '2018-09-27 12:04:16'),
(972, '491', 1, '', '1', '2018-09-27 12:06:12', '2018-09-27 12:06:12'),
(973, '491', 1, '', '1', '2018-09-27 12:06:12', '2018-09-27 12:06:12'),
(974, '491', 1, '', '1', '2018-09-27 12:06:12', '2018-09-27 12:06:12'),
(975, '914', 1, '', '1', '2018-09-27 12:06:12', '2018-09-27 12:06:12'),
(976, '914', 1, '', '1', '2018-09-27 12:06:12', '2018-09-27 12:06:12'),
(977, '914', 1, '', '1', '2018-09-27 12:06:12', '2018-09-27 12:06:12'),
(978, '648', 1, '', '1', '2018-09-27 12:06:13', '2018-09-27 12:06:13'),
(979, '648', 1, '', '1', '2018-09-27 12:06:13', '2018-09-27 12:06:13'),
(980, '648', 1, '', '1', '2018-09-27 12:06:13', '2018-09-27 12:06:13'),
(981, '847', 1, '', '1', '2018-09-27 12:06:14', '2018-09-27 12:06:14'),
(982, '847', 1, '', '1', '2018-09-27 12:06:14', '2018-09-27 12:06:14'),
(983, '847', 1, '', '1', '2018-09-27 12:06:14', '2018-09-27 12:06:14'),
(984, '390', 1, '', '1', '2018-09-27 12:06:14', '2018-09-27 12:06:14'),
(985, '390', 1, '', '1', '2018-09-27 12:06:14', '2018-09-27 12:06:14'),
(986, '390', 1, '', '1', '2018-09-27 12:06:14', '2018-09-27 12:06:14'),
(987, '592', 1, '', '1', '2018-09-27 12:06:14', '2018-09-27 12:06:14'),
(988, '592', 1, '', '1', '2018-09-27 12:06:14', '2018-09-27 12:06:14'),
(989, '592', 1, '', '1', '2018-09-27 12:06:14', '2018-09-27 12:06:14'),
(1000, '501', 1, '', '1', '2018-09-27 12:06:35', '2018-09-27 12:06:35'),
(1001, '501', 1, '', '1', '2018-09-27 12:06:35', '2018-09-27 12:06:35'),
(1002, '501', 1, '', '1', '2018-09-27 12:06:35', '2018-09-27 12:06:35'),
(1003, '501', 1, '', '1', '2018-09-27 12:06:35', '2018-09-27 12:06:35'),
(1004, '501', 1, '', '1', '2018-09-27 12:06:35', '2018-09-27 12:06:35'),
(1005, '501', 1, '', '1', '2018-09-27 12:06:35', '2018-09-27 12:06:35'),
(1006, '501', 1, '', '1', '2018-09-27 12:06:35', '2018-09-27 12:06:35'),
(1013, '993', 1, '', '1', '2018-09-27 12:55:26', '2018-09-27 12:55:26'),
(1014, '993', 1, '', '1', '2018-09-27 12:55:26', '2018-09-27 12:55:26'),
(1015, '993', 1, '', '1', '2018-09-27 12:55:26', '2018-09-27 12:55:26'),
(1016, '993', 1, '', '1', '2018-09-27 12:55:26', '2018-09-27 12:55:26'),
(1017, '993', 1, '', '1', '2018-09-27 12:55:26', '2018-09-27 12:55:26'),
(1018, '993', 1, '', '1', '2018-09-27 12:55:26', '2018-09-27 12:55:26'),
(1019, '993', 1, '', '1', '2018-09-27 12:55:26', '2018-09-27 12:55:26'),
(1023, '666', 1, '', '1', '2018-09-27 13:01:39', '2018-09-27 13:01:39'),
(1024, '666', 1, '', '1', '2018-09-27 13:01:39', '2018-09-27 13:01:39'),
(1025, '666', 1, '', '1', '2018-09-27 13:01:39', '2018-09-27 13:01:39'),
(1026, '162', 1, '', '1', '2018-09-27 13:01:42', '2018-09-27 13:01:42'),
(1027, '162', 1, '', '1', '2018-09-27 13:01:42', '2018-09-27 13:01:42'),
(1028, '162', 1, '', '1', '2018-09-27 13:01:42', '2018-09-27 13:01:42'),
(1039, '609', 1, '', '1', '2018-09-27 13:02:02', '2018-09-27 13:02:02'),
(1040, '609', 1, '', '1', '2018-09-27 13:02:02', '2018-09-27 13:02:02'),
(1041, '609', 1, '', '1', '2018-09-27 13:02:02', '2018-09-27 13:02:02'),
(1042, '609', 1, '', '1', '2018-09-27 13:02:02', '2018-09-27 13:02:02'),
(1043, '609', 1, '', '1', '2018-09-27 13:02:02', '2018-09-27 13:02:02'),
(1044, '609', 1, '', '1', '2018-09-27 13:02:02', '2018-09-27 13:02:02'),
(1045, '609', 1, '', '1', '2018-09-27 13:02:02', '2018-09-27 13:02:02'),
(1046, '593', 1, '', '1', '2018-09-27 13:03:24', '2018-09-27 13:03:24'),
(1047, '593', 1, '', '1', '2018-09-27 13:03:24', '2018-09-27 13:03:24'),
(1048, '593', 1, '', '1', '2018-09-27 13:03:24', '2018-09-27 13:03:24'),
(1052, '590', 1, '', '1', '2018-09-27 13:03:36', '2018-09-27 13:03:36'),
(1053, '590', 1, '', '1', '2018-09-27 13:03:36', '2018-09-27 13:03:36'),
(1054, '590', 1, '', '1', '2018-09-27 13:03:36', '2018-09-27 13:03:36'),
(1055, '590', 1, '', '1', '2018-09-27 13:03:36', '2018-09-27 13:03:36'),
(1056, '590', 1, '', '1', '2018-09-27 13:03:36', '2018-09-27 13:03:36'),
(1057, '590', 1, '', '1', '2018-09-27 13:03:36', '2018-09-27 13:03:36'),
(1058, '590', 1, '', '1', '2018-09-27 13:03:36', '2018-09-27 13:03:36'),
(1059, '931', 1, '', '1', '2018-09-27 13:06:30', '2018-09-27 13:06:30'),
(1060, '931', 1, '', '1', '2018-09-27 13:06:30', '2018-09-27 13:06:30'),
(1061, '931', 1, '', '1', '2018-09-27 13:06:30', '2018-09-27 13:06:30'),
(1062, '557', 1, '', '1', '2018-09-27 13:06:32', '2018-09-27 13:06:32'),
(1063, '557', 1, '', '1', '2018-09-27 13:06:32', '2018-09-27 13:06:32'),
(1064, '557', 1, '', '1', '2018-09-27 13:06:32', '2018-09-27 13:06:32'),
(1075, '985', 1, '', '1', '2018-09-27 13:06:43', '2018-09-27 13:06:43'),
(1076, '985', 1, '', '1', '2018-09-27 13:06:43', '2018-09-27 13:06:43'),
(1077, '985', 1, '', '1', '2018-09-27 13:06:43', '2018-09-27 13:06:43'),
(1078, '985', 1, '', '1', '2018-09-27 13:06:43', '2018-09-27 13:06:43'),
(1079, '985', 1, '', '1', '2018-09-27 13:06:43', '2018-09-27 13:06:43'),
(1080, '985', 1, '', '1', '2018-09-27 13:06:43', '2018-09-27 13:06:43'),
(1081, '985', 1, '', '1', '2018-09-27 13:06:43', '2018-09-27 13:06:43'),
(1082, '583', 0, 'fuse-dark', '1', '2018-09-27 13:10:05', '2018-09-27 13:10:05'),
(1083, '583', 0, 'fuse-dark', '1', '2018-09-27 13:10:05', '2018-09-27 13:10:05'),
(1084, '583', 0, 'fuse-dark', '1', '2018-09-27 13:10:05', '2018-09-27 13:10:05'),
(1137, '186', 1, '', '1', '2018-09-27 13:14:46', '2018-09-27 13:14:46'),
(1138, '186', 1, '', '1', '2018-09-27 13:14:46', '2018-09-27 13:14:46'),
(1139, '186', 1, '', '1', '2018-09-27 13:14:46', '2018-09-27 13:14:46'),
(1140, '186', 1, '', '1', '2018-09-27 13:14:46', '2018-09-27 13:14:46'),
(1141, '186', 1, '', '1', '2018-09-27 13:14:46', '2018-09-27 13:14:46'),
(1142, '186', 1, '', '1', '2018-09-27 13:14:46', '2018-09-27 13:14:46'),
(1143, '186', 1, '', '1', '2018-09-27 13:14:46', '2018-09-27 13:14:46'),
(1168, '511', 1, '', '1', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(1169, '511', 1, '', '1', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(1170, '511', 1, '', '1', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(1171, '511', 1, '', '1', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(1172, '511', 1, '', '1', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(1173, '511', 1, '', '1', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(1174, '511', 1, '', '1', '2018-09-27 13:23:10', '2018-09-27 13:23:10'),
(1175, '10', 1, '', '1', '2018-10-05 10:18:36', '2018-10-05 10:18:36'),
(1176, '10', 1, '', '1', '2018-10-05 10:18:36', '2018-10-05 10:18:36'),
(1177, '10', 1, '', '1', '2018-10-05 10:18:36', '2018-10-05 10:18:36'),
(1178, '480', 1, '', '1', '2018-10-05 10:18:40', '2018-10-05 10:18:40'),
(1179, '480', 1, '', '1', '2018-10-05 10:18:40', '2018-10-05 10:18:40'),
(1180, '480', 1, '', '1', '2018-10-05 10:18:40', '2018-10-05 10:18:40');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_details`
--

DROP TABLE IF EXISTS `shipping_details`;
CREATE TABLE IF NOT EXISTS `shipping_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_Id` int(11) NOT NULL,
  `tracking` varchar(255) DEFAULT NULL,
  `carrier` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'created',
  `colour` varchar(100) NOT NULL DEFAULT 'mat-purple-300-bg',
  `order_reference` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `colour`, `order_reference`, `created_at`, `updated_at`) VALUES
(1, 'Awaiting check payment', 'mat-blue-500-bg', '', '2018-07-21 07:06:20', '2018-07-21 07:06:20'),
(2, 'Payment accepted', 'mat-green-500-bg', '', '2018-07-21 07:06:20', '2018-07-21 07:06:20'),
(3, 'Preparing the order', 'mat-orange-500-bg', '', '2018-07-21 07:07:15', '2018-07-21 07:07:15'),
(4, 'Shipped', 'mat-purple-500-bg', '', '2018-07-21 07:07:15', '2018-07-21 07:07:15'),
(5, 'Delivered', 'mat-purple-300-bgmat-green-800-bg', '', '2018-07-21 07:06:20', '2018-07-21 07:06:20'),
(6, 'Canceled', 'mat-pink-500-bg', '', '2018-07-21 07:06:20', '2018-07-21 07:06:20'),
(7, 'Refunded', 'mat-red-500-bg', '', '2018-07-21 07:07:15', '2018-07-21 07:07:15'),
(8, 'Payment error', 'mat-red-900-bg', '', '2018-07-21 07:07:15', '2018-07-21 07:07:15'),
(9, 'On pre-order (paid)', 'mat-purple-300-bg', '', '2018-07-21 07:07:15', '2018-07-21 07:07:15'),
(10, 'Awaiting bank wire payment', 'mat-blue-500-bg', '', '2018-07-21 07:07:15', '2018-07-21 07:07:15'),
(11, 'Awaiting PayPal payment', 'mat-blue-500-bg', '', '2018-07-21 07:06:20', '2018-07-21 07:06:20'),
(12, 'Remote payment accepted', 'mat-green-500-bg', '', '2018-07-21 07:06:20', '2018-07-21 07:06:20'),
(13, 'On pre-order (not paid)', 'mat-purple-300-bg', '', '2018-07-21 07:07:15', '2018-07-21 07:07:15'),
(14, 'Awaiting Cash-on-delivery payment', 'mat-blue-500-bg', '', '2018-07-21 07:07:15', '2018-07-21 07:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `handle` longtext,
  `title` longtext,
  `color` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `handle`, `title`, `color`, `created_at`, `updated_at`) VALUES
(1, 'frontend', 'Frontend', '#388E3C', '2018-10-17 06:53:04', '2018-10-17 06:53:04'),
(2, 'api', 'API', '#FF9800', '2018-10-17 06:53:46', '2018-10-17 06:53:46'),
(3, 'issue', 'Issue', '#0091EA', '2018-10-17 06:53:46', '2018-10-17 06:53:46'),
(4, 'mobile', 'Mobile', '#9C27B0', '2018-10-17 06:54:09', '2018-10-17 06:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

DROP TABLE IF EXISTS `todos`;
CREATE TABLE IF NOT EXISTS `todos` (
  `id` longtext NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `title` varchar(10000) DEFAULT NULL,
  `notes` varchar(10000) DEFAULT NULL,
  `startDate` varchar(10000) DEFAULT NULL,
  `dueDate` varchar(10000) DEFAULT NULL,
  `completed` tinyint(4) DEFAULT NULL,
  `starred` tinyint(4) DEFAULT NULL,
  `important` tinyint(4) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `tags` varchar(1000) DEFAULT NULL,
  `members` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`id`, `userId`, `title`, `notes`, `startDate`, `dueDate`, `completed`, `starred`, `important`, `deleted`, `tags`, `members`, `created_at`, `updated_at`) VALUES
('ef87417b', 29, 'Task 1 for Ahmad and Fahad', 'Notes here', '2018-10-30T19:00:00.000Z', '2018-11-13T19:00:00.000Z', 0, 0, 0, 0, '[]', 'null', '2018-10-31 08:52:15', '2018-10-31 08:52:15'),
('bf382961', 30, 'A new todo For Fahad', 'Notes here', '2018-10-30T19:00:00.000Z', '2018-11-13T19:00:00.000Z', 0, 0, 0, 0, '[]', '[31]', '2018-10-31 08:55:42', '2018-10-31 08:55:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `fullName` varchar(110) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(500) DEFAULT NULL,
  `account_status` int(11) DEFAULT '0',
  `avatar` varchar(1000) DEFAULT NULL,
  `phone` varchar(1000) DEFAULT NULL,
  `jobTitle` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `fullName`, `password`, `token`, `account_status`, `avatar`, `phone`, `jobTitle`, `created_at`, `updated_at`) VALUES
(18, 'usama3@pay-mon.com', 'Abbott', '$2y$10$6wNpoeU4MI4rrLDNp7GU1.4C8cpGg7CghPXfKCbgp2DBTSqlFEAPy', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC83N2UxMmZmZS5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTUzMzIwMDUwMCwiZXhwIjoxNTMzMjA0MTAwLCJuYmYiOjE1MzMyMDA1MDAsImp0aSI6InBqcWRBbkJ1OVVBZnNNY20iLCJzdWIiOjE4LCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.qAxSnl8wrDXdFbsazfv1bZy--Wmg3L3wCUErlqnUnEc', 1, '../../../../../assets/images/avatars/Abbott.jpg', '090078601', ' Developer', '2018-08-02 04:00:55', '2018-08-02 04:00:55'),
(20, 'abcccaaaaa@pay-mon.com', 'alice', '$2y$10$qn31utRPagrHu.Kq3D/WT.V.9Z6ypinchqQb/hkgmvrVO52ym0ZIW', 'c474af9552af1775a39eefa23ace6d528df8d5ca27bc83ad48', 0, '../../../../../assets/images/avatars/alice.jpg', '090078601', ' Developer', '2018-08-02 05:42:58', '2018-08-02 05:42:58'),
(21, 'abccc@pay-mon.com', 'andrew', '$2y$10$Y4rQsBuG5VPzV8us5IuMO.UhR/khRuzuT/Kn7h0MI8XMOZRe1Jh7i', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xZTA1NDBkMy5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTUzMzI5OTI5MywiZXhwIjoxNTMzMzAyODkzLCJuYmYiOjE1MzMyOTkyOTMsImp0aSI6Im5heDh4TUVxUGl4Vkliam0iLCJzdWIiOjIxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.SMYyRWWfp3XOf3sXl7LWaNoOyeqKUkZEUxj3aCLRUy8', 1, '../../../../../assets/images/avatars/andrew.jpg', '090078601', ' Developer', '2018-08-02 05:49:29', '2018-08-02 05:49:29'),
(22, 'abcd@pay-mon.com', 'Arnold', '$2y$10$GHI3Pea.PbimjWMK2dck7OYBMwGDXGGRbOG9//L4lJeyk6jEiD92W', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xZTA1NDBkMy5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTUzMzMwMTgzOSwiZXhwIjoxNTMzMzA1NDM5LCJuYmYiOjE1MzMzMDE4MzksImp0aSI6ImNRMnNHN2NvTDVRa2xNMk8iLCJzdWIiOjIyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.UU0_wg9wIyFSNwrvHE9QvEvK2iismi0ZsHRTROJQMRw', 1, '../../../../../assets/images/avatars/Arnold.jpg', '090078601', ' Developer', '2018-08-03 01:38:55', '2018-08-03 01:38:55'),
(23, 'abc1@gmail.com', 'Barrera', '$2y$10$sncEbifzcr7oV3UsuFi.bOBFUxLvp0Fqsu879zJwAvkUxpf9DrOE6', '111bd21a53c32d3f2825c759ef061eab12b757513bda64ec95', 0, '../../../../../assets/images/avatars/Barrera.jpg', '090078601', ' Developer', '2018-08-07 02:52:16', '2018-08-07 02:52:16'),
(24, 'ahmadbinizh1ar@gmail.com', 'Blair', '$2y$10$iO10si01Tp03wgtwLOLQRuMWw1w4Lyxnsqoej2Q57t36LTdF8MCkS', '90b25c0fe44a4bb64f39fa4419f84beccc3a8016d9584c0cdc', 0, '../../../../../assets/images/avatars/Blair.jpg', '090078601', ' Developer', '2018-08-07 03:34:02', '2018-08-07 03:34:02'),
(25, 'ahmadbinizhar@gmail.com', 'Boyle', '$2y$10$FKH77VrYPDoKuiJBhHn45uc3.WDXE/zUL4CjlGwZptiTi9Gl7z32u', 'c759e620287afef84310b65dd4335a84cf19aaa20840ef3d45', 0, '../../../../../assets/images/avatars/Boyle.jpg', '090078601', ' Developer', '2018-08-07 05:41:51', '2018-08-07 05:41:51'),
(26, 'ahmadbinizha1r@gmail.com', 'carl', '$2y$10$okCbC8MSh5r5xNeNlpaFpelmXUdQxM3Ng.0K.KrllVINDYLLGjdQq', '43bd4f37eeb0dd628ed20de4da14fba9e3e099db0e9cd89d4d', 0, '../../../../../assets/images/avatars/carl.jpg', '090078601', ' Developer', '2018-08-08 00:52:18', '2018-08-08 00:52:18'),
(27, 'ahmadizhar111@gmail.com', 'Christy', '$2y$10$c0LDkCS8Rpzk2zP60/BSt.FkcJhc.j5QPh1V6auGkxx.33rqSTMra', 'b531019bca84701a5b6812ee69a1902562673bf5abd9c21216', 0, '../../../../../assets/images/avatars/Christy.jpg', '090078601', ' Developer', '2018-08-08 01:18:42', '2018-08-08 01:18:42'),
(29, 'testchange@rupayamail.com', 'Usama Bajwa', '$2y$10$tK2MrXwSPV9hLRvHS94v3umCg14q4LplhQgXa82WzQFqZWIz4zFzW', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9mYjIyNWRiMi5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0MDk5MTcwOSwiZXhwIjoxNTQwOTk1MzA5LCJuYmYiOjE1NDA5OTE3MDksImp0aSI6ImNtQ2owalhjRVJuOEhzOFoiLCJzdWIiOjI5LCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.sX4m0HOEdDNvUAiXrGi49IBT6lWUpvLnNFoQvD9Vr5Y', 1, '../../../../../assets/images/avatars/Abbott.jpg', '090078601', ' Developer', '2018-10-29 02:40:59', '2018-10-29 02:40:59'),
(30, 'testchange1@rupayamail.com', 'Ahmad izhar', '$2y$10$6.XVcq1YBsfnyVJLDvxAFO2I/S7GFermMs1GHJSMV4gDpbUksXDq2', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC83YWMyYTlmZC5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0MTI0NDkxMiwiZXhwIjoxNTQxMjQ4NTEyLCJuYmYiOjE1NDEyNDQ5MTIsImp0aSI6Ing1MllsQ2pJTm1RYVlDZzMiLCJzdWIiOjMwLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.exGGzRk9HJI0j7NIqY3O1WQr8bean2Bp9MOOknsfyu0', 1, '../../../../../assets/images/avatars/Arnold.jpg', NULL, NULL, '2018-10-29 02:59:01', '2018-10-29 02:59:01'),
(31, 'testchange2@rupayamail.com', 'Fahad', '$2y$10$MeMAun5o4qiRLWfmE84gb.R.046TT.LFE1a/QtzAf9d4CQnQvBpW.', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC83YWMyYTlmZC5uZ3Jvay5pb1wvZG9Mb2dpbiIsImlhdCI6MTU0MTI0MTQxNSwiZXhwIjoxNTQxMjQ1MDE1LCJuYmYiOjE1NDEyNDE0MTUsImp0aSI6ImFLODl0WHhSd2lhdm4yd0QiLCJzdWIiOjMxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.kv1XLaqFXIkL8LCTmomVSeoQcG3TPcxROuRm5YT1X20', 1, '../../../../../assets/images/avatars/Blair.jpg', NULL, NULL, '2018-10-29 08:23:58', '2018-10-29 08:23:58');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
