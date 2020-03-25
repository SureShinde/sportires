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
class Customweb_FirstDataConnect_Authorization_Server_Adapter extends Customweb_FirstDataConnect_Authorization_AbstractAdapter implements 
		Customweb_Payment_Authorization_Server_IAdapter {

	public function getAdapterPriority(){
		return 1001;
	}

	public function getAuthorizationMethodName(){
		return self::AUTHORIZATION_METHOD_NAME;
	}

	public function isPaymentMethodSupportingRecurring(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod){
		$paymentMethod = $this->getPaymentMethodFactory()->getPaymentMethod($paymentMethod, self::AUTHORIZATION_METHOD_NAME);
		return $paymentMethod->isRecurringPaymentSupported();
	}

	public function createTransaction(Customweb_Payment_Authorization_Server_ITransactionContext $transactionContext, $failedTransaction){
		$transaction = new Customweb_FirstDataConnect_Authorization_Transaction($transactionContext);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);
		$transaction->setLiveTransaction(!$this->getConfiguration()->isTestMode());
		return $transaction;
	}

	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext){
		$paymentMethod = $this->getPaymentMethodFactory()->getPaymentMethod($orderContext->getPaymentMethod(), self::AUTHORIZATION_METHOD_NAME);
		return $paymentMethod->getFormFields($orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, 
				self::AUTHORIZATION_METHOD_NAME, false);
	}

	public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters){
		if (!($transaction instanceof Customweb_FirstDataConnect_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_FirstDataConnect_Authorization_Transaction');
		}
		try {
			
			$paymentMethod = $this->getPaymentMethodFactory()->getPaymentMethod($transaction->getPaymentMethod(), $this->getAuthorizationMethodName());
			$ipgRequest = $paymentMethod->getServerAPIOrderRequest($transaction, $parameters);
			
			$service = new Customweb_FirstDataConnect_SoapService($this->getAPIUser(false), $this->getAPIPassword(false), $this->getAPIUrl());
			$service->setClientCertificate(Customweb_FirstDataConnect_Util::getCertificate($this->getConfiguration(), false));
			$service->setClientCertificatePassphrase($this->getCertificatePassphrase(false));
			
			//Send XML handle response
			$parameters = array();
			$errorMessage = null;
			try {
				$response = $service->iPGApiOrder($ipgRequest);
			}
			catch (Customweb_Soap_Exception_SoapFaultException $e) {
				$userMessage = Customweb_I18n_Translation::__("An unexpected error occurred.");
				if ($e->getFaultCode() == 'SOAP-ENV:Server') {
					$errorMessage = 'Server Error! Please contact FirstData Connect';
				}
				elseif ($e->getFaultCode() == 'SOAP-ENV:Client') {
					$details = $e->getFaultDetail();

					$decoder = new Customweb_Xml_Binding_Decoder();
					$orderResponse = $decoder->decodeFromDom($details, 
							"Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse");
					/**
					 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse $orderResponse
					 */
					if($orderResponse->getErrorMessage() == null){
						$errorMessage = 'Unkown Error';
					}
					else{
						$errorMessage = $orderResponse->getErrorMessage()->get();
						$userMessage =$paymentMethod->formatFailureReasonCustomerErrorMessage($errorMessage, null);
					}
				}
				else {
					$errorMessage = 'Unkown Error';
				}
				throw new Customweb_Payment_Exception_PaymentErrorException(
							new Customweb_Payment_Authorization_ErrorMessage($userMessage, $errorMessage));
			}
			
			$parameters = array();
			
			$oid = $response->getOrderId()->__toString();
			$parameters['txntype'] = $paymentMethod->getCapturingMode($transaction);
			$parameters['oid'] = $oid;
			$parameters['tdate'] = $response->getTDate()->__toString();
			$parameters['approval_code'] = $response->getApprovalCode()->__toString();
			$parameters['status'] = $response->getTransactionResult()->__toString();
			if ($response->getProcessorReferenceNumber() != null) {
				$parameters['refnumber'] = $response->getProcessorReferenceNumber()->__toString();
			}
			if ($response->getProcessorReceiptNumber() != null) {
				$parameters['receiptnumber'] = $response->getProcessorReceiptNumber()->__toString();
			}
			
			$transaction->setAuthorizationParameters($parameters);
			$authorizationHandler = $this->getContainer()->getBean('Customweb_FirstDataConnect_Authorization_AuthorizationHandler');
			$authorizationHandler->handleAuthorizationNoHashCheck($transaction, $parameters);
		}
		catch (Customweb_Payment_Exception_PaymentErrorException $pe) {
			$transaction->setAuthorizationFailed($pe->getErrorMessage());
		}
		catch (Exception $e) {
			$transaction->setAuthorizationFailed(
					new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("An unexpected error occurred."), $e->getMessage()));
		}
		if ($transaction->isAuthorizationFailed()) {
			return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
		}
		return Customweb_Core_Http_Response::redirect($transaction->getSuccessUrl());
	}
}
