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
 * @XmlType(name="CreditCardData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData {
	/**
	 * @XmlElement(name="CardNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_CardNumber", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_CardNumber
	 */
	private $cardNumber;
	
	/**
	 * @XmlElement(name="ExpMonth", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpMonth", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpMonth
	 */
	private $expMonth;
	
	/**
	 * @XmlElement(name="ExpYear", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpYear", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpYear
	 */
	private $expYear;
	
	/**
	 * @XmlElement(name="CardCodeValue", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue
	 */
	private $cardCodeValue;
	
	/**
	 * @XmlElement(name="CryptData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData
	 */
	private $cryptData;
	
	/**
	 * @XmlElement(name="TrackData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData
	 */
	private $trackData;
	
	/**
	 * @XmlElement(name="Brand", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_Brand", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_Brand
	 */
	private $brand;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData();
		return $i;
	}
	/**
	 * Returns the value for the property cardNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_CardNumber
	 */
	public function getCardNumber(){
		return $this->cardNumber;
	}
	
	/**
	 * Sets the value for the property cardNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_CardNumber $cardNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	public function setCardNumber($cardNumber){
		if ($cardNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_CardNumber) {
			$this->cardNumber = $cardNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument cardNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_CardNumber.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property expMonth.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpMonth
	 */
	public function getExpMonth(){
		return $this->expMonth;
	}
	
	/**
	 * Sets the value for the property expMonth.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpMonth $expMonth
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	public function setExpMonth($expMonth){
		if ($expMonth instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpMonth) {
			$this->expMonth = $expMonth;
		}
		else {
			throw new BadMethodCallException("Type of argument expMonth must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpMonth.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property expYear.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpYear
	 */
	public function getExpYear(){
		return $this->expYear;
	}
	
	/**
	 * Sets the value for the property expYear.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpYear $expYear
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	public function setExpYear($expYear){
		if ($expYear instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpYear) {
			$this->expYear = $expYear;
		}
		else {
			throw new BadMethodCallException("Type of argument expYear must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_ExpYear.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property cardCodeValue.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue
	 */
	public function getCardCodeValue(){
		return $this->cardCodeValue;
	}
	
	/**
	 * Sets the value for the property cardCodeValue.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue $cardCodeValue
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	public function setCardCodeValue($cardCodeValue){
		if ($cardCodeValue instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue) {
			$this->cardCodeValue = $cardCodeValue;
		}
		else {
			throw new BadMethodCallException("Type of argument cardCodeValue must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property cryptData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData
	 */
	public function getCryptData(){
		return $this->cryptData;
	}
	
	/**
	 * Sets the value for the property cryptData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData $cryptData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	public function setCryptData($cryptData){
		if ($cryptData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData) {
			$this->cryptData = $cryptData;
		}
		else {
			throw new BadMethodCallException("Type of argument cryptData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CryptData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property trackData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData
	 */
	public function getTrackData(){
		return $this->trackData;
	}
	
	/**
	 * Sets the value for the property trackData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData $trackData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	public function setTrackData($trackData){
		if ($trackData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData) {
			$this->trackData = $trackData;
		}
		else {
			throw new BadMethodCallException("Type of argument trackData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property brand.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_Brand
	 */
	public function getBrand(){
		return $this->brand;
	}
	
	/**
	 * Sets the value for the property brand.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_Brand $brand
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	public function setBrand($brand){
		if ($brand instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_Brand) {
			$this->brand = $brand;
		}
		else {
			throw new BadMethodCallException("Type of argument brand must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData_Brand.");
		}
		return $this;
	}
	
	
	
}