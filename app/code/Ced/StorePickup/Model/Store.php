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

namespace Ced\StorePickup\Model;

use Magento\Framework\DataObject;


class Store extends DataObject
{

    public function __construct(
        \Ced\StorePickup\Model\StoreInfo $storeinfo
        )
    {
        $this->_storeinfo = $storeinfo;
    }
    /**
     * @return string
     */
    public function getName()
    {
        $storeCollection = $this->_storeinfo->getCollection()->addFieldToFilter('is_active', '1')->getData();
        if(isset($storeCollection)){
            foreach ($storeCollection as $value) {  
                $storename = $value['store_name'];
                return (string)$storename;
            }
        }   
        
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return (string)$this->_getData('location');
    }
}
