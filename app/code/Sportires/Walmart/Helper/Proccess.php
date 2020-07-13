<?php
declare(strict_types=1);

namespace Sportires\Walmart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Proccess extends AbstractHelper
{

	protected $_objectManager;

	protected $_scopeConfig;


    /**
    * @param \Magento\Framework\App\Helper\Context $context
    * @param Magento\Framework\App\Helper\Context $context
    * @param Magento\Store\Model\StoreManagerInterface $storeManager
    * @param Magento\Catalog\Model\Product $product,
    * @param Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
    * @param Magento\Quote\Api\CartManagementInterface $cartManagementInterface,
    * @param Magento\Customer\Model\CustomerFactory $customerFactory,
    * @param Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
    * @param Magento\Sales\Model\Order $order
    * @param Magento\Quote\Model\Quote $quote
    * @param \ClassyLlama\LlamaCoin\Model\QuoteManagement $quoteManagement 
    */
    public function __construct(
    	\Magento\Framework\ObjectManagerInterface $objectmanager,
    	\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Product $product,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
        \Magento\Quote\Api\CartManagementInterface $cartManagementInterface,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Sales\Model\Order $order,
        \Magento\Quote\Model\QuoteFactory $quote,
        \ClassyLlama\LlamaCoin\Model\QuoteManagement $quoteManagement,
        \Magento\Quote\Model\QuoteRepository $quoteRepo
    ) {
    	$this->_objectManager = $objectmanager;
    	$this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->_product = $product;
        $this->cartRepositoryInterface = $cartRepositoryInterface;
        $this->cartManagementInterface = $cartManagementInterface;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->order = $order;
        $this->quote = $quote;
        $this->quoteManagement = $quoteManagement;
        $this->_quoteRepo = $quoteRepo;
        parent::__construct($context);
    }

    /*
    * PROCESAR ORDENES a BASE DE DATOS
    */
    public function proccessOrders(){
        $resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        $sql = "SELECT * FROM sportires_marketplaces_walmart_api WHERE type_request = 'orders' AND http_status = '200' AND proceced = 'received' ORDER BY created_at LIMIT 1;";
        $result = $connection->fetchAll($sql);

        $arrayOrders = array();

        if(count($result) == 1){

            $idResponse = $result[0]['id'];
            $orders = json_decode($result[0]['response']);

            //print_r($orders);

            if(!empty($orders->order)){
                if(count($orders->order) > 0){
                    foreach($orders->order as $order){
                        //$arrayOrders[] = array($order->purchaseOrderId, $order->orderDate);
                        $verific = "SELECT count(*) AS existe FROM sportires_marketplaces_walmart_orders WHERE purchaseOrderId = '$order->purchaseOrderId';";
                        $is = $connection->fetchAll($verific);
                        if($is[0]['existe'] == 0){
                            $detail = json_encode($order);
                            $insertRegisterOrder = "INSERT INTO sportires_marketplaces_walmart_orders VALUES (NULL,$idResponse,NULL,'$order->purchaseOrderId','$order->orderDate','$detail',NOW(),NULL,'200','INICIA')";
                            $connection->query($insertRegisterOrder);

                            $idOrderInternal = "SELECT id FROM `sportires_marketplaces_walmart_orders` ORDER BY id DESC LIMIT 1";
                            $resultId = $connection->fetchAll($idOrderInternal);
                            $this->createMageOrderNew($connection,$order,$resultId[0]['id']);
                        }
                    }
                }

                $update = "UPDATE sportires_marketplaces_walmart_api SET proceced = 'inproccess' where id = $idResponse";
                $connection->query($update);
            }else{
                echo 'No Hay Ordenes';
                $update = "UPDATE sportires_marketplaces_walmart_api SET proceced = 'nulo' where id = $idResponse";
                $connection->query($update);                
            }
        }
    }

    protected function addRate($connection,$quoteId){

       $sql = "INSERT INTO `quote_shipping_rate` VALUES (NULL, (SELECT address_id FROM `quote_address` WHERE quote_id = $quoteId AND address_type = 'shipping'),NOW(),NOW(),'shipbywalmartmx','WalmartMx Shipping Method','shipbywalmartmx_shipbywalmartmx','shipbywalmartmx',NULL,'0.0000',NULL,'WalmartMx Shipping Method(Default)');";
       $connection->query($sql);

    }

