<?php
class Snowdog_Fourzerofour_Block_Adminhtml_Redirects_Renderer_Type extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $array = Mage::getModel('fourzerofour/redirect_type')->toOptionArray();
        $value =  $row->getData($this->getColumn()->getIndex());
        // return $value;
        return $array[$value]['label'];
    }
}
