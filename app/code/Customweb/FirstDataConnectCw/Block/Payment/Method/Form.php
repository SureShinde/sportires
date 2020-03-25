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

namespace Customweb\FirstDataConnectCw\Block\Payment\Method;

class Form extends \Magento\Payment\Block\Form
{
	/**
	 * @var \Magento\Checkout\Model\Session
	 */
	protected $_checkoutSession;

	/**
	 * @var \Customweb\FirstDataConnectCw\Model\Authorization\Method\Factory
	 */
	protected $_authorizationMethodFactory;

	/**
	 * Payment method form template
	 *
	 * @var string
	 */
	protected $_template = 'Customweb_FirstDataConnectCw::payment/method/form.phtml';

	/**
	 * @var \Customweb\FirstDataConnectCw\Model\Authorization\Method\AbstractMethod
	 */
	private $authorizationMethodAdapter;

	/**
	 * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param \Magento\Checkout\Model\Session $checkoutSession
	 * @param \Customweb\FirstDataConnectCw\Model\Authorization\Method\Factory $authorizationMethodFactory
	 * @param array $data
	 */
	public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\Magento\Checkout\Model\Session $checkoutSession,
			\Customweb\FirstDataConnectCw\Model\Authorization\Method\Factory $authorizationMethodFactory,
			array $data = []
	) {
		parent::__construct($context, $data);

		$this->_checkoutSession = $checkoutSession;
		$this->_authorizationMethodFactory = $authorizationMethodFactory;
	}

	/**
	 * @return string
	 */
	public function getMethodDescription()
	{
		return $this->getMethod()->getDescription();
	}

	/**
	 * @return boolean
	 */
	public function isShowMethodImage()
	{
		return $this->getMethod()->isShowImage();
	}

	/**
	 * @return string
	 */
	public function getPaymentForm()
	{
		
		$arguments = null;
		return \Customweb_Licensing_FirstDataConnectCw_License::run('7fko0b2onhacvnqn', $this, $arguments);
	}

	final public function call_7tfai2age7aiah3s() {
		$arguments = func_get_args();
		$method = $arguments[0];
		$call = $arguments[1];
		$parameters = array_slice($arguments, 2);
		if ($call == 's') {
			return call_user_func_array(array(get_class($this), $method), $parameters);
		}
		else {
			return call_user_func_array(array($this, $method), $parameters);
		}
		
		
	}

	/**
	 * @return \Customweb_Form_IRenderer
	 */
	private function getFormRenderer() {
		return new \Customweb\FirstDataConnectCw\Model\Renderer\CheckoutForm($this->getMethodCode());
	}

	/**
	 * @return \Customweb\FirstDataConnectCw\Model\Authorization\Method\AbstractMethod
	 */
	private function getAuthorizationMethodAdapter()
	{
		if (!($this->authorizationMethodAdapter instanceof \Customweb\FirstDataConnectCw\Model\Authorization\Method\AbstractMethod)) {
			$context = $this->_authorizationMethodFactory->getContextFactory()->createQuote($this->getMethod());
			$this->authorizationMethodAdapter = $this->_authorizationMethodFactory->create($context);
		}
		return $this->authorizationMethodAdapter;
	}
}
