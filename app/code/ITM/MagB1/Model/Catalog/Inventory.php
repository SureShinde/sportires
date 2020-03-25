<?php
namespace ITM\MagB1\Model\Catalog;

use ITM\MagB1\Api\Catalog\InventoryInterface;

class Inventory implements InventoryInterface
{
    
    /**
     *
     * @var \Magento\Framework\Api\SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    
    private $resource;
    
    /**
     *
     * @param
     *            * @var \Magento\Framework\Api\SearchResultsInterfaceFactory
     */
    public function __construct(
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\App\ResourceConnection $resource
        )
    {
        $this->searchResultsFactory = $searchResultsFactory;
        $this->resource = $resource;
    }
    /**
     *
     * {@inheritdoc}
     *
     */
    public function getListOLD(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /* Get instance of object manager */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollection->create();
        
        
        $collection->getSelect()->reset(\Magento\Framework\DB\Select::COLUMNS)
        ->columns(array('entity_id as id','sku'));
        
        $collection
        ->getSelect()
        ->joinLeft(
            ['stock' => $this->resource->getTableName('cataloginventory_stock_item')],
            'stock.product_id = e.entity_id',
            ['stock.qty']
            );
        
        $select = (string) $collection->getSelect();
        
        
        $resource =  $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $result = $connection->fetchAll($select);
        
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($result);
        $searchResult->setTotalCount(count($result));
        return $searchResult;
    }
    /**
     *
     * {@inheritdoc}
     *
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /* Get instance of object manager */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        
        /* Get Stock Registry */
        $stockRegistry = $objectManager->get('Magento\CatalogInventory\Api\StockRegistryInterface');
        
        $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        
        $collection = $productCollection->create();
        
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        
        $collection->getSelect()->reset(\Magento\Framework\DB\Select::COLUMNS)
        ->columns(array('entity_id as id','sku','type_id'));
        
        $collection
        ->getSelect()
        ->joinLeft(
            ['stock' => $this->resource->getTableName('cataloginventory_stock_item')],
            'stock.product_id = e.entity_id',
            ['stock.qty']
            );
        
        // Add filters from root filter group to the collection
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        /** @var SortOrder $sortOrder */
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $field = $sortOrder->getField();
            $collection->addOrder($field, ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC');
        }
        
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        
        
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getData());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }
}
