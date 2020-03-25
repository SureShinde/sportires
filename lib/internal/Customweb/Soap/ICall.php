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



/**
 * This class represents a call object.
 *
 * @author Thomas Hunziker
 *
 */
interface Customweb_Soap_ICall {
	const STYLE_DOCUMENT = 'document';
	const STYLE_RPC = 'rpc';
	
	const ENCODING_LITERAL = 'literal';
	const ENCODING_ENCODED = 'encoded';

	const SOAP_VERSION_11 = '1.1';
	const SOAP_VERSION_12 = '1.2';
	
	/**
	 * Returns the name of the soap call.
	 *
	 * @return string
	 */
	public function getOperationName();
	
	/**
	 * Returns the SOAP action name (this value is add as HTTP header).
	 *
	 * @return string
	 */
	public function getSoapAction();
	
	/**
	 * Returns the used SOAP version number. Either SOAP_VERSION_11 or SOAP_VERSION_12.
	 * 
	 * @return string
	 */
	public function getSoapVersion();
	
	/**
	 * Returns a set of SOAP headers to add. A header can either be a string or a object. In case it is a 
	 * string it is added as it is. If it is a object is tries to encode.
	 * 
	 * @return array
	 */
	public function getSoapHeaders();

	/**
	 * Returns the style of the SOAP call (RPC or Document).
	 *
	 * @return string
	 */
	public function getStyle();

	/**
	 * Returns the encoding (either literal or encoded).
	 *
	 * @return string
	 */
	public function getInputEncoding();

	/**
	 * Returns the encoding (either literal or encoded).
	 *
	 * @return string
	 */
	public function getOutputEncoding();

	/**
	 * Returns the data (object tree) to be sent.
	 *
	 * @return object
	 */
	public function getInputMessageData();

	/**
	 * Returns the class name of the output message.
	 *
	 * @return string
	 */
	public function getOutputMessageClass();
	
	/**
	 * Returns the URL to which the message is sent to.
	 * 
	 * @return string
	 */
	public function getLocationUrl();
	
	/**
	 * Returns a list of HTTP headers to add to the request (e.g. authorization headers etc.).
	 * 
	 * @return string[]
	 */
	public function getHttpHeaders();
	
}
