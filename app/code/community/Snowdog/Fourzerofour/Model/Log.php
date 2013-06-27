<?php

class Snowdog_Fourzerofour_Model_Log extends Mage_Core_Model_Abstract
{
    protected function _construct() {
        $this->_init('fourzerofour/log');
    }


   public function saveLogCsv ($logTime, $storeId, $urlAddress, $referer , $ipAddress, $userAgent) {

       $logData = $logTime . ',' . $storeId . ',' . $urlAddress . ',' . $referer . ',' . $ipAddress . ',' . $userAgent;
       Mage::log($logData, null, '404logs.log');

   }


}