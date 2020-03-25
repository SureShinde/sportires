<?php

namespace Firstdata\Gateway\Controller\Response;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Checkout\Model\Session;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Firstdata\Gateway\Logger\Logger;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Response\Http;
use Magento\Sales\Model\Order\Payment\Transaction\Builder as TransactionBuilder;
use \Magento\CatalogInventory\Api\StockRegistryInterface;
use \Firstdata\Gateway\Model\Tokendetails;

class Index extends \Magento\Framework\App\Action\Action {

    protected $_objectmanager;
    protected $_checkoutSession;
    protected $_orderFactory;
    protected $urlBuilder;
    private $logger;
    protected $response;
    protected $config;
    protected $messageManager;
    protected $transactionRepository;
    protected $cart;
    protected $inbox;
    protected $stockRegistry;
    protected $savetoken;
    protected $_invoiceService;

    public function __construct(Context $context, Session $checkoutSession, OrderFactory $orderFactory, Logger $logger, ScopeConfigInterface $scopeConfig, Http $response, TransactionBuilder $tb, \Magento\Checkout\Model\Cart $cart, \Magento\AdminNotification\Model\Inbox $inbox, \Magento\Sales\Api\TransactionRepositoryInterface $transactionRepository, StockRegistryInterface $stockRegistry, Tokendetails $savetoken,\Magento\Sales\Model\Service\InvoiceService $invoiceService) {

        $this->checkoutSession = $checkoutSession;
        $this->orderFactory = $orderFactory;
        $this->response = $response;
        $this->scopeConfig = $scopeConfig;
        $this->transactionBuilder = $tb;
        $this->logger = $logger;
        $this->cart = $cart;
        $this->inbox = $inbox;
        $this->transactionRepository = $transactionRepository;
        $this->urlBuilder = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Magento\Framework\UrlInterface');
        $this->stockRegistry = $stockRegistry;
        $this->savetoken = $savetoken;
        $this->_invoiceService = $invoiceService;

        parent::__construct($context);
    }

    public function execute() {

        $response = $this->getRequest()->getPost();
        
        // For testing
        /* $response = array(
          'status' => 'APPROVED',
          'chargetotal' => '100',
          'oid' => '00000003232',
          'response_hash' => '12121212',
          'approval_code' => 'Y',
          'txndatetime' => '12121212',
          'response_hash' => '12121212',
          'currency' => 'GBP',
          'ipgTransactionId' => '12121212',
          'txntype' => 'sale',
          'hosteddataid' =>'AOI43234324',
          'cardnumber' => '424242424242424242',
          'expdatae' => '0465',
          'ccbrand' => 'visa',
          'pseudo_cc_no' => '532sw',
          'ccbin' => '32423423'
          ); */
        
        // For logging                 
        $this->Log('Response Params:' . print_r($response, true));
        
        if (isset($response['status']) && isset($response['oid'])) {
            $isnotify = false;
            if(isset($response['notification_hash'])){
                $isnotify = true;
            }

            // Order ID
            $orderid = $response['oid'];
            # get order object
            $order = $this->orderFactory->create()->loadByIncrementId($orderid);
            $order_status = $order->getStatus(); 
            
            if (preg_match("/^$order_status/i", Order::STATE_PENDING_PAYMENT)){
                if ($this->validateResponse($response, $isnotify)) {
                    $approval_code = substr($response['approval_code'], 0, 1);
                    if ($approval_code == 'Y') {
                        // Needed response values                    
                        //$amount = $response['chargetotal'];

                        $order->setStatus(Order::STATE_PROCESSING, true);
                        //$order->setTotalPaid($amount);
                        $order->setTotalDue(0);
                        $order->save();
                        //Store details based on IPG response
                        $this->storeData($response);
                        $this->_redirect($this->urlBuilder->getUrl('checkout/onepage/success', array('_secure' => true)));
                    } else if ($approval_code == 'N') {
                        $order->setState(Order::STATE_CANCELED, true);
                        // Inventory updated 
                        $this->updateInventory($orderid);
                        $order->cancel()->save();
                        $this->_redirect($this->urlBuilder->getUrl('checkout/onepage/failure', array('_secure' => true)));
                    } else {
                        $order->setState(Order::STATE_CANCELED, true);
                        // Inventory updated                 
                        $this->updateInventory($orderid);
                        $order->cancel()->save();
                        $this->_redirect($this->urlBuilder->getUrl('checkout/onepage/failure', array('_secure' => true)));
                    }
                } else {
                    
                    $this->Log("Invalid IPG response hash for order [$orderid]");
                    $order->setState(Order::STATE_CANCELED, true);
                    // Inventory updated 
                    $this->updateInventory($orderid);
                    $order->cancel()->save();
                    $this->_redirect($this->urlBuilder->getUrl('checkout/onepage/failure', array('_secure' => true)));
                }
            }else{
                $this->Log("Already IPG response updated for order [$orderid], Status [$order_status], isNotify [".(($isnotify)?'Yes':'No')."]"); 
            }
        }
    }
    
    public function Log($msg) {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $logging = $this->scopeConfig->getValue("payment/firstdata/logging", $storeScope);
        // Log if enabled
        if ($logging == 1) {
            $this->logger->info($msg);
        }
    }
    
