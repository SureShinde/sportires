<?php 
/**
 * * You are allowed to use this API in your web application.
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

class Customweb_FirstDataConnect_Authorization_Moto_Adapter extends Customweb_FirstDataConnect_Authorization_AbstractAdapter
implements Customweb_Payment_Authorization_Moto_IAdapter {
	
	
	public function getAdapterPriority() {
		return 1000;
	}
	
	public function getAuthorizationMethodName() {
		return self::AUTHORIZATION_METHOD_NAME;
	}
	
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		parent::__construct($container);
		$this->isMoto = true;
	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IAdapter::isAuthorizationMethodSupported()
	 */
	public function isAuthorizationMethodSupported(Customweb_Payment_Authorization_IOrderContext $orderContext){
		$adapter = $this->getAdapterInstanceByPaymentMethod($orderContext->getPaymentMethod());
		return $adapter->isAuthorizationMethodSupported($orderContext);
	}
	
	public function validateTransaction(Customweb_Payment_Authorization_ITransaction $transaction) {
		return true;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Moto_IAdapter::createTransaction()
	 */
	public function createTransaction(Customweb_Payment_Authorization_Moto_ITransactionContext $transactionContext, $failedTransaction){
		$transaction = new Customweb_FirstDataConnect_Authorization_Transaction($transactionContext);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);
		$transaction->setLiveTransaction(!$this->getConfiguration()->isTestMode());
		return $transaction;
	}
	
	public function getParameters(Customweb_Payment_Authorization_ITransaction $transaction){
		$adapter = $this->getAdapterInstanceByPaymentMethod($transaction->getTransactionContext()->getOrderContext()->getPaymentMethod());
		$parameters = array();
		if($adapter instanceof Customweb_FirstDataConnect_Authorization_Hidden_Adapter)
		{
			$parameters = $adapter->getHiddenFormFields($transaction);
			unset($parameters['paymentMethod']);
		}
		else{
			$parameters = $adapter->getParameters($transaction, array());
		}
		//Remove Hash, we need to calculate a new one;
		unset($parameters['hash']);
		unset($parameters['hashExtended']);
		
		if(!$transaction->getTransactionContext()->createRecurringAlias()) {
			//If not a recurring Transaction we do not create an Alias
			unset($parameters['hosteddataid']);
		}
		
		// Override StoreName
		$parameters['storename'] = $this->getConfiguration()->getMotoStoreId();
		// Mark as Moto
		$parameters['trxOrigin'] = 'MOTO';
		// Disable 3d secure		 
		$parameters['authenticateTransaction'] = 'false';
		
		$parameters['responseSuccessURL'] = Customweb_Util_Url::appendParameters(
												$transaction->getTransactionContext()->getBackendSuccessUrl(),
												$transaction->getTransactionContext()->getCustomParameters());
		$parameters['responseFailURL'] = Customweb_Util_Url::appendParameters(
												$transaction->getTransactionContext()->getBackendFailedUrl(),
												$transaction->getTransactionContext()->getCustomParameters());
		$parameters['hash_algorithm'] = 'SHA256';
		$parameters['hash'] = Customweb_FirstDataConnect_Util::calculateHash($parameters, $this->getConfiguration()->getMotoConnectSharedSecret());
		
		return $parameters; 
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Moto_IAdapter::getFormActionUrl()
	 */
	public function getFormActionUrl(Customweb_Payment_Authorization_ITransaction $transaction) {
		$adapter = $this->getAdapterInstanceByPaymentMethod($transaction->getTransactionContext()->getOrderContext()->getPaymentMethod());
		return $adapter->getFormActionUrl($transaction, array());
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Moto_IAdapter::getVisibleFormFields()
	 */
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext,
			$aliasTransaction,
			$failedTransaction,$paymentCustomerContext) {
		$adapter = $this->getAdapterInstanceByPaymentMethod($orderContext->getPaymentMethod());
		return $adapter->getVisibleFormFields($orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext);
	}
	
	
	public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters) {
		$adapter = $this->getAdapterInstanceByPaymentMethod($transaction->getTransactionContext()->getOrderContext()->getPaymentMethod());
		return $adapter->processAuthorization($transaction, $parameters);
	}
	
	
	
	protected function getAdapterInstanceByPaymentMethod(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod) {
		$configuredAuthorizationMethod = $paymentMethod->getPaymentMethodConfigurationValue('authorizationMethod');
		$adapter = null;
		switch (strtolower($configuredAuthorizationMethod)) {
	
			// In case the server mode is choosen, we stick to the hidden, for simplicity.
			case strtolower(Customweb_Payment_Authorization_Server_IAdapter::AUTHORIZATION_METHOD_NAME):
			case strtolower(Customweb_Payment_Authorization_Hidden_IAdapter::AUTHORIZATION_METHOD_NAME):
				$adapter = new Customweb_FirstDataConnect_Authorization_Hidden_Adapter($this->getContainer());
				break;
	
			case strtolower(Customweb_Payment_Authorization_PaymentPage_IAdapter::AUTHORIZATION_METHOD_NAME):
				$adapter = new Customweb_FirstDataConnect_Authorization_PaymentPage_Adapter($this->getContainer());
				break;
			default:
				throw new Exception(Customweb_I18n_Translation::__("Could not find an adapter for the authoriztion method !methodName.", array('!methodName' => $configuredAuthorizationMethod)));
		}
	
		$adapter->setIsMoto(true);
		return $adapter;
	}
	
	
	
	
	
	
	
}