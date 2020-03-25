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

namespace Ced\StorePickup\Controller\Stores;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Getstores extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        \Ced\StorePickup\Model\StoreInfo $storeinfo,
        \Ced\StorePickup\Model\StoreHour $storehour,
        PageFactory $resultPageFactory
    ) {
        $this->_storeinfo = $storeinfo;
        $this->_storehour = $storehour;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $config = [];
        $resultJson =$this->_objectManager->get('Magento\Framework\Controller\Result\JsonFactory')->create();
        $config = $this->getStores();
        return $resultJson->setData($config);
    }

    /**
     * @return string
     */
    public function getStores()
    {
        //$destCountryId = $this->_checkoutSession->getQuote()->getShippingAddress()->getCountryId();
        $destCountryId = $this->getRequest()->getParam('country_id');
        //echo $destCountryId;die('=-=-=');
        //$destCountryId = 'IN';
        $stores = array();
        $storeCollection = $this->_storeinfo->getCollection()->addFieldToFilter('is_active', '1')
                            ->addFieldToFilter('store_country',$destCountryId)->getData();

        $this->_options=['id'=>'', title=>'--Select Store--'];
        if(!empty($storeCollection)){
            foreach ($storeCollection as $value) {
                $stores['id'] = $value['pickup_id'];
                $stores['title'] = $value['store_name'];
                array_push($this->_options, $stores);
            }
        }

        return $this->_options;
    }

    /**
     * @return array
     */
    public function getDays()
    {
        $storeInfos = [];
        $daysCollection = $this->_storehour->getCollection()->addFieldToFilter('status', '0')->getData();

        if(isset($daysCollection)){
            foreach ($daysCollection as $value) {
                $storeInfos[$value['pickup_id']] = $value['days'];
            }
        }

        return $storeInfos;
    }

    public function getStoreDays($storeId)
    {
        $storeInfos = [];
        $this->_options=[];
        $daysCollection = $this->_storehour->getCollection()->addFieldToFilter('status', '0')->addFieldToFilter('pickup_id', $storeId)->getData();

        if(isset($daysCollection)){
            foreach ($daysCollection as $value) {
                $daycode = $this->getDaysCode($value['days']);
                $storeInfos[] = $daycode;
            }
        }

        return $storeInfos;
    }

    public function getInterval($storeId, $day){
        $storeInfo = [];
        $daysCollection = $this->_storehour->getCollection()->addFieldToFilter('pickup_id', $storeId)->addFieldToFilter('status', '1')->addFieldToFilter('days', $day)->getData();
        $this->_interval = [];
        if(isset($daysCollection)){
            foreach ($daysCollection as $value) {
                $storeInfo['id'] = $value['start'];
                $storeInfo['title'] = $value['end'];
                array_push($this->_interval, $storeInfo);
            }
        }
        return $this->_interval;
    }

    public function getDaysCode($day){

        $days = ['MONDAY'=>'1', 'TUESDAY'=>'2', 'WEDNESDAY'=>'3', 'THURSDAY'=> '4', 'FRIDAY'=>'5', 'SATURDAY' => '6', 'SUNDAY'=>'0' ];
        return $days[strtoupper($day)];
    }
}