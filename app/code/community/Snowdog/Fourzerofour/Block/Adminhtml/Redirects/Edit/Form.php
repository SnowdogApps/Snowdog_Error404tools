<?php


class Snowdog_Fourzerofour_Block_Adminhtml_Redirects_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
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


        $fieldset = $form->addFieldset('redirect404form', array(
            'legend' =>Mage::helper('fourzerofour')->__('Enter / edit 404 redirect informations')
        ));

        $fieldset->addField('redirect_type', 'select', array(
            'label'     => Mage::helper('fourzerofour')->__('Redirect Type:'),
            'name'      => 'redirect_type',
            'values'    => Mage::getModel('fourzerofour/redirect_type')->toOptionArray(),
            'note'      => 'Product redirect - enter product ID for selected store <br/>
                            Category redirect - enter category ID for selected store <br/>
                            Custom redirect - enter target path for redirect'
        ));

        $fieldset->addField('category_id', 'text', array(
            'label'     => Mage::helper('fourzerofour')->__('Category Id'),
            'name'      => 'category_id'
        ));

        $fieldset->addField('product_id', 'text', array(
            'label'     => Mage::helper('fourzerofour')->__('Product Id'),
            'name'      => 'product_id',
        ));

        $fieldset->addField('store_id', 'select', array(
            'label'     => Mage::helper('fourzerofour')->__('Store Name'),
            'name'      => 'store_id',
            'values'    => Mage::getModel('core/store')->getCollection()->toOptionHash(),
        ));

        $fieldset->addField('request_path', 'text', array(
            'label'     => Mage::helper('fourzerofour')->__('Request Path:'),
            'name'      => 'request_path',
            'note'      => 'everything that comes after slash / '
        ));

        $fieldset->addField('target_path', 'text', array(
            'label'     => Mage::helper('fourzerofour')->__('Target Path:'),
            'name'      => 'target_path',
            'note'      => 'use only for custom redirects '
        ));


        $form->setValues($data);

        return parent::_prepareForm();
    }
}