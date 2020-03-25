<?php

namespace StripeIntegration\Payments\Model\Method\Api;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Payment\Model\InfoInterface;
use StripeIntegration\Payments\Helper;
use StripeIntegration\Payments\Helper\Logger;

abstract class Sources extends \Magento\Payment\Model\Method\AbstractMethod
{
    protected $type = '';

    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = '';

    /**
     * @var string
     */
    //protected $_formBlockType = 'StripeIntegration\Payments\Block\Form';
    protected $_infoBlockType = 'StripeIntegration\Payments\Block\Info';

    /**
     * Payment Method feature
     *
     * @var bool
     */
    protected $_canAuthorize = true;
    protected $_canCapture = true;
    protected $_canCapturePartial = true;
    protected $_canCaptureOnce = true;
    protected $_canRefund = true;
    protected $_canRefundInvoicePartial = true;
    protected $_isGateway = true;
    protected $_isInitializeNeeded = true;
    protected $_canVoid = true;
    protected $_canUseInternal = false;
    protected $_canFetchTransactionInfo = true;
    protected $_canUseForMultishipping  = false;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \StripeIntegration\Payments\Model\Config
     */
    protected $config;

    /**
     * @var Helper\Generic
     */
    protected $helper;

    /**
     * @var Helper\Api
     */
    protected $api;

    /**
     * @var \StripeIntegration\Payments\Model\StripeCustomer
     */
    protected $customer;

    /**
     * @var \Magento\Payment\Model\Method\Logger
     */
    protected $logger;

