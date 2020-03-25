<?php
namespace ITM\MagB1\Controller\Download;

use Psr\Log\LoggerInterface;
use \Magento\Framework\App\RequestInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    
    
    protected $resource;
    
    protected $helper;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\ResourceConnection $resource,
        \ITM\MagB1\Helper\Data $dataHelper
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->resource = $resource;
        $this->helper = $dataHelper;
    }
    
    public function dispatch(RequestInterface $request)
    {
        $type = $this->getRequest()->getParam("type");
        if($type != "catalog_category") {
            if (! $this->customerSession->authenticate()) {
                $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
            }
        }
        return parent::dispatch($request);
    }

    /**
     * say hello text
     */
    public function execute()
    {
       
        $type = $this->getRequest()->getParam("type");
        $file_id = $this->getRequest()->getParam("id");
        $files_model = '';
        $destinationUrl= '';
        $destinationPath = '';
       
        
        $backURL = 'customer/account';
        $customer_id = $this->customerSession->getCustomer()->getId();
        $order_table =  $this->resource->getTableName("sales_order");
        $invoice_table =  $this->resource->getTableName("sales_invoice");
        $shipment_table =  $this->resource->getTableName("sales_shipment");
        
        
        
        
        if($type == "sales_order") {
            $files_model = 'ITM\MagB1\Model\ResourceModel\Orderfiles\Collection';
            $destinationUrl= $this->helper->getOrderfilesUrl();
            $destinationPath= $this->helper->getOrderfilesPath();
            
            $files_collection = $this->_objectManager->get($files_model);
            $files_collection->addFieldToFilter("main_table.entity_id", $file_id);
            $files_collection->getSelect()
            ->join(array('order_table' => $order_table),'main_table.increment_id = order_table.increment_id','order_table.increment_id');
            $files_collection->addFieldToFilter("order_table.customer_id",  $customer_id);
            
        }else if($type == "sales_invoice") {
            $files_model = 'ITM\MagB1\Model\ResourceModel\Invoicefiles\Collection';
            $destinationUrl= $this->helper->getInvoicefilesUrl();
            $destinationPath= $this->helper->getInvoicefilesPath();
            
            
            $files_collection = $this->_objectManager->get($files_model);
            $files_collection->addFieldToFilter("main_table.entity_id", $file_id);
            $files_collection->getSelect()
            ->join(array('invoice_table' => $invoice_table),'main_table.increment_id = invoice_table.increment_id','invoice_table.increment_id')
            ->join(array('order_table' => $order_table),'invoice_table.order_id = order_table.entity_id','order_table.customer_id');
            $files_collection->addFieldToFilter("order_table.customer_id",  $customer_id);
            
        } else if($type == "sales_shipment") {
            $files_model = 'ITM\MagB1\Model\ResourceModel\Shipmentfiles\Collection';
            $destinationUrl= $this->helper->getShipmentfilesUrl();
            $destinationPath= $this->helper->getShipmentfilesPath();
            
            $files_collection = $this->_objectManager->get($files_model);
            $files_collection->addFieldToFilter("main_table.entity_id", $file_id);
            $files_collection->getSelect()
            ->join(array('shipment_table' => $shipment_table),'main_table.increment_id = shipment_table.increment_id','shipment_table.increment_id')
            ->join(array('order_table' => $order_table),'shipment_table.order_id = order_table.entity_id','order_table.customer_id');
            $files_collection->addFieldToFilter("order_table.customer_id",  $customer_id);
        } else if($type == "catalog_category") {
            $files_model = 'ITM\MagB1\Model\ResourceModel\Categoryfiles\Collection';
            $destinationUrl= $this->helper->getCategoryfilesUrl();
            $destinationPath= $this->helper->getCategoryfilesPath();
            
            $files_collection = $this->_objectManager->get($files_model);
            $files_collection->addFieldToFilter("entity_id", $file_id);
        }else if($type == "customer_customer") {
            
            $files_model = 'ITM\MagB1\Model\ResourceModel\Customerfiles\Collection';
            $destinationUrl= $this->helper->getCustomerfilesUrl();
            $destinationPath= $this->helper->getCustomerfilesPath();
            
            $files_collection = $this->_objectManager->get($files_model);
            $files_collection->addFieldToFilter("entity_id", $file_id);
            $files_collection->addFieldToFilter("customer_id", $customer_id);

        }else {
            $this->_redirect($backURL);
            return;
        }
        
        
        
        
        if($files_collection->getSize() > 0) {
            $first_item = $files_collection->getFirstItem()->getData();
                        //$destinationUrl = $destinationUrl."/store_".$first_item["store_id"]."/".md5($first_item["increment_id"])."/".$first_item["path"];
            
            if($type == "customer_customer") {
                $file_ext = "customer";
                $destinationPath = $destinationPath.$first_item["customer_id"]."/".$first_item["path"];
            } else if ($type == "catalog_category") {
                $file_ext = "cat";
                $destinationPath = $destinationPath."/store_".$first_item["store_id"]."/".md5($first_item["code"])."/".$first_item["path"];
                
                
            } else {
                $file_ext = $first_item["increment_id"];
                $destinationPath = $destinationPath."/store_".$first_item["store_id"]."/".md5($first_item["increment_id"])."/".$first_item["path"];
            }
           // $files_collection = $this->_objectManager->get($files_model);
          //  $files_collection->addFieldToFilter("main_table.entity_id", $file_id);
            $ext = pathinfo($destinationPath, PATHINFO_EXTENSION);
            
            
            $file_name = $first_item["path"];//md5($first_item["path"]).".".$ext;
            
            $this->getResponse ()
            ->setHttpResponseCode ( 200 )
            ->setHeader ( 'Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true )
            ->setHeader ( 'Pragma', 'public', true )
            ->setHeader ( 'Content-type', 'application/force-download' )
            ->setHeader ( 'Content-Length', filesize($destinationPath) )
            ->setHeader ('Content-Disposition', 'attachment' . '; filename=' . time()."-".$file_name);
            $this->getResponse ()->clearBody ();
            $this->getResponse ()->sendHeaders ();
            readfile ( $destinationPath);
            exit;
        }
        else {
            $this->_redirect($backURL);
        }

    }
}