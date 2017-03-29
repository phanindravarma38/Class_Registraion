-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2017 at 06:12 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noah_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 4, NULL),
('admin', 5, NULL),
('editor', 3, NULL),
('theCreator', 1, 1489979905);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Administrator of this application', NULL, NULL, 1489631418, 1489631418),
('adminArticle', 2, 'Allows admin+ roles to manage articles', NULL, NULL, 1489631417, 1489631417),
('createArticle', 2, 'Allows editor+ roles to create articles', NULL, NULL, 1489631417, 1489631417),
('deleteArticle', 2, 'Allows admin+ roles to delete articles', NULL, NULL, 1489631417, 1489631417),
('editor', 1, 'Editor of this application', NULL, NULL, 1489631418, 1489631418),
('manageUsers', 2, 'Allows admin+ roles to manage users', NULL, NULL, 1489631417, 1489631417),
('member', 1, 'Registered users, members of this site', NULL, NULL, 1489631418, 1489631418),
('premium', 1, 'Premium members. They have more permissions than normal members', NULL, NULL, 1489631418, 1489631418),
('support', 1, 'Support staff', NULL, NULL, 1489631418, 1489631418),
('theCreator', 1, 'You!', NULL, NULL, 1489631418, 1489631418),
('updateArticle', 2, 'Allows editor+ roles to update articles', NULL, NULL, 1489631417, 1489631417),
('updateOwnArticle', 2, 'Update own article', 'isAuthor', NULL, 1489631417, 1489631417),
('usePremiumContent', 2, 'Allows premium+ roles to use premium content', NULL, NULL, 1489631417, 1489631417);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('theCreator', 'admin'),
('editor', 'adminArticle'),
('editor', 'createArticle'),
('admin', 'deleteArticle'),
('admin', 'editor'),
('admin', 'manageUsers'),
('support', 'member'),
('support', 'premium'),
('editor', 'support'),
('admin', 'updateArticle'),
('updateOwnArticle', 'updateArticle'),
('editor', 'updateOwnArticle'),
('premium', 'usePremiumContent');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 'O:28:"common\\rbac\\rules\\AuthorRule":3:{s:4:"name";s:8:"isAuthor";s:9:"createdAt";i:1489631417;s:9:"updatedAt";i:1489631417;}', 1489631417, 1489631417);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `moodified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `platform_id`, `language_id`, `code`, `status`, `created_by`, `created_date`, `moodified_date`) VALUES
(1, 'PHP', 1, 1, 'PHP', 1, 1, '2017-03-18 03:55:12', '2017-03-18 08:25:12'),
(2, 'Java', 1, 1, 'JAVA', 1, 1, '2017-03-18 08:29:16', '2017-03-18 08:29:16'),
(4, 'Python', 2, 2, 'PYTHON', 1, 4, '2017-03-21 11:08:45', '2017-03-21 01:38:45'),
(5, 'ASP.Net', 2, 1, '.net', 1, 5, '2017-03-21 21:59:07', '2017-03-21 12:29:07'),
(6, 'R', 3, 1, 'R', 1, 5, '2017-03-21 22:00:13', '2017-03-21 12:30:13');

-- --------------------------------------------------------

--
-- Table structure for table `course_user`
--

CREATE TABLE `course_user` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_user`
--

