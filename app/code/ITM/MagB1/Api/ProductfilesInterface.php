<?php
        
namespace ITM\MagB1\Api;
        
interface ProductfilesInterface
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
     * @param ITM\MagB1\Api\Data\ProductfilesDataInterface $entity.
     * @param string $fileName.
     * @return ITM\MagB1\Api\Data\ProductfilesDataInterface
     */
    public function save($entity, $fileName);
    
    /**
     * @param string $sku
     * @param int $store_id
     * @return bool Will returned true if deleted
     */
    public function delete($sku, $store_id);
}
