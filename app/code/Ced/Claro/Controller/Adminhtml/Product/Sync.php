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
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license      http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Controller\Adminhtml\Product;

use Magento\Framework\UrlInterface;

class Sync extends \Magento\Backend\App\Action
{
    //const CHUNK_SIZE = 1;

    /**
     * PageFactory
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public $resultPageFactory;

    /**
     * Filter
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    public $filter;

    /**
     * Session
     * @var \Magento\Backend\Model\Session
     */
    public $session;

    /**
     * Json Factory
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    public $resultJsonFactory;

    public $dataHelper;

    public $registry;

    public $urlBuilder;

    public $helperConfig;

    /**
     * MassValidate constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Ced\Claro\Helper\Data $data
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Ced\Claro\Helper\Config $helperConfig,
        \Ced\Claro\Helper\Product $product,
        \Ced\Claro\Helper\Sdk $sdk,
        UrlInterface $urlBuilder,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->filter = $filter;
        $this->session = $context->getSession();
        $this->resultJsonFactory = $resultJsonFactory;
        $this->registry = $registry;
        $this->urlBuilder = $urlBuilder;
        $this->helperConfig = $helperConfig;
        $this->product = $product;
        $this->sdk = $sdk;
        $this->messageManager = $messageManager;
    }

    /**
     * Product sync
     */
    public function execute()
    {
        $chunk = 10;
        $batchid = $this->getRequest()->getParam('batchid');
        if (isset($batchid)) {
            $index = $batchid + 1;
            $successMsg = null;
            $totalProducts = $this->session->getClaroProducts();
            $resultJson = $this->resultJsonFactory->create();

            if (($totalProducts*$chunk) > $chunk) {
                $limit = $chunk;
                $offset = $batchid * $limit;
                $result =  $this->product->syncClaroProduct($offset, $limit);
                $message = array(
                    'success' => '',
                    'error' => ''
                );
                if (isset($result['success']) && $result['success']) {
                    $successMsg = '';
                    $successMsg .= "<br><ul class='error-msg'>";
                    foreach ($result['success'] as $msg) {
                        $successMsg .= "<li>" . $msg . "</li>";
                    }
                    $successMsg .= "</ul>";
                    $successMsg .= "<li class ='error-msg'>Batch $index product id  Sync ML Product request completed successfully</li>";
                } elseif (isset($result['error']) && $result['error']) {
                    $errorMsg = '';
                    $errorMsg .= "<br><ul class='error-msg'>";

                    foreach ($result['error'] as $msg) {
                        $errorMsg .= "<li>" . $msg . "</li>";
                    }
                    $errorMsg .= "</ul>";
                    $errorMsg .= "<li class ='error-msg'>Batch $index product id  Sync ML Product request failed </li>";
                }
                if (isset($errorMsg) && $errorMsg) {
                    return $resultJson->setData([
                        'error' => $errorMsg,
                    ]);
                }
                return $resultJson->setData([
                    'success' => "<ul class='sub-products'>".$successMsg."<li><b>"."Product(s) Import Successfully successfully"."</b></li></ul>",
                ]);
            }
        }

        $sellerId = $this->helperConfig->getSellerId();
        $data = $this->sdk->getProduct()->getTotalActiveProducts($sellerId);
        $totalProducts = 0;
        if (isset($data['success']) && $data['success']) {
            $totalProducts = (int)$data['message'];
        }
        if ($totalProducts == 0) {
            $this->messageManager->addErrorMessage('No Product Available.');
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }
        if ($totalProducts < $chunk) {
            $offset = 0;
            $limit = $totalProducts;
            $result = $result = $this->product->syncClaroProduct($offset, $limit);
            $message = array(
                'success' => '',
                'error' => ''
            );
            if (isset($result['success']) && $result['success']) {
                $successMsg = '';
                foreach ($result['success'] as $msg) {
                    $successMsg .= $msg;
                }
                $message['success'] = $message['success'] .
                    "Product id  Sync ML Product request completed successfully ";
                $successMsg = implode($message);
                $this->messageManager->addSuccessMessage($successMsg);
            } elseif (isset($result['error']) && $result['error']) {
                $errorMsg = '';
                foreach ($result['error'] as $msg) {
                    $errorMsg .= $msg;
                }
                $message['error'] = "Product id  Sync ML Product request failed or Product Already Available ";
                $error = implode($message);
                $this->messageManager->addErrorMessage($error);
            }
            $resultRedirect = $this->resultFactory->create('redirect');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $this->registry->register('productids', ((int)($totalProducts / $chunk))+1);
        $this->session->setClaroProducts(((int)($totalProducts / $chunk))+1);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Products IDs Import'));
        $resultPage->setActiveMenu('Ced_Claro::Claro');
        return $resultPage;
    }

    public function isAllowed()
    {
        return $this->authorization->isAllowed('Ced_Claro::Claro');
    }

}
