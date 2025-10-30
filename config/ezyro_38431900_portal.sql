-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql304.ezyro.com
-- Generation Time: Sep 05, 2025 at 05:32 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezyro_38431900_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `admin_id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `conpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`admin_id`, `name`, `role`, `username`, `password`, `conpassword`) VALUES
('AD123', 'VIVOR OSCAR MAKAFUI', 'administrator', 'administrator', '$2y$10$.OkYrPuXZD1hS0M07IPQ0eXU4yu93UHphsuzw20f1R0.7gknMTkTW', '$2y$10$3atD.Iu5YtizsOmCfipqKOo4vYHJcrtC69lkYwCcSHJTvVEJ9pBey'),
('AD554', 'ROYAL WEBSTERS', 'administrator', 'SUPER', '$2y$10$b1OuYd9AIW6wbIBzmou71.7sbVm5.TKzzCnnEatV0lUXEvux1Ytr.', '$2y$10$unpgxZziFBP/HyZbNtvseuGxO.xf6phcbMQnOdievIDnV5x.OvmUO');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `date`, `status`) VALUES
(27, 'STD000009', '2025-08-11', 'Present'),
(28, 'STD000010', '2025-08-11', 'Present'),
(29, 'STD000011', '2025-08-11', 'Present'),
(30, 'STD000012', '2025-08-11', 'Present'),
(31, 'STD000013', '2025-08-11', 'Present'),
(32, 'STD000062', '2025-08-11', 'Present'),
(33, 'STD000063', '2025-08-11', 'Present'),
(34, 'STD000064', '2025-08-11', 'Present'),
(35, 'STD000098', '2025-08-11', 'Present'),
(36, 'STD000099', '2025-08-11', 'Present'),
(37, 'STD000100', '2025-08-11', 'Present'),
(38, 'STD000134', '2025-08-11', 'Present'),
(39, 'STD000135', '2025-08-11', 'Present'),
(40, 'STD000136', '2025-08-11', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `class` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `price`, `class`, `created_at`) VALUES
(1, 'COMPUTING', '79.00', 'Basic 7', '2025-09-04 21:10:43'),
(2, 'MATHEMATIC', '89.00', 'Basic 7', '2025-09-04 21:11:07'),
(3, 'ENGLISH', '100.00', 'Basic 7', '2025-09-04 21:11:26'),
(4, 'MATHEMATICS', '152.00', 'Basic 8', '2025-09-04 21:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `checkin_code`
--

CREATE TABLE `checkin_code` (
  `id` int(11) NOT NULL,
  `number` varchar(10) NOT NULL,
  `is_used` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkin_code`
--

INSERT INTO `checkin_code` (`id`, `number`, `is_used`, `created_at`) VALUES
(540, '882894', 0, '2025-04-20 12:41:47'),
(541, '763326', 0, '2025-04-20 12:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` varchar(255) NOT NULL,
  `class_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`) VALUES
('CID0', 'Creche'),
('CID01', 'Nursery 1'),
('CID02', 'Nursery 2'),
('CID03', 'K.G 1'),
('CID04', 'K.G 2'),
('CID05', 'Basic 1'),
('CID06', 'Basic 2'),
('CID07', 'Basic 3'),
('CID08', 'Basic 4'),
('CID09', 'Basic 5'),
('CID10', 'Basic 6'),
('CID11', 'Basic 7'),
('CID12', 'Basic 8'),
('CID13', 'Basic 9');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `expense_date` date NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_structures`
--

CREATE TABLE `fee_structures` (
  `fee_id` int(11) NOT NULL,
  `class_name` varchar(50) DEFAULT NULL,
  `fee_type` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_structures`
--

INSERT INTO `fee_structures` (`fee_id`, `class_name`, `fee_type`, `amount`, `due_date`) VALUES
(5, 'Basic 1', 'Term One - 2025', '330.00', '2025-08-01'),
(6, 'Basic 2', 'Term One - 2025', '330.00', '2025-10-09');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `target_role` varchar(50) NOT NULL COMMENT 'e.g., all, student, staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sender_name` varchar(255) DEFAULT 'Administrator',
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `message`, `target_role`, `created_at`, `sender_name`, `is_read`) VALUES
(4, 'testing', 'all', '2025-08-28 09:54:53', 'Administrator', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `fee_id` int(11) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `receipt_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `student_id`, `fee_id`, `amount_paid`, `payment_method`, `payment_date`, `receipt_number`) VALUES
(6, 'STD000010', 5, '288.00', 'Cash', '2025-09-01 21:30:50', 'RCPT-1756762250606');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `student_id` varchar(100) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`student_id`, `filename`, `filesize`, `filetype`, `upload_date`) VALUES
('STD000021', '2024-2025 Fees Schedule.pdf', 274383, 'application/pdf', '2025-09-04 15:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `school_details`
--

CREATE TABLE `school_details` (
  `id` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `type_of_institution` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `enrollment_capacity` int(11) NOT NULL,
  `facilities` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `academic_year` varchar(50) NOT NULL,
  `color_scheme` varchar(7) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_details`
--

INSERT INTO `school_details` (`id`, `school_name`, `type_of_institution`, `address`, `enrollment_capacity`, `facilities`, `email`, `contact`, `academic_year`, `color_scheme`, `image_path`, `created_at`, `updated_at`) VALUES
(5, 'ROYAL WEBSTERS ACADEMY', 'PRIVATE', 'Akwatia', 500, '14', 'school@mail.com', '+233533519466', '2024/2025', '#2b21c0', 'uploads/photo.jpg', '2025-01-12 21:46:03', '2025-01-27 19:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `mid_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `class` varchar(110) NOT NULL,
  `healthinsur` varchar(255) DEFAULT NULL,
  `curaddress` varchar(255) DEFAULT NULL,
  `cityname` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `join_date` varchar(255) DEFAULT NULL,
  `curr_position` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `conpassword` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `gender`, `first_name`, `mid_name`, `last_name`, `dob`, `number`, `email`, `class`, `healthinsur`, `curaddress`, `cityname`, `qualification`, `join_date`, `curr_position`, `role`, `username`, `password`, `conpassword`) VALUES
('STF000001', 'Male', 'John', '', 'Kuma', '2001-09-24', '233 598 474 785', 'johnkumah@gmail.com', 'Class 3', '65489147', 'KM548', 'Kumasi', 'Degree', '2024-07-09', 'Staff', 'staff', 'johnkuma', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000002', 'Female', 'Ama', '', 'Boateng', '1999-05-12', '233 245 123 456', 'amaboateng@gmail.com', 'Class 2', '78945612', 'HS123', 'Accra', 'Diploma', '2023-11-15', 'Staff', 'staff', 'amaboateng', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000003', 'Male', 'Kwame', '', 'Mensah', '1995-03-01', '233 551 789 012', 'kwamemensah@gmail.com', 'Class 1', '12378945', 'LN789', 'Takoradi', 'Degree', '2022-08-20', 'Staff', 'staff', 'kwamemensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000004', 'Female', 'Adwoa', '', 'Ansah', '2000-11-20', '233 208 901 234', 'adwoaansah@gmail.com', 'Class 4', '45612378', 'GN456', 'Kumasi', 'HND', '2024-01-10', 'Staff', 'staff', 'adwoaansah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000005', 'Male', 'Kofi', '', 'Agyemang', '1998-07-07', '233 543 210 987', 'kofiagyemang@gmail.com', 'Class 3', '98765432', 'AP012', 'Cape Coast', 'Degree', '2023-04-05', 'Staff', 'staff', 'kofiagyemang', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000006', 'Female', 'Akua', '', 'Osei', '1997-02-14', '233 267 890 123', 'akuaosei@gmail.com', 'Class 2', '32198765', 'BT789', 'Accra', 'Diploma', '2022-10-01', 'Staff', 'staff', 'akuaosei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000007', 'Male', 'Yaw', '', 'Owusu', '2002-09-03', '233 599 012 345', 'yawowusu@gmail.com', 'Class 1', '65478912', 'CL345', 'Tamale', 'HND', '2024-06-18', 'Staff', 'staff', 'yawowusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000008', 'Female', 'Afia', '', 'Asare', '1996-04-29', '233 270 123 456', 'afiaasare@gmail.com', 'Class 4', '98712345', 'ER901', 'Kumasi', 'Degree', '2023-01-25', 'Staff', 'staff', 'afiaasare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000009', 'Male', 'Kwabena', '', 'Darko', '1994-12-11', '233 540 890 123', 'kwabenadarko@gmail.com', 'Class 3', '12345678', 'FG567', 'Sunyani', 'Degree', '2022-05-10', 'Staff', 'staff', 'kwabenadarko', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000010', 'Female', 'Yaa', '', 'Mintah', '2001-08-17', '233 205 678 901', 'yaamintah@gmail.com', 'Class 2', '45678901', 'HJ123', 'Accra', 'Diploma', '2024-03-01', 'Staff', 'staff', 'yaamintah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000011', 'Male', 'Ofori', '', 'Asamoah', '1993-01-22', '233 591 234 567', 'oforiasamoah@gmail.com', 'Class 1', '78901234', 'KL678', 'Koforidua', 'Degree', '2021-09-01', 'Staff', 'staff', 'oforiasamoah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000012', 'Female', 'Serwaa', '', 'Boakye', '1998-06-05', '233 248 901 234', 'serwaaboakye@gmail.com', 'Class 4', '21098765', 'MN345', 'Kumasi', 'HND', '2023-08-14', 'Staff', 'staff', 'serwaaboakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000013', 'Male', 'Derrick', '', 'Addo', '2000-03-19', '233 554 321 098', 'derrickaddo@gmail.com', 'Class 3', '54321098', 'PQ901', 'Accra', 'Degree', '2024-02-28', 'Staff', 'staff', 'derrickaddo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000014', 'Female', 'Faustina', '', 'Kyeremeh', '1997-10-25', '233 260 789 012', 'faustinakyeremeh@gmail.com', 'Class 2', '87654321', 'RS123', 'Techiman', 'Diploma', '2023-06-09', 'Staff', 'staff', 'faustinakyeremeh', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000015', 'Male', 'Emmanuel', '', 'Frimpong', '1995-08-08', '233 592 345 678', 'emmanuelfrimpong@gmail.com', 'Class 1', '10987654', 'TU789', 'Kumasi', 'Degree', '2022-03-17', 'Staff', 'staff', 'emmanuelfrimpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000016', 'Female', 'Joyce', '', 'Danquah', '2001-01-30', '233 209 012 345', 'joycedanquah@gmail.com', 'Class 4', '43210987', 'VW456', 'Ho', 'HND', '2024-05-22', 'Staff', 'staff', 'joycedanquah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000017', 'Male', 'Richard', '', 'Ampofo', '1996-11-03', '233 547 890 123', 'richardampofo@gmail.com', 'Class 3', '76543210', 'XY012', 'Accra', 'Degree', '2023-09-01', 'Staff', 'staff', 'richardampofo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000018', 'Female', 'Christiana', '', 'Baah', '1999-04-10', '233 273 456 789', 'christianabaah@gmail.com', 'Class 2', '09876543', 'ZA789', 'Kumasi', 'Diploma', '2022-12-05', 'Staff', 'staff', 'christianabaah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000019', 'Male', 'George', '', 'Sarpong', '2000-07-16', '233 550 123 456', 'georgesarpong@gmail.com', 'Class 1', '32109876', 'BC345', 'Takoradi', 'HND', '2024-01-18', 'Staff', 'staff', 'georgesarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000020', 'Female', 'Mercy', '', 'Opoku', '1994-09-28', '233 204 567 890', 'mercyopoku@gmail.com', 'Class 4', '65432109', 'DE901', 'Accra', 'Degree', '2023-03-07', 'Staff', 'staff', 'mercyopoku', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000021', 'Male', 'Joseph', '', 'Appiah', '1992-02-09', '233 596 789 012', 'josephappiah@gmail.com', 'Class 3', '98765432', 'FG567', 'Kumasi', 'Degree', '2022-07-20', 'Staff', 'staff', 'josephappiah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000022', 'Female', 'Elizabeth', '', 'Owusu-Ansah', '1997-07-23', '233 241 234 567', 'elizabethowusuansah@gmail.com', 'Class 2', '21098765', 'HI123', 'Cape Coast', 'Diploma', '2023-11-01', 'Staff', 'staff', 'elizabowo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000023', 'Male', 'David', '', 'Osei-Tutu', '1996-03-05', '233 558 901 234', 'davidoseitutu@gmail.com', 'Class 1', '54321098', 'JK789', 'Accra', 'HND', '2024-04-10', 'Staff', 'staff', 'davidoos', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000024', 'Female', 'Patricia', '', 'Mensah', '2000-12-18', '233 266 789 012', 'patriciamensah@gmail.com', 'Class 4', '87654321', 'LM456', 'Sunyani', 'Degree', '2023-02-15', 'Staff', 'staff', 'patriciamensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000025', 'Male', 'Samuel', '', 'Opare', '1993-05-01', '233 597 890 123', 'samuelopare@gmail.com', 'Class 3', '10987654', 'NO012', 'Kumasi', 'Degree', '2022-09-25', 'Staff', 'staff', 'samuelopare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000026', 'Female', 'Linda', '', 'Agyapong', '1998-08-02', '233 203 456 789', 'lindaagyapong@gmail.com', 'Class 2', '43210987', 'PQ789', 'Accra', 'Diploma', '2024-06-03', 'Staff', 'staff', 'lindaagyapong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000027', 'Male', 'Peter', '', 'Akoto', '2001-04-15', '233 549 012 345', 'peterakoto@gmail.com', 'Class 1', '76543210', 'RS345', 'Koforidua', 'HND', '2023-01-08', 'Staff', 'staff', 'peterakoto', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000028', 'Female', 'Diana', '', 'Owusu', '1995-10-09', '233 275 678 901', 'dianaowusu@gmail.com', 'Class 4', '09876543', 'TU901', 'Kumasi', 'Degree', '2022-04-20', 'Staff', 'staff', 'dianaowusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000029', 'Male', 'Frank', '', 'Donkor', '1994-01-27', '233 552 345 678', 'frankdonkor@gmail.com', 'Class 3', '32109876', 'VW567', 'Takoradi', 'Degree', '2024-03-11', 'Staff', 'staff', 'frankdonkor', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000030', 'Female', 'Sandra', '', 'Boakye', '1999-06-14', '233 201 234 567', 'sandraboakye@gmail.com', 'Class 2', '65432109', 'XY123', 'Accra', 'Diploma', '2023-07-01', 'Staff', 'staff', 'sandraboakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000031', 'Male', 'Louis', '', 'Annan', '1997-03-08', '233 593 456 789', 'louisannan@gmail.com', 'Class 1', '98765432', 'ZA789', 'Tamale', 'HND', '2022-11-19', 'Staff', 'staff', 'louisannan', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000032', 'Female', 'Vivian', '', 'Kwakye', '2000-09-01', '233 240 123 456', 'viviankwakye@gmail.com', 'Class 4', '21098765', 'BC345', 'Kumasi', 'Degree', '2024-05-06', 'Staff', 'staff', 'viviankwakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000033', 'Male', 'Daniel', '', 'Ofori', '1992-07-10', '233 556 789 012', 'danielofori@gmail.com', 'Class 3', '54321098', 'DE901', 'Accra', 'Degree', '2023-09-12', 'Staff', 'staff', 'danielofori', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000034', 'Female', 'Hannah', '', 'Opare', '1996-02-20', '233 268 901 234', 'hannahopare@gmail.com', 'Class 2', '87654321', 'FG567', 'Cape Coast', 'Diploma', '2022-06-25', 'Staff', 'staff', 'hannahopare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000035', 'Male', 'Kenneth', '', 'Boadi', '1998-11-05', '233 590 123 456', 'kennethboadi@gmail.com', 'Class 1', '10987654', 'HI123', 'Sunyani', 'HND', '2024-01-03', 'Staff', 'staff', 'kennethboadi', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000036', 'Female', 'Theresa', '', 'Adjei', '2001-05-18', '233 206 789 012', 'theresaadjei@gmail.com', 'Class 4', '43210987', 'JK789', 'Kumasi', 'Degree', '2023-04-19', 'Staff', 'staff', 'theresaadjei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000037', 'Male', 'Maxwell', '', 'Amoah', '1995-09-21', '233 541 234 567', 'maxwellamoah@gmail.com', 'Class 3', '76543210', 'LM456', 'Accra', 'Degree', '2022-10-08', 'Staff', 'staff', 'maxwellamoah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000038', 'Female', 'Rebecca', '', 'Dankwa', '1999-01-04', '233 277 890 123', 'rebeccadankwa@gmail.com', 'Class 2', '09876543', 'NO012', 'Takoradi', 'Diploma', '2024-02-01', 'Staff', 'staff', 'rebeccadankwa', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000039', 'Male', 'Kelvin', '', 'Abban', '2000-06-29', '233 553 456 789', 'kelvinabban@gmail.com', 'Class 1', '32109876', 'PQ789', 'Koforidua', 'HND', '2023-06-16', 'Staff', 'staff', 'kelvinabban', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000040', 'Female', 'Dorothy', '', 'Acquah', '1994-03-12', '233 202 345 678', 'dorothyacquah@gmail.com', 'Class 4', '65432109', 'RS345', 'Accra', 'Degree', '2022-12-10', 'Staff', 'staff', 'dorothyacquah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000041', 'Male', 'Dennis', '', 'Boateng', '1993-08-07', '233 595 678 901', 'dennisboateng@gmail.com', 'Class 3', '98765432', 'TU901', 'Kumasi', 'Degree', '2024-04-05', 'Staff', 'staff', 'dennisboateng', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000042', 'Female', 'Philomena', '', 'Asante', '1998-04-24', '233 242 345 678', 'philomenaasante@gmail.com', 'Class 2', '21098765', 'VW567', 'Cape Coast', 'Diploma', '2023-08-28', 'Staff', 'staff', 'philomenaasante', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000043', 'Male', 'Solomon', '', 'Owusu', '2001-10-10', '233 557 890 123', 'solomonowusu@gmail.com', 'Class 1', '54321098', 'XY123', 'Sunyani', 'HND', '2022-05-15', 'Staff', 'staff', 'solomonowusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000044', 'Female', 'Bridget', '', 'Nkrumah', '1995-12-03', '233 269 012 345', 'bridgetnkrumah@gmail.com', 'Class 4', '87654321', 'ZA789', 'Accra', 'Degree', '2024-07-01', 'Staff', 'staff', 'bridgetnkrumah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000045', 'Male', 'Caleb', '', 'Obeng', '1997-06-06', '233 594 567 890', 'calebobeng@gmail.com', 'Class 3', '10987654', 'BC345', 'Kumasi', 'Degree', '2023-03-20', 'Staff', 'staff', 'calebobeng', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy');

-- --------------------------------------------------------

--
-- Table structure for table `staff_attendance`
--

CREATE TABLE `staff_attendance` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `check_in_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_classes`
--

CREATE TABLE `staff_classes` (
  `assignment_id` int(11) NOT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `class_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_classes`
--

INSERT INTO `staff_classes` (`assignment_id`, `staff_id`, `class_name`) VALUES
(12, 'STF000003', 'Basic 1'),
(13, 'STF000001', 'Creche'),
(14, 'STF000002', 'Creche'),
(15, 'STF000004', 'Nursery 1'),
(16, 'STF000006', 'Basic 3');

-- --------------------------------------------------------

--
-- Table structure for table `staff_count`
--

CREATE TABLE `staff_count` (
  `total_staffs` bigint(21) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `mid_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `class` varchar(25) NOT NULL,
  `healthinsur` int(11) NOT NULL,
  `curaddress` varchar(255) NOT NULL,
  `cityname` varchar(255) NOT NULL,
  `parent_first_name` varchar(255) NOT NULL,
  `parent_mid_name` varchar(255) NOT NULL,
  `parent_last_name` varchar(255) NOT NULL,
  `parent_email` varchar(255) NOT NULL,
  `parent_number` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT '''''''student''''''',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `conpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `gender`, `first_name`, `mid_name`, `last_name`, `dob`, `number`, `email`, `class`, `healthinsur`, `curaddress`, `cityname`, `parent_first_name`, `parent_mid_name`, `parent_last_name`, `parent_email`, `parent_number`, `role`, `username`, `password`, `conpassword`) VALUES
('STD000001', 'Female', 'Ama', 'Adwoa', 'Mensah', '2019-01-15', '233 245 111 222', 'amemensah@gmail.com', 'Creche', 10101010, 'P101', 'Accra', 'Kwame', 'Boateng', 'Mensah', 'kwameboateng@gmail.com', '233 245 333 444', 'student', 'ama-mensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000002', 'Male', 'Kwame', 'Kofi', 'Adu', '2019-03-20', '233 555 111 222', 'kwameadu@gmail.com', 'Creche', 10101011, 'P102', 'Kumasi', 'Ama', 'Akua', 'Adu', 'amaakua@gmail.com', '233 555 333 444', 'student', 'kwame-adu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000003', 'Female', 'Akua', 'Yaa', 'Sarpong', '2018-05-10', '233 200 111 222', 'akuaasarpong@gmail.com', 'Nursery 1', 10101012, 'P103', 'Tamale', 'Yaw', 'Kofi', 'Sarpong', 'yawkofi@gmail.com', '233 200 333 444', 'student', 'akua-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000004', 'Male', 'Yaw', 'Kwame', 'Ntim', '2018-07-25', '233 244 111 222', 'yawntim@gmail.com', 'Nursery 1', 10101013, 'P104', 'Sekondi', 'Adwoa', 'Ama', 'Ntim', 'adwoaama@gmail.com', '233 244 333 444', 'student', 'yaw-ntim', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000005', 'Female', 'Adwoa', 'Ama', 'Frimpong', '2018-09-02', '233 500 111 222', 'adwoafrimpong@gmail.com', 'Nursery 1', 10101014, 'P105', 'Cape Coast', 'Kwasi', 'Osei', 'Frimpong', 'kwasifrimpong@gmail.com', '233 500 333 444', 'student', 'adwoa-frimpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000006', 'Male', 'Kofi', 'Yaw', 'Appiah', '2017-02-14', '233 201 111 222', 'kofiappiah@gmail.com', 'Nursery 2', 10101015, 'P106', 'Wa', 'Akosua', 'Adwoa', 'Appiah', 'akosuaadwoa@gmail.com', '233 201 333 444', 'student', 'kofi-appiah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000007', 'Female', 'Akosua', 'Yaa', 'Danquah', '2017-04-28', '233 544 111 222', 'akosuadanq@gmail.com', 'Nursery 2', 10101016, 'P107', 'Bolgatanga', 'Kwame', 'Kofi', 'Danquah', 'kwamedanquah@gmail.com', '233 544 333 444', 'student', 'akosua-danquah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000008', 'Male', 'Kwasi', 'Kojo', 'Nkrumah', '2017-06-12', '233 266 111 222', 'kwasinkrumah@gmail.com', 'Nursery 2', 10101017, 'P108', 'Ho', 'Ama', 'Akosua', 'Nkrumah', 'amankrumah@gmail.com', '233 266 333 444', 'student', 'kwasi-nkrumah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000009', 'Female', 'Yaa', 'Adwoa', 'Owusu', '2016-08-01', '233 577 111 222', 'yaaowusu@gmail.com', 'Basic 1', 10101018, 'P109', 'Sunyani', 'Kofi', 'Yaw', 'Owusu', 'kofiowusu@gmail.com', '233 577 333 444', 'student', 'yaa-owusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j\r\n/mSLy'),
('STD000010', 'Male', 'Kojo', 'Kwame', 'Boateng', '2016-01-05', '233 243 111 222', 'kojoboateng@gmail.com', 'Basic 1', 10101019, 'P110', 'Techiman', 'Adwoa', 'Akosua', 'Boateng', 'adwoaboateng@gmail.com', '233 243 333 444', 'student', 'kojo-boateng', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000011', 'Female', 'Adwoa', 'Akua', 'Osei', '2016-03-18', '233 502 111 222', 'adwoaosei@gmail.com', 'Basic 1', 10101020, 'P111', 'Hohoe', 'Kwasi', 'Kojo', 'Osei', 'kwasio@gmail.com', '233 502 333 444', 'student', 'adwoa-osei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000012', 'Male', 'Kwame', 'Adjei', 'Manu', '2016-05-22', '233 241 111 222', 'kwamemanu@gmail.com', 'Basic 1', 10101021, 'P112', 'Koforidua', 'Akua', 'Yaa', 'Manu', 'akuamanu@gmail.com', '233 241 333 444', 'student', 'kwame-manu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000013', 'Female', 'Abena', 'Akosua', 'Dabo', '2016-07-30', '233 551 111 222', 'abenadabo@gmail.com', 'Basic 1', 10101022, 'P113', 'Tarkwa', 'Yaw', 'Kofi', 'Dabo', 'yawkofi@gmail.com', '233 551 333 444', 'student', 'abena-dabo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000014', 'Male', 'Yaw', 'Kofi', 'Asare', '2015-09-11', '233 203 111 222', 'yawasare@gmail.com', 'Basic 2', 10101023, 'P114', 'Berekum', 'Ama', 'Adwoa', 'Asare', 'amaasare@gmail.com', '233 203 333 444', 'student', 'yaw-asare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000015', 'Female', 'Adwoa', 'Yaa', 'Ansah', '2015-11-25', '233 543 111 222', 'adwoaansah@gmail.com', 'Basic 2', 10101024, 'P115', 'Oda', 'Kwame', 'Kofi', 'Ansah', 'kwameansah@gmail.com', '233 543 333 444', 'student', 'adwoa-ansah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000016', 'Male', 'Kofi', 'Yaw', 'Boakye', '2015-01-08', '233 262 111 222', 'kofiboakye@gmail.com', 'Basic 2', 10101025, 'P116', 'Nkawkaw', 'Akua', 'Adwoa', 'Boakye', 'akuaboakye@gmail.com', '233 262 333 444', 'student', 'kofi-boakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000017', 'Female', 'Akua', 'Ama', 'Agyemang', '2015-03-12', '233 571 111 222', 'akuaagyemang@gmail.com', 'Basic 2', 10101026, 'P117', 'Tema', 'Yaw', 'Kwame', 'Agyemang', 'yawagyemang@gmail.com', '233 571 333 444', 'student', 'akua-agyemang', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000018', 'Male', 'Kwasi', 'Kofi', 'Gyasi', '2015-05-20', '233 240 111 222', 'kwasigyasi@gmail.com', 'Basic 2', 10101027, 'P118', 'Aflao', 'Abena', 'Yaa', 'Gyasi', 'abenagyasi@gmail.com', '233 240 333 444', 'student', 'kwasi-gyasi', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000019', 'Female', 'Yaa', 'Akua', 'Mensah', '2014-07-07', '233 509 111 222', 'yaamensah@gmail.com', 'Basic 3', 10101028, 'P119', 'Bawku', 'Kofi', 'Adjei', 'Mensah', 'kofimensah@gmail.com', '233 509 333 444', 'student', 'yaa-mensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000020', 'Male', 'Kojo', 'Osei', 'Sarpong', '2014-09-19', '233 208 111 222', 'kojosarpong@gmail.com', 'Basic 3', 10101029, 'P120', 'Tema', 'Adwoa', 'Akosua', 'Sarpong', 'adwoasarpong@gmail.com', '233 208 333 444', 'student', 'kojo-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000021', 'Female', 'Adwoa', 'Yaa', 'Dankwa', '2014-11-03', '233 548 111 222', 'adwoadankwa@gmail.com', 'Basic 3', 10101030, 'P121', 'Wa', 'Kwame', 'Kofi', 'Dankwa', 'kwamedankwa@gmail.com', '233 548 333 444', 'student', 'adwoa-dankwa', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000022', 'Male', 'Kwame', 'Kojo', 'Appiah', '2014-01-28', '233 267 111 222', 'kwameappiah@gmail.com', 'Basic 3', 10101031, 'P122', 'Ho', 'Akosua', 'Adwoa', 'Appiah', 'akosuaappiah@gmail.com', '233 267 333 444', 'student', 'kwame-appiah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000023', 'Female', 'Akosua', 'Yaa', 'Owusu', '2014-03-14', '233 576 111 222', 'akosuaowusu@gmail.com', 'Basic 3', 10101032, 'P123', 'Sunyani', 'Yaw', 'Kofi', 'Owusu', 'yawowusu@gmail.com', '233 576 333 444', 'student', 'akosua-owusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000024', 'Male', 'Yaw', 'Kofi', 'Boahen', '2013-05-18', '233 245 111 222', 'yawboahen@gmail.com', 'Basic 4', 10101033, 'P124', 'Berekum', 'Ama', 'Akua', 'Boahen', 'amaboahen@gmail.com', '233 245 333 444', 'student', 'yaw-boahen', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000025', 'Female', 'Ama', 'Adwoa', 'Addai', '2013-07-29', '233 554 111 222', 'amaaddai@gmail.com', 'Basic 4', 10101034, 'P125', 'Oda', 'Kwame', 'Kofi', 'Addai', 'kwameaddai@gmail.com', '233 554 333 444', 'student', 'ama-addai', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000026', 'Male', 'Kwame', 'Kwasi', 'Asante', '2013-09-02', '233 204 111 222', 'kwameasante@gmail.com', 'Basic 4', 10101035, 'P126', 'Nkawkaw', 'Akua', 'Yaa', 'Asante', 'akuaasante@gmail.com', '233 204 333 444', 'student', 'kwame-asante', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000027', 'Female', 'Akua', 'Adwoa', 'Ampofo', '2013-11-15', '233 541 111 222', 'akuaampofo@gmail.com', 'Basic 4', 10101036, 'P127', 'Tema', 'Yaw', 'Kojo', 'Ampofo', 'yawampofo@gmail.com', '233 541 333 444', 'student', 'akua-ampofo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000028', 'Male', 'Kofi', 'Yaw', 'Darko', '2013-01-10', '233 261 111 222', 'kofidarko@gmail.com', 'Basic 4', 10101037, 'P128', 'Aflao', 'Abena', 'Ama', 'Darko', 'abenadarko@gmail.com', '233 261 333 444', 'student', 'kofi-darko', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000029', 'Female', 'Yaa', 'Akosua', 'Agyei', '2012-03-24', '233 570 111 222', 'yaaagyei@gmail.com', 'Basic 5', 10101038, 'P129', 'Bawku', 'Kofi', 'Kwame', 'Agyei', 'kofiagyei@gmail.com', '233 570 333 444', 'student', 'yaa-agyei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000030', 'Male', 'Kojo', 'Kwame', 'Mensah', '2012-05-08', '233 249 111 222', 'kojomensah@gmail.com', 'Basic 5', 10101039, 'P130', 'Techiman', 'Adwoa', 'Yaa', 'Mensah', 'adwoamensah@gmail.com', '233 249 333 444', 'student', 'kojo-mensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000031', 'Female', 'Akua', 'Adwoa', 'Sarpong', '2012-07-16', '233 508 111 222', 'akuasarpong@gmail.com', 'Basic 5', 10101040, 'P131', 'Hohoe', 'Kwame', 'Kofi', 'Sarpong', 'kwamesarpong@gmail.com', '233 508 333 444', 'student', 'akua-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000032', 'Male', 'Yaw', 'Kofi', 'Asare', '2012-09-20', '233 207 111 222', 'yawasare@gmail.com', 'Basic 5', 10101041, 'P132', 'Koforidua', 'Ama', 'Akua', 'Asare', 'amaasare@gmail.com', '233 207 333 444', 'student', 'yaw-asare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000033', 'Female', 'Adwoa', 'Yaa', 'Adu', '2012-11-05', '233 547 111 222', 'adwoaadu@gmail.com', 'Basic 5', 10101042, 'P133', 'Tarkwa', 'Kwasi', 'Kojo', 'Adu', 'kwasiadu@gmail.com', '233 547 333 444', 'student', 'adwoa-adu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000034', 'Male', 'Kofi', 'Adjei', 'Annan', '2011-01-20', '233 266 111 222', 'kofiannan@gmail.com', 'Basic 6', 10101043, 'P134', 'Berekum', 'Akosua', 'Ama', 'Annan', 'akosuaannan@gmail.com', '233 266 333 444', 'student', 'kofi-annan', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000035', 'Female', 'Akua', 'Yaa', 'Boakye', '2011-03-15', '233 575 111 222', 'akuaboakye@gmail.com', 'Basic 6', 10101044, 'P135', 'Oda', 'Yaw', 'Kwame', 'Boakye', 'yawboakye@gmail.com', '233 575 333 444', 'student', 'akua-boakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000036', 'Male', 'Kwame', 'Kofi', 'Gyasi', '2011-05-29', '233 244 111 222', 'kwamegyasi@gmail.com', 'Basic 6', 10101045, 'P136', 'Nkawkaw', 'Abena', 'Akua', 'Gyasi', 'abenagyasi@gmail.com', '233 244 333 444', 'student', 'kwame-gyasi', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000037', 'Female', 'Abena', 'Adwoa', 'Mensah', '2011-07-13', '233 553 111 222', 'abenamensah@gmail.com', 'Basic 6', 10101046, 'P137', 'Tema', 'Kofi', 'Osei', 'Mensah', 'kofimensah@gmail.com', '233 553 333 444', 'student', 'abena-mensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000038', 'Male', 'Yaw', 'Kojo', 'Sarpong', '2011-09-27', '233 203 111 222', 'yawsarpong@gmail.com', 'Basic 6', 10101047, 'P138', 'Aflao', 'Ama', 'Akua', 'Sarpong', 'amasarpong@gmail.com', '233 203 333 444', 'student', 'yaw-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000039', 'Female', 'Ama', 'Yaa', 'Dankwa', '2010-11-04', '233 542 111 222', 'amadankwa@gmail.com', 'Basic 7', 10101048, 'P139', 'Bawku', 'Kwame', 'Kofi', 'Dankwa', 'kwamedankwa@gmail.com', '233 542 333 444', 'student', 'ama-dankwa', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000040', 'Male', 'Kwame', 'Kofi', 'Appiah', '2010-01-18', '233 262 111 222', 'kwameappiah@gmail.com', 'Basic 7', 10101049, 'P140', 'Techiman', 'Akosua', 'Adwoa', 'Appiah', 'akosuaappiah@gmail.com', '233 262 333 444', 'student', 'kwame-appiah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000041', 'Female', 'Adwoa', 'Akosua', 'Owusu', '2010-03-02', '233 571 111 222', 'adwoaowusu@gmail.com', 'Basic 7', 10101050, 'P141', 'Hohoe', 'Yaw', 'Kojo', 'Owusu', 'yawowusu@gmail.com', '233 571 333 444', 'student', 'adwoa-owusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000042', 'Male', 'Kofi', 'Kwame', 'Boahen', '2010-05-16', '233 240 111 222', 'kofiboahen@gmail.com', 'Basic 7', 10101051, 'P142', 'Koforidua', 'Akua', 'Yaa', 'Boahen', 'akuaboahen@gmail.com', '233 240 333 444', 'student', 'kofi-boahen', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000043', 'Female', 'Akua', 'Adwoa', 'Addai', '2010-07-28', '233 509 111 222', 'akuaaddai@gmail.com', 'Basic 7', 10101052, 'P143', 'Tarkwa', 'Kofi', 'Yaw', 'Addai', 'kofiaddai@gmail.com', '233 509 333 444', 'student', 'akua-addai', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000044', 'Male', 'Yaw', 'Kofi', 'Asante', '2009-09-12', '233 208 111 222', 'yawasante@gmail.com', 'Basic 8', 10101053, 'P144', 'Berekum', 'Ama', 'Akua', 'Asante', 'amaasante@gmail.com', '233 208 333 444', 'student', 'yaw-asante', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000045', 'Female', 'Ama', 'Adwoa', 'Ampofo', '2009-11-26', '233 548 111 222', 'amaampofo@gmail.com', 'Basic 8', 10101054, 'P145', 'Oda', 'Kwame', 'Kofi', 'Ampofo', 'kwameampofo@gmail.com', '233 548 333 444', 'student', 'ama-ampofo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000046', 'Male', 'Kwame', 'Kwasi', 'Darko', '2009-01-10', '233 267 111 222', 'kwamedarko@gmail.com', 'Basic 8', 10101055, 'P146', 'Nkawkaw', 'Akua', 'Yaa', 'Darko', 'akuadarko@gmail.com', '233 267 333 444', 'student', 'kwame-darko', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000047', 'Female', 'Akua', 'Adwoa', 'Agyei', '2009-03-24', '233 576 111 222', 'akuaagyei@gmail.com', 'Basic 8', 10101056, 'P147', 'Tema', 'Yaw', 'Kojo', 'Agyei', 'yawagyei@gmail.com', '233 576 333 444', 'student', 'akua-agyei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000048', 'Male', 'Kofi', 'Yaw', 'Mensah', '2009-05-08', '233 245 111 222', 'kofimensah@gmail.com', 'Basic 8', 10101057, 'P148', 'Aflao', 'Abena', 'Akua', 'Mensah', 'abenamensah@gmail.com', '233 245 333 444', 'student', 'kofi-mensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000049', 'Female', 'Yaa', 'Akosua', 'Sarpong', '2008-07-16', '233 554 111 222', 'yaasarpong@gmail.com', 'Basic 9', 10101058, 'P149', 'Bawku', 'Kofi', 'Osei', 'Sarpong', 'kofisarpong@gmail.com', '233 554 333 444', 'student', 'yaa-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000050', 'Male', 'Kojo', 'Kwame', 'Adu', '2008-09-20', '233 204 111 222', 'kojoadu@gmail.com', 'Basic 9', 10101059, 'P150', 'Techiman', 'Adwoa', 'Yaa', 'Adu', 'adwoaadu@gmail.com', '233 204 333 444', 'student', 'kojo-adu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000051', 'Female', 'Akua', 'Adwoa', 'Asare', '2008-11-05', '233 541 111 222', 'akuaasare@gmail.com', 'Basic 9', 10101060, 'P151', 'Hohoe', 'Kwame', 'Kofi', 'Asare', 'kwameasare@gmail.com', '233 541 333 444', 'student', 'akua-asare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000052', 'Male', 'Yaw', 'Kofi', 'Annan', '2008-01-20', '233 261 111 222', 'yawanann@gmail.com', 'Basic 9', 10101061, 'P152', 'Koforidua', 'Ama', 'Akua', 'Annan', 'amaannan@gmail.com', '233 261 333 444', 'student', 'yaw-annan', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000053', 'Female', 'Adwoa', 'Yaa', 'Boakye', '2008-03-15', '233 570 111 222', 'adwoaboakye@gmail.com', 'Basic 9', 10101062, 'P153', 'Tarkwa', 'Kwasi', 'Kojo', 'Boakye', 'kwasiboakye@gmail.com', '233 570 333 444', 'student', 'adwoa-boakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000054', 'Male', 'Kwame', 'Kofi', 'Gyasi', '2019-02-01', '233 241 111 222', 'kwamegyasi2@gmail.com', 'Creche', 10101063, 'P154', 'Accra', 'Akua', 'Adwoa', 'Gyasi', 'akuagyasi@gmail.com', '233 241 333 444', 'student', 'kwame-gyasi2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000055', 'Female', 'Adwoa', 'Akua', 'Mensah', '2019-04-10', '233 500 111 222', 'adwoamensah2@gmail.com', 'Creche', 10101064, 'P155', 'Kumasi', 'Yaw', 'Kwame', 'Mensah', 'yawnmensah@gmail.com', '233 500 333 444', 'student', 'adwoa-mensah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000056', 'Male', 'Yaw', 'Kojo', 'Sarpong', '2018-06-18', '233 200 111 222', 'yawsarpong2@gmail.com', 'Nursery 1', 10101065, 'P156', 'Tamale', 'Ama', 'Akosua', 'Sarpong', 'amasarpong2@gmail.com', '233 200 333 444', 'student', 'yaw-sarpong2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000057', 'Female', 'Ama', 'Yaa', 'Dankwa', '2018-08-25', '233 555 111 222', 'amadankwa2@gmail.com', 'Nursery 1', 10101066, 'P157', 'Sekondi', 'Kwame', 'Kofi', 'Dankwa', 'kwamedankwa2@gmail.com', '233 555 333 444', 'student', 'ama-dankwa2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000058', 'Male', 'Kofi', 'Kwame', 'Appiah', '2018-10-09', '233 244 111 222', 'kofiappiah2@gmail.com', 'Nursery 1', 10101067, 'P158', 'Cape Coast', 'Akosua', 'Adwoa', 'Appiah', 'akosuaappiah2@gmail.com', '233 244 333 444', 'student', 'kofi-appiah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000059', 'Female', 'Adwoa', 'Akosua', 'Owusu', '2017-12-14', '233 500 111 222', 'adwoaowusu2@gmail.com', 'Nursery 2', 10101068, 'P159', 'Wa', 'Yaw', 'Kojo', 'Owusu', 'yawowusu2@gmail.com', '233 500 333 444', 'student', 'adwoa-owusu2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000060', 'Male', 'Kwasi', 'Kofi', 'Boahen', '2017-02-28', '233 201 111 222', 'kwasiboahen@gmail.com', 'Nursery 2', 10101069, 'P160', 'Bolgatanga', 'Akua', 'Yaa', 'Boahen', 'akuaboahen2@gmail.com', '233 201 333 444', 'student', 'kwasi-boahen', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000061', 'Female', 'Akua', 'Adwoa', 'Addai', '2017-04-05', '233 544 111 222', 'akuaaddai2@gmail.com', 'Nursery 2', 10101070, 'P161', 'Ho', 'Kofi', 'Yaw', 'Addai', 'kofiaddai2@gmail.com', '233 544 333 444', 'student', 'akua-addai2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000062', 'Male', 'Yaw', 'Kwame', 'Asante', '2016-06-20', '233 266 111 222', 'yawasante2@gmail.com', 'Basic 1', 10101071, 'P162', 'Sunyani', 'Ama', 'Akua', 'Asante', 'amaasante2@gmail.com', '233 266 333 444', 'student', 'yaw-asante2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000063', 'Female', 'Ama', 'Adwoa', 'Ampofo', '2016-08-01', '233 577 111 222', 'amaampofo2@gmail.com', 'Basic 1', 10101072, 'P163', 'Techiman', 'Kwame', 'Kofi', 'Ampofo', 'kwameampofo2@gmail.com', '233 577 333 444', 'student', 'ama-ampofo2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000064', 'Male', 'Kwame', 'Kofi', 'Darko', '2016-10-15', '233 243 111 222', 'kwamedarko2@gmail.com', 'Basic 1', 10101073, 'P164', 'Hohoe', 'Akua', 'Yaa', 'Darko', 'akuadarko2@gmail.com', '233 243 333 444', 'student', 'kwame-darko2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000065', 'Female', 'Akua', 'Adwoa', 'Agyei', '2015-12-22', '233 502 111 222', 'akuaagyei2@gmail.com', 'Basic 2', 10101074, 'P165', 'Koforidua', 'Yaw', 'Kojo', 'Agyei', 'yawagyei2@gmail.com', '233 502 333 444', 'student', 'akua-agyei2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000066', 'Male', 'Kofi', 'Yaw', 'Mensah', '2015-02-05', '233 241 111 222', 'kofimensah2@gmail.com', 'Basic 2', 10101075, 'P166', 'Tarkwa', 'Abena', 'Akua', 'Mensah', 'abenamensah2@gmail.com', '233 241 333 444', 'student', 'kofi-mensah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000067', 'Female', 'Yaa', 'Akosua', 'Sarpong', '2015-04-14', '233 551 111 222', 'yaasarpong2@gmail.com', 'Basic 2', 10101076, 'P167', 'Berekum', 'Kofi', 'Osei', 'Sarpong', 'kofisarpong2@gmail.com', '233 551 333 444', 'student', 'yaa-sarpong2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000068', 'Male', 'Kojo', 'Kwame', 'Adu', '2014-06-20', '233 203 111 222', 'kojoadu2@gmail.com', 'Basic 3', 10101077, 'P168', 'Oda', 'Adwoa', 'Yaa', 'Adu', 'adwoaadu2@gmail.com', '233 203 333 444', 'student', 'kojo-adu2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000069', 'Female', 'Akua', 'Adwoa', 'Asare', '2014-08-01', '233 543 111 222', 'akuaasare2@gmail.com', 'Basic 3', 10101078, 'P169', 'Nkawkaw', 'Kwame', 'Kofi', 'Asare', 'kwameasare2@gmail.com', '233 543 333 444', 'student', 'akua-asare2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000070', 'Male', 'Yaw', 'Kofi', 'Annan', '2014-10-15', '233 262 111 222', 'yawannan2@gmail.com', 'Basic 3', 10101079, 'P170', 'Tema', 'Ama', 'Akua', 'Annan', 'amaannan2@gmail.com', '233 262 333 444', 'student', 'yaw-annan2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000071', 'Female', 'Adwoa', 'Yaa', 'Boakye', '2013-12-22', '233 571 111 222', 'adwoaboakye2@gmail.com', 'Basic 4', 10101080, 'P171', 'Aflao', 'Kwasi', 'Kojo', 'Boakye', 'kwasiboakye2@gmail.com', '233 571 333 444', 'student', 'adwoa-boakye2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000072', 'Male', 'Kofi', 'Adjei', 'Gyasi', '2013-02-05', '233 240 111 222', 'kofigyasi2@gmail.com', 'Basic 4', 10101081, 'P172', 'Bawku', 'Akosua', 'Ama', 'Gyasi', 'akosuaagyasi@gmail.com', '233 240 333 444', 'student', 'kofi-gyasi2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000073', 'Female', 'Akua', 'Yaa', 'Mensah', '2013-04-14', '233 509 111 222', 'akuamensah2@gmail.com', 'Basic 4', 10101082, 'P173', 'Techiman', 'Yaw', 'Kwame', 'Mensah', 'yawmensah2@gmail.com', '233 509 333 444', 'student', 'akua-mensah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000074', 'Male', 'Kwame', 'Kofi', 'Sarpong', '2012-06-20', '233 208 111 222', 'kwamesarpong2@gmail.com', 'Basic 5', 10101083, 'P174', 'Hohoe', 'Abena', 'Akua', 'Sarpong', 'abenasarpong@gmail.com', '233 208 333 444', 'student', 'kwame-sarpong2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000075', 'Female', 'Abena', 'Adwoa', 'Dankwa', '2012-08-01', '233 548 111 222', 'abenadankwa@gmail.com', 'Basic 5', 10101084, 'P175', 'Koforidua', 'Kofi', 'Osei', 'Dankwa', 'kofidankwa@gmail.com', '233 548 333 444', 'student', 'abena-dankwa', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000076', 'Male', 'Yaw', 'Kojo', 'Appiah', '2012-10-15', '233 267 111 222', 'yawappiah2@gmail.com', 'Basic 5', 10101085, 'P176', 'Tarkwa', 'Ama', 'Akua', 'Appiah', 'amaappiah@gmail.com', '233 267 333 444', 'student', 'yaw-appiah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000077', 'Female', 'Akua', 'Yaa', 'Owusu', '2011-12-22', '233 576 111 222', 'akuaowusu2@gmail.com', 'Basic 6', 10101086, 'P177', 'Berekum', 'Kwame', 'Kofi', 'Owusu', 'kwameowusu2@gmail.com', '233 576 333 444', 'student', 'akua-owusu2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000078', 'Male', 'Kofi', 'Kwame', 'Boahen', '2011-02-05', '233 245 111 222', 'kofiboahen2@gmail.com', 'Basic 6', 10101087, 'P178', 'Oda', 'Akosua', 'Adwoa', 'Boahen', 'akosuaboahen@gmail.com', '233 245 333 444', 'student', 'kofi-boahen2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000079', 'Female', 'Adwoa', 'Akosua', 'Addai', '2011-04-14', '233 554 111 222', 'adwoaaddai2@gmail.com', 'Basic 6', 10101088, 'P179', 'Nkawkaw', 'Yaw', 'Kojo', 'Addai', 'yawaddai@gmail.com', '233 554 333 444', 'student', 'adwoa-addai2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000080', 'Male', 'Kwame', 'Kwasi', 'Asante', '2010-06-20', '233 204 111 222', 'kwameasante2@gmail.com', 'Basic 7', 10101089, 'P180', 'Tema', 'Abena', 'Akua', 'Asante', 'abenaasante@gmail.com', '233 204 333 444', 'student', 'kwame-asante2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000081', 'Female', 'Akua', 'Adwoa', 'Ampofo', '2010-08-01', '233 541 111 222', 'akuaampofo2@gmail.com', 'Basic 7', 10101090, 'P181', 'Aflao', 'Kofi', 'Osei', 'Ampofo', 'kofiampofo@gmail.com', '233 541 333 444', 'student', 'akua-ampofo2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000082', 'Male', 'Yaw', 'Kofi', 'Darko', '2010-10-15', '233 261 111 222', 'yawdarko2@gmail.com', 'Basic 7', 10101091, 'P182', 'Bawku', 'Ama', 'Akua', 'Darko', 'amadarko2@gmail.com', '233 261 333 444', 'student', 'yaw-darko2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000083', 'Female', 'Ama', 'Yaa', 'Agyei', '2009-12-22', '233 570 111 222', 'amaagyei2@gmail.com', 'Basic 8', 10101092, 'P183', 'Techiman', 'Kwame', 'Kofi', 'Agyei', 'kwameagyei2@gmail.com', '233 570 333 444', 'student', 'ama-agyei2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000084', 'Male', 'Kwame', 'Adjei', 'Mensah', '2009-02-05', '233 241 111 222', 'kwamemensah2@gmail.com', 'Basic 8', 10101093, 'P184', 'Hohoe', 'Akosua', 'Adwoa', 'Mensah', 'akosuamensah@gmail.com', '233 241 333 444', 'student', 'kwame-mensah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000085', 'Female', 'Akua', 'Akosua', 'Sarpong', '2009-04-14', '233 500 111 222', 'akuasarpong3@gmail.com', 'Basic 8', 10101094, 'P185', 'Koforidua', 'Yaw', 'Kojo', 'Sarpong', 'yawsarpong3@gmail.com', '233 500 333 444', 'student', 'akua-sarpong3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000086', 'Male', 'Kofi', 'Osei', 'Adu', '2008-06-20', '233 200 111 222', 'kofiadu3@gmail.com', 'Basic 9', 10101095, 'P186', 'Tarkwa', 'Abena', 'Akua', 'Adu', 'abenaadu@gmail.com', '233 200 333 444', 'student', 'kofi-adu3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000087', 'Female', 'Yaa', 'Adwoa', 'Asare', '2008-08-01', '233 555 111 222', 'yaaasare3@gmail.com', 'Basic 9', 10101096, 'P187', 'Berekum', 'Kofi', 'Osei', 'Asare', 'kofiasare3@gmail.com', '233 555 333 444', 'student', 'yaa-asare3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000088', 'Male', 'Kojo', 'Kwame', 'Annan', '2008-10-15', '233 244 111 222', 'kojoannan3@gmail.com', 'Basic 9', 10101097, 'P188', 'Oda', 'Adwoa', 'Yaa', 'Annan', 'adwoaannan@gmail.com', '233 244 333 444', 'student', 'kojo-annan3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000089', 'Female', 'Adwoa', 'Akua', 'Boakye', '2008-12-22', '233 500 111 222', 'adwoaboakye3@gmail.com', 'Basic 9', 10101098, 'P189', 'Nkawkaw', 'Kwame', 'Kofi', 'Boakye', 'kwameboakye3@gmail.com', '233 500 333 444', 'student', 'adwoa-boakye3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000090', 'Male', 'Kwasi', 'Kojo', 'Gyasi', '2019-02-05', '233 201 111 222', 'kwasigyasi3@gmail.com', 'Creche', 10101099, 'P190', 'Tema', 'Akua', 'Yaa', 'Gyasi', 'akuagyasi3@gmail.com', '233 201 333 444', 'student', 'kwasi-gyasi3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000091', 'Female', 'Akua', 'Adwoa', 'Mensah', '2019-04-14', '233 544 111 222', 'akuamensah3@gmail.com', 'Creche', 10101100, 'P191', 'Aflao', 'Kofi', 'Yaw', 'Mensah', 'kofimensah3@gmail.com', '233 544 333 444', 'student', 'akua-mensah3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000092', 'Male', 'Yaw', 'Kofi', 'Sarpong', '2018-06-20', '233 266 111 222', 'yawsarpong4@gmail.com', 'Nursery 1', 10101101, 'P192', 'Bawku', 'Ama', 'Akua', 'Sarpong', 'amasarpong4@gmail.com', '233 266 333 444', 'student', 'yaw-sarpong4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000093', 'Female', 'Ama', 'Adwoa', 'Dankwa', '2018-08-01', '233 577 111 222', 'amadankwa4@gmail.com', 'Nursery 1', 10101102, 'P193', 'Techiman', 'Kwame', 'Kofi', 'Dankwa', 'kwamedankwa4@gmail.com', '233 577 333 444', 'student', 'ama-dankwa4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000094', 'Male', 'Kwame', 'Kojo', 'Appiah', '2018-10-15', '233 243 111 222', 'kwameappiah4@gmail.com', 'Nursery 1', 10101103, 'P194', 'Hohoe', 'Akosua', 'Adwoa', 'Appiah', 'akosuaappiah4@gmail.com', '233 243 333 444', 'student', 'kwame-appiah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000095', 'Female', 'Adwoa', 'Yaa', 'Owusu', '2017-12-22', '233 502 111 222', 'adwoaowusu4@gmail.com', 'Nursery 2', 10101104, 'P195', 'Koforidua', 'Yaw', 'Kofi', 'Owusu', 'yawowusu4@gmail.com', '233 502 333 444', 'student', 'adwoa-owusu4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000096', 'Male', 'Kofi', 'Adjei', 'Boahen', '2017-02-05', '233 241 111 222', 'kofiboahen4@gmail.com', 'Nursery 2', 10101105, 'P196', 'Tarkwa', 'Ama', 'Akua', 'Boahen', 'amaboahen4@gmail.com', '233 241 333 444', 'student', 'kofi-boahen4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000097', 'Female', 'Akua', 'Adwoa', 'Addai', '2017-04-14', '233 551 111 222', 'akuaaddai4@gmail.com', 'Nursery 2', 10101106, 'P197', 'Berekum', 'Kwame', 'Kofi', 'Addai', 'kwameaddai4@gmail.com', '233 551 333 444', 'student', 'akua-addai4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000098', 'Male', 'Yaw', 'Kwame', 'Asante', '2016-06-20', '233 203 111 222', 'yawasante4@gmail.com', 'Basic 1', 10101107, 'P198', 'Oda', 'Akosua', 'Adwoa', 'Asante', 'akosuaasante4@gmail.com', '233 203 333 444', 'student', 'yaw-asante4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000099', 'Female', 'Ama', 'Akua', 'Ampofo', '2016-08-01', '233 543 111 222', 'amaampofo4@gmail.com', 'Basic 1', 10101108, 'P199', 'Nkawkaw', 'Yaw', 'Kojo', 'Ampofo', 'yawampofo4@gmail.com', '233 543 333 444', 'student', 'ama-ampofo4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000100', 'Male', 'Kwame', 'Kwasi', 'Darko', '2016-10-15', '233 262 111 222', 'kwamedarko4@gmail.com', 'Basic 1', 10101109, 'P200', 'Tema', 'Abena', 'Ama', 'Darko', 'abenadarko4@gmail.com', '233 262 333 444', 'student', 'kwame-darko4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000101', 'Female', 'Akua', 'Adwoa', 'Agyei', '2015-12-22', '233 571 111 222', 'akuaagyei4@gmail.com', 'Basic 2', 10101110, 'P201', 'Aflao', 'Kofi', 'Kwame', 'Agyei', 'kofiagyei4@gmail.com', '233 571 333 444', 'student', 'akua-agyei4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000102', 'Male', 'Kofi', 'Yaw', 'Mensah', '2015-02-05', '233 240 111 222', 'kofimensah4@gmail.com', 'Basic 2', 10101111, 'P202', 'Bawku', 'Adwoa', 'Yaa', 'Mensah', 'adwoamensah4@gmail.com', '233 240 333 444', 'student', 'kofi-mensah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000103', 'Female', 'Yaa', 'Akosua', 'Sarpong', '2015-04-14', '233 509 111 222', 'yaasarpong4@gmail.com', 'Basic 2', 10101112, 'P203', 'Techiman', 'Kwame', 'Kofi', 'Sarpong', 'kwamesarpong4@gmail.com', '233 509 333 444', 'student', 'yaa-sarpong4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000104', 'Male', 'Kojo', 'Kwame', 'Adu', '2014-06-20', '233 208 111 222', 'kojoadu4@gmail.com', 'Basic 3', 10101113, 'P204', 'Hohoe', 'Akosua', 'Adwoa', 'Adu', 'akosuaadu4@gmail.com', '233 208 333 444', 'student', 'kojo-adu4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000105', 'Female', 'Akua', 'Adwoa', 'Asare', '2014-08-01', '233 548 111 222', 'akuaasare4@gmail.com', 'Basic 3', 10101114, 'P205', 'Koforidua', 'Yaw', 'Kojo', 'Asare', 'yawasare4@gmail.com', '233 548 333 444', 'student', 'akua-asare4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000106', 'Male', 'Yaw', 'Kofi', 'Annan', '2014-10-15', '233 267 111 222', 'yawannan4@gmail.com', 'Basic 3', 10101115, 'P206', 'Tarkwa', 'Abena', 'Akua', 'Annan', 'abenaannan4@gmail.com', '233 267 333 444', 'student', 'yaw-annan4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000107', 'Female', 'Adwoa', 'Yaa', 'Boakye', '2013-12-22', '233 576 111 222', 'adwoaboakye4@gmail.com', 'Basic 4', 10101116, 'P207', 'Berekum', 'Kwasi', 'Kojo', 'Boakye', 'kwasiboakye4@gmail.com', '233 576 333 444', 'student', 'adwoa-boakye4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000108', 'Male', 'Kofi', 'Adjei', 'Gyasi', '2013-02-05', '233 245 111 222', 'kofigyasi4@gmail.com', 'Basic 4', 10101117, 'P208', 'Oda', 'Akosua', 'Ama', 'Gyasi', 'akosuaagyasi4@gmail.com', '233 245 333 444', 'student', 'kofi-gyasi4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000109', 'Female', 'Akua', 'Yaa', 'Mensah', '2013-04-14', '233 554 111 222', 'akuamensah4@gmail.com', 'Basic 4', 10101118, 'P209', 'Nkawkaw', 'Yaw', 'Kwame', 'Mensah', 'yawmensah4@gmail.com', '233 554 333 444', 'student', 'akua-mensah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000110', 'Male', 'Kwame', 'Kofi', 'Sarpong', '2012-06-20', '233 204 111 222', 'kwamesarpong4@gmail.com', 'Basic 5', 10101119, 'P210', 'Tema', 'Abena', 'Akua', 'Sarpong', 'abenasarpong4@gmail.com', '233 204 333 444', 'student', 'kwame-sarpong4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000111', 'Female', 'Abena', 'Adwoa', 'Dankwa', '2012-08-01', '233 541 111 222', 'abenadankwa4@gmail.com', 'Basic 5', 10101120, 'P211', 'Aflao', 'Kofi', 'Osei', 'Dankwa', 'kofidankwa4@gmail.com', '233 541 333 444', 'student', 'abena-dankwa4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000112', 'Male', 'Yaw', 'Kojo', 'Appiah', '2012-10-15', '233 261 111 222', 'yawappiah4@gmail.com', 'Basic 5', 10101121, 'P212', 'Bawku', 'Ama', 'Akua', 'Appiah', 'amaappiah4@gmail.com', '233 261 333 444', 'student', 'yaw-appiah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000113', 'Female', 'Akua', 'Yaa', 'Owusu', '2011-12-22', '233 570 111 222', 'akuaowusu4@gmail.com', 'Basic 6', 10101122, 'P213', 'Techiman', 'Kwame', 'Kofi', 'Owusu', 'kwameowusu4@gmail.com', '233 570 333 444', 'student', 'akua-owusu4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000114', 'Male', 'Kofi', 'Kwame', 'Boahen', '2011-02-05', '233 241 111 222', 'kofiboahen4@gmail.com', 'Basic 6', 10101123, 'P214', 'Hohoe', 'Akosua', 'Adwoa', 'Boahen', 'akosuaboahen4@gmail.com', '233 241 333 444', 'student', 'kofi-boahen4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000115', 'Female', 'Adwoa', 'Akosua', 'Addai', '2011-04-14', '233 500 111 222', 'adwoaaddai4@gmail.com', 'Basic 6', 10101124, 'P215', 'Koforidua', 'Yaw', 'Kojo', 'Addai', 'yawaddai4@gmail.com', '233 500 333 444', 'student', 'adwoa-addai4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000116', 'Male', 'Kwame', 'Kwasi', 'Asante', '2010-06-20', '233 200 111 222', 'kwameasante4@gmail.com', 'Basic 7', 10101125, 'P216', 'Tarkwa', 'Abena', 'Akua', 'Asante', 'abenaasante4@gmail.com', '233 200 333 444', 'student', 'kwame-asante4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000117', 'Female', 'Akua', 'Adwoa', 'Ampofo', '2010-08-01', '233 555 111 222', 'akuaampofo4@gmail.com', 'Basic 7', 10101126, 'P217', 'Berekum', 'Kofi', 'Osei', 'Ampofo', 'kofiampofo4@gmail.com', '233 555 333 444', 'student', 'akua-ampofo4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000118', 'Male', 'Yaw', 'Kofi', 'Darko', '2010-10-15', '233 244 111 222', 'yawdarko4@gmail.com', 'Basic 7', 10101127, 'P218', 'Oda', 'Ama', 'Akua', 'Darko', 'amadarko4@gmail.com', '233 244 333 444', 'student', 'yaw-darko4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000119', 'Female', 'Ama', 'Yaa', 'Agyei', '2009-12-22', '233 500 111 222', 'amaagyei4@gmail.com', 'Basic 8', 10101128, 'P219', 'Nkawkaw', 'Kwame', 'Kofi', 'Agyei', 'kwameagyei4@gmail.com', '233 500 333 444', 'student', 'ama-agyei4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000120', 'Male', 'Kwame', 'Adjei', 'Mensah', '2009-02-05', '233 201 111 222', 'kwamemensah4@gmail.com', 'Basic 8', 10101129, 'P220', 'Tema', 'Akosua', 'Adwoa', 'Mensah', 'akosuamensah4@gmail.com', '233 201 333 444', 'student', 'kwame-mensah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000121', 'Female', 'Akua', 'Akosua', 'Sarpong', '2009-04-14', '233 544 111 222', 'akuasarpong5@gmail.com', 'Basic 8', 10101130, 'P221', 'Aflao', 'Yaw', 'Kojo', 'Sarpong', 'yawsarpong5@gmail.com', '233 544 333 444', 'student', 'akua-sarpong5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000122', 'Male', 'Kofi', 'Osei', 'Adu', '2008-06-20', '233 266 111 222', 'kofiadu5@gmail.com', 'Basic 9', 10101131, 'P222', 'Bawku', 'Abena', 'Akua', 'Adu', 'abenaadu5@gmail.com', '233 266 333 444', 'student', 'kofi-adu5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000123', 'Female', 'Yaa', 'Adwoa', 'Asare', '2008-08-01', '233 577 111 222', 'yaaasare5@gmail.com', 'Basic 9', 10101132, 'P223', 'Techiman', 'Kofi', 'Osei', 'Asare', 'kofiasare5@gmail.com', '233 577 333 444', 'student', 'yaa-asare5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000124', 'Male', 'Kojo', 'Kwame', 'Annan', '2008-10-15', '233 243 111 222', 'kojoannan5@gmail.com', 'Basic 9', 10101133, 'P224', 'Hohoe', 'Adwoa', 'Yaa', 'Annan', 'adwoaannan5@gmail.com', '233 243 333 444', 'student', 'kojo-annan5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000125', 'Female', 'Adwoa', 'Akua', 'Boakye', '2008-12-22', '233 502 111 222', 'adwoaboakye5@gmail.com', 'Basic 9', 10101134, 'P225', 'Koforidua', 'Kwame', 'Kofi', 'Boakye', 'kwameboakye5@gmail.com', '233 502 333 444', 'student', 'adwoa-boakye5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000126', 'Male', 'Kwasi', 'Kojo', 'Gyasi', '2019-02-05', '233 241 111 222', 'kwasigyasi5@gmail.com', 'Creche', 10101135, 'P226', 'Tarkwa', 'Akua', 'Yaa', 'Gyasi', 'akuagyasi5@gmail.com', '233 241 333 444', 'student', 'kwasi-gyasi5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000127', 'Female', 'Akua', 'Adwoa', 'Mensah', '2019-04-14', '233 551 111 222', 'akuamensah5@gmail.com', 'Creche', 10101136, 'P227', 'Berekum', 'Kofi', 'Yaw', 'Mensah', 'kofimensah5@gmail.com', '233 551 333 444', 'student', 'akua-mensah5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000128', 'Male', 'Yaw', 'Kofi', 'Sarpong', '2018-06-20', '233 203 111 222', 'yawsarpong6@gmail.com', 'Nursery 1', 10101137, 'P228', 'Oda', 'Ama', 'Akua', 'Sarpong', 'amasarpong6@gmail.com', '233 203 333 444', 'student', 'yaw-sarpong6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000129', 'Female', 'Ama', 'Adwoa', 'Dankwa', '2018-08-01', '233 543 111 222', 'amadankwa6@gmail.com', 'Nursery 1', 10101138, 'P229', 'Nkawkaw', 'Kwame', 'Kofi', 'Dankwa', 'kwamedankwa6@gmail.com', '233 543 333 444', 'student', 'ama-dankwa6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000130', 'Male', 'Kwame', 'Kojo', 'Appiah', '2018-10-15', '233 262 111 222', 'kwameappiah6@gmail.com', 'Nursery 1', 10101139, 'P230', 'Tema', 'Akosua', 'Adwoa', 'Appiah', 'akosuaappiah6@gmail.com', '233 262 333 444', 'student', 'kwame-appiah6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000131', 'Female', 'Adwoa', 'Yaa', 'Owusu', '2017-12-22', '233 571 111 222', 'adwoaowusu6@gmail.com', 'Nursery 2', 10101140, 'P231', 'Aflao', 'Yaw', 'Kofi', 'Owusu', 'yawowusu6@gmail.com', '233 571 333 444', 'student', 'adwoa-owusu6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000132', 'Male', 'Kofi', 'Adjei', 'Boahen', '2017-02-05', '233 240 111 222', 'kofiboahen6@gmail.com', 'Nursery 2', 10101141, 'P232', 'Bawku', 'Ama', 'Akua', 'Boahen', 'amaboahen6@gmail.com', '233 240 333 444', 'student', 'kofi-boahen6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000133', 'Female', 'Akua', 'Adwoa', 'Addai', '2017-04-14', '233 509 111 222', 'akuaaddai6@gmail.com', 'Nursery 2', 10101142, 'P233', 'Techiman', 'Kwame', 'Kofi', 'Addai', 'kwameaddai6@gmail.com', '233 509 333 444', 'student', 'akua-addai6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000134', 'Male', 'Yaw', 'Kwame', 'Asante', '2016-06-20', '233 208 111 222', 'yawasante6@gmail.com', 'Basic 1', 10101143, 'P234', 'Hohoe', 'Akosua', 'Adwoa', 'Asante', 'akosuaasante6@gmail.com', '233 208 333 444', 'student', 'yaw-asante6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000135', 'Female', 'Ama', 'Akua', 'Ampofo', '2016-08-01', '233 548 111 222', 'amaampofo6@gmail.com', 'Basic 1', 10101144, 'P235', 'Koforidua', 'Yaw', 'Kojo', 'Ampofo', 'yawampofo6@gmail.com', '233 548 333 444', 'student', 'ama-ampofo6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy');
INSERT INTO `students` (`student_id`, `gender`, `first_name`, `mid_name`, `last_name`, `dob`, `number`, `email`, `class`, `healthinsur`, `curaddress`, `cityname`, `parent_first_name`, `parent_mid_name`, `parent_last_name`, `parent_email`, `parent_number`, `role`, `username`, `password`, `conpassword`) VALUES
('STD000136', 'Male', 'Kwame', 'Kwasi', 'Darko', '2016-10-15', '233 267 111 222', 'kwamedarko6@gmail.com', 'Basic 1', 10101145, 'P236', 'Tarkwa', 'Abena', 'Ama', 'Darko', 'abenadarko6@gmail.com', '233 267 333 444', 'student', 'kwame-darko6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000137', 'Female', 'Akua', 'Adwoa', 'Agyei', '2015-12-22', '233 576 111 222', 'akuaagyei6@gmail.com', 'Basic 2', 10101146, 'P237', 'Berekum', 'Kofi', 'Kwame', 'Agyei', 'kofiagyei6@gmail.com', '233 576 333 444', 'student', 'akua-agyei6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000138', 'Male', 'Kofi', 'Yaw', 'Mensah', '2015-02-05', '233 245 111 222', 'kofimensah6@gmail.com', 'Basic 2', 10101147, 'P238', 'Oda', 'Adwoa', 'Yaa', 'Mensah', 'adwoamensah6@gmail.com', '233 245 333 444', 'student', 'kofi-mensah6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000139', 'Female', 'Yaa', 'Akosua', 'Sarpong', '2015-04-14', '233 554 111 222', 'yaasarpong6@gmail.com', 'Basic 2', 10101148, 'P239', 'Nkawkaw', 'Kwame', 'Kofi', 'Sarpong', 'kwamesarpong6@gmail.com', '233 554 333 444', 'student', 'yaa-sarpong6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000140', 'Male', 'Kojo', 'Kwame', 'Adu', '2014-06-20', '233 204 111 222', 'kojoadu6@gmail.com', 'Basic 3', 10101149, 'P240', 'Tema', 'Akosua', 'Adwoa', 'Adu', 'akosuaadu6@gmail.com', '233 204 333 444', 'student', 'kojo-adu6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000141', 'Female', 'Akua', 'Adwoa', 'Asare', '2014-08-01', '233 541 111 222', 'akuaasare6@gmail.com', 'Basic 3', 10101150, 'P241', 'Aflao', 'Yaw', 'Kojo', 'Asare', 'yawasare6@gmail.com', '233 541 333 444', 'student', 'akua-asare6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000142', 'Male', 'Yaw', 'Kofi', 'Annan', '2014-10-15', '233 261 111 222', 'yawannan6@gmail.com', 'Basic 3', 10101151, 'P242', 'Bawku', 'Abena', 'Akua', 'Annan', 'abenaannan6@gmail.com', '233 261 333 444', 'student', 'yaw-annan6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000143', 'Female', 'Adwoa', 'Yaa', 'Boakye', '2013-12-22', '233 570 111 222', 'adwoaboakye6@gmail.com', 'Basic 4', 10101152, 'P243', 'Techiman', 'Kwasi', 'Kojo', 'Boakye', 'kwasiboakye6@gmail.com', '233 570 333 444', 'student', 'adwoa-boakye6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000144', 'Male', 'Kofi', 'Adjei', 'Gyasi', '2013-02-05', '233 241 111 222', 'kofigyasi6@gmail.com', 'Basic 4', 10101153, 'P244', 'Hohoe', 'Akosua', 'Ama', 'Gyasi', 'akosuaagyasi6@gmail.com', '233 241 333 444', 'student', 'kofi-gyasi6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STD000145', 'Female', 'Akua', 'Yaa', 'Mensah', '2013-04-14', '233 500 111 222', 'akuamensah6@gmail.com', 'Basic 4', 10101154, 'P245', 'Koforidua', 'Yaw', 'Kwame', 'Mensah', 'yawmensah6@gmail.com', '233 500 333 444', 'student', 'akua-mensah6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy');

-- --------------------------------------------------------

--
-- Table structure for table `student_count`
--

CREATE TABLE `student_count` (
  `total_students` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` varchar(100) NOT NULL,
  `subject_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`) VALUES
('', ''),
('SBJ001', 'OWOP'),
('SBJ0010', 'Creative Arts'),
('SBJ002', 'English'),
('SBJ003', 'Science'),
('SBJ004', 'Mathematics'),
('SBJ005', 'ICT'),
('SBJ006', 'RME'),
('SBJ007', 'Social'),
('SBJ008', 'Creative Art');

-- --------------------------------------------------------

--
-- Table structure for table `subject_objectives`
--

CREATE TABLE `subject_objectives` (
  `id` int(11) NOT NULL,
  `subject_id` varchar(100) DEFAULT NULL,
  `objective` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_objectives`
--

INSERT INTO `subject_objectives` (`id`, `subject_id`, `objective`, `start_date`, `end_date`) VALUES
(15, 'SBJ004', 'fvbfdzgbsdf', '2025-01-16', '2025-01-23');

-- --------------------------------------------------------

--
-- Table structure for table `term_plan`
--

CREATE TABLE `term_plan` (
  `id` int(11) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `term_plan`
--

INSERT INTO `term_plan` (`id`, `plan`, `date`) VALUES
(1, 'HOLIDAY', '2025-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` varchar(255) NOT NULL,
  `term` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `class_nm` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `term`, `type`, `class_nm`, `start_date`, `end_date`) VALUES
('TS00001', 'First Term', 'Class Test', 'Class 2', '2025-01-10', '2025-01-17'),
('TS00002', 'Second Term', 'Examination', 'Class 5', '2025-01-10', '2025-01-17'),
('TS00003', 'Second Term', 'Class Test', 'Class 7', '2025-01-10', '2025-01-17'),
('TS00006', 'First Term', 'Class Test', 'Class 8', '2025-02-19', '2025-02-05');

-- --------------------------------------------------------

--
-- Table structure for table `user_count`
--

CREATE TABLE `user_count` (
  `user_type` int(1) DEFAULT NULL,
  `total_users` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`date`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkin_code`
--
ALTER TABLE `checkin_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD PRIMARY KEY (`fee_id`),
  ADD KEY `class_name` (`class_name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `receipt_number` (`receipt_number`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fee_id` (`fee_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`filename`);

--
-- Indexes for table `school_details`
--
ALTER TABLE `school_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff_classes`
--
ALTER TABLE `staff_classes`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `class_id` (`class_name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `subject_objectives`
--
ALTER TABLE `subject_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `term_plan`
--
ALTER TABLE `term_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checkin_code`
--
ALTER TABLE `checkin_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=542;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `school_details`
--
ALTER TABLE `school_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_classes`
--
ALTER TABLE `staff_classes`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subject_objectives`
--
ALTER TABLE `subject_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `term_plan`
--
ALTER TABLE `term_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`fee_id`) REFERENCES `fee_structures` (`fee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
