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
 * @XmlType(name="Billing", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing {
	/**
	 * @XmlElement(name="CustomerID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	private $customerID;
	
	/**
	 * @XmlElement(name="Name", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	private $name;
	
	/**
	 * @XmlElement(name="Firstname", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max
	 */
	private $firstname;
	
	/**
	 * @XmlElement(name="Surname", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max
	 */
	private $surname;
	
	/**
	 * @XmlElement(name="Company", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	private $company;
	
	/**
	 * @XmlElement(name="Address1", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	private $address1;
	
	/**
	 * @XmlElement(name="StreetName", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String84max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String84max
	 */
	private $streetName;
	
	/**
	 * @XmlElement(name="HouseNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max
	 */
	private $houseNumber;
	
	/**
	 * @XmlElement(name="HouseExtension", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max
	 */
	private $houseExtension;
	
	/**
	 * @XmlElement(name="Address2", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	private $address2;
	
	/**
	 * @XmlElement(name="City", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	private $city;
	
	/**
	 * @XmlElement(name="State", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	private $state;
	
	/**
	 * @XmlElement(name="Zip", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String24max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String24max
	 */
	private $zip;
	
	/**
	 * @XmlElement(name="Country", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	private $country;
	
	/**
	 * @XmlElement(name="Phone", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	private $phone;
	
	/**
	 * @XmlElement(name="Fax", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	private $fax;
	
	/**
	 * @XmlElement(name="Email", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String64max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String64max
	 */
	private $email;
	
	/**
	 * @XmlElement(name="PersonalNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $personalNumber;
	
	/**
	 * @XmlValue(name="BirthDate", simpleType=@XmlSimpleTypeDefinition(typeName='date', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Date'), namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_Xml_Binding_DateHandler_Date
	 */
	private $birthDate;
	
	/**
	 * @XmlElement(name="Gender", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_GenderType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_GenderType
	 */
	private $gender;
	
	/**
	 * @XmlElement(name="MobilePhone", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	private $mobilePhone;
	
	/**
	 * @XmlElement(name="Addrnum", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	private $addrnum;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing();
		return $i;
	}
	/**
	 * Returns the value for the property customerID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	public function getCustomerID(){
		return $this->customerID;
	}
	
	/**
	 * Sets the value for the property customerID.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max $customerID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setCustomerID($customerID){
		if ($customerID instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max) {
			$this->customerID = $customerID;
		}
		else {
			throw new BadMethodCallException("Type of argument customerID must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max.");
		}
		return $this;
	}
	
	
	/**
	 * Full name of the customer
	 * 
	 * Returns the value for the property name.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Full name of the customer
	 * 
	 * Sets the value for the property name.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max $name
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setName($name){
		if ($name instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max) {
			$this->name = $name;
		}
		else {
			throw new BadMethodCallException("Type of argument name must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max.");
		}
		return $this;
	}
	
	
	/**
	 * Customer first name - e.g. John (required for KLARNA)
	 * 
	 * Returns the value for the property firstname.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max
	 */
	public function getFirstname(){
		return $this->firstname;
	}
	
	/**
	 * Customer first name - e.g. John (required for KLARNA)
	 * 
	 * Sets the value for the property firstname.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max $firstname
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setFirstname($firstname){
		if ($firstname instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max) {
			$this->firstname = $firstname;
		}
		else {
			throw new BadMethodCallException("Type of argument firstname must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max.");
		}
		return $this;
	}
	
	
	/**
	 * Customer surname - e.g. Doe (required for KLARNA)
	 * 
	 * Returns the value for the property surname.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max
	 */
	public function getSurname(){
		return $this->surname;
	}
	
	/**
	 * Customer surname - e.g. Doe (required for KLARNA)
	 * 
	 * Sets the value for the property surname.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max $surname
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setSurname($surname){
		if ($surname instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max) {
			$this->surname = $surname;
		}
		else {
			throw new BadMethodCallException("Type of argument surname must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property company.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	public function getCompany(){
		return $this->company;
	}
	
	/**
	 * Sets the value for the property company.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max $company
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setCompany($company){
		if ($company instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max) {
			$this->company = $company;
		}
		else {
			throw new BadMethodCallException("Type of argument company must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max.");
		}
		return $this;
	}
	
	
	/**
	 * first part of the address - e.g. Unit 7 (Ignored for KLARNA payment type)
	 * 
	 * Returns the value for the property address1.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	public function getAddress1(){
		return $this->address1;
	}
	
	/**
	 * first part of the address - e.g. Unit 7 (Ignored for KLARNA payment type)
	 * 
	 * Sets the value for the property address1.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max $address1
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setAddress1($address1){
		if ($address1 instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max) {
			$this->address1 = $address1;
		}
		else {
			throw new BadMethodCallException("Type of argument address1 must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max.");
		}
		return $this;
	}
	
	
	/**
	 * required for KLARNA
	 * 
	 * Returns the value for the property streetName.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String84max
	 */
	public function getStreetName(){
		return $this->streetName;
	}
	
	/**
	 * required for KLARNA
	 * 
	 * Sets the value for the property streetName.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String84max $streetName
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setStreetName($streetName){
		if ($streetName instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String84max) {
			$this->streetName = $streetName;
		}
		else {
			throw new BadMethodCallException("Type of argument streetName must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String84max.");
		}
		return $this;
	}
	
	
	/**
	 * required for KLARNA
	 * 
	 * Returns the value for the property houseNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max
	 */
	public function getHouseNumber(){
		return $this->houseNumber;
	}
	
	/**
	 * required for KLARNA
	 * 
	 * Sets the value for the property houseNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max $houseNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setHouseNumber($houseNumber){
		if ($houseNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max) {
			$this->houseNumber = $houseNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument houseNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max.");
		}
		return $this;
	}
	
	
	/**
	 * required for KLARNA
	 * 
	 * Returns the value for the property houseExtension.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max
	 */
	public function getHouseExtension(){
		return $this->houseExtension;
	}
	
	/**
	 * required for KLARNA
	 * 
	 * Sets the value for the property houseExtension.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max $houseExtension
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setHouseExtension($houseExtension){
		if ($houseExtension instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max) {
			$this->houseExtension = $houseExtension;
		}
		else {
			throw new BadMethodCallException("Type of argument houseExtension must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max.");
		}
		return $this;
	}
	
	
	/**
	 * second part of the address - e.g. Elouera Road 27
	 * 
	 * Returns the value for the property address2.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	public function getAddress2(){
		return $this->address2;
	}
	
	/**
	 * second part of the address - e.g. Elouera Road 27
	 * 
	 * Sets the value for the property address2.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max $address2
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setAddress2($address2){
		if ($address2 instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max) {
			$this->address2 = $address2;
		}
		else {
			throw new BadMethodCallException("Type of argument address2 must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property city.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	public function getCity(){
		return $this->city;
	}
	
	/**
	 * Sets the value for the property city.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max $city
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setCity($city){
		if ($city instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max) {
			$this->city = $city;
		}
		else {
			throw new BadMethodCallException("Type of argument city must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property state.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	public function getState(){
		return $this->state;
	}
	
	/**
	 * Sets the value for the property state.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max $state
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setState($state){
		if ($state instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max) {
			$this->state = $state;
		}
		else {
			throw new BadMethodCallException("Type of argument state must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property zip.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String24max
	 */
	public function getZip(){
		return $this->zip;
	}
	
	/**
	 * Sets the value for the property zip.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String24max $zip
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setZip($zip){
		if ($zip instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String24max) {
			$this->zip = $zip;
		}
		else {
			throw new BadMethodCallException("Type of argument zip must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String24max.");
		}
		return $this;
	}
	
	
	/**
	 * For Klarna transactions use ISO 3166 ALPHA-3 code (e.g. DEU, FIN, SWE...) or ISO 3166 ALPHA-2 (e.g. DE, FI, SE...) or ISO 3166 numeric (276, 246, 752)
	 * 
	 * Returns the value for the property country.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	public function getCountry(){
		return $this->country;
	}
	
	/**
	 * For Klarna transactions use ISO 3166 ALPHA-3 code (e.g. DEU, FIN, SWE...) or ISO 3166 ALPHA-2 (e.g. DE, FI, SE...) or ISO 3166 numeric (276, 246, 752)
	 * 
	 * Sets the value for the property country.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max $country
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setCountry($country){
		if ($country instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max) {
			$this->country = $country;
		}
		else {
			throw new BadMethodCallException("Type of argument country must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property phone.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	public function getPhone(){
		return $this->phone;
	}
	
	/**
	 * Sets the value for the property phone.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max $phone
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setPhone($phone){
		if ($phone instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max) {
			$this->phone = $phone;
		}
		else {
			throw new BadMethodCallException("Type of argument phone must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property fax.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	public function getFax(){
		return $this->fax;
	}
	
	/**
	 * Sets the value for the property fax.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max $fax
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setFax($fax){
		if ($fax instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max) {
			$this->fax = $fax;
		}
		else {
			throw new BadMethodCallException("Type of argument fax must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property email.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String64max
	 */
	public function getEmail(){
		return $this->email;
	}
	
	/**
	 * Sets the value for the property email.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String64max $email
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setEmail($email){
		if ($email instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String64max) {
			$this->email = $email;
		}
		else {
			throw new BadMethodCallException("Type of argument email must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String64max.");
		}
		return $this;
	}
	
	
	/**
	 * Customer personal number (required for KLARNA in format: Denmark "ddmmåå-nnnn", Finland "ppkkvvvvxxxx", Norway "ddmmyynnnnn", Sweden "yymmddnnnn"))
	 * 
	 * Returns the value for the property personalNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getPersonalNumber(){
		return $this->personalNumber;
	}
	
	/**
	 * Customer personal number (required for KLARNA in format: Denmark "ddmmåå-nnnn", Finland "ppkkvvvvxxxx", Norway "ddmmyynnnnn", Sweden "yymmddnnnn"))
	 * 
	 * Sets the value for the property personalNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $personalNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setPersonalNumber($personalNumber){
		if ($personalNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->personalNumber = $personalNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument personalNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * required for KLARNA
	 * 
	 * Returns the value for the property birthDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Date
	 */
	public function getBirthDate(){
		return $this->birthDate;
	}
	
	/**
	 * required for KLARNA
	 * 
	 * Sets the value for the property birthDate.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_Date $birthDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setBirthDate($birthDate){
		if ($birthDate instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Date) {
			$this->birthDate = $birthDate;
		}
		else {
			$this->birthDate = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Date::_()->set($birthDate);
		}
		return $this;
	}
	
	
	/**
	 * required for KLARNA
	 * 
	 * Returns the value for the property gender.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_GenderType
	 */
	public function getGender(){
		return $this->gender;
	}
	
	/**
	 * required for KLARNA
	 * 
	 * Sets the value for the property gender.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_GenderType $gender
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setGender($gender){
		if ($gender instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_GenderType) {
			$this->gender = $gender;
		}
		else {
			throw new BadMethodCallException("Type of argument gender must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_GenderType.");
		}
		return $this;
	}
	
	
	/**
	 * at least one phone is required for KLARNA
	 * 
	 * Returns the value for the property mobilePhone.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	public function getMobilePhone(){
		return $this->mobilePhone;
	}
	
	/**
	 * at least one phone is required for KLARNA
	 * 
	 * Sets the value for the property mobilePhone.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max $mobilePhone
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setMobilePhone($mobilePhone){
		if ($mobilePhone instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max) {
			$this->mobilePhone = $mobilePhone;
		}
		else {
			throw new BadMethodCallException("Type of argument mobilePhone must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property addrnum.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max
	 */
	public function getAddrnum(){
		return $this->addrnum;
	}
	
	/**
	 * Sets the value for the property addrnum.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max $addrnum
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function setAddrnum($addrnum){
		if ($addrnum instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max) {
			$this->addrnum = $addrnum;
		}
		else {
			throw new BadMethodCallException("Type of argument addrnum must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max.");
		}
		return $this;
	}
	
	
	
}