<?php
namespace ITM\MagB1\Model\Customer;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use ITM\MagB1\Api\Customer\CustomerInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class Customer implements CustomerInterface
{

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;
    
    
    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;
    
    /**
     * @var \Magento\Customer\Api\CustomerMetadataInterface
     */
    protected $customerMetadata;
    
  

    private $resource;

    /**
     *
     * @var \Magento\Framework\Api\SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;


    /**
     * @var  \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $_customerRepository;

    /**
     *
     * @param \Magento\Customer\Api\Data\CustomerSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \Magento\Customer\Api\Data\CustomerSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor,
        \Magento\Customer\Api\CustomerMetadataInterface $customerMetadata,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
       
    ) {
        
        $this->searchResultsFactory = $searchResultsFactory;
        $this->customerFactory = $customerFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->customerMetadata = $customerMetadata;
        $this->resource = $resource;
        $this->_customerRepository = $customerRepository;
    }


    /**
     *
     * {@inheritdoc}
     *
     */
    public function getCustomerList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $searchResult =   $this->_customerRepository->getList($searchCriteria);

        $customers = [];
        /** @var \Magento\Customer\Model\Customer $customerModel */
        $i = 0;
        $connection = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);

        foreach ($searchResult->getItems() as $customerModel) {

            $customer = $customerModel->__toArray();
            $customer["entity_id"] = $customer["id"];
            $sales_order = $connection->select()
                ->from(['entity' => $this->resource->getTableName('sales_order')], ['sum(total_paid) as total_paid','count(*) as order_count']);
            $sales_order->where('entity.customer_id = :customer_id');

            $mbind[':customer_id'] = $customer["entity_id"];
            $result = $connection->fetchAll($sales_order, $mbind);

            $customer["has_orders"] = $result["0"]["order_count"]>0? "1" : "0";
            $customer["has_paid_orders"] = isset($result["0"]["total_paid"])? "1": "0";
            $customers[] = $customer;
            $i++;
        }
        $searchResult->setTotalCount($i);
        $searchResult->setItems($customers);
        return $searchResult;

    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getCustomerListOLD(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
       
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var \Magento\Customer\Model\ResourceModel\Customer\Collection $collection */
        $collection = $this->customerFactory->create()->getCollection();
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Magento\Customer\Api\Data\CustomerInterface::class
            );
        // This is needed to make sure all the attributes are properly loaded
        foreach ($this->customerMetadata->getAllAttributesMetadata() as $metadata) {
            $collection->addAttributeToSelect($metadata->getAttributeCode());
        }
        // Needed to enable filtering on name as a whole
        $collection->addNameToSelect();
       
        //Add filters from root filter group to the collection
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
       
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                    );
            }
        }
        
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $customers = [];
        /** @var \Magento\Customer\Model\Customer $customerModel */
        $i = 0;
        $connection = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        
        foreach ($collection as $customerModel) {
            $customer = $customerModel->getData();

            $sales_order = $connection->select()
            ->from(['entity' => $this->resource->getTableName('sales_order')], ['sum(total_paid) as total_paid','count(*) as order_count']);
            $sales_order->where('entity.customer_id = :customer_id');
            
            $mbind[':customer_id'] = $customer["entity_id"];
            $result = $connection->fetchAll($sales_order, $mbind);
            
            $customer["has_orders"] = $result["0"]["order_count"]>0? "1" : "0";
            $customer["has_paid_orders"] = isset($result["0"]["total_paid"])? "1": "0";
            $customers[] = $customer;
            $i++;
        }
        $searchResults->setTotalCount($i);
        $searchResults->setItems($customers);
        return $searchResults;
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param \Magento\Framework\Api\Search\FilterGroup $filterGroup
     * @param \Magento\Customer\Model\ResourceModel\Customer\Collection $collection
     * @return void
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Magento\Customer\Model\ResourceModel\Customer\Collection $collection
    ) {
        $fields = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = ['attribute' => $filter->getField(), $condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields);
        }
    }


}