    public function getCustomerId() {
        //return current customer ID
        return $this->_checkoutSession->getId();
    }

    public function updateInventory($orderId) {

        # get order object
        $order = $this->orderFactory->create()->loadByIncrementId($orderId);
        $items = $order->getAllItems();
        foreach ($items as $itemId => $item) {
            $ordered_quantity = $item->getQtyToInvoice();
            $sku = $item->getSku();
            $stockItem = $this->stockRegistry->getStockItemBySku($sku);
            //$qtyStock = $stockItem->getQty();
            //$this->logger->info("sku:".$sku.", qtyStock: ".$qtyStock.", ordered_quantity: ".$ordered_quantity);
            //$updated_inventory = $qtyStock + $ordered_quantity;
            $stockItem->setQtyCorrection($ordered_quantity);
            $this->stockRegistry->updateStockItemBySku($sku, $stockItem);
        }		
    }

    public function storeData($response) {
		
        $orderId = $response['oid'];
        $order = $this->orderFactory->create()->loadByIncrementId($orderId);
        $payment = $order->getPayment();

        $payment->setParentTransactionId($response['ipgTransactionId']);
        $payment->setLastTransId($response['ipgTransactionId']);
        $payment->setTransactionId($response['ipgTransactionId']);	
		
        $additional_info = array(
            'ipgTransactionId' => $response['ipgTransactionId'],            
            'oid' => $response['oid'],            
            'status' => $response['status'],
            'txn_type' => $response['txntype']
        );	 

        $payment->setAdditionalInformation($additional_info);
        $payment->save();
		
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;        
        $country = $this->scopeConfig->getValue("payment/firstdata/country", $storeScope);
        
        if($country == 'ind' && isset($response['number_of_installments']) && $response['number_of_installments']>0)
        { 
            $order->addStatusHistoryComment('Transaction success for order with '.$response['number_of_installments'].' instalments configured');
            $order->save();
        }
        else
        {
            $order->save();  
        }
        
        $invoice = $this->_invoiceService->prepareInvoice($order);
        $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);
        $invoice->register();	
        $transaction = $this->_objectManager->create('Magento\Framework\DB\Transaction')
                                            ->addObject($invoice)
                                            ->addObject($invoice->getOrder());

        $transaction->save();

        //Tokenisation				
        if (isset($response['hosteddataid']) && $response['hosteddataid'] != '') {

            /*$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $customerSession = $objectManager->get('Magento\Customer\Model\Session');
            $customer_id = $customerSession->getCustomer()->getId();*/
            
            $customer_id = $order->getCustomerId();
            			 
            $alias = preg_replace("/^\([A-Z]+\)/", $response['ccbin'], $response['cardnumber']);
            $brand = $response['ccbrand'];
            $hosteddataid = $response['hosteddataid'];

            //Get Customer Details	 				
            $model = $this->_objectManager->create('Firstdata\Gateway\Model\Tokendetails');
            $test = $model->load($customer_id);

            $multiselectupdate = $test->getCollection()
                    ->addFieldToFilter('customer_id', $customer_id)
                    ->addFieldToFilter('alias', $alias)
                    ->addFieldToFilter('brand', $brand)
                    ->getFirstItem();


            if (!$multiselectupdate->getId()) {
                $data = array(
                    'customer_id' => $customer_id,
                    'alias' => $alias,
                    'pseudo_cc_no' => $hosteddataid,
                    'brand' => $brand
                );
                //Save into Database			
                $this->savetoken->setData($data);
                $this->savetoken->save();
            }
        }
    }

    // Validate response hash
    function validateResponse($response, $isnotify) {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        //check the environment under which the plugin works       
        $environment = $this->scopeConfig->getValue('payment/firstdata/environment', $storeScope);
        if ($environment == "Production") {
            $key = $this->scopeConfig->getValue('payment/firstdata/production_key', $storeScope);
            $salt = $this->scopeConfig->getValue('payment/firstdata/production_salt', $storeScope);
        } else {
            $key = $this->scopeConfig->getValue('payment/firstdata/integrate_key', $storeScope);
            $salt = $this->scopeConfig->getValue('payment/firstdata/integrate_salt', $storeScope);
        }

        $currency = $response['currency'];
        if($isnotify){
            $response_hash = $response['notification_hash'];                                                      
        }else{
            $response_hash = $response['response_hash'];                                                      
        }
        
        $approval_code = $response['approval_code'];
        $txndatetime = $response['txndatetime'];
        $chargetotal = $response['chargetotal'];

        $generated_hash = $this->_createResponseHash($isnotify, $approval_code, $txndatetime, $chargetotal, $key, $salt, $currency);
        $validResponse = false;
        if ($generated_hash == $response_hash) {
            $validResponse = true;
        }

        return $validResponse;
    }

    // Response Hash creation
    function _createResponseHash($isnotify, $approvalCode, $txnDateTime, $chargeTotal, $storeId, $sharedSecret, $currency) {        
        if($isnotify){
            $stringToHash = $chargeTotal. $sharedSecret. $currency . $txnDateTime . $storeId. $approvalCode;
        }else{
            $stringToHash = $sharedSecret. $approvalCode. $chargeTotal . $currency . $txnDateTime . $storeId;
        }
        
	$ascii = bin2hex($stringToHash);

	return sha1($ascii);
    }

}
