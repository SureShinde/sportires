<?php
namespace ITM\MagB1\Model\Attribute;

use Magento\Eav\Setup\EavSetupFactory;
use ITM\MagB1\Api\Attribute\AttributeInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class Attribute implements AttributeInterface
{

    private $eavSetupFactory;

    private $setup;

    private $resource;

    /**
     *
     * @var \Magento\Store\Model\ResourceModel\Store\CollectionFactory
     */
    private $storesFactory;

    /**
     *
     * @var \Magento\Framework\Api\SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    
    /**
     * @var \Magento\Eav\Model\AttributeRepository
     */
    protected $attributeRepository;
    
    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute
     */
    protected $resourceModel;
    
    /**
     * @var \Magento\Framework\App\ObjectManager
     */
    protected $objectManager;
    
    /**
     *
     * @param \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        EavSetupFactory $eavSetupFactory,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Store\Model\ResourceModel\Store\CollectionFactory $storesFactory,
        \Magento\Eav\Model\AttributeRepository $attributeRepository,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute $resourceModel
    ) {
        $this->searchResultsFactory = $searchResultsFactory;
        
        $this->eavSetupFactory = $eavSetupFactory;
        $this->resource = $resource;
        $this->storesFactory = $storesFactory;
        $this->attributeRepository = $attributeRepository;
        $this->resourceModel = $resourceModel;
        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // instance of Object manager;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getProductAttributeList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $product_entity_type_id = 4;
        return $this->getAttributeList($searchCriteria, $product_entity_type_id);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getCustomerAttributeList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $customer_entity_type_id = 1;
        return $this->getAttributeList($searchCriteria, $customer_entity_type_id);
    }

    private function getAttributeList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, $entity_type_id)
    {
        $connection = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        
        /* Get instance of object manager */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        
        $collection = $objectManager->create(\Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection::class);
        $collection->addFieldToFilter("entity_type_id", $entity_type_id);
        //$collection->addFieldToFilter("attribute_code", "color");
        
        if ($entity_type_id == "4") {
            $collection->getSelect()->join([
                'l' => $this->resource->getTableName('catalog_eav_attribute')
            ], 'main_table.attribute_id = l.attribute_id', [
                'is_global'
            ]);
        }
        
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->load();
        
        $result = [];
        $eav_attribute_option_table = $this->resource->getTableName('eav_attribute_option');
        $eav_attribute_option_value_table = $this->resource->getTableName('eav_attribute_option_value');
        
        foreach ($collection as $item) {
            $temp_arr = $item->getData();
            
            $options = [];
            if ($item->getData("frontend_input") == "select" || $item->getData("frontend_input") == "multiselect") {
                $source_model = $item->getData('source_model');
                if ($source_model == "Magento\Customer\Model\Customer\Attribute\Source\Store") {
                    // do nothing
                    $store_collection = $this->createStoresCollection();
                    $store_collection->setWithoutDefaultFilter();
                    
                    foreach ($store_collection as $store_item) {
                        $options[] = [
                            'option_id' => $store_item->getStoreId(),
                            'value' => $store_item->getName(),
                            'names' => []
                        ];
                    }
                } elseif ($source_model == "Magento\Eav\Model\Entity\Attribute\Source\Table" || $source_model == "") {
                    // Get Options from option table
                    $select = $connection->select()
                    ->from([
                        'entity_option' => $this->resource->getTableName('eav_attribute_option')
                    ], [
                        'option_id','attribute_id'
                    ])
                    ->joinLeft([
                        'entity_option_value' => $this->resource->getTableName('eav_attribute_option_value')
                    ], 'entity_option.option_id = entity_option_value.option_id', [
                        'value','store_id'
                    ]);
                    $bind = [];
                    $bind[':attribute_id'] = $item->getAttributeId();
                    $select->where('entity_option.attribute_id = :attribute_id');
                    $select->order('entity_option_value.store_id');
                    $temp_options =  $connection->fetchAll($select, $bind);
                    // $options = $temp_options;
                    $all_options_names = [];
                    foreach ($temp_options as $_option) {
                        if ($_option["store_id"] != 0) {
                            $all_options_names[$_option["option_id"]][] = ["store_id" => $_option["store_id"], "value"=> $_option["value"]];
                        }
                    }
                    
                    foreach ($temp_options as $_option) {
                        if ($_option["store_id"] == 0) {
                            $option =  [
                                'option_id' => $_option["option_id"],
                                //  'attribute_id' => $_option["attribute_id"],
                                //  'store_id' => $_option["store_id"],
                                'value' => $_option["value"],
                            ];
                            if (isset($all_options_names[$_option["option_id"]])) {
                                $option["names"] = $all_options_names[$_option["option_id"]];
                            }
                            $options[] = $option;
                        }
                    }

                   /*
                   // $options = $temp_options;
                    foreach ($temp_options as $_option) {
                        if ($_option["store_id"] == 0) {
                            $option =  [
                                'option_id' => $_option["option_id"],
                                'attribute_id' => $_option["attribute_id"],
                                'store_id' => $_option["store_id"],
                                'value' => $_option["value"],
                                'names' =>[]
                            ];
                        } else {
                            $options[$_option["option_id"]]["names"][] = ["store_id" => $_option["store_id"], "value"=> $_option["value"]];
                        }
                        $options[$option["option_id"]] = $option;
                    }
                    */
                    
                    /*
                     // old code
                     // Get Options from option table
                     $select = $connection->select()
                     ->from([
                     'entity_option' => $this->resource->getTableName('eav_attribute_option')
                     ], [
                     'option_id'
                     ])
                     ->joinLeft([
                     'entity_option_value' => $this->resource->getTableName('eav_attribute_option_value')
                     ], 'entity_option.option_id = entity_option_value.option_id', [
                     'value'
                     ]);
                     $bind = [];
                     $bind[':attribute_id'] = $item->getAttributeId();
                     $select->where('entity_option.attribute_id = :attribute_id');
                     $select->order('entity_option_value.store_id');
                     $options = $connection->fetchAll($select, $bind);
                     */
                    
                } elseif ($source_model != "") {
                    // Start
                    $model_options = $objectManager->create($source_model)->getAllOptions(1);
                            
                    foreach ($model_options as $model_option) {
                        if(is_array($model_option['value'])) {
                            $values = $model_option['value'];
                            $text = $model_option['label'];
                            foreach ($values as $_val) {
                                // \Magento\Framework\App\ObjectManager::getInstance()->create('\ITM\MagB1\Helper\Data')
                                //    ->_log($item->getAttributeCode(). " - ".$_val["value"] );
                                $__value = (string)$_val['value'];

                                if ($__value == "") {
                                    continue;
                                }
                                $__label = (string)$_val['label'];

                                $options[] = [
                                    'option_id' => $__value,
                                    'value' => $text." - ".$__label,
                                    'names' => []
                                ];
                            }
                        }else
                        {
                            $value = (string)$model_option['value'];

                            if ($value == "") {
                                continue;
                            }
                            $label = (string)$model_option['label'];

                            $options[] = [
                                'option_id' => $value,
                                'value' => $label,
                                'names' => []
                            ];
                        }
                    }
                            
                            // get Option from Source model
                }
            } elseif ($item->getData("frontend_input") == "boolean") {
                    $model_options = $objectManager->create("Magento\Eav\Model\Entity\Attribute\Source\Boolean")
                                                    ->getAllOptions(1);
                    
                foreach ($model_options as $model_option) {
                    $value = (string) $model_option['value'];
                    if ($value == "") {
                        continue;
                    }
                    $label = (string) $model_option['label'];
                    
                    $options[] = [
                        'option_id' => $value,
                        'value' => $label,
                        'names' => []
                    ];
                }
            }
            $temp_arr["options"] = $options;
            $result[] = $temp_arr;
        }
        
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
    public function getCustomerAttributeSetGroupAttributes(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ) {

        $customer_entity_type_id = 1;
        return $this->getAttributeSetGroupAttributes($searchCriteria, $customer_entity_type_id);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getProductAttributeSetGroupAttributes(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ) {
        $product_entity_type_id = 4;
        return $this->getAttributeSetGroupAttributes($searchCriteria, $product_entity_type_id);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getCustomerAttributeSet()
    {
        $customer_entity_type_id = 1;
        return $this->getAttributeSet($customer_entity_type_id);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getProductAttributeSet()
    {
        $product_entity_type_id = 4;
        return $this->getAttributeSet($product_entity_type_id);
    }

    private function getAttributeSet($entity_type_id)
    {
        /* Get instance of object manager */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        
        /** @var  $coll \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection */
        $collection = $objectManager->create(\Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\Collection::class);
        
        $collection->addFieldToFilter(\Magento\Eav\Model\Entity\Attribute\Set::KEY_ENTITY_TYPE_ID, $entity_type_id);
        
        $product_attribute_set = $collection->load()->getItems();
        
        $result = [];
        foreach ($product_attribute_set as $item) {
            $attributes_collection = $objectManager->create(\Magento\Eav\Model\ResourceModel\Entity\Attribute::class);
            $result[] = [
                "attribute_set_id" => $item->getAttributeSetId(),
                "attribute_set_name" => $item->getAttributeSetName()
            ];
        }
        
        $searchResult = $this->searchResultsFactory->create();
        //$searchResult->setSearchCriteria(null);
        $searchResult->setItems($result);
        $searchResult->setTotalCount(count($result));
        return $searchResult;
    }

    private function getAttributeSetGroupAttributes(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        $entity_type_id
    ) {
        
        /* Get instance of object manager */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        
        /** @var  $coll \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection */
        $collection = $objectManager->create(\Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\Collection::class);
        
        $collection->addFieldToFilter(\Magento\Eav\Model\Entity\Attribute\Set::KEY_ENTITY_TYPE_ID, $entity_type_id);
        
        $product_attribute_set = $collection->load()->getItems();
        
        $result = [];
        
        foreach ($product_attribute_set as $item) {
            // Start
            $attributes_collection = $objectManager->create(\Magento\Eav\Model\ResourceModel\Entity\Attribute::class);

            $result[] = [
                "attribute_set_id" => $item->getAttributeSetId(),
                "attribute_set_name" => $item->getAttributeSetName(),
                "attribute_group" => $this->fetchGroupsData($item->getAttributeSetId(), $entity_type_id)
            ];
        }
        
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($result);
        $searchResult->setTotalCount(count($result));
        return $searchResult;
    }

    private function fetchGroupsData($setId, $entity_type_id)
    {
        $connection = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        
        $select = $connection->select()->from([
            'attribute_group' => $this->resource->getTableName('eav_attribute_group')
        ], [
            'attribute_group_id',
            'attribute_group_code',
            'attribute_group_name',
            'sort_order'
        ]);
        
        $bind = [];
        if (is_numeric($setId)) {
            $bind[':attribute_set_id'] = $setId;
            $select->where('attribute_group.attribute_set_id = :attribute_set_id');
        }
        $attribute_groups_fetch = $connection->fetchAll($select, $bind);
        
        $attribute_groups = [];
        
        foreach ($attribute_groups_fetch as $item) {
            $attribute_groups[] = [
                "attribute_group_id" => $item["attribute_group_id"],
                "attribute_group_code" => $item["attribute_group_code"],
                "attribute_group_name" => $item["attribute_group_name"],
                "sort_order" => $item["sort_order"],
                "attributes" => $this->getAttributesSetGroupData($item["attribute_group_id"], $setId, $entity_type_id)
            ];
        }
        
        return $attribute_groups;
    }

    private function getAttributesSetGroupData($groupId, $setId, $entity_type_id)
    {
        $connection = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        
        $select = $connection->select()
            ->from([
            'entity' => $this->resource->getTableName('eav_attribute')
             ], [
            'attribute_id'
             ])
            ->joinLeft([
                'entity_attribute' => $this->resource->getTableName('eav_entity_attribute')
             ], 'entity.attribute_id = entity_attribute.attribute_id', [
            'sort_order'
             ]);
        
        $bind = [];
        $bind[':entity_type_id'] = $entity_type_id;
        $bind[':attribute_group_id'] = $groupId;
        $bind[':attribute_set_id'] = $setId;
        $select->where('entity_attribute.attribute_set_id = :attribute_set_id');
        $select->where('entity_attribute.attribute_group_id = :attribute_group_id');
        $select->where('entity_attribute.entity_type_id = :entity_type_id');
        $select->where('entity.entity_type_id = :entity_type_id');
        
        return $connection->fetchAll($select, $bind);
    }

    private function createStoresCollection()
    {
        return $this->storesFactory->create();
    }
    
    /**
     *
     * {@inheritdoc}
     *
     */
    public function updateAttributeOptionLabels($attribute_code, $entity_type, $option)
    {
        $entityTypeId = $this->objectManager
        ->create('Magento\Eav\Model\Config')
        ->getEntityType($entity_type)//\Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE
        ->getEntityTypeId();
        
        $entityType = $entityTypeId;
       
        if (empty($attribute_code)) {
            throw new InputException(__('Empty attribute code'));
        }
        
        $attribute = $this->attributeRepository->get($entityType, $attribute_code);
        if (!$attribute->usesSource()) {
            throw new StateException(__('Attribute %1 doesn\'t work with options', $attribute_code));
        }
        
        $optionId = $option->getValue();
        $options = [];
        $options['value'][$optionId][0] = $option->getLabel();
        $options['order'][$optionId] = $option->getSortOrder();
        
        if (is_array($option->getStoreLabels())) {
            foreach ($option->getStoreLabels() as $label) {
                $options['value'][$optionId][$label->getStoreId()] = $label->getLabel();
            }
        }
        if ($option->getIsDefault()) {
            $attribute->setDefault([$optionId]);
        }
        
        $attribute->setOption($options);
        
        try {
            $this->resourceModel->save($attribute);
        } catch (\Exception $e) {
            throw new StateException(__('Cannot save attribute %1'.$e->getMessage(), $attribute_code));
        }
        
        return true;
    }
}
