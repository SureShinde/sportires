<?php


namespace ClassyLlama\LlamaCoin\Controller\Index;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;

class FailPayment extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
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
        //echo 'Llego aqui';
        if(!empty($this->getRequest()->getParams())){
            $this->messageManager->addErrorMessage($this->getRequest()->getParam('status').' '.$this->getRequest()->getParam('fail_reason'));
        }else{
            $this->messageManager->addErrorMessage('Error general, por favor pongase en contacto con nosotros a ventas@sportires.com.mx');
        }
        //$this->messageManager->addErrorMessage($this->getRequest()->getParam('status').' '.$this->getRequest()->getParam('fail_reason'));
        $this->_redirect('checkout/cart/');        
        //return $this->resultPageFactory->create();
    }

    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    } 
}
