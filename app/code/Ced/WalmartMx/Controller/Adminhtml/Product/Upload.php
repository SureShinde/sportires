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
 * Class Upload
 *
 * @package Ced\WalmartMx\Controller\Adminhtml\Product
 */
class Upload extends \Magento\Backend\App\Action
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

    public $session;

    public $registry;

    public $resultJsonFactory;

    public $resultPageFactory;

    /**
     * Upload constructor.
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
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Catalog\Model\Product $collection,
        \Ced\WalmartMx\Helper\Product $product,
        \Ced\WalmartMx\Helper\Config $config,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->catalogCollection = $collection;
        $this->walmartmx = $product;
        $this->session =  $context->getSession();
        $this->registry = $registry;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {

        //print_r($this->getRequest()->getParams());die;
        // case 1 check if api config are valid
        if (!$this->walmartmx->checkForConfiguration()) {
            $this->messageManager->addErrorMessage(
                __('Products Upload Failed. WalmartMx API not enabled or Invalid. Please check WalmartMx Configuration.')
            );
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        // case 2 ajax request for chunk processing
        $batchId = $this->getRequest()->getParam('batchid');
        if (isset($batchId)) {
            $resultJson = $this->resultJsonFactory->create();
            $productIds = $this->session->getWalmartMxProducts();
            $response = $this->walmartmx->createProducts($productIds[$batchId]);
            if (isset($productIds[$batchId]) && $response) {
                return $resultJson->setData(
                    [
                    'success' => count($productIds[$batchId]) . " Product(s) Uploaded successfully",
                    'messages' => $response//$this->registry->registry('walmartmx_product_errors')
                    ]
                );
            }
            return $resultJson->setData(
                [
                'error' => count($productIds[$batchId]) . " Product(s) Upload Failed",
                'messages' => $this->registry->registry('walmartmx_product_errors'),
                ]
            );
        }

        // case 3 normal uploading and chunk creating
        $collection = $this->filter->getCollection($this->catalogCollection->getCollection());
        $productIds = $collection->getAllIds();

        if (count($productIds) == 0) {
            $this->messageManager->addErrorMessage('No Product selected to upload.');
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        // case 3.1 normal uploading if current ids are less than chunk size.
        if (count($productIds) == self::CHUNK_SIZE) {
            $response = $this->walmartmx->createProducts($productIds);
            if ($response) {
                $this->messageManager->addSuccessMessage(count($productIds) . ' Product(s) Uploaded Successfully');
            } else {
                $message = 'Product(s) Upload Failed.';
                $errors = $this->registry->registry('walmartmx_product_errors');
                if (isset($errors)) {
                    $message = "Product(s) Upload Failed. \nErrors: " . (string)json_encode($errors);
                }
                $this->messageManager->addError($message);
            }

            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }
        // case 3.2 normal uploading if current ids are more than chunk size.
        $productIds = array_chunk($productIds, self::CHUNK_SIZE);
        $this->registry->register('productids', count($productIds));
        $this->session->setWalmartMxProducts($productIds);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ced_WalmartMx::WalmartMx');
        $resultPage->getConfig()->getTitle()->prepend(__('Upload Products'));
        return $resultPage;
    }
}
