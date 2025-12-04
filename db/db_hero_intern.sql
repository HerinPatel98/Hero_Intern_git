-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2025 at 02:46 PM
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
-- Database: `db_hero_intern`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(20) NOT NULL,
  `password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `password`) VALUES
(1, 'admin', 1234);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `language` varchar(30) NOT NULL,
  `duration` varchar(30) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `title`, `description`, `language`, `duration`, `price`) VALUES
(1, 'Web Development', 'Learn to build websites and web apps', 'English', '3 Months', 4999),
(3, 'Android App Dev', 'Build Android apps from scratch', 'English', '2 Months', 3999),
(4, 'Python Novice', 'Perfect course for newbie coders.', 'python', '5 weeks', 23000),
(5, 'Vue.Js Intermediate', 'Intermediate course for frontend using Vue.', 'JavaScript', '2 weeks', 12999);

-- --------------------------------------------------------

--
-- Table structure for table `internship`
--

CREATE TABLE `internship` (
  `internship_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `req_language` varchar(30) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `internship`
--

INSERT INTO `internship` (`internship_id`, `title`, `description`, `req_language`, `price`) VALUES
(1, 'Software Intern', 'Work on real software projects', 'Python', 23000),
(2, 'Marketing Intern', 'Assist in digital marketing campaigns', 'English', 25000),
(3, 'Content Writer Intern', 'Write blogs and articles for our platform', 'English', 20500),
(5, 'Digital Marketing Intern', 'Extraordinary internship for digital marketing skills.', 'English', 13999);

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `job_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `position` int(11) NOT NULL,
  `req_exp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`job_id`, `title`, `description`, `position`, `req_exp`) VALUES
(1, 'Frontend Developer', 'Develop UI for web apps', 0, 1),
(3, 'Android Developer', 'Develop Android mobile apps', 4, 1),
(4, 'Html developer', 'Post for odoo developer', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `language1` varchar(20) NOT NULL,
  `language2` varchar(20) NOT NULL,
  `experience` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `username`, `password`, `email`, `language1`, `language2`, `experience`) VALUES
(1, 'Herin', 'BT', 'user2', 1234, 'user2.demo@gmail.com', 'php', 'css', 6),
(6, 'Messi', 'Goat', 'User3', 1234, 'fcbayern@football.gmail', 'English', 'Html', 5),
(7, 'Virat', 'Kohli', 'Chikoo', 1234, 'kohli@bcci.gmail.com', 'Android', 'kotlin', 9);

-- --------------------------------------------------------

--
-- Table structure for table `user_course`
--

CREATE TABLE `user_course` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `application_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_course`
--

INSERT INTO `user_course` (`id`, `user_id`, `course_id`, `application_date`) VALUES
(4, 6, 5, '2025-08-07'),
(6, 7, 5, '2025-08-10'),
(8, 7, 3, '2025-08-10');

-- --------------------------------------------------------

--
-- Table structure for table `user_internship`
--

CREATE TABLE `user_internship` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `internship_id` int(11) NOT NULL,
  `application_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_internship`
--

INSERT INTO `user_internship` (`id`, `user_id`, `internship_id`, `application_date`) VALUES
(2, 1, 1, '2025-07-31'),
(4, 7, 2, '2025-08-10');

-- --------------------------------------------------------

--
-- Table structure for table `user_job`
--

CREATE TABLE `user_job` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `application_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_user_course`
-- (See below for the actual view)
--
CREATE TABLE `vw_user_course` (
`user_id` int(11)
,`title` varchar(30)
,`description` text
,`language` varchar(30)
,`duration` varchar(30)
,`price` int(11)
,`application_date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_user_internship`
-- (See below for the actual view)
--
CREATE TABLE `vw_user_internship` (
`user_id` int(11)
,`title` varchar(30)
,`description` text
,`req_language` varchar(30)
,`price` int(11)
,`application_date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_user_job`
-- (See below for the actual view)
--
CREATE TABLE `vw_user_job` (
`user_id` int(11)
,`title` varchar(30)
,`description` text
,`req_exp` int(11)
,`application_date` date
);

-- --------------------------------------------------------

--
-- Structure for view `vw_user_course`
--
DROP TABLE IF EXISTS `vw_user_course`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `vw_user_course`  AS SELECT `user`.`user_id` AS `user_id`, `course`.`title` AS `title`, `course`.`description` AS `description`, `course`.`language` AS `language`, `course`.`duration` AS `duration`, `course`.`price` AS `price`, `user_course`.`application_date` AS `application_date` FROM ((`user` join `course`) join `user_course`) WHERE `user`.`user_id` = `user_course`.`user_id` AND `course`.`course_id` = `user_course`.`course_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_user_internship`
--
DROP TABLE IF EXISTS `vw_user_internship`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_user_internship`  AS SELECT `user`.`user_id` AS `user_id`, `internship`.`title` AS `title`, `internship`.`description` AS `description`, `internship`.`req_language` AS `req_language`, `internship`.`price` AS `price`, `user_internship`.`application_date` AS `application_date` FROM ((`user` join `internship`) join `user_internship`) WHERE `user`.`user_id` = `user_internship`.`user_id` AND `internship`.`internship_id` = `user_internship`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_user_job`
--
DROP TABLE IF EXISTS `vw_user_job`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `vw_user_job`  AS SELECT `user`.`user_id` AS `user_id`, `job`.`title` AS `title`, `job`.`description` AS `description`, `job`.`req_exp` AS `req_exp`, `user_job`.`application_date` AS `application_date` FROM ((`user` join `job`) join `user_job`) WHERE `user_job`.`user_id` = `user`.`user_id` AND `user_job`.`job_id` = `job`.`job_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_name` (`admin_name`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `internship`
--
ALTER TABLE `internship`
  ADD PRIMARY KEY (`internship_id`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_course`
--
ALTER TABLE `user_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_course_id` (`course_id`);

--
-- Indexes for table `user_internship`
--
ALTER TABLE `user_internship`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`internship_id`),
  ADD KEY `fk_internship_id` (`internship_id`);

--
-- Indexes for table `user_job`
--
ALTER TABLE `user_job`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `internship`
--
ALTER TABLE `internship`
  MODIFY `internship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_course`
--
ALTER TABLE `user_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_internship`
--
ALTER TABLE `user_internship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_job`
--
ALTER TABLE `user_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_course`
--
ALTER TABLE `user_course`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_internship`
--
ALTER TABLE `user_internship`
  ADD CONSTRAINT `fk_internship_id` FOREIGN KEY (`internship_id`) REFERENCES `internship` (`internship_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
