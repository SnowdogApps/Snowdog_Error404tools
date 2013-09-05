<?php
/**
 * @author Jakub Winkler
 * @company Snowdog
 */

class Snowdog_Fourzerofour_Block_Adminhtml_Regexp_Grid
    extends Mage_Adminhtml_Block_Widget_Grid {


    public function __construct() {

        parent::__construct();
        $this->setId('regexpGrid');
        $this->setDefaultSort('regexp_id');
        $this->setDefaultDir('DESC');

    } //public function __construct() {


    protected function _addColumnFilterToCollection($column) {
        $filterArr = Mage::registry('preparedFilter');

        if ($column->getId() === 'store_id') {
            $this->getCollection()->addFieldToFilter('main_table.' . $column->getId(), array('eq' => $column->getFilter()->getValue()));
            return $this;
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    } // protected function _addColumnFilterToCollection($column) {


    protected function _prepareCollection() {

        $model = Mage::getModel('fourzerofour/regexp');
        $collection = $model->getCollection();
        $collection->getSelect()
            ->join('core_store', 'main_table.store_id = core_store.store_id', array('name'));
        $this->setCollection($collection);
        return parent::_prepareCollection();

    } // protected function _prepareCollection() {


    protected function _prepareColumns() {

        $this->addColumn('regexp_id', array(
            'header' => Mage::helper('fourzerofour')->__('ID'),
            'align' => 'left',
            'index' => 'regexp_id',
        ));

        $this->addColumn('reg_expression', array(
            'header' => Mage::helper('fourzerofour')->__('Regular expression'),
            'align' => 'left',
            'index' => 'reg_expression',
        ));

        $this->addColumn('target_path', array(
            'header' => Mage::helper('fourzerofour')->__('Target Path:'),
            'align' => 'left',
            'index' => 'target_path',
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

    } // protected function _prepareColumns() {


    protected function _prepareMassaction() {

        $this->setMassactionIdField('regexp_id');
        $this->getMassactionBlock()->setFormFieldName('regexpsIds');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('fourzerofour')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('fourzerofour')->__('Are you sure?')
        ));

        return $this;

    } // protected function _prepareMassaction() {


    public function getRowUrl($row) {

        return $this->getUrl('*/*/edit', array('id' => $row->getId()));

    } // public function getRowUrl($row)


}
