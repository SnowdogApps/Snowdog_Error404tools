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
class Snowdog_Fourzerofour_Block_Adminhtml_Redirects
    extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {

        $this->_controller = 'adminhtml_redirects';
        $this->_blockGroup = 'fourzerofour';
        $this->_headerText = Mage::helper('fourzerofour')->__('404 redirects');

        parent::__construct();

    } // public function __construct() {

} // class Snowdog_Fourzerofour_Block_Adminhtml_Redirects