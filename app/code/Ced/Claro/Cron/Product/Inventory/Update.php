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

namespace Ced\Claro\Cron\Product\Inventory;

class Update
{
    /** @var \Ced\Claro\Helper\Logger  */
    public $logger;
    
    /** @var \Ced\Claro\Helper\Config  */
    public $config;

    /** @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory  */
    public $productCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Ced\Claro\Helper\Product $product,
        \Ced\Claro\Helper\Logger $logger,
        \Ced\Claro\Helper\Config $config
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->logger = $logger;
        $this->config = $config;
        $this->product = $product;
    }
    /**
     * Execute
     * @return bool
     */
    public function execute()
    {
        $status = false;
        $ids = [];
        $message = false;
        try {
            if ($this->config->isValid()) {
                $sync = $this->config->getInventorySync();
                if ($sync) {
                    /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $products */
                    $products = $this->productCollectionFactory->create();
                    $ids = $products->addAttributeToFilter(
                        \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_ID,
                        ['notnull' => true]
                    )->getAllIds();

                    $chunks = array_chunk($ids, $this->config->getChunkSize());
                    foreach ($chunks as $chunk) {
                        $this->product->update($chunk);
                    }
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        $this->logger->notice(
            "Claro Cron : All inventory executed.",
            ['status' => $status, 'count' => count($ids), 'sync' => $sync, 'exception' => $message]
        );
        return $status;
    }
}