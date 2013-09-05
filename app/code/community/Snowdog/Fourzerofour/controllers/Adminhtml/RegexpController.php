<?php
/**
 * Created by JetBrains PhpStorm.
 * User: altasar
 * Date: 26.06.13
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

 class Snowdog_Fourzerofour_Adminhtml_RegexpController
     extends Mage_Adminhtml_Controller_Action {

     protected function _initAction() {

         $this->loadLayout()
             ->_setActiveMenu('report');

         return $this;

     } // protected function _initAction() {


     public function indexAction() {

         $this->loadLayout();
         $this->renderLayout();

     } // public function indexAction() {


     public function newAction() {

         $this->_forward('edit');

     } // public function newAction() {


     public function editAction() {

         $id = $this->getRequest()->getParam('id', null);

         $model = Mage::getModel('fourzerofour/regexp');

         if ($id) {
             $model->load((int)$id);
             if ($model->getRegexpId()) {
                 $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                 if ($data) {
                     $model->setData($data)->getRegexpId($id);
                 }
             } else {
                 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('fourzerofour')->__('Record does not exists'));
                 $this->_redirect('*/*/');
             }
         }
         Mage::register('fourzerofour', $model);

         $this->loadLayout();
         $this->renderLayout();

     } // public function editAction() {


     public function massDeleteAction() {

         $regExpIds = $this->getRequest()->getParam('regexpsIds');
         if(!is_array($regExpIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
         } else {
             try {
                 foreach ($regExpIds as $regExp) {
                     $regExp = Mage::getModel('fourzerofour/regexp')->load($regExp);
                     $regExp->delete();
                 }
                 Mage::getSingleton('adminhtml/session')->addSuccess(
                     Mage::helper('adminhtml')->__(
                         'Total of %d record(s) were successfully deleted', count($regExpIds)
                     )
                 );
             } catch (Exception $e) {
                 Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
             }
         }
         $this->_redirect('*/*/index');

     } // public function massDeleteAction() {



     public function saveAction() {

         if ($data = $this->getRequest()->getPost())
         {
             $model = Mage::getModel('fourzerofour/regexp');
             $id = $this->getRequest()->getParam('id');

             if ($id) {
                 $model->load($id);
             }
             $model->setData($data);

             Mage::getSingleton('adminhtml/session')->setFormData($data);
             try {
                 if ($id) {
                     $model->setRegexpId($id);
                 }
                 $model->save();

                 if (!$model->getId()) {
                     Mage::throwException(Mage::helper('fourzerofour')->__('Error while saving data...'));
                 }

                 Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('fourzerofour')->__('Regular Expression saved.'));
                 Mage::getSingleton('adminhtml/session')->setFormData(false);

                 // The following line decides if it is a "save" or "save and continue"
                 if ($this->getRequest()->getParam('back')) {
                     $this->_redirect('*/*/edit', array('id' => $model->getRegexpId()));
                 } else {
                     $this->_redirect('*/*/');
                 }

             } catch (Exception $e) {
                 Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                 if ($model && $model->getId()) {
                     $this->_redirect('*/*/edit', array('id' => $model->getRegexpId()));
                 } else {
                     $this->_redirect('*/*/');
                 }
             }

             return;
         }
         Mage::getSingleton('adminhtml/session')->addError(Mage::helper('redirect')->__('No data found to save'));
         $this->_redirect('*/*/');

     } // public function saveAction() {


     public function exportCsvAction () {

         $fileName   = 'regexp.csv';
         $grid       = $this->getLayout()->createBlock('fourzerofour/adminhtml_regexp_grid');
         $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());

     } // public function exportCsvAction () {


     public function deleteAction() {

         $id = $this->getRequest()->getParam('id', null);
         if ($id) {

             $model = Mage::getModel('fourzerofour/regexp');
             $id = $this->getRequest()->getParam('id');
             if ($id) {
                 $model->load($id);
             }

             try {
                 $model->delete();
                 Mage::getSingleton('adminhtml/session')->addSuccess(
                     Mage::helper('adminhtml')->__(
                         '404 Redirect was deleted'
                     )
                 );
                 $this->_redirect('*/*/index');

             } catch (Exception $e) {
                 Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                 if ($model && $model->getId()) {
                     $this->_redirect('*/*/edit', array('id' => $model->getRegexpId()));
                 } else {
                     $this->_redirect('*/*/');
                 }
             }
             return;
         }

     } //public function deleteAction() {

 }