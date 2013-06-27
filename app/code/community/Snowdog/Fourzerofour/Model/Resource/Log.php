<?php


class Snowdog_Fourzerofour_Model_Resource_Log extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('fourzerofour/log', 'log_id');
    }

}