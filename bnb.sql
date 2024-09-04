-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2024 at 06:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bnb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int(10) UNSIGNED NOT NULL,
  `roomID` int(10) UNSIGNED NOT NULL,
  `customerID` int(10) UNSIGNED NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `contact` varchar(20) NOT NULL,
  `booking_extras` text DEFAULT NULL,
  `booking_review` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `roomID`, `customerID`, `checkin_date`, `checkout_date`, `contact`, `booking_extras`, `booking_review`) VALUES
(4, 1, 1, '2024-09-03', '2024-09-03', '123 122 1111', 'aaa', 'fggf'),
(5, 2, 2, '2024-09-04', '2024-09-04', '123 122 1122', 'aaaaaa', 'asdasdas');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'Garrison', 'Jordan', 'sit.amet.ornare@nequesedsem.edu', 'password123'),
(2, 'Desiree', 'Collier', 'Maecenas@non.co.uk', 'password123'),
(3, 'Irene', 'Walker', 'id.erat.Etiam@id.org', 'password123'),
(4, 'Forrest', 'Baldwin', 'eget.nisi.dictum@a.com', 'password123'),
(5, 'Beverly', 'Sellers', 'ultricies.sem@pharetraQuisqueac.co.uk', 'password123'),
(6, 'Glenna', 'Kinney', 'dolor@orcilobortisaugue.org', 'password123'),
(7, 'Montana', 'Gallagher', 'sapien.cursus@ultriciesdignissimlacus.edu', 'password123'),
(8, 'Harlan', 'Lara', 'Duis@aliquetodioEtiam.edu', 'password123'),
(9, 'Benjamin', 'King', 'mollis@Nullainterdum.org', 'password123'),
(10, 'Rajah', 'Olsen', 'Vestibulum.ut.eros@nequevenenatislacus.ca', 'password123'),
(11, 'Castor', 'Kelly', 'Fusce.feugiat.Lorem@porta.co.uk', 'password123'),
(12, 'Omar', 'Oconnor', 'eu.turpis@auctorvelit.co.uk', 'password123'),
(13, 'Porter', 'Leonard', 'dui.Fusce@accumsanlaoreet.net', 'password123'),
(14, 'Buckminster', 'Gaines', 'convallis.convallis.dolor@ligula.co.uk', 'password123'),
(15, 'Hunter', 'Rodriquez', 'ridiculus.mus.Donec@est.co.uk', 'password123'),
(16, 'Zahir', 'Harper', 'vel@estNunc.com', 'password123'),
(17, 'Sopoline', 'Warner', 'vestibulum.nec.euismod@sitamet.co.uk', 'password123'),
(18, 'Burton', 'Parrish', 'consequat.nec.mollis@nequenonquam.org', 'password123'),
(19, 'Abbot', 'Rose', 'non@et.ca', 'password123'),
(20, 'Barry', 'Burks', 'risus@libero.net', 'password123');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomID` int(10) UNSIGNED NOT NULL,
  `roomname` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `roomtype` char(1) DEFAULT 'D',
  `beds` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomID`, `roomname`, `description`, `roomtype`, `beds`) VALUES
(1, 'Kellie', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing', 'S', 5),
(2, 'Herman', 'Lorem ipsum dolor sit amet, consectetuer', 'D', 5),
(3, 'Scarlett', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 'D', 2),
(4, 'Jelani', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam', 'S', 2),
(5, 'Sonya', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.', 'S', 5),
(6, 'Miranda', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 'S', 4),
(7, 'Helen', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.', 'S', 2),
(8, 'Octavia', 'Lorem ipsum dolor sit amet,', 'D', 3),
(9, 'Gretchen', 'Lorem ipsum dolor sit', 'D', 3),
(10, 'Bernard', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer', 'S', 5),
(11, 'Dacey', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 'D', 2),
(12, 'Preston', 'Lorem', 'D', 2),
(13, 'Dane', 'Lorem ipsum dolor', 'S', 4),
(14, 'Cole', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam', 'S', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `roomID` (`roomID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `roomID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`roomID`) REFERENCES `room` (`roomID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
