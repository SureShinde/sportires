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
namespace Ced\StorePickup\Block;

class Storeviews extends \Magento\Framework\View\Element\Template
{
    
    protected $_objectManager;
    protected $context;
    protected $_storesFactory;
    protected $_timeFactory;
    protected $_request;
    protected $_countrys;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Directory\Block\Data $_countrys,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Ced\StorePickup\Model\StoreHour $timeFactory,
        \Ced\StorePickup\Model\StoreInfo $storesFactory,
        array $data = []
    ) {
        $this->_request=$context->getRequest();
        $this->_objectManager = $objectManager;
        $this->_timeFactory = $timeFactory;
        $this->_storesFactory = $storesFactory;
        $this->_countrys = $_countrys;
        $this->_countryFactory = $countryFactory;
        $this->storeId = $this->getRequest()->getParam('storeId');
        $this->store = $this->_storesFactory->load($this->storeId);        
        parent::__construct($context, $data);
    }

    public function getStoreManagerName(){
        
        return $this->store->getStoreManagerName();
    }

    public function getStoreName(){
        
        return $this->store->getStoreName();
    }

    public function getStoreAddress(){
        
        return $this->store->getStoreAddress();
    }
 
    public function getStoreCity(){
        
        return $this->store->getStoreCity();
    }
    public function getStoreState(){
        
        return $this->store->getStoreState();
    }

    public function getStorePincode(){

        return $this->store->getStoreZcode();
    }

    public function getStoreCountryName(){

        $store_country = $this->store->getStoreCountry();
        $country = $this->_countryFactory->create()->loadByCode($store_country);
        return $country->getName();
    }

    public function getStoreLocation(){
        $location = [];
        $location['latitude'] = $this->store->getLatitude();
        $location['longitude'] = $this->store->getLongitude();
        return $location;
    }

    public function getContactNumber(){

        return $this->store->getStorePhone();
    }

    public function getStoreOffDays()
    {    
        $storeInfos = [];
        $this->_options=[];
        $daysCollection = $this->_timeFactory->getCollection()->addFieldToFilter('status', '0')->addFieldToFilter('pickup_id', $this->storeId)->getData();
        
        if(isset($daysCollection)){
            foreach ($daysCollection as $value) {
                $daycode = $this->getDaysCode($value['days']);
                $storeInfos[] = $daycode;
            }
        }
        return $storeInfos;
    }

    public function getDaysCode($day){

        $days = ['MONDAY'=>'1', 'TUESDAY'=>'2', 'WEDNESDAY'=>'3', 'THURSDAY'=> '4', 'FRIDAY'=>'5', 'SATURDAY' => '6', 'SUNDAY'=>'0' ];
        return $days[strtoupper($day)];
    }
}