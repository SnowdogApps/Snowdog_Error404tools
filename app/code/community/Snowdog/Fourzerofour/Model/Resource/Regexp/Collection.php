<?php

class Snowdog_Fourzerofour_Model_Resource_Regexp_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    protected function _construct() {

        parent::_construct();
        $this->_init('fourzerofour/regexp', 'regexp');

    } // protected function _construct() {

} //class Snowdog_Fourzerofour_Model_Resource_Regexp_Collection