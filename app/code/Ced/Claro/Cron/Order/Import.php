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
 * @package   Ced_Claro
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Cron\Order;

/**
 * Class Import
 * @package Ced\Claro\Cron\Order
 */
class Import
{
    /** @var \Ced\Claro\Helper\Logger  */
    public $logger;

    /**
     * Import constructor.
     * @param \Ced\Claro\Helper\Order $order
     * @param \Ced\Claro\Helper\Logger $logger
     */
    public function __construct(
        \Ced\Claro\Helper\Order $order,
        \Ced\Claro\Helper\Logger $logger
    ) {
        $this->order = $order;
        $this->logger = $logger;
    }

    public function execute()
    {
        try {
            $status = $this->order->import();
            $this->logger->info('Claro order import executed via cron.', ['status' => $status]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['path' => __METHOD__]);
        }
    }
}
