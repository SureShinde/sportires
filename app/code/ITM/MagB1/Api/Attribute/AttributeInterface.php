<?php

namespace ITM\MagB1\Api\Attribute;

interface AttributeInterface
{
    /**
     * Get Customer Attribute list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getCustomerAttributeList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
    
    /**
     * Get Product Attribute list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getProductAttributeList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Get Customer Attribute list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getCustomerAttributeSetGroupAttributes(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );
 
    /**
     * Get Product Attribute list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getProductAttributeSetGroupAttributes(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );
    
    /**
     * Get Customer Attribute Set List
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getCustomerAttributeSet();
    
    /**
     * Get Product Attribute Set list
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getProductAttributeSet();
    
    /**
     * update option to attribute
     *
     * @param string $attribute_code
     * @param string $entity_type
     * @param \Magento\Eav\Api\Data\AttributeOptionInterface $option
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\InputException
     * @return bool
     */
    public function updateAttributeOptionLabels($attribute_code, $entity_type, $option);
}
