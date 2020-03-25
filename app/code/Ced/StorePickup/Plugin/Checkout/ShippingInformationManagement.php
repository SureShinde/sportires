<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_StorePickup
 * @author      CedCommerce Core Team <connect@cedcommerce.com >
 * @copyright   Copyright CEDCOMMERCE (https://cedcommerce.com/)
 * @license      https://cedcommerce.com/license-agreement.txt
 */ 
namespace Ced\StorePickup\Plugin\Checkout;

class ShippingInformationManagement
{
    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
    }



    public function beforeSaveAddressInformation(\Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation)
    {
        $extension_attributes = $addressInformation->getExtensionAttributes();    
      
        $pickupId = $extension_attributes->getStorePickupId();
        $pickupDate = $extension_attributes->getStorePickupDate();
        $quote = $this->quoteRepository->getActive($cartId);
        $quote->setStorePickupId($pickupId);
        $quote->setStorePickupDate($pickupDate);
    }
}
