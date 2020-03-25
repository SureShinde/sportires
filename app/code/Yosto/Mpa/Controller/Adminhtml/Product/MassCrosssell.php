<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Mpa\Controller\Adminhtml\Product;

/**
 * Class MassCrosssell
 * @package Yosto\Mpa\Controller\Adminhtml\Product
 */
class MassCrosssell extends MassLinkedProduct
{
    protected $linkTypeId = 5;
    protected $addLinkedProductParam = "add_crosssell_products";
    protected $removeLinkedProductParam = "remove_crosssell_products";
}