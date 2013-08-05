<?php


class Snowdog_Fourzerofour_Model_Resource_Log_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct() {

        parent::_construct();
        $this->_init('fourzerofour/log', 'log_id');
    }


    public function getSize()
    {
        $records = Mage::getModel('fourzerofour/log')->getCollection();
        $records->getSelect()->group('main_table.url_address');
        $recordCount = $records->count();
        return $recordCount;
    }




}