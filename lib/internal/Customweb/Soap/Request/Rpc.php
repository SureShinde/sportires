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



class Customweb_Soap_Request_Rpc extends Customweb_Soap_Request_Abstract {

	public function __construct(Customweb_Soap_ICall $call) {
		parent::__construct($call);
		if ($call->getInputEncoding() == Customweb_Soap_ICall::ENCODING_ENCODED) {
			$this->getEncoder()->setAppendingXmlSchemaInstanceTypesActive(true);
		}
	}

	protected function addSoapBody() {
		$body = $this->getSoapRequest()->getElementsByTagName('Body')->item(0);
		$this->getEncoder()->encodeToDom($this->getCall()->getInputMessageData(), $body);
		
		if ($body->childNodes->length != 1) {
			throw new Exception("Invalid state. Too many or too few child elements added to the body.");
		}
		
		$wrapper = $body->childNodes->item(0);
		
		if (!($wrapper instanceof DOMElement)) {
			throw new Customweb_Core_Exception_CastException('DOMElement');
		}
		$wrapper = Customweb_Core_Util_Xml::renameDomElement($wrapper, $this->getCall()->getOperationName());
		if ($this->getCall()->getInputEncoding() == Customweb_Soap_ICall::ENCODING_ENCODED) {
			$wrapper->removeAttributeNS(Customweb_Xml_Binding_Encoder::XML_SCHEMA_INSTANCE_NAMESPACE, 'type');
		}
	}
	
	
}
