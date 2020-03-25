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
 * @XmlType(name="TravelRoute", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute {
	/**
	 * @XmlElement(name="DepartureDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	private $departureDate;
	
	/**
	 * @XmlElement(name="Origin", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max
	 */
	private $origin;
	
	/**
	 * @XmlElement(name="Destination", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max
	 */
	private $destination;
	
	/**
	 * @XmlElement(name="CarrierCode", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max
	 */
	private $carrierCode;
	
	/**
	 * @XmlElement(name="ServiceClass", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1max
	 */
	private $serviceClass;
	
	/**
	 * @XmlElement(name="StopoverType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute_StopoverType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute_StopoverType
	 */
	private $stopoverType;
	
	/**
	 * @XmlElement(name="FareBasisCode", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max
	 */
	private $fareBasisCode;
	
	/**
	 * @XmlElement(name="DepartureTax", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $departureTax;
	
	/**
	 * @XmlElement(name="FlightNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max
	 */
	private $flightNumber;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute();
		return $i;
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
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
	 * Returns the value for the property origin.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max
	 */
	public function getOrigin(){
		return $this->origin;
	}
	
	/**
	 * Sets the value for the property origin.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max $origin
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public function setOrigin($origin){
		if ($origin instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max) {
			$this->origin = $origin;
		}
		else {
			throw new BadMethodCallException("Type of argument origin must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property destination.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max
	 */
	public function getDestination(){
		return $this->destination;
	}
	
	/**
	 * Sets the value for the property destination.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max $destination
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public function setDestination($destination){
		if ($destination instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max) {
			$this->destination = $destination;
		}
		else {
			throw new BadMethodCallException("Type of argument destination must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String3max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property carrierCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max
	 */
	public function getCarrierCode(){
		return $this->carrierCode;
	}
	
	/**
	 * Sets the value for the property carrierCode.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max $carrierCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public function setCarrierCode($carrierCode){
		if ($carrierCode instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max) {
			$this->carrierCode = $carrierCode;
		}
		else {
			throw new BadMethodCallException("Type of argument carrierCode must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property serviceClass.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1max
	 */
	public function getServiceClass(){
		return $this->serviceClass;
	}
	
	/**
	 * Sets the value for the property serviceClass.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1max $serviceClass
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public function setServiceClass($serviceClass){
		if ($serviceClass instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1max) {
			$this->serviceClass = $serviceClass;
		}
		else {
			throw new BadMethodCallException("Type of argument serviceClass must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property stopoverType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute_StopoverType
	 */
	public function getStopoverType(){
		return $this->stopoverType;
	}
	
	/**
	 * Sets the value for the property stopoverType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute_StopoverType $stopoverType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public function setStopoverType($stopoverType){
		if ($stopoverType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute_StopoverType) {
			$this->stopoverType = $stopoverType;
		}
		else {
			throw new BadMethodCallException("Type of argument stopoverType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute_StopoverType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property fareBasisCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max
	 */
	public function getFareBasisCode(){
		return $this->fareBasisCode;
	}
	
	/**
	 * Sets the value for the property fareBasisCode.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max $fareBasisCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public function setFareBasisCode($fareBasisCode){
		if ($fareBasisCode instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max) {
			$this->fareBasisCode = $fareBasisCode;
		}
		else {
			throw new BadMethodCallException("Type of argument fareBasisCode must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String2max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property departureTax.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getDepartureTax(){
		return $this->departureTax;
	}
	
	/**
	 * Sets the value for the property departureTax.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $departureTax
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public function setDepartureTax($departureTax){
		if ($departureTax instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->departureTax = $departureTax;
		}
		else {
			throw new BadMethodCallException("Type of argument departureTax must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property flightNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max
	 */
	public function getFlightNumber(){
		return $this->flightNumber;
	}
	
	/**
	 * Sets the value for the property flightNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max $flightNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TravelRoute
	 */
	public function setFlightNumber($flightNumber){
		if ($flightNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max) {
			$this->flightNumber = $flightNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument flightNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String10max.");
		}
		return $this;
	}
	
	
	
}