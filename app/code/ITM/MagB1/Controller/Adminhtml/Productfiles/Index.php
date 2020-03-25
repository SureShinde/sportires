<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Productfiles;
    
class Index extends \ITM\MagB1\Controller\Adminhtml\Productfiles
{
    
    /**
     * Productfiles list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('ITM_MagB1::magb1');
        $resultPage->getConfig()->getTitle()->prepend(__('Product Files'));
        $resultPage->addBreadcrumb(__('ITM'), __('ITM'));
        $resultPage->addBreadcrumb(__('Product Files'), __('Product Files'));
        return $resultPage;
    }
}
