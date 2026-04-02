-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2026 at 06:18 AM
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
-- Database: `jst_industry`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `next_department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `next_department_id`, `created_at`, `updated_at`) VALUES
(1, 'ฝ่ายขาย (Sales)', NULL, 2, '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(2, 'วิศวกรรม (Engineering)', NULL, 3, '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(3, 'ฝ่ายผลิต (Production)', NULL, 4, '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(4, 'ควบคุมคุณภาพ (QC/QA)', NULL, 5, '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(5, 'ติดตั้ง (Site)', NULL, NULL, '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(6, 'จัดซื้อ (Procurement)', NULL, 3, '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(7, 'คลังสินค้า (Warehouse)', NULL, 3, '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(8, 'บริหาร (Admin/HR/บัญชี)', NULL, NULL, '2026-03-31 06:44:23', '2026-03-31 06:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `position_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_code` varchar(50) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('active','inactive','resigned') NOT NULL DEFAULT 'active',
  `profile_image` varchar(512) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `department_id`, `position_id`, `employee_code`, `prefix`, `firstname`, `lastname`, `gender`, `start_date`, `status`, `profile_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 8, 12, 'ADMIN-001', 'นาย', 'ผู้ดูแล', 'ระบบ', NULL, '2026-03-31', 'active', NULL, '2026-03-31 06:44:23', '2026-03-31 06:44:23', NULL),
