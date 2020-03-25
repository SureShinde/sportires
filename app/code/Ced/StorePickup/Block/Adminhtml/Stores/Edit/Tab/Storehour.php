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
 namespace Ced\StorePickup\Block\Adminhtml\Stores\Edit\Tab;

class Storehour extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    
    protected $_systemStore;
 
    protected $_wysiwygConfig;
    protected $_storesFactory;
    protected $_status;
    protected $_collectionFactory;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param \Magento\Store\Model\System\Store       $systemStore
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $registry,
        \Ced\StorePickup\Helper\Data $cedhelper,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Ced\StorePickup\Model\Status $status,
        \Ced\StorePickup\Model\StoreHour $storesFactory,
        array $data = []
    ) {
        $this->cedhelper = $cedhelper;
        $this->_storesFactory = $storesFactory;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }
 


    public function getPickupHour($pickupid)
    {
        $collection = $this->_storesFactory->getCollection()
            ->addFieldToFilter('pickup_id', $pickupid)
            ->getData();
        if(isset($collection)) {

              return $collection;
        } 
    }
    
    public function getStoreTiming() 
    {
        
        $timingArray = array('00:00'=>'00:00', '00:15'=>'00:15', '00:30'=>'00:30', '00:45'=>'00:45', '01:00'=>'01:00',
        '01:15'=>'01:15', '01:30'=>'01:30', '01:45'=>'01:45', '02:00'=>'02:00', '02:15'=>'02:15', '02:30'=>'02:30',
        '02:45'=>'02:45', '03:00'=>'03:00', '03:15'=>'03:15', '03:30'=>'03:30', '03:45'=>'03:45', '04:00'=>'04:00',
        '04:15'=>'04:15', '04:30'=>'04:30', '04:45'=>'04:45', '05:00'=>'05:00', '05:15'=>'05:15', '05:30'=>'05:30',
        '05:45'=>'05:45', '06:00'=>'06:00', '06:15'=>'06:15', '06:30'=>'06:30', '06:45'=>'06:45', '07:00'=>'07:00',
        '07:15'=>'07:15', '07:30'=>'07:30', '07:45'=>'07:45', '08:00'=>'08:00', '08:15'=>'08:15', '08:30'=>'08:30',
        '08:45'=>'08:45', '09:00'=>'09:00', '09:15'=>'09:15', '09:30'=>'09:30', '09:45'=>'09:45', '10:00'=>'10:00',
        '10:15'=>'10:15', '10:30'=>'10:30', '10:45'=>'10:45', '11:00'=>'11:00', '11:15'=>'11:15', '11:30'=>'11:30',
        '11:45'=>'11:45', '12:00'=>'12:00', '12:15'=>'12:15', '12:30'=>'12:30', '12:45'=>'12:45', '13:00'=>'13:00',
        '13:15'=>'13:15', '13:30'=>'13:30', '13:45'=>'13:45', '14:00'=>'14:00', '14:15'=>'14:15', '14:30'=>'14:30',
        '14:45'=>'14:45', '15:00'=>'15:00', '15:15'=>'15:15', '15:30'=>'15:30', '15:45'=>'15:45', '16:00'=>'16:00',
        '16:15'=>'16:15', '16:30'=>'16:30', '16:45'=>'16:45', '17:00'=>'17:00', '17:15'=>'17:15', '17:30'=>'17:30',
        '17:45'=>'17:45', '18:00'=>'18:00', '18:15'=>'18:15', '18:30'=>'18:30', '18:45'=>'18:45', '19:00'=>'19:00',
        '19:15'=>'19:15', '19:30'=>'19:30', '19:45'=>'19:45', '20:00'=>'20:00', '20:15'=>'20:15', '20:30'=>'20:30',
        '20:45'=>'20:45', '21:00'=>'21:00', '21:15'=>'21:15', '21:30'=>'21:30', '21:45'=>'21:45', '22:00'=>'22:00',
        '22:15'=>'22:15', '22:30'=>'22:30', '22:45'=>'22:45', '23:00'=>'23:00', '23:15'=>'23:15', '23:30'=>'23:30',
        '23:45'=>'23:45');
        return $timingArray;
    }
    
    public function getStoreStatus() 
    {
        return array(
        '0' => 'Disable',
        '1' => 'Enable'
        );
    }

    public function getStoreInterval() 
    {
         return array(
        '15' => '15 minutes',
        '30' => '30 minutes',
                '60' => '1 hours'
         );
    }
    
    public function getTabLabel() 
    {
        return __('Hour Of Operation');
    }

    
    public function getTabTitle() 
    {
        return __('Hour Of Operation');
    }

    
    public function canShowTab() 
    {
        return true;
    }

    public function isHidden() 
    {
        return false;
    }

   
    protected function _isAllowedAction($resourceId) 
    {
        
        return $this->_authorization->isAllowed($resourceId);
    }
 
    public function getMapKey()
    {
        return $this->cedhelper->getStoreConfig('carriers/storepickupshipping/map_apikey');
    }
}
