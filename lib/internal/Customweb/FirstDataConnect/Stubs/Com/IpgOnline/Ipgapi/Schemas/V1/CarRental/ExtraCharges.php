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
 * @XmlType(name="ExtraCharges", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges extends Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String {
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges
	 */
	public static function EXTRAMILEAGE() {
		return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges::_()->set('Extra Mileage');
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges
	 */
	public static function GAS() {
		return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges::_()->set('Gas');
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges
	 */
	public static function LATERETURN() {
		return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges::_()->set('Late Return');
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges
	 */
	public static function ONEWAYSERFEE() {
		return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges::_()->set('One Way Ser Fee');
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges
	 */
	public static function PARKINGVIOLATION() {
		return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges::_()->set('Parking Violation');
	}
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges();
		return $i;
	}
	
}