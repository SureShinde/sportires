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

namespace Ced\WalmartMx\Cron\Feed;

class Sync
{
    public $logger;
    public $feeds;
    public $product;
    public $systemLogger;

    /**
     * @param \Ced\WalmartMx\Helper\Logger $logger
     */
    public function __construct(
        \Ced\WalmartMx\Model\Feeds $walmartmxFeeds,
        \Ced\WalmartMx\Helper\Logger $logger,
        \Ced\WalmartMx\Helper\Product $product,
        \Psr\Log\LoggerInterface $systemLogger,
        \Ced\WalmartMx\Helper\Config $config
    ) {
        $this->feeds = $walmartmxFeeds;
        $this->logger = $logger;
        $this->product = $product;
        $this->systemLogger = $systemLogger;
        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function execute()
    {
        $response = '';
        try {
            $invCron = $this->config->getFeedSyncCron();
            if ($invCron == '1') {
                $this->logger->info('Feed Sync Cron Enable', ['path' => __METHOD__, 'Cron Status' => 'Enable']);
                $feedIds = $this->feeds->getCollection()
                    ->addFieldToFilter('status', array('neq' => 'COMPLETE'));
                foreach ($feedIds as $feed) {
                    $response = $this->product->syncFeeds($feed);
                }
                return $response;
            } else {
                $this->logger->info('Feed Sync Cron Disabled', ['path' => __METHOD__, 'Cron Status' => 'Disable']);
            }
            return false;
        } catch (\Exception $e){
            $this->logger->error('Feed Sync Cron', ['path' => __METHOD__, 'exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }
}
