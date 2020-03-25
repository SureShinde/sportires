<?php

namespace ITM\MagB1\Model\Sales;

use ITM\MagB1\Api\Sales\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterfaceFactory;

class Order implements OrderInterface
{

    /**
     * @var OrderSearchResultInterfaceFactory
     */
    protected $orderSearchResultFactory = null;
    /**
     *
     * @var \Magento\Framework\Api\SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var  \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var  \Magento\Sales\Model\Order\ItemFactory
     */
    protected $_orderItemFactory;
    /**
     * @var  \Magento\Sales\Api\OrderPaymentRepositoryInterface
     */
    protected $_orderPaymentRepository;

    /**
     * @var  \Magento\Sales\Model\Order\AddressRepository
     */
    protected $_orderAddressRepository;

    /**
     * @var  \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $_productRepository;
    /**
     * @var  \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $_customerRepository;

    /**
     * @var  \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var  \Magento\Sales\Model\OrderRepository
     */
    protected $_orderRepository;

    /**
     * @var \Magento\Framework\Module\Manager
     */

    protected $_moduleManager;

    /**
     * @var \ITM\MagB1\Helper\Data
     */

    private $helper;

    protected $_timezone;
    /**
     *
     * @param
     *            * @var \Magento\Framework\Api\SearchResultsInterfaceFactory
     */
    public function __construct(
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Sales\Model\Order\ItemFactory $orderItemFactory,
        \Magento\Sales\Api\OrderPaymentRepositoryInterface $orderPaymentRepository,
        \Magento\Sales\Model\Order\AddressRepository $orderAddressRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Sales\Model\OrderRepository $orderRepository,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Sales\Api\Data\OrderSearchResultInterfaceFactory $orderSearchResultFactory,
        \ITM\MagB1\Helper\Data $helper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    ) {
        $this->searchResultsFactory = $searchResultsFactory;
        $this->_objectManager = $objectManager;
        $this->_orderFactory = $orderFactory;
        $this->_orderItemFactory = $orderItemFactory;
        $this->_orderPaymentRepository = $orderPaymentRepository;
        $this->_orderAddressRepository = $orderAddressRepository;
        $this->_productRepository = $productRepository;
        $this->_customerRepository = $customerRepositoryInterface;
        $this->_storeManager = $storeManager;
        $this->_orderRepository = $orderRepository;
        $this->_moduleManager = $moduleManager;
        $this->orderSearchResultFactory = $orderSearchResultFactory;
        $this->helper = $helper;
        $this->_timezone = $timezone;
    }
//    $customer = $objectManager->get('\Magento\Customer\Model\Customer')->load(2);


