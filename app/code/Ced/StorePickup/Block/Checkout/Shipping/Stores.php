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

namespace Ced\StorePickup\Block\Checkout\Shipping;


class Stores extends \Magento\Framework\View\Element\Template
{

	public function __construct(
		\Magento\Backend\Block\Widget\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,  
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Quote\Model\Quote\Address $quoteaddress,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Registry $registry,
        \Ced\StorePickup\Model\StoreInfo $storeinfo,
        \Ced\StorePickup\Model\StoreHour $storehour,
         array $data = []
        
    ) {
       	parent::__construct ( $context, $data );
        $this->_quoteaddress = $quoteaddress;
        $this->objectManager = $objectManager;
        $this->_storeinfo = $storeinfo;
        $this->_storehour = $storehour;
        $this->_customerSession = $customerSession; 
        $this->_checkoutSession = $checkoutSession;      
    }

    public function getStores(){
   		return $this->_storeinfo->getCollection()->addFieldToFilter('is_active', '1')->getData();
    }

    public function getStoreTimings($storeId, $day){
    	$storehours = $this->_storehour->getCollection()->addFieldToFilter('pickup_id', '1')->addFieldToFilter('days', 'Monday')->getData();
    	$storetiming = array();
    	if(isset($storehours)){
    		foreach($storehours as $storetmng){
	    		$storetiming['start'] = $storetmng['start'];
	    		$storetiming['end'] = $storetmng['end'];
    		}
    	}
    	return $storetiming;	
    }
}