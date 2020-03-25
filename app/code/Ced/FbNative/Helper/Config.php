<?php
/**
 * Created by PhpStorm.
 * User: cedcoss
 * Date: 9/12/18
 * Time: 5:37 PM
 */

namespace Ced\FbNative\Helper;

use Magento\Framework\App\Helper\Context;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const ATTRIBUTE_MAPPING = 'fbnativeconfiguration/productinfo_map/fbnative_mapping';
    const STORE_ID = 'fbnativeconfiguration/fbnativesetting/fbnative_storeid';

    public $scopeConfigManager;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig ,
        Context $context
    ) {
        $this->scopeConfigManager = $scopeConfig;
        parent::__construct($context);
    }

    public function getAttributeMapping()
    {
        $attributeMapping = $this->scopeConfig->getValue(self::ATTRIBUTE_MAPPING);
        return $attributeMapping;
    }

    /*public function getStore()
    {
        $storeId = $this->scopeConfig->getValue(self::STORE_ID);
        return $storeId;
    }*/
}