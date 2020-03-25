<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Block\Adminhtml\Profile\Ui\Form\Product;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    public $collectionFactory;

    /**
     * @var string
     */
    protected $_template = 'Ced_Claro::widget/grid/extended.phtml';

    protected $_coreRegistry;

    protected $_objectManager;

    protected $_massactionBlockName =
        \Ced\Claro\Block\Adminhtml\Profile\Ui\Form\Product\Widget\Massaction\Extended::class;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Ced\Claro\Model\ResourceModel\Profile\CollectionFactory $collectionFactory
    ) {
        $this->_coreRegistry = $registry;
        $this->_objectManager = $objectManager;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper);
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('asc');
        $this->setId('claro_profile_product');
        $this->_massactionBlockName =
            \Ced\Claro\Block\Adminhtml\Profile\Ui\Form\Product\Widget\Massaction\Extended::class;
        $this->setDefaultFilter(['massaction' => 1]);
        $this->setUseAjax(true);
    }

    public function getGridUrl()
    {
        return $this->getUrl(
            '*/*/product_grid',
            ['_secure' => true, '_current' => true]
        );
    }

    public function isPartUppercase($string)
    {
        return (bool)preg_match('/[A-Z]/', $string);
    }

    public function filterCategory($collection, $column)
    {
        $value = $column->getFilter()->getValue();
        $_category = $this->_objectManager->create(\Magento\Catalog\Model\Category::class)->load($value);
        $collection->addCategoryFilter($_category);
        return $collection;
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'massaction') {
            $inProfileIds = $this->getProducts();
            $inProfileIds = array_filter($inProfileIds);
            if (empty($inProfileIds)) {
                $inProfileIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $inProfileIds]);
            } elseif ($inProfileIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $inProfileIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    public function getProducts($json = false)
    {

        if ($this->getRequest()->getParam('in_profile_products') != "") {
            return $this->getRequest()->getParam('in_profile_products');
        }

        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $profileId = $this->getRequest()->getParam('id');

        $products = $this->_objectManager->create(\Magento\Catalog\Model\Product::class)
            ->getCollection()
            ->addAttributeToFilter(\Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID, $profileId)
            ->getAllIds();

        if (sizeof($products) > 0) {
            if ($json) {
                $jsonProducts = [];
                foreach ($products as $productId) $jsonProducts[$productId] = 0;
                return json_encode((object)$jsonProducts);
            } else {
                return array_values($products);
            }
        } else {
            if ($json) {
                return '{}';
            } else {
                return [];
            }
        }
    }

    protected function _prepareCollection()
    {
        $profileid = $this->getRequest()->getParam('id');
        $conditionCheckbox = $this->getRequest()->getParam('conditionCheckbox');
        $this->_coreRegistry->register('Id', $profileid);

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->_objectManager->create(\Magento\Catalog\Model\Product::class)
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('visibility', ['neq' => 1])
            ->addAttributeToFilter('type_id', ['simple', 'configurable']);
        if ($conditionCheckbox == 'check') {
            $profileIds = $this->collectionFactory->create()->getAllIds();
            $profileIds = array_flip($profileIds);
            unset($profileIds[$profileid]);
            $profileIds = array_flip($profileIds);
            $collection->addAttributeToFilter(
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID,
                ['nin' => $profileIds]
            );
        } elseif ($conditionCheckbox == 'uncheck') {
            $collection->clear()->resetData();
        }

        if (true) {
            $collection->joinField(
                'qty',
                $collection->getTable('cataloginventory_stock_item'),
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1 AND {{table}}.website_id=0',
                'left'
            );
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => __('Product Id'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'entity_id',
                'filter_index' => 'entity_id',
                'type' => 'number',
            ]
        );

        $this->addColumn(
            'name',
            [
                'header' => __('Product Name'),
                'align' => 'left',
                'type' => 'text',
                'index' => 'name',
                'filter_index' => 'name',
            ]
        );
        $this->addColumn(
            'type_id',
            [
                'header' => __('Type'),
                'align' => 'left',
                'index' => 'type_id',
                'type' => 'options',
                'options' => $this->_objectManager->get(\Magento\Catalog\Model\Product\Type::class)
                    ->getOptionArray(),
                'header_css_class' => 'col-group',
                'column_css_class' => 'col-group'
            ]
        );

        $this->addColumn(
            'category',
            [
                'header' => __('Category'),
                'index' => 'category',
                'sortable' => false,
                'type' => 'options',
                'options' => $this->_objectManager->create(\Ced\Claro\Model\Source\Category::class)
                    ->getAllOptions(),
                'renderer' => \Ced\Claro\Block\Adminhtml\Profile\Ui\Form\Product\Renderer\Category::class,
                'filter_condition_callback' => array($this, 'filterCategory'),
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'align' => 'left',
                'index' => 'status',
                'filter_index' => 'status',
                'type' => 'options',
                'options' => $this->_objectManager->get(\Magento\Catalog\Model\Product\Attribute\Source\Status::class)
                    ->getOptionArray(),
            ]
        );

        $attributeSet = $this->_objectManager->get(\Magento\Catalog\Model\Product\AttributeSet\Options::class)
            ->toOptionArray();
        $values = [];
        foreach ($attributeSet as $val) {
            $values[$val['value']] = $val['label'];
        }

        $this->addColumn(
            'set_name',
            [
                'header' => __('Attrib. Set Name'),
                'align' => 'left',
                'index' => 'attribute_set_id',
                'filter_index' => 'attribute_set_id',
                'type' => 'options',
                'options' => $values,
            ]
        );

        $this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'align' => 'left',
                'type' => 'text',
                'index' => 'sku',
                'filter_index' => 'sku',
            ]
        );

        $store = $this->_storeManager->getStore();
        $this->addColumn(
            'price',
            [
                'header' => __('Price '),
                'align' => 'left',
                'type' => 'price',
                'currency_code' => $store->getBaseCurrency()->getCode(),
                'index' => 'price',
                'filter_index' => 'price',
            ]
        );

        $this->addColumn(
            'qty',
            [
                'header' => __('QTY'),
                'align' => 'left',
                'type' => 'number',
                'index' => 'qty',
                'filter_index' => 'qty',
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return array
     */
    protected function _getSelectedProducts()
    {
        $products = $this->getRequest()->getPost('selected_products');
//        $products = $this->getRequest()->getPost('internal_in_profile_products');
        return $products;
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('in_profile_products');
        $this->getMassactionBlock()->setFormFieldName('in_profile_products');

        $this->getMassactionBlock()->addItem(
            'addproduct',
            [
                'label' => __('Add Products'),
                'url' => ''//$this->getUrl('claro/profile/save'),
            ]
        );
        return $this;
    }
}
