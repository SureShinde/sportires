<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_Paction
 */


namespace Amasty\Paction\Plugin\Catalog\Controller\Adminhtml\Product\Action\Attribute;

use Amasty\Paction\Block\Adminhtml\Product\Edit\Action\Attribute\Tab\TierPrice as TierPriceBlock;
use Magento\Catalog\Api\Data\ProductTierPriceExtensionFactory;
use Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Config\Source\ProductPriceOptionsInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Pricing\Price\TierPrice;
use Magento\Framework\App\RequestInterface;
use Amasty\Paction\Helper\Data;

class Save
{
    /**
     * @var \Amasty\Paction\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    private $collection;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductTierPriceInterfaceFactory
     */
    private $productTierPriceInterfaceFactory;

    /**
     * @var ProductTierPriceExtensionFactory
     */
    private $productTierPriceExtensionFactory;

    /**
     * @var \Magento\Catalog\Helper\Product\Edit\Action\Attribute
     */
    private $attributeHelper;

    public function __construct(
        Data $helper,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        ProductRepositoryInterface $productRepository,
        ProductTierPriceInterfaceFactory $productTierPriceInterfaceFactory,
        ProductTierPriceExtensionFactory $productTierPriceExtensionFactory,
        \Magento\Catalog\Helper\Product\Edit\Action\Attribute $attributeHelper
    ) {
        $this->helper = $helper;
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->productTierPriceInterfaceFactory = $productTierPriceInterfaceFactory;
        $this->productTierPriceExtensionFactory = $productTierPriceExtensionFactory;
        $this->attributeHelper = $attributeHelper;
    }

    public function beforeExecute($subject)
    {
        $productIds = $this->attributeHelper->getProductIds();
        $requestParams = $this->request->getParams();
        $attrData = $requestParams['attributes'] ?? [];

        $isNeedDeletePrices = $this->request->getParam(TierPriceBlock::TIER_PRICE_CHANGE_CHECKBOX_NAME);

        if ((isset($attrData[TierPrice::PRICE_CODE]) && $attrData[TierPrice::PRICE_CODE])
            || $isNeedDeletePrices
        ) {
            foreach ($productIds as $productId) {
                $product = $this->productRepository->getById($productId);
                $product->setMediaGalleryEntries($product->getMediaGalleryEntries());
                if (!$isNeedDeletePrices) {
                    // phpcs:ignore
                    $attrData['tier_price'] = array_merge($attrData['tier_price'], $product->getTierPrice());
                }
                $tierPrices = $this->prepareTierPrices($attrData);
                $product->setTierPrices($tierPrices);
                $this->productRepository->save($product);
            }

            unset($attrData[TierPrice::PRICE_CODE]);
        }
        $requestParams['attributes'] = $attrData;
        $this->request->setParams($requestParams);
    }

    /**
     * @param array $tierPriceDataArray
     *
     * @return array
     */
    private function prepareTierPrices(array $tierPriceDataArray)
    {
        $result = [];
        $isPercentValue = false;

        if (isset($tierPriceDataArray[TierPrice::PRICE_CODE])
            && $tierPriceDataArray[TierPrice::PRICE_CODE]
        ) {
            foreach ($tierPriceDataArray[TierPrice::PRICE_CODE] as $item) {
                if (!$item['price_qty']) {
                    continue;
                }

                if (isset($item['value_type'])) {
                    $isPercentValue = $item['value_type'] == ProductPriceOptionsInterface::VALUE_PERCENT;
                }
                $tierPriceExtensionAttribute = $this->productTierPriceExtensionFactory->create()
                    ->setWebsiteId($item['website_id']);

                if ($isPercentValue) {
                    $tierPriceExtensionAttribute->setPercentageValue($item['price']);
                }

                $result[] = $this->productTierPriceInterfaceFactory
                    ->create()
                    ->setCustomerGroupId($item['cust_group'])
                    ->setQty($item['price_qty'])
                    ->setValue(!$isPercentValue ? $item['price'] : '')
                    ->setExtensionAttributes($tierPriceExtensionAttribute);
            }
        }

        return $result;
    }
}
