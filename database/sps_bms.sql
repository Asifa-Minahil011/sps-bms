-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2026 at 03:33 PM
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
-- Database: `sps_bms`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `employee_type` varchar(50) DEFAULT 'Employee',
  `work_status` varchar(50) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `personal_email` varchar(150) DEFAULT NULL,
  `cnic` varchar(30) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `residential_address` text DEFAULT NULL,
  `job_title` varchar(150) DEFAULT NULL,
  `business_area` varchar(150) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `office_no` varchar(50) DEFAULT NULL,
  `mobile_no` varchar(50) DEFAULT NULL,
  `emergency_no` varchar(50) DEFAULT NULL,
  `home_no` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `office_location` varchar(150) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `employee_group` varchar(100) DEFAULT NULL,
  `practice` varchar(100) DEFAULT NULL,
  `hire_source` varchar(100) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `educational_level` varchar(100) DEFAULT NULL,
  `guardian_name` varchar(150) DEFAULT NULL,
  `guardian_contact` varchar(50) DEFAULT NULL,
  `guardian_address` text DEFAULT NULL,
  `sps_corporate` tinyint(1) NOT NULL DEFAULT 0,
  `supervisor_name` varchar(150) DEFAULT NULL,
  `supervisor_email` varchar(150) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `employee_type`, `work_status`, `gender`, `email`, `personal_email`, `cnic`, `date_of_birth`, `residential_address`, `job_title`, `business_area`, `linkedin_url`, `office_no`, `mobile_no`, `emergency_no`, `home_no`, `location`, `office_location`, `department`, `employee_group`, `practice`, `hire_source`, `company`, `educational_level`, `guardian_name`, `guardian_contact`, `guardian_address`, `sps_corporate`, `supervisor_name`, `supervisor_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Abdul Hameed', 'Employee', 'Full Time', '', 'abdul.hameed@spsnet.com', '', '', NULL, '', '', '', '', '', '+92 311 8811906', '', '', 'PK', '', 'Operations', 'Administrative', 'Corporate', '', '', '', NULL, NULL, NULL, 0, 'Hash Malik', 'hash.malik@spsnet.com', 'Active', '2026-09-25 07:59:58', '2026-09-25 09:39:58'),
(2, 'Asifa', 'Employee', 'Full time', NULL, 'asifa@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 'PK', NULL, 'Technical', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, 'Active', '2026-09-25 08:48:24', '2026-09-25 08:48:24'),
(3, 'Abdul Malik', 'Employee', 'Full time', '', 'abdul.malik@spsnet.com', '', '', NULL, '', '', '', '', '', '03041160017', '', '', 'US', '', 'Technical', 'Spinnlabs', 'AppDev', '', '', '', NULL, NULL, NULL, 0, 'Maryam Toor', 'maryam.toor@spsnet.com', 'Active', '2026-09-25 08:53:43', '2026-09-25 09:32:08'),
(4, 'Abdul Raheem', 'Employee', 'Full time', NULL, 'abdul.raheem1@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 347-9061725', NULL, NULL, 'PK', NULL, 'Technical', 'Cloud', 'DevOps', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Usama Khalid', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(5, 'Abdullah Qureshi', 'Employee', 'Full time', '', 'abdullah.qureshi@spsnet.com', '', '', NULL, '', '', 'Software engineering', '', '', '+92 321-7572292', '', '', 'PK', '', 'Technical', 'Spinnlabs', 'AppDev', '', '', '', '', '', '', 0, 'Maryam Toor', 'maryam.toor@spsnet.com', 'Active', '2026-09-25 08:53:43', '2026-09-25 13:27:14'),
(6, 'Abid Nazir', 'Employee', 'Full time', NULL, 'abid.nazir@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 300-8688999', NULL, NULL, 'PK', NULL, 'Operations', 'Administrative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Adnan Rasheed', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(7, 'Ahmad Khan', 'Service Provider', 'On Hold', NULL, 'ahmad.khan@evosions.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 300-4803156', NULL, NULL, NULL, NULL, 'Technical', 'Security', 'Threat Management', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Farrukh Shahzad', NULL, 'Inactive', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(8, 'Ahmed Asad', 'Employee', 'Full time', NULL, 'ahmed.asad@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '03105876464', NULL, NULL, NULL, NULL, 'Technical', 'Cloud', 'DevOps', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Zeeshan Zulfiqar', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(9, 'Albana Grumira', 'Contractor', 'No Record', NULL, 'albana.grumira@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Operations', 'Accounting', 'Corporate', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Neelofar Malik', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(10, 'Ammar Zaib', 'Employee', 'Full time', NULL, 'ammar.zaib@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 312-5492713', NULL, NULL, 'PK', NULL, 'Technical', 'Cloud', 'DevOps', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Adnan Rasheed', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(11, 'Anna Ejaz', 'Employee', 'Admin probe', '', 'anna.ejaz@spsnet.com', '', '', NULL, '', '', 'Software Development', '', '', '03101511398', '', '', '', '', 'Technical', 'Cloud', 'DevOps', '', '', '', NULL, NULL, NULL, 0, 'Zeeshan Zulfiqar', 'zeeshan.zulfiqar@spsnet.com', 'Active', '2026-09-25 08:53:43', '2026-09-25 09:09:23'),
(12, 'Amy Taylor', 'Contractor', 'Full time', NULL, 'amy.taylor@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Operations', 'HR', 'Recruitment', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Debbie Cacchione', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(13, 'Arshad Ali', 'Employee', 'Full time', NULL, 'arshad.ali@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 307-5568721', NULL, NULL, 'US', NULL, 'Operations', 'Spinnlabs', 'Academia', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Hash Malik', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(14, 'Bilal Manzoor', 'Employee', 'On Hold', NULL, 'bilal.manzoor@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92', NULL, NULL, 'PK', NULL, 'Technical', 'Security', 'HigherEd', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Rizwan Ali', NULL, 'Inactive', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(15, 'Hasan Saleem', 'Employee', 'Full time', NULL, 'hasan.saleem@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 307-0117297', NULL, NULL, 'PK', NULL, 'Technical', 'Spinnlabs', 'AppDev', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(16, 'Imran Mufti', 'Employee', 'Full time', NULL, 'imran.mufti@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 703-3718941', NULL, NULL, 'PK', NULL, 'Technical', 'Cloud', 'IAM', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Shahab Akbar', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(17, 'Katie Nucci', 'Employee', 'Full time', NULL, 'katie.nucci@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 301-9432435', NULL, NULL, NULL, NULL, 'Technical', 'Events', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Debbie Cacchione', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(18, 'Maryam Toor', 'Employee', 'Full time', NULL, 'maryam.toor@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 321-5334122', NULL, NULL, 'PK', NULL, 'Technical', 'Spinnlabs', 'AppDev', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Rainer Barthel', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(19, 'Muhammad Anas', 'Employee', 'Full time', NULL, 'muhammad.ahsan@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 332-1386388', NULL, NULL, 'PK', NULL, 'Technical', 'Spinnlabs', 'AppDev', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Maryam Toor', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(20, 'Sadia Ashraf', 'Employee', 'Full time', NULL, 'sadia.ashraf@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 333-5272081', NULL, NULL, 'PK', NULL, 'Operations', 'Spinnlabs', 'AppDev', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Hash Malik', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43'),
(21, 'Zainab Khan', 'Employee', 'Full time', NULL, 'zainab.khan2@spsnet.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '+92 331-5605512', NULL, NULL, 'PK', NULL, 'Technical', 'Spinnlabs', 'IAM', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Nayab Akbar', NULL, 'Active', '2026-09-25 08:53:43', '2026-09-25 08:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `employee_attachments`
--

CREATE TABLE `employee_attachments` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `original_file_name` varchar(255) NOT NULL,
  `stored_file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_badges`
--

CREATE TABLE `employee_badges` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `vendor` varchar(150) DEFAULT NULL,
  `badge_group` varchar(150) DEFAULT NULL,
  `practice` varchar(150) DEFAULT NULL,
  `product` varchar(150) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `badge_url` varchar(500) DEFAULT NULL,
  `completed_on` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_blog_entries`
