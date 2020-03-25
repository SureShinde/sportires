<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
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
class MassAttributeSet extends \Magento\Catalog\Controller\Adminhtml\Product
{
    /**
     * @var \Magento\Catalog\Model\Indexer\Product\Eav\Processor
     */
    protected $_productEavIndexerProcessor;

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
     * @var IndexerRegistry
     */
    protected $_indexerRegistry;

    /**
     * MassText constructor.
     * @param Action\Context $context
     * @param Product\Builder $productBuilder
     * @param \Magento\Catalog\Model\Indexer\Product\Eav\Processor $productEavIndexerProcessor
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ProductFactory $productFactory
     * @param IndexerRegistry $indexerRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Product\Builder $productBuilder,
        \Magento\Catalog\Model\Indexer\Product\Eav\Processor $productEavIndexerProcessor,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ProductFactory $productFactory,
        IndexerRegistry $indexerRegistry
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_productEavIndexerProcessor = $productEavIndexerProcessor;
        $this->_productFactory = $productFactory;
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
            $this->changeAttributeSet($productIds, $params, $storeId);
            $this->_productEavIndexerProcessor->reindexList($productIds);
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', count($productIds)));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('catalog/*/', ['store' => $storeId]);
    }

    /**
     * @param $productIds
     * @param $params
     * @param $storeId
     */
    public function changeAttributeSet($productIds, $params, $storeId)
    {
        if ($productIds && count($productIds) > 0 ) {
            $attributeSetId = $params['attribute_set'];
            $productIdsString  = implode(",", $productIds);
            if ($attributeSetId != "") {
                $connection = $this->_productFactory->create()->getResource()->getConnection();
                $catalogProductEntityTable = $connection->getTableName('catalog_product_entity');

                $updateQuery = "update {$catalogProductEntityTable} set attribute_set_id = {$attributeSetId} where entity_id in ($productIdsString)";
                $connection->query($updateQuery);
            }
        }
    }


}
