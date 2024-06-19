-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2024 at 11:09 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intisar`
--

-- --------------------------------------------------------

--
-- Table structure for table `insurances`
--

CREATE TABLE `insurances` (
  `id` int NOT NULL,
  `member_id` varchar(50) NOT NULL DEFAULT '',
  `insurance_number` varchar(50) DEFAULT NULL,
  `general_command` int DEFAULT '0',
  `month` int DEFAULT NULL,
  `year` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at_paid` varchar(50) DEFAULT NULL,
  `archiv` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `insurances`
--

INSERT INTO `insurances` (`id`, `member_id`, `insurance_number`, `general_command`, `month`, `year`, `created_at`, `created_by`, `updated_at`, `updated_by`, `amount`, `paid`, `updated_at_paid`, `archiv`) VALUES
(17, '288612', '', 0, NULL, 2021, '2024-06-13 03:18:40', '1', '2024-06-13 17:27:28', '1', '100.00', 0, NULL, 0),
(18, '524412', '78657', 1, NULL, 2023, '2024-06-13 03:19:11', '1', '2024-06-13 17:26:13', '1', '160.00', 1, NULL, 0),
(19, '341541', '12345', 1, NULL, 2023, '2024-06-13 03:38:51', '1', '2024-06-13 17:26:07', '1', '150.00', 0, NULL, 0),
(20, '357073', '', 0, NULL, 2021, '2024-06-13 03:39:54', '1', '2024-06-13 17:26:56', '1', '160.00', 0, NULL, 0),
(21, '615184', '', 0, NULL, 2021, '2024-06-13 03:40:06', '1', '2024-06-13 17:26:52', '1', '160.00', 0, NULL, 0),
(22, '097540', '', 0, NULL, 2022, '2024-06-13 07:36:43', '1', '2024-06-13 17:26:47', '1', '140.00', 1, NULL, 0),
(23, '097541', '20053', 1, NULL, 2023, '2024-06-13 07:38:50', '1', '2024-06-13 17:26:02', '1', '130.00', 1, NULL, 0),
(24, '097543', '', 0, NULL, 2022, '2024-06-13 07:39:02', '1', '2024-06-13 17:26:42', '1', '150.00', 1, NULL, 0),
(25, '987654', '', 0, NULL, 2022, '2024-06-13 17:25:24', '1', '2024-06-13 17:26:28', '1', '120.00', 0, NULL, 0),
(26, '876543', '875667', 1, NULL, 2023, '2024-06-13 17:25:35', '1', '2024-06-13 17:26:18', '1', '110.00', 1, NULL, 0),
(27, '615184', '', 0, NULL, 2024, '2024-06-13 17:27:49', '1', '2024-06-19 06:42:27', '1', '160.00', 0, '2024-06-19 07:42:27', 0),
(28, '654321', '0896', 1, NULL, 2024, '2024-06-13 17:28:09', '1', '2024-06-19 06:49:26', '1', '150.00', 1, '2024-06-19 07:49:26', 0),
(29, '097550', '', 0, NULL, 2024, '2024-06-13 17:28:16', '1', '2024-06-13 17:28:16', '1', '120.00', 0, NULL, 0),
(30, '097544', '5443', 1, NULL, 2024, '2024-06-13 17:28:26', '1', '2024-06-13 17:40:43', '1', '160.00', 0, NULL, 0),
(31, '097538', '', 0, NULL, 2024, '2024-06-13 17:28:35', '1', '2024-06-13 17:28:35', '1', '120.00', 0, NULL, 0),
(32, '097537', '123', 1, NULL, 2024, '2024-06-13 17:28:43', '1', '2024-06-19 06:48:51', '1', '120.00', 0, '2024-06-19 07:48:51', 0),
(33, '524412', '612', 1, NULL, 2024, '2024-01-13 17:28:52', '1', '2024-06-19 06:49:11', '1', '160.00', 1, '2024-06-19 07:49:11', 0),
(34, '357073', '', 0, NULL, 2024, '2024-06-13 17:29:06', '1', '2024-06-19 06:49:35', '1', '160.00', 1, '2024-06-19 07:49:35', 0),
(35, '524412', '', 0, NULL, 2021, '2024-06-13 23:42:37', '1', '2024-06-13 23:42:37', '1', '160.00', 1, NULL, 0),
(36, '524412', '5646', 1, NULL, 2018, '2024-06-13 23:43:08', '1', '2024-06-13 23:43:08', '1', '160.00', 0, NULL, 0),
(37, '097548', '', 0, NULL, 2024, '2024-06-18 23:59:08', '1', '2024-06-19 06:48:47', '1', '100.00', 0, '2024-06-19 07:48:47', 0),
(38, '876543', '', 0, NULL, 2024, '2024-06-19 06:55:43', '1', '2024-06-19 06:57:50', '1', '110.00', 1, '2024-06-19 07:55:43', 1),
(39, '876543', '', 0, NULL, 2024, '2024-06-19 06:58:11', '1', '2024-06-19 07:00:56', '1', '110.00', 1, '2024-06-19 07:58:11', 1),
(40, '876543', '', 0, NULL, 2024, '2024-06-19 07:01:02', '1', '2024-06-19 07:01:36', '1', '110.00', 1, '2024-06-19 08:01:02', 1),
(41, '876543', '', 0, NULL, 2024, '2024-06-19 07:01:43', '1', '2024-06-19 07:03:01', '1', '110.00', 1, '2024-06-19 08:01:43', 1),
(42, '876543', '', 0, NULL, 2024, '2024-06-19 07:03:33', '1', '2024-06-19 07:04:26', '1', '110.00', 1, '2024-06-19 08:03:33', 1),
(43, '876543', '', 0, NULL, 2024, '2024-06-19 07:04:30', '1', '2024-06-19 07:04:30', '1', '110.00', 0, '2024-06-19 08:04:30', 0),
(44, '852241', '', 0, NULL, 2024, '2024-06-19 07:04:42', '1', '2024-06-19 07:04:42', '1', '120.00', 1, '2024-06-19 08:04:42', 0),
(45, '765432', '', 0, NULL, 2024, '2024-06-19 07:07:06', '1', '2024-06-19 07:07:06', '1', '140.00', 1, '2024-06-19 08:07:06', 0),
(46, '234567', '', 0, NULL, 2024, '2024-06-19 07:07:48', '1', '2024-06-19 07:07:48', '1', '110.00', 1, '2024-06-19 08:07:48', 0),
(47, '987654', '', 0, NULL, 2024, '2024-06-19 07:08:02', '1', '2024-06-19 07:08:02', '1', '120.00', 0, '2024-06-19 08:08:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `member_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('ذكر','أنثى') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dob` date NOT NULL,
  `place_of_increase` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `father_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mother_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mother_last_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `job_father` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `job_mother` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sport` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `educational_institution` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `family_status` enum('مطلقان','وفاة الأب','وفاة الأم','وفاة كلا الوالدين','لا شي') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `caregiver` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `living_condition` enum('جيدة','عادية','تحت المتوسط','سيئة','سيئة جدا') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guardian_id_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `chronic_diseases` text COLLATE utf8mb4_general_ci,
  `hobbies` text COLLATE utf8mb4_general_ci,
  `picture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `insurance` tinyint(1) DEFAULT NULL,
  `insurance_number` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `insurance_payer` tinyint(1) DEFAULT NULL,
  `scout_uniform_size` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `has_scout_uniform` tinyint(1) NOT NULL,
  `scout_uniform_payer` tinyint(1) NOT NULL,
  `scout_unit` enum('أشبال','كشاف','جوال','زهرات','دليلات','مرشدات','قائد','عميد') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `added_by` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modified_by` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `archiv` tinyint NOT NULL DEFAULT '0',
  `data` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_id`, `first_name`, `last_name`, `gender`, `dob`, `place_of_increase`, `father_name`, `mother_name`, `mother_last_name`, `job_father`, `job_mother`, `sport`, `educational_institution`, `family_status`, `caregiver`, `living_condition`, `guardian_id_number`, `phone_number`, `address`, `chronic_diseases`, `hobbies`, `picture`, `insurance`, `insurance_number`, `insurance_payer`, `scout_uniform_size`, `has_scout_uniform`, `scout_uniform_payer`, `scout_unit`, `joining_date`, `added_by`, `added_date`, `last_modified_date`, `last_modified_by`, `archiv`, `data`) VALUES
(1, '288612', 'dfgdf', 'dfgdfg', 'ذكر', '2021-05-13', '', 'dfgfd', 'dfgdfg', 'dfgdfg', 'test', 'test', 'test', 'test', 'لا شي', '', 'جيدة', '4567567567567', '0558601124', 'fghfghfgh', '', '', 'Members/user.png', 0, '', 1, '', 0, 1, 'أشبال', '2024-05-01', '1', '2024-05-19 05:03:13', '2024-05-29 20:12:43', '1', 0, NULL),
(2, '524412', 'ادريس عبد السلام', 'بوكموش', 'ذكر', '2005-08-16', 'twer', 'فاتح', 'هادية', 'عريبي', 'test', 'test', 'test', 'test', 'لا شي', '', 'عادية', '0558601124', '0558601124', 'سطيف حي 5 جويليا', '', 'برمجة', 'Members/524412/664988eb6b6491.32852794.jpeg', 1, '612', 1, 'xl', 1, 1, 'قائد', '1900-01-03', '1', '2024-05-19 05:06:51', '2024-05-26 02:47:04', '1', 0, NULL),
(3, '341541', 'تجربة', 'تجربة 2', 'أنثى', '2007-06-17', 'سطيف', 'تجربة', 'تجربة', 'تجربة', 'test', 'test', 'test', 'test', 'وفاة الأب', 'الجد', 'عادية', '0772129130', '0772129130', 'سطيف بير نسا', 'سكري', 'كرة القدم', 'Members/341541/6656cade122eb6.83608426.png', 1, '123', 1, 'l', 1, 0, 'مرشدات', '2019-07-10', '1', '2024-05-19 05:10:01', '2024-05-29 06:27:42', '1', 0, NULL),
(4, '357073', 'abdelmouiz', 'ali', 'ذكر', '2005-07-31', '', 'elhadii', 'fatama', 'ali', 'mota9a3d ', 'no', '', '', 'لا شي', '', 'عادية', '4585462', '0633494023', 'Algeria Setif 19000', '', 'sibq7', 'Members/357073/66524efd8041b2.48327227.jpeg', 1, '4526', 0, 'm', 0, 0, 'قائد', '1900-01-10', '1', '2024-05-25 20:50:05', '2024-05-25 21:03:48', '1', 0, NULL),
(5, '615184', 'شمس الدين', 'بلقرون', 'ذكر', '1999-01-01', 'تجربة', 'تجربة', 'تجربة', 'تجربة', 'test', 'test', '', '', 'لا شي', '', 'عادية', '0772129130', '0772129130', 'سطيف بير نسا', '', '', 'Members/615184/665f9782d88fd9.35940924.jpeg', 1, '1234', 1, 'm', 1, 1, 'قائد', '2024-03-01', '1', '2024-05-29 06:16:12', '2024-06-04 22:38:58', '1', 0, NULL),
(6, '097537', 'غيث', 'سالم', 'ذكر', '2014-06-11', 'سطيف', 'قادر', 'زهرة', 'بلخيري', 'بناء', 'ماكثة في البية', 'سباحة', 'متوسطة لغوق محمد', 'لا شي', NULL, 'عادية', NULL, '0678541123', 'سطيف عين طريق', NULL, 'كرة القدم', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'كشاف', '2024-06-13', '1', '2024-06-13 07:18:54', '2024-06-13 07:29:08', '1', 0, NULL),
(7, '097538', 'يوسف', 'علي', 'ذكر', '2010-05-20', 'الجزائر', 'عمر', 'سعاد', 'بن عمار', 'مهندس', 'معلمة', 'كرة القدم', 'مدرسة النجاح', 'لا شي', NULL, 'جيدة', NULL, '0667123456', 'الجزائر وسط', NULL, 'قراءة', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'كشاف', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:09', '1', 0, NULL),
(8, '097539', 'ليلى', 'مراد', 'أنثى', '2012-07-14', 'البليدة', 'عبد الرحمن', 'نورة', 'بن سليمان', 'طبيب', 'محامية', 'رسم', 'مدرسة المستقبل', 'وفاة الأب', 'تجريب', 'عادية', '0000000', '0667234567', 'البليدة شرق', NULL, 'مطالعة', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'زهرات', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:09', '1', 0, NULL),
(9, '097540', 'أحمد', 'سعيد', 'ذكر', '2006-11-03', 'وهران', 'حسين', 'فاطمة', 'بن علوان', 'موظف حكومي', 'طبيبة', 'كرة اليد', 'مدرسة الحكمة', 'مطلقان', 'تجريب', 'سيئة', '0000000', '0667345678', 'وهران وسط', NULL, 'موسيقى', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'جوال', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:10', '1', 0, NULL),
(10, '097541', 'نادية', 'عبد الله', 'أنثى', '2008-03-18', 'قسنطينة', 'سمير', 'لطيفة', 'بن شريف', 'تاجر', 'ربة منزل', 'سباحة', 'مدرسة الأمل', 'لا شي', NULL, 'عادية', NULL, '0667456789', 'قسنطينة جنوب', NULL, 'فنون', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'دليلات', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:10', '1', 0, NULL),
(11, '097542', 'كريم', 'بن علي', 'ذكر', '2004-02-25', 'تيزي وزو', 'إبراهيم', 'زهية', 'بن حسين', 'مزارع', 'طبيبة', 'جري', 'مدرسة السلام', 'وفاة الأم', NULL, 'جيدة', NULL, '0667567890', 'تيزي وزو شمال', NULL, 'شطرنج', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'جوال', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:11', '1', 0, NULL),
(12, '097543', 'فاطمة', 'حسن', 'أنثى', '2005-12-30', 'سكيكدة', 'سفيان', 'أسماء', 'بن فرج', 'محاسب', 'معلمة', 'جودو', 'مدرسة المستقبل', 'وفاة كلا الوالدين', 'تجريب', 'سيئة جدا', '000000', '0667678901', 'سكيكدة شرق', NULL, 'خياطة', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'مرشدات', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:11', '1', 0, NULL),
(13, '097544', 'علي', 'عبد الكريم', 'ذكر', '2002-09-12', 'جيجل', 'كامل', 'هند', 'بن صالح', 'صيدلي', 'ممرضة', 'كاراتيه', 'مدرسة الاتحاد', 'لا شي', NULL, 'عادية', NULL, '0667789012', 'جيجل وسط', NULL, 'صيد', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'قائد', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:12', '1', 0, NULL),
(14, '097545', 'سمية', 'أمين', 'أنثى', '2001-08-22', 'باتنة', 'عبد الباسط', 'رحمة', 'بن يوسف', 'مدير', 'ممرضة', 'تنس', 'مدرسة النور', 'مطلقان', 'تجريب', 'جيدة', '00000', '0667890123', 'باتنة شمال', NULL, 'طبخ', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'قائد', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:12', '1', 0, NULL),
(15, '097546', 'محمد', 'عثمان', 'ذكر', '2003-01-17', 'عنابة', 'كريم', 'سارة', 'بن منصور', 'فني', 'محامية', 'جري', 'مدرسة المستقبل', 'لا شي', NULL, 'جيدة', NULL, '0668901234', 'عنابة شرق', NULL, 'قراءة', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'قائد', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:08', '1', 0, NULL),
(16, '097547', 'سارة', 'نصر', 'أنثى', '2015-11-09', 'بجاية', 'سعيد', 'خديجة', 'بن يوسف', 'مزارع', 'طبيبة', 'رسم', 'مدرسة الحكمة', 'وفاة الأب', 'تجريب', 'سيئة', '000000', '0669012345', 'بجاية وسط', NULL, 'مطالعة', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'زهرات', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:14', '1', 0, NULL),
(17, '097548', 'يوسف', 'زيد', 'ذكر', '2016-03-02', 'تلمسان', 'عبد القادر', 'زهور', 'بن خليل', 'مدير', 'محاسبة', 'سباحة', 'مدرسة الأمل', 'وفاة الأم', NULL, 'عادية', NULL, '0670123456', 'تلمسان شرق', NULL, 'فنون', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'أشبال', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:07', '1', 0, NULL),
(18, '097549', 'مريم', 'إبراهيم', 'أنثى', '2009-10-19', 'غرداية', 'عبد السلام', 'فاطمة', 'بن يوسف', 'مهندس', 'محامية', 'تنس', 'مدرسة النجاح', 'مطلقان', 'تجريب', 'جيدة', '000000000', '0671234567', 'غرداية وسط', NULL, 'موسيقى', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'دليلات', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:14', '1', 0, NULL),
(19, '097550', 'إبراهيم', 'يوسف', 'ذكر', '2011-12-28', 'بسكرة', 'حكيم', 'حليمة', 'بن أحمد', 'طبيب', 'معلمة', 'جودو', 'مدرسة المستقبل', 'وفاة كلا الوالدين', 'تجريب', 'سيئة جدا', '000000000', '0672345678', 'بسكرة وسط', NULL, 'شطرنج', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'كشاف', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:06', '1', 0, NULL),
(20, '097551', 'سلمى', 'محمد', 'أنثى', '2013-05-04', 'تيبازة', 'نور الدين', 'ليلى', 'بن سعيد', 'موظف حكومي', 'طبيبة', 'كاراتيه', 'مدرسة النجاح', 'وفاة الأم', NULL, 'عادية', NULL, '0673456789', 'تيبازة وسط', NULL, 'قراءة', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'زهرات', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:05', '1', 0, NULL),
(21, '097552', 'عمر', 'سفيان', 'ذكر', '2007-09-15', 'المدية', 'بشير', 'مريم', 'بن حمدان', 'فلاح', 'مدرسة', 'جري', 'مدرسة الحكمة', 'لا شي', NULL, 'عادية', NULL, '0674567890', 'المدية وسط', NULL, 'صيد', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'كشاف', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:15', '1', 0, NULL),
(22, '097553', 'ياسمين', 'عبد الحق', 'أنثى', '2008-07-22', 'تندوف', 'أنور', 'صفية', 'بن سليمان', 'مهندس', 'محامية', 'كرة اليد', 'مدرسة الأمل', 'وفاة الأب', 'تجريب', 'جيدة', '0000000000', '0675678901', 'تندوف وسط', NULL, 'مطالعة', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'دليلات', '2024-06-13', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:04', '1', 0, NULL),
(23, '097554', 'أسامة', 'نعيم', 'ذكر', '2014-01-20', 'سعيدة', 'رضوان', 'نسرين', 'بن عمور', 'صيدلي', 'مدرسة', 'جودو', 'مدرسة الاتحاد', 'لا شي', NULL, 'عادية', NULL, '0676789012', 'سعيدة وسط', NULL, 'خياطة', 'Members/user.png', 0, NULL, 0, NULL, 0, 0, 'أشبال', '2024-06-12', '1', '2024-06-13 07:24:47', '2024-06-13 07:29:03', '1', 0, NULL),
(24, '123456', 'علي', 'حسن', 'ذكر', '2010-05-15', 'سطيف', 'أحمد', 'فاطمة', 'علي', 'مدرس', 'طبيبة', 'كرة القدم', 'مدرسة الأمل', 'مطلقان', 'خال', 'جيدة', '12345678901234', '0678123456', 'الجزائر', NULL, 'السباحة', 'Members/user.png', 0, NULL, 0, 'M', 0, 0, 'كشاف', '2023-01-10', '1', '2024-06-13 07:48:21', '2024-06-13 07:48:21', '1', 0, NULL),
(25, '654321', 'سارة', 'جمعة', 'أنثى', '2008-11-20', 'الجزائر', 'علي', 'نور', 'سالم', 'مهندس', 'معلمة', 'كرة السلة', 'مدرسة النجاح', 'وفاة الأب', 'جد', 'عادية', '43210987654321', '0687654321', 'وهران', NULL, 'الرسم', 'Members/user.png', 0, NULL, 0, 'L', 0, 0, 'مرشدات', '2023-02-15', '1', '2024-06-13 07:48:21', '2024-06-13 07:48:21', '1', 0, NULL),
(26, '567890', 'محمد', 'صالح', 'ذكر', '2013-07-23', 'عنابة', 'عبدالله', 'زينب', 'محمد', 'فلاح', 'موظفة', 'سباحة', 'مدرسة المستقبل', 'لا شي', NULL, 'تحت المتوسط', '56789012345678', '0698765432', 'سطيف', NULL, 'كرة القدم', 'Members/user.png', 0, NULL, 0, 'M', 0, 0, 'أشبال', '2023-03-05', '1', '2024-06-13 07:48:21', '2024-06-13 07:48:21', '1', 0, NULL),
(27, '345678', 'نور', 'سعيد', 'أنثى', '2005-12-30', 'بجاية', 'مروان', 'ليلى', 'إبراهيم', 'نجار', 'طبيبة', 'كرة اليد', 'مدرسة الحرية', 'وفاة الأم', 'عم', 'سيئة', '34567890123456', '0665432109', 'قسنطينة', NULL, 'الغناء', 'Members/user.png', 0, NULL, 0, 'L', 0, 0, 'قائد', '2023-04-25', '1', '2024-06-13 07:48:21', '2024-06-13 07:48:21', '1', 0, NULL),
(28, '987654', 'يوسف', 'علي', 'ذكر', '2007-03-12', 'باتنة', 'جميل', 'سعاد', 'حسن', 'مزارع', 'ربة منزل', 'تنس الطاولة', 'مدرسة المجد', 'لا شي', NULL, 'سيئة جدا', '98765432109876', '0676543210', 'تيارت', NULL, 'القراءة', 'Members/user.png', 0, NULL, 0, 'M', 0, 0, 'كشاف', '2023-05-18', '1', '2024-06-13 07:48:21', '2024-06-13 07:48:21', '1', 0, NULL),
(29, '234567', 'مريم', 'خالد', 'أنثى', '2011-09-08', 'أدرار', 'محمود', 'نادية', 'رشيد', 'حداد', 'طبيبة', 'سباحة', 'مدرسة الوحدة', 'لا شي', NULL, 'جيدة', '23456789012345', '0684321098', 'تيزي وزو', NULL, 'التطريز', 'Members/user.png', 0, NULL, 0, 'L', 0, 0, 'زهرات', '2023-06-07', '1', '2024-06-13 07:48:21', '2024-06-13 07:48:21', '1', 0, NULL),
(30, '765432', 'عبدالرحمن', 'حسن', 'ذكر', '2006-04-01', 'الجلفة', 'ياسين', 'سميرة', 'إبراهيم', 'موظف', 'معلمة', 'جري', 'مدرسة الحياة', 'مطلقان', 'عم', 'تحت المتوسط', '76543210987654', '0673210987', 'الأغواط', NULL, 'الصيد', 'Members/user.png', 0, NULL, 0, 'M', 0, 0, 'جوال', '2023-07-13', '1', '2024-06-13 07:48:21', '2024-06-13 07:48:21', '1', 0, NULL),
(31, '876543', 'ليلى', 'محمود', 'أنثى', '2012-05-25', 'مستغانم', 'عمر', 'خديجة', 'سعيد', 'مدرس', 'موظفة', 'كرة الطائرة', 'مدرسة الأفق', 'وفاة كلا الوالدين', 'خال', 'سيئة جدا', '87654321098765', '0682109876', 'بشار', NULL, 'الرسم', 'Members/user.png', 0, NULL, 0, 'L', 0, 0, 'زهرات', '2023-08-22', '1', '2024-06-13 07:48:21', '2024-06-13 07:48:21', '1', 0, NULL),
(32, '852241', 'ياسر', 'باسم', 'ذكر', '2012-06-12', 'سيدي بلعباس', 'سفيان', 'أسماء', 'بن فرج', 'محاسب', 'معلمة', '', '', 'وفاة كلا الوالدين', 'تجريب', 'سيئة جدا', '000000', '0667678901', 'سكيكدة شرق', '', '', 'Members/user.png', NULL, NULL, NULL, '', 1, 1, 'كشاف', '2024-06-13', '1', '2024-06-13 18:21:54', '2024-06-13 18:22:39', '1', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'site_name', 'فوج الانتصار سطيف'),
(2, 'logo', 'Logos/6648503bedf304.00515264.png'),
(3, 'icon', 'Icons/6648503beeaf71.23224409.png'),
(4, 'description', ' قدماء_الكشافة_الإسلامية_الجزائــرية المحافظة الولائية سطيف فوج الانتصار سطيف منظمة وطنية تربوية إنسانية اجتماعية شبابية تطوعية مستقلة ذات طابع المنفعة العمومية، تهدف إلى المساهمة في تنمية قدرات الأطفال والفتية والشباب روحيا وفكريا وبدنيا واجتماعيا ليكونوا مواطنين مسؤولين في وطنهم وصالحين لمجتمعهم.'),
(5, 'keywords', 'قدماء الكشافة الاسلامية الجزائرية,سطيف,الانتصار,فوج,فوج الانتصار,, home,intisar,magazine,كشافة,كشافة الإسلامية,الجزائر,setif,algria,كشافة  فوج الانتصار,فوج الانتصار سطيف,الإسلامية,كشافة الاسلاميةةجزائرية,كشافة جزائرية,كشافة الإسلامية الجزائرية,iba,idriss,boukmouche,إدريس,بوكموش,idriss boukmouche,المحافظة,الولائية,المحافظة الولائية سطيف,كشافة الاسلامية فوج الانتصار,كشافة الاسلامية جزائرية فوج الانتصار,كشافة الإسلامية فوج الانتصار,scout,ادارة فوج الانتصار'),
(6, 'email', 'intisar.sma.19@gmail.com'),
(7, 'phone', '0673848738'),
(8, 'address', 'Algeria Setif 19000'),
(9, 'smtp_email', 'intisar@nutribien.net'),
(10, 'smtp_password', '001144Az@'),
(11, 'smtp_host', 'mail.nutribien.net'),
(12, 'smtp_port', '465'),
(13, 'smtp_encryption', 'ssl'),
(14, 'amount_cubs', '100'),
(15, 'amount_sprouts', '110'),
(16, 'amount_scouts', '120'),
(17, 'amount_guides', '150'),
(18, 'amount_rangers', '140'),
(19, 'amount_leaders', '160'),
(20, 'amount_masters', '170'),
(21, 'amount_dalilat', '130');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fr_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ls_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `access` int NOT NULL,
  `tokens` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fr_name`, `ls_name`, `username`, `email`, `bio`, `avatar`, `password`, `access`, `tokens`) VALUES
