<?php
/**
* CedCommerce
*
* NOTICE OF LICENSE
*
* This source file is subject to the End User License Agreement (EULA)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://cedcommerce.com/license-agreement.txt
*
* @category    Ced
* @package     Ced_StorePickup
* @author      CedCommerce Core Team <connect@cedcommerce.com >
* @copyright   Copyright CEDCOMMERCE (https://cedcommerce.com/)
* @license      https://cedcommerce.com/license-agreement.txt
*/ 
namespace Ced\StorePickup\Model\Source;

class Method implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            ['value' => 7, 'label' => __('Please Select Blackout days')],
            ['value' => 0, 'label' => __('sunday')],
            ['value' => 1, 'label' => __('monday')],
            ['value' => 2, 'label' => __('tuesday')],
            ['value' => 3, 'label' => __('wednesday')],
            ['value' => 4, 'label' => __('thursday')],
            ['value' => 5, 'label' => __('friday')],
            ['value' => 6, 'label' => __('saturday')]
        ];
    }
}