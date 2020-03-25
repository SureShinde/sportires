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
 * @Method(paymentMethods={'KlarnaInstallments'})
 */
class Customweb_FirstDataConnect_Method_Klarna_Installment extends Customweb_FirstDataConnect_Method_Klarna_Abstract {
	
	private static $storageSpace = 'KlarnaInstallmentInfo';
	private static $cacheTime = 6; //in Hours
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, $isMoto){
		$fields = array();
		try {
			$rateConditionElements = $this->getRateAndConditionsElement($orderContext);
		}
		catch (Exception $e) {
			$htmlContent = Customweb_I18n_Translation::__("This payment method is currently not available, please select another one.");
			$htmlControl = new Customweb_Form_Control_Html('klarna_error', $htmlContent . $e->getMessage());
			$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('Error'), $htmlControl);
			$element->setRequired(false);
			return array(
				$element 
			);
		}
		return array_merge($fields, 
				$this->getAdditionalInputFields($orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, 
						$isMoto), $rateConditionElements);
	}

	private function getRateAndConditionsElement(Customweb_Payment_Authorization_IOrderContext $orderContext){
		$rateInfo = $this->getRateInformation($orderContext);
		$details = $rateInfo['details'];
		
		$consentElementId = 'firstdataconnect-klarna-consent-' . uniqid();
		$klarnaMerchantId = $this->getPaymentMethodConfigurationValue('klarna_merchant_id');
		
		$htmlContent = '<script src=\'https://cdn.klarna.com/public/kitt/toc/v1.1/js/klarna.terms.min.js\'></script>';
		$htmlContent .= '<script type=\'text/javascript\'>';
		$htmlContent .= 'function klarnaTermsCallback() {';
		$htmlContent .= 'new Klarna.Terms.Consent({ el: \'' . $consentElementId . '\',  eid: \'' . $klarnaMerchantId . '\', locale: \'' .
				 $this->getLanguageCode($orderContext) . '\' });';
		$htmlContent .= '};';
		$htmlContent .= 'function klarnaCallback() { var klarnaTermsScript = document.createElement(\'script\'); klarnaTermsScript.src = \'https://cdn.klarna.com/public/kitt/toc/v1.1/js/klarna.terms.min.js\'; document.getElementsByTagName(\'head\')[0].appendChild(klarnaTermsScript); klarnaTermsScript.onload=klarnaTermsCallback; };';
		$htmlContent .= 'var klarnaScript = document.createElement(\'script\'); klarnaScript.src = \'https://cdn.klarna.com/public/kitt/core/v1.0/js/klarna.min.js\'; document.getElementsByTagName(\'head\')[0].appendChild(klarnaScript); klarnaScript.onload=klarnaCallback;';
		$htmlContent .= '</script>';
		$htmlControl = new Customweb_Form_Control_Html('klarna_conditions_popup', $htmlContent);
		
		$pclassControl = new Customweb_Form_Control_HiddenInput('pclass', $rateInfo['pclass_id']);
		$currencySymbol = $details['monthly_invoice_fee']['symbol'];
		$rateContent = "<div><table style='width: 100%'><tbody>";
		$rateContent .= "<tr><td style='width: 300px'>" . $details['interest_rate']['label'] . "</td><td>" .
				 $details['interest_rate']['value'] . $details['interest_rate']['symbol'] . "</td></tr>";
				 $rateContent .= "<tr><td style='width: 300px'>" .  $details['monthly_invoice_fee']['label'] . "</td><td>" .
						 $details['monthly_invoice_fee']['value'] . $details['monthly_invoice_fee']['symbol'] . "</td></tr>";
						 $rateContent .= "<tr><td style='width: 300px'>" . $details['monthly_pay']['label'] . "</td><td>" .
				$details['monthly_pay']['value'] . $details['monthly_pay']['symbol']. "</td></tr>";
		$rateContent .= "</tbody></table></div><br />";
		$rateContent .= "<div>" . 				
				Customweb_I18n_Translation::__("Available credits from !symbol 199.99 (depending on the amount of your purchases), effective annual interest rate 18.07% * and total amount 218,57 !symbol * (* in case of full utilization of the credit and repayment in 12 monthly installments of !symbol 18.21 each). Here you will find <a href='!more' target='_blank'>further information</a>, <a href='!tac' target='_blank'>terms and conditions with revocation instructions</a> and <a href='!info' target='_blank'>standard information for consumer credit</a>.", 
				array(
					'!more' => 'https://cdn.klarna.com/1.0/shared/content/legal/terms/' . $klarnaMerchantId . '/' .
							 $this->getLanguageCode($orderContext) . '/account',
					'!tac' => 'https://cdn.klarna.com/1.0/shared/content/legal/' . $this->getLanguageCode($orderContext) . '/account/terms.pdf',
					'!info' => 'https://cdn.klarna.com/1.0/shared/content/legal/' . $this->getLanguageCode($orderContext) .
							 '/consumer_credit.pdf',
					'!symbol' => $currencySymbol
				)). 
				Customweb_I18n_Translation::__("<br />If your purchase with Klarna is higher than !symbol 199.99, you will receive a consumer credit agreement from Klarna with the request for signing. Until then your purchase is considered as invoice purchase.", array('!symbol' => $currencySymbol))."</div>";						
						
		
		$rateControl = new Customweb_Form_Control_Html('klarna_rate', $rateContent);
		
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
					$pclassControl,
					$rateControl,
					 
				);
		$required = false;
		if(strtoupper($orderContext->getBillingAddress()->getCountryIsoCode()) != 'NL'){
			$subControlls[] =$checkboxControl;
			$required = true;
		}
			
		$control = new Customweb_Form_Control_MultiControl('klarna_rate_conditions',$subControlls);
		
		$elements = array();
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('Terms and Conditions'), $control);
		$element->setRequired($required);
		$elements[] = $element;
		return $elements;
	}

	private function getRateInformation(Customweb_Payment_Authorization_IOrderContext $orderContext){
		$klarnaMerchantId = trim($this->getPaymentMethodConfigurationValue('klarna_merchant_id'));
		if (empty($klarnaMerchantId)) {
			throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__('Please configure the Klarna Merchant ID')->toString());
		}
		$klarnaSharedSecret = trim($this->getPaymentMethodConfigurationValue('klarna_shared_secret'));
		if (empty($klarnaSharedSecret)) {
			throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__('Please configure the Klarna Shared Secret')->toString());
		}
		$storage = $this->getContainer()->getStorage();
		
		$currencyCode = $orderContext->getCurrencyCode();
		$price = Customweb_Util_Currency::formatAmount(Customweb_Util_Invoice::getTotalAmountIncludingTax($orderContext->getInvoiceItems()), 
				$currencyCode, '', '');
		$language = $this->getLanguageCode($orderContext);
		
		$authorization = 'xmlrpc-4.2 ' . base64_encode(
				pack("H*", hash("sha256", $klarnaMerchantId . ":" . $currencyCode . ":" . $klarnaSharedSecret)));
		
		$storageKey = $currencyCode . $price . $language;
		$stored = $storage->read(self::$storageSpace, $storageKey);
		$validation = hash('sha256', $klarnaMerchantId . $this->getGlobalConfiguration()->getOperationMode());
		
		if ($stored == null || !isset($stored['data']) || !isset($stored['validation']) || $stored['validation'] != $validation ||
				 !isset($stored['updated']) || Customweb_Core_DateTime::_()->subtractHours(self::$cacheTime)->getTimestamp() > $stored['updated']) {
			$url = new Customweb_Core_Url($this->getKlarnaUrl());
			$url->appendQueryParameters(
					array(
						'merchant_id' => $klarnaMerchantId,
						'total_price' => $price,
						'currency' => $currencyCode,
						'locale' => $language 
					));
			
			$request = new Customweb_Core_Http_Request($url);
			$request->appendHeader(Customweb_Core_Http_Request::HEADER_KEY_AUTHORIZATION . ': ' . $authorization);
			$client = Customweb_Core_Http_Client_Factory::createClient();
			$response = $client->send($request);
			$result = json_decode($response->getBody(), true);
			if ($result === false) {
				throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__('Can not retrieve installment rates.'));
			}
			if (!isset($result['payment_methods'])) {
				throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__('Can not retrieve installment rates.'));
			}
			$methodList = $result['payment_methods'];
			$toUse = null;
			foreach ($methodList as $method) {
				if (isset($method['name']) && $method['name'] == 'Account') {
					$toUse = $method;
					break;
				}
			}
			if (empty($toUse)) {
				throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__('Can not retrieve installment rates.'));
			}
			$toStore = array(
				'data' => $toUse,
				'validation' => $validation,
				'updated' => Customweb_Core_DateTime::_()->getTimestamp() 
			);
			$storage->write(self::$storageSpace, $storageKey, $toStore);
			return $toUse;
		}
		else {
			return $stored['data'];
		}
	}

	public function preValidate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext){
		parent::preValidate($orderContext, $paymentContext);
		$this->getRateInformation($orderContext);
	}

	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, array $formData){
		parent::validate($orderContext, $paymentContext, $formData);
		$billingAddress = $orderContext->getBillingAddress();
		
		if (strtoupper($billingAddress->getCountryIsoCode()) != 'NL' && (!isset($formData['klarna_conditions_checkbox']) || $formData['klarna_conditions_checkbox'] != 'accepted')) {
			throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__('Please accept the terms and conditions.')->toString());
		}
		if (!isset($formData['pclass'])) {
			throw new Customweb_I18n_LocalizableException(
					Customweb_I18n_Translation::__("This payment method is currently not available, please select another one.")->toString());
		}
	}

	public function getServerAPIOrderRequest(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $formData){
		if (!isset($formData['pclass'])) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage(
							Customweb_I18n_Translation::__("This payment method is currently not available, please select another one."), 
							Customweb_I18n_Translation::__("Could not fetch installment plan from Klarna")));
		}
		return $this->createServerRequest($transaction, $formData, $formData['pclass']);
	}

	private function getKlarnaUrl(){
		if ($this->getGlobalConfiguration()->isTestMode()) {
			return 'https://api-test.klarna.com/touchpoint/checkout/';
		}
		return 'https://api.klarna.com/touchpoint/checkout/';
	}

	protected function isFeeExtraItem(){
		return false;
	}
	
	protected function forceFeeExtra(){
		return false;
	}
}