INSERT INTO `course_user` (`id`, `course_id`, `user_id`, `created_date`, `modified_date`) VALUES
(1, 1, 1, '2017-03-19 00:00:00', '2017-03-19 07:49:05'),
(2, 1, 2, '2017-03-19 00:00:00', '2017-03-19 07:49:05'),
(4, 2, 2, '2017-03-19 00:00:00', '2017-03-19 07:49:46'),
(5, 1, 2, '2017-03-19 00:00:00', '2017-03-19 07:50:37'),
(8, 4, 4, '2017-03-21 11:16:49', '2017-03-21 01:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `status`, `created_by`, `created_date`, `modified_date`) VALUES
(1, 'English', 1, 1, '2017-03-20 10:38:06', '2017-03-20 10:38:06'),
(2, 'Spanish', 1, 4, '2017-03-21 11:07:13', '2017-03-21 01:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1489631396),
('m141022_115823_create_user_table', 1489631404),
('m141022_115912_create_rbac_tables', 1489631406),
('m141022_115922_create_session_table', 1489631407),
('m150104_153617_create_article_table', 1489631407);

-- --------------------------------------------------------

--
-- Table structure for table `platforms`
--

CREATE TABLE `platforms` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `platforms`
--

INSERT INTO `platforms` (`id`, `name`, `url`, `status`, `created_by`, `created_date`, `modified_date`) VALUES
(1, 'Coursera', 'https://www.coursera.org/', 1, 1, '2017-03-20 10:35:46', '2017-03-20 10:35:46'),
(2, 'EDX', 'www.edx.com', 1, 4, '2017-03-21 11:07:56', '2017-03-21 01:37:56'),
(3, 'stanfordOnline', 'http://online.stanford.edu/', 1, 5, '2017-03-21 21:59:56', '2017-03-21 12:29:56');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `expire` int(11) NOT NULL,
  `data` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `expire`, `data`) VALUES
('24d1tgr4aqod9m2c5gcjhqnae7', 1489634410, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a31393a222f7068616e69796969322f6261636b656e642f223b),
('ges96b4mq4jab9o7amomk15m06', 1489688770, 0x5f5f666c6173687c613a303a7b7d),
('j493hiv08u8getq1pu4qlvtfn3', 1489988337, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a31393a222f7068616e69796969322f6261636b656e642f223b5f5f69647c693a313b),
('l2ubvlcvn1ar9c9f78j92nce44', 1490128436, 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a353b);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_activation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `username`, `email`, `mobile`, `password_hash`, `status`, `auth_key`, `password_reset_token`, `account_activation_token`, `created_at`, `updated_at`) VALUES
(1, 'Student1', 'student1', 'student1@mailinator.com', '9874563210', '$2y$13$qaWKE8r0oy9bhF/lpv2wRekGs8A7fKMfiMgJHcU997p2490BnaTXm', 10, 'ZyNSiBEHGiJtYu12OHs82SW9-7AG7Q3J', NULL, NULL, 1489979905, 1489979905),
(2, 'Student 2', 'student2', 'student2@mailinator.com', '9874563210', '$2y$13$EN0eAO7gIiV4Bn7NZVe1UevW7Ybhdb/F5ZnGUOij3mIV6FOt1jOoe', 10, '-_1Gn2KAdbRKnhauI9Jk9u9EPsNfwSGo', NULL, NULL, 1489979956, 1489979956),
(3, 'Student3', 'student3', 'student3@mailinator.com', '9533765491', '$2y$13$YwK.TsvSlBoVxr4MqAq7/.AKsxoMJW5IBKHHpLw1DlKMDxals2X/y', 10, 'Tjaml2tOziUDN-Po7VNbwdb1XLIdeTks', NULL, NULL, 1490074282, 1490074282),
(4, 'Student4', 'student4', 'student4@gmail.com', '9702312321', '$2y$13$am4Ssm1R.yM6TI7bvl9EQuwPHYSjTVES7WXY2jhTUDgURyGh0vRdm', 10, 'cPYa8p3-Vm9a62lPK0SY-7hoA3KSccD9', NULL, NULL, 1490075138, 1490075138),
(5, 'student5', 'student5', 'student5@mail.com', '1234567891', '$2y$13$bjLsxBJza.bLN/7oL6uBsepV.r6TdGfZriaUp.zXC6dZbnxngpbdm', 10, 'xG8nQghCEIdUY5FkhVfL197Odx6URvv8', NULL, NULL, 1490113588, 1490113588);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_activation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `email`, `password_hash`, `status`, `auth_key`, `password_reset_token`, `account_activation_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'testuser', 'testuser@mailinator.com', '$2y$13$ylpcwJDCWGeZJ.ua1RPtNuCTB1w29POzBsBG01d61q.kjvbF6jmR6', 10, 's06VxcZwgcL9VAWr1FgCbMXvaCV4TzBD', NULL, NULL, 1489631624, 1489631624),
(3, 'Editor', 'editor', 'editor@mailinator.com', '$2y$13$5KKSOMEyG4vCr7aRKi0rfefQkSH7cR5aKm/XpZCX/yjGUyVloKsF6', 10, 'N6jNWOWAfIZerN66LmhLMmfYWdHEDfA_', NULL, NULL, 1489687183, 1489687183),
(4, 'Admin', 'admin', 'admin@malinator.com', '$2y$13$VGqRsoPWg6.M2LP.c10RJuFb0jDNmoIAEaelEwFO3SVazUzNfd/P2', 10, '3AQO4Iaj2GFHg9tPHLabuIQ5r9YTHlfx', NULL, NULL, 1489687289, 1489687289),
(5, 'User1', 'user1', 'user1@mailinator.com', '$2y$13$CV8IUa8P0C3arpYWBKC1WuvnkwOAD9lRRRdoEHu9/yb.nqLgLT/M6', 10, 'JwVpAiT1w-lunqeRP_M2LbqvOlPS5UL2', NULL, NULL, 1489977958, 1489977958);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `platform_id` (`platform_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `course_user`
--
ALTER TABLE `course_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `course_user`
--
ALTER TABLE `course_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_user`
--
ALTER TABLE `course_user`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
