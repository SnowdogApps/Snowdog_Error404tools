<?php

class Snowdog_Fourzerofour_Model_Redirect_Type  {

    public function toOptionArray() {

        return array(
            1 => array('value'=>1, 'label'=>Mage::helper('fourzerofour')->__('Product redirect')),
            2 => array('value'=>2, 'label'=>Mage::helper('fourzerofour')->__('Category redirect')),
            3 => array('value'=>3, 'label'=>Mage::helper('fourzerofour')->__('Custom redirect')),

        );

    } // public function toOptionArray() {


    public function toOptionHash() {

        $res = array();
        foreach ($this->toOptionArray() as $item) {
            $res[$item['value']] = $item['label'];
        }
        return $res;

    } // public function toOptionHash() {

}