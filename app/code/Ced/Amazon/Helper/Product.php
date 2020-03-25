<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement(EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
 * @package   Ced_Amazon
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Amazon\Helper;

/**
 * Directory separator shorthand
 */

use Ced\Amazon\Api\AccountRepositoryInterface;
use Ced\Amazon\Api\ProfileRepositoryInterface;
use Ced\Amazon\Repository\Account;
use Magento\Framework\DataObjectFactory;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Class Product
 * @package Ced\Amazon\Helper
 */
class Product extends \Magento\Framework\App\Helper\AbstractHelper implements \Ced\Integrator\Helper\ProductInterface
{
    const WYSIWYG_TYPE = [
        'description',
        'short_description'
    ];

    const ATTRIBUTE_CODE_PROFILE_ID = 'amazon_profile_id';
    const ATTRIBUTE_CODE_ASIN = 'asin';
    const ATTRIBUTE_CODE_PRODUCT_STATUS = 'amazon_product_status';
    const ATTRIBUTE_CODE_VALIDATION_ERRORS = 'amazon_validation_errors';
    const ATTRIBUTE_CODE_FEED_ERRORS = 'amazon_feed_errors';

    const PRODUCT_ERROR_VALID = 'valid';

    const PRODUCT_TYPE_PARENT = 'parent';
    const PRODUCT_TYPE_CHILD = 'child';

    const BULLET_POINT_1 = 'DescriptionData_BulletPoint1';
    const BULLET_POINT_2 = 'DescriptionData_BulletPoint2';
    const BULLET_POINT_3 = 'DescriptionData_BulletPoint3';
    const BULLET_POINT_4 = 'DescriptionData_BulletPoint4';
    const BULLET_POINT_5 = 'DescriptionData_BulletPoint5';

    const BULLET_POINTS = [
        self::BULLET_POINT_1,
        self::BULLET_POINT_2,
        self::BULLET_POINT_3,
        self::BULLET_POINT_4,
        self::BULLET_POINT_5,
    ];

    const SEARCH_TERMS_1 = 'DescriptionData_SearchTerms1';
    const SEARCH_TERMS_2 = 'DescriptionData_SearchTerms2';
    const SEARCH_TERMS_3 = 'DescriptionData_SearchTerms3';
    const SEARCH_TERMS_4 = 'DescriptionData_SearchTerms4';
    const SEARCH_TERMS_5 = 'DescriptionData_SearchTerms5';

    const SEARCH_TERMS = [
        self::SEARCH_TERMS_1,
        self::SEARCH_TERMS_2,
        self::SEARCH_TERMS_3,
        self::SEARCH_TERMS_4,
        self::SEARCH_TERMS_5,
    ];

    /** @var \Magento\Framework\Api\SearchCriteriaInterface */
    public $search;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    public $objectManager;

    /**
     * @var \Zend_Filter_StripTags
     */
    public $stripTags;

    /** @var AccountRepositoryInterface */
    public $account;

    /**
     * @var ProfileRepositoryInterface
     */
    public $profile;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    public $product;

    /**
     * @var \Magento\ConfigurableProduct\Model\Product\Type\ConfigurableFactory
     */
    public $productConfigurable;

    /** @var \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable */
    public $productConfigurableResource;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    public $products;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    public $productResource;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    public $storeManager;

    /**
     * @var \Ced\Amazon\Model\Profileproducts
     */
    public $profileProducts;

    /**
     * @var $config
     */
    public $config;

    /**
     * @var \Amazon\Sdk\EnvelopeFactory
     */
    public $envelope;

    /**
     * DirectoryList
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    public $directoryList;

    /**
     * File Manager
     * @var $fileIo
     */
    public $fileIo;

    /**
     * Date/Time
     * @var $dateTime
     */
    public $dateTime;

    /** @var \Ced\Amazon\Api\FeedRepositoryInterface */
    public $feed;

    /**
     * @var \Ced\Amazon\Helper\Logger
     */
    public $logger;

    /**
     * @var \Ced\Amazon\Model\FeedsFactory
     */
    public $amazonFeed;

    /**
     * @var \Ced\Amazon\Model\ResourceModel\Feeds\CollectionFactory
     */
    public $amazonFeeds;

    /**
     * @var \Ced\Amazon\Api\QueueRepositoryInterface
     */
    public $queue;

    /** @var \Ced\Amazon\Api\Data\Queue\DataInterfaceFactory */
    public $queueDataFactory;

    /**
     * @var \Amazon\Sdk\Api\Product\ProductListFactory
     */
    public $productList;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    public $urlBuilder;

    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    public $serializer;

    /** @var DataObjectFactory */
    public $data;

    /**
     * @var \Amazon\Sdk\Envelope
     */
    public $relationships = null;

    /** @var \Amazon\Sdk\Product\RelationshipFactory */
    public $relationship;

    /**
     * Product Ids
     * @var array
     */
    public $ids = [];

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Filesystem\DirectoryList $directoryList, //remove
        \Magento\Framework\Filesystem\Io\File $fileIo, //remove
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Backend\Model\UrlInterface $url,
        \Magento\Framework\DataObjectFactory $dataObjectFactory, //remove
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \Magento\Framework\Api\SearchCriteriaInterface $search,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Zend_Filter_StripTags $stripTags,

        \Ced\Amazon\Api\AccountRepositoryInterface $account,
        \Ced\Amazon\Api\ProfileRepositoryInterface $profile,
        \Ced\Amazon\Api\QueueRepositoryInterface $queue,
        \Ced\Amazon\Api\FeedRepositoryInterface $feed,
        \Ced\Amazon\Api\Data\Queue\DataInterfaceFactory $queueDataFactory,

        \Magento\Catalog\Model\ProductFactory $product,
        \Magento\Catalog\Model\ResourceModel\Product $productResource,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\ConfigurableProduct\Model\Product\Type\ConfigurableFactory $configurableFactory,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $configurableResource,
        \Ced\Amazon\Model\Profileproducts $profileProducts, //remove

        \Ced\Amazon\Model\FeedsFactory $feedsFactory, //remove
        \Ced\Amazon\Model\ResourceModel\Feeds\CollectionFactory $feedsCollectionFactory, //remove

        \Ced\Amazon\Helper\Config $config,
        \Ced\Amazon\Helper\Logger $logger,

        \Amazon\Sdk\Api\Product\ProductListFactory $productList,
        \Amazon\Sdk\EnvelopeFactory $envelope,
        \Amazon\Sdk\Product\RelationshipFactory $relationship
    ) {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->directoryList = $directoryList;
        $this->fileIo = $fileIo;
        $this->dateTime = $dateTime;
        $this->search = $search;
        $this->storeManager = $storeManager;
        $this->stripTags = $stripTags;

        $this->account = $account;
        $this->profile = $profile;
        $this->feed = $feed;
        $this->queue = $queue;
        $this->queueDataFactory = $queueDataFactory;

        $this->product = $product;
        $this->products = $productCollectionFactory;
        $this->productConfigurable = $configurableFactory;
        $this->productConfigurableResource = $configurableResource;
        $this->productResource = $productResource;
        $this->urlBuilder = $url;
        $this->serializer = $serializer;
        $this->data = $dataObjectFactory;

        $this->amazonFeed = $feedsFactory;
        $this->amazonFeeds = $feedsCollectionFactory;
        $this->profileProducts = $profileProducts;
        $this->config = $config;
        $this->logger = $logger;

        $this->envelope = $envelope;
        $this->productList = $productList;
        $this->relationship = $relationship;
    }

    /**
     * Update/upload products on Amazon
     * @param array $ids
     * @param bool $throttle
     * @param string $operationType
     * @return boolean
     * @throws \Exception
     */
    public function update(array $ids = [], $throttle = true, $operationType = \Amazon\Sdk\Base::OPERATION_TYPE_UPDATE)
    {
        $status = false;
        if (isset($ids) && !empty($ids)) {
            $profileIds = $this->profile->getProfileIdsByProductIds($ids);
            if (!empty($profileIds)) {
                /** @var \Magento\Framework\Api\SearchCriteriaInterface $search */
                $search = $this->search->setData(
                    'filter_groups',
                    [
                        [
                            'filters' => [
                                [
                                    'field' => \Ced\Amazon\Model\Profile::COLUMN_ID,
                                    'value' => $profileIds,
                                    'condition_type' => 'in'
                                ],
                                [
                                    'field' => \Ced\Amazon\Model\Profile::COLUMN_STATUS,
                                    'value' => \Ced\Amazon\Model\Source\Profile\Status::ENABLED,
                                    'condition_type' => 'eq'
                                ]
                            ]
                        ]
                    ]
                );

                /** @var \Ced\Amazon\Api\Data\ProfileSearchResultsInterface $profiles */
                $profiles = $this->profile->getList($search);

                /** @var \Ced\Amazon\Api\Data\AccountSearchResultsInterface $accounts */
                $accounts = $profiles->getAccounts();

                /** @var array $stores */
                $stores = $profiles->getProfileByStoreIdWise();

                /** @var \Ced\Amazon\Api\Data\AccountInterface $account */
                foreach ($accounts->getItems() as $accountId => $account) {
                    foreach ($stores as $storeId => $profiles) {
                        $envelope = null;
                        /** @var \Ced\Amazon\Api\Data\ProfileInterface $profile */
                        foreach ($profiles as $profileId => $profile) {
                            $productIds = $this->profile->getAssociatedProductIds($profileId, $storeId, $ids);
                            $specifics = [
                                'ids' => $productIds,
                                'account_id' => $accountId,
                                'marketplace' => $profile->getMarketplace(),
                                'profile_id' => $profileId,
                                'store_id' => $storeId,
                                'type' => \Amazon\Sdk\Api\Feed::PRODUCT,
                            ];

                            if (!empty($productIds)) {
                                if ($throttle == true) {
                                    // queue
                                    /** @var \Ced\Amazon\Api\Data\Queue\DataInterface $queueData */
                                    $queueData = $this->queueDataFactory->create();
                                    $queueData->setAccountId($accountId);
                                    $queueData->setMarketplace($profile->getMarketplace());
                                    $queueData->setSpecifics($specifics);
                                    $queueData->setOperationType($operationType);
                                    $queueData->setType(\Amazon\Sdk\Api\Feed::PRODUCT);
                                    $status = $this->queue->push($queueData);
                                } else {
                                    //TODO: add all data to uniqueid in session & process via multiple ajax requests.

                                    // prepare & send: divide in chunks and process in multiple requests

                                    if ($operationType == \Amazon\Sdk\Base::OPERATION_TYPE_DELETE) {
                                        $envelope = $this->prepareDelete($specifics, $envelope);
                                    } else {
                                        $envelope = $this->prepare($specifics, $envelope, $operationType);
                                    }

                                    $status = $this->feed->send($envelope, $specifics);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $status;
    }

    /**
     * Product Prepare Delete for Amazon
     * @param array $specifics
     * @param array|null $envelope
     * @return array
     * @throws \Exception
     */
    public function prepareDelete(array $specifics = [], $envelope = null)
    {
        if (isset($specifics) && !empty($specifics)) {
            /** @var \Ced\Amazon\Api\Data\ProfileInterface $profile */
            $profile = $this->profile->getById($specifics['profile_id']);

            $ids = $specifics['ids'];
            /** @var \Ced\Amazon\Api\Data\AccountInterface $account */
            $account = $this->account->getById($specifics['account_id']);

            if (!isset($envelope)) {
                /** @var \Amazon\Sdk\Envelope $envelope */
                $envelope = $this->envelope->create(
                    [
                        'merchantIdentifier' => $account->getConfig($profile->getMarketplaceIds())->getSellerId(),
                        'messageType' => \Amazon\Sdk\Base::MESSAGE_TYPE_PRODUCT
                    ]
                );
            }

            $storeId = $profile->getStore()->getId();

            /** @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $products */
            $products = $this->products->create()
                ->setStoreId($storeId)
                ->addAttributeToSelect(['sku', 'entity_id', 'type_id'])
                ->addAttributeToFilter('entity_id', ['in' => $ids]);
            /** @var \Magento\Catalog\Model\Product $product */
            foreach ($products as $product) {
                // case 1 : for configurable products
                if ($product->getTypeId() == 'configurable') {
                    $parentId = $product->getId();
                    /** @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable $productType */
                    $productType = $product->getTypeInstance();

                    /** @codingStandardsIgnoreStart */
                    $childIds = $productType->getChildrenIds($parentId);
                    /** @codingStandardsIgnoreEnd */
                    /** @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $products */
                    $childs = $this->products->create()
                        ->setStoreId($storeId)
                        ->addAttributeToSelect(['sku', 'entity_id', 'type_id'])
                        ->addAttributeToFilter('entity_id', ['in' => $childIds[0]]);

                    foreach ($childs as $child) {
                        $mpProduct = $this->objectManager->create(
                            \Amazon\Sdk\Product\Category\DefaultCategory::class,
                            [
                                'subCategory' => 'DefaultCategory'
                            ]
                        );
                        $mpProduct->setId($child->getId());
                        $mpProduct->setOperationType(\Amazon\Sdk\Base::OPERATION_TYPE_DELETE);
                        $mpProduct->SKU = $child->getSku();
                        $envelope->addProduct($mpProduct);
                    }
                } elseif ($product->getTypeId() == 'simple') {
                    // case 2 : for simple products
                    $mpProduct = $this->objectManager->create(
                        \Amazon\Sdk\Product\Category\DefaultCategory::class,
                        [
                            'subCategory' => 'DefaultCategory'
                        ]
                    );
                    $mpProduct->setId($product->getId());
                    $mpProduct->setOperationType(\Amazon\Sdk\Base::OPERATION_TYPE_DELETE);
                    $mpProduct->SKU = $product->getSku();
                    $envelope->addProduct($mpProduct);
                }
            }
        }

        return $envelope;
    }

    /**
     * TODO: Option mappings, Update product status for Amazon
     * Product Prepare for Amazon
     * @param array $specifics
     * @param array|null $envelope
     * @param string $operationType
     * @return \Amazon\Sdk\Envelope
     * @throws \Exception
     */
    public function prepare(array $specifics = [], $envelope = null, $operationType = \Amazon\Sdk\Base::OPERATION_TYPE_UPDATE)
    {
        if (isset($specifics) && !empty($specifics)) {
            /** @var \Ced\Amazon\Api\Data\ProfileInterface $profile */
            $profile = $this->profile->getById($specifics['profile_id']);

            $this->ids = $specifics['ids'];
            /** @var \Ced\Amazon\Api\Data\AccountInterface $account */
            $account = $this->account->getById($specifics['account_id']);
            $this->initRelationships($account);

            if (!isset($envelope)) {
                /** @var \Amazon\Sdk\Envelope $envelope */
                $envelope = $this->envelope->create(
                    [
                        'merchantIdentifier' => $account->getConfig($profile->getMarketplaceIds())->getSellerId(),
                        'messageType' => \Amazon\Sdk\Base::MESSAGE_TYPE_PRODUCT
                    ]
                );
            }

            /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $products */
            $products = $this->products->create();
            $products->setStoreId($specifics['store_id']);
            $products->addAttributeToSelect('*')
                ->addAttributeToFilter('entity_id', ['in' => $specifics['ids']]);

            /** @var \Magento\Catalog\Model\Product $product */
            foreach ($products as $product) {
                $sku = $product->getSku();
                $errors = [
                    $sku => [
                        'sku' => $sku,
                        'id' => $product->getId(),
                        'profile_id' => $profile->getId(),
                        'account_id' => $profile->getAccountId(),
                        'store_id' => $profile->getStoreId(),
                        'url' => $this->urlBuilder
                            ->getUrl('catalog/product/edit', ['id' => $product->getId()]),
                        'errors' => self::PRODUCT_ERROR_VALID
                    ]
                ];

                // case 1 : for configurable products
                if ($product->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE &&
                    $profile->getId()) {
                    $relation = [];
                    $parentId = $product->getId();
                    /** @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable $productType */
                    $productType = $product->getTypeInstance();

                    $variantAttributes = [];
                    /** @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable\Attribute $attribute */
                    foreach ($productType->getConfigurableAttributes($product) as $attribute) {
                        $eavAttribute = $attribute->getProductAttribute();
                        $eavAttribute->setStoreId($product->getStoreId());
                        $variantAttributes[$eavAttribute->getAttributeCode()] = $eavAttribute->getAttributeCode();
                    }

                    /** @codingStandardsIgnoreStart */
                    $childIds = $productType->getChildrenIds($parentId);
                    /** @codingStandardsIgnoreEnd */

                    if (isset($childIds[0])) {
                        $valid = false;
                        /** @var \Amazon\Sdk\Product\CategoryInterface $parent */
                        $parent = $this->create($profile, $product, self::PRODUCT_TYPE_PARENT);

                        // setting a parentSku as the configurable sku.
                        $parentSku = $product->getSku();

                        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $products */
                        $childs = $this->products->create()
                            ->setStoreId($profile->getStoreId())
                            ->addAttributeToSelect('*')
                            ->addAttributeToFilter('entity_id', ['in' => $childIds[0]]);
                        /** @var \Magento\Catalog\Model\Product $child */
                        foreach ($childs as $child) {
                            // TODO: add childs to skip list if processed from parent.
                            $error = [
                                'sku' => $child->getSku(),
                                'id' => $child->getId(),
                                'profile_id' => $profile->getId(),
                                'account_id' => $profile->getAccountId(),
                                'store_id' => $profile->getStoreId(),
                                'url' => $this->urlBuilder
                                    ->getUrl('catalog/product/edit', ['id' => $child->getId()]),
                                'errors' => self::PRODUCT_ERROR_VALID
                            ];

                            /** @var \Amazon\Sdk\Product\CategoryInterface $mpProduct */
                            $mpProduct = $this->create($profile, $child, self::PRODUCT_TYPE_CHILD, $variantAttributes, $parent);
                            $mpProduct->setOperationType($operationType);
                            if ($mpProduct->isValid()) {
                                $valid = true;
                                $envelope->addProduct($mpProduct);
                                $relation[$child->getSku()] =
                                    \Amazon\Sdk\Product\Relationship::RELATION_TYPE_VARIATION;
                            } else {
                                $error['errors'] = [$mpProduct->getError()];
                            }

                            // adding child error to parent errors if exists
                            if (isset($error['errors']) && $error['errors'] != self::PRODUCT_ERROR_VALID) {
                                $errors[$child->getSku()] = $error;
                            }

                            // saving child errors only.
                            $child->setData(
                                self::ATTRIBUTE_CODE_VALIDATION_ERRORS,
                                $this->serializer->serialize([$child->getSku() => $error])
                            );

                            if (!empty($relation)) {
                                $relationship = $this->relationship->create();
                                $relationship->setId($product->getId());
                                $relationship->setData($parentSku, $relation);
                                // Adding a relationship to envelope.
                                $this->relationships->addRelationship($relationship);
                            }
                        }

                        /** @codingStandardsIgnoreStart */
                        $this->save($childs);
                        /** @codingStandardsIgnoreEnd */

                        if ($valid) {
                            if (isset($mpProduct) && $mpProduct->isValid() &&
                                $key = $mpProduct->getVariationThemeAttribute()) {
                                $parent->$key = $mpProduct->get($key);
                            }

                            $envelope->addProduct($parent);
                            $relation[$product->getSku()] = \Amazon\Sdk\Product\Relationship::RELATION_TYPE_VARIATION;
                        }
                    }
                } elseif ($product->getTypeId() == \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE &&
                    $profile->getId()) {
                    // case 2 : for simple products

                    $type = null;
                    $parentIds = $this->productConfigurableResource->getParentIdsByChild($product->getId());
                    if (!empty($parentIds)) {
                        $type = self::PRODUCT_TYPE_CHILD;
                    }

                    /** @var \Amazon\Sdk\Product\CategoryInterface $mpProduct */
                    $mpProduct = $this->create($profile, $product, $type);
                    $mpProduct->setOperationType($operationType);
                    if ($mpProduct->isValid()) {
                        $envelope->addProduct($mpProduct);
                    } else {
                        $errors[$sku]['errors'] = [$mpProduct->getError()];
                    }
                }

                // saving errors in simple product and configurable parent product.
                $product->setData(
                    self::ATTRIBUTE_CODE_VALIDATION_ERRORS,
                    $this->serializer->serialize($errors)
                );
            }

            $this->save($products);
        }

        return $envelope;
    }

    /**
     * Save attribute in a collection
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $products
     */
    private function save($products)
    {
        $storeId = null;
        if ($this->storeManager->hasSingleStore()) {
            $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
        }

        /** @var \Magento\Catalog\Model\Product $product */
        foreach ($products as $product) {
            try {
                if (isset($storeId)) {
                    $product->setStoreId($storeId);
                }
                // Overriding as "amazon_validation_errors" is Global attribute
                $product->setStoreId(\Magento\Store\Model\Store::DEFAULT_STORE_ID);
                $this->productResource->saveAttribute($product, self::ATTRIBUTE_CODE_VALIDATION_ERRORS);
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    /**
     * TODO: use it
     * Intialize relationship object
     * @param \Ced\Amazon\Api\Data\AccountInterface $account
     */
    private function initRelationships(\Ced\Amazon\Api\Data\AccountInterface $account)
    {
        $this->relationships = $this->envelope->create(
            [
                'merchantIdentifier' => $account->getConfig()->getSellerId(),
                'messageType' => \Amazon\Sdk\Base::MESSAGE_TYPE_RELATIONSHIP
            ]
        );
    }

    /**
     * Create Product Data
     * @param \Ced\Amazon\Api\Data\ProfileInterface $profile
     * @param \Magento\Catalog\Model\Product $product
     * @param string $type
     * @param array $variant
     * @param \Amazon\Sdk\Product\CategoryInterface|null $parent
     * @return \Amazon\Sdk\Product\CategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function create($profile, $product, $type = null, $variant = [], $parent = null)
    {
        $theme = [];
        $asin = null;
        $variationList = $variant;

        /**
         * @var \Amazon\Sdk\Product\CategoryInterface $mpProduct
         * @codingStandardsIgnoreStart
         */
        $mpProduct = $this->objectManager->create(
            '\Amazon\Sdk\Product\Category\\' . $profile->getProfileCategory(),
            [
                'subCategory' => $profile->getProfileSubCategory()
            ]
        );
        /** @codingStandardsIgnoreEnd */

        $mpProduct->setId($profile->getId() . $product->getId());
        $mpProduct->setBarcodeExemption($profile->getBarcodeExemption());

        $attributes = $profile->getProfileAttributes();
        foreach ($attributes as $id => $attribute) {
            $value = null;
            $code = null;
            if (isset($attribute['magento_attribute_code']) &&
                $attribute['magento_attribute_code'] !== "default_value") {
                $code = $attribute['magento_attribute_code'];
                /** @var \Magento\Eav\Model\Attribute $magentoAttribute */
                $magentoAttribute = $product->getResource()
                    ->getAttribute($code);
                if ($magentoAttribute && ($magentoAttribute->usesSource() ||
                        $magentoAttribute->getData('frontend_input') == 'select')
                ) {
                    $source = $magentoAttribute->getSource();
                    // For Magento 2.2.5 and below,the storeId is not set on loading product.
                    //$attr = $source->getAttribute();
                    //$attr->setStoreId($product->getStoreId());
                    //$source->setAttribute($attr);
                    $value = $source->getOptionText(
                        $product->getData($code)
                    );

                    if (is_object($value)) {
                        $value = $value->getText();
                    }
                } else {
                    $value = $product->getData($code);
                }
            }

            // Filtering html
            if (!empty($code) && in_array($code, self::WYSIWYG_TYPE)) {
                // <strong> replace to <b>
                $value = preg_replace("/<strong(.*?)>(.*?)<\/strong>/", "<b>$2</b>", $value);

                // Filtering other tags except 'b', 'br', 'p'
                $this->stripTags->setTagsAllowed(['b', 'br', 'p']);
                $this->stripTags->setAttributesAllowed([]);
                $value = $this->stripTags->filter($value);
            }

            // Adding units for dimensions. TODO: get from config
            $a = $mpProduct->getAttribute($id);
            if (isset($a['attribute']) && !empty($code)) {
                $subAttribute = $a['attribute'];
                if (in_array($code, ['ts_dimensions_length', 'ts_dimensions_width', 'ts_dimensions_height' ])) {
                    $mpProduct->$subAttribute = "inches";
                } elseif (in_array($code, ['packed_height', 'packed_width', 'packed_height', 'packed_depth' ])) {
                    $mpProduct->$subAttribute = "MM";
                } elseif (in_array($code, ['weight'])) {
                    $mpProduct->$subAttribute = "LB";
                }
            }

            // Using parent product values in case of configurable product. (skipping variation attributes)
            if (isset($parent) && empty($value) && !isset($variationList[$code])) {
                $value = $parent->get($id);
            }

            // Setting default value
            if ((isset($attribute['default_value']) && empty($value) && !empty($attribute['default_value'])) ||
                (isset($attribute['magento_attribute_code']) && $attribute['magento_attribute_code'] == 'default')) {
                $value = $attribute['default_value'];
            }

            // Merging bullets
            if (in_array($id, self::BULLET_POINTS) && !empty(trim((string)$value))) {
                $previous = $mpProduct->get('DescriptionData_BulletPoint');
                $value = isset($previous) ? $previous . "||" . trim((string)$value) : trim((string)$value);
                $mpProduct->DescriptionData_BulletPoint = $value;
            }

            // Merging search terms
            if (in_array($id, self::SEARCH_TERMS) && !empty(trim((string)$value))) {
                $previous = $mpProduct->get('DescriptionData_SearchTerms');
                $value = isset($previous) ? $previous . "||" . trim((string)$value) : trim((string)$value);
                $mpProduct->DescriptionData_SearchTerms = $value;
            }

            if (is_array($value)) {
                $value = implode(",", $value);
            }

            $mpProduct->$id = trim((string)$value);

            // Deleting variantion required attribute if its value is satisfied.
            if (isset($code, $value, $variationList[$code])) {
                $theme[$code][] = $attribute['name'];
                unset($variant[$code]);
            }

            if ($id == "StandardProductID_Value_ASIN") {
                $asin = $value;
            }
        }

        // Adding ASIN
        $barcodeIndex = "StandardProductID_Value";
        $typeIndex = "StandardProductID_Type";
        if (empty($mpProduct->get($barcodeIndex)) && !empty($asin)) {
            $mpProduct->$barcodeIndex = $asin;
        }

        // Sanitizing for Variation
        if ($type == self::PRODUCT_TYPE_PARENT) {
            $index = $mpProduct->getParentageAttribute();
            if (isset($index)) {
                $mpProduct->$index = self::PRODUCT_TYPE_PARENT;
            }
            // Removing barcode for parents
            unset($mpProduct->$barcodeIndex);
            unset($mpProduct->$typeIndex);
        } elseif ($type == self::PRODUCT_TYPE_CHILD) {
            $index = $mpProduct->getParentageAttribute();
            if (isset($index)) {
                $mpProduct->$index = self::PRODUCT_TYPE_CHILD;
            }
        }

        // Adding Variation Theme
        if (!empty($variant)) {
            $attributes = implode('|', $variant);
            $mpProduct->setError(
                "Variation_Attribute_Value",
                "{$attributes} attributes are not mapped in profile or have a invalid value.",
                1
            );
        } elseif (!empty($theme)) {
            // Extract and Set Variation Theme Basis of Variation Attributes Mapped.
            $this->extract($mpProduct, $theme);
        }

        return $mpProduct;
    }

    /**
     * Extract variation theme
     * @param \Amazon\Sdk\Product\ProductInterface $mpProduct
     * @param array $themeList,
     * [
     *      'magento_color' => ['Color', 'ColorMap'],
     *      'magento_size'  => ['Size']
     * ]
     */
    public function extract($mpProduct, $themeList)
    {
        // Setting Variation theme
        /** @var string $key */
        $key = $mpProduct->getVariationThemeAttribute();
        if (!empty($key) && empty($mpProduct->get($key))) {
            $themeIdentified = false;
            /** @var array $variationThemeAttribute */
            $variationThemeAttribute = $mpProduct->getAttribute($key);
            /** @var array $variationThemes */
            $variationThemes = isset($variationThemeAttribute['restriction']['optionValues']) ?
                $variationThemeAttribute['restriction']['optionValues'] : [];
            $themeList = $this->combinations(array_values($themeList));
            $theme = "";
            foreach ($themeList as $theme) {
                if (!is_array($theme)) {
                    // For Single Variation Attribute
                    $theme = [$theme];
                }

                $theme = array_unique($theme);
                $count = count($theme);
                $theme = implode('|', $theme);

                foreach ($variationThemes as $variationTheme) {
                    if (preg_match_all("({$theme})", $variationTheme) === $count) {
                        $mpProduct->$key = $variationTheme;
                        $themeIdentified = true;
                        break;
                    }
                }
            }

            if (!$themeIdentified) {
                $mpProduct->setError(
                    "Variation_Theme_Value",
                    "{$theme} unable to identify the variation theme.
                         Kindly specify the theme explicitly in profile attribute mapping.",
                    1
                );
            }
        }
    }

    /**
     * Generate cartesian product of an array
     * @param $arrays
     * @param int $i
     * @return array
     */
    private function combinations($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) {
            return [];
        }

        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = $this->combinations($arrays, $i + 1);

        $result = [];

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge([$v], $t) :
                    [$v, $t];
            }
        }

        return $result;
    }

    /**
     * TODO: use it.
     * @return \Amazon\Sdk\Envelope
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     * NOTE: SKU should not - (dash)
     * Get Product from Amazon.
     * @param null $id
     * @param null $sku
     * @param string $idType
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProduct($id = null, $sku = null, $idType = 'SellerSKU')
    {
        $result = [];
        /** @var \Ced\Amazon\Api\Data\ProfileSearchResultsInterface $profileList */
        $profileList = $this->profile->getByProductId($id);

        $i = 0;
        /** @var \Ced\Amazon\Api\Data\ProfileInterface $profile */
        foreach ($profileList->getItems() as $profile) {
            $productList = $this->productList->create(
                [
                    'config' => $this->account->getById($profile->getAccountId())
                        ->getConfig($profile->getMarketplaceIds()),
                    'logger' => $this->logger
                ]
            );

            foreach ($profile->getMarketplaceIds() as $marketplaceId) {
                $result[$i] = [
                    'profile_id' => $profile->getId(),
                    'profile_name' => $profile->getName(),
                    'store_id' => $profile->getStoreId(),
                    'account_id' => $profile->getAccountId(),
                    'product' => [
                        "Product data not available for SKU: {$sku}."
                    ]
                ];

                $productList->setIdType($idType);
                $productList->setProductIds($sku);
                //$productList->setIdType('ASIN');
                //$productList->setProductIds('B0736YGJGZ');
                $productList->setMarketplaceIds($marketplaceId);
                $productList->fetchProductList();
                $products = $productList->getProduct();
                if ($products != false && !isset($products['Error'])) {
                    /** @var \Amazon\Sdk\Api\Product $product */
                    foreach ($products as $product) {
                        $result[$i]['product'] = $product->getData();
                    }
                } elseif (isset($products['Error'])) {
                    $result[$i]['error'] = $products['Error'];
                }

                $i++;
            }
        }

        return $result;
    }

    /**
     * TODO: not used. update or set for removal
     * @param $product
     * @return \Magento\Framework\DataObject
     * @throws \Exception
     */
    private function parseProfile($product, $loadParent = true)
    {
        $data = $this->data->create();

        // 1.1: Getting Parents and loading parent profile and sending product as child.
        /**
         * @var  $productParents
         * @codingStandardsIgnoreStart
         */
        $productParents = $this->productConfigurable->create()->getParentIdsByChild($product->getId());
        /** @codingStandardsIgnoreEnd */
        if (!empty($productParents)) {
            /** @var \Ced\Amazon\Helper\Profile $profile */
            $profile = $this->profile->getProfile($productParents[0]);
            if (!empty($profile->getId()) and $loadParent == true) {
                // 1.1.1: Getting parent product and sending  as configurable
                /**
                 * @var  $product
                 * @codingStandardsIgnoreStart
                 */
                $product = $this->product->create()->load($productParents[0])
                    ->setStoreId($this->config->getStore());
                /** @codingStandardsIgnoreEnd */
            } else {
                // 1.1.2: Getting product profile id and sending as simple product.
                /** @var \Ced\Amazon\Helper\Profile $profile */
                $profile = $this->profile->getProfile(
                    $product->getId(),
                    $product->getData(\Ced\Amazon\Helper\Profile::ATTRIBUTE_CODE_PROFILE_ID)
                );
                if (empty($profile->getId())) {
                    $errors[$product->getSku()]['errors'] =
                        ['profile_missing' => 'Please assign product to a profile and try again.'];
                    $product->setData(
                        \Ced\Amazon\Helper\Product::ATTRIBUTE_CODE_VALIDATION_ERRORS,
                        $this->serializer->serialize($errors)
                    );
                }
            }
        } else {
            // 1.2: Getting product profile id and sending as simple product.
            /** @var \Ced\Amazon\Helper\Profile $profile */
            $profile = $this->profile->getProfile(
                $product->getId(),
                $product->getData(\Ced\Amazon\Helper\Profile::ATTRIBUTE_CODE_PROFILE_ID)
            );
            if (empty($profile->getId())) {
                $errors[$profile->getId()]['errors'] =
                    ['profile_missing' => 'Please assign product to a profile and try again.'];
                $product->setData(
                    \Ced\Amazon\Helper\Product::ATTRIBUTE_CODE_VALIDATION_ERRORS,
                    $this->serializer->serialize([$errors])
                );
            }
        }
        $data->setProfile($profile);
        $data->setProduct($product);
        return $data;
    }
}
