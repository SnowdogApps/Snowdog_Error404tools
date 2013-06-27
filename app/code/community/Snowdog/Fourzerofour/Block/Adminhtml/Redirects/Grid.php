<?php
/**
 * @author Jakub Winkler
 * @company Snowdog
 */
class Snowdog_Fourzerofour_Block_Adminhtml_Redirects_Grid extends Mage_Adminhtml_Block_Widget_Grid {


    public function __construct() {
        parent::__construct();
        $this->setId('redirectsGrid');
        $this->setDefaultSort('redirect_id');
        $this->setDefaultDir('DESC');
    }


    protected function _addColumnFilterToCollection($column) {
        $filterArr = Mage::registry('preparedFilter');

        if ($column->getId() === 'store_id') {
            $this->getCollection()->addFieldToFilter('main_table.' . $column->getId(), array('eq' => $column->getFilter()->getValue()));
            return $this;
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }


    protected function _prepareCollection() {
        $model = Mage::getModel('fourzerofour/redirect');
        $collection = $model->getCollection();
        $collection->getSelect()
            ->join('core_store', 'main_table.store_id = core_store.store_id', array('name'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


    protected function _prepareColumns() {
        $this->addColumn('redirect_id', array(
            'header' => Mage::helper('fourzerofour')->__('ID'),
            'align' => 'left',
            'width' => '1px',
            'index' => 'redirect_id',
        ));

        $this->addColumn('redirect_type', array(
            'header' => Mage::helper('fourzerofour')->__('Redirect Type:'),
            'align' => 'left',
            'index' => 'redirect_type',
            'type' => 'options',
            'renderer' => 'Snowdog_Fourzerofour_Block_Adminhtml_Redirects_Renderer_Type',
            'options'    => Mage::getModel('fourzerofour/redirect_type')->toOptionHash(),
        ));

        $this->addColumn('request_path', array(
            'header' => Mage::helper('fourzerofour')->__('Request Path'),
            'align' => 'left',
            'index' => 'request_path',
        ));

        $this->addColumn('target_path', array(
            'header' => Mage::helper('fourzerofour')->__('Target Path'),
            'align' => 'left',
            'index' => 'target_path',
        ));


        $this->addColumn('product_id', array(
            'header' => Mage::helper('fourzerofour')->__('Product ID'),
            'align' => 'left',
            'index' => 'product_id',
        ));

        $this->addColumn('category_id', array(
            'header' => Mage::helper('fourzerofour')->__('Category ID'),
            'align' => 'left',
            'index' => 'category_id',
        ));

        $this->addColumn('store_id', array(
            'header' => Mage::helper('fourzerofour')->__('Store Name:'),
            'align' => 'left',
            'index' => 'name',
            'type' => 'options',
            'renderer' => 'Snowdog_Fourzerofour_Block_Adminhtml_Logs_Renderer_Storename',
            'options' => Mage::getModel('core/store')->getCollection()->toOptionHash(),
        ));


        $this->addExportType('*/*/exportCsv', Mage::helper('fourzerofour')->__('CSV'));
        return parent::_prepareColumns();
    }


    protected function _prepareMassaction() {
        $this->setMassactionIdField('redirect_id');
        $this->getMassactionBlock()->setFormFieldName('redirects404');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('fourzerofour')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('fourzerofour')->__('Are you sure?')
        ));

        return $this;
    }


    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }



}