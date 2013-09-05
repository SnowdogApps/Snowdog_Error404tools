<?php


class Snowdog_Fourzerofour_Model_Resource_Redirect_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract {

    protected function _construct() {

        parent::_construct();
        $this->_init('fourzerofour/redirect', 'redirect_id');

    } //protected function _construct() {

} // class Snowdog_Fourzerofour_Model_Resource_Redirect_Collection