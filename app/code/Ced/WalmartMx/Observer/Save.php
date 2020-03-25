<?php

namespace Ced\WalmartMx\Observer;

class Save implements \Magento\Framework\Event\ObserverInterface
{
	protected $objectManager;
	protected $productHelper;
	protected $logger;

	public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Ced\WalmartMx\Helper\Logger $logger,
        \Ced\WalmartMx\Helper\Product $productHelper
    ) {
        $this->objectManager = $objectManager;
        $this->productHelper = $productHelper;
        $this->logger = $logger;
    }
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		if($product = $observer->getEvent()->getProduct()) {
			try{
				$product = $observer->getEvent()->getProduct();	
				if($product->getWalmartmxProfileId())
				$this->productHelper->updatePriceInventory([$product->getId()]);
			} catch (\Exception $e){
                $this->logger->error('Save Observer', ['path' => __METHOD__, 'exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
			}
		}
	}
}