<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Invoicefiles;
    
class Delete extends \ITM\MagB1\Controller\Adminhtml\Invoicefiles
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
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->_objectManager->create('ITM\MagB1\Model\Invoicefiles');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('You deleted the item.'));
                
                // Delete the file.
                $destinationPath = $this->getDestinationPath() ."store_". $model->getData("store_id") . "/".md5($model->getData("increment_id"))."/";
                $destinationFilePath = $destinationPath . $model->getPath();
                if (file_exists($destinationFilePath)) {
                    unlink($destinationFilePath);
                    $this->messageManager->addSuccess(__('File has been deleted successfully.'));
                }
                // end delete file
                
                
                $this->_redirect('itm_magb1/*/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('We can\'t delete item right now. Please review the log and try again.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('itm_magb1/*/edit', [
                        'id' => $this->getRequest()->getParam('id')
                ]);
                return;
            }
        }
        $this->messageManager->addError(__('We can\'t find a item to delete.'));
        $this->_redirect('itm_magb1/*/');
    }
    
    private function getDestinationPath()
    {
        return $this->helper->getInvoiceFilesPath();
    }
}
