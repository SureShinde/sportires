<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Api\Catalog;

/**
 * Interface for Management of ProductLink
 * @api
 */
interface Magb1ProductLinkManagementInterface extends \Magento\Bundle\Api\ProductLinkManagementInterface
{
    /**
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Magento\Bundle\Api\Data\OptionInterface[]
     */
    public function getOptions(\Magento\Catalog\Api\Data\ProductInterface $product);
}
