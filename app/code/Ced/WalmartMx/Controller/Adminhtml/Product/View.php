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
 * Class View
 *
 * @package Ced\WalmartMx\Controller\Adminhtml\Product
 */
class View extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    public $filter;

    /**
     * @var \WalmartMxSdk\ProductFactory
     */
    public $walmartmx;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    public $catalogCollection;

    /**
     * Json Factory
     *
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    public $resultJsonFactory;

    /**
     * View constructor.
     *
     * @param \Magento\Backend\App\Action\Context              $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Ui\Component\MassAction\Filter          $filter
     * @param \Magento\Catalog\Model\Product                   $collection
     * @param \Ced\WalmartMx\Helper\Config                        $config
     * @param \WalmartMxSdk\ProductFactory                       $walmartmx
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Catalog\Model\Product $collection,
        \Ced\WalmartMx\Helper\Config $config,
        \WalmartMxSdk\ProductFactory $walmartmx
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->filter = $filter;
        $this->catalogCollection = $collection;
        $this->walmartmx = $walmartmx;
        $this->config = $config;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $sku = $this->getRequest()->getParam('sku');
        $products = $this->walmartmx->create(['config' => $this->config->getApiConfig()])
            ->getProducts(['SkuSellerList' => json_encode([$sku])]);
        return $this->resultJsonFactory
            ->create()
            ->setData($products->getBody());
    }
}
