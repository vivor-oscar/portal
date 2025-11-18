-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2025 at 04:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portal`
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
('', '', 'staff', 'vivoroscar', '$2y$10$wDVNj5HKiMtZNmoIAm1yyeBF.aVRgxwZHAZ2GGtPQUrfyxY.QdBlC', '$2y$10$sfiiBilNnY..TiTzyFQc/O6jwy2xAr/as7YaLkhMlxXtlWxjPlU7i'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `username`, `role`, `action`, `details`, `ip`, `created_at`) VALUES
(1, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-10-23 21:59:19'),
(2, 'AD123', 'administrator', 'administrator', 'delete', 'table=checkin_code;id=540;type=checkin_code', '::1', '2025-10-24 13:48:07'),
(3, 'AD123', 'administrator', 'administrator', 'delete', 'table=checkin_code;id=541;type=checkin_code', '::1', '2025-10-24 13:48:08'),
(4, 'AD123', 'administrator', 'administrator', 'delete', 'table=checkin_code;id=551;type=checkin_code', '::1', '2025-10-24 13:57:11'),
(5, 'AD123', 'administrator', 'administrator', 'delete', 'table=checkin_code;id=550;type=checkin_code', '::1', '2025-10-24 13:57:12'),
(6, 'AD123', 'administrator', 'administrator', 'delete', 'table=checkin_code;id=549;type=checkin_code', '::1', '2025-10-24 13:57:14'),
(7, 'AD123', 'administrator', 'administrator', 'delete', 'table=checkin_code;id=548;type=checkin_code', '::1', '2025-10-24 13:57:15'),
(8, 'AD123', 'administrator', 'administrator', 'delete', 'table=checkin_code;id=547;type=checkin_code', '::1', '2025-10-24 13:57:16'),
(9, 'AD123', 'administrator', 'administrator', 'delete', 'table=checkin_code;id=546;type=checkin_code', '::1', '2025-10-24 13:57:17'),
(10, 'AD123', 'administrator', 'administrator', 'logout', 'User logged out', '::1', '2025-10-24 15:08:28'),
(11, 'STF000004', 'adwoaansah', 'staff', 'login', 'Successful login', '::1', '2025-10-24 15:08:36'),
(12, 'STF000004', 'adwoaansah', 'staff', 'logout', 'User logged out', '::1', '2025-10-24 15:08:40'),
(13, 'STF000008', 'afiaasare', 'staff', 'login', 'Successful login', '::1', '2025-10-24 15:08:47'),
(14, 'STF000008', 'afiaasare', 'staff', 'logout', 'User logged out', '::1', '2025-10-24 15:08:49'),
(15, 'STD000001', 'ama-mensah', 'student', 'login', 'Successful login', '::1', '2025-10-24 15:08:57'),
(16, 'STF000004', 'adwoaansah', 'staff', 'login', 'Successful login', '::1', '2025-10-24 17:01:50'),
(17, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-10-28 10:44:56'),
(18, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-10-31 09:59:27'),
(19, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-03 17:03:45'),
(20, 'AD123', 'administrator', 'administrator', 'logout', 'User logged out', '::1', '2025-11-03 17:45:47'),
(21, 'STF000004', 'adwoaansah', 'staff', 'login', 'Successful login', '::1', '2025-11-03 17:45:56'),
(22, 'STF000008', 'afiaasare', 'staff', 'login', 'Successful login', '::1', '2025-11-03 17:46:34'),
(23, 'STF000008', 'afiaasare', 'staff', 'logout', 'User logged out', '::1', '2025-11-03 17:46:41'),
(24, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-03 17:50:46'),
(25, 'AD123', 'administrator', 'administrator', 'logout', 'User logged out', '::1', '2025-11-03 17:54:37'),
(26, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-03 17:58:17'),
(27, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-03 18:00:10'),
(28, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-03 18:01:06'),
(29, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-03 18:02:36'),
(30, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-03 18:03:22'),
(31, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-03 18:05:29'),
(32, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-03 18:14:17'),
(33, 'AD123', 'administrator', 'administrator', 'logout', 'User logged out', '::1', '2025-11-03 18:14:49'),
(34, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-05 22:05:31'),
(35, '', 'vivoroscar', 'administrator', 'failed_login', 'Incorrect password', '::1', '2025-11-05 23:37:47'),
(36, '', 'VivorOscar', 'unknown', 'failed_login', 'Unknown account attempt from IP: ::1', '::1', '2025-11-05 23:37:47'),
(37, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-05 23:38:07'),
(38, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-05 23:43:02'),
(39, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-12 13:49:19'),
(40, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-12 13:53:39'),
(41, 'AD123', 'administrator', 'administrator', 'logout', 'User logged out', '::1', '2025-11-12 15:09:13'),
(42, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-16 07:26:11'),
(43, 'STF000004', 'adwoaansah', 'staff', 'login', 'Successful login', '::1', '2025-11-16 07:31:54'),
(44, 'AD123', 'adwoaansah', 'staff', 'logout', 'User logged out', '::1', '2025-11-16 07:33:13'),
(45, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-16 07:33:16'),
(46, 'AD123', 'administrator', 'administrator', 'assign_staff', 'staff_id=STF000006;class=Basic 9', '::1', '2025-11-16 08:02:58'),
(47, 'AD123', 'administrator', 'administrator', 'logout', 'User logged out', '::1', '2025-11-16 08:05:46'),
(48, 'STF000004', 'adwoaansah', 'staff', 'login', 'Successful login', '::1', '2025-11-16 08:05:54'),
(49, 'STF000004', 'adwoaansah', 'staff', 'logout', 'User logged out', '::1', '2025-11-16 08:06:20'),
(50, 'STF000006', 'akuaosei', 'staff', 'login', 'Successful login', '::1', '2025-11-16 08:06:30'),
(51, 'STF000006', 'akuaosei', 'staff', 'logout', 'User logged out', '::1', '2025-11-16 08:08:39'),
(52, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-16 08:08:44'),
(53, 'AD123', 'administrator', 'administrator', 'assign_staff', 'staff_id=STF000006;class=Basic 9', '::1', '2025-11-16 08:09:03'),
(54, 'AD123', 'administrator', 'administrator', 'logout', 'User logged out', '::1', '2025-11-16 08:09:09'),
(55, 'STF000006', 'akuaosei', 'staff', 'login', 'Successful login', '::1', '2025-11-16 08:09:13'),
(56, 'STF000006', 'akuaosei', 'staff', 'logout', 'User logged out', '::1', '2025-11-16 08:09:41'),
(57, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-16 08:09:46'),
(58, 'AD123', 'administrator', 'administrator', 'logout', 'User logged out', '::1', '2025-11-16 08:15:18'),
(59, 'STF000004', 'adwoaansah', 'staff', 'login', 'Successful login', '::1', '2025-11-16 08:15:28'),
(60, 'STF000004', 'adwoaansah', 'staff', 'logout', 'User logged out', '::1', '2025-11-16 08:15:46'),
(61, 'STD2326382054', 'darkwahelvin', 'student', 'login', 'Successful login', '::1', '2025-11-16 08:16:28'),
(62, 'STD2326382054', 'darkwahelvin', 'student', 'logout', 'User logged out', '::1', '2025-11-16 08:16:44'),
(63, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-16 08:16:48'),
(64, 'AD123', 'administrator', 'administrator', 'delete_payment', 'id=6', '::1', '2025-11-16 08:24:20'),
(65, 'AD123', 'administrator', 'administrator', 'logout', 'User logged out', '::1', '2025-11-16 08:26:16'),
(66, 'STF000006', 'akuaosei', 'staff', 'login', 'Successful login', '::1', '2025-11-16 08:26:21'),
(67, 'STF000006', 'akuaosei', 'staff', 'logout', 'User logged out', '::1', '2025-11-16 08:26:54'),
(68, 'AD123', 'administrator', 'administrator', 'login', 'Successful login', '::1', '2025-11-16 08:26:57'),
(69, 'STF000004', 'adwoaansah', 'staff', 'login', 'Successful login', '::1', '2025-11-16 10:31:19'),
(70, 'STF000004', 'adwoaansah', 'staff', 'logout', 'User logged out', '::1', '2025-11-16 15:22:58');

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
(1, 'COMPUTING', 79.00, 'Basic 7', '2025-09-04 21:10:43'),
(2, 'MATHEMATIC', 89.00, 'Basic 7', '2025-09-04 21:11:07'),
(3, 'ENGLISH', 100.00, 'Basic 7', '2025-09-04 21:11:26'),
(4, 'MATHEMATICS', 152.00, 'Basic 8', '2025-09-04 21:11:57');

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
(542, '254772', 0, '2025-10-24 13:55:19'),
(543, '844188', 0, '2025-10-24 13:55:19'),
(544, '154163', 0, '2025-10-24 13:55:19'),
(545, '455771', 0, '2025-10-24 13:55:19');

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

INSERT INTO `daily_class_summaries` (`id`, `class_name`, `summary_date`, `expected_total`, `received_total`, `updated_at`) VALUES
(1, 'Basic 4', '2025-10-13', 27.00, 135.00, '2025-10-13 05:20:59');

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
(5, 'Basic 1', 'Term One - 2025', 330.00, '2025-08-01'),
(6, 'Basic 2', 'Term One - 2025', 330.00, '2025-10-09');

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
(6, 'feeding', 'Akwatia', 'curaddress', 9.00, '2025-10-12 11:40:57');

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

--
-- Dumping data for table `service_payments`
--

INSERT INTO `service_payments` (`id`, `student_id`, `service_fee_id`, `amount_paid`, `staff_id`, `payment_date`, `receipt_number`) VALUES
(10, 'STD000024', 2, 27.00, 'STF000008', '2025-10-12 11:30:40', 'RCPT-1760268640877'),
(11, 'STD000024', 0, 45.00, 'STF000008', '2025-10-13 05:20:59', 'RCPT-1760332859666'),
(12, 'STD000026', 0, 45.00, 'STF000008', '2025-10-13 05:20:59', 'RCPT-1760332859419'),
(13, 'STD000071', 0, 45.00, 'STF000008', '2025-10-13 05:20:59', 'RCPT-1760332859794'),
(14, 'STD000072', 0, 0.00, 'STF000008', '2025-10-13 05:22:47', 'RCPT-1760332967422');

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
  `curaddress` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `join_date` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `conpassword` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `gender`, `first_name`, `mid_name`, `last_name`, `dob`, `number`, `email`, `class`, `curaddress`, `qualification`, `join_date`, `role`, `username`, `password`, `conpassword`) VALUES
('STF000001', 'Male', 'John', '', 'Kuma', '2001-09-24', '233 598 474 785', 'johnkumah@gmail.com', 'Basic 3', 'KM548', 'Degree', '2024-07-09', 'staff', 'johnkuma', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000002', 'Female', 'Ama', '', 'Boateng', '1999-05-12', '233 245 123 456', 'amaboateng@gmail.com', 'Class 2', 'HS123', 'Diploma', '2023-11-15', 'staff', 'amaboateng', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000003', 'Male', 'Kwame', '', 'Mensah', '1995-03-01', '233 551 789 012', 'kwamemensah@gmail.com', 'Class 1', 'LN789', 'Degree', '2022-08-20', 'staff', 'kwamemensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000004', 'Female', 'Adwoa', '', 'Ansah', '2000-11-20', '233 208 901 234', 'adwoaansah@gmail.com', 'Class 4', 'GN456', 'HND', '2024-01-10', 'staff', 'adwoaansah', '$2y$10$6v543DUHqivv57fzYycmCOIOSptTVa9ol2txmT2yzw4VDYQXRn8Py', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000005', 'Male', 'Kofi', '', 'Agyemang', '1998-07-07', '233 543 210 987', 'kofiagyemang@gmail.com', 'Basic 7', 'AP012', 'Degree', '2023-04-05', 'staff', 'kofiagyemang', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000006', 'Female', 'Akua', '', 'Osei', '1997-02-14', '233 267 890 123', 'akuaosei@gmail.com', 'Basic 9', 'BT789', 'Diploma', '2022-10-01', 'staff', 'akuaosei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000007', 'Male', 'Yaw', '', 'Owusu', '2002-09-03', '233 599 012 345', 'yawowusu@gmail.com', 'Class 1', 'CL345', 'HND', '2024-06-18', 'staff', 'yawowusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000008', 'Female', 'Afia', '', 'Asare', '1996-04-29', '233 270 123 456', 'afiaasare@gmail.com', 'Basic 4', 'ER901', 'Degree', '2023-01-25', 'staff', 'afiaasare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000009', 'Male', 'Kwabena', '', 'Darko', '1994-12-11', '233 540 890 123', 'kwabenadarko@gmail.com', 'Class 3', 'FG567', 'Degree', '2022-05-10', 'staff', 'kwabenadarko', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000010', 'Female', 'Yaa', '', 'Mintah', '2001-08-17', '233 205 678 901', 'yaamintah@gmail.com', 'Class 2', 'HJ123', 'Diploma', '2024-03-01', 'staff', 'yaamintah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000011', 'Male', 'Ofori', '', 'Asamoah', '1993-01-22', '233 591 234 567', 'oforiasamoah@gmail.com', 'Class 1', 'KL678', 'Degree', '2021-09-01', 'staff', 'oforiasamoah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000012', 'Female', 'Serwaa', '', 'Boakye', '1998-06-05', '233 248 901 234', 'serwaaboakye@gmail.com', 'Class 4', 'MN345', 'HND', '2023-08-14', 'staff', 'serwaaboakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000013', 'Male', 'Derrick', '', 'Addo', '2000-03-19', '233 554 321 098', 'derrickaddo@gmail.com', 'Class 3', 'PQ901', 'Degree', '2024-02-28', 'staff', 'derrickaddo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000014', 'Female', 'Faustina', '', 'Kyeremeh', '1997-10-25', '233 260 789 012', 'faustinakyeremeh@gmail.com', 'Class 2', 'RS123', 'Diploma', '2023-06-09', 'staff', 'faustinakyeremeh', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000015', 'Male', 'Emmanuel', '', 'Frimpong', '1995-08-08', '233 592 345 678', 'emmanuelfrimpong@gmail.com', 'Class 1', 'TU789', 'Degree', '2022-03-17', 'staff', 'emmanuelfrimpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000016', 'Female', 'Joyce', '', 'Danquah', '2001-01-30', '233 209 012 345', 'joycedanquah@gmail.com', 'Class 4', 'VW456', 'HND', '2024-05-22', 'staff', 'joycedanquah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000017', 'Male', 'Richard', '', 'Ampofo', '1996-11-03', '233 547 890 123', 'richardampofo@gmail.com', 'Class 3', 'XY012', 'Degree', '2023-09-01', 'staff', 'richardampofo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000018', 'Female', 'Christiana', '', 'Baah', '1999-04-10', '233 273 456 789', 'christianabaah@gmail.com', 'Class 2', 'ZA789', 'Diploma', '2022-12-05', 'staff', 'christianabaah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000019', 'Male', 'George', '', 'Sarpong', '2000-07-16', '233 550 123 456', 'georgesarpong@gmail.com', 'Class 1', 'BC345', 'HND', '2024-01-18', 'staff', 'georgesarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000020', 'Female', 'Mercy', '', 'Opoku', '1994-09-28', '233 204 567 890', 'mercyopoku@gmail.com', 'Class 4', 'DE901', 'Degree', '2023-03-07', 'staff', 'mercyopoku', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000021', 'Male', 'Joseph', '', 'Appiah', '1992-02-09', '233 596 789 012', 'josephappiah@gmail.com', 'Class 3', 'FG567', 'Degree', '2022-07-20', 'staff', 'josephappiah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000022', 'Female', 'Elizabeth', '', 'Owusu-Ansah', '1997-07-23', '233 241 234 567', 'elizabethowusuansah@gmail.com', 'Class 2', 'HI123', 'Diploma', '2023-11-01', 'staff', 'elizabowo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000023', 'Male', 'David', '', 'Osei-Tutu', '1996-03-05', '233 558 901 234', 'davidoseitutu@gmail.com', 'Class 1', 'JK789', 'HND', '2024-04-10', 'staff', 'davidoos', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000024', 'Female', 'Patricia', '', 'Mensah', '2000-12-18', '233 266 789 012', 'patriciamensah@gmail.com', 'Class 4', 'LM456', 'Degree', '2023-02-15', 'staff', 'patriciamensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000025', 'Male', 'Samuel', '', 'Opare', '1993-05-01', '233 597 890 123', 'samuelopare@gmail.com', 'Class 3', 'NO012', 'Degree', '2022-09-25', 'staff', 'samuelopare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000026', 'Female', 'Linda', '', 'Agyapong', '1998-08-02', '233 203 456 789', 'lindaagyapong@gmail.com', 'Class 2', 'PQ789', 'Diploma', '2024-06-03', 'staff', 'lindaagyapong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000027', 'Male', 'Peter', '', 'Akoto', '2001-04-15', '233 549 012 345', 'peterakoto@gmail.com', 'Class 1', 'RS345', 'HND', '2023-01-08', 'staff', 'peterakoto', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000028', 'Female', 'Diana', '', 'Owusu', '1995-10-09', '233 275 678 901', 'dianaowusu@gmail.com', 'Class 4', 'TU901', 'Degree', '2022-04-20', 'staff', 'dianaowusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000029', 'Male', 'Frank', '', 'Donkor', '1994-01-27', '233 552 345 678', 'frankdonkor@gmail.com', 'Class 3', 'VW567', 'Degree', '2024-03-11', 'staff', 'frankdonkor', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000030', 'Female', 'Sandra', '', 'Boakye', '1999-06-14', '233 201 234 567', 'sandraboakye@gmail.com', 'Class 2', 'XY123', 'Diploma', '2023-07-01', 'staff', 'sandraboakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000031', 'Male', 'Louis', '', 'Annan', '1997-03-08', '233 593 456 789', 'louisannan@gmail.com', 'Class 1', 'ZA789', 'HND', '2022-11-19', 'staff', 'louisannan', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000032', 'Female', 'Vivian', '', 'Kwakye', '2000-09-01', '233 240 123 456', 'viviankwakye@gmail.com', 'Class 4', 'BC345', 'Degree', '2024-05-06', 'staff', 'viviankwakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000033', 'Male', 'Daniel', '', 'Ofori', '1992-07-10', '233 556 789 012', 'danielofori@gmail.com', 'Class 3', 'DE901', 'Degree', '2023-09-12', 'staff', 'danielofori', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000034', 'Female', 'Hannah', '', 'Opare', '1996-02-20', '233 268 901 234', 'hannahopare@gmail.com', 'Class 2', 'FG567', 'Diploma', '2022-06-25', 'staff', 'hannahopare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000035', 'Male', 'Kenneth', '', 'Boadi', '1998-11-05', '233 590 123 456', 'kennethboadi@gmail.com', 'Class 1', 'HI123', 'HND', '2024-01-03', 'staff', 'kennethboadi', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000036', 'Female', 'Theresa', '', 'Adjei', '2001-05-18', '233 206 789 012', 'theresaadjei@gmail.com', 'Class 4', 'JK789', 'Degree', '2023-04-19', 'staff', 'theresaadjei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000037', 'Male', 'Maxwell', '', 'Amoah', '1995-09-21', '233 541 234 567', 'maxwellamoah@gmail.com', 'Class 3', 'LM456', 'Degree', '2022-10-08', 'staff', 'maxwellamoah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000038', 'Female', 'Rebecca', '', 'Dankwa', '1999-01-04', '233 277 890 123', 'rebeccadankwa@gmail.com', 'Class 2', 'NO012', 'Diploma', '2024-02-01', 'staff', 'rebeccadankwa', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy'),
('STF000039', 'Male', 'Kelvin', '', 'Abban', '2000-06-29', '233 553 456 789', 'kelvinabban@gmail.com', 'Class 1', 'PQ789', 'HND', '2023-06-16', 'staff', 'kelvinabban', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy');

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
(14, 'STF000002', 'Creche'),
(15, 'STF000004', 'Nursery 1'),
(19, 'STF000005', 'Basic 7'),
(23, 'STF0000040', 'Basic 4'),
(24, 'STF000008', 'Basic 4'),
(26, 'STF000006', 'Basic 9');

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
  `conpassword` varchar(255) NOT NULL,
  `alumni_year` int(11) DEFAULT NULL,
  `promotion_status` varchar(20) DEFAULT NULL,
  `promotion_target` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `gender`, `first_name`, `mid_name`, `last_name`, `dob`, `number`, `email`, `class`, `curaddress`, `parent_name`, `parent_email`, `parent_number`, `role`, `username`, `password`, `conpassword`, `alumni_year`, `promotion_status`, `promotion_target`) VALUES
('STD000001', 'Female', 'Ama', 'Adwoa', 'Mensah', '2019-01-15', '233 245 111 222', 'amemensah@gmail.com', 'Creche', 'Akwatia', 'Kwame', 'kwameboateng@gmail.com', '233 245 333 444', 'student', 'ama-mensah', '$2y$10$QNqkEg6enF0wTFqIPFlS7.MSxJhlAFwyAJLL6zuMkvYEqQx0cPZFW', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000002', 'Male', 'Kwame', 'Kofi', 'Adu', '2019-03-20', '233 555 111 222', 'kwameadu@gmail.com', 'Creche', 'P102', 'Ama', 'amaakua@gmail.com', '233 555 333 444', 'student', 'kwame-adu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000003', 'Female', 'Akua', 'Yaa', 'Sarpong', '2018-05-10', '233 200 111 222', 'akuaasarpong@gmail.com', 'Nursery 1', 'P103', 'Yaw', 'yawkofi@gmail.com', '233 200 333 444', 'student', 'akua-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000004', 'Male', 'Yaw', 'Kwame', 'Ntim', '2018-07-25', '233 244 111 222', 'yawntim@gmail.com', 'Nursery 1', 'P104', 'Adwoa', 'adwoaama@gmail.com', '233 244 333 444', 'student', 'yaw-ntim', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000005', 'Female', 'Adwoa', 'Ama', 'Frimpong', '2018-09-02', '233 500 111 222', 'adwoafrimpong@gmail.com', 'Nursery 1', 'P105', 'Kwasi', 'kwasifrimpong@gmail.com', '233 500 333 444', 'student', 'adwoa-frimpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000006', 'Male', 'Kofi', 'Yaw', 'Appiah', '2017-02-14', '233 201 111 222', 'kofiappiah@gmail.com', 'Nursery 2', 'P106', 'Akosua', 'akosuaadwoa@gmail.com', '233 201 333 444', 'student', 'kofi-appiah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000007', 'Female', 'Akosua', 'Yaa', 'Danquah', '2017-04-28', '233 544 111 222', 'akosuadanq@gmail.com', 'Nursery 2', 'P107', 'Kwame', 'kwamedanquah@gmail.com', '233 544 333 444', 'student', 'akosua-danquah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000008', 'Male', 'Kwasi', 'Kojo', 'Nkrumah', '2017-06-12', '233 266 111 222', 'kwasinkrumah@gmail.com', 'Nursery 2', 'P108', 'Ama', 'amankrumah@gmail.com', '233 266 333 444', 'student', 'kwasi-nkrumah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000009', 'Female', 'Yaa', 'Adwoa', 'Owusu', '2016-08-01', '233 577 111 222', 'yaaowusu@gmail.com', 'Basic 1', 'P109', 'Kofi', 'kofiowusu@gmail.com', '233 577 333 444', 'student', 'yaa-owusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j\r\n/mSLy', NULL, NULL, NULL),
('STD000010', 'Male', 'Kojo', 'Kwame', 'Boateng', '2016-01-05', '233 243 111 222', 'kojoboateng@gmail.com', 'Basic 1', 'P110', 'Adwoa', 'adwoaboateng@gmail.com', '233 243 333 444', 'student', 'kojo-boateng', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000011', 'Female', 'Adwoa', 'Akua', 'Osei', '2016-03-18', '233 502 111 222', 'adwoaosei@gmail.com', 'Basic 1', 'P111', 'Kwasi', 'kwasio@gmail.com', '233 502 333 444', 'student', 'adwoa-osei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000012', 'Male', 'Kwame', 'Adjei', 'Manu', '2016-05-22', '233 241 111 222', 'kwamemanu@gmail.com', 'Basic 1', 'P112', 'Akua', 'akuamanu@gmail.com', '233 241 333 444', 'student', 'kwame-manu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000013', 'Female', 'Abena', 'Akosua', 'Dabo', '2016-07-30', '233 551 111 222', 'abenadabo@gmail.com', 'Basic 1', 'P113', 'Yaw', 'yawkofi@gmail.com', '233 551 333 444', 'student', 'abena-dabo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000014', 'Male', 'Yaw', 'Kofi', 'Asare', '2015-09-11', '233 203 111 222', 'yawasare@gmail.com', 'Basic 2', 'P114', 'Ama', 'amaasare@gmail.com', '233 203 333 444', 'student', 'yaw-asare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD0000146', 'WASSCE', 'Vivor ', 'Oscar', 'Makafui', '2025-09-13', '233533519466', 'oscarvivor@gmail.com', '', 'KN456', '', '', '', 'staff', 'vivoroscar', '$2y$10$TBqxLQjjQwlHBvdCoUs0QulvpWoXuAgSuDCFeqL9wivsQC5RwQRfy', '$2y$10$ygqIMqdjqzxOM9YuJXqQW.fT3A3poqDpCGYQqwB7AJs7KFmoPQWaO', NULL, NULL, NULL),
('STD000015', 'Female', 'Adwoa', 'Yaa', 'Ansah', '2015-11-25', '233 543 111 222', 'adwoaansah@gmail.com', 'Basic 2', 'P115', 'Kwame', 'kwameansah@gmail.com', '233 543 333 444', 'student', 'adwoa-ansah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000016', 'Male', 'Kofi', 'Yaw', 'Boakye', '2015-01-08', '233 262 111 222', 'kofiboakye@gmail.com', 'Basic 2', 'P116', 'Akua', 'akuaboakye@gmail.com', '233 262 333 444', 'student', 'kofi-boakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000017', 'Female', 'Akua', 'Ama', 'Agyemang', '2015-03-12', '233 571 111 222', 'akuaagyemang@gmail.com', 'Basic 2', 'P117', 'Yaw', 'yawagyemang@gmail.com', '233 571 333 444', 'student', 'akua-agyemang', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000018', 'Male', 'Kwasi', 'Kofi', 'Gyasi', '2015-05-20', '233 240 111 222', 'kwasigyasi@gmail.com', 'Basic 2', 'P118', 'Abena', 'abenagyasi@gmail.com', '233 240 333 444', 'student', 'kwasi-gyasi', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000019', 'Female', 'Yaa', 'Akua', 'Mensah', '2014-07-07', '233 509 111 222', 'yaamensah@gmail.com', 'Basic 3', 'P119', 'Kofi', 'kofimensah@gmail.com', '233 509 333 444', 'student', 'yaa-mensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000020', 'Male', 'Kojo', 'Osei', 'Sarpong', '2014-09-19', '233 208 111 222', 'kojosarpong@gmail.com', 'Basic 3', 'P120', 'Adwoa', 'adwoasarpong@gmail.com', '233 208 333 444', 'student', 'kojo-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000021', 'Female', 'Adwoa', 'Yaa', 'Dankwa', '2014-11-03', '233 548 111 222', 'adwoadankwa@gmail.com', 'Basic 3', 'P121', 'Kwame', 'kwamedankwa@gmail.com', '233 548 333 444', 'student', 'adwoa-dankwa', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000022', 'Male', 'Kwame', 'Kojo', 'Appiah', '2014-01-28', '233 267 111 222', 'kwameappiah@gmail.com', 'Basic 3', 'P122', 'Akosua', 'akosuaappiah@gmail.com', '233 267 333 444', 'student', 'kwame-appiah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000023', 'Female', 'Akosua', 'Yaa', 'Owusu', '2014-03-14', '233 576 111 222', 'akosuaowusu@gmail.com', 'Basic 3', 'P123', 'Yaw', 'yawowusu@gmail.com', '233 576 333 444', 'student', 'akosua-owusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000024', 'Male', 'Yaw', 'Kofi', 'Boahen', '2013-05-18', '233 245 111 222', 'yawboahen@gmail.com', 'Basic 4', 'Akwatia', 'Ama', 'amaboahen@gmail.com', '233 245 333 444', 'student', 'yaw-boahen', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000025', 'Female', 'Ama', 'Adwoa', 'Addai', '2013-07-29', '233 554 111 222', 'amaaddai@gmail.com', 'Basic 4', 'P125', 'Kwame', 'kwameaddai@gmail.com', '233 554 333 444', 'student', 'ama-addai', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000026', 'Male', 'Kwame', 'Kwasi', 'Asante', '2013-09-02', '233 204 111 222', 'kwameasante@gmail.com', 'Basic 4', 'Akwatia', 'Akua', 'akuaasante@gmail.com', '233 204 333 444', 'student', 'kwame-asante', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000027', 'Female', 'Akua', 'Adwoa', 'Ampofo', '2013-11-15', '233 541 111 222', 'akuaampofo@gmail.com', 'Basic 4', 'P127', 'Yaw', 'yawampofo@gmail.com', '233 541 333 444', 'student', 'akua-ampofo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000028', 'Male', 'Kofi', 'Yaw', 'Darko', '2013-01-10', '233 261 111 222', 'kofidarko@gmail.com', 'Basic 4', 'P128', 'Abena', 'abenadarko@gmail.com', '233 261 333 444', 'student', 'kofi-darko', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000029', 'Female', 'Yaa', 'Akosua', 'Agyei', '2012-03-24', '233 570 111 222', 'yaaagyei@gmail.com', 'Basic 5', 'P129', 'Kofi', 'kofiagyei@gmail.com', '233 570 333 444', 'student', 'yaa-agyei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000030', 'Male', 'Kojo', 'Kwame', 'Mensah', '2012-05-08', '233 249 111 222', 'kojomensah@gmail.com', 'Basic 5', 'P130', 'Adwoa', 'adwoamensah@gmail.com', '233 249 333 444', 'student', 'kojo-mensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000031', 'Female', 'Akua', 'Adwoa', 'Sarpong', '2012-07-16', '233 508 111 222', 'akuasarpong@gmail.com', 'Basic 5', 'P131', 'Kwame', 'kwamesarpong@gmail.com', '233 508 333 444', 'student', 'akua-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000032', 'Male', 'Yaw', 'Kofi', 'Asare', '2012-09-20', '233 207 111 222', 'yawasare@gmail.com', 'Basic 5', 'P132', 'Ama', 'amaasare@gmail.com', '233 207 333 444', 'student', 'yaw-asare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000033', 'Female', 'Adwoa', 'Yaa', 'Adu', '2012-11-05', '233 547 111 222', 'adwoaadu@gmail.com', 'Basic 5', 'P133', 'Kwasi', 'kwasiadu@gmail.com', '233 547 333 444', 'student', 'adwoa-adu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000034', 'Male', 'Kofi', 'Adjei', 'Annan', '2011-01-20', '233 266 111 222', 'kofiannan@gmail.com', 'Basic 6', 'P134', 'Akosua', 'akosuaannan@gmail.com', '233 266 333 444', 'student', 'kofi-annan', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000035', 'Female', 'Akua', 'Yaa', 'Boakye', '2011-03-15', '233 575 111 222', 'akuaboakye@gmail.com', 'Basic 6', 'P135', 'Yaw', 'yawboakye@gmail.com', '233 575 333 444', 'student', 'akua-boakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000036', 'Male', 'Kwame', 'Kofi', 'Gyasi', '2011-05-29', '233 244 111 222', 'kwamegyasi@gmail.com', 'Basic 6', 'P136', 'Abena', 'abenagyasi@gmail.com', '233 244 333 444', 'student', 'kwame-gyasi', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000037', 'Female', 'Abena', 'Adwoa', 'Mensah', '2011-07-13', '233 553 111 222', 'abenamensah@gmail.com', 'Basic 6', 'P137', 'Kofi', 'kofimensah@gmail.com', '233 553 333 444', 'student', 'abena-mensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000038', 'Male', 'Yaw', 'Kojo', 'Sarpong', '2011-09-27', '233 203 111 222', 'yawsarpong@gmail.com', 'Basic 6', 'P138', 'Ama', 'amasarpong@gmail.com', '233 203 333 444', 'student', 'yaw-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000039', 'Female', 'Ama', 'Yaa', 'Dankwa', '2010-11-04', '233 542 111 222', 'amadankwa@gmail.com', 'Basic 7', 'P139', 'Kwame', 'kwamedankwa@gmail.com', '233 542 333 444', 'student', 'ama-dankwa', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000040', 'Male', 'Kwame', 'Kofi', 'Appiah', '2010-01-18', '233 262 111 222', 'kwameappiah@gmail.com', 'Basic 7', 'P140', 'Akosua', 'akosuaappiah@gmail.com', '233 262 333 444', 'student', 'kwame-appiah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000041', 'Female', 'Adwoa', 'Akosua', 'Owusu', '2010-03-02', '233 571 111 222', 'adwoaowusu@gmail.com', 'Basic 7', 'P141', 'Yaw', 'yawowusu@gmail.com', '233 571 333 444', 'student', 'adwoa-owusu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000042', 'Male', 'Kofi', 'Kwame', 'Boahen', '2010-05-16', '233 240 111 222', 'kofiboahen@gmail.com', 'Basic 7', 'P142', 'Akua', 'akuaboahen@gmail.com', '233 240 333 444', 'student', 'kofi-boahen', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000043', 'Female', 'Akua', 'Adwoa', 'Addai', '2010-07-28', '233 509 111 222', 'akuaaddai@gmail.com', 'Basic 7', 'P143', 'Kofi', 'kofiaddai@gmail.com', '233 509 333 444', 'student', 'akua-addai', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000044', 'Male', 'Yaw', 'Kofi', 'Asante', '2009-09-12', '233 208 111 222', 'yawasante@gmail.com', 'Basic 8', 'P144', 'Ama', 'amaasante@gmail.com', '233 208 333 444', 'student', 'yaw-asante', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000045', 'Female', 'Ama', 'Adwoa', 'Ampofo', '2009-11-26', '233 548 111 222', 'amaampofo@gmail.com', 'Basic 8', 'P145', 'Kwame', 'kwameampofo@gmail.com', '233 548 333 444', 'student', 'ama-ampofo', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000046', 'Male', 'Kwame', 'Kwasi', 'Darko', '2009-01-10', '233 267 111 222', 'kwamedarko@gmail.com', 'Basic 8', 'P146', 'Akua', 'akuadarko@gmail.com', '233 267 333 444', 'student', 'kwame-darko', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000047', 'Female', 'Akua', 'Adwoa', 'Agyei', '2009-03-24', '233 576 111 222', 'akuaagyei@gmail.com', 'Basic 8', 'P147', 'Yaw', 'yawagyei@gmail.com', '233 576 333 444', 'student', 'akua-agyei', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000048', 'Male', 'Kofi', 'Yaw', 'Mensah', '2009-05-08', '233 245 111 222', 'kofimensah@gmail.com', 'Basic 8', 'P148', 'Abena', 'abenamensah@gmail.com', '233 245 333 444', 'student', 'kofi-mensah', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000049', 'Female', 'Yaa', 'Akosua', 'Sarpong', '2008-07-16', '233 554 111 222', 'yaasarpong@gmail.com', 'Old Student - 2025', 'P149', 'Kofi', 'kofisarpong@gmail.com', '233 554 333 444', 'student', 'yaa-sarpong', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', 2025, 'success', NULL),
('STD000050', 'Male', 'Kojo', 'Kwame', 'Adu', '2008-09-20', '233 204 111 222', 'kojoadu@gmail.com', 'Old Student - 2025', 'P150', 'Adwoa', 'adwoaadu@gmail.com', '233 204 333 444', 'student', 'kojo-adu', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', 2025, 'success', NULL),
('STD000051', 'Female', 'Akua', 'Adwoa', 'Asare', '2008-11-05', '233 541 111 222', 'akuaasare@gmail.com', 'Old Student - 2025', 'P151', 'Kwame', 'kwameasare@gmail.com', '233 541 333 444', 'student', 'akua-asare', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', 2025, 'success', NULL),
('STD000052', 'Male', 'Yaw', 'Kofi', 'Annan', '2008-01-20', '233 261 111 222', 'yawanann@gmail.com', 'Old Student - 2025', 'P152', 'Ama', 'amaannan@gmail.com', '233 261 333 444', 'student', 'yaw-annan', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', 2025, 'success', NULL),
('STD000053', 'Female', 'Adwoa', 'Yaa', 'Boakye', '2008-03-15', '233 570 111 222', 'adwoaboakye@gmail.com', 'Old Student - 2025', 'P153', 'Kwasi', 'kwasiboakye@gmail.com', '233 570 333 444', 'student', 'adwoa-boakye', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', 2025, 'success', NULL),
('STD000054', 'Male', 'Kwame', 'Kofi', 'Gyasi', '2019-02-01', '233 241 111 222', 'kwamegyasi2@gmail.com', 'Creche', 'P154', 'Akua', 'akuagyasi@gmail.com', '233 241 333 444', 'student', 'kwame-gyasi2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000055', 'Female', 'Adwoa', 'Akua', 'Mensah', '2019-04-10', '233 500 111 222', 'adwoamensah2@gmail.com', 'Creche', 'P155', 'Yaw', 'yawnmensah@gmail.com', '233 500 333 444', 'student', 'adwoa-mensah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000056', 'Male', 'Yaw', 'Kojo', 'Sarpong', '2018-06-18', '233 200 111 222', 'yawsarpong2@gmail.com', 'Nursery 1', 'P156', 'Ama', 'amasarpong2@gmail.com', '233 200 333 444', 'student', 'yaw-sarpong2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000057', 'Female', 'Ama', 'Yaa', 'Dankwa', '2018-08-25', '233 555 111 222', 'amadankwa2@gmail.com', 'Nursery 1', 'P157', 'Kwame', 'kwamedankwa2@gmail.com', '233 555 333 444', 'student', 'ama-dankwa2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000058', 'Male', 'Kofi', 'Kwame', 'Appiah', '2018-10-09', '233 244 111 222', 'kofiappiah2@gmail.com', 'Nursery 1', 'P158', 'Akosua', 'akosuaappiah2@gmail.com', '233 244 333 444', 'student', 'kofi-appiah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000059', 'Female', 'Adwoa', 'Akosua', 'Owusu', '2017-12-14', '233 500 111 222', 'adwoaowusu2@gmail.com', 'Nursery 2', 'P159', 'Yaw', 'yawowusu2@gmail.com', '233 500 333 444', 'student', 'adwoa-owusu2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000060', 'Male', 'Kwasi', 'Kofi', 'Boahen', '2017-02-28', '233 201 111 222', 'kwasiboahen@gmail.com', 'Nursery 2', 'P160', 'Akua', 'akuaboahen2@gmail.com', '233 201 333 444', 'student', 'kwasi-boahen', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000061', 'Female', 'Akua', 'Adwoa', 'Addai', '2017-04-05', '233 544 111 222', 'akuaaddai2@gmail.com', 'Nursery 2', 'P161', 'Kofi', 'kofiaddai2@gmail.com', '233 544 333 444', 'student', 'akua-addai2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000062', 'Male', 'Yaw', 'Kwame', 'Asante', '2016-06-20', '233 266 111 222', 'yawasante2@gmail.com', 'Basic 1', 'P162', 'Ama', 'amaasante2@gmail.com', '233 266 333 444', 'student', 'yaw-asante2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000063', 'Female', 'Ama', 'Adwoa', 'Ampofo', '2016-08-01', '233 577 111 222', 'amaampofo2@gmail.com', 'Basic 1', 'P163', 'Kwame', 'kwameampofo2@gmail.com', '233 577 333 444', 'student', 'ama-ampofo2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000064', 'Male', 'Kwame', 'Kofi', 'Darko', '2016-10-15', '233 243 111 222', 'kwamedarko2@gmail.com', 'Basic 1', 'P164', 'Akua', 'akuadarko2@gmail.com', '233 243 333 444', 'student', 'kwame-darko2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000065', 'Female', 'Akua', 'Adwoa', 'Agyei', '2015-12-22', '233 502 111 222', 'akuaagyei2@gmail.com', 'Basic 2', 'P165', 'Yaw', 'yawagyei2@gmail.com', '233 502 333 444', 'student', 'akua-agyei2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000066', 'Male', 'Kofi', 'Yaw', 'Mensah', '2015-02-05', '233 241 111 222', 'kofimensah2@gmail.com', 'Basic 2', 'P166', 'Abena', 'abenamensah2@gmail.com', '233 241 333 444', 'student', 'kofi-mensah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000067', 'Female', 'Yaa', 'Akosua', 'Sarpong', '2015-04-14', '233 551 111 222', 'yaasarpong2@gmail.com', 'Basic 2', 'P167', 'Kofi', 'kofisarpong2@gmail.com', '233 551 333 444', 'student', 'yaa-sarpong2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000068', 'Male', 'Kojo', 'Kwame', 'Adu', '2014-06-20', '233 203 111 222', 'kojoadu2@gmail.com', 'Basic 3', 'P168', 'Adwoa', 'adwoaadu2@gmail.com', '233 203 333 444', 'student', 'kojo-adu2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000069', 'Female', 'Akua', 'Adwoa', 'Asare', '2014-08-01', '233 543 111 222', 'akuaasare2@gmail.com', 'Basic 3', 'P169', 'Kwame', 'kwameasare2@gmail.com', '233 543 333 444', 'student', 'akua-asare2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000070', 'Male', 'Yaw', 'Kofi', 'Annan', '2014-10-15', '233 262 111 222', 'yawannan2@gmail.com', 'Basic 3', 'P170', 'Ama', 'amaannan2@gmail.com', '233 262 333 444', 'student', 'yaw-annan2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000071', 'Female', 'Adwoa', 'Yaa', 'Boakye', '2013-12-22', '233 571 111 222', 'adwoaboakye2@gmail.com', 'Basic 4', 'Akwatia', 'Kwasi', 'kwasiboakye2@gmail.com', '233 571 333 444', 'student', 'adwoa-boakye2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000072', 'Male', 'Kofi', 'Adjei', 'Gyasi', '2013-02-05', '233 240 111 222', 'kofigyasi2@gmail.com', 'Basic 4', 'P172', 'Akosua', 'akosuaagyasi@gmail.com', '233 240 333 444', 'student', 'kofi-gyasi2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000073', 'Female', 'Akua', 'Yaa', 'Mensah', '2013-04-14', '233 509 111 222', 'akuamensah2@gmail.com', 'Basic 4', 'P173', 'Yaw', 'yawmensah2@gmail.com', '233 509 333 444', 'student', 'akua-mensah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000074', 'Male', 'Kwame', 'Kofi', 'Sarpong', '2012-06-20', '233 208 111 222', 'kwamesarpong2@gmail.com', 'Basic 5', 'P174', 'Abena', 'abenasarpong@gmail.com', '233 208 333 444', 'student', 'kwame-sarpong2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000075', 'Female', 'Abena', 'Adwoa', 'Dankwa', '2012-08-01', '233 548 111 222', 'abenadankwa@gmail.com', 'Basic 5', 'P175', 'Kofi', 'kofidankwa@gmail.com', '233 548 333 444', 'student', 'abena-dankwa', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000076', 'Male', 'Yaw', 'Kojo', 'Appiah', '2012-10-15', '233 267 111 222', 'yawappiah2@gmail.com', 'Basic 5', 'P176', 'Ama', 'amaappiah@gmail.com', '233 267 333 444', 'student', 'yaw-appiah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000077', 'Female', 'Akua', 'Yaa', 'Owusu', '2011-12-22', '233 576 111 222', 'akuaowusu2@gmail.com', 'Basic 6', 'P177', 'Kwame', 'kwameowusu2@gmail.com', '233 576 333 444', 'student', 'akua-owusu2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000078', 'Male', 'Kofi', 'Kwame', 'Boahen', '2011-02-05', '233 245 111 222', 'kofiboahen2@gmail.com', 'Basic 6', 'P178', 'Akosua', 'akosuaboahen@gmail.com', '233 245 333 444', 'student', 'kofi-boahen2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000079', 'Female', 'Adwoa', 'Akosua', 'Addai', '2011-04-14', '233 554 111 222', 'adwoaaddai2@gmail.com', 'Basic 6', 'P179', 'Yaw', 'yawaddai@gmail.com', '233 554 333 444', 'student', 'adwoa-addai2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000080', 'Male', 'Kwame', 'Kwasi', 'Asante', '2010-06-20', '233 204 111 222', 'kwameasante2@gmail.com', 'Basic 7', 'P180', 'Abena', 'abenaasante@gmail.com', '233 204 333 444', 'student', 'kwame-asante2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000081', 'Female', 'Akua', 'Adwoa', 'Ampofo', '2010-08-01', '233 541 111 222', 'akuaampofo2@gmail.com', 'Basic 7', 'P181', 'Kofi', 'kofiampofo@gmail.com', '233 541 333 444', 'student', 'akua-ampofo2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000082', 'Male', 'Yaw', 'Kofi', 'Darko', '2010-10-15', '233 261 111 222', 'yawdarko2@gmail.com', 'Basic 7', 'P182', 'Ama', 'amadarko2@gmail.com', '233 261 333 444', 'student', 'yaw-darko2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000083', 'Female', 'Ama', 'Yaa', 'Agyei', '2009-12-22', '233 570 111 222', 'amaagyei2@gmail.com', 'Basic 8', 'P183', 'Kwame', 'kwameagyei2@gmail.com', '233 570 333 444', 'student', 'ama-agyei2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000084', 'Male', 'Kwame', 'Adjei', 'Mensah', '2009-02-05', '233 241 111 222', 'kwamemensah2@gmail.com', 'Basic 8', 'P184', 'Akosua', 'akosuamensah@gmail.com', '233 241 333 444', 'student', 'kwame-mensah2', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000085', 'Female', 'Akua', 'Akosua', 'Sarpong', '2009-04-14', '233 500 111 222', 'akuasarpong3@gmail.com', 'Basic 8', 'P185', 'Yaw', 'yawsarpong3@gmail.com', '233 500 333 444', 'student', 'akua-sarpong3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000086', 'Male', 'Kofi', 'Osei', 'Adu', '2008-06-20', '233 200 111 222', 'kofiadu3@gmail.com', 'Basic 9', 'P186', 'Abena', 'abenaadu@gmail.com', '233 200 333 444', 'student', 'kofi-adu3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000087', 'Female', 'Yaa', 'Adwoa', 'Asare', '2008-08-01', '233 555 111 222', 'yaaasare3@gmail.com', 'Basic 9', 'P187', 'Kofi', 'kofiasare3@gmail.com', '233 555 333 444', 'student', 'yaa-asare3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000088', 'Male', 'Kojo', 'Kwame', 'Annan', '2008-10-15', '233 244 111 222', 'kojoannan3@gmail.com', 'Basic 9', 'P188', 'Adwoa', 'adwoaannan@gmail.com', '233 244 333 444', 'student', 'kojo-annan3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000089', 'Female', 'Adwoa', 'Akua', 'Boakye', '2008-12-22', '233 500 111 222', 'adwoaboakye3@gmail.com', 'Basic 9', 'P189', 'Kwame', 'kwameboakye3@gmail.com', '233 500 333 444', 'student', 'adwoa-boakye3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000090', 'Male', 'Kwasi', 'Kojo', 'Gyasi', '2019-02-05', '233 201 111 222', 'kwasigyasi3@gmail.com', 'Creche', 'P190', 'Akua', 'akuagyasi3@gmail.com', '233 201 333 444', 'student', 'kwasi-gyasi3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000091', 'Female', 'Akua', 'Adwoa', 'Mensah', '2019-04-14', '233 544 111 222', 'akuamensah3@gmail.com', 'Creche', 'P191', 'Kofi', 'kofimensah3@gmail.com', '233 544 333 444', 'student', 'akua-mensah3', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000092', 'Male', 'Yaw', 'Kofi', 'Sarpong', '2018-06-20', '233 266 111 222', 'yawsarpong4@gmail.com', 'Nursery 1', 'P192', 'Ama', 'amasarpong4@gmail.com', '233 266 333 444', 'student', 'yaw-sarpong4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000093', 'Female', 'Ama', 'Adwoa', 'Dankwa', '2018-08-01', '233 577 111 222', 'amadankwa4@gmail.com', 'Nursery 1', 'P193', 'Kwame', 'kwamedankwa4@gmail.com', '233 577 333 444', 'student', 'ama-dankwa4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000094', 'Male', 'Kwame', 'Kojo', 'Appiah', '2018-10-15', '233 243 111 222', 'kwameappiah4@gmail.com', 'Nursery 1', 'P194', 'Akosua', 'akosuaappiah4@gmail.com', '233 243 333 444', 'student', 'kwame-appiah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000095', 'Female', 'Adwoa', 'Yaa', 'Owusu', '2017-12-22', '233 502 111 222', 'adwoaowusu4@gmail.com', 'Nursery 2', 'P195', 'Yaw', 'yawowusu4@gmail.com', '233 502 333 444', 'student', 'adwoa-owusu4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000096', 'Male', 'Kofi', 'Adjei', 'Boahen', '2017-02-05', '233 241 111 222', 'kofiboahen4@gmail.com', 'Nursery 2', 'P196', 'Ama', 'amaboahen4@gmail.com', '233 241 333 444', 'student', 'kofi-boahen4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000097', 'Female', 'Akua', 'Adwoa', 'Addai', '2017-04-14', '233 551 111 222', 'akuaaddai4@gmail.com', 'Nursery 2', 'P197', 'Kwame', 'kwameaddai4@gmail.com', '233 551 333 444', 'student', 'akua-addai4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000098', 'Male', 'Yaw', 'Kwame', 'Asante', '2016-06-20', '233 203 111 222', 'yawasante4@gmail.com', 'Basic 1', 'P198', 'Akosua', 'akosuaasante4@gmail.com', '233 203 333 444', 'student', 'yaw-asante4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000099', 'Female', 'Ama', 'Akua', 'Ampofo', '2016-08-01', '233 543 111 222', 'amaampofo4@gmail.com', 'Basic 1', 'P199', 'Yaw', 'yawampofo4@gmail.com', '233 543 333 444', 'student', 'ama-ampofo4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000100', 'Male', 'Kwame', 'Kwasi', 'Darko', '2016-10-15', '233 262 111 222', 'kwamedarko4@gmail.com', 'Basic 1', 'P200', 'Abena', 'abenadarko4@gmail.com', '233 262 333 444', 'student', 'kwame-darko4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000101', 'Female', 'Akua', 'Adwoa', 'Agyei', '2015-12-22', '233 571 111 222', 'akuaagyei4@gmail.com', 'Basic 2', 'P201', 'Kofi', 'kofiagyei4@gmail.com', '233 571 333 444', 'student', 'akua-agyei4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000102', 'Male', 'Kofi', 'Yaw', 'Mensah', '2015-02-05', '233 240 111 222', 'kofimensah4@gmail.com', 'Basic 2', 'P202', 'Adwoa', 'adwoamensah4@gmail.com', '233 240 333 444', 'student', 'kofi-mensah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000103', 'Female', 'Yaa', 'Akosua', 'Sarpong', '2015-04-14', '233 509 111 222', 'yaasarpong4@gmail.com', 'Basic 2', 'P203', 'Kwame', 'kwamesarpong4@gmail.com', '233 509 333 444', 'student', 'yaa-sarpong4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000104', 'Male', 'Kojo', 'Kwame', 'Adu', '2014-06-20', '233 208 111 222', 'kojoadu4@gmail.com', 'Basic 3', 'P204', 'Akosua', 'akosuaadu4@gmail.com', '233 208 333 444', 'student', 'kojo-adu4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000105', 'Female', 'Akua', 'Adwoa', 'Asare', '2014-08-01', '233 548 111 222', 'akuaasare4@gmail.com', 'Basic 3', 'P205', 'Yaw', 'yawasare4@gmail.com', '233 548 333 444', 'student', 'akua-asare4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000106', 'Male', 'Yaw', 'Kofi', 'Annan', '2014-10-15', '233 267 111 222', 'yawannan4@gmail.com', 'Basic 3', 'P206', 'Abena', 'abenaannan4@gmail.com', '233 267 333 444', 'student', 'yaw-annan4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000107', 'Female', 'Adwoa', 'Yaa', 'Boakye', '2013-12-22', '233 576 111 222', 'adwoaboakye4@gmail.com', 'Basic 4', 'P207', 'Kwasi', 'kwasiboakye4@gmail.com', '233 576 333 444', 'student', 'adwoa-boakye4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000108', 'Male', 'Kofi', 'Adjei', 'Gyasi', '2013-02-05', '233 245 111 222', 'kofigyasi4@gmail.com', 'Basic 4', 'P208', 'Akosua', 'akosuaagyasi4@gmail.com', '233 245 333 444', 'student', 'kofi-gyasi4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000109', 'Female', 'Akua', 'Yaa', 'Mensah', '2013-04-14', '233 554 111 222', 'akuamensah4@gmail.com', 'Basic 4', 'P209', 'Yaw', 'yawmensah4@gmail.com', '233 554 333 444', 'student', 'akua-mensah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000110', 'Male', 'Kwame', 'Kofi', 'Sarpong', '2012-06-20', '233 204 111 222', 'kwamesarpong4@gmail.com', 'Basic 5', 'P210', 'Abena', 'abenasarpong4@gmail.com', '233 204 333 444', 'student', 'kwame-sarpong4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000111', 'Female', 'Abena', 'Adwoa', 'Dankwa', '2012-08-01', '233 541 111 222', 'abenadankwa4@gmail.com', 'Basic 5', 'P211', 'Kofi', 'kofidankwa4@gmail.com', '233 541 333 444', 'student', 'abena-dankwa4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000112', 'Male', 'Yaw', 'Kojo', 'Appiah', '2012-10-15', '233 261 111 222', 'yawappiah4@gmail.com', 'Basic 5', 'P212', 'Ama', 'amaappiah4@gmail.com', '233 261 333 444', 'student', 'yaw-appiah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000113', 'Female', 'Akua', 'Yaa', 'Owusu', '2011-12-22', '233 570 111 222', 'akuaowusu4@gmail.com', 'Basic 6', 'P213', 'Kwame', 'kwameowusu4@gmail.com', '233 570 333 444', 'student', 'akua-owusu4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000114', 'Male', 'Kofi', 'Kwame', 'Boahen', '2011-02-05', '233 241 111 222', 'kofiboahen4@gmail.com', 'Basic 6', 'P214', 'Akosua', 'akosuaboahen4@gmail.com', '233 241 333 444', 'student', 'kofi-boahen4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000115', 'Female', 'Adwoa', 'Akosua', 'Addai', '2011-04-14', '233 500 111 222', 'adwoaaddai4@gmail.com', 'Basic 6', 'P215', 'Yaw', 'yawaddai4@gmail.com', '233 500 333 444', 'student', 'adwoa-addai4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000116', 'Male', 'Kwame', 'Kwasi', 'Asante', '2010-06-20', '233 200 111 222', 'kwameasante4@gmail.com', 'Basic 7', 'P216', 'Abena', 'abenaasante4@gmail.com', '233 200 333 444', 'student', 'kwame-asante4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000117', 'Female', 'Akua', 'Adwoa', 'Ampofo', '2010-08-01', '233 555 111 222', 'akuaampofo4@gmail.com', 'Basic 7', 'P217', 'Kofi', 'kofiampofo4@gmail.com', '233 555 333 444', 'student', 'akua-ampofo4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000118', 'Male', 'Yaw', 'Kofi', 'Darko', '2010-10-15', '233 244 111 222', 'yawdarko4@gmail.com', 'Basic 7', 'P218', 'Ama', 'amadarko4@gmail.com', '233 244 333 444', 'student', 'yaw-darko4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000119', 'Female', 'Ama', 'Yaa', 'Agyei', '2009-12-22', '233 500 111 222', 'amaagyei4@gmail.com', 'Basic 8', 'P219', 'Kwame', 'kwameagyei4@gmail.com', '233 500 333 444', 'student', 'ama-agyei4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000120', 'Male', 'Kwame', 'Adjei', 'Mensah', '2009-02-05', '233 201 111 222', 'kwamemensah4@gmail.com', 'Basic 8', 'P220', 'Akosua', 'akosuamensah4@gmail.com', '233 201 333 444', 'student', 'kwame-mensah4', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000121', 'Female', 'Akua', 'Akosua', 'Sarpong', '2009-04-14', '233 544 111 222', 'akuasarpong5@gmail.com', 'Basic 8', 'P221', 'Yaw', 'yawsarpong5@gmail.com', '233 544 333 444', 'student', 'akua-sarpong5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000122', 'Male', 'Kofi', 'Osei', 'Adu', '2008-06-20', '233 266 111 222', 'kofiadu5@gmail.com', 'Basic 9', 'P222', 'Abena', 'abenaadu5@gmail.com', '233 266 333 444', 'student', 'kofi-adu5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000123', 'Female', 'Yaa', 'Adwoa', 'Asare', '2008-08-01', '233 577 111 222', 'yaaasare5@gmail.com', 'Basic 9', 'P223', 'Kofi', 'kofiasare5@gmail.com', '233 577 333 444', 'student', 'yaa-asare5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000124', 'Male', 'Kojo', 'Kwame', 'Annan', '2008-10-15', '233 243 111 222', 'kojoannan5@gmail.com', 'Basic 9', 'P224', 'Adwoa', 'adwoaannan5@gmail.com', '233 243 333 444', 'student', 'kojo-annan5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000125', 'Female', 'Adwoa', 'Akua', 'Boakye', '2008-12-22', '233 502 111 222', 'adwoaboakye5@gmail.com', 'Basic 9', 'P225', 'Kwame', 'kwameboakye5@gmail.com', '233 502 333 444', 'student', 'adwoa-boakye5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000126', 'Male', 'Kwasi', 'Kojo', 'Gyasi', '2019-02-05', '233 241 111 222', 'kwasigyasi5@gmail.com', 'Creche', 'P226', 'Akua', 'akuagyasi5@gmail.com', '233 241 333 444', 'student', 'kwasi-gyasi5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000127', 'Female', 'Akua', 'Adwoa', 'Mensah', '2019-04-14', '233 551 111 222', 'akuamensah5@gmail.com', 'Creche', 'P227', 'Kofi', 'kofimensah5@gmail.com', '233 551 333 444', 'student', 'akua-mensah5', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000128', 'Male', 'Yaw', 'Kofi', 'Sarpong', '2018-06-20', '233 203 111 222', 'yawsarpong6@gmail.com', 'Nursery 1', 'P228', 'Ama', 'amasarpong6@gmail.com', '233 203 333 444', 'student', 'yaw-sarpong6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000129', 'Female', 'Ama', 'Adwoa', 'Dankwa', '2018-08-01', '233 543 111 222', 'amadankwa6@gmail.com', 'Nursery 1', 'P229', 'Kwame', 'kwamedankwa6@gmail.com', '233 543 333 444', 'student', 'ama-dankwa6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000130', 'Male', 'Kwame', 'Kojo', 'Appiah', '2018-10-15', '233 262 111 222', 'kwameappiah6@gmail.com', 'Nursery 1', 'P230', 'Akosua', 'akosuaappiah6@gmail.com', '233 262 333 444', 'student', 'kwame-appiah6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000131', 'Female', 'Adwoa', 'Yaa', 'Owusu', '2017-12-22', '233 571 111 222', 'adwoaowusu6@gmail.com', 'Nursery 2', 'P231', 'Yaw', 'yawowusu6@gmail.com', '233 571 333 444', 'student', 'adwoa-owusu6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000132', 'Male', 'Kofi', 'Adjei', 'Boahen', '2017-02-05', '233 240 111 222', 'kofiboahen6@gmail.com', 'Nursery 2', 'P232', 'Ama', 'amaboahen6@gmail.com', '233 240 333 444', 'student', 'kofi-boahen6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000133', 'Female', 'Akua', 'Adwoa', 'Addai', '2017-04-14', '233 509 111 222', 'akuaaddai6@gmail.com', 'Nursery 2', 'P233', 'Kwame', 'kwameaddai6@gmail.com', '233 509 333 444', 'student', 'akua-addai6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000134', 'Male', 'Yaw', 'Kwame', 'Asante', '2016-06-20', '233 208 111 222', 'yawasante6@gmail.com', 'Basic 1', 'P234', 'Akosua', 'akosuaasante6@gmail.com', '233 208 333 444', 'student', 'yaw-asante6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000135', 'Female', 'Ama', 'Akua', 'Ampofo', '2016-08-01', '233 548 111 222', 'amaampofo6@gmail.com', 'Basic 1', 'P235', 'Yaw', 'yawampofo6@gmail.com', '233 548 333 444', 'student', 'ama-ampofo6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000136', 'Male', 'Kwame', 'Kwasi', 'Darko', '2016-10-15', '233 267 111 222', 'kwamedarko6@gmail.com', 'Basic 1', 'P236', 'Abena', 'abenadarko6@gmail.com', '233 267 333 444', 'student', 'kwame-darko6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000137', 'Female', 'Akua', 'Adwoa', 'Agyei', '2015-12-22', '233 576 111 222', 'akuaagyei6@gmail.com', 'Basic 2', 'P237', 'Kofi', 'kofiagyei6@gmail.com', '233 576 333 444', 'student', 'akua-agyei6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000138', 'Male', 'Kofi', 'Yaw', 'Mensah', '2015-02-05', '233 245 111 222', 'kofimensah6@gmail.com', 'Basic 2', 'P238', 'Adwoa', 'adwoamensah6@gmail.com', '233 245 333 444', 'student', 'kofi-mensah6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000139', 'Female', 'Yaa', 'Akosua', 'Sarpong', '2015-04-14', '233 554 111 222', 'yaasarpong6@gmail.com', 'Basic 2', 'P239', 'Kwame', 'kwamesarpong6@gmail.com', '233 554 333 444', 'student', 'yaa-sarpong6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000140', 'Male', 'Kojo', 'Kwame', 'Adu', '2014-06-20', '233 204 111 222', 'kojoadu6@gmail.com', 'Basic 3', 'P240', 'Akosua', 'akosuaadu6@gmail.com', '233 204 333 444', 'student', 'kojo-adu6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000141', 'Female', 'Akua', 'Adwoa', 'Asare', '2014-08-01', '233 541 111 222', 'akuaasare6@gmail.com', 'Basic 3', 'P241', 'Yaw', 'yawasare6@gmail.com', '233 541 333 444', 'student', 'akua-asare6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL);
INSERT INTO `students` (`student_id`, `gender`, `first_name`, `mid_name`, `last_name`, `dob`, `number`, `email`, `class`, `curaddress`, `parent_name`, `parent_email`, `parent_number`, `role`, `username`, `password`, `conpassword`, `alumni_year`, `promotion_status`, `promotion_target`) VALUES
('STD000142', 'Male', 'Yaw', 'Kofi', 'Annan', '2014-10-15', '233 261 111 222', 'yawannan6@gmail.com', 'Basic 3', 'P242', 'Abena', 'abenaannan6@gmail.com', '233 261 333 444', 'student', 'yaw-annan6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000143', 'Female', 'Adwoa', 'Yaa', 'Boakye', '2013-12-22', '233 570 111 222', 'adwoaboakye6@gmail.com', 'Basic 4', 'P243', 'Kwasi', 'kwasiboakye6@gmail.com', '233 570 333 444', 'student', 'adwoa-boakye6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000144', 'Male', 'Kofi', 'Adjei', 'Gyasi', '2013-02-05', '233 241 111 222', 'kofigyasi6@gmail.com', 'Basic 4', 'P244', 'Akosua', 'akosuaagyasi6@gmail.com', '233 241 333 444', 'student', 'kofi-gyasi6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL),
('STD000145', 'Female', 'Akua', 'Yaa', 'Mensah', '2013-04-14', '233 500 111 222', 'akuamensah6@gmail.com', 'Basic 4', 'P245', 'Yaw', 'yawmensah6@gmail.com', '233 500 333 444', 'student', 'akua-mensah6', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', '$2y$10$MqaBrd3lVsbP3l3BJWTqKeMoxIN3AgOfvFlSI726piDM/b.j/mSLy', NULL, NULL, NULL);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_code`, `school_status`, `first_name`, `surname`, `other_names`, `date_of_birth`, `sex`, `marital_status`, `phone_number`, `email`, `gh_card_number`, `ssnit_number`, `staff_number`, `license_number`, `created_at`, `updated_at`) VALUES
(1, 'RW0000000001', 'Private', 'Oscar', 'Vivor', 'Makafui', '2004-06-03', 'Male', 'Single', '0533519466', 'oscarvivor@gmail.com', 'GHA-722896979-1', 'E035000058489', NULL, NULL, '2025-10-23 21:11:12', '2025-10-23 21:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classes`
--

CREATE TABLE `teacher_classes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_professional_info`
--

INSERT INTO `teacher_professional_info` (`id`, `teacher_id`, `professional_status`, `teacher_type`, `basic_level`, `basic_subject`, `mode_of_qualification`, `academic_qualification`, `professional_certificate`, `created_at`) VALUES
(1, 1, 'Untrained', 'Subject', 'JHS', 'Computing', NULL, NULL, NULL, '2025-10-23 21:11:12');

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
-- Table structure for table `term_plans`
--

CREATE TABLE `term_plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `plan_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `event_type` varchar(50) DEFAULT 'general',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `term_plans`
--

INSERT INTO `term_plans` (`id`, `title`, `description`, `plan_date`, `end_date`, `event_type`, `created_at`) VALUES
(1, 'Term Examination', 'All classes will start termly examination', '2025-12-09', '2025-12-12', 'exam', '2025-10-12 17:28:48');

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
('', '', '', '', '0000-00-00', '0000-00-00'),
('TS00001', 'First Term', 'Class Test', 'Class 2', '2025-01-10', '2025-01-17'),
('TS00002', 'Second Term', 'Examination', 'Class 5', '2025-01-10', '2025-01-17'),
('TS00003', 'Second Term', 'Class Test', 'Class 7', '2025-01-10', '2025-01-17');

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
(1, 'Basic 4', '2025-10-13', 135.00, 135.00, '2025-10-13 05:20:59');

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
(7, 'STD000024', '2025-10-06', '', 3, '2025-10-12 11:30:40'),
(8, 'STD000024', '2025-10-13', 'service', 5, '2025-10-13 05:20:59'),
(9, 'STD000026', '2025-10-13', 'service', 5, '2025-10-13 05:20:59'),
(10, 'STD000071', '2025-10-13', 'service', 5, '2025-10-13 05:20:59'),
(11, 'STD000072', '2025-10-13', 'service', 5, '2025-10-13 05:22:47');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checkin_code`
--
ALTER TABLE `checkin_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=552;

--
-- AUTO_INCREMENT for table `daily_class_summaries`
--
ALTER TABLE `daily_class_summaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT for table `service_fees`
--
ALTER TABLE `service_fees`
  MODIFY `service_fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service_payments`
--
ALTER TABLE `service_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_classes`
--
ALTER TABLE `staff_classes`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `subject_objectives`
--
ALTER TABLE `subject_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_professional_info`
--
ALTER TABLE `teacher_professional_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `weekly_service_scores`
--
ALTER TABLE `weekly_service_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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

--
-- Constraints for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD CONSTRAINT `teacher_classes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_professional_info`
--
ALTER TABLE `teacher_professional_info`
  ADD CONSTRAINT `teacher_professional_info_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
