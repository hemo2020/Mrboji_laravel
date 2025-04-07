-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 12:20 AM
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
-- Database: `boji`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Toyota', '2024-06-04 13:05:38', '2024-06-04 13:05:38'),
(2, 'FORD', '2024-06-05 12:27:11', '2024-06-05 12:27:11'),
(3, 'BMW', '2024-06-05 12:27:21', '2024-06-05 12:27:21'),
(4, 'changan', '2024-06-06 11:12:10', '2024-06-06 11:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `brand`, `model`, `year`, `created_at`, `updated_at`) VALUES
(8, 'ايمن', 'فورد', 'ب150', '2022', '2024-05-20 13:05:31', '2024-05-21 12:15:41'),
(9, '.', 'Toyota', 'Fj', '2020', '2024-06-04 13:05:26', '2024-06-04 13:05:26');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_no` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `vin` varchar(255) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `closing_date` date DEFAULT NULL,
  `status` enum('pending','in_progress','completed','close') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `case_no`, `brand`, `model`, `year`, `vin`, `created_by`, `assigned_to`, `date`, `closing_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'DA1234567789', 'Toyota', 'FJ', '2024', 'fj1532154646764', 2, 3, '2024-05-22', '2024-06-04', 'close', '2024-05-22 12:00:25', '2024-06-04 15:14:22'),
