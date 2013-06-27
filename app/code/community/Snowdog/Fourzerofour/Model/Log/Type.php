<?php

class Snowdog_Fourzerofour_Model_Log_Type  {

    public function toOptionArray() {
        return array(
            array('value'=>1, 'label'=>Mage::helper('fourzerofour')->__('Database')),
            array('value'=>2, 'label'=>Mage::helper('fourzerofour')->__('Database + Log file')),
            array('value'=>3, 'label'=>Mage::helper('fourzerofour')->__('Log file')),

        );
    }
}