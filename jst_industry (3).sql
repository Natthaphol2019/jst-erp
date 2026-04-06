-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2026 at 08:01 AM
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
(1, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กแผ่น SS400 8mm (ID: 1)', 'App\\Models\\Item', 1, '{\"old\":{\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e41\\u0e1c\\u0e48\\u0e19 SS400 6mm\"},\"attributes\":{\"id\":1,\"category_id\":\"1\",\"item_code\":\"RM-001\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e41\\u0e1c\\u0e48\\u0e19 SS400 8mm\",\"type\":\"consumable\",\"unit\":\"\\u0e41\\u0e1c\\u0e48\\u0e19\",\"current_stock\":50,\"min_stock\":10,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 07:21:29', '2026-04-05 07:21:29'),
(2, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กแผ่น SS400 8mm (ID: 1)', 'App\\Models\\Item', 1, '{\"old\":{\"image_url\":null},\"attributes\":{\"id\":1,\"category_id\":\"1\",\"item_code\":\"RM-001\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e41\\u0e1c\\u0e48\\u0e19 SS400 8mm\",\"type\":\"consumable\",\"unit\":\"\\u0e41\\u0e1c\\u0e48\\u0e19\",\"current_stock\":50,\"min_stock\":10,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":\"items\\/1775398993_181931_l.webp\",\"status\":\"available\"}}', '2026-04-05 07:23:13', '2026-04-05 07:23:13'),
(3, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กแผ่น SS400 8mm (ID: 1)', 'App\\Models\\Item', 1, '{\"old\":{\"image_url\":\"items\\/1775398993_181931_l.webp\"},\"attributes\":{\"id\":1,\"category_id\":\"1\",\"item_code\":\"RM-001\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e41\\u0e1c\\u0e48\\u0e19 SS400 8mm\",\"type\":\"consumable\",\"unit\":\"\\u0e41\\u0e1c\\u0e48\\u0e19\",\"current_stock\":50,\"min_stock\":10,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":\"items\\/1775399136_181931_l.webp\",\"status\":\"available\"}}', '2026-04-05 07:25:36', '2026-04-05 07:25:36'),
(4, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กแผ่น SS400 8mm (ID: 1)', 'App\\Models\\Item', 1, '{\"old\":{\"image_url\":\"items\\/1775399136_181931_l.webp\"},\"attributes\":{\"id\":1,\"category_id\":\"1\",\"item_code\":\"RM-001\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e41\\u0e1c\\u0e48\\u0e19 SS400 8mm\",\"type\":\"consumable\",\"unit\":\"\\u0e41\\u0e1c\\u0e48\\u0e19\",\"current_stock\":50,\"min_stock\":10,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":\"items\\/1775399373_181931_l.webp\",\"status\":\"available\"}}', '2026-04-05 07:29:33', '2026-04-05 07:29:33'),
(5, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กแผ่น SS400 8mm (ID: 1)', 'App\\Models\\Item', 1, '{\"old\":{\"image_url\":\"items\\/1775399373_181931_l.webp\"},\"attributes\":{\"id\":1,\"category_id\":\"1\",\"item_code\":\"RM-001\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e41\\u0e1c\\u0e48\\u0e19 SS400 8mm\",\"type\":\"consumable\",\"unit\":\"\\u0e41\\u0e1c\\u0e48\\u0e19\",\"current_stock\":50,\"min_stock\":10,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":\"items\\/1775399557_181931_l.webp\",\"status\":\"available\"}}', '2026-04-05 07:32:37', '2026-04-05 07:32:37'),
(6, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กกล่อง 50x50x2.3mm (ID: 2)', 'App\\Models\\Item', 2, '{\"old\":{\"image_url\":null},\"attributes\":{\"id\":2,\"category_id\":\"1\",\"item_code\":\"RM-002\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e01\\u0e25\\u0e48\\u0e2d\\u0e07 50x50x2.3mm\",\"type\":\"consumable\",\"unit\":\"\\u0e40\\u0e2a\\u0e49\\u0e19\",\"current_stock\":120,\"min_stock\":20,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":\"items\\/1775399564_181931_l.webp\",\"status\":\"available\"}}', '2026-04-05 07:32:44', '2026-04-05 07:32:44'),
(7, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กแผ่น SS400 8mm (ID: 1)', 'App\\Models\\Item', 1, '{\"old\":{\"image_url\":\"items\\/1775399557_181931_l.webp\"},\"attributes\":{\"id\":1,\"category_id\":\"1\",\"item_code\":\"RM-001\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e41\\u0e1c\\u0e48\\u0e19 SS400 8mm\",\"type\":\"consumable\",\"unit\":\"\\u0e41\\u0e1c\\u0e48\\u0e19\",\"current_stock\":50,\"min_stock\":10,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":\"items\\/1775399576_e9457d39-90e0-4349-be53-eacbca0a3a38.png\",\"status\":\"available\"}}', '2026-04-05 07:32:56', '2026-04-05 07:32:56'),
(8, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กแผ่น SS400 8mm (ID: 1)', 'App\\Models\\Item', 1, '{\"old\":{\"image_url\":\"items\\/1775399576_e9457d39-90e0-4349-be53-eacbca0a3a38.png\"},\"attributes\":{\"id\":1,\"category_id\":\"1\",\"item_code\":\"RM-001\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e41\\u0e1c\\u0e48\\u0e19 SS400 8mm\",\"type\":\"consumable\",\"unit\":\"\\u0e41\\u0e1c\\u0e48\\u0e19\",\"current_stock\":50,\"min_stock\":10,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":\"items\\/1775399770_181931_l.webp\",\"status\":\"available\"}}', '2026-04-05 07:36:10', '2026-04-05 07:36:10'),
(9, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กกล่อง 50x50x2.3mm (ID: 2)', 'App\\Models\\Item', 2, '{\"old\":{\"image_url\":\"items\\/1775399564_181931_l.webp\"},\"attributes\":{\"id\":2,\"category_id\":\"1\",\"item_code\":\"RM-002\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e01\\u0e25\\u0e48\\u0e2d\\u0e07 50x50x2.3mm\",\"type\":\"consumable\",\"unit\":\"\\u0e40\\u0e2a\\u0e49\\u0e19\",\"current_stock\":120,\"min_stock\":20,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":\"items\\/1775399833_318122_original.webp\",\"status\":\"available\"}}', '2026-04-05 07:37:13', '2026-04-05 07:37:13'),
(10, NULL, 'inventory', 'แก้ไขสินค้า: เหล็กฉาก 40x40x3mm (ID: 3)', 'App\\Models\\Item', 3, '{\"old\":{\"image_url\":null},\"attributes\":{\"id\":3,\"category_id\":\"1\",\"item_code\":\"RM-003\",\"asset_number\":null,\"name\":\"\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\\u0e09\\u0e32\\u0e01 40x40x3mm\",\"type\":\"consumable\",\"unit\":\"\\u0e40\\u0e2a\\u0e49\\u0e19\",\"current_stock\":80,\"min_stock\":15,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a B\",\"image_url\":\"items\\/1775399857_303346_original.webp\",\"status\":\"available\"}}', '2026-04-05 07:37:37', '2026-04-05 07:37:37'),
(11, NULL, 'inventory', 'แก้ไขสินค้า: สแตนเลสแผ่น 304 3mm (ID: 4)', 'App\\Models\\Item', 4, '{\"old\":{\"image_url\":null},\"attributes\":{\"id\":4,\"category_id\":\"1\",\"item_code\":\"RM-004\",\"asset_number\":null,\"name\":\"\\u0e2a\\u0e41\\u0e15\\u0e19\\u0e40\\u0e25\\u0e2a\\u0e41\\u0e1c\\u0e48\\u0e19 304 3mm\",\"type\":\"consumable\",\"unit\":\"\\u0e41\\u0e1c\\u0e48\\u0e19\",\"current_stock\":30,\"min_stock\":5,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a A\",\"image_url\":\"items\\/1775399887_303513_original.webp\",\"status\":\"available\"}}', '2026-04-05 07:38:07', '2026-04-05 07:38:07'),
(12, NULL, 'inventory', 'แก้ไขสินค้า: อลูมิเนียมแผ่น 1.5mm (ID: 5)', 'App\\Models\\Item', 5, '{\"old\":{\"image_url\":null},\"attributes\":{\"id\":5,\"category_id\":\"1\",\"item_code\":\"RM-005\",\"asset_number\":null,\"name\":\"\\u0e2d\\u0e25\\u0e39\\u0e21\\u0e34\\u0e40\\u0e19\\u0e35\\u0e22\\u0e21\\u0e41\\u0e1c\\u0e48\\u0e19 1.5mm\",\"type\":\"consumable\",\"unit\":\"\\u0e41\\u0e1c\\u0e48\\u0e19\",\"current_stock\":40,\"min_stock\":10,\"location\":\"\\u0e04\\u0e25\\u0e31\\u0e07\\u0e27\\u0e31\\u0e15\\u0e16\\u0e38\\u0e14\\u0e34\\u0e1a B\",\"image_url\":\"items\\/1775400037_iTopPlus1081829973600.webp\",\"status\":\"available\"}}', '2026-04-05 07:40:37', '2026-04-05 07:40:37'),
(13, NULL, 'inventory', 'แก้ไขสินค้า: น้ำยาเชื่อมเหล็ก (ID: 6)', 'App\\Models\\Item', 6, '{\"old\":{\"status\":\"available\"},\"attributes\":{\"id\":6,\"category_id\":2,\"item_code\":\"CHM-001\",\"asset_number\":null,\"name\":\"\\u0e19\\u0e49\\u0e33\\u0e22\\u0e32\\u0e40\\u0e0a\\u0e37\\u0e48\\u0e2d\\u0e21\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\",\"type\":\"consumable\",\"unit\":\"\\u0e25\\u0e34\\u0e15\\u0e23\",\"current_stock\":25,\"min_stock\":5,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e2a\\u0e32\\u0e23\\u0e40\\u0e04\\u0e21\\u0e35\",\"image_url\":null,\"status\":\"unavailable\"}}', '2026-04-05 07:50:48', '2026-04-05 07:50:48'),
(14, NULL, 'inventory', 'แก้ไขสินค้า: น้ำยาเชื่อมเหล็ก (ID: 6)', 'App\\Models\\Item', 6, '{\"old\":{\"status\":\"unavailable\"},\"attributes\":{\"id\":6,\"category_id\":2,\"item_code\":\"CHM-001\",\"asset_number\":null,\"name\":\"\\u0e19\\u0e49\\u0e33\\u0e22\\u0e32\\u0e40\\u0e0a\\u0e37\\u0e48\\u0e2d\\u0e21\\u0e40\\u0e2b\\u0e25\\u0e47\\u0e01\",\"type\":\"consumable\",\"unit\":\"\\u0e25\\u0e34\\u0e15\\u0e23\",\"current_stock\":25,\"min_stock\":5,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e2a\\u0e32\\u0e23\\u0e40\\u0e04\\u0e21\\u0e35\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 07:53:58', '2026-04-05 07:53:58'),
(15, 12, 'hr', 'ลบพนักงาน: ADMIN-001 ผู้ดูแล ระบบ (ID: 1)', 'App\\Models\\Employee', 1, '{\"attributes\":{\"id\":1,\"department_id\":8,\"position_id\":12,\"employee_code\":\"ADMIN-001\",\"prefix\":\"\\u0e19\\u0e32\\u0e07\",\"firstname\":\"\\u0e1c\\u0e39\\u0e49\\u0e14\\u0e39\\u0e41\\u0e25\",\"lastname\":\"\\u0e23\\u0e30\\u0e1a\\u0e1a\",\"gender\":\"female\",\"phone\":null,\"address\":null,\"start_date\":\"2026-04-02\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-05 08:36:00', '2026-04-05 08:36:00'),
(16, 32, 'inventory', 'สร้างใบเบิก: #1 (ID: 1)', 'App\\Models\\Requisition', 1, '{\"attributes\":{\"employee_id\":17,\"req_type\":\"consume\",\"status\":\"issued\",\"req_date\":\"2026-04-05\",\"note\":\"\\u0e2d\\u0e34\\u0e2d\\u0e34\",\"approved_by\":32,\"id\":1}}', '2026-04-05 10:29:02', '2026-04-05 10:29:02'),
(17, 32, 'inventory', 'สร้างรายการเบิก: #1 (ID: 1)', 'App\\Models\\RequisitionItem', 1, '{\"attributes\":{\"requisition_id\":1,\"item_id\":\"7\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":1}}', '2026-04-05 10:29:02', '2026-04-05 10:29:02'),
(18, 32, 'inventory', 'แก้ไขสินค้า: Isopropyl Alcohol 99% (ID: 7)', 'App\\Models\\Item', 7, '{\"old\":{\"current_stock\":120},\"attributes\":{\"id\":7,\"category_id\":2,\"item_code\":\"CHM-002\",\"asset_number\":null,\"name\":\"Isopropyl Alcohol 99%\",\"type\":\"disposable\",\"unit\":\"\\u0e25\\u0e34\\u0e15\\u0e23\",\"current_stock\":119,\"min_stock\":50,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e2a\\u0e32\\u0e23\\u0e40\\u0e04\\u0e21\\u0e35\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 10:29:02', '2026-04-05 10:29:02'),
(19, 32, 'inventory', 'สร้างรายการเบิก: #2 (ID: 2)', 'App\\Models\\RequisitionItem', 2, '{\"attributes\":{\"requisition_id\":1,\"item_id\":\"36\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":2}}', '2026-04-05 10:29:02', '2026-04-05 10:29:02'),
(20, 32, 'inventory', 'แก้ไขสินค้า: กระดาษ A4 80 แกรม (ID: 36)', 'App\\Models\\Item', 36, '{\"old\":{\"current_stock\":50},\"attributes\":{\"id\":36,\"category_id\":9,\"item_code\":\"OFF-002\",\"asset_number\":null,\"name\":\"\\u0e01\\u0e23\\u0e30\\u0e14\\u0e32\\u0e29 A4 80 \\u0e41\\u0e01\\u0e23\\u0e21\",\"type\":\"disposable\",\"unit\":\"\\u0e23\\u0e35\\u0e21\",\"current_stock\":49,\"min_stock\":10,\"location\":\"\\u0e2a\\u0e33\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 10:29:02', '2026-04-05 10:29:02'),
(21, 32, 'inventory', 'สร้างใบเบิก: #2 (ID: 2)', 'App\\Models\\Requisition', 2, '{\"attributes\":{\"employee_id\":17,\"req_type\":\"consume\",\"status\":\"issued\",\"req_date\":\"2026-04-05\",\"note\":\"\\u0e2d\\u0e34\\u0e2d\\u0e34\",\"approved_by\":32,\"id\":2}}', '2026-04-05 10:29:05', '2026-04-05 10:29:05'),
(22, 32, 'inventory', 'สร้างรายการเบิก: #3 (ID: 3)', 'App\\Models\\RequisitionItem', 3, '{\"attributes\":{\"requisition_id\":2,\"item_id\":\"7\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":3}}', '2026-04-05 10:29:05', '2026-04-05 10:29:05'),
(23, 32, 'inventory', 'แก้ไขสินค้า: Isopropyl Alcohol 99% (ID: 7)', 'App\\Models\\Item', 7, '{\"old\":{\"current_stock\":119},\"attributes\":{\"id\":7,\"category_id\":2,\"item_code\":\"CHM-002\",\"asset_number\":null,\"name\":\"Isopropyl Alcohol 99%\",\"type\":\"disposable\",\"unit\":\"\\u0e25\\u0e34\\u0e15\\u0e23\",\"current_stock\":118,\"min_stock\":50,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e2a\\u0e32\\u0e23\\u0e40\\u0e04\\u0e21\\u0e35\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 10:29:05', '2026-04-05 10:29:05'),
(24, 32, 'inventory', 'สร้างรายการเบิก: #4 (ID: 4)', 'App\\Models\\RequisitionItem', 4, '{\"attributes\":{\"requisition_id\":2,\"item_id\":\"36\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":4}}', '2026-04-05 10:29:05', '2026-04-05 10:29:05'),
(25, 32, 'inventory', 'แก้ไขสินค้า: กระดาษ A4 80 แกรม (ID: 36)', 'App\\Models\\Item', 36, '{\"old\":{\"current_stock\":49},\"attributes\":{\"id\":36,\"category_id\":9,\"item_code\":\"OFF-002\",\"asset_number\":null,\"name\":\"\\u0e01\\u0e23\\u0e30\\u0e14\\u0e32\\u0e29 A4 80 \\u0e41\\u0e01\\u0e23\\u0e21\",\"type\":\"disposable\",\"unit\":\"\\u0e23\\u0e35\\u0e21\",\"current_stock\":48,\"min_stock\":10,\"location\":\"\\u0e2a\\u0e33\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 10:29:05', '2026-04-05 10:29:05'),
(26, 32, 'inventory', 'สร้างใบเบิก: #3 (ID: 3)', 'App\\Models\\Requisition', 3, '{\"attributes\":{\"employee_id\":17,\"req_type\":\"consume\",\"status\":\"issued\",\"req_date\":\"2026-04-05\",\"note\":\"\\u0e2d\\u0e34\\u0e2d\\u0e34\",\"approved_by\":32,\"id\":3}}', '2026-04-05 10:29:10', '2026-04-05 10:29:10'),
(27, 32, 'inventory', 'สร้างรายการเบิก: #5 (ID: 5)', 'App\\Models\\RequisitionItem', 5, '{\"attributes\":{\"requisition_id\":3,\"item_id\":\"7\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":5}}', '2026-04-05 10:29:10', '2026-04-05 10:29:10'),
(28, 32, 'inventory', 'แก้ไขสินค้า: Isopropyl Alcohol 99% (ID: 7)', 'App\\Models\\Item', 7, '{\"old\":{\"current_stock\":118},\"attributes\":{\"id\":7,\"category_id\":2,\"item_code\":\"CHM-002\",\"asset_number\":null,\"name\":\"Isopropyl Alcohol 99%\",\"type\":\"disposable\",\"unit\":\"\\u0e25\\u0e34\\u0e15\\u0e23\",\"current_stock\":117,\"min_stock\":50,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e2a\\u0e32\\u0e23\\u0e40\\u0e04\\u0e21\\u0e35\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 10:29:10', '2026-04-05 10:29:10'),
(29, 32, 'inventory', 'สร้างรายการเบิก: #6 (ID: 6)', 'App\\Models\\RequisitionItem', 6, '{\"attributes\":{\"requisition_id\":3,\"item_id\":\"36\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":6}}', '2026-04-05 10:29:10', '2026-04-05 10:29:10'),
(30, 32, 'inventory', 'แก้ไขสินค้า: กระดาษ A4 80 แกรม (ID: 36)', 'App\\Models\\Item', 36, '{\"old\":{\"current_stock\":48},\"attributes\":{\"id\":36,\"category_id\":9,\"item_code\":\"OFF-002\",\"asset_number\":null,\"name\":\"\\u0e01\\u0e23\\u0e30\\u0e14\\u0e32\\u0e29 A4 80 \\u0e41\\u0e01\\u0e23\\u0e21\",\"type\":\"disposable\",\"unit\":\"\\u0e23\\u0e35\\u0e21\",\"current_stock\":47,\"min_stock\":10,\"location\":\"\\u0e2a\\u0e33\\u0e19\\u0e31\\u0e01\\u0e07\\u0e32\\u0e19\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 10:29:10', '2026-04-05 10:29:10'),
(31, 32, 'inventory', 'สร้างใบเบิก: #4 (ID: 4)', 'App\\Models\\Requisition', 4, '{\"attributes\":{\"employee_id\":17,\"req_type\":\"consume\",\"status\":\"issued\",\"req_date\":\"2026-04-05\",\"note\":\"\\u0e40\\u0e17\\u0e2a\",\"approved_by\":32,\"id\":4}}', '2026-04-05 10:29:50', '2026-04-05 10:29:50'),
(32, 32, 'inventory', 'สร้างรายการเบิก: #7 (ID: 7)', 'App\\Models\\RequisitionItem', 7, '{\"attributes\":{\"requisition_id\":4,\"item_id\":\"7\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":7}}', '2026-04-05 10:29:50', '2026-04-05 10:29:50'),
(33, 32, 'inventory', 'แก้ไขสินค้า: Isopropyl Alcohol 99% (ID: 7)', 'App\\Models\\Item', 7, '{\"old\":{\"current_stock\":117},\"attributes\":{\"id\":7,\"category_id\":2,\"item_code\":\"CHM-002\",\"asset_number\":null,\"name\":\"Isopropyl Alcohol 99%\",\"type\":\"disposable\",\"unit\":\"\\u0e25\\u0e34\\u0e15\\u0e23\",\"current_stock\":116,\"min_stock\":50,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e2a\\u0e32\\u0e23\\u0e40\\u0e04\\u0e21\\u0e35\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 10:29:50', '2026-04-05 10:29:50'),
(34, 32, 'inventory', 'สร้างใบเบิก: #5 (ID: 5)', 'App\\Models\\Requisition', 5, '{\"attributes\":{\"employee_id\":17,\"req_type\":\"consume\",\"status\":\"issued\",\"req_date\":\"2026-04-05T00:00:00.000000Z\",\"note\":\"\\u0e40\\u0e17\\u0e2a\",\"approved_by\":32,\"id\":5}}', '2026-04-05 10:39:42', '2026-04-05 10:39:42'),
(35, 32, 'inventory', 'สร้างรายการเบิก: #8 (ID: 8)', 'App\\Models\\RequisitionItem', 8, '{\"attributes\":{\"requisition_id\":5,\"item_id\":\"7\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":8}}', '2026-04-05 10:39:42', '2026-04-05 10:39:42'),
(36, 32, 'inventory', 'แก้ไขสินค้า: Isopropyl Alcohol 99% (ID: 7)', 'App\\Models\\Item', 7, '{\"old\":{\"current_stock\":116},\"attributes\":{\"id\":7,\"category_id\":2,\"item_code\":\"CHM-002\",\"asset_number\":null,\"name\":\"Isopropyl Alcohol 99%\",\"type\":\"disposable\",\"unit\":\"\\u0e25\\u0e34\\u0e15\\u0e23\",\"current_stock\":115,\"min_stock\":50,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e2a\\u0e32\\u0e23\\u0e40\\u0e04\\u0e21\\u0e35\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 10:39:42', '2026-04-05 10:39:42'),
(37, 30, 'inventory', 'สร้างใบเบิก: #6 (ID: 6)', 'App\\Models\\Requisition', 6, '{\"attributes\":{\"employee_id\":15,\"req_type\":\"consume\",\"status\":\"issued\",\"req_date\":\"2026-04-06T00:00:00.000000Z\",\"note\":null,\"approved_by\":30,\"id\":6}}', '2026-04-05 19:42:59', '2026-04-05 19:42:59'),
(38, 30, 'inventory', 'สร้างรายการเบิก: #9 (ID: 9)', 'App\\Models\\RequisitionItem', 9, '{\"attributes\":{\"requisition_id\":6,\"item_id\":\"7\",\"quantity_requested\":\"5\",\"quantity_returned\":0,\"id\":9}}', '2026-04-05 19:42:59', '2026-04-05 19:42:59'),
(39, 30, 'inventory', 'แก้ไขสินค้า: Isopropyl Alcohol 99% (ID: 7)', 'App\\Models\\Item', 7, '{\"old\":{\"current_stock\":115},\"attributes\":{\"id\":7,\"category_id\":2,\"item_code\":\"CHM-002\",\"asset_number\":null,\"name\":\"Isopropyl Alcohol 99%\",\"type\":\"disposable\",\"unit\":\"\\u0e25\\u0e34\\u0e15\\u0e23\",\"current_stock\":110,\"min_stock\":50,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e2a\\u0e32\\u0e23\\u0e40\\u0e04\\u0e21\\u0e35\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 19:42:59', '2026-04-05 19:42:59'),
(40, 12, 'hr', 'แก้ไขพนักงาน: ACC-002 ธนวัตต์ บัญชี (ID: 25)', 'App\\Models\\Employee', 25, '{\"old\":{\"status\":\"active\"},\"attributes\":{\"id\":25,\"department_id\":8,\"position_id\":14,\"employee_code\":\"ACC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e27\\u0e31\\u0e15\\u0e15\\u0e4c\",\"lastname\":\"\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\",\"gender\":\"male\",\"phone\":\"083-444-5555\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"inactive\",\"profile_image\":null}}', '2026-04-05 20:40:15', '2026-04-05 20:40:15'),
(41, 12, 'hr', 'แก้ไขพนักงาน: ACC-002 ธนวัตต์ บัญชี (ID: 25)', 'App\\Models\\Employee', 25, '{\"old\":{\"status\":\"inactive\"},\"attributes\":{\"id\":25,\"department_id\":8,\"position_id\":14,\"employee_code\":\"ACC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e27\\u0e31\\u0e15\\u0e15\\u0e4c\",\"lastname\":\"\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\",\"gender\":\"male\",\"phone\":\"083-444-5555\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-05 20:40:19', '2026-04-05 20:40:19'),
(42, 12, 'hr', 'แก้ไขพนักงาน: ACC-002 ธนวัตต์ บัญชี (ID: 25)', 'App\\Models\\Employee', 25, '{\"old\":{\"status\":\"active\"},\"attributes\":{\"id\":25,\"department_id\":8,\"position_id\":14,\"employee_code\":\"ACC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e27\\u0e31\\u0e15\\u0e15\\u0e4c\",\"lastname\":\"\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\",\"gender\":\"male\",\"phone\":\"083-444-5555\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"inactive\",\"profile_image\":null}}', '2026-04-05 20:42:28', '2026-04-05 20:42:28'),
(43, 12, 'hr', 'แก้ไขพนักงาน: ACC-002 ธนวัตต์ บัญชี (ID: 25)', 'App\\Models\\Employee', 25, '{\"old\":{\"status\":\"inactive\"},\"attributes\":{\"id\":25,\"department_id\":8,\"position_id\":14,\"employee_code\":\"ACC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e27\\u0e31\\u0e15\\u0e15\\u0e4c\",\"lastname\":\"\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\",\"gender\":\"male\",\"phone\":\"083-444-5555\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":null}}', '2026-04-05 20:42:31', '2026-04-05 20:42:31'),
(44, 12, 'inventory', 'สร้างใบเบิก: #7 (ID: 7)', 'App\\Models\\Requisition', 7, '{\"attributes\":{\"employee_id\":\"15\",\"req_type\":\"borrow\",\"status\":\"approved\",\"req_date\":\"2026-04-06T00:00:00.000000Z\",\"due_date\":\"2026-04-07T00:00:00.000000Z\",\"note\":null,\"approved_by\":12,\"id\":7}}', '2026-04-05 20:45:14', '2026-04-05 20:45:14'),
(45, 12, 'inventory', 'สร้างรายการเบิก: #10 (ID: 10)', 'App\\Models\\RequisitionItem', 10, '{\"attributes\":{\"requisition_id\":7,\"item_id\":\"23\",\"quantity_requested\":\"1\",\"quantity_returned\":0,\"id\":10}}', '2026-04-05 20:45:14', '2026-04-05 20:45:14'),
(46, 12, 'inventory', 'แก้ไขสินค้า: ตลับเมตร 5m (ID: 23)', 'App\\Models\\Item', 23, '{\"old\":{\"current_stock\":20},\"attributes\":{\"id\":23,\"category_id\":5,\"item_code\":\"TLS-005\",\"asset_number\":null,\"name\":\"\\u0e15\\u0e25\\u0e31\\u0e1a\\u0e40\\u0e21\\u0e15\\u0e23 5m\",\"type\":\"returnable\",\"unit\":\"\\u0e2d\\u0e31\\u0e19\",\"current_stock\":19,\"min_stock\":5,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e21\\u0e37\\u0e2d\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 20:45:14', '2026-04-05 20:45:14'),
(47, 12, 'inventory', 'แก้ไขรายการเบิก: #10 (ID: 10)', 'App\\Models\\RequisitionItem', 10, '{\"old\":{\"quantity_returned\":0},\"attributes\":{\"id\":10,\"requisition_id\":7,\"item_id\":23,\"quantity_requested\":1,\"quantity_returned\":1}}', '2026-04-05 20:53:06', '2026-04-05 20:53:06'),
(48, 12, 'inventory', 'แก้ไขสินค้า: ตลับเมตร 5m (ID: 23)', 'App\\Models\\Item', 23, '{\"old\":{\"current_stock\":19},\"attributes\":{\"id\":23,\"category_id\":5,\"item_code\":\"TLS-005\",\"asset_number\":null,\"name\":\"\\u0e15\\u0e25\\u0e31\\u0e1a\\u0e40\\u0e21\\u0e15\\u0e23 5m\",\"type\":\"returnable\",\"unit\":\"\\u0e2d\\u0e31\\u0e19\",\"current_stock\":20,\"min_stock\":5,\"location\":\"\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\\u0e21\\u0e37\\u0e2d\",\"image_url\":null,\"status\":\"available\"}}', '2026-04-05 20:53:06', '2026-04-05 20:53:06'),
(49, 12, 'inventory', 'แก้ไขใบเบิก: #7 (ID: 7)', 'App\\Models\\Requisition', 7, '{\"old\":{\"status\":\"approved\"},\"attributes\":{\"id\":7,\"employee_id\":15,\"req_type\":\"borrow\",\"status\":\"returned_all\",\"req_date\":\"2026-04-06T00:00:00.000000Z\",\"period\":null,\"due_date\":\"2026-04-07T00:00:00.000000Z\",\"note\":null,\"approved_by\":12}}', '2026-04-05 20:53:06', '2026-04-05 20:53:06'),
(50, 12, 'hr', 'แก้ไขพนักงาน: ACC-002 ธนวัตต์ บัญชี (ID: 25)', 'App\\Models\\Employee', 25, '{\"old\":{\"profile_image\":null},\"attributes\":{\"id\":25,\"department_id\":8,\"position_id\":14,\"employee_code\":\"ACC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e27\\u0e31\\u0e15\\u0e15\\u0e4c\",\"lastname\":\"\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\",\"gender\":\"male\",\"phone\":\"083-444-5555\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":\"employees\\/employee_25_1775453554.png\"}}', '2026-04-05 22:32:34', '2026-04-05 22:32:34'),
(51, 12, 'hr', 'แก้ไขพนักงาน: ACC-002 ธนวัตต์ โอว้าว (ID: 25)', 'App\\Models\\Employee', 25, '{\"old\":{\"lastname\":\"\\u0e1a\\u0e31\\u0e0d\\u0e0a\\u0e35\"},\"attributes\":{\"id\":25,\"department_id\":\"8\",\"position_id\":\"14\",\"employee_code\":\"ACC-002\",\"prefix\":\"\\u0e19\\u0e32\\u0e22\",\"firstname\":\"\\u0e18\\u0e19\\u0e27\\u0e31\\u0e15\\u0e15\\u0e4c\",\"lastname\":\"\\u0e42\\u0e2d\\u0e27\\u0e49\\u0e32\\u0e27\",\"gender\":\"male\",\"phone\":\"083-444-5555\",\"address\":null,\"start_date\":\"2026-04-01\",\"status\":\"active\",\"profile_image\":\"employees\\/employee_25_1775453554.png\"}}', '2026-04-05 22:33:05', '2026-04-05 22:33:05');

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
('laravel-cache-unread_count_12', 'i:0;', 1775455301);

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
(1, 'ฝ่ายขาย (Sales)', NULL, 2, '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(2, 'วิศวกรรม (Engineering)', NULL, 3, '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(3, 'ฝ่ายผลิต (Production)', NULL, 4, '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(4, 'ควบคุมคุณภาพ (QC/QA)', NULL, 5, '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(5, 'ติดตั้ง (Site)', NULL, NULL, '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(6, 'จัดซื้อ (Procurement)', NULL, 3, '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(7, 'คลังสินค้า (Warehouse)', NULL, 3, '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(8, 'บริหาร (Admin/HR/บัญชี)', NULL, NULL, '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL);

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
(1, 8, 12, 'ADMIN-001', 'นาง', 'ผู้ดูแล', 'ระบบ', 'female', NULL, NULL, '2026-04-02', 'active', NULL, '2026-04-02 03:23:56', '2026-04-05 08:36:00', '2026-04-05 08:36:00'),
(2, 1, 1, 'SAL-001', 'นาย', 'สมชาย', 'วงศ์สวัสดิ์', 'male', '081-234-5678', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(3, 1, 2, 'SAL-002', 'นางสาว', 'สุภาวดี', 'จันทร์เพ็ญ', 'female', '089-876-5432', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(4, 1, 2, 'SAL-003', 'นาย', 'ธนกร', 'รัตนชัย', 'male', '062-345-6789', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(5, 2, 3, 'ENG-001', 'นาย', 'กิตติ', 'พัฒนาพงศ์', 'male', '083-456-7890', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(6, 2, 4, 'ENG-002', 'นาย', 'วิชัย', 'แก้วมณี', 'male', '095-567-8901', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(7, 2, 4, 'ENG-003', 'นางสาว', 'พิมพ์ใจ', 'สุขสมบูรณ์', 'female', '087-678-9012', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(8, 3, 5, 'PRD-001', 'นาย', 'ประสิทธิ์', 'การช่าง', 'male', '084-789-0123', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(9, 3, 6, 'PRD-002', 'นาย', 'มงคล', 'เหล็กกล้า', 'male', '091-890-1234', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(10, 3, 6, 'PRD-003', 'นาย', 'บุญมี', 'ช่างเชื่อม', 'male', '063-901-2345', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(11, 3, 6, 'PRD-004', 'นาย', 'สุรชัย', 'ประกอบกิจ', 'male', '088-012-3456', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(12, 3, 6, 'PRD-005', 'นาย', 'อภิชาติ', 'ผลิตผล', 'male', '092-123-4567', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(13, 4, 7, 'QC-001', 'นาย', 'ชัยวัฒน์', 'ตรวจดี', 'male', '085-234-5678', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(14, 4, 7, 'QC-002', 'นางสาว', 'รัตนา', 'คุณภาพ', 'female', '096-345-6789', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(15, 5, 8, 'SIT-001', 'นาย', 'พีรพัฒน์', 'หน้างาน', 'male', '086-456-7890', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(16, 5, 9, 'SIT-002', 'นาย', 'อนุชา', 'ติดตั้ง', 'male', '093-567-8901', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(17, 5, 9, 'SIT-003', 'นาย', 'ธนพล', 'ไซต์งาน', 'male', '064-678-9012', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(18, 6, 10, 'PUR-001', 'นางสาว', 'จิดาภา', 'จัดซื้อ', 'female', '082-789-0123', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(19, 6, 10, 'PUR-002', 'นาย', ' กรกฎ', 'หามา', 'male', '094-890-1234', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(20, 7, 11, 'WH-001', 'นาย', 'วิรัตน์', 'คลังสินค้า', 'male', '081-901-2345', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(21, 7, 11, 'WH-002', 'นาย', 'สมบัติ', 'เบิกจ่าย', 'male', '097-012-3456', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(22, 8, 12, 'ADM-001', 'นาง', 'ผู้ดูแล', 'ระบบ', 'female', '080-111-2222', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(23, 8, 13, 'HR-001', 'นางสาว', 'กัลยา', 'บุคคล', 'female', '089-222-3333', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(24, 8, 14, 'ACC-001', 'นางสาว', 'พิชชา', 'การเงิน', 'female', '062-333-4444', NULL, '2026-04-01', 'active', NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37', NULL),
(25, 8, 14, 'ACC-002', 'นาย', 'ธนวัตต์', 'โอว้าว', 'male', '083-444-5555', NULL, '2026-04-01', 'active', 'employees/employee_25_1775453554.png', '2026-04-05 15:35:37', '2026-04-05 22:33:05', NULL);

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
(1, 1, 'RM-001', NULL, 'เหล็กแผ่น SS400 8mm', 'disposable', 'แผ่น', 50, 10, 'คลังวัตถุดิบ A', 'items/1775399770_181931_l.webp', 'available', '2026-04-05 14:00:54', '2026-04-05 07:36:10', NULL),
(2, 1, 'RM-002', NULL, 'เหล็กกล่อง 50x50x2.3mm', 'disposable', 'เส้น', 120, 20, 'คลังวัตถุดิบ A', 'items/1775399833_318122_original.webp', 'available', '2026-04-05 14:00:54', '2026-04-05 07:37:13', NULL),
(3, 1, 'RM-003', NULL, 'เหล็กฉาก 40x40x3mm', 'disposable', 'เส้น', 80, 15, 'คลังวัตถุดิบ B', 'items/1775399857_303346_original.webp', 'available', '2026-04-05 14:00:54', '2026-04-05 07:37:37', NULL),
(4, 1, 'RM-004', NULL, 'สแตนเลสแผ่น 304 3mm', 'disposable', 'แผ่น', 30, 5, 'คลังวัตถุดิบ A', 'items/1775399887_303513_original.webp', 'available', '2026-04-05 14:00:54', '2026-04-05 07:38:07', NULL),
(5, 1, 'RM-005', NULL, 'อลูมิเนียมแผ่น 1.5mm', 'disposable', 'แผ่น', 40, 10, 'คลังวัตถุดิบ B', 'items/1775400037_iTopPlus1081829973600.webp', 'available', '2026-04-05 14:00:54', '2026-04-05 07:40:37', NULL),
(6, 2, 'CHM-001', NULL, 'น้ำยาเชื่อมเหล็ก', 'disposable', 'ลิตร', 25, 5, 'ห้องสารเคมี', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 07:53:58', NULL),
(7, 2, 'CHM-002', NULL, 'Isopropyl Alcohol 99%', 'disposable', 'ลิตร', 110, 50, 'ห้องสารเคมี', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 19:42:59', NULL),
(8, 2, 'CHM-003', NULL, 'น้ำยาล้างคราบไขมัน', 'disposable', 'ลิตร', 40, 10, 'ห้องสารเคมี', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(9, 2, 'CHM-004', NULL, 'สีพ่นอุตสาหกรรม สีเทา', 'disposable', 'กระป๋อง', 60, 15, 'ห้องสารเคมี', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(10, 3, 'MSP-001', NULL, 'สายพานมอเตอร์ 3HP', 'disposable', 'เส้น', 8, 2, 'ห้องอะไหล่', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(11, 3, 'MSP-002', NULL, 'ตลับลูกปืน 6205', 'disposable', 'ลูก', 15, 5, 'ห้องอะไหล่', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(12, 3, 'MSP-003', NULL, 'ใบมีดตัดเหล็ก', 'disposable', 'แผ่น', 20, 5, 'ห้องอะไหล่', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(13, 3, 'MSP-004', NULL, 'หัวเชื่อม MIG', 'disposable', 'อัน', 30, 10, 'ห้องอะไหล่', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(14, 4, 'SAF-001', NULL, 'หมวกนิรภัย', 'returnable', 'ใบ', 25, 10, 'ห้องเซฟตี้', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(15, 4, 'SAF-002', NULL, 'แว่นตานิรภัย', 'returnable', 'อัน', 40, 15, 'ห้องเซฟตี้', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(16, 4, 'SAF-003', NULL, 'ถุงมือกันความร้อน', 'disposable', 'คู่', 60, 20, 'ห้องเซฟตี้', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(17, 4, 'SAF-004', NULL, 'รองเท้าเซฟตี้', 'returnable', 'คู่', 20, 5, 'ห้องเซฟตี้', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(18, 4, 'SAF-005', NULL, 'ที่อุดหูกันเสียง', 'disposable', 'คู่', 100, 30, 'ห้องเซฟตี้', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(19, 5, 'TLS-001', NULL, 'เครื่องเจียร 4 นิ้ว', 'returnable', 'เครื่อง', 10, 3, 'ห้องเครื่องมือ', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(20, 5, 'TLS-002', NULL, 'ประแจเลื่อน 12 นิ้ว', 'returnable', 'อัน', 15, 5, 'ห้องเครื่องมือ', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(21, 5, 'TLS-003', NULL, 'ชุดประแจบล็อก', 'returnable', 'ชุด', 5, 2, 'ห้องเครื่องมือ', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(22, 5, 'TLS-004', NULL, 'สว่านไฟฟ้า', 'returnable', 'เครื่อง', 8, 2, 'ห้องเครื่องมือ', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(23, 5, 'TLS-005', NULL, 'ตลับเมตร 5m', 'returnable', 'อัน', 20, 5, 'ห้องเครื่องมือ', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 20:53:06', NULL),
(24, 6, 'PKG-001', NULL, 'กล่องกระดาษลูกฟูก 60x40x40', 'disposable', 'ใบ', 200, 50, 'คลังบรรจุภัณฑ์', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(25, 6, 'PKG-002', NULL, 'พลาสติกกันกระแทก', 'disposable', 'ม้วน', 30, 10, 'คลังบรรจุภัณฑ์', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(26, 6, 'PKG-003', NULL, 'เทปกาวใส 2 นิ้ว', 'disposable', 'ม้วน', 100, 30, 'คลังบรรจุภัณฑ์', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(27, 6, 'PKG-004', NULL, 'สายรัด PP', 'disposable', 'ม้วน', 25, 5, 'คลังบรรจุภัณฑ์', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(28, 7, 'ELC-001', NULL, 'เบรกเกอร์ 3P 30A', 'disposable', 'ตัว', 10, 3, 'ห้องไฟฟ้า', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(29, 7, 'ELC-002', NULL, 'สายไฟ VCT 3x2.5 sq.mm.', 'disposable', 'ม้วน', 15, 5, 'ห้องไฟฟ้า', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(30, 7, 'ELC-003', NULL, 'ปลั๊กอุตสาหกรรม 3P', 'disposable', 'ตัว', 20, 5, 'ห้องไฟฟ้า', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(31, 7, 'ELC-004', NULL, 'หลอด LED 18W', 'disposable', 'ดวง', 40, 10, 'ห้องไฟฟ้า', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(32, 8, 'LUB-001', NULL, 'น้ำมันเครื่อง SAE 40', 'disposable', 'ลิตร', 50, 10, 'ห้องน้ำมัน', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(33, 8, 'LUB-002', NULL, 'จารบีอเนกประสงค์', 'disposable', 'กระป๋อง', 30, 10, 'ห้องน้ำมัน', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(34, 8, 'LUB-003', NULL, 'น้ำมันไฮดรอลิก ISO 46', 'disposable', 'ลิตร', 80, 20, 'ห้องน้ำมัน', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(35, 9, 'OFF-001', NULL, 'ปากกาลูกลื่น น้ำเงิน', 'disposable', 'ด้าม', 100, 20, 'สำนักงาน', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(36, 9, 'OFF-002', NULL, 'กระดาษ A4 80 แกรม', 'disposable', 'รีม', 47, 10, 'สำนักงาน', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 10:29:10', NULL),
(37, 9, 'OFF-003', NULL, 'แฟ้มเอกสาร', 'disposable', 'อัน', 40, 10, 'สำนักงาน', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(38, 9, 'OFF-004', NULL, 'ดินสอ 2B', 'disposable', 'แท่ง', 80, 20, 'สำนักงาน', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(39, 10, 'CLN-001', NULL, 'น้ำยาถูพื้น', 'disposable', 'ลิตร', 30, 5, 'ห้องทำความสะอาด', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(40, 10, 'CLN-002', NULL, 'ไม้กวาดดอกหญ้า', 'disposable', 'อัน', 15, 5, 'ห้องทำความสะอาด', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(41, 10, 'CLN-003', NULL, 'ถังขยะ 60 ลิตร', 'returnable', 'ใบ', 10, 3, 'ห้องทำความสะอาด', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(42, 10, 'CLN-004', NULL, 'ผ้าขี้ริ้ว', 'disposable', 'กก.', 20, 5, 'ห้องทำความสะอาด', NULL, 'available', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `prefix` varchar(10) DEFAULT NULL COMMENT 'ตัวย่อหมวดหมู่ เช่น SAF, TLS',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name`, `prefix`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Raw Materials', 'RM', 'วัตถุดิบหลักที่ใช้สำหรับกระบวนการผลิต', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(2, 'Chemical', 'CHM', 'สารเคมีที่ใช้ในโรงงานและในกระบวนการผลิต', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(3, 'Machine Spare Parts', 'MSP', 'อะไหล่เครื่องจักรและอุปกรณ์', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(4, 'Safety Equipment', 'SAF', 'อุปกรณ์ความปลอดภัย', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(5, 'Tools', 'TLS', 'เครื่องมือช่าง', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(6, 'Packaging', 'PKG', 'วัสดุบรรจุภัณฑ์', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(7, 'Electrical Parts', 'ELC', 'อุปกรณ์ไฟฟ้า', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(8, 'Lubricants', 'LUB', 'น้ำมันหล่อลื่น', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(9, 'Office Supplies', 'OFF', 'อุปกรณ์สำนักงาน', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL),
(10, 'Cleaning Materials', 'CLN', 'อุปกรณ์ทำความสะอาด', '2026-04-05 14:00:54', '2026-04-05 14:00:54', NULL);

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
(15, '2026_04_05_000000_add_transaction_types_to_stock_transactions', 2),
(16, '2026_04_05_071644_add_contact_info_to_employees_table', 3),
(17, '2026_04_05_074011_add_soft_deletes_to_important_tables', 4),
(18, '2026_04_05_080551_create_notifications_table', 5),
(19, '2026_04_05_082143_add_constraints_and_indexes', 6),
(20, '2026_04_05_100000_create_activity_logs_table', 7),
(21, '2026_04_05_084053_add_stock_constraint', 8),
(22, '2026_04_05_163004_create_permissions_table', 9),
(23, '2026_04_05_163020_create_role_permissions_table', 9),
(24, '2026_04_05_163355_add_returnable_type_to_items', 10),
(25, '2026_04_05_163645_add_period_to_requisitions_table', 11),
(26, '2026_04_05_172555_add_issued_status_to_requisitions', 12);

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
('19afa5cc-8d22-4438-8937-4f1c6791fdf2', 'App\\Notifications\\RequisitionSubmitted', 'App\\Models\\User', 12, '{\"type\":\"requisition_submitted\",\"icon\":\"bi-file-earmark-text\",\"color\":\"primary\",\"title\":\"\\u0e21\\u0e35\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e43\\u0e2b\\u0e21\\u0e48\\u0e23\\u0e2d\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\",\"message\":\"\\u0e1e\\u0e35\\u0e23\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e4c \\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19 \\u0e44\\u0e14\\u0e49\\u0e22\\u0e37\\u0e48\\u0e19\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e27\\u0e31\\u0e19\\u0e17\\u0e35\\u0e48 06\\/04\\/2026\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/inventory\\/requisition\\/6\\/approve\",\"action_text\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\",\"requisition_id\":6}', '2026-04-05 20:51:35', '2026-04-05 19:43:00', '2026-04-05 20:51:35'),
('275e594a-2230-421b-8773-42635dcaeec4', 'App\\Notifications\\RequisitionSubmitted', 'App\\Models\\User', 14, '{\"type\":\"requisition_submitted\",\"icon\":\"bi-file-earmark-text\",\"color\":\"primary\",\"title\":\"\\u0e21\\u0e35\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e43\\u0e2b\\u0e21\\u0e48\\u0e23\\u0e2d\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\",\"message\":\"\\u0e1e\\u0e35\\u0e23\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e4c \\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19 \\u0e44\\u0e14\\u0e49\\u0e22\\u0e37\\u0e48\\u0e19\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e27\\u0e31\\u0e19\\u0e17\\u0e35\\u0e48 06\\/04\\/2026\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/inventory\\/requisition\\/6\\/approve\",\"action_text\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\",\"requisition_id\":6}', NULL, '2026-04-05 19:43:00', '2026-04-05 19:43:00'),
('40ac5983-4819-4b13-8985-531523567df4', 'App\\Notifications\\RequisitionSubmitted', 'App\\Models\\User', 14, '{\"type\":\"requisition_submitted\",\"icon\":\"bi-file-earmark-text\",\"color\":\"primary\",\"title\":\"\\u0e21\\u0e35\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e43\\u0e2b\\u0e21\\u0e48\\u0e23\\u0e2d\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\",\"message\":\"\\u0e18\\u0e19\\u0e1e\\u0e25 \\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19 \\u0e44\\u0e14\\u0e49\\u0e22\\u0e37\\u0e48\\u0e19\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e27\\u0e31\\u0e19\\u0e17\\u0e35\\u0e48 05\\/04\\/2026\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/inventory\\/requisition\\/5\\/approve\",\"action_text\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\",\"requisition_id\":5}', NULL, '2026-04-05 10:39:43', '2026-04-05 10:39:43'),
('5c87ae88-0226-48f5-a154-30c65ad29889', 'App\\Notifications\\RequisitionSubmitted', 'App\\Models\\User', 12, '{\"type\":\"requisition_submitted\",\"icon\":\"bi-file-earmark-text\",\"color\":\"primary\",\"title\":\"\\u0e21\\u0e35\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e43\\u0e2b\\u0e21\\u0e48\\u0e23\\u0e2d\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\",\"message\":\"\\u0e18\\u0e19\\u0e1e\\u0e25 \\u0e44\\u0e0b\\u0e15\\u0e4c\\u0e07\\u0e32\\u0e19 \\u0e44\\u0e14\\u0e49\\u0e22\\u0e37\\u0e48\\u0e19\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e27\\u0e31\\u0e19\\u0e17\\u0e35\\u0e48 05\\/04\\/2026\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/inventory\\/requisition\\/5\\/approve\",\"action_text\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\",\"requisition_id\":5}', '2026-04-05 11:33:47', '2026-04-05 10:39:43', '2026-04-05 11:33:47'),
('bde5584c-d909-42ee-968c-925e129525b6', 'App\\Notifications\\RequisitionSubmitted', 'App\\Models\\User', 35, '{\"type\":\"requisition_submitted\",\"icon\":\"bi-file-earmark-text\",\"color\":\"primary\",\"title\":\"\\u0e21\\u0e35\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e43\\u0e2b\\u0e21\\u0e48\\u0e23\\u0e2d\\u0e2d\\u0e19\\u0e38\\u0e21\\u0e31\\u0e15\\u0e34\",\"message\":\"\\u0e1e\\u0e35\\u0e23\\u0e1e\\u0e31\\u0e12\\u0e19\\u0e4c \\u0e2b\\u0e19\\u0e49\\u0e32\\u0e07\\u0e32\\u0e19 \\u0e44\\u0e14\\u0e49\\u0e22\\u0e37\\u0e48\\u0e19\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\\u0e27\\u0e31\\u0e19\\u0e17\\u0e35\\u0e48 06\\/04\\/2026\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/inventory\\/requisition\\/6\\/approve\",\"action_text\":\"\\u0e15\\u0e23\\u0e27\\u0e08\\u0e2a\\u0e2d\\u0e1a\\u0e43\\u0e1a\\u0e40\\u0e1a\\u0e34\\u0e01\",\"requisition_id\":6}', NULL, '2026-04-05 19:43:00', '2026-04-05 19:43:00');

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

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `module_key`, `module_name`, `module_icon`, `permission_key`, `permission_name`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'hr.dashboard', 'แดชบอร์ด HR', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(2, 'admin.dashboard', 'แดชบอร์ด Admin', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(3, 'manager.dashboard', 'แดชบอร์ด Manager', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(4, 'inventory.dashboard', 'แดชบอร์ดคลังสินค้า', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(5, 'employee.dashboard', 'แดชบอร์ดพนักงาน', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(6, 'hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'view', 'ดูรายการ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(7, 'hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'create', 'เพิ่มพนักงาน', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(8, 'hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'edit', 'แก้ไขข้อมูล', 3, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(9, 'hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'delete', 'ลบพนักงาน', 4, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(10, 'hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'export', 'Export Excel', 5, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(11, 'hr.departments', 'จัดการแผนก', 'fas fa-building', 'view', 'ดูรายการ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(12, 'hr.departments', 'จัดการแผนก', 'fas fa-building', 'create', 'เพิ่มแผนก', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(13, 'hr.departments', 'จัดการแผนก', 'fas fa-building', 'edit', 'แก้ไขแผนก', 3, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(14, 'hr.departments', 'จัดการแผนก', 'fas fa-building', 'delete', 'ลบแผนก', 4, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(15, 'hr.positions', 'จัดการตำแหน่ง', 'fas fa-briefcase', 'view', 'ดูรายการ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(16, 'hr.positions', 'จัดการตำแหน่ง', 'fas fa-briefcase', 'create', 'เพิ่มตำแหน่ง', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(17, 'hr.positions', 'จัดการตำแหน่ง', 'fas fa-briefcase', 'edit', 'แก้ไขตำแหน่ง', 3, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(18, 'hr.positions', 'จัดการตำแหน่ง', 'fas fa-briefcase', 'delete', 'ลบตำแหน่ง', 4, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(19, 'hr.time_records', 'บันทึกเวลาทำงาน', 'fas fa-clock', 'view', 'ดู/บันทึกเวลา', 1, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(20, 'hr.time_records', 'บันทึกเวลาทำงาน', 'fas fa-clock', 'create', 'เพิ่มบันทึก', 2, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(21, 'hr.time_records', 'บันทึกเวลาทำงาน', 'fas fa-clock', 'edit', 'แก้ไขบันทึก', 3, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(22, 'hr.time_records', 'บันทึกเวลาทำงาน', 'fas fa-clock', 'delete', 'ลบบันทึก', 4, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(23, 'hr.time_summary', 'รายงานสรุปรายเดือน', 'fas fa-chart-line', 'view', 'ดูรายงาน', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(24, 'hr.time_summary', 'รายงานสรุปรายเดือน', 'fas fa-chart-line', 'export', 'Export Excel', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(25, 'hr.time_lock', 'ปิดงวดเวลาทำงาน', 'fas fa-lock', 'view', 'ดูงวดเวลา', 1, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(26, 'hr.time_lock', 'ปิดงวดเวลาทำงาน', 'fas fa-lock', 'create', 'ล็อก/ปลดล็อกงวด', 2, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(27, 'hr.time_logs', 'ประวัติแก้ไขเวลา', 'fas fa-history', 'view', 'ดูประวัติ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(28, 'inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'view', 'ดูรายการ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(29, 'inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'create', 'เพิ่มสินค้า', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(30, 'inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'edit', 'แก้ไขสินค้า', 3, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(31, 'inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'delete', 'ลบสินค้า', 4, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(32, 'inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'export', 'Export Excel', 5, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(33, 'inventory.categories', 'จัดการหมวดหมู่สินค้า', 'fas fa-tags', 'view', 'ดูรายการ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(34, 'inventory.categories', 'จัดการหมวดหมู่สินค้า', 'fas fa-tags', 'create', 'เพิ่มหมวดหมู่', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(35, 'inventory.categories', 'จัดการหมวดหมู่สินค้า', 'fas fa-tags', 'edit', 'แก้ไขหมวดหมู่', 3, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(36, 'inventory.categories', 'จัดการหมวดหมู่สินค้า', 'fas fa-tags', 'delete', 'ลบหมวดหมู่', 4, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(37, 'inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'view', 'ดูรายการ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(38, 'inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'create', 'สร้างใบยืม', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(39, 'inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'edit', 'แก้ไขใบยืม', 3, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(40, 'inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'delete', 'ลบใบยืม', 4, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(41, 'inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'export', 'Export Excel', 5, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(42, 'inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'view', 'ดูรายการ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(43, 'inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'create', 'สร้างใบเบิก', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(44, 'inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'edit', 'แก้ไข/อนุมัติใบเบิก', 3, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(45, 'inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'delete', 'ลบใบเบิก', 4, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(46, 'inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'export', 'Export Excel', 5, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(47, 'inventory.transactions', 'ประวัติเคลื่อนไหวสต๊อก', 'fas fa-exchange-alt', 'view', 'ดูประวัติ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(48, 'inventory.transactions', 'ประวัติเคลื่อนไหวสต๊อก', 'fas fa-exchange-alt', 'export', 'Export Excel', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(49, 'inventory.stock_summary', 'สรุปยอดคงเหลือ', 'fas fa-balance-scale', 'view', 'ดูสรุป', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(50, 'inventory.stock_summary', 'สรุปยอดคงเหลือ', 'fas fa-balance-scale', 'export', 'Export Excel', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(51, 'admin.users', 'จัดการผู้ใช้งาน', 'fas fa-user-shield', 'view', 'ดูรายการ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(52, 'admin.users', 'จัดการผู้ใช้งาน', 'fas fa-user-shield', 'create', 'เพิ่มผู้ใช้', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(53, 'admin.users', 'จัดการผู้ใช้งาน', 'fas fa-user-shield', 'edit', 'แก้ไขผู้ใช้', 3, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(54, 'admin.users', 'จัดการผู้ใช้งาน', 'fas fa-user-shield', 'delete', 'ลบผู้ใช้', 4, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(55, 'admin.permissions', 'ตั้งค่าสิทธิ์การใช้งาน', 'fas fa-key', 'view', 'ดู/ตั้งค่าสิทธิ์', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(56, 'admin.permissions', 'ตั้งค่าสิทธิ์การใช้งาน', 'fas fa-key', 'edit', 'แก้ไขสิทธิ์', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(57, 'admin.activity_logs', 'บันทึกกิจกรรม', 'fas fa-clipboard-check', 'view', 'ดูบันทึก', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(58, 'admin.activity_logs', 'บันทึกกิจกรรม', 'fas fa-clipboard-check', 'export', 'Export Excel', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(59, 'admin.backups', 'สำรองข้อมูล', 'fas fa-database', 'view', 'ดูรายการ Backup', 1, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(60, 'admin.backups', 'สำรองข้อมูล', 'fas fa-database', 'create', 'สร้าง Backup', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(61, 'admin.backups', 'สำรองข้อมูล', 'fas fa-database', 'delete', 'ลบ Backup', 4, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(62, 'admin.health', 'ตรวจสอบสถานะระบบ', 'fas fa-heartbeat', 'view', 'ดูสถานะ', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(63, 'admin.imports', 'นำเข้าข้อมูล', 'fas fa-file-import', 'view', 'ดูหน้านำเข้า', 1, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(64, 'admin.imports', 'นำเข้าข้อมูล', 'fas fa-file-import', 'create', 'อัปโหลดไฟล์', 2, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(65, 'admin.exports', 'ส่งออกข้อมูล', 'fas fa-file-export', 'view', 'ดูหน้าส่งออก', 1, '2026-04-05 09:32:18', '2026-04-05 19:24:31'),
(66, 'profile.edit', 'แก้ไขโปรไฟล์', 'fas fa-user-edit', 'view', 'แก้ไขข้อมูลส่วนตัว', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(67, 'profile.password', 'เปลี่ยนรหัสผ่าน', 'fas fa-lock', 'view', 'เปลี่ยนรหัสผ่าน', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(68, 'notifications', 'การแจ้งเตือน', 'fas fa-bell', 'view', 'ดูการแจ้งเตือน', 1, '2026-04-05 09:32:18', '2026-04-05 09:32:18'),
(69, 'hr.time_records', 'บันทึกเวลาทำงาน', 'fas fa-clock', 'export', 'Export Excel', 5, '2026-04-05 19:24:31', '2026-04-05 19:24:31'),
(70, 'inventory.categories', 'จัดการหมวดหมู่สินค้า', 'fas fa-tags', 'export', 'Export Excel', 5, '2026-04-05 19:24:31', '2026-04-05 19:24:31'),
(71, 'admin.backups', 'สำรองข้อมูล', 'fas fa-database', 'edit', 'ดาวน์โหลด/Restore Backup', 3, '2026-04-05 19:24:31', '2026-04-05 19:24:31'),
(72, 'admin.exports', 'ส่งออกข้อมูล', 'fas fa-file-export', 'export', 'ส่งออกข้อมูล', 2, '2026-04-05 19:24:31', '2026-04-05 19:24:31');

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
(1, 1, 'Sales Engineer', 'รับลูกค้า, เสนอราคา, เก็บ requirement', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(2, 1, 'Sales', 'รับลูกค้า, เสนอราคา, เก็บ requirement', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(3, 2, 'Design Engineer', 'ออกแบบ, เขียนแบบ', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(4, 2, 'Draftman', 'ออกแบบ, เขียนแบบ', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(5, 3, 'Production Manager', 'คุมทีมผลิตงาน, เชื่อม, ประกอบ', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(6, 3, 'ช่างผลิต/ช่างเชื่อม', 'ผลิตงาน, เชื่อม, ประกอบ', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(7, 4, 'QC Inspector', 'ตรวจคุณภาพงาน', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(8, 5, 'Site Engineer', 'คุมงานติดตั้งหน้างานลูกค้า', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(9, 5, 'ช่างติดตั้ง', 'ติดตั้งหน้างานลูกค้า', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(10, 6, 'Purchasing', 'จัดซื้อวัสดุ อุปกรณ์', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(11, 7, 'Store / Stock', 'ควบคุมการเบิกจ่ายวัสดุ Production', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(12, 8, 'Admin', 'จัดการเอกสารทั่วไป ทุกแผนก', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(13, 8, 'HR', 'จัดการบุคคล, เงินเดือน', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL),
(14, 8, 'Accountant', 'จัดการบัญชี, การเงิน', '2026-04-02 03:23:56', '2026-04-02 03:23:56', NULL);

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
(1, 17, 'consume', 'issued', '2026-04-05', NULL, NULL, 'อิอิ', 32, '2026-04-05 10:29:02', '2026-04-05 10:29:02', NULL),
(2, 17, 'consume', 'issued', '2026-04-05', NULL, NULL, 'อิอิ', 32, '2026-04-05 10:29:05', '2026-04-05 10:29:05', NULL),
(3, 17, 'consume', 'issued', '2026-04-05', NULL, NULL, 'อิอิ', 32, '2026-04-05 10:29:10', '2026-04-05 10:29:10', NULL),
(4, 17, 'consume', 'issued', '2026-04-05', NULL, NULL, 'เทส', 32, '2026-04-05 10:29:50', '2026-04-05 10:29:50', NULL),
(5, 17, 'consume', 'issued', '2026-04-05', NULL, NULL, 'เทส', 32, '2026-04-05 10:39:42', '2026-04-05 10:39:42', NULL),
(6, 15, 'consume', 'issued', '2026-04-06', NULL, NULL, NULL, 30, '2026-04-05 19:42:59', '2026-04-05 19:42:59', NULL),
(7, 15, 'borrow', 'returned_all', '2026-04-06', NULL, '2026-04-07', NULL, 12, '2026-04-05 20:45:14', '2026-04-05 20:53:06', NULL);

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
(1, 1, 7, 1, 0, '2026-04-05 10:29:02', '2026-04-05 10:29:02', NULL),
(2, 1, 36, 1, 0, '2026-04-05 10:29:02', '2026-04-05 10:29:02', NULL),
(3, 2, 7, 1, 0, '2026-04-05 10:29:05', '2026-04-05 10:29:05', NULL),
(4, 2, 36, 1, 0, '2026-04-05 10:29:05', '2026-04-05 10:29:05', NULL),
(5, 3, 7, 1, 0, '2026-04-05 10:29:10', '2026-04-05 10:29:10', NULL),
(6, 3, 36, 1, 0, '2026-04-05 10:29:10', '2026-04-05 10:29:10', NULL),
(7, 4, 7, 1, 0, '2026-04-05 10:29:50', '2026-04-05 10:29:50', NULL),
(8, 5, 7, 1, 0, '2026-04-05 10:39:42', '2026-04-05 10:39:42', NULL),
(9, 6, 7, 5, 0, '2026-04-05 19:42:59', '2026-04-05 19:42:59', NULL),
(10, 7, 23, 1, 1, '2026-04-05 20:45:14', '2026-04-05 20:53:06', NULL);

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

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role`, `permission_id`, `can_view`, `can_create`, `can_edit`, `can_delete`, `can_export`, `notes`, `created_at`, `updated_at`) VALUES
(1062, 'admin', 1, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1063, 'admin', 2, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1064, 'admin', 3, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1065, 'admin', 4, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1066, 'admin', 5, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1067, 'admin', 6, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1068, 'admin', 7, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1069, 'admin', 8, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1070, 'admin', 9, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1071, 'admin', 10, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1072, 'admin', 11, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1073, 'admin', 12, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1074, 'admin', 13, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1075, 'admin', 14, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1076, 'admin', 15, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1077, 'admin', 16, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1078, 'admin', 17, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1079, 'admin', 18, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1080, 'admin', 19, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1081, 'admin', 20, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1082, 'admin', 21, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1083, 'admin', 22, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1084, 'admin', 23, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1085, 'admin', 24, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1086, 'admin', 25, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1087, 'admin', 26, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1088, 'admin', 27, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1089, 'admin', 28, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1090, 'admin', 29, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1091, 'admin', 30, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1092, 'admin', 31, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1093, 'admin', 32, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1094, 'admin', 33, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1095, 'admin', 34, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1096, 'admin', 35, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1097, 'admin', 36, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1098, 'admin', 37, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1099, 'admin', 38, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1100, 'admin', 39, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1101, 'admin', 40, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1102, 'admin', 41, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1103, 'admin', 42, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1104, 'admin', 43, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1105, 'admin', 44, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1106, 'admin', 45, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1107, 'admin', 46, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1108, 'admin', 47, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1109, 'admin', 48, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1110, 'admin', 49, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1111, 'admin', 50, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1112, 'admin', 51, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1113, 'admin', 52, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1114, 'admin', 53, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1115, 'admin', 54, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1116, 'admin', 55, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1117, 'admin', 56, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1118, 'admin', 57, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1119, 'admin', 58, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1120, 'admin', 59, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1121, 'admin', 60, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1122, 'admin', 61, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1123, 'admin', 62, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1124, 'admin', 63, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1125, 'admin', 64, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1126, 'admin', 65, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1127, 'admin', 66, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1128, 'admin', 67, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1129, 'admin', 68, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1130, 'admin', 69, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1131, 'admin', 70, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1132, 'admin', 71, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1133, 'admin', 72, 1, 1, 1, 1, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1134, 'hr', 1, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1135, 'hr', 2, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:15:06'),
(1136, 'hr', 3, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1137, 'hr', 4, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1138, 'hr', 5, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1139, 'hr', 6, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1140, 'hr', 7, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1141, 'hr', 8, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1142, 'hr', 9, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1143, 'hr', 10, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1144, 'hr', 11, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1145, 'hr', 12, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1146, 'hr', 13, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1147, 'hr', 14, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1148, 'hr', 15, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1149, 'hr', 16, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1150, 'hr', 17, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1151, 'hr', 18, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1152, 'hr', 19, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1153, 'hr', 20, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1154, 'hr', 21, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1155, 'hr', 22, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1156, 'hr', 23, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1157, 'hr', 24, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1158, 'hr', 25, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1159, 'hr', 26, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1160, 'hr', 27, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1161, 'hr', 28, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1162, 'hr', 29, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1163, 'hr', 30, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1164, 'hr', 31, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1165, 'hr', 32, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1166, 'hr', 33, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1167, 'hr', 34, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1168, 'hr', 35, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1169, 'hr', 36, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1170, 'hr', 37, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1171, 'hr', 38, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1172, 'hr', 39, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1173, 'hr', 40, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1174, 'hr', 41, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1175, 'hr', 42, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1176, 'hr', 43, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1177, 'hr', 44, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1178, 'hr', 45, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1179, 'hr', 46, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1180, 'hr', 47, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1181, 'hr', 48, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1182, 'hr', 49, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1183, 'hr', 50, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1184, 'hr', 51, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1185, 'hr', 52, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1186, 'hr', 53, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1187, 'hr', 54, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1188, 'hr', 55, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1189, 'hr', 56, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1190, 'hr', 57, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1191, 'hr', 58, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1192, 'hr', 59, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1193, 'hr', 60, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1194, 'hr', 61, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1195, 'hr', 62, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1196, 'hr', 63, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1197, 'hr', 64, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1198, 'hr', 65, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1199, 'hr', 66, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1200, 'hr', 67, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1201, 'hr', 68, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1202, 'hr', 69, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:14:21'),
(1203, 'hr', 70, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1204, 'hr', 71, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1205, 'hr', 72, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1206, 'manager', 1, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1207, 'manager', 2, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1208, 'manager', 3, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1209, 'manager', 4, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1210, 'manager', 5, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1211, 'manager', 6, 1, 0, 0, 0, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1212, 'manager', 7, 1, 0, 0, 0, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1213, 'manager', 8, 1, 0, 0, 0, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1214, 'manager', 9, 1, 0, 0, 0, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1215, 'manager', 10, 1, 0, 0, 0, 1, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1216, 'manager', 11, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1217, 'manager', 12, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1218, 'manager', 13, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1219, 'manager', 14, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1220, 'manager', 15, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1221, 'manager', 16, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1222, 'manager', 17, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1223, 'manager', 18, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1224, 'manager', 19, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1225, 'manager', 20, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1226, 'manager', 21, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1227, 'manager', 22, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1228, 'manager', 23, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1229, 'manager', 24, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1230, 'manager', 25, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1231, 'manager', 26, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1232, 'manager', 27, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1233, 'manager', 28, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1234, 'manager', 29, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1235, 'manager', 30, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1236, 'manager', 31, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1237, 'manager', 32, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1238, 'manager', 33, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1239, 'manager', 34, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1240, 'manager', 35, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1241, 'manager', 36, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1242, 'manager', 37, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1243, 'manager', 38, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1244, 'manager', 39, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1245, 'manager', 40, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1246, 'manager', 41, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1247, 'manager', 42, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1248, 'manager', 43, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1249, 'manager', 44, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1250, 'manager', 45, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1251, 'manager', 46, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1252, 'manager', 47, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1253, 'manager', 48, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1254, 'manager', 49, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1255, 'manager', 50, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1256, 'manager', 51, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1257, 'manager', 52, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1258, 'manager', 53, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1259, 'manager', 54, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1260, 'manager', 55, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1261, 'manager', 56, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1262, 'manager', 57, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1263, 'manager', 58, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1264, 'manager', 59, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1265, 'manager', 60, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1266, 'manager', 61, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1267, 'manager', 62, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1268, 'manager', 63, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1269, 'manager', 64, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1270, 'manager', 65, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1271, 'manager', 66, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1272, 'manager', 67, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1273, 'manager', 68, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1274, 'manager', 69, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1275, 'manager', 70, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1276, 'manager', 71, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1277, 'manager', 72, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1278, 'inventory', 1, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1279, 'inventory', 2, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1280, 'inventory', 3, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1281, 'inventory', 4, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1282, 'inventory', 5, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1283, 'inventory', 6, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1284, 'inventory', 7, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1285, 'inventory', 8, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1286, 'inventory', 9, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1287, 'inventory', 10, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1288, 'inventory', 11, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1289, 'inventory', 12, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1290, 'inventory', 13, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1291, 'inventory', 14, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1292, 'inventory', 15, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1293, 'inventory', 16, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1294, 'inventory', 17, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1295, 'inventory', 18, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1296, 'inventory', 19, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1297, 'inventory', 20, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1298, 'inventory', 21, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1299, 'inventory', 22, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1300, 'inventory', 23, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1301, 'inventory', 24, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1302, 'inventory', 25, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1303, 'inventory', 26, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1304, 'inventory', 27, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1305, 'inventory', 28, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1306, 'inventory', 29, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1307, 'inventory', 30, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1308, 'inventory', 31, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1309, 'inventory', 32, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1310, 'inventory', 33, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1311, 'inventory', 34, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1312, 'inventory', 35, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1313, 'inventory', 36, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1314, 'inventory', 37, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1315, 'inventory', 38, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1316, 'inventory', 39, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1317, 'inventory', 40, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1318, 'inventory', 41, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1319, 'inventory', 42, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1320, 'inventory', 43, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1321, 'inventory', 44, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1322, 'inventory', 45, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1323, 'inventory', 46, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1324, 'inventory', 47, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1325, 'inventory', 48, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1326, 'inventory', 49, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1327, 'inventory', 50, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1328, 'inventory', 51, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1329, 'inventory', 52, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1330, 'inventory', 53, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1331, 'inventory', 54, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1332, 'inventory', 55, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1333, 'inventory', 56, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1334, 'inventory', 57, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1335, 'inventory', 58, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1336, 'inventory', 59, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1337, 'inventory', 60, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1338, 'inventory', 61, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1339, 'inventory', 62, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1340, 'inventory', 63, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1341, 'inventory', 64, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1342, 'inventory', 65, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1343, 'inventory', 66, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1344, 'inventory', 67, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1345, 'inventory', 68, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1346, 'inventory', 69, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1347, 'inventory', 70, 1, 1, 1, 1, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1348, 'inventory', 71, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1349, 'inventory', 72, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1350, 'employee', 1, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1351, 'employee', 2, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1352, 'employee', 3, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1353, 'employee', 4, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1354, 'employee', 5, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1355, 'employee', 6, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1356, 'employee', 7, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1357, 'employee', 8, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1358, 'employee', 9, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1359, 'employee', 10, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1360, 'employee', 11, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1361, 'employee', 12, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1362, 'employee', 13, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1363, 'employee', 14, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1364, 'employee', 15, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1365, 'employee', 16, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1366, 'employee', 17, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1367, 'employee', 18, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1368, 'employee', 19, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1369, 'employee', 20, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1370, 'employee', 21, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1371, 'employee', 22, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1372, 'employee', 23, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1373, 'employee', 24, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1374, 'employee', 25, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1375, 'employee', 26, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1376, 'employee', 27, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1377, 'employee', 28, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1378, 'employee', 29, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1379, 'employee', 30, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1380, 'employee', 31, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1381, 'employee', 32, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1382, 'employee', 33, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1383, 'employee', 34, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1384, 'employee', 35, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1385, 'employee', 36, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1386, 'employee', 37, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1387, 'employee', 38, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1388, 'employee', 39, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1389, 'employee', 40, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1390, 'employee', 41, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1391, 'employee', 42, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1392, 'employee', 43, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1393, 'employee', 44, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1394, 'employee', 45, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1395, 'employee', 46, 1, 1, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1396, 'employee', 47, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1397, 'employee', 48, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1398, 'employee', 49, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1399, 'employee', 50, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1400, 'employee', 51, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1401, 'employee', 52, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1402, 'employee', 53, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1403, 'employee', 54, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1404, 'employee', 55, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1405, 'employee', 56, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1406, 'employee', 57, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1407, 'employee', 58, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1408, 'employee', 59, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1409, 'employee', 60, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1410, 'employee', 61, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1411, 'employee', 62, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1412, 'employee', 63, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1413, 'employee', 64, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1414, 'employee', 65, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1415, 'employee', 66, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1416, 'employee', 67, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1417, 'employee', 68, 1, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1418, 'employee', 69, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1419, 'employee', 70, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1420, 'employee', 71, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46'),
(1421, 'employee', 72, 0, 0, 0, 0, 0, NULL, '2026-04-05 20:10:46', '2026-04-05 20:10:46');

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
('4xKVTb0QG5sKddnGX1c3ILtLRO5GOoZsacod60ew', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVkY4STZ5Y2xxQlhvQW45Z0lST0o1bE9QbDA3WmMycGNHREJsUG1ZaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnZlbnRvcnkvaXRlbXM/c2VhcmNoPSVFMCVCOSU4MSVFMCVCOCVBNyVFMCVCOSU4OCVFMCVCOCU5OSVFMCVCOCU5NSVFMCVCOCVCMiI7czo1OiJyb3V0ZSI7czoyMToiaW52ZW50b3J5Lml0ZW1zLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==', 1775455275),
('WCQD5AW3IhLJTjeBOzr6QOT249bwFtlrU78Kh3Xh', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVUs2dXJWNEJmM3Y4Tk9GaXVRUEd1aUx6WUsyR2xMTVRUczRyUGYwNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9oci90aW1lLXJlY29yZHMvbG9jayI7czo1OiJyb3V0ZSI7czoyMDoiaHIudGltZS1yZWNvcmRzLmxvY2siO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMzt9', 1775445363);

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
(1, 7, 'consume_out', 1, 119, 1, 32, 'เบิกโดย: ธนพล ไซต์งาน เมื่อ 00:29 น.', '2026-04-05 10:29:02', '2026-04-05 10:29:02'),
(2, 36, 'consume_out', 1, 49, 1, 32, 'เบิกโดย: ธนพล ไซต์งาน เมื่อ 00:29 น.', '2026-04-05 10:29:02', '2026-04-05 10:29:02'),
(3, 7, 'consume_out', 1, 118, 2, 32, 'เบิกโดย: ธนพล ไซต์งาน เมื่อ 00:29 น.', '2026-04-05 10:29:05', '2026-04-05 10:29:05'),
(4, 36, 'consume_out', 1, 48, 2, 32, 'เบิกโดย: ธนพล ไซต์งาน เมื่อ 00:29 น.', '2026-04-05 10:29:05', '2026-04-05 10:29:05'),
(5, 7, 'consume_out', 1, 117, 3, 32, 'เบิกโดย: ธนพล ไซต์งาน เมื่อ 00:29 น.', '2026-04-05 10:29:10', '2026-04-05 10:29:10'),
(6, 36, 'consume_out', 1, 47, 3, 32, 'เบิกโดย: ธนพล ไซต์งาน เมื่อ 00:29 น.', '2026-04-05 10:29:10', '2026-04-05 10:29:10'),
(7, 7, 'consume_out', 1, 116, 4, 32, 'เบิกโดย: ธนพล ไซต์งาน เมื่อ 00:29 น.', '2026-04-05 10:29:50', '2026-04-05 10:29:50'),
(8, 7, 'consume_out', 1, 115, 5, 32, 'เบิกโดย: ธนพล ไซต์งาน เมื่อ 00:39 น.', '2026-04-05 10:39:42', '2026-04-05 10:39:42'),
(9, 7, 'consume_out', 5, 110, 6, 30, 'เบิกโดย: พีรพัฒน์ หน้างาน เมื่อ 09:42 น.', '2026-04-05 19:42:59', '2026-04-05 19:42:59'),
(10, 23, 'borrow_out', 1, 19, 7, 12, 'ยืมโดย: พีรพัฒน์ หน้างาน', '2026-04-05 20:45:14', '2026-04-05 20:45:14'),
(11, 23, 'borrow_return', 1, 20, 7, 12, 'คืนสินค้า: ตลับเมตร 5m', '2026-04-05 20:53:06', '2026-04-05 20:53:06');

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
(1, 2, '2026-04-01', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(2, 2, '2026-04-02', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(3, 2, '2026-04-03', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(4, 2, '2026-04-04', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(5, 2, '2026-04-05', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(6, 2, '2026-04-06', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(7, 3, '2026-04-01', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(8, 3, '2026-04-02', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(9, 3, '2026-04-03', 'absent', NULL, NULL, 'batch', 0, NULL, 'ป่วย', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(10, 3, '2026-04-04', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(11, 3, '2026-04-05', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(12, 3, '2026-04-06', 'present', NULL, NULL, 'batch', 0, NULL, '', '2026-04-05 20:43:46', '2026-04-05 20:43:46');

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
(1, 1, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(2, 1, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(3, 2, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(4, 2, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(5, 3, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(6, 3, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(7, 4, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(8, 4, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(9, 5, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(10, 5, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(11, 6, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(12, 6, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(13, 7, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(14, 7, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(15, 8, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(16, 8, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(17, 10, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(18, 10, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(19, 11, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(20, 11, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(21, 12, 'morning', '08:00:00', '12:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(22, 12, 'afternoon', '13:00:00', '17:00:00', '2026-04-05 20:43:46', '2026-04-05 20:43:46');

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

--
-- Dumping data for table `time_record_logs`
--

INSERT INTO `time_record_logs` (`id`, `time_record_id`, `action`, `reason`, `old_data`, `new_data`, `changed_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(2, 2, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(3, 3, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(4, 4, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(5, 5, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(6, 6, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:31', '2026-04-05 20:43:31'),
(7, 7, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(8, 8, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(9, 9, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"absent\\\",\\\"remark\\\":\\\"\\u0e1b\\u0e48\\u0e27\\u0e22\\\",\\\"details\\\":[]}\"', 12, '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(10, 10, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(11, 11, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:46', '2026-04-05 20:43:46'),
(12, 12, 'create', 'แก้ไขเวลาทำงานด้วย Batch Entry', NULL, '\"{\\\"status\\\":\\\"present\\\",\\\"remark\\\":\\\"\\\",\\\"details\\\":[{\\\"period\\\":\\\"morning\\\",\\\"in\\\":\\\"08:00:00\\\",\\\"out\\\":\\\"12:00:00\\\"},{\\\"period\\\":\\\"afternoon\\\",\\\"in\\\":\\\"13:00:00\\\",\\\"out\\\":\\\"17:00:00\\\"}]}\"', 12, '2026-04-05 20:43:46', '2026-04-05 20:43:46');

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
(12, 'นางผู้ดูแล ระบบ', 'admin', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'admin', 22, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(13, 'นางสาวกัลยา บุคคล', 'hr01', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'hr', 23, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(14, 'นายวิรัตน์ คลังสินค้า', 'wh01', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'inventory', 20, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(15, 'นางสาวพิชชา การเงิน', 'acc01', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 24, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(16, 'นายธนวัตต์ โอว้าว', 'acc02', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 25, NULL, '2026-04-05 15:35:37', '2026-04-05 22:33:05'),
(17, 'นายสมชาย วงศ์สวัสดิ์', 'sal01', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 2, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(18, 'นางสาวสุภาวดี จันทร์เพ็ญ', 'sal02', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 3, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(19, 'นายธนกร รัตนชัย', 'sal03', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 4, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(20, 'นายกิตติ พัฒนาพงศ์', 'eng01', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 5, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(21, 'นายวิชัย แก้วมณี', 'eng02', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 6, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(22, 'นางสาวพิมพ์ใจ สุขสมบูรณ์', 'eng03', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 7, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(23, 'นายประสิทธิ์ การช่าง', 'prd01', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 8, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(24, 'นายมงคล เหล็กกล้า', 'prd02', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 9, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(25, 'นายบุญมี ช่างเชื่อม', 'prd03', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 10, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(26, 'นายสุรชัย ประกอบกิจ', 'prd04', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 11, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(27, 'นายอภิชาติ ผลิตผล', 'prd05', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 12, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(28, 'นายชัยวัฒน์ ตรวจดี', 'qc01', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 13, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(29, 'นางสาวรัตนา คุณภาพ', 'qc02', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 14, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(30, 'นายพีรพัฒน์ หน้างาน', 'sit01', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 15, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(31, 'นายอนุชา ติดตั้ง', 'sit02', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 16, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(32, 'นายธนพล ไซต์งาน', 'sit03', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 17, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(33, 'นางสาวจิดาภา จัดซื้อ', 'pur01', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 18, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(34, 'นาย กรกฎ หามา', 'pur02', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'employee', 19, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37'),
(35, 'นายสมบัติ เบิกจ่าย', 'wh02', '$2y$12$7kGMwLwMym.iU0/kS20Ygu7Lon5etHEidylLuAzoYL6pNBhgzrlSy', 'inventory', 21, NULL, '2026-04-05 15:35:37', '2026-04-05 15:35:37');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `requisitions`
--
ALTER TABLE `requisitions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `requisition_items`
--
ALTER TABLE `requisition_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1422;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `time_records`
--
ALTER TABLE `time_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `time_record_details`
--
ALTER TABLE `time_record_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `time_record_logs`
--
ALTER TABLE `time_record_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
