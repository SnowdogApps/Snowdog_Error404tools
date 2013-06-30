<?php
/*
 * URL 4040 fix script - part 1
 * this script copies all the data from core_url_rewrite to snowdog_404_redirect table
 */

// comment this below to run this script in console mode
die ("For safety reasons please run this script from console, not as a magento autoinstaller \n");

// from magento upgrade script
// $installer = $this;
// $installer->startSetup();

echo "running core_ulr_rewrite copy: \n";

require_once ('app/Mage.php');
Mage::app('default');

// get connection singleton
$resource        = Mage::getSingleton('core/resource');
// get readConnection
$readConnection  = $resource->getConnection('core_read');
// get writeConnection
$writeConnection = $resource->getConnection('core_write');

// select all core_url_rewrite records
$recordQuery  = 'select count(*) as count from core_url_rewrite';
$recordResult = $readConnection->fetchAll($recordQuery);
$recordCount  = $recordResult[0]['count'];

$recordProcess = 1000;
// divide and ceil number of select operations
// this is required so script wont cause 500 error on a large database
$counter      = ceil ($recordCount / $recordProcess);

// processed record counter
$j = 0;


// get total count and go every 1000;

for ($i = 0; $i < $counter; $i++) {
    // var_dump($result);
    echo "going " . ($i+1) . ": rows : " . $recordProcess . "\n" ;
    $query = 'SELECT * FROM core_url_rewrite order by url_rewrite_id limit ' . $recordProcess . ' offset ' . $i * $recordProcess;
    $results = $readConnection->fetchAll($query);

    foreach ($results as $result) {
        ++$j;
        switch ((int)$result['is_system']) {
            // create target path only for custom (not system) redirects
            case 0 : { $redirectType = 3; $targetPath = $result['target_path']; break ; }
            case 1 : { $targetPath = '' ;break ; }
        }

        if ($result['product_id'] == null ) {
            // set redirect type = category
            if ($result['category_id'] == null ) {
                // set redirect type - custom
                $redirectType = 3;
            } else {
                // set redirect type - category
                $redirectType = 2;
            }
        } else if ($result['category_id'] == null ) {
            // set redirect type = product
            $redirectType = 1;
        }

        $insertQuery = 'insert into `snowdog_404_redirect`
                (
                    `redirect_type` ,
                    `product_id` ,
                    `category_id` ,
                    `store_id` ,
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
        // you can uncomment this to see insert query
        // echo $insertQuery . '<br/ >';

        /* uncomment this after running display operation */
        // $writeConnection->query($insertQuery);

        echo "Processed $j out of $recordCount; url_rewrite_id id: ". $result['url_rewrite_id']. "\n";
    } // end foreach
} // end i


// magento method
//$installer->endSetup();