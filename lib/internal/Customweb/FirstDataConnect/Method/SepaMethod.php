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
*/



/**
 *
 * @author nicoeigenmann
 * @Method(paymentMethods={'DirectDebitsSepa'})
 */
class Customweb_FirstDataConnect_Method_SepaMethod extends Customweb_FirstDataConnect_Method_DefaultMethod {
	
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_FirstDataConnect_Method_DefaultMethod::getFormFields()
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, $isMoto) {
		$elements = parent::getFormFields($orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, $isMoto);
		if (Customweb_Payment_Authorization_Hidden_IAdapter::AUTHORIZATION_METHOD_NAME == $authorizationMethod ) {
				
			$errorIBAN = null;
			
			$formBuilder = new Customweb_Payment_Authorization_Method_Sepa_ElementBuilder();
				
			// Set field names
			$formBuilder->setIbanFieldName('iban');
			if ($failedTransaction !== null) {
				$failedParameters = $failedTransaction->getAuthorizationParameters();
				$detailedError = $failedParameters['fail_reason_details'];
				if(strpos($detailedError, 'iban') !== false) {
					$errorIBAN = Customweb_I18n_Translation::__("You have to enter a valid IBAN");
				}
				$formBuilder->setIbanErrorMessage($errorIBAN);
			}
			$elements = array_merge($elements, $formBuilder->build());
		}
		return $elements;
	}

	
	public function getAuthorizationParameters(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $formData, $authorizationMethod) {
		$parameters = parent::getAuthorizationParameters($transaction, $formData, $authorizationMethod);
		
		if (Customweb_Payment_Authorization_Server_IAdapter::AUTHORIZATION_METHOD_NAME == $authorizationMethod) {
				
			if (empty($formData['iban'])) {
				throw new Exception(Customweb_I18n_Translation::__("You have to enter an IBAN."));
			}
			$parameters['iban'] = strip_tags($formData['iban']);
	
		}
		
		return $parameters;
	}

}