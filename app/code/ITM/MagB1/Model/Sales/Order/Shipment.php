<?php
namespace ITM\MagB1\Model\Sales\Order;

use ITM\MagB1\Api\Sales\ShipmentInterface;

class Shipment implements ShipmentInterface
{

    private $logger;

    /**
     *
     * @var \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader
     */
    private $shipmentLoader;

    /**
     *
     * @var \Magento\Framework\App\ObjectManager
     */
    private $objectManager;


    private $helper;
    /**
     * Factory constructor.
     *
     * @param \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader
     */
    public function __construct(
        \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader,
        \Psr\Log\LoggerInterface $logger,
        \ITM\MagB1\Helper\Data $helper
    ) {
        $this->helper = $helper;
        $this->shipmentLoader = $shipmentLoader;
        $this->logger = $logger;
        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }
    
    private function getOrderItemsUomEntryProductOption($order)
    {
        $uom_entry_list = [];
        foreach ($order->getAllItems() as $item) {
            $uom_entry_list["order"][$item->getItemId()] = "-1";
            $product_options = $item->getProductOptions();
            $info_buyRequest = $product_options["info_buyRequest"];
            $info = $item->getProductOptionByCode('info_buyRequest');
            if(isset($info["itm_uom_entry"])) {
                $uom_entry_list["order"][$item->getItemId()] = $info["itm_uom_entry"];
            }else {
                if(isset( $uom_entry_list["order"][$item->getParentItemId()])) {
                    $uom_entry_list["order"][$item->getItemId()] =  $uom_entry_list["order"][$item->getParentItemId()];
                } else {
                    $uom_entry_list["order"][$item->getItemId()] = "-1";
                }
            }
            if( $uom_entry_list["order"][$item->getItemId()] == "0") {
                $uom_entry_list["order"][$item->getItemId()] = "-1";
            }
        }
        return $uom_entry_list;
    }
    
    private function getOrderItemsUomEntry($order)
    {
        $quote = $this->objectManager->create('\Magento\Quote\Model\Quote');
        $quote->load($order->getQuoteId());
        
        $uom_entry = [];
        foreach ($quote->getAllItems() as $item) {
            if (null != $item->getBuyRequest()->getData("itm_uom_entry") &&
                     $item->getBuyRequest()->getData("itm_uom_entry") > 0) {
                $uom_entry["quote"][$item->getItemId()] = $item->getBuyRequest()->getData("itm_uom_entry");
            } else {
                $uom_entry["quote"][$item->getItemId()] = - 1;
            }
        }
        if (isset($uom_entry["quote"])) {
            foreach ($order->getAllVisibleItems() as $item) {
                $uom_entry["order"][$item->getItemId()] = $uom_entry["quote"][$item->getQuoteItemId()];
            }
        }
        return $uom_entry;
    }

