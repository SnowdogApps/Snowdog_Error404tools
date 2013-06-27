<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Snowdog_Fourzerofour_Block_Adminhtml_Redirects_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'redirects404_edit';
        $this->_blockGroup = 'fourzerofour';
        $this->_controller = 'adminhtml_redirects';
        $this->_mode = 'edit';

        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('fourzerofour')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_updateButton('save', 'label', Mage::helper('fourzerofour')->__('Save 404 redirect'));

    }

    public function getHeaderText()
    {
        if (Mage::registry('fourzerofour') && Mage::registry('fourzerofour')->getId())
        {
            return Mage::helper('fourzerofour')->__('Redirect edit');
        } else {
            return Mage::helper('fourzerofour')->__('New redirect');
        }
    }


    protected function _prepareLayout() {

        if ($this->_blockGroup && $this->_controller && $this->_mode) {
            $this->setChild('form', $this->getLayout()->createBlock($this->_blockGroup . '/' . $this->_controller . '_' . $this->_mode . '_form'));
        }
        return parent::_prepareLayout();
    }

}
