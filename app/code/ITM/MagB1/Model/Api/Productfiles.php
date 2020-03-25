<?php
    
namespace ITM\MagB1\Model\Api;
    
use ITM\MagB1\Api\ProductfilesInterface;

class Productfiles implements ProductfilesInterface
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
    public function __construct(
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \ITM\MagB1\Helper\Data $dataHelper
    ) {
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
        $collection = $this->_objectManager->create('\ITM\MagB1\Model\ResourceModel\Productfiles\Collection');
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
        $collection = $this->_objectManager->create('\ITM\MagB1\Model\ResourceModel\Productfiles\Collection');
        $collection->addFieldToFilter("entity_id", $entity->getEntityId());
        $item = $collection->getFirstItem();
        $model = $this->_objectManager->create('ITM\MagB1\Model\Productfiles');
        if ($item->getEntityId()) {
            $model->load($item->getEntityId());
        }
       // save File
        if ($entity->getPath()!="") {
            $file = base64_decode($entity->getPath());
            $timeStamp = time();
            
            $file_name = $timeStamp."_".$fileName;
            
            $destination = $this->getDestinationPath().$entity->getSku()."/";
            $path = $destination.$file_name;
          
            //Create the folder if not existed.
            if (!is_dir($destination)) {
                mkdir($destination, 0777, true);
            }
            $result = file_put_contents($path, $file, FILE_APPEND);
            $model->setPath($file_name);
        }
        // End File
        $model->setSku($entity->getSku());
        $model->setDescription($entity->getDescription());
        $model->setStoreId($entity->getStoreId());
        $model->setPosition($entity->getPosition());
        $model->setStatus($entity->getStatus());
        $model->save();
        return $model;
    }
    
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function delete($sku, $store_id)
    {
        try {
            $model = $this->_objectManager->create('ITM\MagB1\Model\Productfiles');
            $collection=$model->getCollection()->addFieldToFilter("sku", $sku)
                                   ->addFieldToFilter("store_id", $store_id);
            $destination=$this->getDestinationPath().$sku."/";
            foreach ($collection as $item) {
                $file_name_path = $destination.$item->getPath();
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
        return $this->helper->getProductFilesPath();
    }
}
