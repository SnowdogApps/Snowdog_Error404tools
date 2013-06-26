<?php
class Snowdog_Fourzerofour_Model_Observer_Fourzerofour {

    public function log404(Varien_Event_Observer $observer) {
        // var_dump($observer);
        $logReferer = Mage::app()->getRequest()->getServer('HTTP_REFERER');
        $controller = Mage::app()->getRequest()->getControllerName();
        $route      = Mage::app()->getRequest()->getRouteName();;
        $action     = Mage::app()->getRequest()->getActionName();;
        $path = strtolower($controller . $route . $action);

        $logSaveType      = Mage::getStoreConfig('log404_options/log404_group/log404type');
        $saveEmptyReferer = (int)Mage::getStoreConfig('log404_options/log404_group/log404referer');

        if ($path == 'indexcmsnoroute') {

            if (($logReferer != '') || ($logReferer == '' && $saveEmptyReferer) ) {
                $logTime    = date('Y-m-d H:i:s');
                $logStoreId = Mage::app()->getStore()->getStoreId();
                $logUrlAddress = $_SERVER['REQUEST_URI'];
                $logUserAgent  = Mage::app()->getRequest()->getServer('HTTP_USER_AGENT');
                $logIp         = Mage::app()->getRequest()->getServer('REMOTE_ADDR');


                // set data to fourzerofour/log resource model
                $log = Mage::getModel('fourzerofour/log');
                $log->setLogTime($logTime)
                    ->setStoreId($logStoreId)
                    ->setUrlAddress($logUrlAddress)
                    ->setReferer($logReferer)
                    ->setIpAddress($logIp)
                    ->setUserAgent($logUserAgent);

                // save data based from system store configuration
                switch ($logSaveType) {
                    case '1' : { $log->save(); break ;}
                    case '2' : { $log->save();
                                 $log->saveLogCsv($logTime, $logStoreId, $logUrlAddress, $logReferer, $logIp, $logUserAgent); break ;}
                    case '3' : { $log->saveLogCsv($logTime, $logStoreId, $logUrlAddress, $logReferer, $logIp, $logUserAgent); break ;}
                }
            }
        }
    }
}