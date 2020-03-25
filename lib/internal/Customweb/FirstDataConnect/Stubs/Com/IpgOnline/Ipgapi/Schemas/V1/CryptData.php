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
 * @XmlType(name="CryptData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData {
	/**
	 * @XmlElement(name="SRED", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_SRED", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_SRED
	 */
	private $sRED;
	
	/**
	 * @XmlElement(name="PINBlock", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock
	 */
	private $pINBlock;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData();
		return $i;
	}
	/**
	 * Returns the value for the property sRED.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_SRED
	 */
	public function getSRED(){
		return $this->sRED;
	}
	
	/**
	 * Sets the value for the property sRED.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_SRED $sRED
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData
	 */
	public function setSRED($sRED){
		if ($sRED instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_SRED) {
			$this->sRED = $sRED;
		}
		else {
			throw new BadMethodCallException("Type of argument sRED must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_SRED.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property pINBlock.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock
	 */
	public function getPINBlock(){
		return $this->pINBlock;
	}
	
	/**
	 * Sets the value for the property pINBlock.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock $pINBlock
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData
	 */
	public function setPINBlock($pINBlock){
		if ($pINBlock instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock) {
			$this->pINBlock = $pINBlock;
		}
		else {
			throw new BadMethodCallException("Type of argument pINBlock must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData_PINBlock.");
		}
		return $this;
	}
	
	
	
}