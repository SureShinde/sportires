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
 
namespace Ced\StorePickup\Controller\Main;
class Check extends \Magento\Framework\App\Action\Action
{
	/**
     * Index action
     *
     * @return void
     */
	public function execute(){
		$data = $this->getRequest()->getParams();
        $json = array('success'=>0,'module_name'=>'','module_license'=>'');
        if($data && isset($data['module_name'])) {          
            $json['module_name'] = strtolower($data['module_name']);
            $json['module_license'] =  $this->_objectManager->get('Ced\StorePickup\Helper\Feed')->getStoreConfig(\Ced\StorePickup\Block\Extensions::HASH_PATH_PREFIX.strtolower($data['module_name']));
            if(strlen($json['module_license']) > 0) $json['success'] = 1;
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $resultJson =$this->_objectManager->get('Magento\Framework\Controller\Result\JsonFactory')->create();
            return $resultJson->setData(json_encode($json));
        } else {
            $this->_forward('noroute');
        }
	}
}