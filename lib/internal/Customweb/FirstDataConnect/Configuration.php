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
 * @Bean
 */
class Customweb_FirstDataConnect_Configuration {

	/**
	 * @var Customweb_Payment_IConfigurationAdapter
	 */
	private $configurationAdapter = null;

	public function __construct(Customweb_Payment_IConfigurationAdapter $configurationAdapter) {
		$this->configurationAdapter = $configurationAdapter;
	}

	/**
	 * @return Customweb_Payment_IConfigurationAdapter
	 */
	public function getConfigurationAdapter() {
		return $this->configurationAdapter;
	}

	/**
	 * Return a configuration value by it's key.
	 *
	 * @param string $key
	 * @return string
	 */
	public function getConfigurationValue($key) {
		return $this->configurationAdapter->getConfigurationValue($key);
	}

	/**
	 * Return in what mode the transactions should be processed in. Possible values are 'live',
	 * 'test'.
	 *
	 * @return string
	 */
	public function getOperationMode() {
		return $this->getConfigurationValue('operation_mode');
	}

	/**
	 * Return whether a test mode is active.
	 *
	 * @return boolean
	 */
	public function isTestMode() {
		if (strtolower($this->getOperationMode()) == 'live') {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Return whether the alias manager is active.
	 *
	 * @return boolean
	 */
	public function isAliasManagerActive() {
		$alias_manager = strtolower($this->getConfigurationValue('alias_manager'));
		if ($alias_manager == 'active') {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Return the transaction id schema.
	 *
	 * @return string
	 */
	public function getOrderIdSchema() {
		return $this->getConfigurationValue('order_id_schema');
	}

	/**
	 * Return the url to be used to send transaction requests.
	 *
	 * @return string
	 */
	public function getBaseUrl() {
		if ($this->isTestMode()) {
			return 'https://test.ipg-online.com/';
		} else {
			return 'https://www.ipg-online.com/';
		}
	}
	
	public function getUncertain3dstates() {
		return $this->getConfigurationValue("three_d_secure_behavior");
	}
	
	public function getStoreId() {
		$value = '';
		if ($this->isTestMode()){
			$value = $this->getConfigurationValue('test_store_id');
		}
		if (empty($value)) {
			$value = $this->getConfigurationValue('store_id');
		}
		return $value;
	}
	
	public function getConnectSharedSecret() {
		$value = '';
		if ($this->isTestMode()){
			$value = $this->getConfigurationValue('test_connect_shared_secret');
		}
		if(empty($value)) {
			$value = $this->getConfigurationValue('connect_shared_secret');
		}
		return $value;
	}
	

	public function getAPIUserId() {
		$value = '';
		if ($this->isTestMode()) {
			$value = $this->getConfigurationValue('test_api_user_id');
		}
		if (empty($value)) {
			$value = $this->getConfigurationValue('api_user_id');
		}
		return $value;
	}
	
	public function getAPIPassword() {
		$value = '';
		if ($this->isTestMode()) {
			$value = $this->getConfigurationValue('test_api_password');
		}
		if(empty($value)) {
			$value = $this->getConfigurationValue('api_password');
		}
		return $value;
		
	}
	
	public function getClientCertificatePassPhrase() {
		$value = '';
		if($this->isTestMode()) {
			$value = $this->getConfigurationValue('test_client_certificate_passphrase');
		}
		if(empty($value)) {
			$value = $this->getConfigurationValue('client_certificate_passphrase');
		}
		return $value;
	}
	/*
	public function getAPIUserName() {
		return 'WS'.$this->getStoreId().'._.'.$this->getAPIUserId();
	}
	*/
	
	
	public function getMotoStoreId() {
		$value = '';
		if($this->isTestMode()) {
			$value = $this->getConfigurationValue('test_moto_store_id');
		}
		if(empty($value)) {
			$value = $this->getConfigurationValue('moto_store_id');
		}
		return $value;
	}
	
	public function getMotoConnectSharedSecret() {
		$value = '';
		if($this->isTestMode()) {
			$value = $this->getConfigurationValue('test_moto_connect_shared_secret');
		}
		if(empty($value)) {
			$value = $this->getConfigurationValue('moto_connect_shared_secret');
		}
		return $value;
	}
	
	
	public function getMotoAPIUserId() {
		$value = '';
		if($this->isTestMode()) {
			$value = $this->getConfigurationValue('test_moto_api_user_id');
		}
		if(empty($value)) {
			$value = $this->getConfigurationValue('moto_api_user_id');
		}
		return $value;
	}
	
	public function getMotoAPIPassword() {
		$value = '';
		if($this->isTestMode()) {
			$value = $this->getConfigurationValue('test_moto_api_password');
		}
		if(empty($value)) {
			$value = $this->getConfigurationValue('moto_api_password');
		}
		return $value;
	
	}
	
	public function getMotoClientCertificatePassPhrase() {
		$value = '';
		if($this->isTestMode()) {
			$value = $this->getConfigurationValue('test_moto_client_certificate_passphrase');
		}
		if(empty($value)) {
			$value = $this->getConfigurationValue('moto_client_certificate_passphrase');
		}
		return $value;
	}
	
	
	public function isForcedNonSSlNotification() {
		if($this->getConfigurationValue('force_non_ssl') == 'true') {
			return true;
		}
		return false;
	}
	
	
	public function isDeviceDetection(){
		return $this->getConfigurationValue('page_mobile_detection') == 'mobile';			
	}
		
}

