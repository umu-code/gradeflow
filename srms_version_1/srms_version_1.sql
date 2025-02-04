-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 07:36 AM
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
-- Database: `srms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `adminEmail` varchar(100) DEFAULT NULL,
  -- `gender` varchar(10) DEFAULT NULL,
  `role` varchar(25) DEFAULT NULL,
  `contacts` varchar(15) DEFAULT NULL,
  `updationDate` timestamp DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admins` (`id`, `UserName`, `Password`,`adminEmail`, `role`, `contacts`, `updationDate`) VALUES
(1, 'admin', 'f925916e2754e5e03f75dd58a5733251', 'pkalema@umu.ac.ug', 'associate dean' , '+256-705722053', NULL),
(2,'admin2','97ef50293dc49d09ea439e50107928d5','ivanm@umu.ac.ug','lecturer','+256-701453678', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblclasses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `CourseName` varchar(80) DEFAULT NULL,
  `CourseCode` varchar(10) DEFAULT NULL,
  `Faculty` varchar(30) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclasses`
--

INSERT INTO `courses` (`id`, `CourseName`, `CourseCode`, `Faculty`, `CreationDate`, `UpdationDate`) VALUES
(1, 'DIPCS&IT', 'DCS100', 'Science', '2024-04-25 10:30:57', '2022-01-01 10:30:57'),
(2, 'BSCIT', 'BC209', 'Science', '2024-04-25 10:30:57', '2022-01-01 10:30:57');

-- --------------------------------------------------------

--
-- Table structure for table `tblnotice`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `noticeTitle` varchar(255) DEFAULT NULL,
  `noticeDetails` mediumtext DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblnotice`
--

INSERT INTO `notices` (`id`, `noticeTitle`, `noticeDetails`, `postingDate`) VALUES
(2, 'Notice regarding result Delearation', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Adipiscing elit ut aliquam purus. Vel risus commodo viverra maecenas. Et netus et malesuada fames ac turpis egestas sed. Cursus eget nunc scelerisque viverra mauris in aliquam sem fringilla. Ornare arcu odio ut sem nulla pharetra diam. Vel pharetra vel turpis nunc eget lorem dolor sed. Velit ut tortor pretium viverra suspendisse. In ornare quam viverra orci sagittis eu. Viverra tellus in hac habitasse. Donec massa sapien faucibus et molestie. Libero justo laoreet sit amet cursus sit amet dictum. Dignissim diam quis enim lobortis scelerisque fermentum dui.\r\n\r\nEget nulla facilisi etiam dignissim. Quisque non tellus orci ac. Amet cursus sit amet dictum sit amet justo donec. Interdum velit euismod in pellentesque massa. Condimentum lacinia quis vel eros donec ac odio. Magna eget est lorem ipsum dolor. Bibendum at varius vel pharetra vel turpis nunc eget lorem. Pellentesque adipiscing commodo elit at imperdiet dui accumsan sit amet. Maecenas accumsan lacus vel facilisis volutpat est velit egestas dui. Massa tincidunt dui ut ornare lectus sit amet est placerat. Nisi quis eleifend quam adipiscing vitae.', '2024-05-01 14:34:58'),
(3, 'Test Notice', 'This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  This is for testing purposes only.  ', '2024-05-02 14:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `tblresult`



CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `RegistrationNumber` int(11) DEFAULT NULL,
  `CourseId` int(11) DEFAULT NULL,
  `CourseunitId` int(11) DEFAULT NULL,
  `CourseWorkmarks` int(11) DEFAULT NULL,
  `FinalAssesmentmarks` int(11) DEFAULT NULL,
  `TotalMarks` int(11) DEFAULT NULL,
  `Year` int(3) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Dumping data for table `tblresult`
--

INSERT INTO `results` (`id`, `RegistrationNumber`, `CourseId`, `CourseunitId`, `CourseWorkmarks`,`FinalAssesmentmarks`, `Year`, `PostingDate`, `UpdationDate`) VALUES
(2, '2023-D011-14010', 1, 2, 50, 70, 2,'2024-05-10 10:30:57', NULL),
(3, '2023-BSIT-10000', 1, 1, 40, 60, 1,'2024-05-10 10:30:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `Students` (
  `StudentId` int(11) NOT NULL,
  `StudentName` varchar(100) DEFAULT NULL,
  `RegistrationNumber` varchar(100) DEFAULT NULL,
  `StudentEmail` varchar(100) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `DOB` varchar(100) DEFAULT NULL,
  `CourseId` int(11) DEFAULT NULL,
  `RegistrationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL,
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `Students` (`StudentId`, `StudentName`, `RegistrationNumber`, `StudentEmail`, `Gender`, `DOB`, `CourseId`, `RegistrationDate`, `UpdationDate`, `Status`) VALUES
(1, 'Sarita', '2023-D011-14010', 'sarita@stud.umu.ac.ug', 'Female', '1995-03-03', 1, '2024-04-20 10:30:57', NULL, 1),
(2, 'Anuj kumar', '2023-BSIT-10000', 'anujkumar@stud.umu.ac.ug', 'Male', '1995-02-02', 2, '2024-04-24 10:30:57', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjectcombination`
--

CREATE TABLE `course&courseunit_combination` (
  `id` int(11) NOT NULL,
  `CourseId` int(11) DEFAULT NULL,
  `CourseUnitId` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `Updationdate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubjectcombination`
--

INSERT INTO `course&courseunit_combination` (`id`, `CourseId`, `CourseUnitId`, `status`, `CreationDate`, `Updationdate`) VALUES
(1, 1, 1, 0, '2024-05-01 10:30:57', '2024-06-07 05:25:49'),
(2, 2, 2, 1, '2024-05-01 10:30:57', '2024-06-07 04:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE `CourseUnits` (
  `CourseUnitId` int(11) NOT NULL,
  `CourseUnitName` varchar(100) NOT NULL,
  `CourseUnitCode` varchar(100) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubjects`
--

INSERT INTO `CourseUnits` (`CourseUnitId`, `CourseUnitName`, `CourseUnitCode`, `Creationdate`, `UpdationDate`) VALUES
(1, 'Computational Mathematics', 'MTH01', '2024-04-25 10:30:57', NULL),
(2, 'English Grammar', 'Gram101', '2024-04-25 10:30:57', NULL),
(4, 'Computer Science', 'CS111', '2024-04-25 10:30:57', NULL),
(5, 'Fundamentals Of Networking', 'CISCO201', '2024-04-25 10:30:57', NULL);


-- Faculty table
CREATE TABLE `faculties` (
    `faculty_id` INT AUTO_INCREMENT PRIMARY KEY,
    `faculty_name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertion statements
INSERT INTO `faculties` (`faculty_name`) VALUES
('Faculty of Science'),
('Faculty of Law'),
('Faculty of Education'),
('Faculty of Agriculture'),
('Faculty of Business Administration and Management'),
('Institute of Languages and Communication Studies'),
('School of Arts and Social Studies'),
('Faculty of Built Environment'),
('Directorate of Postgraduate Studies, Research and Enterprise'),
('Faculty of Health Science'),
('Faculty of Engineering and Applied Sciences');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclasses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblnotice`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblresult`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`StudentId`);

--
-- Indexes for table `course&courseunit_combination`
--
ALTER TABLE `course&courseunit_combination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsubjects`
--
ALTER TABLE `CourseUnits`
  ADD PRIMARY KEY (`CourseUnitId`);


--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblclasses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblnotice`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblresult`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `Students`
  MODIFY `StudentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblsubjectcombination`
--
ALTER TABLE `course&courseunit_combination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tblsubjects`
--
ALTER TABLE `CourseUnits`
  MODIFY `CourseUnitId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;



-- make the adminemails unique and username

ALTER TABLE `admins` 
  MODIFY `UserName` VARCHAR(100) NOT NULL, 
  MODIFY `adminEmail` VARCHAR(100) NOT NULL, 
  ADD CONSTRAINT unique_username UNIQUE (`UserName`), 
  ADD CONSTRAINT unique_admin_email UNIQUE (`adminEmail`);


-- make the students registration number unique and the student email
ALTER TABLE `Students` 
  MODIFY `RegistrationNumber` VARCHAR(100) NOT NULL, 
  MODIFY `StudentEmail` VARCHAR(100) NOT NULL, 
  ADD CONSTRAINT unique_registration_number UNIQUE (`RegistrationNumber`), 
  ADD CONSTRAINT unique_student_email UNIQUE (`StudentEmail`);


-- make the courseunits have uniqur names and code
ALTER TABLE `CourseUnits`
 MODIFY `CourseUnitName` VARCHAR(100) NOT NULL, 
 MODIFY `CourseUnitCode` VARCHAR(100) NOT NULL, 
 ADD CONSTRAINT unique_courseunit_name UNIQUE (`CourseUnitName`), 
 ADD CONSTRAINT unique_courseunit_Code UNIQUE (`CourseUnitCode`);



-- Alter table `admins` to set `UpdationDate` default to CURRENT_TIMESTAMP on update
ALTER TABLE `admins`
MODIFY `updationDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Alter table `courses` to set `UpdationDate` default to CURRENT_TIMESTAMP on update
ALTER TABLE `courses`
MODIFY `UpdationDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Alter table `notices` to set `postingDate` default to CURRENT_TIMESTAMP on update
ALTER TABLE `notices`
MODIFY `postingDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Alter table `results` to set `UpdationDate` default to CURRENT_TIMESTAMP on update
ALTER TABLE `results`
MODIFY `UpdationDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Alter table `Students` to set `UpdationDate` default to CURRENT_TIMESTAMP on update
ALTER TABLE `Students`
MODIFY `UpdationDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Alter table `course&courseunit_combination` to set `Updationdate` default to CURRENT_TIMESTAMP on update
ALTER TABLE `course&courseunit_combination`
MODIFY `Updationdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Alter table `CourseUnits` to set `UpdationDate` default to CURRENT_TIMESTAMP on update
ALTER TABLE `CourseUnits`
MODIFY `UpdationDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;


ALTER TABLE `results` ADD COLUMN `TotalMarks` INT(3) DEFAULT NULL; 

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