(1, 'ادريس', 'بوكموش', 'idriss', 'boukemoucheidriss@gmail.com', '                                                                                                    مرحبا أنا ادريس                                                                                          ', 'Avatar/ادريس بوكموش/666b2fb94b0569.43960112.png', '$2y$10$gMS7w1c.9mNfrzeJZzaC7u3dmxik0vayyymEQEAGdZ.Jzyj3k9nDG', 1, '[]'),
(6, 'yassar', 'boukmouche', 'yassar', 'bou.kemoucheidriss@gmail.com', NULL, 'Avatar/yassar boukmouche/66493d8d0f4526.16459071.png', '$2y$10$IaRQCNO9..YsTMlOpxZGSet3APDFh4JFF0YbMWil0lMrfsUN8nPWC', 1, '{\"1\":{\"token\":\"078bf6967da2a812fdb1310a37c8e9b7\",\"time\":1718705208},\"2\":{\"token\":\"c7aefdafd8ea04c0b9b8f20421001318\",\"time\":1718705354},\"3\":{\"token\":\"78a8a839431912a61c43f6926c5d24a0\",\"time\":1718705361}}'),
(7, 'nizzar', 'bouk', 'nizzar', 'boukemouche.idriss@gmail.com', NULL, 'Avatar/user.png', '$2y$10$IaRQCNO9..YsTMlOpxZGSet3APDFh4JFF0YbMWil0lMrfsUN8nPWC', 0, '{\"1\":{\"token\":\"078bf6967da2a812fdb1310a37c8e9b7\",\"time\":1718705208},\"2\":{\"token\":\"c7aefdafd8ea04c0b9b8f20421001318\",\"time\":1718705354},\"3\":{\"token\":\"78a8a839431912a61c43f6926c5d24a0\",\"time\":1718705361}}'),
(8, 'شمس الدين', 'بلقرون', 'acb', 'intisar@nutribien.net', NULL, 'Avatar/user.png', '$2y$10$IaRQCNO9..YsTMlOpxZGSet3APDFh4JFF0YbMWil0lMrfsUN8nPWC', 1, '{\"1\":{\"token\":\"078bf6967da2a812fdb1310a37c8e9b7\",\"time\":1718705208},\"2\":{\"token\":\"c7aefdafd8ea04c0b9b8f20421001318\",\"time\":1718705354},\"3\":{\"token\":\"78a8a839431912a61c43f6926c5d24a0\",\"time\":1718705361}}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `insurances`
--
ALTER TABLE `insurances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_id` (`member_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