--

CREATE TABLE `employee_blog_entries` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_certifications`
--

CREATE TABLE `employee_certifications` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `vendor` varchar(150) DEFAULT NULL,
  `certification_group` varchar(150) DEFAULT NULL,
  `practice` varchar(150) DEFAULT NULL,
  `product` varchar(150) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `certification_code` varchar(100) DEFAULT NULL,
  `certification_url` varchar(500) DEFAULT NULL,
  `certification_type` varchar(100) DEFAULT NULL,
  `completed_on` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_checklists`
--

CREATE TABLE `employee_checklists` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `checklist_type` enum('onboarding_checklist','onboarding_steps','offboarding_checklist') NOT NULL,
  `item_key` varchar(100) NOT NULL,
  `item_label` varchar(255) DEFAULT NULL,
  `choice_value` varchar(20) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_communication_skills`
--

CREATE TABLE `employee_communication_skills` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `added_by` varchar(150) DEFAULT NULL,
  `speaking` varchar(50) DEFAULT NULL,
  `writing` varchar(50) DEFAULT NULL,
  `listening` varchar(50) DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_corporate_roles`
--

CREATE TABLE `employee_corporate_roles` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `role` varchar(150) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `level_title` varchar(100) DEFAULT NULL,
  `rank_value` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_departmental_roles`
--

CREATE TABLE `employee_departmental_roles` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `role` varchar(150) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `level_title` varchar(100) DEFAULT NULL,
  `rank_value` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_department_customers`
