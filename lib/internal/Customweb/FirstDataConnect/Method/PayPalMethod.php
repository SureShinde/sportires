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
 * @Method(paymentMethods={'Paypal'})
 */
class Customweb_FirstDataConnect_Method_PayPalMethod extends Customweb_FirstDataConnect_Method_DefaultMethod {
	
	/**
	 * This method returns the parameters to add for processing an authorization request for this payment method. Sub classes
	 * may override this method. But they should call the parent and merge in their own parameters.
	 *
	 * @param Customweb_FirstDataConnect_Authorization_Transaction $transaction
	 * @param array $formData
	 * @return array
	 */
	public function getAuthorizationParameters(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $formData, $authorizationMethod) {
		$parameters = array();
		$parameters['paymentMethod'] = $this->getPaymentType();
		$parameters['full_bypass'] = 'true';
		return $parameters;
	}

}