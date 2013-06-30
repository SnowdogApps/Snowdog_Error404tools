<?php
/*
 * URL 4040 fix script - part 1
 * this script copies all the data from core_url_rewrite to snowdog_404_redirect table
 */

// comment this below to run this script in console mode
    die ("For safety reasons please run this script from console, not as a magento autoinstaller \n");

    require_once ('app/Mage.php');
    Mage::app('default');


// get connection singleton
$resource        = Mage::getSingleton('core/resource');
// get readConnection
$readConnection  = $resource->getConnection('core_read');
// get writeConnection
$writeConnection = $resource->getConnection('core_write');


// get total product count
$recordQuery  = 'select count(*) as count from catalog_product_entity';
$recordResult = $readConnection->fetchAll($recordQuery);
$recordCount  = $recordResult[0]['count'];

// numver of records passed to SELECT
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
    // select all core_url_rewrite records
    $query           = 'SELECT type_id, catalog_product_entity.entity_id FROM catalog_product_entity
                join catalog_product_entity_int
                    on (catalog_product_entity.entity_id = catalog_product_entity_int.entity_id and value=1 and attribute_id = 85)
                        where `type_id` = "simple"
                        order by catalog_product_entity.entity_id
                          limit ' . $recordProcess . ' offset ' . $i * $recordProcess;

    $results         = $readConnection->fetchAll($query);
    foreach ($results as $result) {

        $urlQuery = 'select value_id, store_id, entity_id, attribute_id, value from catalog_product_entity_varchar where
                        `entity_id` = "'. $result['entity_id'].'"
                            and
                                `attribute_id` = "82"';
        $urlResult = $readConnection->fetchAll($urlQuery);

        foreach ($urlResult as $res) {
            if ($res['value'] != '') {
                //$duplicatedKeys  = 'select count(entity_id) as counter from catalog_product_entity_varchar  where value = "'. $res['value'] .'" and store_id="'. $res['store_id'] .'" and entity_id <> "'. $res['entity_id'] .'"'  ;
                // echo $duplicatedKeys;

                $isVisible = 0;

                // check if product id is at the end
                if (!preg_match("/-[0-9]+$/" , $res['value']))
                {
                    $updateQuery  = 'update catalog_product_entity_varchar set value = CONCAT(value , "-" , "' . $result['entity_id'] . '") where
                        `value_id`  =  "' . $res['value_id'] . '" ' ;
                    /* uncomment line below to update informations in database when running this script from shell*/
                    // $updateRes = $writeConnection->query($updateQuery);
                    echo "updated: $j; url key chagned from " . $res['value'] . " to: "  . $res['value'] . "-" . $result['entity_id'] . "\n";
                }
            } // end if
        } // end foreach - attribute for all stores

        // add increment
        ++$j;
        echo "Processed $j out of $recordCount; product id: ". $result['entity_id']. "\n";
    } // end foreach

} // end for i


echo "\n\n it is done ... \n";
echo "remember to reindex all the data in magento using: php shell/indexer.php reindexall \n \n" ;
