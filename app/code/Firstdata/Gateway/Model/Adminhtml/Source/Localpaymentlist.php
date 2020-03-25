<?php

namespace Firstdata\Gateway\Model\Adminhtml\Source;

use Firstdata\Gateway\Model\Adminhtml\Source\Localisation;

/**
 * Class PaymentAction
 */
class Localpaymentlist implements \Magento\Framework\Option\ArrayInterface {

    /**
     * {@inheritdoc}
     */
    protected $localpayments;

    public function __construct(Localisation $localpayments, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig) {

        $this->localpayments = $localpayments;
        $this->scopeConfig = $scopeConfig;
    }

    public function toOptionArray() {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $country = $this->scopeConfig->getValue("payment/firstdata/country", $storeScope);
        $reseller = $this->scopeConfig->getValue("payment/firstdata/reseller", $storeScope);
        $alternative_payments = $this->localpayments->getAlternatePayments($country, $reseller);
        $result = array();
        foreach ($alternative_payments as $payment_code) {
            $payment_method = $this->localpayments->getPaymentMethodValue($payment_code);
            $result[] = array('value' => $payment_code, 'label' => $payment_method);
        }
        return $result;
    }

}