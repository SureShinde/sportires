<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Yosto\Mpa\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Indexer\IndexerRegistry;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ProductFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MassText extends \Magento\Catalog\Controller\Adminhtml\Product
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

            $this->replaceText($productIds, $params, $storeId);
            $this->appendText($productIds, $params, $storeId);
            $this->_productEavIndexerProcessor->reindexList($productIds);
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
    public function replaceText($productIds, $params, $storeId)
    {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->_objectManager->create(ProductRepository::class);

        if ($productIds && count($productIds) > 0 ) {
            $attributeCode = $params['attribute_code'];
            $action = $params['text_action'];
            $oldText = $params['old_text'];
            $newText = $params['new_text'];
            if ($action == 1 && $attributeCode != "" && $oldText != "") {
                $textArray = [];
                foreach ($productIds as $productId) {
                    $currentProduct = $productRepository->getById($productId, true, $storeId);
                    $attributeValue = $currentProduct->getData($attributeCode);
                    if ($attributeValue && $attributeValue != "") {
                        $textArray[$productId] = str_replace($oldText, $newText, $attributeValue);
                    } else {
                        $textArray[$productId] = "";
                    }
                }

                if (count($textArray) > 0) {
                    /** @var \Yosto\Mpa\Model\ResourceModel\Action  $productMassActionResource */
                    $productMassActionResource = $this->_objectManager->create(\Yosto\Mpa\Model\ResourceModel\Action::class);
                    $productMassActionResource->updateAttributesText($productIds, $attributeCode, $storeId, $textArray);
                }
            }
        }
    }

    /**
     * @param $productIds
     * @param $params
     * @param $storeId
     */
    public function appendText($productIds, $params, $storeId)
    {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->_objectManager->create(ProductRepository::class);

        if ($productIds && count($productIds) > 0 ) {
            $attributeCode = $params['attribute_code'];
            $action = $params['text_action'];
            $appendText = $params['append_text'];
            $appendPosition = $params['append_position'];
            if ($action == 0 && $attributeCode != "" && $appendText != "" && $appendPosition != "") {
                $textArray = [];
                foreach ($productIds as $productId) {
                    $currentProduct = $productRepository->getById($productId, true, $storeId);
                    $attributeValue = $currentProduct->getData($attributeCode);
                    if ($attributeValue === null) {
                        $textArray[$productId] = $appendText;
                    } else {
                        if ($appendPosition == 1) {
                            $textArray[$productId] = $appendText . $attributeValue;
                        } else {
                            $textArray[$productId] = $attributeValue . $appendText;
                        }
                    }
                }

                if (count($textArray) > 0) {
                    /** @var \Yosto\Mpa\Model\ResourceModel\Action  $productMassActionResource */
                    $productMassActionResource = $this->_objectManager->create(\Yosto\Mpa\Model\ResourceModel\Action::class);
                    $productMassActionResource->updateAttributesText($productIds, $attributeCode, $storeId, $textArray);
                }
            }
        }
    }

}
