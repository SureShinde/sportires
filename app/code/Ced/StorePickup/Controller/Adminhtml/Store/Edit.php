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
namespace Ced\StorePickup\Controller\Adminhtml\Store;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    
    protected $_coreRegistry = null;

   
    protected $resultPageFactory;

   
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

   
    protected function _isAllowed()
    {
        return true;
    }

    public function execute()
    {
        
        $id = $this->getRequest()->getParam('pickup_id');
        $model = $this->_objectManager->create('Ced\StorePickup\Model\StoreInfo');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This post no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('storepickup_data', $model);
        $resultPage = $this->resultPageFactory->create();
          $resultPage->getConfig()->getTitle()
              ->prepend($model->getId() ? __("Edit Pickup Store '%1' ", $model->getStoreName()) : __('New Pickup Store'));

        return $resultPage;
    }
}