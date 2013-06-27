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

//    // get connection singleton
//    $resource        = Mage::getSingleton('core/resource');
//    // get readConnection
//    $readConnection  = $resource->getConnection('core_read');
//    // get writeConnection
//    $writeConnection = $resource->getConnection('core_write');
//
//    // select all core_url_rewrite records
//    $query           = 'SELECT * FROM core_url_rewrite order by url_rewrite_id';
//
//    $results         = $readConnection->fetchAll($query);
//
//    foreach ($results as $result) {
//        var_dump($result);
//
//        $insertQuery = 'insert into `snowdog_404_redirect`
//                          (
//                            `product_id`   ,
//                            `category_id`  ,
//                            `store_id`  ,
//                            `request_path` ,
//                            `target_path`
//                          )
//                            VALUES
//                            (
//                              "'.$result['product_id'].'" ,
//                              "'.$result['category_id'].'" ,
//                              "'.$result['store_id'].'" ,
//                              "'.$result['request_path'].'" ,
//                              "'.$result['target_path'].'" ,
//                            )';
//
//        $writeConnection->query($insertQuery);
//    }


$installer->endSetup();