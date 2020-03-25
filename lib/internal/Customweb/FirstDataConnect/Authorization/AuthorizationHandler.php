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
class Customweb_FirstDataConnect_Authorization_AuthorizationHandler {
	private $container;

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		$this->container = new Customweb_FirstDataConnect_Container($container);
	}

	public function getConfigurationAdapter(){
		return $this->getConfiguration()->getConfigurationAdapter();
	}

	public function getConfiguration(){
		return $this->getContainer()->getConfiguration();
	}

	public function getContainer(){
		return $this->container;
	}

	public function handleAuthorizationWithHashCheck(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $parameters){
		/*
		 * @var Customweb_FirstDataConnect_Authorization_Transaction $transaction
		 */
		if ($transaction->isAuthorized() || $transaction->isAuthorizationFailed()) {
			return $this->finalizeAuthorizationRequest($transaction);
		}
		
		$transaction->setAuthorizationParameters($parameters);
		if (isset($parameters['oid'])) {
			$transaction->setPaymentId($parameters['oid']);
		}
		
		if (isset($parameters['notification_hash'])) {
			$computedHash = '';
			if ($transaction->isMoto()) {
				$computedHash = Customweb_FirstDataConnect_Util::calculateNotificationHash($parameters, 
						$this->getConfiguration()->getMotoConnectSharedSecret(), $this->getConfiguration()->getMotoStoreId());
			}
			else {
				$computedHash = Customweb_FirstDataConnect_Util::calculateNotificationHash($parameters, 
						$this->getConfiguration()->getConnectSharedSecret(), $this->getConfiguration()->getStoreId());
			}
			
			if ($computedHash != trim($parameters['notification_hash'])) {
				$transaction->setAuthorizationFailed(new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__('The transaction failed.'),Customweb_I18n_Translation::__('Transaction notification verification failed.')));
				return $this->finalizeAuthorizationRequest($transaction);
			}
		}
		else {
			$backendMessage = Customweb_I18n_Translation::__('No hash provided');
			if(!isset($parameters['approval_code'])){
				$backendMessage = Customweb_I18n_Translation::__('The return parameters from FirstData Connect are missing. Please check the Force Non SSL Notification Setting and your rewrite rules.');
			}
			
			$transaction->setAuthorizationFailed(new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__('The transaction failed. Please contact us.'),$backendMessage));
			return $this->finalizeAuthorizationRequest($transaction);
		}
		return $this->handleAuthorizationNoHashCheck($transaction, $parameters);
	}

	public function handleAuthorizationNoHashCheck(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $parameters){
		$transaction->setAuthorizationParameters($parameters);
		if (isset($parameters['oid'])) {
			$transaction->setPaymentId($parameters['oid']);
		}
		
		$paymentMethod = $this->getContainer()->getPaymentMethodByTransaction($transaction);
		$approvalCode = $parameters['approval_code'];
		if (empty($approvalCode)) {
			$transaction->setAuthorizationFailed(Customweb_I18n_Translation::__('Approval Code missing'));
			return $this->finalizeAuthorizationRequest($transaction);
		}
		switch (substr($approvalCode, 0, 1)) {
			case 'Y':
				//Successful
				if (isset($parameters['response_code_3dsecure'])) {
					//Transaction with 3d secure
					switch ($parameters['response_code_3dsecure']) {
						case 1: //successful
						case 2: //successful without AVV
							$transaction->authorize();
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_SUCCESS);
							break;
						
						case 4: //Authorization Attempted (card may be not enrolled)
							$transaction->authorize();
							if (in_array(Customweb_FirstDataConnect_IConstants::THREE_D_AUTH_ATTEMPTED, 
									$this->getConfiguration()->getUncertain3dstates())) {
								$transaction->setAuthorizationUncertain();
							}
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_AUTH_ATTEMPTED);
							break;
						
						case 5: //Directory Server not responding
							$transaction->authorize();
							if (in_array(Customweb_FirstDataConnect_IConstants::THREE_D_DIR_SERVER, 
									$this->getConfiguration()->getUncertain3dstates())) {
								$transaction->setAuthorizationUncertain();
							}
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_DIR_SERVER);
							break;
						
						case 6: //Authorization Control Server not responding
							$transaction->authorize();
							if (in_array(Customweb_FirstDataConnect_IConstants::THREE_D_AUTH_SERVER, 
									$this->getConfiguration()->getUncertain3dstates())) {
								$transaction->setAuthorizationUncertain();
							}
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_AUTH_SERVER);
							break;
						
						case 7: //Not enrolled
							$transaction->authorize();
							if (in_array(Customweb_FirstDataConnect_IConstants::THREE_D_NOT_ENROLLED, 
									$this->getConfiguration()->getUncertain3dstates())) {
								$transaction->setAuthorizationUncertain();
							}
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_NOT_ENROLLED);
							break;
						
						case 3: //Failed
						case 8: //Invalid Response
						default:
							$transaction->setAuthorizationFailed(Customweb_I18n_Translation::__('3d Secure Verification failed'));
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_FAILED);
							break;
					}
				}
				else {
					//Transaction without 3d secure (ELV, GIROPAY,...) authorize
					$transaction->authorize();
					if (isset($parameters['status']) && strtolower($parameters['status']) == 'waiting') {
						$transaction->setAuthorizationUncertain();
					}
				}
				//Get Alias Parameters
				if (isset($parameters['hosteddataid']) && (($paymentMethod->isAliasManagerSupported() && $paymentMethod->isAliasManagerActive()) ||
						 $transaction->getTransactionContext()->createRecurringAlias())) {
					
					if (isset($parameters['cardnumber'])) {
						$aliasDisplay = 'xxxx-xxxx-xxxx-';
						$aliasDisplay .= substr($parameters['cardnumber'], -4);
						$aliasDisplay .= ' (' . $parameters['expmonth'] . '/' . $parameters['expyear'] . ')';
						$transaction->setAliasForDisplay($aliasDisplay);
						$transaction->setAlias($parameters['hosteddataid']);
					}
					elseif (isset($parameters['accountnumber'])) {
						$transaction->setAliasForDisplay('xx' . $parameters['accountnumber']);
						$transaction->setAlias($parameters['hosteddataid']);
					}
				}
				//Check Capturesettings
				$supportDeferred = $this->isDeferredCapturingSupported($transaction);
				if (!$supportDeferred ||
						 (isset($parameters['txntype']) && $parameters['txntype'] == Customweb_FirstDataConnect_IConstants::OPERATION_SALE)) {
					$transaction->capture();
				}
				break;
			case '?':
				//Pending
				if (isset($parameters['response_code_3dsecure'])) {
					//Transaction with 3d secure
					switch ($parameters['response_code_3dsecure']) {
						case 1: //successful
						case 2: //successful without AVV
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_STATUS_SUCCESS);
							break;
						
						case 4: //Authorization Attempted (card may be not enrolled)
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_AUTH_ATTEMPTED);
							break;
						
						case 5: //Directory Server not responding
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_STATUS_DIR_ERROR);
							break;
						
						case 6: //Authorization Control Server not responding
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_STATUS_AUTH_ERROR);
							break;
						
						case 7: //Not enrolled
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_STATUS_NOT_ENROLLED);
							break;
						
						case 3: //Failed
						case 8: //Invalid Response
						default:
							$transaction->setAuthorizationFailed(Customweb_I18n_Translation::__('3d Secure Verification failed'));
							$transaction->setThreeDSecureState(Customweb_FirstDataConnect_IConstants::THREE_D_STATUS_FAILED);
							return $this->finalizeAuthorizationRequest($transaction);
					}
				}

				if (!$transaction->isAuthorizationFailed()) {
					
					$transaction->authorize();
					$transaction->setAuthorizationUncertain();
					$transaction->setUpdateExecutionDate(Customweb_Core_DateTime::_()->addMinutes(10));
				}
				break;
			case 'N':
			default:
				
				//failed
				$reason = '';
				if (isset($parameters['fail_reason'])) {
					$details = null;
					if (isset($parameters['fail_reason_details'])) {
						$details = $parameters['fail_reason_details'];
					}
					$reason = $paymentMethod->formatFailureReasonCustomerErrorMessage($parameters['fail_reason'], $details);
				}
				else {
					$reason = Customweb_I18n_Translation::__("The transaction failed with an unkown error.");
				}
				
				// In test mode amounts with digits after the decimal point are rejected
				if ($this->getConfiguration()->isTestMode()) {
					$roundedToCent = Customweb_Util_Currency::roundAmount($transaction->getAuthorizationAmount(), $transaction->getCurrencyCode());
					$rounded = round($transaction->getAuthorizationAmount(), 0);
					if ($roundedToCent != $rounded) {
						$reason = Customweb_I18n_Translation::__(
								'In test mode amounts with decimal places fail. Only xx.00 is accepted: !originalReason', 
								array(
									'!originalReason' => $reason 
								));
					}
				}
				$reason = str_replace('"', "'", $reason);
				$transaction->setAuthorizationFailed($reason);
				break;
		}
		return $this->finalizeAuthorizationRequest($transaction);
	}

	public function finalizeAuthorizationRequest(Customweb_Payment_Authorization_ITransaction $transaction){
		return new Customweb_Core_Http_Response();
	}

	public function handleFailedTransaction(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $parameters){
		$paymentMethod = $this->getContainer()->getPaymentMethodByTransaction($transaction);
		//failed
		$reason = '';
		if (isset($parameters['fail_reason'])) {
			$details = null;
			if (isset($parameters['fail_reason_details'])) {
				$details = $parameters['fail_reason_details'];
			}
			$reason = $paymentMethod->formatFailureReasonCustomerErrorMessage($parameters['fail_reason'], $details);
		}
		else {
			$reason = Customweb_I18n_Translation::__("The transaction failed with an unkown error.");
		}
		
		// In test mode amounts with digits after the decimal point are rejected
		if ($this->getConfiguration()->isTestMode()) {
			$roundedToCent = Customweb_Util_Currency::roundAmount($transaction->getAuthorizationAmount(), $transaction->getCurrencyCode());
			$rounded = round($transaction->getAuthorizationAmount(), 0);
			if ($roundedToCent != $rounded) {
				$reason = Customweb_I18n_Translation::__('In test mode amounts with decimal places fail. Only xx.00 is accepted');
			}
		}
		$reason = str_replace('"', "'", $reason);
		$transaction->setAuthorizationParameters($parameters);
		$transaction->setAuthorizationFailed($reason);
		return "redirect:" . $transaction->getFailedUrl();
	}

	public function isDeferredCapturingSupported(Customweb_FirstDataConnect_Authorization_Transaction $transaction){
		$paymentMethod = $this->getContainer()->getPaymentMethodByTransaction($transaction);
		return $paymentMethod->isDeferredCapturingSupported();
	}
}
	