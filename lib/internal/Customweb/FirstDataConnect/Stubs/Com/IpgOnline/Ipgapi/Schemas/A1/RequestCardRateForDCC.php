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
 * @XmlType(name="RequestCardRateForDCC", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RequestCardRateForDCC {
	/**
	 * @XmlElement(name="StoreId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $storeId;
	
	/**
	 * @XmlElement(name="BIN", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_BINType", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_BINType
	 */
	private $bIN;
	
	/**
	 * @XmlElement(name="BaseAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $baseAmount;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RequestCardRateForDCC
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RequestCardRateForDCC();
		return $i;
	}
	/**
	 * Returns the value for the property storeId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getStoreId(){
		return $this->storeId;
	}
	
	/**
	 * Sets the value for the property storeId.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $storeId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RequestCardRateForDCC
	 */
	public function setStoreId($storeId){
		if ($storeId instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->storeId = $storeId;
		}
		else {
			throw new BadMethodCallException("Type of argument storeId must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property bIN.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_BINType
	 */
	public function getBIN(){
		return $this->bIN;
	}
	
	/**
	 * Sets the value for the property bIN.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_BINType $bIN
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RequestCardRateForDCC
	 */
	public function setBIN($bIN){
		if ($bIN instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_BINType) {
			$this->bIN = $bIN;
		}
		else {
			throw new BadMethodCallException("Type of argument bIN must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_BINType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property baseAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getBaseAmount(){
		return $this->baseAmount;
	}
	
	/**
	 * Sets the value for the property baseAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $baseAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RequestCardRateForDCC
	 */
	public function setBaseAmount($baseAmount){
		if ($baseAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->baseAmount = $baseAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument baseAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	
}