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
 * @package   Ced_WalmartMx
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\WalmartMx\Controller\Adminhtml\Product;

/**
 * Class Price
 *
 * @package Ced\WalmartMx\Controller\Adminhtml\Product
 */
class Inactive extends \Magento\Backend\App\Action
{
    const CHUNK_SIZE = 5;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    public $filter;

    /**
     * @var \Ced\WalmartMx\Helper\Product
     */
    public $walmartmx;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    public $catalogCollection;

    /**
     * @var \Ced\WalmartMx\Helper\Config
     */
    public $config;

    public $session;

    public $registry;

    public $resultJsonFactory;

    public $resultPageFactory;

    /**
     * Price constructor.
     *
     * @param \Magento\Backend\App\Action\Context              $context
     * @param \Magento\Framework\View\Result\PageFactory       $resultPageFactory
     * @param \Magento\Ui\Component\MassAction\Filter          $filter
     * @param \Magento\Catalog\Model\Product                   $collection
     * @param \Ced\WalmartMx\Helper\Product                       $product
     * @param \Ced\WalmartMx\Helper\Config                        $config
     * @param \Magento\Framework\Registry                      $registry
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Catalog\Model\Product $collection,
        \Magento\Backend\App\Action\Context $context,
        \Ced\WalmartMx\Helper\Product $product,
        \Ced\WalmartMx\Helper\Config $config,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ResourceModel\Product\Action $productAction,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->filter               = $filter;
        $this->config               = $config;
        $this->registry             = $registry;
        $this->resultJsonFactory    = $resultJsonFactory;
        $this->catalogCollection    = $collection;
        $this->walmartmx              = $product;
        $this->resultPageFactory    = $resultPageFactory;
        $this->_prodAction = $productAction;
        $this->session              =  $context->getSession();
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {

        if (!$this->walmartmx->checkForConfiguration()) {
            $this->messageManager->addErrorMessage(
                __('Products Upload Failed. WalmartMx API not enabled or Invalid. Please check WalmartMx Configuration.')
            );
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $batch_id = $this->getRequest()->getParam('batchid');
        if (isset($batch_id)) {
            $resultJson = $this->resultJsonFactory->create();
            $productIds = $this->session->getWalmartMxProducts();
            $response = $this->walmartmx->updatePriceInventory($productIds[$batch_id], false, true);
            if (isset($productIds[$batch_id]) && $response) {
                $attrData = array( 'walmartmx_exclude_from_sync' => '1' );
                $storeId = 0;
                $this->_prodAction->updateAttributes($productIds[$batch_id], $attrData, $storeId);
                return $resultJson->setData(
                    [
                    'success' => count($productIds[$batch_id]) . " Product(s) Updated successfully",
                    'messages' => $response
                    ]
                );
            }
            return $resultJson->setData(
                [
                'error' => count($productIds[$batch_id]) . " Product(s) Update Failed",
                'messages' => $this->registry->registry('walmartmx_product_errors'),
                ]
            );
        }

        // case 3 normal uploading and chunk creating
        $collection = $this->filter->getCollection($this->catalogCollection->getCollection());
        $productIds = $collection->getAllIds();

        if (count($productIds) == 0) {
            $this->messageManager->addErrorMessage('No Product selected to update.');
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        // case 3.1 normal uploading if current ids are equal to chunk size.
        if (count($productIds) == self::CHUNK_SIZE) {
            $response = $this->walmartmx->updatePriceInventory($productIds, false, true);
            if ($response) {
                $attrData = array( 'walmartmx_exclude_from_sync' => '1' );
                $storeId = 0;
                $this->_prodAction->updateAttributes($productIds, $attrData, $storeId);
                $this->messageManager->addSuccessMessage(count($productIds) . ' Product(s) Updated Successfully');
            } else {
                $message = 'Product(s) Update Failed.';
                $errors = $this->registry->registry('walmartmx_product_errors');
                if (isset($errors)) {
                    $message = "Product(s) Update Failed. \nErrors: " . (string)json_encode($errors);
                }
                $this->messageManager->addError($message);
            }

            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $productIds = array_chunk($productIds, self::CHUNK_SIZE);
        $this->registry->register('productids', count($productIds));
        $this->session->setWalmartMxProducts($productIds);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ced_WalmartMx::WalmartMx');
        $resultPage->getConfig()->getTitle()->prepend(__('Inactive On WalmartMx'));
        return $resultPage;
    }
}
