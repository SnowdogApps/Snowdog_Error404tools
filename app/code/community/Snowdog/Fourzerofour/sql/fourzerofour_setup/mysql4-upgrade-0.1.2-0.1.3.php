<?php


$installer = $this;

$installer->startSetup();


    // get connection singleton
    $resource        = Mage::getSingleton('core/resource');
    // get readConnection
    $readConnection  = $resource->getConnection('core_read');
    // get writeConnection
    $writeConnection = $resource->getConnection('core_write');

    // select all core_url_rewrite records
    $query           = 'SELECT * FROM core_url_rewrite order by url_rewrite_id';

    $results         = $readConnection->fetchAll($query);

    foreach ($results as $result) {
        // var_dump($result);

        switch ((int)$result['is_system']) {
            // create target path only for custom (not system) redirects
            case 0 : { $redirectType = 3; $targetPath = $result['target_path']; break ; }
            case 1 : { $targetPath = '' ;break ; }
        }

        if ($result['product_id'] == null ) {
            // set redirect type = category
            $redirectType = 2;
        } else if ($result['category_id'] == null ) {
            // set redirect type = product
            $redirectType = 1;
        }

        $insertQuery = 'insert into `snowdog_404_redirect`
                          (
                            `redirect_type` ,
                            `product_id`   ,
                            `category_id`  ,
                            `store_id`  ,
                            `request_path` ,
                            `target_path`
                          )
                            VALUES
                            (
                              "' . $redirectType . '" ,
                              "' . $result['product_id'] . '" ,
                              "' . $result['category_id'] . '" ,
                              "' . $result['store_id'] . '" ,
                              "' . $result['request_path'] . '" ,
                              "' . $targetPath . '"
                            )';

        // echo $insertQuery . '<br/ >';

        $writeConnection->query($insertQuery);
    }

// die ();

$installer->endSetup();