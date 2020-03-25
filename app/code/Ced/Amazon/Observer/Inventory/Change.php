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
 * @category    Ced
 * @package     Ced_Amazon
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Amazon\Observer\Inventory;

use Magento\Framework\Event\ObserverInterface;
use Ced\Amazon\Helper\Product\Inventory;
use Ced\Amazon\Helper\Config;
use Ced\Amazon\Helper\Logger;
use Magento\TestFramework\Event\Magento;

class Change implements ObserverInterface
{
    /**
     * Amazon Logger
     * @var \Ced\Amazon\Helper\Logger
     */
    private $logger;

    /** @var Config */
    private $config;

    /** @var Inventory */
    private $inventory;

    /**
     * Change constructor.
     * @param Logger $logger
     * @param Inventory $inventory
     * @param Config $config
     */
    public function __construct(
        Logger $logger,
        Inventory $inventory,
        Config $config
    ) {
        $this->config = $config;
        $this->logger = $logger;
        $this->inventory = $inventory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            if ($this->config->getInventoryObserver()) {
                $productId = $observer->getData('item')->getData('product_id');
                /** @var \Magento\Framework\Event  $event */
                $event = $observer->getEvent();
                if ($event->hasData('item')) {
                    /** @var \Magento\Catalog\Model\Product $item */
                    $item = $event->getData('item');
                    if ((int)$item->getData('qty') != (int)$item->getOrigData('qty')) {
                        $this->inventory->update([$productId], true, \Ced\Amazon\Model\Source\Queue\Priorty::HIGH);
                    }
                }
            }
        } catch (\Exception $e) {
            // silence
        }
    }
}
