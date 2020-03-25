<?php
namespace ITM\MagB1\Model\Config;

use ITM\MagB1\Api\Config\ConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{

    /**
     *
     * @var \Magento\Framework\Api\SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     *
     * @var \Magento\Shipping\Model\Config
     */
    private $shippingConfig;

    /**
     * Payment method factory
     *
     * @var \Magento\Payment\Model\Method\Factory
     */
    private $paymentMethodFactory;

    /**
     *
     * @var \Magento\Indexer\Model\IndexerFactory
     */
    private $indexerFactory;

    /**
     *
     * @var Indexer\CollectionFactory
     */
    private $indexersFactory;

    /**
     *
     * @var \ITM\MagB1\Helper\Data
     */
    private $helper;

    /**
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Shipping\Model\Config $shippingConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Shipping\Model\Config $shippingConfig,
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Payment\Model\Method\Factory $paymentMethodFactory,
        \Magento\Indexer\Model\Indexer\CollectionFactory $indexersFactory,
        \ITM\MagB1\Helper\Data $helper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->shippingConfig = $shippingConfig;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->paymentMethodFactory = $paymentMethodFactory;
        $this->indexersFactory = $indexersFactory;
        $this->helper = $helper;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getCarrierList()
    {
        $isActiveOnlyFlag = true;
        $carriers = $this->shippingConfig->getAllCarriers();
        $shipping = [];
        foreach ($carriers as $carrierCode => $carrierModel) {
            if (! $carrierModel->isActive() && (bool) $isActiveOnlyFlag === true) {
                continue;
            }
            $carrierMethods = $carrierModel->getAllowedMethods();
            if (! $carrierMethods) {
                continue;
            }
            $carrierTitle = $this->scopeConfig->getValue(
                'carriers/' . $carrierCode . '/title',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            foreach ($carrierMethods as $methodCode => $methodTitle) {
                // Start
                $_code = $carrierCode . '_' . $methodCode;

                if ($methodTitle == false) {
                    $methodTitle = $_code;
                }
                if ($methodTitle == '') {
                    $methodTitle = $_code;
                }
                $shipping[] = [
                    'method_code' => (string) $_code,
                    'method_title' => (string) $methodTitle,
                    'carrier_title' => (string) $carrierTitle,
                    'code' => (string) $carrierCode
                ];
            }
        }
        $searchResult = $this->searchResultsFactory->create();
        //$searchResult->setSearchCriteria(null);
        $searchResult->setItems($shipping);
        $searchResult->setTotalCount(count($shipping));
        return $searchResult;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getPaymentMethodList()
    {
      /*  $result = [];
        foreach ($this->scopeConfig->getValue('payment', ScopeInterface::SCOPE_STORE, null) as $code => $data) {
            if (isset($data['active']) && (bool) $data['active'] && isset($data['model'])) {
                $result[] = [
                    "code" => $code,
                    "model" => $data
                ];
            }
        }
      */
        $result =  $this->helper->getPaymentMethodList();
        $searchResult = $this->searchResultsFactory->create();
        //$searchResult->setSearchCriteria(null);
        $searchResult->setItems($result);
        $searchResult->setTotalCount(count($result));
        return $searchResult;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function reIndex()
    {
        /** @var IndexerInterface[] $indexers */
        $indexers = $this->indexersFactory->create()->getItems();
        foreach ($indexers as $indexer) {
            $indexer->reindexAll();
        }
        return true;
    }
    /**
     *
     * {@inheritdoc}
     *
     */
    public function getVersion()
    {
        return  $this->helper->getVersion();

    }
}
