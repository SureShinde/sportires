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



/**
 * 
 * @author nicoeigenmann
 * @Bean 
 */

class Customweb_FirstDataConnect_Authorization_Hidden_Adapter extends Customweb_FirstDataConnect_Authorization_AbstractAdapter 
	implements Customweb_Payment_Authorization_Hidden_IAdapter {
	
	
	public function getAdapterPriority() {
		return 200;
	}
		
	public function getAuthorizationMethodName() {
		return self::AUTHORIZATION_METHOD_NAME;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Hidden_IAdapter::createTransaction()
	 */
	public function createTransaction(Customweb_Payment_Authorization_Hidden_ITransactionContext $transactionContext, $failedTransaction) {
		$transaction = new Customweb_FirstDataConnect_Authorization_Transaction($transactionContext);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);
		if($failedTransaction !== null && $failedTransaction->getTransactionContext()->getAlias() != null && $failedTransaction->getTransactionContext()->getAlias() != 'new' ) {
			$transaction->setAlias($failedTransaction->getTransactionContext()->getAlias());
		}
		elseif($transactionContext->getAlias() != null && $transactionContext->getAlias() != 'new') {
			$transaction->setAlias($transactionContext->getAlias());
		}
		$transaction->setLiveTransaction(!$this->getConfiguration()->isTestMode());
		return $transaction;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Hidden_IAdapter::getHiddenFormFields()
	 */
	public function getHiddenFormFields(Customweb_Payment_Authorization_ITransaction $transaction) {
		$builder = new Customweb_FirstDataConnect_Authorization_Hidden_ParameterBuilder($transaction, $this->getContainer(), array());
		return $builder->buildParameters();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Hidden_IAdapter::getFormActionUrl()
	 */
	public function getFormActionUrl(Customweb_Payment_Authorization_ITransaction $transaction) {
		return $this->getConfiguration()->getBaseUrl().Customweb_FirstDataConnect_IConstants::URL_CONNECT;
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Hidden_IAdapter::getVisibleFormFields()
	 */
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext) {
		$factory = $this->getContainer()->getBean('Customweb_FirstDataConnect_Method_Factory');
		$paymentMethod = $factory->getPaymentMethod($orderContext->getPaymentMethod(), $this->getAuthorizationMethodName());
		return $paymentMethod->getFormFields($orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, self::AUTHORIZATION_METHOD_NAME, $this->isMoto);
	}


}