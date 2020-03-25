<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Categoryfiles;
    
class Index extends \ITM\MagB1\Controller\Adminhtml\Categoryfiles
{
    
    /**
     * Categoryfiles list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('ITM_MagB1::magb1');
        $resultPage->getConfig()->getTitle()->prepend(__('Categoryfiles'));
        $resultPage->addBreadcrumb(__('ITM'), __('ITM'));
        $resultPage->addBreadcrumb(__('Categoryfiles'), __('Categoryfiles'));
        return $resultPage;
    }
}