    protected function changePrefix($connection){

        $insert = "INSERT INTO sequence_order_1 VALUE (NULL)";
        $connection->query($insert);

        $select = "SELECT sequence_value AS increment_id FROM sequence_order_1 ORDER BY 1 DESC LIMIT 1;";
        $id = $connection->fetchAll($select);

        return  'WALMARTMX--'.str_pad($id[0]['increment_id'], 9, '0', STR_PAD_LEFT); 

    }

    protected function registerProducts($connection,$idRecord,$idProduct,$price){

        $sql = "INSERT INTO sportires_marketplaces_walmart_products VALUES (NULL,$idRecord,$idProduct,1,$price) ON DUPLICATE KEY UPDATE qty=qty+1;";
        $connection->query($sql);
    }

    protected function getItemsOrder($connection,$idRecord){

        $get = "SELECT * FROM sportires_marketplaces_walmart_products WHERE id_order = $idRecord;";
        $rows = $connection->fetchAll($get);

        return $rows;
    }

    protected function getDetailByProductInOrder($connection,$idRecord,$idProduct){

        $select = "SELECT * FROM sportires_marketplaces_walmart_products WHERE id_order = $idRecord AND product_id = $idProduct;";
        $rows = $connection->fetchAll($select);

        return $rows;
    }

    protected function asignOrderId($connection, $idRecord, $incrementId){
        
        $update = "UPDATE sportires_marketplaces_walmart_orders SET order_sportires = '$incrementId' WHERE id = $idRecord"; 
        $connection->query($update);
    }

