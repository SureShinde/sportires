<?php

namespace ITM\Sportires\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use \Magento\Framework\App\RequestInterface;

class Observer implements ObserverInterface
{
    private $helper;
    private $productFactory;

    public function __construct(
        \ITM\Sportires\Helper\Data $helper,
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory

    ) {
        $this->helper = $helper;
        $this->productFactory = $productFactory;
    }


    private function catalog_product_save_before(\Magento\Framework\Event\Observer $observer)
    {

        return;
        $product = $observer->getEvent()->getProduct();
        $width_option_id = $product->getData("tire_width");
        $ratio_option_id = $product->getData("tire_ratio");
        $diameter_option_id = $product->getData("tire_diameter");
        if (!empty($width_option_id) && !empty($ratio_option_id) && !empty($diameter_option_id)) {
            $attr_tire_width = $product->getResource()->getAttribute('tire_width');
            $attr_tire_ratio = $product->getResource()->getAttribute('tire_ratio');
            $attr_tire_diameter = $product->getResource()->getAttribute('tire_diameter');
            //if ($attr_tire_width->usesSource()) {
            $width = $attr_tire_width->getSource()->getOptionText($width_option_id);
            $ratio = $attr_tire_ratio->getSource()->getOptionText($ratio_option_id);
            $diameter = $attr_tire_diameter->getSource()->getOptionText($diameter_option_id);
            $tire_size = $this->helper->getTireSize($width, $ratio, $diameter);
            $poductReource = $this->productFactory->create();
            $attribute = $poductReource->getAttribute("tire_size");

            $optionId = $attribute->getSource()->getOptionId($tire_size);
            if ($optionId > 0) {
                //$product->setData("tire_size", $optionId );
            }
        }
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event_name = $observer->getEvent()->getName();
        switch ($event_name) {
            case "catalog_product_save_before":
                $this->catalog_product_save_before($observer);
                break;
        }
        return $this;
    }
}
