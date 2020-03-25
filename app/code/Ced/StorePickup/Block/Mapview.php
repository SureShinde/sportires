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

class Mapview extends \Magento\Framework\View\Element\Template
{
    
    protected $_objectManager;
    protected $context;
    protected $_storesFactory;
    protected $_timeFactory;
    protected $_request;
    protected $_countrys;
    protected $_urlInterface;
    protected $helper;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Directory\Block\Data $_countrys,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Ced\StorePickup\Model\StoreHour $timeFactory,
        \Ced\StorePickup\Model\StoreInfo $storesFactory,
        \Ced\StorePickup\Helper\Data $helper,
        \Magento\Framework\UrlInterface $url,
        array $data = []
    ) {
        $this->_request=$context->getRequest();
        $this->_objectManager = $objectManager;
        $this->_timeFactory = $timeFactory;
        $this->_storesFactory = $storesFactory;
        $this->_countrys = $_countrys;
        $this->_urlInterface = $url;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    public function getAllStores() 
    {
        $collection = $this->_storesFactory->getCollection()->addFieldToFilter('is_active', '1');
        return $collection;
    }

    public function getAllStoresMarker() 
    {
        $storesCollection = $this->getAllStores();
        $markers = array();
        $i = 1;
        $totalStoreCount = count($storesCollection);

        foreach($storesCollection as $stores) 
        {  
            $storeName = $stores->getStoreName();
            $storeLat =  $stores->getLatitude();
            $storeLong = $stores->getLongitude();
            $storeRadius = '0';
            $storeZoomLevel ='15';
            $markers[$i]['name'] = $storeName;
            $markers[$i]['lat'] = $stores->getLatitude();
            $markers[$i]['long'] = $stores->getLongitude();
            $markers[$i]['storeid'] = $stores->getPickupId();
            $markers[$i]['storemgrname'] = $stores->getStoreManagerName();
            $markers[$i]['storephone'] = $stores->getStorePhone();
            $markers[$i]['storeemail'] = $stores->getStoreManagerEmail();

            $i++;
        }
        return $markers;
    }

    public function getBaseUrl()
    {
        return $this->_urlInterface->getBaseUrl();
    }
    
    public function getMapKey()
    {
        return $this->helper->getStoreConfig('carriers/storepickupshipping/map_apikey');
    }
}
