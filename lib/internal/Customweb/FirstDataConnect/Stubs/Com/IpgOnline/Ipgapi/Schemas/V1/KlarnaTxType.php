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
 * @XmlType(name="KlarnaTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType extends Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Options {
	/**
	 * @XmlElement(name="Type", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type
	 */
	private $type;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType();
		return $i;
	}
	/**
	 * Returns the value for the property type.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type
	 */
	public function getType(){
		return $this->type;
	}
	
	/**
	 * Sets the value for the property type.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type $type
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType
	 */
	public function setType($type){
		if ($type instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type) {
			$this->type = $type;
		}
		else {
			throw new BadMethodCallException("Type of argument type must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type.");
		}
		return $this;
	}
	
	
	
}