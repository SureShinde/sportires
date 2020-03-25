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


class Customweb_Soap_Client implements Customweb_Soap_IClient {
	
	/**
	 * @var Customweb_Soap_Request_IFactory
	 */
	private $requestFactory;

	/**
	 * @var Customweb_Soap_Response_IFactory
	 */
	private $responseFactory;
	
	private $httpClient;
	
	public function __construct(Customweb_Soap_Request_IFactory $requestFactory = null, Customweb_Soap_Response_IFactory $responseFactory = null, Customweb_Core_Http_IClient $httpClient = null){
		if ($requestFactory === null) {
			$this->requestFactory = new Customweb_Soap_Request_Factory();
		} else {
			$this->requestFactory = $requestFactory;
		}
		if ($responseFactory === null) {
			$this->responseFactory = new Customweb_Soap_Response_Factory();
		}
		else {
			$this->responseFactory = $responseFactory;
		}
		if ($httpClient === null) {
			$this->httpClient = Customweb_Core_Http_Client_Factory::createClient();
		}
		else {
			$this->httpClient = $httpClient;
		}
	}

	final public function invokeOperation(Customweb_Soap_ICall $call) {
		$httpRequest = $this->getRequestFactory()->createRequest($call)->createHttpRequest();
		$httpResponse = $this->sendHttpRequest($httpRequest);
		return $this->getResponseFactory()->createResponse($call, $httpResponse)->parseHttpResponse();
	}
	
	/**
	 * Sends the given HTTP request to the remote system.
	 * 
	 * Sub classes may override this method to inject the request or the response.
	 * 
	 * @param Customweb_Core_Http_IRequest $request
	 * @return Customweb_Core_Http_IResponse
	 */
	protected function sendHttpRequest(Customweb_Core_Http_IRequest $request) {
		return $this->getHttpClient()->send($request);
	}

	/**
	 * Returns the HTTP client to send the SOAP message.
	 * 
	 * Sub classes may override this method. This can be used to wrap or replace
	 * the default HTTP client. The default client is created over the factory, which
	 * is also an option to control the creation of the client.
	 * 
	 * @return Customweb_Core_Http_IClient
	 */
	public function getHttpClient(){
		return $this->httpClient;
	}

	/**
	 * Returns the factory to create request objects.
	 * 
	 * @return Customweb_Soap_Request_IFactory
	 */
	final protected function getRequestFactory(){
		return $this->requestFactory;
	}

	/**
	 * Returns the factory to create responses.
	 * 
	 * @return Customweb_Soap_Response_IFactory
	 */
	final protected function getResponseFactory(){
		return $this->responseFactory;
	}
	
}