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

namespace Ced\Claro\Model;

class Order extends \Magento\Framework\Model\AbstractModel
{
    const NAME = "ced_claro_order";

    const COLUMN_ID = 'id';
    const COLUMN_MAGENTO_ORDER_ID = 'magento_order_id';
    const COLUMN_MAGENTO_INCREMENT_ID = 'magento_increment_id';
    const COLUMN_MARKETPLACE_ORDER_ID = 'claro_order_id';
    const COLUMN_MARKETPLACE_SHIPMENT_ID = 'claro_shipment_id';
    const COLUMN_MARKETPLACE_DATE_CREATED = 'date_created';
    const COLUMN_STATUS = 'status';
    const COLUMN_FAILURE_REASON = 'reason';
    const COLUMN_ORDER_DATA = 'order_data';
    const COLUMN_SHIPMENT_DATA = 'shipment_data';
    const COLUMN_CANCELLATION_DATA = 'cancellation_data';

    public function _construct()
    {
        $this->_init(\Ced\Claro\Model\ResourceModel\Order::class);
    }

    public function getByPurchaseOrderId($poId)
    {
        $order = $this->load($poId, self::COLUMN_MARKETPLACE_ORDER_ID);
        if ($order->getId() !== null) {
            return $order;
        }

        return null;
    }

    public function loadByMagentoOrderId($magentoOrderId)
    {
        return $this->load($magentoOrderId, self::COLUMN_MAGENTO_ORDER_ID);
    }
}
