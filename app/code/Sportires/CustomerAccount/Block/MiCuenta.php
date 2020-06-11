<?php 

namespace Sportires\CustomerAccount\Block;
 
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface; 
 
class MiCuenta extends Template implements BlockInterface 
{
   protected $_template = "account.phtml";

    /**
     * @return string
     */
    public function accountMainMenuTop()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
    	$request = $objectManager->get('Magento\Framework\App\Action\Context')->getRequest();

	    /**
	    * @var \Magento\Store\Model\StoreManagerInterface $this->_storeManager
	    */

	    $baseUrl = $this->_storeManager->getStore()->getBaseUrl();



        if($customerSession->isLoggedIn()) {
        	if($request->getFullActionName() == "customer_account_index"){
            return '<li class="ui-menu-item level0">
                        <a href="'.$baseUrl.'customer/account/logout/" class="level-top"><span>Cerrar sesión</span></a>
                    </li>';
        	}else{
            return '<li class="ui-menu-item level0">
                        <a href="'.$baseUrl.'customer/account/" class="level-top"><span>MI CUENTA</span></a>
                    </li>';
            }
        }else{
            return '<li class="ui-menu-item level0">
                        <a href="'.$baseUrl.'customer/account/login/" class="level-top"><span>Iniciar sesión</span></a>
                    </li>';
        }

        
    }

}