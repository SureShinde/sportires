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

namespace Ced\Claro\Model\Source\Order\Shipment;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class Status
 *
 * @package Ced\Claro\Model\Source\Order\Shipment
 */
class Status extends AbstractSource
{
    const ALL = 'all';
    const TO_BE_AGREED = 'to_be_agreed';
    const PENDING = 'pending';
    const HANDLING = 'handling';
    const READY_TO_SHIP = 'ready_to_ship';
    const SHIPPED = 'shipped';
    const DELIVERED = 'delivered';
    const NOT_DELIVERED = 'not_delivered';
    const NOT_VERIFIED = 'not_verified';
    const CANCELLED = 'cancelled';
    const CLOSED = 'closed';
    const ACTIVE = 'active';

    const STATUS = [
        self::ALL,
        self::TO_BE_AGREED,
        self::PENDING,
        self::HANDLING ,
        self::READY_TO_SHIP,
        self::SHIPPED,
        self::DELIVERED,
        self::NOT_DELIVERED,
        self::NOT_VERIFIED,
        self::CANCELLED,
        self::CLOSED,
        self::ACTIVE,
    ];

    /**
     * @return array
     */
    public function getAllOptions()
    {
        return [
            [
                'value' => self::ALL,
                'label' => __('All')
            ],
            [
                'value' => self::TO_BE_AGREED,
                'label' => __('To Be Agreed')
            ],
            [
                'value' => self::PENDING,
                'label' => __('Pending')
            ],
            [
                'value' => self::HANDLING,
                'label' => __('Handling')
            ],
            [
                'value' => self::READY_TO_SHIP,
                'label' => __('Ready To Ship')
            ],
            [
                'value' => self::SHIPPED,
                'label' => __('Shipped')
            ],
            [
                'value' => self::DELIVERED,
                'label' => __('Delivered')
            ],
            [
                'value' => self::NOT_DELIVERED,
                'label' => __('Not Delivered')
            ],
            [
                'value' => self::NOT_VERIFIED,
                'label' => __('Not Verified')
            ],
            [
                'value' => self::CANCELLED,
                'label' => __('Cancelled')
            ],
            [
                'value' => self::CLOSED,
                'label' => __('Closed')
            ],
            [
                'value' => self::ACTIVE,
                'label' => __('Active')
            ]
        ];
    }
}
