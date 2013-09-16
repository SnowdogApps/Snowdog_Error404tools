<?php


class Snowdog_Fourzerofour_Block_Adminhtml_Regexp_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        if (Mage::getSingleton('adminhtml/session')->getFourzerofour())
        {
            $data = Mage::getSingleton('adminhtml/session')->getFourzerofour();
            Mage::getSingleton('adminhtml/session')->getFourzerofour(null);
        }
        elseif (Mage::registry('fourzerofour'))
        {
            $data = Mage::registry('fourzerofour')->getData();
        }
        else
        {
            $data = array();
        }

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);
        $this->setForm($form);


        $fieldset = $form->addFieldset('regexp_form', array(
            'legend' =>Mage::helper('fourzerofour')->__('Enter / edit Regular Expression informations')
        ));


        $fieldset->addField('store_id', 'select', array(
            'label'     => Mage::helper('fourzerofour')->__('Store Name'),
            'name'      => 'store_id',
            'values'    => Mage::getModel('core/store')->getCollection()->toOptionHash(),
        ));

        $fieldset->addField('reg_expression', 'text', array(
            'label'     => Mage::helper('fourzerofour')->__('Regular Expression:'),
            'name'      => 'reg_expression',
            'note'      => $this->__('')
        ));

        $fieldset->addField('target_path', 'text', array(
            'label'     => Mage::helper('fourzerofour')->__('Target Path:'),
            'name'      => 'target_path',
        ));

        $form->setValues($data);

        return parent::_prepareForm();
    } //  protected function _prepareForm() {

}
