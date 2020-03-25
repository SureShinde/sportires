<?php
namespace Ced\StorePickup\Block;
class Email extends \Magento\Framework\View\Element\Template
{
	protected $_objectManager;
	protected $order;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Sales\Model\Order $order
		)
	{
		$this->_objectManager = $objectManager;
		$this->order = $order;
		parent::__construct($context);
	}

	public function getOrderDetails(){
		$orderId = $this->getRequest()->getParam('order_id');
		$order = $this->order->load($orderId);
		return $order;
	}
}
