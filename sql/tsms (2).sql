-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 18, 2023 at 05:21 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inquiry`
--

CREATE TABLE `tbl_inquiry` (
  `inquiry_id` int(11) NOT NULL,
  `user_fk` int(11) DEFAULT NULL,
  `staff_fk` int(11) DEFAULT NULL,
  `inquiry_type` varchar(30) NOT NULL,
  `inquiry_description` text NOT NULL,
  `inquiry_date` datetime NOT NULL DEFAULT current_timestamp(),
  `inquiry_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_inquiry`
--

INSERT INTO `tbl_inquiry` (`inquiry_id`, `user_fk`, `staff_fk`, `inquiry_type`, `inquiry_description`, `inquiry_date`, `inquiry_status`) VALUES
(2, 4, 2, 'high', 'dfsfdaf', '2023-03-26 20:33:18', 'solved'),
(4, 4, 2, 'High Priorty', 'this is a testing entry			', '2023-05-18 19:41:37', 'Member Accepted'),
(5, 4, 2, 'High Priorty', 'this is a testing entry		', '2023-05-18 19:48:23', 'Member Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL,
  `type` varchar(5) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `first_name`, `last_name`, `email`, `password`, `last_login`, `type`, `is_deleted`) VALUES
(2, 'staff', 'staff account', 'staff@gmail.com', '6ccb4b7c39a6e77f76ecfa935a855c6c46ad5611', '2023-05-18 20:09:57', 'staff', 0),
(3, 'ucsc', 'ucsc', 'ucsc@gmail.com', 'c0d0cb34565fe05ca2a14e8b13285bf6dbdf6dfc', '2023-05-18 20:14:05', 'admin', 0),
(4, 'ravien', 'dalpatadu', 'dalpataduravien@gmail.com', 'ef245fbb4dd920d7eb3cdd92991c10e113398552', '2023-05-18 19:47:39', 'user', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_inquiry`
--
ALTER TABLE `tbl_inquiry`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `staff_fk` (`staff_fk`),
  ADD KEY `user_fk` (`user_fk`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_inquiry`
--
ALTER TABLE `tbl_inquiry`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_inquiry`
--
ALTER TABLE `tbl_inquiry`
  ADD CONSTRAINT `staff_fk` FOREIGN KEY (`staff_fk`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_fk`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
