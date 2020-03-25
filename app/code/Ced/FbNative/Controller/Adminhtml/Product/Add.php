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
 * @package     Ced_Fyndiq
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\FbNative\Controller\Adminhtml\Product;

use Ced\FbNative\Model\Account;
use Magento\Backend\App\Action;
use Magento\Catalog\Controller\Adminhtml\Product;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Add extends \Magento\Catalog\Controller\Adminhtml\Product
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
     * @var Account
     */
    protected $accountCollection;

    /**
     * @param Action\Context $context
     * @param Builder $productBuilder
     * @param \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param Ced\FbNative\Model\ResourceMode\Account\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Product\Builder $productBuilder,
        \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Ced\FbNative\Model\ResourceModel\Account\CollectionFactory $accountCollection
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_productPriceIndexerProcessor = $productPriceIndexerProcessor;
        $this->accountCollection = $accountCollection->create();
        parent::__construct($context, $productBuilder);
    }

    public function execute()
    {
//        $attribute = $this->getRequest()->getParam('is_facebook');
        $collection = $this->_objectManager->create('Magento\Catalog\Model\Product')
            ->getCollection();
        $productIds = $this->filter->getCollection($collection)->getAllIds();

        if (!is_array($productIds) /*&& !$attribute*/) {
            $this->messageManager->addError(__('Please select Product(s).'));
        } /*elseif ($attribute == "false") {
            $productIds = $this->_objectManager->create('Magento\Catalog\Model\Product')->getCollection()->getAllIds();
        }*/
        $ids = [];

        if (!empty($productIds)) {
            try {
                foreach ($productIds as $productId) {
                    $product = $this->_objectManager->create(\Magento\Catalog\Model\Product::class)->load($productId);
                    $ids[] = $product->getEntityId();
                    if($product->getTypeId()=="configurable") {
                        $productType = $product->getTypeInstance();
                        $products = $productType->getUsedProducts($product);
                        foreach ($products as $productData) {
                            $ids[] = $productData->getEntityId();
                        }
                    }
                }
                $action = $this->_objectManager->create(\Magento\Catalog\Model\Product\Action::class);
                $ids = array_unique($ids);
                foreach ($this->accountCollection as $account) {
                    if($account->getAccountStatus()) {
                        $storeId = $account->getData('account_store');
                        $attributeCode = 'fbnative_store_'.$account->getId();
                        $action->updateAttributes($ids,[$attributeCode => 1],$storeId);
                        try {
                            $action->updateAttributes($ids,['is_facebook' => 1],$storeId);
                        } catch (\Exception $e) {

                        }catch (\Error $er) {

                        }

                    }
                }

                $this->messageManager->addSuccessMessage(__('Total of %1 record(s) have been added to the store. Count Includes Variants as well.', count($ids)));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}
