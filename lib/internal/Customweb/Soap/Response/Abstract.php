<?php

/**
 *  * You are allowed to use this API in your web application.
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

class Customweb_Soap_Response_Abstract implements Customweb_Soap_IResponse {
	
	/**
	 *
	 * @var Customweb_Soap_ICall
	 */
	private $call;
	
	/**
	 *
	 * @var Customweb_Core_Http_Response
	 */
	private $httpResponse;
	
	/**
	 *
	 * @var DOMDocument
	 */
	private $soapResponse;
	
	/**
	 *
	 * @var Customweb_Xml_Binding_Decoder
	 */
	private $decoder;

	public function __construct(Customweb_Soap_ICall $call, Customweb_Core_Http_IResponse $response){
		$this->call = $call;
		if ($response instanceof Customweb_Core_Http_Response) {
			$this->httpResponse = $response;
		}
		else {
			$this->httpResponse = new Customweb_Core_Http_Response($response);
		}
		$this->decoder = new Customweb_Xml_Binding_Decoder();
	}

	public function parseHttpResponse(){
		$this->checkHttpResponse();
		$this->readHttpResponseBody();
		$this->checkForSoapFaults();
		return $this->extractSoapMessageObject();
	}

	protected function extractSoapMessageObject(){
		$body = $this->getSoapResponse()->getElementsByTagName('Body')->item(0);
		return $this->getDecoder()->decodeFromDom($body, $this->getCall()->getOutputMessageClass());
	}

	protected function checkForSoapFaults(){
		$body = $this->getSoapResponse()->getElementsByTagName('Body')->item(0);
		
		if ($body === null) {
			throw new Exception("The remote service does not provide any SOAP body.");
		}
		
		if (($faultNode = $body->getElementsByTagName('Fault')->item(0)) !== null) {
			$data = array();
			
			foreach ($faultNode->childNodes as $n) {
				$data[$n->nodeName] = $n->nodeValue;
				if(strtolower($n->nodeName) == 'detail'){
					$data[$n->nodeName] = $n;
				}				
			}			
			throw new Customweb_Soap_Exception_SoapFaultException(self::removeFrom($data, 'faultstring'), self::removeFrom($data, 'faultcode'), 
					self::removeFrom($data, 'faultactor'), self::removeFrom($data, 'detail'), $data);
		}
	}

	protected function checkHttpResponse(){
		$code = $this->getHttpResponse()->getStatusCode();
		if (substr($code, 0, 1) != '2' && strpos($this->getHttpResponse()->getContentType(), '/xml') === false) {
			throw new Exception(
					'Exception:' . PHP_EOL . $this->getHttpResponse()->getStatusLine() . PHP_EOL . 'Message:' . PHP_EOL .
							 $this->getHttpResponse()->getStatusMessage());
		}
	}

	protected function readHttpResponseBody(){
		$body = $this->getHttpResponse()->getBody();
		if (empty($body)) {
			throw new Exception("The SOAP response body is empty.");
		}
		$this->soapResponse = new DOMDocument();
		$this->soapResponse->loadXML($body);
	}

	/**
	 *
	 * @return DOMDocument
	 */
	protected final function getSoapResponse(){
		return $this->soapResponse;
	}

	protected final function setSoapResponse(DOMDocument $soapResponse){
		$this->soapResponse = $soapResponse;
		return $this;
	}

	/**
	 *
	 * @return Customweb_Soap_ICall
	 */
	protected final function getCall(){
		return $this->call;
	}

	/**
	 *
	 * @return Customweb_Core_Http_Response
	 */
	protected final function getHttpResponse(){
		return $this->httpResponse;
	}

	protected final function getDecoder(){
		return $this->decoder;
	}

	private static function removeFrom(array &$arr, $key){
		if (array_key_exists($key, $arr)) {
			$val = $arr[$key];
			unset($arr[$key]);
			return $val;
		}
		return null;
	}
}