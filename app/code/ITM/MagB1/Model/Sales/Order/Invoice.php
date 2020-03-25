<?php
namespace ITM\MagB1\Model\Sales\Order;

use ITM\MagB1\Api\Sales\InvoiceInterface;

class Invoice implements InvoiceInterface
{

    private $logger;

    private $objectManager;

    private $helper;
    /**
     * Factory constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger, \ITM\MagB1\Helper\Data $helper)
    {
        $this->logger = $logger;
        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->helper = $helper;
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
                }else {
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
        $items = array();
        //$uom_entry = $this->getOrderItemsUomEntry($order);
        $uom_entry = $this->getOrderItemsUomEntryProductOption($order);
        
        
        foreach ($order->getAllVisibleItems() as $item) {
            $oItem = $this->objectManager->create("\Magento\Sales\Api\Data\InvoiceItemInterface");
            $oItem->setOrderItemId($item->getItemId());
            $oItem->setQty(0);
            $items[] = $oItem;
        }
        
        foreach ($_items as $_item) {
            $total_qty = $_item->getQty();
            //$sap_uom_entry = $_item->getUomEntry();
            $sap_uom_entry =  $this->helper->ignoreUom() == true? "-1":$_item->getUomEntry();
            $sap_sku = $_item->getSku();
            
            $order_items = $this->objectManager->create('Magento\Sales\Model\Order\Item')
                ->getCollection()
                ->AddFieldToFilter("sku", $_item->getSku())
                ->AddFieldToFilter("order_id", $order->getId())
                ->load();
            
            foreach ($order->getAllVisibleItems() as $order_item) {
            //foreach ($order_items as $order_item) {
                $item_sku = $order_item->getSku();
                $allowed_qty = $order_item->getQtyOrdered() - $order_item->getQtyInvoiced();
                
                $order_item->load($order_item->getItemId());
                $item_uom_entry = $order_item->getBuyRequest()->getData("itm_uom_entry");
                
                // $item_uom_entry = isset($item_uom_entry)? $item_uom_entry : "";
                
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
                    $oItem = $this->objectManager->create("\Magento\Sales\Api\Data\InvoiceItemInterface");
                    $oItem->setOrderItemId($order_item->getItemId());
                    $oItem->setQty($ordered_qty);
                    $items[] = $oItem;
                    break;
                } else {
                    $ordered_qty = $allowed_qty;
                    $total_qty = $total_qty - $allowed_qty; // $allowed_qty = $ordered_qty
                    
                    $oItem = $this->objectManager->create("\Magento\Sales\Api\Data\InvoiceItemInterface");
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
    public function createInvoice($entity, $items, $send_email = true)
    {
        $return_result = $this->objectManager->create("\ITM\MagB1\Model\ReturnResult");
        $shipment_data = $entity;
        
        $order = $this->objectManager->create('\Magento\Sales\Model\Order');
        $order->loadByIncrementId($entity->getIncrementId());

        // Invoice Data
        $data = [];
        
        if (count($entity->getItems()) == 0) {
            $entity->setItems($this->getItemsBySku($items, $order));
        }
        
        $data["increment_id"] = $entity->getIncrementId();
        $data["items"] = [];
        
        foreach ($entity->getItems() as $item) {
            $data["items"][$item->getOrderItemId()] = $item->getQty();
        }
        
        $data["comment_text"] = $entity->getCommentText();
        $data['comment_customer_notify'] = $entity->getCommentCustomerNotify();
        $data['is_visible_on_front'] = $entity->getIsVisibleOnFront();
        
        // $return_result->setError(true);
        // $return_result->setData(json_encode($data["items"]));
        // return $return_result;
        
        if (count($data["items"]) == 0) {
            $return_result->setError(true);
            $return_result->setData(json_encode([
                "error_message" => "lines is not set"
            ]));
            return $return_result;
        }
        
        foreach ($data["items"] as $key=>$value) {
            if($value <= 0) {
                unset($data["items"] [$key]);
            }
        }
        
        $itemsArray = $data["items"];
        
        if (count($itemsArray) <= 0) {
            $return_result->setError(true);
            $return_result->setData(
                json_encode(
                    [
                        "error_message" => "order cannot be invoiced, no lines found"
                    ]));
            return $return_result;
        }
       // return json_encode($itemsArray);
        if ($order->canInvoice()) {
            // Check if can invoice
            $invoice = $this->objectManager->create('Magento\Sales\Model\Service\InvoiceService')
                ->prepareInvoice($order, $itemsArray);

            if($entity->getIsPaid() == true) {
                $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_OFFLINE);
            }else {
                $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::NOT_CAPTURE);
            }
            $invoice->register();
            
            if (! empty($data['comment_text'])) {
                $invoice->addComment(
                    $data['comment_text'],
                    isset($data['comment_customer_notify']),
                    isset($data['is_visible_on_front'])
                );
            }
            $invoice->save();
            $transactionSave = $this->objectManager->create('Magento\Framework\DB\Transaction')
                ->addObject($invoice)
                ->addObject($invoice->getOrder());
            $transactionSave->save();
            
            if ($send_email) {
                // Send email
                $this->objectManager->create('Magento\Sales\Model\Order\InvoiceNotifier')
                ->notify($invoice);
            }
            
            // send notification code
            $order->addStatusHistoryComment(__('Invoice #%1 created by MagB1.', $invoice->getIncrementId()))
                ->setIsCustomerNotified(true)
                ->save();
            
            $return_result->setError(false);
            $return_result->setData(
                json_encode([
                    "increment_id" => $invoice->getIncrementId()
                ])
            );
        } else {
            $return_result->setError(true);
            $return_result->setData(
                json_encode([
                        "error_message" => "order cannot be invoiced"
                ])
            );
        }

        return $return_result;
    }
}
