<?php
    
namespace ITM\Sportires\Controller\Adminhtml\Vehicletire;
    
class Edit extends \ITM\Sportires\Controller\Adminhtml\Vehicletire
{
    
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('ITM\Sportires\Model\Vehicletire');
        if ($id) {
            $model->load($id);
            if (!$model->getEntityId()) {
                $this->messageManager->addError(__('This item no longer exists.'));
                $this->_redirect('itm_sportires/*');
                return;
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $resultPage = $this->resultPageFactory->create();
        if ($id) {
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Items Entry'));
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('Add Items Entry'));
        }
    
        $this->_coreRegistry->register('current_itm_sportires_vehicletire', $model);
        $this->_initAction();
        $this->_view->getLayout()->getBlock('vehicletire_vehicletire_edit');
        $this->_view->renderLayout();
    }
}
