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
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MassPrice extends \Magento\Catalog\Controller\Adminhtml\Product
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
        $collection = $this->filter->getCollection($this->collectionFactory->create()
            ->addAttributeToSelect('price'));
        $productIds = $collection->getAllIds();
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        $filters = (array)$this->getRequest()->getParam('filters', []);
        $params = $this->getRequest()->getParams();
        if (isset($filters['store_id'])) {
            $storeId = (int)$filters['store_id'];
        }

        try {
            $this->updatePrice($collection, $productIds, $params,$storeId);
            $this->updateSpecialPrice($collection, $productIds, $params,$storeId);
            $this->updateCost($collection, $productIds, $params,$storeId);
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', count($productIds)));
            $this->_productPriceIndexerProcessor->reindexList($productIds);
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
     * @param $storeId
     */
    public function updatePrice($collection, $productIds, $params, $storeId)
    {
            $modifyPrice = $params['modify_price'];
            if ($productIds && $modifyPrice != "") {
                /** @var \Yosto\Mpa\Model\ResourceModel\Action $productMassActionResource */
                $productMassActionResource = $this->_objectManager->create(\Yosto\Mpa\Model\ResourceModel\Action::class);
                $priceArray = $this->getPriceArray($collection, $modifyPrice);
                $productMassActionResource->updateAttributesPrice($productIds, 'price', $storeId, $priceArray);
            }
    }

    /**
     * @param $productIds
     * @param $params
     * @param $storeId
     */
    public function updateSpecialPrice($collection, $productIds, $params, $storeId)
    {
        $modifyPrice = $params['modify_special_price'];
        if ($productIds && $modifyPrice != "") {
            /** @var \Yosto\Mpa\Model\ResourceModel\Action $productMassActionResource */
            $productMassActionResource = $this->_objectManager->create(\Yosto\Mpa\Model\ResourceModel\Action::class);
            $priceArray = $this->getSpecialPriceArray($collection, $modifyPrice);
            $productMassActionResource->updateAttributesPrice($productIds, 'special_price', $storeId, $priceArray);
        }
    }
    /**
     * @param $productIds
     * @param $params
     * @param $storeId
     */
    public function updateCost($collection, $productIds, $params, $storeId)
    {
        $modifyPrice = $params['modify_cost'];
        if ($productIds && $modifyPrice != "") {
            /** @var \Yosto\Mpa\Model\ResourceModel\Action $productMassActionResource */
            $productMassActionResource = $this->_objectManager->create(\Yosto\Mpa\Model\ResourceModel\Action::class);
            $priceArray = $this->getPriceArray($collection, $modifyPrice);
            $productMassActionResource->updateAttributesPrice($productIds, 'cost', $storeId, $priceArray);
        }
    }

    /**
     * @param $collection
     * @param $modifyPrice
     * @return array
     */
    public function getPriceArray($collection, $modifyPrice)
    {
        $priceArray = [];
        /** @var \Magento\Catalog\Model\Product $product */
        foreach ($collection as $product) {
            $priceArray[$product->getId()] = $product->getPrice();
        }
        if (strpos($modifyPrice, "%") !== false) {
            $modifyPrice = floatval(str_replace("%", "", $modifyPrice));
            foreach ($priceArray as $key => $value) {
                $priceArray[$key] = $value * (1 + $modifyPrice / 100);
            }
        } else {
            if (strpos($modifyPrice, "-") !== false || strpos($modifyPrice, "+") !== false) {
                $modifyPrice = floatval($modifyPrice);
                foreach ($priceArray as $key => $value) {
                    $priceArray[$key] = $value + $modifyPrice;
                }
            } else {
                $modifyPrice = floatval($modifyPrice);
                foreach ($priceArray as $key => $value) {
                    $priceArray[$key] = $modifyPrice;
                }
            }

        }
        return $priceArray;
    }

    /**
     * @param $collection
     * @param $modifyPrice
     * @return array
     */
    public function getSpecialPriceArray($collection, $modifyPrice)
    {
        $priceArray = [];
        $productPriceArray = [];
        /** @var \Magento\Catalog\Model\Product $product */
        foreach ($collection as $product) {
            $priceArray[$product->getId()] = $this->_productFactory->create()->load($product->getId())->getSpecialPrice();
            $productPriceArray[$product->getId()] = $product->getPrice();
        }
        if (strpos($modifyPrice, "%") !== false) {
            if (strpos($modifyPrice, "pp") !== false) {
                $modifyPrice = floatval(str_replace("%pp", "", $modifyPrice));
                foreach ($productPriceArray as $key => $value) {
                    $priceArray[$key] = $value * (1 + $modifyPrice / 100);
                }
            } else {
                $modifyPrice = floatval(str_replace("%", "", $modifyPrice));
                foreach ($priceArray as $key => $value) {
                    $priceArray[$key] = $value * (1 + $modifyPrice / 100);
                }
            }
        } else {
            if (strpos($modifyPrice, "-") !== false || strpos($modifyPrice, "+") !== false ) {
                if (strpos($modifyPrice, "pp") !== false) {
                    $modifyPrice = floatval(str_replace("pp", "", $modifyPrice));
                    foreach ($productPriceArray as $key => $value) {
                        $priceArray[$key] = $value + $modifyPrice;
                    }
                } else {
                    $modifyPrice = floatval($modifyPrice);
                    foreach ($priceArray as $key => $value) {
                        $priceArray[$key] = $value + $modifyPrice;
                    }
                }
            } else {
                $modifyPrice = floatval($modifyPrice);
                foreach ($priceArray as $key => $value) {
                    $priceArray[$key] = $modifyPrice;
                }
            }

        }
        return $priceArray;
    }

}
