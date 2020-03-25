<?php
    
namespace ITM\MagB1\Block\Adminhtml\Shipmentfiles;
    
use ITM\MagB1\Model\System\Config\Status;
use Magento\Framework\Exception;
    
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
     
    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $_status;
    protected $_collectionFactory;
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $setsFactory
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $status
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \ITM\MagB1\Model\ResourceModel\Shipmentfiles\CollectionFactory $collectionFactory,
        //\ITM\MagB1\Model\ResourceModel\Shipmentfiles\Collection $collectionFactory,
        Status $status,
        array $data = []
    ) {

        $this->_status = $status;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {

        parent::_construct();
        $this->setId('shipmentfilesGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
    }
                
    /**
     * @return Store
     */
    protected function _getStore()
    {
        $storeId =(int )$this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }
                
    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        //$collection = $this->_collectionFactory->load();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
                
    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {

        $this->addColumn('entity_id', [
            'header' => __('ID'),
            'type' => 'number',
            'index' => 'entity_id',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
        ]);
        
        $this->addColumn('increment_id', [
            'header' => __('Increment ID'),
            'index' => 'increment_id',
            'class' => 'increment_id'
            ]);

        $this->addColumn('path', [
            'header' => __('Path'),
            'index' => 'path',
            'class' => 'path'
            ]);

        $this->addColumn('description', [
            'header' => __('Description'),
            'index' => 'description',
            'class' => 'description'
            ]);

        $this->addColumn('store_id', [
            'header' => __('Store View'),
            'index' => 'store_id',
            'type' => 'store',
            'store_all' => true,
            'store_view' => true,
            'sortable' => false,
            'filter_condition_callback' => [$this, '_filterStoreCondition']
        ]);

        $this->addColumn('position', [
            'header' => __('Position'),
            'index' => 'position',
            'class' => 'position'
            ]);
                
        $this->addColumn('status', [
            'header' => __('Status'),
            'index' => 'status',
            'class' => 'status',
            'type' => 'options',
            'options' => $this->_status->toOptionArray()
        ]);
        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }
        return parent::_prepareColumns();
    }
                
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_id');
        $this->getMassactionBlock()->addItem('delete', [
            'label' => __('Delete'),
            'url' => $this->getUrl('itm_magb1/*/massDelete'),
            'confirm' => __('Are you sure?')
        ]);
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('itm_magb1/*/index', ['_current' => true]);
    }
    
    /**
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('itm_magb1/*/edit', [
            'store' => $this->getRequest()->getParam('store'),
            'id' => $row->getEntityId()
        ]);
    }
    /**
     * Filter store condition
     *
     * @param \Magento\Framework\Data\Collection $collection
     * @param \Magento\Framework\DataObject $column
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _filterStoreCondition($collection, \Magento\Framework\DataObject $column)
    {
        if (!($value = $column->getFilter()->getValue())) {
            return;
        }
        
        $this->getCollection()->addFieldToFilter("store_id", $value);
    }
}