    public function createMageOrderNew($connection,$orderData,$idRecord) {

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/WalmartCreateOrder'.date('Ymd').'.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $store=$this->_storeManager->getStore();
        $websiteId = $this->_storeManager->getStore()->getWebsiteId();
        $customer=$this->customerFactory->create();
        $customer->setWebsiteId($websiteId);
        $customer->loadByEmail($orderData->customerEmailId);// load customet by email address
        $name = explode(' ',$orderData->shippingInfo->postalAddress->name);

        if(!$customer->getEntityId()){
            //If not avilable then create this customer 
            $customer->setWebsiteId($websiteId)
                    ->setStore($store)
                    ->setFirstname($name[0])
                    ->setLastname($name[1])
                    ->setEmail($orderData->customerEmailId) 
                    ->setPassword($orderData->customerEmailId);
            $customer->save();
        }
        $quote=$this->quote->create(); //Create object of quote
        $quote->setStore($store); //set store for which you create quote
        // if you have allready buyer id then you can load customer directly 
        $customer= $this->customerRepository->getById($customer->getEntityId());
        $quote->setCurrency();
        $quote->assignCustomer($customer); //Assign quote to customer
 
        $arrayItems = array();
        foreach($orderData->orderLines as $item){
            $productId = $this->_objectManager->get('Magento\Catalog\Api\ProductRepositoryInterface')->get($item->item->sku);
            $this->registerProducts($connection,$idRecord,$productId->getId(),$item->item->unitPrice->amount);
        }
        
        //add items in quote
        foreach($this->getItemsOrder($connection,$idRecord) as $item){

        //$priceCustom = $item->item->unitPrice->amount;
        //$productId = $this->_objectManager->get('Magento\Catalog\Api\ProductRepositoryInterface')->get($item->item->sku);
      
        $logger->info("CREANDO ITEMS");
        $logger->info('PRODUCT ID : '.$item['product_id']);
        $logger->info('PRECIO : '.$item['price']);

            $product=$this->_product->load($item['product_id']);
            $product->setPrice($item['price'])
                    //->setCustomPrice($item->item->unitPrice->amount)
                    ->setBasePrice($item['price'])
                    ->setOriginalPrice($item['price'])
                    ->setBaseOriginalPrice($item['price'])
                    ->setOriginalPrice($item['price'])
                    //->setOriginalCustomPrice($item->item->unitPrice->amount)
                    ->setRowTotal($item['price']*$item['qty'])
                    ->setBaseRowTotal($item['price']*$item['qty'])
                    ->setRowInvoiced($item['price']*$item['qty']) 
                    ->setBaseRowInvoiced($item['price']*$item['qty'])   
                    ->setPriceInclTax($item['price']) 
                    ->setBasePriceInclTax($item['price']) 
                    ->setRowTotalInclTax($item['price']*$item['qty'])
                    ->setBaseRowTotalInclTax($item['price']*$item['qty']);        
            $quote->addProduct(
                $product,
                intval(1)
            );
        }
 
        $shipping_address = array(
            'firstname' => $orderData->shippingInfo->postalAddress->name,
            'lastname'  => $orderData->shippingInfo->postalAddress->name,
            'street'    => $orderData->shippingInfo->postalAddress->address1,
            'city'      => $orderData->shippingInfo->postalAddress->city,
            'country_id'=> 'MX',
            'region'    => $orderData->billingInfo->postalAddress->state,
            'region_id' => 583,
            'postcode'  => $orderData->shippingInfo->postalAddress->postalCode,
            'telephone' => $orderData->shippingInfo->phone
        );

        $billing_address = array(
            'firstname' => $orderData->billingInfo->postalAddress->name,
            'lastname'  => $orderData->billingInfo->postalAddress->name,
            'street'    => $orderData->billingInfo->postalAddress->address1,
            'city'      => $orderData->billingInfo->postalAddress->city,
            'country_id'=> 'MX',
            'region'    => $orderData->billingInfo->postalAddress->state,
            'region_id' => 583,
            'postcode'  => $orderData->billingInfo->postalAddress->postalCode,
            'telephone' => $orderData->billingInfo->phone
        );  
        //Set Address to quote
        $quote->getBillingAddress()->addData($shipping_address);
        $quote->getShippingAddress()->addData($billing_address);
 
        // Collect Rates and Set Shipping & Payment Method
 
        $shippingAddress = $quote->getShippingAddress();
        $shippingAddress->setCollectShippingRates(true)
                        ->collectShippingRates()
                        ->setShippingMethod('shipbywalmartmx_shipbywalmartmx'); //shipping method
        $quote->setPaymentMethod('paybywalmartmx'); //payment method
        $quote->setInventoryProcessed(false); //not effetc inventory
        $quote->setReservedOrderId($this->changePrefix($connection));
        $quote->save(); //Now Save quote and your quote is ready
       
 
        // Set Sales Order Payment
        $quote->getPayment()->importData(['method' => 'paybywalmartmx']);
 

        // Collect Totals & Save Quote
        $quote->collectTotals()->save();

        $this->addRate($connection,$quote->getId());


        $quote = $this->_quoteRepo->get($quote->getId());
        foreach($quote->getAllVisibleItems() as $item){
            $item = $quote->getItemById($item->getId());
            if (!$item) {
              continue;
            }

            $data = $this->getDetailByProductInOrder($connection,$idRecord,$item->getProductId());
            $data = $data[0];
            $item->setQty((double) $data['qty']);
            $item->setCustomPrice($data['price']);
            $item->setOriginalCustomPrice($data['price']);
            $item->getProduct()->setIsSuperMode(true);
            $item->save(); 
        }


        // Create Order From Quote
        $quote = $this->cartRepositoryInterface->get($quote->getId());
        $orderId = $this->cartManagementInterface->placeOrder($quote->getId());

        $order = $this->order->load($orderId);
        $order->setCanSendNewEmailFlag(false);
        $order->setEmailSent(false);
        $order->setSendEmail(false);

        $increment_id = $order->getRealOrderId();
        if($order->getEntityId()){
            $result['order_id']= $order->getRealOrderId();
        }else{
            $result=['error'=>1,'msg'=>'Your custom message'];
        }

        //$this->changePrefix($quote->getId());
        $this->asignOrderId($connection,$idRecord,$increment_id);
        //echo '['.$quote->getId().'-'.$increment_id.']';
    }


}