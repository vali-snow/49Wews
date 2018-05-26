-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2018 at 01:01 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `49wews`
--

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `FeedID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feeds`
--

INSERT INTO `feeds` (`FeedID`, `Name`, `Description`, `Link`) VALUES
(1, 'Anacronic', 'Stiri Altfel', 'http://www.anacronic.ro/feed/'),
(2, 'Karamazov', 'Stiri Religioase', 'http://karamazov.ro/index.php?format=feed'),
(3, 'Marginalia', 'Stiri Elitiste', 'https://www.marginaliaetc.ro/feed/'),
(9, 'Zoso', 'Stiri Mondene', 'https://www.zoso.ro/feed/'),
(10, 'It-Blog.ro', 'Stiri Tech', 'https://www.it-blog.ro/feed'),
(11, 'Logica Economica', 'Stiri Economice', 'https://logec.ro/feed/');

-- --------------------------------------------------------

--
-- Table structure for table `readers`
--

CREATE TABLE `readers` (
  `ReaderID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `SessionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `readers`
--

INSERT INTO `readers` (`ReaderID`, `Username`, `Email`, `Password`, `SessionID`) VALUES
(1, 'admin', 'admin@dv.feed', 'admin', 596143072),
(3, 'dorina', 'dorina@cabac.com', 'dorina', 0),
(4, 'valen', 'valentin@sarghi.com', 'valen', 490692086),
(7, 'admin2', 'admin2@dv.feed', 'admin2', 0),
(13, 'admin3', 'aa', 'aa', 0),
(16, 'admin4', 'admin4', 'admin4', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `SubscriptionID` int(11) NOT NULL,
  `FeedID` int(11) NOT NULL,
  `ReaderID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`SubscriptionID`, `FeedID`, `ReaderID`) VALUES
(16, 1, 4),
(31, 2, 1),
(19, 2, 4),
(29, 9, 1),
(32, 11, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`FeedID`);

--
-- Indexes for table `readers`
--
ALTER TABLE `readers`
  ADD PRIMARY KEY (`ReaderID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`SubscriptionID`),
  ADD UNIQUE KEY `UQ_FeedID_ReaderID` (`FeedID`,`ReaderID`),
  ADD KEY `subscriptions_ibfk_2` (`ReaderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `FeedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `readers`
--
ALTER TABLE `readers`
  MODIFY `ReaderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `SubscriptionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`FeedID`) REFERENCES `feeds` (`FeedID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`ReaderID`) REFERENCES `readers` (`ReaderID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
