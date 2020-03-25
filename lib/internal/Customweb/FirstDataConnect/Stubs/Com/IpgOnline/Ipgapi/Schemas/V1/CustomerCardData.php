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
 * @XmlType(name="CustomerCardData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData {
	/**
	 * @XmlElement(name="CardNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_CardNumber", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_CardNumber
	 */
	private $cardNumber;
	
	/**
	 * @XmlElement(name="ExpMonth", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpMonth", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpMonth
	 */
	private $expMonth;
	
	/**
	 * @XmlElement(name="ExpYear", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpYear", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpYear
	 */
	private $expYear;
	
	/**
	 * @XmlElement(name="TrackData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData
	 */
	private $trackData;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData();
		return $i;
	}
	/**
	 * Returns the value for the property cardNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_CardNumber
	 */
	public function getCardNumber(){
		return $this->cardNumber;
	}
	
	/**
	 * Sets the value for the property cardNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_CardNumber $cardNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData
	 */
	public function setCardNumber($cardNumber){
		if ($cardNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_CardNumber) {
			$this->cardNumber = $cardNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument cardNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_CardNumber.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property expMonth.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpMonth
	 */
	public function getExpMonth(){
		return $this->expMonth;
	}
	
	/**
	 * Sets the value for the property expMonth.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpMonth $expMonth
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData
	 */
	public function setExpMonth($expMonth){
		if ($expMonth instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpMonth) {
			$this->expMonth = $expMonth;
		}
		else {
			throw new BadMethodCallException("Type of argument expMonth must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpMonth.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property expYear.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpYear
	 */
	public function getExpYear(){
		return $this->expYear;
	}
	
	/**
	 * Sets the value for the property expYear.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpYear $expYear
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData
	 */
	public function setExpYear($expYear){
		if ($expYear instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpYear) {
			$this->expYear = $expYear;
		}
		else {
			throw new BadMethodCallException("Type of argument expYear must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData_ExpYear.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData
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
	
	
	
}