<?php


$installer  = $this;


$writeConnection = $installer->getConnection('core_write');
// update manually all Url keys - remove "/" from all url_addresses
$query           = 'UPDATE `snowdog_404_log` SET `url_address` = substr(url_address , 2) where substr(url_address ,1 ,1) = "/"';
$writeConnection->query($query);


$installer->endSetup();
