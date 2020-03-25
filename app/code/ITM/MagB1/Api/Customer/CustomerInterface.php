<?php
namespace ITM\MagB1\Api\Customer;

interface CustomerInterface
{

    /**
     * Get Attribute list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Customer\Api\Data\CustomerSearchResultsInterface
     */
    public function getCustomerList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
    
}
