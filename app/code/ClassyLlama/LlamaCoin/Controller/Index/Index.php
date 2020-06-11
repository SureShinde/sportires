<?php


namespace ClassyLlama\LlamaCoin\Controller\Index;


class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;

    protected $_publicActions = ['index'];
    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/FirstData.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $obj = \Magento\Framework\App\ObjectManager::getInstance();
            $logger->info('FIRST RESPONSE'); 

            $logger->info(print_r($this->getRequest()->getParams(),true)); 


        if(!empty($this->getRequest()->getParam('tockenId'))){
 
            $helper = $obj->get('ClassyLlama\LlamaCoin\Helper\FirstData');     
            $helper->savePaymentData($this->getRequest()->getParams());
            return $this->resultPageFactory->create();
        }else{

            if($this->getRequest()->getParam('proccess-pay') == '1'){
                $logger->info('RESPONSE SUCCESS'); 
                $logger->info(print_r($this->getRequest()->getParams(),true));    

                $helper = $obj->get('ClassyLlama\LlamaCoin\Helper\FirstData');     
                $orderId = $helper->saveOrder($this->getRequest()->getParams());

                return $this->resultPageFactory->create();

            }else{


                $logger->info('RESPONSE FAIL'.print_r($this->getRequest()->getParams(),true)); 

                if(!empty($this->getRequest()->getParams())){
                    $this->messageManager->addErrorMessage($this->getRequest()->getParam('status').' '.$this->getRequest()->getParam('fail_reason'));
                }else{
                    $this->messageManager->addErrorMessage('Error general, por favor pongase en contacto con nosotros a ventas@sportires.com.mx');
                }
            
                $this->_redirect('checkout/cart/');  

            }
        }
    }
}