(3, 'DA123456788', 'Ford', 'Crowon victoria', '2011', 'laksjfklajsf46464', 3, 4, '2024-05-22', NULL, 'in_progress', '2024-05-23 14:36:27', '2024-05-25 00:15:52'),
(7, 'DA147258', 'ford', 'f140', '2014', '2574133699', 2, 3, '2024-05-24', '2024-06-04', 'close', '2024-05-24 17:21:19', '2024-06-04 15:10:16'),
(8, 'da1472580', 'toyota', 'fj', '2020', 'hjgjhgjhgj', 2, 3, '2024-05-25', '2024-06-04', 'close', '2024-05-25 16:30:04', '2024-06-04 15:14:04'),
(9, 'da987654', 'bmw', '750l', '2022', 'jhgj12346', 2, 4, '2024-05-26', '2024-06-04', 'close', '2024-05-26 00:20:10', '2024-06-04 15:12:31'),
(10, 'sa150000', 'nissan', 'altima', '2015', 'bjjkb1231', 2, 3, '2024-05-26', '2024-06-04', 'close', '2024-05-26 11:18:09', '2024-06-04 15:12:47'),
(11, '22229952', 'toyota', 'fj', '2000', 'ihihihi', 2, 3, '2024-05-26', '2024-06-04', 'close', '2024-05-26 13:03:56', '2024-06-04 15:12:59'),
(12, 'DA101010', 'Toyota', 'fj', '2022', 'kdfjgld456', 2, 3, '2024-05-26', '2024-06-04', 'close', '2024-05-26 13:09:53', '2024-06-04 15:14:36'),
(13, 'jj123', 'toyota', 'camry', '2022', 'hgj1234567', 2, 3, '2024-05-26', '2024-06-04', 'close', '2024-05-26 16:32:00', '2024-06-04 15:13:55'),
(14, 'saaa10123', 'bmw', '750', '2024', 'abcdef', 5, 6, '2024-05-27', NULL, 'completed', '2024-05-27 10:10:02', '2024-05-27 10:11:52'),
(15, 'DA102030', 'Toyota', 'Fj', '2020', 'fdfs123', 2, 3, '2024-06-04', '2024-06-04', 'close', '2024-06-04 13:11:10', '2024-06-04 13:12:53'),
(16, 'DA203040', 'Toyota', 'Fj', '2024', 'jkadshfkah2', 2, 3, '2024-06-04', '2024-06-04', 'close', '2024-06-04 15:08:30', '2024-06-04 15:13:43'),
(17, 'da1040', 'Toyota', 'Fj', '2020', 'abcd12345', 2, 3, '2024-06-04', NULL, 'in_progress', '2024-06-04 15:15:36', '2024-06-04 15:15:45'),
(18, 'DA10203000', 'FORD', 'F150', '2018', 'kdjsfksjdf55555474', 2, 3, '2024-06-05', NULL, 'in_progress', '2024-06-05 10:50:33', '2024-06-05 12:28:57'),
(19, 'DA10203040', 'Toyota', 'Fj', '2010', 'skhfkjshg123', 2, 3, '2024-06-05', '2024-06-05', 'close', '2024-06-05 11:09:22', '2024-06-05 11:29:02'),
(20, 'da102201', 'changan', 'rt', '2020', 'da210230fd', 2, 3, '2024-06-06', '2024-06-06', 'close', '2024-06-06 11:13:17', '2024-06-06 11:16:18'),
(21, 'DA4789654', 'BMW', '750L', '2020', 'bcde', 2, 3, '2024-06-06', NULL, 'in_progress', '2024-06-06 11:36:08', '2024-06-06 11:36:08'),
(22, 'DA1020304099', 'BMW', '750L', '2020', 'asdxz', 2, 3, '2024-06-09', NULL, 'in_progress', '2024-06-09 10:38:48', '2024-06-09 10:38:48'),
(23, 'DA1020304000', 'FORD', '750L', '2020', 'sa123453', 2, 3, '2024-06-13', NULL, 'in_progress', '2024-06-13 12:58:50', '2024-06-13 12:58:50'),
(24, '123', 'BMW', '750L', '2020', '12345jhjhj', 2, 3, '2024-10-09', '2024-10-09', 'close', '2024-10-09 16:25:55', '2024-10-09 16:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `case_pricings`
--

CREATE TABLE `case_pricings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_id` int(10) UNSIGNED NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `part_no` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `discount` decimal(8,2) DEFAULT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_pricings`
--

INSERT INTO `case_pricings` (`id`, `case_id`, `part_name`, `qty`, `part_no`, `price`, `discount`, `total`, `created_at`, `updated_at`) VALUES
(1, 4, 'صدام امامي', 1, NULL, NULL, NULL, NULL, '2024-05-24 16:59:00', '2024-05-24 16:59:00'),
(2, 4, 'شمعة يمين', 1, NULL, NULL, NULL, NULL, '2024-05-24 16:59:00', '2024-05-24 16:59:00'),
(3, 5, 'door', 1, NULL, NULL, NULL, NULL, '2024-05-24 17:07:00', '2024-05-24 17:07:00'),
(4, 6, 'صدام', 1, NULL, NULL, NULL, NULL, '2024-05-24 17:13:06', '2024-05-24 17:13:06'),
(5, 7, 'صدام امامي', 1, 'vcf2546', 2500.00, 25.00, NULL, '2024-05-24 17:21:19', '2024-05-26 00:17:56'),
(6, 1, 'light', 1, 'fgsa', 1200.00, 25.00, NULL, '2024-05-25 00:04:10', '2024-05-26 14:09:16'),
(8, 9, 'صدام امامي', 1, 'kjhv', 3500.00, 15.00, NULL, '2024-05-26 00:20:10', '2024-05-26 00:21:17'),
(9, 9, 'شمعة', 1, '1480', 1500.00, 20.00, NULL, '2024-05-26 00:20:10', '2024-05-26 00:21:17'),
(10, 10, 'door', 1, 'xyzabc', 1100.00, 15.00, NULL, '2024-05-26 11:18:09', '2024-05-26 11:19:33'),
(11, 10, 'glass', 1, 'aaxz', 1200.00, 15.00, NULL, '2024-05-26 11:18:09', '2024-05-26 11:19:33'),
(12, 11, 'صدام', 1, 'fg456', 1400.00, 25.00, NULL, '2024-05-26 13:03:56', '2024-05-26 13:05:24'),
(13, 11, 'تاتا', 1, '1470', 1230.00, 25.00, NULL, '2024-05-26 13:03:56', '2024-05-26 13:05:24'),
(14, 12, 'شمعة', 1, 'xfkjh', 1200.00, 10.00, NULL, '2024-05-26 13:09:53', '2024-05-26 13:11:07'),
(15, 13, 'light', 1, '12234', 5000.00, 0.00, NULL, '2024-05-26 16:32:00', '2024-06-04 13:09:31'),
(16, 13, 'door', 1, '12345', 1000.00, 0.00, NULL, '2024-02-01 16:32:00', '2024-06-04 13:09:31'),
(17, 8, 'door', 1, 'xzsffdf', 1200.00, 30.00, NULL, '2024-05-27 10:01:19', '2024-05-29 17:23:01'),
(18, 14, 'door', 1, 'xyz', 1500.00, 15.00, NULL, '2024-02-01 10:10:02', '2024-05-27 10:11:52'),
(19, 14, 'hood', 1, 'abcdxyz', 2000.00, 15.00, NULL, '2024-05-27 10:10:02', '2024-05-27 10:11:52'),
(20, 15, 'light', 1, '12345', 1000.00, 0.00, NULL, '2024-06-04 13:11:10', '2024-06-04 13:11:53'),
(21, 16, 'light', 1, '12345', 1000.00, 5.00, NULL, '2024-06-04 15:08:30', '2024-06-04 15:09:35'),
(22, 16, 'glass', 1, '12345', 1000.00, 5.00, NULL, '2024-06-04 15:08:30', '2024-06-04 15:09:35'),
(23, 17, 'light', 1, NULL, NULL, NULL, NULL, '2024-06-04 15:15:36', '2024-06-04 15:15:36'),
(24, 17, 'mud guared', 1, NULL, NULL, NULL, NULL, '2024-06-04 15:15:36', '2024-06-04 15:15:36'),
(32, 19, 'صدام', 1, '12345', 1000.00, 5.00, NULL, '2024-06-05 11:09:22', '2024-06-05 11:28:14'),
(33, 19, 'كفر', 1, '2547', 100.00, 1.00, NULL, '2024-06-05 11:09:22', '2024-06-05 11:28:14'),
(34, 19, 'باب', 1, '547', 3250.00, 3.00, NULL, '2024-06-05 11:09:22', '2024-06-05 11:28:14'),
(35, 19, 'كبوت', 1, '2547', 1200.00, 25.00, NULL, '2024-06-05 11:09:22', '2024-06-05 11:28:14'),
(36, 19, 'باب شنطة', 1, '2540', 1400.00, 5.00, NULL, '2024-06-05 11:09:22', '2024-06-05 11:28:14'),
(37, 19, 'زجاج امامي', 1, '12547', 15.00, 10.00, NULL, '2024-06-05 11:09:22', '2024-06-05 11:28:14'),
(45, 18, 'door', 1, '1234', 100.00, 20.00, NULL, '2024-06-05 12:28:57', '2024-06-06 11:22:05'),
(46, 18, 'light', 1, '123456', 1200.00, 25.00, NULL, '2024-06-05 12:28:57', '2024-06-06 11:22:05'),
(47, 18, 'front bumber', 1, '25', 100.00, 0.00, NULL, '2024-06-05 12:28:57', '2024-06-06 11:22:05'),
(48, 18, 'hood', 1, NULL, NULL, NULL, NULL, '2024-06-05 12:28:57', '2024-06-05 12:28:57'),
(49, 18, 'mud guared', 1, NULL, NULL, NULL, NULL, '2024-06-05 12:28:57', '2024-06-05 12:28:57'),
(50, 18, 'tyre', 1, NULL, NULL, NULL, NULL, '2024-06-05 12:28:57', '2024-06-05 12:28:57'),
(51, 18, 'tail light', 1, NULL, NULL, NULL, NULL, '2024-06-05 12:28:57', '2024-06-05 12:28:57'),
(52, 20, 'light', 1, '147', 50.00, 20.00, NULL, '2024-06-06 11:13:17', '2024-06-06 11:14:27'),
(53, 20, 'door', 1, '1234', 100.00, 20.00, NULL, '2024-06-06 11:13:17', '2024-06-06 11:14:27'),
(54, 21, 'light', 1, 'abc123', 1000.00, 20.00, NULL, '2024-06-06 11:36:08', '2024-06-06 11:37:53'),
(55, 21, 'hood', 1, 'ab123', 1200.00, 20.00, NULL, '2024-06-06 11:36:08', '2024-06-06 11:37:53'),
(56, 22, 'صدام', 1, NULL, NULL, NULL, NULL, '2024-06-09 10:38:48', '2024-06-09 10:38:48'),
(57, 22, 'باب', 1, NULL, NULL, NULL, NULL, '2024-06-09 10:38:48', '2024-06-09 10:38:48'),
(58, 23, 'صدام', 1, NULL, NULL, NULL, NULL, '2024-06-13 12:58:50', '2024-06-13 12:58:50'),
(59, 24, 'light', 1, 'acx', 2000.00, 25.00, NULL, '2024-10-09 16:25:55', '2024-10-09 16:27:14');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_01_24_025019_create_notifications_table', 1),
(7, '2024_05_17_030418_create_cars_table', 1),
(8, '2024_05_17_130418_create_cases_table', 2),
(9, '2024_05_17_230418_create_case_pricings_table', 3),
(10, '2024_05_29_030418_create_brands_table', 4),
(11, '2024_05_29_130418_create_models_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `name`, `brand_id`, `created_at`, `updated_at`) VALUES
(1, 'Fj', 1, '2024-06-04 13:10:11', '2024-06-04 13:10:11'),
(2, 'F150', 2, '2024-06-05 12:27:47', '2024-06-05 12:27:47'),
(3, '750L', 3, '2024-06-05 12:27:56', '2024-06-05 12:27:56'),
(4, 'rt', 4, '2024-06-06 11:12:31', '2024-06-06 11:12:31');

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

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
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
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `role` enum('admin','writer','pricing') NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=>Inactive, 1=>Active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `city`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '2024-05-20 13:02:19', '$2y$10$X/.j429oka8lCT/2aYs31OuGrJOqjDAHF7BNtex0jzhgJdbs981hy', NULL, NULL, NULL, 'admin', 1, 'CyseV1eaGSwEXDXEE2YyphFedMuYa3SaahFSKlaYVqd7M8nzngABxKluEWAl', '2024-05-20 13:02:19', '2024-05-20 13:02:19'),
(2, 'Writer User', 'writer@admin.com', '2024-05-20 13:02:19', '$2y$10$LhORZqKEgPm.WfqVIaOkbu182su6Y/LD8tFB3QjT/SVF3ERfjGilO', NULL, NULL, NULL, 'writer', 1, 'rnAHNRUuC4sCVKp8eQilNTrPLiQvXEorpXy7LiTY56DkiRIOI0QshRf2u8oz', '2024-05-20 13:02:19', '2024-05-20 13:02:19'),
(3, 'Pricing User', 'pricing@admin.com', '2024-05-20 13:02:19', '$2y$10$rp9Q1tg8k6LgRSwHnRjUpO05nQhHa5.E4ksZGGLJwwWc5VQMkARw2', NULL, NULL, NULL, 'pricing', 1, '2grjmSqvXCqV1b2drM3ZsPQGNXlqH80OD78C7FXnJ4uSMxRqfa7Lf0Sndp1t', '2024-05-20 13:02:19', '2024-05-20 13:02:19'),
(5, 'ibrahim bashmmakh', 'hemo@gmail.com', NULL, '$2y$10$CQeKqQgzoyqgImc.UZpAZ.V32FpVjcjzZf6y/tmmsUuVLP79FA2h6', '0507986759', 'riyadh', 'الرياض', 'writer', 1, NULL, '2024-05-27 10:03:55', '2024-05-27 10:03:55'),
(6, 'ibrahim bashmmakh', 'hemoo@gmail.com', NULL, '$2y$10$MlDOwobobdIyMJTJFz02/uoGznI1WWFQJl3JDTc0dN2iE5XWXBeEm', '05079867..', 'الاصيل\r\n2', 'الرياض', 'pricing', 1, NULL, '2024-05-27 10:04:55', '2024-05-27 10:04:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_pricings`
--
ALTER TABLE `case_pricings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `models_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `case_pricings`
--
ALTER TABLE `case_pricings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `models_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
