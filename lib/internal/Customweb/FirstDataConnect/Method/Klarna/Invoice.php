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
 * @author Nico Eigenmann
 * @Method(paymentMethods={'KlarnaOpenInvoice'})
 */
class Customweb_FirstDataConnect_Method_Klarna_Invoice extends Customweb_FirstDataConnect_Method_Klarna_Abstract {

	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, $isMoto){
		$fields = array();
		
		return array_merge($fields, 
				$this->getAdditionalInputFields($orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, $isMoto), $this->getConditionsElement($orderContext));
	}
	
	
	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, array $formData){
		parent::validate($orderContext, $paymentContext, $formData);
		$billingAddress = $orderContext->getBillingAddress();
		if (strtoupper($billingAddress->getCountryIsoCode()) != 'NL' && (!isset($formData['klarna_conditions_checkbox']) || $formData['klarna_conditions_checkbox'] != 'accepted')) {
			throw new Exception(Customweb_I18n_Translation::__('Please accept the terms and conditions.')->toString());
		}
		
	}

	private function getConditionsElement(Customweb_Payment_Authorization_IOrderContext $orderContext){
		$conditionElementId = 'firstdataconnect-klarna-conditions-' . uniqid();
		$consentElementId = 'firstdataconnect-klarna-consent-' . uniqid();
		$klarnaMerchantId = $this->getPaymentMethodConfigurationValue('klarna_merchant_id');
		$invoiceFee = Customweb_Util_Currency::formatAmount($this->getInvoiceFee($orderContext), $orderContext->getCurrencyCode());
		$htmlContent = '<span id=\'' . $conditionElementId . '\'></span>';
		$htmlContent .= '<script src=\'https://cdn.klarna.com/public/kitt/core/v1.0/js/klarna.min.js\'></script>';
		$htmlContent .= '<script src=\'https://cdn.klarna.com/public/kitt/toc/v1.1/js/klarna.terms.min.js\'></script>';
		$htmlContent .= '<script type=\'text/javascript\'>';
		$htmlContent .= 'function klarnaTermsCallback() {';
		
		$htmlContent .= 'new Klarna.Terms.Invoice({ el: \'' . $conditionElementId . '\',  eid: \'' . $klarnaMerchantId . '\', locale: \'' .
				$this->getLanguageCode($orderContext) . '\', charge: ' . $invoiceFee. ' });';
		$htmlContent .= 'new Klarna.Terms.Consent({ el: \'' . $consentElementId . '\',  eid: \'' . $klarnaMerchantId . '\', locale: \'' .
				 $this->getLanguageCode($orderContext) . '\' });';
		$htmlContent .= '};';
		$htmlContent .= 'function klarnaCallback() { var klarnaTermsScript = document.createElement(\'script\'); klarnaTermsScript.src = \'https://cdn.klarna.com/public/kitt/toc/v1.1/js/klarna.terms.min.js\'; document.getElementsByTagName(\'head\')[0].appendChild(klarnaTermsScript); klarnaTermsScript.onload=klarnaTermsCallback; };';
		$htmlContent .= 'var klarnaScript = document.createElement(\'script\'); klarnaScript.src = \'https://cdn.klarna.com/public/kitt/core/v1.0/js/klarna.min.js\'; document.getElementsByTagName(\'head\')[0].appendChild(klarnaScript); klarnaScript.onload=klarnaCallback;';
		$htmlContent .= '</script>';
		$htmlControl = new Customweb_Form_Control_Html('klarna_conditions_popup', $htmlContent);
		
		$checkboxControl = new Customweb_Form_Control_SingleCheckbox('klarna_conditions_checkbox', 'accepted', 
				Customweb_I18n_Translation::__(
						'I agree that that Klarna can use my adress data for identity and scoring checks. I am aware that I can revoke my !consent at any time in the future. The general terms and conditions of the merchant apply.', 
						array(
							'!consent' => '<span id="' . $consentElementId . '"></span>' 
						)));
		$checkboxControl->addValidator(
				new Customweb_Form_Validator_Checked($checkboxControl, Customweb_I18n_Translation::__('Please accept the terms and conditions.')));
		
		
		$subControlls =	array(
			$htmlControl,
		);
		$required = false;
		
		if(strtoupper($orderContext->getBillingAddress()->getCountryIsoCode()) != 'NL'){
			$subControlls[] =$checkboxControl;
			$required = true;
		}
		
		$control = new Customweb_Form_Control_MultiControl('klarna_conditions',$subControlls);
		
		$elements = array();
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('Terms and Conditions'), $control);
		$element->setRequired($required);
		$elements[] = $element;
		return $elements;
	}


	public function getServerAPIOrderRequest(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $formData){
		return $this->createServerRequest($transaction, $formData, -1);

	}
	
	private function getInvoiceFee(Customweb_Payment_Authorization_IOrderContext $orderContext) {
		$feeAmount = 0;
		foreach ($orderContext->getInvoiceItems() as $item) {
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_FEE) {
				$feeAmount += $item->getAmountIncludingTax();
			}
		}
		return $feeAmount;
	}
	
	protected function isFeeExtraItem(){
		return true;
	}
	
	protected function forceFeeExtra(){
		return true;
	}
}