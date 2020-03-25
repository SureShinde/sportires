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




class Customweb_FirstDataConnect_Authorization_Hidden_ParameterBuilder extends Customweb_FirstDataConnect_Authorization_AbstractParameterBuilder {



	public function buildParameters() {
		$parameters = array_merge_recursive(
				$this->getBasicParameters(),
				$this->getBypassParameters(),
				$this->getPaymentMethod()->getAuthorizationParameters(
						$this->getTransaction(),
						$this->getFormData(),
						$this->getTransaction()->getAuthorizationMethod()
				)
		);
		$parameters['hash_algorithm'] = 'SHA256';
		$parameters['hash'] = Customweb_FirstDataConnect_Util::calculateHash($parameters,$this->getConfiguration()->getConnectSharedSecret());
		return $parameters;
	}
	
	public function getBypassParameters() {
		return array( 'full_bypass' => 'true');
	}

}