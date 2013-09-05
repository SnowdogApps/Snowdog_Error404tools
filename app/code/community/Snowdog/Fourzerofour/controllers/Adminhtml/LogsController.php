<?php

class Snowdog_Fourzerofour_Adminhtml_LogsController
    extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {

        $this->loadLayout()
            ->_setActiveMenu('report');

        return $this;

    } // protected function _initAction() {


    public function indexAction() {

        $this->loadLayout();
        $this->renderLayout();

    } // public function indexAction()


    public function massDeleteAction() {

        $redirectIds = $this->getRequest()->getParam('logs404');
        if(!is_array($redirectIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($redirectIds as $redirectId) {
                    $redirect = Mage::getModel('fourzerofour/log')->load($redirectId);
                    $redirect->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($redirectIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');

    } // public function massDeleteAction() {


    public function exportCsvAction () {

        $fileName   = 'logs404.csv';
        $grid       = $this->getLayout()->createBlock('fourzerofour/adminhtml_logs_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());

    } // public function exportCsvAction () {
}