<?php

$installer = $this;

$installer->startSetup();

$installer->run("
        DROP TABLE IF EXISTS `{$installer->getTable('fourzerofour/regexp')}`;
        CREATE TABLE `{$installer->getTable('fourzerofour/regexp')}` (
         `regexp_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
         `reg_expression` text NOT NULL,
         `target_path` text NOT NULL,
         `store_id` INT(10) UNSIGNED,
          PRIMARY KEY  (`regexp_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
        ");


$installer->endSetup();