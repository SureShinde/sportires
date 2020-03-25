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

class Daytimings extends \Magento\Framework\View\Element\Template
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
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Ced\StorePickup\Model\StoreHour $storeTime,
        \Ced\StorePickup\Model\StoreInfo $storeInfo,
        array $data = []
    ) {

        $this->_request=$context->getRequest();
        $this->_objectManager = $objectManager;
        $this->_countrys = $_countrys;
        $this->checkoutSession = $checkoutSession;
        $this->_storeTime = $storeTime;
        $this->_storeInfo = $storeInfo;
        parent::__construct($context, $data);
        self::getTimings();
    }

    public function getDay() 
    {
        $storeDate = $this->getRequest()->getParam('storepkp_date');
        $nameOfDay = date('l', strtotime($storeDate));
        return $nameOfDay;
    }

    public function getStoreId(){
        return $this->checkoutSession->getData('storeId');
    }

    public function getTimings(){

        $timings = [];
        $storeTimings = $this->_storeTime->getCollection()->addFieldToFilter('pickup_id', $this->getStoreId())->addFieldToFilter('days', $this->getDay())->addFieldToFilter('status', '1')->getData();

        if(!empty($storeTimings)){
            foreach ($storeTimings as $value) {
              $timings['opening'] = $value['start'];
              $timings['closing'] = $value['end']; 
              $timings['interval'] = $value['interval']; 
            }
            
            return $timings;
        }
    }

    public function getBaseUrl()
    {
        return $this->_urlInterface->getBaseUrl();
    }

    
}
