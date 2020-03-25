<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Mpa\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Indexer\IndexerRegistry;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ProductFactory;
/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MassStock extends \Magento\Catalog\Controller\Adminhtml\Product
{
    /**
     * @var \Magento\Catalog\Model\Indexer\Product\Price\Processor
     */
    protected $_productPriceIndexerProcessor;

    /**
     * MassActions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;


    /**
     * @var ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    protected $_stockRegistry;

    /**
     * @var IndexerRegistry
     */
    protected $_indexerRegistry;

    /**
     * MassStock constructor.
     * @param Action\Context $context
     * @param Product\Builder $productBuilder
     * @param \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ProductFactory $productFactory
     * @param \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
     * @param IndexerRegistry $indexerRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Product\Builder $productBuilder,
        \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ProductFactory $productFactory,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        IndexerRegistry $indexerRegistry
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_productPriceIndexerProcessor = $productPriceIndexerProcessor;
        $this->_productFactory = $productFactory;
        $this->_stockRegistry = $stockRegistry;
        $this->_indexerRegistry = $indexerRegistry;
        parent::__construct($context, $productBuilder);
    }


    /**
     * Update product(s) status action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $productIds = $collection->getAllIds();
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        $filters = (array)$this->getRequest()->getParam('filters', []);
        $params =  $this->getRequest()->getParams();
        if (isset($filters['store_id'])) {
            $storeId = (int)$filters['store_id'];
        }

        try {
            $quantity = $params['quantity'];
            $stockStatus = $params['stock_status'];
            $manageStock = $params['manage_stock'];
            $threshold = $params['stock_threshold'];
            $useConfigSettingsForThreshold = $params['use_config_settings_for_threshold'];
            $count  = 0;
            if ($productIds && count($productIds) > 0) {
                foreach ($collection as $product) {
                    $productId = $product->getId();
                    $stockItem = $this->_stockRegistry->getStockItem($productId, $storeId);
                    if ($quantity != "") {
                        $stockItem->setQty($quantity);
                    }

                    if ($stockStatus != "") {
                        $stockItem->setIsInStock((bool)$stockStatus);
                    }

                    if ($manageStock != "") {
                        if ($manageStock == 2) {
                            $stockItem->setUseConfigManageStock(true);
                        } else {
                            $stockItem->setManageStock((bool)$manageStock);
                            $stockItem->setUseConfigManageStock(false);
                        }
                    }
                    if ($threshold != "") {
                        $stockItem->setMinQty($threshold);
                    }
                    if ($useConfigSettingsForThreshold != ""  && !$useConfigSettingsForThreshold) {
                        $stockItem->setUseConfigMinQty((bool)$useConfigSettingsForThreshold);
                    }
                    try {
                        $this->_stockRegistry->updateStockItemBySku($product->getSku(), $stockItem);
                        $count++;
                    } catch (\Exception $e) {
                        $this->messageManager->addErrorMessage("Product ID {$productId}: " . $e->getMessage());
                    }
                }
            }
            if ($count > 0) {
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', $count));
            }

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('catalog/*/', ['store' => $storeId]);
    }


}
