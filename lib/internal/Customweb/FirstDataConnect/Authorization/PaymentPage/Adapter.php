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
class Customweb_FirstDataConnect_Authorization_PaymentPage_Adapter extends Customweb_FirstDataConnect_Authorization_AbstractAdapter
implements Customweb_Payment_Authorization_PaymentPage_IAdapter
{
	
	public function getAdapterPriority() {
		return 100;
	}
	
	public function getAuthorizationMethodName() {
		return self::AUTHORIZATION_METHOD_NAME;
	}
	
	public function createTransaction(Customweb_Payment_Authorization_PaymentPage_ITransactionContext $transactionContext, $failedTransaction){
		$transaction = new Customweb_FirstDataConnect_Authorization_Transaction($transactionContext);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);
		if($transactionContext->getAlias() != null && $transactionContext->getAlias() != 'new') {
			$transaction->setAlias($transactionContext->getAlias());
		}
		$transaction->setLiveTransaction(!$this->getConfiguration()->isTestMode());
		return $transaction;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::getVisibleFormFields()
	 */
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext){
		$paymentMethod = $this->getPaymentMethodFactory()->getPaymentMethod($orderContext->getPaymentMethod(), self::AUTHORIZATION_METHOD_NAME);
		return $paymentMethod->getFormFields($orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, self::AUTHORIZATION_METHOD_NAME, false);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::getRedirectionUrl()
	 */
	public function getRedirectionUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		throw new Exception('Not allowed');
	}
	

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::isHeaderRedirectionSupported()
	 */
	public function isHeaderRedirectionSupported(Customweb_Payment_Authorization_ITransaction $transaction, array $formData) {
		return false;
	}
	
	public function getParameters(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		$url = new Customweb_Core_Url($this->generateUrl($transaction, $formData));
		return $url->getQueryAsArray();		
	}
	
	public function getFormActionUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		$url = new Customweb_Core_Url($this->generateUrl($transaction, $formData));
		return $url->setQuery(array())->toString();
		
	}


	private function generateUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData) {
		
		try {
			$url = new Customweb_Core_Url($this->getConfiguration()->getBaseUrl().Customweb_FirstDataConnect_IConstants::URL_CONNECT);
			$builder = new Customweb_FirstDataConnect_Authorization_PaymentPage_ParameterBuilder($transaction, $this->getContainer(), $formData);
			$url->appendQueryParameters($builder->buildParameters());
			return $url->toString();
		}
		catch(Exception $e) {
			$transaction->setAuthorizationFailed($e->getMessage());
			return $transaction->getFailedUrl();
		}
		
	}

}