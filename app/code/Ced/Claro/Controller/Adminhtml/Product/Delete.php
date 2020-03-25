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
 * @package   Ced_Claro
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Controller\Adminhtml\Product;

/**
 * Class Delete
 *
 * @package Ced\Claro\Controller\Adminhtml\Product
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    public $filter;

    /**
     * @var \Ced\Claro\Helper\Product
     */
    public $product;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    public $productCollectionFactory;

    /** @var \Magento\Backend\Model\Session  */
    public $session;

    public $registry;

    public $resultJsonFactory;

    public $resultPageFactory;

    public $config;

    /**
     * Upload constructor.
     *
     * @param \Magento\Backend\App\Action\Context              $context
     * @param \Magento\Framework\View\Result\PageFactory       $resultPageFactory
     * @param \Magento\Ui\Component\MassAction\Filter          $filter
     * @param \Magento\Catalog\Model\Product                   $collection
     * @param \Ced\Claro\Helper\Product                       $product
     * @param \Ced\Claro\Helper\Config                        $config
     * @param \Magento\Framework\Registry                      $registry
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collection,
        \Ced\Claro\Helper\Config $config,
        \Ced\Claro\Helper\Product $product,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->productCollectionFactory = $collection;
        $this->config = $config;

        $this->product = $product;
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
        // case 1 check if api config are valid
        if (!$this->config->isValid()) {
            $this->messageManager->addErrorMessage(
                __('Products Upload Failed. Claro API not enabled or Invalid. Please check Claro Configuration.')
            );
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        // case 2.1 normal uploading and chunk creating
        $isFilter = $this->getRequest()->getParam('filters');
        $ids = [];
        if (isset($isFilter)) {
            $collection = $this->filter->getCollection($this->productCollectionFactory->create());
            $ids = $collection->getAllIds();
        }

        if (empty($ids)) {
            $this->messageManager->addErrorMessage('No Product(s) selected to delete.');
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setPath('*/*/index');
            return $resultRedirect;
        }

        /*$chunkSize = $this->config->getChunkSize(\Ced\Claro\Helper\Config::ACTION_PRODUCT_DELETE);*/
        // case 2.2 normal uploading if current ids are less than chunk size.
        $chunkSize = 1;
        if (count($ids) <= $chunkSize) {
            $response = $this->product->delete($ids);
            if (isset($response['success']) && $response['success'] == 1) {
                $this->messageManager->addSuccessMessage(count($ids) . ' Product(s) deleted Successfully');
            } else {
                $message = 'Product(s) deleted failed because Product is not in ClaroShop Seller list.';
                $this->messageManager->addErrorMessage($message);
            }

            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setPath('*/*/index');
            return $resultRedirect;
        } else {
            $response = $this->product->delete($ids);
            if (isset($response['success']) && $response['success'] == 1) {
                $this->messageManager->addSuccessMessage(count($ids) . ' Product(s) deleted Successfully');
            } else {
                $message = 'Product(s) deleted failed because Product is not in ClaroShop Seller list.';
                $this->messageManager->addErrorMessage($message);
            }

            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setPath('*/*/index');
            return $resultRedirect;
        }
        // case 3.2 normal uploading if current ids are more than chunk size.
       /* $key = uniqid(\Ced\Claro\Helper\Config::ACTION_PRODUCT_DELETE . '_');
        $ids = array_chunk($ids, $chunkSize);
        $index = 'set' . $key;
        $this->session->$index($ids);
        $this->registry->register($key, count($ids));
        $this->registry->register(\Ced\Claro\Helper\Config::PRODUCT_ACTION_KEY, $key);
        $this->registry->register(
            \Ced\Claro\Helper\Config::PRODUCT_ACTION_TYPE,
            \Ced\Claro\Helper\Config::ACTION_PRODUCT_DELETE
        );
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;*/
    }
}
