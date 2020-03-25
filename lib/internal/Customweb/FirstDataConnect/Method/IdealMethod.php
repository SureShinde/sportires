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
 *         @Method(paymentMethods={'Ideal'})
 */
class Customweb_FirstDataConnect_Method_IdealMethod extends Customweb_FirstDataConnect_Method_DefaultMethod {
	private static $issuerListLive = array (
			
			'ABNANL2A' => 'ABN AMRO',
			'ASNBNL21' => 'ASN Bank',
			'BUNQNL2A' => 'Bunq',
			'INGBNL2A' => 'ING',
			'KNABNL2H' => 'Knab',
			'RABONL2U' => 'Rabobank',
			'RBRBNL21' => 'RegioBank',
			'SNSBNL2A' => 'SNS Bank',
			'TRIONL2U' => 'Triodos Bank',
			'FVLBNL22' => 'van Lanschot' 
	)
	;
	private static $issuerListTest = array (
			'INGBNL2A' => 'Issuer Simulation ING',
			'RABONL2U' => 'Issuer Simulation RABO' 
	);
	
	/**
	 * This method returns a list of form elements.
	 * This form elements are used to generate the user input.
	 * Sub classes may override this method to provide their own form fields.
	 *
	 * @return array List of form elements
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, $isMoto) {
		$elements = parent::getFormFields ( $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, $isMoto );
		
		if ($authorizationMethod == Customweb_Payment_Authorization_Hidden_IAdapter::AUTHORIZATION_METHOD_NAME) {
			$options = array ();
			if ($this->getGlobalConfiguration ()->isTestMode ()) {
				$options = self::$issuerListTest;
			} else {
				$options = self::$issuerListLive;
			}
			
			$issuerControl = new Customweb_Form_Control_Select ( 'idealIssuerID', $options );
			$issuerControl->addValidator ( new Customweb_Form_Validator_NotEmpty ( $issuerControl, 'Please select your issuing bank.' ) );
			$issuerElement = new Customweb_Form_Element ( Customweb_I18n_Translation::__ ( 'Please select your issuing bank.' ), $issuerControl );
			$elements [] = $issuerElement;
		}
		
		return $elements;
	}
}