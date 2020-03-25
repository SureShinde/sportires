<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Block\Order;

use \Magento\Framework\App\ObjectManager;
use \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;


class History extends \Magento\Sales\Block\Order\History
{

    /**
     * @var string
     */
    protected $_template = 'ITM_MagB1::sales/order/history.phtml';

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $_orderCollectionFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    protected $_orderConfig;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Collection
     */
    protected $orders;

    /**
     * @var \ITM\MagB1\Helper\Data
     */
    protected $_helper;

    /**
     * @var CollectionFactoryInterface
     */
    private $orderCollectionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Sales\Model\Order\Config $orderConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \ITM\MagB1\Helper\Data $helper,
        array $data = []
    ) {
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_customerSession = $customerSession;
        $this->_orderConfig = $orderConfig;
        $this->_helper = $helper;
        parent::__construct($context, $orderCollectionFactory, $customerSession, $orderConfig, $data);
    }


    private function getOrderCollectionFactory()
    {
        if ($this->orderCollectionFactory === null) {
            $this->orderCollectionFactory = ObjectManager::getInstance()->get(CollectionFactoryInterface::class);
        }
        return $this->orderCollectionFactory;
    }

    /**
     * @return bool|\Magento\Sales\Model\ResourceModel\Order\Collection
     */
    public function getOrders()
    {

        if(!$this->_helper->displayAllOrders()) {
            return parent::getOrders();
        }

        if (!($customerId = $this->_customerSession->getCustomerId())) {
            return false;
        }
        if (!$this->orders) {
            $this->orders = $this->getOrderCollectionFactory()->create()->addFieldToSelect(
                '*'
            )->addFieldToFilter(
                'status',
                ['in' => $this->_orderConfig->getVisibleOnFrontStatuses()]
            )->addFieldToFilter(
                'customer_id',
                ['in' => $this->_helper->getCustomerIdsByCardCode($this->_customerSession->getCustomer()->getData("itm_cardcode"))]
            )->setOrder(
                'created_at',
                'desc'
            );
        }
        return $this->orders;
    }
    /**
     * @param object $order
     * @return string
     */
    public function getViewUrl($order)
    {
        return $this->getUrl('magb1/order/view', ['order_id' => $order->getId()]);
    }
    /**
     * @param object $order
     * @return string
     */
    public function getPrintUrl($order)
    {
        return $this->getUrl('magb1/order/print', ['order_id' => $order->getId()]);
    }
}
