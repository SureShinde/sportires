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

namespace Mageplaza\AbandonedCart\Block\Email;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Directory\Model\PriceCurrency;
use Magento\Quote\Model\Quote;
use Mageplaza\AbandonedCart\Helper\Data as ModuleHelper;

/**
 * Class Template
 * @method Quote getQuote()
 * @package Mageplaza\AbandonedCart\Block\Email
 */
class Template extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @var \Magento\Directory\Model\PriceCurrency
     */
    protected $priceCurrency;

    /**
     * @var \Mageplaza\AbandonedCart\Helper\Data
     */
    protected $helperData;

    /**
     * Template constructor.
     *
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Directory\Model\PriceCurrency $priceCurrency
     * @param \Mageplaza\AbandonedCart\Helper\Data $helperData
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        PriceCurrency $priceCurrency,
        ModuleHelper $helperData,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->_productRepository = $productRepository;
        $this->imageHelper = $context->getImageHelper();
        $this->priceCurrency = $priceCurrency;
        $this->helperData = $helperData;
    }

    /**
     * Get items in quote
     *
     * @return array
     */
    public function getProductCollection()
    {
        $items = [];

        if ($quote = $this->getQuote()) {
            return $quote->getAllVisibleItems();
        }

        return $items;
    }

    /**
     * Get subtotal in quote
     *
     * @param bool $inclTax
     *
     * @return float|string
     */
    public function getSubtotal($inclTax = false)
    {
        $subtotal = 0;
        if ($quote = $this->getQuote()) {
            $address = $quote->isVirtual() ? $quote->getBillingAddress() : $quote->getShippingAddress();
            $subtotal = $inclTax ? $address->getSubtotalInclTax() : $address->getSubtotal();
        }

        return $this->priceCurrency->format($subtotal, true, PriceCurrency::DEFAULT_PRECISION, $quote ? $quote->getStoreId() : null);
    }

    /**
     * Get image url in quote
     *
     * @param $_item
     *
     * @return string
     */
    public function getProductImage($_item)
    {
        $productId = $_item->getProductId();
        $product = $this->_productRepository->getById($productId);
        $imageUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $product->getImage();

        return str_replace('\\', '/', $imageUrl);
    }

    /**
     * Get item price in quote
     *
     * @param $_item
     *
     * @return float|string
     */
    public function getProductPrice($_item)
    {
        $productPrice = $_item->getRowTotal();

        return $this->priceCurrency->format($productPrice, false);
    }

    /**
     * @return string
     */
    public function getPlaceholderImage()
    {
        return $this->imageHelper->getDefaultPlaceholderUrl('image');
    }
}
