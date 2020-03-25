<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Invoicefiles;
    
class MassDelete extends \ITM\MagB1\Controller\Adminhtml\Invoicefiles
{
    protected $helper;
    
    /**
     * Initialize Group Controller
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \ITM\MagB1\Helper\Data $dataHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \ITM\MagB1\Helper\Data $dataHelper
        ) {
            $this->helper = $dataHelper;
            parent::__construct($context, $coreRegistry, $resultForwardFactory, $resultPageFactory);
    }
    
    
    /**
     * @return void
     */
    public function execute()
    {
        $itemsIds = $this->getRequest()->getParam('entity_id');
        if (!is_array($itemsIds)) {
            $this->messageManager->addError(__('Please select item(s).'));
        } else {
            try {
                foreach ($itemsIds as $itemId) {
                    $model = $this->_objectManager->create('ITM\MagB1\Model\Invoicefiles');
                    $model->load($itemId);
                    $model->delete();
                    
                    // delete the file
                    $destinationPath = $this->getDestinationPath() ."store_". $model->getData("store_id") . "/".md5($model->getData("increment_id"))."/";
                    $destinationFilePath = $destinationPath . $model->getPath();
                    if (file_exists($destinationFilePath) && $model->getPath()!="") {
                        unlink($destinationFilePath);
                    }
                    // end delete file
                }
                $this->messageManager->addSuccess(
                    __('A total of record(s) have been deleted.', count($itemsIds))
                );
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('An error occurred while deleting record(s).'));
            }
        }
        $this->_redirect('itm_magb1/*/');
    }
    
    private function getDestinationPath()
    {
        return $this->helper->getInvoiceFilesPath();
    }
}
