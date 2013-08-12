<?php
/**
 * @author Jakub Winkler
 * @company Snowdog
 */

class Snowdog_Fourzerofour_Block_Adminhtml_Logs_Grid extends Mage_Adminhtml_Block_Widget_Grid {


    public function __construct() {
        parent::__construct();
        $groupLogs = (int)Mage::getStoreConfig('log404_options/log404_group/dbjoin');

        $this->setId('logsGrid');
        if (!$groupLogs ) {
            $this->setDefaultSort('log_id');
        } else {
            $this->setDefaultSort('log_time');
        }

        $this->setDefaultDir('DESC');
    }


    protected function _addColumnFilterToCollection($column) {
        $filterArr = Mage::registry('preparedFilter');

        if ($column->getId() === 'store_id') {
            $this->getCollection()->addFieldToFilter('main_table.' . $column->getId(), array('eq' => $column->getFilter()->getValue()));
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }


    protected function _prepareCollection() {

        $groupLogs = (int)Mage::getStoreConfig('log404_options/log404_group/dbjoin');

        if ($groupLogs) {
            $model = Mage::getModel('fourzerofour/log');
            $collection = $model->getCollection();
            $collection->getSelect()
                ->join('core_store', 'main_table.store_id = core_store.store_id', array('name'))
                ->joinLeft('snowdog_404_redirect' , 'main_table.url_address = snowdog_404_redirect.request_path' , array('redirect_id'))
                ->group('main_table.url_address');

            $collection->getSelecT()->columns (
                array (
                    'log_count' => 'count(*)'
                )
            );
        } else {
            $model = Mage::getModel('fourzerofour/log');
            $collection = $model->getCollection();
            $collection->getSelect()
                ->joinLeft('core_store', 'main_table.store_id = core_store.store_id', array('name'));
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();

    } // protected function _prepareCollection() {


    protected function _prepareColumns() {

        $groupLogs = (int)Mage::getStoreConfig('log404_options/log404_group/dbjoin');

        if (!$groupLogs ) {
            $this->addColumn('log_id', array(
                'header' => Mage::helper('fourzerofour')->__('Log Id'),
                'align' => 'left',
                'index' => 'log_id',
            ));
        }

        $this->addColumn('url_address', array(
            'header' => Mage::helper('fourzerofour')->__('404 Url address'),
            'align' => 'left',
            'index' => 'url_address',
        ));

        $this->addColumn('referer', array(
            'header' => Mage::helper('fourzerofour')->__('HTTP referrer:'),
            'align' => 'left',
            'index' => 'referer',
        ));

        $this->addColumn('ip_address', array(
            'header' => Mage::helper('fourzerofour')->__('Ip Address:'),
            'align' => 'left',
            'index' => 'ip_address',
        ));

        $this->addColumn('user_agent', array(
            'header' => Mage::helper('fourzerofour')->__('User Agent:'),
            'align' => 'left',
            'index' => 'user_agent',
        ));


        $this->addColumn('store_id', array(
            'header' => Mage::helper('fourzerofour')->__('Store Name:'),
            'align' => 'left',
            'index' => 'name',
            'type' => 'options',
            'renderer' => 'Snowdog_Fourzerofour_Block_Adminhtml_Logs_Renderer_Storename',
            'options' => Mage::getModel('core/store')->getCollection()->toOptionHash(),
        ));


        $this->addColumn('log_time', array(
            'header' => Mage::helper('fourzerofour')->__('Log Time'),
            'align' => 'right',
            'index' => 'log_time',
        ));


        // show log count & action for redirect only if records are joined
        if ($groupLogs ) {
            $this->addColumn('log_count', array(
                'header' => Mage::helper('fourzerofour')->__('Log Count'),
                'align' => 'right',
                'index' => 'log_count',
            ));

            $this->addColumn('action', array(
                'header' => Mage::helper('fourzerofour')->__('Action'),
                'align' => 'center',
                'renderer' => 'Snowdog_Fourzerofour_Block_Adminhtml_Logs_Renderer_Action'
            ));
        }


        $this->addExportType('*/*/exportCsv', Mage::helper('fourzerofour')->__('CSV'));
        return parent::_prepareColumns();
    }


    protected function _prepareMassaction() {
        $this->setMassactionIdField('log_id');
        $this->getMassactionBlock()->setFormFieldName('logs404');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('fourzerofour')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('fourzerofour')->__('Are you sure?')
        ));

        return $this;
    }





}
