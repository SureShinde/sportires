<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Block of links in Order view page
 */
namespace ITM\MagB1\Block\Order\Info;

use Magento\Customer\Model\Context;

/**
 * @api
 * @since 100.0.2
 */
class Buttons extends \Magento\Sales\Block\Order\Info\Buttons
{
    /**
     * @var string
     */
    protected $_template = 'ITM_MagB1::sales/order/info/buttons.phtml';
    /**
     * Get url for printing order
     *
     * @param \Magento\Sales\Model\Order $order
     * @return string
     */
    public function getPrintUrl($order)
    {
        return $this->getUrl('magb1/order/print', ['order_id' => $order->getId()]);
    }
}
