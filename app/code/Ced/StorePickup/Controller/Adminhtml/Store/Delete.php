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

class Delete extends \Magento\Backend\App\Action
{

    public function __construct(Action\Context $context) 
    {
        parent::__construct($context);
    }

    public function execute() 
    {
        $id = $this->getRequest()->getParam('pickup_id');
        $model = $this->_objectManager->create('Ced\StorePickup\Model\StoreInfo');
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $model->load($id);
            $model->delete();
            $coll = $this->_objectManager->create('Ced\StorePickup\Model\StoreHour');
            $coll = $coll->getCollection()
                ->addFieldToFilter('pickup_id', $id)
                ->getData();
            foreach($coll as $val){
                $deleteObject = $this->_objectManager->create('Ced\StorePickup\Model\StoreHour');
                $deleteObject->load($val['id']);
                $deleteObject->delete();
            }
            $this->messageManager->addSuccess(__('Deleted Successfully'));
            return $resultRedirect->setPath('*/store/');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while deleting the pickup store.'));
        }
        return $resultRedirect->setPath('*/*/delete', ['pickup_id' => $this->getRequest()->getParam('pickup_id')]);
    }
}
