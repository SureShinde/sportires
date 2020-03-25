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
 * @author Bjoern Hasselmann
 * 
 */
class Customweb_Soap_Exception_SoapFaultException extends Exception {
	
	private $faultString;
	
	private $faultCode;
	
	private $faultActor;
	
	private $faultDetail;
	
	private $faultRest;
	
	public function __construct($string, $code = null, $actor = null, $detail = null, $rest = null){
		$this->faultString = $string;
		$this->faultCode = $code;
		$this->faultActor = $actor;
		$this->faultDetail = $detail;
		$this->faultRest = $rest;
		parent::__construct("\nSOAP FaultException: " . $string);
	}
	
	public function getFaultString() {
		return $this->faultString;
	}
	public function getFaultCode() {
		return $this->faultCode;
	}
	public function getFaultActor() {
		return $this->faultActor;
	}
	/**
	 * @return DOMElement The detail element with its children (the detail entries)
	 */
	public function getFaultDetail() {
		return $this->faultDetail;
	}
	/**
	 * @return array An array of possible, additional, namespace qualified children of the SOAP Fault element.
	 */
	public function getFaultRest() {
		return $this->faultRest;
	}
	
	
}