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

namespace Ced\StorePickup\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;

class Storepickup extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'storepickupshipping';
    
    protected $_logger;
    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    protected $_rateResultFactory;
    
    protected $_storesFactory;
    protected $_timeFactory;
    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface          $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory  $rateErrorFactory
     * @param \Psr\Log\LoggerInterface                                    $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory                  $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array                                                       $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Ced\StorePickup\Model\StoreInfo $storesFactory,
        \Ced\StorePickup\Model\StoreHour $timeFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollection,
        array $data = []
    ) {
        $this->_countryCollection = $countryCollection;
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_storesFactory = $storesFactory;
        $this->_timeFactory = $timeFactory;
        $this->scopeconfig = $scopeConfig;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * Check if carrier has shipping tracking option available
     *
     * @return bool
     */
    public function isTrackingAvailable()
    {
        return false;
    }
    /**
     * @param RateRequest $request
     * @return \Magento\Shipping\Model\Rate\Result|bool
     */
    public function collectRates(RateRequest $request)
    {
 
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = $this->_rateResultFactory->create();

        $options = $this->_countryCollection->create()->loadByStore()
                    ->setForegroundCountries($this->getTopDestinations())
                        ->toOptionArray();
        $availableCountries = $this->scopeconfig->getValue('carriers/storepickupshipping/specificcountry');
        $title = $this->scopeconfig->getValue('carriers/storepickupshipping/title');
        $method_name = $this->scopeconfig->getValue('carriers/storepickupshipping/name');
        if($availableCountries != ''){
            $availableCountries = explode(',', $availableCountries);
        }
        else{
           foreach ($options as $value) {
                $availableCountries[] = $value['value'];
            } 
        }
        
        $result =  $this->_rateResultFactory->create();
      

        $savedrates =$this->scopeconfig->getValue('carriers/storepickupshipping/shipping_price');

        if(empty($savedrates)) {
            $savedrates = 0;
        }
        $destCountryId = $request->getDestCountryId();
        //echo $destCountryId;
        //$destCountryId = 'IN';
        $storeInfo = $this->_storesFactory->getCollection()->addFieldToFilter('is_active',1)
                        ->addFieldToFilter('store_country',$destCountryId)->getData();
        //echo $destCountryId;
        //print_r($storeInfo);die('=-=-=-=');
        if(!empty($storeInfo)){
        	if(in_array($request->getDestCountryId(), $availableCountries)) {
        		$method = $this->_rateMethodFactory->create();
        		$custom_method = $this->_code;
        		$method->setCarrier($this->_code);
        		$method->setCarrierTitle(__($title));
        		$method->setMethod($custom_method);
        		$method->setMethodTitle(__($method_name));
        		$method->setCost($savedrates);
        		$method->setPrice($savedrates);
        		$result->append($method);
        	}else{
        		$error = $this->_rateErrorFactory->create();;
        		$error->setCarrier($this->_code);
        		$error->setCarrierTitle($this->getConfigData('title'));
        		$error->setErrorMessage($this->getConfigData('specificerrmsg'));
        		$result->append($error);
        	}
        }
       
        return $result;
    }
    
    
    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        
        return ['storepickupshipping' => $this->getConfigData('name')];
    }
}