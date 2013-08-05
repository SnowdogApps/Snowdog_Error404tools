<?php

    $installer = $this;
    $installer->startSetup();

    $installer->run("
    DROP TABLE IF EXISTS `{$installer->getTable('fourzerofour/log')}`;
    CREATE TABLE `{$installer->getTable('fourzerofour/log')}` (
     `log_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
     `log_time` DATETIME NOT NULL,
     `store_id` SMALLINT(5) UNSIGNED NOT NULL,
     `url_address` VARCHAR(255) NOT NULL,
     `referer`    VARCHAR(255) NOT NULL,
      PRIMARY KEY  (`log_id`),
      FOREIGN KEY (`store_id`) REFERENCES `{$installer->getTable('core/store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT = '404 logs with refeffers';
    ");

    $installer->endSetup();
