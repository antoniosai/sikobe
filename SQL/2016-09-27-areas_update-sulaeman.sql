ALTER TABLE `areas`
ADD `is_active` tinyint(1) NOT NULL DEFAULT '1' AFTER `status`;
ALTER TABLE `areas`
ADD INDEX `is_active` (`is_active`);
ALTER TABLE `areas_statuses`
ADD `is_active` tinyint(1) NOT NULL DEFAULT '1' AFTER `datetime`;
ALTER TABLE `areas_statuses`
ADD INDEX `is_active` (`is_active`);
ALTER TABLE `files`
ADD `is_active` tinyint(1) NOT NULL DEFAULT '1' AFTER `size`;
ALTER TABLE `files`
ADD INDEX `author_id` (`author_id`),
ADD INDEX `is_active` (`is_active`);