-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql304.ezyro.com
-- Generation Time: Oct 30, 2025 at 03:49 PM
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
('AD0254', 'Vivor Oscar Makafui', 'administrator', 'VivorOscar', '$2y$10$7ymP/Wlz/IGFt2PlzErreOallyvD8QsCYnS1uQs8N0ptN8FPpn9JS', '$2y$10$pp1/yu3OYPiRfre4Epsnv.U3Mfuv3nD5zz6I2EtsGldEVlUip/Usi'),
('AD55487', 'Alilu Zakari', 'administrator', 'Alhaji', '$2y$10$df/cLHvq4Asr7F2MACIFg.ASPRSvmKrWUYLqaOLZQ1y72lFu8oaWe', '$2y$10$mjl7erEnQa5x6JkW7pUuEOvrRkhXk0i0m.kai91rMZJJkeMLqBqQe');

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

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `audit_logs`
--
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
(16, 'Mathematics', '70.00', 'Basic 3', '2025-09-08 09:07:44'),
(17, 'English', '70.00', 'Basic 3', '2025-09-08 09:07:44'),
(18, 'Science', '70.00', 'Basic 3', '2025-09-08 09:07:44'),
(19, 'History', '60.00', 'Basic 3', '2025-09-08 09:07:44'),
(20, 'RME', '60.00', 'Basic 3', '2025-09-08 09:07:44'),
(21, 'Twi', '50.00', 'Basic 3', '2025-09-08 09:07:44'),
(22, 'Computing', '70.00', 'Basic 3', '2025-09-08 09:07:44'),
(23, 'Creative Arts', '70.00', 'Basic 3', '2025-09-08 09:07:44'),
(24, 'Exercise 20', '120.00', 'Basic 3', '2025-09-08 09:07:44'),
(25, 'Copybook', '10.00', 'Basic 3', '2025-09-08 09:07:44'),
(26, 'Mathematics', '70.00', 'Basic 4', '2025-09-08 09:14:07'),
(27, 'English', '70.00', 'Basic 4', '2025-09-08 09:14:07'),
(28, 'History', '60.00', 'Basic 4', '2025-09-08 09:14:07'),
(29, 'Science', '70.00', 'Basic 4', '2025-09-08 09:14:07'),
(30, 'Creative Arts', '70.00', 'Basic 4', '2025-09-08 09:14:07'),
(31, 'RME', '60.00', 'Basic 4', '2025-09-08 09:14:07'),
(32, 'Computing', '60.00', 'Basic 4', '2025-09-08 09:14:07'),
(33, 'Exercise books 20', '120.00', 'Basic 4', '2025-09-08 09:14:07'),
(34, 'Twi', '60.00', 'Basic 4', '2025-09-08 09:14:07');

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
-- Table structure for table `daily_class_summaries`
--

