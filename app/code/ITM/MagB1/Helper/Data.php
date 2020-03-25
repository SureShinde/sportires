<?php

namespace ITM\MagB1\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    const MODULE_NAME = 'ITM_MagB1';

    protected $_moduleList;

    protected $_storeManager;

    protected $fileSystem;

    protected $_objectManager;

    protected $customerSession;

    protected $_urlInterface;

    protected $_orderCollectionFactory;

    protected $_scopeConfig;

    protected $_send_order_email;

    protected $_clear_product_cache;

    protected $_global_display_all_orders;

    protected $_customer_display_all_orders;

    protected $_customerFactory;

    protected $request;

    protected $files_tab_label;

    protected $display_general_infomration = false;

    protected $dgi_groups = [];

    protected $allow_delete_orders = false;

    protected $_customer_group_id = 0;

    protected $_ignoreUom = false;
    /**
     * @var \Magento\Customer\Model\GroupFactory
     */
    protected $_groupFactory;

    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $_priceHelper;

    protected $_display_customer_attributes = [];

    /**
     *
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\UrlInterface $urlInterface,
        \ITM\MagB1\Model\ResourceModel\Orderfiles\CollectionFactory $collectionFactory,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\GroupFactory $groupFactory,
        \Magento\Framework\Pricing\Helper\Data $priceHelper
    )
    {
        $this->fileSystem = $fileSystem;
        $this->_storeManager = $storeManager;
        $this->_objectManager = $objectManager;
        $this->customerSession = $customerSession;
        $this->_urlInterface = $urlInterface;
        $this->_orderCollectionFactory = $collectionFactory;
        $this->_moduleList = $moduleList;
        $this->_scopeConfig = $scopeConfig;
        $this->_customerFactory = $customerFactory;
        $this->request = $request;
        $this->_send_order_email = (bool)trim($this->_scopeConfig->getValue('itm_magb1_section/general/send_order_email'));
        $this->_clear_product_cache = (bool)trim($this->_scopeConfig->getValue('itm_magb1_section/general/clear_product_cache'));
        $this->_global_display_all_orders = (bool)trim($this->_scopeConfig->getValue('itm_magb1_section/general/display_all_orders'));
        $this->files_tab_label = trim($this->_scopeConfig->getValue('itm_magb1_section/general/files_tab_label', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
        $this->allow_delete_orders = trim($this->_scopeConfig->getValue('itm_magb1_section/general/allow_delete_orders'));
        $this->check_disabled_payment_methods = (bool)trim($this->_scopeConfig->getValue('itm_magb1_section/general/check_disabled_payment_methods'));
        $this->display_general_infomration = (bool)trim($this->_scopeConfig->getValue('itm_magb1_section/general/display_general_infomration'));
        $dgi_customer_attributes = trim($this->_scopeConfig->getValue('itm_magb1_section/general/dgi_customer_attributes'));

        // coming from the pricing ext.
        $this->_ignoreUom = (bool)trim($this->_scopeConfig->getValue('itm_pricing_section/general/ignore_uom'));

        $dgi_groups = trim($this->_scopeConfig->getValue('itm_magb1_section/general/dgi_customer_groups'));

        $this->dgi_groups = explode(",",$dgi_groups);

        if (empty($this->files_tab_label)) {
            $this->files_tab_label = __("Files");
        }

       // $this->customerSession = $this->_objectManager->create('\Magento\Customer\Model\Session');
        $customer_id =  $this->customerSession->getCustomer()->getId();
        if ($customer_id > 0) {
            $this->_customer_group_id =  $this->customerSession->getCustomer()->getGroupId();
        }

        $this->_groupFactory = $groupFactory;
        $this->_priceHelper = $priceHelper;


        $dgi_customer_attributes_array =  [];
        if(!empty($dgi_customer_attributes)) {
            $dgi_customer_attributes_array = explode(PHP_EOL, $dgi_customer_attributes);
        }
        if(!empty($dgi_customer_attributes_array)) {
            foreach ($dgi_customer_attributes_array as $_item) {
                $item = explode("|", $_item);
                $value = $this->getCustomer()->getData($item[1]);
                if(isset($item[2])) {
                    switch (trim($item[2])) {
                        case "#" :
                            {
                                $value = "#". $value;
                                break;
                            }
                        case "price" :
                            {
                                $value =  $this->_priceHelper->currency($value,true,false);;
                                break;
                            }
                    }
                }
                $this->_display_customer_attributes[] = [
                    "label" =>__($item[0]),
                    "value" => $value
                ];
            }
        }
        //
    }

    public function ignoreUom() {
        return $this->_ignoreUom;
    }
    public function getDisplayAttributes()
    {
        return $this->_display_customer_attributes;
    }
    public function displayGeneralInfomration()
    {
        if($this->display_general_infomration == true) {
            if(in_array($this->_customer_group_id, $this->dgi_groups) | in_array("32000", $this->dgi_groups)) {
                return $this->display_general_infomration;
            }
        }
        return false;
    }

    public function getCustomerCollection()
    {
        return $this->_customerFactory->create();
    }

    public function  getDisabledPaymentMethods(){

        $_customerSession = $this->_objectManager->create('\Magento\Customer\Model\Session');
        $customer_id = $_customerSession->getCustomer()->getId();
        $group_id = 0;
        if ($customer_id > 0) {
            $group_id = $_customerSession->getCustomer()->getGroupId();
        }
        $customerGroup = $this->_groupFactory->create();
        $customerGroup->load($group_id);
        $value = $customerGroup->getData("itm_payment_methods");

        $methods = explode(",",$value);
        return $methods;
    }

    public function checkDisabledPaymentMethods() {

        return $this->check_disabled_payment_methods;
    }
    public function getPaymentMethodList()
    {
        $result = [];
        foreach ($this->_scopeConfig->getValue('payment', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null) as $code => $data) {
            if (isset($data['active']) && (bool) $data['active'] && isset($data['model'])) {
                $result[] = [
                    "code" => $code,
                    "model" => $data
                ];
            }
        }
        return $result;
    }

    public function displayAllOrders()
    {
        $customer_display_all_orders = $this->customerSession->getCustomer()->getData("display_all_orders");
        if (empty($customer_display_all_orders)) {
            return $this->_global_display_all_orders;
        } else {
            if ($customer_display_all_orders == 1) {
                return true;
            } else {
                return false;
            }
        }
        return $this->_global_display_all_orders;
    }

    public function allowDeleteOrders()
    {
        return $this->allow_delete_orders;
    }
    public function getFilesTabTitle()
    {
        return $this->files_tab_label;
    }

    public function getVersion()
    {
        $version = "MagB1 Version: " . $this->_moduleList
                ->getOne(self::MODULE_NAME)['setup_version'];

        $current_version = $this->_objectManager->get('\Magento\Framework\App\ProductMetadataInterface')->getVersion();
        $current_edition = $this->_objectManager->get('\Magento\Framework\App\ProductMetadataInterface')->getEdition();

        $version .= ", " . $current_edition . ": " . $current_version;
        return $version;
    }

    public function isDisable()
    {
        return $module_status = (boolean)$this->_scopeConfig->getValue('advanced/modules_disable_output/ITM_MagB1');
    }

    public function canViewOrder(\Magento\Sales\Model\Order $order)
    {
        $full_name = $this->request->getFullActionName();

        $names = ["magb1_order_view", "magb1_order_print"];
        if (!in_array($full_name, $names)) {
            return false;
        }
        if ($this->displayAllOrders()) {
            $cardCode = $this->customerSession->getCustomer()->getData("itm_cardcode");
            if (in_array($order->getCustomerId(), $this->getCustomerIdsByCardCode($cardCode))) {
                return true;
            }
        }
        return false;
    }

    public function getCustomerId()
    {
        $customerId = $this->customerSession->getCustomerId();
        return $customerId;
    }

    public function getCurrentCustomerCardCode()
    {
        return $this->getCustomer()->getData("itm_cardcode");
    }

    public function getCurrentCustomerCreditBalance()
    {
        return $this->_priceHelper->currency($this->getCustomer()->getData("itm_credit_balance"),true,false);
    }
    public function getCurrentCustomerCreditLimit()
    {

        return $this->_priceHelper->currency($this->getCustomer()->getData("itm_credit_limit"),true,false);
    }

    public function getCustomer()
    {
        return $this->customerSession->getCustomer();
    }

    public function getCustomerIdsByCardCode($cardCode)
    {
        $collection = $this->getCustomerCollection();
        // $cardCode = $this->getCustomer()->getData("itm_cardcode");
        $collection->addAttributeToFilter("itm_cardcode", $cardCode);
        return $collection->getColumnValues("entity_id");
    }

    public function sendOrderEmail()
    {
        return $this->_send_order_email;

    }

    public function clearProductCache()
    {
        return $this->_clear_product_cache;

    }

    public function _log($message)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/magb1.log');

        $logger = new \Zend\Log\Logger();

        $logger->addWriter($writer);

        $logger->info($message);
    }

    public function getCategoryFileById($id)
    {
        $url = $this->_urlInterface->getUrl('magb1/download/index', [
                "type" => "catalog_category",
                "id" => $id,
                '_nosid' => true
            ]
        );
        return $url;
    }

    public function getCategoryFileLinkById($id)
    {
        $files_collection = $this->_objectManager->get('\ITM\MagB1\Model\ResourceModel\Categoryfiles\CollectionFactory')->create();
        $files_collection->addFieldToFilter("entity_id", $id);
        $first_item = $files_collection->getFirstItem()->getData();

        $destinationUrl = $this->getCategoryfilesUrl();

        $destinationPath = $destinationUrl . "/store_" . $first_item["store_id"] . "/" . md5($first_item["code"]) . "/" . $first_item["path"];

        $url = $destinationPath;
        return $url;
    }

    public function getCategoriesFiles($category_ids = [], $store_id = null)
    {
        $collectionFactory = $this->_objectManager->get('\ITM\MagB1\Model\ResourceModel\Categoryfiles\CollectionFactory');
        $collection = $collectionFactory->create();
        $collection->addFieldToFilter('status', 1);
        $find_in_set = [];

        foreach ($category_ids as $category_id) {
            $find_in_set[] = ['finset' => [$category_id]];
        }

        if (count($find_in_set) > 0) {
            $collection->addFieldToFilter('category_id', $find_in_set);
        }

        if (!empty($store_id)) {
            $store_ids = [0, $store_id];
            $collection->addFieldToFilter("store_id", ["in" => $store_ids]);
        }
        $results = [];
        foreach ($collection as $item) {
            $result["url"] = $this->_storeManager->getStore()->getUrl('magb1/download/index', [
                    "type" => "catalog_category",
                    "id" => $item->getData("entity_id")
                ]
            );
            $result["description"] = $item->getData("description");
            $results[] = $result;
        }

        return $results;
    }


    public function getProductFiles($sku)
    {
        $model = $this->_objectManager->create('ITM\MagB1\Model\Productfiles');

        $stores = [];
        $stores[] = 0;
        $store_id = $this->_storeManager->getStore()->getStoreId();
        $stores[] = $store_id;
        $collection = $model->getCollection()
            ->addFieldToFilter("sku", $sku)
            ->addFieldToFilter("store_id", array("in" => $stores));

        return $collection;
    }

    public function getOrderFiles($customer_id, $increment_id)
    {
        $collection = $this->_orderCollectionFactory->create();
        $collection->addFieldToFilter("increment_id", $increment_id);
        $store_id = $this->_storeManager->getStore()->getId();

        $collection->addFieldToFilter("store_id", [
            "in" => [
                $store_id,
                0
            ]
        ]);

        $collection->addFieldToSelect("entity_id");
        $collection->addFieldToSelect("path");
        $collection->addFieldToSelect("description");

        return $collection->getData();
    }

    public function getInvoiceFiles($customer_id, $increment_id)
    {
        $collection = $this->_objectManager->create('ITM\MagB1\Model\ResourceModel\Invoicefiles\Collection');
        $collection->addFieldToFilter("increment_id", $increment_id);

        $store_id = $this->_storeManager->getStore()->getId();

        $collection->addFieldToFilter("store_id", [
            "in" => [
                $store_id,
                0
            ]
        ]);

        $collection->addFieldToSelect("entity_id");
        $collection->addFieldToSelect("path");
        $collection->addFieldToSelect("description");

        return $collection->getData();
    }

    public function getShipmentFiles($customer_id, $increment_id)
    {
        $collection = $this->_objectManager->create('ITM\MagB1\Model\ResourceModel\Shipmentfiles\Collection');
        $collection->addFieldToFilter("increment_id", $increment_id);

        $store_id = $this->_storeManager->getStore()->getId();

        $collection->addFieldToFilter("store_id", [
            "in" => [
                $store_id,
                0
            ]
        ]);

        $collection->addFieldToSelect("entity_id");
        $collection->addFieldToSelect("path");
        $collection->addFieldToSelect("description");

        return $collection->getData();
    }

    public function getCustomerFiles($customer_id)
    {
        $collection = $this->_objectManager->create('ITM\MagB1\Model\ResourceModel\Customerfiles\Collection');
        $collection->addFieldToFilter("customer_id", $customer_id);

        $collection->addFieldToSelect("entity_id");
        $collection->addFieldToSelect("path");
        $collection->addFieldToSelect("description");

        return $collection->getData();
    }

    public function getMediaPath()
    {
        return $this->fileSystem
                ->getDirectoryWrite(DirectoryList::MEDIA)
                ->getAbsolutePath('/') . "catalog/product/";
    }

    public function getModuleFilesPath()
    {
        return $this->fileSystem
                ->getDirectoryWrite(DirectoryList::MEDIA)
                ->getAbsolutePath('/') . "itm/magb1/";
    }

    public function getModuleFilesUrl()
    {
        return $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . "itm/magb1/";
    }

    public function getProductFilesPath()
    {
        return $this->getModuleFilesPath() . "Productfiles/";
    }

    public function getCategoryFilesPath()
    {
        return $this->getModuleFilesPath() . "Categoryfiles/";
    }

    public function getOrderfilesPath()
    {
        return $this->getModuleFilesPath() . "Orderfiles/";
    }

    public function getInvoicefilesPath()
    {
        return $this->getModuleFilesPath() . "Invoicefiles/";
    }

    public function getShipmentfilesPath()
    {
        return $this->getModuleFilesPath() . "Shipmentfiles/";
    }

    public function getCustomerfilesPath()
    {
        return $this->getModuleFilesPath() . "Customerfiles/";
    }

    public function getProductFilesURL()
    {
        $mediaUrl = $this->getModuleFilesUrl() . "Productfiles/";

        return $mediaUrl;
    }

    public function getCategoryFilesURL()
    {
        $mediaUrl = $this->getModuleFilesUrl() . "Categoryfiles/";

        return $mediaUrl;
    }

    public function getOrderfilesURL()
    {
        $mediaUrl = $this->getModuleFilesUrl() . "Orderfiles/";

        return $mediaUrl;
    }

    public function getInvoicefilesURL()
    {
        $mediaUrl = $this->getModuleFilesUrl() . "Invoicefiles/";

        return $mediaUrl;
    }

    public function getShipmentfilesURL()
    {
        $mediaUrl = $this->getModuleFilesUrl() . "Shipmentfiles/";

        return $mediaUrl;
    }

    public function getCustomerfilesURL()
    {
        $mediaUrl = $this->getModuleFilesUrl() . "Customerfiles/";

        return $mediaUrl;
    }
}
