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
 * @XmlType(name="CarRental", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental {
	/**
	 * @XmlElement(name="AgreementNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $agreementNumber;
	
	/**
	 * @XmlElement(name="RenterName", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $renterName;
	
	/**
	 * @XmlElement(name="ReturnCity", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $returnCity;
	
	/**
	 * @XmlElement(name="ReturnDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	private $returnDate;
	
	/**
	 * @XmlElement(name="PickupDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	private $pickupDate;
	
	/**
	 * @XmlElement(name="RentalClassID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max
	 */
	private $rentalClassID;
	
	/**
	 * @XmlList(name="ExtraCharges", type='Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges', namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges[]
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental();
		return $i;
	}
	/**
	 * Returns the value for the property agreementNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getAgreementNumber(){
		return $this->agreementNumber;
	}
	
	/**
	 * Sets the value for the property agreementNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $agreementNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
	 */
	public function setAgreementNumber($agreementNumber){
		if ($agreementNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->agreementNumber = $agreementNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument agreementNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property renterName.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getRenterName(){
		return $this->renterName;
	}
	
	/**
	 * Sets the value for the property renterName.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $renterName
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
	 */
	public function setRenterName($renterName){
		if ($renterName instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->renterName = $renterName;
		}
		else {
			throw new BadMethodCallException("Type of argument renterName must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property returnCity.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getReturnCity(){
		return $this->returnCity;
	}
	
	/**
	 * Sets the value for the property returnCity.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $returnCity
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
	 */
	public function setReturnCity($returnCity){
		if ($returnCity instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->returnCity = $returnCity;
		}
		else {
			throw new BadMethodCallException("Type of argument returnCity must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property returnDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	public function getReturnDate(){
		return $this->returnDate;
	}
	
	/**
	 * Sets the value for the property returnDate.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate $returnDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
	 */
	public function setReturnDate($returnDate){
		if ($returnDate instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate) {
			$this->returnDate = $returnDate;
		}
		else {
			throw new BadMethodCallException("Type of argument returnDate must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property pickupDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	public function getPickupDate(){
		return $this->pickupDate;
	}
	
	/**
	 * Sets the value for the property pickupDate.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate $pickupDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
	 */
	public function setPickupDate($pickupDate){
		if ($pickupDate instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate) {
			$this->pickupDate = $pickupDate;
		}
		else {
			throw new BadMethodCallException("Type of argument pickupDate must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property rentalClassID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max
	 */
	public function getRentalClassID(){
		return $this->rentalClassID;
	}
	
	/**
	 * Sets the value for the property rentalClassID.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max $rentalClassID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
	 */
	public function setRentalClassID($rentalClassID){
		if ($rentalClassID instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max) {
			$this->rentalClassID = $rentalClassID;
		}
		else {
			throw new BadMethodCallException("Type of argument rentalClassID must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property extraCharges.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges[]
	 */
	public function getExtraCharges(){
		return $this->extraCharges;
	}
	
	/**
	 * Sets the value for the property extraCharges.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges $extraCharges
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
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
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
	 */
	public function addExtraCharges(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental_ExtraCharges $item) {
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CarRental
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