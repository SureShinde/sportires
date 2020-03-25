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
class Customweb_FirstDataConnect_Authorization_Recurring_Adapter extends Customweb_FirstDataConnect_Authorization_AbstractAdapter implements 
		Customweb_Payment_Authorization_Recurring_IAdapter {

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

	public function createTransaction(Customweb_Payment_Authorization_Recurring_ITransactionContext $transactionContext){
		$transaction = new Customweb_FirstDataConnect_Authorization_Transaction($transactionContext);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);
		$transaction->setLiveTransaction(!$this->getConfiguration()->isTestMode());
		return $transaction;
	}

	public function process(Customweb_Payment_Authorization_ITransaction $transaction){
		try {
			$date = date('Ymd');
			$formattedAmount = Customweb_Util_Currency::formatAmount(
					$transaction->getTransactionContext()->getOrderContext()->getOrderAmountInDecimals(), 
					$transaction->getTransactionContext()->getOrderContext()->getCurrencyCode());
			$currency = Customweb_FirstDataConnect_Util::getNumericCurrencyCode(
					$transaction->getTransactionContext()->getOrderContext()->getCurrencyCode());
			
			$initalAlias = $transaction->getTransactionContext()->getInitialTransaction()->getAlias();
			if ($initalAlias == null || $initalAlias == 'new') {
				throw new Exception('No Alias found for this transaction');
			}
			$isMoto = $transaction->getTransactionContext()->getInitialTransaction()->isMoto();
			$urlString = $this->getBaseUrl() . Customweb_FirstDataConnect_IConstants::URL_API;
			$orderId = Customweb_FirstDataConnect_Util::getOrderAppliedSchema($transaction, $this->getConfiguration());
			
			//Create XML
			$ipgFunction = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Function::INSTALL();
			$ipgRecurringDetails = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation();
			$ipgRecurringDetails->setRecurringStartDate(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate::_()->set($date))->setInstallmentCount(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentCount::_()->set(1))->setInstallmentFrequency(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentFrequency::_()->set(1))->setInstallmentPeriod(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentPeriod::DAY());
			
			$ipgPayment = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment();
			$ipgPayment->setCurrency(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType::_()->set($currency))->setChargeTotal(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType::_()->set($formattedAmount))->setHostedDataID(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max::_()->set($initalAlias));
			
			$ipgRecurringPayment = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment();
			$ipgRecurringPayment->setRecurringPaymentInformation($ipgRecurringDetails)->setFunction($ipgFunction)->setPayment($ipgPayment)->setOrderId(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max::_()->set($orderId));
			if ($isMoto) {
				$ipgRecurringPayment->setTransactionOrigin(
						Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionOrigin::MOTO());
			}
			else {
				$ipgRecurringPayment->setTransactionOrigin(
						Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionOrigin::ECI());
			}
			
			$ipgAction = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Action();
			$ipgAction->setRecurringPayment($ipgRecurringPayment);
			
			$actionRequest = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionRequest();
			$actionRequest->setAction($ipgAction);
			
			$service = new Customweb_FirstDataConnect_SoapService($this->getAPIUser($isMoto), $this->getAPIPassword($isMoto), $this->getAPIUrl());
			$service->setClientCertificate(Customweb_FirstDataConnect_Util::getCertificate($this->getConfiguration(), $isMoto));
			$service->setClientCertificatePassphrase($this->getCertificatePassphrase($isMoto));
			
			//Send XML handle response
			
			try {
				$response = $service->iPGApiAction($actionRequest);
			}
			catch (Customweb_Soap_Exception_SoapFaultException $e) {
				$userMessage = Customweb_I18n_Translation::__("An unexpected error occurred.");
				$errorMessage = null;
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
					$errorMessage = $orderResponse->getErrorMessage()->get();
				}
				else {
					$errorMessage = 'Unkown Error';
				}
				$transaction->setAuthorizationFailed(new Customweb_Payment_Authorization_ErrorMessage($userMessage, $errorMessage));
				throw new Customweb_Payment_Exception_RecurringPaymentErrorException($errorMessage);
			}
			
			
			$parameters = array();
			$parameters['oid'] = $orderId;
			$transaction->setPaymentId($orderId);
			
			$userMessage = Customweb_I18n_Translation::__("The transaction failed.");
			$errorMessage = null;
			if ($response->getSuccessfully()->get() === false) {
				$errorMessage = 'Error executing request';
			}
			if ($response->getError() != null) {
				$error = $response->getError();
				if($response->getError()->getErrorMessage() != null){
					$errorMessage = $response->getError()->getErrorMessage()->get();
				}
				if($error->getCode() != null){
					$errorMessage .= ' '.Customweb_I18n_Translation::__("Error Code: !code", array("!code" => $error->getCode()->get()));
				}
			}
			if (!empty($errorMessage)) {
				$transaction->setAuthorizationParameters($parameters);
				$transaction->setAuthorizationFailed(new Customweb_Payment_Authorization_ErrorMessage($userMessage, $errorMessage));
				throw new Customweb_Payment_Exception_RecurringPaymentErrorException($errorMessage);
			}
			
			$orderResponse = $response->getTransactionValues()->getIPGApiOrderResponse();
			$parameters['tdate'] = $orderResponse->getTDate()->get();
			$parameters['approval_code'] = $orderResponse->getApprovalCode()->get();
			
			$parameters['hosteddataid'] = $initalAlias;
			
			if ($orderResponse->getProcessorReferenceNumber() != null) {
				$parameters['refnumber'] = $orderResponse->getProcessorReferenceNumber()->get();
			}
			if ($orderResponse->getProcessorReceiptNumber() != null) {
				$parameters['receiptnumber'] = $orderResponse->getProcessorReceiptNumber()->get();
			}
			
			$initialTransaction = $transaction->getTransactionContext()->getInitialTransaction();
			$initialParameters = $initialTransaction->getAuthorizationParameters();
			//Store Parameters
			if (isset($initialParameters['expyear'])) {
				$parameters['expyear'] = $initialParameters['expyear'];
			}
			
			if (isset($initialParameters['expmonth'])) {
				$parameters['expmonth'] = $initialParameters['expmonth'];
			}
			
			if (isset($initialParameters['cardnumber'])) {
				$parameters['cardnumber'] = $initialParameters['cardnumber'];
			}
			
			if (isset($initialParameters['accountnumber'])) {
				$parameters['accountnumber'] = $initialParameters['accountnumber'];
			}
			
			if (isset($initialParameters['bankcode'])) {
				$parameters['bankcode'] = $initialParameters['bankcode'];
			}
			$transaction->setAlias($initialTransaction->getAlias());
			$transaction->setAliasForDisplay($initialTransaction->getAliasForDisplay());
			
			$transaction->setAuthorizationParameters($parameters);
			$transaction->authorize();
			
			$transaction->capture();
		}
		catch (Exception $e) {
			throw new Customweb_Payment_Exception_RecurringPaymentErrorException($e);
		}
	}
}
