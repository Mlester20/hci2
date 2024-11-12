-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 06:17 AM
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
-- Database: `scheduling`
--

-- --------------------------------------------------------

--
-- Table structure for table `cys`
--

CREATE TABLE `cys` (
  `cys_id` int(11) NOT NULL,
  `cys` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cys`
--

INSERT INTO `cys` (`cys_id`, `cys`) VALUES
(6, 'IT 4A - WEB'),
(5, 'IT 4B - NS'),
(4, 'IT 4A - NS'),
(7, 'IT 3A - WEB'),
(8, 'IT 3B - WEB'),
(9, 'IT - 1A'),
(10, 'IT - 1B'),
(12, 'IT 2A - WEB'),
(13, 'IT 2B- WEB'),
(14, 'IT 2C - WEB'),
(15, 'IT 2A - NS'),
(16, 'IT 4B-WEB');

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE `dept` (
  `dept_id` int(11) NOT NULL,
  `dept_code` varchar(10) NOT NULL,
  `dept_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dept`
--

INSERT INTO `dept` (`dept_id`, `dept_code`, `dept_name`) VALUES
(9, 'Institute ', 'IICT'),
(10, 'Registrar', 'Registrar');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `designation_id` int(11) NOT NULL,
  `designation_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`designation_id`, `designation_name`) VALUES
(67, 'Faculty'),
(66, 'Dean'),
(68, 'Registrar'),
(69, 'Campus Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `exam_sched`
--

CREATE TABLE `exam_sched` (
  `sched_id` int(11) NOT NULL,
  `time_id` int(1) NOT NULL,
  `day` varchar(50) NOT NULL,
  `member_id` int(11) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `cys` varchar(15) NOT NULL,
  `room` varchar(15) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `settings_id` int(11) NOT NULL,
  `cys1` varchar(10) NOT NULL,
  `term` varchar(10) NOT NULL,
  `encoded_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `member_last` varchar(30) NOT NULL,
  `member_first` varchar(30) NOT NULL,
  `member_rank` varchar(50) NOT NULL,
  `member_salut` varchar(30) NOT NULL,
  `dept_code` varchar(10) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `program_code` varchar(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_last`, `member_first`, `member_rank`, `member_salut`, `dept_code`, `designation_id`, `program_code`, `username`, `password`, `status`) VALUES
(27, 'Raguindin', 'Mark Lester', 'Assistant Professor I', 'Mr', 'IICT', 5, '', 'admin', 'admin', 'admin'),
(190, 'Cunanan', 'Janet', 'Professor I', 'Dr', 'Institute ', 67, '', 'janet', 'cunanan', 'user'),
(191, 'Alzate', 'Ma. Valen', 'Professor II', 'Dean', 'Institute ', 66, '', 'ma.valen', 'alzate', 'user'),
(192, 'Bautista', 'Rosalinda', 'Professor II', 'Campus Administrator', 'Institute ', 69, '', 'rosalinda', 'bautista', 'user'),
(193, 'Dela Cruz', 'Michelle', 'Professor IV', 'Mrs', 'Registrar', 67, '', 'michelle', 'delacruz', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `prog_id` int(11) NOT NULL,
  `prog_code` varchar(10) NOT NULL,
  `prog_title` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`prog_id`, `prog_code`, `prog_title`) VALUES
(6, 'BSPsych ', 'Bachelor of Science in Psychology'),
(13, 'BSED', 'Bachelor of Science in Secondary Education'),
(14, 'BEED', 'Bachelor of Science in Elementary Education'),
(15, 'BSIT ', 'Bachelor of Science in Information Technology Majo');

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE `rank` (
  `rank_id` int(11) NOT NULL,
  `rank` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`rank_id`, `rank`) VALUES
(1, 'Instructor I'),
(4, 'Instructor II'),
(6, 'Assistant Professor I'),
(5, 'Instructor III'),
(7, 'Assistant Professor II'),
(8, 'Assistant Professor III'),
(9, 'Assistant Professor IV'),
(10, 'Associate Professor I'),
(11, 'Associate Professor II'),
(12, 'Associate Professor III'),
(13, 'Associate Professor IV'),
(14, 'Professor I'),
(15, 'Professor II'),
(16, 'Professor III'),
(17, 'Professor IV'),
(18, 'Campus Administrator'),
(19, 'University Professor '),
(23, 'Registrar');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room`) VALUES
(6, 'D4'),
(5, 'D3'),
(4, 'D2'),
(7, 'D5'),
(8, 'D6'),
(9, 'D7'),
(10, 'D8'),
(11, 'D9'),
(12, 'CL-A'),
(13, 'CL-B'),
(14, 'CL-C'),
(15, 'CL-D'),
(16, 'CL-E');

-- --------------------------------------------------------

--
-- Table structure for table `salut`
--

CREATE TABLE `salut` (
  `salut_id` int(11) NOT NULL,
  `salut` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `salut`
--

INSERT INTO `salut` (`salut_id`, `salut`) VALUES
(1, 'Ms'),
(2, 'Mrs'),
(3, 'Mr'),
(5, 'Dr'),
(6, 'Prof'),
(7, 'Engr'),
(11, 'Dean'),
(13, 'Campus Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `sched_id` int(11) NOT NULL,
  `time_id` int(1) NOT NULL,
  `day` varchar(50) NOT NULL,
  `member_id` int(11) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `cys` varchar(15) NOT NULL,
  `room` varchar(15) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `settings_id` int(11) NOT NULL,
  `encoded_by` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL,
  `term` varchar(10) NOT NULL,
  `sem` varchar(15) NOT NULL,
  `sy` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `term`, `sem`, `sy`, `status`) VALUES
(12, 'Midterm', '1st', '2024-2025', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `signatories`
--

CREATE TABLE `signatories` (
  `sign_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `seq` int(2) NOT NULL,
  `set_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `signatories`
--

INSERT INTO `signatories` (`sign_id`, `member_id`, `seq`, `set_by`) VALUES
(3, 187, 2, 27),
(4, 188, 4, 27),
(5, 189, 1, 27),
(6, 191, 2, 27),
(7, 193, 1, 27),
(8, 192, 4, 27);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(15) NOT NULL,
  `subject_title` varchar(100) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_code`, `subject_title`, `member_id`) VALUES
