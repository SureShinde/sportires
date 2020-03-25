<?php
namespace ITM\MagB1\Model\Entity;

use ITM\MagB1\Api\Entity\EntityInterface;
use ITM\MagB1\Model\EntityLineData;
use ITM\MagB1\Model\EntityLineColumnData;

class Entity implements EntityInterface
{

    private $logger;

    private $objectManager;

    /**
     * Factory constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\ObjectManagerInterface $objectManager
    )
    {
        $this->logger = $logger;
        $this->objectManager = $objectManager;
    }
    private function getCollection($model_name)
    {
        $model_name_factory  = $this->getModelCollectionFactory($model_name);
        $collectionFactory = $this->objectManager->get($model_name_factory);
        $collection =  $collectionFactory->create();
        return $collection;
    }
    private function saveLine($primary_code, $model_name, $line)
    {
        $model_name = $this->getModelName($model_name);
        $model = $this->objectManager->create($model_name);

        $collection = $this->getCollection($model_name);
        
        $columns = $line->getColumns();
        
        $codes_name = explode(",", $primary_code);
        $primary_string_array = [];

        foreach ($columns as $column) {
            if (in_array($column->getColumnName(), $codes_name)) {
                $collection->addFieldToFilter($column->getColumnName(), $column->getColumnValue());
                $primary_string_array[] = $column->getColumnName()." = ".$column->getColumnValue();
            }
        }
        $collection->setCurPage(1);
        $collection->setPageSize(1);
        $model = $collection->getFirstItem();

        if ($model->getId()) {
            $model->load($model->getId());
        }
        
        foreach ($columns as $column) {
            if ($model->getId() && in_array($column->getColumnName(), $codes_name)) {
                continue;
            }
            
            $model->setData($column->getColumnName(), $column->getColumnValue());
        }

        try {
            $model->save();
        }catch (\Exception $e) {
            return $e->getMessage(). " Primary Code= ".implode("&", $primary_string_array);
        }
        return $model->getId();
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function saveEntity($entity)
    {
        $primary_code = $entity->getPrimaryCode();
        $model_name = $entity->getModelName();
        $lines = $entity->getLines();
        $ids = [];
        
        try {
            foreach ($lines as $line) {
                $ids[] = $this->saveLine($primary_code, $model_name, $line);
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        
        return $ids;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getList($cur_page, $page_size, $model_name)
    {
        $entity_model_name = $this->getModelEntityName($model_name);
        $model_name_factory  = $this->getModelCollectionFactory($model_name);

        $collectionFactory = $this->objectManager->get($model_name_factory);
        $collection =  $collectionFactory->create();

        if(method_exists($entity_model_name,"getEntityType")) {
            $entityType = $this->objectManager
                ->get($entity_model_name)
                ->getEntityType(\Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE);

            if ($entityType) {
                $collection->addAttributeToSelect("*");
            }
        }
        if ($page_size > 0) {
            $collection->setPageSize($page_size);
        }
        if ($cur_page > 0) {
            $collection->setCurPage($cur_page);
        }
        $result = [];
        foreach ($collection as $item) {
            $line = $this->objectManager->create("\ITM\MagB1\Model\EntityLineData");
            $columns = [];
            $data = $item->getData();
            
            foreach ($data as $key => $value) {
                if(is_array($value) ) {
                    continue;
                }
                $col =  $this->objectManager->create("\ITM\MagB1\Model\EntityLineColumnData");
                $col->setColumnName($key);
                $col->setColumnValue($value);
                $columns[] = $col;
            }
            
            $line->setColumns($columns);
            $result[] = $line;
        }
        return $result;
    }

    public function  getModelCollectionFactory($model_name) {

        $model_name = str_replace("_", "\\", $model_name);
        $model_name = str_replace("Model", "Model\\ResourceModel", $model_name);
        $model_name .= "\CollectionFactory";
        return $model_name;
    }
    public function  getModelName($model_name) {

        $model_name = str_replace("_", "\\", $model_name);
        return $model_name;
    }
    public function  getModelEntityName($model_name) {

        $model_name = str_replace("_", "\\", $model_name);
        $model_name = str_replace("Model", "Model\\ResourceModel", $model_name);
        return $model_name;
    }
    /**
     *
     * {@inheritdoc}
     *
     */
    public function getCollectionCount($model_name)
    {
        $collection = $this->getCollection($model_name);
        return $collection->getSize();
    }

    private function deleteEntityLineByKey($primary_code, $model_name, $line)
    {
        $collection = $this->getCollection($model_name);
        $columns = $line->getColumns();

        $codes_name = explode(",", $primary_code);
        $primary_string_array = [];

        foreach ($columns as $column) {
            if (in_array($column->getColumnName(), $codes_name)) {
                $collection->addFieldToFilter($column->getColumnName(), $column->getColumnValue());
            }
        }
        foreach ($collection as $item) {
            $item->delete();
        }

        return true;
    }
    /**
     *
     * {@inheritdoc}
     *
     */
    public function deleteEntityByKey($entity)
    {
        $primary_code = $entity->getPrimaryCode();
        $model_name = $entity->getModelName();
        $lines = $entity->getLines();
        $ids = [];

        try {
            foreach ($lines as $line) {
                $ids[] = $this->deleteEntityLineByKey($primary_code, $model_name, $line);
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        return $ids;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function deleteEntity($model_name, $ids)
    {
        $restrict_venders = ["Magento"];
        $restrict_venders = array_map('strtolower', $restrict_venders);
        
        $model_name = $this->getModelName($model_name);
        
        $name_spaces = explode("\\", $model_name);
        $vender = strtolower($name_spaces[0]);
        if (in_array($vender, $restrict_venders)) {
            return "Cannot execute delete in this class please contact the developer.";
        }
        
        $model = $this->objectManager->create($model_name);
        foreach ($ids as $id) {
            $model->load($id);
            $model->delete();
        }
        return true;
    }
}
