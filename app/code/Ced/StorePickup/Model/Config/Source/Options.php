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
    namespace Ced\StorePickup\Model\Config\Source;

    use Magento\Eav\Setup\EavSetup;
    use Magento\Eav\Setup\EavSetupFactory;
    use Magento\Framework\Setup\UpgradeDataInterface;
    use Magento\Framework\Setup\ModuleDataSetupInterface;
    use Magento\Framework\Setup\ModuleContextInterface;

class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
		
	protected $optionFactory;

	public function __construct(
		\Ced\StorePickup\Model\StoreInfo $storeinfo
		) {
			$this->_storeinfo = $storeinfo;
	}
	
	public function getAllOptions()
	{

		$stores = array();
		$storeCollection = $this->_storeinfo->getCollection()->addFieldToFilter('is_active', '1')->getData();
		$this->_options=[];
		if(isset($storeCollection)){
			foreach ($storeCollection as $value) {	
				$stores['label'] = $value['store_name'];
				$stores['value'] = $value['pickup_id'];
				array_push($this->_options, $stores);
			}
		}	
		/* your Attribute options list*/		
		return $this->_options;
	}
}
