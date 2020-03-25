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
 */

class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderService extends Customweb_Soap_AbstractService {

	/**
	 * @var Customweb_Soap_IClient
	 */
	private $soapClient;
		
	/**
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionRequest $iPGApiActionRequest
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */ 
	public function iPGApiAction(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionRequest $iPGApiActionRequest){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("IPGApiAction", $data, "Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse", "");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://test.ipg-online.com:443/ipgapi/services"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderRequest $iPGApiOrderRequest
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */ 
	public function iPGApiOrder(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderRequest $iPGApiOrderRequest){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("IPGApiOrder", $data, "Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse", "");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://test.ipg-online.com:443/ipgapi/services"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse
	 */ 
	public function eMVCardPresent(){
		$data = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse();
		$call = $this->createSoapCall("EMVCardPresent", $data, "Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse", "");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_ENCODED);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://test.ipg-online.com:443/ipgapi/services"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
	
}