<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Invoicefiles;
    
class Index extends \ITM\MagB1\Controller\Adminhtml\Invoicefiles
{
    
    /**
     * Invoicefiles list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('ITM_MagB1::magb1');
        $resultPage->getConfig()->getTitle()->prepend(__('Invoice Files'));
        $resultPage->addBreadcrumb(__('ITM'), __('ITM'));
        $resultPage->addBreadcrumb(__('Invoice Files'), __('Invoice Files'));
        return $resultPage;
    }
}
