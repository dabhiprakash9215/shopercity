13-02-2024
ALTER TABLE `vendor` ADD `user_id` INT NULL DEFAULT NULL AFTER `id`;

29-02-2024
ALTER TABLE `vendor` CHANGE `status` `status` INT(10) NULL DEFAULT '0' COMMENT '0=pending\r\n1=reject\r\n2=approve\r\n3=delete';
ALTER TABLE `vendor` ADD `reason` TEXT NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `vendor` CHANGE `city_id` `city_id` VARCHAR(255) NULL DEFAULT NULL;
done