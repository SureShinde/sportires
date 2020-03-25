<?php

/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Model\Catalog;

use ITM\MagB1\Api\Catalog\ProductInterface;
use Magento\Catalog\Model\Product\Gallery\MimeTypeExtensionMap;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Api\Data\ImageContentInterfaceFactory;
use Magento\Framework\Api\ImageContentValidatorInterface;
use Magento\Framework\Api\ImageProcessorInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\CatalogInventory\Api\StockRegistryInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class Product extends \Magento\Catalog\Model\ProductRepository implements ProductInterface
{

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $serializer;

    /**
     * @var int
     */
    private $cacheLimit = 0;
    /**
     *
     * @var \Magento\Bundle\Model\ResourceModel\BundleFactory
     */
    private $bundleFactory;

    private $current_version;

    private $current_edition;

    protected $_itm_objectManager;

    /**
     * @var StockItemRepositoryInterface
     */
    protected $stockItemRepository;

    protected $stockConfiguration;

    protected $stockRegistryProvider;

    /**
     * @var EventManager
     */
    private $eventManager;

    protected $magb1Helper;



    /**
     * ProductRepository constructor.
     * @param ProductFactory $productFactory
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $initializationHelper
     * @param \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
     * @param ResourceModel\Product\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attributeRepository
     * @param ResourceModel\Product $resourceModel
     * @param Product\Initialization\Helper\ProductLinks $linkInitializer
     * @param Product\LinkTypeProvider $linkTypeProvider
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param Product\Option\Converter $optionConverter
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param ImageContentValidatorInterface $contentValidator
     * @param ImageContentInterfaceFactory $contentFactory
     * @param MimeTypeExtensionMap $mimeTypeExtensionMap
     * @param ImageProcessorInterface $imageProcessor
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param CollectionProcessorInterface $collectionProcessor [optional]
     * @param \Magento\Framework\Serialize\Serializer\Json|null $serializer
     * @param int $cacheLimit [optional]
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $initializationHelper,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attributeRepository,
        \Magento\Catalog\Model\ResourceModel\Product $resourceModel,
        \Magento\Catalog\Model\Product\Initialization\Helper\ProductLinks $linkInitializer,
        \Magento\Catalog\Model\Product\LinkTypeProvider $linkTypeProvider,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        \Magento\Catalog\Model\Product\Option\Converter $optionConverter,
        \Magento\Framework\Filesystem $fileSystem,
        ImageContentValidatorInterface $contentValidator,
        ImageContentInterfaceFactory $contentFactory,
        MimeTypeExtensionMap $mimeTypeExtensionMap,
        ImageProcessorInterface $imageProcessor,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor = null,
        \Magento\Framework\Serialize\Serializer\Json $serializer = null,
        // ITMD
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Bundle\Model\ResourceModel\BundleFactory $bundleFactory,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface $stockRegistryProvider,
        \Magento\CatalogInventory\Api\StockItemRepositoryInterface $stockItemRepository,
        \Magento\Framework\Event\Manager $eventManager,
        \ITM\MagB1\Helper\Data $magb1Helper,
        // END ITMD
        $cacheLimit = 1000)
    {
        $this->productFactory = $productFactory;
        $this->collectionFactory = $collectionFactory;
        $this->initializationHelper = $initializationHelper;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resourceModel = $resourceModel;
        $this->linkInitializer = $linkInitializer;
        $this->linkTypeProvider = $linkTypeProvider;
        $this->storeManager = $storeManager;
        $this->attributeRepository = $attributeRepository;
        $this->filterBuilder = $filterBuilder;
        $this->metadataService = $metadataServiceInterface;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->optionConverter = $optionConverter;
        $this->fileSystem = $fileSystem;
        $this->contentValidator = $contentValidator;
        $this->contentFactory = $contentFactory;
        $this->mimeTypeExtensionMap = $mimeTypeExtensionMap;
        $this->imageProcessor = $imageProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        // $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
        $this->serializer = $serializer ?: \Magento\Framework\App\ObjectManager::getInstance()->get(
            \Magento\Framework\Serialize\Serializer\Json::class);
        $this->cacheLimit = (int) $cacheLimit;

        // ITMD
        $this->bundleFactory = $bundleFactory;
        $this->stockConfiguration = $stockConfiguration;
        $this->stockRegistryProvider = $stockRegistryProvider;
        $this->stockItemRepository = $stockItemRepository;
        $this->_itm_objectManager = $objectManager;//\Magento\Framework\App\ObjectManager::getInstance();
        $this->current_version = $this->_itm_objectManager->get('\Magento\Framework\App\ProductMetadataInterface')->getVersion();
        $this->current_edition = $this->_itm_objectManager->get('\Magento\Framework\App\ProductMetadataInterface')->getEdition();
        $this->eventManager = $eventManager;
        $this->magb1Helper = $magb1Helper;
        // END ITMD
    }

    /**
     * Get key for cache
     *
     * @param array $data
     * @return string
     */
    protected function getCacheKey(
        $data)
    {
        $serializeData = [];
        foreach ($data as $key => $value)
        {
            if (is_object($value))
            {
                $serializeData[$key] = $value->getId();
            } else
            {
                $serializeData[$key] = $value;
            }
        }
        $serializeData = $this->serializer->serialize($serializeData);
        return sha1($serializeData);
    }

    /**
     * Add product to internal cache and truncate cache if it has more than cacheLimit elements.
     *
     * @param string $cacheKey
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return void
     */
    private function cacheProduct(
        $cacheKey,
        \Magento\Catalog\Api\Data\ProductInterface $product)
    {
        $this->instancesById[$product->getId()][$cacheKey] = $product;
        $this->instances[$product->getSku()][$cacheKey] = $product;

        if ($this->cacheLimit && count($this->instances) > $this->cacheLimit)
        {
            $offset = round($this->cacheLimit / - 2);
            $this->instancesById = array_slice($this->instancesById, $offset, null, true);
            $this->instances = array_slice($this->instances, $offset);
        }
    }

    /**
     *
     * {@inheritdoc} @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function saveProduct(
        \Magento\Catalog\Api\Data\ProductInterface $product,
        $store_id,
        $website_ids = [],
        $saveOptions = false)
    {
        $website_ids = array_unique($website_ids);



        if (version_compare($this->current_version, '2.3.0') >= 0){
            $final_product = $this->saveProduct_2_2($product, $store_id, $website_ids, $saveOptions);
        }else if (version_compare($this->current_version, '2.2.4') < 0)
        {
            $final_product = $this->saveProduct_2_2($product, $store_id, $website_ids, $saveOptions);
        } else
        {
            $final_product = $this->saveProduct_2_2_4($product, $store_id, $website_ids, $saveOptions);
        }

        if($this->magb1Helper->clearProductCache()) {
            $final_product->cleanCache();
            $this->eventManager->dispatch('clean_cache_by_tags', ['object' => $final_product]);
        }
        return $final_product; //->load($final_product->getId());
    }

    /**
     * @param int $productId
     * @param int $scopeId
     * @return \Magento\CatalogInventory\Api\Data\StockItemInterface
     */
    public function getStockItem(
        $productId,
        $scopeId = null)
    {
        $scopeId = $this->stockConfiguration->getDefaultScopeId();
        return $this->stockRegistryProvider->getStockItem($productId, $scopeId);
    }

    /**
     * @inheritdoc
     */
    public function updateStockItemBySku(
        $productId,
        \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem)
    {
        $websiteId = $stockItem->getWebsiteId() ?: null;

        $origStockItem = $this->getStockItem($productId, $websiteId);
        $data = $stockItem->getData();
        if ($origStockItem->getItemId())
        {
            unset($data['item_id']);
        }

        $origStockItem->addData($data);
        $origStockItem->setProductId($productId);
        return $this->stockItemRepository->save($origStockItem)->getItemId();
    }

    /**
     *
     * {@inheritdoc} @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    private function saveProduct_2_2_4(
        \Magento\Catalog\Api\Data\ProductInterface $product,
        $store_id,
        $website_ids = [],
        $saveOptions = false)
    {
        $store_id = (int) $store_id;
        $tierPrices = $product->getData('tier_price');

        try
        {
            //$existingProduct = $product->getId() ? $this->getById($product->getId()) : $this->get($product->getSku());
            $existingProduct = $this->get($product->getSku());
            $all_media = [];

            if(count($product->getMediaGalleryEntries())>0) {
                foreach ($product->getMediaGalleryEntries() as $entry)
                {
                    $all_media[] = $entry;
                }
            }
            if(count($existingProduct->getMediaGalleryEntries())>0) {
                foreach ($existingProduct->getMediaGalleryEntries() as $entry)
                {
                    $all_media[] = $entry;
                }
            }
            if(count($all_media)>0) {
                $product->setMediaGallery(null);
                $product->setMediaGalleryEntries($all_media);
            }
            $product->setData($this->resourceModel->getLinkField(),
                $existingProduct->getData($this->resourceModel->getLinkField()));
            if (! $product->hasData(\Magento\Catalog\Model\Product::STATUS))
            {
                $product->setStatus($existingProduct->getStatus());
            }
        } catch (NoSuchEntityException $e)
        {
            $existingProduct = null;
        }

        $productDataArray = $this->extensibleDataObjectConverter->toNestedArray($product, [],
            \Magento\Catalog\Api\Data\ProductInterface::class);
        $productDataArray = array_replace($productDataArray, $product->getData());
        $ignoreLinksFlag = $product->getData('ignore_links_flag');
        $productLinks = null;
        if (! $ignoreLinksFlag && $ignoreLinksFlag !== null)
        {
            $productLinks = $product->getProductLinks();
        }
        // Start WH
        $productDataArray['store_id'] = $store_id;

        //if(count($website_ids) > 0) {
        $productDataArray['website_ids'] = $website_ids;
        //}
        // End WH
        $product = $this->initializeProductData($productDataArray, empty($existingProduct));

        $this->processLinks($product, $productLinks);

        $this->processLinks($product, $productLinks);
        if (isset($productDataArray['media_gallery_entries']))
        {
            $this->getMediaGalleryProcessor()->processMediaGallery($product, $productDataArray['media_gallery_entries']);
        }

        // Start WH
        /*
         * if (isset($productDataArray['media_gallery_entries'])) {
         * $image_array = [];
         * foreach ($productDataArray['media_gallery_entries'] as $image_item) {
         * $image_item["content"]["data"] = $image_item["content"];
         * $image_array[] = $image_item;
         * }
         * $this->processMediaGallery($product, $image_array);
         * }
         */
        // End WH

        if (! $product->getOptionsReadonly())
        {
            $product->setCanSaveCustomOptions(true);
        }

        $validationResult = $this->resourceModel->validate($product);
        if (true !== $validationResult)
        {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Invalid product data: %1', implode(',', $validationResult)));
        }

        try
        {
            if ($tierPrices !== null)
            {
                $product->setData('tier_price', $tierPrices);
            }
            unset($this->instances[$product->getSku()]);
            unset($this->instancesById[$product->getId()]);
            // Start WH
            //if(count($website_ids) > 0) {
            $product->setWebsiteIds($website_ids);
            //}
            // End WH
            $this->resourceModel->save($product);
        } catch (ConnectionException $exception)
        {
            throw new \Magento\Framework\Exception\TemporaryState\CouldNotSaveException(__('Database connection error'),
                $exception, $exception->getCode());
        } catch (DeadlockException $exception)
        {
            throw new \Magento\Framework\Exception\TemporaryState\CouldNotSaveException(
                __('Database deadlock found when trying to get lock'), $exception, $exception->getCode());
        } catch (LockWaitException $exception)
        {
            throw new \Magento\Framework\Exception\TemporaryState\CouldNotSaveException(
                __('Database lock wait timeout exceeded'), $exception, $exception->getCode());
        } catch (\Magento\Eav\Model\Entity\Attribute\Exception $exception)
        {
            throw \Magento\Framework\Exception\InputException::invalidFieldValue($exception->getAttributeCode(),
                $product->getData($exception->getAttributeCode()), $exception);
        } catch (ValidatorException $e)
        {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (LocalizedException $e)
        {
            throw $e;
        } catch (\Exception $e)
        {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__(__('Unable to save product')." - ".$e->getMessage()), $e);
            //throw new \Magento\Framework\Exception\CouldNotSaveException(__('Unable to save product'), $e);
        }
        unset($this->instances[$product->getSku()]);
        unset($this->instancesById[$product->getId()]);
        return $this->get($product->getSku(), false, $product->getStoreId());
    }

    /**
     * @return ProductRepository\MediaGalleryProcessor
     */
    private function getMediaGalleryProcessor()
    {
        if (null === $this->mediaGalleryProcessor)
        {
            $this->mediaGalleryProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Catalog\Model\ProductRepository\MediaGalleryProcessor::class);
        }
        return $this->mediaGalleryProcessor;
    }

    /**
     *
     * {@inheritdoc} @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    private function saveProduct_2_2(
        \Magento\Catalog\Api\Data\ProductInterface $product,
        $store_id,
        $website_ids = [],
        $saveOptions = false)
    {
        $store_id = (int) $store_id;
        $tierPrices = $product->getData('tier_price');

        try
        {
            $existingProduct = $this->get($product->getSku());

            $all_media = [];
            if (!empty($product->getMediaGalleryEntries())) {
                foreach ($product->getMediaGalleryEntries() as $entry)
                {
                    $all_media[] = $entry;
                }
            }
            if (!empty($existingProduct->getMediaGalleryEntries())) {
                foreach ($existingProduct->getMediaGalleryEntries() as $entry) {
                    $all_media[] = $entry;
                }
            }

            $product->setMediaGallery(null);
            $product->setMediaGalleryEntries($all_media);

            $product->setData($this->resourceModel->getLinkField(),
                $existingProduct->getData($this->resourceModel->getLinkField()));
            if (! $product->hasData(\Magento\Catalog\Model\Product::STATUS))
            {
                $product->setStatus($existingProduct->getStatus());
            }
        } catch (NoSuchEntityException $e)
        {
            $existingProduct = null;
        }

        $productDataArray = $this->extensibleDataObjectConverter->toNestedArray($product, [],
            \Magento\Catalog\Api\Data\ProductInterface::class);
        $productDataArray = array_replace($productDataArray, $product->getData());
        $ignoreLinksFlag = $product->getData('ignore_links_flag');
        $productLinks = null;
        if (! $ignoreLinksFlag && $ignoreLinksFlag !== null)
        {
            $productLinks = $product->getProductLinks();
        }

        // Start WH
        $productDataArray['store_id'] = $store_id;

        //if(count($website_ids) > 0) {
        $productDataArray['website_ids'] = $website_ids;
        //}
        // End WH
        $product = $this->initializeProductData($productDataArray, empty($existingProduct));

        $this->processLinks($product, $productLinks);

        if (isset($productDataArray['media_gallery']))
        {
            $this->processMediaGallery($product, $productDataArray['media_gallery']['images']);
        }

        // Start WH
        /*
         * if (isset($productDataArray['media_gallery_entries'])) {
         * $image_array = [];
         * foreach ($productDataArray['media_gallery_entries'] as $image_item) {
         * $image_item["content"]["data"] = $image_item["content"];
         * $image_array[] = $image_item;
         * }
         * $this->processMediaGallery($product, $image_array);
         * }
         */
        // End WH

        if (! $product->getOptionsReadonly())
        {
            $product->setCanSaveCustomOptions(true);
        }

        $validationResult = $this->resourceModel->validate($product);
        if (true !== $validationResult)
        {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Invalid product data: %1', implode(',', $validationResult)));
        }

        try
        {
            if ($tierPrices !== null)
            {
                $product->setData('tier_price', $tierPrices);
            }
            unset($this->instances[$product->getSku()]);
            unset($this->instancesById[$product->getId()]);
            // Start WH
            //if(count($website_ids) > 0) {
            $product->setWebsiteIds($website_ids);
            //}
            // End WH
            $this->resourceModel->save($product);
        } catch (ConnectionException $exception)
        {
            throw new \Magento\Framework\Exception\TemporaryState\CouldNotSaveException(__('Database connection error'),
                $exception, $exception->getCode());
        } catch (DeadlockException $exception)
        {
            throw new \Magento\Framework\Exception\TemporaryState\CouldNotSaveException(
                __('Database deadlock found when trying to get lock'), $exception, $exception->getCode());
        } catch (LockWaitException $exception)
        {
            throw new \Magento\Framework\Exception\TemporaryState\CouldNotSaveException(
                __('Database lock wait timeout exceeded'), $exception, $exception->getCode());
        } catch (\Magento\Eav\Model\Entity\Attribute\Exception $exception)
        {
            throw \Magento\Framework\Exception\InputException::invalidFieldValue($exception->getAttributeCode(),
                $product->getData($exception->getAttributeCode()), $exception);
        } catch (ValidatorException $e)
        {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (LocalizedException $e)
        {
            throw $e;
        } catch (\Exception $e)
        {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__(__('Unable to save product')." - ".$e->getMessage()), $e);
            //throw new \Magento\Framework\Exception\CouldNotSaveException(__('Unable to save product'), $e);
        }
        unset($this->instances[$product->getSku()]);
        unset($this->instancesById[$product->getId()]);
        return $this->get($product->getSku(), false, $product->getStoreId());
    }

    /**
     * Process product options, creating new options, updating and deleting existing options
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @param array $newOptions
     * @return $this
     * @throws NoSuchEntityException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function processOptions(
        \Magento\Catalog\Api\Data\ProductInterface $product,
        $newOptions)
    {
        //existing options by option_id
        /** @var \Magento\Catalog\Api\Data\ProductCustomOptionInterface[] $existingOptions */
        $existingOptions = $product->getOptions();
        if ($existingOptions === null)
        {
            $existingOptions = [];
        }

        $newOptionIds = [];
        foreach ($newOptions as $key => $option)
        {
            if (isset($option['option_id']))
            {
                //updating existing option
                $optionId = $option['option_id'];
                if (! isset($existingOptions[$optionId]))
                {
                    throw new NoSuchEntityException(__('Product option with id %1 does not exist', $optionId));
                }
                $existingOption = $existingOptions[$optionId];
                $newOptionIds[] = $option['option_id'];
                if (isset($option['values']))
                {
                    //updating option values
                    $optionValues = $option['values'];
                    $valueIds = [];
                    foreach ($optionValues as $optionValue)
                    {
                        if (isset($optionValue['option_type_id']))
                        {
                            $valueIds[] = $optionValue['option_type_id'];
                        }
                    }
                    $originalValues = $existingOption->getValues();
                    foreach ($originalValues as $originalValue)
                    {
                        if (! in_array($originalValue->getOptionTypeId(), $valueIds))
                        {
                            $originalValue->setData('is_delete', 1);
                            $optionValues[] = $originalValue->getData();
                        }
                    }
                    $newOptions[$key]['values'] = $optionValues;
                } else
                {
                    $existingOptionData = $this->optionConverter->toArray($existingOption);
                    if (isset($existingOptionData['values']))
                    {
                        $newOptions[$key]['values'] = $existingOptionData['values'];
                    }
                }
            }
        }

        $optionIdsToDelete = array_diff(array_keys($existingOptions), $newOptionIds);
        foreach ($optionIdsToDelete as $optionId)
        {
            $optionToDelete = $existingOptions[$optionId];
            $optionDataArray = $this->optionConverter->toArray($optionToDelete);
            $optionDataArray['is_delete'] = 1;
            $newOptions[] = $optionDataArray;
        }
        $product->setProductOptions($newOptions);
        return $this;
    }

    /**
     * Process product links, creating new links, updating and deleting existing links
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @param \Magento\Catalog\Api\Data\ProductLinkInterface[] $newLinks
     * @return $this
     * @throws NoSuchEntityException
     */
    private function processLinks(
        \Magento\Catalog\Api\Data\ProductInterface $product,
        $newLinks)
    {
        if ($newLinks === null)
        {
            // If product links were not specified, don't do anything
            return $this;
        }

        // Clear all existing product links and then set the ones we want
        $linkTypes = $this->linkTypeProvider->getLinkTypes();
        foreach (array_keys($linkTypes) as $typeName)
        {
            $this->linkInitializer->initializeLinks($product, [
                $typeName => []
            ]);
        }

        // Set each linktype info
        if (! empty($newLinks))
        {
            $productLinks = [];
            foreach ($newLinks as $link)
            {
                $productLinks[$link->getLinkType()][] = $link;
            }

            foreach ($productLinks as $type => $linksByType)
            {
                $assignedSkuList = [];
                /** @var \Magento\Catalog\Api\Data\ProductLinkInterface $link */
                foreach ($linksByType as $link)
                {
                    $assignedSkuList[] = $link->getLinkedProductSku();
                }
                $linkedProductIds = $this->resourceModel->getProductsIdsBySkus($assignedSkuList);

                $linksToInitialize = [];
                foreach ($linksByType as $link)
                {
                    $linkDataArray = $this->extensibleDataObjectConverter->toNestedArray($link, [],
                        'Magento\Catalog\Api\Data\ProductLinkInterface');
                    $linkedSku = $link->getLinkedProductSku();
                    if (! isset($linkedProductIds[$linkedSku]))
                    {
                        throw new NoSuchEntityException(__('Product with SKU "%1" does not exist', $linkedSku));
                    }
                    $linkDataArray['product_id'] = $linkedProductIds[$linkedSku];
                    $linksToInitialize[$linkedProductIds[$linkedSku]] = $linkDataArray;
                }

                $this->linkInitializer->initializeLinks($product,
                    [
                        $type => $linksToInitialize
                    ]);
            }
        }

        $product->setProductLinks($newLinks);
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getProductList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        $store_id)
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->extensionAttributesJoinProcessor->process($collection);

        foreach ($this->metadataService->getList($this->searchCriteriaBuilder->create())
                     ->getItems() as $metadata)
        {
            $collection->addAttributeToSelect($metadata->getAttributeCode());
        }

        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');

        /*
         * $collection->joinTable('catalog_category_product',
         * 'product_id=entity_id', array('category_id' => 'category_id'),
         * null, 'left')
         * ->groupByAttribute('entity_id')
         * ->getSelect()->columns(array('category_id' => new \Zend_Db_Expr("IFNULL(GROUP_CONCAT(`catalog_category_product`.`category_id` SEPARATOR ', '), '')")));
         * ;
         */

        // Add filters from root filter group to the collection
        foreach ($searchCriteria->getFilterGroups() as $group)
        {
            $this->addFilterGroupToCollection($group, $collection);
        }
        /** @var SortOrder $sortOrder */
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder)
        {
            $field = $sortOrder->getField();
            $collection->addOrder($field, ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->addStoreFilter($store_id);

        $collection->load();

        // Ignored
        /*
         * foreach ($collection as $product) {
         * $product->load($product->getId());
         * }
         */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }

    private function getImageAttributes()
    {
        $objectManager = $this->_itm_objectManager;
        $collection = $objectManager->create(\Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection::class);
        $collection->addFieldToFilter("frontend_input", array(
            "eq" => "media_image"
        ));

        $collection->getSelect()
            ->reset(\Magento\Framework\DB\Select::COLUMNS)
            ->columns('attribute_code')
            ->columns('attribute_id');
        return $collection->getData();
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function deleteProductImages($key,  $useid = false)
    {
        $objectManager = $this->_itm_objectManager;
        $productId = $key;
        if($useid == false) {
            $productId = $this->resourceModel->getIdBySku($key);
        }else {
            $product = $this->getById($productId);
        }
        if ($productId > 0)
        {
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
        } else
        {
            return;
        }

        //$productRepository = $objectManager->create('Magento\Catalog\Api\ProductRepositoryInterface');
        //$magb1_helper = $objectManager->create('ITM\MagB1\Helper\Data');
        $existingMediaGalleryEntries = $product->getMediaGalleryEntries();

        $media = [];
        $files = [];
        foreach ($existingMediaGalleryEntries as $key => $entry)
        {
            if ($entry->getMediaType() != "image")
            {
                continue;
            }
            $media[] = $entry->getId();
            $files[] = $entry->getFile();
            // $types[] = $entry->getMediaType();
        }

        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);

        //return print_r($types,true);
        if (count($media) > 0)
        {
            $media_implode = implode($media, ",");
            // query products
            $select = $connection->delete($resource->getTableName('catalog_product_entity_media_gallery'),
                "value_id in ($media_implode)");
            foreach ($files as $file)
            {
                $file_path = $this->magb1Helper->getMediaPath() . $file;

                if (file_exists($file_path))
                {
                    unlink($file_path);
                }
            }
        }

        $img_attributes = $this->getImageAttributes();
        $att_ids = implode(', ',
            array_map(function (
                $entry) {
                return $entry['attribute_id'];
            }, $img_attributes));

        if ($this->current_edition == "Community")
        {
            $select = $connection->delete($resource->getTableName('catalog_product_entity_varchar'),
                "attribute_id in ($att_ids) and entity_id= $productId");
        } else
        {
            $select = $connection->delete($resource->getTableName('catalog_product_entity_varchar'),
                "attribute_id in ($att_ids) and row_id= $productId");
        }

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function deleteBundleOptionById(
        $sku,
        $optionId)
    {
        try
        {
            $store_id = $this->storeManager->getStore()->getId();
            $objectManager = $this->_itm_objectManager;

            $productId = $this->resourceModel->getIdBySku($sku);
            $product = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);

            $options = $objectManager->get('Magento\Bundle\Model\Option')
                ->getResourceCollection()
                ->setProductIdFilter($productId)
                ->setIdFilter($optionId)
                ->setPositionOrder();

            $options->joinValues($store_id);

            $options->setCurPage(1);
            $options->setPageSize(1);

            $option = $options->getFirstItem();

            $typeInstance = $objectManager->get('Magento\Bundle\Model\Product\Type');
            $selections = $typeInstance->getSelectionsCollection($typeInstance->getOptionsIds($product), $product);

            $nonUsedProductIds = [];
            $excludeSelectionIds = [];

            foreach ($selections as $selection)
            {
                if (($selection->getOptionId() == $optionId))
                {
                    $nonUsedProductIds[] = $selection->getProductId();
                    $excludeSelectionIds[] = $selection->getSelectionId();
                }
            }

            $resource = $this->bundleFactory->create();
            $resource->dropAllUnneededSelections($product->getId(), $excludeSelectionIds);
            $resource->removeProductRelations($product->getId(), array_unique($nonUsedProductIds));

            $option->delete();

            return true;
        } catch (\Exception $exception)
        {
            throw new \Magento\Framework\Exception\StateException(
                __('Cannot delete option with id %1', $option->getOptionId()), $exception);
        }
        return false;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function deleteBundleOptions(
        $sku)
    {
        try
        {
            $store_id = $this->storeManager->getStore()->getId();
            $objectManager = $this->_itm_objectManager;

            $productId = $this->resourceModel->getIdBySku($sku);
            $product = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);

            $options = $objectManager->get('Magento\Bundle\Model\Option')
                ->getResourceCollection()
                ->setProductIdFilter($productId)
                ->setPositionOrder();

            $options->joinValues($store_id);

            $typeInstance = $objectManager->get('Magento\Bundle\Model\Product\Type');
            $selections = $typeInstance->getSelectionsCollection($typeInstance->getOptionsIds($product), $product);

            $nonUsedProductIds = [];
            $excludeSelectionIds = [];

            foreach ($selections as $selection)
            {
                $nonUsedProductIds[] = $selection->getProductId();
                $excludeSelectionIds[] = $selection->getSelectionId();
            }

            $resource = $this->bundleFactory->create();
            $resource->dropAllUnneededSelections($product->getId(), $excludeSelectionIds);
            $resource->removeProductRelations($product->getId(), array_unique($nonUsedProductIds));
            foreach ($options as $option)
            {
                $option->delete();
            }

            return true;
        } catch (\Exception $exception)
        {
            throw new \Magento\Framework\Exception\StateException(__('Cannot delete options with id %1', $productId),
                $exception);
        }
        return false;
    }

    private function checkValues(
        $current_option,
        $new_option)
    {

        // value changed if the values are not the same count
        if (count($current_option->getValues()) != count($new_option->getValues()))
        {
            return true;
        } else
        {
            $current_skus = [];
            $current_titles = [];
            $current_prices = [];
            foreach ($current_option->getValues() as $value)
            {
                $current_skus[] = $value->getSku();
                $current_titles[] = $value->getTitle();
                $current_prices[] = $value->getPrice();
            }
            $new_option_skus = [];
            $new_option_titles = [];
            $new_option_prices = [];
            foreach ($new_option->getValues() as $value)
            {
                $new_option_skus[] = $value->getSku();
                $new_option_titles[] = $value->getTitle();
                $new_option_prices[] = $value->getPrice();
            }
        }

        if (count(array_diff($current_skus, $new_option_skus)))
        {
            return true;
        }
        if (count(array_diff($current_titles, $new_option_titles)))
        {
            return true;
        }
        if (count(array_diff($current_prices, $new_option_prices)))
        {
            return true;
        }
        return false;
        ;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function saveOptions(
        $sku,
        $options)
    {
        $objectManager = $this->_itm_objectManager;
        $existingProduct = $this->get($sku);
        $current_options = $existingProduct->getOptions();

        $final_options = [];
        // Delete Non Exist Option
        foreach ($options as $option)
        {
            $option_found = false;
            foreach ($current_options as $current_option)
            {
                if ($current_option->getTitle() == $option->getTitle())
                {
                    $option_found = true;
                    // check if the value of this option is not the same
                    $value_changed = $this->checkValues($current_option, $option);
                    if ($value_changed == true)
                    {
                        $final_options[] = $option;
                    } else
                    {
                        $final_options[] = $current_option;
                    }
                    break;
                }
            }
            if (! $option_found)
            {
                $final_options[] = $option;
            }
        }

        foreach ($final_options as $option)
        {
            if ($option->getOptionId() == 0)
            {
                $option->setOptionId(null);
            }
            if (($option->getValues()) > 0)
            {
                foreach ($option->getValues() as $value)
                {
                    if ($value["option_type_id"] == 0)
                    {
                        unset($value["option_type_id"]);
                    }
                }
            }
        }

        //  return $final_options;

        $existingProduct->setCanSaveCustomOptions(true);
        $existingProduct->setOptions($final_options);
        $this->resourceModel->save($existingProduct);
        //////////////////////////////
        return $existingProduct->getOptions();
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function saveOptions_old(
        $sku,
        $options)
    {
        $objectManager = $this->_itm_objectManager;

        $existingProduct = $this->get($sku);
        $current_options = $existingProduct->getOptions();

        /////////////////////
        $customOptions = [];
        foreach ($options as $option)
        {
            $customOption = $this->_itm_objectManager->create('Magento\Catalog\Api\Data\ProductCustomOptionInterface');
            $customOption->setTitle($option->getTitle())
                ->setType($option->getType())
                ->setIsRequire($option->getIsRequire())
                ->setSortOrder($option->getSortOrder())
                ->setPrice($option->getPrice())
                ->setPriceType($option->getPriceType())
                ->setProductSku($option->getProductSku());

            $oCurrent_option = $this->_itm_objectManager->create(
                'Magento\Catalog\Api\Data\ProductCustomOptionInterface');
            foreach ($current_options as $current_option)
            {
                if ($current_option->getTitle() == $option->getTitle())
                {
                    $oCurrent_option = $current_option; //
                    break;
                }
            }
            if ($oCurrent_option->getOptionId() > 0)
            {
                $customOption->setOptionId($oCurrent_option->getOptionId());
            }

            $values = [];
            foreach ($option->getValues() as $option_values)
            {
                $item_value["title"] = $option_values->getTitle();
                $item_value['price'] = $option_values->getPrice();
                $item_value['price_type'] = $option_values->getPriceType();
                $item_value['sku'] = $option_values->getSku();
                $item_value['sort_order'] = $option_values->getSortOrder();
                if ($oCurrent_option->getOptionId() > 0)
                {
                    foreach ($oCurrent_option->getValues() as $current_option_values)
                    {
                        if ($current_option_values->getSku() == $option_values->getSku())
                        {
                            $item_value['option_type_id'] = $current_option_values->getOptionTypeId();
                            break;
                        }
                    }
                }

                $values[] = $item_value;
            }
            $customOption->setValues($values);
            $customOptions[] = $customOption;
        }

        $existingProduct->setCanSaveCustomOptions(true);
        $existingProduct->setOptions($customOptions);
        $this->resourceModel->save($existingProduct);
        //////////////////////////////
        return $existingProduct->getOptions();
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getProductListCount(
        $store_id)
    {

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->extensionAttributesJoinProcessor->process($collection);

        $collection->addStoreFilter($store_id);
        // $collection->load();

        return $collection->getSize();
    }

    public function getSkuList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        $store_id,
        $method = "s")
    {
        if (strtolower($method) == "c")
        {
            return $this->getSkuListCollection($searchCriteria, $store_id);
        } else
        {
            return $this->getSkuListSql($searchCriteria, $store_id);
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    private function getSkuListSql(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        $store_id)
    {
        $objectManager = $this->_itm_objectManager;

        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);

        // query products
        $select = $connection->select()->from([
            'entity' => $resource->getTableName('catalog_product_entity')
        ], [
            'entity_id as id',
            'sku'
        ]);
        $cur_page = $searchCriteria->getCurrentPage() - 1;
        $page_size = $searchCriteria->getPageSize();

        if ($cur_page >= 0)
        {
            $select->limit($page_size, $cur_page);
        }

        $result = $connection->fetchAll($select);

        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($result);
        $searchResult->setTotalCount(count($result));

        return $searchResult;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    private function getSkuListCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        $store_id)
    {
        $collection = $this->collectionFactory->create();
        $this->extensionAttributesJoinProcessor->process($collection);

        $collection->addStoreFilter($store_id);

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        $collection->getSelect()
            ->reset(\Magento\Framework\DB\Select::COLUMNS)
            ->columns([
                'entity_id as id',
                'sku'
            ]);
        $collection->load();
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
    public function deleteProductById($id){
        $product = $this->getById($id);
        $this->delete($product);
        return true;
    }
}
