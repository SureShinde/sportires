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
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Helper;

use Magento\Framework\App\Helper\Context;

class Product extends \Magento\Framework\App\Helper\AbstractHelper implements \Ced\Integrator\Helper\ProductInterface
{
    const WYSIWYG_TYPE = [
        'description',
        'short_description'
    ];
    const PRODUCT_ERROR_VALID = 'valid';

    const ATTRIBUTE_CODE_PRODUCT_PRICING = 'claro_pricing';
    const ATTRIBUTE_CODE_PRICING_FIELD = 'claro_increase_decrease';

    const ATTRIBUTE_CODE_PRODUCT_STATUS = "claro_product_status";
    const ATTRIBUTE_CODE_PRODUCT_ERRORS = "claro_product_errors";
    const ATTRIBUTE_CODE_PROFILE_ID = "claro_profile_id";
    const ATTRIBUTE_CODE_PRODUCT_ID = "claro_product_id";
    const ATTRIBUTE_CODE_VARIANT_ID = "claro_variant_id";

    const VALIDATION_ERROR_VARIANT_ATTRIBUTE_NOT_MAPPED = "%s (%s) variantion attribute is not mapped.";
    const VALIDATION_ERROR_INVALID_QTY = "(%s) invalid qty value";

    /** @var \Magento\Catalog\Model\ProductFactory */
    public $productFactory;

    /** @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory */
    public $productCollectionFactory;

    /** @var \Magento\ConfigurableProduct\Model\Product\Type\ConfigurableFactory */
    public $productConfigurableFactory;

    /** @var \Magento\Catalog\Model\ResourceModel\Product */
    public $productResource;

    /** @var \Magento\Backend\Model\UrlInterface */
    public $url;

    /** @var \Ced\Claro\Repository\Profile */
    public $profileRepository;

    /** @var Config */
    public $config;

    /** @var Logger */
    public $logger;

    /** @var Sdk */
    public $sdk;

    /** @var \Magento\CatalogInventory\Api\StockStateInterface */
    public $stockState;

    public $pause = [];

    public $product;

    public $store;

    public $catalogProductTypeConfigurable;

    public $stockItemRepository;

    public $stockRegistry;

    public function __construct(
        Context $context,
        \Magento\Backend\Model\UrlInterface $url,
        \Magento\CatalogInventory\Api\StockStateInterface $stockState,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product $productResource,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\ConfigurableProduct\Model\Product\Type\ConfigurableFactory $configurableFactory,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Ced\Claro\Repository\Profile $profileRepository,
        \Ced\Claro\Helper\Logger $logger,
        \Ced\Claro\Helper\Sdk $sdk,
        \Ced\Claro\Helper\Config $config,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $catalogProductTypeConfigurable,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
    ) {
        parent::__construct($context);
        $this->url = $url;
        $this->stockState = $stockState;
        $this->productFactory = $productFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productConfigurableFactory = $configurableFactory;
        $this->productResource = $productResource;
        $this->profileRepository = $profileRepository;
        $this->sdk = $sdk;
        $this->config = $config;
        $this->logger = $logger;
        $this->store  = $storeManager;
        $this->catalogProductTypeConfigurable = $catalogProductTypeConfigurable;
        $this->stockItemRepository = $stockItemRepository;
        $this->stockRegistry = $stockRegistry;
    }

