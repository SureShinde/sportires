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
 * @category  Ced
 * @package   Ced_WalmartMx
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CedCommerce (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\WalmartMx\Model\Source\Config;

class Attributes implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Ced\WalmartMx\Helper\Category
     * */
    protected $category;

    /**
     * @param Category $category
     * */
    public function __construct(
        \Ced\WalmartMx\Helper\Category $category
    )
    {
        $this->category = $category;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $attributes = $walmartmxAttributes = [];
        $attributes = $this->category->getAllAttributes();
        if(isset($attributes) && is_array($attributes)) {
            $attributes = array_column($attributes, 'label', 'code');
        }
        foreach ($attributes as $attributeCode => $attributeLabel) {
            $walmartmxAttributes[] = array(
                'label' => $attributeLabel,
                'value' => $attributeCode
            );
        }
        return $walmartmxAttributes;
    }
}
