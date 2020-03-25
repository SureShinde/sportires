<?php
    
namespace ITM\Sportires\Block\Adminhtml\Vehicletire;
    
use ITM\Sportires\Model\System\Config\Status;
use ITM\Sportires\Model\System\Config\Attributeoption;
use Magento\Framework\Exception;
    
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
     
    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $_status;
    protected $_collectionFactory;
	protected $_attributeoption;
    
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
        \ITM\Sportires\Model\ResourceModel\Vehicletire\CollectionFactory $collectionFactory,
        //\ITM\Sportires\Model\ResourceModel\Vehicletire\Collection $collectionFactory,
        Status $status,
		Attributeoption $attributeoption,
        array $data = []
    ) {

        $this->_status = $status;
		$this->_attributeoption = $attributeoption;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {

        parent::_construct();
        $this->setId('vehicletireGrid');
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
        
        $this->addColumn('make', [
            'header' => __('Make'),
            'index' => 'make',
            'class' => 'make'
            ]);

        $this->addColumn('year', [
            'header' => __('Year'),
            'index' => 'year',
            'class' => 'year'
            ]);

        $this->addColumn('model', [
            'header' => __('Model'),
            'index' => 'model',
            'class' => 'model'
            ]);

        $this->addColumn('trim', [
            'header' => __('Trim'),
            'index' => 'trim',
            'class' => 'trim'
            ]);

       /* $this->addColumn('front_width', [
            'header' => __('Front Width'),
            'index' => 'front_width',
            'class' => 'front_width',
			'type' => 'options',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_width")
            ]);

        $this->addColumn('front_ratio', [
            'header' => __('Front Ratio'),
            'index' => 'front_ratio',
            'class' => 'front_ratio',
			'type' => 'options',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_ratio")
            ]);

        $this->addColumn('front_diameter', [
            'header' => __('Front Diameter'),
            'index' => 'front_diameter',
            'class' => 'front_diameter',
			'type' => 'options',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_diameter")
            ]);

        $this->addColumn('rear_width', [
            'header' => __('Rear Width'),
            'index' => 'rear_width',
            'class' => 'rear_width',
			'type' => 'options',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_width")
            ]);

        $this->addColumn('rear_ratio', [
            'header' => __('Rear Ratio'),
            'index' => 'rear_ratio',
            'class' => 'rear_ratio',
			'type' => 'options',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_ratio")
			
            ]);

        $this->addColumn('rear_diameter', [
            'header' => __('Rear Diameter'),
            'index' => 'rear_diameter',
            'class' => 'rear_diameter',
			'type' => 'options',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_diameter")
            ]);
        */
        $this->addColumn('front_width', [
            'header' => __('Front Width'),
            'index' => 'front_width',
            'class' => 'front_width'
        ]);

        $this->addColumn('front_ratio', [
            'header' => __('Front Ratio'),
            'index' => 'front_ratio',
            'class' => 'front_ratio'
        ]);

        $this->addColumn('front_diameter', [
            'header' => __('Front Diameter'),
            'index' => 'front_diameter',
            'class' => 'front_diameter'
        ]);

        $this->addColumn('rear_width', [
            'header' => __('Rear Width'),
            'index' => 'rear_width',
            'class' => 'rear_width'
        ]);

        $this->addColumn('rear_ratio', [
            'header' => __('Rear Ratio'),
            'index' => 'rear_ratio',
            'class' => 'rear_ratio'
        ]);

        $this->addColumn('rear_diameter', [
            'header' => __('Rear Diameter'),
            'index' => 'rear_diameter',
            'class' => 'rear_diameter'
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
            'url' => $this->getUrl('itm_sportires/*/massDelete'),
            'confirm' => __('Are you sure?')
        ]);
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('itm_sportires/*/index', ['_current' => true]);
    }
    
    /**
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('itm_sportires/*/edit', [
            'store' => $this->getRequest()->getParam('store'),
            'id' => $row->getEntityId()
        ]);
    }
}
