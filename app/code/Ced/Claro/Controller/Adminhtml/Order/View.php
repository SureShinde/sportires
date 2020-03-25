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

namespace Ced\Claro\Controller\Adminhtml\Order;

/**
 * TODO: dev
 * Class View
 * @package Ced\Claro\Controller\Adminhtml\Order
 */
class View extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    public $filter;

    /**
     * @var \Ced\Claro\Helper\Product
     */
    public $claroHelper;

    /**
     * @var \Ced\Claro\Model\Order
     */
    public $orders;

    /**
     * Json Factory
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    public $resultJsonFactory;

    /**
     * View constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Ced\Claro\Model\Order $orders
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Ced\Claro\Model\Order $orders
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->filter = $filter;
        $this->orders = $orders;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $order = [
            'order' => [],
            'order_items' => []
        ];

        $id = $this->getRequest()->getParam('id');
        if (!empty($id)) {
            $claroOrder = $this->orders->load($id);
            if ($claroOrder and $claroOrder->getId()) {
                $order['order'] = json_decode($claroOrder->getOrderData());
                $order['order_items'] = json_decode($claroOrder->getOrderItems());
            }
        }
        return $this->resultJsonFactory
            ->create()
            ->setData($order);
    }
}