    /**
     *
     * {@inheritdoc}
     *
     */
    public function updateOrder(\Magento\Sales\Api\Data\OrderInterface $entity)
    {
        $increment_id = $entity->getIncrementId();
        $order = $this->_orderFactory->create();
        $order = $order->loadByIncrementId($increment_id);

        $order->setItmSboDocentry($entity->getExtensionAttributes()->getItmSboDocentry());
        $order->setItmSboDocnum($entity->getExtensionAttributes()->getItmSboDocnum());
        $order->setItmSboDownloadToSap($entity->getExtensionAttributes()->getItmSboDownloadToSap());

        $order->save();
        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function saveOrder(\Magento\Sales\Api\Data\OrderInterface $entity)
    {

        $customer_id = $entity->getData("customer_id");

        $customer = $this->_customerRepository->getById($customer_id);
        $storeId = $customer->getStoreId();
        if($entity->getData("store_id") != -1) {
            $storeId =  $entity->getData("store_id");
        }
        $createdAt = "";
        $updatedAt = "";


        //$now_timezone_time =  $this->_timezone->date(date("Y-m-d H:i:s"))->format('Y-m-d H:i:s');
        $now_timezone_time =  $this->_timezone->date()->format('Y-m-d H:i:s');
        $date1 = strtotime(date("Y-m-d H:i:s"));
        $date2 = strtotime($now_timezone_time);
        $difference = $date1 - $date2;
        //$hours = floor($difference / (60*60) );

        if(!empty($entity->getData("created_at"))) {
            $timestamp_created_at = strtotime($entity->getData("created_at"));
            if($timestamp_created_at) {
                $createdAt = date("Y-m-d H:i:s", $timestamp_created_at);
                $createdAt = date("Y-m-d H:i:s",  strtotime($createdAt)+ ($difference));
            }
        }

        if(!empty($entity->getData("updated_at"))) {
            $timestamp_updated_at = strtotime($entity->getData("updated_at"));
            if($timestamp_updated_at) {
                $updatedAt = date("Y-m-d H:i:s", $timestamp_updated_at);
                $updatedAt = date("Y-m-d H:i:s",  strtotime($updatedAt)+ ($difference));
            }
        }
   
        $currency = $this->_storeManager->getStore($storeId)->getCurrentCurrency()->getCode();
        $billing_address = $entity->getBillingAddress();

        $shippingAssignments = $entity->getExtensionAttributes()->getShippingAssignments();
        $shipping = array_shift($shippingAssignments)->getShipping();

        $shipping_address = $shipping->getAddress();
        $shipping_method = $shipping->getMethod();
        $shipping_description = $entity->getShippingDescription();

        // Prepare the Billing Address
        /* @var $orderAddressRepository \Magento\Sales\Model\Order\AddressRepository */
        $billingOrderAddress = $this->_orderAddressRepository->create();
        $billingOrderAddress
            ->setStoreId($storeId)
            ->setAddressType(\Magento\Sales\Model\Order\Address::TYPE_BILLING)
            ->setCustomerId($customer_id)
            ->setPrefix($billing_address->getPrefix())
            ->setFirstname($billing_address->getFirstname())
            ->setMiddlename($billing_address->getMiddlename())
            ->setLastname($billing_address->getLastname())
            ->setCompany($billing_address->getCompany())
            ->setStreet($billing_address->getStreet())
            ->setCity($billing_address->getCity())
            ->setPostcode($billing_address->getPostcode())
            ->setTelephone($billing_address->getTelephone())
            ->setFax($billing_address->getFax())
            ->setCountryId($billing_address->getCountryId())
            ->setRegionId($billing_address->getRegionId());


        // Prepare the Shipping Address
        $shippingOrderAddress = $this->_orderAddressRepository->create();
        $shippingOrderAddress
            ->setStoreId($storeId)
            ->setAddressType(\Magento\Sales\Model\Order\Address::TYPE_SHIPPING)
            ->setCustomerId($customer_id)
            ->setPrefix($shipping_address->getPrefix())
            ->setFirstname($shipping_address->getFirstname())
            ->setMiddlename($shipping_address->getMiddlename())
            ->setLastname($shipping_address->getLastname())
            ->setCompany($shipping_address->getCompany())
            ->setStreet($shipping_address->getStreet())
            ->setCity($shipping_address->getCity())
            ->setPostcode($shipping_address->getPostcode())
            ->setTelephone($shipping_address->getTelephone())
            ->setFax($shipping_address->getFax())
            ->setCountryId($shipping_address->getCountryId())
            ->setRegionId($shipping_address->getRegionId());

        // payment method
        $payment_method = $entity->getPayment()->getMethod();//'checkmo';


        // Create/Update the order

        $increment_id = $entity->getIncrementId();

        $order = $this->_orderFactory->create()->setStoreId($storeId);

        if ($increment_id != "") {
            $order = $order->loadByIncrementId($increment_id);
            if ($order->getEntityId() == 0) {
                return "error|This order is not exist";
            }
            $items = $order->getAllItems();
            $qty_invoiced = 0;
            $qty_shipped = 0;
            foreach ($items as $item) {
                $qty_invoiced += $item->getQtyInvoiced();
                $qty_shipped += $item->getQtyShipped();
            }

            if ($qty_invoiced > 0) {
                return "error|This order cannot be updated - order has invoice(s)";
            }
            if ($qty_shipped > 0) {
                return "error|This order cannot be updated - order has shipment(s)";
            }

            //Delete the items
            foreach ($items as $item) {
                $item->delete();
            }
        }
        //
        //return $order;
        // Set customer Data
        $order
            ->setStoreId($storeId)
            ->setCustomerId($customer_id)
            ->setCustomerEmail($customer->getEmail())
            ->setCustomerFirstname($customer->getFirstname())
            ->setCustomerLastname($customer->getLastname())
            ->setCustomerGroupId($customer->getGroupId())
            ->setCustomerIsGuest(0);




        // Set Order Currency from store
        $order
            ->setGlobalCurrencyCode($currency)
            ->setBaseCurrencyCode($currency)
            ->setStoreCurrencyCode($currency)
            ->setOrderCurrencyCode($currency);

        // Set Billing address
        $order->setBillingAddress($billingOrderAddress);

        // set shipping address
        $order->setShippingAddress($shippingOrderAddress);


        if ($increment_id == "") {
            // set shipping method
            $order
                ->setShippingMethod($shipping_method)
                ->setShippingDescription($shipping_description);

            // set pyment method
            $orderPayment = $this->_orderPaymentRepository->create();
            $orderPayment->setMethod($payment_method);
            $order->setPayment($orderPayment);
        }

        $order->setState(\Magento\Sales\Model\Order::STATE_NEW);

        $quote_status=["quote_approved","quote_closed","quote_canceled"];

        if($order->getStatus() == "quote_pending" || $order->getStatus() == "quote_pending_approval") {
            $order->setItmQuoteExpDate($entity->getExtensionAttributes()->getItmQuoteExpDate());
            $order->setItmSboDownloadToSap("0");
            $order->setStatus("quote_pending_approval");
        }else if(in_array($order->getStatus(),$quote_status)){
            return "error|This quote cannot be updated - quote status = ".$order->getStatus();
        }else {

            // Set order status
            // set status
            $order->setStatus("pending");
        }


        //$product =  $this->_productRepository->get("A00001");

        // Set the Items
        foreach ($entity->getItems() as $item) {
            $orderItem = $this->_orderItemFactory->create();
            $sku = $item->getSku();
            $product = $this->_productRepository->get($sku);

            $rowSubTotal = $item->getQtyOrdered() * $item->getPrice();
            $discountRow = (float)$item->getDiscountPercent() * $rowSubTotal / 100;
            //$discountRow = $entity->getDiscountPercent()* $rowSubTotal / 100;


            $product_option = $item->getProductOption();
            $extAtt = $product_option->getExtensionAttributes();
            $cus_option = $extAtt->getCustomOptions();
            $options = [];

            foreach ($cus_option as $_option) {
                $option_value = $_option->getOptionValue();
                if( $_option->getOptionId()== "itm_uom_entry") {
                    if(empty($option_value)) {
                        $option_value = "-1";
                    }
                }
                $options["info_buyRequest"][$_option->getOptionId()] = $option_value;
            }
            //return count($cus_option);
            //return get_class($item->getProductOption() $item->getProductOption();//->getExtensionAttributes()->getCustomOptions();
            //  $options = [];
            //   $options["info_buyRequest"] = ["itm_uom_entry"=>"-1"];

            $orderItem
                ->setStoreId($storeId)
                ->setQuoteItemId(0)
                ->setQuoteParentItemId(null)
                ->setProductId($product->getId())
                ->setProductType($product->getTypeId())
                ->setQtyBackordered(null)
                ->setName($product->getName())
                ->setSku($product->getSku())
                ->setTotalQtyOrdered($item->getQtyOrdered())
                ->setQtyOrdered($item->getQtyOrdered())
                ->setPrice($item->getPrice())
                ->setBasePrice($item->getPrice())
                ->setOriginalPrice($item->getPrice())
                ->setBaseOriginalPrice($item->getPrice())
                ->setProductOptions($options)
                ->setTaxAmount($item->getTaxAmount())
                ->setBaseTaxAmount($item->getTaxAmount())
                ->setTaxPercent($item->getTaxAmount())
                ->setDiscountAmount($discountRow)
                ->setBaseDiscountAmount($discountRow)
                ->setRowTotal($item->getRowTotal())
                ->setBaseRowTotal($item->getBaseRowTotal())
                ->setWeight($product->getWeight() * $item->getQtyOrdered())
                ->setIsVirtual(0);

            if(!empty($createdAt)) {
                $orderItem->setCreatedAt($createdAt);
            }
            if(!empty($updatedAt)) {
                $orderItem->setUpdatedAt($updatedAt);
            }
            $order->addItem($orderItem);
        }




        // Set Total
        $order->setBaseGrandTotal($entity->getBaseGrandTotal());
        $order->setGrandTotal($entity->getGrandTotal());
        $order->setBaseSubtotal($entity->getBaseSubtotal());
        $order->setSubtotal($entity->getSubtotal());
        // Tax
        $order->setBaseTaxAmount($entity->getBaseTaxAmount());
        $order->setTaxAmount($entity->getTaxAmount());
        //Discount
        $order->setBaseDiscountAmount($entity->getDiscountAmount());
        $order->setDiscountAmount($entity->getDiscountAmount());

        // Total + Tax
        $order->setBaseSubtotalInclTax($entity->getBaseSubtotalInclTax());
        $order->setSubtotalInclTax($entity->getSubtotalInclTax());

        $order->setTotalItemCount($entity->getTotalItemCount());
        $order->setTotalQtyOrdered($entity->getTotalQtyOrdered());

        // set shipping amounts
        $order->setShippingAmount($entity->getShippingAmount());
        $order->setBaseShippingAmount($entity->getBaseShippingAmount());
        $order->setShippingTaxAmount($entity->getShippingTaxAmount());
        $order->setBaseShippingTaxAmount($entity->getBaseShippingTaxAmount());
        // shipping + tax
        $order->setShippingInclTax($entity->getShippingInclTax());
        $order->setBaseShippingInclTax($entity->getBaseShippingInclTax());


        $order->setItmSboDocentry($entity->getExtensionAttributes()->getItmSboDocentry());
        $order->setItmSboDocnum($entity->getExtensionAttributes()->getItmSboDocnum());
        $order->setItmSboDownloadToSap("0");


        if(!empty($createdAt)) {
            $order->setCreatedAt($createdAt);
        }

        if(!empty($updatedAt)) {
            $order->setUpdatedAt($updatedAt);
        }



        //  $order->setTotalPaid($paid);
        //$order->setBaseTotalPaid($paid);
        $order->save();

        if ($increment_id == "") {
            if ($this->helper->sendOrderEmail()) {
                // Send email
                $this->_objectManager->create('Magento\Sales\Model\OrderNotifier')
                    ->notify($order);
            }
        }
        $increment_id = $order->getIncrementId();
        $order = $order->loadByIncrementId($increment_id);

        return $order;
    }

    private function isJson($string)
    {
        if(is_array($string)){
            return false;
        }
        if (strpos($string, "{") == false && strpos($string, "[") == false) {
            return false;
        }
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getOrderInfo($increment_id)
    {
        /* Get instance of object manager */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $order = $objectManager->create('Magento\Sales\Model\Order');

        $order->loadByIncrementId($increment_id);
        if(empty($order->getEntityId())) {
            return "error|Order is not exist ID #".$increment_id;
        }
        $result = [];
        $order_array = $order->getData();

        $result["order"] = $order_array;

        $items_array = [];
        $i = 0;

        // $order->getItemsCollection()
        foreach ($order->getItems() as $item) {
            // if ($item->getParentItem()) {
            //    continue;
            //  }
            $items_array[$i] = $item->getData();

            $parent_product_id = $item->getData("parent_item")["product_id"];
            $parent_product = $objectManager->create('\Magento\Catalog\Model\Product')->load($parent_product_id);

            $items_array[$i]["original_sku"] = $parent_product->getSku();
            $i++;
        }

        $result["order"]["items"] = $items_array;

        if ($order->getShippingAddress() != null) {
            $result["order"]["shipping_address"] = $order->getShippingAddress()->getData();
        }

        if ($order->getBillingAddress() != null) {
            $result["order"]["billing_address"] = $order->getBillingAddress()->getData();
        }

        $payment_array = [];
        $payment_array = $order->getPayment()->getData();
        $payment_array["method"] = $order->getPayment()->getMethod();
        $additional_information_standard = $order->getPayment()->getData("additional_information");
        $additional_information = [];
        foreach ($additional_information_standard as $key => $addInfo) {
            if ($this->isJson($addInfo)) {
                $json_data = json_decode($addInfo, true);
                $additional_information[$key] = $json_data;
            } else {

                if (!empty($addInfo) && $addInfo != "{}") {
                    $additional_information[$key] = $addInfo;
                }
            }
        }


        /* if(count($payment_array["additional_information"])==0) {
             unset($payment_array["additional_information"]);
         }

         // Validate values (casuing error in PayPal when the value = "{}")
         foreach ($additional_information as $key=>$value) {
             if(empty($value)){
                 unset($additional_information[$key]);
             }
             if($value=="{}"){
                 unset($additional_information[$key]);
             }
         }
         */
        $payment_array["additional_information"] = $additional_information;


        // Code for ParadoxLabs / authnetcim
        if ($payment_array["method"] == "authnetcim") {
            if ($this->_moduleManager->isEnabled("ParadoxLabs_TokenBase")) {
                $cardRepository = $objectManager->get('\ParadoxLabs\TokenBase\Api\CardRepositoryInterface');
                $searchCriteriaBuilder = $objectManager->get('Magento\Framework\Api\SearchCriteriaBuilder');

                $filterBuilder = $objectManager->get('Magento\Framework\Api\FilterBuilder');
                $customer_id = $additional_information["customer_id"];
                $profile_id = $additional_information["profile_id"];
                $payment_id = $additional_information["payment_id"];

                $searchCriteria = $searchCriteriaBuilder
                    ->addFilter('customer_id', $customer_id, "eq")
                    ->addFilter('profile_id', $profile_id, "eq")
                    ->addFilter('payment_id', $payment_id, "eq")
                    ->create();

                $card_data_items = $cardRepository->getList($searchCriteria)->getItems();

                $payment_array["authnetcim"] = $card_data_items;
                if (count($card_data_items == 1)) {
                    foreach ($card_data_items as $card) {
                        if ($card->getCustomerId() == $customer_id && $card->getProfileId() == $profile_id && $card->getPaymentId() == $payment_id
                        ) {
                            $payment_array["authnetcim"] = $card->getData();
                        }
                    }
                }
            }
        }

        $result["order"]["payment"] = $payment_array;

        $result["order"]["status_histories"] = $order->getStatusHistoryCollection()->getData();

        // Get Invoices
        $invoices_collection = $order->getInvoiceCollection();
        $invoices_array = [];
        $i = 0;
        foreach ($invoices_collection as $_invoice) {
            $invoices_array[$i] = $_invoice->getData();
            $invoices_array[$i]["items"] = $_invoice->getItemsCollection()->getData();
            $i++;
        }

        $result["order"]["invoices"] = $invoices_array;

        // Get shipments
        $shipments_collection = $order->getShipmentsCollection();
        $shipments_array = [];
        $i = 0;
        foreach ($shipments_collection as $_shipment) {
            $shipments_array[$i] = $_shipment->getData();
            if(!is_array($_shipment->getItemsCollection())) {
                $shipments_array[$i]["items"] = $_shipment->getItemsCollection()->getData();
            }else {
                /// start
                $_items = [];
                foreach ($_shipment->getItemsCollection() as $__key=>$__item) {
                    $_item = [];
                    foreach ($__item->getData() as $__key=>$__value) {
                        $_item[$__key] = $__value;
                    }
                    $_items[] = $_item;
                }
                // end
                $shipments_array[$i]["items"] = $_items;//$_shipment->getItemsCollection();
            }
            $i++;
        }

        $result["order"]["shipments"] = $shipments_array;

        // getCreditmemosCollection
        // Get creditmemos
        $creditmemos_collection = $order->getCreditmemosCollection();
        $creditmemos_array = [];
        $i = 0;
        foreach ($creditmemos_collection as $_creditmemo) {
            $creditmemos_array[$i] = $_creditmemo->getData();
            $creditmemos_array[$i]["items"] = $_creditmemo->getItemsCollection()->getData();
        }

        $result["order"]["creditmemos"] = $creditmemos_array;

        $searchResult = $this->searchResultsFactory->create();
        //$searchResult->setSearchCriteria(null);
        $searchResult->setItems($result);
        $searchResult->setTotalCount(count($result));
        return $searchResult;
    }

    /**
     * Find entities by criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Sales\Api\Data\OrderSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $getFilterGroups = $searchCriteria->getFilterGroups();

        $filterGroup = $this->_objectManager->get('Magento\Framework\Api\Search\FilterGroup');
        $filterBuilder = $this->_objectManager->get('Magento\Framework\Api\FilterBuilder');
        $filter[] = $filterBuilder
            ->setField('itm_sbo_download_to_sap')
            ->setConditionType('null')
            //->setValue("0")
            ->create();

        $filter[] = $filterBuilder
            ->setField('itm_sbo_download_to_sap')
            ->setConditionType('neq')
            ->setValue("0")
            ->create();

        $filterGroup->setFilters($filter);
        $getFilterGroups[] = $filterGroup;
        $searchCriteria->setFilterGroups($getFilterGroups);
        $searchResult = $this->_orderRepository->getList($searchCriteria);

        return $searchResult;

    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getOrderCount(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {

        // new code
        $collection = $this->_objectManager
            ->get('Magento\Sales\Model\ResourceModel\Order\CollectionFactory')
            ->create();
        $collection->addFieldToFilter(
            array('itm_sbo_download_to_sap'), // columns/field of database table
            array( // conditions
                array( // conditions for 'sku' (first field)
                    array('null' => true),
                    array('eq' => 1),
                    array('eq' => "1"),
                )
            )
        );
        return $collection->getSize();
        // old code

        $getFilterGroups = $searchCriteria->getFilterGroups();
        $filterGroup = $this->_objectManager->get('Magento\Framework\Api\Search\FilterGroup');
        $filterBuilder = $this->_objectManager->get('Magento\Framework\Api\FilterBuilder');
        $filter[] = $filterBuilder
            ->setField('itm_sbo_download_to_sap')
            ->setConditionType('null')
            ->create();

        $filter[] = $filterBuilder
            ->setField('itm_sbo_download_to_sap')
            ->setConditionType('neq')
            ->setValue("0")
            ->create();

        $filterGroup->setFilters($filter);
        $getFilterGroups[] = $filterGroup;
        $searchCriteria->setFilterGroups($getFilterGroups);;
        $searchResult = $this->getList($searchCriteria);
        return count($searchResult);
    }

}
