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
 * @XmlType(name="GetLastOrders", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders {
	/**
	 * @XmlElement(name="StoreId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $storeId;
	
	/**
	 * @XmlElement(name="Count", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders_Count", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders_Count
	 */
	private $count = '10';
	
	/**
	 * @XmlValue(name="DateFrom", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $dateFrom;
	
	/**
	 * @XmlValue(name="DateTo", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $dateTo;
	
	/**
	 * @XmlElement(name="OrderID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	private $orderID;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders();
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders
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
	 * Returns the value for the property count.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders_Count
	 */
	public function getCount(){
		return $this->count;
	}
	
	/**
	 * Sets the value for the property count.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders_Count $count
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders
	 */
	public function setCount($count){
		if ($count instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders_Count) {
			$this->count = $count;
		}
		else {
			throw new BadMethodCallException("Type of argument count must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders_Count.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dateFrom.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getDateFrom(){
		return $this->dateFrom;
	}
	
	/**
	 * Sets the value for the property dateFrom.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $dateFrom
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders
	 */
	public function setDateFrom($dateFrom){
		if ($dateFrom instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->dateFrom = $dateFrom;
		}
		else {
			$this->dateFrom = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime::_()->set($dateFrom);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dateTo.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getDateTo(){
		return $this->dateTo;
	}
	
	/**
	 * Sets the value for the property dateTo.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $dateTo
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders
	 */
	public function setDateTo($dateTo){
		if ($dateTo instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->dateTo = $dateTo;
		}
		else {
			$this->dateTo = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime::_()->set($dateTo);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property orderID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	public function getOrderID(){
		return $this->orderID;
	}
	
	/**
	 * Sets the value for the property orderID.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max $orderID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastOrders
	 */
	public function setOrderID($orderID){
		if ($orderID instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max) {
			$this->orderID = $orderID;
		}
		else {
			throw new BadMethodCallException("Type of argument orderID must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max.");
		}
		return $this;
	}
	
	
	
}