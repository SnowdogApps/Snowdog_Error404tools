<?php

    $installer = $this;

    $installer->startSetup();

    $installer->run("
        DROP TABLE IF EXISTS `{$installer->getTable('fourzerofour/redirect')}`;
        CREATE TABLE `{$installer->getTable('fourzerofour/redirect')}` (
         `redirect_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
         `redirect_type` INT (10) NOT NULL,
         `product_id` INT(10) DEFAULT NULL,
         `category_id` INT(10) DEFAULT NULL,
         `store_id` INT(10) UNSIGNED,
         `request_path` VARCHAR(255) NOT NULL,
         `target_path` VARCHAR(255) NOT NULL,
          PRIMARY KEY  (`redirect_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='redirect pages - from core_url_rewrite';
        ");


$installer->endSetup();