    /**
     * @var \Magento\Checkout\Helper\Data
     */
    protected $checkoutHelper;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Magento\Payment\Helper\Data $paymentData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Payment\Model\Method\Logger $logger
     * @param \Magento\Checkout\Helper\Data $checkoutHelper
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \StripeIntegration\Payments\Model\Config $config,
        \StripeIntegration\Payments\Helper\Generic $helper,
        \StripeIntegration\Payments\Helper\Api $api,
        \StripeIntegration\Payments\Model\StripeCustomer $customer,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Checkout\Helper\Data $checkoutHelper,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $resource,
            $resourceCollection,
            $data
        );

        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;

        $this->config = $config;
        $this->helper = $helper;
        $this->api = $api;
        $this->customer = $customer;
        $this->logger = $logger;
        $this->request = $request;
        $this->checkoutHelper = $checkoutHelper;

        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check whether payment method can be used
     *
     * @param \Magento\Quote\Api\Data\CartInterface|null $quote
     * @return bool
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        if (parent::isAvailable($quote) === false) {
            return false;
        }

        if (!$this->isActive($quote ? $quote->getStoreId() : null)) {
            return false;
        }

        if (!$quote) {
            return false;
        }

        // Check currency is allowed
        $allowCurrencies = $this->getConfigData('allow_currencies');
        if (!$allowCurrencies && in_array($this->type, ['alipay', 'wechat']))
            return true;

        $allowedCurrencies = $this->getConfigData('allowed_currencies');

        // This is the "All currencies" setting
        if (!$allowedCurrencies)
            return true;

        $allowedCurrencies = explode(',', $allowedCurrencies);
        if (!in_array($quote->getQuoteCurrencyCode(), $allowedCurrencies))
            return false;

        return true;
    }

    /**
     * Method that will be executed instead of authorize or capture
     * if flag isInitializeNeeded set to true
     *
     * @param string $paymentAction
     * @param object $stateObject
     *
     * @return $this
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @api
     */
    public function initialize($paymentAction, $stateObject)
    {
        /** @var \Magento\Quote\Model\Quote\Payment $info */
        $info = $this->getInfoInstance();

        /** @var \Magento\Sales\Model\Order $order */
        $order = $info->getOrder();
        $quote = $order->getQuote();

        // Prepare Order
        $order->setCanSendNewEmailFlag(false);

        // Prepare params
        if ($this->config->getConfigData('use_store_currency')) {
            $amount = $order->getGrandTotal();
            $currency = $order->getOrderCurrencyCode();
        } else {
            $amount = $order->getBaseGrandTotal();
            $currency = $order->getBaseCurrencyCode();
        }

        $cents = $this->helper->isZeroDecimal($currency) ? 1 : 100;

        $params = [
            'amount' => round($amount * $cents),
            'currency' => $currency,
            'description' => sprintf('Order #%s by %s', $order->getIncrementId(), $order->getCustomerName()),
        ];

        $customerEmail = $this->helper->getCustomerEmail();
        if ($customerEmail)
            $params['receipt_email'] = $customerEmail;

        $params['type'] = $this->type;
        $params['owner'] = [
            'name'  => $order->getCustomerName(),
            'email' => (string)($this->getTestEmail() ? $this->getTestEmail() : $order->getBillingAddress()->getEmail() )
        ];
        $params['redirect'] = [
            'return_url' => $this->urlBuilder->getUrl('stripe/payment/index', ['_secure' => $this->request->isSecure()])
        ];
        $params['metadata'] = [
            'Order #' => $order->getIncrementId(),
        ];

        // Add Statement Descriptor
        $statementDescriptor = $this->getConfigData('statement_descriptor');
        if (!empty($statementDescriptor)) {
            $params[$this->type] = [
                'statement_descriptor' => $statementDescriptor
            ];
        }

        if ($this->type === 'sepa_debit')
        {
            // Make the source reusable
            unset($params['amount']);

            // Add IBAN
            $iban = $info->getAdditionalInformation('iban');
            if (empty($iban)) {
                throw new LocalizedException(__('No IBAN provided.'));
            }

            $params[$this->type] = [
                'iban' => $iban
            ];
        }

        // Add Country
        if ($this->type === 'sofort') {
            $params[$this->type] = [
                'country' => $order->getBillingAddress()->getCountryId()
            ];
        }

        // Clean params
        $this->cleanParams($params);

        try {
            // Init Stripe Source
            $source = \Stripe\Source::create($params);

            $info->setAdditionalInformation('source_id', $source->id);

            // Add payment method to the customer
            if ($this->config->getSaveCards() || $this->type === 'sepa_debit')
            {
                try
                {
                    $stripeCustomer = $this->getStripeCustomer($order);
                    $stripeCustomer->sources->create(array('source' => $source));
                }
                catch (\Stripe\Error $e)
                {
                    throw new LocalizedException(__($e->getMessage()));
                }
                catch (\Stripe\Error\Card $e)
                {
                    throw new LocalizedException(__($e->getMessage()));
                }
                catch (\Exception $e)
                {
                    $this->helper->dieWithError(__('An error has occurred. Please contact us to complete your order.'), $e);
                }

                $info->setAdditionalInformation('customer_stripe_id', $stripeCustomer->id);
            }

            // Save values in session
            $session = $this->checkoutHelper->getCheckout();

            if (!empty($source->redirect->url))
            {
                $session->setStripePaymentsRedirectUrl($source->redirect->url);
            }
            elseif ($this->type === 'sepa_debit')
            {
                $redirect_url = $this->urlBuilder->getUrl('stripe/payment/index',
                    [
                        '_secure' => $this->request->isSecure(),
                        'source' => $source->id,
                        'client_secret' => $source->client_secret
                    ]
                );
                $session->setStripePaymentsRedirectUrl($redirect_url);
            }
            else if (!empty($source->wechat->qr_code_url))
            {
                $session->setStripePaymentsRedirectUrl($source->wechat->qr_code_url);
            }
            else
            {
                $session->setStripePaymentsRedirectUrl(null);
            }

            $session->setStripePaymentsClientSecret($source->client_secret);
        }
        catch (\Stripe\Error\Card $e)
        {
            throw new LocalizedException(__($e->getMessage()));
        }
        catch (\Stripe\Error $e)
        {
            throw new LocalizedException(__($e->getMessage()));
        }
        catch (\Exception $e)
        {
            if (strstr($e->getMessage(), 'Invalid country') !== false) {
                throw new LocalizedException(__('Sorry, this payment method is not available in your country.'));
            }
            throw new LocalizedException(__($e->getMessage()));
        }

        return $this;
    }

    /**
     * Cancel payment
     * @param \Magento\Payment\Model\InfoInterface $payment
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     * @api
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function cancel(InfoInterface $payment, $amount = null)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        /** @var \Magento\Payment\Helper\Data $helper */
        $helper = $objectManager->get('Magento\Payment\Helper\Data');

        /** @var \StripeIntegration\Payments\Model\PaymentMethod $method */
        $method = $helper->getMethodInstance('stripe_payments');

        $method->cancel($payment, $amount);
    }

    /**
     * Refund specified amount for payment
     * @param \Magento\Payment\Model\InfoInterface $payment
     * @param float $amount
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     * @api
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function refund(InfoInterface $payment, $amount)
    {
        $this->cancel($payment, $amount);

        return $this;
    }

    /**
     * Void payment method
     *
     * @param \Magento\Framework\DataObject|InfoInterface $payment
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     * @api
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function void(InfoInterface $payment)
    {
        $this->cancel($payment);

        return $this;
    }

    // Fixes https://github.com/magento/magento2/issues/5413 in Magento 2.1
    public function setId($code) { }
    public function getId() { return $this->_code; }

    /**
     * The Sources API throws an error if an unknown parameter is passed.
     * Delete all non-allowed params
     * @param $params
     */
    protected function cleanParams(&$params)
    {
        $allowed = array_flip(['type', 'amount', 'currency', 'owner', 'redirect', 'metadata', $this->type]);
        $params = array_intersect_key($params, $allowed);
    }

    /**
     * Get Stripe Customer object
     * @param \Magento\Sales\Model\Order $order
     *
     * @return \Stripe\Customer
     * @throws LocalizedException
     */
    protected function getStripeCustomer($order = null)
    {
        if ($this->customer->_stripeCustomer) {
            return $this->customer->_stripeCustomer;
        }

        if ($order) {
            $email = (string)$order->getBillingAddress()->getEmail();
            $customer = $this->customer->getCollection()
                           ->addFieldToFilter('customer_email', $email)
                           ->addFieldToFilter('customer_id', (int)$this->helper->getCustomerId())
                           ->load()->getFirstItem();

            if ($customer->getId()) {
                $stripeCustomer = $customer->retrieveByStripeID($customer->getStripeId());
            } else {
                // Create Customer
                $stripeCustomer = $this->customer->createStripeCustomer($order);
            }

            return $stripeCustomer;
        }

        throw new LocalizedException(__('Could not set up customer profile'));
    }

    /**
     * For testing multibanco
     * @return bool
     */
    public function getTestEmail()
    {
        return false;
    }

    /**
     * For testing multibanco
     * @return bool
     */
    public function getTestName()
    {
        return false;
    }

    /**
     * For validating Multibanco test emails
     * @param $email
     * @return bool
     */
    public function isEmailValid($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;

        return false;
    }
}
