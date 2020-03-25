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



class Customweb_FirstDataConnect_Authorization_Transaction extends Customweb_Payment_Authorization_DefaultTransaction
{

	
	private $threeDSecureState = null;
	
	private $captureTDate = null;
	
	public function isMoto() {
		return ($this->getAuthorizationMethod() == Customweb_Payment_Authorization_Moto_IAdapter::AUTHORIZATION_METHOD_NAME);
	}
	
	public function getTDate() {
		$parameters = $this->getAuthorizationParameters();
		return $parameters['tdate'];
	}
	
	public function getCaptureTDate() {
		return $this->captureTDate;
	}
	
	public function setCaptureTDate($tDate) {
		$this->captureTDate = $tDate;
		
	}
	
	public function getTransactionSpecificLabels() {
		$labels = array();
		$params = $this->getAuthorizationParameters();
	
		if (isset($params['cardnumber'])) {
			$labels['cardnumber'] = array(
					'label' => Customweb_I18n_Translation::__('Card Number'),
					'value' => 'xxxx-xxxx-xxxx-'.substr($params['cardnumber'], -4),
			);
		}
		if (isset($params['expyear']) && isset($params['expmonth'])) {
			$labels['card_expiry'] = array(
					'label' => Customweb_I18n_Translation::__('Card Expiry Date'),
					'value' => $params['expmonth'] . '/' . $params['expyear']
			);
		}
		if (isset($params['accountnumber'])) {
			$labels['account_number'] = array(
				'label' => Customweb_I18n_Translation::__('Account Number'),
				'value' => $params['accountnumber']
			);
		}
		if (isset($params['bankcode'])) {
			$labels['bank_code'] = array(
				'label' => Customweb_I18n_Translation::__('Bank Code'),
				'value' => $params['bankcode']
			);	
		}
		if (isset($params['iban'])) {
			$labels['account_number'] = array(
					'label' => Customweb_I18n_Translation::__('IBAN'),
					'value' => $params['iban']
			);
		}
		if (isset($params['bic'])) {
			$labels['bank_code'] = array(
					'label' => Customweb_I18n_Translation::__('BIC'),
					'value' => $params['bic']
			);
		}
		if (isset($params['cccountry']) && $params['cccountry'] != "N/A") {
			$labels['card_country'] = array(
				'label' => Customweb_I18n_Translation::__('Card Country Origin'),
				'value' => $params['cccountry']
			);
		}

		if ($this->isMoto()) {
			$labels['moto'] = array(
				'label' => Customweb_I18n_Translation::__('MoTo'),
				'value' => Customweb_I18n_Translation::__('Yes'),
			);
		}
		if (isset($params['approval_code'])) {
			$labels['approval_code'] = array(
					'label' => Customweb_I18n_Translation::__('Approval Code'),
					'value' => $params['approval_code']
			);
			
			$splitted = explode(':', $params['approval_code']);
			if(count($splitted) == 5) {
				$labels['trans_id'] = array(
					'label' => Customweb_I18n_Translation::__('Trans ID'),
					'value' => $splitted[4]
				);
			}
		}
		if (isset($params['mandateReference']) && $params['mandateReference'] != '' ) {
			$labels['mandate_reference'] = array(
					'label' => Customweb_I18n_Translation::__('Mandate Reference'),
					'value' => $params['mandateReference']
			);
		}
		return $labels;
	}
	
	public function isCaptureClosable() {
		return false;
	}
	
	public function setThreeDSecureState($state){
		$this->threeDSecureState= $state;
		return $this;
	}
	
	public function getThreeDSecureState() {
		return $this->threeDSecureState;
	}
	
	
	
	protected function getState3DSecureLabel(){
		$labels = array();
		if($this->getThreeDSecureState() == Customweb_FirstDataConnect_IConstants::THREE_D_FAILED) {
			$labels['3DSecure'] = array(
					'label' => Customweb_I18n_Translation::__('3D Secure'),
					'value' => Customweb_I18n_Translation::__('Failed')
			);
		}
		elseif($this->getThreeDSecureState() == Customweb_FirstDataConnect_IConstants::THREE_D_SUCCESS) {
			$labels['3DSecure'] = array(
					'label' => Customweb_I18n_Translation::__('3D Secure'),
					'value' => Customweb_I18n_Translation::__('Successful')
			);
		}
			elseif($this->getThreeDSecureState() == Customweb_FirstDataConnect_IConstants::THREE_D_NOT_ENROLLED) {
			$labels['3DSecure'] = array(
					'label' => Customweb_I18n_Translation::__('3D Secure'),
					'value' => Customweb_I18n_Translation::__('Not enrolled')
			);
		}
		elseif($this->getThreeDSecureState() == Customweb_FirstDataConnect_IConstants::THREE_D_AUTH_ATTEMPTED) {
			$labels['3DSecure'] = array(
					'label' => Customweb_I18n_Translation::__('3D Secure'),
					'value' => Customweb_I18n_Translation::__('Authorization Attempted')
			);
		}
		elseif($this->getThreeDSecureState() == Customweb_FirstDataConnect_IConstants::THREE_D_AUTH_SERVER) {
			$labels['3DSecure'] = array(
					'label' => Customweb_I18n_Translation::__('3D Secure'),
					'value' => Customweb_I18n_Translation::__('Authentication Server Error')
			);
		}
		elseif($this->getThreeDSecureState() == Customweb_FirstDataConnect_IConstants::THREE_D_DIR_SERVER) {
			$labels['3DSecure'] = array(
					'label' => Customweb_I18n_Translation::__('3D Secure'),
					'value' => Customweb_I18n_Translation::__('Directory Server Error')
			);
		}
		return $labels;
	}

}