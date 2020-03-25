<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
namespace Yosto\Mpa\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ProductFactory;


/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MassCustomOptions extends \Magento\Catalog\Controller\Adminhtml\Product
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
     *
     */

    protected $_productFactory;

    /**
     * MassPrice constructor.
     * @param Action\Context $context
     * @param Product\Builder $productBuilder
     * @param \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ProductFactory $productFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Product\Builder $productBuilder,
        \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ProductFactory $productFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_productPriceIndexerProcessor = $productPriceIndexerProcessor;
        $this->_productFactory = $productFactory;
        parent::__construct($context, $productBuilder);
    }


    /**
     * Update product(s) status action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create()->addAttributeToSelect('price'));
        $productIds = $collection->getAllIds();
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        $filters = (array)$this->getRequest()->getParam('filters', []);
        $params = $this->getRequest()->getParams();
        if (isset($filters['store_id'])) {
            $storeId = (int)$filters['store_id'];
        }

        try {
            $this->copyCustomOptions($productIds, $params);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('catalog/*/', ['store' => $storeId]);
    }

    public function copyCustomOptions($productIds, $params)
    {
        $copyFromProductIds = $params['copy_custom_options'];
        /**
         * @var $productRepo \Magento\Catalog\Model\ProductRepository
         */
        $productRepo = $this->_objectManager->create(\Magento\Catalog\Api\ProductRepositoryInterface::class);
        $dataPersistor = $this->_objectManager->get(\Magento\Framework\App\Request\DataPersistorInterface::class);
        $optionRepository = $this->_objectManager->get(\Magento\Catalog\Api\ProductCustomOptionRepositoryInterface::class);

        if ($productIds && $copyFromProductIds!="") {
            $copyFromProductIdsArray = explode(",", $copyFromProductIds);

            $options = [];

            foreach ($copyFromProductIdsArray as $id) {
                $product = $this->_productFactory->create()->load($id);
                $options = array_diff($product->getOptions(), $options) ;
            }
            $count = 0;

            foreach ($productIds as $productId) {
                /** @var \Magento\Catalog\Model\Product\Option $option */

                try {

                    foreach ($optionRepository->getProductOptions($productRepo->getById($productId)) as $currentOption) {
                        $optionRepository->delete($currentOption);
                    }
                    $countOptions = 0;
                    $isRequired = false;
                    foreach ($options as $option) {
                        if ($countOptions > 0) {
                            continue;
                        }
                        $option->duplicate($option->getProductId(), $productId );
                        if ($option->getData('is_required')) {
                            $isRequired = true;
                        }
                        $countOptions ++;
                    }
                    $count++;
                    $updatedProduct = $productRepo->getById($productId, true);
                    $updatedProduct->setStoreId(0);
                    $updatedProduct->setData('can_save_custom_options', $countOptions > 0 ? true : false);
                    $productRepo->save($updatedProduct);

                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage("Product ID {$productId}: " . $e->getMessage());
                }

            }
            $dataPersistor->clear('catalog_product');

            if ($count > 0) {
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', $count));
            }

            $this->resolveMultiStoreConfig();
        }
    }


    public function resolveMultiStoreConfig()
    {
        try {
            $connection = $this->_productFactory->create()->getResource()->getConnection();
            $entityIntTable = $connection->getTableName('catalog_product_entity_int');
            $entityDecimalTable = $connection->getTableName('catalog_product_entity_decimal');
            $entityTextTable = $connection->getTableName('catalog_product_entity_text');
            $entityDateTimeTable = $connection->getTableName('catalog_product_entity_datetime');
            $entityVarcharTable = $connection->getTableName('catalog_product_entity_varchar');
            $entityGalleryTable = $connection->getTableName('catalog_product_entity_media_gallery_value');

            $query1 = "delete from {$entityIntTable} where IFNULL(store_id, 0) <> 0";
            $query2 = "delete from {$entityDecimalTable} where IFNULL(store_id, 0) <> 0";
            $query3 = "delete from {$entityTextTable} where IFNULL(store_id, 0) <> 0";
            $query4 = "delete from {$entityDateTimeTable} where IFNULL(store_id, 0) <> 0";
            $query5 = "delete from {$entityVarcharTable} where IFNULL(store_id, 0) <> 0";
            $query6 = "delete from {$entityGalleryTable} where IFNULL(store_id, 0) <> 0";

            $connection->query($query1);
            $connection->query($query2);
            $connection->query($query3);
            $connection->query($query4);
            $connection->query($query5);
            $connection->query($query6);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

    }
}
