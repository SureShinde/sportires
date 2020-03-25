<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Mpa\Controller\Adminhtml\Product;
use Magento\Backend\App\Action;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ProductFactory;

/**
 * Class MassLinkedProduct
 * @package Yosto\Mpa\Controller\Adminhtml\Product
 */
class MassLinkedProduct extends \Magento\Catalog\Controller\Adminhtml\Product
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
     * @var int
     */
    protected $linkTypeId = 1;

    /**
     * @var string
     */
    protected $addLinkedProductParam = "add_related_products";

    /**
     * @var string
     */
    protected $removeLinkedProductParam = "remove_related_products";

    /**
     * MassLinkedProduct constructor.
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
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $productIds = $collection->getAllIds();
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        $filters = (array)$this->getRequest()->getParam('filters', []);
        $params = $this->getRequest()->getParams();
        if (isset($filters['store_id'])) {
            $storeId = (int)$filters['store_id'];
        }

        try {
            $this->addLinkedProducts($productIds, $params);
            $this->removeLinkedProducts($productIds, $params);
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
     */
    public function addLinkedProducts($productIds, $params)
    {
        $addLinkedProducts = $params[$this->addLinkedProductParam];
        if ($productIds && $addLinkedProducts != "") {
            /*$productLinkResource = $this->_objectManager->create(\Magento\Catalog\Model\ResourceModel\Product\Link::class);*/
            $addLinkedProductsArray = explode(",", $addLinkedProducts);
            $connection  = $this->_productFactory->create()->getResource()->getConnection();
            $catalogProductLinkTable =  $connection->getTableName('catalog_product_link');
            $insertQuery = "insert into {$catalogProductLinkTable} (product_id, linked_product_id, link_type_id) values";
            $count = 0;
            $existingLikedProducts = [];
            foreach ($productIds as $productId) {
                $addLinkedProductsArray = array_diff($addLinkedProductsArray, [$productId]);
                $select = $connection->select();
                $select->from($catalogProductLinkTable, ['linked_product_id'])->where("link_type_id = {$this->linkTypeId} and product_id = {$productId} ");
                $linkedProductIds = $connection->fetchCol($select);
                $newLinkedProductIds = array_diff($addLinkedProductsArray, $linkedProductIds);
                if (!$newLinkedProductIds || count($newLinkedProductIds) == 0) {
                    $existingLikedProducts[] = false;
                }
                foreach ($newLinkedProductIds as $id) {

                    if ($count==0) {
                        $insertQuery = $insertQuery . " ({$productId}, {$id}, {$this->linkTypeId}) ";
                    } else {
                        $insertQuery = $insertQuery . " , ({$productId}, {$id}, {$this->linkTypeId})";
                    }
                    $count++;
                }


            }
            $insertQuery = $insertQuery . ";";
            if (count($existingLikedProducts) == count($productIds)) {
                $this->messageManager->addSuccessMessage(__('All linked products existed! Nothing to change'));
                return;
            }
            $connection->query($insertQuery);
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', count($productIds)));
        }
    }

    /**
     * @param $productIds
     * @param $params
     */
    public function removeLinkedProducts($productIds, $params)
    {
        $removeLinkedProducts = $params[$this->removeLinkedProductParam];
        if ($productIds && $removeLinkedProducts != "") {
            $productIdsString = implode(",", $productIds);
            $connection  = $this->_productFactory->create()->getResource()->getConnection();
            $catalogProductLinkTable =  $connection->getTableName('catalog_product_link');

            $deleteQuery = "delete from {$catalogProductLinkTable}"
                . " WHERE product_id in ({$productIdsString}) and linked_product_id in ({$removeLinkedProducts}) "
                . " and link_type_id = {$this->linkTypeId}";

            $connection->query($deleteQuery);
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', count($productIds)));
        }
    }

}