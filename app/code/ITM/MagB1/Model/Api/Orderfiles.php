<?php
    
namespace ITM\MagB1\Model\Api;
    
use ITM\MagB1\Api\OrderfilesInterface;
                
class Orderfiles implements OrderfilesInterface
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
        $collection = $this->_objectManager->create('\ITM\MagB1\Model\ResourceModel\Orderfiles\Collection');
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
        $collection = $this->_objectManager->create('\ITM\MagB1\Model\ResourceModel\Orderfiles\Collection');
        $collection->addFieldToFilter("entity_id", $entity->getId());
        $item = $collection->getFirstItem();
        $model = $this->_objectManager->create('ITM\MagB1\Model\Orderfiles');
        
        if ($item->getEntityId()) {
            $model->load($item->getEntityId());
        }
            
        if ($entity->getPath()!="") {
            $file = base64_decode($entity->getPath());
            $timeStamp = time();
            
            $file_name = $timeStamp."_".$fileName;
            
            $destinationPath= $this->getDestinationPath()."/store_".$entity->getStoreId()."/".md5($entity->getIncrementId())."/";
            
            $path = $destinationPath.$file_name;
            
            //Create the folder if not existed.
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $result = file_put_contents($path, $file, FILE_APPEND);
            $model->setPath($file_name);
        }
        
        $model->setIncrementId($entity->getIncrementId());
        $model->setDescription($entity->getDescription());
        $model->setStoreId($entity->getStoreId());
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
    public function delete($increment_id)
    {
        try {
            $model = $this->_objectManager->create('ITM\MagB1\Model\Orderfiles');
            $collection=$model->getCollection()->addFieldToFilter("increment_id", $increment_id)
            //->addFieldToFilter("store_id", $store_id)
            ;
            
            $destinationRootPath = $this->getDestinationPath();
            //$destinationPath = $this->getDestinationPath() ."store_". $store_id. "/".md5($increment_id)."/";
            
            
            
          
            
            foreach ($collection as $item) {
                $destinationPath = $destinationRootPath."store_". $item->getData("store_id"). "/".md5($increment_id)."/";
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
        return $this->helper->getOrderFilesPath();
    }
}
