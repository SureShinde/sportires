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
 * @Method(paymentMethods={'CreditCard', 'Diners', 'Mastercard', 'Visa', 'AmericanExpress', 'Maestro', 'Maestrouk', 'Jcb'})
 */
class Customweb_FirstDataConnect_Method_CreditCardMethod extends Customweb_FirstDataConnect_Method_DefaultMethod {

	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, $isMoto) {
		$elements = array();
		
		if ($authorizationMethod == Customweb_Payment_Authorization_Hidden_IAdapter::AUTHORIZATION_METHOD_NAME) {
			$formBuilder = new Customweb_Payment_Authorization_Method_CreditCard_ElementBuilder();
				
			// Set field names
			$formBuilder
				->setBrandFieldName('paymentMethod')
				->setCardHolderFieldName(null)
				->setCardNumberFieldName('cardnumber')
				->setCvcFieldName('cvm')
				->setExpiryMonthFieldName('expmonth')
				->setExpiryYearFieldName('expyear')
				->setExpiryYearNumberOfDigits(2);
				
				
			// Handle brand selection
			if (strtolower($this->getPaymentMethodName()) == 'creditcard') {
				$formBuilder
					->setCardHandlerByBrandInformationMap($this->getPaymentInformationMap(), $this->getPaymentMethodConfigurationValue('credit_card_brands'), 'paymentType')
					->setAutoBrandSelectionActive(true);
				
				if ($this->getPaymentMethodConfigurationValue('brand_selection') == 'active') {
					$formBuilder->setImageBrandSelectionActive(true);
				}
				else {
					$formBuilder->setImageBrandSelectionActive(false);
				}
			}
			else {
				$formBuilder
					->setCardHandlerByBrandInformationMap($this->getPaymentInformationMap(), $this->getPaymentMethodName(), 'paymentType')
					->setSelectedBrand($this->getPaymentMethodName())
					->setFixedBrand(true)
				;
			}
				
			// Set context values
			if($aliasTransaction !== null && $aliasTransaction !== 'new'){
				$params = $aliasTransaction->getAuthorizationParameters();
				$formBuilder
					->setMaskedCreditCardNumber($params['cardnumber'])
					//->setCardHolderName($aliasTransaction->getCardHolderName())
					->setSelectedExpiryMonth($params['expmonth'])
					->setSelectedExpiryYear($params['expyear'])
					->setSelectedBrand($formBuilder->getCardHandler()->mapExternalBrandNameToBrandKey($params['paymentMethod']));
			}
			
			if ($isMoto) {
				$formBuilder->setForceCvcOptional(true);
			}
			
			
			return $formBuilder->build();
		}
		return $elements;
	}
	
	public function getAuthorizationParameters(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $formData, $authorizationMethod) {
		$parameters = array();
		if ($authorizationMethod == Customweb_Payment_Authorization_PaymentPage_IAdapter::AUTHORIZATION_METHOD_NAME || $authorizationMethod == Customweb_Payment_Authorization_Moto_IAdapter::AUTHORIZATION_METHOD_NAME) {
			$parameters['paymentMethod'] = $this->getPaymentType();
		}
		if ($this->getPaymentMethodConfigurationValue('threeD_active') == 'deactivated') {
			$parameters['authenticateTransaction'] = 'false'; 
			
		}
		return $parameters;
	}
	
}