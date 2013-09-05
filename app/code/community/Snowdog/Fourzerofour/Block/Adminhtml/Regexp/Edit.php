<?php

class Snowdog_Fourzerofour_Block_Adminhtml_Regexp_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {

        parent::__construct();

        $this->_objectId = 'regexp_edit';
        $this->_blockGroup = 'fourzerofour';
        $this->_controller = 'adminhtml_regexp';
        $this->_mode = 'edit';

        $this->_updateButton('save', 'label', Mage::helper('fourzerofour')->__('Save Regular Expression'));

    } // public function __construct() {


    public function getHeaderText() {

        if (Mage::registry('fourzerofour') && Mage::registry('fourzerofour')->getId())
        {
            return Mage::helper('fourzerofour')->__('Regexp edit');
        } else {
            return Mage::helper('fourzerofour')->__('New regexp');
        }

    } // public function getHeaderText() {


    protected function _prepareLayout() {

        if ($this->_blockGroup && $this->_controller && $this->_mode) {
            $this->setChild('form', $this->getLayout()->createBlock($this->_blockGroup . '/' . $this->_controller . '_' . $this->_mode . '_form'));
        }
        return parent::_prepareLayout();

    } // protected function _prepareLayout() {s

} // class Snowdog_Fourzerofour_Block_Adminhtml_Regexp_Edit