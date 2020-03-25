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

namespace Ced\Claro\Model\Source\Order;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class Status
 *
 * @package Ced\Claro\Model\Source
 */
class Status extends AbstractSource
{
    //Claro status
    const PENDING = 'pendientes';
    const SHIPPED = 'embarcados';
    const DELIVERED = 'entregados';

    // Custom Status
    const NOT_IMPORTED = 'not_imported';
    const IMPORTED = 'imported';
    const COMPLETED = 'completed';
    const FAILED = 'failed';

    // Api Status
    const ALL = 'all';
    const CONFIRMED = 'confirmed';
    const PAYMENT_IN_PROGRESS = 'payment_in_process';
    const PARTIALLY_PAID = 'partially_paid';
    const PAID = 'paid';
    const CANCELLED = 'cancelled';
    const INVALID = 'invalid';

    const STATUS = [
        self::ALL,
        self::CONFIRMED,
        self::PAYMENT_IN_PROGRESS,
        self::PARTIALLY_PAID,
        self::PAID,
        self::CANCELLED,
        self::INVALID,
    ];

    /**
     * @return array
     */
    public function getAllOptions()
    {
        return [
            [
                'value' => self::PENDING,
                'label' => __('Pending')
            ],
            [
                'value' => self::SHIPPED,
                'label' => __('Shipped')
            ],
            [
                'value' => self::DELIVERED,
                'label' => __('delivered')
            ]
            /*[
                'value' => self::NOT_IMPORTED,
                'label' => __('Not Imported')
            ],
            [
                'value' => self::IMPORTED,
                'label' => __('Imported')
            ],
            [
                'value' => self::COMPLETED,
                'label' => __('Completed')
            ],
            [
                'value' => self::FAILED,
                'label' => __('Failed')
            ],
            [
                'value' => self::ALL,
                'label' => __('All')
            ],
            [
                'value' => self::CONFIRMED,
                'label' => __('Confirmed')
            ],
            [
                'value' => self::PAYMENT_IN_PROGRESS,
                'label' => __('Payment In Progress')
            ],
            [
                'value' => self::PARTIALLY_PAID,
                'label' => __('Partially Paid')
            ],
            [
                'value' => self::PAID,
                'label' => __('Paid')
            ],
            [
                'value' => self::CANCELLED,
                'label' => __('Cancelled')
            ],
            [
                'value' => self::INVALID,
                'label' => __('Invalid')
            ]*/
        ];
    }
}
