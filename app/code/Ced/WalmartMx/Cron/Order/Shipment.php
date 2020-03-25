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

namespace Ced\WalmartMx\Cron\Order;

class Shipment
{
    public $logger;

    /**
     * @var $config
     */
    public $config;

    /**
     * Import constructor.
     *
     * @param \Ced\WalmartMx\Helper\Order  $order
     * @param \Ced\WalmartMx\Helper\Logger $logger
     */
    public function __construct(
        \Ced\WalmartMx\Helper\Order $order,
        \Ced\WalmartMx\Helper\Logger $logger,
        \Ced\WalmartMx\Model\Orders $collection,
        \Ced\WalmartMx\Helper\Config $config
    ) {
        $this->order = $order;
        $this->logger = $logger;
        $this->orders = $collection;
        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function execute()
    {
        try {
            $orderSyncCron = $this->config->getOrderShipmentCron();
            if ($orderSyncCron == '1') {
                $orderCollection = $this->orders->getCollection()
                    ->addFieldToFilter('status', array('in', array('SHIPPING')));
                $orderIds = $orderCollection->getColumnValues('walmartmx_order_id');
                $syncResponse = $this->order->shipOrders($orderCollection);
                $this->logger->info('Shipment Order Cron Response', ['path' => __METHOD__, 'OrderIds' => implode(',', $orderIds), 'OrderShipmentReponse' => var_export($syncResponse)]);
                return $syncResponse;
            } else {
                $this->logger->info('Shipment Cron Disabled', ['path' => __METHOD__, 'Cron Status' => 'Disable']);
            }
            return false;
        } catch (\Exception $e){
            $this->logger->error('Order Shipment Cron', ['path' => __METHOD__, 'exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }
}
