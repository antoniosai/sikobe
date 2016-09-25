SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `collection` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` bigint(20) unsigned NOT NULL,
  `identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `identifier` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `collection` (`id`, `author_id`, `identifier`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1,  'information',  'Test Information', 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nWhy do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',  '2016-09-25 17:56:00',  '0000-00-00 00:00:00');

CREATE TABLE `failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `groups` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'Administrators', '{}', '0000-00-00 00:00:00',  '0000-00-00 00:00:00'),
(2, 'Relawan',  '{}', '0000-00-00 00:00:00',  '0000-00-00 00:00:00');

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`remember_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `email`, `password`, `activated`, `activation_code`, `activated_at`, `last_login`, `remember_token`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(1, 'me@sulaeman.com',  '$2y$10$B29h0gAXn9Hvlo4EKW0bHunNYjErM4vKB4/UZjaiBRkwk0YmnvJJG', 1,  NULL, NULL, NULL, 'QnwJctVgB03BUPe8DHDy5y0lVubSQx2bhE7LkSa04boydkR9gFQdJyy9uM9l', 'Sulaeman', '', '2016-09-25 14:48:45',  '2016-09-25 14:48:45'),
(2, 'antoniosaiful10@gmail.com',  '$2y$10$D7jyTdUB5.cdAv9n4cZbGuGjK1GLmRidYL6H1LoWIMZtp1r/bo.8q', 0,  NULL, NULL, NULL, NULL, 'Antonio',  'Saiful Islam', '2016-09-25 15:03:07',  '2016-09-25 15:03:07'),
(3, 'hikmat.iqbal@gmail.com', '$2y$10$xZPKSbyLfyQizlLy9Ee7tOzfzGPsxAyUYHvg.MXRZCViD5c80wxWK', 0,  NULL, NULL, NULL, NULL, 'Ikbal',  'Mohamad Hikmat', '2016-09-25 15:37:43',  '2016-09-25 15:37:43'),
(4, 'saddam.almahali@gmail.com',  '$2y$10$YaPko6jSfvvLKkmxYymQ7Obhv0JuEEYI/d8jgeR.yumDcZjobnf66', 0,  NULL, NULL, NULL, NULL, 'Saddam', 'Almahali', '2016-09-25 15:10:43',  '2016-09-25 15:10:43'),
(5, 'rindacahyana@gmail.com', '$2y$10$hl9d3YqDHGsSNUwjU1U2QOYPnGKfRN52Wmx4r4AAWvKmZZcSMLdTS', 0,  NULL, NULL, NULL, NULL, 'Rinda',  'Cahyana',  '2016-09-25 15:11:24',  '2016-09-25 15:11:24');

CREATE TABLE `users_groups` (
  `user_id` bigint(20) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users_groups` (`user_id`, `group_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2);

CREATE TABLE `users_login_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `os_family` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_mobile` tinyint(1) NOT NULL DEFAULT '0',
  `is_tablet` tinyint(1) NOT NULL DEFAULT '0',
  `is_desktop` tinyint(1) NOT NULL DEFAULT '0',
  `browser_family` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `browser_version_major` int(10) NOT NULL DEFAULT '0',
  `browser_version_minor` int(10) NOT NULL DEFAULT '0',
  `browser_version_patch` int(10) NOT NULL DEFAULT '0',
  `device_family` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_model` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_saved` tinyint(1) NOT NULL DEFAULT '0',
  `last_activity` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_history` (`user_id`,`ip_address`,`country_code`,`os_family`,`is_mobile`,`is_tablet`,`is_desktop`,`browser_family`,`browser_version_major`,`browser_version_minor`,`browser_version_patch`,`device_family`,`device_model`) USING BTREE,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `users_metas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `handle` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `key` (`handle`),
  CONSTRAINT `users_metas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users_metas` (`id`, `user_id`, `handle`, `value`, `created_at`, `updated_at`) VALUES
(1, 1,  'username', 'me@sulaeman.com',  '2015-04-14 16:46:56',  '0000-00-00 00:00:00'),
(2, 1,  'first_name', 'Sulaeman', '2015-04-14 16:56:26',  '2015-04-14 09:55:12'),
(3, 1,  'last_name',  '', '2015-04-14 16:56:32',  '2015-04-14 09:55:12'),
(4, 1,  'display_name', 'Sulaeman', '2015-04-14 16:56:37',  '2015-04-14 09:55:12'),
(5, 1,  'phone',  '+62-822-1477-1883',  '2016-09-25 14:38:29',  '2016-09-25 15:03:56'),
(6, 2,  'display_name', 'Antonio Saiful Islam', '2016-09-25 15:03:07',  '2016-09-25 15:03:07'),
(7, 2,  'phone',  '+62-812-1494-007', '2016-09-25 15:03:07',  '2016-09-25 15:03:07'),
(8, 3,  'display_name', 'Ikbal Mohamad Hikmat', '2016-09-25 15:08:54',  '2016-09-25 15:08:54'),
(9, 3,  'phone',  '+62-857-2346-3342',  '2016-09-25 15:08:54',  '2016-09-25 15:08:54'),
(10,  4,  'display_name', 'Saddam Almahali',  '2016-09-25 15:10:43',  '2016-09-25 15:10:43'),
(11,  4,  'phone',  '+62-812-2359-6458',  '2016-09-25 15:10:43',  '2016-09-25 15:10:43'),
(12,  5,  'display_name', 'Rinda Cahyana',  '2016-09-25 15:11:24',  '2016-09-25 15:11:24'),
(13,  5,  'phone',  '+62-813-2006-3272',  '2016-09-25 15:11:24',  '2016-09-25 15:11:24');