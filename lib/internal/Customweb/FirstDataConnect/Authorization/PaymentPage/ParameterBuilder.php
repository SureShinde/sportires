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


class Customweb_FirstDataConnect_Authorization_PaymentPage_ParameterBuilder extends Customweb_FirstDataConnect_Authorization_AbstractParameterBuilder {

	public function buildParameters(){
		$parameters = array_merge($this->getBasicParameters(),
				$this->getPaymentMethod()->getAuthorizationParameters($this->getTransaction(), $this->getFormData(),
						$this->getTransaction()->getAuthorizationMethod()));
		$mobileMode = false;
		
		if ($this->getConfiguration()->isDeviceDetection()) {
			try {
				$detect = new Customweb_Mobile_Detect($this->getContainer()->getBean("Customweb_Core_Http_IRequest"));
				if ($detect->isMobileDevice() && !$detect->isTabletDevice()){
					$mobileMode = true;
				}
			}
			catch (Exception $exc) {
				// in case there is any issue detecting, or retrieving request do not fail, but fall back to responsive
			}
		}
		if($mobileMode){
			$parameters['mobileMode'] = 'true';
		}
		else{
			//The hostedData feature is not available on the combined page
			if(!isset($parameters['hosteddataid'])){
				$parameters['checkoutoption'] = 'combinedpage';
			}
		}
		
		$parameters['hash_algorithm'] = 'SHA256';
		$parameters['hashExtended'] = Customweb_FirstDataConnect_Util::calculateExtendedHash($parameters,
				$this->getConfiguration()->getConnectSharedSecret());
		return $parameters;
	}
}