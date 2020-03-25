<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Block\Adminhtml\Profile\Ui\Form\Product\Renderer;

class Category extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $categoryFactory;

    protected $productFactory;

    public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->productFactory = $productFactory;
    }
    public function render(\Magento\Framework\DataObject $row)
    {
        $product = $this->productFactory->create()->load($row->getEntityId());
        $cats = $product->getCategoryIds();
        $allCats = '';
        foreach($cats as $key => $cat)
        {
            $_category = $this->categoryFactory->create()->load($cat);
            $allCats.= $_category->getName();
            if($key < count($cats)-1)
                $allCats.= ',<br />';
        }
        return $allCats;
    }
}
