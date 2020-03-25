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
 * @XmlType(name="AirlineDetails", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails {
	/**
	 * @XmlElement(name="PassengerName", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	private $passengerName;
	
	/**
	 * @XmlElement(name="TicketNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $ticketNumber;
	
	/**
	 * @XmlElement(name="IssuingCarrier", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $issuingCarrier;
	
	/**
	 * @XmlElement(name="CarrierName", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $carrierName;
	
	/**
	 * @XmlElement(name="TravelAgencyCodeOrIATACode", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $travelAgencyCodeOrIATACode;
	
	/**
	 * @XmlElement(name="TravelAgencyName", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	private $travelAgencyName;
	
	/**
	 * @XmlElement(name="AirlinePlanNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max
	 */
	private $airlinePlanNumber;
	
	/**
	 * @XmlElement(name="AirlineInvoiceNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max
	 */
	private $airlineInvoiceNumber;
	
	/**
	 * @XmlElement(name="ComputerizedReservationSystem", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails_ComputerizedReservationSystem", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails_ComputerizedReservationSystem
	 */
	private $computerizedReservationSystem;
	
	/**
	 * @XmlValue(name="Restricted", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean'), namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var boolean
	 */
	private $restricted;
	
	/**
	 * @XmlElement(name="TravelRoute", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	private $travelRoute;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails();
		return $i;
	}
	/**
	 * Returns the value for the property passengerName.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	public function getPassengerName(){
		return $this->passengerName;
	}
	
	/**
	 * Sets the value for the property passengerName.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max $passengerName
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setPassengerName($passengerName){
		if ($passengerName instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max) {
			$this->passengerName = $passengerName;
		}
		else {
			throw new BadMethodCallException("Type of argument passengerName must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property ticketNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getTicketNumber(){
		return $this->ticketNumber;
	}
	
	/**
	 * Sets the value for the property ticketNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $ticketNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setTicketNumber($ticketNumber){
		if ($ticketNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->ticketNumber = $ticketNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument ticketNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property issuingCarrier.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getIssuingCarrier(){
		return $this->issuingCarrier;
	}
	
	/**
	 * Sets the value for the property issuingCarrier.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $issuingCarrier
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setIssuingCarrier($issuingCarrier){
		if ($issuingCarrier instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->issuingCarrier = $issuingCarrier;
		}
		else {
			throw new BadMethodCallException("Type of argument issuingCarrier must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property carrierName.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getCarrierName(){
		return $this->carrierName;
	}
	
	/**
	 * Sets the value for the property carrierName.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $carrierName
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setCarrierName($carrierName){
		if ($carrierName instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->carrierName = $carrierName;
		}
		else {
			throw new BadMethodCallException("Type of argument carrierName must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property travelAgencyCodeOrIATACode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getTravelAgencyCodeOrIATACode(){
		return $this->travelAgencyCodeOrIATACode;
	}
	
	/**
	 * Sets the value for the property travelAgencyCodeOrIATACode.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $travelAgencyCodeOrIATACode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setTravelAgencyCodeOrIATACode($travelAgencyCodeOrIATACode){
		if ($travelAgencyCodeOrIATACode instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->travelAgencyCodeOrIATACode = $travelAgencyCodeOrIATACode;
		}
		else {
			throw new BadMethodCallException("Type of argument travelAgencyCodeOrIATACode must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property travelAgencyName.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max
	 */
	public function getTravelAgencyName(){
		return $this->travelAgencyName;
	}
	
	/**
	 * Sets the value for the property travelAgencyName.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max $travelAgencyName
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setTravelAgencyName($travelAgencyName){
		if ($travelAgencyName instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max) {
			$this->travelAgencyName = $travelAgencyName;
		}
		else {
			throw new BadMethodCallException("Type of argument travelAgencyName must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String30max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property airlinePlanNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max
	 */
	public function getAirlinePlanNumber(){
		return $this->airlinePlanNumber;
	}
	
	/**
	 * Sets the value for the property airlinePlanNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max $airlinePlanNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setAirlinePlanNumber($airlinePlanNumber){
		if ($airlinePlanNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max) {
			$this->airlinePlanNumber = $airlinePlanNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument airlinePlanNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property airlineInvoiceNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max
	 */
	public function getAirlineInvoiceNumber(){
		return $this->airlineInvoiceNumber;
	}
	
	/**
	 * Sets the value for the property airlineInvoiceNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max $airlineInvoiceNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setAirlineInvoiceNumber($airlineInvoiceNumber){
		if ($airlineInvoiceNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max) {
			$this->airlineInvoiceNumber = $airlineInvoiceNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument airlineInvoiceNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property computerizedReservationSystem.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails_ComputerizedReservationSystem
	 */
	public function getComputerizedReservationSystem(){
		return $this->computerizedReservationSystem;
	}
	
	/**
	 * Sets the value for the property computerizedReservationSystem.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails_ComputerizedReservationSystem $computerizedReservationSystem
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setComputerizedReservationSystem($computerizedReservationSystem){
		if ($computerizedReservationSystem instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails_ComputerizedReservationSystem) {
			$this->computerizedReservationSystem = $computerizedReservationSystem;
		}
		else {
			throw new BadMethodCallException("Type of argument computerizedReservationSystem must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails_ComputerizedReservationSystem.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property restricted.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getRestricted(){
		return $this->restricted;
	}
	
	/**
	 * Sets the value for the property restricted.
	 * 
	 * @param boolean $restricted
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setRestricted($restricted){
		if ($restricted instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->restricted = $restricted;
		}
		else {
			$this->restricted = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean::_()->set($restricted);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property travelRoute.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public function getTravelRoute(){
		return $this->travelRoute;
	}
	
	/**
	 * Sets the value for the property travelRoute.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute $travelRoute
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AirlineDetails
	 */
	public function setTravelRoute($travelRoute){
		if ($travelRoute instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute) {
			$this->travelRoute = $travelRoute;
		}
		else {
			throw new BadMethodCallException("Type of argument travelRoute must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute.");
		}
		return $this;
	}
	
	
	
}