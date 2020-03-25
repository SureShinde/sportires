<?php
/**
* CedCommerce
*
* NOTICE OF LICENSE
*
* This source file is subject to the End User License Agreement (EULA)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://cedcommerce.com/license-agreement.txt
*
* @category    Ced
* @package     Ced_StorePickup
* @author      CedCommerce Core Team <connect@cedcommerce.com >
* @copyright   Copyright CEDCOMMERCE (https://cedcommerce.com/)
* @license      https://cedcommerce.com/license-agreement.txt
*/
namespace Ced\StorePickup\Block\Adminhtml\Stores;

class Stores extends \Magento\Backend\Block\Widget\Grid\Extended
{
    
    protected $moduleManager;

    /**
     * @var \Ced\Learn\Model\BlogPostsFactory
     */
    protected $_storesFactory;

    /**
     * @var \Ced\Learn\Model\Status
     */
    protected $_status;

    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Ced\StorePickup\Model\StoreInfoFactory $_storesFactory,
        \Ced\StorePickup\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        
        $this->_storesFactory = $_storesFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postsGrid');
        $this->setDefaultSort('pickup_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('post_filter');
    }

    
    protected function _prepareCollection()
    {

        $collection = $this->_storesFactory->create()->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    
    protected function _prepareColumns()
    {
        $this->addColumn(
            'pickup_id',
            [
            'header' => __('ID'),
            'type' => 'number',
            'index' => 'pickup_id',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
            ]
        );
        
        $this->addColumn(
            'store_name',
            [
            'header' => __('Store Name'),
            'index' => 'store_name',
            'class' => 'xxx'
            ]
        );
        
        $this->addColumn(
            'store_manager_name',
            [
            'header' => __('Store Manager Name'),
            'index' => 'store_manager_name',
            'class' => 'xxx'
            ]
        );
        
        $this->addColumn(
            'store_manager_email',
            [
            'header' => __('Store Manager Email'),
            'index' => 'store_manager_email',
            'class' => 'xxx'
            ]
        );
        
        $this->addColumn(
            'is_active',
            [
            'header' => __('Status'),
            'index' => 'is_active',
            'type' => 'options',
            'options' => $this->_status->getOptionArray()
            ]
        );
        
        $this->addColumn(
            'edit',
            [
            'header' => __('Edit'),
            'type' => 'action',
            'getter' => 'getId',
            'actions' => [
            [
            'caption' => __('Edit'),
            'url' => [
            'base' => '*/*/edit'
            ],
            'field' => 'pickup_id'
            ]
            ],
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'header_css_class' => 'col-action',
            'column_css_class' => 'col-action'
            ]
        );
        
        return parent::_prepareColumns();
        
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}