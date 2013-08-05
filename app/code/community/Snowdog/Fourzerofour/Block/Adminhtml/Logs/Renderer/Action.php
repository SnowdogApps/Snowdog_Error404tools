<?php
class Snowdog_Fourzerofour_Block_Adminhtml_Logs_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if ($row->getRedirectId()) {
            //images/success_msg_icon.gif
            return '<img src="' . Mage::getDesign()->getSkinUrl() . 'images/success_msg_icon.gif' . '" >';
        } else {
            return '
            <button class="redirectBtn" id="redirectBtn_'. $row->getId() . '">
                <input type="hidden" name="redirectPath_'. $row->getId() . '" value="' . $row->getUrlAddress(). '" />
                <span>
                    Add redirect
                </span>
            </button>';
        }
    }
}
