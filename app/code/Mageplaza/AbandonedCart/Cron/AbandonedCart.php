<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_AbandonedCart
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\AbandonedCart\Cron;

use Mageplaza\AbandonedCart\Model\AbandonedCart as AbandonedCartModel;
use Psr\Log\LoggerInterface;

/**
 * Class AbandonedCart
 * @package Mageplaza\AbandonedCart\Cron
 */
class AbandonedCart
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Mageplaza\AbandonedCart\Model\AbandonedCart
     */
    private $abandonedCartModel;

    /**
     * AbandonedCart constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Mageplaza\AbandonedCart\Model\AbandonedCart $abandonedCartModel
     */
    public function __construct(
        LoggerInterface $logger,
        AbandonedCartModel $abandonedCartModel
    ) {
        $this->logger = $logger;
        $this->abandonedCartModel = $abandonedCartModel;
    }

    /**
     * @return void
     */
    public function execute()
    {
        try {
            $this->abandonedCartModel->prepareForAbandonedCart();
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
    }
}
