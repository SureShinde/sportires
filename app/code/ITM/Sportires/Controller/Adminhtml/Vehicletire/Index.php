<?php
    
namespace ITM\Sportires\Controller\Adminhtml\Vehicletire;
    
class Index extends \ITM\Sportires\Controller\Adminhtml\Vehicletire
{
    
    /**
     * Vehicletire list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('ITM_Sportires::sportires');
        $resultPage->getConfig()->getTitle()->prepend(__('Vehicle Tire'));
        $resultPage->addBreadcrumb(__('ITM'), __('ITM'));
        $resultPage->addBreadcrumb(__('Vehicle Tire'), __('Vehicle Tire'));
        return $resultPage;
    }
}
