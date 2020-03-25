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
 * @XmlType(name="PINBlock", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock {
	/**
	 * @XmlElement(name="Value", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_Value", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_Value
	 */
	private $value;
	
	/**
	 * @XmlElement(name="KSN", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_KSN", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_KSN
	 */
	private $kSN;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock();
		return $i;
	}
	/**
	 * Returns the value for the property value.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_Value
	 */
	public function getValue(){
		return $this->value;
	}
	
	/**
	 * Sets the value for the property value.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_Value $value
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock
	 */
	public function setValue($value){
		if ($value instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_Value) {
			$this->value = $value;
		}
		else {
			throw new BadMethodCallException("Type of argument value must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_Value.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property kSN.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_KSN
	 */
	public function getKSN(){
		return $this->kSN;
	}
	
	/**
	 * Sets the value for the property kSN.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_KSN $kSN
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock
	 */
	public function setKSN($kSN){
		if ($kSN instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_KSN) {
			$this->kSN = $kSN;
		}
		else {
			throw new BadMethodCallException("Type of argument kSN must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock_KSN.");
		}
		return $this;
	}
	
	
	
}