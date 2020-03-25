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
 *  TODO: dev
 * Class Sync
 * @package Ced\Claro\Controller\Adminhtml\Order
 */
class Sync extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    public $filter;

    /**
     * @var \Ced\Claro\Model\ResourceModel\Order\CollectionFactory
     */
    public $orders;

    /**
     * @var \Ced\Claro\Helper\Order
     */
    public $helper;

    /** @var \Ced\Claro\Helper\Config  */
    public $config;

    /**
     * Sync constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Ced\Claro\Model\ResourceModel\Order\CollectionFactory $collectionFactory
     * @param \Ced\Claro\Helper\Order $order
     * @param \Ced\Claro\Helper\Config $config
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Ced\Claro\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        \Ced\Claro\Helper\Order $order,
        \Ced\Claro\Helper\Config $config
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->orders = $collectionFactory;
        $this->helper = $order;
        $this->config = $config;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $isFilter = $this->getRequest()->getParam('filters');
        if (isset($isFilter)) {
            $collection = $this->filter->getCollection($this->orders->create());
        } else {
            $id = $this->getRequest()->getParam('id');
            if (isset($id) && !empty($id)) {
                $collection = $this->orders->create()->addFieldToFilter('id', ['eq' => $id]);
            }
        }

        $response = false;
        $message = 'Order(s) synced successfully.';
        if (isset($collection) && $collection->getSize() > 0) {
            /** @var \Ced\Claro\Model\Order $item */
            foreach ($collection as $item) {
                if ($item->getData(\Ced\Claro\Model\Order::COLUMN_STATUS) ==
                    \Ced\Claro\Model\Source\Order\Status::IMPORTED &&
                    $this->config->getAutoAcknowledgement()) {
                    $response = $this->helper->acknowledge(
                        $item->getMagentoOrderId(),
                        $item->getClaroOrderId()
                    );
                }

                // Create order in magento
                if (empty($item->getData(\Ced\Claro\Model\Order::COLUMN_MAGENTO_ORDER_ID))) {
                    $this->helper->import([$item->getAccountId()], $item->getClaroOrderId());
                }
            }

            $response =true;
        }

        if ($response) {
            $this->messageManager->addSuccessMessage($message);
        } else {
            $this->messageManager->addErrorMessage('Order(s) sync failed.');
        }

        return $this->_redirect('*/order/index');
    }
}