CREATE TABLE `daily_class_summaries` (
  `id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `summary_date` date NOT NULL,
  `expected_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `received_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_class_summaries`
--


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
(8, 'Creche', 'Term One - 2025', '430.00', '2025-12-19'),
(9, 'Nursery 1', 'Term One - 2025', '430.00', '2025-12-19'),
(10, 'Nursery 2', 'Term One - 2025', '430.00', '2025-12-19'),
(12, 'K.G 1', 'Term One - 2025', '330.00', '2025-12-19'),
(13, 'K.G 2', 'Term One - 2025', '330.00', '2025-12-19'),
(14, 'Basic 3', 'Term One - 2025', '330.00', '2025-12-19');

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
(5, 'Royal Websters Academy', 'Private', 'Boadua-Topremang', 750, '14', 'webstersacademy139@gmail.com', '0244730220/024326189', '2025/2026', '#2b21c0', 'uploads/photo.jpg', '2025-01-12 21:46:03', '2025-10-24 16:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `service_fees`
--

CREATE TABLE `service_fees` (
  `service_fee_id` int(11) NOT NULL,
  `service_name` enum('feeding','transport') NOT NULL,
  `location` varchar(255) NOT NULL,
  `student_location_field` varchar(100) NOT NULL DEFAULT 'curaddress' COMMENT 'students table column to match (e.g. curaddress or class)',
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_fees`
--

INSERT INTO `service_fees` (`service_fee_id`, `service_name`, `location`, `student_location_field`, `amount`, `created_at`) VALUES
(1, 'feeding', 'Akwatia', 'curaddress', '9.00', '2025-10-12 13:50:36'),
(2, 'feeding', 'Boadua', 'curaddress', '9.00', '2025-10-12 13:50:41'),
(3, 'feeding', 'Apinamang', 'curaddress', '15.00', '2025-10-12 13:50:47'),
(4, 'feeding', 'Topremmang', 'curaddress', '12.00', '2025-10-12 13:51:04'),
(5, 'feeding', 'Bamenase', 'curaddress', '12.00', '2025-10-12 13:51:17'),
(6, 'feeding', 'Kade', 'curaddress', '10.00', '2025-10-12 13:51:34'),
(8, 'feeding', 'Nkwantanang', 'curaddress', '15.00', '2025-10-12 13:52:42');

-- --------------------------------------------------------

--
-- Table structure for table `service_payments`
--

CREATE TABLE `service_payments` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `service_fee_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_day` date GENERATED ALWAYS AS (cast(`payment_date` as date)) STORED,
  `receipt_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
('STF0000002', 'Male', 'Agbanyo', 'Nketia', 'Philip', '2002-02-04', '233597330198', 'nketiaphilip33@gmail', 'Basic 3', NULL, 'P o box Kade 39', '', 'WASSCE', '2024-10-15', '', 'staff', 'PhilipNketia', '$2y$10$omg773jGlZtgPePKmOpdROeBkUTaofPg4xtvncvyhWNGE8alYApvK', '$2y$10$/jnmzGrLSfrerf3NGmk3Reh0DZ33dhGhpXSFF90xrBw8S2TAtAnOa'),
('STF0000003', 'Male', 'Danquah', 'Derrick', 'Amissah', '1994-04-14', '233245778924', 'derrickdanquah21@gmail.com', 'Basic 8', NULL, 'Kade', '', 'Masters', '2025-05-08', '', 'staff', 'Derrick', '$2y$10$qdP9TXJcsCrv/mTtlL9OUuMW4WbUigXBfCVJPz3guJExO9TVx905S', '$2y$10$/xxcoY0N23MDQv1ty2OTOeA9n1NZJszveJsnOCgKknJpPwlVLW0eK'),
('STF0000004', 'Male', 'Armah', 'Jones', 'Enimil', '1996-03-26', '233243124689', 'emeritusazo06@gmail.com', 'Basic 9', NULL, 'Kade', NULL, 'Degree', '2023-01-10', NULL, 'staff', 'EmeritusAzo', '$2y$10$NI2TXgJQwAuBf7/DUmRSaOn8EBJzxtUNkjg5EUBABjvDdOAKwaBei', '$2y$10$CVnKKkuk6qMfOikUP.fgA.o59IxWP8L1h3Qwod9.rsIOtqmaxfMqq'),
('STF0000005', 'Male', 'Ocran', 'Joshua', 'Wilson', '1991-06-06', '233240369996', 'ocranjoshuawilson@gmail.com', 'Basic 7', NULL, 'Kade', NULL, 'Degree', '2025-01-23', NULL, 'staff', 'OcranJoshua', '$2y$10$Ux8feX9n0mFi/wJ/22YdQ.JWYpy4a8RG2ZKCxj7VJtTzLJMmtmhSW', '$2y$10$e.0PvNC5.gJqf7vyli0bJeIggYmnCdiV3iQ3qX7ntmuBmIeqN1v82'),
('STF0000006', 'Female', 'Ahorgba', 'Sefakor', 'Phyllis', '2005-04-05', '233533549226', 'phyllisablasefakorahorgba@gmail.com', 'K.G 1', NULL, 'Akwatia', NULL, 'WASSCE', '2025-05-07', NULL, 'staff', 'PhyllisSefakor', '$2y$10$WTlIbvCr0NcGr6DGJJR/I.3H/kHS0uRVgbM67DzQF0r3B87nMpYEi', '$2y$10$H2vvr5VpSA4c6Ixn2DXv6uBPiLjfUC.mnH.RSC.jLsxwuE0Zp9xv2');

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
(24, 'STF0000002', 'Basic 3'),
(25, 'STF0000003', 'Basic 8'),
(26, 'STF0000004', 'Basic 9'),
(27, 'STF0000005', 'Basic 7'),
(28, 'STF0000006', 'K.G 1');

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
  `number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `class` varchar(25) NOT NULL,
  `curaddress` varchar(255) NOT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `parent_email` varchar(255) DEFAULT NULL,
  `parent_number` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT '''''''student''''''',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `conpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `gender`, `first_name`, `mid_name`, `last_name`, `dob`, `number`, `email`, `class`, `curaddress`, `parent_name`, `parent_email`, `parent_number`, `role`, `username`, `password`, `conpassword`) VALUES
('STD0000124', 'Male', 'Alorwu', '', 'Philbert', '2010-12-15', '2335593455', NULL, 'Basic 9', 'Boadua', 'Eric Alorwu', NULL, '0542492083', 'student', 'lorwuhilbert', '$2y$10$Z6a4u5/cLIp/Md5O0KpfyOnd./EQsPAJj51aYomEf3s96//Xvghbu', '$2y$10$P8pfjGh4mj95ITRnMjG6euIsiw32eatQNywFmEVsWnfV6jw1WzE6e'),
('STD0001', 'M', 'Abdul', '----', 'Kareem', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'abdulkareem', '1234', '1234'),
('STD0002', 'M', 'Adnan', 'Issaka', 'Dawuda', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'adnandawuda', '1234', '1234'),
('STD0003', 'M', 'Abdul', 'Kwaari', 'Wahab', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'abdulwahab', '1234', '1234'),
('STD0004', 'M', 'Amir', 'Ofori', 'Effah', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'amireffah', '1234', '1234'),
('STD0005', 'M', 'Adehuyi', 'Selorm', 'Ezra', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'adehuyiezra', '1234', '1234'),
('STD0006', 'M', 'Bonsu', 'Osei', 'Isaac', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'bonsuisaac', '1234', '1234'),
('STD0007', 'M', 'Bodeeng', 'Selorm', 'Kurt', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'bodeengkurt', '1234', '1234'),
('STD0008', 'M', 'Debra', 'Darius', 'Jay', '2025-10-24', '0568245789', 'donmauel45@gmail.com', 'Nursery 2', '', NULL, NULL, NULL, 'student', 'debrajayden', '$2y$10$ELkb5xl/0mWJ19DEl0WZYOAC13s90yJrfpuHkC4fqJN92XLeWKleC', '1234'),
('STD0009', 'M', 'Bentil', 'Akwasi', 'Bradley', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'bentilbradley', '1234', '1234'),
('STD0010', 'M', 'Eshun', '----', 'Ericsson', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'eshunericsson', '1234', '1234'),
('STD0011', 'M', 'Muta', 'Kiru', 'Seidu', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'mutaseidu', '1234', '1234'),
('STD0012', 'M', 'Nhyiraba', 'Jayden', 'Okokroko', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'nhyirabaokokroko', '1234', '1234'),
('STD0013', 'M', 'Nana', 'Yaw', 'Gyasi', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'nanagyasi', '1234', '1234'),
('STD0014', 'M', 'Anane', 'S.', 'Lloyd', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'ananelloyd', '1234', '1234'),
('STD0015', 'M', 'Abdul', 'Latif', 'Kassim', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'abdulkassim', '1234', '1234'),
('STD0016', 'M', 'Allocktey', 'Ajom', 'Rahmal', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'allockteyrahmal', '1234', '1234'),
('STD0017', 'M', 'Boahene', 'Lomena', 'Austin', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'boaheneaustin', '1234', '1234'),
('STD0018', 'M', 'Kariko', '----', 'Exedous', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'karikoexedous', '1234', '1234'),
('STD0019', 'M', 'Kwame', 'Okyere', 'Darkwa', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'kwamedarkwa', '1234', '1234'),
('STD0020', 'M', 'Kwame', 'Sallah', 'Osei', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'kwameosei', '1234', '1234'),
('STD0021', 'M', 'Mensah', '----', 'Richmond', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'mensahrichmond', '1234', '1234'),
('STD0022', 'M', 'Ntiamoah', 'A.', 'Jeremy', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'ntiamoahjeremy', '1234', '1234'),
('STD0023', 'M', 'Obrempong', '----', 'Rightious', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'obrempongrightious', '1234', '1234'),
('STD0024', 'M', 'Oame', 'Asare', 'Solomon', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'oamesolomon', '1234', '1234'),
('STD0025', 'M', 'Oti', '----', 'Emmanuel', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'otiemmanuel', '1234', '1234'),
('STD0026', 'M', 'Adankwa', 'Derriek', 'Mohammed', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'adankwamohammed', '1234', '1234'),
('STD0027', 'M', 'Harris', 'Nana T.', 'Boamah', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'harrisboamah', '1234', '1234'),
('STD0028', 'M', 'Saani', '----', 'Ibrahim', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'saaniibrahim', '1234', '1234'),
('STD0029', 'F', 'Awotwe', 'Pratt', 'Emilly', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'awotweemilly', '1234', '1234'),
('STD0030', 'F', 'Ayisha', 'Inusah', 'Yakubu', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'ayishayakubu', '1234', '1234'),
('STD0031', 'F', 'Arisah', 'Owusu', 'Kendra', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'arisahkendra', '1234', '1234'),
('STD0032', 'F', 'Baidoo', '----', 'Chelsea', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'baidoochelsea', '1234', '1234'),
('STD0033', 'F', 'Frimpomaa', 'Hanniel', 'Mame', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'frimpomaamame', '1234', '1234'),
('STD0034', 'F', 'Giasiwaa', 'Aden', 'Mirabel', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'giasiwaamirabel', '1234', '1234'),
('STD0035', 'F', 'Nhyiraba', '----', 'Princess', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'nhyirabaprincess', '1234', '1234'),
('STD0036', 'F', 'Fiahyɔ', '----', 'Victoria', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'fiahyovictoria', '1234', '1234'),
('STD0037', 'F', 'Karur', 'Dake', 'Alberta', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'karuralberta', '1234', '1234'),
('STD0038', 'F', 'Odrkwa', '----', 'Nuella', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'odrkwanuella', '1234', '1234'),
('STD0039', 'F', 'Adera', '----', 'Deborah', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'aderadeborah', '1234', '1234'),
('STD0040', 'F', 'Asumadu', '----', 'Abigail', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'asumaduabigail', '1234', '1234'),
('STD0041', 'F', 'Akyede', 'D. Asum', 'Arriet', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'akyedearriet', '1234', '1234'),
('STD0042', 'F', 'Anwal', '----', 'Mariam', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'anwalmariam', '1234', '1234'),
('STD0043', 'F', 'Awal', '----', 'Asillah', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'awalasillah', '1234', '1234'),
('STD0044', 'F', 'Dankor', 'Ayeyi A.', 'Oser', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'dankoroser', '1234', '1234'),
('STD0045', 'F', 'Essuman', 'J.B.', 'Hellen', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'essumanhellen', '1234', '1234'),
('STD0046', 'F', 'Frimpomaa', 'Lady', 'Julia', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'frimpomaajulia', '1234', '1234'),
('STD0047', 'F', 'Ayesiwaa', '----', 'Niaha', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'ayesiwaaniaha', '1234', '1234'),
('STD0048', 'F', 'Sarkodie', '----', 'Christabel', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'sarkodiechristabel', '1234', '1234'),
('STD0049', 'F', 'Sia', 'Kelly', 'Princess', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'siaprincess', '1234', '1234'),
('STD0050', 'F', 'Eudora', 'Haaj', 'Adjetey', '2025-10-24', NULL, NULL, 'Nursery 2', '', NULL, NULL, NULL, 'student', 'eudoraadjetey', '1234', '1234'),
('STD0051', 'M', 'Abdul', 'Hamid', 'Saliu', '2025-10-24', '', '', 'Basic 3', 'Cayco', NULL, NULL, NULL, 'student', 'abdulsaliu', '$2y$10$p4lwm1c3U0xwGj.QtRyOVurL5ubNuc4CJoUBsPOnyq41MkgfKxSP6', '1234'),
('STD0052', 'M', 'Abdul', 'Rhaman', 'Ibrahim', '2025-10-24', '', '', 'Basic 3', 'Boadua', NULL, NULL, NULL, 'student', 'abdulibrahim', '1234', '1234'),
('STD0053', 'M', 'Agyei', 'Christopher', 'Danso', '2025-10-24', '', '', 'Basic 3', 'Apinamang', NULL, NULL, NULL, 'student', 'agyeidanso', '1234', '1234'),
('STD0054', 'M', 'Agyei', '----', 'Peaceford', '2025-10-24', '', '', 'Basic 3', 'Apinamang', NULL, NULL, NULL, 'student', 'agyeipeaceford', '1234', '1234'),
('STD0055', 'M', 'Adukpo', '----', 'Kelvin', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'adukpokelvin', '1234', '1234'),
('STD0056', 'M', 'Amankwah', 'Nhyira', 'Asare', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'amankwahasare', '1234', '1234'),
('STD0057', 'M', 'Amponsah', 'Nana', 'Frimpong', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'amponsahfrimpong', '1234', '1234'),
('STD0058', 'M', 'Ankor', 'Kendrick', 'Selorm', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'ankorselorm', '1234', '1234'),
('STD0059', 'M', 'Asamoah', 'Christian', '----', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'asamoahchristian', '1234', '1234'),
('STD0060', 'M', 'Asante', 'Sarpong', 'Virgilius', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'asantevirgilius', '1234', '1234'),
('STD0061', 'M', 'Abdul', '----', 'Suleman', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'abdulsuleman', '1234', '1234'),
('STD0062', 'M', 'Awuni', '----', 'David', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'awunidavid', '1234', '1234'),
('STD0063', 'M', 'Boakye', 'Ethan', 'Adepa', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'boakyeadepa', '1234', '1234'),
('STD0064', 'M', 'Cobb', '----', 'Damien', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'cobbdamien', '1234', '1234'),
('STD0065', 'M', 'Esor', '----', 'Elorm', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'esorelorm', '1234', '1234'),
('STD0066', 'M', 'Gyasi', 'Enoch', 'Boadi', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'gyasiboadi', '1234', '1234'),
('STD0067', 'M', 'Manu', 'Larry', '----', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'manularry', '1234', '1234'),
('STD0068', 'M', 'Mohammed', 'Amin', 'Hakeem', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'mohammedhakeem', '1234', '1234'),
('STD0069', 'M', 'Mohammed', 'Briham', '----', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'mohammedbriham', '1234', '1234'),
('STD0070', 'M', 'Mohammed', 'Farouk', 'Habib', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'mohammedhabib', '1234', '1234'),
('STD0071', 'M', 'Moro', '----', 'Husaif', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'morohusaif', '1234', '1234'),
('STD0072', 'M', 'Obeng', '----', 'Christian', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'obengchristian', '1234', '1234'),
('STD0073', 'M', 'Ofori', 'Nana', 'Armstrong', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'oforiarmstrong', '1234', '1234'),
('STD0074', 'M', 'Ofori', '----', 'Perez', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'oforiperez', '1234', '1234'),
('STD0075', 'M', 'Okyere', '----', 'Jerome', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'okyerejerome', '1234', '1234'),
('STD0076', 'M', 'Opoku', '----', 'Arnold', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'opokuarnold', '1234', '1234'),
('STD0077', 'M', 'Owusu', '----', 'Nathaniel', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'owusunathaniel', '1234', '1234'),
('STD0078', 'M', 'Abubakar', '----', 'Sherif', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'abubakarsherif', '1234', '1234'),
('STD0079', 'M', 'Wahab', '----', 'Junior', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'wahabjunior', '1234', '1234'),
('STD0079108990', 'Female', 'Nkebi', '', 'Alice', '2009-09-21', '0535772313', NULL, 'Basic 9', 'Boadua', 'Rebecca Aquaye', NULL, '0535772313', 'student', 'kebilice', '$2y$10$GUdlPLRt8SIetusEdZaXQ.pxl6Rc4Cc66eVVyRuoDsSDj7nSm9OiK', '$2y$10$HbUTlv7MEmoBBLSM9uNq0.Q5QV54EBmBLUC1q.TW1YBceViL7mQlW'),
('STD0080', 'M', 'Sarpong', 'Gideon', 'Benkyi', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'sarpongbenkyi', '1234', '1234'),
('STD0081', 'M', 'Yeboah', 'Jaiden', 'Antwi', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'yeboahantwi', '1234', '1234'),
('STD0082', 'M', 'Samuel', '----', 'Nyarko', '2025-10-24', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'samuelnyarko', '1234', '1234'),
('STD0101', 'Female', 'Abdul', 'Hauwa', 'Latif', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'abdulhauwalatif', '1234', '1234'),
('STD0102', 'Female', 'Afesi', '', 'Thecla', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'afesithecla', '1234', '1234'),
('STD0103', 'Female', 'Agyapong', '', 'Leontina', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'agyapongeleontina', '1234', '1234'),
('STD0104', 'Female', 'Al-Zakari', '', 'Malika', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'alzakarimalika', '1234', '1234'),
('STD0105', 'Female', 'Apea', '', 'Patricia', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'appapatricia', '1234', '1234'),
('STD0106', 'Female', 'Asabea', '', 'Hilary', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'asabeahilary', '1234', '1234'),
('STD0107', 'Female', 'Asante', 'Pheobe', 'Oforiwaa', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'asantepheobeoforiwaa', '1234', '1234'),
('STD0108', 'Female', 'Asare', 'O. Lordia', 'Esther', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'asarelordiaesther', '1234', '1234'),
('STD0109', 'Female', 'Braimah', 'Frimpomaa', 'Kendrah', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'braimahfrimpomaakendrah', '1234', '1234'),
('STD0110', 'Female', 'Danso', 'Osei', 'Adjoa', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'dansooseiadjoa', '1234', '1234'),
('STD0111', 'Female', 'Darkwah', 'Adutwumwaa', 'Anida', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'narkwahadutwumwaaanida', '1234', '1234'),
('STD0112', 'Female', 'Edem', '', 'Elizabeth', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'edemelizabeth', '1234', '1234'),
('STD0113', 'Female', 'Hamidu', '', 'Ramzyatu', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'hamiduramzyatu', '1234', '1234'),
('STD0114', 'Female', 'Kwakye', 'Deborah', 'Frema', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'kusiakydeborahfrema', '1234', '1234'),
('STD0115', 'Female', 'Kyerewaa', '', 'Hannah', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'kyeremaahannah', '1234', '1234'),
('STD0116', 'Female', 'Monney', '', 'Gifty', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'monneygifty', '1234', '1234'),
('STD0117', 'Female', 'Ohenewaa', '', 'Comfort', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'ohenewaacomfort', '1234', '1234'),
('STD0118', 'Female', 'Owusua', '', 'Angela', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'owusuaangela', '1234', '1234'),
('STD0119', 'Female', 'Owusua', '', 'Larisa', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'owusualarisa', '1234', '1234'),
('STD0120', 'Female', 'Padiky', 'Petra Dede', 'Lamptey', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'padikypetradedelamptey', '1234', '1234'),
('STD0121', 'Female', 'Perwaa', '', 'Melody', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'perwoaamelody', '1234', '1234'),
('STD0122', 'Female', 'Yeboah', 'Comfort', 'Tetteh Nyamekye', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'yeboahcomforttettehnyamekye', '1234', '1234'),
('STD0123', 'Female', 'Offei', '', 'Golda', '', NULL, NULL, 'Basic 3', '', NULL, NULL, NULL, 'student', 'offeigolda', '1234', '1234'),
('STD0533016247', 'Female', 'Ayitey', '', 'Racheal', '2012-12-04', '0541702963', NULL, 'Basic 9', 'Cayco', 'Ayitey Mary', NULL, '0541702963', 'student', 'yiteyacheal', '$2y$10$LOqvNgssu41f/MtCVbsuGuy9ZhjkLzooYWfrqjFAf5LD4rPJxoJiO', '$2y$10$bGKqgh0fgh./mF/Jqm2Rv.7HLGhq.ngNaxfy3/vfkItjuE1vR8IsC'),
('STD0543135204', 'Female', 'Abdul', 'Fataw', 'Sumaiya', '2012-03-12', '0551076978', NULL, 'Basic 9', 'Kade', 'Amina Fataw', NULL, '0551076978', 'student', 'bdulumaiya', '$2y$10$.KDem.enPjj0BT7gylyPgebkEs5hT5PSX2kTTlaLHps3eGVoQxzA2', '$2y$10$dTBwZl3Wedp6Ti7TvhHXseOwNnemjqxuj/j5sYbNf4aMJn9nk1lsa'),
('STD2133497700', 'Female', 'Abdul', 'Karim', 'Firdaws', '2011-03-24', '0544667824', NULL, 'Basic 9', 'Kade', 'Hajara Salifu', NULL, '0544667824', 'student', 'bdulirdaws', '$2y$10$p1OzBv7EPcgH68oVnCkF9eY9fJOVVykjgdW/1nkT1bvDLG7ZljVJG', '$2y$10$xAGuMU6GnjDDexVXHFK1t.J5XrjOjCzuNZkG2cuM8ryPxR5PsOPE6'),
('STD3036362972', 'Male', 'Bosompem', 'Agyei', 'Larry', '2010-04-05', '0243765484', NULL, 'Basic 9', '', 'Idah Takyiwaa Smith', NULL, '0243765484', 'student', 'osompemarry', '$2y$10$apX8cRS1USGGXHZnGOqMd.JZ0iPzlJIb7AT.x1s4qRkr.qwqHOudW', '$2y$10$upN/Eav3Ma5QD4OuEcRJJeGi6zLyIuUn6X/7WAXB9PzMC5nm7vUAy'),
('STD3972319299', 'Male', 'Asante ', 'Darus ', 'Amoako', '2011-05-27', '0542822266', NULL, 'Basic 9', 'Boadua', 'Hilda Obenewaa Twumasi', NULL, '0243309480', 'student', 'santemoako', '$2y$10$fXUCce5Dq5BTRMG0oDhKduKNb2JdJYtWh.ucLhxaajxBTD95t9Qzi', '$2y$10$gg4W505rlN5BL7rPEdIDMuVf4PCAyKdhHUrBHkKXBD6Ktz0pgrZge'),
('STD4598038309', 'Female', 'Issaka', '', 'Ayisha', '2011-12-02', '0553528553', NULL, 'Basic 9', '', 'Gladys Williams', NULL, '0553528553', 'student', 'ssakayisha', '$2y$10$b6X704R.WarICAaZqYzIGe1g4Ij5njyXc1FtAvaHIVP77OvjTBqwy', '$2y$10$PsDA.P9oWU6zmKoJLHgkfO5LK2S.D0y6tGGryROt7GxmbrRKYddBa'),
('STD4857624700', 'Female', 'Kumassa', '', 'Vanessa', '2012-08-22', '0541145921', NULL, 'Basic 9', 'Boadua', 'Racheal Kumassa', NULL, '0541145929', 'student', 'umassaanessa', '$2y$10$W7drM1TtthVkj2Ae4KnazuRdrjqi4o6HujEBqi7yHJOUO7DcbBEWK', '$2y$10$m3uQqqidrti2p8POfIIDF.AiKr0..PmOSmAlfhJO.9vzAi60GGzwG'),
('STD8604949023', 'Female', 'Akyaa', '', 'Mary', '2009-07-27', '0559474113', NULL, 'Basic 9', 'Boadua', 'Philomena Sablah', NULL, '0533990775', 'student', 'kyaaary', '$2y$10$BCX4E2MnkM.K/1RbQnE9Q.N//.6M9xgvCWq3/BrUUwVy6CUK8wySS', '$2y$10$306FgxqWDmJbSSsSXuWzCuXT4ENAVQdrl3ZETIDUgUUn/Gz3IzmlS'),
('STD8656678598', 'Female', 'Irene', '', 'Norvor', '2010-05-22', '0543898055', NULL, 'Basic 9', 'Boadua', 'Gladys Norvor', NULL, '0543898055', 'student', 'reneorvor', '$2y$10$T1W1XRV8E2NVbCsURpiZaOT20lY/JhSa5fRtUytM2ZafNoIe1.q4u', '$2y$10$eUBmJ0.RSp6rrx.RIjbYU.ID5xtUP0MN80XlYdecb1iXR4ieryBiq'),
('STD8844309182', 'Male', 'Adarkwah', 'Danso', 'Kelvin', '2010-05-01', '0244142058', NULL, 'Basic 9', 'Kade', 'Olivia Bentil', NULL, '0244142058', 'student', 'darkwahelvin', '$2y$10$fsMBTHbx1gdqaDWKpH6CLeo6qJ69UZnCaMvo8743BQWFqPQt1JX06', '$2y$10$gb5ukoq0Rc9lPq2IUoyodOKHQged09LCCXZLRL5O0uluhAu0VM.LG'),
('STD9110313421', 'Female', 'Abubakari Sadik', '', 'Hajara', '2011-09-17', '0243571138', NULL, 'Basic 9', 'Akwatia', 'Musa Zinabu', NULL, '0243571138', 'student', 'bubakariadikajara', '$2y$10$2KPlJ7j8WTx1HWKdAjG3JeHma/iuqGkQjR5PZpqv/BK5Tu6utuMYu', '$2y$10$O0na0aG0WLAzbgDRk1yJp.0nYym8MkLxCRiMJHicQhojYLnY7tth2'),
('STD9415149839', 'Female', 'Dzakpasu', '', 'Rosestar', '2012-04-27', '0557851367', NULL, 'Basic 9', 'Akwatia', 'Patricia Osei', NULL, '0552045464', 'student', 'zakpasuosestar', '$2y$10$NhQQY0toJbqrotP6jzusFOUsgdBGWgwjG5oHXCWXf6dyVIqqoXARG', '$2y$10$SW2NTCoC/GMfgOq..1UIx.g.0mrWgwuJJbluGkB1NxWEdiPq7wNyy');

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
('', '');

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
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `teacher_code` varchar(50) NOT NULL,
  `school_status` enum('Public','Private') NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `other_names` varchar(200) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `marital_status` enum('Single','Married','Divorced','Widowed') NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `gh_card_number` varchar(50) DEFAULT NULL,
  `ssnit_number` varchar(50) NOT NULL,
  `staff_number` varchar(50) DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_code`, `school_status`, `first_name`, `surname`, `other_names`, `date_of_birth`, `sex`, `marital_status`, `phone_number`, `email`, `gh_card_number`, `ssnit_number`, `staff_number`, `license_number`, `created_at`, `updated_at`) VALUES
(1, 'RW0000000002', 'Private', 'Vivor', 'Oscar', 'Makafui', '2025-10-09', 'Male', 'Single', '0533519466', 'oscarvivor@gmail.com', 'GHA-722896979-1', 'E0426282920378', NULL, NULL, '2025-10-24 12:16:30', '2025-10-24 12:16:30'),
(2, 'RW0000000003', 'Private', 'Philip', 'Agbanyo', '', '2002-02-04', 'Male', 'Single', '0597330198', 'nketiaphilip33@gmail.com', 'GHA7273992436', 'E029802040052', NULL, NULL, '2025-10-24 12:23:19', '2025-10-24 12:23:19'),
(3, 'RW000000000221', 'Private', 'Derrick', 'Danquah', 'Amissah', '1994-04-14', 'Male', 'Single', '0245778924', 'derrickdanquah21@gmail.com', 'GA-582-5252', 'B077607250021', NULL, NULL, '2025-10-24 12:29:40', '2025-10-24 12:29:40'),
(4, 'RW000000000102', 'Private', 'Grace', 'Bempomaa', '', '1994-07-02', 'Female', 'Single', '0545099402', 'bempomaagrace02@gmail.com', 'GHA-722097516-5', 'E079407020044', NULL, NULL, '2025-10-24 13:43:49', '2025-10-24 13:43:49'),
(5, 'RW000000000289', 'Private', 'Jones', 'Armah', 'Enimil', '1996-03-26', 'Male', 'Single', '0243124689', 'emeritusazo6@gmail.com', 'GHA-722395224-8', 'A169603260010', NULL, NULL, '2025-10-24 15:38:25', '2025-10-24 15:38:25'),
(6, 'RW000000000234', 'Private', 'Joshua', 'Ocran', 'Wilson', '1991-06-06', 'Male', 'Single', '0240369996', 'ocranjoshuawilson@gmail.com', 'GHA-721413827-1', 'E079106060132', NULL, NULL, '2025-10-24 15:39:35', '2025-10-24 15:39:35'),
(7, 'RW000000000233', 'Private', 'Phyllis', 'Ahorgba', 'Abena Sefakor', '2005-04-05', 'Female', 'Single', '0533549226', 'phyllisablasefakorahorgba@gmail.com', 'GHA722891662-7', 'E00000000000', NULL, NULL, '2025-10-24 16:13:51', '2025-10-24 16:13:51'),
(8, 'RW000000000265', 'Private', 'Christiana', 'Akwarfo', '', '2005-11-17', 'Female', 'Single', '0536987828', 'christianarichy565@gmail.com', 'GHA-730884537-3', '730884537', NULL, NULL, '2025-10-24 16:20:34', '2025-10-24 16:20:34'),
(9, 'Rw000000000255', 'Private', 'DANIEL', 'AGYEI', '', '2005-02-04', 'Male', 'Single', '0539433706', 'agyeidaniel0539@gmail.com', '721787185-6', 'I do not have', NULL, NULL, '2025-10-24 16:21:21', '2025-10-24 16:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classes`
--

CREATE TABLE `teacher_classes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_classes`
--

INSERT INTO `teacher_classes` (`id`, `teacher_id`, `class_name`, `created_at`) VALUES
(1, 4, 'P1', '2025-10-24 13:43:49'),
(2, 7, 'KG1', '2025-10-24 16:13:51'),
(3, 8, 'P2', '2025-10-24 16:20:34'),
(4, 9, 'P4', '2025-10-24 16:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_professional_info`
--

CREATE TABLE `teacher_professional_info` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `professional_status` enum('Trained','Untrained') NOT NULL,
  `teacher_type` enum('Class','Subject') DEFAULT NULL,
  `basic_level` enum('Creche/Nursery','KG','Primary','JHS') DEFAULT NULL,
  `basic_subject` enum('Mathematics','Science','English Language','Computing','Creative Arts','French','Career Tech','RME','Twi') DEFAULT NULL,
  `mode_of_qualification` enum('College of Education','Distance Education','Sandwich Programme','University of Education') DEFAULT NULL,
  `academic_qualification` enum('BECE','DEGREE','DIPLOMA','HND','MASTERS DEGREE','TECHNICIAN','SSCE/WASSCE','MSLC','PHD','POST GRADUATE DEGREE','POST GRADUATE CERTIFICATE','GCE A LEVEL','GCE O LEVEL') DEFAULT NULL,
  `professional_certificate` enum('CERT A','DEGREE IN EDUCATION','DIPLOMA IN EDUCATION','MASTERS DEGREE IN EDUCATION','PHD IN EDUCATION','POST GRADUATE CERTIFICATE IN EDUCATION','POST GRADUATE DEGREE IN EDUCATION','OTHERS') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_professional_info`
--

INSERT INTO `teacher_professional_info` (`id`, `teacher_id`, `professional_status`, `teacher_type`, `basic_level`, `basic_subject`, `mode_of_qualification`, `academic_qualification`, `professional_certificate`, `created_at`) VALUES
(1, 1, 'Untrained', 'Subject', 'JHS', 'Computing', NULL, NULL, NULL, '2025-10-24 12:16:30'),
(2, 2, 'Untrained', 'Class', 'Primary', NULL, NULL, NULL, NULL, '2025-10-24 12:23:19'),
(3, 3, 'Untrained', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-24 12:29:40'),
(4, 4, 'Trained', 'Class', 'Primary', NULL, 'University of Education', 'DEGREE', 'DEGREE IN EDUCATION', '2025-10-24 13:43:49'),
(5, 5, 'Trained', 'Subject', 'JHS', NULL, 'University of Education', 'DEGREE', 'DEGREE IN EDUCATION', '2025-10-24 15:38:25'),
(6, 6, 'Trained', 'Subject', 'JHS', 'Creative Arts', 'University of Education', 'DEGREE', 'DEGREE IN EDUCATION', '2025-10-24 15:39:35'),
(7, 7, 'Untrained', 'Class', 'KG', NULL, NULL, NULL, NULL, '2025-10-24 16:13:51'),
(8, 8, 'Untrained', 'Class', 'Primary', NULL, NULL, NULL, NULL, '2025-10-24 16:20:34'),
(9, 9, 'Untrained', 'Class', 'Primary', NULL, NULL, NULL, NULL, '2025-10-24 16:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `term_plan`
--

CREATE TABLE `term_plan` (
  `id` int(11) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `term_plans`
--

CREATE TABLE `term_plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `plan_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `event_type` varchar(50) DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `user_count`
--

CREATE TABLE `user_count` (
  `user_type` int(1) DEFAULT NULL,
  `total_users` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weekly_class_summaries`
--

CREATE TABLE `weekly_class_summaries` (
  `id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `week_start` date NOT NULL,
  `expected_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `received_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weekly_class_summaries`
--

INSERT INTO `weekly_class_summaries` (`id`, `class_name`, `week_start`, `expected_total`, `received_total`, `updated_at`) VALUES
(8, 'Nursery 1', '2025-10-13', '0.00', '0.00', '2025-10-14 09:19:52'),
(11, 'Basic 3', '2025-10-13', '290.00', '31.00', '2025-10-15 19:47:00'),
(14, 'Basic 3', '2025-10-27', '195.00', '39.00', '2025-10-27 20:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_service_scores`
--

CREATE TABLE `weekly_service_scores` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `week_start` date NOT NULL,
  `service_name` varchar(50) NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weekly_service_scores`
--

INSERT INTO `weekly_service_scores` (`id`, `student_id`, `week_start`, `service_name`, `score`, `updated_at`) VALUES
(8, 'STD0000045', '2025-10-13', 'service', 1, '2025-10-14 09:19:52'),
(9, 'STD0000046', '2025-10-13', 'service', 1, '2025-10-14 09:19:52'),
(10, 'STD0000047', '2025-10-13', 'service', 1, '2025-10-14 09:19:52'),
(11, 'STD000151', '2025-10-13', 'service', 1, '2025-10-15 19:46:14'),
(12, 'STD000152', '2025-10-13', 'service', 1, '2025-10-15 19:46:14'),
(13, 'STD000153', '2025-10-13', 'service', 1, '2025-10-15 19:47:00'),
(14, 'STD0051', '2025-10-27', 'service', 1, '2025-10-27 20:59:32'),
(15, 'STD0052', '2025-10-27', 'service', 1, '2025-10-27 20:59:32'),
(16, 'STD0053', '2025-10-27', 'service', 1, '2025-10-27 20:59:32'),
(17, 'STD0054', '2025-10-27', 'service', 1, '2025-10-27 20:59:32');

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
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created_at` (`created_at`);

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
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `daily_class_summaries`
--
ALTER TABLE `daily_class_summaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_class_date` (`class_name`,`summary_date`);

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
-- Indexes for table `service_fees`
--
ALTER TABLE `service_fees`
  ADD PRIMARY KEY (`service_fee_id`);

--
-- Indexes for table `service_payments`
--
ALTER TABLE `service_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_student_service_day` (`student_id`,`service_fee_id`,`payment_day`),
  ADD KEY `service_fee_idx` (`service_fee_id`);

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
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_code` (`teacher_code`),
  ADD KEY `idx_teacher_code` (`teacher_code`),
  ADD KEY `idx_ssnit` (`ssnit_number`);

--
-- Indexes for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teacher_professional_info`
--
ALTER TABLE `teacher_professional_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `idx_professional_status` (`professional_status`);

--
-- Indexes for table `term_plan`
--
ALTER TABLE `term_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `term_plans`
--
ALTER TABLE `term_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `weekly_class_summaries`
--
ALTER TABLE `weekly_class_summaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_class_week` (`class_name`,`week_start`);

--
-- Indexes for table `weekly_service_scores`
--
ALTER TABLE `weekly_service_scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_student_week_service` (`student_id`,`week_start`,`service_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `checkin_code`
--
ALTER TABLE `checkin_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=547;

--
-- AUTO_INCREMENT for table `daily_class_summaries`
--
ALTER TABLE `daily_class_summaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `service_fees`
--
ALTER TABLE `service_fees`
  MODIFY `service_fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_payments`
--
ALTER TABLE `service_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff_classes`
--
ALTER TABLE `staff_classes`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `subject_objectives`
--
ALTER TABLE `subject_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teacher_professional_info`
--
ALTER TABLE `teacher_professional_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `term_plan`
--
ALTER TABLE `term_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `term_plans`
--
ALTER TABLE `term_plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `weekly_class_summaries`
--
ALTER TABLE `weekly_class_summaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `weekly_service_scores`
--
ALTER TABLE `weekly_service_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
