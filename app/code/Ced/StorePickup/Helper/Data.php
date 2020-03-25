<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_StorePickup
 * @author 		CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (https://cedcommerce.com/)
 * @license      https://cedcommerce.com/license-agreement.txt
 */ 
namespace Ced\StorePickup\Helper;
 
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{    
    protected $_allowedFeedType = array();
    protected $_objectManager;
    protected $_storeManager;
    protected $_scopeConfigManager;
    protected $_configValueManager;
    protected $_transaction;
    protected $_context;
    protected $_cacheTypeList;
    protected $_cacheFrontendPool;
    protected $request;
    protected $_productMetadata;
    protected $_storeId = 0;
    protected $_storesFactory;
    
    public function __construct(\Magento\Framework\App\Helper\Context $context,
        \Ced\StorePickup\Model\StoreInfoFactory $_storesFactory,
        \Ced\StorePickup\Model\StoreHour $storehour,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata
    ) {

        $this->_objectManager = $objectManager;
        $this->_storehour = $storehour;
        $this->_storesFactory = $_storesFactory;
        $this->_context = $context;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->_request = $request;
        $this->_productMetadata = $productMetadata;
        parent::__construct($context);
        $this->_storeManager = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface');
        $this->_scopeConfigManager = $this->_objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface');
        $this->_configValueManager = $this->_objectManager->get('Magento\Framework\App\Config\ValueInterface');
        $this->_transaction = $this->_objectManager->get('Magento\Framework\DB\Transaction');
    }
    
    /**
     * Set a specified store ID value
     *
     * @param  int $store
     * @return $this
     */
    public function setStoreId($store)
    {
        $this->_storeId = $store;
        return $this;
    }
    
    /**
     * Get current store
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        $storeId = (int) $this->_objectManager->get('Magento\Framework\App\RequestInterface')->getParam('store', 0);
        if($storeId) {
            return $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore($storeId);
        }
        else {
            return $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore(null);
        }
    }
    
    public function getCustomCSS()
    {
        return $this->_scopeConfigManager->getValue('ced_csmarketplace/vendor/theme_css', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $this->getStore()->getId());
    }
    
    /**
     * Check if current url is url for home page
     *
     * @return true
     */
    public function getIsDashboard()
    {
        return $this->getVendorUrl() == $this->_getUrl('*/*/*')
        ||
        $this->getVendorUrl().'/index' == $this->_getUrl('*/*/*')
        ||
        $this->getVendorUrl().'/index/' == $this->_getUrl('*/*/*')
        ||
        $this->getVendorUrl().'index' == $this->_getUrl('*/*/*')
        ||
        $this->getVendorUrl().'index/' == $this->_getUrl('*/*/*');
    }

    public function setLogo($logo_src, $logo_alt)
    {
        $this->setLogoSrc($logo_src);
        $this->setLogoAlt($logo_alt);
        return $this;
    }
    
    public function getMarketplaceVersion()
    {
        return trim((string)$this->getReleaseVersion('Ced_CsMarketplace'));
    }
    
    public function getReleaseVersion($module)
    {
        $modulePath = $this->moduleRegistry->getPath(self::XML_PATH_INSTALLATED_MODULES, $module);
        $filePath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, "$modulePath/etc/module.xml");
        $source = new \Magento\Framework\Simplexml\Config($filePath);
        if($source->getNode(self::XML_PATH_INSTALLATED_MODULES)->attributes()->release_version) {
            return $source->getNode(self::XML_PATH_INSTALLATED_MODULES)->attributes()->release_version->__toString(); 
        }
        return false; 
    }
   
    
    /**
     * Url encode the parameters
     *
     * @param  string | array
     * @return string | array | boolean
     */
    public function prepareParams($data)
    {
        if(!is_array($data) && strlen($data)) {
            return urlencode($data);
        }
        if($data && is_array($data) && count($data)>0) {
            foreach($data as $key=>$value){
                $data[$key] = urlencode($value);
            }
            return $data;
        }
        return false;
    }
    
    /**
     * Url decode the parameters
     *
     * @param  string | array
     * @return string | array | boolean
     */
    public function extractParams($data)
    {
        if(!is_array($data) && strlen($data)) {
            return urldecode($data);
        }
        if($data && is_array($data) && count($data)>0) {
            foreach($data as $key=>$value){
                $data[$key] = urldecode($value);
            }
            return $data;
        }
        return false;
    }
    
    /**
     * Add params into url string
     *
     * @param  string  $url       (default '')
     * @param  array   $params    (default array())
     * @param  boolean $urlencode (default true)
     * @return string | array
     */
    public function addParams($url = '', $params = array(), $urlencode = true) 
    {
        if(count($params)>0) {
            foreach($params as $key=>$value){
                if(parse_url($url, PHP_URL_QUERY)) {
                    if($urlencode) {
                        $url .= '&'.$key.'='.$this->prepareParams($value); 
                    }
                    else {
                        $url .= '&'.$key.'='.$value; 
                    }
                } else {
                    if($urlencode) {
                        $url .= '?'.$key.'='.$this->prepareParams($value); 
                    }
                    else {
                        $url .= '?'.$key.'='.$value; 
                    }
                }
            }
        }
        return $url;
    }
    
    /**
     * Retrieve all the extensions name and version developed by CedCommerce
     *
     * @param  boolean $asString (default false)
     * @return array|string
     */
    public function getCedCommerceExtensions($asString = false) 
    {
        if($asString) {
            $cedCommerceModules = '';
        } else {
            $cedCommerceModules = array();
        }
        $allModules = $this->_context->getScopeConfig()->getValue(\Ced\StorePickup\Model\Feed::XML_PATH_INSTALLATED_MODULES);
        $allModules = json_decode(json_encode($allModules), true);
        foreach($allModules as $name=>$module) {
            $name = trim($name);
            if(preg_match('/ced_/i', $name) && isset($module['release_version'])) {
                if($asString) {
                    $cedCommerceModules .= $name.':'.trim($module['release_version']).'~';
                } else {
                    $cedCommerceModules[$name] = trim($module['release_version']);
                }
            }
        }
        if($asString) { trim($cedCommerceModules, '~'); 
        }
        return $cedCommerceModules;
    }
    
    /**
     * Retrieve environment information of magento
     * And installed extensions provided by CedCommerce
     *
     * @return array
     */
    public function getEnvironmentInformation() 
    {
        $info = array();
        $info['domain_name'] = $this->_productMetadata->getBaseUrl();
        $info['magento_edition'] = 'default';
        if(method_exists('Mage', 'getEdition')) { $info['magento_edition'] = $this->_productMetadata->getEdition(); 
        }
        $info['magento_version'] = $this->_productMetadata->getVersion();
        $info['php_version'] = phpversion();
        $info['feed_types'] = $this->getStoreConfig(\Ced\StorePickup\Model\Feed::XML_FEED_TYPES);
        $info['installed_extensions_by_cedcommerce'] = $this->getCedCommerceExtensions(true);
        
        return $info;
    } 
    
    /**
     * Function for setting Config value of current store
     *
     * @param string $path,
     * @param string $value,
     */
    public function setStoreConfig($path, $value, $storeId=null)
    {
        $store=$this->_storeManager->getStore($storeId);
        $data = [
                    'path' => $path,
                    'scope' =>  'stores',
                    'scope_id' => $storeId,
                    'scope_code' => $store->getCode(),
                    'value' => $value,
                ];
        $this->_configValueManager->addData($data);
        $this->_transaction->addObject($this->_configValueManager);
        $this->_transaction->save();
    }
    
    /**
     * Function for getting Config value of current store
     *
     * @param string $path,
     */
    public function getStoreConfig($path,$storeId=null)
    {
        $store=$this->_storeManager->getStore($storeId);
        return $this->_scopeConfigManager->getValue($path, 'store', $store->getCode());
    }

    public function getStoreDetail($pickupId)
    {
        return $this->_storesFactory->create()->load($pickupId);
    }

    public function getStoreTimings($storeId, $day){
        $storehours = $this->_storehour->getCollection()->addFieldToFilter('pickup_id', $storeId)->addFieldToFilter('days', $day)->getData();
        $storetiming = array();
        if(isset($storehours)){
            foreach($storehours as $storetmng){
                $storetiming['start'] = $storetmng['start'];
                $storetiming['end'] = $storetmng['end'];
                $storetiming['status'] = $storetmng['status'];
            }
        }
        return $storetiming;
    }
}
