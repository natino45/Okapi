-- Host: localhost
-- Generation Time: Mar 21, 2014 at 07:19 PM
-- Server version: 5.5.18
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `okapi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_log`
--

CREATE TABLE IF NOT EXISTS `access_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aLog` text NOT NULL,
  `user_ID` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folderName` varchar(100) NOT NULL,
  `bootLoader` varchar(100) NOT NULL,
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `projectName` varchar(200) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `clientDetails` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=198025 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_clients`
--

CREATE TABLE IF NOT EXISTS `project_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `project_ID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `reviewContent` text NOT NULL,
  `dateCreated` datetime NOT NULL,
  `extraData` text NOT NULL,
  `seen` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `level` enum('client','admin') NOT NULL,
  `fullName` varchar(200) NOT NULL,
  `lastLogin` datetime NOT NULL,
  `notes` text NOT NULL,
  `dateCreated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `level`, `fullName`, `lastLogin`, `notes`, `dateCreated`) VALUES
(1, 'okapi@dev45.net', 'okapi', 'admin', 'Okapi Admin', '2014-03-21 17:31:20', 'Okapi rocks', '0000-00-00 00:00:00');
