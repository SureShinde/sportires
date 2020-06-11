<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Merchant
 *
 * @author ibar
 */
namespace ClassyLlama\LlamaCoin\Helper;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\RequestInterface;

class FirstData extends \Magento\Framework\App\Helper\AbstractHelper{

    /**
    * @var \Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $scopeConfig;

    /**
    * @var \Magento\Store\Model\StoreManagerInterface
    */
    protected $storeManager;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    protected $customerSession;

    protected $_checkoutSession;

    protected $_request;

    protected $_email;

    /**
    * @param \Magento\Framework\App\Action\Context $context
    * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    * @param \Magento\Store\Model\StoreManagerInterface $storeManager
    * @param \Magento\Customer\Model\Session $customerSession
    * @param \Magento\Checkout\Model\Session $checkoutSession
    * @param Magento\Framework\App\RequestInterface $request
    * @param GeneralMails $_email,
    */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession
    ){
        $this->objectManager        = $objectManager;
        $this->scopeConfig          = $scopeConfig;
        $this->storeManager         = $storeManager;
        $this->customerSession      = $customerSession;
        $this->_checkoutSession     = $checkoutSession;
        parent::__construct($context);
    }

    public function updateReservedOrderId(){

    $checkoutSession = $this->objectManager->create('Magento\Checkout\Model\Session');
    $resource = $this->objectManager->get('Magento\Framework\App\ResourceConnection');
    $connection = $resource->getConnection();

      $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/FirstData.log');
      $logger = new \Zend\Log\Logger();
      $logger->addWriter($writer);

        $data = array();

        $logger->info('GENERANDO PROCESO PARA ENVIAR A FIRSTDATA : ');

      
        $quoteId = $checkoutSession->getQuoteId();
        $logger->info('QUOTE : ['.$quoteId.']');

        $cartData = $this->objectManager->create('Magento\Quote\Model\QuoteRepository')->get($quoteId);

        $checkoutSession->getQuote()->reserveOrderId();
        $reservedOrderId = $checkoutSession->getQuote()->getReservedOrderId();


        $quoteReserveId = str_pad($reservedOrderId, 9, "0", STR_PAD_LEFT);;    

        $connection->query("UPDATE quote set reserved_order_id = '$quoteReserveId' WHERE entity_id = $quoteId");

        return $quoteReserveId;
    }

    public function getOrderDetail(){

    $checkoutSession = $this->objectManager->create('Magento\Checkout\Model\Session');

      $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/FirstData.log');
      $logger = new \Zend\Log\Logger();
      $logger->addWriter($writer);

        $quoteId = $checkoutSession->getQuoteId();
        $cartData = $this->objectManager->create('Magento\Quote\Model\QuoteRepository')->get($quoteId);

        return $cartData;        
    }

    public function savePaymentData($data){
      $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/FirstData.log');
      $logger = new \Zend\Log\Logger();
      $logger->addWriter($writer);

      $logger->info('PROCCESS FIRSTDATA : '.print_r($data,true));
      $cartObject = $this->objectManager->get('\Magento\Checkout\Model\Cart');
      $quoteModel = $this->objectManager->get('\Magento\Quote\Model\QuoteFactory');
      $session = $this->objectManager->get('\Magento\Checkout\Model\Session');
      $quote = $cartObject->getQuote();

          $quoteGet = $quoteModel->create()->load($quote->getId());
          $dataCustomer = $quoteGet->getData();

            $additionalData = [
              'cc_type' => substr($data['ccType'],0,1),
              'cc_owner' => $quote->getCustomerFirstname().' '.$quote->getCustomerLastname(),
              'cc_last_4' => substr($data['ccNumber'],-4,4),
              'cc_number' => substr($data['ccNumber'],-4,4),
              'cc_cid_enc' => '000',
              'cc_exp_month' => $data['ccExpitation'],
              'cc_exp_year' => $data['ccExpitationyr'],
              'cc_ss_issue' => '',
              'cc_ss_start_month' => '',
              'cc_ss_start_year' => ''
            ];


          $logger->info('additional_data Pay : '.print_r($additionalData,true));
          $quote->setData('additional_data', $additionalData);


          try{

              $quoteGet->setPaymentMethod('classyllama_llamacoin');
              $quoteGet->setCustomerEmail($dataCustomer['customer_email']);
              $quoteGet->getPayment()->setMethod('classyllama_llamacoin');
              //$quoteGet->getPayment()->setCcNumberEnc('************'.substr($data['ccNumber'],-4,4));
              //$quoteGet->getPayment()->setCcLast4(substr($data['ccNumber'],-4,4));
              //$quoteGet->getPayment()->setCcExpYear($data['ccExpitationyr']);
              //$quoteGet->getPayment()->setCcExpMonth($data['ccExpitation']);
              //$quoteGet->getPayment()->setCcCidEnc('000');
              $quoteGet->getPayment()->setCcType($data['ccType']);
              if($data['ccMsi'] > 0){
                    $quoteGet->getPayment()->setAdditionalInformation(array('Meses sin intereses' => $data['ccMsi']));
              }
              $quoteGet->save();

              return 'OK';
          }catch(\Exception $e){
              return 'KO';
          }
          
    }


    public function saveOrder($data){
      $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/FirstData.log');
      $logger = new \Zend\Log\Logger();
      $logger->addWriter($writer);

      $logger->info('RESPONSE PAY FIRSTDATA: '.print_r($data,true));

              $cartObject = $this->objectManager->get('\Magento\Checkout\Model\Cart');
              $quoteObject = $this->objectManager->get('\ClassyLlama\LlamaCoin\Model\QuoteManagement');
              $quoteModel = $this->objectManager->get('\Magento\Quote\Model\QuoteFactory');
              $session = $this->objectManager->get('\Magento\Checkout\Model\Session');
              $saveItem = $this->objectManager->get('\Magento\Sales\Model\Order\Item');

              $quote = $cartObject->getQuote();

              $logger->info('QUOTE: '.$quote->getId());

              $order = $quoteObject->submit($quote);

              $referencia = $data['endpointTransactionId'].'-'. $data['approval_code'].'-'. $data['refnumber'].'-'. $data['ipgTransactionId'];

              $logger->info('REFERENCIA: '.$referencia);

              $order->setEmailSent(0);
              $order->addStatusHistoryComment('Pago Realizado Referencia '.$referencia);
              $orderState = 'processing';
              $order->setState($orderState)->setStatus('Pagado');              
              $order->save();

              $this->objectManager->create('Magento\Sales\Model\OrderNotifier')->notify($order);

              $increment_id = $order->getRealOrderId();
              if($order->getEntityId()){
                  $result['order_id']= $order->getRealOrderId();
              }else{
                  $result=['error'=>1,'msg'=>'Error al colocar la orden'];
              }
              $session->setLastOrderId($order->getRealOrderId());
              $session->setLastRealOrderId($order->getRealOrderId());

              $this->updatePaymentCode($quote->getId(),$data);

              return $order->getRealOrderId();
    }


    private function updatePaymentCode($quoteId,$data){
      $resource = $this->objectManager->get('Magento\Framework\App\ResourceConnection');
      $connection = $resource->getConnection();

      $trans_id = $data['endpointTransactionId'].'-'. $data['approval_code'].'-'. $data['refnumber'].'-'. $data['ipgTransactionId'];

      $sql = "UPDATE sales_order_payment a
                INNER JOIN sales_order b
                ON a.parent_id = b.entity_id
                SET a.last_trans_id = '$trans_id'";
      $connection->query($sql);

    }

  

}
