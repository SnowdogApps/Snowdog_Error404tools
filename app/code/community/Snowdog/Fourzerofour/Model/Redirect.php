<?php

class Snowdog_Fourzerofour_Model_Redirect extends Mage_Core_Model_Abstract {

    protected function _construct() {
        $this->_init('fourzerofour/redirect');
    }

    public function redirect404($oldUrl , $store) {

        Mage::getUrl($oldUrl, array(
            // '_current' => true,
            '_use_rewrite' => true,
            '_store' => $store
        ));
    }

}