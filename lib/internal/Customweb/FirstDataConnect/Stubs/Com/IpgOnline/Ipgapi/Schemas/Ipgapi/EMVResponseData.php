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
 * @XmlType(name="EMVResponseData", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData {
	/**
	 * @XmlElement(name="IssuerAuthenticationData-91", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthenticationData91", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthenticationData91
	 */
	private $issuerAuthenticationData91;
	
	/**
	 * @XmlElement(name="IssuerScriptTemplate1-71", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate171", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate171
	 */
	private $issuerScriptTemplate171;
	
	/**
	 * @XmlElement(name="IssuerScriptTemplate2-72", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate272", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate272
	 */
	private $issuerScriptTemplate272;
	
	/**
	 * @XmlElement(name="IssuerAuthorizationResponseCode-8A", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthorizationResponseCode8A", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthorizationResponseCode8A
	 */
	private $issuerAuthorizationResponseCode8A;
	
	/**
	 * @XmlElement(name="MessageControlField-DF4F", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_MessageControlFieldDF4F", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_MessageControlFieldDF4F
	 */
	private $messageControlFieldDF4F;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData();
		return $i;
	}
	/**
	 * Returns the value for the property issuerAuthenticationData91.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthenticationData91
	 */
	public function getIssuerAuthenticationData91(){
		return $this->issuerAuthenticationData91;
	}
	
	/**
	 * Sets the value for the property issuerAuthenticationData91.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthenticationData91 $issuerAuthenticationData91
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData
	 */
	public function setIssuerAuthenticationData91($issuerAuthenticationData91){
		if ($issuerAuthenticationData91 instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthenticationData91) {
			$this->issuerAuthenticationData91 = $issuerAuthenticationData91;
		}
		else {
			throw new BadMethodCallException("Type of argument issuerAuthenticationData91 must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthenticationData91.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property issuerScriptTemplate171.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate171
	 */
	public function getIssuerScriptTemplate171(){
		return $this->issuerScriptTemplate171;
	}
	
	/**
	 * Sets the value for the property issuerScriptTemplate171.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate171 $issuerScriptTemplate171
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData
	 */
	public function setIssuerScriptTemplate171($issuerScriptTemplate171){
		if ($issuerScriptTemplate171 instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate171) {
			$this->issuerScriptTemplate171 = $issuerScriptTemplate171;
		}
		else {
			throw new BadMethodCallException("Type of argument issuerScriptTemplate171 must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate171.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property issuerScriptTemplate272.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate272
	 */
	public function getIssuerScriptTemplate272(){
		return $this->issuerScriptTemplate272;
	}
	
	/**
	 * Sets the value for the property issuerScriptTemplate272.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate272 $issuerScriptTemplate272
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData
	 */
	public function setIssuerScriptTemplate272($issuerScriptTemplate272){
		if ($issuerScriptTemplate272 instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate272) {
			$this->issuerScriptTemplate272 = $issuerScriptTemplate272;
		}
		else {
			throw new BadMethodCallException("Type of argument issuerScriptTemplate272 must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerScriptTemplate272.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property issuerAuthorizationResponseCode8A.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthorizationResponseCode8A
	 */
	public function getIssuerAuthorizationResponseCode8A(){
		return $this->issuerAuthorizationResponseCode8A;
	}
	
	/**
	 * Sets the value for the property issuerAuthorizationResponseCode8A.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthorizationResponseCode8A $issuerAuthorizationResponseCode8A
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData
	 */
	public function setIssuerAuthorizationResponseCode8A($issuerAuthorizationResponseCode8A){
		if ($issuerAuthorizationResponseCode8A instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthorizationResponseCode8A) {
			$this->issuerAuthorizationResponseCode8A = $issuerAuthorizationResponseCode8A;
		}
		else {
			throw new BadMethodCallException("Type of argument issuerAuthorizationResponseCode8A must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_IssuerAuthorizationResponseCode8A.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property messageControlFieldDF4F.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_MessageControlFieldDF4F
	 */
	public function getMessageControlFieldDF4F(){
		return $this->messageControlFieldDF4F;
	}
	
	/**
	 * Sets the value for the property messageControlFieldDF4F.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_MessageControlFieldDF4F $messageControlFieldDF4F
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData
	 */
	public function setMessageControlFieldDF4F($messageControlFieldDF4F){
		if ($messageControlFieldDF4F instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_MessageControlFieldDF4F) {
			$this->messageControlFieldDF4F = $messageControlFieldDF4F;
		}
		else {
			throw new BadMethodCallException("Type of argument messageControlFieldDF4F must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData_MessageControlFieldDF4F.");
		}
		return $this;
	}
	
	
	
}