<?php

namespace ITM\MagB1\Model\System\Config;

class CategoryList implements \Magento\Framework\Option\ArrayInterface
{
    static $arr = array();
    static $tmp = array();

    /**
     * @var \Magento\Framework\Escaper
     */
    protected $_escaper = null;
    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * @param \Magento\Cms\Model\Block $blockModel
     */
    public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Escaper $escaper
        ) {
        $this->_escaper = $escaper;
        $this->_categoryFactory = $categoryFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray($showEmpty = true)
    {
        $collection = $this->_categoryFactory->create();

        $root_parent_id = 1;
        $root_parent_collection = $collection->getCollection()
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('is_active','1')
        ->addAttributeToFilter('level', '0')
        ->addAttributeToFilter('parent_id',array('eq' => "0"))
        ->setStoreId(0);
        
        if(0 < $root_parent_collection->getSize()) {
            $root_parent_id = $root_parent_collection->getFirstItem()->getId();
        }
        $arr = $this->getTreeCategories($root_parent_id);
        if($showEmpty){
            array_unshift($arr, array(
                'value' => '',
                'label' => ' ',
                ));
        }
        return $arr;
    }

    public function getTreeCategories($parentId,$level = 0, $caret = ' _ '){
        $allCats = $this->_categoryFactory->create()->getCollection()
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('is_active','1')
        ->addAttributeToSort('position', 'asc')
        ->setStoreId(0); 
        if ($parentId) {
            $allCats->addAttributeToFilter('parent_id',array('eq' => $parentId));
        }

        $prefix = "";
        if($level) {
            $prefix = "|_";
            for($i=0;$i < $level; $i++) {
                $prefix .= $caret;
            }
        }
        foreach($allCats as $category)
        {
            if(!isset(self::$tmp[$category->getId()])) {
                self::$tmp[$category->getId()] = $category->getId();
                $tmp["value"] = $category->getId();
                $tmp["label"] = $prefix."(ID:".$category->getId().") ".addslashes($category->getName());
                $arr[] = $tmp;
                $subcats = $category->getChildren();
                if($subcats != ''){ 
                    $arr = array_merge($arr, $this->getTreeCategories($category->getId(),(int)$level + 1, $caret.' _ '));
                }

            }
            
        }
        return isset($arr)?$arr:array();
    }
}