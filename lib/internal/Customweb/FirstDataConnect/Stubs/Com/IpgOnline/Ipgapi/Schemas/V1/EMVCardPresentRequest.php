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
 * @XmlType(name="EMVCardPresentRequest", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest {
	/**
	 * @XmlElement(name="CryptData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData
	 */
	private $cryptData;
	
	/**
	 * @XmlElement(name="EMVRequestData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVRequestData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVRequestData
	 */
	private $eMVRequestData;
	
	/**
	 * @XmlElement(name="TLVData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TLVData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TLVData
	 */
	private $tLVData;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest();
		return $i;
	}
	/**
	 * Returns the value for the property cryptData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData
	 */
	public function getCryptData(){
		return $this->cryptData;
	}
	
	/**
	 * Sets the value for the property cryptData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData $cryptData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest
	 */
	public function setCryptData($cryptData){
		if ($cryptData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData) {
			$this->cryptData = $cryptData;
		}
		else {
			throw new BadMethodCallException("Type of argument cryptData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property eMVRequestData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVRequestData
	 */
	public function getEMVRequestData(){
		return $this->eMVRequestData;
	}
	
	/**
	 * Sets the value for the property eMVRequestData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVRequestData $eMVRequestData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest
	 */
	public function setEMVRequestData($eMVRequestData){
		if ($eMVRequestData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVRequestData) {
			$this->eMVRequestData = $eMVRequestData;
		}
		else {
			throw new BadMethodCallException("Type of argument eMVRequestData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVRequestData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property tLVData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TLVData
	 */
	public function getTLVData(){
		return $this->tLVData;
	}
	
	/**
	 * Sets the value for the property tLVData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TLVData $tLVData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest
	 */
	public function setTLVData($tLVData){
		if ($tLVData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TLVData) {
			$this->tLVData = $tLVData;
		}
		else {
			throw new BadMethodCallException("Type of argument tLVData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TLVData.");
		}
		return $this;
	}
	
	
	
}