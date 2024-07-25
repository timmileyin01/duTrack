-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 11:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `track`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(11) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `fac_id` int(11) DEFAULT NULL,
  `faculty` varchar(255) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_title`, `fac_id`, `faculty`, `dept_id`, `department`) VALUES
(1, 'SEN 101', 'Introduction to Software Engineering', 1, 'Computing and Applied Sciences', 1, 'Computer Sciences'),
(2, 'CSC 101', 'Introduction to Computer Engineering', 1, 'Computing and Applied Sciences', 1, 'Computer Sciences'),
(3, 'CSC 202', 'Data Structures and Algorithms ', 1, 'Computing and Applied Sciences', 1, 'Computer Sciences'),
(4, 'CSC 205', 'Computer Security', 1, 'Computing and Applied Sciences', 1, 'Computer Sciences');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hod` varchar(255) NOT NULL,
  `hod_sig` varchar(255) NOT NULL,
  `fac_id` int(11) DEFAULT NULL,
  `faculty` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `hod`, `hod_sig`, `fac_id`, `faculty`) VALUES
(1, 'Computer Sciences', 'Dr. Mainoo Kobie', '1718832549_research 1.jpg', 1, 'Computing and Applied Sciences');

-- --------------------------------------------------------

--
-- Table structure for table `disciplinary`
--

