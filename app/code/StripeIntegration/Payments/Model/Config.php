<?php

namespace StripeIntegration\Payments\Model;

use StripeIntegration\Payments\Helper;
use StripeIntegration\Payments\Helper\Logger;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public static $moduleName           = "Magento2";
    public static $moduleVersion        = "1.3.0";
    public static $moduleUrl            = "https://stripe.com/docs/plugins/magento";
    public static $partnerId            = "pp_partner_Fs67gT2M6v3mH7";
    const STRIPE_API                    = "2019-03-14";

    // active
    // title
    // stripe_mode
    // stripe_test_sk
    // stripe_mode
    // stripe_test_pk
    // stripe_mode
    // stripe_live_sk
    // stripe_mode
    // stripe_live_pk
    // stripe_mode
    // payment_action
    // expired_authorizations
    // payment_action
    // avs
    // ccsave
    // order_status
    // card_autodetect
    // cctypes
    // card_autodetect
    // allowspecific
    // specificcountry
    // sort_order

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Helper\Generic $helper,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        \Magento\Framework\Locale\Resolver $localeResolver
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->helper = $helper;
        $this->encryptor = $encryptor;
        $this->localeResolver = $localeResolver;

        $this->initStripe();
    }

    public function initStripe()
    {
        \Stripe\Stripe::setApiKey($this->getSecretKey());
        \Stripe\Stripe::setAppInfo($this::$moduleName, $this::$moduleVersion, $this::$moduleUrl, $this::$partnerId);
        \Stripe\Stripe::setApiVersion(\StripeIntegration\Payments\Model\Config::STRIPE_API);
    }

    public static function module()
    {
        return self::$moduleName . " v" . self::$moduleVersion;
    }

    public function getConfigData($field, $method = null)
    {
        $storeId = $this->helper->getStoreId();

        $section = "";
        if ($method)
            $section = "_$method";

        $data = $this->scopeConfig->getValue("payment/stripe_payments$section/$field", ScopeInterface::SCOPE_STORE, $storeId);

        return $data;
    }

    public function isEnabled()
    {
        $enabled = ((bool)$this->getConfigData('active')) && $this->getSecretKey() && $this->getPublishableKey();
        return $enabled;
    }

    public function getStripeMode()
    {
        return $this->getConfigData('stripe_mode', 'basic');
    }

    public function getSecretKey()
    {
        $mode = $this->getStripeMode();
        $key = $this->getConfigData("stripe_{$mode}_sk", "basic");

        // The following is due to a magento bug causing the key to need to be saved more than once to be decrypted correctly
        if (!preg_match('/^[A-Za-z0-9_]+$/',$key))
            $key = $this->encryptor->decrypt($key);

        return trim($key);
    }

    public function getPublishableKey()
    {
        $mode = $this->getStripeMode();
        return trim($this->getConfigData("stripe_{$mode}_pk", "basic"));
    }

    public function getWebhooksSigningSecret()
    {
        $mode = $this->getStripeMode();
        $key = $this->getConfigData("stripe_{$mode}_wss", "basic");

        // The following is due to a magento bug causing the key to need to be saved more than once to be decrypted correctly
        if (!preg_match('/^[A-Za-z0-9_]+$/',$key))
            $key = $this->encryptor->decrypt($key);

        return trim($key);
    }

    public function isAutomaticInvoicingEnabled()
    {
        return (bool)$this->getConfigData("automatic_invoicing");
    }

    public function getSecurityMethod()
    {
        // Older security methods have been depreciated
        return 2;
    }

    // If the module is unconfigured, payment_action will be null, defaulting to authorize & capture, so this would still return the correct value
    public function isAuthorizeOnly()
    {
        return ($this->getConfigData('payment_action') == \Magento\Payment\Model\Method\AbstractMethod::ACTION_AUTHORIZE);
    }

    public function isStripeRadarEnabled()
    {
        return (($this->getConfigData('radar_risk_level') > 0) && !$this->helper->isAdmin());
    }

    public function isApplePayEnabled()
    {
        return $this->getConfigData('apple_pay_checkout')
            && !$this->helper->isAdmin();
    }

    public function isPaymentRequestButtonEnabled()
    {
        return $this->isApplePayEnabled();
    }

    public function useStoreCurrency()
    {
        return (bool)$this->getConfigData('use_store_currency');
    }

    public function getSaveCards()
    {
        return $this->getConfigData('ccsave');
    }

    public function getStatementDescriptor()
    {
        return $this->getConfigData('statement_descriptor');
    }

    public function retryWithSavedCard()
    {
        return $this->getConfigData('expired_authorizations') == 1;
    }

    public function setIsStripeAPIKeyError($isError)
    {
        $this->isStripeAPIKeyError = $isError;
    }

    public function alwaysSaveCards()
    {
        return ($this->getSaveCards() == 2 || $this->helper->hasSubscriptions() || $this->helper->isMultiShipping());
    }

    public function isMOTOExemptionsEnabled()
    {
        return (bool)$this->getConfigData('moto_exemptions');
    }

    public function getIsStripeAPIKeyError()
    {
        if (isset($this->isStripeAPIKeyError))
            return $this->isStripeAPIKeyError;

        return false;
    }

    public function getApplePayLocation()
    {
        $location = $this->getConfigData('apple_pay_location');

        if (!$location)
            return 1;
        else
            return (int)$location;
    }

    public function getStripeJsLocale()
    {
        $supportedValues = ["ar", "da", "de", "en", "es", "fi", "fr", "he", "it", "ja", "lt", "ms", "nl", "no", "pl", "ru", "sv", "zh"];

        $locale = $this->localeResolver->getLocale();
        if (empty($locale))
            return "auto";

        $lang = strstr($locale, '_', true);
        if (in_array($lang, $supportedValues))
            return $lang;

        return "auto";
    }

    public function getAmountCurrencyFromQuote($quote, $useCents = true)
    {
        $params = array();
        $items = $quote->getAllItems();

        if ($this->useStoreCurrency())
        {
            $amount = $quote->getGrandTotal();
            $currency = $quote->getQuoteCurrencyCode();
        }
        else
        {
            $amount = $quote->getBaseGrandTotal();;
            $currency = $quote->getBaseCurrencyCode();
        }

        if ($useCents)
        {
            $cents = 100;
            if ($this->helper->isZeroDecimal($currency))
                $cents = 1;

            $fields["amount"] = round($amount * $cents);
        }
        else
        {
            // Used for Apple Pay only
            $fields["amount"] = number_format($amount, 2, '.', '');
        }

        $fields["currency"] = $currency;

        return $fields;
    }

    public function getStripeParamsFrom($order)
    {
        if ($this->useStoreCurrency())
        {
            $amount = $order->getGrandTotal();
            $currency = $order->getOrderCurrencyCode();
        }
        else
        {
            $amount = $order->getBaseGrandTotal();
            $currency = $order->getBaseCurrencyCode();
        }

        $cents = 100;
        if ($this->helper->isZeroDecimal($currency))
            $cents = 1;

        $metadata = [
            "Module" => Config::module(),
            "Order #" => $order->getIncrementId()
        ];
        if ($order->getCustomerIsGuest())
        {
            $customer = $this->helper->getGuestCustomer($order);
            $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();
            $metadata["Guest"] = "Yes";
        }
        else
            $customerName = $order->getCustomerName();

        if ($this->helper->isMultiShipping())
            $description = "Multi-shipping Order #" . $order->getRealOrderId().' by ' . $customerName;
        else
            $description = "Order #" . $order->getRealOrderId().' by ' . $customerName;

        $params = array(
          "amount" => round($amount * $cents),
          "currency" => $currency,
          "description" => $description,
          "metadata" => $metadata
        );

        $customerEmail = $this->helper->getCustomerEmail();
        if ($customerEmail)
            $params["receipt_email"] = $customerEmail;

        return $params;
    }
}
