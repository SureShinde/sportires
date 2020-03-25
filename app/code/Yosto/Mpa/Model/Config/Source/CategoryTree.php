<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Mpa\Model\Config\Source;

/**
 * Class CategoryTree
 * @package Yosto\Mpa\Model\Config\Source
 */
class CategoryTree implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var \Magento\Catalog\Model\Category\Tree
     */
    protected $categoryTree;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $categoriesFactory;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoriesFactory
     * @param \Yosto\Mpa\Model\Catalog\Category\Tree $categoryTree
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoriesFactory,
        \Yosto\Mpa\Model\Catalog\Category\Tree $categoryTree
    ) {
        $this->categoriesFactory = $categoriesFactory;
        $this->categoryTree = $categoryTree;
    }

    /**
     * To option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $_categoryTree = $this->getCategoryTree();
        $_options[] = [
            'label' => __('  '),
            'value' => ''
        ];

        foreach ($_categoryTree['result']['children_data'] as $category) {
            $_options[] = $this->toOptionIdArray($category);
            foreach ($this->getChildren($category, '') as $_categoryChild) {
                $_options[] = $_categoryChild;
            }
        }

        if (!$this->options) {
            $this->options = $_options;
        }
        return $_options;
    }

    /**
     * @param array $category
     * @param string $currentLevel
     * @return array
     */
    protected function getChildren($category, $currentLevel)
    {
        if (!empty($category['children_data'])) {
            $children = [];
            foreach ($category['children_data'] as $child) {
                $children[] = $this->toOptionIdArray($child, $currentLevel.'---');
                if (!empty($child['children_data'])) {
                    foreach ($this->getChildren($child, $currentLevel.'---') as $_child) {
                        $children[] = $_child;
                    }
                }
            }
            return $children;
        }
        return [];
    }

    /**
     * @param array $category
     * @param string $currentLevel
     * @return array
     */
    protected function toOptionIdArray($category, $currentLevel = '')
    {
        return [
            'label' => $currentLevel
                .'(ID:'
                .$category['entity_id']
                .') '
                .$category['name']
                .' ('
                .$category['product_count']
                .')',
            'value' => $category['entity_id']
        ];
    }

    /**
     *
     * @return array
     */
    public function getCategoryTree()
    {
        return $this->categoryTree->getTree(
            $this->categoryTree->getRootNode(
                $this->getTopLevelCategory()
            ),
            null
        );
    }

    /**
     * Get top level hidden root category
     *
     * @return \Magento\Catalog\Model\Category
     */
    private function getTopLevelCategory()
    {
        $categoriesCollection = $this->categoriesFactory->create();
        return $categoriesCollection->addFilter('level', ['eq' => 0])->getFirstItem();
    }
}
