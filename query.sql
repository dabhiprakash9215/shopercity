13-02-2024
ALTER TABLE `vendor` ADD `user_id` INT NULL DEFAULT NULL AFTER `id`;

29-02-2024
ALTER TABLE `vendor` CHANGE `status` `status` INT(10) NULL DEFAULT '0' COMMENT '0=pending\r\n1=reject\r\n2=approve\r\n3=delete';
ALTER TABLE `vendor` ADD `reason` TEXT NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `vendor` CHANGE `city_id` `city_id` VARCHAR(255) NULL DEFAULT NULL;
ALTER TABLE `commission_settings` ADD `plan_price` INT NOT NULL AFTER `admin_commission`;
done


06-02-2026
ALTER TABLE `vendor` ADD `website_link` TEXT NULL DEFAULT NULL AFTER `youtube_link`, ADD `yt_link` TEXT NULL DEFAULT NULL AFTER `website_link`;
ALTER TABLE `vendor` ADD `bio` TEXT NOT NULL AFTER `yt_link`;
ALTER TABLE `vendor` CHANGE `bio` `bio` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
