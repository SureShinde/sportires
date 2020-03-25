<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Mpa\Controller\Adminhtml\Product;

/**
 * Class MassUpsell
 * @package Yosto\Mpa\Controller\Adminhtml\Product
 */
class MassUpsell extends MassLinkedProduct
{
    protected $linkTypeId = 4;
    protected $addLinkedProductParam = "add_upsell_products";
    protected $removeLinkedProductParam = "remove_upsell_products";
}

