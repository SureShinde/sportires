<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Claro
 * @author        CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license      http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Helper;

/**
 * Directory separator shorthand
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const PRODUCT_ACTION_TYPE = 'claro_product_action_type';
    const PRODUCT_ACTION_KEY = 'claro_product_action_key';
    const ACTION_PRODUCT_UPLOAD = 'claro_product_upload';
    const ACTION_PRODUCT_UPDATE = 'claro_product_update';
    const ACTION_PRODUCT_UPDATE_DESCRIPTION = 'claro_product_update_description';
    const ACTION_PRODUCT_DELETE = 'claro_product_delete';
    const ACTION_PRODUCT_PAUSE = 'claro_product_pause';
    const ACTION_PRODUCT_REACTIVATE = 'claro_product_reactivate';

    const CONFIG_PATH_PRODUCT_CHUNK_UPLOAD_SIZE = 'claro/Product/chunk_settings/product_upload';
    const CONFIG_PATH_PRODUCT_CHUNK_UPDATE_DESCRIPTION_SIZE =
        'claro/Product/chunk_settings/product_description_update';
    const CONFIG_PATH_PRODUCT_CHUNK_DELETE_SIZE = 'claro/Product/chunk_settings/product_delete';

    const CONFIG_PATH_STORE_ID = "claro/settings/store_id";
    const CONFIG_PATH_ENABLED = "claro/settings/enable";
    const CONFIG_PATH_CONFIG_VALID = "claro/settings/valid";

    const CONFIG_PATH_DEBUG = "claro/developer/debug";
    const CONFIG_PATH_LOGGING_LEVEL = "claro/developer/logging_level";

    const CONFIG_PATH_INVENTORY_SYNC = "claro/cron/inventory_cron";
    const CONFIG_PATH_PRICE_SYNC = "claro/cron/price_cron";

    const CONFIG_PATH_PRICE_TYPE = "claro/Product/price_settings/price";
    const CONFIG_PATH_PRICE_TYPE_FIXED = "claro/Product/price_settings/fix_price";
    const CONFIG_PATH_PRICE_TYPE_PERCENTAGE = "claro/Product/price_settings/percentage_price";
    const CONFIG_PATH_PRICE_TYPE_ATTRIBUTE = "claro/Product/price_settings/different_price";

    const CONFIG_PATH_INVENTORY_ZERO_CONDITION = "claro/Product/inventory_settings/zero_inventory_condition";

    const CONFIG_PATH_ORDER_ID_PREFIX = "claro/order/order_id_prefix";
    const CONFIG_PATH_NOTIFICATION_EMAIL = "claro/order/order_notify_email";
    const CONFIG_PATH_ENABLE_DEFAULT_CUSTOMER = "claro/order/enable_default_customer";
    const CONFIG_PATH_DEFAULT_CUSTOMER = "claro/order/default_customer";
    const CONFIG_PATH_AUTO_ACKNOWLEDGEMENT = "claro/order/auto_acknowledgement";
    const CONFIG_PATH_AUTO_CANCELLATION = "claro/order/auto_cancellation";
    const CONFIG_PATH_AUTO_INVOICE = "claro/order/auto_invoice";

    const CONFIG_PATH_APP_ID = "claro/settings/app_id";
    const CONFIG_PATH_PUBLIC_KEY = "claro/settings/public_key";
    const CONFIG_PATH_PRIVATE_KEY = "claro/settings/private_key";
    const CONFIG_PATH_ENDPOINT_URI = "claro/settings/endpoint_uri";
    const CONFIG_PATH_SECRET_KEY = "claro/settings/secret_key";
    const CONFIG_PATH_SITE_ID = "claro/settings/site";
    const CONFIG_PATH_ATTRIBUTES = "claro/product/attributes";

    const CONFIG_PATH_CURRENCY_ID = "claro/settings/currency";

    const FLAG_KEY_SELLER_ID = "claro_seller_id";
    const FLAG_KEY_SELLER_ADDRESS = "claro_seller_address";
    const FLAG_KEY_SELLER_EMAIL = "claro_seller_email";
    const FLAG_KEY_SELLER_COUNTRY_ID = "claro_seller_country_id";
    const FLAG_KEY_SELLER_NAME = "claro_seller_name";
    const FLAG_KEY_SELLER_PHONE = "claro_seller_phone";

    const FLAG_KEY_ACCESS_TOKEN = "claro_access_token";
    const FLAG_KEY_REFRESH_TOKEN = "claro_refresh_token";
    const FLAG_KEY_EXPIRY = "claro_token_expiry";
    const FLAG_KEY_CONFIG_VALID = "claro_config_status";

    const TYPE_DEFAULT = 'default';
    const TYPE_FIXED_INCREASE = 'plus_fixed';
    const TYPE_FIXED_DECREASE = 'min_fixed';
    const TYPE_PERCENTAGE_INCREASE = 'plus_per';
    const TYPE_PERCENTAGE_DECREASE = 'min_per';
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfigManager;

    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    public $dl;

    /**
     * @var $appId
     */
    public $appId;

    /**
     * @var $secretKey
     */
    public $secretKey;

    /**
     * Debug Log Mode
     * @var boolean
     */
    public $debugMode = true;

    /** @var \Magento\Framework\FlagFactory  */
    public $flagFactory;

    /** @var \Magento\Framework\Flag\FlagResource  */
    public $flagResource;

    public $accessToken = null;

    public $refreshToken = null;

    public $expiry = null;

    public $sellerName = null;
    public $sellerId = null;
    public $sellerAddress = null;
    public $sellerPhone = null;
    public $sellerCountryId = null;

    /**
     * Config constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Flag\FlagResource $flagResource
     * @param \Magento\Framework\FlagFactory $flagFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Flag\FlagResource $flagResource,
        \Magento\Framework\FlagFactory $flagFactory
    ) {
        parent::__construct($context);
        $this->scopeConfigManager = $context->getScopeConfig();
        $this->flagFactory = $flagFactory;
        $this->flagResource = $flagResource;
    }

    public function setSellerEmail($email)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_EMAIL]]);
        $flag->loadSelf();
        $flag->setFlagData($email);
        $this->flagResource->save($flag);
        $this->sellerEmail = $email;
    }

    public function getSellerEmail()
    {
        if (empty($this->sellerEmail)) {
            $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_EMAIL]]);
            $this->flagResource->load($flag, self::FLAG_KEY_SELLER_EMAIL, 'flag_code');
            $this->sellerEmail = $flag->getFlagData();
        }
        return $this->sellerEmail;
    }

    public function setSellerName($name)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_NAME]]);
        $flag->loadSelf();
        $flag->setFlagData($name);
        $this->flagResource->save($flag);
        $this->sellerName = $name;
    }

    public function getSellerName()
    {
        if (empty($this->sellerName)) {
            $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_NAME]]);
            $this->flagResource->load($flag, self::FLAG_KEY_SELLER_NAME, 'flag_code');
            $this->sellerName = $flag->getFlagData();
        }
        return $this->sellerName;
    }

    public function setSellerId($id)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_ID]]);
        $flag->loadSelf();
        $flag->setFlagData($id);
        $this->flagResource->save($flag);
        $this->sellerId = $id;
    }

    public function getSellerId()
    {
        if (empty($this->sellerId)) {
            $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_ID]]);
            $this->flagResource->load($flag, self::FLAG_KEY_SELLER_ID, 'flag_code');
            $this->sellerId = $flag->getFlagData();
        }
        return $this->sellerId;
    }

    public function setSellerCountryId($id)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_COUNTRY_ID]]);
        $flag->loadSelf();
        $flag->setFlagData($id);
        $this->flagResource->save($flag);
        $this->sellerCountryId = $id;
    }

    public function getSellerCountryId()
    {
        if (empty($this->sellerCountryId)) {
            $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_COUNTRY_ID]]);
            $this->flagResource->load($flag, self::FLAG_KEY_SELLER_COUNTRY_ID, 'flag_code');
            $this->sellerCountryId = $flag->getFlagData();
        }
        return $this->sellerCountryId;
    }

    public function setSellerPhone($phone)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_PHONE]]);
        $flag->loadSelf();
        $flag->setFlagData($phone);
        $this->flagResource->save($flag);
        $this->sellerPhone = $phone;
    }

    public function getSellerPhone()
    {
        if (empty($this->sellerPhone)) {
            $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_PHONE]]);
            $this->flagResource->load($flag, self::FLAG_KEY_SELLER_PHONE, 'flag_code');
            $this->sellerPhone = $flag->getFlagData();
        }
        return $this->sellerPhone;
    }

    public function setSellerAddress($address)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_ADDRESS]]);
        $flag->loadSelf();
        $flag->setFlagData($address);
        $this->flagResource->save($flag);
        $this->sellerAddress = $address;
    }

    public function getSellerAddress()
    {
        if (empty($this->sellerAddress)) {
            $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_SELLER_ADDRESS]]);
            $this->flagResource->load($flag, self::FLAG_KEY_SELLER_ADDRESS, 'flag_code');
            $this->sellerAddress = $flag->getFlagData();
        }
        return $this->sellerAddress;
    }

    public function getAccessToken()
    {
        if (empty($this->accessToken)) {
            $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_ACCESS_TOKEN]]);
            $this->flagResource->load($flag, self::FLAG_KEY_ACCESS_TOKEN, 'flag_code');
            $this->accessToken = $flag->getFlagData();
        }
        return $this->accessToken;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken()
    {
        if (empty($this->refreshToken)) {
            $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_REFRESH_TOKEN]]);
            $this->flagResource->load($flag, self::FLAG_KEY_REFRESH_TOKEN, 'flag_code');
            $this->refreshToken = $flag->getFlagData();
        }
        return $this->refreshToken;
    }

    public function getTokenExpiry()
    {
        if (empty($this->expiry)) {
            $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_EXPIRY]]);
            $this->flagResource->load($flag, self::FLAG_KEY_EXPIRY, 'flag_code');
            $this->expiry = $flag->getFlagData();
        }
        return $this->expiry;
    }

    /**
     * Set Access Token
     * @param string $token
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function setAccessToken($token)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_ACCESS_TOKEN]]);
        $flag->loadSelf();
        $flag->setFlagData($token);
        $this->flagResource->save($flag);
        $this->accessToken = $token;
    }

    /**
     * Set Refresh Token
     * @param string $token
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function setRefreshToken($token)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_REFRESH_TOKEN]]);
        $flag->loadSelf();
        $flag->setFlagData($token);
        $this->flagResource->save($flag);
        $this->refreshToken = $token;
    }

    /**
     * Set Expiry Time
     * @param string $expiry
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function setTokenExpiry($expiry)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_EXPIRY]]);
        $flag->loadSelf();
        $flag->setFlagData($expiry);
        $this->flagResource->save($flag);
        $this->expiry = $expiry;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        /*$flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_CONFIG_VALID]]);
        $this->flagResource->load($flag, self::FLAG_KEY_CONFIG_VALID, 'flag_code');
        $valid = $flag->getFlagData();
        return $valid;*/
        return true;
    }

    public function setValid($status)
    {
        /** @var \Magento\Framework\Flag $flag */
        $flag = $this->flagFactory->create(['data' => ['flag_code' => self::FLAG_KEY_CONFIG_VALID]]);
        $flag->loadSelf();
        $flag->setFlagData($status);
        $this->flagResource->save($flag);
    }

    /**
     * Get Mock mode for config
     * @return bool
     */
    public function isEnabled()
    {
        $enable = $this->scopeConfigManager->getValue(self::CONFIG_PATH_ENABLED);
        if ($enable === null) {
            $enable = false;
        }
        return $enable;
    }

    public function getOrderIdPrefix()
    {
        $prefix = $this->scopeConfigManager->getValue(self::CONFIG_PATH_ORDER_ID_PREFIX);
        if (isset($prefix) && !empty($prefix)) {
            return $prefix . '-';
        }

        return '';
    }

    public function getDefaultStoreId()
    {
        $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;

        return $storeId;
    }

    public function getStoreId()
    {
        $storeId = $this->scopeConfig->getValue(self::CONFIG_PATH_STORE_ID);
        if (!isset($storeId) || empty($storeId)) {
            $storeId = $this->getDefaultStoreId();
        }

        return $storeId;
    }

    public function getStore()
    {
        return $this->getStoreId();
    }

    public function getNotificationEmail()
    {
        $email = $this->scopeConfig->getValue(self::CONFIG_PATH_NOTIFICATION_EMAIL);
        return $email;
    }

    public function getLoggingLevel()
    {
        $level = $this->scopeConfig->getValue(self::CONFIG_PATH_LOGGING_LEVEL);
        return $level;
    }

    public function getAppId()
    {
        $appId = $this->scopeConfig->getValue(self::CONFIG_PATH_APP_ID);
        return $appId;
    }

    public function getSiteId()
    {
        $siteId = $this->scopeConfig->getValue(self::CONFIG_PATH_SITE_ID);
        return $siteId;
    }

    public function getSecretKey()
    {
        $key = $this->scopeConfig->getValue(self::CONFIG_PATH_SECRET_KEY);
        return $key;
    }
    public function getPublicKey()
    {
        $key = $this->scopeConfig->getValue(self::CONFIG_PATH_PUBLIC_KEY);
        return $key;
    }
    public function getPrivateKey()
    {
        $key = $this->scopeConfig->getValue(self::CONFIG_PATH_PRIVATE_KEY);
        return $key;
    }
    public function getEndPointUri()
    {
        $key = $this->scopeConfig->getValue(self::CONFIG_PATH_ENDPOINT_URI);
        return $key;
    }
    public function getAttributesFromConfig()
    {
        $key = $this->scopeConfigManager->getValue(self::CONFIG_PATH_ATTRIBUTES);
        return $key;
    }

    public function getDebug()
    {
        $this->debugMode = $this->scopeConfigManager
            ->getValue(self::CONFIG_PATH_DEBUG);
        if (!isset($this->debugMode)) {
            $this->debugMode = true;
        }

        return $this->debugMode ;
    }

    public function getPriceSync()
    {
        $sync = $this->scopeConfigManager->getValue(self::CONFIG_PATH_PRICE_SYNC);
        return $sync;
    }

    public function getInventorySync()
    {
        $sync = $this->scopeConfigManager->getValue(self::CONFIG_PATH_INVENTORY_SYNC);
        return $sync;
    }

    public function getPriceType()
    {
        $type = trim((string)$this->scopeConfigManager->getValue(self::CONFIG_PATH_PRICE_TYPE));
        return $type;
    }

    public function getPriceFixed()
    {
        $fixed = trim((string)$this->scopeConfigManager->getValue(self::CONFIG_PATH_PRICE_TYPE_FIXED));
        return $fixed;
    }

    public function getPricePercentage()
    {
        $percentage = trim((string)$this->scopeConfigManager->getValue(self::CONFIG_PATH_PRICE_TYPE_PERCENTAGE));
        return $percentage;
    }

    public function getPriceAttribute()
    {
        //@Suggest: can be obtained from profile
        $attribute = trim((string)$this->scopeConfigManager->getValue(self::CONFIG_PATH_PRICE_TYPE_ATTRIBUTE));
        return $attribute;
    }

    public function getRedirectUri()
    {
        return $this->_getUrl('claro/install', ['_nosid' => true, '_forced_secure' => true]);
    }

    /**
     * Get Chunk Size, default 25
     * @param string $type
     * @return int
     */
    public function getChunkSize($type = self::ACTION_PRODUCT_UPLOAD)
    {
        switch ($type) {
            case self::ACTION_PRODUCT_UPLOAD:
            case self::ACTION_PRODUCT_UPDATE:
                $chunkSize = $this->scopeConfigManager
                    ->getValue(self::CONFIG_PATH_PRODUCT_CHUNK_UPLOAD_SIZE);
                break;
            case self::ACTION_PRODUCT_UPDATE_DESCRIPTION:
                $chunkSize = $this->scopeConfigManager
                    ->getValue(self::CONFIG_PATH_PRODUCT_CHUNK_UPDATE_DESCRIPTION_SIZE);
                break;
            case self::ACTION_PRODUCT_DELETE:
            case self::ACTION_PRODUCT_PAUSE:
            case self::ACTION_PRODUCT_REACTIVATE:
                $chunkSize = $this->scopeConfigManager
                    ->getValue(self::CONFIG_PATH_PRODUCT_CHUNK_DELETE_SIZE);
                break;
            default:
                $chunkSize = 30;
        }

        if (!isset($chunkSize) || empty($chunkSize)) {
            $chunkSize = 30;
        }

        return $chunkSize;
    }

    public function getCurrency()
    {
        $currency = $this->scopeConfigManager->getValue(self::CONFIG_PATH_CURRENCY_ID);
        return $currency;
    }

    public function getZeroInventory()
    {
        $condition = $this->scopeConfigManager->getValue(self::CONFIG_PATH_INVENTORY_ZERO_CONDITION);
        if (empty($condition)) {
            $condition = \Ced\Claro\Model\Source\Config\Inventory\ZeroCondition::SKIP;
        }
        return $condition;
    }

    /**
     * Get default customer id
     * @return bool|string
     */
    public function getDefaultCustomer()
    {
        $customer = false;
        $enabled = $this->scopeConfigManager->getValue(self::CONFIG_PATH_ENABLE_DEFAULT_CUSTOMER);
        if ($enabled == 1) {
            $customer = $this->scopeConfigManager->getValue(self::CONFIG_PATH_DEFAULT_CUSTOMER);
        }
        return $customer;
    }

    /**
     * Get auto invoice enable
     * @return bool|mixed
     */
    public function getAutoInvoice()
    {
        $autoInvoice = $this->scopeConfigManager->getValue(self::CONFIG_PATH_AUTO_INVOICE);
        if (isset($autoInvoice) && empty($autoInvoice)) {
            $autoInvoice = false;
        }
        return $autoInvoice;
    }

    public function getAutoCancellation()
    {
        $autoReject = $this->scopeConfigManager
            ->getValue(self::CONFIG_PATH_AUTO_CANCELLATION);
        if (isset($autoReject) && empty($autoReject)) {
            $autoReject = false;
        }
        return $autoReject;
    }

    public function getAutoAcknowledgement()
    {
        $ack = $this->scopeConfigManager->getValue(self::CONFIG_PATH_AUTO_ACKNOWLEDGEMENT);
        if (isset($ack) && empty($ack)) {
            $ack = false;
        }
        return $ack;
    }
    public function createRegion()
    {
        return true;
    }
    public function useGeocode()
    {
        return false;
    }
    public function useDash()
    {
        return false;
    }
}
