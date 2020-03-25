<?php
/**
 * Copyright © 2015 Scommerce Mage. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Scommerce\GoogleRemarketing\Model\Config\Source;

class Attributes extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $_product;

    /**
     * @param \Magento\Catalog\Model\Product $product
     */
    public function __construct(
        \Magento\Catalog\Model\Product $product
    ) {
        $this->_product = $product;
    }

    /**
     * return the list of product attributes for administrator to choose from
     */
    public function getAllOptions()
    {
        $attributes = $this->_product->getAttributes();
        $attributeArray[] = array('label' => __('Please select'), 'value' => '');

        foreach($attributes as $attribute){
            $attributeArray[] = array(
                'label' => $attribute->getName(),
                'value' => $attribute->getName()
            );
        }

        return $attributeArray;
    }
}