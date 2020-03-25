<?php

namespace ITM\MagB1\Api;

interface ShipmentfilesInterface
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
     * @param ITM\MagB1\Api\Data\ShipmentfilesDataInterface $entity.
     * @param string $fileName.
     * @return ITM\MagB1\Api\Data\ShipmentfilesDataInterface
     */
    public function save($entity, $fileName);

    /**
     * @param string $increment_id
     * @return bool Will returned true if deleted
     */
    public function delete($increment_id);
}
