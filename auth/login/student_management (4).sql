-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2024 at 06:19 PM
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
-- Database: `student_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `academic_year_id` int(11) NOT NULL,
  `year` varchar(15) DEFAULT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`academic_year_id`, `year`, `status`) VALUES
(1, '2023-2024', 'current'),
(3, '2024-2025', ''),
(5, '2025-2026', '');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `academic_id` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `school_days` int(11) DEFAULT NULL,
  `present_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `academic_id`, `month`, `school_days`, `present_days`) VALUES
(7, 4, 0, 9, 20, 10),
(8, 4, 0, 8, 10, 5),
(9, 4, 1, 8, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `contact_type` enum('father','mother','guardian') DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `final_grade`
--

CREATE TABLE `final_grade` (
  `final_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `semester_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `final_grade` int(11) DEFAULT NULL,
  `remark` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `final_grade`
--

INSERT INTO `final_grade` (`final_id`, `student_id`, `subject_id`, `semester_id`, `academic_id`, `final_grade`, `remark`) VALUES
(10, 4, 13, 1, 1, 82, NULL),
(11, 4, 12, 1, 1, 93, NULL),
(12, 2, 13, 1, 1, 92, NULL),
(13, 2, 12, 1, 1, 12, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grades_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `initial_grade` int(10) NOT NULL,
  `highest_grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grades_id`, `student_id`, `semester_id`, `academic_id`, `subject_id`, `component_id`, `initial_grade`, `highest_grade`) VALUES
(35, 4, 1, 1, 12, 7, 19, 20),
(36, 4, 1, 1, 12, 8, 91, 100),
(37, 4, 1, 1, 13, 12, 17, 20),
(38, 4, 1, 1, 13, 12, 21, 30),
(39, 4, 1, 1, 13, 13, 8, 10),
(40, 4, 1, 1, 13, 16, 42, 50),
(41, 4, 1, 1, 13, 13, 25, 30),
(42, 4, 1, 1, 12, 7, 10, 10),
(43, 4, 1, 1, 12, 9, 38, 40),
(44, 4, 1, 1, 12, 7, 19, 20),
(45, 2, 1, 1, 13, 12, 10, 10),
(46, 2, 1, 1, 13, 13, 47, 50),
(47, 2, 1, 1, 13, 16, 39, 50),
(49, 2, 1, 1, 12, 7, 9, 10),
(50, 2, 1, 1, 12, 7, 20, 50);

-- --------------------------------------------------------

--
-- Table structure for table `grade_component`
--

CREATE TABLE `grade_component` (
  `component_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `component_name` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade_component`
--

INSERT INTO `grade_component` (`component_id`, `subject_id`, `component_name`, `weight`) VALUES
(7, 12, 'Written Works', 25),
(8, 12, 'Performance Task', 50),
(9, 12, 'Quarterly Assessment', 25),
(12, 13, 'Written Works', 20),
(13, 13, 'Performance Task', 60),
(16, 13, 'Quarterly Exam', 20);

-- --------------------------------------------------------

--
-- Table structure for table `grade_factor`
--

CREATE TABLE `grade_factor` (
  `factor_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `highest_possible` int(11) NOT NULL,
  `grades_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guardian`
--

CREATE TABLE `guardian` (
  `guardian_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `year` varchar(10) NOT NULL,
  `advisor_id` int(11) NOT NULL,
  `strand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`, `year`, `advisor_id`, `strand_id`) VALUES
(0, 'Thomson', '11', 1, 2),
(7, 'Newton', '12', 11, 3),
(8, 'Bonifacio', '11', 9, 3),
(9, 'Thomson', '12', 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `semester_id` int(11) NOT NULL,
  `semester_name` varchar(255) DEFAULT NULL,
  `Quarter` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`semester_id`, `semester_name`, `Quarter`) VALUES
(1, 'First Semester', '1st'),
(2, 'Second Semester', '3rd'),
(3, 'First Semester', '2nd'),
(4, 'Second Semester', '4th');

-- --------------------------------------------------------

--
-- Table structure for table `strand`
--

CREATE TABLE `strand` (
  `strand_id` int(11) NOT NULL,
  `strand_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `strand`
--

INSERT INTO `strand` (`strand_id`, `strand_name`) VALUES
(0, 'TVL - Culinary'),
(1, 'STEM'),
(2, 'ABM'),
(3, 'TVL - ICT'),
(4, 'HUMSS'),
(5, 'GAS'),
(6, 'TVL - HUMSS');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `section_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `DOB` date DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `profile_picture_url` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `user_id`, `section_id`, `first_name`, `middle_name`, `last_name`, `email`, `DOB`, `barangay`, `city`, `province`, `nationality`, `religion`, `gender`, `profile_picture_url`, `remarks`) VALUES
(2, NULL, 7, 'Rommel', 'Bautista', 'Maningas', 'johnrendel87@gmail.com', '2024-04-02', '', 'Cabanatuan City', 'Nueva Ecija', 'Filipino', 'Catholic', 'Female', NULL, 'test'),
(3, NULL, 7, 'Rommel', 'Dizon', 'Maningas', 'johnrendel87@gmail.com', '2024-04-01', 'San Josef Norte', 'Cabanatuan City', 'Nueva Ecija', 'Filipino', 'Catholic', 'Male', NULL, 'test'),
(4, NULL, 7, 'Yamagishi', 'Dizon', 'Ken', 'ken@gmail.com', '2024-04-16', 'San Josef Norte', 'Cabanatuan City', 'Nueva Ecija', 'Japanese', 'Baptist', 'Male', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `student_subject`
--

CREATE TABLE `student_subject` (
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_teacher` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `strand_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `subject_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_teacher`, `academic_year_id`, `strand_id`, `semester_id`, `subject_name`, `subject_code`) VALUES
(12, 11, 1, 3, 1, 'Oral Comunication', 'OC -1 '),
(13, 11, 1, 3, 1, 'Introduction in Computer Programming I', 'CP-1'),
(14, 12, 1, 1, 1, 'Oral Communication in Context', 'MATS01G');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `gender` enum('male','female','others') NOT NULL,
  `subject_taught` varchar(255) DEFAULT NULL,
  `contact_num` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `profile_picture_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `DOB`, `gender`, `subject_taught`, `contact_num`, `title`, `profile_picture_url`) VALUES
(1, NULL, 'John', 'Doe', 'Smith', '1990-01-01', 'male', NULL, '1234567890', 'Mathematics Teacher', 'https://example.com/profile_pic1.jpg'),
(2, NULL, 'Jane', 'Doe', 'Johnson', '1991-02-02', 'female', NULL, '9876543210', 'English Teacher', 'https://example.com/profile_pic2.jpg'),
(3, NULL, 'Michael', 'Brown', 'Williams', '1988-03-03', 'male', NULL, '4567890123', 'Science Teacher', 'https://example.com/profile_pic3.jpg'),
(4, NULL, 'Emily', 'Wilson', 'Taylor', '1989-04-04', 'female', NULL, '7890123456', 'History Teacher', 'https://example.com/profile_pic4.jpg'),
(5, NULL, 'David', 'Jones', 'Miller', '1992-05-05', 'male', NULL, '5678901234', 'Art Teacher', 'https://example.com/profile_pic5.jpg'),
(6, NULL, 'Jennifer', 'Brown', 'Martinez', '1993-06-06', 'female', NULL, '8901234567', 'Physical Education Teacher', 'https://example.com/profile_pic6.jpg'),
(7, NULL, 'Daniel', 'Wilson', 'Hernandez', '1987-07-07', 'male', NULL, '6789012345', 'Music Teacher', 'https://example.com/profile_pic7.jpg'),
(8, NULL, 'Sophia', 'Johnson', 'Garcia', '1994-08-08', 'female', NULL, '9012345678', 'Computer Science Teacher', 'https://example.com/profile_pic8.jpg'),
(9, 10, 'Rommel', 'Dizon', 'Maningas', '2024-04-01', 'female', NULL, '123132131', 'Teacher II', 'https://ui-avatars.com/api/?name=Rommel+Maningas&size=256'),
(10, 11, 'Rendel', 'San Luis', 'Maningas', '2024-04-02', 'male', NULL, '123131', 'Teacher II', 'https://ui-avatars.com/api/?name=Rendel+Maningas&size=256'),
(11, 12, 'Ryan', 'San Luis', 'Maningas', '2024-04-07', 'others', NULL, '123131', 'Teacher II', 'https://ui-avatars.com/api/?name=Ryan+Maningas&size=256'),
(12, 13, 'Teacher', 'Test', 'Test', '2024-04-02', 'male', NULL, '123123123123', 'Teacher IV', 'https://ui-avatars.com/api/?name=Teacher+Test&size=256'),
(20, NULL, 'Matthew', 'Anderson', 'Lopez', '1986-09-09', 'male', NULL, '7890123456', 'Foreign Language Teacher', 'https://example.com/profile_pic9.jpg'),
(21, NULL, 'Emma', 'Harris', 'Gonzalez', '1995-10-10', 'female', NULL, '8901234567', 'Geography Teacher', 'https://example.com/profile_pic10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `category` enum('admin','teacher') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password_hash`, `email`, `category`) VALUES
(1, 'admin', '123', 'nexuslinkofficial@gmail.com', 'admin'),
(9, 'johnrendel87', '2024-89914', 'johnrendel87@gmail.com', 'teacher'),
(10, 'mrskybrine', '2024-72679', 'mrskybrine@gmail.com', 'teacher'),
(11, 'rendel', '2024-81960', 'rendel@gmail.com', 'teacher'),
(12, 'ryan', '2024-47144', 'ryan@gmail.com', 'teacher'),
(13, 'teacher', '2024-99991', 'teacher@gmail.com', 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`academic_year_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `final_grade`
--
ALTER TABLE `final_grade`
  ADD PRIMARY KEY (`final_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grades_id`);

--
-- Indexes for table `grade_component`
--
ALTER TABLE `grade_component`
  ADD PRIMARY KEY (`component_id`);

--
-- Indexes for table `guardian`
--
ALTER TABLE `guardian`
  ADD PRIMARY KEY (`guardian_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `strand`
--
ALTER TABLE `strand`
  ADD PRIMARY KEY (`strand_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `student_ibfk_1` (`user_id`);

--
-- Indexes for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD PRIMARY KEY (`student_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `academic_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `final_grade`
--
ALTER TABLE `final_grade`
  MODIFY `final_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grades_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `grade_component`
--
ALTER TABLE `grade_component`
  MODIFY `component_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `guardian`
--
ALTER TABLE `guardian`
  MODIFY `guardian_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
