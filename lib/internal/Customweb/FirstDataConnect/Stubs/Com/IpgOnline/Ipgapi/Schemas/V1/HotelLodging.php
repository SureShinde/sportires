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
 * @XmlType(name="HotelLodging", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging {
	/**
	 * @XmlElement(name="ArrivalDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	private $arrivalDate;
	
	/**
	 * @XmlElement(name="DepartureDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	private $departureDate;
	
	/**
	 * @XmlElement(name="FolioNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $folioNumber;
	
	/**
	 * @XmlList(name="ExtraCharges", type='Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging_ExtraCharges', namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging_ExtraCharges[]
	 */
	private $extraCharges;
	
	/**
	 * @XmlValue(name="NoShowIndicator", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean'), namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var boolean
	 */
	private $noShowIndicator;
	
	public function __construct() {
		$this->extraCharges = new ArrayObject();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging();
		return $i;
	}
	/**
	 * Returns the value for the property arrivalDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	public function getArrivalDate(){
		return $this->arrivalDate;
	}
	
	/**
	 * Sets the value for the property arrivalDate.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate $arrivalDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging
	 */
	public function setArrivalDate($arrivalDate){
		if ($arrivalDate instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate) {
			$this->arrivalDate = $arrivalDate;
		}
		else {
			throw new BadMethodCallException("Type of argument arrivalDate must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property departureDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	public function getDepartureDate(){
		return $this->departureDate;
	}
	
	/**
	 * Sets the value for the property departureDate.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate $departureDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging
	 */
	public function setDepartureDate($departureDate){
		if ($departureDate instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate) {
			$this->departureDate = $departureDate;
		}
		else {
			throw new BadMethodCallException("Type of argument departureDate must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property folioNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getFolioNumber(){
		return $this->folioNumber;
	}
	
	/**
	 * Sets the value for the property folioNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $folioNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging
	 */
	public function setFolioNumber($folioNumber){
		if ($folioNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->folioNumber = $folioNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument folioNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property extraCharges.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging_ExtraCharges[]
	 */
	public function getExtraCharges(){
		return $this->extraCharges;
	}
	
	/**
	 * Sets the value for the property extraCharges.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging_ExtraCharges $extraCharges
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging
	 */
	public function setExtraCharges($extraCharges){
		if (is_array($extraCharges)) {
			$extraCharges = new ArrayObject($extraCharges);
		}
		if ($extraCharges instanceof ArrayObject) {
			$this->extraCharges = $extraCharges;
		}
		else {
			throw new BadMethodCallException("Type of argument extraCharges must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of extraCharges.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging_ExtraCharges $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging
	 */
	public function addExtraCharges(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging_ExtraCharges $item) {
		if (!($this->extraCharges instanceof ArrayObject)) {
			$this->extraCharges = new ArrayObject();
		}
		$this->extraCharges[] = $item;
		return $this;
	}
	
	/**
	 * Returns the value for the property noShowIndicator.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getNoShowIndicator(){
		return $this->noShowIndicator;
	}
	
	/**
	 * Sets the value for the property noShowIndicator.
	 * 
	 * @param boolean $noShowIndicator
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_HotelLodging
	 */
	public function setNoShowIndicator($noShowIndicator){
		if ($noShowIndicator instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->noShowIndicator = $noShowIndicator;
		}
		else {
			$this->noShowIndicator = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean::_()->set($noShowIndicator);
		}
		return $this;
	}
	
	
	
}