(2, 8, 13, 'JST-001', 'นาย', 'natthaphol', 'saeaueng', 'male', '2026-04-01', 'active', NULL, '2026-03-31 22:41:29', '2026-03-31 22:41:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('equipment','consumable') NOT NULL,
  `unit` varchar(50) NOT NULL,
  `current_stock` int(11) NOT NULL DEFAULT 0,
  `min_stock` int(11) NOT NULL DEFAULT 0,
  `location` varchar(100) DEFAULT NULL,
  `image_url` varchar(512) DEFAULT NULL,
  `status` enum('available','unavailable','maintenance') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_03_31_091020_create_departments_table', 1),
(4, '2026_03_31_091030_create_positions_table', 1),
(5, '2026_03_31_091044_create_employees_table', 1),
(6, '2026_03_31_091045_create_users_table', 1),
(7, '2026_03_31_091054_create_time_records_table', 1),
(8, '2026_03_31_091104_create_time_record_details_table', 1),
(9, '2026_03_31_091109_create_time_record_logs_table', 1),
(10, '2026_03_31_091114_create_item_categories_table', 1),
(11, '2026_03_31_091116_create_items_table', 1),
(12, '2026_03_31_091118_create_requisitions_table', 1),
(13, '2026_03_31_091119_create_stock_transactions_table', 1),
(14, '2026_03_31_091120_create_requisition_items_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `job_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `department_id`, `name`, `job_description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sales Engineer', 'รับลูกค้า, เสนอราคา, เก็บ requirement', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(2, 1, 'Sales', 'รับลูกค้า, เสนอราคา, เก็บ requirement', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(3, 2, 'Design Engineer', 'ออกแบบ, เขียนแบบ', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(4, 2, 'Draftman', 'ออกแบบ, เขียนแบบ', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(5, 3, 'Production Manager', 'คุมทีมผลิตงาน, เชื่อม, ประกอบ', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(6, 3, 'ช่างผลิต/ช่างเชื่อม', 'ผลิตงาน, เชื่อม, ประกอบ', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(7, 4, 'QC Inspector', 'ตรวจคุณภาพงาน', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(8, 5, 'Site Engineer', 'คุมงานติดตั้งหน้างานลูกค้า', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(9, 5, 'ช่างติดตั้ง', 'ติดตั้งหน้างานลูกค้า', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(10, 6, 'Purchasing', 'จัดซื้อวัสดุ อุปกรณ์', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(11, 7, 'Store / Stock', 'ควบคุมการเบิกจ่ายวัสดุ Production', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(12, 8, 'Admin', 'จัดการเอกสารทั่วไป ทุกแผนก', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(13, 8, 'HR', 'จัดการบุคคล, เงินเดือน', '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(14, 8, 'Accountant', 'จัดการบัญชี, การเงิน', '2026-03-31 06:44:23', '2026-03-31 06:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `requisitions`
--

CREATE TABLE `requisitions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `req_type` enum('borrow','consume') NOT NULL,
  `status` enum('pending','approved','rejected','returned_partial','returned_all') NOT NULL DEFAULT 'pending',
  `req_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `note` text DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requisition_items`
--

CREATE TABLE `requisition_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `requisition_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_requested` int(11) NOT NULL,
  `quantity_returned` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KdJVkoiIAy9gqEYedrib8NRjdUZwh5QwEX9VYvVE', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZzBYSzdnVFlKenNtdlFHNlR0U0tEVVBiZGNJa1J2YVJOelJXYlUybiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9oci9kZXBhcnRtZW50cyI7czo1OiJyb3V0ZSI7czoyMDoiaHIuZGVwYXJ0bWVudHMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1775026824);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` enum('in','out','return','adjust') NOT NULL,
  `quantity` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `requisition_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_records`
--

CREATE TABLE `time_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `work_date` date NOT NULL,
  `status` enum('present','late','absent','leave') NOT NULL DEFAULT 'present',
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `source` varchar(50) DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `locked_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_records`
--

INSERT INTO `time_records` (`id`, `employee_id`, `work_date`, `status`, `check_in_time`, `check_out_time`, `source`, `is_locked`, `locked_by`, `remark`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-03-31', 'present', '00:00:00', '00:00:00', 'batch', 0, NULL, '', '2026-03-31 11:25:32', '2026-03-31 12:39:31'),
(2, 1, '2026-03-01', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(3, 1, '2026-03-02', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(4, 1, '2026-03-03', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(5, 1, '2026-03-04', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(6, 1, '2026-03-05', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(7, 1, '2026-03-06', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(8, 1, '2026-03-07', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(9, 1, '2026-03-08', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(10, 1, '2026-03-09', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(11, 1, '2026-03-10', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(12, 1, '2026-03-11', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(13, 1, '2026-03-12', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(14, 1, '2026-03-13', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(15, 1, '2026-03-14', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(16, 1, '2026-03-15', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(17, 1, '2026-03-16', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(18, 1, '2026-03-17', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(19, 1, '2026-03-18', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(20, 1, '2026-03-19', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(21, 1, '2026-03-20', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(22, 1, '2026-03-21', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(23, 1, '2026-03-22', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(24, 1, '2026-03-23', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(25, 1, '2026-03-24', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(26, 1, '2026-03-25', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(27, 1, '2026-03-26', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(28, 1, '2026-03-27', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(29, 1, '2026-03-28', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(30, 1, '2026-03-29', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(31, 1, '2026-03-30', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(32, 1, '2026-04-01', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:51:54', '2026-03-31 12:51:54'),
(33, 1, '2026-04-02', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-03-31 12:51:54', '2026-03-31 12:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `time_record_details`
--

CREATE TABLE `time_record_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `time_record_id` bigint(20) UNSIGNED NOT NULL,
  `period_type` enum('morning','afternoon','overtime') NOT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_record_details`
--

INSERT INTO `time_record_details` (`id`, `time_record_id`, `period_type`, `check_in_time`, `check_out_time`, `created_at`, `updated_at`) VALUES
(1, 2, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(2, 2, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(3, 3, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(4, 3, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(5, 4, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(6, 4, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(7, 5, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(8, 5, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(9, 6, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(10, 6, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(11, 7, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(12, 7, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(13, 8, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(14, 8, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(15, 9, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(16, 9, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(17, 10, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(18, 10, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(19, 11, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(20, 11, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(21, 12, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(22, 12, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(23, 13, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(24, 13, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(25, 14, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(26, 14, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(27, 15, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(28, 15, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(29, 16, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(30, 16, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(31, 17, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(32, 17, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(33, 18, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(34, 18, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(35, 19, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(36, 19, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(37, 20, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(38, 20, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(39, 21, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(40, 21, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(41, 22, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(42, 22, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(43, 23, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(44, 23, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(45, 24, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(46, 24, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(47, 25, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(48, 25, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(49, 26, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(50, 26, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(51, 27, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(52, 27, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(53, 28, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(54, 28, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(55, 29, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(56, 29, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(57, 30, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(58, 30, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(59, 31, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(60, 31, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(61, 1, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(62, 1, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:39:31', '2026-03-31 12:39:31'),
(63, 32, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:51:54', '2026-03-31 12:51:54'),
(64, 32, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:51:54', '2026-03-31 12:51:54'),
(65, 33, 'morning', '08:00:00', '12:00:00', '2026-03-31 12:51:54', '2026-03-31 12:51:54'),
(66, 33, 'afternoon', '13:00:00', '17:00:00', '2026-03-31 12:51:54', '2026-03-31 12:51:54'),
(67, 33, 'overtime', '17:00:00', '21:00:00', '2026-03-31 12:51:54', '2026-03-31 12:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `time_record_logs`
--

CREATE TABLE `time_record_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `time_record_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(50) NOT NULL,
  `reason` text DEFAULT NULL,
  `old_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_data`)),
  `new_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_data`)),
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','hr','inventory','employee') NOT NULL DEFAULT 'employee',
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `employee_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ผู้ดูแลระบบ JST', 'admin', '$2y$12$PHdY5Fd2kynKVdEUBWiIQ.dZcae4QZPNlYEIGMbUDujCkQXln7tTi', 'admin', 1, NULL, '2026-03-31 06:44:23', '2026-03-31 06:44:23'),
(2, 'นายnatthaphol saeaueng', 'natthaphol', '$2y$12$YqbNKJ9859ZKQvsv/bOq1.v79w9btsbUNlQ7G4yHK6y.9KMrvb3GK', 'hr', 2, NULL, '2026-03-31 22:41:29', '2026-03-31 22:58:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_next_department_id_foreign` (`next_department_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employee_code_unique` (`employee_code`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_position_id_foreign` (`position_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_item_code_unique` (`item_code`),
  ADD KEY `items_category_id_foreign` (`category_id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `positions_department_id_foreign` (`department_id`);

--
-- Indexes for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requisitions_employee_id_foreign` (`employee_id`),
  ADD KEY `requisitions_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requisition_items_requisition_id_foreign` (`requisition_id`),
  ADD KEY `requisition_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transactions_item_id_foreign` (`item_id`),
  ADD KEY `stock_transactions_requisition_id_foreign` (`requisition_id`),
  ADD KEY `stock_transactions_created_by_foreign` (`created_by`);

--
-- Indexes for table `time_records`
--
ALTER TABLE `time_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `time_records_employee_id_work_date_unique` (`employee_id`,`work_date`),
  ADD KEY `time_records_locked_by_foreign` (`locked_by`);

--
-- Indexes for table `time_record_details`
--
ALTER TABLE `time_record_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `time_record_details_time_record_id_period_type_unique` (`time_record_id`,`period_type`);

--
-- Indexes for table `time_record_logs`
--
ALTER TABLE `time_record_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time_record_logs_time_record_id_foreign` (`time_record_id`),
  ADD KEY `time_record_logs_changed_by_foreign` (`changed_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `requisitions`
--
ALTER TABLE `requisitions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requisition_items`
--
ALTER TABLE `requisition_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_records`
--
ALTER TABLE `time_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `time_record_details`
--
ALTER TABLE `time_record_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `time_record_logs`
--
ALTER TABLE `time_record_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_next_department_id_foreign` FOREIGN KEY (`next_department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `item_categories` (`id`);

--
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD CONSTRAINT `requisitions_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requisitions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD CONSTRAINT `requisition_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `requisition_items_requisition_id_foreign` FOREIGN KEY (`requisition_id`) REFERENCES `requisitions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_transactions_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `stock_transactions_requisition_id_foreign` FOREIGN KEY (`requisition_id`) REFERENCES `requisitions` (`id`);

--
-- Constraints for table `time_records`
--
ALTER TABLE `time_records`
  ADD CONSTRAINT `time_records_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `time_records_locked_by_foreign` FOREIGN KEY (`locked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `time_record_details`
--
ALTER TABLE `time_record_details`
  ADD CONSTRAINT `time_record_details_time_record_id_foreign` FOREIGN KEY (`time_record_id`) REFERENCES `time_records` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `time_record_logs`
--
ALTER TABLE `time_record_logs`
  ADD CONSTRAINT `time_record_logs_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `time_record_logs_time_record_id_foreign` FOREIGN KEY (`time_record_id`) REFERENCES `time_records` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
