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
 * @XmlType(name="GetExternalConsumerInformation", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation {
	/**
	 * @XmlElement(name="StoreId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $storeId;
	
	/**
	 * @XmlElement(name="OrderId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	private $orderId;
	
	/**
	 * @XmlElement(name="DataProvider", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_DataProvider", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_DataProvider
	 */
	private $dataProvider;
	
	/**
	 * @XmlElement(name="FirstName", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	private $firstName;
	
	/**
	 * @XmlElement(name="Surname", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	private $surname;
	
	/**
	 * @XmlElement(name="Birthday", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate
	 */
	private $birthday;
	
	/**
	 * @XmlElement(name="Street", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	private $street;
	
	/**
	 * @XmlElement(name="HouseNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max
	 */
	private $houseNumber;
	
	/**
	 * @XmlElement(name="PostCode", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max
	 */
	private $postCode;
	
	/**
	 * @XmlElement(name="City", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	private $city;
	
	/**
	 * @XmlElement(name="Country", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_Country", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_Country
	 */
	private $country;
	
	/**
	 * @XmlValue(name="DisplayProcessorMessages", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var boolean
	 */
	private $displayProcessorMessages = 'true';
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation();
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
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
	 * Returns the value for the property orderId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	public function getOrderId(){
		return $this->orderId;
	}
	
	/**
	 * Sets the value for the property orderId.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max $orderId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setOrderId($orderId){
		if ($orderId instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max) {
			$this->orderId = $orderId;
		}
		else {
			throw new BadMethodCallException("Type of argument orderId must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dataProvider.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_DataProvider
	 */
	public function getDataProvider(){
		return $this->dataProvider;
	}
	
	/**
	 * Sets the value for the property dataProvider.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_DataProvider $dataProvider
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setDataProvider($dataProvider){
		if ($dataProvider instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_DataProvider) {
			$this->dataProvider = $dataProvider;
		}
		else {
			throw new BadMethodCallException("Type of argument dataProvider must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_DataProvider.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property firstName.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	public function getFirstName(){
		return $this->firstName;
	}
	
	/**
	 * Sets the value for the property firstName.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max $firstName
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setFirstName($firstName){
		if ($firstName instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max) {
			$this->firstName = $firstName;
		}
		else {
			throw new BadMethodCallException("Type of argument firstName must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property surname.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	public function getSurname(){
		return $this->surname;
	}
	
	/**
	 * Sets the value for the property surname.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max $surname
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setSurname($surname){
		if ($surname instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max) {
			$this->surname = $surname;
		}
		else {
			throw new BadMethodCallException("Type of argument surname must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property birthday.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate
	 */
	public function getBirthday(){
		return $this->birthday;
	}
	
	/**
	 * Sets the value for the property birthday.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate $birthday
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setBirthday($birthday){
		if ($birthday instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate) {
			$this->birthday = $birthday;
		}
		else {
			throw new BadMethodCallException("Type of argument birthday must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property street.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	public function getStreet(){
		return $this->street;
	}
	
	/**
	 * Sets the value for the property street.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max $street
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setStreet($street){
		if ($street instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max) {
			$this->street = $street;
		}
		else {
			throw new BadMethodCallException("Type of argument street must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property houseNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max
	 */
	public function getHouseNumber(){
		return $this->houseNumber;
	}
	
	/**
	 * Sets the value for the property houseNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max $houseNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setHouseNumber($houseNumber){
		if ($houseNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max) {
			$this->houseNumber = $houseNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument houseNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property postCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max
	 */
	public function getPostCode(){
		return $this->postCode;
	}
	
	/**
	 * Sets the value for the property postCode.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max $postCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setPostCode($postCode){
		if ($postCode instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max) {
			$this->postCode = $postCode;
		}
		else {
			throw new BadMethodCallException("Type of argument postCode must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property city.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	public function getCity(){
		return $this->city;
	}
	
	/**
	 * Sets the value for the property city.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max $city
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setCity($city){
		if ($city instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max) {
			$this->city = $city;
		}
		else {
			throw new BadMethodCallException("Type of argument city must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property country.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_Country
	 */
	public function getCountry(){
		return $this->country;
	}
	
	/**
	 * Sets the value for the property country.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_Country $country
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setCountry($country){
		if ($country instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_Country) {
			$this->country = $country;
		}
		else {
			throw new BadMethodCallException("Type of argument country must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation_Country.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property displayProcessorMessages.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getDisplayProcessorMessages(){
		return $this->displayProcessorMessages;
	}
	
	/**
	 * Sets the value for the property displayProcessorMessages.
	 * 
	 * @param boolean $displayProcessorMessages
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetExternalConsumerInformation
	 */
	public function setDisplayProcessorMessages($displayProcessorMessages){
		if ($displayProcessorMessages instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->displayProcessorMessages = $displayProcessorMessages;
		}
		else {
			$this->displayProcessorMessages = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean::_()->set($displayProcessorMessages);
		}
		return $this;
	}
	
	
	
}