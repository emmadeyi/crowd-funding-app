-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2022 at 07:59 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kingsquest_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'annual_subscription', '5000', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `close_date` date DEFAULT NULL,
  `salary_range` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT 0,
  `author` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `careers`
--

INSERT INTO `careers` (`id`, `position`, `description`, `close_date`, `salary_range`, `publish`, `author`, `created_at`, `updated_at`, `location`) VALUES
(1, 'Frontend Web Developer', '<p>Carrotsuite Global Ltd. is a world class accounting software and ERP web/mobile applications developer powering digital transformation for a growing number of world class companies.</p>\r\n<p>We specialize in providing tech solutions that eliminate bureaucracy and promote automation of business processes.</p>\r\n<p>We need a practical, experienced and passionate Node Js + HTML/CSS Developer who will work with a team to build back-end or front end (as necessary) services, development of custom features on our ongoing web and mobile apps and do thorough documentation of their APIs and codes.</p>\r\n<p>Proof of proper documentation of a previous project is an added advantage.</p>\r\n<p><strong>RESPONSIBILITIES</strong></p>\r\n<p>- Be a team player<br>- Proper <strong>code DOCUMENTATION</strong> is a priority as we want to be an API-First company<br>- Make continual modifications to our code base to cover new feature requests and bug fixes<br>- Create re-usable APIs for our web app<br>- Build API integrations of our web app with other web apps<br>- Build efficient, testable, and reusable node and react JS modules<br>- Solve complex performance problems and architectural challenges<br>- Integration of data storage solutions like mysql<br>- Conducting regular website updates<br>- Represent a professional image in dealings with internal and external parties at all times<br>- Other tasks as may be required from time to time</p>\r\n<p>- <strong>REQUIREMENTS</strong></p>\r\n<p>- Knowledge and experience with express Node JS framework</p>\r\n<p>- Practical Knowledge of html and CSS</p>\r\n<p>- Familiar with Sequelize ORM</p>\r\n<p>- Familiar with practical usage of Swagger Docs</p>\r\n<p>- MYSQL Database experience (queries, design, implementation, Maintenance)</p>\r\n<p>- Knowledge &amp; Experience with use of Mongo DB<br>- Knowledge and experience with Version control tools such as bitbucket git<br>- Understanding of systems integration and various web devices and environments.<br>- Ability to design and implement web services.<br>- strong Familiarity with authentication and access control.<br>- Knowledge of website delivery best practices.</p>\r\n<p>- strong willingness to learn</p>\r\n<p>- experience with AWS or Linode server will be an added advantage.</p>\r\n<p>- ND, HND, BSC are welcome to apply</p>\r\n<p>If you are applying as a student in tertiary education, kindly Note that your prospective remuneration may vary slightly less than advertised If hired.</p>\r\n<p>Job Types: Full-time, Contract, Permanent</p>\r\n<p>Application Question(s):</p>\r\n<ul>\r\n<li>What is the most complex project you have done with express Node js?</li>\r\n<li>We work Mondays to Saturdays and submit reports each day, are you comfortable with this?</li>\r\n</ul>', '2021-09-10', '450000 NGN', 0, 1, '2021-07-10 07:40:07', '2021-07-11 18:57:31', 'Warri');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(11, '2014_10_12_000000_create_users_table', 1),
(12, '2014_10_12_100000_create_password_resets_table', 1),
(13, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(14, '2019_08_19_000000_create_failed_jobs_table', 1),
(15, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(16, '2020_05_21_100000_create_teams_table', 1),
(17, '2020_05_21_200000_create_team_user_table', 1),
(18, '2020_05_21_300000_create_team_invitations_table', 1),
(19, '2021_06_02_124851_create_sessions_table', 1),
(20, '2021_06_03_183606_create_posts_table', 1),
(21, '2021_06_07_125044_add_post_status_to_posts_table', 2),
(22, '2021_06_08_111035_create_projects_table', 3),
(23, '2021_06_10_051029_add_min_investment_to_projects', 4),
(24, '2021_06_15_211924_create_project_photos_table', 5),
(25, '2021_06_15_212043_create_project_files_table', 5),
(26, '2021_06_16_134906_add_project_status_and_approval', 6),
(27, '2021_06_21_055008_add_author_and_image_to_posts', 7),
(28, '2021_06_21_055206_add_author_to_projects', 7),
(32, '2021_06_23_075237_add_details_to_project', 8),
(35, '2021_06_24_185219_create_app_settings_table', 10),
(43, '2021_06_24_100744_create_project_subcriptions_table', 11),
(44, '2021_06_25_064125_create_routine_maintenance_fees_table', 11),
(45, '2021_06_29_142844_create_subscription_payouts_table', 11),
(46, '2021_06_29_143140_create_transactions_table', 11),
(47, '2021_07_06_083508_create_permission_tables', 12),
(48, '2021_07_06_162308_add_status_to_users_table', 13),
(49, '2021_07_06_175103_create_user_bank_details_table', 14),
(50, '2021_07_06_175128_create_user_contact_details_table', 14),
(51, '2021_07_06_175152_create_user_identity_details_table', 14),
(52, '2021_07_10_070646_create_careers_table', 15),
(53, '2021_07_10_075420_add_location_to_careers_table', 16),
(54, '2021_07_28_071308_add_contribution_status_to_projects_table', 17),
(55, '2021_07_30_142335_add_terms_to_projectsubcription_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 7),
(1, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 10),
(4, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 10),
(5, 'App\\Models\\User', 7),
(5, 'App\\Models\\User', 10),
(6, 'App\\Models\\User', 7),
(6, 'App\\Models\\User', 10),
(7, 'App\\Models\\User', 7),
(7, 'App\\Models\\User', 10),
(8, 'App\\Models\\User', 7),
(8, 'App\\Models\\User', 10),
(9, 'App\\Models\\User', 7),
(9, 'App\\Models\\User', 10),
(10, 'App\\Models\\User', 7),
(10, 'App\\Models\\User', 10),
(11, 'App\\Models\\User', 7),
(11, 'App\\Models\\User', 10),
(12, 'App\\Models\\User', 7),
(12, 'App\\Models\\User', 10),
(13, 'App\\Models\\User', 7),
(13, 'App\\Models\\User', 10),
(14, 'App\\Models\\User', 7),
(14, 'App\\Models\\User', 10),
(15, 'App\\Models\\User', 7),
(15, 'App\\Models\\User', 10),
(16, 'App\\Models\\User', 7),
(16, 'App\\Models\\User', 10),
(17, 'App\\Models\\User', 7),
(17, 'App\\Models\\User', 10),
(18, 'App\\Models\\User', 7),
(18, 'App\\Models\\User', 10),
(19, 'App\\Models\\User', 7),
(19, 'App\\Models\\User', 10),
(20, 'App\\Models\\User', 7),
(20, 'App\\Models\\User', 10),
(21, 'App\\Models\\User', 7),
(21, 'App\\Models\\User', 10),
(22, 'App\\Models\\User', 7),
(22, 'App\\Models\\User', 10),
(23, 'App\\Models\\User', 7),
(23, 'App\\Models\\User', 10),
(24, 'App\\Models\\User', 7),
(24, 'App\\Models\\User', 10),
(25, 'App\\Models\\User', 7),
(25, 'App\\Models\\User', 10),
(26, 'App\\Models\\User', 7),
(26, 'App\\Models\\User', 10),
(27, 'App\\Models\\User', 7),
(27, 'App\\Models\\User', 10),
(28, 'App\\Models\\User', 7),
(28, 'App\\Models\\User', 10),
(29, 'App\\Models\\User', 7),
(29, 'App\\Models\\User', 10),
(30, 'App\\Models\\User', 7),
(30, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(5, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 10),
(9, 'App\\Models\\User', 2),
(9, 'App\\Models\\User', 3),
(9, 'App\\Models\\User', 4),
(9, 'App\\Models\\User', 5),
(9, 'App\\Models\\User', 6),
(9, 'App\\Models\\User', 7),
(9, 'App\\Models\\User', 8),
(9, 'App\\Models\\User', 9),
(9, 'App\\Models\\User', 11),
(9, 'App\\Models\\User', 13),
(11, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Create User', 'web', '2021-07-07 09:46:37', '2021-07-07 09:51:32'),
(2, 'Edit User', 'web', '2021-07-07 09:50:41', '2021-07-07 09:50:41'),
(3, 'Read User', 'web', '2021-07-07 09:51:55', '2021-07-07 09:51:55'),
(4, 'Delete User', 'web', '2021-07-07 09:53:03', '2021-07-07 09:53:03'),
(5, 'Manage User', 'web', '2021-07-07 09:53:54', '2021-07-07 09:53:54'),
(6, 'Create Project', 'web', '2021-07-07 20:14:16', '2021-07-07 20:14:16'),
(7, 'Edit Project', 'web', '2021-07-07 20:14:51', '2021-07-07 20:14:51'),
(8, 'Read Project', 'web', '2021-07-07 20:15:10', '2021-07-07 20:15:10'),
(9, 'Delete Project', 'web', '2021-07-07 20:15:20', '2021-07-07 20:15:20'),
(10, 'Manage Project', 'web', '2021-07-07 20:15:30', '2021-07-07 20:15:30'),
(11, 'Manage Subscription', 'web', '2021-07-07 20:36:59', '2021-07-07 20:36:59'),
(12, 'Manage Payout', 'web', '2021-07-07 20:37:33', '2021-07-07 20:37:33'),
(13, 'Create Payout', 'web', '2021-07-08 08:27:45', '2021-07-08 08:27:45'),
(14, 'Delete Payout', 'web', '2021-07-08 08:28:05', '2021-07-08 08:28:05'),
(15, 'Create Subscription', 'web', '2021-07-08 08:28:36', '2021-07-08 08:28:36'),
(16, 'Create Transaction', 'web', '2021-07-08 08:28:55', '2021-07-08 08:28:55'),
(17, 'Create Post', 'web', '2021-07-08 08:29:08', '2021-07-08 08:29:08'),
(18, 'Create Career', 'web', '2021-07-08 08:29:28', '2021-07-08 08:29:28'),
(19, 'Edit Career', 'web', '2021-07-08 08:29:57', '2021-07-08 08:29:57'),
(20, 'Read Career', 'web', '2021-07-08 08:30:05', '2021-07-08 08:30:05'),
(21, 'Delete Career', 'web', '2021-07-08 08:30:14', '2021-07-08 08:30:14'),
(22, 'Edit Payout', 'web', '2021-07-08 08:30:45', '2021-07-08 08:30:45'),
(23, 'Read Post', 'web', '2021-07-08 08:31:49', '2021-07-08 08:31:49'),
(24, 'Read Subscription', 'web', '2021-07-08 08:32:24', '2021-07-08 08:32:24'),
(25, 'Read Transaction', 'web', '2021-07-08 08:32:37', '2021-07-08 08:32:37'),
(26, 'Manage Transaction', 'web', '2021-07-08 08:33:11', '2021-07-08 08:33:11'),
(27, 'Delete Transaction', 'web', '2021-07-08 08:33:48', '2021-07-08 08:33:48'),
(28, 'Delete Subscription', 'web', '2021-07-08 08:34:09', '2021-07-08 08:34:09'),
(29, 'Delete Post', 'web', '2021-07-08 08:34:48', '2021-07-08 08:34:48'),
(30, 'Edit Post', 'web', '2021-07-08 08:34:57', '2021-07-08 08:34:57'),
(31, 'Manage Post', 'web', '2021-07-11 18:42:15', '2021-07-11 18:42:15'),
(32, 'Manage Career', 'web', '2021-07-11 18:42:24', '2021-07-11 18:42:24');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `author` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `created_at`, `updated_at`, `status`, `author`, `image`) VALUES
(38, 'Saepe aut blanditiis officiis sunt. Updated 01', '<h1>Some Good Title</h1>\r\n<p>ok this is it</p>\r\n<p>Your API Key is a unique token that links your TinyMCE instances to your account.&nbsp;It grants you access to the Premium Features that you are subscribed to.</p>', '2021-07-09 12:12:59', '2021-08-09 06:43:01', 1, 1, NULL),
(39, 'Saepe aut blanditiis Update', '<p><strong>Intro</strong></p>\r\n<p>As I was building this new Kuztek site I wanted to build it to the same standards I would if I were building it for any client and that means protecting the site from malicious code or security threats. I may be the only one adding content to this site or modifying what is in the database, but filtering what we are outputting to the browser to make sure it doesn’t harm the site or our users just makes sense. We don’t want to leave our sites vulnerable to Cross-Sites Scripting(XSS). This tutorial covers Laravel customization and is intended to be used by developers to improve their site security.</p>\r\n<p>When using Laravel Blade templates we typically would output content doing something like this:</p>', '2021-07-09 13:10:20', '2021-08-09 06:42:57', 1, 1, 'post/photos/DUV9Hz73io2IvgpSK3zKUe5GsbeQpJSUvvyXK4Zy.PNG'),
(40, 'Saepe aut blanditiis officiis sunt', '<p>As I was <strong>building this new Kuztek</strong> site I wanted to build it to the same standards I would if I were building it for any client and that means protecting the site from malicious code or security threats.</p>\r\n<p>I may be the only one adding content to this site or modifying what is in the database, but filtering what we are outputting to the browser to make sure it doesn’t harm the site or our users just makes sense. We don’t want to leave our sites vulnerable to Cross-Sites Scripting(XSS). This tutorial covers Laravel customization and is intended to be used by developers to improve their site security.</p>', '2021-07-09 13:11:47', '2021-07-09 20:18:16', 1, 1, 'post/photos/pP4LesoVt0nLsxJi9aBP4NNC50SLnYGF4fUAdA6T.PNG'),
(41, 'Saepe aut blanditiis officiis suntghjfh', '<p><strong>Theology</strong> is the systematic study of the nature of the <a title=\"Divinity\" href=\"https://en.wikipedia.org/wiki/Divinity\">divine</a> and, more broadly, of religious belief. It is taught as an <a title=\"Discipline (academia)\" href=\"https://en.wikipedia.org/wiki/Discipline_(academia)\">academic discipline</a>, typically in universities and <a title=\"Seminaries\" href=\"https://en.wikipedia.org/wiki/Seminaries\">seminaries</a>.<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-1\">[1]</a> It occupies itself with the unique content of analyzing the <a title=\"Supernatural\" href=\"https://en.wikipedia.org/wiki/Supernatural\">supernatural</a>, but also deals with <a title=\"\" href=\"https://en.wikipedia.org/wiki/Religious_epistemology\">religious epistemology</a>, asks and seeks to answer the question of <a title=\"Revelation\" href=\"https://en.wikipedia.org/wiki/Revelation\">revelation</a>. Revelation pertains to the acceptance of <a title=\"God\" href=\"https://en.wikipedia.org/wiki/God\">God</a>, <a title=\"Gods\" href=\"https://en.wikipedia.org/wiki/Gods\">gods</a>, or <a title=\"Deity\" href=\"https://en.wikipedia.org/wiki/Deity\">deities</a>, as not only transcendent or above the natural world, but also willing and able to interact with the natural world and, in particular, to reveal themselves to humankind. While theology has turned into a <a title=\"Secular\" href=\"https://en.wikipedia.org/wiki/Secular\">secular field</a>, religious adherents still consider theology to be a discipline that helps them live and understand concepts such as life and love and that helps them lead lives of obedience to the deities they follow or worship.</p>\r\n<p>Theologians use various forms of analysis and argument (<a title=\"Spirituality\" href=\"https://en.wikipedia.org/wiki/Spirituality\">experiential</a>, <a title=\"Philosophy\" href=\"https://en.wikipedia.org/wiki/Philosophy\">philosophical</a>, <a title=\"Ethnography\" href=\"https://en.wikipedia.org/wiki/Ethnography\">ethnographic</a>, <a title=\"History\" href=\"https://en.wikipedia.org/wiki/History\">historical</a>, and others) to help <a title=\"Understanding\" href=\"https://en.wikipedia.org/wiki/Understanding\">understand</a>, <a title=\"Explanation\" href=\"https://en.wikipedia.org/wiki/Explanation\">explain</a>, test, <a title=\"Critique\" href=\"https://en.wikipedia.org/wiki/Critique\">critique</a>, defend or promote any myriad of <a title=\"List of religious topics\" href=\"https://en.wikipedia.org/wiki/List_of_religious_topics\">religious topics</a>. As in <a title=\"Philosophy of ethics\" href=\"https://en.wikipedia.org/wiki/Philosophy_of_ethics\">philosophy of ethics</a> and <a title=\"Case law\" href=\"https://en.wikipedia.org/wiki/Case_law\">case law</a>, arguments often assume the existence of previously resolved questions, and develop by making analogies from them to draw new inferences in new situations.</p>\r\n<p>The study of theology may help a theologian more deeply understand their own <a title=\"Religion\" href=\"https://en.wikipedia.org/wiki/Religion\">religious tradition</a>,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-2\">[2]</a> another religious tradition,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-3\">[3]</a> or it may enable them to explore the nature of divinity without reference to any specific tradition. Theology may be used to <a title=\"Proselytism\" href=\"https://en.wikipedia.org/wiki/Proselytism\">propagate</a>,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-4\">[4]</a> reform,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-5\">[5]</a> or <a title=\"Apologetics\" href=\"https://en.wikipedia.org/wiki/Apologetics\">justify</a> a religious tradition; or it may be used to <a title=\"Comparative religion\" href=\"https://en.wikipedia.org/wiki/Comparative_religion\">compare</a>,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-6\">[6]</a> challenge (e.g. <a title=\"Biblical criticism\" href=\"https://en.wikipedia.org/wiki/Biblical_criticism\">biblical criticism</a>), or oppose (e.g. <a title=\"Irreligion\" href=\"https://en.wikipedia.org/wiki/Irreligion\">irreligion</a>) a religious tradition or <a title=\"Worldview\" href=\"https://en.wikipedia.org/wiki/Worldview\">worldview</a>. Theology might also help a theologian address some present situation or need through a religious tradition,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-7\">[7]</a> or to explore possible ways of interpreting the world.<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-8\">[8]</a></p>\r\n<p>some</p>', '2021-08-05 14:47:17', '2021-08-09 06:48:13', 1, 1, NULL),
(42, 'sfvsfvdhghhhh', '<p><strong>Theology</strong> is the systematic study of the nature of the <a title=\"Divinity\" href=\"https://en.wikipedia.org/wiki/Divinity\">divine</a> and, more broadly, of religious belief. It is taught as an <a title=\"Discipline (academia)\" href=\"https://en.wikipedia.org/wiki/Discipline_(academia)\">academic discipline</a>, typically in universities and <a title=\"Seminaries\" href=\"https://en.wikipedia.org/wiki/Seminaries\">seminaries</a>.<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-1\">[1]</a> It occupies itself with the unique content of analyzing the <a title=\"Supernatural\" href=\"https://en.wikipedia.org/wiki/Supernatural\">supernatural</a>, but also deals with <a title=\"\" href=\"https://en.wikipedia.org/wiki/Religious_epistemology\">religious epistemology</a>, asks and seeks to answer the question of <a title=\"Revelation\" href=\"https://en.wikipedia.org/wiki/Revelation\">revelation</a>. Revelation pertains to the acceptance of <a title=\"God\" href=\"https://en.wikipedia.org/wiki/God\">God</a>, <a title=\"Gods\" href=\"https://en.wikipedia.org/wiki/Gods\">gods</a>, or <a title=\"Deity\" href=\"https://en.wikipedia.org/wiki/Deity\">deities</a>, as not only transcendent or above the natural world, but also willing and able to interact with the natural world and, in particular, to reveal themselves to humankind. While theology has turned into a <a title=\"Secular\" href=\"https://en.wikipedia.org/wiki/Secular\">secular field</a>, religious adherents still consider theology to be a discipline that helps them live and understand concepts such as life and love and that helps them lead lives of obedience to the deities they follow or worship.</p>\r\n<p>Theologians use various forms of analysis and argument (<a title=\"Spirituality\" href=\"https://en.wikipedia.org/wiki/Spirituality\">experiential</a>, <a title=\"Philosophy\" href=\"https://en.wikipedia.org/wiki/Philosophy\">philosophical</a>, <a title=\"Ethnography\" href=\"https://en.wikipedia.org/wiki/Ethnography\">ethnographic</a>, <a title=\"History\" href=\"https://en.wikipedia.org/wiki/History\">historical</a>, and others) to help <a title=\"Understanding\" href=\"https://en.wikipedia.org/wiki/Understanding\">understand</a>, <a title=\"Explanation\" href=\"https://en.wikipedia.org/wiki/Explanation\">explain</a>, test, <a title=\"Critique\" href=\"https://en.wikipedia.org/wiki/Critique\">critique</a>, defend or promote any myriad of <a title=\"List of religious topics\" href=\"https://en.wikipedia.org/wiki/List_of_religious_topics\">religious topics</a>. As in <a title=\"Philosophy of ethics\" href=\"https://en.wikipedia.org/wiki/Philosophy_of_ethics\">philosophy of ethics</a> and <a title=\"Case law\" href=\"https://en.wikipedia.org/wiki/Case_law\">case law</a>, arguments often assume the existence of previously resolved questions, and develop by making analogies from them to draw new inferences in new situations.</p>\r\n<p>The study of theology may help a theologian more deeply understand their own <a title=\"Religion\" href=\"https://en.wikipedia.org/wiki/Religion\">religious tradition</a>,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-2\">[2]</a> another religious tradition,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-3\">[3]</a> or it may enable them to explore the nature of divinity without reference to any specific tradition. Theology may be used to <a title=\"Proselytism\" href=\"https://en.wikipedia.org/wiki/Proselytism\">propagate</a>,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-4\">[4]</a> reform,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-5\">[5]</a> or <a title=\"Apologetics\" href=\"https://en.wikipedia.org/wiki/Apologetics\">justify</a> a religious tradition; or it may be used to <a title=\"Comparative religion\" href=\"https://en.wikipedia.org/wiki/Comparative_religion\">compare</a>,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-6\">[6]</a> challenge (e.g. <a title=\"Biblical criticism\" href=\"https://en.wikipedia.org/wiki/Biblical_criticism\">biblical criticism</a>), or oppose (e.g. <a title=\"Irreligion\" href=\"https://en.wikipedia.org/wiki/Irreligion\">irreligion</a>) a religious tradition or <a title=\"Worldview\" href=\"https://en.wikipedia.org/wiki/Worldview\">worldview</a>. Theology might also help a theologian address some present situation or need through a religious tradition,<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-7\">[7]</a> or to explore possible ways of interpreting the world.<a href=\"https://en.wikipedia.org/wiki/Theology#cite_note-8\">[8]</a></p>', '2021-08-05 14:48:21', '2021-08-09 07:30:22', 1, 1, 'post/photos/eMtNxutxPvkpKxomm10NaJ1TNnPgNxrdO5bXoIMY.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `execution_cost` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `roi_percent` double(8,2) DEFAULT NULL,
  `execution_start_date` date DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `author` bigint(20) UNSIGNED NOT NULL,
  `payment_cycle` int(11) NOT NULL DEFAULT 0,
  `payment_starts` int(11) NOT NULL DEFAULT 0,
  `min_investment` double(8,2) NOT NULL DEFAULT 0.00,
  `contribution_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `execution_cost`, `duration`, `roi_percent`, `execution_start_date`, `image`, `created_at`, `updated_at`, `published`, `approved`, `author`, `payment_cycle`, `payment_starts`, `min_investment`, `contribution_status`) VALUES
(14, 'Saepe aut blanditiis officiis sunt. Updated', ' Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis optio, adipisci sed magni, iste maiores totam, sint hic tenetur nulla consequatur? Molestiae quia, aspernatur necessitatibus optio sequi perspiciatis iure, quisquam soluta fugit voluptatem, cum nisi dignissimos quod reprehenderit saepe expedita ex atque nesciunt aliquam id natus repudiandae ad? Tempore eum explicabo nesciunt repellat omnis porro similique voluptates fugiat, quaerat pariatur nostrum laborum dolore optio neque, placeat nisi praesentium voluptatum exercitationem.', 3000000, 60, 15.00, '2021-10-27', NULL, '2021-06-21 17:00:15', '2021-08-01 11:47:46', 1, 1, 1, 30, 60, 5000.00, 0),
(16, 'Saepe officiis sunt', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequuntur rem ratione quasi quo in repellendus eaque exercitationem repellat possimus est nesciunt, quibusdam, perferendis nobis ea ipsa praesentium recusandae ab eveniet? Deserunt reprehenderit nihil impedit quasi fuga beatae unde eum asperiores sint ea culpa laboriosam, odit quaerat illum quibusdam pariatur. Soluta.', 11000000, 150, 12.00, '2021-08-18', NULL, '2021-07-02 04:38:54', '2021-07-30 13:16:26', 1, 1, 1, 30, 75, 100000.00, 1),
(17, 'Saepe aut blanditiis officiis sunt', 'Some text with project', 30000000, 40, NULL, NULL, NULL, '2021-07-13 20:02:48', '2021-07-13 20:02:48', 0, 0, 2, 0, 0, 0.00, 0),
(18, 'Saepe aut blanditiis officiis sunt. Updated', 'Somethings again', 100000000, 100, NULL, NULL, NULL, '2021-07-13 20:15:42', '2021-07-13 20:15:42', 0, 0, 2, 0, 0, 0.00, 0),
(19, 'Saepe aut blanditiis officiis sunt', 'something good', 3000000, 84, 10.00, '2021-09-30', NULL, '2021-08-01 11:54:59', '2021-08-01 11:59:08', 1, 1, 7, 28, 60, 5000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

CREATE TABLE `project_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_files`
--

INSERT INTO `project_files` (`id`, `url`, `project_id`, `created_at`, `updated_at`) VALUES
(3, 'project/files/RP7IFTgJnKnhniTs68eVJkL8E4SeBRutMXv7auH2.pdf', 16, '2021-07-12 06:36:28', '2021-07-12 06:36:28'),
(4, 'project/files/kU3KeRDHMDX99jzxaBBoo680RHmLDW3vH8lX2Qnf.pdf', 17, '2021-07-13 20:02:48', '2021-07-13 20:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `project_photos`
--

CREATE TABLE `project_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_photos`
--

INSERT INTO `project_photos` (`id`, `url`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 'project/photos/nM7He75bIvyIUTqN8dQxdgHI0N1cUTFXV6Q0j1rt.png', 16, '2021-07-02 04:38:54', '2021-07-02 04:38:54'),
(2, 'project/photos/SD6w4o5WF9uLzgzAKnBE8xDR1DxCt0tbnHyGLcpj.png', 16, '2021-07-12 06:24:00', '2021-07-12 06:24:00'),
(3, 'project/photos/KyNwhaWpSF41QCJAQEvzaYRnGGihqUt6stz8ZLAX.png', 16, '2021-07-12 06:24:00', '2021-07-12 06:24:00'),
(4, 'project/photos/7oBlAsIFBTDRxP36zp3v89dBhlJuX1QAqPa2Nwoq.png', 16, '2021-07-12 06:24:01', '2021-07-12 06:24:01'),
(5, 'project/photos/PHbppo1oloAOQ32mA7WyBXuaeLlObPkjffL8xAqV.png', 16, '2021-07-12 06:24:01', '2021-07-12 06:24:01'),
(6, 'project/photos/58uIGYt7bm38u04ivJeXBlGKWxwDewh4a5g4otdu.png', 16, '2021-07-12 06:24:01', '2021-07-12 06:24:01'),
(7, 'project/photos/wTdhLQBWGAr309a2ULGuaSqKBIkc14Kk8YaeJ9C8.png', 16, '2021-07-12 06:24:01', '2021-07-12 06:24:01'),
(8, 'project/photos/IoUZXDXqSh6kQfklMv2wvC7rra1sLNJmYQy0K8gR.png', 16, '2021-07-12 06:24:01', '2021-07-12 06:24:01'),
(9, 'project/photos/itJKSCfXv4R2754QKqrPNEFMHJLJvznacMNcn0xx.png', 16, '2021-07-12 06:24:01', '2021-07-12 06:24:01'),
(10, 'project/photos/QUIFBX4lt5INJptD5gjTciOzoC5zsx3SEEFviWJW.png', 16, '2021-07-12 06:24:01', '2021-07-12 06:24:01'),
(11, 'project/photos/3NHqSEylbWjULKrYIfxb47MS6NHw7HJvaEsCFcjl.png', 16, '2021-07-12 06:24:01', '2021-07-12 06:24:01'),
(12, 'project/photos/ysMVwgIF2ZeHQEVUO4AQczlcR2fz41vSrvLd3l7T.png', 17, '2021-07-13 20:02:48', '2021-07-13 20:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `project_subcriptions`
--

CREATE TABLE `project_subcriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `confirmation` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `acceptTerms` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_subcriptions`
--

INSERT INTO `project_subcriptions` (`id`, `reference`, `transaction_id`, `project_id`, `user_id`, `amount_paid`, `status`, `confirmation`, `created_at`, `updated_at`, `acceptTerms`) VALUES
(1, 'qmeYQ3Xv1ifePFilrLifFCBE7', 2, 16, 1, 100000, 1, '2', '2021-07-30 13:21:28', '2021-07-30 13:21:28', 0),
(2, 'null_by_admin', 10, 16, 7, 10000, 1, '2', '2021-11-15 09:22:04', '2021-11-16 03:52:11', 0),
(3, 'null_by_admin', 11, 19, 7, 40000, 1, '2', '2021-11-15 09:24:52', '2021-11-15 09:24:52', 0),
(4, 'null_by_admin', 12, 14, 7, 50000, 1, '2', '2021-11-15 09:26:40', '2021-11-16 03:54:59', 0),
(5, 'null_by_admin', 13, 16, 10, 0, 1, '2', '2021-11-15 09:31:31', '2021-11-15 09:31:31', 0),
(6, 'null_by_admin', 14, 16, 11, 50000, 1, '2', '2021-11-15 09:37:59', '2021-11-15 09:37:59', 0),
(7, 'null_by_admin', 15, 16, 10, 30000, 1, '2', '2021-11-15 12:58:01', '2021-11-15 12:58:01', 0),
(8, 'null_by_admin', 17, 16, 10, 30000, 1, '2', '2021-11-15 12:58:18', '2021-11-15 12:58:18', 0),
(9, 'null_by_admin', 19, 16, 10, 30000, 1, '2', '2021-11-15 13:00:21', '2021-11-15 13:00:21', 0),
(10, 'null_by_admin', 20, 0, 0, 30000, 1, '2', '2021-11-15 13:00:21', '2021-11-15 13:00:21', 0),
(11, 'null_by_admin', 21, 19, 12, 5000, 1, '2', '2021-11-15 13:01:24', '2021-11-15 13:01:24', 0),
(12, 'null_by_admin', 22, 0, 0, 5000, 1, '2', '2021-11-15 13:01:24', '2021-11-15 13:01:24', 0),
(13, 'null_by_admin', 46, 16, 10, 20000, 0, '2', '2021-11-15 13:14:03', '2021-11-15 13:15:22', 0),
(14, 'null_by_admin', 47, 0, 0, 20000, 1, '2', '2021-11-15 13:14:03', '2021-11-15 13:14:03', 0),
(15, 'null_by_admin', 101, 16, 10, 50000, 1, '2', '2021-11-16 05:04:47', '2021-11-16 05:04:47', 0),
(16, 'null_by_admin', 102, 0, 0, 50000, 1, '2', '2021-11-16 05:04:47', '2021-11-16 05:04:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(5, 'Developer', 'web', '2021-07-07 09:30:44', '2021-07-07 09:30:44'),
(8, 'Staff', 'web', '2021-07-07 10:10:55', '2021-07-07 10:10:55'),
(9, 'Basic', 'web', '2021-07-07 10:11:11', '2021-07-07 10:11:11'),
(10, 'Administrator', 'web', '2021-07-08 08:35:13', '2021-07-08 09:00:50'),
(11, 'Super Admin', 'web', '2021-07-08 16:59:41', '2021-07-08 16:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 5),
(1, 11),
(2, 5),
(2, 11),
(3, 5),
(3, 11),
(4, 5),
(4, 11),
(5, 5),
(5, 11),
(6, 5),
(6, 9),
(6, 11),
(7, 5),
(7, 9),
(7, 11),
(8, 5),
(8, 9),
(8, 11),
(9, 5),
(9, 11),
(10, 5),
(10, 11),
(11, 5),
(11, 11),
(12, 5),
(12, 11),
(13, 5),
(13, 11),
(14, 5),
(14, 11),
(15, 5),
(15, 9),
(15, 11),
(16, 5),
(16, 9),
(16, 11),
(17, 5),
(17, 11),
(18, 5),
(18, 11),
(19, 5),
(19, 11),
(20, 5),
(20, 9),
(20, 11),
(21, 5),
(21, 11),
(22, 5),
(22, 11),
(23, 5),
(23, 9),
(23, 11),
(24, 5),
(24, 9),
(24, 11),
(25, 5),
(25, 9),
(25, 11),
(26, 5),
(26, 9),
(26, 11),
(27, 5),
(27, 11),
(28, 5),
(28, 11),
(29, 5),
(29, 11),
(30, 5),
(30, 11);

-- --------------------------------------------------------

--
-- Table structure for table `routine_maintenance_fees`
--

CREATE TABLE `routine_maintenance_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `confirmation` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `renewal_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routine_maintenance_fees`
--

INSERT INTO `routine_maintenance_fees` (`id`, `reference`, `transaction_id`, `user_id`, `amount_paid`, `status`, `confirmation`, `renewal_date`, `created_at`, `updated_at`) VALUES
(1, 'qmeYQ3Xv1ifePFilrLifFCBE7', 1, 1, 5000, 1, '2', '2022-07-30 13:21:28', '2021-07-30 13:21:28', '2021-07-30 13:21:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('E818oSE96croJK3dm3Jgbi3rDpeluJfd0VysU1oT', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR1RGbWp6WlNQckVoNGZtTEl2OTNmSEp1VEVHZTcyaXY3NjhOREJ3QyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYW5hZ2UtYWNjb3VudCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkcGMwY1ZJSHZFcDlYUVVlQUVTY2dwT0ROWVh1c3cxZG1pMU1ESjhTcXAzcEVuZnBnbFZhWGEiO30=', 1655228783);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_payouts`
--

CREATE TABLE `subscription_payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_payouts`
--

INSERT INTO `subscription_payouts` (`id`, `transaction_id`, `subscription_id`, `user_id`, `admin_id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 1, 22400, 1, '2021-08-01 12:01:36', '2021-08-01 12:05:46'),
(2, 4, 1, 1, 1, 22400, 1, '2021-08-01 12:01:49', '2021-08-01 12:05:38'),
(3, 5, 1, 1, 1, 22400, 1, '2021-08-01 12:07:31', '2021-11-15 08:53:35'),
(4, 5, 1, 1, 1, 22400, 1, '2021-08-01 12:07:31', '2021-11-15 08:53:35'),
(5, 5, 1, 1, 1, 22400, 1, '2021-08-01 12:07:31', '2021-11-15 08:53:35'),
(41, 61, 4, 7, 10, 2000, 0, '2021-11-15 13:43:59', '2021-11-15 13:43:59'),
(42, 62, 4, 7, 10, 6000, 0, '2021-11-15 13:44:09', '2021-11-15 13:44:09'),
(43, 63, 4, 7, 10, 49500, 0, '2021-11-15 13:44:47', '2021-11-15 13:44:47'),
(44, 65, 4, 7, 10, 20000, 0, '2021-11-15 13:52:58', '2021-11-15 13:52:58'),
(45, 66, 4, 7, 10, 2000, 0, '2021-11-15 13:53:05', '2021-11-15 13:53:05'),
(46, 67, 1, 1, 10, 2000, 0, '2021-11-15 13:53:22', '2021-11-15 13:53:22'),
(47, 68, 2, 7, 10, 2000, 0, '2021-11-15 13:53:22', '2021-11-15 13:53:22'),
(48, 69, 5, 10, 10, 2000, 1, '2021-11-15 13:53:22', '2021-11-16 04:45:06'),
(49, 70, 6, 11, 10, 2000, 0, '2021-11-15 13:53:23', '2021-11-15 13:53:23'),
(50, 71, 7, 10, 10, 2000, 1, '2021-11-15 13:53:23', '2021-11-16 04:41:55'),
(51, 72, 8, 10, 10, 2000, 1, '2021-11-15 13:53:23', '2021-11-16 04:43:18'),
(52, 73, 9, 10, 10, 2000, 1, '2021-11-15 13:53:23', '2021-11-16 04:41:59'),
(53, 74, 1, 1, 10, 2000, 0, '2021-11-15 13:55:49', '2021-11-15 13:55:49'),
(54, 75, 2, 7, 10, 2000, 0, '2021-11-15 13:55:49', '2021-11-15 13:55:49'),
(55, 76, 5, 10, 10, 2000, 1, '2021-11-15 13:55:49', '2021-11-16 04:43:12'),
(56, 77, 6, 11, 10, 2000, 0, '2021-11-15 13:55:49', '2021-11-15 13:55:49'),
(57, 78, 7, 10, 10, 2000, 1, '2021-11-15 13:55:50', '2021-11-16 04:43:15'),
(58, 79, 8, 10, 10, 2000, 1, '2021-11-15 13:55:50', '2021-11-16 04:41:13'),
(59, 80, 9, 10, 10, 2000, 0, '2021-11-15 13:55:50', '2021-11-15 13:55:50'),
(60, 81, 1, 1, 10, 2000, 0, '2021-11-15 13:56:04', '2021-11-15 13:56:04'),
(61, 82, 2, 7, 10, 2000, 0, '2021-11-15 13:56:04', '2021-11-15 13:56:04'),
(62, 83, 5, 10, 10, 2000, 0, '2021-11-15 13:56:04', '2021-11-15 13:56:04'),
(63, 84, 6, 11, 10, 2000, 0, '2021-11-15 13:56:05', '2021-11-15 13:56:05'),
(64, 85, 7, 10, 10, 2000, 0, '2021-11-15 13:56:05', '2021-11-15 13:56:05'),
(65, 86, 8, 10, 10, 2000, 0, '2021-11-15 13:56:05', '2021-11-15 13:56:05'),
(66, 87, 9, 10, 10, 2000, 0, '2021-11-15 13:56:05', '2021-11-15 13:56:05'),
(67, 88, 1, 1, 10, 200, 0, '2021-11-16 03:29:08', '2021-11-16 03:29:08'),
(68, 89, 2, 7, 10, 200, 0, '2021-11-16 03:29:08', '2021-11-16 03:29:08'),
(69, 90, 5, 10, 10, 200, 0, '2021-11-16 03:29:08', '2021-11-16 03:29:08'),
(70, 91, 6, 11, 10, 200, 0, '2021-11-16 03:29:08', '2021-11-16 03:29:08'),
(71, 92, 7, 10, 10, 200, 0, '2021-11-16 03:29:09', '2021-11-16 03:29:09'),
(72, 93, 8, 10, 10, 200, 0, '2021-11-16 03:29:09', '2021-11-16 03:29:09'),
(73, 94, 9, 10, 10, 200, 0, '2021-11-16 03:29:09', '2021-11-16 03:29:09'),
(74, 95, 3, 7, 10, 2000, 0, '2021-11-16 03:29:34', '2021-11-16 03:29:34'),
(75, 96, 11, 12, 10, 2000, 0, '2021-11-16 03:29:34', '2021-11-16 03:29:34'),
(76, 98, 4, 7, 10, 2000, 0, '2021-11-16 04:06:32', '2021-11-16 04:06:32'),
(77, 99, 4, 7, 10, 2000, 0, '2021-11-16 04:07:08', '2021-11-16 04:07:08'),
(78, 100, 4, 7, 10, 3000, 0, '2021-11-16 04:07:21', '2021-11-16 04:07:21'),
(79, 103, 15, 10, 10, 20000, 0, '2021-11-16 05:05:18', '2021-11-16 05:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_invitations`
--

CREATE TABLE `team_invitations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_user`
--

CREATE TABLE `team_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `user_id`, `admin_id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, '3', 1, 0, 5000, 1, '2021-07-30 13:21:28', '2021-07-30 13:21:28'),
(2, '2', 1, 0, 100000, 1, '2021-07-30 13:21:28', '2021-07-30 13:21:28'),
(3, '1', 1, 1, 22400, 1, '2021-08-01 12:01:36', '2021-08-01 12:05:46'),
(4, '1', 1, 1, 22400, 1, '2021-08-01 12:01:49', '2021-08-01 12:05:38'),
(5, '1', 1, 1, 67200, 1, '2021-08-01 12:07:31', '2021-11-15 08:53:35'),
(59, '1', 7, 10, 28750, 0, '2021-11-15 13:36:57', '2021-11-15 13:36:57'),
(60, '1', 7, 10, 2000, 0, '2021-11-15 13:38:22', '2021-11-15 13:38:22'),
(61, '1', 7, 10, 2000, 0, '2021-11-15 13:43:59', '2021-11-15 13:43:59'),
(62, '1', 7, 10, 6000, 0, '2021-11-15 13:44:09', '2021-11-15 13:44:09'),
(63, '1', 7, 10, 49500, 0, '2021-11-15 13:44:47', '2021-11-15 13:44:47'),
(64, '1', 7, 10, 20000, 0, '2021-11-15 13:50:46', '2021-11-15 13:50:46'),
(65, '1', 7, 10, 20000, 0, '2021-11-15 13:52:58', '2021-11-15 13:52:58'),
(66, '1', 7, 10, 2000, 0, '2021-11-15 13:53:05', '2021-11-15 13:53:05'),
(67, '1', 1, 10, 2000, 0, '2021-11-15 13:53:22', '2021-11-15 13:53:22'),
(68, '1', 7, 10, 2000, 0, '2021-11-15 13:53:22', '2021-11-15 13:53:22'),
(69, '1', 10, 10, 2000, 1, '2021-11-15 13:53:22', '2021-11-16 04:45:06'),
(70, '1', 11, 10, 2000, 0, '2021-11-15 13:53:22', '2021-11-15 13:53:22'),
(71, '1', 10, 10, 2000, 1, '2021-11-15 13:53:23', '2021-11-16 04:41:55'),
(72, '1', 10, 10, 2000, 1, '2021-11-15 13:53:23', '2021-11-16 04:43:18'),
(73, '1', 10, 10, 2000, 1, '2021-11-15 13:53:23', '2021-11-16 04:41:59'),
(74, '1', 1, 10, 2000, 0, '2021-11-15 13:55:49', '2021-11-15 13:55:49'),
(75, '1', 7, 10, 2000, 0, '2021-11-15 13:55:49', '2021-11-15 13:55:49'),
(76, '1', 10, 10, 2000, 1, '2021-11-15 13:55:49', '2021-11-16 04:43:12'),
(77, '1', 11, 10, 2000, 0, '2021-11-15 13:55:49', '2021-11-15 13:55:49'),
(78, '1', 10, 10, 2000, 1, '2021-11-15 13:55:49', '2021-11-16 04:43:15'),
(79, '1', 10, 10, 2000, 1, '2021-11-15 13:55:50', '2021-11-16 04:41:13'),
(80, '1', 10, 10, 2000, 0, '2021-11-15 13:55:50', '2021-11-15 13:55:50'),
(81, '1', 1, 10, 2000, 0, '2021-11-15 13:56:04', '2021-11-15 13:56:04'),
(82, '1', 7, 10, 2000, 0, '2021-11-15 13:56:04', '2021-11-15 13:56:04'),
(83, '1', 10, 10, 2000, 0, '2021-11-15 13:56:04', '2021-11-15 13:56:04'),
(84, '1', 11, 10, 2000, 0, '2021-11-15 13:56:04', '2021-11-15 13:56:04'),
(85, '1', 10, 10, 2000, 0, '2021-11-15 13:56:05', '2021-11-15 13:56:05'),
(86, '1', 10, 10, 2000, 0, '2021-11-15 13:56:05', '2021-11-15 13:56:05'),
(87, '1', 10, 10, 2000, 0, '2021-11-15 13:56:05', '2021-11-15 13:56:05'),
(88, '1', 1, 10, 200, 0, '2021-11-16 03:29:08', '2021-11-16 03:29:08'),
(89, '1', 7, 10, 200, 0, '2021-11-16 03:29:08', '2021-11-16 03:29:08'),
(90, '1', 10, 10, 200, 0, '2021-11-16 03:29:08', '2021-11-16 03:29:08'),
(91, '1', 11, 10, 200, 0, '2021-11-16 03:29:08', '2021-11-16 03:29:08'),
(92, '1', 10, 10, 200, 0, '2021-11-16 03:29:09', '2021-11-16 03:29:09'),
(93, '1', 10, 10, 200, 0, '2021-11-16 03:29:09', '2021-11-16 03:29:09'),
(94, '1', 10, 10, 200, 0, '2021-11-16 03:29:09', '2021-11-16 03:29:09'),
(95, '1', 7, 10, 2000, 0, '2021-11-16 03:29:34', '2021-11-16 03:29:34'),
(96, '1', 12, 10, 2000, 0, '2021-11-16 03:29:34', '2021-11-16 03:29:34'),
(97, '1', 7, 10, 2000, 0, '2021-11-16 04:04:52', '2021-11-16 04:04:52'),
(98, '1', 7, 10, 2000, 0, '2021-11-16 04:06:32', '2021-11-16 04:06:32'),
(99, '1', 7, 10, 2000, 0, '2021-11-16 04:07:06', '2021-11-16 04:07:06'),
(100, '1', 7, 10, 3000, 0, '2021-11-16 04:07:21', '2021-11-16 04:07:21'),
(101, '2', 10, 10, 50000, 0, '2021-11-16 05:04:47', '2021-11-16 05:04:47'),
(102, '2', 0, 10, 50000, 0, '2021-11-16 05:04:47', '2021-11-16 05:04:47'),
(103, '1', 10, 10, 20000, 0, '2021-11-16 05:05:17', '2021-11-16 05:05:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `status`) VALUES
(7, 'John Max', 'j.max@app.io', '2021-07-19 06:46:03', '$2y$10$HXt9bhQXgysN51i4vXUXlOBiRsLJP5.bzVQ4dvN.yhUdr/.WnVQHO', NULL, NULL, NULL, NULL, NULL, '2021-07-19 06:45:08', '2021-07-19 06:46:03', '0'),
(10, 'Nuetion Developer', 'developer@nuetion.com', '2021-07-19 16:53:17', '$2y$10$pc0cVIHvEp9XQUeAEScgpODNYXusw1dmi1MDJ8Sqp3pEnfpglVaXa', NULL, NULL, NULL, NULL, NULL, '2021-07-19 16:51:02', '2021-11-12 05:17:18', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details`
--

CREATE TABLE `user_bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` int(11) NOT NULL,
  `bvn` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_bank_details`
--

INSERT INTO `user_bank_details` (`id`, `user_id`, `bank`, `account_number`, `bvn`, `created_at`, `updated_at`) VALUES
(1, 1, 'First Bank', 2147483647, 2147483647, '2021-07-12 05:27:15', '2021-07-12 05:27:15'),
(2, 11, 'First Bank', 2147483647, 2147483647, '2021-07-20 16:21:22', '2021-07-20 16:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_contact_details`
--

CREATE TABLE `user_contact_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_contact_details`
--

INSERT INTO `user_contact_details` (`id`, `user_id`, `address`, `state`, `country`, `phone`, `created_at`, `updated_at`) VALUES
(1, 1, '1 Okotete Street, Ovwian', 'Delta', 'Nigeria', '09021843208', '2021-07-07 07:06:34', '2021-07-07 07:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_identity_details`
--

CREATE TABLE `user_identity_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('M','F','U') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'U',
  `marital_status` enum('S','M','D','U') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'U',
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_of_origin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NIN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_card` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_identity_details`
--

INSERT INTO `user_identity_details` (`id`, `user_id`, `dob`, `gender`, `marital_status`, `nationality`, `state_of_origin`, `NIN`, `qualification`, `passport_photo`, `id_card`, `created_at`, `updated_at`) VALUES
(2, 1, '2002-12-30', 'F', 'M', 'Nigerian', 'Delta', '10294873645756634', 'BSc', 'user/passport_photo/Htnt4VykthHnE57oy17rv5QX0R47fmPKDOoowufl.png', NULL, '2021-07-07 06:53:17', '2021-07-07 07:26:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_photos`
--
ALTER TABLE `project_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_subcriptions`
--
ALTER TABLE `project_subcriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `routine_maintenance_fees`
--
ALTER TABLE `routine_maintenance_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscription_payouts`
--
ALTER TABLE `subscription_payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_user_id_index` (`user_id`);

--
-- Indexes for table `team_invitations`
--
ALTER TABLE `team_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `team_invitations_team_id_email_unique` (`team_id`,`email`);

--
-- Indexes for table `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_contact_details`
--
ALTER TABLE `user_contact_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_identity_details`
--
ALTER TABLE `user_identity_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_photos`
--
ALTER TABLE `project_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `project_subcriptions`
--
ALTER TABLE `project_subcriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `routine_maintenance_fees`
--
ALTER TABLE `routine_maintenance_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscription_payouts`
--
ALTER TABLE `subscription_payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_invitations`
--
ALTER TABLE `team_invitations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_contact_details`
--
ALTER TABLE `user_contact_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_identity_details`
--
ALTER TABLE `user_identity_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_invitations`
--
ALTER TABLE `team_invitations`
  ADD CONSTRAINT `team_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
