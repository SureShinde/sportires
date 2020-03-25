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
 * @XmlType(name="EMVCardPresentResponse", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse {
	/**
	 * @XmlElement(name="EMVResponseData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData
	 */
	private $eMVResponseData;
	
	/**
	 * @XmlElement(name="TLVData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TLVData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TLVData
	 */
	private $tLVData;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse();
		return $i;
	}
	/**
	 * Returns the value for the property eMVResponseData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData
	 */
	public function getEMVResponseData(){
		return $this->eMVResponseData;
	}
	
	/**
	 * Sets the value for the property eMVResponseData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData $eMVResponseData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse
	 */
	public function setEMVResponseData($eMVResponseData){
		if ($eMVResponseData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData) {
			$this->eMVResponseData = $eMVResponseData;
		}
		else {
			throw new BadMethodCallException("Type of argument eMVResponseData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVResponseData.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse
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