-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2024 at 04:17 PM
-- Server version: 11.7.1-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `artifitech`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `admin_id`, `customer_id`, `user_id`, `user_email`, `action`, `details`, `ip_address`, `created_at`) VALUES
(1, NULL, 1, NULL, 'user1@gmail.com', 'login', 'Customer login successful', '::1', '2024-12-21 12:27:49'),
(2, NULL, 1, NULL, 'user1@gmail.com', 'login', 'Customer login successful', '::1', '2024-12-21 12:37:10'),
(3, NULL, 1, NULL, 'user1@gmail.com', 'login', 'Customer login successful', '::1', '2024-12-21 12:41:57'),
(4, NULL, 1, NULL, 'user1@gmail.com', 'login', 'Customer login successful', '::1', '2024-12-21 12:44:20'),
(5, NULL, 1, NULL, 'user1@gmail.com', 'login', 'Customer login successful', '::1', '2024-12-21 13:58:56'),
(6, NULL, 1, NULL, 'user1@gmail.com', 'login', 'Customer login successful', '::1', '2024-12-21 14:01:53'),
(7, NULL, 1, NULL, 'user1@gmail.com', 'login', 'Customer login successful', '::1', '2024-12-21 14:10:42');

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `role` enum('super_admin','admin') NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `username`, `email`, `password_hash`, `first_name`, `last_name`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'vgkhoza@ehlanzenicollege.co.za', 'vgkhoza@ehlanzenicollege.co.za', '$2y$10$Tuc6qtr.e2cbdSTGBJSfe.mjFf1zCq/D5oSS4RNQIOT.a2HikCvIu', 'Vuyani', 'Khoza', 'super_admin', 1, '2024-12-13 03:21:16', '2024-12-12 20:20:27', '2024-12-13 01:21:16');

-- --------------------------------------------------------

