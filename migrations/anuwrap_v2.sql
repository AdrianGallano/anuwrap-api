-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2024 at 12:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anuwrap`
--

-- --------------------------------------------------------

--
-- Table structure for table `annualreport`
--

CREATE TABLE `annualreport` (
  `annual_report_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `workspace_id` int(10) UNSIGNED DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collage`
--

CREATE TABLE `collage` (
  `collage_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `workspace_id` int(10) UNSIGNED DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collageimage`
--

CREATE TABLE `collageimage` (
  `collage_image_id` int(10) UNSIGNED NOT NULL,
  `path` text NOT NULL,
  `collage_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `workspace_id` int(10) UNSIGNED DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reportselection`
--

CREATE TABLE `reportselection` (
  `annual_report_id` int(10) UNSIGNED NOT NULL,
  `report_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` tinytext NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userworkspace`
--

CREATE TABLE `userworkspace` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `workspace_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workspace`
--

CREATE TABLE `workspace` (
  `workspace_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annualreport`
--
ALTER TABLE `annualreport`
  ADD PRIMARY KEY (`annual_report_id`),
  ADD KEY `title` (`title`),
  ADD KEY `workspace_id` (`workspace_id`);

--
-- Indexes for table `collage`
--
ALTER TABLE `collage`
  ADD PRIMARY KEY (`collage_id`),
  ADD KEY `workspace_id` (`workspace_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `collageimage`
--
ALTER TABLE `collageimage`
  ADD PRIMARY KEY (`collage_image_id`),
  ADD KEY `collage_id` (`collage_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `workspace_id` (`workspace_id`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `reportselection`
--
ALTER TABLE `reportselection`
  ADD PRIMARY KEY (`annual_report_id`,`report_id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`(255));

--
-- Indexes for table `userworkspace`
--
ALTER TABLE `userworkspace`
  ADD PRIMARY KEY (`user_id`,`workspace_id`),
  ADD KEY `workspace_id` (`workspace_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `workspace`
--
ALTER TABLE `workspace`
  ADD PRIMARY KEY (`workspace_id`),
  ADD KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annualreport`
--
ALTER TABLE `annualreport`
  MODIFY `annual_report_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `collage`
--
ALTER TABLE `collage`
  MODIFY `collage_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collageimage`
--
ALTER TABLE `collageimage`
  MODIFY `collage_image_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workspace`
--
ALTER TABLE `workspace`
  MODIFY `workspace_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annualreport`
--
ALTER TABLE `annualreport`
  ADD CONSTRAINT `annualreport_ibfk_1` FOREIGN KEY (`workspace_id`) REFERENCES `workspace` (`workspace_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `collage`
--
ALTER TABLE `collage`
  ADD CONSTRAINT `collage_ibfk_1` FOREIGN KEY (`workspace_id`) REFERENCES `workspace` (`workspace_id`);

--
-- Constraints for table `collageimage`
--
ALTER TABLE `collageimage`
  ADD CONSTRAINT `collageimage_ibfk_1` FOREIGN KEY (`collage_id`) REFERENCES `collage` (`collage_id`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`workspace_id`) REFERENCES `workspace` (`workspace_id`);

--
-- Constraints for table `reportselection`
--
ALTER TABLE `reportselection`
  ADD CONSTRAINT `reportselection_ibfk_1` FOREIGN KEY (`annual_report_id`) REFERENCES `annualreport` (`annual_report_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reportselection_ibfk_2` FOREIGN KEY (`report_id`) REFERENCES `report` (`report_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userworkspace`
--
ALTER TABLE `userworkspace`
  ADD CONSTRAINT `userworkspace_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userworkspace_ibfk_2` FOREIGN KEY (`workspace_id`) REFERENCES `workspace` (`workspace_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userworkspace_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
