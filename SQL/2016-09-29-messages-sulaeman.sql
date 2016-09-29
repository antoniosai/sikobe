CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `sender` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `phone` (`phone`),
  KEY `email` (`email`),
  KEY `is_read` (`is_read`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `messages` (`id`, `title`, `content`, `sender`, `phone`, `email`, `is_read`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pesan dari Sulaeman',  'Tolong dslf sdlfkj lsdkfj sldkf jlksdj flksd jf\r\nd\r\nfkjsdl kfjlsdk jflks djflk jsdlkf jlksd jflksdf\r\nsdjlfk jsdlkfjsldkfsdfsd fsd',  'Sulaeman', '+62-853-20000-483',  '', 0,  1,  '2016-09-29 01:46:56',  '2016-09-29 01:46:56'),
(2, 'Pesan dari Sulaeman',  'sdfs dfsdf sdf \r\ndf sdf sd fsd\r\nfs dfsdf sdf sdfdsf',  'Sulaeman', '+734343434', 'me@sulaeman.com',  0,  1,  '2016-09-29 02:32:53',  '2016-09-29 02:32:53'),
(3, 'Pesan dari Sulaemand', 'sdlfjlsdkfj lskdf\r\ndjflksd jfksd\r\nfjs kldfsdf sdf sdf',  'Sulaemand',  'sdfksjdlfkdsjfl',  '', 0,  1,  '2016-09-29 02:33:06',  '2016-09-29 02:33:06');