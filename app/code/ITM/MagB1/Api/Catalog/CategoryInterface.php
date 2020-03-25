<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ITM\MagB1\Api\Catalog;

/**
 * @api
 */
interface CategoryInterface
{
    /**
     * Retrieve list of categories
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException If ID is not found
     * @return \Magento\Catalog\Api\Data\CategoryTreeInterface containing Tree objects
     */
    public function getCategoryTree();
}
