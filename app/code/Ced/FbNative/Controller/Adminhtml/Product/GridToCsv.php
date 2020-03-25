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

namespace Ced\FbNative\Controller\Adminhtml\Product;


use Ced\FbNative\Helper\Data;
use Ced\FbNative\Model\Account;
use Ced\FbNative\Model\Feeds;
use Magento\Backend\App\Action;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManager;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Ced\FbNative\Helper\Config;

/**
 * Class Render
 */
class GridToCsv extends \Magento\Catalog\Controller\Adminhtml\Product
{
    /** @var \Magento\Catalog\Model\Indexer\Product\Price\Processor $_productPriceIndexerProcessor */
    public $_productPriceIndexerProcessor;

    /** @var Filter $filter */
    public $filter;

    /** @var CollectionFactory $collectionFactory */
    public $collectionFactory;

    /** @var Data $dataHelper */
    public $dataHelper;

    /** @var StoreManager $storeManager */
    public $storeManager;

    /** @var Account $account */
    public $account;

    /** @var Config $configHelper */
    public $configHelper;

    /** @var \Ced\FbNative\Helper\MultiAccount $multiAccount */
    public $multiAccount;

    /** @var \Magento\Framework\UrlInterface $_urlInterface ; */
    public $_urlInterface;

    /** @var \Ced\FbNative\Model\Feeds Feeds  */
    public $feed;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Product\Builder $productBuilder,
        \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor,
        Filter $filter,
        StoreManager $storeManager,
        Data $dataHelper,
        Config $configHelper,
        Account $account,
        Feeds $feed,
        CollectionFactory $collectionFactory,
        \Ced\FbNative\Helper\MultiAccount $multiAccount,
        \Magento\Framework\UrlInterface $urlInterface
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->dataHelper = $dataHelper;
        $this->configHelper = $configHelper;
        $this->account = $account;
        $this->storeManager = $storeManager;
        $this->_productPriceIndexerProcessor = $productPriceIndexerProcessor;
        $this->multiAccount = $multiAccount;
        $this->_urlInterface = $urlInterface;
        $this->feed = $feed;
        parent::__construct($context, $productBuilder);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $condition = array('new', 'refurbished', 'used', 'cpo');
        $outOfStock = $this->configHelper->scopeConfigManager->getValue('fbnativeconfiguration/productinfo_map/out_of_stock');
        try {
            $AccountCollection = $this->account->getCollection();
            $accounts = $AccountCollection->addFilter('account_status', 1)->getColumnValues('id');
            $data = array();
            $mappedAttr = $this->dataHelper->readCsv();
            if ($mappedAttr) {
                foreach ($mappedAttr as $key => $value) {
                    $data[] = $key;
                }
            } else {
                $this->messageManager->addErrorMessage(__('First map Attributes in Configuration'));
                $resultRedirect->setPath('fbnative/product/index');
                return $resultRedirect;
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

            if (!$accounts) {
                $accountUrl = $this->_urlInterface->getUrl('fbnative/account/index');
                $this->messageManager->addError(__('First Create Account from <a href="' . $accountUrl . '"> Account Section </a>'));
                $resultRedirect->setPath('fbnative/product/index');
                return $resultRedirect;
            }

            foreach ($accounts as $account) {
                $addedProduct = [];
                $attrCode = $this->multiAccount->getStoreAttrForAcc($account);
                $accountData = $this->account->load($account)->getData();
                $productCollection = $this->collectionFactory->create()
                    ->addStoreFilter($accountData['account_store'])
                    ->addAttributeToFilter($attrCode, ['eq' => 1])
                    ->addAttributeToFilter('status', ['eq' => 1]);
                if(!$outOfStock) {
                    $this->_objectManager->create(\Magento\CatalogInventory\Helper\Stock::class)->addInStockFilterToCollection($productCollection);
                }

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
                        $product = $this->_objectManager->create('Magento\Catalog\Model\Product')
                            ->setStoreId($accountData['account_store'])->load($product->getId());
                        $stockState = $this->_objectManager->create(\Magento\CatalogInventory\Api\StockStateInterface::class);
                        $qty = $stockState->getStockQty($product->getId());
                        if(!$qty && !$outOfStock) {
                            continue;
                        }
                        $mappedAttr = $this->dataHelper->readCsv();
                        $default = [];
                        $uIntersect = [];
                            $mappedData = array();
                            foreach ($mappedAttr as $fbAttr => $magentoAttr) {
                                $attrValue = $this->dataHelper->getMappedAttributeValue($magentoAttr, $product);
                                if ($magentoAttr == 'image' && $attrValue != '') {
                                    $attrValue = $url . $attrValue;
                                }

                                if ($fbAttr == 'google_product_category' && empty($attrValue)) {
                                    $attrValue = '632';
                                }

                                if (is_array($attrValue)) {
                                    foreach ($attrValue as $key => $value) {
                                        $mappedData[$fbAttr] = $attrValue[$key];
                                        if($fbAttr == 'sale_price' && $magentoAttr == 'tier_price') {
                                            $mappedData[$fbAttr] = $attrValue[$key]['price'];
                                        }
                                    }
                                } else {
                                    $mappedData[$fbAttr] = $attrValue;
                                }

                                if ($fbAttr == 'price' || $fbAttr == 'sale_price') {
                                    if(!empty($mappedData[$fbAttr])) {
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
                            $default = $this->dataHelper->defaultMappingAttribute($product, $accountData['account_store']);
                            $mappedData = array_merge($default,$mappedData);

                            if (!in_array($mappedData['condition'], $condition)) {
                                $mappedData['condition'] = 'new';
                            }
                            $uIntersect = array_diff_key(array_flip($data),array_flip(array_keys($mappedData)));
                            $mappedData = array_merge($mappedData,array_fill_keys(array_keys($uIntersect),null));
                            ksort($mappedData);
                            fputcsv($fp, $mappedData,chr(9));
                            array_push($addedProduct,$product->getSku());
                    }
                    $feedArray = [
                        'account' => $accountData['id'],
                        'product_ids' => implode(',', $addedProduct),
                        'source' => 'Mannual',
                        'uploaded_time' => date("Y-m-d h:i:sa", strtotime("now"))
                    ];

                    $this->feed->addData($feedArray)->save();
                    $this->messageManager->addSuccessMessage(__('Csv Exported for: ' . $accountData['page_name'] . ' store successfully'));
                    fclose($fp);
                }
            }
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('We found ' . $exception->getMessage() . ' Error while creating feed'));
            $dirPath = BP . '/pub/media/ced_fbnative';
            $filePath = $dirPath . '/fb_log.log';
            $log = fopen($filePath, "w+");
            fwrite($log, $exception->getMessage());
        }
        $resultRedirect->setPath('fbnative/product/index');
        return $resultRedirect;
    }
}