(7, 'GE ELECT IT 2', 'Foreign Language 1', 27),
(6, 'GE ELECT IT 1', 'Health and Wellness Science', 27),
(8, 'GEC 4', 'Purposive Communication', 27),
(9, 'GEC 5', 'Art Appreciation', 27),
(10, 'IT 111', 'Introduction to Computing', 27),
(11, 'IT 112', 'Computer Programing 1', 27),
(12, 'IT INST 1', 'Climate Change and Disaster Risk Management', 27),
(13, 'NTSP 1', 'CWTS/MS/LTS', 27),
(14, 'PE 1', 'Physical Education Towards Health Fitness 1', 27),
(15, 'GEC 1', 'Understanding the Self', 27),
(16, 'GEC 2', 'Readings in Philippine History', 27),
(17, 'GEC 3', 'Mathematics in the Modern World', 27),
(18, 'GEC 7', 'Ethics', 27),
(19, 'IT 121', 'Computer Programming 2', 27),
(20, 'IT 122', 'Human - Computer Interaction 1', 27),
(21, 'IT 123', 'Discrete Mathematics', 27),
(22, 'PE 2', 'Physical Activity Towards Health Fitness II', 27),
(23, 'NSTP 2', 'CETS/MS/LTS', 27),
(24, 'GEC 6', 'Science, Technology, Society', 27),
(25, 'GEC 8 ', 'The Contemporary World', 27),
(26, 'INST 2', 'Creative and Critical Thinking', 27),
(27, 'IT 211', 'Data Structures and Algorithm', 27),
(28, 'IT BPO 1', 'Business Communication', 27),
(29, 'IT ELEC 1', 'Platform Technologies', 27),
(30, 'IT ELEC 2', 'Object Oriented Programming', 27),
(31, 'IT GE Elect 3', 'Foreign Language 2', 27),
(32, 'PE 3 ', 'Physical Activity Toward Health Fitness 3', 27),
(33, 'GEC 9 ', 'The Life and Works of Rizal', 27),
(34, 'IT 221 ', 'Information Management', 27),
(35, 'IT 222', 'Networking 1', 27),
(36, 'IT 223', 'Quantitative Methods ', 27),
(37, 'IT 225', 'Accounting for Information Technology', 27),
(38, 'IT APPDEV 1', 'Fundamentals of Mobile Technology', 27),
(39, 'IT GE ELEC 4', 'The Entrepreneurial Mind', 27),
(40, 'PE 4', 'Physical Activity Towards Health and Fitness 4', 27),
(41, 'IT 226', 'Applications Development and Emerging Technologies', 27),
(42, 'IT ELEC 3', 'Web systems and Technologies', 27),
(43, 'IT 331', 'Advanced Database Systems', 27),
(44, 'IT 312', 'Networking 2', 27),
(45, 'IT 313', 'System Integration and Architecture', 27),
(46, 'IT 314', 'Information Assurance and Security 1', 27),
(47, 'IT APPDEV 2', 'Mobile Applications', 27),
(48, 'IT Inst 3', 'Data Science Analytics', 27),
(49, 'IT 321', 'Information Assurance and Security 2', 27),
(50, 'IT 322', 'Social and Professional Issues', 27),
(51, 'IT 323', 'Capstone Project and Research 1', 27),
(52, 'IT APPDEV 4', 'Game Development', 27),
(53, 'IT APPDEV 5', 'Cloud Computing', 27),
(54, 'IT GE ELEC 5', 'Multicultural Education', 27),
(55, 'IT 412', 'Capstone Project and Research 2', 27),
(56, 'IT ELECT 6', 'Leadership Management', 27);