--
-- Table structure for table `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `permission_name`, `description`, `created_at`) VALUES
(1, 'manage_users', 'Can create, edit, and delete users', '2024-12-08 15:01:40'),
(2, 'view_users', 'Can view user list and details', '2024-12-08 15:01:40'),
(3, 'manage_content', 'Can create, edit, and delete content', '2024-12-08 15:01:40'),
(4, 'view_content', 'Can view content', '2024-12-08 15:01:40'),
(5, 'manage_settings', 'Can modify system settings', '2024-12-08 15:01:40'),
(6, 'view_reports', 'Can view system reports', '2024-12-08 15:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `role_name`, `description`, `created_at`) VALUES
(1, 'Super Admin', 'Full system access', '2024-12-08 15:01:40'),
(2, 'Manager', 'Can manage content and users', '2024-12-08 15:01:40'),
(3, 'Editor', 'Can edit content', '2024-12-08 15:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_description` text DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `setting_key`, `setting_value`, `setting_description`, `updated_by`, `updated_at`) VALUES
(1, 'site_name', 'Artifitech Admin', 'Site name displayed in admin panel', NULL, '2024-12-08 15:01:40'),
(2, 'items_per_page', '10', 'Number of items to display per page', NULL, '2024-12-08 15:01:40'),
(3, 'maintenance_mode', '0', 'Site maintenance mode (0=off, 1=on)', NULL, '2024-12-08 15:01:40'),
(4, 'allowed_file_types', 'jpg,jpeg,png,pdf', 'Allowed file upload types', NULL, '2024-12-08 15:01:40'),
(5, 'max_file_size', '5242880', 'Maximum file upload size in bytes', NULL, '2024-12-08 15:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `auth_logs`
--

CREATE TABLE `auth_logs` (
  `id` int(11) NOT NULL,
  `user_type` enum('customer','admin','unknown') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_logs`
--

INSERT INTO `auth_logs` (`id`, `user_type`, `user_id`, `action`, `details`, `ip_address`, `created_at`) VALUES
(1, 'unknown', NULL, 'failed_login', '{\"email\":\"user1@gmail.com\"}', '::1', '2024-12-22 13:51:00'),
(2, 'unknown', NULL, 'failed_login', '{\"email\":\"test@example.com\"}', '::1', '2024-12-22 13:52:51'),
(3, 'unknown', NULL, 'failed_login', '{\"email\":\"test@example.com\"}', '::1', '2024-12-22 13:53:04'),
(4, 'customer', 2, 'login', NULL, '::1', '2024-12-22 13:56:13'),
(5, 'customer', 2, 'login', NULL, '::1', '2024-12-22 14:29:29'),
(6, 'customer', 2, 'login', NULL, '::1', '2024-12-22 14:37:52'),
(7, 'customer', 2, 'login', NULL, '::1', '2024-12-22 14:55:30'),
(8, 'customer', 2, 'login', NULL, '::1', '2024-12-22 14:58:02'),
(9, 'customer', 2, 'login', NULL, '::1', '2024-12-22 15:00:37'),
(10, 'customer', 2, 'login', NULL, '::1', '2024-12-22 15:05:27'),
(11, 'customer', 2, 'login', NULL, '::1', '2024-12-22 15:12:26');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_categories`
--

CREATE TABLE `blog_post_categories` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `certificate_number` varchar(50) NOT NULL,
  `issue_date` timestamp NULL DEFAULT current_timestamp(),
  `expiry_date` timestamp NULL DEFAULT NULL,
  `status` enum('active','expired','revoked') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `students_count` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `duration`, `status`, `students_count`, `created_at`, `updated_at`) VALUES
(1, 'Introduction to Educational Technology', 'Learn the basics of EdTech', '6 weeks', 'active', 150, '2024-12-22 13:49:11', '2024-12-22 13:49:11'),
(2, 'Advanced Learning Management', 'Master LMS administration', '8 weeks', 'active', 75, '2024-12-22 13:49:11', '2024-12-22 13:49:11'),
(3, 'Digital Classroom Strategies', 'Modern teaching techniques', '4 weeks', 'active', 200, '2024-12-22 13:49:11', '2024-12-22 13:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `course_content`
--

CREATE TABLE `course_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content_type` enum('video','document','quiz','assignment') NOT NULL,
  `content` text DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'Duration in minutes',
  `is_required` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `course_content_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_content`
--

INSERT INTO `course_content` (course_id, title, content_type, content, sequence, duration, is_required) VALUES
-- Content for "Introduction to Educational Technology"
(1, 'Welcome to EdTech', 'video', 'Introduction to the course and overview of educational technology', 1, 15, 1),
(1, 'Understanding LMS Basics', 'document', 'Comprehensive guide to Learning Management Systems', 2, 30, 1),
(1, 'Basic Features Quiz', 'quiz', 'Test your knowledge of basic LMS features', 3, 20, 1),
(1, 'Your First EdTech Project', 'assignment', 'Create a simple online lesson using basic tools', 4, 60, 1),

-- Content for "Advanced Learning Management"
(2, 'Advanced LMS Features', 'video', 'Deep dive into advanced LMS functionality', 1, 25, 1),
(2, 'Integration Techniques', 'document', 'Guide to integrating third-party tools', 2, 45, 1),
(2, 'Advanced Features Assessment', 'quiz', 'Test your knowledge of advanced features', 3, 30, 1),
(2, 'Custom LMS Setup', 'assignment', 'Set up a customized LMS environment', 4, 90, 1),

-- Content for "Digital Classroom Strategies"
(3, 'Modern Teaching Methods', 'video', 'Overview of contemporary teaching strategies', 1, 20, 1),
(3, 'Engagement Techniques', 'document', 'Guide to increasing student engagement', 2, 40, 1),
(3, 'Teaching Methods Quiz', 'quiz', 'Assessment of teaching strategies', 3, 25, 1),
(3, 'Create Engaging Lesson', 'assignment', 'Design an engaging digital lesson', 4, 75, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `password_hash`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'User', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '2024-12-22 13:49:11', '2024-12-22 13:49:11'),
(2, 'user1', 'Khoza', 'user1@gmail.com', '$2y$10$52SzJlMKefFUz2up6rTK9ODgRHtsqoJLVYKGL6fjKYnk69OQm/Xg6', 1, '2024-12-22 13:53:56', '2024-12-22 13:53:56');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` enum('active','completed','cancelled','suspended') DEFAULT 'active',
  `progress` int(11) DEFAULT 0 COMMENT 'Progress percentage',
  `start_date` timestamp NULL DEFAULT current_timestamp(),
  `completion_date` timestamp NULL DEFAULT NULL,
  `last_accessed` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed','cancelled') DEFAULT 'pending',
  `payment_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `user_type` enum('admin','customer') NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `monthly_price` decimal(10,2) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `monthly_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'EduManager LMS - Starter', 'For Small Institutions', 2499.00, 'active', '2024-12-22 13:49:11', '2024-12-22 13:49:11'),
(2, 'EduManager LMS - Professional', 'For Medium Institutions', 4999.00, 'active', '2024-12-22 13:49:11', '2024-12-22 13:49:11'),
(3, 'EduManager LMS - Enterprise', 'For Large Institutions', 9999.00, 'active', '2024-12-22 13:49:11', '2024-12-22 13:49:11'),
(4, 'HR System - Basic', 'Essential HR management for small teams - Up to 50 employees, Employee management, Leave management, Basic reporting', 1999.00, 'active', '2024-12-22 15:11:25', '2024-12-22 15:11:25'),
(5, 'HR System - Professional', 'Advanced HR solutions for growing organizations - Up to 200 employees, Full HR management, Payroll processing, Performance management', 3999.00, 'active', '2024-12-22 15:11:25', '2024-12-22 15:11:25'),
(6, 'HR System - Enterprise', 'Complete HR suite for large organizations - Unlimited employees, Advanced HR analytics, Custom workflows, API access', 7999.00, 'active', '2024-12-22 15:11:25', '2024-12-22 15:11:25'),
(7, 'Financial System - Basic', 'Essential financial tools for small businesses - Basic accounting, Invoice management, Expense tracking', 2999.00, 'active', '2024-12-22 15:11:25', '2024-12-22 15:11:25'),
(8, 'Financial System - Professional', 'Advanced financial management - Full accounting suite, Financial reporting, Budgeting tools', 5999.00, 'active', '2024-12-22 15:11:25', '2024-12-22 15:11:25'),
(9, 'Financial System - Enterprise', 'Enterprise financial solutions - Advanced analytics, Multi-entity management, Custom integrations', 11999.00, 'active', '2024-12-22 15:11:25', '2024-12-22 15:11:25'),
(10, 'Analytics Suite - Basic', 'Essential analytics tools - Basic reporting, Data visualization, Standard dashboards', 1499.00, 'active', '2024-12-22 15:11:25', '2024-12-22 15:11:25'),
(11, 'Analytics Suite - Professional', 'Advanced analytics platform - Custom reports, Advanced visualizations, Data integration', 3499.00, 'active', '2024-12-22 15:11:25', '2024-12-22 15:11:25'),
(12, 'Analytics Suite - Enterprise', 'Enterprise analytics solution - AI-powered insights, Predictive analytics, Custom solutions', 6999.00, 'active', '2024-12-22 15:11:25', '2024-12-22 15:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_inquiries`
--

CREATE TABLE `product_inquiries` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `organization` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','contacted','in_progress','completed','cancelled') NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remember_me_tokens`
--

CREATE TABLE `remember_me_tokens` (
  `id` int(11) NOT NULL,
  `user_type` enum('customer','admin') NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

CREATE TABLE `site_content` (
  `id` int(11) NOT NULL,
  `hero_title` varchar(255) NOT NULL,
  `hero_subtitle` text DEFAULT NULL,
  `featured_courses_title` varchar(255) DEFAULT NULL,
  `about_section_title` varchar(255) DEFAULT NULL,
  `about_section_content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_content`
--

INSERT INTO `site_content` (`id`, `hero_title`, `hero_subtitle`, `featured_courses_title`, `about_section_title`, `about_section_content`, `created_at`, `updated_at`) VALUES
(1, 'Welcome to Artifitech', 'Empowering minds through technology education', 'Featured Courses', 'About Us', 'Artifitech is a leading online learning platform dedicated to providing high-quality technology education.', '2024-12-22 11:00:11', '2024-12-22 11:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `site_description` text DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `social_facebook` varchar(255) DEFAULT NULL,
  `social_twitter` varchar(255) DEFAULT NULL,
  `social_instagram` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `favicon_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `site_description`, `contact_email`, `contact_phone`, `contact_address`, `social_facebook`, `social_twitter`, `social_instagram`, `logo_path`, `favicon_path`, `created_at`, `updated_at`) VALUES
(1, 'Artifitech', 'Your premier destination for technology education and skill development', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-22 11:00:11', '2024-12-22 11:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `student_progress`
--

CREATE TABLE `student_progress` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `status` enum('not_started','in_progress','completed') DEFAULT 'not_started',
  `progress` int(11) DEFAULT 0 COMMENT 'Progress percentage',
  `score` decimal(5,2) DEFAULT NULL COMMENT 'Quiz/Assignment score',
  `attempts` int(11) DEFAULT 0,
  `last_accessed` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` enum('active','cancelled','expired') DEFAULT 'active',
  `renewal_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) DEFAULT 'ZAR',
  `type` enum('course_purchase','subscription_payment','refund') NOT NULL,
  `status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `reference_id` varchar(100) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_details`)),
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `progress` int(11) DEFAULT 0,
  `status` enum('active', 'completed', 'cancelled') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `activity_log_admin_fk` (`admin_id`),
  ADD KEY `activity_log_customer_fk` (`customer_id`);

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_name` (`permission_name`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `auth_logs`
--
ALTER TABLE `auth_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_published` (`published_at`);

--
-- Indexes for table `blog_post_categories`
--
ALTER TABLE `blog_post_categories`
  ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_number` (`certificate_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `idx_certificate_number` (`certificate_number`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_content`
--
ALTER TABLE `course_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_course_sequence` (`course_id`,`sequence`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`customer_id`,`course_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_token` (`token`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_inquiries`
--
ALTER TABLE `product_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `site_content`
--
ALTER TABLE `site_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_progress` (`customer_id`,`content_id`),
  ADD KEY `content_id` (`content_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_reference` (`reference_id`),
  ADD KEY `idx_created` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `auth_logs`
--
ALTER TABLE `auth_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_content`
--
ALTER TABLE `course_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_inquiries`
--
ALTER TABLE `product_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_content`
--
ALTER TABLE `site_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_progress`
--
ALTER TABLE `student_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_admin_fk` FOREIGN KEY (`admin_id`) REFERENCES `administrators` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `activity_log_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD CONSTRAINT `admin_settings_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users_old` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `administrators` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blog_post_categories`
--
ALTER TABLE `blog_post_categories`
  ADD CONSTRAINT `blog_post_categories_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_post_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `course_content`
--
ALTER TABLE `course_content`
  ADD CONSTRAINT `course_content_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_inquiries`
--
ALTER TABLE `product_inquiries`
  ADD CONSTRAINT `product_inquiries_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `admin_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD CONSTRAINT `student_progress_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_progress_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `course_content` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