--

CREATE TABLE `employee_department_customers` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `customer_code` varchar(50) DEFAULT NULL,
  `customer_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_development_plans`
--

CREATE TABLE `employee_development_plans` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `goal` text DEFAULT NULL,
  `target_date` date DEFAULT NULL,
  `progress` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_education`
--

CREATE TABLE `employee_education` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `university` varchar(200) DEFAULT NULL,
  `field_of_study` varchar(150) DEFAULT NULL,
  `passing_year` varchar(20) DEFAULT NULL,
  `course` varchar(150) DEFAULT NULL,
  `grade_gpa` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_education`
--

INSERT INTO `employee_education` (`id`, `employee_id`, `university`, `field_of_study`, `passing_year`, `course`, `grade_gpa`, `created_at`, `updated_at`) VALUES
(1, 1, 'FAST', 'SE', '2028', 'BS SE', '3.50', '2026-09-25 09:39:58', '2026-09-25 09:39:58'),
(2, 5, '', '', '', '', '', '2026-09-25 13:27:14', '2026-09-25 13:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `employee_employment_history`
--

CREATE TABLE `employee_employment_history` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `job_title` varchar(150) DEFAULT NULL,
  `corporate_role` varchar(150) DEFAULT NULL,
  `department_role` varchar(150) DEFAULT NULL,
  `functional_role` varchar(150) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_forms`
--

CREATE TABLE `employee_forms` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `form_type` enum('A','B') NOT NULL,
  `responsibilities` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `review_year` varchar(20) DEFAULT NULL,
  `review_quarter` varchar(50) DEFAULT NULL,
  `rating` varchar(50) DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `development` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_hours_distribution`
--

CREATE TABLE `employee_hours_distribution` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `department` varchar(150) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `practice` varchar(200) NOT NULL,
  `hours` decimal(8,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_hr_talk`
--

CREATE TABLE `employee_hr_talk` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `answer` text DEFAULT NULL,
  `send_email` tinyint(1) DEFAULT 0,
  `saved_at` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_kpi_records`
--

CREATE TABLE `employee_kpi_records` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `kpi_period` varchar(50) DEFAULT '2026 · Q1',
  `section_type` varchar(50) NOT NULL,
  `department` varchar(150) DEFAULT NULL,
  `group_name` varchar(150) DEFAULT NULL,
  `practice` varchar(150) DEFAULT NULL,
  `vendor` varchar(150) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `practice_multiplier` varchar(50) DEFAULT NULL,
  `percent_multiplier` varchar(50) DEFAULT NULL,
  `kpi_target` varchar(50) DEFAULT NULL,
  `kpi_actual` varchar(50) DEFAULT NULL,
  `bonus_target` varchar(50) DEFAULT NULL,
  `bonus_actual` varchar(50) DEFAULT NULL,
  `plan` varchar(200) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_learning_development`
--

CREATE TABLE `employee_learning_development` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `course_name` varchar(200) NOT NULL,
  `training_taken` varchar(150) DEFAULT NULL,
  `test_taken` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_loaded_cost`
--

CREATE TABLE `employee_loaded_cost` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `base_cost` decimal(12,2) DEFAULT 0.00,
  `individual_cost` decimal(12,2) DEFAULT 0.00,
  `practice_cost` decimal(12,2) DEFAULT 0.00,
  `last_year_cost` decimal(12,2) DEFAULT 0.00,
  `loaded_rate` decimal(12,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_offboarding_reasons`
--

CREATE TABLE `employee_offboarding_reasons` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_orientation_plan`
--

CREATE TABLE `employee_orientation_plan` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `module_key` varchar(50) NOT NULL,
  `module_name` varchar(150) NOT NULL,
  `orientation_day` varchar(100) DEFAULT NULL,
  `orientation_date` date DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_performance`
--

CREATE TABLE `employee_performance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `performance_year` smallint(6) NOT NULL,
  `revenue_margin` longtext DEFAULT NULL,
  `utilization` longtext DEFAULT NULL,
  `certifications` longtext DEFAULT NULL,
  `communication_score` longtext DEFAULT NULL,
  `performance_choice` varchar(150) DEFAULT NULL,
  `performance_dimension` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_plan_assignments`
--

CREATE TABLE `employee_plan_assignments` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `plan_type` enum('onboarding','offboarding') NOT NULL,
  `item_key` varchar(100) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `assignee` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_products`
--

CREATE TABLE `employee_products` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `product_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_projects`
--

CREATE TABLE `employee_projects` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `project_code` varchar(50) DEFAULT NULL,
  `project_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_timelive`
--

CREATE TABLE `employee_timelive` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `work_date` date NOT NULL,
  `client` varchar(150) DEFAULT NULL,
  `project` varchar(200) DEFAULT NULL,
  `task` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `hours` decimal(6,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_weekly_performance`
--

CREATE TABLE `employee_weekly_performance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `performance_year` smallint(6) NOT NULL DEFAULT 2026,
  `week_number` tinyint(4) NOT NULL,
  `score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employee_attachments`
--
ALTER TABLE `employee_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_attachment` (`employee_id`);

--
-- Indexes for table `employee_badges`
--
ALTER TABLE `employee_badges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_badge` (`employee_id`);

--
-- Indexes for table `employee_blog_entries`
--
ALTER TABLE `employee_blog_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_blog_employee` (`employee_id`);

--
-- Indexes for table `employee_certifications`
--
ALTER TABLE `employee_certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_certification` (`employee_id`);

--
-- Indexes for table `employee_checklists`
--
ALTER TABLE `employee_checklists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_checklist_item` (`employee_id`,`checklist_type`,`item_key`);

--
-- Indexes for table `employee_communication_skills`
--
ALTER TABLE `employee_communication_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_communication_skill` (`employee_id`);

--
-- Indexes for table `employee_corporate_roles`
--
ALTER TABLE `employee_corporate_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_corporate_role_employee` (`employee_id`);

--
-- Indexes for table `employee_departmental_roles`
--
ALTER TABLE `employee_departmental_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_departmental_role_employee` (`employee_id`);

--
-- Indexes for table `employee_department_customers`
--
ALTER TABLE `employee_department_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_department_customer_employee` (`employee_id`);

--
-- Indexes for table `employee_development_plans`
--
ALTER TABLE `employee_development_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_development_plan` (`employee_id`);

--
-- Indexes for table `employee_education`
--
ALTER TABLE `employee_education`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_education` (`employee_id`);

--
-- Indexes for table `employee_employment_history`
--
ALTER TABLE `employee_employment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employment_history_employee` (`employee_id`);

--
-- Indexes for table `employee_forms`
--
ALTER TABLE `employee_forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_form` (`employee_id`,`form_type`);

--
-- Indexes for table `employee_hours_distribution`
--
ALTER TABLE `employee_hours_distribution`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_hours` (`employee_id`,`department`,`group_name`,`practice`);

--
-- Indexes for table `employee_hr_talk`
--
ALTER TABLE `employee_hr_talk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_hr_talk` (`employee_id`);

--
-- Indexes for table `employee_kpi_records`
--
ALTER TABLE `employee_kpi_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_kpi` (`employee_id`);

--
-- Indexes for table `employee_learning_development`
--
ALTER TABLE `employee_learning_development`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_learning_development` (`employee_id`);

--
-- Indexes for table `employee_loaded_cost`
--
ALTER TABLE `employee_loaded_cost`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_loaded_cost` (`employee_id`);

--
-- Indexes for table `employee_offboarding_reasons`
--
ALTER TABLE `employee_offboarding_reasons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_reason` (`employee_id`,`reason`);

--
-- Indexes for table `employee_orientation_plan`
--
ALTER TABLE `employee_orientation_plan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_orientation_module` (`employee_id`,`module_key`);

--
-- Indexes for table `employee_performance`
--
ALTER TABLE `employee_performance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_performance_year` (`employee_id`,`performance_year`);

--
-- Indexes for table `employee_plan_assignments`
--
ALTER TABLE `employee_plan_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_plan_assignment` (`employee_id`,`plan_type`,`item_key`);

--
-- Indexes for table `employee_products`
--
ALTER TABLE `employee_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_product` (`employee_id`);

--
-- Indexes for table `employee_projects`
--
ALTER TABLE `employee_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_project` (`employee_id`);

--
-- Indexes for table `employee_timelive`
--
ALTER TABLE `employee_timelive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_timelive_employee` (`employee_id`);

--
-- Indexes for table `employee_weekly_performance`
--
ALTER TABLE `employee_weekly_performance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_employee_week` (`employee_id`,`performance_year`,`week_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `employee_attachments`
--
ALTER TABLE `employee_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_badges`
--
ALTER TABLE `employee_badges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_blog_entries`
--
ALTER TABLE `employee_blog_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_certifications`
--
ALTER TABLE `employee_certifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_checklists`
--
ALTER TABLE `employee_checklists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_communication_skills`
--
ALTER TABLE `employee_communication_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_corporate_roles`
--
ALTER TABLE `employee_corporate_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_departmental_roles`
--
ALTER TABLE `employee_departmental_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_department_customers`
--
ALTER TABLE `employee_department_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_development_plans`
--
ALTER TABLE `employee_development_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_education`
--
ALTER TABLE `employee_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_employment_history`
--
ALTER TABLE `employee_employment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_forms`
--
ALTER TABLE `employee_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_hours_distribution`
--
ALTER TABLE `employee_hours_distribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_hr_talk`
--
ALTER TABLE `employee_hr_talk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_kpi_records`
--
ALTER TABLE `employee_kpi_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_learning_development`
--
ALTER TABLE `employee_learning_development`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_loaded_cost`
--
ALTER TABLE `employee_loaded_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_offboarding_reasons`
--
ALTER TABLE `employee_offboarding_reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_orientation_plan`
--
ALTER TABLE `employee_orientation_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_performance`
--
ALTER TABLE `employee_performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_plan_assignments`
--
ALTER TABLE `employee_plan_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_products`
--
ALTER TABLE `employee_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_projects`
--
ALTER TABLE `employee_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_timelive`
--
ALTER TABLE `employee_timelive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_weekly_performance`
--
ALTER TABLE `employee_weekly_performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_attachments`
--
ALTER TABLE `employee_attachments`
  ADD CONSTRAINT `fk_employee_attachment` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_badges`
--
ALTER TABLE `employee_badges`
  ADD CONSTRAINT `fk_employee_badge` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_blog_entries`
--
ALTER TABLE `employee_blog_entries`
  ADD CONSTRAINT `fk_blog_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_certifications`
--
ALTER TABLE `employee_certifications`
  ADD CONSTRAINT `fk_employee_certification` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_checklists`
--
ALTER TABLE `employee_checklists`
  ADD CONSTRAINT `fk_employee_checklist_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_communication_skills`
--
ALTER TABLE `employee_communication_skills`
  ADD CONSTRAINT `fk_employee_communication_skill` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_corporate_roles`
--
ALTER TABLE `employee_corporate_roles`
  ADD CONSTRAINT `fk_corporate_role_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_departmental_roles`
--
ALTER TABLE `employee_departmental_roles`
  ADD CONSTRAINT `fk_departmental_role_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_department_customers`
--
ALTER TABLE `employee_department_customers`
  ADD CONSTRAINT `fk_department_customer_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_development_plans`
--
ALTER TABLE `employee_development_plans`
  ADD CONSTRAINT `fk_development_plan_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_education`
--
ALTER TABLE `employee_education`
  ADD CONSTRAINT `fk_employee_education` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_employment_history`
--
ALTER TABLE `employee_employment_history`
  ADD CONSTRAINT `fk_employment_history_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_forms`
--
ALTER TABLE `employee_forms`
  ADD CONSTRAINT `fk_employee_forms_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_hours_distribution`
--
ALTER TABLE `employee_hours_distribution`
  ADD CONSTRAINT `fk_hours_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_hr_talk`
--
ALTER TABLE `employee_hr_talk`
  ADD CONSTRAINT `fk_hr_talk_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_kpi_records`
--
ALTER TABLE `employee_kpi_records`
  ADD CONSTRAINT `fk_employee_kpi` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_learning_development`
--
ALTER TABLE `employee_learning_development`
  ADD CONSTRAINT `fk_employee_learning_development` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_loaded_cost`
--
ALTER TABLE `employee_loaded_cost`
  ADD CONSTRAINT `fk_employee_loaded_cost` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_offboarding_reasons`
--
ALTER TABLE `employee_offboarding_reasons`
  ADD CONSTRAINT `fk_offboarding_reason_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_orientation_plan`
--
ALTER TABLE `employee_orientation_plan`
  ADD CONSTRAINT `fk_orientation_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_performance`
--
ALTER TABLE `employee_performance`
  ADD CONSTRAINT `fk_performance_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_plan_assignments`
--
ALTER TABLE `employee_plan_assignments`
  ADD CONSTRAINT `fk_plan_assignment_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_products`
--
ALTER TABLE `employee_products`
  ADD CONSTRAINT `fk_employee_product` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_projects`
--
ALTER TABLE `employee_projects`
  ADD CONSTRAINT `fk_employee_project` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_timelive`
--
ALTER TABLE `employee_timelive`
  ADD CONSTRAINT `fk_timelive_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_weekly_performance`
--
ALTER TABLE `employee_weekly_performance`
  ADD CONSTRAINT `fk_weekly_performance_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
