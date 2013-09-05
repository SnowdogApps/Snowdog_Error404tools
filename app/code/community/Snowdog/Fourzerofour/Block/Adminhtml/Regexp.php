<?php

class Snowdog_Fourzerofour_Block_Adminhtml_Regexp
    extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {

        $this->_controller = 'adminhtml_regexp';
        $this->_blockGroup = 'fourzerofour';
        $this->_headerText = Mage::helper('fourzerofour')->__('Regular Expressions');

        parent::__construct();

    } // public function __construct() {

} // class Snowdog_Fourzerofour_Block_Adminhtml_Regexp