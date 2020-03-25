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

namespace Customweb\FirstDataConnectCw\Model\Authorization\Method\Context;

class Quote extends AbstractContext
{
	/**
	 * @var \Magento\Quote\Model\Quote
	 */
	protected $quote;

	/**
	 * @var \Customweb\FirstDataConnectCw\Model\Payment\Method\AbstractMethod
	 */
	protected $paymentMethod;

	/**
	 * @var \Customweb\FirstDataConnectCw\Model\Authorization\OrderContext
	 */
	protected $orderContext;

	/**
	 * @param \Magento\Framework\Registry $coreRegistry
	 * @param \Magento\Checkout\Model\Session $checkoutSession
	 * @param \Magento\Framework\App\RequestInterface $request
	 * @param \Customweb\FirstDataConnectCw\Model\Authorization\OrderContextFactory $orderContextFactory
	 * @param \Customweb\FirstDataConnectCw\Model\Authorization\CustomerContextFactory $customerContextFactory
	 * @param \Magento\Backend\Model\Session\Quote $backendQuoteSession
	 * @param \Customweb\FirstDataConnectCw\Model\Payment\Method\AbstractMethod $paymentMethod
	 * @param \Magento\Quote\Model\Quote $quote
	 * @param int $alias
	 */
	public function __construct(
			\Magento\Framework\Registry $coreRegistry,
			\Magento\Checkout\Model\Session $checkoutSession,
			\Magento\Framework\App\RequestInterface $request,
			\Customweb\FirstDataConnectCw\Model\Authorization\OrderContextFactory $orderContextFactory,
			\Customweb\FirstDataConnectCw\Model\Authorization\CustomerContextFactory $customerContextFactory,
			\Magento\Backend\Model\Session\Quote $backendQuoteSession,
			\Customweb\FirstDataConnectCw\Model\Payment\Method\AbstractMethod $paymentMethod = null,
			\Magento\Quote\Model\Quote $quote = null,
			$alias = null
	) {
		parent::__construct($coreRegistry, $checkoutSession, $request, $orderContextFactory, $customerContextFactory);

		if (!($quote instanceof \Magento\Quote\Model\Quote)) {
			if ($this->_coreRegistry->registry('firstdataconnectcwcheckout_moto')) {
				$quote = $backendQuoteSession->getQuote();
			} else {
				$quote = $this->_checkoutSession->getQuote();
			}
		}
		$this->quote = $quote;

		if (!($paymentMethod instanceof \Customweb\FirstDataConnectCw\Model\Payment\Method\AbstractMethod)) {
			$paymentMethod = $this->quote->getPayment()->getMethodInstance();
		}
		$this->paymentMethod = $paymentMethod;

		$this->alias = $alias;
	}

	public function getPaymentMethod()
	{
		return $this->paymentMethod;
	}

	public function getOrderContext()
	{
		if (!($this->orderContext instanceof \Customweb\FirstDataConnectCw\Model\Authorization\OrderContext)) {
			$this->orderContext = $this->_orderContextFactory->create(['order' => $this->getQuote(), 'paymentMethod' => $this->getPaymentMethod()]);
		}
		return $this->orderContext;
	}

	public function getTransaction()
	{
		throw new \Exception("No transaction available yet.");
	}

	public function getOrder()
	{
		throw new \Exception("No order available yet.");
	}

	public function getQuote()
	{
		return $this->quote;
	}

	public function isMoto()
	{
		return $this->getQuote()->getIsSuperMode()
			|| $this->_coreRegistry->registry('firstdataconnectcwcheckout_moto');
	}
}