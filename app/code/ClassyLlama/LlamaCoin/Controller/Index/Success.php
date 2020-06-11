<?php


namespace ClassyLlama\LlamaCoin\Controller\Index;

class Success extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;

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

        $logger->info('RESPONSE SUCCESS'); 
        $logger->info(print_r($this->getRequest()->getParams(),true));    


        $obj = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $obj->get('ClassyLlama\LlamaCoin\Helper\FirstData');     
        $orderId = $helper->saveOrder($this->getRequest()->getParams());
        //$this->_redirect('checkout/onepage/success/'); 
/*

        $order = $obj->create('\Magento\Sales\Model\Order') ->load($orderId);
        $orderState = 'processing';
        $order->setState($orderState)->setStatus('Pagado');
        $order->save();
*/
        /*$referencia = $this->getRequest()->getParam('endpointTransactionId').'-'. $this->getRequest()->getParam('approval_code').'-'.$this->getRequest()->getParam('refnumber').'-'.$this->getRequest()->getParam('ipgTransactionId');

        $order = $obj->create('\Magento\Sales\Model\Order')->load($orderId);
        $order->addStatusHistoryComment('Pago Realizado Referencia '.$referencia);
        $order->save();*/

        return $this->resultPageFactory->create();
    }
}
