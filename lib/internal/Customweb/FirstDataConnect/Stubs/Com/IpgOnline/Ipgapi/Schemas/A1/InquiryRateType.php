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
 * @XmlType(name="InquiryRateType", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType {
	/**
	 * @XmlElement(name="InquiryRateId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId
	 */
	private $inquiryRateId;
	
	/**
	 * @XmlElement(name="ForeignCurrencyCode", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType
	 */
	private $foreignCurrencyCode;
	
	/**
	 * @XmlElement(name="ForeignAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $foreignAmount;
	
	/**
	 * @XmlValue(name="ExchangeRate", simpleType=@XmlSimpleTypeDefinition(typeName='decimal', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Float'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var float
	 */
	private $exchangeRate;
	
	/**
	 * @XmlValue(name="DccApplied", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var boolean
	 */
	private $dccApplied;
	
	/**
	 * @XmlValue(name="DccOffered", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var boolean
	 */
	private $dccOffered;
	
	/**
	 * @XmlValue(name="ExpirationTimestamp", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $expirationTimestamp;
	
	/**
	 * @XmlValue(name="MarginRatePercentage", simpleType=@XmlSimpleTypeDefinition(typeName='decimal', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Float'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var float
	 */
	private $marginRatePercentage;
	
	/**
	 * @XmlElement(name="ExchangeRateSourceName", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	private $exchangeRateSourceName;
	
	/**
	 * @XmlValue(name="ExchangeRateSourceTimestamp", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $exchangeRateSourceTimestamp;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType();
		return $i;
	}
	/**
	 * Returns the value for the property inquiryRateId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId
	 */
	public function getInquiryRateId(){
		return $this->inquiryRateId;
	}
	
	/**
	 * Sets the value for the property inquiryRateId.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId $inquiryRateId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setInquiryRateId($inquiryRateId){
		if ($inquiryRateId instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId) {
			$this->inquiryRateId = $inquiryRateId;
		}
		else {
			throw new BadMethodCallException("Type of argument inquiryRateId must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property foreignCurrencyCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType
	 */
	public function getForeignCurrencyCode(){
		return $this->foreignCurrencyCode;
	}
	
	/**
	 * Sets the value for the property foreignCurrencyCode.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType $foreignCurrencyCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setForeignCurrencyCode($foreignCurrencyCode){
		if ($foreignCurrencyCode instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType) {
			$this->foreignCurrencyCode = $foreignCurrencyCode;
		}
		else {
			throw new BadMethodCallException("Type of argument foreignCurrencyCode must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property foreignAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getForeignAmount(){
		return $this->foreignAmount;
	}
	
	/**
	 * Sets the value for the property foreignAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $foreignAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setForeignAmount($foreignAmount){
		if ($foreignAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->foreignAmount = $foreignAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument foreignAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property exchangeRate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Float
	 */
	public function getExchangeRate(){
		return $this->exchangeRate;
	}
	
	/**
	 * Sets the value for the property exchangeRate.
	 * 
	 * @param float $exchangeRate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setExchangeRate($exchangeRate){
		if ($exchangeRate instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Float) {
			$this->exchangeRate = $exchangeRate;
		}
		else {
			$this->exchangeRate = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Float::_()->set($exchangeRate);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dccApplied.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getDccApplied(){
		return $this->dccApplied;
	}
	
	/**
	 * Sets the value for the property dccApplied.
	 * 
	 * @param boolean $dccApplied
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setDccApplied($dccApplied){
		if ($dccApplied instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->dccApplied = $dccApplied;
		}
		else {
			$this->dccApplied = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean::_()->set($dccApplied);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dccOffered.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getDccOffered(){
		return $this->dccOffered;
	}
	
	/**
	 * Sets the value for the property dccOffered.
	 * 
	 * @param boolean $dccOffered
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setDccOffered($dccOffered){
		if ($dccOffered instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->dccOffered = $dccOffered;
		}
		else {
			$this->dccOffered = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean::_()->set($dccOffered);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property expirationTimestamp.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getExpirationTimestamp(){
		return $this->expirationTimestamp;
	}
	
	/**
	 * Sets the value for the property expirationTimestamp.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $expirationTimestamp
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setExpirationTimestamp($expirationTimestamp){
		if ($expirationTimestamp instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->expirationTimestamp = $expirationTimestamp;
		}
		else {
			$this->expirationTimestamp = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime::_()->set($expirationTimestamp);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property marginRatePercentage.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Float
	 */
	public function getMarginRatePercentage(){
		return $this->marginRatePercentage;
	}
	
	/**
	 * Sets the value for the property marginRatePercentage.
	 * 
	 * @param float $marginRatePercentage
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setMarginRatePercentage($marginRatePercentage){
		if ($marginRatePercentage instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Float) {
			$this->marginRatePercentage = $marginRatePercentage;
		}
		else {
			$this->marginRatePercentage = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Float::_()->set($marginRatePercentage);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property exchangeRateSourceName.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max
	 */
	public function getExchangeRateSourceName(){
		return $this->exchangeRateSourceName;
	}
	
	/**
	 * Sets the value for the property exchangeRateSourceName.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max $exchangeRateSourceName
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setExchangeRateSourceName($exchangeRateSourceName){
		if ($exchangeRateSourceName instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max) {
			$this->exchangeRateSourceName = $exchangeRateSourceName;
		}
		else {
			throw new BadMethodCallException("Type of argument exchangeRateSourceName must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property exchangeRateSourceTimestamp.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getExchangeRateSourceTimestamp(){
		return $this->exchangeRateSourceTimestamp;
	}
	
	/**
	 * Sets the value for the property exchangeRateSourceTimestamp.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $exchangeRateSourceTimestamp
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function setExchangeRateSourceTimestamp($exchangeRateSourceTimestamp){
		if ($exchangeRateSourceTimestamp instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->exchangeRateSourceTimestamp = $exchangeRateSourceTimestamp;
		}
		else {
			$this->exchangeRateSourceTimestamp = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime::_()->set($exchangeRateSourceTimestamp);
		}
		return $this;
	}
	
	
	
}