    /**
     * Update the values for provided ids
     * @param array $ids
     * @return array|mixed
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function update(array $ids = [])
    {
        return $this->upload($ids);
    }

    /**
     * Upload the values for provided ids
     * @param array $ids
     * @return array
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function upload(array $ids = [])
    {
        $report = [];
        if (!empty($ids)) {
            /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
            $collection = $this->productCollectionFactory->create()
                ->setStoreId($this->config->getStoreId())
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('entity_id', ['in' => $ids])
                ->addMediaGalleryData();
            if ($collection->getSize() > 0) {
                /** @var \Magento\Catalog\Model\Product $product */
                foreach ($collection->getItems() as $product) {
                    /** @var \Ced\Claro\Api\Data\ProfileInterface $profile */
                    $profile = $this->profileRepository
                        ->getById($product->getData(self::ATTRIBUTE_CODE_PROFILE_ID));
                    $sku = $product->getSku();
                    $errors = [
                        $sku => [
                            'sku' => $sku,
                            'id' => $product->getId(),
                            'profile_id' => $profile->getId(),
                            'url' => $this->url->getUrl('catalog/product/edit', ['id' => $product->getId()]),
                            'errors' => self::PRODUCT_ERROR_VALID
                        ]
                    ];
                    // case 1 : for configurable products
                    if ($product->getTypeId() == 'configurable' && $profile->getId()) {
                        $response = [
                            'success' => 0,
                            'message' => 'Configurable product not Uploaded'
                        ];
                        // case 2 : for simple products
                    } elseif ($product->getTypeId() == 'simple' && $profile->getId()) {
                        $mpProduct = $this->create($profile, $product);
                    }
                    $mpProductId = $product->getData(self::ATTRIBUTE_CODE_PRODUCT_ID);
                    $response = null;
                    // for Configurable
                    if ($product->getTypeId() == 'configurable') {
                        $response = [
                            'success' => 0,
                            'message' => 'Configurable product not Uploaded'
                        ];
                        // for Simple
                    } elseif ($product->getTypeId() == 'simple' && isset($mpProduct)) {
                        if (!empty($mpProductId)) {
                            // update the Product
                            unset($mpProduct["skupadre"]);
                            unset($mpProduct["fotos"]);
                            unset($mpProduct["categoria"]);
                            unset($mpProduct["filtro"]);
                            $response = $this->sdk->getProduct()->upload(
                                $mpProduct,
                                \Ced\Claro\Sdk\Product::PRODUCT_ACTION_TYPE_UPDATE,
                                $mpProductId
                            );
                        } else {
                            // create the Product in market Place
                            $response = $this->sdk->getProduct()->upload($mpProduct);
                        }
                    }
                    if (isset($response['success']) || isset($response['message'])) {
                        if ($response['success']==0) {
                            $report[$sku] = \Ced\Claro\Model\Source\Product\Status::INVALID;
                            $report['message'] = $response['message'];
                            $report['success'] = $response['success'];
                            $errors[$product->getSku()]['errors'] = [$response['message']];
                            $product->setData(self::ATTRIBUTE_CODE_PRODUCT_ERRORS, json_encode($errors));
                            $this->productResource->saveAttribute($product, self::ATTRIBUTE_CODE_PRODUCT_ERRORS);
                        } elseif ($response['success']==1) {
                            $report[$sku] = \Ced\Claro\Model\Source\Product\Status::ACTIVE;
                            if (isset($response['transaction_id'])) {
                                $product->setData(
                                    self::ATTRIBUTE_CODE_PRODUCT_ID,
                                    $response['transaction_id']
                                );
                                $this->productResource->saveAttribute($product, self::ATTRIBUTE_CODE_PRODUCT_ID);
                            }
                            $report['message'] = $response['message'];
                            $report['success'] = $response['success'];
                        } else {
                            $report['message'] = 'Configurable Product cannot be uploaded ';
                            $report['success'] = 0;
                        }
                        // saving errors in simple Product and configurable parent Product.
                        $product->setData(self::ATTRIBUTE_CODE_PRODUCT_ERRORS, json_encode($errors));
                        $this->productResource->saveAttribute($product, self::ATTRIBUTE_CODE_PRODUCT_ERRORS);
                    }
                }
            }
        }
        return $report;
    }
    public function childAttributesArray($childs, $variationAttributes, $profile)
    {
        $preparedArray = [];
        foreach ($childs as $child) {
            $preparedArray[$child->getSku()] = [];
            foreach ($variationAttributes as $variationAttribute) {
                $code = $variationAttribute->getProductAttribute()->getAttributeCode();
                $mapping = $profile->getAttributeByCode($code);
                if (isset($mapping['id']) && $mapping['name'] == 'colores') {
                    $value = $this->getMagentoProductAttributeValue($child, $code);
                    $preparedArray[$child->getSku()]['color'] = $value;
                }
                if (isset($mapping['id']) && $mapping['name'] == 'talla') {
                    $value = $this->getMagentoProductAttributeValue($child, $code);
                    $preparedArray[$child->getSku()]['size'] = $value;
                }
            }
        }
        /*$color = [];
        foreach ($preparedArray as $colorValue) {
            array_push($color, $colorValue['color']);
        }
        return array_unique($color);*/
        return $preparedArray;
    }

    /**
     * Create child Product data
     * @param \Ced\Claro\Api\Data\ProfileInterface $profile
     * @param \Magento\Catalog\Model\Product $product
     * @return array
     */
    private function createChild($profile, $product)
    {
        // Adding basic required data
        $product = $this->catalogProductTypeConfigurable
            ->getParentIdsByChild($product->getId());
        $product = $this->productFactory->create()->load($product);//todo:issue
        $claroPriceType = $product->getData('claro_pricing');
        if (!empty($claroPriceType)) {
            $price = $this->getProductPrice($product);
        } else {
            $price = $this->processPrice($product, $profile);
        }
        $data = [
            "price" => $price['price'],
            "seller_custom_field" => $this->getAttributeValue($product, $profile->getAttribute("seller_custom_field"))
        ];
        // Adding additional attributes
        $attributes = $profile->getAttributes();
        if (!empty($attributes)) {
            foreach ($attributes as $id => $attribute) {
                if (!\Ced\Claro\Helper\Category::isDefaultAttribute($id)) {
                    if (isset($attribute['tags']['variation_attribute'])) {
                        $productAttributeValue = $this->getAttributeValue($product, $attribute);
                        // NOTE: option type should be set on "value_id" index
                        if (!empty($productAttributeValue)) {
                            $data['attributes'][] = [
                                "id" => $id,
                                "value_name" => $productAttributeValue
                            ];
                        }
                    }
                }
            }
        }
        return $data;
    }

    /**
     * CreateMagento Product data
     * @param \Ced\Claro\Api\Data\ProfileInterface $profile
     * @param \Magento\Catalog\Model\Product $product
     * @param bool $parent
     * @return array
     */
    private function create($profile, $product, $parent = false)
    {
        //preparing Data
        $data = [];
        $qty = $this->stockState->getStockQty(
            $product->getId(),
            $product->getStore()->getWebsiteId()
        );
        $attributes = $profile->getAttributes();
        $numFormatFields = ['alto','ancho','profundidad','peso','preciopublicobase','preciopublicooferta'];
        foreach ($attributes as $key => $value) {
            if (in_array($key, $numFormatFields)) {
                $data[$key] = number_format(
                    (double)$this->getAttributeValue($product, $profile->getAttribute($value['id'])),
                    2,
                    ".",
                    ""
                );
            } elseif ($key=="cantidad") {
                $data[$key] = (string)$qty;
            } else {
                $data[$key] = $this->getAttributeValue($product, $profile->getAttribute($value['id']));
            }
        }
        $data["fotos"] = $this->getImages($product);
        $data["categoria"] = $profile->getCategoryNode();
        $data["filtro"] = $profile->getLastCategoryNode();
        if ($data["descripcion"]=="") {
            $data["descripcion"] = "descripcion";
        }
        if ($data["especificacionestecnicas"]=="") {
            $data["especificacionestecnicas"] = "especificacionestecnicas";
        }
        if ($data["filtro"]=="0") {
            unset($data["filtro"]);
        }
        if (array_key_exists('colores', $data)) {
            unset($data['colores']);
        } elseif (array_key_exists('talla', $data)) {
            unset($data['talla']);
        }
        foreach ($data as $key => $value) {
            if (empty($data[$key]) || !isset($data[$key])) {
                unset($data[$key]);
            }
        }
        return $data;
    }
    /**
     * Get Images
     * @param \Magento\Catalog\Model\Product $product
     * @param boolean $child
     * @return array
     */
    private function getImages($product, $child = false)
    {
        $productImages = $product->getMediaGalleryImages();
        $images = [];
        if ($productImages->getSize() > 0) {
            $count = 0;
            $c = 1;

            foreach ($productImages as $image) {
                // Max 8 allowed.
                if ($count > 5) {
                    break;
                }

                if ($child) {
                    $images[] = $image->getUrl();
                } else {
                    $images[] = [
                        "url" => $image->getUrl(),
                        "orden" =>(string)($c)
                    ];
                }
                $c++;
                $count++;
            }
        }

        return $images;
    }

    /**
     * Process the attribute value,
     * order $optionMappingValue > $selectTypeValue > $textValue > $defaultValue
     * @param $product
     * @param $attribute
     * @return bool|float|string
     */
    private function getAttributeValue($product, $attribute)
    {
        $optionMappingValue = $selectTypeValue = $textValue = $defaultValue = $productAttributeValue = null;

        // case 1: default value
        if (isset($attribute['default_value']) && !empty($attribute['default_value'])
        ) {
            $defaultValue = $attribute['default_value'];
        }

        // Processing values
        if (isset($attribute['magento_attribute_code']) && !empty($attribute['magento_attribute_code'])) {
            // case 2: text value
            $textValue = $product->getData($attribute['magento_attribute_code']);

            // case 3: option mapping value
            if (isset($attribute['option_mapping'][$textValue]) && is_array($attribute['option_mapping'])) {
                $optionMappingValue = $attribute['option_mapping'][$textValue];
            }

            // case 4: select type value
            $attr = $product->getResource()->getAttribute($attribute['magento_attribute_code']);
            if ($attr && ($attr->usesSource() ||
                    $attr->getData('frontend_input') == 'select')) {
                if (is_array($textValue)) {
                    $values = [];
                    foreach ($textValue as $item) {
                        // case 4.1: Option value for array
                        $values[] =
                            $attr->getSource()
                                ->getOptionText($item);
                    }

                    $selectTypeValue = implode(',', $values);
                } else {
                    // case 4.2: Option value
                    $selectTypeValue = $attr->getSource()->getOptionText($textValue);
                }

                if (is_object($selectTypeValue)) {
                    $selectTypeValue = $selectTypeValue->getText();
                }
            }
        }
        foreach ([$optionMappingValue, $selectTypeValue, $textValue, $defaultValue] as $value) {
            if (isset($value) && !empty($value)) {
                $productAttributeValue = $value;
            }
        }
        // Removing html tags and sanitizing values for html type
        if (isset($attribute['magento_attribute_code']) &&
            in_array($attribute['magento_attribute_code'], self::WYSIWYG_TYPE)) {
            $productAttributeValue = strip_tags($productAttributeValue);
        }

        return $this->setAttributeValueType($attribute, $productAttributeValue);
    }

    /**
     * Type cast attribute to required type in mappings
     * @param $attribute
     * @param $value
     * @return bool|float|string
     */
    private function setAttributeValueType($attribute, $value)
    {
        if (isset($attribute['value_type'])) {
            switch ($attribute['value_type']) {
                case "Integer":
                    $value = number_format((double)$value, 2, ".", "");
                    break;
                case "boolean":
                    $value = (boolean)$value;
                    break;
                default:
                    $value = (string)$value;
            }
        }

        return $value;
    }

    /**
     * Note: setting products to closed.
     * Delete the values for provided ids
     * @param array $ids
     * @return array
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function delete(array $ids = [])
    {
        $report = [];
        if (!empty($ids)) {
            /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
            $collection = $this->productCollectionFactory->create()
                ->setStoreId($this->config->getStoreId())
                ->addAttributeToSelect('type_id')
                ->addAttributeToSelect(self::ATTRIBUTE_CODE_PRODUCT_ID)
                ->addAttributeToFilter('entity_id', ['in' => $ids]);
            if ($collection->getSize() > 0) {
                /** @var \Magento\Catalog\Model\Product $product */
                foreach ($collection->getItems() as $product) {
                    $claroProductTransactionId = $product->getData(self::ATTRIBUTE_CODE_PRODUCT_ID);
                    if (!empty($claroProductTransactionId)) {
                        $response = $this->sdk->getProduct()->delete($claroProductTransactionId);
                        if (isset($response) && $response['success'] == 1 && isset($response['message'])) {
                            $report[$product->getSku()] = \Ced\Claro\Model\Source\Product\Status::CLOSED;
                            $report['message'] = $response['message'];
                            $report['success'] = $response['success'];
                            $product->setData(self::ATTRIBUTE_CODE_PRODUCT_ID, "");
                            $this->productResource->saveAttribute($product, self::ATTRIBUTE_CODE_PRODUCT_ID);
                            $product->save();
                            if ($product->getTypeId() == 'configurable') {
                                // case 1 : for configurable products
                                /** @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable $productType */
                                $productType = $product->getTypeInstance();
                                /** @codingStandardsIgnoreStart */
                                $childIds = $productType->getChildrenIds($product->getId());
                                /** @codingStandardsIgnoreEnd */
                                if (isset($childIds[0])) {
                                    /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $childs */
                                    $childs = $this->productCollectionFactory->create()
                                        ->setStoreId($this->config->getStoreId())
                                        ->addAttributeToSelect('*')
                                        ->addAttributeToSelect('type_id')
                                        ->addAttributeToSelect(self::ATTRIBUTE_CODE_PRODUCT_ID)
                                        ->addAttributeToFilter('entity_id', ['in' => $childIds[0]]);
                                    /** @var \Magento\Catalog\Model\Product $child */
                                    foreach ($childs as $child) {
                                        $child->setData(self::ATTRIBUTE_CODE_PRODUCT_ID, "");
                                    }
                                    $childs->save();
                                }
                            }
                        }
                    }
                }
            }
        }
        return $report;
    }

    /**
     * Get Product Data
     * @param $id
     * @return array
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function get($id)
    {
        $response = [];
        if (!empty($id)) {
            $product = $this->productFactory->create();
            $this->productResource->load($product, $id);
            $mpId = $product->getData(self::ATTRIBUTE_CODE_PRODUCT_ID);
            if (!empty($mpId)) {
                $response = $this->sdk->getProduct()->getData($mpId);
            }
        }

        return $response;
    }
    /**
     * Process price value
     * @param \Magento\Catalog\Model\Product $product
     * @param \Ced\Claro\Api\Data\ProfileInterface $profile
     * @return array
     */
    public function processPrice($product, $profile)
    {
        $splprice = (float)$product->getFinalPrice();
        $price = (float)$product->getPrice();

        $configPrice = $this->config->getPriceType();
        $attribute = $profile->getMappedAttribute('price', 'price');
        if ($attribute != 'price') {
            $configPrice = 'differ';
        }

        switch ($configPrice) {
            case 'plus_fixed':
                $fixedPrice = $this->config->getPriceFixed();
                $price = $this->forFixPrice($price, $fixedPrice, 'plus_fixed');
                $splprice = $this->forFixPrice($splprice, $fixedPrice, 'plus_fixed');
                break;

            case 'min_fixed':
                $fixedPrice = $this->config->getPriceFixed();
                $price = $this->forFixPrice($price, $fixedPrice, 'min_fixed');
                $splprice = $this->forFixPrice($splprice, $fixedPrice, 'min_fixed');
                break;

            case 'plus_per':
                $percentPrice = $this->config->getPricePercentage();
                $price = $this->forPerPrice($price, $percentPrice, 'plus_per');
                $splprice = $this->forPerPrice($splprice, $percentPrice, 'plus_per');
                break;

            case 'min_per':
                $percentPrice = $this->config->getPricePercentage();
                $price = $this->forPerPrice($price, $percentPrice, 'min_per');
                $splprice = $this->forPerPrice($splprice, $percentPrice, 'min_per');
                break;

            case 'differ':
                try {
                    $cprice = (float)$product->getData($attribute);
                } catch (\Exception $e) {
                    $this->logger->debug($e->getMessage(), ['path' => __METHOD__]);
                }
                $price = (isset($cprice) && $cprice != 0) ? $cprice : $price;
                $splprice = $price;
                break;

            default:
                return [
                    'price' => (string)$price,
                    'special_price' => (string)$splprice,
                ];
        }
        return [
            'price' => (string)$price,
            'special_price' => (string)$splprice,
        ];
    }

    /**
     * ForFixPrice
     * @param null $price
     * @param null $fixedPrice
     * @param string $configPrice
     * @return float|null
     */
    public function forFixPrice($price = null, $fixedPrice = null, $configPrice = 'plus_fixed')
    {
        if (is_numeric($fixedPrice) && ($fixedPrice != '')) {
            $fixedPrice = (float)$fixedPrice;
            if ($fixedPrice > 0) {
                $price = $configPrice == 'plus_fixed' ? (float)($price + $fixedPrice)
                    : (float)($price - $fixedPrice);
            }
        }
        return $price;
    }

    /**
     * ForPerPrice
     * @param null $price
     * @param null $percentPrice
     * @param string $configPrice
     * @return float|null
     */
    public function forPerPrice($price = null, $percentPrice = null, $configPrice = 'plus_per')
    {
        if (is_numeric($percentPrice)) {
            $percentPrice = (float)$percentPrice;
            if ($percentPrice > 0) {
                $price = $configPrice == 'plus_per' ?
                    (float)($price + (($price / 100) * $percentPrice))
                    : (float)($price - (($price / 100) * $percentPrice));
            }
        }
        return $price;
    }

    /**
     * @param $offset
     * @param $limit
     * @return array
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function syncClaroProduct($offset, $limit)
    {
        $success = null;
        $sellerId = $this->config->getSellerId();
        $storeId = $this->store->getStore()->getId();
        $result = $this->sdk->getProduct()->getMLProductIds($sellerId, $offset, $limit);
        if (isset($result['success']) && $result['success']) {
            $ids = $result['message'];
            $success = [];
            $errors = [];
            $response = $this->sdk->getProduct()->getMLProductsByIds($ids);
            if (isset($response['success']) && $response['success']) {
                foreach ($response['message'] as $item) {
                    $mlId = isset($item['body']['id']) ? $item['body']['id'] : '';
                    if (isset($item['body']['title'])) {
                        $item = $item['body'];
                        $sku = '';
                        $mlId = $item['id'];
                        $status = $item['status'];
                        $attributes = $item['attributes'];
                        $variations = $item['variations'];
                        $seller_custom_field = $item['seller_custom_field'];
                        if (!empty($seller_custom_field)) {
                            $collection =  $this->productCollectionFactory->create()->addAttributeToSelect('*');
                            foreach ($collection->getItems() as $product) {
                                $sku = $product->getSku();
                                if (isset($seller_custom_field) && $seller_custom_field == $sku) {
                                    if (!empty($sku)) {
                                        $id = $this->productFactory->create()
                                            ->setStoreId($storeId)
                                            ->getIdBySku($sku);
                                        $product = $this->productFactory->create()
                                            ->setStoreId($storeId)
                                            ->load($id);
                                        $magemlId = $product->getData(self::ATTRIBUTE_CODE_PRODUCT_ID);
                                        if (empty($magemlId) && !empty($id)) {
                                            $product->setData(self::ATTRIBUTE_CODE_PRODUCT_STATUS, $status);
                                            $product->getResource()
                                                ->saveAttribute($product, self::ATTRIBUTE_CODE_PRODUCT_STATUS);
                                            $product->setData(self::ATTRIBUTE_CODE_PRODUCT_ID, $mlId);
                                            $product->getResource()
                                                ->saveAttribute($product, self::ATTRIBUTE_CODE_PRODUCT_ID);
                                            $success[] = '<b>ML ID : ' . $mlId . ' </b> SKU : ' . $sku;
                                        } else {
                                            $errors[] = "<b>ML ID :$mlId </b>:No Product Found Of Id <b>$id</b></i> </b>is Already Present For ML  SKU <b>$sku</b> And ML Item Id $mlId";
                                        }
                                    } else {
                                        $errors[] = "<b>ML ID :  $mlId :</b> No SKU Found For ML Product Id $mlId";
                                    }
                                }
                            }
                        }
                        if (!empty($variations)) {
                            foreach ($variations as $variation) {
                                $varId = $variation['id'];
                                $varSellerSku = $variation['seller_custom_field'];
                                $varsku = '';
                                $varattributes = isset($variation['attribute_combinations']) ? $variation['attribute_combinations'] : [];
                                foreach ($varattributes as $varattribute) {
                                    if (isset($varattribute['id']) && $varattribute['id'] == 'SELLER_SKU') {
                                        if (isset($varattribute['value_name']) && !empty($varattribute['value_name'])) {
                                            $varsku = $varattribute['value_name'];
                                        } elseif (isset($varattribute['value_id']) && !empty($varattribute['value_id'])) {
                                            $varsku = $varattribute['value_id'];
                                        }
                                    }
                                }
                                if (!empty($varSellerSku) && empty($varsku)) {
                                    $product = $this->productFactory->create()->getIdBySku($varSellerSku);
                                    if (!empty($product)) {
                                        $varsku = $varSellerSku;
                                    }
                                }
                                if (!empty($varsku)) {
                                    $varproduct = $this->productFactory->create()
                                        ->loadByAttribute('sku', $varsku);
                                    $varProdId = $this->productFactory->create()->setStoreId($storeId)
                                        ->getIdBySku($varsku);
                                    $varmagemlvarId = $varproduct->getData(self::ATTRIBUTE_CODE_VARIANT_ID);

                                    if (empty($varmagemlvarId) && !empty($varProdId)) {
                                        $varproduct->setData(self::ATTRIBUTE_CODE_PRODUCT_STATUS, $status);
                                        $varproduct->setData(self::ATTRIBUTE_CODE_PRODUCT_ID, $varId);
                                        $varproduct->getResource()
                                            ->saveAttribute($varproduct, self::ATTRIBUTE_CODE_PRODUCT_STATUS)
                                            ->saveAttribute($varproduct, self::ATTRIBUTE_CODE_PRODUCT_ID);
                                        $success[] = '<b> ML Child ID : </b>' . $mlId . ' <b> SKU : <b/>' . $varsku;

                                        $productParents = $this->catalogProductTypeConfigurable
                                            ->getParentIdsByChild($varProdId);
                                        if (!empty($productParents) && is_array($productParents)) {
                                            $parent_id = $productParents[0];

                                            $parent_product = $this->productFactory->create()
                                                ->setStoreId($storeId)
                                                ->load($parent_id);
                                            $parentmlId = $parent_product->getData(self::ATTRIBUTE_CODE_PRODUCT_ID);

                                            if (empty($parentmlId) && !empty($parent_id)) {
                                                $parent_product->setData(self::ATTRIBUTE_CODE_PRODUCT_STATUS, $status);
                                                $parent_product->setData(self::ATTRIBUTE_CODE_PRODUCT_ID, $mlId);

                                                $parent_product->getResource()
                                                    ->saveAttribute($parent_product, self::ATTRIBUTE_CODE_PRODUCT_STATUS);
                                                $parent_product->getResource()
                                                    ->saveAttribute($parent_product, self::ATTRIBUTE_CODE_PRODUCT_ID);
                                                $success[] ='<b>ML Parent ID : </b>' . $mlId . ' <b> SKU : <b/>' . $sku;
                                            }
                                        }
                                    } else {
                                        $errors[] = "<b>ML Parent ID : $mlId </b>: No Product Found Or  ML Id is Already Present For ML Variant SKU $varsku And ML Variation Id $varId";
                                    }
                                } else {
                                    $errors[] = "<b>ML Parent ID : $mlId </b>: No SKU Found For ML Variation Id $varId";
                                }
                            }
                        } else {
                            foreach ($attributes as $attribute) {
                                if (isset($attribute['id']) && $attribute['id'] == 'SELLER_SKU') {
                                    if (isset($attribute['value_name']) && !empty($attribute['value_name'])) {
                                        $sku = $attribute['value_name'];
                                    } elseif (isset($attribute['value_id']) && !empty($attribute['value_id'])) {
                                        $sku = $attribute['value_id'];
                                    }
                                }
                            }
                            if (!empty($sku)) {
                                $id = $this->productFactory->create()
                                    ->setStoreId($storeId)
                                    ->getIdBySku($sku);
                                $product = $this->productFactory->create()
                                    ->setStoreId($storeId)
                                    ->load($id);
                                $magemlId = $product->getData(self::ATTRIBUTE_CODE_PRODUCT_ID);
                                if (empty($magemlId) && !empty($id)) {
                                    $product->setData(self::ATTRIBUTE_CODE_PRODUCT_STATUS, $status);
                                    $product->getResource()
                                        ->saveAttribute($product, self::ATTRIBUTE_CODE_PRODUCT_STATUS);
                                    $product->setData(self::ATTRIBUTE_CODE_PRODUCT_ID, $mlId);
                                    $product->getResource()
                                        ->saveAttribute($product, self::ATTRIBUTE_CODE_PRODUCT_ID);
                                    $success[] = '<b>ML Parent ID : ' . $mlId . ' </b> SKU : ' . $sku;
                                } else {
                                    $errors[] = "<b>ML Parent ID :$mlId </b>: No Product Found Of Id <b>$id</b> is Already Present For ML  SKU <b>$sku</b> And ML Item Id $mlId";
                                }
                            } else {
                                $errors[] = "<b>ML Parent ID :  $mlId : </b> No SKU Found For ML Product Id $mlId";
                            }
                        }
                    } else {
                        $err = 'Failed To Get Item Data For ID ' . $mlId;
                        if (isset($item['body']['message'])) {
                            $err = $item['body']['message'];
                        }
                        $errors[] = $err;
                    }
                }
            } else {
                if (isset($response['message'])) {
                    $err = $response['message'];
                    if (is_array($err)) {
                        $errors = $err;
                    } else {
                        $errors[] = $err;
                    }
                }
            }
        } else {
            if (isset($result['message'])) {
                $err = $result['message'];
                if (is_array($err)) {
                    $errors = $err;
                } else {
                    $errors[] = $err;
                }
            }
        }
        return [
            'success' => $success,
            'error' => $errors
        ];
    }

    /**
     * get all product and apply price rule
     * @param $product
     * @return array
     */
    public function getProductPrice($product)
    {
        $claroPriceType = $product->getData('claro_pricing');
        $updatePrice = $product->getData('claro_increase_decrease');
        $finalprice = (float)$product->getFinalPrice();
        $spclprice = (float)$product->getSpecialPrice();
        $price = (float)$product->getPrice();
        if (!empty($spclprice)) {
            $finalprice = $spclprice;
        }
        if (empty($price)) {
            $price = $finalprice;
        }
        switch ($claroPriceType) {
            case 1:
                $price = (string)$price;
                $finalprice = (string)$finalprice;
                break;

            case 2:
                $price = $this->forFixPrice(
                    $price,
                    $updatePrice,
                    \Ced\Claro\Helper\Config::TYPE_FIXED_INCREASE
                );
                $finalprice = $this->forFixPrice(
                    $finalprice,
                    $updatePrice,
                    \Ced\Claro\Helper\Config::TYPE_FIXED_INCREASE
                );
                break;

            case 3:
                $price = $this->forFixPrice(
                    $price,
                    $updatePrice,
                    \Ced\Claro\Helper\Config::TYPE_FIXED_DECREASE
                );
                $finalprice = $this->forFixPrice(
                    $finalprice,
                    $updatePrice,
                    \Ced\Claro\Helper\Config::TYPE_FIXED_DECREASE
                );
                break;

            case 4:
                $price = $this->forPerPrice(
                    $price,
                    $updatePrice,
                    \Ced\Claro\Helper\Config::TYPE_PERCENTAGE_INCREASE
                );
                $finalprice = $this->forPerPrice(
                    $finalprice,
                    $updatePrice,
                    \Ced\Claro\Helper\Config::TYPE_PERCENTAGE_INCREASE
                );
                break;

            case 5:
                $price = $this->forPerPrice(
                    $price,
                    $updatePrice,
                    \Ced\Claro\Helper\Config::TYPE_PERCENTAGE_DECREASE
                );
                $finalprice = $this->forPerPrice(
                    $finalprice,
                    $updatePrice,
                    \Ced\Claro\Helper\Config::TYPE_PERCENTAGE_DECREASE
                );
                break;
        }
        $finalprice = round((float)$finalprice, 2);
        $price = round((float)$price, 2);
        if ((empty($finalprice) || $finalprice == 0.00) && (!empty($price) || $price != 0.00)) {
            $finalprice = $price;
        }

        if ((empty($price) || $price == 0.00) && (!empty($finalprice) || $finalprice != 0.00)) {
            $price = $finalprice;
        }

        $response = [
            'price' => (string)$finalprice,
            'Actualprice' => (string)$price,
        ];
        return $response;
    }

    /**
     * @param $product
     * @param $attributeCode
     * @return mixed
     */
    public function getMagentoProductAttributeValue($product, $attributeCode)
    {
        if ($product->getData($attributeCode) == "") {
            return $product->getData($attributeCode);
        }

        $attr = $product->getResource()->getAttribute($attributeCode);
        if ($attr && ($attr->usesSource() || $attr->getData('frontend_input') == 'select')) {
            $productAttributeValue = $attr->getSource()->getOptionText($product->getData($attributeCode));
        } else {
            $productAttributeValue = $product->getData($attributeCode);
        }
        return $productAttributeValue;
    }
}
