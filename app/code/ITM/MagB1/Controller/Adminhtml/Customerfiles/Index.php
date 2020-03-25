<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Customerfiles;
    
class Index extends \ITM\MagB1\Controller\Adminhtml\Customerfiles
{
    
    /**
     * Customerfiles list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('ITM_MagB1::magb1');
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Files'));
        $resultPage->addBreadcrumb(__('ITM'), __('ITM'));
        $resultPage->addBreadcrumb(__('Customer Files'), __('Customer Files'));
        return $resultPage;
    }
}
