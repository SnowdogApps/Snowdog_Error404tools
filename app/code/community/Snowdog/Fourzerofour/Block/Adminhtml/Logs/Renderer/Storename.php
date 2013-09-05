<?php
class Snowdog_Fourzerofour_Block_Adminhtml_Logs_Renderer_Storename
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {

        $value =  $row->getData($this->getColumn()->getIndex());
        return $value;

    } // public function render(Varien_Object $row)

} // class Snowdog_Fourzerofour_Block_Adminhtml_Logs_Renderer_Storename