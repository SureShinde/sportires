<?php
/**
 * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 *
 * @category	Customweb
 * @package		Customweb_FirstDataConnectCw
 *
 */

namespace Customweb\FirstDataConnectCw\Observer;

use Magento\Framework\Event\ObserverInterface;

class EmailOrderVars implements ObserverInterface
{

	/**
	 * @var \Customweb\FirstDataConnectCw\Api\TransactionRepositoryInterface
	 */
	protected $_transactionRepository;

	/**
	 * @param \Customweb\FirstDataConnectCw\Api\TransactionRepositoryInterface $transactionRepository
	 */
	public function __construct(
			\Customweb\FirstDataConnectCw\Api\TransactionRepositoryInterface $transactionRepository
	) {
		$this->_transactionRepository = $transactionRepository;
	}

	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		/* @var $order \Magento\Sales\Model\Order */
		$transport = $observer->getEvent()->getTransport();
		$order = $transport->getOrder();
		if ($order != null && $order->getPayment() instanceof \Magento\Sales\Model\Order\Payment
				&& $order->getPayment()->getMethodInstance() instanceof \Customweb\FirstDataConnectCw\Model\Payment\Method\AbstractMethod) {
			try {
				$transaction = $this->_transactionRepository->getByOrderId($transport->getOrder()->getId());
				$transport->setPaymentTransaction($transaction);
			} catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
				return;
			}
	    }
	}
}