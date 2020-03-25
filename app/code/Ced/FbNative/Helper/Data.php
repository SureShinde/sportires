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
 * @package     Ced_Fyndiq
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\FbNative\Helper;


use Ced\FbNative\Model\Account;
use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\App\ObjectManager;
use Ced\FbNative\Model\Feeds;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use \Magento\Framework\Message\Manager;
use Magento\Store\Model\StoreManager;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /** @var \Magento\Catalog\Model\Indexer\Product\Price\Processor $_productPriceIndexerProcessor */
    public $_productPriceIndexerProcessor;

    /** @var Filter $filter */
    public $filter;

    /** @var CollectionFactory */
    public $collectionFactory;

    /** @var \Magento\Framework\Filesystem\DirectoryList $directoryList */
    public $directoryList;

    /** @var \Magento\Framework\Filesystem\Io\File $fileIo */
    public $fileIo;
    /** @var Config */
    public $configHelper;

    public $storeManager;

    public $resultRedirectFactory;

    public $messageManager;

    public $objectManager;

    public $account;

    public $multiAccount;

    public $_assetRepo;

    /** @var \Ced\FbNative\Model\Feeds Feeds */
    public $feed;

    /**
     * Data constructor.
     * @param \Magento\Framework\Filesystem\DirectoryList $directoryList
     * @param \Magento\Framework\Filesystem\Io\File $fileIo
     * @param Context $context
     * @param Product\Builder $productBuilder
     * @param \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor
     * @param Filter $filter
     * @param Config $configHelper
     * @param StoreManager $storeManager
     * @param CollectionFactory $collectionFactory
     * @param RedirectFactory $resultRedirectFactory
     * @param ObjectManager $objectManager
     * @param Manager $manager
     */
    public function __construct(
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Io\File $fileIo,
        Context $context,
        Product\Builder $productBuilder,
        \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor,
        Filter $filter,
        Config $configHelper,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        StoreManager $storeManager,
        CollectionFactory $collectionFactory,
        RedirectFactory $resultRedirectFactory,
        Manager $manager,
        Account $account,
        Feeds $feed,
        \Ced\FbNative\Helper\MultiAccount $multiAccount,
        \Magento\Framework\View\Asset\Repository $assetRepo
    )
    {
        parent::__construct($context);
        $this->fileIo = $fileIo;
        $this->directoryList = $directoryList;
        $this->filter = $filter;
        $this->configHelper = $configHelper;
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->_productPriceIndexerProcessor = $productPriceIndexerProcessor;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->objectManager = $objectManager;
        $this->messageManager = $manager;
        $this->account = $account;
        $this->multiAccount = $multiAccount;
        $this->_assetRepo = $assetRepo;
        $this->feed = $feed;
    }

    public function productCron()
    {
        $condition = array('new', 'refurbished', 'used', 'cpo');
        try {
            $AccountCollection = $this->account->getCollection();
            $accounts = $AccountCollection->addFilter('account_status', 1)->getColumnValues('id');
            $data = array();
            $mappedAttr = $this->readCsv();
            if ($mappedAttr) {
                foreach ($mappedAttr as $key => $value) {
                    $data[] = $key;
                }
                array_push($data, 'id');
                array_push($data, 'offer_id');
                array_push($data, 'channel');
                array_push($data, 'image_link');
                array_push($data, 'availability');
                array_push($data, 'Inventory');
                array_push($data, 'product_type');

                if (!in_array('price', $data)) {
                    array_push($data, 'price');
                }
                if (!in_array('sale_price', $data)) {
                    array_push($data, 'sale_price');
                }
                /*array_push($data, 'price');*/
                /*array_push($data, 'sale_price');*/

                if (!in_array('brand', $data)) {
                    array_push($data, 'brand');
                }

                array_push($data, 'description');
                array_push($data, 'link');
                array_push($data, 'item_group_id');
                array_push($data, 'additional_image_link');

                if (!in_array('condition', $data)) {
                    array_push($data, 'condition');
                }
                sort($data);

                foreach ($accounts as $account) {
                    $addedProduct = [];
                    $attrCode = $this->multiAccount->getStoreAttrForAcc($account);
                    $accountData = $this->account->load($account)->getData();
                    $productCollection = $this->collectionFactory->create()
                        ->addStoreFilter($accountData['account_store'])
                        ->addAttributeToSelect($attrCode, ['in' => $account])
                        ->addAttributeToFilter('status', ['eq' => 1]);

                    if (isset($accountData)) {
                        /** @var \Magento\Store\Api\Data\StoreInterface $store */
                        $store = $this->storeManager->getStore(/*$accountData['account_store']*/);
                        $url = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product';
                        $currencyCode = $this->storeManager->getStore($accountData['account_store'])->getDefaultCurrencyCode();
                        $fileName = strtolower($accountData['page_name']) . '.csv';
                        $dirPath = BP . '/pub/media/ced_fbnative';
                        $filePath = $dirPath . '/' . $fileName;
                        if (!file_exists($dirPath)) {
                            mkdir($dirPath, 0777, true);
                        }

                        $fp = fopen($filePath, "w+");
                        fputcsv($fp, $data, chr(9));
                        foreach ($productCollection as $product) {
                            $product = $this->objectManager->create('Magento\Catalog\Model\Product')
                                ->setStoreId($accountData['account_store'])->load($product->getId());
                            $mappedAttr = $this->readCsv();
                            $default = [];
                            $uIntersect = [];
//                            if ($attr == 1) {
                            $mappedData = array();
                            foreach ($mappedAttr as $fbAttr => $magentoAttr) {
                                $attrValue = $this->getMappedAttributeValue($magentoAttr, $product);
                                if ($magentoAttr == 'image' && $attrValue != '') {
                                    $attrValue = $url . $attrValue;
                                }

                                if ($fbAttr == 'google_product_category' && empty($attrValue)) {
                                    $attrValue = '632';
                                }

                                if (is_array($attrValue)) {
                                    foreach ($attrValue as $key => $value) {
                                        $mappedData[$fbAttr] = $attrValue[$key];
                                        if ($fbAttr == 'sale_price' && $magentoAttr == 'tier_price') {
                                            $mappedData[$fbAttr] = $attrValue[$key]['price'];
                                        }
                                    }
                                } else {
                                    $mappedData[$fbAttr] = $attrValue;
                                }

                                if ($fbAttr == 'price' || $fbAttr == 'sale_price') {
                                    if (!empty($mappedData[$fbAttr])) {
                                        $mappedData[$fbAttr] = $currencyCode . ' ' . $mappedData[$fbAttr];
                                    } else {
                                        $mappedData[$fbAttr] = $currencyCode . ' ' . 0.00;
                                    }
                                }

                                if ($fbAttr == 'title') {
                                    $attrValueLen = strlen($attrValue);
                                    if ($attrValueLen >= 150) {
                                        $mappedData[$fbAttr] = strtolower(substr($attrValue, 0, 149));
                                    } else {
                                        $mappedData[$fbAttr] = strtolower($attrValue);
                                    }

                                }
                            }
                            $default = $this->defaultMappingAttribute($product, $accountData['account_store']);
                            $mappedData = array_merge($default, $mappedData);

                            if (array_key_exists('condition', $mappedData) && !in_array($mappedData['condition'], $condition)) {
                                $mappedData['condition'] = 'new';
                            } else {
                                $mappedData['condition'] = 'new';
                            }
                            $uIntersect = array_diff_key(array_flip($data), array_flip(array_keys($mappedData)));
                            $mappedData = array_merge($mappedData, array_fill_keys(array_keys($uIntersect), null));
                            ksort($mappedData);
                            fputcsv($fp, $mappedData, chr(9));
                            array_push($addedProduct, $product->getSku());
//                            }
                        }
                        $feedArray = [
                            'account' => $accountData['id'],
                            'product_ids' => implode(',', $addedProduct),
                            'source' => 'Automatic',
                            'uploaded_time' => date("Y-m-d h:i:sa", strtotime("now"))
                        ];

                        $this->feed->addData($feedArray)->save();
                        $this->messageManager->addSuccessMessage(__('Csv Exported for: ' . $accountData['page_name'] . ' store successfully'));
                        fclose($fp);
                    }
                }
            }
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('We found ' . $exception->getMessage() . ' Error while creating feed'));
            $dirPath = BP . '/pub/media/ced_fbnative';
            $filePath = $dirPath . '/fb_log.log';
            $log = fopen($filePath, "w+");
            fwrite($log, $exception->getMessage());
        }
    }

    /**
     * @return array|bool
     */
    public function readCsv()
    {
        $mapped = $this->configHelper->getAttributeMapping();
        $mapped = json_decode($mapped, true);
        $mappedAttr = [];
        if ($mapped) {
            foreach ($mapped as $key => $value) {
                if (!$mapped[$key] == null) {
                    foreach ($value as $attr => $item) {
                        if ($attr == 'facebook_attribute_code') {
                            $fbAttr = $item;
                        } else if ($attr == 'magento_attribute_code') {
                            $magentoAttr = $item;
                        }
                    }
                    $mappedAttr[$fbAttr] = $magentoAttr;
                }
            }
            return $mappedAttr;
        }
        return false;

    }

    /**
     * @param $magentoAttribute
     * @param $product
     * @return mixed
     */
    public function getMappedAttributeValue($magentoAttribute, $product)
    {
        $attribute = isset($magentoAttribute) ? $magentoAttribute : '';
        $value = $product->getData($attribute);
        if (!$value) {
            $parentIds = $this->objectManager->get('Magento\ConfigurableProduct\Model\Product\Type\Configurable')
                ->getParentIdsByChild($product->getId());
            $parentId = array_shift($parentIds);
            if ($parentId) {
                $configProduct = $this->objectManager->get('Magento\Catalog\Model\Product')->load($parentId);
                $value = $configProduct->getData($attribute);
            }

        }
        return $value;
    }

    /**
     * @param $product
     * @param $storeId
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function defaultMappingAttribute($product, $storeId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $baseUrl = $this->storeManager->getStore($storeId)->getBaseUrl();
        $url = $baseUrl . 'pub/media/catalog/product';
        $currencyCode = $this->storeManager->getStore($storeId)->getDefaultCurrencyCode();
        $productdata = $product->getData();

        $default = [];
        $default['id'] = 'facebook_ads_' . $product->getId();
        $default['offer_id'] = 'facebook_ads_' . $product->getId();
        $default['channel'] = 'online';
        $default['image_link'] = isset($productdata['small_image']) ? $url . $productdata['small_image'] :
            $this->_assetRepo->getUrl("Ced_FbNative::images/dummy.jpeg");

        if(!file_exists($default['image_link'])) {
            $default['image_link'] = $this->_assetRepo->getUrl("Ced_FbNative::images/dummy.jpeg");
        }
        
        $stockState = $this->objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
        $qty = $stockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId());
        $default['availability'] = $qty ? 'In Stock' : 'Out of Stock';
        $default['Inventory'] = $qty;
        $default['product_type'] = $product->getTypeId();
        if ($product->getTypeId() == 'configurable') {
            $child = $product->getTypeInstance()->getUsedProducts($product);
            $price = $this->getPrice($child[0]->getPrice());
            $default['price'] = $currencyCode . ' ' . $price;
        } else {
            $price = $this->getPrice($product->getPrice());
            $default['price'] = isset($productdata['price']) ? $currencyCode . ' ' . $price : $currencyCode . ' 0';
        }
        $amt = '';
        if ($product->getTypeId() == 'configurable') {
            $child = $product->getTypeInstance()->getUsedProducts($product);
            $offerPercent = $child[0]->getData('offer_percent');
            if (!$offerPercent) {
                $offerPercent = $product->getData('offer_percent');
            }
        } else {
            $offerPercent = $product->getData('offer_percent');
            if (!$offerPercent) {
                $parentProductId = $this->objectManager->create('Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable')
                    ->getParentIdsByChild($product->getId());
                if ($parentProductId) {
                    $parentProduct = $this->objectManager->get('Magento\Catalog\Model\Product')->load($parentProductId);
                    $offerPercent = $parentProduct->getData('offer_percent');
                }
            }
        }

        if ($offerPercent) {
            $offerPrice = ($price * $offerPercent) / 100;
            $PriceDifference = $price - $offerPrice;

            if ($product->getTypeId() == 'configurable') {
                $child = $product->getTypeInstance()->getUsedProducts($product);
                $specialPrice = $child[0]->getSpecialPrice();
                $salePrice = isset($PriceDifference) && !empty($PriceDifference) ? $this->getPrice($PriceDifference) :
                    (isset($specialPrice) ? $this->getPrice($specialPrice) : 0);
                $default['sale_price'] = $currencyCode . ' ' . number_format($salePrice, 2);
            } else {
                $salePrice = isset($PriceDifference) && !empty($PriceDifference) ? $PriceDifference :
                    (isset($product['special_price']) ? $this->getPrice($product['special_price']) : 0);
                $default['sale_price'] = $currencyCode . ' ' . number_format($salePrice, 2);
            }
        } else {
            $salePrice = isset($product['special_price']) ? $this->getPrice($product['special_price']) : 0;
            $default['sale_price'] = $currencyCode . ' ' . number_format($salePrice, 2);
        }

        $default['brand'] = $this->_httpHeader->getHttpHost();

        $confProduct = $objectManager->create('Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable')
            ->getParentIdsByChild($product->getId());

        $default['description'] = isset($productdata['description']) ? trim($productdata['description']) :
            (isset($productdata['short_description']) ? trim($productdata['short_description']) : '');

        if (empty($default['description']) && $product->getTypeId() == 'simple' && $confProduct) {
            $confProd = $this->objectManager->create('Magento\Catalog\Model\Product')->load($confProduct[0]);
            $confProdArray = $confProd->toArray();
            $default['description'] = isset($confProdArray['description']) ? trim($confProdArray['description']) :
                (isset($confProdArray['short_description']) ? trim($confProdArray['short_description']) : '');
        }
        $default['description'] = strip_tags($default['description']);
        $default['description'] = preg_replace('/\s+/', ' ', $default['description']);
        if (strlen($default['description']) >= 9999) {
            $default['description'] = substr($default['description'], 0, 9998);
        }

        if (empty($default['description'])) {
            $default['description'] = $this->isInUpperCase($product->getName()) ? strtolower($product->getName()) : $product->getName();
        }

        if ($confProduct) {
            $confProd = $this->objectManager->create('Magento\Catalog\Model\Product')->load($confProduct[0]);
            $default['link'] = $confProd->getProductUrl(true);
        } else {
            $default['link'] = $product->getProductUrl(true);
        }


        if ($confProduct) {
            $default['item_group_id'] = $confProduct[0];
        } else {
            $default['item_group_id'] = $product->getId();
        }
        $images = $product->getMediaGallery('images');
        $mediaPath = $this->storeManager->getStore($storeId)->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $temp = array();
        foreach ($images as $image) {
            $temp[] = $mediaPath . "catalog/product" . $image['file'];
        }
        $temp = array_unique($temp);
        $temp = array_slice($temp, 0, 5, true);
        $temp = implode(',', $temp);
        $default['additional_image_link'] = $temp;
        return $default;
    }

    public function isInUpperCase($string)
    {
        return preg_match('/^[^a-z]+$/', $string) === 1 ? true : false;
    }

    public function getPrice($price)
    {
        if (isset($price) && !empty($price)) {
            $price = (float)$price;
            $priceType = $this->scopeConfig->getValue('fbnativeconfiguration/productinfo_map/fbnative_product_price');
            if (isset($priceType) and !empty($priceType)) {
                switch ($priceType) {
                    case 'plus_fixed':
                        $fixedPrice = $this->scopeConfig->getValue('fbnativeconfiguration/productinfo_map/fbnative_fix_price');
                        if (isset($fixedPrice) && is_numeric($fixedPrice) && $fixedPrice != '') {
                            $fixedPrice = (float)$fixedPrice;
                            if ($fixedPrice > 0) {
                                $price = (float)($price + $fixedPrice);
                            }
                        }
                        break;

                    case 'min_fixed':
                        $fixedPrice = $this->scopeConfig->getValue('fbnativeconfiguration/productinfo_map/fbnative_fix_price');
                        if (isset($fixedPrice) && is_numeric($fixedPrice) && $fixedPrice != '') {
                            $fixedPrice = (float)$fixedPrice;
                            if ($fixedPrice > 0) {
                                $price = (float)($price - $fixedPrice);
                            }
                        }
                        break;

                    case 'plus_per':
                        $percentPrice = $this->scopeConfig->getValue('fbnativeconfiguration/productinfo_map/fbnative_percentage_price');
                        if (isset($percentPrice) && is_numeric($percentPrice) && $percentPrice != '') {
                            $percentPrice = (float)$percentPrice;
                            if ($percentPrice > 0) {
                                $price = (float)($price + (($price / 100) * $percentPrice));
                            }
                        }
                        break;

                    case 'min_per':
                        $percentPrice = $this->scopeConfig->getValue('fbnativeconfiguration/productinfo_map/fbnative_percentage_price');
                        if (isset($percentPrice) && is_numeric($percentPrice) && $percentPrice != '') {
                            $percentPrice = (float)$percentPrice;
                            if ($percentPrice > 0) {
                                $price = (float)($price - (($price / 100) * $percentPrice));
                            }
                        }
                        break;

                    default:
                        return (float)$price;
                }
            }
        }
        return (float)$price;
    }

    public function getStoreConfig($path, $storeId = null)
    {
        $this->_storeManager = $this->objectManager->get('Magento\Store\Model\StoreManagerInterface');
        $store = $this->_storeManager->getStore($storeId);
        return $this->scopeConfig->getValue($path, 'store', $store->getCode());
    }

    public function checkForLicence()
    {
        if ($this->_request->getModuleName() != 'fbnative') {
            return $this;
        }
        $helper = $this->objectManager->create('Ced\FbNative\Helper\Feed');
        $modules = $helper->getCedCommerceExtensions();
        foreach ($modules as $moduleName => $releaseVersion) {
            $m = strtolower($moduleName);
            if (!preg_match('/ced/i', $m)) {
                return $this;
            }

            $h = $this->scopeConfig->getValue(\Ced\FbNative\Block\Extensions::HASH_PATH_PREFIX . $m . '_hash');

            for ($i = 1; $i <= (int)$this->scopeConfig->getValue(\Ced\FbNative\Block\Extensions::HASH_PATH_PREFIX . $m . '_level'); $i++) {
                $h = base64_decode($h);
            }

            $h = json_decode($h, true);
            if ($moduleName == "Magento2_Ced_FbNative")
                if (is_array($h) && isset($h['domain']) && isset($h['module_name']) && isset($h['license']) && strtolower($h['module_name']) == $m && $h['license'] == $this->scopeConfig->getValue(\Ced\FbNative\Block\Extensions::HASH_PATH_PREFIX . $m)) {
                    return $this;
                } else {
                    return false;
                }
        }
        return $this;
    }
}