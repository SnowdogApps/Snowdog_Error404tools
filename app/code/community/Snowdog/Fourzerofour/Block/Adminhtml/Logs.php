<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Orders
 *
 * @author Jakub Winkler
 * @company Snowdog
 */
class Snowdog_Fourzerofour_Block_Adminhtml_Logs extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_logs';
        $this->_blockGroup = 'fourzerofour';
        $this->_headerText = Mage::helper('fourzerofour')->__('404 database logs');

        parent::__construct();
        $this->_removeButton('add');
    }

}

