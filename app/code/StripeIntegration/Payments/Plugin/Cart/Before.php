<?php
declare(strict_types = 1);
namespace StripeIntegration\Payments\Plugin\Cart;

use StripeIntegration\Payments\Helper\Logger;

class Before
{
    public function __construct(
        \StripeIntegration\Payments\Helper\Subscriptions $subscriptionsHelper,
        \StripeIntegration\Payments\Helper\Generic $paymentsHelper,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable
    ) {
        $this->subscriptionsHelper = $subscriptionsHelper;
        $this->paymentsHelper = $paymentsHelper;
        $this->configurable = $configurable;
    }

    /**
     * beforeAddProduct
     *
     * @param      $subject
     * @param      $productInfo
     * @param null $requestInfo
     *
     * @return array
     * @throws LocalizedException
     */
    public function beforeAddProduct($subject, $productInfo, $requestInfo = null)
    {
        if ($productInfo->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE)
        {
            // The product was added from the product page
            if (isset($requestInfo['selected_configurable_option']))
            {
                $productId = $requestInfo['selected_configurable_option'];
                $product = $this->paymentsHelper->loadProductById($productId);
                $this->subscriptionsHelper->validateCartItems($product);
            }
            // The product was added from the catalog
            else if (isset($requestInfo['super_attribute']))
            {
                $product = $this->configurable->getProductByAttributes(
                    $requestInfo['super_attribute'], $productInfo
                );
                $this->subscriptionsHelper->validateCartItems($product);
            }
            else
                return [$productInfo, $requestInfo];
        }
        else
            $this->subscriptionsHelper->validateCartItems($productInfo);

        return [$productInfo, $requestInfo];
    }
}
