<?php

namespace ITM\MagB1\Api;

interface CustomerfilesInterface
{

    /**
     * Get list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     *
     * @api
     * @param ITM\MagB1\Api\Data\CustomerfilesDataInterface $entity.
     * @param string $fileName.
     * @return ITM\MagB1\Api\Data\CustomerfilesDataInterface
     */
    public function save($entity, $fileName);

    /**
     * @param int $customer_id
     * @return bool Will returned true if deleted
     */
    public function deleteByCustomerId($customer_id);
}