CREATE TABLE `disciplinary` (
  `id` int(11) NOT NULL,
  `id_number` varchar(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `date` date NOT NULL,
  `filename` varchar(255) NOT NULL,
  `format` varchar(11) NOT NULL,
  `size` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disciplinary`
--

INSERT INTO `disciplinary` (`id`, `id_number`, `title`, `note`, `date`, `filename`, `format`, `size`) VALUES
(2, 'DU0276', 'Bullying, Rape', 'This action was taking because, you were caught', '2024-06-19', '1718833176_IMG-20230127-WA0004.jpg', 'jpg', '68510');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `id_number` varchar(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `format` varchar(50) NOT NULL,
  `size` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `id_number`, `title`, `note`, `filename`, `format`, `size`) VALUES
(2, 'DU0276', 'O\' level Result', 'This is a copy of my O\'level Result', '1718833068_IMG-20221021-WA0008.jpg', 'jpg', '87170');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` int(11) NOT NULL,
  `id_number` varchar(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `relationship` varchar(30) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_contacts`
--

INSERT INTO `emergency_contacts` (`id`, `id_number`, `firstname`, `middlename`, `surname`, `mobile_number`, `email`, `relationship`, `address`) VALUES
(3, 'DU0276', 'Mercy', 'Noah', 'Caroline', '09022222222', 'caro@example.com', 'Mother', 'Behind Oyo State');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dean` varchar(100) NOT NULL,
  `dean_sig` varchar(255) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `dean`, `dean_sig`, `about`) VALUES
(1, 'Computing and Applied Sciences', 'Prof. Adenike Osofisan', '1690871645_research 1.jpg', 'it is a nice faculty'),
(3, 'Arts, Social & Management Sciences', 'Prof. Adenike Osofisan', '1690871660_research 3(1).jpg', 'it is a good faculty');

-- --------------------------------------------------------

--
-- Table structure for table `gpa`
--

CREATE TABLE `gpa` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `semester` varchar(30) NOT NULL,
  `level` varchar(30) NOT NULL,
  `matric_no` varchar(20) NOT NULL,
  `total_points` int(11) NOT NULL,
  `total_unit` int(11) NOT NULL,
  `gpa` decimal(11,2) NOT NULL,
  `unique_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gpa`
--

INSERT INTO `gpa` (`id`, `session_id`, `semester`, `level`, `matric_no`, `total_points`, `total_unit`, `gpa`, `unique_id`) VALUES
(1, 1, '1', '100', 'DU0276', 21, 6, 3.50, 'DU027611100'),
(2, 2, '1', '200', 'DU0276', 27, 6, 4.50, 'DU027621200');

-- --------------------------------------------------------

--
-- Table structure for table `medical_information`
--

CREATE TABLE `medical_information` (
  `id` int(11) NOT NULL,
  `id_number` varchar(11) NOT NULL,
  `history` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_information`
--

INSERT INTO `medical_information` (`id`, `id_number`, `history`) VALUES
(2, 'DU0276', 'These are some medical information about this student');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `id_number` varchar(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `id_number`, `name`, `email`, `message`) VALUES
(1, 'DU0276', 'Carson Dummy Ben', 'ben@example.com', 'I have a question'),
(2, 'DU0276', 'Carson Dummy Ben', 'ben@example.com', 'Hey! Good Morning');

-- --------------------------------------------------------

--
-- Table structure for table `personal_data`
--

CREATE TABLE `personal_data` (
  `id` int(11) NOT NULL,
  `id_number` varchar(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `program` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `mobile_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_data`
--

INSERT INTO `personal_data` (`id`, `id_number`, `date_of_birth`, `program`, `address`, `mobile_number`) VALUES
(2, 'DU0276', '1998-05-21', 'Software Engineering', 'Behind Lagos State', '07033333333');

-- --------------------------------------------------------

--
-- Table structure for table `reset`
--

CREATE TABLE `reset` (
  `id` int(11) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(50) NOT NULL,
  `matric_id` varchar(50) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `semester` varchar(50) NOT NULL,
  `level` varchar(10) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `score` int(11) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `course_unit` int(11) NOT NULL,
  `total_points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `unique_id`, `matric_id`, `student_name`, `session_id`, `semester`, `level`, `course_id`, `score`, `remark`, `course_unit`, `total_points`) VALUES
(1, 'DU0276SEN 1012019/2020', 'DU0276', 'Carson Dummy Ben', 1, '1', '100', 1, 67, 'Good', 3, 12),
(2, 'DU0276CSC 1012019/2020', 'DU0276', 'Carson Dummy Ben', 1, '1', '100', 2, 56, 'Good', 3, 9),
(3, 'DU0276CSC 2022020/2021', 'DU0276', 'Carson Dummy Ben', 2, '1', '200', 3, 79, 'Good', 3, 15),
(4, 'DU0276CSC 2052020/2021', 'DU0276', 'Carson Dummy Ben', 2, '1', '200', 4, 66, 'Good', 3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `session` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `session`, `date_added`) VALUES
(1, '2019/2020', '2023-07-30 08:18:35'),
(2, '2020/2021', '2023-07-30 09:30:29'),
(3, '2021/2022', '2023-08-11 23:50:46'),
(4, '1999/2000', '2024-06-02 14:52:19'),
(5, '2000/2001', '2024-06-02 14:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `max_upload` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `image`, `description`, `max_upload`) VALUES
(1, 'EduTrack', '1689074995_duLogo.png', 'A dynamic tool that harmoniously integrates student data.', 15000000);

-- --------------------------------------------------------

--
-- Table structure for table `student_guardian`
--

CREATE TABLE `student_guardian` (
  `id` int(11) NOT NULL,
  `id_number` varchar(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `surname` varchar(100) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `relationship` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_guardian`
--

INSERT INTO `student_guardian` (`id`, `id_number`, `firstname`, `middlename`, `surname`, `mobile_number`, `email`, `address`, `avatar`, `relationship`) VALUES
(1, 'DU0276', 'Mercy', 'Noah', 'Caroline', '09022222222', 'caro@example.com', 'Behind Oyo State', '1718832335_profile-3.jpg', 'Mother');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `surname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `othernames` varchar(50) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(125) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `admin` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `surname`, `firstname`, `othernames`, `id_number`, `gender`, `email`, `password`, `avatar`, `admin`, `date`) VALUES
(1, 'Benny', 'John', 'Actor', 'DU/ST/0023', 'Male', 'john@example.com', '$2y$10$5ent1fLySt5xgTZNj4QgGexbe3SQsXL1k3.GOKF.I3jPgH2bicVlO', '1717253590_profile-1.jpg', 'repo_super_admin', '2024-06-01 14:53:10'),
(4, 'Ben', 'Carson', 'Dummy', 'DU0276', 'Male', 'ben@example.com', '$2y$10$sd2tXRQGSAOxW0hP7B1jN.BFGPas1Vb.xsmDYgMX0KBwJRBC9fVDK', '1718832031_profile-1.jpg', 'repo_user', '2024-06-19 21:20:32'),
(5, 'Gift', 'Dola', 'Vally', 'DU/ST/0040', 'Female', 'dola@example.com', '$2y$10$Ef8vEU1t6jiajje.rwU4FOyiAFM/kYI4otXSiL5c0DVKzRs9F053y', '1718833902_profile-4.jpg', 'repo_admin', '2024-06-19 21:51:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fac_id` (`fac_id`);

--
-- Indexes for table `disciplinary`
--
ALTER TABLE `disciplinary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gpa`
--
ALTER TABLE `gpa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `medical_information`
--
ALTER TABLE `medical_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_data`
--
ALTER TABLE `personal_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset`
--
ALTER TABLE `reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_guardian`
--
ALTER TABLE `student_guardian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_number` (`id_number`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `disciplinary`
--
ALTER TABLE `disciplinary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gpa`
--
ALTER TABLE `gpa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `medical_information`
--
ALTER TABLE `medical_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_data`
--
ALTER TABLE `personal_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reset`
--
ALTER TABLE `reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_guardian`
--
ALTER TABLE `student_guardian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`fac_id`) REFERENCES `faculties` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `gpa`
--
ALTER TABLE `gpa`
  ADD CONSTRAINT `gpa_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
