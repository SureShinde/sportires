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

class StoreManagement
{
    protected $storeFactory;

    /**
     * StoreManagement constructor.
     * @param StoreInterfaceFactory $storeInterfaceFactory
     */
    public function __construct(
        \Ced\StorePickup\Model\StoreInfo $storeinfo
        )
    {
        $this->_storeinfo = $storeinfo;
    }

    /**
     * Get stores for the given postcode and city
     *
     * @param string $postcode
     * @param string $limit
     * @return \Ced\StorePickup\Api\Data\StoreInterface[]
     */
    public function fetchNearestStores($postcode, $city)
    {
        $result = [];
        $stores = [];
        $storeCollection = $this->_storeinfo->getCollection()->addFieldToFilter('is_active', '1')->getData();
        if(isset($storeCollection)){
            foreach ($storeCollection as $value) {  
                $stores['label'] = $value['store_name'];
                $stores['value'] = $value['pickup_id'];
                array_push($result, $stores);
            }
        }   
    
        return $result;
    }
}
