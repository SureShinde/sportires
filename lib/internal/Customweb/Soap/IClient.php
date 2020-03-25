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


interface Customweb_Soap_IClient {

	/**
	 * The method to make a SOAP call with the specified operation.
	 *
	 * @param Customweb_Soap_ICall $call The call object which defines the way how to call the remote service.
	 * @return object The parsed response (as defined in the call object).
	 */
	public function invokeOperation(Customweb_Soap_ICall $call);

	/**
	 * Returns the HTTP client to send the SOAP message.
	 *
	 * Sub classes may override this method. This can be used to wrap or replace
	 * the default HTTP client. The default client is created over the factory, which
	 * is also an option to control the creation of the client.
	 *
	 * @return Customweb_Core_Http_IClient
	 */
	public function getHttpClient();
}