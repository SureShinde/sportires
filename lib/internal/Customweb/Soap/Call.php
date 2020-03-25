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
 * Implements a SOAP call object class.
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Soap_Call implements Customweb_Soap_ICall {
	
	private $operationName;
	
	private $soapAction;
	
	private $style = self::STYLE_DOCUMENT;
	
	private $inputMessageData;
	
	private $outputMessageClass;
	
	private $inputEncoding = self::ENCODING_LITERAL;
	
	private $outputEncoding = self::ENCODING_LITERAL;
	
	private $soapVersion = self::SOAP_VERSION_11;
	
	private $headers = array();
	
	private $locationUrl = null;
	
	private $soapHeaders = array();
	
	public function __construct(Customweb_Soap_ICall $call = null) {
		if ($call !== null) {
			$this->operationName = $call->getOperationName();
			$this->soapAction = $call->getSoapAction();
			$this->style = $call->getStyle();
			$this->inputMessageData = $call->getInputMessageData();
			$this->outputMessageClass = $call->getOutputMessageClass();
			$this->inputEncoding = $call->getInputEncoding();
			$this->outputEncoding = $call->getOutputEncoding();
			$this->namespaceRequired = $call->isNamespaceRequired();
			$this->soapVersion = $call->getSoapVersion();
			$this->headers = $call->getHttpHeaders();
			$this->locationUrl = $call->getLocationUrl();
		}
	}
	
	public function getOperationName(){
		return $this->operationName;
	}

	/**
	 * Sets the operation name.
	 * 
	 * @param string $operationName
	 * @return Customweb_Soap_Call
	 */
	public function setOperationName($operationName){
		$this->operationName = $operationName;
		return $this;
	}

	public function getSoapAction(){
		return $this->soapAction;
	}

	/**
	 * Sets the SOAP action name.
	 * 
	 * @param string $soapAction
	 * @return Customweb_Soap_Call
	 */
	public function setSoapAction($soapAction){
		$this->soapAction = $soapAction;
		return $this;
	}

	public function getStyle(){
		return $this->style;
	}
	
	public function getSoapHeaders() {
		return $this->soapHeaders;
	}
	
	/**
	 * Sets the SOAP headers to add to the message.
	 * 
	 * @param array $headers
	 * @return Customweb_Soap_Call
	 */
	public function setSoapHeaders(array $headers) {
		$this->soapHeaders = $headers;
		return $this;
	}
	
	/**
	 * Adds a SOAP header. It must be either a string or a object which can be encoded.
	 * 
	 * @param object|string $header
	 * @return Customweb_Soap_Call
	 */
	public function addSoapHeader($header) {
		$this->soapHeaders[] = $header;
		return $this;
	}

	/**
	 * Sets the style 
	 * 
	 * @param string $style
	 * @return Customweb_Soap_Call
	 */
	public function setStyle($style){
		if (strtolower($style) == self::STYLE_DOCUMENT) {
			$this->style = self::STYLE_DOCUMENT;
		}
		else {
			$this->style = self::STYLE_RPC;
		}
		return $this;
	}

	public function getInputMessageData(){
		return $this->inputMessageData;
	}

	/**
	 * Sets the input message data.
	 * 
	 * @param object $inputMessageData
	 * @return Customweb_Soap_Call
	 */
	public function setInputMessageData($inputMessageData){
		$this->inputMessageData = $inputMessageData;
		return $this;
	}

	public function getOutputMessageClass(){
		return $this->outputMessageClass;
	}

	/**
	 * Sets the output class name.
	 * 
	 * @param string $outputMessageClass
	 * @return Customweb_Soap_Call
	 */
	public function setOutputMessageClass($outputMessageClass){
		$this->outputMessageClass = $outputMessageClass;
		return $this;
	}

	public function getInputEncoding(){
		return $this->inputEncoding;
	}
	
	/**
	 * Sets the encoding of the message.
	 *
	 * @param string $inputEncoding
	 * @return Customweb_Soap_Call
	 */
	public function setInputEncoding($inputEncoding){
		if (strtolower($inputEncoding) == self::ENCODING_LITERAL) {
			$this->inputEncoding = self::ENCODING_LITERAL;
		}
		else {
			$this->inputEncoding = self::ENCODING_ENCODED;
		}
		return $this;
	}

	public function getOutputEncoding(){
		return $this->outputEncoding;
	}

	/**
	 * Sets the encoding of the message.
	 *
	 * @param string $outputEncoding
	 * @return Customweb_Soap_Call
	 */
	public function setOutputEncoding($outputEncoding){
		if (strtolower($outputEncoding) == self::ENCODING_LITERAL) {
			$this->outputEncoding = self::ENCODING_LITERAL;
		}
		else {
			$this->outputEncoding = self::ENCODING_ENCODED;
		}
		return $this;
	}

	public function getSoapVersion(){
		return $this->soapVersion;
	}

	public function setSoapVersion($soapVersion){
		if (strtolower($soapVersion) == self::SOAP_VERSION_11) {
			$this->soapVersion = self::SOAP_VERSION_11;
		}
		else {
			$this->soapVersion = self::SOAP_VERSION_12;
		}
		return $this;
	}

	public function getHttpHeaders(){
		return $this->headers;
	}
	
	public function addHttpHeader($header) {
		$this->headers[] = $header;
		return $this;
	}
	
	public function addBasicAuthentication($username, $password) {
		$basic = new Customweb_Core_Http_Authorization_Basic($username, $password);
		$this->addHttpHeader("Authorization: " . $basic->getHeaderFieldValue());
		return $this;
	}

	public function getLocationUrl(){
		return $this->locationUrl;
	}

	public function setLocationUrl($locationUrl){
		$this->locationUrl = $locationUrl;
		return $this;
	}
	
	
}
