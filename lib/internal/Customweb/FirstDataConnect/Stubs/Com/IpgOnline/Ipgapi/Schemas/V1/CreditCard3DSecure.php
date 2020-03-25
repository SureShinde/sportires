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
 * @XmlType(name="CreditCard3DSecure", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure {
	/**
	 * @XmlElement(name="VerificationResponse", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_VerificationResponse", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_VerificationResponse
	 */
	private $verificationResponse;
	
	/**
	 * @XmlElement(name="PayerAuthenticationResponse", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_PayerAuthenticationResponse", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_PayerAuthenticationResponse
	 */
	private $payerAuthenticationResponse;
	
	/**
	 * @XmlElement(name="AuthenticationValue", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_AuthenticationValue", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_AuthenticationValue
	 */
	private $authenticationValue;
	
	/**
	 * @XmlElement(name="XID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_XID", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_XID
	 */
	private $xID;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure();
		return $i;
	}
	/**
	 * Returns the value for the property verificationResponse.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_VerificationResponse
	 */
	public function getVerificationResponse(){
		return $this->verificationResponse;
	}
	
	/**
	 * Sets the value for the property verificationResponse.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_VerificationResponse $verificationResponse
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure
	 */
	public function setVerificationResponse($verificationResponse){
		if ($verificationResponse instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_VerificationResponse) {
			$this->verificationResponse = $verificationResponse;
		}
		else {
			throw new BadMethodCallException("Type of argument verificationResponse must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_VerificationResponse.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property payerAuthenticationResponse.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_PayerAuthenticationResponse
	 */
	public function getPayerAuthenticationResponse(){
		return $this->payerAuthenticationResponse;
	}
	
	/**
	 * Sets the value for the property payerAuthenticationResponse.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_PayerAuthenticationResponse $payerAuthenticationResponse
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure
	 */
	public function setPayerAuthenticationResponse($payerAuthenticationResponse){
		if ($payerAuthenticationResponse instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_PayerAuthenticationResponse) {
			$this->payerAuthenticationResponse = $payerAuthenticationResponse;
		}
		else {
			throw new BadMethodCallException("Type of argument payerAuthenticationResponse must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_PayerAuthenticationResponse.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property authenticationValue.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_AuthenticationValue
	 */
	public function getAuthenticationValue(){
		return $this->authenticationValue;
	}
	
	/**
	 * Sets the value for the property authenticationValue.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_AuthenticationValue $authenticationValue
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure
	 */
	public function setAuthenticationValue($authenticationValue){
		if ($authenticationValue instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_AuthenticationValue) {
			$this->authenticationValue = $authenticationValue;
		}
		else {
			throw new BadMethodCallException("Type of argument authenticationValue must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_AuthenticationValue.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property xID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_XID
	 */
	public function getXID(){
		return $this->xID;
	}
	
	/**
	 * Sets the value for the property xID.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_XID $xID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure
	 */
	public function setXID($xID){
		if ($xID instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_XID) {
			$this->xID = $xID;
		}
		else {
			throw new BadMethodCallException("Type of argument xID must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure_XID.");
		}
		return $this;
	}
	
	
	
}