    private function getItemsBySku($_items, $order)
    {
        $items = [];
        //$uom_entry = $this->getOrderItemsUomEntry($order);
        
        $uom_entry = $this->getOrderItemsUomEntryProductOption($order);
                
        foreach ($order->getAllVisibleItems() as $item) {
            $oItem = $this->objectManager->create("\Magento\Sales\Api\Data\ShipmentItemInterface");
            $oItem->setOrderItemId($item->getItemId());
            $oItem->setQty(0);
            $items[] = $oItem;
        }

        foreach ($_items as $_item) {
            $total_qty = $_item->getQty();
            $sap_uom_entry =  $this->helper->ignoreUom() == true? "-1":$_item->getUomEntry();
            $sap_sku = $_item->getSku();

            $order_items = $this->objectManager->create('Magento\Sales\Model\Order\Item')
                ->getCollection()
                ->AddFieldToFilter("sku", $_item->getSku())
                ->AddFieldToFilter("order_id", $order->getId());
            
            foreach ($order->getAllVisibleItems() as $order_item) {
            //foreach ($order_items as $order_item) {
                $item_sku = $order_item->getSku();
                $allowed_qty = $order_item->getQtyOrdered() - $order_item->getQtyShipped();
                $order_item->load($order_item->getItemId());
                $item_uom_entry = $order_item->getBuyRequest()->getData("itm_uom_entry");

                // if the available qty = 0 then we cannot preocess this line, go to the next line
                if ($allowed_qty == 0) {
                    continue;
                }
                if ($sap_sku != $item_sku) {
                    continue;
                }
                
                $item_uom_entry = $uom_entry["order"][$order_item->getItemId()];
                if ($item_uom_entry != $sap_uom_entry) {
                    continue;
                }
                
                if ($total_qty <= $allowed_qty) {
                    $ordered_qty = $total_qty;
                    $oItem = $this->objectManager->create("\Magento\Sales\Api\Data\ShipmentItemInterface");
                    $oItem->setOrderItemId($order_item->getItemId());
                    $oItem->setQty($ordered_qty);
                    $items[] = $oItem;
                    break;
                } else {
                    $ordered_qty = $allowed_qty;
                    $total_qty = $total_qty - $allowed_qty; // $allowed_qty = $ordered_qty
                    
                    $oItem = $this->objectManager->create("\Magento\Sales\Api\Data\ShipmentItemInterface");
                    $oItem->setOrderItemId($order_item->getItemId());
                    $oItem->setQty($ordered_qty);
                    $items[] = $oItem;
                    continue;
                }
            }
        }
        return $items;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function createShipment($entity, $items, $send_email= true)
    {
        

        $return_result = $this->objectManager->create("\ITM\MagB1\Model\ReturnResult");
        $shipment_data = $entity;
        
        $order = $this->objectManager->create('\Magento\Sales\Model\Order');
        $order->loadByIncrementId($entity->getIncrementId());


       // return json_encode($this->getOrderItemsUomEntry($order));
        //return json_encode($this->getOrderItemsUomEntryProductOption($order));

        // Shipment Data
        $data = [];
        
        if (count($entity->getItems()) == 0) {
            $entity->setItems($this->getItemsBySku($items, $order));
        }
        
        $data["increment_id"] = $shipment_data->getIncrementId();
        $data["items"] = [];
        
        foreach ($shipment_data->getItems() as $item) {
            $data["items"][$item->getOrderItemId()] = $item->getQty();
        }
        
        $data["comment_text"] = $shipment_data->getCommentText();
        $data['comment_customer_notify'] = $shipment_data->getCommentCustomerNotify();
        ;
        $data['is_visible_on_front'] = $shipment_data->getIsVisibleOnFront();
        ;
        
        $data['tracks'] = [];
        
        foreach ($shipment_data->getTracks() as $item) {
            $data['tracks'][] = [
                "carrier_code" => $item->getCarrierCode(),
                "title" => $item->getTitle(),
                "number" => $item->getNumber()
            ];
        }
        
        //return json_encode($data);
        // $return_result->setError(true);
        // $return_result->setData(json_encode($data["items"]));
        // return $return_result;
        
        $tracking = $data["tracks"];
        
        foreach ($data["items"] as $key=>$value) {
            if($value <= 0) {
                unset($data["items"] [$key]);
            }
        }
        $itemsArray = $data["items"];

       // return json_encode($itemsArray);
        if (count($itemsArray) <= 0) {
            $return_result->setError(true);
            $return_result->setData(
                json_encode(
                    [
                        "error_message" => "order cannot be shipped, no lines found"
                    ]));
            return $return_result;
        }
        
        
        if ($order->canShip()) {
            // Start Create Shipment
            $order_id = $order->getEntityId();
            $this->shipmentLoader->setOrderId($order_id);
            $this->shipmentLoader->setShipmentId(null);
            $this->shipmentLoader->setShipment($data);
            $this->shipmentLoader->setTracking($tracking);
            
            $shipment = $this->shipmentLoader->load();
            
            if (! empty($data['comment_text'])) {
                $shipment->addComment(
                    $data['comment_text'],
                    isset($data['comment_customer_notify']),
                    isset($data['is_visible_on_front'])
                );
                
                $shipment->setCustomerNote($data['comment_text']);
                $shipment->setCustomerNoteNotify(isset($data['comment_customer_notify']));
            }
            
            $shipment->register();
            $shipment->getOrder()->setCustomerNoteNotify(! empty($data['send_email']));
            
            $shipment->getOrder()->setIsInProcess(true);
            $transaction = $this->objectManager->create('Magento\Framework\DB\Transaction');
            
            $transaction->addObject($shipment)
                ->addObject($shipment->getOrder())
                ->save();
            
            if ($send_email) {
                // Send email
                $this->objectManager->create('Magento\Shipping\Model\ShipmentNotifier')
                ->notify($shipment);
            }
            // send notification code
            $order->addStatusHistoryComment(__('Invoice #%1 created by MagB1.', $shipment->getIncrementId()))
                ->setIsCustomerNotified(true)
                ->save();

            $return_result->setError(false);
            $return_result->setData(
                json_encode([
                    "increment_id" => $shipment->getIncrementId()
                ])
            );
        } else {
            $return_result->setError(true);
            $return_result->setData(
                json_encode([
                    "error_message" => "order cannot be shiped"
                ])
            );
        }
        
        return $return_result;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function shipmentDataExample()
    {
        
        // Shipment Data
        $data = [];
        $data["increment_id"] = "2000000002";
        $data["items"] = [
            "15" => 1
        ];
        
        $data["comment_text"] = "TEST From Code";
        $data['comment_customer_notify'] = 1;
        $data['comment_customer_notify'] = 1;
        $data['is_visible_on_front'] = 1;
        $data['tracks'][] = [
            "carrier_code" => "dhl",
            "title" => "DHT",
            "number" => "30"
        ];
        ;
        $tracking = $data["tracks"];
    }
    /**
     *
     * {@inheritdoc}
     *
     */
    public function sendShipmentEmail($increment_id)
    {
        $shipment = $this->objectManager->create('\Magento\Sales\Model\Order\Shipment');
        $shipment->loadByIncrementId($increment_id);

        $this->objectManager->create('Magento\Shipping\Model\ShipmentNotifier')
            ->notify($shipment);
        return $increment_id;
    }
}
