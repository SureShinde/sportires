<?php

/**
 *  * You are allowed to use this API in your web application.
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
 */


abstract class Customweb_FirstDataConnect_Authorization_AbstractAdapter extends Customweb_FirstDataConnect_AbstractAdapter {
	protected $isMoto = false;

	public function setIsMoto($moto){
		$this->isMoto = $moto;
		return $this;
	}

	public function isDeferredCapturingSupported(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext){
		$paymentMethod = $this->getPaymentMethodFactory()->getPaymentMethod($orderContext->getPaymentMethod(), $this->getAuthorizationMethodName());
		return $paymentMethod->isDeferredCapturingSupported();
	}

	public function isAuthorizationMethodSupported(Customweb_Payment_Authorization_IOrderContext $orderContext){
		$paymentMethod = $this->getPaymentMethodFactory()->getPaymentMethod($orderContext->getPaymentMethod(), $this->getAuthorizationMethodName());
		return $paymentMethod->isAuthorizationMethodSupported($this->getAuthorizationMethodName());
	}

	public function preValidate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext){
		$paymentMethod = $this->getPaymentMethodFactory()->getPaymentMethod($orderContext->getPaymentMethod(), $this->getAuthorizationMethodName());
		return $paymentMethod->preValidate($orderContext, $paymentContext);
	}

	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, array $formData){
		$paymentMethod = $this->getPaymentMethodFactory()->getPaymentMethod($orderContext->getPaymentMethod(), $this->getAuthorizationMethodName());
		return $paymentMethod->validate($orderContext, $paymentContext, $formData);
	}

	public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters){
		$authorizationHandler = $this->getContainer()->getBean('Customweb_FirstDataConnect_Authorization_AuthorizationHandler');
		return $authorizationHandler->handleAuthorizationWithHashCheck($transaction, $parameters);
	}


	public function handleFailedTransaction(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $parameters){
		
		$authorizationHandler = $this->getContainer()->getBean('Customweb_FirstDataConnect_Authorization_AuthorizationHandler');
		return $authorizationHandler->handleFailedTransaction($transaction, $parameters);

	}
}