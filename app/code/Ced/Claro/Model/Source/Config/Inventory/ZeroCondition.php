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

namespace Ced\Claro\Model\Source\Config\Inventory;

class ZeroCondition extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    const PAUSE = 'pause';
    const SKIP = 'skip';

    /**
     * @return array
     */
    public function getAllOptions()
    {
        return [
            [
                'value' => self::PAUSE,
                'label' => __('Pause Product')
            ],
            [
                'value' => self::SKIP,
                'label' => __('Skip Product')
            ]
        ];
    }
}
