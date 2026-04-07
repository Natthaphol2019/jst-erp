-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2026 at 10:48 AM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `log_name` varchar(255) NOT NULL DEFAULT 'default',
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `log_name`, `description`, `subject_type`, `subject_id`, `properties`, `created_at`, `updated_at`) VALUES
(493, NULL, 'hr', 'สร้างแผนก: Administration (ID: 210)', 'App\\Models\\Department', 210, '{\"attributes\":{\"name\":\"Administration\",\"description\":\"Admin Department\",\"id\":210}}', '2026-04-06 23:01:45', '2026-04-06 23:01:45'),
(494, NULL, 'hr', 'สร้างตำแหน่ง: System Administrator (ID: 106)', 'App\\Models\\Position', 106, '{\"attributes\":{\"department_id\":210,\"name\":\"System Administrator\",\"job_description\":\"Manage system\",\"id\":106}}', '2026-04-06 23:01:45', '2026-04-06 23:01:45'),
(495, NULL, 'hr', 'สร้างพนักงาน: ADMIN001 System Administrator (ID: 89)', 'App\\Models\\Employee', 89, '{\"attributes\":{\"department_id\":210,\"position_id\":106,\"employee_code\":\"ADMIN001\",\"prefix\":\"Mr.\",\"firstname\":\"System\",\"lastname\":\"Administrator\",\"gender\":\"male\",\"start_date\":\"2026-04-07T06:01:45.771070Z\",\"status\":\"active\",\"id\":89}}', '2026-04-06 23:01:45', '2026-04-06 23:01:45'),
(496, NULL, 'hr', 'สร้างแผนก: คลังสินค้า (ID: 211)', 'App\\Models\\Department', 211, '{\"attributes\":{\"name\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"description\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"id\":211}}', '2026-04-06 23:06:42', '2026-04-06 23:06:42'),
(497, NULL, 'hr', 'สร้างแผนก: บริหาร (ID: 212)', 'App\\Models\\Department', 212, '{\"attributes\":{\"name\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"description\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e41\\u0e25\\u0e30\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\",\"id\":212}}', '2026-04-06 23:06:42', '2026-04-06 23:06:42'),
(498, NULL, 'hr', 'สร้างแผนก: พนักงานทั่วไป (ID: 213)', 'App\\Models\\Department', 213, '{\"attributes\":{\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\",\"description\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e17\\u0e35\\u0e48\\u0e21\\u0e32\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\",\"id\":213}}', '2026-04-06 23:06:42', '2026-04-06 23:06:42'),
(499, NULL, 'hr', 'สร้างตำแหน่ง: เจ้าหน้าที่คลังสินค้า (ID: 107)', 'App\\Models\\Position', 107, '{\"attributes\":{\"department_id\":211,\"name\":\"\\u0e40\\u0e08\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e17\\u0e35\\u0e48\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"job_description\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e23\\u0e31\\u0e1a-\\u0e08\\u0e48\\u0e32\\u0e22\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"id\":107}}', '2026-04-06 23:06:42', '2026-04-06 23:06:42'),
(500, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าคลังสินค้า (ID: 108)', 'App\\Models\\Position', 108, '{\"attributes\":{\"department_id\":211,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u548c\\u7ba1\\u7406\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e17\\u0e31\\u0e49\\u0e07\\u0e2b\\u0e21\\u0e14\",\"id\":108}}', '2026-04-06 23:06:42', '2026-04-06 23:06:42'),
(501, NULL, 'hr', 'สร้างตำแหน่ง: ผู้จัดการฝ่ายบริหาร (ID: 109)', 'App\\Models\\Position', 109, '{\"attributes\":{\"department_id\":212,\"name\":\"\\u0e1c\\u0e39\\u0e49\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"job_description\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e41\\u0e25\\u0e30\\u0e27\\u0e32\\u0e07\\u0e41\\u0e1c\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"id\":109}}', '2026-04-06 23:06:42', '2026-04-06 23:06:42'),
(502, NULL, 'hr', 'สร้างตำแหน่ง: เจ้าหน้าที่บริหาร (ID: 110)', 'App\\Models\\Position', 110, '{\"attributes\":{\"department_id\":212,\"name\":\"\\u0e40\\u0e08\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e17\\u0e35\\u0e48\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"job_description\":\"\\u0e2a\\u0e19\\u0e31\\u0e1a\\u0e2a\\u0e19\\u0e38\\u0e19\\u0e07\\u0e32\\u0e19\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\",\"id\":110}}', '2026-04-06 23:06:42', '2026-04-06 23:06:42'),
(503, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานทั่วไป (ID: 111)', 'App\\Models\\Position', 111, '{\"attributes\":{\"department_id\":213,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\",\"job_description\":\"\\u0e1b\\u0e0f\\u0e34\\u0e1a\\u0e31\\u0e15\\u0e34\\u0e07\\u0e32\\u0e19\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\\u0e41\\u0e25\\u0e30\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\",\"id\":111}}', '2026-04-06 23:06:42', '2026-04-06 23:06:42'),
(504, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้างาน (ID: 112)', 'App\\Models\\Position', 112, '{\"attributes\":{\"department_id\":213,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e41\\u0e25\\u0e30\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\\u0e01\\u0e32\\u0e23\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"id\":112}}', '2026-04-06 23:06:42', '2026-04-06 23:06:42'),
(505, NULL, 'hr', 'สร้างพนักงาน: เ001 สมชาย คลังทอง (ID: 90)', 'App\\Models\\Employee', 90, '{\"attributes\":{\"department_id\":211,\"position_id\":107,\"employee_code\":\"\\u0e40001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e0a\\u0e32\\u0e22\",\"lastname\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e17\\u0e2d\\u0e07\",\"gender\":\"male\",\"start_date\":\"2025-05-19T06:08:40.605063Z\",\"status\":\"active\",\"phone\":\"0875983188\",\"id\":90}}', '2026-04-06 23:08:40', '2026-04-06 23:08:40'),
(506, NULL, 'hr', 'สร้างพนักงาน: เ002 สมศักดิ์ รักษาสต๊อก (ID: 91)', 'App\\Models\\Employee', 91, '{\"attributes\":{\"department_id\":211,\"position_id\":107,\"employee_code\":\"\\u0e40002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e28\\u0e31\\u0e01\\u0e14\\u0e34\\u0e4c\",\"lastname\":\"\\u0e23\\u0e31\\u0e01\\u0e29\\u0e32\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"gender\":\"male\",\"start_date\":\"2025-06-20T06:08:40.882604Z\",\"status\":\"active\",\"phone\":\"0838655481\",\"id\":91}}', '2026-04-06 23:08:40', '2026-04-06 23:08:40'),
(507, NULL, 'hr', 'สร้างพนักงาน: ห003 วิชัย จัดการดี (ID: 92)', 'App\\Models\\Employee', 92, '{\"attributes\":{\"department_id\":211,\"position_id\":108,\"employee_code\":\"\\u0e2b003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e14\\u0e35\",\"gender\":\"male\",\"start_date\":\"2025-06-07T06:08:41.205940Z\",\"status\":\"active\",\"phone\":\"0896198925\",\"id\":92}}', '2026-04-06 23:08:41', '2026-04-06 23:08:41'),
(508, NULL, 'hr', 'สร้างพนักงาน: ห004 สมหญิง ควบคุมสต๊อก (ID: 93)', 'App\\Models\\Employee', 93, '{\"attributes\":{\"department_id\":211,\"position_id\":108,\"employee_code\":\"\\u0e2b004\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e2a\\u0e21\\u0e2b\\u0e0d\\u0e34\\u0e07\",\"lastname\":\"\\u0e04\\u0e27\\u0e1a\\u0e04\\u0e38\\u0e21\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"gender\":\"female\",\"start_date\":\"2025-06-13T06:08:41.447207Z\",\"status\":\"active\",\"phone\":\"0828234016\",\"id\":93}}', '2026-04-06 23:08:41', '2026-04-06 23:08:41'),
(509, NULL, 'hr', 'สร้างพนักงาน: ผ005 ประเสริฐ บริหารงาน (ID: 94)', 'App\\Models\\Employee', 94, '{\"attributes\":{\"department_id\":212,\"position_id\":109,\"employee_code\":\"\\u0e1c005\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1b\\u0e23\\u0e30\\u0e40\\u0e2a\\u0e23\\u0e34\\u0e10\",\"lastname\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"start_date\":\"2026-01-23T06:08:41.703082Z\",\"status\":\"active\",\"phone\":\"0882976099\",\"id\":94}}', '2026-04-06 23:08:41', '2026-04-06 23:08:41'),
(510, NULL, 'hr', 'สร้างพนักงาน: ผ006 พิมพ์ใจ จัดการเก่ง (ID: 95)', 'App\\Models\\Employee', 95, '{\"attributes\":{\"department_id\":212,\"position_id\":109,\"employee_code\":\"\\u0e1c006\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e21\\u0e1e\\u0e4c\\u0e43\\u0e08\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e40\\u0e01\\u0e48\\u0e07\",\"gender\":\"female\",\"start_date\":\"2025-04-16T06:08:41.953701Z\",\"status\":\"active\",\"phone\":\"0883284356\",\"id\":95}}', '2026-04-06 23:08:41', '2026-04-06 23:08:41'),
(511, NULL, 'hr', 'สร้างพนักงาน: เ007 นภา ธุรการ (ID: 96)', 'App\\Models\\Employee', 96, '{\"attributes\":{\"department_id\":212,\"position_id\":110,\"employee_code\":\"\\u0e40007\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e19\\u0e20\\u0e32\",\"lastname\":\"\\u0e18\\u0e38\\u0e23\\u0e01\\u0e32\\u0e23\",\"gender\":\"female\",\"start_date\":\"2025-12-22T06:08:42.205065Z\",\"status\":\"active\",\"phone\":\"0878419531\",\"id\":96}}', '2026-04-06 23:08:42', '2026-04-06 23:08:42'),
(512, NULL, 'hr', 'สร้างพนักงาน: เ008 ธนพล ประสานงาน (ID: 97)', 'App\\Models\\Employee', 97, '{\"attributes\":{\"department_id\":212,\"position_id\":110,\"employee_code\":\"\\u0e40008\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e1e\\u0e25\",\"lastname\":\"\\u0e1b\\u0e23\\u0e30\\u0e2a\\u0e32\\u0e19\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"start_date\":\"2026-01-19T06:08:42.456455Z\",\"status\":\"active\",\"phone\":\"0833617658\",\"id\":97}}', '2026-04-06 23:08:42', '2026-04-06 23:08:42'),
(513, NULL, 'hr', 'สร้างพนักงาน: พ009 อนุชา เบิกของ (ID: 98)', 'App\\Models\\Employee', 98, '{\"attributes\":{\"department_id\":213,\"position_id\":111,\"employee_code\":\"\\u0e1e009\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e19\\u0e38\\u0e0a\\u0e32\",\"lastname\":\"\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e02\\u0e2d\\u0e07\",\"gender\":\"male\",\"start_date\":\"2025-07-12T06:08:42.698675Z\",\"status\":\"active\",\"phone\":\"0828968832\",\"id\":98}}', '2026-04-06 23:08:42', '2026-04-06 23:08:42'),
(514, NULL, 'hr', 'สร้างพนักงาน: พ010 รัตนา ใช้อุปกรณ์ (ID: 99)', 'App\\Models\\Employee', 99, '{\"attributes\":{\"department_id\":213,\"position_id\":111,\"employee_code\":\"\\u0e1e010\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e32\",\"lastname\":\"\\u0e43\\u0e0a\\u0e49\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\",\"gender\":\"female\",\"start_date\":\"2025-12-26T06:08:42.943121Z\",\"status\":\"active\",\"phone\":\"0865884155\",\"id\":99}}', '2026-04-06 23:08:42', '2026-04-06 23:08:42'),
(515, NULL, 'hr', 'สร้างพนักงาน: ห011 สุรกิจ อนุมัติเบิก (ID: 100)', 'App\\Models\\Employee', 100, '{\"attributes\":{\"department_id\":213,\"position_id\":112,\"employee_code\":\"\\u0e2b011\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e38\\u0e23\\u0e01\\u0e34\\u0e08\",\"lastname\":\"\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\\u0e40\\u0e1a\\u0e34\\u0e01\",\"gender\":\"male\",\"start_date\":\"2025-06-24T06:08:43.179676Z\",\"status\":\"active\",\"phone\":\"0887272719\",\"id\":100}}', '2026-04-06 23:08:43', '2026-04-06 23:08:43'),
(516, NULL, 'hr', 'สร้างพนักงาน: ห012 วรรณา ควบคุมงาน (ID: 101)', 'App\\Models\\Employee', 101, '{\"attributes\":{\"department_id\":213,\"position_id\":112,\"employee_code\":\"\\u0e2b012\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e27\\u0e23\\u0e23\\u0e13\\u0e32\",\"lastname\":\"\\u0e04\\u0e27\\u0e1a\\u0e04\\u0e38\\u0e21\\u0e07\\u0e32\\u0e19\",\"gender\":\"female\",\"start_date\":\"2025-07-03T06:08:43.406778Z\",\"status\":\"active\",\"phone\":\"0867281193\",\"id\":101}}', '2026-04-06 23:08:43', '2026-04-06 23:08:43'),
(517, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-001 System Administrator (ID: 89)', 'App\\Models\\Employee', 89, '{\"old\":{\"employee_code\":\"ADMIN001\"},\"attributes\":{\"id\":89,\"department_id\":210,\"position_id\":106,\"employee_code\":\"JST-EMP-001\",\"prefix\":\"Mr.\",\"firstname\":\"System\",\"lastname\":\"Administrator\",\"gender\":\"male\",\"phone\":null,\"address\":null,\"start_date\":\"2026-04-07\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(518, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-002 สมชาย คลังทอง (ID: 90)', 'App\\Models\\Employee', 90, '{\"old\":{\"employee_code\":\"\\u0e40001\"},\"attributes\":{\"id\":90,\"department_id\":211,\"position_id\":107,\"employee_code\":\"JST-EMP-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e0a\\u0e32\\u0e22\",\"lastname\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e17\\u0e2d\\u0e07\",\"gender\":\"male\",\"phone\":\"0875983188\",\"address\":null,\"start_date\":\"2025-05-19\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(519, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-003 สมศักดิ์ รักษาสต๊อก (ID: 91)', 'App\\Models\\Employee', 91, '{\"old\":{\"employee_code\":\"\\u0e40002\"},\"attributes\":{\"id\":91,\"department_id\":211,\"position_id\":107,\"employee_code\":\"JST-EMP-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e28\\u0e31\\u0e01\\u0e14\\u0e34\\u0e4c\",\"lastname\":\"\\u0e23\\u0e31\\u0e01\\u0e29\\u0e32\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"gender\":\"male\",\"phone\":\"0838655481\",\"address\":null,\"start_date\":\"2025-06-20\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(520, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-004 วิชัย จัดการดี (ID: 92)', 'App\\Models\\Employee', 92, '{\"old\":{\"employee_code\":\"\\u0e2b003\"},\"attributes\":{\"id\":92,\"department_id\":211,\"position_id\":108,\"employee_code\":\"JST-EMP-004\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e14\\u0e35\",\"gender\":\"male\",\"phone\":\"0896198925\",\"address\":null,\"start_date\":\"2025-06-07\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(521, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-005 สมหญิง ควบคุมสต๊อก (ID: 93)', 'App\\Models\\Employee', 93, '{\"old\":{\"employee_code\":\"\\u0e2b004\"},\"attributes\":{\"id\":93,\"department_id\":211,\"position_id\":108,\"employee_code\":\"JST-EMP-005\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e2a\\u0e21\\u0e2b\\u0e0d\\u0e34\\u0e07\",\"lastname\":\"\\u0e04\\u0e27\\u0e1a\\u0e04\\u0e38\\u0e21\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"gender\":\"female\",\"phone\":\"0828234016\",\"address\":null,\"start_date\":\"2025-06-13\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(522, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-006 ประเสริฐ บริหารงาน (ID: 94)', 'App\\Models\\Employee', 94, '{\"old\":{\"employee_code\":\"\\u0e1c005\"},\"attributes\":{\"id\":94,\"department_id\":212,\"position_id\":109,\"employee_code\":\"JST-EMP-006\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1b\\u0e23\\u0e30\\u0e40\\u0e2a\\u0e23\\u0e34\\u0e10\",\"lastname\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"0882976099\",\"address\":null,\"start_date\":\"2026-01-23\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(523, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-007 พิมพ์ใจ จัดการเก่ง (ID: 95)', 'App\\Models\\Employee', 95, '{\"old\":{\"employee_code\":\"\\u0e1c006\"},\"attributes\":{\"id\":95,\"department_id\":212,\"position_id\":109,\"employee_code\":\"JST-EMP-007\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e21\\u0e1e\\u0e4c\\u0e43\\u0e08\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e40\\u0e01\\u0e48\\u0e07\",\"gender\":\"female\",\"phone\":\"0883284356\",\"address\":null,\"start_date\":\"2025-04-16\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(524, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-008 นภา ธุรการ (ID: 96)', 'App\\Models\\Employee', 96, '{\"old\":{\"employee_code\":\"\\u0e40007\"},\"attributes\":{\"id\":96,\"department_id\":212,\"position_id\":110,\"employee_code\":\"JST-EMP-008\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e19\\u0e20\\u0e32\",\"lastname\":\"\\u0e18\\u0e38\\u0e23\\u0e01\\u0e32\\u0e23\",\"gender\":\"female\",\"phone\":\"0878419531\",\"address\":null,\"start_date\":\"2025-12-22\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(525, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-009 ธนพล ประสานงาน (ID: 97)', 'App\\Models\\Employee', 97, '{\"old\":{\"employee_code\":\"\\u0e40008\"},\"attributes\":{\"id\":97,\"department_id\":212,\"position_id\":110,\"employee_code\":\"JST-EMP-009\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e1e\\u0e25\",\"lastname\":\"\\u0e1b\\u0e23\\u0e30\\u0e2a\\u0e32\\u0e19\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"0833617658\",\"address\":null,\"start_date\":\"2026-01-19\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(526, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-010 อนุชา เบิกของ (ID: 98)', 'App\\Models\\Employee', 98, '{\"old\":{\"employee_code\":\"\\u0e1e009\"},\"attributes\":{\"id\":98,\"department_id\":213,\"position_id\":111,\"employee_code\":\"JST-EMP-010\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e19\\u0e38\\u0e0a\\u0e32\",\"lastname\":\"\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e02\\u0e2d\\u0e07\",\"gender\":\"male\",\"phone\":\"0828968832\",\"address\":null,\"start_date\":\"2025-07-12\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(527, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-011 รัตนา ใช้อุปกรณ์ (ID: 99)', 'App\\Models\\Employee', 99, '{\"old\":{\"employee_code\":\"\\u0e1e010\"},\"attributes\":{\"id\":99,\"department_id\":213,\"position_id\":111,\"employee_code\":\"JST-EMP-011\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e32\",\"lastname\":\"\\u0e43\\u0e0a\\u0e49\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\",\"gender\":\"female\",\"phone\":\"0865884155\",\"address\":null,\"start_date\":\"2025-12-26\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(528, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-012 สุรกิจ อนุมัติเบิก (ID: 100)', 'App\\Models\\Employee', 100, '{\"old\":{\"employee_code\":\"\\u0e2b011\"},\"attributes\":{\"id\":100,\"department_id\":213,\"position_id\":112,\"employee_code\":\"JST-EMP-012\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e38\\u0e23\\u0e01\\u0e34\\u0e08\",\"lastname\":\"\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\\u0e40\\u0e1a\\u0e34\\u0e01\",\"gender\":\"male\",\"phone\":\"0887272719\",\"address\":null,\"start_date\":\"2025-06-24\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(529, NULL, 'hr', 'แก้ไขพนักงาน: JST-EMP-013 วรรณา ควบคุมงาน (ID: 101)', 'App\\Models\\Employee', 101, '{\"old\":{\"employee_code\":\"\\u0e2b012\"},\"attributes\":{\"id\":101,\"department_id\":213,\"position_id\":112,\"employee_code\":\"JST-EMP-013\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e27\\u0e23\\u0e23\\u0e13\\u0e32\",\"lastname\":\"\\u0e04\\u0e27\\u0e1a\\u0e04\\u0e38\\u0e21\\u0e07\\u0e32\\u0e19\",\"gender\":\"female\",\"phone\":\"0867281193\",\"address\":null,\"start_date\":\"2025-07-03\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:13:32', '2026-04-06 23:13:32'),
(530, NULL, 'hr', 'ลบพนักงาน: JST-EMP-001 System Administrator (ID: 89)', 'App\\Models\\Employee', 89, '{\"attributes\":{\"id\":89,\"department_id\":210,\"position_id\":106,\"employee_code\":\"JST-EMP-001\",\"prefix\":\"Mr.\",\"firstname\":\"System\",\"lastname\":\"Administrator\",\"gender\":\"male\",\"phone\":null,\"address\":null,\"start_date\":\"2026-04-07\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(531, NULL, 'hr', 'ลบพนักงาน: JST-EMP-002 สมชาย คลังทอง (ID: 90)', 'App\\Models\\Employee', 90, '{\"attributes\":{\"id\":90,\"department_id\":211,\"position_id\":107,\"employee_code\":\"JST-EMP-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e0a\\u0e32\\u0e22\",\"lastname\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e17\\u0e2d\\u0e07\",\"gender\":\"male\",\"phone\":\"0875983188\",\"address\":null,\"start_date\":\"2025-05-19\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(532, NULL, 'hr', 'ลบพนักงาน: JST-EMP-003 สมศักดิ์ รักษาสต๊อก (ID: 91)', 'App\\Models\\Employee', 91, '{\"attributes\":{\"id\":91,\"department_id\":211,\"position_id\":107,\"employee_code\":\"JST-EMP-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e28\\u0e31\\u0e01\\u0e14\\u0e34\\u0e4c\",\"lastname\":\"\\u0e23\\u0e31\\u0e01\\u0e29\\u0e32\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"gender\":\"male\",\"phone\":\"0838655481\",\"address\":null,\"start_date\":\"2025-06-20\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(533, NULL, 'hr', 'ลบพนักงาน: JST-EMP-004 วิชัย จัดการดี (ID: 92)', 'App\\Models\\Employee', 92, '{\"attributes\":{\"id\":92,\"department_id\":211,\"position_id\":108,\"employee_code\":\"JST-EMP-004\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e14\\u0e35\",\"gender\":\"male\",\"phone\":\"0896198925\",\"address\":null,\"start_date\":\"2025-06-07\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(534, NULL, 'hr', 'ลบพนักงาน: JST-EMP-005 สมหญิง ควบคุมสต๊อก (ID: 93)', 'App\\Models\\Employee', 93, '{\"attributes\":{\"id\":93,\"department_id\":211,\"position_id\":108,\"employee_code\":\"JST-EMP-005\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e2a\\u0e21\\u0e2b\\u0e0d\\u0e34\\u0e07\",\"lastname\":\"\\u0e04\\u0e27\\u0e1a\\u0e04\\u0e38\\u0e21\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"gender\":\"female\",\"phone\":\"0828234016\",\"address\":null,\"start_date\":\"2025-06-13\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(535, NULL, 'hr', 'ลบพนักงาน: JST-EMP-006 ประเสริฐ บริหารงาน (ID: 94)', 'App\\Models\\Employee', 94, '{\"attributes\":{\"id\":94,\"department_id\":212,\"position_id\":109,\"employee_code\":\"JST-EMP-006\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1b\\u0e23\\u0e30\\u0e40\\u0e2a\\u0e23\\u0e34\\u0e10\",\"lastname\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"0882976099\",\"address\":null,\"start_date\":\"2026-01-23\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(536, NULL, 'hr', 'ลบพนักงาน: JST-EMP-007 พิมพ์ใจ จัดการเก่ง (ID: 95)', 'App\\Models\\Employee', 95, '{\"attributes\":{\"id\":95,\"department_id\":212,\"position_id\":109,\"employee_code\":\"JST-EMP-007\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e21\\u0e1e\\u0e4c\\u0e43\\u0e08\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e40\\u0e01\\u0e48\\u0e07\",\"gender\":\"female\",\"phone\":\"0883284356\",\"address\":null,\"start_date\":\"2025-04-16\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(537, NULL, 'hr', 'ลบพนักงาน: JST-EMP-008 นภา ธุรการ (ID: 96)', 'App\\Models\\Employee', 96, '{\"attributes\":{\"id\":96,\"department_id\":212,\"position_id\":110,\"employee_code\":\"JST-EMP-008\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e19\\u0e20\\u0e32\",\"lastname\":\"\\u0e18\\u0e38\\u0e23\\u0e01\\u0e32\\u0e23\",\"gender\":\"female\",\"phone\":\"0878419531\",\"address\":null,\"start_date\":\"2025-12-22\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(538, NULL, 'hr', 'ลบพนักงาน: JST-EMP-009 ธนพล ประสานงาน (ID: 97)', 'App\\Models\\Employee', 97, '{\"attributes\":{\"id\":97,\"department_id\":212,\"position_id\":110,\"employee_code\":\"JST-EMP-009\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e1e\\u0e25\",\"lastname\":\"\\u0e1b\\u0e23\\u0e30\\u0e2a\\u0e32\\u0e19\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"0833617658\",\"address\":null,\"start_date\":\"2026-01-19\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(539, NULL, 'hr', 'ลบพนักงาน: JST-EMP-010 อนุชา เบิกของ (ID: 98)', 'App\\Models\\Employee', 98, '{\"attributes\":{\"id\":98,\"department_id\":213,\"position_id\":111,\"employee_code\":\"JST-EMP-010\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e19\\u0e38\\u0e0a\\u0e32\",\"lastname\":\"\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e02\\u0e2d\\u0e07\",\"gender\":\"male\",\"phone\":\"0828968832\",\"address\":null,\"start_date\":\"2025-07-12\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(540, NULL, 'hr', 'ลบพนักงาน: JST-EMP-011 รัตนา ใช้อุปกรณ์ (ID: 99)', 'App\\Models\\Employee', 99, '{\"attributes\":{\"id\":99,\"department_id\":213,\"position_id\":111,\"employee_code\":\"JST-EMP-011\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e32\",\"lastname\":\"\\u0e43\\u0e0a\\u0e49\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\",\"gender\":\"female\",\"phone\":\"0865884155\",\"address\":null,\"start_date\":\"2025-12-26\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(541, NULL, 'hr', 'ลบพนักงาน: JST-EMP-012 สุรกิจ อนุมัติเบิก (ID: 100)', 'App\\Models\\Employee', 100, '{\"attributes\":{\"id\":100,\"department_id\":213,\"position_id\":112,\"employee_code\":\"JST-EMP-012\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e38\\u0e23\\u0e01\\u0e34\\u0e08\",\"lastname\":\"\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\\u0e40\\u0e1a\\u0e34\\u0e01\",\"gender\":\"male\",\"phone\":\"0887272719\",\"address\":null,\"start_date\":\"2025-06-24\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(542, NULL, 'hr', 'ลบพนักงาน: JST-EMP-013 วรรณา ควบคุมงาน (ID: 101)', 'App\\Models\\Employee', 101, '{\"attributes\":{\"id\":101,\"department_id\":213,\"position_id\":112,\"employee_code\":\"JST-EMP-013\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e27\\u0e23\\u0e23\\u0e13\\u0e32\",\"lastname\":\"\\u0e04\\u0e27\\u0e1a\\u0e04\\u0e38\\u0e21\\u0e07\\u0e32\\u0e19\",\"gender\":\"female\",\"phone\":\"0867281193\",\"address\":null,\"start_date\":\"2025-07-03\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:16', '2026-04-06 23:17:16'),
(543, NULL, 'hr', 'ลบพนักงาน: JST-EMP-001 System Administrator (ID: 89)', 'App\\Models\\Employee', 89, '{\"attributes\":{\"id\":89,\"department_id\":210,\"position_id\":106,\"employee_code\":\"JST-EMP-001\",\"prefix\":\"Mr.\",\"firstname\":\"System\",\"lastname\":\"Administrator\",\"gender\":\"male\",\"phone\":null,\"address\":null,\"start_date\":\"2026-04-07\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(544, NULL, 'hr', 'ลบพนักงาน: JST-EMP-002 สมชาย คลังทอง (ID: 90)', 'App\\Models\\Employee', 90, '{\"attributes\":{\"id\":90,\"department_id\":211,\"position_id\":107,\"employee_code\":\"JST-EMP-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e0a\\u0e32\\u0e22\",\"lastname\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e17\\u0e2d\\u0e07\",\"gender\":\"male\",\"phone\":\"0875983188\",\"address\":null,\"start_date\":\"2025-05-19\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(545, NULL, 'hr', 'ลบพนักงาน: JST-EMP-003 สมศักดิ์ รักษาสต๊อก (ID: 91)', 'App\\Models\\Employee', 91, '{\"attributes\":{\"id\":91,\"department_id\":211,\"position_id\":107,\"employee_code\":\"JST-EMP-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e28\\u0e31\\u0e01\\u0e14\\u0e34\\u0e4c\",\"lastname\":\"\\u0e23\\u0e31\\u0e01\\u0e29\\u0e32\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"gender\":\"male\",\"phone\":\"0838655481\",\"address\":null,\"start_date\":\"2025-06-20\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(546, NULL, 'hr', 'ลบพนักงาน: JST-EMP-004 วิชัย จัดการดี (ID: 92)', 'App\\Models\\Employee', 92, '{\"attributes\":{\"id\":92,\"department_id\":211,\"position_id\":108,\"employee_code\":\"JST-EMP-004\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e14\\u0e35\",\"gender\":\"male\",\"phone\":\"0896198925\",\"address\":null,\"start_date\":\"2025-06-07\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(547, NULL, 'hr', 'ลบพนักงาน: JST-EMP-005 สมหญิง ควบคุมสต๊อก (ID: 93)', 'App\\Models\\Employee', 93, '{\"attributes\":{\"id\":93,\"department_id\":211,\"position_id\":108,\"employee_code\":\"JST-EMP-005\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e2a\\u0e21\\u0e2b\\u0e0d\\u0e34\\u0e07\",\"lastname\":\"\\u0e04\\u0e27\\u0e1a\\u0e04\\u0e38\\u0e21\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"gender\":\"female\",\"phone\":\"0828234016\",\"address\":null,\"start_date\":\"2025-06-13\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(548, NULL, 'hr', 'ลบพนักงาน: JST-EMP-006 ประเสริฐ บริหารงาน (ID: 94)', 'App\\Models\\Employee', 94, '{\"attributes\":{\"id\":94,\"department_id\":212,\"position_id\":109,\"employee_code\":\"JST-EMP-006\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1b\\u0e23\\u0e30\\u0e40\\u0e2a\\u0e23\\u0e34\\u0e10\",\"lastname\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"0882976099\",\"address\":null,\"start_date\":\"2026-01-23\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(549, NULL, 'hr', 'ลบพนักงาน: JST-EMP-007 พิมพ์ใจ จัดการเก่ง (ID: 95)', 'App\\Models\\Employee', 95, '{\"attributes\":{\"id\":95,\"department_id\":212,\"position_id\":109,\"employee_code\":\"JST-EMP-007\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e21\\u0e1e\\u0e4c\\u0e43\\u0e08\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e40\\u0e01\\u0e48\\u0e07\",\"gender\":\"female\",\"phone\":\"0883284356\",\"address\":null,\"start_date\":\"2025-04-16\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(550, NULL, 'hr', 'ลบพนักงาน: JST-EMP-008 นภา ธุรการ (ID: 96)', 'App\\Models\\Employee', 96, '{\"attributes\":{\"id\":96,\"department_id\":212,\"position_id\":110,\"employee_code\":\"JST-EMP-008\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e19\\u0e20\\u0e32\",\"lastname\":\"\\u0e18\\u0e38\\u0e23\\u0e01\\u0e32\\u0e23\",\"gender\":\"female\",\"phone\":\"0878419531\",\"address\":null,\"start_date\":\"2025-12-22\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(551, NULL, 'hr', 'ลบพนักงาน: JST-EMP-009 ธนพล ประสานงาน (ID: 97)', 'App\\Models\\Employee', 97, '{\"attributes\":{\"id\":97,\"department_id\":212,\"position_id\":110,\"employee_code\":\"JST-EMP-009\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e1e\\u0e25\",\"lastname\":\"\\u0e1b\\u0e23\\u0e30\\u0e2a\\u0e32\\u0e19\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"0833617658\",\"address\":null,\"start_date\":\"2026-01-19\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(552, NULL, 'hr', 'ลบพนักงาน: JST-EMP-010 อนุชา เบิกของ (ID: 98)', 'App\\Models\\Employee', 98, '{\"attributes\":{\"id\":98,\"department_id\":213,\"position_id\":111,\"employee_code\":\"JST-EMP-010\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e19\\u0e38\\u0e0a\\u0e32\",\"lastname\":\"\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e02\\u0e2d\\u0e07\",\"gender\":\"male\",\"phone\":\"0828968832\",\"address\":null,\"start_date\":\"2025-07-12\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(553, NULL, 'hr', 'ลบพนักงาน: JST-EMP-011 รัตนา ใช้อุปกรณ์ (ID: 99)', 'App\\Models\\Employee', 99, '{\"attributes\":{\"id\":99,\"department_id\":213,\"position_id\":111,\"employee_code\":\"JST-EMP-011\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e32\",\"lastname\":\"\\u0e43\\u0e0a\\u0e49\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\",\"gender\":\"female\",\"phone\":\"0865884155\",\"address\":null,\"start_date\":\"2025-12-26\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(554, NULL, 'hr', 'ลบพนักงาน: JST-EMP-012 สุรกิจ อนุมัติเบิก (ID: 100)', 'App\\Models\\Employee', 100, '{\"attributes\":{\"id\":100,\"department_id\":213,\"position_id\":112,\"employee_code\":\"JST-EMP-012\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e38\\u0e23\\u0e01\\u0e34\\u0e08\",\"lastname\":\"\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\\u0e40\\u0e1a\\u0e34\\u0e01\",\"gender\":\"male\",\"phone\":\"0887272719\",\"address\":null,\"start_date\":\"2025-06-24\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(555, NULL, 'hr', 'ลบพนักงาน: JST-EMP-013 วรรณา ควบคุมงาน (ID: 101)', 'App\\Models\\Employee', 101, '{\"attributes\":{\"id\":101,\"department_id\":213,\"position_id\":112,\"employee_code\":\"JST-EMP-013\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e27\\u0e23\\u0e23\\u0e13\\u0e32\",\"lastname\":\"\\u0e04\\u0e27\\u0e1a\\u0e04\\u0e38\\u0e21\\u0e07\\u0e32\\u0e19\",\"gender\":\"female\",\"phone\":\"0867281193\",\"address\":null,\"start_date\":\"2025-07-03\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:17:51', '2026-04-06 23:17:51'),
(556, NULL, 'hr', 'สร้างแผนก: ฝ่ายขาย (ID: 214)', 'App\\Models\\Department', 214, '{\"attributes\":{\"name\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e02\\u0e32\\u0e22\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e02\\u0e32\\u0e22\\u0e41\\u0e25\\u0e30\\u0e01\\u0e32\\u0e23\\u0e15\\u0e25\\u0e32\\u0e14\",\"id\":214}}', '2026-04-06 23:18:51', '2026-04-06 23:18:51'),
(557, NULL, 'hr', 'สร้างแผนก: วิศวกรรม (ID: 215)', 'App\\Models\\Department', 215, '{\"attributes\":{\"name\":\"\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\\u0e41\\u0e25\\u0e30\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"id\":215}}', '2026-04-06 23:18:51', '2026-04-06 23:18:51'),
(558, NULL, 'hr', 'สร้างแผนก: การผลิต (ID: 216)', 'App\\Models\\Department', 216, '{\"attributes\":{\"name\":\"\\u0e01\\u0e32\\u0e23\\u0e1c\\u0e25\\u0e34\\u0e15\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e1c\\u0e25\\u0e34\\u0e15\\u0e41\\u0e25\\u0e30\\u0e1b\\u0e23\\u0e30\\u0e01\\u0e2d\\u0e1a\",\"id\":216}}', '2026-04-06 23:18:51', '2026-04-06 23:18:51'),
(559, NULL, 'hr', 'สร้างแผนก: QC (ID: 217)', 'App\\Models\\Department', 217, '{\"attributes\":{\"name\":\"QC\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"id\":217}}', '2026-04-06 23:18:51', '2026-04-06 23:18:51'),
(560, NULL, 'hr', 'สร้างแผนก: หน้างาน (ID: 218)', 'App\\Models\\Department', 218, '{\"attributes\":{\"name\":\"\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\\u0e41\\u0e25\\u0e30\\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19\",\"id\":218}}', '2026-04-06 23:18:51', '2026-04-06 23:18:51'),
(561, NULL, 'hr', 'สร้างแผนก: จัดซื้อ (ID: 219)', 'App\\Models\\Department', 219, '{\"attributes\":{\"name\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"id\":219}}', '2026-04-06 23:18:51', '2026-04-06 23:18:51'),
(562, NULL, 'hr', 'สร้างแผนก: คลังสินค้า (ID: 220)', 'App\\Models\\Department', 220, '{\"attributes\":{\"name\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e08\\u0e48\\u0e32\\u0e22\",\"id\":220}}', '2026-04-06 23:18:51', '2026-04-06 23:18:51'),
(563, NULL, 'hr', 'สร้างแผนก: บริหาร (ID: 221)', 'App\\Models\\Department', 221, '{\"attributes\":{\"name\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"description\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"id\":221}}', '2026-04-06 23:18:51', '2026-04-06 23:18:51'),
(564, NULL, 'hr', 'สร้างแผนก: ฝ่ายขาย (ID: 222)', 'App\\Models\\Department', 222, '{\"attributes\":{\"name\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e02\\u0e32\\u0e22\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e02\\u0e32\\u0e22\\u0e41\\u0e25\\u0e30\\u0e01\\u0e32\\u0e23\\u0e15\\u0e25\\u0e32\\u0e14\",\"id\":222}}', '2026-04-06 23:19:07', '2026-04-06 23:19:07'),
(565, NULL, 'hr', 'สร้างแผนก: วิศวกรรม (ID: 223)', 'App\\Models\\Department', 223, '{\"attributes\":{\"name\":\"\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\\u0e41\\u0e25\\u0e30\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"id\":223}}', '2026-04-06 23:19:07', '2026-04-06 23:19:07'),
(566, NULL, 'hr', 'สร้างแผนก: การผลิต (ID: 224)', 'App\\Models\\Department', 224, '{\"attributes\":{\"name\":\"\\u0e01\\u0e32\\u0e23\\u0e1c\\u0e25\\u0e34\\u0e15\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e1c\\u0e25\\u0e34\\u0e15\\u0e41\\u0e25\\u0e30\\u0e1b\\u0e23\\u0e30\\u0e01\\u0e2d\\u0e1a\",\"id\":224}}', '2026-04-06 23:19:07', '2026-04-06 23:19:07'),
(567, NULL, 'hr', 'สร้างแผนก: QC (ID: 225)', 'App\\Models\\Department', 225, '{\"attributes\":{\"name\":\"QC\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"id\":225}}', '2026-04-06 23:19:07', '2026-04-06 23:19:07'),
(568, NULL, 'hr', 'สร้างแผนก: หน้างาน (ID: 226)', 'App\\Models\\Department', 226, '{\"attributes\":{\"name\":\"\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\\u0e41\\u0e25\\u0e30\\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19\",\"id\":226}}', '2026-04-06 23:19:07', '2026-04-06 23:19:07'),
(569, NULL, 'hr', 'สร้างแผนก: จัดซื้อ (ID: 227)', 'App\\Models\\Department', 227, '{\"attributes\":{\"name\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"id\":227}}', '2026-04-06 23:19:07', '2026-04-06 23:19:07'),
(570, NULL, 'hr', 'สร้างแผนก: คลังสินค้า (ID: 228)', 'App\\Models\\Department', 228, '{\"attributes\":{\"name\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e08\\u0e48\\u0e32\\u0e22\",\"id\":228}}', '2026-04-06 23:19:07', '2026-04-06 23:19:07'),
(571, NULL, 'hr', 'สร้างแผนก: บริหาร (ID: 229)', 'App\\Models\\Department', 229, '{\"attributes\":{\"name\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"description\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"id\":229}}', '2026-04-06 23:19:07', '2026-04-06 23:19:07'),
(572, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานขาย (ID: 115)', 'App\\Models\\Position', 115, '{\"attributes\":{\"department_id\":222,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e02\\u0e32\\u0e22\",\"job_description\":\"\\u0e1b\\u0e0f\\u0e34\\u0e1a\\u0e31\\u0e15\\u0e34\\u0e07\\u0e32\\u0e19\\u0e02\\u0e32\\u0e22\",\"id\":115}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(573, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าพนักงานขาย (ID: 116)', 'App\\Models\\Position', 116, '{\"attributes\":{\"department_id\":222,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e02\\u0e32\\u0e22\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e17\\u0e35\\u0e21\\u0e02\\u0e32\\u0e22\",\"id\":116}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(574, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานฝ่ายเทคนิค (ID: 117)', 'App\\Models\\Position', 117, '{\"attributes\":{\"department_id\":223,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"job_description\":\"\\u0e07\\u0e32\\u0e19\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\",\"id\":117}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(575, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าฝ่ายเทคนิค (ID: 118)', 'App\\Models\\Position', 118, '{\"attributes\":{\"department_id\":223,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e17\\u0e35\\u0e21\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"id\":118}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(576, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานฝ่ายผลิต (ID: 119)', 'App\\Models\\Position', 119, '{\"attributes\":{\"department_id\":224,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1c\\u0e25\\u0e34\\u0e15\",\"job_description\":\"\\u0e07\\u0e32\\u0e19\\u0e1c\\u0e25\\u0e34\\u0e15\",\"id\":119}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(577, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าฝ่ายผลิต (ID: 120)', 'App\\Models\\Position', 120, '{\"attributes\":{\"department_id\":224,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1c\\u0e25\\u0e34\\u0e15\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e17\\u0e35\\u0e21\\u0e1c\\u0e25\\u0e34\\u0e15\",\"id\":120}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(578, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานฝ่าย QC (ID: 121)', 'App\\Models\\Position', 121, '{\"attributes\":{\"department_id\":225,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22 QC\",\"job_description\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"id\":121}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(579, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานหน้างาน (ID: 122)', 'App\\Models\\Position', 122, '{\"attributes\":{\"department_id\":226,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"job_description\":\"\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"id\":122}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(580, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าหน้างาน (ID: 123)', 'App\\Models\\Position', 123, '{\"attributes\":{\"department_id\":226,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"id\":123}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(581, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานจัดซื้อ (ID: 124)', 'App\\Models\\Position', 124, '{\"attributes\":{\"department_id\":227,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"job_description\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\\u0e08\\u0e31\\u0e14\\u0e08\\u0e49\\u0e32\\u0e07\",\"id\":124}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(582, NULL, 'hr', 'สร้างพนักงาน: SAL-001 สมชาย วงศ์สวัสดิ์ (ID: 103)', 'App\\Models\\Employee', 103, '{\"attributes\":{\"department_id\":222,\"position_id\":115,\"employee_code\":\"SAL-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e0a\\u0e32\\u0e22\",\"lastname\":\"\\u0e27\\u0e07\\u0e28\\u0e4c\\u0e2a\\u0e27\\u0e31\\u0e2a\\u0e14\\u0e34\\u0e4c\",\"gender\":\"male\",\"phone\":\"081-234-5678\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":103}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(583, NULL, 'hr', 'สร้างพนักงาน: SAL-002 สุภาวดี จันทร์เพ็ญ (ID: 104)', 'App\\Models\\Employee', 104, '{\"attributes\":{\"department_id\":222,\"position_id\":116,\"employee_code\":\"SAL-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e2a\\u0e38\\u0e20\\u0e32\\u0e27\\u0e14\\u0e35\",\"lastname\":\"\\u0e08\\u0e31\\u0e19\\u0e17\\u0e23\\u0e4c\\u0e40\\u0e1e\\u0e47\\u0e0d\",\"gender\":\"female\",\"phone\":\"089-876-5432\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":104}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(584, NULL, 'hr', 'สร้างพนักงาน: SAL-003 ธนกร รัตนชัย (ID: 105)', 'App\\Models\\Employee', 105, '{\"attributes\":{\"department_id\":222,\"position_id\":115,\"employee_code\":\"SAL-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e01\\u0e23\",\"lastname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e0a\\u0e31\\u0e22\",\"gender\":\"male\",\"phone\":\"062-345-6789\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":105}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(585, NULL, 'hr', 'สร้างพนักงาน: ENG-001 กิตติ พัฒนาพงศ์ (ID: 106)', 'App\\Models\\Employee', 106, '{\"attributes\":{\"department_id\":223,\"position_id\":117,\"employee_code\":\"ENG-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e01\\u0e34\\u0e15\\u0e15\\u0e34\",\"lastname\":\"\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e32\\u0e1e\\u0e07\\u0e28\\u0e4c\",\"gender\":\"male\",\"phone\":\"083-456-7890\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":106}}', '2026-04-06 23:21:32', '2026-04-06 23:21:32'),
(586, NULL, 'hr', 'สร้างพนักงาน: ENG-002 วิชัย แก้วมณี (ID: 107)', 'App\\Models\\Employee', 107, '{\"attributes\":{\"department_id\":223,\"position_id\":118,\"employee_code\":\"ENG-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e41\\u0e01\\u0e49\\u0e27\\u0e21\\u0e13\\u0e35\",\"gender\":\"male\",\"phone\":\"095-567-8901\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":107}}', '2026-04-06 23:21:33', '2026-04-06 23:21:33'),
(587, NULL, 'hr', 'สร้างพนักงาน: ENG-003 พิมพ์ใจ สุขสมบูรณ์ (ID: 108)', 'App\\Models\\Employee', 108, '{\"attributes\":{\"department_id\":223,\"position_id\":117,\"employee_code\":\"ENG-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e21\\u0e1e\\u0e4c\\u0e43\\u0e08\",\"lastname\":\"\\u0e2a\\u0e38\\u0e02\\u0e2a\\u0e21\\u0e1a\\u0e39\\u0e23\\u0e13\\u0e4c\",\"gender\":\"female\",\"phone\":\"087-678-9012\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":108}}', '2026-04-06 23:21:33', '2026-04-06 23:21:33'),
(588, NULL, 'hr', 'สร้างพนักงาน: PRD-001 ประสิทธิ์ การช่าง (ID: 109)', 'App\\Models\\Employee', 109, '{\"attributes\":{\"department_id\":224,\"position_id\":119,\"employee_code\":\"PRD-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1b\\u0e23\\u0e30\\u0e2a\\u0e34\\u0e17\\u0e18\\u0e34\\u0e4c\",\"lastname\":\"\\u0e01\\u0e32\\u0e23\\u0e0a\\u0e48\\u0e32\\u0e07\",\"gender\":\"male\",\"phone\":\"084-789-0123\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":109}}', '2026-04-06 23:21:33', '2026-04-06 23:21:33'),
(589, NULL, 'hr', 'สร้างพนักงาน: PRD-002 มงคล เหล็กกล้า (ID: 110)', 'App\\Models\\Employee', 110, '{\"attributes\":{\"department_id\":224,\"position_id\":120,\"employee_code\":\"PRD-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e21\\u0e07\\u0e04\\u0e25\",\"lastname\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e01\\u0e25\\u0e49\\u0e32\",\"gender\":\"male\",\"phone\":\"091-890-1234\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":110}}', '2026-04-06 23:21:33', '2026-04-06 23:21:33'),
(590, NULL, 'hr', 'สร้างพนักงาน: PRD-003 บุญมี ช่างเชื่อม (ID: 111)', 'App\\Models\\Employee', 111, '{\"attributes\":{\"department_id\":224,\"position_id\":119,\"employee_code\":\"PRD-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1a\\u0e38\\u0e0d\\u0e21\\u0e35\",\"lastname\":\"\\u0e0a\\u0e48\\u0e32\\u0e07\\u0e40\\u0e0a\\u0e37\\u0e48\\u0e2d\\u0e21\",\"gender\":\"male\",\"phone\":\"063-901-2345\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":111}}', '2026-04-06 23:21:34', '2026-04-06 23:21:34'),
(591, NULL, 'hr', 'สร้างพนักงาน: PRD-004 สุรชัย ประกอบกิจ (ID: 112)', 'App\\Models\\Employee', 112, '{\"attributes\":{\"department_id\":224,\"position_id\":119,\"employee_code\":\"PRD-004\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e38\\u0e23\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e1b\\u0e23\\u0e30\\u0e01\\u0e2d\\u0e1a\\u0e01\\u0e34\\u0e08\",\"gender\":\"male\",\"phone\":\"088-012-3456\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":112}}', '2026-04-06 23:21:34', '2026-04-06 23:21:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `log_name`, `description`, `subject_type`, `subject_id`, `properties`, `created_at`, `updated_at`) VALUES
(592, NULL, 'hr', 'สร้างพนักงาน: PRD-005 อภิชาติ ผลิตผล (ID: 113)', 'App\\Models\\Employee', 113, '{\"attributes\":{\"department_id\":224,\"position_id\":119,\"employee_code\":\"PRD-005\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e20\\u0e34\\u0e0a\\u0e32\\u0e15\\u0e34\",\"lastname\":\"\\u0e1c\\u0e25\\u0e34\\u0e15\\u0e1c\\u0e25\",\"gender\":\"male\",\"phone\":\"092-123-4567\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":113}}', '2026-04-06 23:21:34', '2026-04-06 23:21:34'),
(593, NULL, 'hr', 'สร้างพนักงาน: QC-001 ชัยวัฒน์ ตรวจดี (ID: 114)', 'App\\Models\\Employee', 114, '{\"attributes\":{\"department_id\":225,\"position_id\":121,\"employee_code\":\"QC-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e0a\\u0e31\\u0e22\\u0e27\\u0e31\\u0e12\\u0e19\\u0e4c\",\"lastname\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e14\\u0e35\",\"gender\":\"male\",\"phone\":\"085-234-5678\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":114}}', '2026-04-06 23:21:34', '2026-04-06 23:21:34'),
(594, NULL, 'hr', 'สร้างพนักงาน: QC-002 รัตนา คุณภาพ (ID: 115)', 'App\\Models\\Employee', 115, '{\"attributes\":{\"department_id\":225,\"position_id\":121,\"employee_code\":\"QC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e32\",\"lastname\":\"\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"gender\":\"female\",\"phone\":\"096-345-6789\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":115}}', '2026-04-06 23:21:34', '2026-04-06 23:21:34'),
(595, NULL, 'hr', 'สร้างพนักงาน: SIT-001 พีรพัฒน์ หน้างาน (ID: 116)', 'App\\Models\\Employee', 116, '{\"attributes\":{\"department_id\":226,\"position_id\":122,\"employee_code\":\"SIT-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1e\\u0e35\\u0e23\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e4c\",\"lastname\":\"\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"086-456-7890\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":116}}', '2026-04-06 23:21:35', '2026-04-06 23:21:35'),
(596, NULL, 'hr', 'สร้างพนักงาน: SIT-002 อนุชา ติดตั้ง (ID: 117)', 'App\\Models\\Employee', 117, '{\"attributes\":{\"department_id\":226,\"position_id\":123,\"employee_code\":\"SIT-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e19\\u0e38\\u0e0a\\u0e32\",\"lastname\":\"\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\",\"gender\":\"male\",\"phone\":\"093-567-8901\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":117}}', '2026-04-06 23:21:35', '2026-04-06 23:21:35'),
(597, NULL, 'hr', 'สร้างพนักงาน: SIT-003 ธนพล ไซต์งาน (ID: 118)', 'App\\Models\\Employee', 118, '{\"attributes\":{\"department_id\":226,\"position_id\":122,\"employee_code\":\"SIT-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e1e\\u0e25\",\"lastname\":\"\\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"064-678-9012\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":118}}', '2026-04-06 23:21:35', '2026-04-06 23:21:35'),
(598, NULL, 'hr', 'สร้างพนักงาน: PUR-001 จิดาภา จัดซื้อ (ID: 119)', 'App\\Models\\Employee', 119, '{\"attributes\":{\"department_id\":227,\"position_id\":124,\"employee_code\":\"PUR-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e08\\u0e34\\u0e14\\u0e32\\u0e20\\u0e32\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"gender\":\"female\",\"phone\":\"082-789-0123\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":119}}', '2026-04-06 23:21:35', '2026-04-06 23:21:35'),
(599, NULL, 'hr', 'สร้างพนักงาน: PUR-002  กรกฎ หามา (ID: 120)', 'App\\Models\\Employee', 120, '{\"attributes\":{\"department_id\":227,\"position_id\":124,\"employee_code\":\"PUR-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\" \\u0e01\\u0e23\\u0e01\\u0e0e\",\"lastname\":\"\\u0e2b\\u0e32\\u0e21\\u0e32\",\"gender\":\"male\",\"phone\":\"094-890-1234\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":120}}', '2026-04-06 23:21:36', '2026-04-06 23:21:36'),
(600, NULL, 'hr', 'สร้างพนักงาน: WH-001 วิรัตน์ คลังสินค้า (ID: 121)', 'App\\Models\\Employee', 121, '{\"attributes\":{\"department_id\":211,\"position_id\":107,\"employee_code\":\"WH-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e23\\u0e31\\u0e15\\u0e19\\u0e4c\",\"lastname\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"gender\":\"male\",\"phone\":\"081-901-2345\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":121}}', '2026-04-06 23:22:06', '2026-04-06 23:22:06'),
(601, NULL, 'hr', 'สร้างพนักงาน: WH-002 สมบัติ เบิกจ่าย (ID: 122)', 'App\\Models\\Employee', 122, '{\"attributes\":{\"department_id\":211,\"position_id\":107,\"employee_code\":\"WH-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e1a\\u0e31\\u0e15\\u0e34\",\"lastname\":\"\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e08\\u0e48\\u0e32\\u0e22\",\"gender\":\"male\",\"phone\":\"097-012-3456\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":122}}', '2026-04-06 23:22:06', '2026-04-06 23:22:06'),
(602, NULL, 'hr', 'สร้างพนักงาน: ADM-001 ผู้ดูแล ระบบ (ID: 123)', 'App\\Models\\Employee', 123, '{\"attributes\":{\"department_id\":210,\"position_id\":106,\"employee_code\":\"ADM-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e1c\\u0e39\\u0e49\\u0e14\\u0e39\\u0e41\\u0e25\",\"lastname\":\"\\u0e23\\u0e30\\u0e1a\\u0e1a\",\"gender\":\"female\",\"phone\":\"080-111-2222\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":123}}', '2026-04-06 23:22:06', '2026-04-06 23:22:06'),
(603, NULL, 'hr', 'สร้างพนักงาน: HR-001 กัลยา บุคคล (ID: 124)', 'App\\Models\\Employee', 124, '{\"attributes\":{\"department_id\":210,\"position_id\":106,\"employee_code\":\"HR-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e01\\u0e31\\u0e25\\u0e22\\u0e32\",\"lastname\":\"\\u0e1a\\u0e38\\u0e04\\u0e04\\u0e25\",\"gender\":\"female\",\"phone\":\"089-222-3333\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":124}}', '2026-04-06 23:22:06', '2026-04-06 23:22:06'),
(604, NULL, 'hr', 'สร้างพนักงาน: ACC-001 พิชชา การเงิน (ID: 125)', 'App\\Models\\Employee', 125, '{\"attributes\":{\"department_id\":210,\"position_id\":106,\"employee_code\":\"ACC-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e0a\\u0e0a\\u0e32\",\"lastname\":\"\\u0e01\\u0e32\\u0e23\\u0e40\\u0e07\\u0e34\\u0e19\",\"gender\":\"female\",\"phone\":\"062-333-4444\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":125}}', '2026-04-06 23:22:07', '2026-04-06 23:22:07'),
(605, NULL, 'hr', 'สร้างพนักงาน: ACC-002 ธนวัตต์ โอว้าว (ID: 126)', 'App\\Models\\Employee', 126, '{\"attributes\":{\"department_id\":210,\"position_id\":106,\"employee_code\":\"ACC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e27\\u0e31\\u0e15\\u0e15\\u0e4c\",\"lastname\":\"\\u0e42\\u0e2d\\u0e27\\u0e49\\u0e32\\u0e27\",\"gender\":\"male\",\"phone\":\"083-444-5555\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":126}}', '2026-04-06 23:22:07', '2026-04-06 23:22:07'),
(606, NULL, 'hr', 'ลบพนักงาน: ADM-001 ผู้ดูแล ระบบ (ID: 123)', 'App\\Models\\Employee', 123, '{\"attributes\":{\"id\":123,\"department_id\":210,\"position_id\":106,\"employee_code\":\"ADM-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e1c\\u0e39\\u0e49\\u0e14\\u0e39\\u0e41\\u0e25\",\"lastname\":\"\\u0e23\\u0e30\\u0e1a\\u0e1a\",\"gender\":\"female\",\"phone\":\"080-111-2222\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(607, NULL, 'hr', 'ลบพนักงาน: HR-001 กัลยา บุคคล (ID: 124)', 'App\\Models\\Employee', 124, '{\"attributes\":{\"id\":124,\"department_id\":210,\"position_id\":106,\"employee_code\":\"HR-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e01\\u0e31\\u0e25\\u0e22\\u0e32\",\"lastname\":\"\\u0e1a\\u0e38\\u0e04\\u0e04\\u0e25\",\"gender\":\"female\",\"phone\":\"089-222-3333\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(608, NULL, 'hr', 'ลบพนักงาน: ACC-001 พิชชา การเงิน (ID: 125)', 'App\\Models\\Employee', 125, '{\"attributes\":{\"id\":125,\"department_id\":210,\"position_id\":106,\"employee_code\":\"ACC-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e0a\\u0e0a\\u0e32\",\"lastname\":\"\\u0e01\\u0e32\\u0e23\\u0e40\\u0e07\\u0e34\\u0e19\",\"gender\":\"female\",\"phone\":\"062-333-4444\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(609, NULL, 'hr', 'ลบพนักงาน: ACC-002 ธนวัตต์ โอว้าว (ID: 126)', 'App\\Models\\Employee', 126, '{\"attributes\":{\"id\":126,\"department_id\":210,\"position_id\":106,\"employee_code\":\"ACC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e27\\u0e31\\u0e15\\u0e15\\u0e4c\",\"lastname\":\"\\u0e42\\u0e2d\\u0e27\\u0e49\\u0e32\\u0e27\",\"gender\":\"male\",\"phone\":\"083-444-5555\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(610, NULL, 'hr', 'ลบพนักงาน: WH-001 วิรัตน์ คลังสินค้า (ID: 121)', 'App\\Models\\Employee', 121, '{\"attributes\":{\"id\":121,\"department_id\":211,\"position_id\":107,\"employee_code\":\"WH-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e23\\u0e31\\u0e15\\u0e19\\u0e4c\",\"lastname\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"gender\":\"male\",\"phone\":\"081-901-2345\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(611, NULL, 'hr', 'ลบพนักงาน: WH-002 สมบัติ เบิกจ่าย (ID: 122)', 'App\\Models\\Employee', 122, '{\"attributes\":{\"id\":122,\"department_id\":211,\"position_id\":107,\"employee_code\":\"WH-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e1a\\u0e31\\u0e15\\u0e34\",\"lastname\":\"\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e08\\u0e48\\u0e32\\u0e22\",\"gender\":\"male\",\"phone\":\"097-012-3456\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(612, NULL, 'hr', 'ลบพนักงาน: SAL-001 สมชาย วงศ์สวัสดิ์ (ID: 103)', 'App\\Models\\Employee', 103, '{\"attributes\":{\"id\":103,\"department_id\":222,\"position_id\":115,\"employee_code\":\"SAL-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e0a\\u0e32\\u0e22\",\"lastname\":\"\\u0e27\\u0e07\\u0e28\\u0e4c\\u0e2a\\u0e27\\u0e31\\u0e2a\\u0e14\\u0e34\\u0e4c\",\"gender\":\"male\",\"phone\":\"081-234-5678\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(613, NULL, 'hr', 'ลบพนักงาน: SAL-003 ธนกร รัตนชัย (ID: 105)', 'App\\Models\\Employee', 105, '{\"attributes\":{\"id\":105,\"department_id\":222,\"position_id\":115,\"employee_code\":\"SAL-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e01\\u0e23\",\"lastname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e0a\\u0e31\\u0e22\",\"gender\":\"male\",\"phone\":\"062-345-6789\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(614, NULL, 'hr', 'ลบพนักงาน: SAL-002 สุภาวดี จันทร์เพ็ญ (ID: 104)', 'App\\Models\\Employee', 104, '{\"attributes\":{\"id\":104,\"department_id\":222,\"position_id\":116,\"employee_code\":\"SAL-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e2a\\u0e38\\u0e20\\u0e32\\u0e27\\u0e14\\u0e35\",\"lastname\":\"\\u0e08\\u0e31\\u0e19\\u0e17\\u0e23\\u0e4c\\u0e40\\u0e1e\\u0e47\\u0e0d\",\"gender\":\"female\",\"phone\":\"089-876-5432\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(615, NULL, 'hr', 'ลบพนักงาน: ENG-001 กิตติ พัฒนาพงศ์ (ID: 106)', 'App\\Models\\Employee', 106, '{\"attributes\":{\"id\":106,\"department_id\":223,\"position_id\":117,\"employee_code\":\"ENG-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e01\\u0e34\\u0e15\\u0e15\\u0e34\",\"lastname\":\"\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e32\\u0e1e\\u0e07\\u0e28\\u0e4c\",\"gender\":\"male\",\"phone\":\"083-456-7890\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(616, NULL, 'hr', 'ลบพนักงาน: ENG-003 พิมพ์ใจ สุขสมบูรณ์ (ID: 108)', 'App\\Models\\Employee', 108, '{\"attributes\":{\"id\":108,\"department_id\":223,\"position_id\":117,\"employee_code\":\"ENG-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e21\\u0e1e\\u0e4c\\u0e43\\u0e08\",\"lastname\":\"\\u0e2a\\u0e38\\u0e02\\u0e2a\\u0e21\\u0e1a\\u0e39\\u0e23\\u0e13\\u0e4c\",\"gender\":\"female\",\"phone\":\"087-678-9012\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(617, NULL, 'hr', 'ลบพนักงาน: ENG-002 วิชัย แก้วมณี (ID: 107)', 'App\\Models\\Employee', 107, '{\"attributes\":{\"id\":107,\"department_id\":223,\"position_id\":118,\"employee_code\":\"ENG-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e41\\u0e01\\u0e49\\u0e27\\u0e21\\u0e13\\u0e35\",\"gender\":\"male\",\"phone\":\"095-567-8901\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(618, NULL, 'hr', 'ลบพนักงาน: PRD-001 ประสิทธิ์ การช่าง (ID: 109)', 'App\\Models\\Employee', 109, '{\"attributes\":{\"id\":109,\"department_id\":224,\"position_id\":119,\"employee_code\":\"PRD-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1b\\u0e23\\u0e30\\u0e2a\\u0e34\\u0e17\\u0e18\\u0e34\\u0e4c\",\"lastname\":\"\\u0e01\\u0e32\\u0e23\\u0e0a\\u0e48\\u0e32\\u0e07\",\"gender\":\"male\",\"phone\":\"084-789-0123\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(619, NULL, 'hr', 'ลบพนักงาน: PRD-003 บุญมี ช่างเชื่อม (ID: 111)', 'App\\Models\\Employee', 111, '{\"attributes\":{\"id\":111,\"department_id\":224,\"position_id\":119,\"employee_code\":\"PRD-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1a\\u0e38\\u0e0d\\u0e21\\u0e35\",\"lastname\":\"\\u0e0a\\u0e48\\u0e32\\u0e07\\u0e40\\u0e0a\\u0e37\\u0e48\\u0e2d\\u0e21\",\"gender\":\"male\",\"phone\":\"063-901-2345\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(620, NULL, 'hr', 'ลบพนักงาน: PRD-004 สุรชัย ประกอบกิจ (ID: 112)', 'App\\Models\\Employee', 112, '{\"attributes\":{\"id\":112,\"department_id\":224,\"position_id\":119,\"employee_code\":\"PRD-004\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e38\\u0e23\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e1b\\u0e23\\u0e30\\u0e01\\u0e2d\\u0e1a\\u0e01\\u0e34\\u0e08\",\"gender\":\"male\",\"phone\":\"088-012-3456\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(621, NULL, 'hr', 'ลบพนักงาน: PRD-005 อภิชาติ ผลิตผล (ID: 113)', 'App\\Models\\Employee', 113, '{\"attributes\":{\"id\":113,\"department_id\":224,\"position_id\":119,\"employee_code\":\"PRD-005\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e20\\u0e34\\u0e0a\\u0e32\\u0e15\\u0e34\",\"lastname\":\"\\u0e1c\\u0e25\\u0e34\\u0e15\\u0e1c\\u0e25\",\"gender\":\"male\",\"phone\":\"092-123-4567\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(622, NULL, 'hr', 'ลบพนักงาน: PRD-002 มงคล เหล็กกล้า (ID: 110)', 'App\\Models\\Employee', 110, '{\"attributes\":{\"id\":110,\"department_id\":224,\"position_id\":120,\"employee_code\":\"PRD-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e21\\u0e07\\u0e04\\u0e25\",\"lastname\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e01\\u0e25\\u0e49\\u0e32\",\"gender\":\"male\",\"phone\":\"091-890-1234\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(623, NULL, 'hr', 'ลบพนักงาน: QC-001 ชัยวัฒน์ ตรวจดี (ID: 114)', 'App\\Models\\Employee', 114, '{\"attributes\":{\"id\":114,\"department_id\":225,\"position_id\":121,\"employee_code\":\"QC-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e0a\\u0e31\\u0e22\\u0e27\\u0e31\\u0e12\\u0e19\\u0e4c\",\"lastname\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e14\\u0e35\",\"gender\":\"male\",\"phone\":\"085-234-5678\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(624, NULL, 'hr', 'ลบพนักงาน: QC-002 รัตนา คุณภาพ (ID: 115)', 'App\\Models\\Employee', 115, '{\"attributes\":{\"id\":115,\"department_id\":225,\"position_id\":121,\"employee_code\":\"QC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e32\",\"lastname\":\"\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"gender\":\"female\",\"phone\":\"096-345-6789\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(625, NULL, 'hr', 'ลบพนักงาน: SIT-001 พีรพัฒน์ หน้างาน (ID: 116)', 'App\\Models\\Employee', 116, '{\"attributes\":{\"id\":116,\"department_id\":226,\"position_id\":122,\"employee_code\":\"SIT-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1e\\u0e35\\u0e23\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e4c\",\"lastname\":\"\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"086-456-7890\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(626, NULL, 'hr', 'ลบพนักงาน: SIT-003 ธนพล ไซต์งาน (ID: 118)', 'App\\Models\\Employee', 118, '{\"attributes\":{\"id\":118,\"department_id\":226,\"position_id\":122,\"employee_code\":\"SIT-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e1e\\u0e25\",\"lastname\":\"\\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"064-678-9012\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(627, NULL, 'hr', 'ลบพนักงาน: SIT-002 อนุชา ติดตั้ง (ID: 117)', 'App\\Models\\Employee', 117, '{\"attributes\":{\"id\":117,\"department_id\":226,\"position_id\":123,\"employee_code\":\"SIT-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e19\\u0e38\\u0e0a\\u0e32\",\"lastname\":\"\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\",\"gender\":\"male\",\"phone\":\"093-567-8901\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(628, NULL, 'hr', 'ลบพนักงาน: PUR-001 จิดาภา จัดซื้อ (ID: 119)', 'App\\Models\\Employee', 119, '{\"attributes\":{\"id\":119,\"department_id\":227,\"position_id\":124,\"employee_code\":\"PUR-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e08\\u0e34\\u0e14\\u0e32\\u0e20\\u0e32\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"gender\":\"female\",\"phone\":\"082-789-0123\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(629, NULL, 'hr', 'ลบพนักงาน: PUR-002  กรกฎ หามา (ID: 120)', 'App\\Models\\Employee', 120, '{\"attributes\":{\"id\":120,\"department_id\":227,\"position_id\":124,\"employee_code\":\"PUR-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\" \\u0e01\\u0e23\\u0e01\\u0e0e\",\"lastname\":\"\\u0e2b\\u0e32\\u0e21\\u0e32\",\"gender\":\"male\",\"phone\":\"094-890-1234\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(630, NULL, 'hr', 'ลบตำแหน่ง: System Administrator (ID: 106)', 'App\\Models\\Position', 106, '{\"attributes\":{\"id\":106,\"department_id\":210,\"name\":\"System Administrator\",\"job_description\":\"Manage system\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(631, NULL, 'hr', 'ลบตำแหน่ง: เจ้าหน้าที่คลังสินค้า (ID: 107)', 'App\\Models\\Position', 107, '{\"attributes\":{\"id\":107,\"department_id\":211,\"name\":\"\\u0e40\\u0e08\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e17\\u0e35\\u0e48\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"job_description\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e23\\u0e31\\u0e1a-\\u0e08\\u0e48\\u0e32\\u0e22\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(632, NULL, 'hr', 'ลบตำแหน่ง: หัวหน้าคลังสินค้า (ID: 108)', 'App\\Models\\Position', 108, '{\"attributes\":{\"id\":108,\"department_id\":211,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u548c\\u7ba1\\u7406\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e17\\u0e31\\u0e49\\u0e07\\u0e2b\\u0e21\\u0e14\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(633, NULL, 'hr', 'ลบตำแหน่ง: ผู้จัดการฝ่ายบริหาร (ID: 109)', 'App\\Models\\Position', 109, '{\"attributes\":{\"id\":109,\"department_id\":212,\"name\":\"\\u0e1c\\u0e39\\u0e49\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"job_description\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e41\\u0e25\\u0e30\\u0e27\\u0e32\\u0e07\\u0e41\\u0e1c\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(634, NULL, 'hr', 'ลบตำแหน่ง: เจ้าหน้าที่บริหาร (ID: 110)', 'App\\Models\\Position', 110, '{\"attributes\":{\"id\":110,\"department_id\":212,\"name\":\"\\u0e40\\u0e08\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e17\\u0e35\\u0e48\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"job_description\":\"\\u0e2a\\u0e19\\u0e31\\u0e1a\\u0e2a\\u0e19\\u0e38\\u0e19\\u0e07\\u0e32\\u0e19\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(635, NULL, 'hr', 'ลบตำแหน่ง: พนักงานทั่วไป (ID: 111)', 'App\\Models\\Position', 111, '{\"attributes\":{\"id\":111,\"department_id\":213,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\",\"job_description\":\"\\u0e1b\\u0e0f\\u0e34\\u0e1a\\u0e31\\u0e15\\u0e34\\u0e07\\u0e32\\u0e19\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\\u0e41\\u0e25\\u0e30\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(636, NULL, 'hr', 'ลบตำแหน่ง: หัวหน้างาน (ID: 112)', 'App\\Models\\Position', 112, '{\"attributes\":{\"id\":112,\"department_id\":213,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e41\\u0e25\\u0e30\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\\u0e01\\u0e32\\u0e23\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(637, NULL, 'hr', 'ลบตำแหน่ง: พนักงานขาย (ID: 115)', 'App\\Models\\Position', 115, '{\"attributes\":{\"id\":115,\"department_id\":222,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e02\\u0e32\\u0e22\",\"job_description\":\"\\u0e1b\\u0e0f\\u0e34\\u0e1a\\u0e31\\u0e15\\u0e34\\u0e07\\u0e32\\u0e19\\u0e02\\u0e32\\u0e22\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(638, NULL, 'hr', 'ลบตำแหน่ง: หัวหน้าพนักงานขาย (ID: 116)', 'App\\Models\\Position', 116, '{\"attributes\":{\"id\":116,\"department_id\":222,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e02\\u0e32\\u0e22\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e17\\u0e35\\u0e21\\u0e02\\u0e32\\u0e22\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(639, NULL, 'hr', 'ลบตำแหน่ง: พนักงานฝ่ายเทคนิค (ID: 117)', 'App\\Models\\Position', 117, '{\"attributes\":{\"id\":117,\"department_id\":223,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"job_description\":\"\\u0e07\\u0e32\\u0e19\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(640, NULL, 'hr', 'ลบตำแหน่ง: หัวหน้าฝ่ายเทคนิค (ID: 118)', 'App\\Models\\Position', 118, '{\"attributes\":{\"id\":118,\"department_id\":223,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e17\\u0e35\\u0e21\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(641, NULL, 'hr', 'ลบตำแหน่ง: พนักงานฝ่ายผลิต (ID: 119)', 'App\\Models\\Position', 119, '{\"attributes\":{\"id\":119,\"department_id\":224,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1c\\u0e25\\u0e34\\u0e15\",\"job_description\":\"\\u0e07\\u0e32\\u0e19\\u0e1c\\u0e25\\u0e34\\u0e15\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(642, NULL, 'hr', 'ลบตำแหน่ง: หัวหน้าฝ่ายผลิต (ID: 120)', 'App\\Models\\Position', 120, '{\"attributes\":{\"id\":120,\"department_id\":224,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1c\\u0e25\\u0e34\\u0e15\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e17\\u0e35\\u0e21\\u0e1c\\u0e25\\u0e34\\u0e15\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(643, NULL, 'hr', 'ลบตำแหน่ง: พนักงานฝ่าย QC (ID: 121)', 'App\\Models\\Position', 121, '{\"attributes\":{\"id\":121,\"department_id\":225,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22 QC\",\"job_description\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(644, NULL, 'hr', 'ลบตำแหน่ง: พนักงานหน้างาน (ID: 122)', 'App\\Models\\Position', 122, '{\"attributes\":{\"id\":122,\"department_id\":226,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"job_description\":\"\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(645, NULL, 'hr', 'ลบตำแหน่ง: หัวหน้าหน้างาน (ID: 123)', 'App\\Models\\Position', 123, '{\"attributes\":{\"id\":123,\"department_id\":226,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(646, NULL, 'hr', 'ลบตำแหน่ง: พนักงานจัดซื้อ (ID: 124)', 'App\\Models\\Position', 124, '{\"attributes\":{\"id\":124,\"department_id\":227,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"job_description\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\\u0e08\\u0e31\\u0e14\\u0e08\\u0e49\\u0e32\\u0e07\"}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(647, NULL, 'hr', 'ลบแผนก: Administration (ID: 210)', 'App\\Models\\Department', 210, '{\"attributes\":{\"id\":210,\"name\":\"Administration\",\"description\":\"Admin Department\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(648, NULL, 'hr', 'ลบแผนก: คลังสินค้า (ID: 211)', 'App\\Models\\Department', 211, '{\"attributes\":{\"id\":211,\"name\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"description\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(649, NULL, 'hr', 'ลบแผนก: บริหาร (ID: 212)', 'App\\Models\\Department', 212, '{\"attributes\":{\"id\":212,\"name\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"description\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e41\\u0e25\\u0e30\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(650, NULL, 'hr', 'ลบแผนก: พนักงานทั่วไป (ID: 213)', 'App\\Models\\Department', 213, '{\"attributes\":{\"id\":213,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\",\"description\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e17\\u0e35\\u0e48\\u0e21\\u0e32\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(651, NULL, 'hr', 'ลบแผนก: ฝ่ายขาย (ID: 214)', 'App\\Models\\Department', 214, '{\"attributes\":{\"id\":214,\"name\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e02\\u0e32\\u0e22\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e02\\u0e32\\u0e22\\u0e41\\u0e25\\u0e30\\u0e01\\u0e32\\u0e23\\u0e15\\u0e25\\u0e32\\u0e14\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(652, NULL, 'hr', 'ลบแผนก: วิศวกรรม (ID: 215)', 'App\\Models\\Department', 215, '{\"attributes\":{\"id\":215,\"name\":\"\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\\u0e41\\u0e25\\u0e30\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(653, NULL, 'hr', 'ลบแผนก: การผลิต (ID: 216)', 'App\\Models\\Department', 216, '{\"attributes\":{\"id\":216,\"name\":\"\\u0e01\\u0e32\\u0e23\\u0e1c\\u0e25\\u0e34\\u0e15\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e1c\\u0e25\\u0e34\\u0e15\\u0e41\\u0e25\\u0e30\\u0e1b\\u0e23\\u0e30\\u0e01\\u0e2d\\u0e1a\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(654, NULL, 'hr', 'ลบแผนก: QC (ID: 217)', 'App\\Models\\Department', 217, '{\"attributes\":{\"id\":217,\"name\":\"QC\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(655, NULL, 'hr', 'ลบแผนก: หน้างาน (ID: 218)', 'App\\Models\\Department', 218, '{\"attributes\":{\"id\":218,\"name\":\"\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\\u0e41\\u0e25\\u0e30\\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(656, NULL, 'hr', 'ลบแผนก: จัดซื้อ (ID: 219)', 'App\\Models\\Department', 219, '{\"attributes\":{\"id\":219,\"name\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(657, NULL, 'hr', 'ลบแผนก: คลังสินค้า (ID: 220)', 'App\\Models\\Department', 220, '{\"attributes\":{\"id\":220,\"name\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e08\\u0e48\\u0e32\\u0e22\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(658, NULL, 'hr', 'ลบแผนก: บริหาร (ID: 221)', 'App\\Models\\Department', 221, '{\"attributes\":{\"id\":221,\"name\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"description\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(659, NULL, 'hr', 'ลบแผนก: ฝ่ายขาย (ID: 222)', 'App\\Models\\Department', 222, '{\"attributes\":{\"id\":222,\"name\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e02\\u0e32\\u0e22\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e02\\u0e32\\u0e22\\u0e41\\u0e25\\u0e30\\u0e01\\u0e32\\u0e23\\u0e15\\u0e25\\u0e32\\u0e14\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(660, NULL, 'hr', 'ลบแผนก: วิศวกรรม (ID: 223)', 'App\\Models\\Department', 223, '{\"attributes\":{\"id\":223,\"name\":\"\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\\u0e41\\u0e25\\u0e30\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(661, NULL, 'hr', 'ลบแผนก: การผลิต (ID: 224)', 'App\\Models\\Department', 224, '{\"attributes\":{\"id\":224,\"name\":\"\\u0e01\\u0e32\\u0e23\\u0e1c\\u0e25\\u0e34\\u0e15\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e1c\\u0e25\\u0e34\\u0e15\\u0e41\\u0e25\\u0e30\\u0e1b\\u0e23\\u0e30\\u0e01\\u0e2d\\u0e1a\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(662, NULL, 'hr', 'ลบแผนก: QC (ID: 225)', 'App\\Models\\Department', 225, '{\"attributes\":{\"id\":225,\"name\":\"QC\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(663, NULL, 'hr', 'ลบแผนก: หน้างาน (ID: 226)', 'App\\Models\\Department', 226, '{\"attributes\":{\"id\":226,\"name\":\"\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\\u0e41\\u0e25\\u0e30\\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(664, NULL, 'hr', 'ลบแผนก: จัดซื้อ (ID: 227)', 'App\\Models\\Department', 227, '{\"attributes\":{\"id\":227,\"name\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(665, NULL, 'hr', 'ลบแผนก: คลังสินค้า (ID: 228)', 'App\\Models\\Department', 228, '{\"attributes\":{\"id\":228,\"name\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e08\\u0e48\\u0e32\\u0e22\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(666, NULL, 'hr', 'ลบแผนก: บริหาร (ID: 229)', 'App\\Models\\Department', 229, '{\"attributes\":{\"id\":229,\"name\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"description\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"next_department_id\":null}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(667, NULL, 'hr', 'สร้างแผนก: บริหาร (ID: 1)', 'App\\Models\\Department', 1, '{\"attributes\":{\"name\":\"\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"description\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e41\\u0e25\\u0e30\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\",\"id\":1}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(668, NULL, 'hr', 'สร้างแผนก: ฝ่ายขาย (ID: 2)', 'App\\Models\\Department', 2, '{\"attributes\":{\"name\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e02\\u0e32\\u0e22\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e02\\u0e32\\u0e22\\u0e41\\u0e25\\u0e30\\u0e01\\u0e32\\u0e23\\u0e15\\u0e25\\u0e32\\u0e14\",\"id\":2}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(669, NULL, 'hr', 'สร้างแผนก: วิศวกรรม (ID: 3)', 'App\\Models\\Department', 3, '{\"attributes\":{\"name\":\"\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\\u0e41\\u0e25\\u0e30\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"id\":3}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(670, NULL, 'hr', 'สร้างแผนก: การผลิต (ID: 4)', 'App\\Models\\Department', 4, '{\"attributes\":{\"name\":\"\\u0e01\\u0e32\\u0e23\\u0e1c\\u0e25\\u0e34\\u0e15\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e1c\\u0e25\\u0e34\\u0e15\\u0e41\\u0e25\\u0e30\\u0e1b\\u0e23\\u0e30\\u0e01\\u0e2d\\u0e1a\",\"id\":4}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(671, NULL, 'hr', 'สร้างแผนก: QC (ID: 5)', 'App\\Models\\Department', 5, '{\"attributes\":{\"name\":\"QC\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"id\":5}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(672, NULL, 'hr', 'สร้างแผนก: หน้างาน (ID: 6)', 'App\\Models\\Department', 6, '{\"attributes\":{\"name\":\"\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\\u0e41\\u0e25\\u0e30\\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19\",\"id\":6}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(673, NULL, 'hr', 'สร้างแผนก: จัดซื้อ (ID: 7)', 'App\\Models\\Department', 7, '{\"attributes\":{\"name\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"description\":\"\\u0e41\\u0e1c\\u0e19\\u0e01\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"id\":7}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(674, NULL, 'hr', 'สร้างแผนก: คลังสินค้า (ID: 8)', 'App\\Models\\Department', 8, '{\"attributes\":{\"name\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"description\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"id\":8}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(675, NULL, 'hr', 'สร้างแผนก: บุคคล (ID: 9)', 'App\\Models\\Department', 9, '{\"attributes\":{\"name\":\"\\u0e1a\\u0e38\\u0e04\\u0e04\\u0e25\",\"description\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e38\\u0e04\\u0e04\\u0e25\\u0e41\\u0e25\\u0e30\\u0e17\\u0e23\\u0e31\\u0e1e\\u0e22\\u0e32\\u0e01\\u0e23\\u0e1a\\u0e38\\u0e04\\u0e04\\u0e25\",\"id\":9}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(676, NULL, 'hr', 'สร้างแผนก: บัญชี (ID: 10)', 'App\\Models\\Department', 10, '{\"attributes\":{\"name\":\"\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\",\"description\":\"\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\\u0e41\\u0e25\\u0e30\\u0e01\\u0e32\\u0e23\\u0e40\\u0e07\\u0e34\\u0e19\",\"id\":10}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(677, NULL, 'hr', 'สร้างตำแหน่ง: ผู้จัดการฝ่ายบริหาร (ID: 1)', 'App\\Models\\Position', 1, '{\"attributes\":{\"department_id\":1,\"name\":\"\\u0e1c\\u0e39\\u0e49\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"job_description\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e41\\u0e25\\u0e30\\u0e27\\u0e32\\u0e07\\u0e41\\u0e1c\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"id\":1}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(678, NULL, 'hr', 'สร้างตำแหน่ง: เจ้าหน้าที่บริหาร (ID: 2)', 'App\\Models\\Position', 2, '{\"attributes\":{\"department_id\":1,\"name\":\"\\u0e40\\u0e08\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e17\\u0e35\\u0e48\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\",\"job_description\":\"\\u0e2a\\u0e19\\u0e31\\u0e1a\\u0e2a\\u0e19\\u0e38\\u0e19\\u0e07\\u0e32\\u0e19\\u0e1a\\u0e23\\u0e34\\u0e2b\\u0e32\\u0e23\\u0e17\\u0e31\\u0e48\\u0e27\\u0e44\\u0e1b\",\"id\":2}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(679, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานขาย (ID: 3)', 'App\\Models\\Position', 3, '{\"attributes\":{\"department_id\":2,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e02\\u0e32\\u0e22\",\"job_description\":\"\\u0e1b\\u0e0f\\u0e34\\u0e1a\\u0e31\\u0e15\\u0e34\\u0e07\\u0e32\\u0e19\\u0e02\\u0e32\\u0e22\",\"id\":3}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(680, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าพนักงานขาย (ID: 4)', 'App\\Models\\Position', 4, '{\"attributes\":{\"department_id\":2,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e02\\u0e32\\u0e22\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e17\\u0e35\\u0e21\\u0e02\\u0e32\\u0e22\",\"id\":4}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(681, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานฝ่ายเทคนิค (ID: 5)', 'App\\Models\\Position', 5, '{\"attributes\":{\"department_id\":3,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"job_description\":\"\\u0e07\\u0e32\\u0e19\\u0e27\\u0e34\\u0e28\\u0e27\\u0e01\\u0e23\\u0e23\\u0e21\",\"id\":5}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(682, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าฝ่ายเทคนิค (ID: 6)', 'App\\Models\\Position', 6, '{\"attributes\":{\"department_id\":3,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e17\\u0e35\\u0e21\\u0e40\\u0e17\\u0e04\\u0e19\\u0e34\\u0e04\",\"id\":6}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(683, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานฝ่ายผลิต (ID: 7)', 'App\\Models\\Position', 7, '{\"attributes\":{\"department_id\":4,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1c\\u0e25\\u0e34\\u0e15\",\"job_description\":\"\\u0e07\\u0e32\\u0e19\\u0e1c\\u0e25\\u0e34\\u0e15\",\"id\":7}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(684, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าฝ่ายผลิต (ID: 8)', 'App\\Models\\Position', 8, '{\"attributes\":{\"department_id\":4,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e1d\\u0e48\\u0e32\\u0e22\\u0e1c\\u0e25\\u0e34\\u0e15\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e17\\u0e35\\u0e21\\u0e1c\\u0e25\\u0e34\\u0e15\",\"id\":8}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(685, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานฝ่าย QC (ID: 9)', 'App\\Models\\Position', 9, '{\"attributes\":{\"department_id\":5,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e1d\\u0e48\\u0e32\\u0e22 QC\",\"job_description\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"id\":9}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(686, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานหน้างาน (ID: 10)', 'App\\Models\\Position', 10, '{\"attributes\":{\"department_id\":6,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"job_description\":\"\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"id\":10}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(687, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าหน้างาน (ID: 11)', 'App\\Models\\Position', 11, '{\"attributes\":{\"department_id\":6,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"id\":11}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(688, NULL, 'hr', 'สร้างตำแหน่ง: พนักงานจัดซื้อ (ID: 12)', 'App\\Models\\Position', 12, '{\"attributes\":{\"department_id\":7,\"name\":\"\\u0e1e\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"job_description\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\\u0e08\\u0e31\\u0e14\\u0e08\\u0e49\\u0e32\\u0e07\",\"id\":12}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(689, NULL, 'hr', 'สร้างตำแหน่ง: เจ้าหน้าที่คลังสินค้า (ID: 13)', 'App\\Models\\Position', 13, '{\"attributes\":{\"department_id\":8,\"name\":\"\\u0e40\\u0e08\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e17\\u0e35\\u0e48\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"job_description\":\"\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e23\\u0e31\\u0e1a-\\u0e08\\u0e48\\u0e32\\u0e22\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e41\\u0e25\\u0e30\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e2a\\u0e15\\u0e4a\\u0e2d\\u0e01\",\"id\":13}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(690, NULL, 'hr', 'สร้างตำแหน่ง: หัวหน้าคลังสินค้า (ID: 14)', 'App\\Models\\Position', 14, '{\"attributes\":{\"department_id\":8,\"name\":\"\\u0e2b\\u0e31\\u0e27\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e41\\u0e25\\u0e30\\u0e08\\u0e31\\u0e14\\u0e01\\u0e32\\u0e23\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\\u0e17\\u0e31\\u0e49\\u0e07\\u0e2b\\u0e21\\u0e14\",\"id\":14}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(691, NULL, 'hr', 'สร้างตำแหน่ง: เจ้าหน้าที่ HR (ID: 15)', 'App\\Models\\Position', 15, '{\"attributes\":{\"department_id\":9,\"name\":\"\\u0e40\\u0e08\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e17\\u0e35\\u0e48 HR\",\"job_description\":\"\\u0e07\\u0e32\\u0e19\\u0e1a\\u0e38\\u0e04\\u0e04\\u0e25\",\"id\":15}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(692, NULL, 'hr', 'สร้างตำแหน่ง: เจ้าหน้าที่บัญชี (ID: 16)', 'App\\Models\\Position', 16, '{\"attributes\":{\"department_id\":10,\"name\":\"\\u0e40\\u0e08\\u0e49\\u0e32\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e17\\u0e35\\u0e48\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\",\"job_description\":\"\\u0e07\\u0e32\\u0e19\\u0e01\\u0e32\\u0e23\\u0e40\\u0e07\\u0e34\\u0e19\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\",\"id\":16}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(693, NULL, 'hr', 'สร้างตำแหน่ง: System Administrator (ID: 17)', 'App\\Models\\Position', 17, '{\"attributes\":{\"department_id\":1,\"name\":\"System Administrator\",\"job_description\":\"\\u0e14\\u0e39\\u0e41\\u0e25\\u0e23\\u0e30\\u0e1a\\u0e1a\",\"id\":17}}', '2026-04-06 23:38:15', '2026-04-06 23:38:15'),
(694, NULL, 'hr', 'สร้างพนักงาน: SAL-001 สมชาย วงศ์สวัสดิ์ (ID: 1)', 'App\\Models\\Employee', 1, '{\"attributes\":{\"department_id\":2,\"position_id\":3,\"employee_code\":\"SAL-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e0a\\u0e32\\u0e22\",\"lastname\":\"\\u0e27\\u0e07\\u0e28\\u0e4c\\u0e2a\\u0e27\\u0e31\\u0e2a\\u0e14\\u0e34\\u0e4c\",\"gender\":\"male\",\"phone\":\"081-234-5678\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":1}}', '2026-04-06 23:39:08', '2026-04-06 23:39:08'),
(695, NULL, 'hr', 'สร้างพนักงาน: SAL-002 สุภาวดี จันทร์เพ็ญ (ID: 2)', 'App\\Models\\Employee', 2, '{\"attributes\":{\"department_id\":2,\"position_id\":4,\"employee_code\":\"SAL-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e2a\\u0e38\\u0e20\\u0e32\\u0e27\\u0e14\\u0e35\",\"lastname\":\"\\u0e08\\u0e31\\u0e19\\u0e17\\u0e23\\u0e4c\\u0e40\\u0e1e\\u0e47\\u0e0d\",\"gender\":\"female\",\"phone\":\"089-876-5432\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":2}}', '2026-04-06 23:39:08', '2026-04-06 23:39:08'),
(696, NULL, 'hr', 'สร้างพนักงาน: SAL-003 ธนกร รัตนชัย (ID: 3)', 'App\\Models\\Employee', 3, '{\"attributes\":{\"department_id\":2,\"position_id\":3,\"employee_code\":\"SAL-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e01\\u0e23\",\"lastname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e0a\\u0e31\\u0e22\",\"gender\":\"male\",\"phone\":\"062-345-6789\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":3}}', '2026-04-06 23:39:08', '2026-04-06 23:39:08'),
(697, NULL, 'hr', 'สร้างพนักงาน: ENG-001 กิตติ พัฒนาพงศ์ (ID: 4)', 'App\\Models\\Employee', 4, '{\"attributes\":{\"department_id\":3,\"position_id\":5,\"employee_code\":\"ENG-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e01\\u0e34\\u0e15\\u0e15\\u0e34\",\"lastname\":\"\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e32\\u0e1e\\u0e07\\u0e28\\u0e4c\",\"gender\":\"male\",\"phone\":\"083-456-7890\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":4}}', '2026-04-06 23:39:08', '2026-04-06 23:39:08'),
(698, NULL, 'hr', 'สร้างพนักงาน: ENG-002 วิชัย แก้วมณี (ID: 5)', 'App\\Models\\Employee', 5, '{\"attributes\":{\"department_id\":3,\"position_id\":6,\"employee_code\":\"ENG-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e41\\u0e01\\u0e49\\u0e27\\u0e21\\u0e13\\u0e35\",\"gender\":\"male\",\"phone\":\"095-567-8901\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":5}}', '2026-04-06 23:39:09', '2026-04-06 23:39:09');
INSERT INTO `activity_logs` (`id`, `user_id`, `log_name`, `description`, `subject_type`, `subject_id`, `properties`, `created_at`, `updated_at`) VALUES
(699, NULL, 'hr', 'สร้างพนักงาน: ENG-003 พิมพ์ใจ สุขสมบูรณ์ (ID: 6)', 'App\\Models\\Employee', 6, '{\"attributes\":{\"department_id\":3,\"position_id\":5,\"employee_code\":\"ENG-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e21\\u0e1e\\u0e4c\\u0e43\\u0e08\",\"lastname\":\"\\u0e2a\\u0e38\\u0e02\\u0e2a\\u0e21\\u0e1a\\u0e39\\u0e23\\u0e13\\u0e4c\",\"gender\":\"female\",\"phone\":\"087-678-9012\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":6}}', '2026-04-06 23:39:09', '2026-04-06 23:39:09'),
(700, NULL, 'hr', 'สร้างพนักงาน: PRD-001 ประสิทธิ์ การช่าง (ID: 7)', 'App\\Models\\Employee', 7, '{\"attributes\":{\"department_id\":4,\"position_id\":7,\"employee_code\":\"PRD-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1b\\u0e23\\u0e30\\u0e2a\\u0e34\\u0e17\\u0e18\\u0e34\\u0e4c\",\"lastname\":\"\\u0e01\\u0e32\\u0e23\\u0e0a\\u0e48\\u0e32\\u0e07\",\"gender\":\"male\",\"phone\":\"084-789-0123\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":7}}', '2026-04-06 23:39:09', '2026-04-06 23:39:09'),
(701, NULL, 'hr', 'สร้างพนักงาน: PRD-002 มงคล เหล็กกล้า (ID: 8)', 'App\\Models\\Employee', 8, '{\"attributes\":{\"department_id\":4,\"position_id\":8,\"employee_code\":\"PRD-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e21\\u0e07\\u0e04\\u0e25\",\"lastname\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e01\\u0e25\\u0e49\\u0e32\",\"gender\":\"male\",\"phone\":\"091-890-1234\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":8}}', '2026-04-06 23:39:09', '2026-04-06 23:39:09'),
(702, NULL, 'hr', 'สร้างพนักงาน: PRD-003 บุญมี ช่างเชื่อม (ID: 9)', 'App\\Models\\Employee', 9, '{\"attributes\":{\"department_id\":4,\"position_id\":7,\"employee_code\":\"PRD-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1a\\u0e38\\u0e0d\\u0e21\\u0e35\",\"lastname\":\"\\u0e0a\\u0e48\\u0e32\\u0e07\\u0e40\\u0e0a\\u0e37\\u0e48\\u0e2d\\u0e21\",\"gender\":\"male\",\"phone\":\"063-901-2345\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":9}}', '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(703, NULL, 'hr', 'สร้างพนักงาน: PRD-004 สุรชัย ประกอบกิจ (ID: 10)', 'App\\Models\\Employee', 10, '{\"attributes\":{\"department_id\":4,\"position_id\":7,\"employee_code\":\"PRD-004\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e38\\u0e23\\u0e0a\\u0e31\\u0e22\",\"lastname\":\"\\u0e1b\\u0e23\\u0e30\\u0e01\\u0e2d\\u0e1a\\u0e01\\u0e34\\u0e08\",\"gender\":\"male\",\"phone\":\"088-012-3456\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":10}}', '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(704, NULL, 'hr', 'สร้างพนักงาน: PRD-005 อภิชาติ ผลิตผล (ID: 11)', 'App\\Models\\Employee', 11, '{\"attributes\":{\"department_id\":4,\"position_id\":7,\"employee_code\":\"PRD-005\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e20\\u0e34\\u0e0a\\u0e32\\u0e15\\u0e34\",\"lastname\":\"\\u0e1c\\u0e25\\u0e34\\u0e15\\u0e1c\\u0e25\",\"gender\":\"male\",\"phone\":\"092-123-4567\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":11}}', '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(705, NULL, 'hr', 'สร้างพนักงาน: QC-001 ชัยวัฒน์ ตรวจดี (ID: 12)', 'App\\Models\\Employee', 12, '{\"attributes\":{\"department_id\":5,\"position_id\":9,\"employee_code\":\"QC-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e0a\\u0e31\\u0e22\\u0e27\\u0e31\\u0e12\\u0e19\\u0e4c\",\"lastname\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e14\\u0e35\",\"gender\":\"male\",\"phone\":\"085-234-5678\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":12}}', '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(706, NULL, 'hr', 'สร้างพนักงาน: QC-002 รัตนา คุณภาพ (ID: 13)', 'App\\Models\\Employee', 13, '{\"attributes\":{\"department_id\":5,\"position_id\":9,\"employee_code\":\"QC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e23\\u0e31\\u0e15\\u0e19\\u0e32\",\"lastname\":\"\\u0e04\\u0e38\\u0e13\\u0e20\\u0e32\\u0e1e\",\"gender\":\"female\",\"phone\":\"096-345-6789\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":13}}', '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(707, NULL, 'hr', 'สร้างพนักงาน: SIT-001 พีรพัฒน์ หน้างาน (ID: 14)', 'App\\Models\\Employee', 14, '{\"attributes\":{\"department_id\":6,\"position_id\":10,\"employee_code\":\"SIT-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1e\\u0e35\\u0e23\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e4c\",\"lastname\":\"\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"086-456-7890\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":14}}', '2026-04-06 23:39:11', '2026-04-06 23:39:11'),
(708, NULL, 'hr', 'สร้างพนักงาน: SIT-002 อนุชา ติดตั้ง (ID: 15)', 'App\\Models\\Employee', 15, '{\"attributes\":{\"department_id\":6,\"position_id\":11,\"employee_code\":\"SIT-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2d\\u0e19\\u0e38\\u0e0a\\u0e32\",\"lastname\":\"\\u0e15\\u0e34\\u0e14\\u0e15\\u0e31\\u0e49\\u0e07\",\"gender\":\"male\",\"phone\":\"093-567-8901\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":15}}', '2026-04-06 23:39:11', '2026-04-06 23:39:11'),
(709, NULL, 'hr', 'สร้างพนักงาน: SIT-003 ธนพล ไซต์งาน (ID: 16)', 'App\\Models\\Employee', 16, '{\"attributes\":{\"department_id\":6,\"position_id\":10,\"employee_code\":\"SIT-003\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e1e\\u0e25\",\"lastname\":\"\\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"064-678-9012\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":16}}', '2026-04-06 23:39:11', '2026-04-06 23:39:11'),
(710, NULL, 'hr', 'สร้างพนักงาน: PUR-001 จิดาภา จัดซื้อ (ID: 17)', 'App\\Models\\Employee', 17, '{\"attributes\":{\"department_id\":7,\"position_id\":12,\"employee_code\":\"PUR-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e08\\u0e34\\u0e14\\u0e32\\u0e20\\u0e32\",\"lastname\":\"\\u0e08\\u0e31\\u0e14\\u0e0b\\u0e37\\u0e49\\u0e2d\",\"gender\":\"female\",\"phone\":\"082-789-0123\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":17}}', '2026-04-06 23:39:11', '2026-04-06 23:39:11'),
(711, NULL, 'hr', 'สร้างพนักงาน: PUR-002  กรกฎ หามา (ID: 18)', 'App\\Models\\Employee', 18, '{\"attributes\":{\"department_id\":7,\"position_id\":12,\"employee_code\":\"PUR-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\" \\u0e01\\u0e23\\u0e01\\u0e0e\",\"lastname\":\"\\u0e2b\\u0e32\\u0e21\\u0e32\",\"gender\":\"male\",\"phone\":\"094-890-1234\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":18}}', '2026-04-06 23:39:11', '2026-04-06 23:39:11'),
(712, NULL, 'hr', 'สร้างพนักงาน: WH-001 วิรัตน์ คลังสินค้า (ID: 19)', 'App\\Models\\Employee', 19, '{\"attributes\":{\"department_id\":8,\"position_id\":13,\"employee_code\":\"WH-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e27\\u0e34\\u0e23\\u0e31\\u0e15\\u0e19\\u0e4c\",\"lastname\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e2a\\u0e34\\u0e19\\u0e04\\u0e49\\u0e32\",\"gender\":\"male\",\"phone\":\"081-901-2345\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":19}}', '2026-04-06 23:39:12', '2026-04-06 23:39:12'),
(713, NULL, 'hr', 'สร้างพนักงาน: WH-002 สมบัติ เบิกจ่าย (ID: 20)', 'App\\Models\\Employee', 20, '{\"attributes\":{\"department_id\":8,\"position_id\":13,\"employee_code\":\"WH-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e2a\\u0e21\\u0e1a\\u0e31\\u0e15\\u0e34\",\"lastname\":\"\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e08\\u0e48\\u0e32\\u0e22\",\"gender\":\"male\",\"phone\":\"097-012-3456\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":20}}', '2026-04-06 23:39:12', '2026-04-06 23:39:12'),
(714, NULL, 'hr', 'สร้างพนักงาน: HR-001 กัลยา บุคคล (ID: 21)', 'App\\Models\\Employee', 21, '{\"attributes\":{\"department_id\":9,\"position_id\":15,\"employee_code\":\"HR-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e01\\u0e31\\u0e25\\u0e22\\u0e32\",\"lastname\":\"\\u0e1a\\u0e38\\u0e04\\u0e04\\u0e25\",\"gender\":\"female\",\"phone\":\"089-222-3333\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":21}}', '2026-04-06 23:39:12', '2026-04-06 23:39:12'),
(715, NULL, 'hr', 'สร้างพนักงาน: ACC-001 พิชชา การเงิน (ID: 22)', 'App\\Models\\Employee', 22, '{\"attributes\":{\"department_id\":10,\"position_id\":16,\"employee_code\":\"ACC-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\\u0e2a\\u0e32\\u0e27\",\"firstname\":\"\\u0e1e\\u0e34\\u0e0a\\u0e0a\\u0e32\",\"lastname\":\"\\u0e01\\u0e32\\u0e23\\u0e40\\u0e07\\u0e34\\u0e19\",\"gender\":\"female\",\"phone\":\"062-333-4444\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":22}}', '2026-04-06 23:39:12', '2026-04-06 23:39:12'),
(716, NULL, 'hr', 'สร้างพนักงาน: ACC-002 ธนวัตต์ โอว้าว (ID: 23)', 'App\\Models\\Employee', 23, '{\"attributes\":{\"department_id\":10,\"position_id\":16,\"employee_code\":\"ACC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e27\\u0e31\\u0e15\\u0e15\\u0e4c\",\"lastname\":\"\\u0e42\\u0e2d\\u0e27\\u0e49\\u0e32\\u0e27\",\"gender\":\"male\",\"phone\":\"083-444-5555\",\"start_date\":\"2026-04-01\",\"status\":\"active\",\"id\":23}}', '2026-04-06 23:39:13', '2026-04-06 23:39:13'),
(717, NULL, 'inventory', 'สร้างหมวดหมู่สินค้า: อุปกรณ์สำนักงาน (ID: 49)', 'App\\Models\\ItemCategory', 49, '{\"attributes\":{\"name\":\"\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e2a\\u0e33\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\",\"description\":\"\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e17\\u0e35\\u0e48\\u0e43\\u0e0a\\u0e49\\u0e43\\u0e19\\u0e2a\\u0e33\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\",\"id\":49}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(718, NULL, 'inventory', 'สร้างหมวดหมู่สินค้า: เครื่องมือช่าง (ID: 50)', 'App\\Models\\ItemCategory', 50, '{\"attributes\":{\"name\":\"\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e21\\u0e37\\u0e2d\\u0e0a\\u0e48\\u0e32\\u0e07\",\"description\":\"\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e21\\u0e37\\u0e2d\\u0e41\\u0e25\\u0e30\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e0a\\u0e48\\u0e32\\u0e07\",\"id\":50}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(719, NULL, 'inventory', 'สร้างหมวดหมู่สินค้า: วัสดุสิ้นเปลือง (ID: 51)', 'App\\Models\\ItemCategory', 51, '{\"attributes\":{\"name\":\"\\u0e27\\u0e31\\u0e2a\\u0e14\\u0e38\\u0e2a\\u0e34\\u0e49\\u0e19\\u0e40\\u0e1b\\u0e25\\u0e37\\u0e2d\\u0e07\",\"description\":\"\\u0e27\\u0e31\\u0e2a\\u0e14\\u0e38\\u0e43\\u0e0a\\u0e49\\u0e41\\u0e25\\u0e49\\u0e27\\u0e2b\\u0e21\\u0e14\\u0e44\\u0e1b\",\"id\":51}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(720, NULL, 'inventory', 'สร้างหมวดหมู่สินค้า: อุปกรณ์ไอที (ID: 52)', 'App\\Models\\ItemCategory', 52, '{\"attributes\":{\"name\":\"\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e44\\u0e2d\\u0e17\\u0e35\",\"description\":\"\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e04\\u0e2d\\u0e21\\u0e1e\\u0e34\\u0e27\\u0e40\\u0e15\\u0e2d\\u0e23\\u0e4c\\u0e41\\u0e25\\u0e30\\u0e44\\u0e2d\\u0e17\\u0e35\",\"id\":52}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(721, NULL, 'inventory', 'สร้างสินค้า: ปากกาลูกลื่น (ID: 41)', 'App\\Models\\Item', 41, '{\"attributes\":{\"category_id\":49,\"item_code\":\"SUP-001\",\"name\":\"\\u0e1b\\u0e32\\u0e01\\u0e01\\u0e32\\u0e25\\u0e39\\u0e01\\u0e25\\u0e37\\u0e48\\u0e19\",\"type\":\"disposable\",\"unit\":\"\\u0e14\\u0e49\\u0e32\\u0e21\",\"current_stock\":500,\"min_stock\":50,\"location\":\"\\u0e15\\u0e39\\u0e49\\u0e40\\u0e2d\\u0e01\\u0e2a\\u0e32\\u0e23 A\",\"status\":\"available\",\"id\":41}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(722, NULL, 'inventory', 'สร้างสินค้า: กระดาษ A4 (ID: 42)', 'App\\Models\\Item', 42, '{\"attributes\":{\"category_id\":49,\"item_code\":\"SUP-002\",\"name\":\"\\u0e01\\u0e23\\u0e30\\u0e14\\u0e32\\u0e29 A4\",\"type\":\"disposable\",\"unit\":\"\\u0e23\\u0e35\\u0e21\",\"current_stock\":200,\"min_stock\":20,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e40\\u0e01\\u0e47\\u0e1a\\u0e02\\u0e2d\\u0e07 1\",\"status\":\"available\",\"id\":42}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(723, NULL, 'inventory', 'สร้างสินค้า: สว่านไฟฟ้า (ID: 43)', 'App\\Models\\Item', 43, '{\"attributes\":{\"category_id\":50,\"item_code\":\"TL-001\",\"name\":\"\\u0e2a\\u0e27\\u0e48\\u0e32\\u0e19\\u0e44\\u0e1f\\u0e1f\\u0e49\\u0e32\",\"type\":\"returnable\",\"unit\":\"\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\",\"current_stock\":10,\"min_stock\":2,\"location\":\"\\u0e15\\u0e39\\u0e49\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e21\\u0e37\\u0e2d\",\"status\":\"available\",\"id\":43}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(724, NULL, 'inventory', 'สร้างสินค้า: ประแจเลื่อน (ID: 44)', 'App\\Models\\Item', 44, '{\"attributes\":{\"category_id\":50,\"item_code\":\"TL-002\",\"name\":\"\\u0e1b\\u0e23\\u0e30\\u0e41\\u0e08\\u0e40\\u0e25\\u0e37\\u0e48\\u0e2d\\u0e19\",\"type\":\"returnable\",\"unit\":\"\\u0e2d\\u0e31\\u0e19\",\"current_stock\":15,\"min_stock\":3,\"location\":\"\\u0e15\\u0e39\\u0e49\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e21\\u0e37\\u0e2d\",\"status\":\"available\",\"id\":44}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(725, NULL, 'inventory', 'สร้างสินค้า: น้ำยาทำความสะอาด (ID: 45)', 'App\\Models\\Item', 45, '{\"attributes\":{\"category_id\":51,\"item_code\":\"CON-001\",\"name\":\"\\u0e19\\u0e49\\u0e33\\u0e22\\u0e32\\u0e17\\u0e33\\u0e04\\u0e27\\u0e32\\u0e21\\u0e2a\\u0e30\\u0e2d\\u0e32\\u0e14\",\"type\":\"consumable\",\"unit\":\"\\u0e02\\u0e27\\u0e14\",\"current_stock\":50,\"min_stock\":10,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e40\\u0e01\\u0e47\\u0e1a\\u0e02\\u0e2d\\u0e07 2\",\"status\":\"available\",\"id\":45}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(726, NULL, 'inventory', 'สร้างสินค้า: ถุงมือยาง (ID: 46)', 'App\\Models\\Item', 46, '{\"attributes\":{\"category_id\":51,\"item_code\":\"CON-002\",\"name\":\"\\u0e16\\u0e38\\u0e07\\u0e21\\u0e37\\u0e2d\\u0e22\\u0e32\\u0e07\",\"type\":\"consumable\",\"unit\":\"\\u0e04\\u0e39\\u0e48\",\"current_stock\":100,\"min_stock\":20,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e40\\u0e01\\u0e47\\u0e1a\\u0e02\\u0e2d\\u0e07 2\",\"status\":\"available\",\"id\":46}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(727, NULL, 'inventory', 'สร้างสินค้า: เมาส์ไร้สาย (ID: 47)', 'App\\Models\\Item', 47, '{\"attributes\":{\"category_id\":52,\"item_code\":\"IT-001\",\"name\":\"\\u0e40\\u0e21\\u0e32\\u0e2a\\u0e4c\\u0e44\\u0e23\\u0e49\\u0e2a\\u0e32\\u0e22\",\"type\":\"equipment\",\"unit\":\"\\u0e2d\\u0e31\\u0e19\",\"current_stock\":30,\"min_stock\":5,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07 IT\",\"status\":\"available\",\"id\":47}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(728, NULL, 'inventory', 'สร้างสินค้า: คีย์บอร์ด (ID: 48)', 'App\\Models\\Item', 48, '{\"attributes\":{\"category_id\":52,\"item_code\":\"IT-002\",\"name\":\"\\u0e04\\u0e35\\u0e22\\u0e4c\\u0e1a\\u0e2d\\u0e23\\u0e4c\\u0e14\",\"type\":\"equipment\",\"unit\":\"\\u0e2d\\u0e31\\u0e19\",\"current_stock\":25,\"min_stock\":5,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07 IT\",\"status\":\"available\",\"id\":48}}', '2026-04-06 23:41:56', '2026-04-06 23:41:56'),
(729, NULL, 'inventory', 'แก้ไขหมวดหมู่สินค้า: อุปกรณ์สำนักงาน (ID: 49)', 'App\\Models\\ItemCategory', 49, '{\"old\":{\"code_prefix\":null},\"attributes\":{\"id\":49,\"name\":\"\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e2a\\u0e33\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\",\"code_prefix\":\"SUP\",\"prefix\":null,\"description\":\"\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e17\\u0e35\\u0e48\\u0e43\\u0e0a\\u0e49\\u0e43\\u0e19\\u0e2a\\u0e33\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\"}}', '2026-04-06 23:45:14', '2026-04-06 23:45:14'),
(730, NULL, 'inventory', 'แก้ไขหมวดหมู่สินค้า: เครื่องมือช่าง (ID: 50)', 'App\\Models\\ItemCategory', 50, '{\"old\":{\"code_prefix\":null},\"attributes\":{\"id\":50,\"name\":\"\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e21\\u0e37\\u0e2d\\u0e0a\\u0e48\\u0e32\\u0e07\",\"code_prefix\":\"TL\",\"prefix\":null,\"description\":\"\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e21\\u0e37\\u0e2d\\u0e41\\u0e25\\u0e30\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e0a\\u0e48\\u0e32\\u0e07\"}}', '2026-04-06 23:45:14', '2026-04-06 23:45:14'),
(731, NULL, 'inventory', 'แก้ไขหมวดหมู่สินค้า: วัสดุสิ้นเปลือง (ID: 51)', 'App\\Models\\ItemCategory', 51, '{\"old\":{\"code_prefix\":null},\"attributes\":{\"id\":51,\"name\":\"\\u0e27\\u0e31\\u0e2a\\u0e14\\u0e38\\u0e2a\\u0e34\\u0e49\\u0e19\\u0e40\\u0e1b\\u0e25\\u0e37\\u0e2d\\u0e07\",\"code_prefix\":\"CON\",\"prefix\":null,\"description\":\"\\u0e27\\u0e31\\u0e2a\\u0e14\\u0e38\\u0e43\\u0e0a\\u0e49\\u0e41\\u0e25\\u0e49\\u0e27\\u0e2b\\u0e21\\u0e14\\u0e44\\u0e1b\"}}', '2026-04-06 23:45:14', '2026-04-06 23:45:14'),
(732, NULL, 'inventory', 'แก้ไขหมวดหมู่สินค้า: อุปกรณ์ไอที (ID: 52)', 'App\\Models\\ItemCategory', 52, '{\"old\":{\"code_prefix\":null},\"attributes\":{\"id\":52,\"name\":\"\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e44\\u0e2d\\u0e17\\u0e35\",\"code_prefix\":\"IT\",\"prefix\":null,\"description\":\"\\u0e2d\\u0e38\\u0e1b\\u0e01\\u0e23\\u0e13\\u0e4c\\u0e04\\u0e2d\\u0e21\\u0e1e\\u0e34\\u0e27\\u0e40\\u0e15\\u0e2d\\u0e23\\u0e4c\\u0e41\\u0e25\\u0e30\\u0e44\\u0e2d\\u0e17\\u0e35\"}}', '2026-04-06 23:45:14', '2026-04-06 23:45:14'),
(733, 15, 'inventory', 'สร้างใบเบิก: #1 (ID: 1)', 'App\\Models\\Requisition', 1, '{\"attributes\":{\"employee_id\":14,\"req_type\":\"consume\",\"status\":\"issued\",\"req_date\":\"2026-04-07T00:00:00.000000Z\",\"note\":\"\\u0e40\\u0e2d\\u0e32\\u0e44\\u0e1b\\u0e08\\u0e14\",\"approved_by\":15,\"id\":1}}', '2026-04-06 23:54:38', '2026-04-06 23:54:38'),
(734, 15, 'inventory', 'สร้างรายการเบิก: #1 (ID: 1)', 'App\\Models\\RequisitionItem', 1, '{\"attributes\":{\"requisition_id\":1,\"item_id\":\"42\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":1}}', '2026-04-06 23:54:38', '2026-04-06 23:54:38'),
(735, 15, 'inventory', 'แก้ไขสินค้า: กระดาษ A4 (ID: 42)', 'App\\Models\\Item', 42, '{\"old\":{\"current_stock\":200},\"attributes\":{\"id\":42,\"category_id\":49,\"item_code\":\"SUP-002\",\"asset_number\":null,\"name\":\"\\u0e01\\u0e23\\u0e30\\u0e14\\u0e32\\u0e29 A4\",\"type\":\"disposable\",\"unit\":\"\\u0e23\\u0e35\\u0e21\",\"current_stock\":199,\"min_stock\":20,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e40\\u0e01\\u0e47\\u0e1a\\u0e02\\u0e2d\\u0e07 1\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-06 23:54:38', '2026-04-06 23:54:38'),
(736, 15, 'inventory', 'สร้างใบเบิก: #2 (ID: 2)', 'App\\Models\\Requisition', 2, '{\"attributes\":{\"employee_id\":14,\"req_type\":\"consume\",\"status\":\"issued\",\"req_date\":\"2026-04-07T00:00:00.000000Z\",\"note\":\"\\u0e40\\u0e2d\\u0e32\\u0e44\\u0e1b\\u0e08\\u0e14\",\"approved_by\":15,\"id\":2}}', '2026-04-06 23:54:40', '2026-04-06 23:54:40'),
(737, 15, 'inventory', 'สร้างรายการเบิก: #2 (ID: 2)', 'App\\Models\\RequisitionItem', 2, '{\"attributes\":{\"requisition_id\":2,\"item_id\":\"42\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":2}}', '2026-04-06 23:54:40', '2026-04-06 23:54:40'),
(738, 15, 'inventory', 'แก้ไขสินค้า: กระดาษ A4 (ID: 42)', 'App\\Models\\Item', 42, '{\"old\":{\"current_stock\":199},\"attributes\":{\"id\":42,\"category_id\":49,\"item_code\":\"SUP-002\",\"asset_number\":null,\"name\":\"\\u0e01\\u0e23\\u0e30\\u0e14\\u0e32\\u0e29 A4\",\"type\":\"disposable\",\"unit\":\"\\u0e23\\u0e35\\u0e21\",\"current_stock\":198,\"min_stock\":20,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e40\\u0e01\\u0e47\\u0e1a\\u0e02\\u0e2d\\u0e07 1\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-06 23:54:40', '2026-04-06 23:54:40'),
(739, 15, 'inventory', 'สร้างใบเบิก: #3 (ID: 3)', 'App\\Models\\Requisition', 3, '{\"attributes\":{\"employee_id\":\"14\",\"req_type\":\"borrow\",\"status\":\"approved\",\"req_date\":\"2026-04-06T17:00:00.000000Z\",\"due_date\":\"2026-04-08T17:00:00.000000Z\",\"note\":null,\"approved_by\":15,\"id\":3}}', '2026-04-07 07:28:00', '2026-04-07 07:28:00'),
(740, 15, 'inventory', 'สร้างรายการเบิก: #3 (ID: 3)', 'App\\Models\\RequisitionItem', 3, '{\"attributes\":{\"requisition_id\":3,\"item_id\":\"43\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":3}}', '2026-04-07 07:28:00', '2026-04-07 07:28:00'),
(741, 15, 'inventory', 'แก้ไขสินค้า: สว่านไฟฟ้า (ID: 43)', 'App\\Models\\Item', 43, '{\"old\":{\"current_stock\":10},\"attributes\":{\"id\":43,\"category_id\":50,\"item_code\":\"TL-001\",\"asset_number\":null,\"name\":\"\\u0e2a\\u0e27\\u0e48\\u0e32\\u0e19\\u0e44\\u0e1f\\u0e1f\\u0e49\\u0e32\",\"type\":\"returnable\",\"unit\":\"\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\",\"current_stock\":9,\"min_stock\":2,\"location\":\"\\u0e15\\u0e39\\u0e49\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e21\\u0e37\\u0e2d\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-07 07:28:00', '2026-04-07 07:28:00'),
(742, 15, 'hr', 'แก้ไขพนักงาน: SIT-001 พีรพัฒน์ หน้างาน (ID: 14)', 'App\\Models\\Employee', 14, '{\"old\":{\"profile_image\":null},\"attributes\":{\"id\":14,\"department_id\":6,\"position_id\":10,\"employee_code\":\"SIT-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e1e\\u0e35\\u0e23\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e4c\",\"lastname\":\"\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19\",\"gender\":\"male\",\"phone\":\"086-456-7890\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":\"employees\\/1775549460_69d4bc1406cfe_EAGLE-\\u0e23\\u0e38\\u0e48\\u0e19-SS-7043.jpg\"}}', '2026-04-07 08:11:00', '2026-04-07 08:11:00');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-unread_count_1', 'i:0;', 1775546917),
('laravel-cache-unread_count_15', 'i:0;', 1775549483),
('laravel-cache-unread_count_58', 'i:0;', 1775542545),
('laravel-cache-unread_count_91', 'i:0;', 1775543848);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `next_department_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'บริหาร', 'ฝ่ายบริหารและจัดการทั่วไป', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(2, 'ฝ่ายขาย', 'แผนกขายและการตลาด', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(3, 'วิศวกรรม', 'แผนกวิศวกรรมและเทคนิค', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(4, 'การผลิต', 'แผนกผลิตและประกอบ', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(5, 'QC', 'แผนกตรวจสอบคุณภาพ', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(6, 'หน้างาน', 'แผนกติดตั้งและไซต์งาน', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(7, 'จัดซื้อ', 'แผนกจัดซื้อ', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(8, 'คลังสินค้า', 'จัดการสินค้าและสต๊อก', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(9, 'บุคคล', 'ฝ่ายบุคคลและทรัพยากรบุคคล', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(10, 'บัญชี', 'ฝ่ายบัญชีและการเงิน', NULL, '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL);

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
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
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

INSERT INTO `employees` (`id`, `department_id`, `position_id`, `employee_code`, `prefix`, `firstname`, `lastname`, `gender`, `phone`, `address`, `start_date`, `status`, `profile_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 3, 'SAL-001', 'นาย', 'สมชาย', 'วงศ์สวัสดิ์', 'male', '081-234-5678', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:08', '2026-04-06 23:39:08', NULL),
(2, 2, 4, 'SAL-002', 'นางสาว', 'สุภาวดี', 'จันทร์เพ็ญ', 'female', '089-876-5432', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:08', '2026-04-06 23:39:08', NULL),
(3, 2, 3, 'SAL-003', 'นาย', 'ธนกร', 'รัตนชัย', 'male', '062-345-6789', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:08', '2026-04-06 23:39:08', NULL),
(4, 3, 5, 'ENG-001', 'นาย', 'กิตติ', 'พัฒนาพงศ์', 'male', '083-456-7890', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:08', '2026-04-06 23:39:08', NULL),
(5, 3, 6, 'ENG-002', 'นาย', 'วิชัย', 'แก้วมณี', 'male', '095-567-8901', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:09', '2026-04-06 23:39:09', NULL),
(6, 3, 5, 'ENG-003', 'นางสาว', 'พิมพ์ใจ', 'สุขสมบูรณ์', 'female', '087-678-9012', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:09', '2026-04-06 23:39:09', NULL),
(7, 4, 7, 'PRD-001', 'นาย', 'ประสิทธิ์', 'การช่าง', 'male', '084-789-0123', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:09', '2026-04-06 23:39:09', NULL),
(8, 4, 8, 'PRD-002', 'นาย', 'มงคล', 'เหล็กกล้า', 'male', '091-890-1234', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:09', '2026-04-06 23:39:09', NULL),
(9, 4, 7, 'PRD-003', 'นาย', 'บุญมี', 'ช่างเชื่อม', 'male', '063-901-2345', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10', NULL),
(10, 4, 7, 'PRD-004', 'นาย', 'สุรชัย', 'ประกอบกิจ', 'male', '088-012-3456', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10', NULL),
(11, 4, 7, 'PRD-005', 'นาย', 'อภิชาติ', 'ผลิตผล', 'male', '092-123-4567', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10', NULL),
(12, 5, 9, 'QC-001', 'นาย', 'ชัยวัฒน์', 'ตรวจดี', 'male', '085-234-5678', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10', NULL),
(13, 5, 9, 'QC-002', 'นางสาว', 'รัตนา', 'คุณภาพ', 'female', '096-345-6789', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10', NULL),
(14, 6, 10, 'SIT-001', 'นาย', 'พีรพัฒน์', 'หน้างาน', 'male', '086-456-7890', NULL, '2026-04-01', 'active', 'employees/1775549460_69d4bc1406cfe_EAGLE-รุ่น-SS-7043.jpg', '2026-04-06 23:39:11', '2026-04-07 08:11:00', NULL),
(15, 6, 11, 'SIT-002', 'นาย', 'อนุชา', 'ติดตั้ง', 'male', '093-567-8901', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:11', '2026-04-06 23:39:11', NULL),
(16, 6, 10, 'SIT-003', 'นาย', 'ธนพล', 'ไซต์งาน', 'male', '064-678-9012', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:11', '2026-04-06 23:39:11', NULL),
(17, 7, 12, 'PUR-001', 'นางสาว', 'จิดาภา', 'จัดซื้อ', 'female', '082-789-0123', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:11', '2026-04-06 23:39:11', NULL),
(18, 7, 12, 'PUR-002', 'นาย', ' กรกฎ', 'หามา', 'male', '094-890-1234', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:11', '2026-04-06 23:39:11', NULL),
(19, 8, 13, 'WH-001', 'นาย', 'วิรัตน์', 'คลังสินค้า', 'male', '081-901-2345', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:12', '2026-04-06 23:39:12', NULL),
(20, 8, 13, 'WH-002', 'นาย', 'สมบัติ', 'เบิกจ่าย', 'male', '097-012-3456', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:12', '2026-04-06 23:39:12', NULL),
(21, 9, 15, 'HR-001', 'นางสาว', 'กัลยา', 'บุคคล', 'female', '089-222-3333', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:12', '2026-04-06 23:39:12', NULL),
(22, 10, 16, 'ACC-001', 'นางสาว', 'พิชชา', 'การเงิน', 'female', '062-333-4444', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:12', '2026-04-06 23:39:12', NULL),
(23, 10, 16, 'ACC-002', 'นาย', 'ธนวัตต์', 'โอว้าว', 'male', '083-444-5555', NULL, '2026-04-01', 'active', NULL, '2026-04-06 23:39:13', '2026-04-06 23:39:13', NULL);

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
  `asset_number` varchar(100) DEFAULT NULL COMMENT 'เลขครุภัณฑ์ สำหรับอุปกรณ์',
  `name` varchar(255) NOT NULL,
  `type` enum('disposable','returnable','equipment','consumable') NOT NULL,
  `unit` varchar(50) NOT NULL,
  `current_stock` int(11) NOT NULL DEFAULT 0,
  `min_stock` int(11) NOT NULL DEFAULT 0,
  `location` varchar(100) DEFAULT NULL,
  `image_url` varchar(512) DEFAULT NULL,
  `status` enum('available','unavailable','maintenance') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `category_id`, `item_code`, `asset_number`, `name`, `type`, `unit`, `current_stock`, `min_stock`, `location`, `image_url`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(41, 49, 'SUP-001', NULL, 'ปากกาลูกลื่น', 'disposable', 'ด้าม', 500, 50, 'ตู้เอกสาร A', NULL, 'available', '2026-04-06 23:41:56', '2026-04-06 23:41:56', NULL),
(42, 49, 'SUP-002', NULL, 'กระดาษ A4', 'disposable', 'รีม', 198, 20, 'ห้องเก็บของ 1', NULL, 'available', '2026-04-06 23:41:56', '2026-04-06 23:54:40', NULL),
(43, 50, 'TL-001', NULL, 'สว่านไฟฟ้า', 'returnable', 'เครื่อง', 9, 2, 'ตู้เครื่องมือ', NULL, 'available', '2026-04-06 23:41:56', '2026-04-07 07:28:00', NULL),
(44, 50, 'TL-002', NULL, 'ประแจเลื่อน', 'returnable', 'อัน', 15, 3, 'ตู้เครื่องมือ', NULL, 'available', '2026-04-06 23:41:56', '2026-04-06 23:41:56', NULL),
(45, 51, 'CON-001', NULL, 'น้ำยาทำความสะอาด', 'consumable', 'ขวด', 50, 10, 'ห้องเก็บของ 2', NULL, 'available', '2026-04-06 23:41:56', '2026-04-06 23:41:56', NULL),
(46, 51, 'CON-002', NULL, 'ถุงมือยาง', 'consumable', 'คู่', 100, 20, 'ห้องเก็บของ 2', NULL, 'available', '2026-04-06 23:41:56', '2026-04-06 23:41:56', NULL),
(47, 52, 'IT-001', NULL, 'เมาส์ไร้สาย', 'equipment', 'อัน', 30, 5, 'ห้อง IT', NULL, 'available', '2026-04-06 23:41:56', '2026-04-06 23:41:56', NULL),
(48, 52, 'IT-002', NULL, 'คีย์บอร์ด', 'equipment', 'อัน', 25, 5, 'ห้อง IT', NULL, 'available', '2026-04-06 23:41:56', '2026-04-06 23:41:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code_prefix` varchar(10) DEFAULT NULL COMMENT 'รหัสย่อสำหรับสร้างรหัสสินค้าอัตโนมัติ',
  `prefix` varchar(10) DEFAULT NULL COMMENT 'ตัวย่อหมวดหมู่ เช่น SAF, TLS',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name`, `code_prefix`, `prefix`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(49, 'อุปกรณ์สำนักงาน', 'SUP', NULL, 'อุปกรณ์ที่ใช้ในสำนักงาน', '2026-04-06 23:41:56', '2026-04-06 23:45:14', NULL),
(50, 'เครื่องมือช่าง', 'TL', NULL, 'เครื่องมือและอุปกรณ์ช่าง', '2026-04-06 23:41:56', '2026-04-06 23:45:14', NULL),
(51, 'วัสดุสิ้นเปลือง', 'CON', NULL, 'วัสดุใช้แล้วหมดไป', '2026-04-06 23:41:56', '2026-04-06 23:45:14', NULL),
(52, 'อุปกรณ์ไอที', 'IT', NULL, 'อุปกรณ์คอมพิวเตอร์และไอที', '2026-04-06 23:41:56', '2026-04-06 23:45:14', NULL);

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
(14, '2026_03_31_091120_create_requisition_items_table', 1),
(15, '2026_04_05_000000_add_transaction_types_to_stock_transactions', 1),
(16, '2026_04_05_071644_add_contact_info_to_employees_table', 1),
(17, '2026_04_05_074011_add_soft_deletes_to_important_tables', 1),
(18, '2026_04_05_080551_create_notifications_table', 1),
(19, '2026_04_05_082143_add_constraints_and_indexes', 1),
(20, '2026_04_05_084053_add_stock_constraint', 1),
(21, '2026_04_05_100000_create_activity_logs_table', 1),
(22, '2026_04_05_163004_create_permissions_table', 1),
(23, '2026_04_05_163020_create_role_permissions_table', 1),
(24, '2026_04_05_163355_add_returnable_type_to_items', 1),
(25, '2026_04_05_163645_add_period_to_requisitions_table', 1),
(26, '2026_04_05_172555_add_issued_status_to_requisitions', 1),
(27, '2026_04_07_000001_add_code_prefix_to_item_categories', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('23364ba3-3000-404b-b1f8-e9a94a6c60cc', 'App\\Notifications\\RequisitionSubmitted', 'App\\Models\\User', 1, '{\"type\":\"requisition_submitted\",\"icon\":\"bi-file-earmark-text\",\"color\":\"primary\",\"title\":\"\\u0e21\\u0e35\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e43\\u0e2b\\u0e21\\u0e48\\u0e23\\u0e2d\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\",\"message\":\"\\u0e1e\\u0e35\\u0e23\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e4c \\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19 \\u0e44\\u0e14\\u0e49\\u0e22\\u0e37\\u0e48\\u0e19\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e27\\u0e31\\u0e19\\u0e17\\u0e35\\u0e48 07\\/04\\/2026\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/inventory\\/requisition\\/1\\/approve\",\"action_text\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\",\"requisition_id\":1}', '2026-04-06 23:54:53', '2026-04-06 23:54:40', '2026-04-06 23:54:53'),
('a882a322-e89b-434b-8b17-3c7a4f3e506e', 'App\\Notifications\\RequisitionSubmitted', 'App\\Models\\User', 1, '{\"type\":\"requisition_submitted\",\"icon\":\"bi-file-earmark-text\",\"color\":\"primary\",\"title\":\"\\u0e21\\u0e35\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e43\\u0e2b\\u0e21\\u0e48\\u0e23\\u0e2d\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\",\"message\":\"\\u0e1e\\u0e35\\u0e23\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e4c \\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19 \\u0e44\\u0e14\\u0e49\\u0e22\\u0e37\\u0e48\\u0e19\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e27\\u0e31\\u0e19\\u0e17\\u0e35\\u0e48 07\\/04\\/2026\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/inventory\\/requisition\\/2\\/approve\",\"action_text\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\",\"requisition_id\":2}', '2026-04-06 23:55:02', '2026-04-06 23:54:40', '2026-04-06 23:55:02');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_key` varchar(255) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `module_icon` varchar(255) DEFAULT NULL,
  `permission_key` varchar(255) NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `department_id`, `name`, `job_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'ผู้จัดการฝ่ายบริหาร', 'จัดการและวางแผนฝ่ายบริหาร', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(2, 1, 'เจ้าหน้าที่บริหาร', 'สนับสนุนงานบริหารทั่วไป', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(3, 2, 'พนักงานขาย', 'ปฏิบัติงานขาย', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(4, 2, 'หัวหน้าพนักงานขาย', 'ดูแลทีมขาย', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(5, 3, 'พนักงานฝ่ายเทคนิค', 'งานวิศวกรรม', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(6, 3, 'หัวหน้าฝ่ายเทคนิค', 'ดูแลทีมเทคนิค', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(7, 4, 'พนักงานฝ่ายผลิต', 'งานผลิต', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(8, 4, 'หัวหน้าฝ่ายผลิต', 'ดูแลทีมผลิต', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(9, 5, 'พนักงานฝ่าย QC', 'ตรวจสอบคุณภาพ', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(10, 6, 'พนักงานหน้างาน', 'ติดตั้งหน้างาน', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(11, 6, 'หัวหน้าหน้างาน', 'ดูแลหน้างาน', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(12, 7, 'พนักงานจัดซื้อ', 'จัดซื้อจัดจ้าง', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(13, 8, 'เจ้าหน้าที่คลังสินค้า', 'จัดการรับ-จ่ายสินค้าและตรวจสอบสต๊อก', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(14, 8, 'หัวหน้าคลังสินค้า', 'ดูแลและจัดการคลังสินค้าทั้งหมด', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(15, 9, 'เจ้าหน้าที่ HR', 'งานบุคคล', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(16, 10, 'เจ้าหน้าที่บัญชี', 'งานการเงินบัญชี', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL),
(17, 1, 'System Administrator', 'ดูแลระบบ', '2026-04-06 23:38:15', '2026-04-06 23:38:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `requisitions`
--

CREATE TABLE `requisitions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `req_type` enum('borrow','consume') NOT NULL,
  `status` enum('pending','approved','rejected','returned_partial','returned_all','issued') NOT NULL DEFAULT 'pending',
  `req_date` date NOT NULL,
  `period` enum('morning','afternoon','evening') DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `note` text DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requisitions`
--

INSERT INTO `requisitions` (`id`, `employee_id`, `req_type`, `status`, `req_date`, `period`, `due_date`, `note`, `approved_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 14, 'consume', 'issued', '2026-04-07', NULL, NULL, 'เอาไปจด', 15, '2026-04-06 23:54:38', '2026-04-06 23:54:38', NULL),
(2, 14, 'consume', 'issued', '2026-04-07', NULL, NULL, 'เอาไปจด', 15, '2026-04-06 23:54:40', '2026-04-06 23:54:40', NULL),
(3, 14, 'borrow', 'approved', '2026-04-07', NULL, '2026-04-09', NULL, 15, '2026-04-07 07:28:00', '2026-04-07 07:28:00', NULL);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requisition_items`
--

INSERT INTO `requisition_items` (`id`, `requisition_id`, `item_id`, `quantity_requested`, `quantity_returned`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 42, 1, 0, '2026-04-06 23:54:38', '2026-04-06 23:54:38', NULL),
(2, 2, 42, 1, 0, '2026-04-06 23:54:40', '2026-04-06 23:54:40', NULL),
(3, 3, 43, 1, 0, '2026-04-07 07:28:00', '2026-04-07 07:28:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `can_view` tinyint(1) NOT NULL DEFAULT 0,
  `can_create` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit` tinyint(1) NOT NULL DEFAULT 0,
  `can_delete` tinyint(1) NOT NULL DEFAULT 0,
  `can_export` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
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
('68oRxX9wLQRfjxeCgaJ7Gj5ivuwF7WCWchst47iK', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN3lGOTR4VHdlOUVlcU5IQkFweVF3cU9MOVlBYlplT21RTElQUTh1OSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnZlbnRvcnkvYm9ycm93aW5nLzMiO3M6NToicm91dGUiO3M6MjQ6ImludmVudG9yeS5ib3Jyb3dpbmcuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1775546895),
('eJIhhX9qdgGMMRACW2f6iq1jTDEyU7anuX4B8DrN', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieEhnek84WGx3RDJONVdENE54eHhLb2c2SWc2V1B5QzlzWmVnM3RBOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb3llZS9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTg6ImVtcGxveWVlLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE1O30=', 1775549464);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` enum('in','out','return','adjust','borrow_out','borrow_return','consume_out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `requisition_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transactions`
--

INSERT INTO `stock_transactions` (`id`, `item_id`, `transaction_type`, `quantity`, `balance`, `requisition_id`, `created_by`, `remark`, `created_at`, `updated_at`) VALUES
(4, 42, 'consume_out', 1, 199, 1, 15, 'เบิกโดย: พีรพัฒน์ หน้างาน เมื่อ 13:54 น.', '2026-04-06 23:54:38', '2026-04-06 23:54:38'),
(5, 42, 'consume_out', 1, 198, 2, 15, 'เบิกโดย: พีรพัฒน์ หน้างาน เมื่อ 13:54 น.', '2026-04-06 23:54:40', '2026-04-06 23:54:40'),
(6, 43, 'borrow_out', 1, 9, 3, 15, 'ยืมโดย: พีรพัฒน์ หน้างาน', '2026-04-07 07:28:00', '2026-04-07 07:28:00');

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
(1, 'System Administrator', 'admin', '$2y$12$HuN2h2psNkp1/0aDlOD.s.rKBF08mPPuQSaj2C7cIoVqVN5DDxBCK', 'admin', NULL, NULL, '2026-04-06 23:39:08', '2026-04-06 23:40:14'),
(2, 'นายสมชาย วงศ์สวัสดิ์', 'sal001', '$2y$12$FsrOvL9CdDcMRvrJI9J0b.rJgljXCZ5DYDN5SCuaKJy7I8DVB/vji', 'employee', 1, NULL, '2026-04-06 23:39:08', '2026-04-06 23:39:08'),
(3, 'นางสาวสุภาวดี จันทร์เพ็ญ', 'sal002', '$2y$12$1XiIl6PtMeiD37M7vhBynO3giD6cF8WmqgV1HKplcSQwCID2sS2FW', 'employee', 2, NULL, '2026-04-06 23:39:08', '2026-04-06 23:39:08'),
(4, 'นายธนกร รัตนชัย', 'sal003', '$2y$12$c1SFCAogIFiFk8P0.jLz3O5cRVk2t1FwRwTFP9t34kJ/6qUmZra1O', 'employee', 3, NULL, '2026-04-06 23:39:08', '2026-04-06 23:39:08'),
(5, 'นายกิตติ พัฒนาพงศ์', 'eng001', '$2y$12$ZBeV4ftHIwBca3vVPF/S8.CcNwPY2K4z.8ocsJ3dJJiXOnZrm38ha', 'employee', 4, NULL, '2026-04-06 23:39:09', '2026-04-06 23:39:09'),
(6, 'นายวิชัย แก้วมณี', 'eng002', '$2y$12$afGcwK4Aw5e2nHo/R688LePBWy/JB7hZgJ.iRzNmtigm6Od8rrf1q', 'employee', 5, NULL, '2026-04-06 23:39:09', '2026-04-06 23:39:09'),
(7, 'นางสาวพิมพ์ใจ สุขสมบูรณ์', 'eng003', '$2y$12$.5ZTCvDk6SQdxk3s7O1XkOYllOgvFQEq8f2agDfPUgHJv0n6uHmQS', 'employee', 6, NULL, '2026-04-06 23:39:09', '2026-04-06 23:39:09'),
(8, 'นายประสิทธิ์ การช่าง', 'prd001', '$2y$12$mZt/HwcgrXFvF9Pd2QTI6eWnG2sQTjCSNoOXLEiXiGNvFtfSJBNFC', 'employee', 7, NULL, '2026-04-06 23:39:09', '2026-04-06 23:39:09'),
(9, 'นายมงคล เหล็กกล้า', 'prd002', '$2y$12$AaR34Y5ofWvdVfGy7pCf..B7mfCPrRLHooB0Okeja/EKbyE6B2xWa', 'employee', 8, NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(10, 'นายบุญมี ช่างเชื่อม', 'prd003', '$2y$12$C4gT0.LkurUpNyG/iV04H.MeSkLp/LZ9UVciEg6TxM0rt3ocRHvNS', 'employee', 9, NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(11, 'นายสุรชัย ประกอบกิจ', 'prd004', '$2y$12$nQ4B97WrfgzefuRypJun6eY1J1WJj.//SxIcF0V5M3IvG6iFcqnaa', 'employee', 10, NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(12, 'นายอภิชาติ ผลิตผล', 'prd005', '$2y$12$907nW5gF1unn46rfiL.ZXeeYr44m.G2nQeMWVPswjn6nbZs70GNNa', 'employee', 11, NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(13, 'นายชัยวัฒน์ ตรวจดี', 'qc001', '$2y$12$ONvWdwWo33bfBX.mqOsQz.xFpRzHuDFaoyvKca66N1.MaHUlRqlK6', 'employee', 12, NULL, '2026-04-06 23:39:10', '2026-04-06 23:39:10'),
(14, 'นางสาวรัตนา คุณภาพ', 'qc002', '$2y$12$8aQQ9zEIRBpDNbp62ERkwOvcyC6d1UoEWrua5HBxeuyC.qIh1gud6', 'employee', 13, NULL, '2026-04-06 23:39:11', '2026-04-06 23:39:11'),
(15, 'นาย พีรพัฒน์ หน้างาน', 'sit001', '$2y$12$wO.G3JDbgYmTfBDwHLK6f.7nmREljXbuNOKVycpmijenPbwEZYJoe', 'employee', 14, NULL, '2026-04-06 23:39:11', '2026-04-07 08:11:00'),
(16, 'นายอนุชา ติดตั้ง', 'sit002', '$2y$12$6BmuWnkAbod4FV5JoktrfO0AuDPrvMo3.IMhr/Ix3oYZsGqRaoxCK', 'employee', 15, NULL, '2026-04-06 23:39:11', '2026-04-06 23:39:11'),
(17, 'นายธนพล ไซต์งาน', 'sit003', '$2y$12$dsV.5K3wqDphpe7ducXwCu7k1swe.bG1VhLnuSqCApjTYQvQtzYz6', 'employee', 16, NULL, '2026-04-06 23:39:11', '2026-04-06 23:39:11'),
(18, 'นางสาวจิดาภา จัดซื้อ', 'pur001', '$2y$12$QpUDQMm2prg4d5EMc6nrHuwkzlVUMnYmk6GD0jrAo8z9X0H.xdURG', 'employee', 17, NULL, '2026-04-06 23:39:11', '2026-04-06 23:39:11'),
(19, 'นาย กรกฎ หามา', 'pur002', '$2y$12$ugmDnl4g2bL6ItA.wN3HHOx0slPmpbzWnoY11rseZnXpniqtF1vjq', 'employee', 18, NULL, '2026-04-06 23:39:12', '2026-04-06 23:39:12'),
(20, 'นายวิรัตน์ คลังสินค้า', 'wh001', '$2y$12$8gYCZSonOCpVTtwqvBfVOuXANmfgvbfVbP4Bq.HqcdenvCCLhY8ju', 'employee', 19, NULL, '2026-04-06 23:39:12', '2026-04-06 23:39:12'),
(21, 'นายสมบัติ เบิกจ่าย', 'wh002', '$2y$12$JSOv5tJo4i7evIEA.CgSyuKXJ3HN4Etr2r9U8ziMPsaNUUPx24gba', 'employee', 20, NULL, '2026-04-06 23:39:12', '2026-04-06 23:39:12'),
(22, 'นางสาวกัลยา บุคคล', 'hr001', '$2y$12$W/35Dh.gXDRjve5o.ityDueDLvgNKjGaJH.pIB5W6fgE3AEqjVSby', 'hr', 21, NULL, '2026-04-06 23:39:12', '2026-04-06 23:39:12'),
(23, 'นางสาวพิชชา การเงิน', 'acc001', '$2y$12$Z3ZeBuBij86FOXs4G.lCperKYL8pwZlrXNLICTjXnnbsmNw/x1gra', 'employee', 22, NULL, '2026-04-06 23:39:13', '2026-04-06 23:39:13'),
(24, 'นายธนวัตต์ โอว้าว', 'acc002', '$2y$12$LRIpkaR9XPr1KH3Rl/5lvOc1XZdqhOnIIijZAJAxC76rCzW4Ha9he', 'employee', 23, NULL, '2026-04-06 23:39:13', '2026-04-06 23:39:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_index` (`user_id`),
  ADD KEY `activity_logs_log_name_index` (`log_name`),
  ADD KEY `subject_index` (`subject_type`,`subject_id`),
  ADD KEY `activity_logs_created_at_index` (`created_at`);

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
  ADD KEY `idx_employees_department_id` (`department_id`),
  ADD KEY `idx_employees_position_id` (`position_id`),
  ADD KEY `idx_employees_employee_code` (`employee_code`);

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
  ADD UNIQUE KEY `items_asset_number_unique` (`asset_number`),
  ADD KEY `idx_items_category_id` (`category_id`),
  ADD KEY `idx_items_item_code` (`item_code`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_categories_name_unique` (`name`),
  ADD UNIQUE KEY `item_categories_prefix_unique` (`prefix`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`),
  ADD KEY `idx_notifications_notifiable` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_module_key_permission_key_unique` (`module_key`,`permission_key`),
  ADD KEY `permissions_module_key_index` (`module_key`);

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
  ADD KEY `requisitions_approved_by_foreign` (`approved_by`),
  ADD KEY `idx_requisitions_employee_id` (`employee_id`),
  ADD KEY `idx_requisitions_status` (`status`);

--
-- Indexes for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_req_items_requisition_id` (`requisition_id`),
  ADD KEY `idx_req_items_item_id` (`item_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_role_permission_id_unique` (`role`,`permission_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `role_permissions_role_index` (`role`);

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
  ADD KEY `stock_transactions_requisition_id_foreign` (`requisition_id`),
  ADD KEY `stock_transactions_created_by_foreign` (`created_by`),
  ADD KEY `idx_stock_txn_item_id` (`item_id`),
  ADD KEY `idx_stock_txn_created_at` (`created_at`);

--
-- Indexes for table `time_records`
--
ALTER TABLE `time_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `time_records_employee_id_work_date_unique` (`employee_id`,`work_date`),
  ADD KEY `time_records_locked_by_foreign` (`locked_by`),
  ADD KEY `idx_time_records_employee_id` (`employee_id`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=743;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `requisitions`
--
ALTER TABLE `requisitions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requisition_items`
--
ALTER TABLE `requisition_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `time_records`
--
ALTER TABLE `time_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time_record_details`
--
ALTER TABLE `time_record_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_record_logs`
--
ALTER TABLE `time_record_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

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
