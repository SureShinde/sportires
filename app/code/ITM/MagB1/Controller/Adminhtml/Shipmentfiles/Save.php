<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Shipmentfiles;
    
class Save extends \ITM\MagB1\Controller\Adminhtml\Shipmentfiles
{
    protected $uploaderFactory;
    
    protected $helper;
    
    protected $allowedExtensions = ['csv','txt','pdf','zip'];
    
    protected $fileId = 'path';
    
    /**
     * Initialize Group Controller
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     * @param \ITM\MagB1\Helper\Data $dataHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \ITM\MagB1\Helper\Data $dataHelper
        ) {
            $this->helper = $dataHelper;
            $this->uploaderFactory = $uploaderFactory;
            parent::__construct($context, $coreRegistry, $resultForwardFactory, $resultPageFactory);
    }
    
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                $model = $this->_objectManager->create('ITM\MagB1\Model\Shipmentfiles');
                $data = $this->getRequest()->getPostValue();
                $inputFilter = new \Zend_Filter_Input([ ], [ ], $data);
                $data = $inputFilter->getUnescaped();
                $id = $this->getRequest()->getParam('id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getEntityId()) {
                        throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
                    }
                }
                
                // save the file
                $destinationPath = $this->getDestinationPath()."/store_".$data["store_id"]."/".md5($data["increment_id"])."/";
                
               
                
                $valid_file = false;
                try {
                    $uploader1 = $this->uploaderFactory->create(['fileId' => $this->fileId]);
                    $valid_file = true;
                } catch (\Exception $ex) {
                    $valid_file = false;
                }
                

               
                if ($valid_file) {
                    
                    $uploader = $this->uploaderFactory->create(['fileId' => $this->fileId])
                    ->setAllowCreateFolders(true)
                    ->setAllowRenameFiles(true)
                    ->setAllowedExtensions($this->allowedExtensions)
                    ->addValidateCallback('validate', $this, 'validateFile');
                    
                    if (!$uploader->save($destinationPath)) {
                        throw new LocalizedException(
                            __('File cannot be saved to path: $1', $destinationPath)
                            );
                    }
                    
                    $data["path"] = $uploader->getUploadedFileName();
                    $data["delete_old_path"] = "on";
                   
                } else {
                    if (isset($data["delete_file_path"])) {
                        $file_path = $destinationPath.$model->getPath();
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                        $data["path"] = "";
                    }
                }
                // when upload new file , the old file will delete automaticlly
                if (isset($data["delete_old_path"])) {
                    $file_path = $destinationPath.$model->getPath();
                    if ($model->getPath() != $data["path"]) {
                        if (file_exists($file_path) && $model->getPath()!="") {
                            unlink($file_path);
                        }
                    }
                }
                // end save file
                
                
                
                $data["entity_id"] = $id;
                $model->setData($data);
                $session = $this->_objectManager->get('Magento\Backend\Model\Session');
                $session->setPageData($model->getData());
                $model->save();
                $this->messageManager->addSuccess(__('You saved the item.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('itm_magb1/*/edit', ['id' => $model->getEntityId()]);
                    return;
                }
                $this->_redirect('itm_magb1/*/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $id =(int ) $this->getRequest()->getParam('id');
                if (! empty($id)) {
                    $this->_redirect('itm_magb1/*/edit', ['id' => $id]);
                } else {
                    $this->_redirect('itm_magb1/*/new');
                }
                return;
            } catch (\Exception $e) {
                /*$this->messageManager->addError(
                    __('Something went wrong while saving the item data. Please review the error log.')
                );*/
                $this->messageManager->addError(
                    __($e->getMessage())
                    );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $this->_redirect('itm_magb1/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->_redirect('itm_magb1/*/');
    }
    
    private function validateFile($filePath)
    {
        return;
        // @todo
        // your custom validation code here
    }
    
    private function getDestinationPath()
    {
        return $this->helper->getShipmentFilesPath();
    }
}
