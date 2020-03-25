<?php
    
namespace ITM\MagB1\Model\Api;
    
use ITM\MagB1\Api\CustomerfilesInterface;
                
class Customerfiles implements CustomerfilesInterface
{
    
    /**
     *
     * @var \Magento\Framework\Api\SearchResultsInterfaceFactory
     */
    protected $_searchResultsFactory;
    
    protected $_objectManager;
    
    protected $helper;
    
    /**
     *
     * @param \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(\Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \ITM\MagB1\Helper\Data $dataHelper
        )
    {
        $this->helper = $dataHelper;
        $this->_searchResultsFactory = $searchResultsFactory;
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }
                
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->_objectManager->create('\ITM\MagB1\Model\ResourceModel\Customerfiles\Collection');
        $result=$collection->getData();
        $searchResult = $this->_searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($result);
        $searchResult->setTotalCount(count($result));
        return $searchResult;
    }
    
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function save($entity, $fileName)
    {
        $collection = $this->_objectManager->create('\ITM\MagB1\Model\ResourceModel\Customerfiles\Collection');
        $collection->addFieldToFilter("entity_id", $entity->getId());
        $item = $collection->getFirstItem();
        $model = $this->_objectManager->create('ITM\MagB1\Model\Customerfiles');
        
        if ($item->getEntityId()) {
            $model->load($item->getEntityId());
        }
            
        if ($entity->getPath()!="") {
            $file = base64_decode($entity->getPath());
            $timeStamp = time();
            
            $file_name = $timeStamp."_".$fileName;
            
            $destinationPath= $this->getDestinationPath()."/".$entity->getCustomerId()."/";
            
            $path = $destinationPath.$file_name;
            
            //Create the folder if not existed.
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $result = file_put_contents($path, $file, FILE_APPEND);
            $model->setPath($file_name);
        }
        
        
        $model->setCustomerId($entity->getCustomerId());
        $model->setDescription($entity->getDescription());
        $model->setPosition($entity->getPosition());
        $model->save();
            
        return $model;
    }
    
   
    
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function deleteByCustomerId($customer_id)
    {
        try {
            $model = $this->_objectManager->create('ITM\MagB1\Model\Customerfiles');
            $collection=$model->getCollection()->addFieldToFilter("customer_id", $customer_id)
            ;
            
            $destinationPath = $this->getDestinationPath() . "/".$customer_id."/";
            
            
            
            foreach ($collection as $item) {
                $file_name_path = $destinationPath.$item->getPath();
                $file_name = $item->getPath();
                if (file_exists($file_name_path) && $file_name !="") {
                    unlink($file_name_path);
                }
                $item->delete();
            }
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }
    
    private function getDestinationPath()
    {
        return $this->helper->getCustomerFilesPath();
    }
}
