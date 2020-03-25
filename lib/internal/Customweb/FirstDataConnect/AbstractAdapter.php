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



class Customweb_FirstDataConnect_AbstractAdapter {

	private $container;
	
	
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
	
		$this->container = $container;
	}
	
	public function getConfigurationAdapter() {
		return $this->getConfiguration()->getConfigurationAdapter();
	}
	
	
	public function getConfiguration() {
		return $this->getContainer()->getBean('Customweb_FirstDataConnect_Configuration');
	}
	

	public function getContainer() {
		return $this->container;
	}
	
	public function isTestMode() {
		return $this->getConfiguration()->isTestMode();
	}
	
	/**
	 * Return the base url to interact with the PSP.
	 *
	 * @return string
	 */
	public function getBaseUrl() {
		return $this->getConfiguration()->getBaseUrl();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Method_Factory
	 */
	public function getPaymentMethodFactory(){
		return $this->getContainer()->getBean('Customweb_FirstDataConnect_Method_Factory');
	}
	
	
	protected function getAPIUser($isMoto = false){
		if($isMoto) {
			return $this->getConfiguration()->getMotoAPIUserId();
		}
		else {
			return $this->getConfiguration()->getAPIUserId();
		}
	}
	
	protected function getAPIPassword($isMoto = false) {
		if($isMoto) {
			return $this->getConfiguration()->getMotoAPIPassword();
		}
		else {
			return $this->getConfiguration()->getAPIPassword();
		}
	}
	
	protected function getCertificatePassphrase($isMoto = false) {
		if($isMoto) {
			return $this->getConfiguration()->getMotoClientCertificatePassPhrase();
		}
		else {
			return $this->getConfiguration()->getClientCertificatePassPhrase();
		}
	}
	
	protected function getApiURl(){
		return $this->getBaseUrl().Customweb_FirstDataConnect_IConstants::URL_API;
	}

}