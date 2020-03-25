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


final class Customweb_Soap_Request_Factory implements Customweb_Soap_Request_IFactory{
	
	/**
	 * Returns a request object based up on the given call object.
	 * 
	 * @return Customweb_Soap_IRequest
	 */
	public function createRequest(Customweb_Soap_ICall $call) {
		
		if ($call->getStyle() === Customweb_Soap_ICall::STYLE_DOCUMENT) {
			return new Customweb_Soap_Request_Document($call);
		}
		else {
			return new Customweb_Soap_Request_Rpc($call);
		}
		
	}
	
}