-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 23, 2026 at 01:10 PM
-- Server version: 8.0.45-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_images`
--

CREATE TABLE `admin_images` (
  `id` bigint UNSIGNED NOT NULL,
  `image_file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_image` enum('logo','favicon') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'logo',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_images`
--

INSERT INTO `admin_images` (`id`, `image_file_name`, `type_of_image`, `file_path`, `created_at`, `updated_at`, `user_id`) VALUES
(1, '1768307179_logo3.ico', 'favicon', 'storage/admin/favicon/logo3.ico', '2026-01-13 06:56:19', '2026-01-13 06:56:19', 1),
(2, '1768307316_logo3.png', 'logo', 'storage/admin/logo/logo3.png', '2026-01-13 06:58:36', '2026-01-13 06:58:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('vivahbandhan-cache-krinavisrolia@gmail.com|127.0.0.1', 'i:2;', 1769863485),
('vivahbandhan-cache-krinavisrolia@gmail.com|127.0.0.1:timer', 'i:1769863485;', 1769863485),
('vivahbandhan-cache-testtest@gmail.com|127.0.0.1', 'i:1;', 1769079564),
('vivahbandhan-cache-testtest@gmail.com|127.0.0.1:timer', 'i:1769079564;', 1769079564);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `state_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rajkot', NULL, NULL),
(2, 1, 'Surat', NULL, NULL),
(3, 2, 'Mumbai', NULL, NULL),
(4, 2, 'Sirdi', NULL, NULL),
(5, 3, 'Los Angeles', NULL, NULL),
(7, 1, 'Ahmedabad', '2026-01-19 06:48:39', '2026-01-19 06:48:39'),
(8, 1, 'Jamnagar', '2026-01-19 06:48:39', '2026-01-19 06:48:39'),
(9, 1, 'Vadodara', '2026-01-19 06:48:39', '2026-01-19 06:48:39'),
(10, 2, 'Nasik', '2026-01-19 06:48:39', '2026-01-19 06:48:39'),
(11, 2, 'Pune', '2026-01-19 06:48:39', '2026-01-19 06:48:39'),
(12, 2, 'Nagpur', '2026-01-19 06:48:39', '2026-01-19 06:48:39'),
(13, 6, 'Jaipur', '2026-01-19 06:48:39', '2026-01-19 06:48:39'),
(14, 6, 'Udaipur', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(16, 3, 'San Francisco', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(17, 8, 'Houston', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(18, 8, 'Dallas', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(19, 9, 'New York City', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(20, 9, 'Buffalo', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(21, 10, 'Toronto', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(22, 10, 'Ottawa', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(23, 11, 'Vancouver', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(24, 11, 'Victoria', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(25, 12, 'London', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(26, 12, 'Manchester', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(27, 13, 'Edinburgh', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(28, 13, 'Glasgow', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(29, 14, 'Sydney', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(30, 14, 'Newcastle', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(31, 15, 'Melbourne', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(32, 15, 'Geelong', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(33, 16, 'Munich', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(34, 16, 'Nuremberg', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(35, 17, 'Berlin', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(36, 18, 'Paris', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(37, 19, 'Marseille', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(38, 19, 'Nice', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(39, 20, 'Shinjuku', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(40, 20, 'Shibuya', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(41, 21, 'Osaka', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(42, 21, 'Sakai', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(43, 22, 'Beijing', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(44, 23, 'Shanghai', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(45, 24, 'São Paulo', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(46, 25, 'Rio de Janeiro', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(47, 26, 'Johannesburg', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(48, 26, 'Pretoria', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(49, 27, 'Cape Town', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(50, 28, 'Dubai', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(51, 29, 'Abu Dhabi', '2026-01-19 06:48:41', '2026-01-19 06:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'India', '2026-01-19 05:45:53', '2026-01-19 05:45:53'),
(2, 'USA', '2026-01-19 05:45:53', '2026-01-19 05:45:53'),
(5, 'Canada', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(6, 'UK', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(7, 'Australia', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(8, 'Germany', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(9, 'France', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(10, 'Japan', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(11, 'China', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(12, 'Brazil', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(13, 'South Africa', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(14, 'UAE', '2026-01-19 06:48:41', '2026-01-19 06:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `filters`
--

CREATE TABLE `filters` (
  `id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  `age_from` int DEFAULT NULL,
  `age_to` int DEFAULT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `community` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` enum('single','divorced','widow') COLLATE utf8mb4_unicode_ci DEFAULT 'single',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `filters`
--

INSERT INTO `filters` (`id`, `profile_id`, `age_from`, `age_to`, `gender`, `religion`, `community`, `profession`, `country`, `state`, `city`, `marital_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 13, NULL, NULL, 'Male', 'Hindu', NULL, NULL, NULL, NULL, NULL, 'single', '2025-12-22 07:39:31', '2025-12-22 07:39:31', NULL),
(11, 13, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-22 08:35:42', '2025-12-22 08:35:42', NULL),
(12, 13, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-22 08:42:26', '2025-12-22 08:42:26', NULL),
(13, 13, 22, 30, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-22 08:43:31', '2025-12-22 08:43:31', NULL),
(14, 13, 25, NULL, 'Male', NULL, NULL, 'software engineer', NULL, NULL, NULL, 'single', '2025-12-30 06:28:33', '2025-12-30 06:28:33', NULL),
(15, 28, 26, NULL, NULL, 'Hindu', NULL, NULL, 'India', NULL, NULL, NULL, '2026-01-16 05:45:56', '2026-01-16 05:45:56', NULL),
(16, 28, NULL, NULL, NULL, 'Hindu', NULL, 'Software Engineer', 'India', NULL, NULL, NULL, '2026-01-16 05:46:42', '2026-01-16 05:46:42', NULL),
(18, 34, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-23 08:12:42', '2026-01-23 08:14:16', '2026-01-23 08:14:16'),
(19, 34, 25, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'single', '2026-01-26 04:51:15', '2026-01-26 04:51:48', '2026-01-26 04:51:48'),
(20, 34, NULL, NULL, 'Male', 'Hindu', NULL, NULL, NULL, NULL, NULL, 'single', '2026-01-26 05:14:18', '2026-01-26 05:14:24', NULL),
(21, 34, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-26 05:16:31', '2026-01-26 05:16:31', NULL),
(22, 34, NULL, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-26 05:16:45', '2026-01-26 05:16:45', NULL),
(23, 23, 24, 30, 'Male', 'Hindu', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-28 07:01:46', '2026-01-28 07:01:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED DEFAULT NULL,
  `file_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_image` set('Profile','General','favicon') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `user_id`, `profile_id`, `file_name`, `type_of_image`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 5, 2, '1764850263_profile.jpeg', 'Profile', 'storage/uploads/profiles/1764850263_profile.jpeg', '2025-12-04 06:41:03', '2025-12-04 06:41:03'),
(10, 9, 13, '1765455312_girl.jpeg', 'Profile', 'storage/uploads/profiles/1765455312_girl.jpeg', '2025-12-11 06:45:12', '2025-12-11 06:45:12'),
(33, 17, 18, '1766058115_1.png', 'Profile', 'storage/uploads/profiles/1766058115_1.png', '2025-12-18 06:11:55', '2025-12-18 06:11:55'),
(34, 18, 19, '1766059099_3.jpg', 'Profile', 'storage/uploads/profiles/1766059099_3.jpg', '2025-12-18 06:21:19', '2025-12-18 06:28:19'),
(37, 19, 22, '1766144219_1.jpg', 'Profile', 'storage/uploads/profiles/1766144219_1.jpg', '2025-12-19 06:06:59', '2025-12-19 06:06:59'),
(38, 4, 23, '1766661675_2.jpg', 'Profile', 'storage/uploads/profiles/1766661675_2.jpg', '2025-12-25 05:51:15', '2025-12-25 05:51:15'),
(39, 20, 24, '1767959499_girl_profile.jpg', 'Profile', 'storage/uploads/profiles/1767959499_girl_profile.jpg', '2026-01-06 08:11:51', '2026-01-09 06:21:39'),
(41, 22, 26, '1767879006_3.jpg', 'Profile', 'storage/uploads/profiles/1767879006_3.jpg', '2026-01-08 08:00:06', '2026-01-08 08:00:06'),
(45, 1, NULL, '1768300671_logo3.ico', 'favicon', 'storage/admin/favicon/logo3.ico', '2026-01-13 05:07:51', '2026-01-13 05:07:51'),
(46, 1, NULL, '1768306279_logo3.ico', 'favicon', 'storage/admin/favicon/logo3.ico', '2026-01-13 06:41:19', '2026-01-13 06:41:19'),
(47, 25, 27, '1768476092_3.jpg', 'Profile', 'storage/uploads/profiles/1768476092_3.jpg', '2026-01-15 05:51:32', '2026-01-15 05:51:32'),
(48, 27, 28, '1768561398_girl.jpeg', 'Profile', 'storage/uploads/profiles/1768561398_girl.jpeg', '2026-01-16 05:33:18', '2026-01-16 05:33:18'),
(54, 28, 34, '1769174874_girl_profile.jpg', 'Profile', 'storage/uploads/profiles/1769174874_girl_profile.jpg', '2026-01-23 07:57:54', '2026-01-23 07:57:54'),
(57, 29, 37, '1769770469_1.png', 'Profile', 'storage/uploads/profiles/1769770469_1.png', '2026-01-30 05:24:29', '2026-01-30 05:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_02_122234_profile_table', 1),
(5, '2025_12_02_124041_images_table', 1),
(7, '2025_12_02_130014_user_requests_table', 1),
(8, '2025_12_02_130600_verifications_table', 1),
(9, '2025_12_03_110917_add_session_id_in__user_table', 2),
(11, '2025_12_02_125239_filters_table', 3),
(12, '2025_12_04_124036_create_personal_access_tokens_table', 3),
(13, '2025_12_18_122356_change_preferences_column_in_profiles_table', 4),
(15, '2025_12_20_103445_create_notifications_table', 5),
(16, '2025_12_22_112945_update_foreign_keys_for_cascade', 6),
(17, '2025_12_22_114637_add_foreign_keys_for_cascade', 7),
(18, '2025_12_26_124555_reports_table', 8),
(19, '2025_12_30_125721_create_reports_table', 8),
(20, '2026_01_13_120308_adminimages', 9),
(21, '2026_01_13_121525_add_userid_columnin_admin_images_table', 10),
(22, '2026_01_19_111125_create_countries_table', 11),
(23, '2026_01_19_111139_create_states_table', 11),
(24, '2026_01_19_111149_create_cities_table', 11),
(25, '2026_01_23_113542_add_soft_delete_on_filters_table', 12),
(26, '2026_01_28_101911_create_testimonials_table', 13),
(27, '2026_01_30_130800_create_ratings_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('066550f1-4729-42cf-ab28-cc613655c00f', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:36:06', '2025-12-31 07:35:08', '2025-12-31 07:36:06'),
('0bfe5755-7ce4-40dd-96c2-1616abc1cb55', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"This is Warning For You please Upload your Real Photograph in our Website\",\"report_id\":\"3\"}', '2025-12-31 07:53:19', '2025-12-31 07:50:59', '2025-12-31 07:53:19'),
('1d47f665-2de2-4535-8692-1a9c940eab61', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 18, '{\"message\":\"Please addyouru real details on this website within 3 days, otherwise we willbana you\",\"report_id\":14}', '2026-01-12 05:35:44', '2026-01-12 05:14:11', '2026-01-12 05:35:44'),
('1e66a898-3708-4ef9-a67b-5b2a868f8e43', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"Swati Gangani accepted your request \\ud83d\\udc96\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\\/sent\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:33:38', '2025-12-26 05:33:30', '2025-12-26 05:33:38'),
('20c2b212-f085-40e5-994f-af151a1fbb7c', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 17, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:32:34', '2025-12-26 04:53:49', '2025-12-26 05:32:34'),
('2ce27e2f-461e-4cc5-a65c-db543260732f', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:36:09', '2025-12-31 07:32:54', '2025-12-31 07:36:09'),
('2f0e5473-caf8-41bd-bb94-bf61f975af65', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 17, '{\"message\":\"Viral Gangani sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 06:00:49', '2025-12-26 05:37:32', '2025-12-26 06:00:49'),
('2f49d95c-dc01-4926-9dde-1fc510f3680c', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:39:11', '2025-12-26 05:37:44', '2025-12-26 05:39:11'),
('35f83912-c6ef-49c1-b1a6-307d547fb884', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:35:46', '2025-12-31 07:35:35', '2025-12-31 07:35:46'),
('380d2e38-cf52-42a3-a775-241fd4ddd150', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 17, '{\"message\":\"Viral Gangani sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:33:21', '2025-12-26 05:33:02', '2025-12-26 05:33:21'),
('3ab541c2-74b4-420c-a71f-27937f0cce94', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 22, '{\"message\":\"You are Entered Wrong Details, so pleas Enter your correct detailsonn this website within 3 days\",\"report_id\":4}', NULL, '2026-01-12 05:14:06', '2026-01-12 05:14:06'),
('3b826364-04a2-480c-9204-e43d5dc6eeff', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"This is Warning For You please Upload your Real Photograph in our Website\",\"report_id\":\"3\"}', '2025-12-31 07:53:23', '2025-12-31 07:50:59', '2025-12-31 07:53:23'),
('3e4fb635-072a-4fd2-a895-1d38fd311d34', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"Shreya poriya canceled the request \\ud83d\\udeab\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2026-01-12 05:05:43', '2026-01-12 04:49:11', '2026-01-12 05:05:43'),
('41c6d7c4-84c5-4be7-8422-0d53ec6c1541', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"This is Warning For You please Upload your Real Photograph in our Website\",\"report_id\":\"3\"}', '2025-12-31 07:53:22', '2025-12-31 07:50:44', '2025-12-31 07:53:22'),
('41e02743-674a-4fe3-b030-ed65d367cbcb', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"Swati Gangani sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 04:51:16', '2025-12-26 04:50:55', '2025-12-26 04:51:16'),
('44a71411-6e9a-476b-83a7-c22bcfeef5b4', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 17, '{\"message\":\"Viral Gangani accepted your request \\ud83d\\udc96\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\\/sent\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:32:25', '2025-12-26 04:57:54', '2025-12-26 05:32:25'),
('44b4bc05-485d-42b2-9cc1-c53b22be2e8e', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 17, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:32:32', '2025-12-26 04:53:46', '2025-12-26 05:32:32'),
('4a01c44b-7a90-4b0a-b3ba-426dc7c961fe', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"dvklndk;vnmd;sf\",\"report_id\":\"3\"}', '2025-12-31 08:03:42', '2025-12-31 08:02:38', '2025-12-31 08:03:42'),
('4e6cb3b3-a342-4e3f-b343-e7b6b562c2fa', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"Isha sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-22 06:54:28', '2025-12-22 06:53:39', '2025-12-22 06:54:28'),
('501e6921-80c3-4646-832a-518b71aba451', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:40:10', '2025-12-26 05:38:26', '2025-12-26 05:40:10'),
('5f0661f7-7af4-4e1a-b2c9-34944a28d025', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 5, '{\"message\":\"Ravi Joshi sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-25 07:07:43', '2025-12-25 06:38:28', '2025-12-25 07:07:43'),
('62e6d5ff-d8b9-42e8-8fa1-a9fdd4f4a2fd', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 04:48:09', '2025-12-26 04:46:51', '2025-12-26 04:48:09'),
('69160d43-ecc2-40bd-893e-be6629ca0227', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:39:13', '2025-12-26 05:37:42', '2025-12-26 05:39:13'),
('6d2ffd7d-a764-4fcc-83f2-58c06ceaeccf', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"This is Warning For You please Upload your Real Photograph in our Website\",\"report_id\":\"3\"}', '2025-12-31 07:53:25', '2025-12-31 07:50:22', '2025-12-31 07:53:25'),
('738deecb-173f-4311-a12f-5ee090bfa7f3', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"Shreya poriya sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2026-01-09 05:21:27', '2026-01-09 05:20:44', '2026-01-09 05:21:27'),
('75d4302c-ea82-4928-873d-2295f5019e81', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:36:00', '2025-12-31 07:35:34', '2025-12-31 07:36:00'),
('7826d663-9090-464d-8715-a116f7a8b52e', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 9, '{\"message\":\"Viral Gangani accepted your request \\ud83d\\udc96\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\\/sent\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-22 07:59:17', '2025-12-22 07:56:44', '2025-12-22 07:59:17'),
('7b6a2ff8-6b48-42cb-9ece-ae8f840fb796', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 19, '{\"message\":\"Swati Gangani sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-31 07:22:52', '2025-12-26 04:47:52', '2025-12-31 07:22:52'),
('815f65af-1184-4441-8183-a6c160af7558', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"b hbukfjkdnfdsf\",\"report_id\":3}', '2026-01-12 05:40:19', '2026-01-12 05:39:02', '2026-01-12 05:40:19'),
('88583b14-e205-49fb-9b54-db2935759e4b', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 17, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:32:31', '2025-12-26 04:55:31', '2025-12-26 05:32:31'),
('8d7c2959-f7c4-4912-b0bf-9407c754ce4c', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 19, '{\"message\":\"Priya sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-25 06:48:37', '2025-12-25 06:37:48', '2025-12-25 06:48:37'),
('902dbfa4-ae8b-4957-9bbf-169320e9faf7', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"dvklndk;vnmd;sf\",\"report_id\":\"3\"}', '2025-12-31 08:03:38', '2025-12-31 08:03:24', '2025-12-31 08:03:38'),
('924b9462-80ae-400d-9a49-1fe17aa7d144', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:35:58', '2025-12-31 07:30:15', '2025-12-31 07:35:58'),
('9287a1da-413e-451d-aaa4-b45e5b1ee8cc', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 17, '{\"message\":\"Viral Gangani sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-22 08:00:41', '2025-12-22 07:59:57', '2025-12-22 08:00:41'),
('9373ba70-9283-4d4f-92fa-05cdd2f3c075', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"This is Warning For You please Upload your Real Photograph in our Website\",\"report_id\":\"3\"}', '2025-12-31 07:53:21', '2025-12-31 07:50:45', '2025-12-31 07:53:21'),
('a61b1adb-f594-4332-a62a-7f35c27e1524', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:36:05', '2025-12-31 07:35:13', '2025-12-31 07:36:05'),
('b6252046-269a-44ce-83eb-8b980a08c390', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"bhbnb;lsfdb\",\"report_id\":3}', '2026-01-12 05:40:17', '2026-01-12 05:26:42', '2026-01-12 05:40:17'),
('c16b3190-5ff3-4d35-9e7d-7650054a4015', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 17, '{\"message\":\"Ravi Joshi rejected your request \\u274c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\\/sent\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', NULL, '2026-01-02 06:55:38', '2026-01-02 06:55:38'),
('c3a29620-0e9a-4145-a229-781b711195a0', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 06:01:03', '2025-12-26 05:58:10', '2025-12-26 06:01:03'),
('c44aba87-ac61-4ae4-9b16-a53786e3fd8d', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:36:02', '2025-12-31 07:35:33', '2025-12-31 07:36:02'),
('c8d1dfc1-4f1f-4659-a6e9-da6a86efa020', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 5, '{\"message\":\"Ravi Joshi accepted your request \\ud83d\\udc96\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\\/sent\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2026-02-03 07:19:16', '2026-01-02 06:55:34', '2026-02-03 07:19:16'),
('c95bb3b5-8255-45d6-9c59-c28c995584ae', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"Shreya poriya sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2026-01-09 05:21:06', '2026-01-09 05:19:51', '2026-01-09 05:21:06'),
('d093355a-72f7-4447-9b8c-919d6a147344', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"dvklndk;vnmd;sf\",\"report_id\":\"3\"}', '2025-12-31 08:03:39', '2025-12-31 08:03:19', '2025-12-31 08:03:39'),
('d94e5387-c418-44ae-85f6-78498ed11d6c', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:36:03', '2025-12-31 07:35:34', '2025-12-31 07:36:03'),
('e0c4c273-70c1-4d1b-8003-575b0dab9ec9', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 4, '{\"message\":\"Ravi Joshi rejected your request \\u274c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\\/sent\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-31 07:47:17', '2025-12-31 07:40:21', '2025-12-31 07:47:17'),
('e9161b9a-e628-4469-8485-48b86d17ccfd', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"This is a warning for you. Please upload your Real photographonn our website within 3 Days\",\"report_id\":\"3\"}', '2025-12-31 07:47:12', '2025-12-31 07:46:51', '2025-12-31 07:47:12'),
('ea9dbba2-286b-46d3-b02e-7170ec10492a', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 19, '{\"message\":\"chhaiya sent you a request \\ud83d\\udc8c\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-25 06:48:42', '2025-12-25 06:37:03', '2025-12-25 06:48:42'),
('ed9656fd-88bf-434b-9e6e-4d4aefe94c10', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 06:05:58', '2025-12-26 06:04:01', '2025-12-26 06:05:58'),
('efebbfcf-c0d9-4048-aef7-c0996ad48b10', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 18, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 06:05:53', '2025-12-26 06:05:39', '2025-12-26 06:05:53'),
('f38bd2fd-b393-42c3-929d-39d00ffe3e0a', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:36:08', '2025-12-31 07:32:59', '2025-12-31 07:36:08'),
('f8e982ba-d3eb-4fa7-83b5-b349563f916c', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 4, '{\"message\":\"This is a Last Warning. Please upload your Real photograph on our website within 3 days; otherwise, we will ban your profile\",\"report_id\":\"3\"}', '2025-12-31 08:03:35', '2025-12-31 07:57:33', '2025-12-31 08:03:35'),
('fa95b2ba-ce51-4c33-8580-426b40e30276', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 19, '{\"message\":\"Your profile has been banned due to a report.\",\"report_id\":\"1\"}', '2025-12-31 07:35:53', '2025-12-31 07:35:35', '2025-12-31 07:35:53'),
('fceafdb0-e18e-43af-9628-a02244140ab0', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 17, '{\"message\":\"You have been blocked \\u26d4\",\"request_id\":\"http:\\/\\/localhost:8000\\/dashboard\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-26 05:32:29', '2025-12-26 04:55:34', '2025-12-26 05:32:29'),
('fe7355db-295f-4721-b215-557078e84896', 'App\\Notifications\\ReportNotification', 'App\\Models\\User', 18, '{\"message\":\"bvhjdbvhfgjjnjdnbjf\",\"report_id\":14}', '2026-01-12 05:35:38', '2026-01-12 05:14:12', '2026-01-12 05:35:38'),
('ffa3c283-58af-44bd-a4b8-972eac2d1371', 'App\\Notifications\\UserRequestNotification', 'App\\Models\\User', 19, '{\"message\":\"Priya accepted your request \\ud83d\\udc96\",\"request_id\":\"http:\\/\\/localhost:8000\\/requests\\/sent\",\"url\":\"http:\\/\\/localhost:8000\\/requests\"}', '2025-12-25 08:19:14', '2025-12-25 08:19:03', '2025-12-25 08:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('testsp@gmail.com', '$2y$12$smP05fru1pGSkIe8i1U3E.xExFF/TJzZUzCw8pdgOaOFsSIe6icw2', '2026-02-03 07:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `age` int NOT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `community` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marital_status` enum('single','divorced','widow') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'single',
  `education` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preferences` json DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` enum('public','private') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `is_active` tinyint NOT NULL DEFAULT '1',
  `verified_by` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `age`, `religion`, `community`, `marital_status`, `education`, `profession`, `preferences`, `country`, `state`, `city`, `visibility`, `is_active`, `verified_by`, `created_at`, `updated_at`) VALUES
(2, 5, 24, 'Hindu', 'Vaishnav', 'single', '', 'Fasion Desiger', '{\"Cast\": \"Any\", \"age_max\": \"30\", \"age_min\": \"25\", \"location\": [\"India\", \"Gujarat\", \"Ahemdabad\"], \"religion\": \"Hindu\", \"profession\": [\"Architecture\"], \"personality\": [\"Simple, family-oriented\"], \"marital_status\": [\"single\"]}', 'India', 'Gujarat', 'Rajkot', 'public', 1, NULL, '2025-12-04 06:41:03', '2025-12-19 06:33:34'),
(13, 9, 23, 'hindu', 'Patel', 'single', '', 'professor', '{\"Cast\": \"Patel\", \"age_max\": \"32\", \"age_min\": \"25\", \"location\": [\"India,Gujarat\", \"Rajkot\"], \"religion\": \"Hindu\", \"profession\": [\"Accountant,Family Business\"], \"personality\": [\"Kind,Calm,Family man\"], \"marital_status\": [\"deactive\", \"single\"]}', 'india', 'Gujarat', 'Vadodara', 'public', 1, NULL, '2025-12-11 06:45:12', '2026-01-02 08:32:13'),
(18, 17, 25, 'Jain', 'Sthanakvasi', 'single', '', 'Web Developer', '{\"Cast\": \"Any\", \"age_max\": \"30\", \"age_min\": \"24\", \"location\": [\"India,Gujarat,Ahemdabad\"], \"religion\": \"Hindu\", \"profession\": [\"Architecture\"], \"personality\": [\"Simple, family-oriented, value-based\"], \"marital_status\": [\"single\"]}', 'India', 'Gujarat', 'Ahemdabad', 'public', 1, 1, '2025-12-18 06:11:55', '2025-12-20 05:31:48'),
(19, 18, 26, 'Hindu', 'Vaishnav', 'single', '', 'Software Engineer', '{\"Cast\": \"Vaishnav\", \"age_max\": \"30\", \"age_min\": \"25\", \"location\": [\"India,Gujarat\", \"Surat\"], \"religion\": \"Hindu\", \"profession\": [\"Fashion Designer\"], \"personality\": [\"Simple, family-oriented, value-based\"], \"marital_status\": [\"single\"]}', 'india', 'Gujarat', 'Rajkot', 'public', 1, NULL, '2025-12-18 06:21:19', '2026-01-09 05:19:33'),
(22, 19, 26, 'Hindu', 'Bramhin', 'single', 'B.com,M.com', 'Banker', '{\"Cast\": \"Bramhin\", \"age_max\": \"30\", \"age_min\": \"25\", \"location\": [\"India\", \"Maharastra\", \"Mumbai\"], \"religion\": \"Hindu\", \"profession\": [\"Any\"], \"personality\": [\"Soft-spoken\", \"patient\", \"and emotionally supportive\"], \"marital_status\": [\"single\"]}', 'india', 'Maharastra', 'Mumbai', 'public', 1, NULL, '2025-12-19 06:06:59', '2025-12-19 06:06:59'),
(23, 4, 28, 'Christian', 'Protestant', 'single', 'BCA', 'Software Engineer', '{\"Cast\": \"Any\", \"age_max\": \"35\", \"age_min\": \"30\", \"location\": [\"India, Karanatka\", \"Mysuru\"], \"religion\": \"Christian\", \"profession\": [\"Engineer\"], \"personality\": [\"Well-educated and professionally settled, Honest and respectful by nature\"], \"marital_status\": [\"single\"]}', 'India', 'Karnataka', 'Bangluru', 'public', 1, NULL, '2025-12-25 05:51:15', '2025-12-25 06:00:03'),
(24, 20, 24, 'hindu', 'Rajput', 'single', 'B.com,M.com', 'Bank Manager in Bank of Maharastra', '{\"Cast\": \"Rajput\", \"age_max\": \"32\", \"age_min\": \"26\", \"location\": [\"India, Gujarat, Rajkot\"], \"religion\": \"Hindu\", \"profession\": [\"Banker\"], \"personality\": [\"Well-educated and professionally settled, Honest and respectful by nature\"], \"marital_status\": [\"single\"]}', 'India', 'Gujarat', 'Rajkot', 'public', 1, 1, '2026-01-06 08:11:50', '2026-01-09 06:21:39'),
(26, 22, 25, 'Hindu', 'Rajput', 'single', 'Msc.IT', 'Software Engineer', '{\"Cast\": \"Rajput\", \"age_max\": \"30\", \"age_min\": \"23\", \"location\": [\"India, Gujarat\", \"Vadodra\"], \"religion\": \"Hindu\", \"profession\": [\"Any\"], \"personality\": [\"Simple, family-oriented, value-based\"], \"marital_status\": [\"single\"]}', 'india', 'Karnataka', 'Bengaluru', 'public', 1, NULL, '2026-01-08 08:00:05', '2026-01-08 08:01:33'),
(27, 25, 25, 'hindu', 'Rajput', 'single', 'Msc.IT', 'Software Engineer', '{\"Cast\": \"Vaishnav\", \"age_max\": \"25\", \"age_min\": \"22\", \"location\": [\"India, Gujarat, Rajkot\"], \"religion\": \"Hindu\", \"profession\": [\"Any\"], \"personality\": [\"Simple, family-oriented, value-based\"], \"marital_status\": [\"single\"]}', 'india', 'Gujarat', 'Rajkot', 'public', 1, NULL, '2026-01-15 05:51:32', '2026-01-15 06:15:24'),
(28, 27, 22, 'Hindu', 'Rajput', 'single', 'MBBS', 'Doctor', '{\"cast\": \"Vaisnav\", \"age_max\": \"30\", \"age_min\": \"25\", \"location\": [\"india\", \"Gujarat\", \"Rajkot\"], \"religion\": \"Hindu\", \"profession\": [\"Doctor\", \"Engginer\"], \"personality\": [\"Well-educated and professionally settled\", \"Honest and respectful by nature\"], \"marital_status\": [\"single\"]}', 'India', 'Gujarat', 'Rajkot', 'public', 1, NULL, '2026-01-16 05:33:18', '2026-01-16 05:33:18'),
(34, 28, 24, 'Hindu', 'Rajput', 'single', 'MBBS', 'Doctor', '{\"cast\": \"Any\", \"age_max\": \"30\", \"age_min\": \"26\", \"location\": [\"USA\", \"Florida\", \"Miami\"], \"religion\": \"Hindu\", \"profession\": [\"Doctor\"], \"personality\": [\"Calm\", \"Caring\", \"Supportive\"], \"marital_status\": [\"single\"]}', '6', '13', '27', 'public', 1, NULL, '2026-01-23 07:57:53', '2026-01-23 07:57:53'),
(37, 29, 24, 'Muslim', 'Sufi', 'single', 'B.com,M.com', 'Bank manager', '{\"Cast\": null, \"age_max\": \"30\", \"age_min\": \"26\", \"location\": [\"India,Maharashtra,Mumbai\"], \"religion\": \"Muslim\", \"profession\": [\"Developer\"], \"personality\": [\"Caring\", \"Supportive\", \"Romantic\", \"Funny\"], \"marital_status\": [\"single\"]}', '1', '2', '3', 'public', 1, NULL, '2026-01-30 05:24:29', '2026-02-03 06:17:49');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `skip` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `rating`, `comment`, `skip`, `created_at`, `updated_at`) VALUES
(2, 28, 5, NULL, 0, '2026-01-30 13:30:39', '2026-01-30 13:30:39'),
(3, 17, 5, NULL, 0, '2026-01-31 13:31:09', '2026-01-31 13:31:09'),
(4, 2, 0, NULL, 1, '2026-02-01 13:31:23', '2026-02-01 13:31:23'),
(6, 16, 3, NULL, 0, '2026-02-02 07:17:16', '2026-02-02 07:17:16'),
(7, 29, 4, 'loved the service, will definitely come back', 0, '2026-02-02 07:58:28', '2026-02-03 13:22:19'),
(9, 5, 0, NULL, 1, '2026-02-03 12:56:35', '2026-02-03 12:56:35');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `reporter_id` bigint UNSIGNED NOT NULL,
  `reported_profile_id` bigint UNSIGNED NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','resolved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `reporter_id`, `reported_profile_id`, `reason`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 22, 'Fake Profile', 'This profile is fake. I met this guy, thisis  not real, and he is misbehaving with me', 'resolved', '2025-12-30 07:47:49', '2025-12-31 07:21:09'),
(3, 22, 23, 'Harassment', 'Her behavior is very bad, and she does not look like the photo', 'resolved', '2025-12-31 07:43:55', '2025-12-31 07:46:51'),
(4, 24, 26, 'Fake Profile', 'This profile Is Fack the details are Wrong', 'resolved', '2026-01-09 07:32:00', '2026-01-09 07:47:55'),
(14, 24, 19, 'Fake Profile', 'bkfjvkfdfg', 'resolved', '2026-01-12 04:59:25', '2026-01-12 05:01:37'),
(16, 27, 2, 'Fake Profile', 'vvvhgubnbsdjks', 'pending', '2026-01-15 06:04:44', '2026-01-15 06:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('YZPpMo4oaFspwbdR2nJRlqfvtzKYI81L8NqQENeu', 29, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiclNjbURXR1ZTeXlPeVRJbTd0TmhyMXBXNkFBaGRmdEkzNmZPcllMRSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjk7fQ==', 1770126039);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gujarat', '2026-01-19 05:45:54', '2026-01-19 05:45:54'),
(2, 1, 'Maharashtra', '2026-01-19 05:45:54', '2026-01-19 05:45:54'),
(3, 2, 'California', '2026-01-19 05:45:54', '2026-01-19 05:45:54'),
(6, 1, 'Rajasthan', '2026-01-19 06:48:39', '2026-01-19 06:48:39'),
(8, 2, 'Texas', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(9, 2, 'New York', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(10, 5, 'Ontario', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(11, 5, 'British Columbia', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(12, 6, 'England', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(13, 6, 'Scotland', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(14, 7, 'New South Wales', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(15, 7, 'Victoria', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(16, 8, 'Bavaria', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(17, 8, 'Berlin', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(18, 9, 'Île-de-France', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(19, 9, 'Provence-Alpes-Côte d\'Azur', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(20, 10, 'Tokyo', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(21, 10, 'Osaka', '2026-01-19 06:48:40', '2026-01-19 06:48:40'),
(22, 11, 'Beijing', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(23, 11, 'Shanghai', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(24, 12, 'São Paulo', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(25, 12, 'Rio de Janeiro', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(26, 13, 'Gauteng', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(27, 13, 'Western Cape', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(28, 14, 'Dubai', '2026-01-19 06:48:41', '2026-01-19 06:48:41'),
(29, 14, 'Abu Dhabi', '2026-01-19 06:48:41', '2026-01-19 06:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  `couple_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `profile_id`, `couple_name`, `status`, `message`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 23, 'Neha & Abhisek', 'Married', 'Our success story is a reminder that love can find you when you least expect it. With patience, trust, and genuine intentions, this platform helped us discover a bond that feels natural and lasting. Today, we look forward to a lifetime of memories together', 'testimonials/mA6vOoDpqrvPc2GRLlFQKFmPBDEPWm8P22xgILv5.jpg', 1, '2026-01-28 05:26:56', '2026-01-28 05:26:56'),
(2, 13, 'Shradha & Mitul', 'Engaged', 'We joined this platform with hope and patience, and it truly rewarded us. Our conversations felt natural, honest, and respectful from the very beginning. Over time, we discovered shared values, mutual understanding, and a deep connection. Today, we are happily married and grateful for this beautiful journey.', 'testimonials/4qzEwbRU77aJjdJOMJ2zKhmoV7jE55Z2fa8K3RFz.jpg', 1, '2026-01-28 05:46:02', '2026-01-28 05:46:02'),
(3, 18, 'Ritu & Mayur', 'Married', 'This platform made the journey of finding a life partner simple and meaningful. There was no pressure, only comfort and clarity. From our first conversation to our wedding day, everything felt perfectly aligned. We truly found a partner for life.', 'testimonials/mlXYXQVjVH25N4VKSqXGU62iBPf5yq7kyA5xxXuE.jpg', 1, '2026-01-28 05:47:18', '2026-01-28 05:47:18'),
(4, 2, 'Kavya & Sandeep', 'Engaged', 'This platform values emotions, trust, and meaningful connections. Our conversations were deep and sincere, leading us to believe we had found the right partner. We are excited to build our future together.', 'testimonials/kSptXYKSckBG5q3K07X7jwpDzkXMRZxie1BWCNKt.jpg', 1, '2026-01-28 05:49:16', '2026-01-28 05:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Female','Male') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','premium','free') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free',
  `plan` enum('Active','Expired','Canceled','None') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'None',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'None',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `gender`, `email_verified_at`, `password`, `role`, `plan`, `status`, `remember_token`, `created_at`, `updated_at`, `session_id`) VALUES
(1, 'Shreya Poriya', 'shreya.p@techxperts.co.in', 'Female', NULL, '$2y$12$PXyKZgJrItoGSf7ACHtZRu5eRkNOJiXVAIrjI/Klh3PQh6R2Dkfi.', 'admin', 'None', 'None', NULL, '2025-12-02 07:57:07', '2026-01-12 08:13:33', NULL),
(2, 'Lilah Copeland', 'mopoku@mailinator.com', 'Male', NULL, '$2y$12$r8paRUfGt9jbyKyrLKpQiuBCHpCHgBx/mdQ4DJspWQUNceQ9UEdMm', 'free', 'None', 'None', NULL, '2025-12-02 08:14:41', '2025-12-02 08:14:41', NULL),
(4, 'chhaiya', 'testtest95107@gmail.com', 'Female', NULL, '$2y$12$7nmm6Z6GKnHTuLWVHWNYz.1XrLfyOlR8OYnhwqEHgv8vjHPpEJalm', 'free', 'None', 'None', 'gwdztqMSJ3yUJmF2ALH3OUOA0CUO4kOLwoWGwbUzG6H5ggMzdYOzR9X8E5yK', '2025-12-03 06:28:56', '2026-01-28 05:14:36', NULL),
(5, 'Priya', 'priyashah@gmail.com', 'Female', NULL, '$2y$12$u1QP6XoFFbNUzjQr2EZSgOfwK.HwqV.stQcYCsOw3Yw8fYB9cNA52', 'free', 'None', 'None', NULL, '2025-12-03 08:12:43', '2025-12-03 08:12:43', NULL),
(9, 'Isha Vora', 'ishavora@gmail.com', 'Female', NULL, '$2y$12$xVO/oGKafGvgU1.GwS.9zeBY2w1BQ5lfsORhK3cg52X0osIOYJ8fy', 'free', 'None', 'None', NULL, '2025-12-03 08:29:10', '2026-01-06 06:45:55', NULL),
(14, 'isha', 'ishavora123@example.com', 'Female', NULL, '$2y$12$EkMGdMMEipHzxJ9AebPN3u.Ft5.a1cQhCUaZPYAfhhjIjmHTYuAPu', 'free', 'None', 'None', NULL, '2025-12-08 06:14:43', '2026-01-06 08:21:53', NULL),
(16, 'Meera Patel', 'meerap895@gmail.com', 'Female', NULL, '$2y$12$JP7vmfzzBzutIKgehqz9JO0PKiQ5TuBmXtCI0IJk7IGcsKMZ1Vyw2', 'free', 'None', 'None', NULL, '2025-12-11 05:24:59', '2026-01-06 08:21:49', NULL),
(17, 'Swati Gangani', 'swatig07@gmail.com', 'Female', NULL, '$2y$12$M4i6wClEsw1EhSLph7FocuGoDCUjCQOz7UWdwlfNGEfIXx041BspC', 'free', 'None', 'None', NULL, '2025-12-18 06:04:35', '2026-01-06 08:16:00', NULL),
(18, 'Viral Gangani', 'techxpert.manish@gmail.com', 'Male', NULL, '$2y$12$YOqaSOo1Kr/qWRfX2fvfqe5.2pJAID9Bl8CyMzkuO/EQVXensHC3a', 'free', 'None', 'None', NULL, '2025-12-18 06:13:07', '2026-01-12 04:47:57', NULL),
(19, 'Ravi Joshi', 'ravij253@gmail.com', 'Female', NULL, '$2y$12$Fmh5cQ3uVPsPoyisVu/4FeiKwjrVep6hxD6rNPnzSZ744YVmKwXlm', 'free', 'None', 'banned', NULL, '2025-12-19 05:59:11', '2026-01-06 06:49:19', NULL),
(20, 'Shreya poriya', 'shreyaporiya08@gmail.com', 'Female', NULL, '$2y$12$uGl3hMwIijF1ZqykT0xF.Ov.H6FW7Ndh1PmqzQ8SXiR8uS3suj.xW', 'free', 'None', 'None', NULL, '2026-01-06 08:04:39', '2026-01-06 08:39:43', NULL),
(22, 'Rishiraj Jadeja', 'rishiraj456@gmail.com', 'Male', NULL, '$2y$12$ihaRj5ZmbdRxQoGqIjfx1upcggicwhulMyt/JpSwIQh7Ci9yw0fTa', 'free', 'None', 'None', NULL, '2026-01-08 07:58:58', '2026-01-13 08:08:03', NULL),
(23, 'Krina Visrolia', 'krinavisrolia123@gmail.com', 'Female', NULL, '$2y$12$99Ke6T3YfGyCxXQVJE36ROjDRw9mgVNPS81FlkT/rFaWoiNr2ksoa', 'free', 'None', 'None', NULL, '2026-01-13 06:00:54', '2026-01-13 06:00:54', NULL),
(24, 'test', 'test@stazing.com', 'Female', NULL, '$2y$12$kKy/rUtV5jA49HrBE/8xgeMNWDjjyTjC3m6fqZjB/2QEDCndckGZO', 'free', 'None', 'None', NULL, '2026-01-15 05:15:39', '2026-01-28 07:59:47', NULL),
(25, 'tersd', 'testabc@stazing.com', 'Male', NULL, '$2y$12$3ez93GI7TR/G5KZqdxfpieA9q78NugUFV08X7Eed676HwV7./GTU2', 'free', 'None', 'None', NULL, '2026-01-15 05:21:22', '2026-01-15 05:21:22', NULL),
(27, 'testtest', 'testtest@gmail.com', 'Female', NULL, '$2y$12$hU0bf6WnB5DG8dYnok3BX.qMbk5yWzk/QqZG9Y6lEfA9PEWDZu.sy', 'free', 'None', 'None', NULL, '2026-01-15 08:13:12', '2026-01-15 08:13:12', NULL),
(28, 'testshreya', 'testshreya@gmail.com', 'Female', NULL, '$2y$12$KWs0CV85e2F0xPs9YgGvq.Znp3/dmxELyebYsd5w7/ojM5eaTPY22', 'free', 'None', 'None', NULL, '2026-01-23 07:09:08', '2026-01-23 07:09:08', NULL),
(29, 'testsp', 'testsp@gmail.com', 'Male', NULL, '$2y$12$UoBVfNNcZtmo.eRRyhtmluTfzNLyMhPInGMs5bOPxQO7BYhTD/wye', 'free', 'None', 'None', 'AVGPlyH4wfZhKWzTkMMnKAeDJjwH9abpgLqACTi1YYhz6MJAkKyFNZcRx4va', '2026-01-27 05:38:09', '2026-01-27 05:40:06', NULL),
(30, 'shreya test', 'shreyatest@gmail.com', 'Male', NULL, '$2y$12$2.iYlZzxHUZhR83tLIZjqe4yCQ2HNlNvtFyEtczL9Ah5WZFbFt1Ci', 'free', 'None', 'None', NULL, '2026-02-03 13:02:33', '2026-02-03 13:23:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_request`
--

CREATE TABLE `user_request` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `is_pending` tinyint NOT NULL DEFAULT '1',
  `is_accepted` tinyint NOT NULL DEFAULT '0',
  `is_rejected` tinyint NOT NULL DEFAULT '0',
  `is_blocked` tinyint NOT NULL DEFAULT '0',
  `is_canceled` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_request`
--

INSERT INTO `user_request` (`id`, `sender_id`, `receiver_id`, `is_pending`, `is_accepted`, `is_rejected`, `is_blocked`, `is_canceled`, `created_at`, `updated_at`) VALUES
(6, 23, 22, 1, 0, 1, 0, 0, '2025-12-25 06:37:03', '2025-12-31 07:40:21'),
(7, 2, 22, 1, 1, 0, 0, 0, '2025-12-25 06:37:48', '2026-01-02 06:55:34'),
(8, 22, 2, 0, 1, 0, 0, 0, '2025-12-25 06:38:28', '2025-12-25 08:19:03'),
(9, 18, 22, 1, 0, 1, 0, 0, '2025-12-26 04:47:52', '2026-01-02 06:55:38'),
(12, 19, 18, 1, 0, 0, 1, 0, '2025-12-26 05:37:32', '2025-12-26 06:05:39'),
(13, 24, 19, 1, 0, 0, 0, 1, '2026-01-09 05:19:51', '2026-01-12 04:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--

CREATE TABLE `verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  `doc_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verifications`
--

INSERT INTO `verifications` (`id`, `profile_id`, `doc_type`, `doc_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 18, 'aadhaar', 'verification_docs/92b6sNjF1TocorMMnPTihOKiauLwqtw5B05hiVjX.jpg', 1, '2025-12-29 06:19:29', '2025-12-29 06:19:29'),
(2, 19, 'aadhaar', 'verification_docs/SAsFUBXIXJjoCxW1sRhEgDsamJmAj1T1B4O0bQGv.jpg', 2, '2025-12-29 08:48:41', '2025-12-29 08:48:41'),
(3, 24, 'pan', 'verification_docs/11KveAeJEiHKqm82hwDCjuudsNWJmtnEEVB9x66W.png', 1, '2026-01-09 05:46:53', '2026-01-09 05:46:53'),
(4, 23, 'passport', 'verification_docs/57JQSLrteiTT4f7JRs2oev0VvzSS7bNNvjzWaGd4.png', 0, '2026-01-12 07:06:15', '2026-01-12 07:06:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_images`
--
ALTER TABLE `admin_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_foreign` (`state_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filters_profile_id_foreign` (`profile_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_user_id_foreign` (`user_id`),
  ADD KEY `images_profile_id_foreign` (`profile_id`);

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
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_reporter_id_foreign` (`reporter_id`),
  ADD KEY `reports_reported_profile_id_foreign` (`reported_profile_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_profile_id_foreign` (`profile_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_request`
--
ALTER TABLE `user_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_request_sender_id_foreign` (`sender_id`),
  ADD KEY `user_request_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verifications_profile_id_foreign` (`profile_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_images`
--
ALTER TABLE `admin_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `filters`
--
ALTER TABLE `filters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_request`
--
ALTER TABLE `user_request`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_images`
--
ALTER TABLE `admin_images`
  ADD CONSTRAINT `admin_images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `filters`
--
ALTER TABLE `filters`
  ADD CONSTRAINT `filters_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_reported_profile_id_foreign` FOREIGN KEY (`reported_profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_reporter_id_foreign` FOREIGN KEY (`reporter_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_request`
--
ALTER TABLE `user_request`
  ADD CONSTRAINT `user_request_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_request_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verifications`
--
ALTER TABLE `verifications`
  ADD CONSTRAINT `verifications_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
