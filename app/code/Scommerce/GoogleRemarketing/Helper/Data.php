<?php
/**
 * Google Remarketing Data Helper
 *
 * Copyright © 2016 Scommerce Mage. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Scommerce\GoogleRemarketing\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	/**#@+
     * Facebook Conversion config data
     */

    const XML_PATH_ACTIVE   			= 'googleremarketing/general/active';
    const XML_PATH_LICENSE_KEY 			= 'googleremarketing/general/license_key';
    const XML_PATH_ENABLE_DYNAMIC 		= 'googleremarketing/general/enable_dynamic';
	const XML_PATH_ENABLE_OTHER_SITES 	= 'googleremarketing/general/enable_other_sites';
    const XML_PATH_CONVERSION_ID 		= 'googleremarketing/general/conversion_id';
    const XML_PATH_ATTRIBUTE_KEY 		= 'googleremarketing/general/attribute_key';

    /**#@-*/

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;
	protected $_data;
	protected $_source;
    protected $_storeManager;
    protected $_coreSession;
    protected $_objectManager;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Registry $registry
	 * @param \Scommerce\Core\Helper\Data $data
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Session\Generic $coreSession
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Registry $registry,
		\Scommerce\Core\Helper\Data $data,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Session\Generic $coreSession,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        parent::__construct($context);
        $this->_registry = $registry;
		$this->_data = $data;
        $this->_storeManager = $storeManager;
        $this->_coreSession = $coreSession;
        $this->_objectManager = $objectManager;
    }

    /**
     * returns whether module is enabled or not
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ACTIVE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ) && $this->isLicenseValid();
    }

    /**
     * checks to see if the extension is enabled for advanced tagging in admin
     *
     * @return boolean
     */
    public function getDynamicRemarketingEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLE_DYNAMIC,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
	
	/**
     * checks to see if the other site variable is enabled or not
     *
     * @return boolean
     */
    public function isOtherSiteEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLE_OTHER_SITES,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * returns the store config value for javascript tag google_conversion_id
     *
     * @return string
     */
    public function getGoogleConversionId()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CONVERSION_ID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * returns product attribute key
     *
     * @return string
     */
    public function getProductAtributeKey()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ATTRIBUTE_KEY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * returns license key administration configuration option
     *
     * @return string
     */
    public function getLicenseKey(){
        return $this->scopeConfig->getValue(
            self::XML_PATH_LICENSE_KEY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
	
	/**
     * returns whether license key is valid or not
     *
     * @return bool
     */
    public function isLicenseValid(){
		$sku = strtolower(str_replace('\\Helper\\Data','',str_replace('Scommerce\\','',get_class($this))));
		return $this->_data->isLicenseValid($this->getLicenseKey(),$sku);
	}
}