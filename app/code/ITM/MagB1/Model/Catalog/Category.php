<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ITM\MagB1\Model\Catalog;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class Category extends  \Magento\Catalog\Model\Category\Tree
{

     /**
     * {@inheritdoc}
     */
    public function getCategoryTree()
    {
        $nodeId = 1;
        $node = $this->categoryTree->loadNode($nodeId);
        $node->loadChildren();
        $this->prepareCollection();
        $this->categoryTree->addCollectionData($this->categoryCollection);

        return $this->getTree($node,null,0);
    }



   
}
