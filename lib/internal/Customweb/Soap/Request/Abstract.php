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



abstract class Customweb_Soap_Request_Abstract implements Customweb_Soap_IRequest {

	/**
	 * @var Customweb_Soap_ICall
	 */
	private $call;
	
	private static $requestBaseXml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
					xmlns:soapenc="http://www.w3.org/2001/12/soap-encoding"
					xmlns:xs="http://www.w3.org/2001/XMLSchema"
					xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<soapenv:Header />
	<soapenv:Body />
</soapenv:Envelope>';
	
	/**
	 * @var DOMDocument
	 */
	private $xml;
	
	/**
	 * @var Customweb_Core_Http_Request
	 */
	private $request;
	
	private $encoder;
	
	public function __construct(Customweb_Soap_ICall $call) {
		$this->call = $call;
		$this->xml = new DOMDocument();
		$this->xml->loadXML(self::$requestBaseXml);
		$this->request = new Customweb_Core_Http_Request($call->getLocationUrl());
		$this->request->setMethod('POST');
		$this->encoder = new Customweb_Xml_Binding_Encoder();
		
	}
	
	public function createHttpRequest() {
		$this->addSoapEvelopeNamespace();
		$this->addSoapHeader();
		$this->addSoapBody();
		$this->addSoapFault();
		$this->addXmlToRequestBody();
		$this->addHttpRequestHeader();
		return $this->getHttpRequest();
	}
	
	protected function addSoapHeader() {
		// Empty. Sub classes may override this method to provide soap headers.
	}
	
	abstract protected function addSoapBody();
	
	protected function addSoapFault() {
		// Empty. Sub classes may override this method to provide soap faults.
	}
	
	protected function addXmlToRequestBody() {
		$this->getHttpRequest()->setBody($this->getSoapRequest()->saveXML());
	}
	
	protected function addHttpRequestHeader() {
		$soapAction = $this->getCall()->getSoapAction();
		if ($this->getCall()->getSoapVersion() == Customweb_Soap_ICall::SOAP_VERSION_11) {
			if (!empty($soapAction)) {
				$this->getHttpRequest()->appendHeader('SOAPAction: "' . $this->getCall()->getSoapAction() . '"');
			}
			$this->getHttpRequest()->setContentType("text/xml; charset=utf-8");
		}
		else if ($this->getCall()->getSoapVersion() == Customweb_Soap_ICall::SOAP_VERSION_12) {
			$contentType = 'application/soap+xml; charset=utf-8';
			if (!empty($soapAction)) {
				$contentType .= '; action="' . $this->getCall()->getSoapAction() . '"';
			}
			$this->getHttpRequest()->setContentType($contentType);
		}
		else {
			throw new Exception("Unsupported SOAP version.");
		}
		
		foreach ($this->getCall()->getHttpHeaders() as $header) {
			$this->getHttpRequest()->appendHeader($header);
		}
	}
	
	protected function addSoapEvelopeNamespace() {
		$root = $this->getSoapRequest()->documentElement;
		$root->setAttribute('xmlns:soapenv', $this->getSoapEnvelopeNamespace());
		return $this;
	}
	
	protected function getSoapEnvelopeNamespace() {
		if ($this->getCall()->getSoapVersion() == Customweb_Soap_ICall::SOAP_VERSION_11) {
			return 'http://www.w3.org/2001/12/soap-envelope';;
		}
		else {
			return 'http://schemas.xmlsoap.org/soap/envelope/';
		}
	}

	final protected function getCall(){
		return $this->call;
	}
	
	/**
	 * @return DOMDocument
	 */
	final protected function getSoapRequest() {
		return $this->xml;
	}
	
	/**
	 * @return Customweb_Core_Http_Request
	 */
	final protected function getHttpRequest() {
		return $this->request;
	}
	
	/**
	 * @return Customweb_Xml_Binding_Encoder
	 */
	final protected function getEncoder() {
		return $this->encoder;
	}
	
}