-- --------------------------------------------------------

--
-- Table structure for table `sy`
--

CREATE TABLE `sy` (
  `sy_id` int(11) NOT NULL,
  `sy` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sy`
--

INSERT INTO `sy` (`sy_id`, `sy`) VALUES
(9, '2023-2024'),
(10, '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `time_id` int(11) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `days` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `time`
--

INSERT INTO `time` (`time_id`, `time_start`, `time_end`, `days`) VALUES
(8, '07:30:00', '10:30:00', 'mtwthf'),
(23, '07:30:00', '08:30:00', 'mtwthf'),
(22, '13:00:00', '14:30:00', 'mtwthf'),
(21, '07:30:00', '09:30:00', 'mtwthf');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `program` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `name`, `status`, `program`) VALUES
(1, 'Mark Lester Rag', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'active', 'all');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cys`
--
ALTER TABLE `cys`
  ADD PRIMARY KEY (`cys_id`),
  ADD UNIQUE KEY `cys` (`cys`);

--
-- Indexes for table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `exam_sched`
--
ALTER TABLE `exam_sched`
  ADD PRIMARY KEY (`sched_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`prog_id`);

--
-- Indexes for table `rank`
--
ALTER TABLE `rank`
  ADD PRIMARY KEY (`rank_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `salut`
--
ALTER TABLE `salut`
  ADD PRIMARY KEY (`salut_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sched_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `signatories`
--
ALTER TABLE `signatories`
  ADD PRIMARY KEY (`sign_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `sy`
--
ALTER TABLE `sy`
  ADD PRIMARY KEY (`sy_id`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cys`
--
ALTER TABLE `cys`
  MODIFY `cys_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dept`
--
ALTER TABLE `dept`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `exam_sched`
--
ALTER TABLE `exam_sched`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `prog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rank`
--
ALTER TABLE `rank`
  MODIFY `rank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `salut`
--
ALTER TABLE `salut`
  MODIFY `salut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `signatories`
--
ALTER TABLE `signatories`
  MODIFY `sign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `sy`
--
ALTER TABLE `sy`
  MODIFY `sy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
