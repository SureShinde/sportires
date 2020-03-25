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

abstract class Customweb_Soap_AbstractService {
	private $client;
	private $overriddenLocations = array();

	public function __construct(){
		$this->client = $this->createSoapClient();
	}

	/**
	 * This method allows the overridding of endpoint locations (URLs).
	 * This allows to send the SOAP message dynamically to another location.
	 *
	 * @param string $locationToOverride
	 * @param string $newLocation
	 * @return Customweb_Soap_AbstractService
	 */
	public final function overrideLocation($locationToOverride, $newLocation){
		$key = strtolower($locationToOverride);
		$this->overriddenLocations[$key] = $newLocation;
		return $this;
	}

	/**
	 * Creates a new soap client.
	 * Sub classes may override this method
	 * to replace the SOAP client implementation with another one.
	 *
	 * @return Customweb_Soap_IClient
	 */
	protected function createSoapClient(){
		return new Customweb_Soap_Client();
	}

	/**
	 * Returns the SOAP client to use.
	 *
	 *
	 * @return Customweb_Soap_IClient
	 */
	final public function getClient(){
		return $this->client;
	}

	/**
	 * Creates a new SOAP call object.
	 * Sub classes may override this method
	 * to customize the SOAP call.
	 *
	 * @param string $operationName Name of the operation to invoke.
	 * @param object $data The object, which contains the data for invoking the remote server.
	 * @param string $outputClassName The class name to which the response message should be mapped to.
	 * @param string $soapActionName (Optional)The SOAP action name.
	 * @return Customweb_Soap_Call
	 */
	protected function createSoapCall($operationName, $data, $outputClassName, $soapActionName = null){
		$call = new Customweb_Soap_Call();
		$call->setOperationName($operationName)->setInputMessageData($data)->setOutputMessageClass($outputClassName);
		if ($soapActionName !== null) {
			$call->setSoapAction($soapActionName);
		}
		return $call;
	}

	/**
	 * This method resolves the given location to effective location.
	 *
	 * @param string $location
	 * @return string
	 */
	protected final function resolveLocation($location){
		if (empty($location)) {
			throw new Exception("Unable to resolve a empty URL location.");
		}
		$key = strtolower($location);
		if (isset($this->overriddenLocations[$key])) {
			if($this->overriddenLocations[$key] == $location) {
				return $location;
			}
			return $this->resolveLocation($this->overriddenLocations[$key]);
		}
		else {
			return $location;
		}
	}
}