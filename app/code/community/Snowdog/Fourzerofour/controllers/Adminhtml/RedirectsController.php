<?php
/**
 * Created by JetBrains PhpStorm.
 * User: altasar
 * Date: 26.06.13
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

 class Snowdog_Fourzerofour_Adminhtml_RedirectsController extends Mage_Adminhtml_Controller_Action {

     protected function _initAction() {
         $this->loadLayout()
             ->_setActiveMenu('report');

         return $this;
     }

     public function indexAction()
     {
         $this->loadLayout();
         $this->renderLayout();
     }


     public function newAction()
     {
         $this->_forward('edit');
     }


     public function editAction()
     {
         $id = $this->getRequest()->getParam('id', null);

         $model = Mage::getModel('fourzerofour/redirect');

         if ($id) {
             $model->load((int)$id);
             if ($model->getRedirectId()) {
                 $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                 if ($data) {
                     $model->setData($data)->setRedirectId($id);
                 }
             } else {
                 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('fourzerofour')->__('Record does not exists'));
                 $this->_redirect('*/*/');
             }
         }
         Mage::register('fourzerofour', $model);

         $this->loadLayout();
         $this->renderLayout();
     }


     public function massDeleteAction() {
         $redirectIds = $this->getRequest()->getParam('redirects404');
         if(!is_array($redirectIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
         } else {
             try {
                 foreach ($redirectIds as $redirectId) {
                     $redirect = Mage::getModel('fourzerofour/redirect')->load($redirectId);
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
     }



     public function saveAction()
     {
         if ($data = $this->getRequest()->getPost())
         {
             $model = Mage::getModel('fourzerofour/redirect');
             $id = $this->getRequest()->getParam('id');
             if ($id) {
                 $model->load($id);
             }
             $model->setData($data);

             Mage::getSingleton('adminhtml/session')->setFormData($data);
             try {
                 if ($id) {
                     $model->setRedirectId($id);
                 }
                 $model->save();

                 if (!$model->getId()) {
                     Mage::throwException(Mage::helper('fourzerofour')->__('Error while saving data...'));
                 }

                 Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('fourzerofour')->__('404 Redirect Saved.'));
                 Mage::getSingleton('adminhtml/session')->setFormData(false);

                 // The following line decides if it is a "save" or "save and continue"
                 if ($this->getRequest()->getParam('back')) {
                     $this->_redirect('*/*/edit', array('id' => $model->getRedirectId()));
                 } else {
                     $this->_redirect('*/*/');
                 }

             } catch (Exception $e) {
                 Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                 if ($model && $model->getId()) {
                     $this->_redirect('*/*/edit', array('id' => $model->getRedirectId()));
                 } else {
                     $this->_redirect('*/*/');
                 }
             }

             return;
         }
         Mage::getSingleton('adminhtml/session')->addError(Mage::helper('redirect')->__('No data found to save'));
         $this->_redirect('*/*/');
     }





     public function exportCsvAction () {
         $fileName   = 'logs404.csv';
         $grid       = $this->getLayout()->createBlock('fourzerofour/adminhtml_logs_grid');
         $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
     }
 }