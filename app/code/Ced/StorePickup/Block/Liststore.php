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

class Liststore extends \Magento\Framework\View\Element\Template
{
    protected $_timeFactory;
    protected $_objectManager;
    protected $context;
    protected $_request;
    protected $_countrys;
    protected $_storesFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Directory\Block\Data $_countrys,
        \Ced\StorePickup\Model\StoreHour $timeFactory,
        \Ced\StorePickup\Model\StoreInfo $storesFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = []
    ) {

        $this->_request=$context->getRequest();
        $this->_objectManager = $objectManager;
        $this->_storesFactory = $storesFactory;
        $this->_countrys = $_countrys;
        $this->_timeFactory = $timeFactory;
        parent::__construct($context, $data);
    }

    public function getAllStores() 
    {
        $data = $this->getRequest()->getPostValue();
        $country = '';
        $state = '';
        $city = '';
        if(isset($data['country_id'])) {
            $country = trim($data['country_id']);
        }
        
        if(isset($data['region_id'])) {
            $state = trim($data['region_id']);
        }

        if(isset($data['city'])) {
            $city = trim($data['city']);
        }
        
        $collection = $this->_storesFactory->getCollection()
            ->addFieldToFilter('is_active', '1');
        
        if($country) {
            $collection->addFieldToFilter('store_country', array('like'=>$country));
        }
        
        if($state) {
            $collection->addFieldToFilter('store_state', array('like'=>$state));
        }
        
        if($city) {
            $collection->addFieldToFilter('store_city', array('like'=>$city));
        }
        return $collection;
    }
    
    public function getFullRouteInfo() 
    {
        return $this->_request->getFullActionName();
    }
    
    public function getFullCon() 
    {
        return $this->_countrys->getCountryHtmlSelect();
    }
    
    public function getConfig($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}