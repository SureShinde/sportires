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
namespace Ced\StorePickup\Controller\Getmap;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class View extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context);
    }
    
    public function execute()
    {
        $sessStoreId = $this->checkoutSession->getData('storeId');
        $storeId = $this->_request->getParam('storeId');
        if(empty($sessStoreId)){
            $this->checkoutSession->setData('storeId', $storeId);}
            else{
                if($sessStoreId == $storeId){
                    $this->checkoutSession->setData('storeId', $storeId);
                }
                else{
                    $this->checkoutSession->setData('storeId', $storeId);
                }
            }
       
        $resultRedirect = $this->resultPageFactory->create();
        return $resultRedirect;
    }
}