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
 * @XmlType(name="TopUpTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType extends Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Options {
	/**
	 * @XmlElement(name="MPCharge", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType_MPCharge", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType_MPCharge
	 */
	private $mPCharge;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType();
		return $i;
	}
	/**
	 * Returns the value for the property mPCharge.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType_MPCharge
	 */
	public function getMPCharge(){
		return $this->mPCharge;
	}
	
	/**
	 * Sets the value for the property mPCharge.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType_MPCharge $mPCharge
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType
	 */
	public function setMPCharge($mPCharge){
		if ($mPCharge instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType_MPCharge) {
			$this->mPCharge = $mPCharge;
		}
		else {
			throw new BadMethodCallException("Type of argument mPCharge must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType_MPCharge.");
		}
		return $this;
	}
	
	
	
}