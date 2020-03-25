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



class Customweb_Soap_Request_Document extends Customweb_Soap_Request_Abstract {
	
	protected function addSoapBody() {
		$body = $this->getSoapRequest()->getElementsByTagName('Body')->item(0);
		$this->getEncoder()->encodeToDom($this->getCall()->getInputMessageData(), $body);
	}
	
	protected function addSoapHeader() {
		$headerElement = $this->getSoapRequest()->getElementsByTagName('Header')->item(0);
		foreach ($this->getCall()->getSoapHeaders() as $header) {
			if (is_string($header)) {
				$fragment = $headerElement->ownerDocument->createDocumentFragment();
				$fragment->appendXML($header);
				$headerElement->appendChild($fragment);
			}
			else if(is_object($header)) {
				$this->getEncoder()->encodeToDom($header, $headerElement);
			}
			else {
				throw new Exception("The provided header is neither a string nor an object. Hence it could not be added to the SOAP message.");
			}
		}
	}
	
}
