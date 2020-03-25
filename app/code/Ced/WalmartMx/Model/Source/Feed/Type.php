<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement(EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
 * @package   Ced_WalmartMx
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\WalmartMx\Model\Source\Feed;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class Type
 *
 * @package Ced\WalmartMx\Model\Source
 */
class Type extends AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions()
    {
        return [
            [
                'value' => \WalmartMxSdk\Core\Request::FEED_CODE_INVENTORY_UPDATE,
                'label' => __(\WalmartMxSdk\Core\Request::FEED_CODE_INVENTORY_UPDATE),
            ],
            [
                'value' => \WalmartMxSdk\Core\Request::FEED_CODE_ITEM_UPDATE,
                'label' => __(\WalmartMxSdk\Core\Request::FEED_CODE_ITEM_UPDATE),
            ],
            [
                'value' => \WalmartMxSdk\Core\Request::FEED_CODE_ITEM_DELETE,
                'label' => __(\WalmartMxSdk\Core\Request::FEED_CODE_ITEM_DELETE),
            ],
            [
                'value' => \WalmartMxSdk\Core\Request::FEED_CODE_ORDER_SHIPMENT,
                'label' => __(\WalmartMxSdk\Core\Request::FEED_CODE_ORDER_SHIPMENT),
            ],
            [
                'value' => \WalmartMxSdk\Core\Request::FEED_CODE_PRICE_UPDATE,
                'label' => __(\WalmartMxSdk\Core\Request::FEED_CODE_PRICE_UPDATE),
            ],
            [
                'value' => \WalmartMxSdk\Core\Request::FEED_CANCEL_ORDER_ITEM,
                'label' => __(\WalmartMxSdk\Core\Request::FEED_CANCEL_ORDER_ITEM),
            ],
            [
                'value' => \WalmartMxSdk\Core\Request::FEED_CODE_ORDER_CREATE,
                'label' => __(\WalmartMxSdk\Core\Request::FEED_CODE_ORDER_CREATE),
            ]
        ];
    }
}
