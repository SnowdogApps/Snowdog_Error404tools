<?php

class Snowdog_Fourzerofour_Model_Observer_Fourzerofour {

    public function log404(Varien_Event_Observer $observer) {

        $logReferer = Mage::app()->getRequest()->getServer('HTTP_REFERER');
        $controller = Mage::app()->getRequest()->getControllerName();
        $route      = Mage::app()->getRequest()->getRouteName();;
        $action     = Mage::app()->getRequest()->getActionName();;
        $path       = strtolower($controller . $route . $action);

        $logSaveType      = Mage::getStoreConfig('log404_options/log404_group/log404type');
        $saveEmptyReferer = (int)Mage::getStoreConfig('log404_options/log404_group/log404referer');

        if ($path == 'indexcmsnoroute') {

            // check for 404 redirect in the database
            // remove slash from REQUEST_URI
            $requestUrl = substr($_SERVER['REQUEST_URI'] ,1);

            // get redirect404 collection and look by request path
            $redirect404  = Mage::getModel('fourzerofour/redirect')->getCollection()
                ->addFieldToFilter('request_path' , array ('eq' => $requestUrl))
                ->addFieldToFilter('store_id' ,     array ('eq' => Mage::app()->getStore()->getStoreId()))
                ->getFirstItem();

            // dont log 404 error for if redirect already exists
            if ($redirect404->getId()) {
                // var_dump($redirect404);

                switch ($redirect404->getRedirectType()) {
                    case 1 : { $productId  = (int)$redirect404->getProductId();  $url = Mage::getModel('catalog/product')->load($productId)->getProductUrl() ; break ;}
                    case 2 : { $categoryId = (int)$redirect404->getCategoryId(); $url = Mage::getModel('catalog/category')->load($categoryId)->getUrl() ; break ; }
                    case 3 : { $url        = $redirect404->getTargetPath(); break;  }
                }

                // redirect to specified page
                Mage::app()->getFrontController()->getResponse()->setRedirect($url);

            } else {

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
}