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
 * Class View
 *
 * @package Ced\Claro\Controller\Adminhtml\Product
 */
class View extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    public $product;

    /**
     * Json Factory
     *
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    public $resultJsonFactory;

    /**
     * View constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Ced\Claro\Helper\Product $product
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Ced\Claro\Helper\Product $product
    )
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->product = $product;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $products = [];
        if (isset($id)) {
            $products = $this->product->get($id);
            if (empty($products)) {
                $products = ["Product is not available or not uploaded on claro."];
            }
        }
        return $this->resultJsonFactory
            ->create()
            ->setData($products);
    }
}
