<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Mpa\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Indexer\IndexerRegistry;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\CategoryLinkRepository;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MassCategory extends \Magento\Catalog\Controller\Adminhtml\Product
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
     * @var CategoryLinkManagementInterface
     */
    protected $_categoryLinkManagement;

    /**
     * @var CategoryLinkRepository
     */
    protected $_categoryLinkRepository;

    /**
     * @var IndexerRegistry
     */
    protected $_indexerRegistry;

    /**
     * MassCategory constructor.
     * @param Action\Context $context
     * @param Product\Builder $productBuilder
     * @param \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ProductFactory $productFactory
     * @param CategoryLinkManagementInterface $categoryLinkManagement
     * @param CategoryLinkRepository $categoryLinkRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Product\Builder $productBuilder,
        \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ProductFactory $productFactory,
        CategoryLinkManagementInterface $categoryLinkManagement,
        CategoryLinkRepository $categoryLinkRepository,
        IndexerRegistry $indexerRegistry
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_productPriceIndexerProcessor = $productPriceIndexerProcessor;
        $this->_productFactory = $productFactory;
        $this->_categoryLinkManagement = $categoryLinkManagement;
        $this->_categoryLinkRepository = $categoryLinkRepository;
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
          /*  $this->_validateMassStatus($productIds, $status);
            $this->_objectManager->get(\Magento\Catalog\Model\Product\Action::class)
                ->updateAttributes($productIds, ['status' => $status], $storeId); **/

            $this->assignCategories($collection, $productIds, $params);
            $this->removeCategories($productIds, $params);
            $this->replaceCategory($productIds, $params);
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', count($productIds)));
            $categoryIndexer = $this->_indexerRegistry->get(\Magento\Catalog\Model\Indexer\Product\Category::INDEXER_ID);
            if (!$categoryIndexer->isScheduled()) {
                $categoryIndexer->reindexList(array_unique($productIds));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('catalog/*/', ['store' => $storeId]);
    }

    /**
     * @param $collection
     * @param $productIds
     * @param $params
     * @return bool
     */
    public function assignCategories($collection, $productIds, $params)
    {
        try {
            if ($productIds && count($productIds) > 0) {
                $categoriesString = $params['assign_categories'];
                if ($categoriesString != "") {
                    $categoriesIds = explode(',', $categoriesString);
                    foreach ($collection as $product) {
                        $currentProductCategoryIds = $product->getCategoryIds();
                        $mergeCategoryIds = array_merge($categoriesIds, $currentProductCategoryIds);
                        if (count(array_diff($categoriesIds, $currentProductCategoryIds)) == 0) {
                            continue;
                        }
                        $this->_categoryLinkManagement->assignProductToCategories($product->getSku(), $mergeCategoryIds);
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @param $productIds
     * @param $params
     * @return bool
     */
    public function removeCategories($productIds, $params)
    {
        $connection  = $this->_productFactory->create()->getResource()->getConnection();
        $categoryProductTable =  $connection->getTableName('catalog_category_product');
        try {
            if ($productIds && count($productIds) > 0) {
                $productIdsString = implode(",", $productIds);
                $categoriesString = $params['remove_categories'];
                if ($categoriesString != "") {
                    $query = "delete from "
                        . $categoryProductTable
                        . " where category_id in ({$categoriesString}) "
                        . " and product_id in ({$productIdsString}) ";

                    $connection->query($query);

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return false;
        }

    }

    /**
     * @param $productIds
     * @param $params
     * @return bool
     */
    public function replaceCategory($productIds, $params)
    {
        $connection  = $this->_productFactory->create()->getResource()->getConnection();
        $categoryProductTable =  $connection->getTableName('catalog_category_product');
        try {
            if ($productIds && count($productIds) > 0) {
                $productIdsString = implode(",", $productIds);
                $currentCategory = $params['current_category'];
                $newCategory = $params['new_category'];
                if ($currentCategory && $newCategory) {
                    $query = "update {$categoryProductTable} set category_id = {$newCategory}"
                        . " where product_id in ({$productIdsString}) and category_id = {$currentCategory}";

                    $connection->query($query);

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return false;
        }
    }
}
