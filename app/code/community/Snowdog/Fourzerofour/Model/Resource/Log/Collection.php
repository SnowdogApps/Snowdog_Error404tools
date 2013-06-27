<?php


class Snowdog_Fourzerofour_Model_Resource_Log_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct() {

        parent::_construct();
        $this->_init('fourzerofour/log', 'log_id');
    }

}