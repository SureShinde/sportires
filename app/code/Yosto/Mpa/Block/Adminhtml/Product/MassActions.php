<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Mpa\Block\Adminhtml\Product;


use Magento\Eav\Model\AttributeRepository;
use Magento\Framework\View\Element\Template;
use Yosto\Mpa\Model\Config\Source\CategoryTree;

/**
 * Class MassActions
 * @package Yosto\Mpa\Block\Adminhtml\Product
 */
class MassActions extends \Magento\Framework\View\Element\Template
{
    /**
     * @var CategoryTree
     */
    protected $_categoryTree;

    /**
     * @var AttributeRepository
     */
    protected $_eavAttributeRepository;

    /**
     * @var \Magento\Eav\Model\Entity\Attribute\SetFactory
     */
    protected $_attributeSetFactory;

    /**
     * MassActions constructor.
     * @param CategoryTree $categoryTree
     * @param Template\Context $context
     * @param AttributeRepository $attributeRepository
     * @param \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory
     * @param array $data
     */
    public function __construct(
        CategoryTree $categoryTree,
        Template\Context $context,
        AttributeRepository $attributeRepository,
        \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory,
        array $data = []
    ) {
        $this->_categoryTree = $categoryTree;
        $this->_eavAttributeRepository = $attributeRepository;
        $this->_attributeSetFactory = $attributeSetFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getCategoryTree()
    {
        return $this->_categoryTree->toOptionArray();
    }

    /**
     * @return array
     */
    public function getTextAttributes()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $searchCriteriaBuilder = $objectManager->create(\Magento\Framework\Api\SearchCriteriaBuilder::class);
        $searchCriteria = $searchCriteriaBuilder->addFilter(
            'frontend_input',
            ['text', 'textarea'],
            'in'
        )->create();
        $attributes = $this->_eavAttributeRepository->getList(\Magento\Catalog\Model\Product::ENTITY, $searchCriteria);
        $attributeArray = [];
        $excludedAttribute = ["category_ids", "tier_price", "sku"];
        foreach ($attributes->getItems() as $attribute) {
            $attributeCode = $attribute->getAttributeCode();
            if (in_array($attributeCode, $excludedAttribute) ) {
                continue;
            }
            if (!$attribute->getDefaultFrontendLabel()) {
                continue;
            }
            $attributeArray[$attributeCode] = $attribute->getDefaultFrontendLabel();
        }

        return $attributeArray;
    }

    /**
     * @return array
     */
    public function getAttributeSet()
    {
        $collection = $this->_attributeSetFactory->create()->getCollection()->addFieldToFilter('entity_type_id', 4);

        $attributeSetArray = [];

        foreach ($collection->getItems() as $set) {
            $attributeSetArray[$set->getData('attribute_set_id')] = $set->getData('attribute_set_name');
        }

        return $attributeSetArray;
    }

    public function getAllStores()
    {
        $stores = $this->_storeManager->getStores();
        return $stores;
    }
}